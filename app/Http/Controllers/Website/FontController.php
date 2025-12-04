<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FontFiles; 
use App\Font;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class FontController extends Controller
{
    public function uploadJson(Request $request)
    {
        // Validate the request
        $request->validate([
            // 'post_name'=>'required|string',
            'user_email'=>'required|string',
            'post_tags'=>'sometimes|nullable|string',
        ]);

        $file_id = "";
        $file_id_string = $request->input('file_id');
        if ($file_id_string !== null && $file_id_string !== "") {
            $file_id = $file_id_string;
        }
       // Use the S3 disk to store the image in Amazon S3
   
        
        $image_name="";
        // Get the image file
        if ($request->hasFile('image')) {
            $image = $request->file('image');
           // Generate a unique image filename
            $temporaryFileName = uniqid() . '.' . $image->getClientOriginalExtension();
        
            // Store the image in the S3 bucket
            Storage::disk('s3')->put('font_images/' . $temporaryFileName, file_get_contents($image));
            
           $image_name= 'font_images/'.$temporaryFileName;
        }
        $file_name="";
        
        if($file_id==""){
        
        // Store the file name in the database
        $jsonFile = new FontFiles();
        $jsonFile->post_name = strtotime("now");
        $jsonFile->user_email = $request->input('user_email');
        $jsonFile->post_tags = ",".$request->input('post_tags').",";
        $jsonFile->image_path = $image_name;
        $file_name=$image_name;
        $jsonFile->save();
        $file_id=$jsonFile->id;
        }else{
                     // Update the existing record in the database
            $jsonFile = FontFiles::find($file_id);
            if ($jsonFile) {
                // Update the fields
                // $jsonFile->post_name = $request->input('post_name');
                $jsonFile->post_tags = ",".$request->input('post_tags').",";
                $file_name= 'font_images/'.$temporaryFileName;
                $jsonFile->image_path = 'font_images/'.$temporaryFileName;
                // Save the changes
                $jsonFile->save();
            } else {
                // Handle case when file_id doesn't match any record
                // Possibly return an error response or perform other actions
            }
            
        }
        
        
        
       
        return response()->json(['message' => 'success','file_id'=>$file_id,'file_name'=>$file_name]);
    }
    private function getPostersForCategory($category)
    {
        // Get all descendant category names
        $descendantNames = $this->getAllDescendantNames($category);
    
        // Query FontFiles for posters matching any descendant category name
        $posters = FontFiles::where(function ($query) use ($descendantNames) {
            foreach ($descendantNames as $name) {
                $query->orWhere('post_tags', 'like', '%' . $name . '%');
            }
        })->orderBy('sort', 'desc')->limit(20)->get();
    
        return $posters;
    }

    private function getAllDescendantNames($category)
    {
        $descendantNames = [];
        
        // Helper function to recursively get names of all descendants
        $getDescendantNames = function ($category) use (&$getDescendantNames, &$descendantNames) {
            foreach ($category->getAllChildren as $child) {
                $descendantNames[] = $child->name;
                $getDescendantNames($child);
            }
        };
    
        // Start with current category
        $descendantNames[] = $category->name;
    
        // Call the helper function recursively
        $getDescendantNames($category);
    
        return $descendantNames;
    }
    private function getPostersForCategoryPaginate($category)
    {
        // Get all descendant category names
        $descendantNames = $this->getAllDescendantNames($category);
    
        // Query FontFiles for posters matching any descendant category name
        $posters = FontFiles::where(function ($query) use ($descendantNames) {
            foreach ($descendantNames as $name) {
                $query->orWhere('post_tags', 'like', '%,' . $name . ',%');
            }
        })->orderBy('sort', 'desc')->orderBy('id', 'desc')->paginate(20);
    
        return $posters;
    }

    public function getJsonFiles(Request $request)
    {
        
        $name = $request->input('name', '');
        $cat_id = $request->input('cat_id', '');
            
        $cat = Font::with(['children' => function ($query) use ($name) {
               $query->with('getAllChildren');
            }]);
        if($name!=""){
             $cat->where('name', 'like', '%' . $name . '%');
        }
        if($cat_id!=""){
             $cat->where('id','=', $cat_id);
        }
        if($name==""&&$cat_id==""){
             $cat->where('parent_id','=', '')->OrWhere('parent_id','=', null)->OrWhere('parent_id','=', '0');
        }

        $categories=$cat->OrderBy('sort','desc')->get();
        
        $data=array();
        foreach ($categories as $category) {
            $posters = $this->getPostersForCategory($category);
            
            $data[] = [
                "category_id" => $category->id,
                "category_name" => $category->name,
                "posters" => $posters,
                "categories" => $category->children
            ];
        }
        if(count($data)==0){
            $data=['message'=>'List is Empty'];
        }
           
        
    
        return response($data,200);

    }
    public function getJsonFilesSub(Request $request)
    {
        
        $name = $request->input('name', '');
        $cat_id = $request->input('cat_id', '');
            
        $cat = Font::with(['children' => function ($query) use ($name) {
               $query->with('getAllChildren');
            }]);
        if($name!=""){
             $cat->where('name', 'like', '%' . $name . '%');
        }
        if($cat_id!=""){
             $cat->where('id','=', $cat_id);
        }
        if($name==""&&$cat_id==""){
        
             $cat->where('parent_id','=', '')->OrWhere('parent_id','=', null)->OrWhere('parent_id','=', '0');
        }

        $category=$cat->OrderBy('sort','desc')->first();
        
        $data=array();

            $posters = $this->getPostersForCategoryPaginate($category);
            
            $data = [
                "category_id" => $category->id,
                "category_name" => $category->name,
                "posters" => $posters,
                "categories" => $category->children
            ];
        
        if(count($data)==0){
            $data=['message'=>'List is Empty'];
        }
           
        
    
        return response($data,200);

    }
    public function getJsonFilesSearch(Request $request)
    {
        
         
        $name = $request->input('name', '');
        $cat_id = $request->input('cat_id', '');
            
        $cat = Font::where("id","!=",0);
        
        if($name!=""){
             $cat->where('name', 'like', '%' . $name . '%');
        }
        if($cat_id!=""){
             $cat->where('id','=', $cat_id);
        }
        
         if($name==""&&$cat_id==""){
        
             $cat->where('parent_id','=', '')->OrWhere('parent_id','=', null)->OrWhere('parent_id','=', '0');
        }
        $cat->whereIn('name', function ($query) {
            $query->selectRaw("font.name AS tag")
                ->from('json_font')
                ->where('post_tags', 'LIKE', DB::raw("CONCAT('%,', font.name, ',%')"));
        });


        $categories=$cat->OrderBy('sort','desc')->OrderBy('name','asc')->paginate(30);
        
        // $data=array();
        // foreach ($categories as $category) {

            
        //     $data[] = [
        //         "id" => $category->id,
        //         "name" => $category->name,
              
        //     ];
        // }
        if(count($categories)==0){
            $categories=[];
        }
           
        
    
        return response($categories,200);

    }
     public function getCategories(Request $request)
    {

    $name="";
    if(isset($request->name))
      $name = $request->name;

 // Retrieve both parent and child categories matching the search criteria
        $categories = Font::with(['children' => function ($query) use ($name) {
           // $query->where('name', 'like', '%' . $name . '%')->with('getAllChildren');
           $query->with('getAllChildren');
        }])
        ->where('name', 'like', '%' . $name . '%')
        // ->orWhereHas('children', function ($query) use ($name) {
        //     $query->where('name', 'like', '%' . $name . '%');
        // })
        ->get();
        
        return response()->json(['categories' => $categories]);
    }
}
