<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Admin;
use App\Agency;
use App\Option;
use App\Package;
use App\Locations;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
  private function route() {
    return 'admin.package.';
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     return view('admin.package.index');
   }



   public function datatable(Request $request) {
    if ($request->ajax()) {
      $agency = Agency::where('user_id',auth()->user()->id)->first();
      if(auth()->user()->id == 1){
        $model = Package::all();
      }else{
        $model = Package::where('agency_id',$agency->id)->get();
      }
      // $model = Package::all();
      return Datatables::of($model)
      ->addIndexColumn()
      ->editColumn('image',function($model){
        $url= $model->photo;
        return '<img src="'.$url.'" border="0" width="120" class="img-rounded" align="center" />';
      })
      ->editColumn('status', function ($model) {
        $route =$this->route();
        return view('admin.status', compact('model','route'));
      })
      ->addColumn('action', function ($model) {
        return view('admin.package.action', compact('model'));
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
      $option =Option::all()->pluck('name','id')->prepend(_lang('Select One'), '');
      $locations = Locations::all();
      $agencies = Agency::all()->pluck('name','id')->prepend(_lang('Select One'), '');
      $model =null;
      return view('admin.package.form',compact('option','locations','model','agencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      if ($request->ajax())
      {
        $validator = $request->validate([
          'name' => ['required', 'max:255'],
          'duration' => ['required'],
          'start' => 'required|date',
          'end' => 'required|date|after:start',
          'type' => ['required', 'max:255'],
          'location' => ['required'],
        //   'option.id' => ['required', 'integer'],
          'description' => ['required'],
          'itinary' => ['required'],
          'price' => ['required', 'numeric'],
          'photo' => 'required|mimes:jpeg,bmp,png,jpg|max:2000',
          'banner' => 'required|mimes:jpeg,bmp,png,jpg|max:2000',
        ]);
        $user_id = Auth::user()->id;
        $agency = Agency::where('id',$request->agency_id)->first();
        $package =new Package;
        if($request->hasFile('photo')) {
          $storagepath = $request->file('photo')->store('public/packege');
          $baseUrl = config('app.url');
          $fullImagePath =  Storage::url($storagepath);
          $package->photo = $fullImagePath;
        }

        if($request->hasFile('banner')) {
          $storagepath = $request->file('banner')->store('public/packege');
          $baseUrl = config('app.url');
          $fullImagePath =  Storage::url($storagepath);
          $package->banner = $fullImagePath;
        }

		$start = DateTime::createFromFormat('d-m-Y', $request->start);
		$end = DateTime::createFromFormat('d-m-Y', $request->end);
		$startDate = $start->format('Y-m-d');
		$endDate = $end->format('Y-m-d');

        $package->agency_id=$agency->id;
        $package->name=$request->name;
        $package->slug=str_slug($request->name);
        $package->duration =$request->duration;
        $package->start = $startDate;
        $package->end = $endDate;
        $package->type =$request->type;
        // $package->option_id =$request->option['id'];
        $package->description =$request->description;
        $package->location =$request->location;
        $package->itinary =$request->itinary;
        $package->price =$request->price;
        $package->policy =$request->policy;
        $package->hotel =$request->hotel;
        $package->package_class =$request->package_class;
        $package->term_condition =$request->term_condition;
        $package->meta_title =$request->meta_title;
        $package->meta_keyword =$request->meta_keyword;
        $package->meta_description =$request->meta_description;
        $package->save();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Package Incude'), 'goto' => route('admin.package.index')]);
      }
    }

    // Functions for api's starts
    public function createPackageByAgent(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
          'name' => ['required', 'max:255'],
          'duration' => ['required'],
          'start' =>'required|date',
          'end' => 'required|date|after:start',
          'type' => ['required', 'max:255'],
          'location' => ['required'],
          'description' => ['required'],
          'itinary' => ['required'],
          'price' => ['required', 'numeric'],
          'photo' => 'required|mimes:jpeg,bmp,png,jpg|max:2000',
          'banner' => 'required|mimes:jpeg,bmp,png,jpg|max:2000',
          'package_class'=> ['nullable'],
          'hotel'=> ['nullable'],
          'policy'=> ['nullable'],
          'term_condition'=> ['nullable'],

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $agent = Admin::find($id);
        if($agent==null)
        {
            return response()->json(['error' => true,'message'=>"Agent Not Found",'error'=>503]);
        }
        if($agent->status === "activated")
        {
            $agency = Agency::where('user_id',$id)->first();
            $package =new Package;
            if($request->hasFile('photo')) {
              $storagepath = $request->file('photo')->store('public/packege');
              $baseUrl = config('app.url');
              $fullImagePath =  Storage::url($storagepath);
              $package->photo = $fullImagePath;
            }

            if($request->hasFile('banner')) {
              $storagepath = $request->file('banner')->store('public/packege');
              $baseUrl = config('app.url');
              $fullImagePath =  Storage::url($storagepath);
              $package->banner = $fullImagePath;
            }


            $package->agency_id=$agency->id;
            $package->name=$request->name;
            $package->slug=str_slug($request->name);
            $package->duration =$request->duration;
            $package->start =$request->start;
            $package->end =$request->end;
            $package->type =$request->type;
            // $package->option_id =$$agency->id;
            $package->description =$request->description;
            $package->location =$request->location;
            $package->itinary =$request->itinary;
            $package->price =$request->price;
            $package->policy =$request->policy;
            $package->hotel =$request->hotel;
            $package->package_class =$request->package_class;
            $package->term_condition =$request->term_condition;
            // $package->meta_title =$request->meta_title;
            // $package->meta_keyword =$request->meta_keyword;
            // $package->meta_description =$request->meta_description;
            $package->save();
            return response()->json(['success' => true, 'status' => 'success','Data' =>$package, 'message' => _lang('Package Created Successfully'), ]);
        }
        else
        {
            return response()->json(['error' => true,'message'=>"Your account is not active",'error'=>503]);
        }

    }

    public function displayAgentPackages($id)
    {
        $agent = Admin::find($id);
        if ($agent) {
            $data = $agent->agency->package;
            return response()->json(['success' => true, 'status' => 'success','Data' =>$data, ]);
        } else {
            return response()->json(['success' => true, 'status' => 404,'message' =>"No Record Found" ]);
        }
    }

    public function viewPackage($id)
    {
        $package = Package::find($id);
        if ($package) {
            return response()->json(['success' => true, 'status' => 'success','Data' =>$package, ]);
        } else {
            return response()->json(['success' => true, 'status' => 404,'message' =>"No Record Found" ]);
        }
    }

   // Functions for api's ends

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
      $locations = Locations::all();
      $option =Option::all()->pluck('name','id')->prepend(_lang('Select One'), '');
      $model =Package::findOrfail($id);
      $agencies = Agency::where('id',$model->agency_id)->pluck('name','id')->prepend(_lang('Select One'), '');
      return view('admin.package.form',compact('model','option','locations','agencies'));
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
      if ($request->ajax())
      {
        $validator = $request->validate([
          'name' => ['required', 'max:255'],
          'duration' => ['required'],
          'start' => 'required|date',
          'end' => 'required|date|after:start',
          'type' => ['required', 'max:255'],
          'package_class'=> ['nullable'],
          'description' => ['required'],
          'itinary' => ['required'],
          'price' => ['required', 'numeric'],
          'photo' => 'mimes:jpeg,bmp,png,jpg|max:2000',
          'banner' => 'mimes:jpeg,bmp,png,jpg|max:2000',
        ]);
        $package =Package::findOrfail($id);

        if ($request->hasFile('photo')) {
          $storagepath = $request->file('photo')->store('public/packege');
          $baseUrl = config('app.url');
          $fullImagePath = Storage::url($storagepath);
          $package->photo = $fullImagePath;
        } else {
          $package->photo = $request->get('oldphoto', '');
        }

        //
        if ($request->hasFile('banner')) {
          $storagepath = $request->file('banner')->store('public/packege');
          $baseUrl = config('app.url');
          $fullImagePath =  Storage::url($storagepath);
          $package->banner = $fullImagePath;


        } else {
          $package->banner = $request->get('oldbanner', '');
        }

        $package->name=$request->name;
        $package->slug=str_slug($request->name);
        $package->duration =$request->duration;
        $package->start =$request->start;
        $package->end =$request->end;
        $package->type =$request->type;
        $package->package_class =$request->package_class;
        $package->description =$request->description;
        $package->location =$request->location;
        $package->itinary =$request->itinary;
        $package->price =$request->price;
        $package->policy =$request->policy;
        $package->hotel =$request->hotel;
        $package->term_condition =$request->term_condition;
        $package->meta_title =$request->meta_title;
        $package->meta_keyword =$request->meta_keyword;
        $package->meta_description =$request->meta_description;
        $package->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Package Update'), 'goto' => route('admin.package.index')]);
      }
      else
      {
        if ($id==null) {
        return response()->json(['error' => true, 'status' => 'error', 'message' => 'ID is missing']);
        }

        $validator = Validator::make($request->all(), [
            'start' => 'date',
            'end' => 'date|after:start',
          ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $package =Package::findOrfail($id);
        if($package)
        {
            if ($request->hasFile('photo'))
            {
              $storagepath = $request->file('photo')->store('public/packege');
              $baseUrl = config('app.url');
              $fullImagePath = Storage::url($storagepath);
              $package->photo = $fullImagePath;

            }
            else if ($request->hasFile('banner'))
            {
              $storagepath = $request->file('banner')->store('public/packege');
              $fileName = basename($storagepath);
              $baseUrl = config('app.url');
              $fullImagePath =  Storage::url($storagepath);
              $package->banner = $fullImagePath;


            }

            $package->name=$request->name ?? $package->name;
            $package->slug=str_slug($request->name) ?? $package->slug;
            $package->duration =$request->duration ?? $package->duration;
            $package->start =$request->start ?? $package->start;
            $package->end =$request->end ?? $package->end;
            $package->type =$request->type ?? $package->type;
            // $package->option_id =$request->option['id'];
            $package->description =$request->description ?? $package->description;
            $package->location =$request->location ?? $package->location;
            $package->itinary =$request->itinary ?? $package->itinary;
            $package->price =$request->price ?? $package->price;
            $package->policy =$request->policy ?? $package->policy;
            $package->hotel =$request->hotel ?? $package->hotel;
            $package->term_condition =$request->term_condition ?? $package->term_condition;
            $package->package_class =$request->package_class ?? $package->package_class;
            // $package->meta_title =$request->meta_title;
            // $package->meta_keyword =$request->meta_keyword;
            // $package->meta_description =$request->meta_description;
            $package->save();
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Package Updated'),'package' => $package]);
        }
        else
        {
            return response()->json(['error' => true, 'status' => 404, 'message' => _lang('No Record Found'),]);
        }
      }
    }

    public function status(Request $request, $value, $id) {


      if (request()->ajax()) {
        $user = Package::find($id);
        $user->status = $value;
        $user->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Status Updated')]);
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
            $package = Package::find($id);
            $photo =   basename($package->photo);
            $banner =   basename($package->banner);
            $photoPath = 'storage/package/' . $photo;
            $bannerPath = 'storage/package/' . $banner;
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
            if(file_exists($bannerPath)){
                unlink($bannerPath);
            }
            $package->delete();
            if ($package) {
               return response()->json(['success' => true, 'status' => 'success', 'message' => 'Packege Information Delete Successfully.']);
            }
        }
        //This part is for api
        else
        {
            $package = Package::find($id);
            if ($package) {
                $photo =   basename($package->photo);
                $banner =   basename($package->banner);

                if (file_exists(storage_path('app/public/packege/' . $photo))) {
                    unlink(storage_path('app/public/packege/' . $photo));
                }

                if (file_exists(storage_path('app/public/packege/' . $banner))) {
                    unlink(storage_path('app/public/packege/' . $banner));
                }
                $package->delete();
                return response()->json(['success' => true, 'status' => 'success', 'message' => 'Packege Information Deleted Successfully.']);
            }
            else
            {
                return response()->json(['success' => false, 'status' => 404, 'message' => 'Package not found']);
            }
        }
   }
 }
