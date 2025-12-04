<?php

namespace App\Http\Controllers\WebBackground;
use App\Http\Controllers\Controller;
use App\Models\BackgroundCategory;
use Illuminate\Http\Request;

class BackgroundCategoryController extends Controller
{
        public function create()
    {

        $categories = BackgroundCategory::get();
        return view('background_categories', compact( 'categories'));
        // Return a view with the form for creating a Background category
        return view('background_categories'); // Make sure you have this view
    }
      public function index()
    {
        $categories = BackgroundCategory::paginate(20); 
        return view('background_categories_list', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:background,id',
            'sort' => 'nullable|integer',
        ]);

        BackgroundCategory::create($validated);

        return redirect()->back()->with('success', 'Background category created successfully!');
    }

    public function edit($id)
    {
        $category = BackgroundCategory::findOrFail($id);
        $categories = BackgroundCategory::where('id', '!=', $id)->get();
        return view('background_categories', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $category = BackgroundCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:background,id',
            'sort' => 'nullable|integer',
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Background category updated successfully!');
    }
    public function destroy($id)
    {
        $category = BackgroundCategory::findOrFail($id);
    
        // Check for child categories before deleting
        if ($category->children()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete a category with child categories.');
        }
    
        $category->delete();
    
        return redirect()->route('background_categories.index')->with('success', 'Background category deleted successfully!');
    }
}
