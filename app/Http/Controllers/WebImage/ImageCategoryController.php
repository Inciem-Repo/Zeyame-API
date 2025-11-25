<?php

namespace App\Http\Controllers\WebImage;
use App\Http\Controllers\Controller;
use App\Models\ImageCategory;
use Illuminate\Http\Request;

class ImageCategoryController extends Controller
{
        public function create()
    {

        $categories = ImageCategory::get();
        return view('image_categories', compact( 'categories'));
        // Return a view with the form for creating a Image category
        return view('image_categories'); // Make sure you have this view
    }
      public function index()
    {
        $categories = ImageCategory::paginate(20); 
        return view('image_categories_list', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:image,id',
            'sort' => 'nullable|integer',
        ]);

        ImageCategory::create($validated);

        return redirect()->back()->with('success', 'Image category created successfully!');
    }

    public function edit($id)
    {
        $category = ImageCategory::findOrFail($id);
        $categories = ImageCategory::where('id', '!=', $id)->get();
        return view('image_categories', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $category = ImageCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:image,id',
            'sort' => 'nullable|integer',
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Image category updated successfully!');
    }
    public function destroy($id)
    {
        $category = ImageCategory::findOrFail($id);
    
        // Check for child categories before deleting
        if ($category->children()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete a category with child categories.');
        }
    
        $category->delete();
    
        return redirect()->route('image_categories.index')->with('success', 'Image category deleted successfully!');
    }
}
