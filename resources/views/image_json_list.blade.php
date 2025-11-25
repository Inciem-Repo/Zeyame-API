<!-- resources/views/image_categories_list.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Images List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style></style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Image Gallery</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add New Category Button -->
        <div class="mb-4">
            <a href="{{ route('image.create') }}" class="btn btn-primary">Add New</a>
        </div>

       <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th> Name</th>
                <th>Parent Category</th>
                <th>Sort Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                    <td>{{ $category->post_name }}</td>
                    <td>{{ $category->post_tags ? $category->post_tags : 'None' }}</td>
                    <td>{{ $category->sort ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('image.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('image.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No image categories available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

<!-- Pagination Links -->
<div class="d-flex justify-content-center mt-3">
    {{ $categories->links('pagination::bootstrap-4') }}
</div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
