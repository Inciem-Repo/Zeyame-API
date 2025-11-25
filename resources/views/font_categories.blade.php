<!-- resources/views/font_categories.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Font Categories</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Font Categories</h1>
          <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form id="fontCategoryForm" method="POST" action="{{ isset($category) ? route('font_categories.update', $category->id) : route('font_categories.store') }}">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" id="name" name="name" class="form-control" 
                       value="{{ old('name', $category->name ?? '') }}" required placeholder="Enter category name">
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Category</label>
                <select id="parent_id" name="parent_id" class="form-control">
                    <option value="">None</option>
                    @foreach($categories as $parent)
                        <option value="{{ $parent->id }}" 
                                {{ (old('parent_id', $category->parent_id ?? '') == $parent->id) ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="sort" class="form-label">Sort Order</label>
                <input type="number" id="sort" name="sort" class="form-control" 
                       value="{{ old('sort', $category->sort ?? 0) }}" placeholder="Enter sort order">
            </div>

            <button type="submit" class="btn btn-primary">Save Category</button>
        </form>
           <a href="{{ route('font_categories.index') }}" class="btn btn-secondary mt-3">Go to Home</a>
    </div>
<!-- Button to go home page -->
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
