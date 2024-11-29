<?php

namespace App\Http\Controllers\Admin;

use App\Agency;
use App\Option;
use App\Package;
use App\Admin;
use App\Locations;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AgencyController extends Controller
{
    private function route() {
        return 'admin.agency.';
      }
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
          $agency = Agency::where('user_id',auth()->user()->id)->first();
         return view('admin.agency.index')->with('agency',$agency);
        }
        public function location()
        {
          $location = Locations::get();
         return view('admin.agency.location')->with('location',$location);
        }

        public function add_location()
        {
         return view('admin.agency.addlocation');
        }

        public function submit_location(Request $request)
        {
          // dd($request);
          $location = new Locations;
          $location->city = $request->city;
          $location->country = $request->country;
          $location->save();
         return redirect('admin/location');
        }

        public function submit_edit_location(Request $request)
        {
          // dd($request);
          $location = Locations::find($request->location_id);
          $location->city = $request->city;
          $location->country = $request->country;
          $location->save();
         return redirect('admin/location');
        }

        public function edit_location(Request $request,$id)
        {
          $location = Locations::find($id);
          return view('admin.agency.editlocation')->with('location',$location);
        }

        public function delete_location(Request $request,$id)
        {
          if ($request->ajax()) {
            // return response()->json(['success' => true, 'status' => 'success', 'message' => 'Packege Information Delete Successfully.']);
            $location = Locations::find($id);
            $location->delete();
            return response()->json(['message' => 'Location Information Deleted Successfully', 'goto' => route('admin.location')]);
         }
        }



       public function datatable(Request $request) {

        if ($request->ajax()) {
          if(auth()->user()->id == 1){
            $model = Agency::all();
          }else{
            $model = Agency::where('user_id',auth()->user()->id)->get();
          }
          return Datatables::of($model)
          ->addIndexColumn()
          ->editColumn('image',function($model){
            $url= $model->img;
            return '<img src="'.$url.'" border="0" width="120" class="img-rounded" align="center" />';
          })
          ->editColumn('status', function ($model) {
            $mail= $model->email;
            return $mail;
          })
          ->addColumn('action', function ($model) {
            return view('admin.agency.action', compact('model'));
          })->rawColumns(['action','status','image'])->make(true);
        }
      }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
          // $option =Option::all()->pluck('name','id')->prepend(_lang('Select One'), '');
          // return view('admin.agency.form',compact('option'));
          return view('admin.agency.form');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
          // dd(Auth::user()->id);
          if ($request) {
            // $validator = $request->validate([
            //   'name' => ['required', 'max:255'],
            //   'email' => ['required'],
            //   'phone' => ['required'],
            //   'photo' => 'required|mimes:jpeg,bmp,png,jpg|max:2000',
            // ]);
            $agency =new Agency();
            if($request->hasFile('photo')) {
              $storagepath = $request->file('photo')->store('public/packege');
              $baseUrl = config('app.url');
              $fullImagePath =  Storage::url($storagepath);
              $agency->img = $fullImagePath;
            }
            $agency->user_id=Auth::user()->id;
            $agency->name=$request->name;
            $agency->phone =$request->phone;
            $agency->save();
            // return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Agency Incude'), 'goto' => route('admin.agency.index')]);
            return redirect()->back();
          }
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {

        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
          // $option =Option::all()->pluck('name','id')->prepend(_lang('Select One'), '');
          $model =Agency::findOrfail($id);
          return view('admin.agency.form',compact('model'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
          if ($request) {
            $agency =Agency::findOrfail($id);
            if ($request->hasFile('photo')) {
                $storagepath = $request->file('photo')->store('public/packege');
                $baseUrl = env('APP_URL');
                $fullImagePath = $baseUrl . Storage::url($storagepath);
                $agency->img = $fullImagePath;

                // if file chnage then delete old one
                // $oldFile = $request->get('oldphoto', '');
                // if ($oldFile != '') {
                // $file_path = "public/packege" . $oldFile;
                // Storage::delete($file_path);
                // }
            } else {
                $agency->img = $request->get('oldphoto', '');
            }

            // $agency->user_id=Auth::user()->id;
            $agency->name=$request->name;
            $agency->phone =$request->phone;
            $agency->save();
            return redirect('admin/agency/');
          }
        }

        public function showAgentAgencies($id)
        {
            $agency =Agency::where('user_id',$id)->get();
            if ($agency)
            {
              return response()->json(['success' => true, 'status' => 'success',"Agencies" => $agency, 'message' => 'User agencies']);
            }
            return response()->json(['success' => false, 'status' => 404 ,'message' => 'No data exists']);

        }

        public function updateAgencyByAgent(Request $request, $id)  //agency id is used not agent id
        {

            if ($id == null) {
                return response()->json(['errors' => 'Agency ID is missing'], 422);
            }
            $agency =Agency::where('id',$id)->first();
            if($agency)
            {
                if ($request->hasFile('photo')) {
                    $storagePath = $request->file('photo')->store('public/agencies');
                    $baseUrl = env('APP_URL');
                    $fullImagePath = $baseUrl . Storage::url($storagePath);
                    $agency->img = $fullImagePath;
                    // $oldFile = $request->get('oldphoto', '');
                    // if ($oldFile !== '') {
                    //     $file_path = "public/agencies/" . basename($oldFile);
                    //     Storage::delete($file_path);
                    // }
                } else {
                    $agency->img = $request->get('oldphoto', '');
                }
                $agency->name=$request->name ?? $agency->name;
                $agency->phone =$request->phone ?? $agency->phone;
                $agency->save();
                $agency_agent = Admin::where('id', $agency->user_id)->first();
                $agency_agent->password = $request->has('password') ? bcrypt($request->password) : $agency_agent->password;
                $agency_agent->save();
                return response()->json(['success' => true,'Agency'=> $agency, 'status' => 'success', 'message' => 'Agency succcessfully updated']);

            }
            else
            {
                return response()->json(['error' => true, 'status' => 'error', 'message' => 'Agency not found']);

            }

        }
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Request $request,$id)
        {
          if ($request->ajax()) {
            // return response()->json(['success' => true, 'status' => 'success', 'message' => 'Packege Information Delete Successfully.']);
            $agency = Agency::find($id);
            if (file_exists('storage/package/'.$agency->img))
            {
              unlink('storage/package/'.$agency->img);
            }
            $agency->delete();
            if ($agency) {
              return response()->json(['success' => true, 'status' => 'success', 'message' => 'Packege Information Delete Successfully.']);
           }
         }
       }
}
