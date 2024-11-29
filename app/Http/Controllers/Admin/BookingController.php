<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Agency;
use App\Package;

class BookingController extends Controller
{
    public function index()
   {
    // dd($package);
    if(auth()->user()->id == 1){
      $book =Book::all();
    }else{
      $agency = Agency::where('user_id',auth()->user()->id)->first();
      $package = Package::where('agency_id',$agency->id)->pluck('id')->toArray();
      $book =Book::whereIn('package_id',$package)->get();
    }
   	// $book =Book::all();
   	return view('admin.booking.index',compact('book'));
   }

   //

   public function client(Request $request,$id)
   {
   	if ($request->ajax()) {
   	 
   	  $book =Book::findOrFail($id);
   	  return view('admin.booking.client',compact('book'));
   	}
   }


   //
   public function packege(Request $request,$id)
    {
      if ($request->ajax()) {
        $book =Book::findOrFail($id);
        return view('admin.booking.packege',compact('book'));
      }
    }

    //
    public function destroy(Request $request,$id)
    {
        if ($request->ajax()) {
            $book = Book::findOrFail($id);
            $book->delete();
            if ($book) {
             return response()->json(['success' => true, 'status' => 'success', 'message' => 'Book Information Delete Successfully.','goto'=>route('admin.book.index')]);
         }
     }
 }
}
