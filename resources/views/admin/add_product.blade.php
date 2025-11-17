@extends('admin.body')

@section('title', 'Add Product')

@section('content')
<div class="container-fluid py-4">
  <div class="card shadow-lg border-0" style="background: var(--card-bg); color: var(--text-color);">
    <div class="card-body">

      <h2 class="text-center mb-4 text-gradient">Add New Product</h2>

      <form action="{{ route('admin.products.upload') }}" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 700px;">
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          <i class="fa-solid fa-triangle-exclamation"></i>
          @foreach ($errors->all() as $error)
          {{ $error }}
          @endforeach
        </div>
        @endif

        <div class="mb-3">
          <label class="form-label fw-bold">Product Title</label>
          <input type="text" name="title" class="form-control bg-transparent text-light border-secondary" placeholder="Enter product title" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Description</label>
          <textarea name="description" class="form-control bg-transparent text-light border-secondary" placeholder="Enter description" rows="3" required></textarea>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Price ($)</label>
            <input type="number" name="price" step="0.01" class="form-control bg-transparent text-light border-secondary" placeholder="Enter price">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Discount Price ($)</label>
            <input type="number" name="discount_price" step="0.01" class="form-control bg-transparent text-light border-secondary" placeholder="Enter discount price">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Quantity</label>
          <input type="number" name="qty" class="form-control bg-transparent text-light border-secondary" placeholder="Enter quantity">
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Product Category</label>
          <select name="category" class="form-select bg-transparent text-light border-secondary" required>
            <option value="" disabled selected>Select a Category</option>
            @foreach($category as $cat)
            <option value="{{ $cat->category_name }}">{{ $cat->category_name }}</option>
            @endforeach
          </select>
        </div>

        <!-- 🖼 Main Image -->
        <div class="mb-4">
          <label class="form-label fw-bold">Main Product Image</label>
          <input type="file" name="image" class="form-control bg-transparent text-light border-secondary" required>
        </div>

        <!-- 🖼 Gallery Images -->
        <div class="mb-4">
          <label class="form-label fw-bold">Gallery Images (Optional)</label>
          <input type="file" name="images[]" class="form-control bg-transparent text-light border-secondary" multiple>
          <small class="text-muted">You can select multiple images (JPEG, JPG, PNG only, ≤ 10240 each)</small>
        </div>

        <!-- 🖼 Preview -->
        <div id="preview-wrap" class="mt-3 d-flex flex-wrap gap-2"></div>

        <script>
          document.querySelector('input[name="images[]"]').addEventListener('change', function(e) {
            const preview = document.getElementById('preview-wrap');
            preview.innerHTML = '';
            [...this.files].forEach(file => {
              const img = document.createElement('img');
              img.src = URL.createObjectURL(file);
              img.style.width = '70px';
              img.style.height = '70px';
              img.style.objectFit = 'cover';
              img.style.border = '1px solid #555';
              img.style.borderRadius = '6px';
              preview.appendChild(img);
            });
          });
        </script>

        <div class="text-center">
          <button type="submit" class="btn btn-primary px-4 py-2">Add Product</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection