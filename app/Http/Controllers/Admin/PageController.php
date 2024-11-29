<?php

namespace App\Http\Controllers\Admin;

use App\Blogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myblogs()
    {
        $blogs = Blogs::get();
        return view('admin.pages.myblogs')->with('blogs',$blogs);
    }

    public function create_blog()
    {
        return view('admin.pages.addblog');
    }
    public function edit_blog($id)
    {
        $blog = Blogs::find($id);
        return view('admin.pages.editblog')->with('blog',$blog);
    }
    public function submit_edit_blog(Request $request)
    {
        // dd($request->blog_id);
        $blog = Blogs::find($request->blog_id);
        $blog->heading = $request->blog_heading;
        $blog->slug = str_slug($request->blog_heading);
        $blog->description = $request->blog_description;
        if($request->hasFile('blog_image')) {
            $storagepath = $request->file('blog_image')->store('public/pages');
            $fileName = basename($storagepath);
            $blog->photo = $fileName;

            //if file chnage then delete old one
            $oldFile = $request->get('old_blog_image','');
            if( $oldFile != ''){
                $file_path = "public/pages/".$oldFile;
                Storage::delete($file_path);
            }
        }
        else{
            $blog->photo = $request->get('old_blog_image','');
        }
        $blog->meta_title = $request->meta_title;
        $blog->meta_keyword = $request->meta_keyword;
        $blog->meta_description = $request->meta_description;
        $blog->save();
        return redirect()->back();
    }
    public function delete_blog(Request $request,$id)
    {
        if ($request->ajax()) {
            $blog = Blogs::find($id);
            unlink('storage/pages/'.$blog->photo);
            $blog->delete();
            return response()->json(['message' => 'Blog Information Deleted Successfully', 'goto' => route('admin.pages.myblogs')]);
         }
    }

    public function datatable(Request $request) {
        if ($request->ajax()) {
            // return response()->json(['success' => true, 'status' => 'success', 'message' => 'Blog Information Delete Successfully.']);
          $model = Blogs::all();
          return Datatables::of($model)
          ->addIndexColumn()
          ->editColumn('photo',function($model){
            $url= asset('storage/packege/'.$model->photo);
            return '<img src="'.$url.'" border="0" width="120" align="center" />';
          })
          ->editColumn('heading', function ($model) {
            $mail= $model->heading;
            return $mail;
          })
          ->editColumn('description', function ($model) {
            $mail= $model->description;
            return $mail;
          })
          ->addColumn('action', function ($model) {
            return view('admin.pages.action', compact('model'));
          })->rawColumns(['action','status','image'])->make(true);
        }
      }


    public function submit_blog(Request $request)
    {
        // dd($request->file('blog_image'));
        $blog = new Blogs();
        $blog->heading = $request->blog_heading;
        $blog->slug = str_slug($request->blog_heading);
        $blog->description = $request->blog_description;
        if($request->hasFile('blog_image')) {
            $storagepath = $request->file('blog_image')->store('public/pages');
            $fileName = basename($storagepath);
            $blog->photo = $fileName;
        }
        $blog->meta_title = $request->meta_title;
        $blog->meta_keyword = $request->meta_keyword;
        $blog->meta_description = $request->meta_description;
        $blog->save();
        return redirect('admin/pages/myblogs');
    }

    public function index()
    {
      if (!auth()->user()->can('page.view')) {
        abort(403, 'Unauthorized action.');
      }
     $home = Page::where('key', 'home')->select('key','value')->first();
     $about = Page::where('key', 'about')->select('key','value')->first();
     $contact = Page::where('key', 'contact')->select('key','value')->first();
     $news = Page::where('key', 'news')->select('key','value')->first();
    //  $blog = Page::where('key', 'blog')->select('key','value')->first();
     $hajj = Page::where('key', 'hajj')->select('key','value')->first();
     $umrah = Page::where('key', 'umrah')->select('key','value')->first();
     $homeinfo =null;
     $aboutinfo =null;
     $newsinfo =null;
     $bloginfo =null;
     $hajjinfo =null;
     $umrahinfo =null;
     $contactinfo =null;

     if ($home) {
        $homeinfo=json_decode($home->value);
     }
     if ($about) {
        $aboutinfo=json_decode($about->value);
     }
     if ($contact) {
        $contactinfo=json_decode($contact->value);
     }

    //  if ($blog) {
    //     $bloginfo=json_decode($blog->value);
    //  }
     if ($news) {
        $newsinfo=json_decode($news->value);
     }

     if ($hajj) {
        $hajjinfo=json_decode($hajj->value);
     }
     if ($umrah) {
        $umrahinfo=json_decode($umrah->value);
     }
        return view('admin.pages.index',compact(
            'homeinfo',
            'aboutinfo',
            'contactinfo',
            // 'bloginfo',
            'newsinfo',
            'hajjinfo',
            'umrahinfo'

        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if ($request->ajax()) {
        $validator = $request->validate([
          'about_banner' => 'mimes:jpeg,bmp,png,jpg|max:2000',
          'about_image' => 'mimes:jpeg,bmp,png,jpg|max:2000',
          'contact_image' => 'mimes:jpeg,bmp,png,jpg|max:2000',
        ]);

        $home['meta_title'] =$request->meta_title;
        $home['meta_keyword'] =$request->meta_keyword;
        $home['meta_description'] =$request->meta_description;

          //now crate Home page
            Page::updateOrCreate(
                ['key' => 'home'],
                ['value' => json_encode($home)]
            );
          //about
            if($request->hasFile('about_banner')) {
            $storagepath = $request->file('about_banner')->store('public/pages');
            $fileName = basename($storagepath);
            $about['about_banner'] = $fileName;

            //if file chnage then delete old one
            $oldFile = $request->get('old_about_banner','');
            if( $oldFile != ''){
                $file_path = "public/pages/".$oldFile;
                Storage::delete($file_path);
            }
            }
            else{
                $about['about_banner'] = $request->get('old_about_banner','');
            }
            //................

             if($request->hasFile('about_image')) {
            $storagepath = $request->file('about_image')->store('public/pages');
            $fileName = basename($storagepath);
            $about['about_image'] = $fileName;

            //if file chnage then delete old one
            $oldFile = $request->get('old_about_image','');
            if( $oldFile != ''){
                $file_path = "public/pages/".$oldFile;
                Storage::delete($file_path);
            }
            }
            else{
                $about['about_image'] = $request->get('old_about_image','');
            }

            $about['about_content'] =$request->about_content;
            $about['about_meta_title'] =$request->about_meta_title;
            $about['about_meta_keyword'] =$request->about_meta_keyword;
            $about['about_meta_description'] =$request->about_meta_description;
              //now crate about page
            Page::updateOrCreate(
                ['key' => 'about'],
                ['value' => json_encode($about)]
            );
            //contact
            if($request->hasFile('contact_image')) {
            $storagepath = $request->file('contact_image')->store('public/pages');
            $fileName = basename($storagepath);
            $contact['contact_image'] = $fileName;

            //if file chnage then delete old one
            $oldFile = $request->get('old_contact_image','');
            if( $oldFile != ''){
                $file_path = "public/pages/".$oldFile;
                Storage::delete($file_path);
            }
            }
            else{
                $contact['contact_image'] = $request->get('old_contact_image','');
            }

            $contact['contact_heading'] =$request->contact_heading;
            $contact['contact_address'] =$request->contact_address;
            $contact['contact_email'] =$request->contact_email;
            $contact['contact_phone'] =$request->contact_phone;
            $contact['contact_map'] =$request->contact_map;
            $contact['contact_meta_title'] =$request->contact_meta_title;
            $contact['contact_meta_keyword'] =$request->contact_meta_keyword;
            $contact['contact_meta_description'] =$request->contact_meta_description;
              //now crate contact page
            Page::updateOrCreate(
                ['key' => 'contact'],
                ['value' => json_encode($contact)]
            );

            //news
            // if($request->hasFile('blog_image')) {
            //     $storagepath = $request->file('blog_image')->store('public/pages');
            //     $fileName = basename($storagepath);
            //     $blog['blog_image'] = $fileName;
    
            //     //if file chnage then delete old one
            //     $oldFile = $request->get('old_blog_image','');
            //     if( $oldFile != ''){
            //         $file_path = "public/pages/".$oldFile;
            //         Storage::delete($file_path);
            //     }
            // }
            // else{
            //     $blog['blog_image'] = $request->get('old_blog_image','');
            // }

            $news['news_meta_title'] =$request->news_meta_title;
            $news['news_meta_keyword'] =$request->news_meta_keyword;
            $news['news_meta_description'] =$request->news_meta_description;
         ;
              //now crate news page
            Page::updateOrCreate(
                ['key' => 'blog'],
                ['value' => json_encode($news)]
            );

              //hajj

            $hajj['hajj_heading'] =$request->hajj_heading;
            $hajj['hajj_meta_title'] =$request->hajj_meta_title;
            $hajj['hajj_meta_keyword'] =$request->hajj_meta_keyword;
            $hajj['hajj_meta_description'] =$request->hajj_meta_description;
         ;
              //now crate hajj page
            Page::updateOrCreate(
                ['key' => 'hajj'],
                ['value' => json_encode($hajj)]
            );

              //umrah

            $umrah['umrah_heading'] =$request->umrah_heading;
            $umrah['umrah_meta_title'] =$request->umrah_meta_title;
            $umrah['umrah_meta_keyword'] =$request->umrah_meta_keyword;
            $umrah['umrah_meta_description'] =$request->umrah_meta_description;
         ;
              //now crate umrah page
            Page::updateOrCreate(
                ['key' => 'umrah'],
                ['value' => json_encode($umrah)]
            );

            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Updated')]); 
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
