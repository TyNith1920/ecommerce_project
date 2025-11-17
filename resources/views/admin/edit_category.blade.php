@extends('admin.body')

@section('title', 'Edit Category')

@section('content')
<div class="container-fluid py-4">

  <div class="card shadow-lg border-0" style="background: var(--card-bg);">
    <div class="card-body">

      <h2 class="text-center mb-4 text-gradient">Update Category</h2>

      <!-- Update Category Form -->
      <form action="{{ route('admin.categories.update', $data->id) }}" method="POST" class="d-flex justify-content-center mb-4">
        @csrf
        <input 
          type="text" 
          name="category" 
          value="{{ $data->category_name }}" 
          class="form-control w-50 me-2" 
          placeholder="Enter category name" 
          required>
        <button type="submit" class="btn btn-warning px-4">Update Category</button>
      </form>

      <div class="text-center">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">← Back to Categories</a>
      </div>

    </div>
  </div>

</div>
@endsection
