<?php

namespace App\Http\Controllers\Admin;

use Hash;
use App\User;
use App\Admin;
use App\Agency;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller {

	private function route() {
		return 'admin.user.';
	}
	public function index(Request $request) {
		return view('admin.user.index');
	}

	public function datatable(Request $request) {
		if (request()->ajax()) {
			if(auth()->user()->id == 1){
				$users = Admin::all()->except(1);
			  }else{
				$users = Admin::where('id',auth()->user()->id)->get();
			  }
			// $users = Admin::all()->except(1);
			return Datatables::of($users)
				->addIndexColumn()
				->addColumn('action', function ($model) {
					return view('admin.user.action', compact('model'));
				})
				->addColumn('role', function ($model) {
					return $role_name = getUserRoleName($model->id);
				})
				->editColumn('status', function ($model) {
					$route = $this->route();
					return view('admin.status', compact('model','route'));
				})
				->rawColumns(['action', 'status'])->make(true);

		}
	}

	public function create(Request $request) {
		if (!auth()->user()->can('user.create')) {
			abort(403, 'Unauthorized action.');
		}

		if ($request->isMethod('get')) {
			$role = Role::where('name', 'agent')->pluck('name', 'id')->prepend('Select Role...', '');
			return view('admin.user.create', compact('role'));
		} else {
			$validator = $request->validate([
				'name' => 'required', 'max:255',
				'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
				'password' => ['required', 'string', 'min:6', 'confirmed'],
				'agency_name' => 'required|string|max:255',
				'phone' => 'required',
			]);

			$user = new Admin;
			$user->surname = $request->surname ?? '';
			$nameParts = explode(' ', $request->name);
			$user->first_name = $nameParts[0] ?? '';
			$user->last_name = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : '';
			$user->username = $request->first_name.'_'.$request->last_name.'_'. $request->email;
			$user->email = $request->email;
			$user->password = bcrypt($request->password);
			// $user->activation_token = Str::uuid();
			$user->status = 'activated';
			$user->save();
			if ($request->hasFile('photo')) 
			{
				$storagepath = $request->file('photo')->store('public/packege');
				$fileName = basename($storagepath);
				$agency_img = $fileName;
			}
			$agency =new Agency();
			$agency->user_id = $user->id;  
			$agency->name = $request->agency_name;  
			$agency->email = $request->email;
			$agency->img = $agency_img ?? '';
			$agency->phone = $request->phone; 
			$agency->save();
			
			$role_id = $request->input('role');
			$role = Role::findOrFail($role_id);
			$user->assignRole($role->name);

			return response()->json(['success' => true, 'status' => 'success', 'message' => __('User Created'), 'goto' => route('admin.user.index')]);
		}
	}

	public function edit($id) {
		if (!auth()->user()->can('user.update')) {
			abort(403, 'Unauthorized action.');
		}
		$user = Admin::find($id);
		$roles = Role::where('name', '!=', config('system.default_role.admin'))->get()->pluck('name', 'id')->prepend('Select Role...', '');
		return view('admin.user.edit', compact('user', 'roles'));
	}

	public function status(Request $request, $value, $id) {
		if (!auth()->user()->can('user.update')) {
			abort(403, 'Unauthorized action.');
		}

		if (request()->ajax()) {
			$user = Admin::find($id);
			$user->status = $value;
			$user->save();

			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Status Updated')]);
		}
	}

	public function update(Request $request) {
		if (!auth()->user()->can('user.update')) {
			abort(403, 'Unauthorized action.');
		}

		if (request()->ajax()) {
			$id = $request->id;
			$user = Admin::findOrFail($id);
			$validator = $request->validate([

				'username' => ['required', 'string', 'max:255',
					Rule::unique('admins', 'username')->ignore($user->id)],
				'email' => ['required', 'string', 'email', 'max:255',
					Rule::unique('admins', 'email')->ignore($user->id)],

			]);

			
			$user->username = $request->username;
			$user->email = $request->email;
			$user->username = $request->username;
			$user->password = Hash::make($request->password);

			$role_id = $request->input('role');
			$user_role = $user->roles->first();

			if ($user_role->id != $role_id) {
				$user->removeRole($user_role->name);

				$role = Role::findOrFail($role_id);
				$user->assignRole($role->name);
			}

			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('User Updated'), 'goto' => route('admin.user.index')]);

		}
	}

	public function destroy(Request $request, $id) {
		if (!auth()->user()->can('user.delete')) {
			abort(403, 'Unauthorized action.');
		}

		if (request()->ajax()) {

			$user = Admin::find($id);
			if ($user) {
				$agency = $user->agency;
				if ($agency) {
					$packages = $agency->package;
					if ($packages) {
						foreach($packages as $package)
						{
							$package->delete();
						}
					}
					$agency->delete();
				}
				$user->delete();
			}
			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('User Deleted')]);
		}
	}
	// customers
	private function customer_route() {
		return 'admin.customer.';
	}
	public function customer_index(Request $request) {
		$users = User::orderBy('created_at','desc')->paginate(10);
		return view('admin.customer.index',compact('users'));
	}

	public function customer_datatable(Request $request) {
		if (request()->ajax()) {
			if(auth()->user()->id == 1){
				$users = User::all();
			  }else{
				$users = User::where('id',auth()->user()->id)->get();
			  }
			// $users = Admin::all()->except(1);
			return Datatables::of($users)
				->addIndexColumn()
				->addColumn('action', function ($model) {
					return view('admin.customer.action', compact('model'));
				})
				->editColumn('status', function ($model) {
					$route = $this->route();
					return view('admin.status', compact('model','route'));
				})
				->rawColumns(['action', 'status'])->make(true);

		}
	}

	public function customer_create() {
		return view('admin.customer.create');
	}

	public function customer_store(Request $request)
	{
		$user = new User();
		$user->name = $request->user_name;
		$user->email =$request->email;
		$user->password =bcrypt($request->password);
		$user->remember_token =Str::random(80);
		$user->ip ="";
		$user->country ="";
		$user->city ="";
		$user->continent ="";
		$user->latitude ="";
		$user->longitude ="";
		$user->currency_symbol ="";
		$user->currency_code ="";
		$user->timezone ="";
		$user->save();
		// $user->sendApiEmailVerificationNotification();
		return response()->json(['success' => true, 'status' => 'success', 'message' => __('User Created'), 'goto' => route('admin.customer.index')]);
	}

	public function customer_edit($id) {
		$user = User::find($id);
		$statuses = ['inactive' => 'Inactive', 'activated' => 'Activated'];
		return view('admin.customer.edit', compact('user','statuses'));
	}

	public function customer_status(Request $request, $value, $id) {
		if (!auth()->user()->can('user.update')) {
			abort(403, 'Unauthorized action.');
		}

		if (request()->ajax()) {
			$user = Admin::find($id);
			$user->status = $value;
			$user->save();

			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Status Updated')]);
		}
	}

	public function customer_update(Request $request)
	{
		$user = User::find($request->id);
        if($user)
		{
		  //if($request->password){
		  //  $user->password =Hash::make($request->password);
		  //  // $user->remember_token =Str::random(80);
		  //}
          $user->name =$request->user_name;
          $user->phone =$request->phone;
		  $user->status =$request->status;
          $user->save();
        }
		return response()->json(['success' => true, 'status' => 'success', 'message' => __('User Updated'), 'goto' => route('admin.customer.index')]);
	}

	public function customer_destroy(Request $request, $id) {
		if (!auth()->user()->can('user.delete')) {
			abort(403, 'Unauthorized action.');
		}
		
		$user = User::find($id);
		$user->delete();
		return redirect()->back()->with(['success' => true, 'status' => 'success', 'message' =>'User Deleted']);
	}
}
