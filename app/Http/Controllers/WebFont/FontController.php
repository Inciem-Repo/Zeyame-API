<?php

namespace App\Http\Controllers\WebFont;
use App\Http\Controllers\Controller;
use App\Models\FontFiles;
use App\Models\FontCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class FontController extends Controller
{
    public function getFonts()
    {
        $fonts = FontFiles::where('show_status', true)
            ->get([
                'post_name as name',
                'image_path as href' // Assuming image_path stores the font file path
            ]);
    
        // Generate full URLs for the fonts
        foreach ($fonts as $font) {
            $font->href = Storage::disk('s3')->url($font->href);
        }
    
        return response()->json(['fonts' => $fonts]);
    }
        public function create()
    {

         $categories = FontCategory::get();
        return view('font_json', compact( 'categories'));
        // Return a view with the form for creating a font category
       // Make sure you have this view
    }
      public function index()
    {
        $categories = FontFiles::paginate(20); 
        return view('font_json_list', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
             'show_status' => 'sometimes|boolean',
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
            Storage::disk('s3')->put('font_images/' . $temporaryFileName, file_get_contents($image));
            
           $image_name= 'font_images/'.$temporaryFileName;
        }

        $jsonFile = new FontFiles();
        $jsonFile->post_name =  $validated['post_name'];
        $jsonFile->user_email ="salam@gmail.com";
        $jsonFile->post_tags = $validated['post_tags']??[];
        $jsonFile->image_path = $image_name;
       $jsonFile->sort= $validated['sort'] ?? 0;
       $jsonFile->show_status = $request->has('show_status'); 
        $jsonFile->save();

        return redirect()->back()->with('success', 'Font category created successfully!');
    }

    public function edit($id)
    {
        $category = FontFiles::findOrFail($id);
        $categories = FontCategory::get();
        $image_url = Storage::disk('s3')->url($category->image_path); 
        return view('font_json', compact('category', 'categories','image_url'));
    }

    public function update(Request $request, $id)
    {
        $category = FontFiles::findOrFail($id);

 
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
            Storage::disk('s3')->put('font_images/' . $temporaryFileName, file_get_contents($image));
            
           $image_name= 'font_images/'.$temporaryFileName;
        }
        $category->show_status = $request->has('show_status');
        $category->post_name =  $validated['post_name'];
        $category->post_tags = $validated['post_tags']??[];
        $category->sort= $validated['sort'] ?? 0;
        if($image_name!=""){
             $category->image_path = $image_name;
        }
             $category->save();

        return redirect()->back()->with('success', 'Font category updated successfully!');
    }
    public function destroy($id)
    {
        $category = FontFiles::findOrFail($id);
    
        // // Check for child categories before deleting
        // if ($category->children()->exists()) {
        //     return redirect()->back()->with('error', 'Cannot delete a category with child categories.');
        // }
    
        $category->delete();
    
        return redirect()->route('font.index')->with('success', 'Font category deleted successfully!');
    }
}
