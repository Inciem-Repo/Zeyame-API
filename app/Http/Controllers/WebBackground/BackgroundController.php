<?php

namespace App\Http\Controllers\WebBackground;
use App\Http\Controllers\Controller;
use App\Models\BackgroundFiles;
use App\Models\BackgroundCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class BackgroundController extends Controller
{
        public function create()
    {

         $categories = BackgroundCategory::get();
        return view('background_json', compact( 'categories'));
        // Return a view with the form for creating a background category
       // Make sure you have this view
    }
      public function index()
    {
        $categories = BackgroundFiles::paginate(20); 
        return view('background_json_list', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_name' => 'required|string|max:255',
            'post_tags' => 'nullable|array',
            'sort' => 'nullable|integer',
            'image_path' => 'required', // Validate .ttf file
        ]);
        
        $background_name="";
        // Get the background file
        if ($request->hasFile('image_path')) {
            $background = $request->file('image_path');
           // Generate a unique background filename
            $temporaryFileName = uniqid() . '.' . $background->getClientOriginalExtension();
        
            // Store the background in the S3 bucket
            Storage::disk('s3')->put('background_backgrounds/' . $temporaryFileName, file_get_contents($background));
            
           $background_name= 'background_backgrounds/'.$temporaryFileName;
        }

        $jsonFile = new BackgroundFiles();
        $jsonFile->post_name =  $validated['post_name'];
        $jsonFile->user_email ="salam@gmail.com";
        $jsonFile->post_tags = $validated['post_tags']??[];
        $jsonFile->image_path = $background_name;
       $jsonFile->sort= $validated['sort'] ?? 0;
        $jsonFile->save();

        return redirect()->back()->with('success', 'Background category created successfully!');
    }

    public function edit($id)
    {
        $category = BackgroundFiles::findOrFail($id);
        $categories = BackgroundCategory::get();
        $background_url = Storage::disk('s3')->url($category->image_path); 
        return view('background_json', compact('category', 'categories','background_url'));
    }

    public function update(Request $request, $id)
    {
        $category = BackgroundFiles::findOrFail($id);

 
        $validated = $request->validate([
            'post_name' => 'required|string|max:255',
            'post_tags' => 'nullable|array',
            'sort' => 'nullable|integer',
          
        ]);
        
        $background_name="";
        // Get the background file
        if ($request->hasFile('image_path')) {
            $background = $request->file('image_path');
           // Generate a unique background filename
            $temporaryFileName = uniqid() . '.' . $background->getClientOriginalExtension();
        
            // Store the background in the S3 bucket
            Storage::disk('s3')->put('background_backgrounds/' . $temporaryFileName, file_get_contents($background));
            
           $background_name= 'background_backgrounds/'.$temporaryFileName;
        }
   
        $category->post_name =  $validated['post_name'];
        $category->post_tags = $validated['post_tags']??[];
        $category->sort= $validated['sort'] ?? 0;
        if($background_name!=""){
             $category->image_path = $background_name;
        }
             $category->save();

        return redirect()->back()->with('success', 'Background category updated successfully!');
    }
    public function destroy($id)
    {
        $category = BackgroundFiles::findOrFail($id);
    
        // // Check for child categories before deleting
        // if ($category->children()->exists()) {
        //     return redirect()->back()->with('error', 'Cannot delete a category with child categories.');
        // }
    
        $category->delete();
    
        return redirect()->route('background.index')->with('success', 'Background category deleted successfully!');
    }
}
