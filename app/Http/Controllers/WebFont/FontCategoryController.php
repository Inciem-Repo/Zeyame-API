<?php

namespace App\Http\Controllers\WebFont;
use App\Http\Controllers\Controller;
use App\Models\FontCategory;
use Illuminate\Http\Request;

class FontCategoryController extends Controller
{
        public function create()
    {

        $categories = FontCategory::get();
        return view('font_categories', compact( 'categories'));
        // Return a view with the form for creating a font category
        return view('font_categories'); // Make sure you have this view
    }
      public function index()
    {
        $categories = FontCategory::paginate(20); 
        return view('font_categories_list', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:font,id',
            'sort' => 'nullable|integer',
        ]);

        FontCategory::create($validated);

        return redirect()->back()->with('success', 'Font category created successfully!');
    }

    public function edit($id)
    {
        $category = FontCategory::findOrFail($id);
        $categories = FontCategory::where('id', '!=', $id)->get();
        return view('font_categories', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $category = FontCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:font,id',
            'sort' => 'nullable|integer',
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Font category updated successfully!');
    }
    public function destroy($id)
    {
        $category = FontCategory::findOrFail($id);
    
        // Check for child categories before deleting
        if ($category->children()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete a category with child categories.');
        }
    
        $category->delete();
    
        return redirect()->route('font_categories.index')->with('success', 'Font category deleted successfully!');
    }
}
