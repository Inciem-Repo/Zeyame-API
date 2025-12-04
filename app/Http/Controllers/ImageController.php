<?php

namespace App\Http\Controllers;


use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Poster;
use App\Models\PosterItems;
use App\Models\SearchCategory;
use App\Models\User;
use App\Models\Font;
use App\Models\Gallery;
use App\Models\Customer;
use App\Models\Goldrate;
use App\Models\Download;
use App\Models\DownloadHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload()
    {
        return view('upload');
    }
    public function userimage(){
        // $customer=Poster::get();
        // $i=0;
        // foreach($customer as $item){
        //     $image_name = $item->ofile;
        //     if (Storage::disk('out')->exists($image_name)) {
        //         $i=$i+1;
        //     }
        // }
        // echo "Totoal Count=".$i;
        
       // $customer=Poster::offset(100)->limit(101)->get();
        $customer=Poster::whereBetween('id', array(8653, 8663))->get();
        foreach($customer as $item){
            $image_name = $item->ofile;
            if (Storage::disk('out')->exists($image_name)) {
                $file=Storage::disk('out')->get($item->ofile);
                $p="user";
                $path =Storage::disk('s3')->put(
                    'poster/' .$image_name,
                    $file
                );
            }
            
           
        }
        
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $extension  = request()->file('image')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
            $image_name = time() .'_' . $request->title . '.' . $extension;
            $path = $request->file('image')->storeAs(
                'images',
                $image_name,
                's3'
            );
            Image::create([
                'title'=>$request->title,
                'image'=>$path
            ]);
            return redirect()->back()->with([
                'message'=> "Image uploaded successfully",
            ]);
     }
    }
}
