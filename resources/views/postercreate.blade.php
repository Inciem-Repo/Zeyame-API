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
        <form id="imageCategoryForm" method="POST" action="{{ route('posters.store', ['id' => $id]) }}" enctype="multipart/form-data">
            @csrf
        

            <div class="mb-3">
               
                <label for="image_path" class="form-label">Upload Image File</label>
                <input type="file" id="image_path" name="image_path" class="form-control" accept="image/*" >
                @error('image_path')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
          

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
         <a href="{{ route('generatecpy', ['id' => $id]) }}" class="btn btn-secondary mt-3">Go to Home</a>

    </div>
<!-- Button to go home page -->
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
