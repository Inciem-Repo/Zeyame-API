<!-- resources/views/image_categories.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Images</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Image </h1>
          <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form id="imageCategoryForm" method="POST" action="{{ isset($category) ? route('image.update', $category->id) : route('image.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="post_name" class="form-label">Image Name</label>
                <input type="text" id="post_name" name="post_name" class="form-control" 
                       value="{{ old('post_name', $category->post_name ?? '') }}" required placeholder="Enter category name">
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label"> Category</label>
                 <select name="post_tags[]" id="post_tags" class="form-control" multiple>
                    <option value="">None</option>
                    @foreach($categories as $cat)
                         <option value="{{ strtolower($cat->name) }}" 
                            {{ isset($category) && in_array(strtolower($cat->name), $category->post_tags_array ?? []) ? 'selected' : '' }}>
                          {{ ucfirst($cat->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
          @if(isset($image_url) && !empty($image_url))
                <a href="{{ $image_url }}" class="btn btn-secondary mt-3" target="_blank">Saved File</a>
          
            @endif
            <div class="mb-3">
               
                <label for="image_path" class="form-label">Upload Image File</label>
                <input type="file" id="image_path" name="image_path" class="form-control" accept="image/*" >
                @error('image_path')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="sort" class="form-label">Sort Order</label>
                <input type="number" id="sort" name="sort" class="form-control" 
                       value="{{ old('sort', $category->sort ?? 0) }}" placeholder="Enter sort order">
            </div>

            <button type="submit" class="btn btn-primary">Save Category</button>
        </form>
           <a href="{{ route('image.index') }}" class="btn btn-secondary mt-3">Go to Home</a>
    </div>
<!-- Button to go home page -->
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
