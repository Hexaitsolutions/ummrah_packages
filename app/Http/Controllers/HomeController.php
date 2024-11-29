<?php

namespace App\Http\Controllers;

use App\Book;
use App\News;
// use Request;
use App\Page;
use App\User;
use App\Blogs;
use App\Agency;
use App\Review;
use App\Slider;
use App\Comment;
use App\Contact;
use App\Package;
use App\Service;
use App\Question;
use App\AirTicket;
use App\Locations;
use App\Subsciber;
use Carbon\Carbon;
use App\ServiceSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      Log::info(request()->fullUrl());
      Log::info(request());

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
      // dd(Auth::guard('user')->user());
        $slider =Slider::where('status','activated')->get();
        $agencies = Agency::get();
        $data = DB::table('packages')
            ->join('agencies', 'packages.agency_id', '=', 'agencies.id')
            ->select('packages.*', 'agencies.img')
            ->get();
        $reviews = Review::get();
        $package =Package::where('status','activated')->orderby('id','DESC')->paginate(6);
        $service =Service::where('status','activated')->get();
        $service_slider =ServiceSlider::where('status','activated')->get();
        $locations = Locations::all();
        $featured_packages = collect();
        foreach($agencies as $agency){
          $agency_package =Package::where('status','activated')->where('agency_id',$agency->id)->orderBy('price', 'ASC')->first();
          if($agency_package && $agency_package->agency){
            $agency_package->img = $agency_package->agency->img;
            $featured_packages->add($agency_package);
          }
        }
        // dd($request->route()->getPrefix());
        if ($request->route()->getPrefix() == "api") {
          return response()->json([
            'package' => $data,
            'locations' => $locations,
            'featured_packages' => $featured_packages,
            'agencies' => $agencies,
            'reviews'=> $reviews,
            'slider' => $slider
          ]);
        } else {
            // return HTML response
            return view('pages.main',compact(
            'slider',
            'package',
            'service',
            'service_slider',
            'locations',
            'featured_packages',
            'agencies'
            ));
        }
    }

    public function customize_packages(Request $request){
      // dd($request->start_date);
      $about = Page::where('key', 'about')->select('key','value')->first();
      $aboutinfo =null;

      if ($about) {
        $aboutinfo=json_decode($about->value);
      }
      // $start = date('d-m-Y',strtotime(str_replace('/', '-', $request->start_date)));
      // $end = date('d-m-Y',strtotime(str_replace('/', '-', $request->end_date)));
      $start = date('d-m-Y', strtotime($request->start_date));
      $end = date('d-m-Y', strtotime($request->end_date));
      $packages =Package::where('status','activated')->whereBetween('start', [$start,$end])->get();
      // $packages =Package::where('status','activated')->whereBetween('start', [$start,$end])->get();
      // dd($end);
      return view('pages.customize_packages',compact('packages','aboutinfo'));
    }
    public function add_comment(Request $request){
      if ($request->route()->getPrefix() == "api") {
        $user_token = $request->header('token');
        if(! $user_token){
          return response()->json(['error' => "Bad request! Provide access token" ],403);
        }
        $access = User::where('remember_token',$user_token)->first();
        if ($access==null) {
          return response()->json(['error' => "Invalid token" ],403);
        }
        if(!$request->package_id){
          return response()->json(['error' => "Package id can't be null" ],400);
        }
        $check_package = Package::find($request->package_id);
        if(!$check_package){
          return response()->json(['error' => "No package found" ],400);
        }
        if(!$request->comment){
          return response()->json(['error' => "Comment secton cannot be null" ],400);
        }
        $book = Book::where('user_id',$access->id)->where('package_id',$request->package_id)->first();
        if(!$book){
          return response()->json(['error' => "You are not allowed to comment on package as you didn't book this" ],403);
        }
        $comment = New Comment;
        $comment->user_id = $access->id;
        $comment->package_id = $request->package_id;
        $comment->code_body = $request->comment;
        $comment->save();
        return response()->json(['success' => "Comment added succesfully" ],200);
      }
      else{
        if(! Auth::guard('user')->check()){
          return response()->json(['success' => false, 'status' => 'danger', 'message' => _lang('Login to add comment')]);
        }
        $book = Book::where('user_id',Auth::guard('user')->user()->id)->where('package_id',$request->package_id)->first();
        if(! $book){
          return response()->json(['success' => false, 'status' => 'danger', 'message' => _lang('Book this package to add comment')]);
        }
        $comment = New Comment;
        $comment->user_id = Auth::guard('user')->user()->id;
        $comment->package_id = $request->package_id;
        $comment->code_body = $request->comment;
        $comment->save();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Comment Added'), 'goto' => route('home')]);
      }
    }
    public function add_review(Request $request){
      if ($request->route()->getPrefix() == "api") {
        $user_token = $request->header('token');
        if(! $user_token){
          return response()->json(['error' => "Bad request! Provide access token" ],403);
        }
        $access = User::where('remember_token',$user_token)->first();
        if ($access==null) {
          return response()->json(['error' => "Invalid token" ],403);
        }
        if(!$request->package_id){
          return response()->json(['error' => "Package id can't be null" ],400);
        }
        $check_package = Package::find($request->package_id);
        if(!$check_package){
          return response()->json(['error' => "No package found" ],400);
        }
        if(!$request->comment){
          return response()->json(['error' => "Comment secton cannot be null" ],400);
        }
        if(!$request->rate){
          return response()->json(['error' => "Rating secton cannot be null" ],400);
        }
        $book = Book::where('user_id',$access->id)->where('package_id',$request->package_id)->first();
        if(!$book){
          return response()->json(['error' => "You are not allowed to add review on package as you didn't book this" ],403);
        }
        $my_review = Review::where('user_id',$access->id)->where('package_id',$request->package_id)->get();
        if(sizeof($my_review) > 0){
          return response()->json(['error' => "Your review is already submitted" ],403);
        }
        $revew = New Review;
        $revew->user_id = $access->id;
        $revew->package_id = $request->package_id;
        $revew->code_body = $request->comment;
        $revew->stars = $request->rate;
        $revew->save();
        return response()->json(['success' => "Review added succesfully" ],200);
      }
      else{
        if(! Auth::guard('user')->check()){
          return response()->json(['success' => false, 'status' => 'danger', 'message' => _lang('Login to add review')]);
        }
        $book = Book::where('user_id',Auth::guard('user')->user()->id)->where('package_id',$request->package_id)->first();
        if(! $book){
          return response()->json(['success' => false, 'status' => 'danger', 'message' => _lang('Book this package to add review')]);
        }
        $my_review = Review::where('user_id',Auth::guard('user')->user()->id)->where('package_id',$request->package_id)->get();
        if(sizeof($my_review) > 0){
          return response()->json(['success' => false, 'status' => 'danger', 'message' => _lang('Your review is already submitted')]);
        }
        $revew = New Review;
        $revew->user_id = Auth::guard('user')->user()->id;
        $revew->package_id = $request->package_id;
        $revew->code_body = $request->comment;
        $revew->stars = $request->rate;
        $revew->save();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Review Added'), 'goto' => route('home')]);
      }
    }

    public function details(Request $request,$type,$agency,$slug,$id)
    {
      $package =Package::where('id',$id)->where('slug',$slug)->firstOrfail();
      $comments = Comment::where('package_id',$package->id)->get();
      $reviews = Review::where('package_id',$package->id)->get();
      if ($request->route()->getPrefix() == "api") {
        // dd('yes');
        return response()->json([
          'package' => $package,
          'comments' => $comments,
          'reviews' => $reviews,
        ]);
      }
      else{
        return view('pages.pkg_details',compact('package','comments','reviews'));
      }
    }
    public function package_details(Request $request,$id)
    {
      $package =Package::find($id);
      if(!$package){
        return response()->json([
          'error' => "Package not found",
        ]);
      }
      $reviews_stars = Review::where('package_id',$package->id)->sum('stars');
      $total_reviews = Review::where('package_id',$package->id)->count();
      $reviews = Review::where('package_id',$package->id)->get();
      if(!$total_reviews){
        return response()->json([
          'reviews_rating' => 0,
          'total_reviews' => 0,
          'reviews' => $reviews
        ]);
      }
      return response()->json([
        'reviews_rating' => $reviews_stars / $total_reviews,
        'total_reviews' => $total_reviews,
        'reviews' => $reviews,
      ]);
    }
    public function agency_details(Request $request,$id)
    {
      $agency =Agency::find($id);
      if(!$agency){
        return response()->json([
          'error' => "Agency not found",
        ]);
      }
      $package =Package::where('agency_id',$agency->id)->pluck('id');
      if(!$agency){
        return response()->json([
          'reviews_rating' => 0,
          'total_reviews' => 0,
          'agency' => $agency,
        ]);
      }
      $reviews_stars = Review::whereIn('package_id',$package)->sum('stars');
      $total_reviews = Review::whereIn('package_id',$package)->count();
      // $reviews = Review::where('package_id',$package->id)->get();
      if(!$total_reviews){
        return response()->json([
          'reviews_rating' => 0,
          'total_reviews' => 0,
          'agency' => $agency,
        ]);
      }
      return response()->json([
        'reviews_rating' => $reviews_stars / $total_reviews,
        'total_reviews' => $total_reviews,
        'agency' => $agency,
      ]);
    }

    public function book(Request $request)
    {
        if ($request->ajax()) {
          if(! Auth::guard('user')->check()){
            return response()->json(['success' => false, 'status' => 'danger', 'message' => _lang('Login to book package')]);
          }
          // $validator = $request->validate([
          //   'name' => ['required', 'max:255'],
          //   'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          //   'phone' => ['required','numeric'],
          //   'subject' => ['required','max:255'],
          //   'messege' => ['required','string']
          // ]);

          $ip =getVisIpAddr();
          $getvalue=  getVisIpDetails($ip);

          $user = User::find($request->user_id);

          // $user = New User;
          // $user->name =$request->name;
          // $user->email =$request->email;
          // $user->phone =$request->phone;
          $user->subject =$request->subject;
          $user->messege =$request->messege;
          // $user->ip =$ip;
          // $user->country =$getvalue->geoplugin_countryName;
          // $user->city =$getvalue->geoplugin_city;
          // $user->continent =$getvalue->geoplugin_continentName;
          // $user->latitude =$getvalue->geoplugin_latitude;
          // $user->longitude =$getvalue->geoplugin_longitude;
          // $user->currency_symbol =$getvalue->geoplugin_currencySymbol;
          // $user->currency_code =$getvalue->geoplugin_currencyCode;
          // $user->timezone =$getvalue->geoplugin_timezone;
          // $user->save();

          $book =new Book;
          $book->user_id =$user->id;
          $book->package_id =$request->package_id;
          $book->save();

          return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Book Confirm')]);
        }else{
          $user_token = $request->header('token');
          if(! $user_token){
            return response()->json(['error' => "Bad request! Provide access token" ],403);
          }
          if(!$request->user_id){
            return response()->json(['error' => "Login to book package" ],400);
          }
          $access = User::where('remember_token',$user_token)->first();
          if ($access==null || $access->id != $request->user_id) {
            return response()->json(['error' => "Invalid token" ],403);
          }

          if(!$request->package_id){
            return response()->json(['error' => "Package id can't be null" ],400);
          }
          $check_package = Package::find($request->package_id);
          if(!$check_package){
            return response()->json(['error' => "No package found" ],400);
          }
          $ip =getVisIpAddr();
          $getvalue=  getVisIpDetails($ip);
          $user = User::find($request->user_id);
         
          // $user = New User;
          // $user->name =$request->name;
          // $user->email =$request->email;
          // $user->phone =$request->phone;
       
          $user->subject =$request->subject;
          $user->messege =$request->messege;
          // $user->ip =$ip;
          // $user->country =$getvalue->geoplugin_countryName;
          // $user->city =$getvalue->geoplugin_city;
          // $user->continent =$getvalue->geoplugin_continentName;
          // $user->latitude =$getvalue->geoplugin_latitude;
          // $user->longitude =$getvalue->geoplugin_longitude;
          // $user->currency_symbol =$getvalue->geoplugin_currencySymbol;
          // $user->currency_code =$getvalue->geoplugin_currencyCode;
          // $user->timezone =$getvalue->geoplugin_timezone;
           $user->save();

          $book =new Book;
          $book->user_id =$user->id;
          $book->package_id =$request->package_id;
          $book->save();
          return response()->json(['success' => "Book Confirm! Will contact you as soon as possible", ]);
        }
    }


    public function policy(Request $request)
    {

      $about = Page::where('key', 'about')->select('key','value')->first();
      $aboutinfo =null;
      $policy = 0;
      $title = "Terms of Condition";

      if ($about) {
        $aboutinfo=json_decode($about->value);
      }
      if ($request->route()->getName() == "policy") {
        $policy = 1;
        $title = "Privacy Policy";
      }
        return view('pages.policy',compact('aboutinfo','policy','title'));
    }

    public function about(Request $request)
    {

      $about = Page::where('key', 'about')->select('key','value')->first();
      $aboutinfo =null;

      if ($about) {
        $aboutinfo=json_decode($about->value);
      }
      if ($request->route()->getPrefix() == "api") {
        return response()->json([
          'aboutinfo' => $aboutinfo,
        ]);
      }
      else{
        return view('pages.about',compact('aboutinfo'));
      }

    }

    public function faq(Request $request)
    {

      $about = Page::where('key', 'about')->select('key','value')->first();
      $aboutinfo =null;

      if ($about) {
        $aboutinfo=json_decode($about->value);
      }
      if ($request->route()->getPrefix() == "api") {
        return response()->json([
          'aboutinfo' => $aboutinfo,
        ]);
      }
      else{
        return view('pages.faq',compact('aboutinfo'));
      }

    }

    public function blog(Request $request)
    {
      $blogs = Blogs::orderBy('id', 'DESC')->get();
      $about = Page::where('key', 'about')->select('key','value')->first();
      $aboutinfo =null;
      if ($about) {
        $aboutinfo=json_decode($about->value);
      }
      if ($request->route()->getPrefix() == "api") {
        return response()->json([
          'aboutinfo' => $aboutinfo,
          'blogs' => $blogs,
        ]);
      }
      else{
        return view('pages.blog',compact('aboutinfo','blogs'));
      }
    }

    public function blog_detail(Request $request,$slug)
    {
      $bloginfo = Blogs::where('slug',$slug)->first();
      $about = Page::where('key', 'about')->select('key','value')->first();
      $aboutinfo =null;
      if ($about) {
         $aboutinfo=json_decode($about->value);
      }
      $contact = Page::where('key', 'contact')->select('key','value')->first();
      $contactinfo =null;
      if ($contact) {
         $contactinfo=json_decode($contact->value);
      }

      if ($request->route()->getPrefix() == "api") {
        return response()->json([
          'aboutinfo' => $aboutinfo,
          'bloginfo' => $bloginfo,
          'contactinfo' => $contactinfo,
        ]);
      }
      else{
        return view('pages.blog_detail',compact('aboutinfo','bloginfo','contactinfo'));
      }
    }

    public function umrah(Request $request)
    {
      $about = Page::where('key', 'about')->select('key','value')->first();
      $aboutinfo =null;

      if ($about) {
          $aboutinfo=json_decode($about->value);
      }
      $packages =Package::where('type','umrah')->where('status','activated')->get();
      foreach($packages as $package)
      {
        $package->img = $package->agency->img;
        unset($package->agency);
      }

      if ($request->route()->getPrefix() == "api") {
        return response()->json([
          'aboutinfo' => $aboutinfo,
          'packages' => $packages,
        ]);
      }
      else{
        return view('pages.umrah',compact('packages','aboutinfo'));
      }
    }

   public function hajj(Request $request)
   {
      $about = Page::where('key', 'about')->select('key','value')->first();
      $aboutinfo =null;

      if ($about) {
          $aboutinfo=json_decode($about->value);
      }
      $packages =Package::where('type','hajj')->where('status','activated')->get();
      foreach($packages as $package)
      {
        $package->img = $package->agency->img;
        unset($package->agency);
      }

      if ($request->route()->getPrefix() == "api") {
        return response()->json([
          'aboutinfo' => $aboutinfo,
          'packages' => $packages,
        ]);
      }
      else{
        return view('pages.hajj',compact('packages','aboutinfo'));
      }
     }

    public function news()
    {

    $about = Page::where('key', 'about')->select('key','value')->first();
        $aboutinfo =null;

     if ($about) {
        $aboutinfo=json_decode($about->value);
     }
        $news =News::where('status','activated')->paginate(12);
        return view('pages.news',compact('news','aboutinfo'));
     }

     public function news_details(Request $request ,$slug,$id)
     {
        $populars =News::get()->take(4)->except($id);
        $comments =Comment::findOrFail(1);
        $news =News::where('id',$id)->where('slug',$slug)->firstOrfail();
        return view('pages.news_details',compact('news','populars','comments'));
     }

     public function profile(Request $request,$id)
     {
        $packages = collect();
       $books = Book::where('user_id',$id)->pluck('package_id');
       if(sizeof($books)>0){
         $packages = Package::whereIn('id',$books)->get();
       }

       $packages->transform(function ($package) {
            $package->img = $package->agency->img;
            unset($package->agency);
            return $package;
        });

       if ($request->route()->getPrefix() == "api") {
         return response()->json([
           'packages' => $packages,
          ]);
        }
        else{
          if(! Auth::guard('user')->check() || Auth::guard('user')->user()->id != $id){
            return redirect('/');
          }
          $contact = Page::where('key', 'contact')->select('key','value')->first();
          $contactinfo =null;
          if ($contact) {
              $contactinfo=json_decode($contact->value);
          }
          return view('pages.profile',compact('contactinfo','packages'));
        }

     }
     public function contact(Request $request)
     {
        $contact = Page::where('key', 'contact')->select('key','value')->first();
        $contactinfo =null;
        if ($contact) {
            $contactinfo=json_decode($contact->value);
        }

        if ($request->route()->getPrefix() == "api") {
          return response()->json([
            'contactinfo' => $contactinfo,
          ]);
        }
        else{
          return view('pages.contact',compact('contactinfo'));
        }

     }

     public function post_contact(Request $request)
     {
        if ($request->ajax()) {
          $validator = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required','numeric'],
            'subject' => ['required','max:255'],
          ]);

          $contact = New Contact;
          $contact->name =$request->name;
          $contact->email =$request->email;
          $contact->phone =$request->phone;
          $contact->subject =$request->subject;
          $contact->messege =$request->messege;
          $contact->save();
          $expiresAt = Carbon::now()->addMinutes(60);

          Cache::put('contact', $contact, $expiresAt);
          return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Thank For Your Response')]);
        }else{
          if($request->email == "" || $request->name=="" || $request->subject || $request->subject){
            return response()->json([
              'error' => "Email, name, phone and subject can't be null",
            ]);
          }
          $contact = New Contact;
          $contact->name =$request->name;
          $contact->email =$request->email;
          $contact->phone =$request->phone;
          $contact->subject =$request->subject;
          $contact->messege =$request->messege;
          $contact->save();
          $expiresAt = Carbon::now()->addMinutes(60);

          Cache::put('contact', $contact, $expiresAt);
          return response()->json([
            'Success' =>"Your message sent successfully",
          ]);
        }
     }


  public function question(Request $request)
  {
    if ($request->ajax()) {
          $validator = $request->validate([
            'qname' => ['required', 'max:255'],
            'qemail' => ['required', 'string', 'email', 'max:255', 'unique:questions'],
            'ques' => ['required','string']
        ]);
    $question =new Question;
    $question->package_id =$request->package_id;
    $question->qname =$request->qname;
    $question->qemail =$request->qemail;
    $question->ques =$request->ques;
    $question->save();
    return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Thank For Your Feedback')]);

  }
  }

  public function subscibers(Request $request)
  {
    if ($request->ajax()) {
        $validator = $request->validate([
            'sub_email' => ['required', 'string', 'email', 'max:255', 'unique:subscibers'],
        ]);

        $subs =new Subsciber;
        $subs->sub_email=$request->sub_email;
        $subs->save();
         return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Thank For Subscibe')]);

    }
  }

  //
  public function air_ticket()
  {
    $about = Page::where('key', 'about')->select('key','value')->first();
        $aboutinfo =null;

     if ($about) {
        $aboutinfo=json_decode($about->value);
     }
    return view('pages.air_ticket',compact('aboutinfo'));
  }

  //
  public function book_ticket(Request $request)
  {
    if ($request->ajax()) {
        $validator = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:air_tickets'],
            'phone' => ['required', 'max:12'],
            'departure_city' => ['required'],
            'destination_city' => ['required'],
            'departure_date' => ['required', 'date'],
            'arrival_date' => ['required', 'date'],
            'numberz_of_persons' => ['required', 'numeric'],
        ]);

        $air =new AirTicket;
        $air->name =$request->name;
        $air->email =$request->email;
        $air->phone =$request->phone;
        $air->departure_city =$request->departure_city;
        $air->destination_city =$request->destination_city;
        $air->departure_date =$request->departure_date;
        $air->arrival_date =$request->arrival_date;
        $air->arrival_date =$request->arrival_date;
        $air->numberz_of_persons =$request->numberz_of_persons;
        $air->message =$request->message;
        $air->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Thank For  Submit We will Contact you as soon as posible')]);
    }
  }

  public function favoritePackage(Request $request, $id)
  {
    $user = User::where('remember_token',$request->bearerToken())->first();
    if(!$user)
    {
        return response()->json(['success' => false, 'status' => 404,'message' => "User not found"]);
    }
    $package = Package::find($id);
    if($package)
    {
        $existing_package = $user->favoritePackages()->where('package_id',$id)->first();
        if(!$existing_package)
        {
            $user->favoritePackages()->attach($package->id);
            return response()->json(['success' => true, 'status' => 'success','message' => "Favorite package added successfully"]);
        }
        else
        {
            return response()->json(['success' => false, 'status' => 'success','message' => "Package already exists in favorite Packages"]);
        }
    }
    else
    {
        return response()->json(['success' => false, 'status' => 404,'message' => "Package not exists"]);
    }

  }

  public function getFavoritePackages(Request $request)
  {
    $user = User::where('remember_token', $request->bearerToken())->first();
    if($user)
    {
        $packages = [];
        foreach($user->favoritePackages as $package)
        {
          $package->img = $package->agency->img;
          unset($package->agency);
          $packages[] = $package;
        }
        return response()->json(['success' => true, 'status' => 'success','Data' => $packages]);
    }
    else
    {
        return response()->json(['success' => false, 'status' => 404,'message' => "User not found"]);
    }
  }

  public function removeFavoritePackage(Request $request, $id)
  {
    $user = User::where('remember_token', $request->bearerToken())->first();
    if($user)
    {
        $package = $user->favoritePackages()->wherePivot('package_id',$id)->first();
        if($package)
        {
            $user->favoritePackages()->detach($id);
            return response()->json(['success' => true, 'status' => 'success','message' =>"Package removed from favorite packages list successfully" ]);
        }
        else
        {
            return response()->json(['success' => true, 'status' => 404,'message' => "Package not exists in favorite packages list"]);
        }
    }
    else
    {
        return response()->json(['success' => false, 'status' => 404,'message' => "User not found"]);
    }
  }
}
