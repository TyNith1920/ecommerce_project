@extends('admin.body')

@section('title', 'Manage Categories')

@section('content')
<div class="container-fluid py-4">

  <div class="card shadow-lg border-0" style="background: var(--card-bg);">
    <div class="card-body">

      <h2 class="text-center mb-4 text-gradient">Add Category</h2>

      <!-- Add Category Form -->
      <form action="{{ route('admin.categories.add') }}" method="POST" class="d-flex justify-content-center mb-4">
        @csrf
        <input type="text" name="category" class="form-control w-50 me-2"
          placeholder="Enter category name" required>
        <button type="submit" class="btn btn-primary px-4">Add Category</button>
      </form>

      <!-- Category Table -->
      <div class="table-responsive">
        <table class="table table-dark table-hover text-center align-middle rounded">
          <thead class="table-primary">
            <tr>
              <th>Category Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $item)
            <tr>
              <td>{{ $item->category_name }}</td>
              <td>
                <!-- ✅ Use route() instead of url() -->
                <a class="btn btn-success btn-sm" href="{{ route('admin.categories.edit', $item->id) }}">Edit</a>
              </td>
              <td>
                <a class="btn btn-danger btn-sm" 
                   onclick="return confirm('Are you sure to delete this category?')" 
                   href="{{ route('admin.categories.delete', $item->id) }}">Delete</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>

</div>
@endsection
