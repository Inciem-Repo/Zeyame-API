<?php

namespace App\Http\Controllers\WebImage;
use App\Http\Controllers\Controller;
use App\Models\ImageFiles;
use App\Models\ImageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ImageController extends Controller
{
        public function create()
    {

         $categories = ImageCategory::get();
        return view('image_json', compact( 'categories'));
        // Return a view with the form for creating a image category
       // Make sure you have this view
    }
      public function index()
    {
        $categories = ImageFiles::paginate(20); 
        return view('image_json_list', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_name' => 'required|string|max:255',
            'post_tags' => 'nullable|array',
            'sort' => 'nullable|integer',
            'image_path' => 'required', // Validate .ttf file
        ]);
        
        $image_name="";
        // Get the image file
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
           // Generate a unique image filename
            $temporaryFileName = uniqid() . '.' . $image->getClientOriginalExtension();
        
            // Store the image in the S3 bucket
            Storage::disk('s3')->put('image_images/' . $temporaryFileName, file_get_contents($image));
            
           $image_name= 'image_images/'.$temporaryFileName;
        }

        $jsonFile = new ImageFiles();
        $jsonFile->post_name =  $validated['post_name'];
        $jsonFile->user_email ="salam@gmail.com";
        $jsonFile->post_tags = $validated['post_tags']??[];
        $jsonFile->image_path = $image_name;
       $jsonFile->sort= $validated['sort'] ?? 0;
        $jsonFile->save();

        return redirect()->back()->with('success', 'Image category created successfully!');
    }

    public function edit($id)
    {
        $category = ImageFiles::findOrFail($id);
        $categories = ImageCategory::get();
        $image_url = Storage::disk('s3')->url($category->image_path); 
        return view('image_json', compact('category', 'categories','image_url'));
    }

    public function update(Request $request, $id)
    {
        $category = ImageFiles::findOrFail($id);

 
        $validated = $request->validate([
            'post_name' => 'required|string|max:255',
            'post_tags' => 'nullable|array',
            'sort' => 'nullable|integer',
          
        ]);
        
        $image_name="";
        // Get the image file
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
           // Generate a unique image filename
            $temporaryFileName = uniqid() . '.' . $image->getClientOriginalExtension();
        
            // Store the image in the S3 bucket
            Storage::disk('s3')->put('image_images/' . $temporaryFileName, file_get_contents($image));
            
           $image_name= 'image_images/'.$temporaryFileName;
        }
   
        $category->post_name =  $validated['post_name'];
        $category->post_tags = $validated['post_tags']??[];
        $category->sort= $validated['sort'] ?? 0;
        if($image_name!=""){
             $category->image_path = $image_name;
        }
             $category->save();

        return redirect()->back()->with('success', 'Image category updated successfully!');
    }
    public function destroy($id)
    {
        $category = ImageFiles::findOrFail($id);
    
        // // Check for child categories before deleting
        // if ($category->children()->exists()) {
        //     return redirect()->back()->with('error', 'Cannot delete a category with child categories.');
        // }
    
        $category->delete();
    
        return redirect()->route('image.index')->with('success', 'Image category deleted successfully!');
    }
}
