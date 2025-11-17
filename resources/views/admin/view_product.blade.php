@extends('admin.body')
@php use Illuminate\Support\Str; @endphp

@section('title', 'All Products')

@section('content')
<div class="container-fluid py-4">

  <div class="card shadow-lg border-0" style="background: var(--card-bg); color: var(--text-color);">
    <div class="card-body">

      <h2 class="text-center mb-4 text-gradient">All Products</h2>

      <!-- Search Bar -->
      <form action="{{ route('admin.products.search') }}" method="GET" class="d-flex justify-content-center mb-4">
        <input type="text" name="search" class="form-control w-50 me-2 bg-transparent text-light border-secondary" placeholder="Search by title or category...">
        <button type="submit" class="btn btn-secondary">Search</button>
      </form>

      <!-- Products Table -->
      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle text-center">
          <thead class="table-primary">
            <tr>
              <th>Product Title</th>
              <th>Description</th>
              <th>Category</th>
              <th>Price ($)</th>
              <th>Discount ($)</th>
              <th>Quantity</th>
              <th>Image</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            @forelse($product as $item)
              <tr>
                <td>{{ $item->title }}</td>
                <td>{{ Str::limit($item->description, 50) }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->discount_price ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>
                  @if($item->image && file_exists(public_path('products/'.$item->image)))
                    <img src="{{ asset('products/' . $item->image) }}" width="80" height="80" class="rounded shadow-sm">

                  @else
                    <span class="text-muted">No Image</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                </td>
                <td>
                  <a href="{{ route('admin.products.delete', $item->id) }}" class="btn btn-danger btn-sm delete-btn">Delete</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-muted">No products found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-center mt-4">
        {{ $product->onEachSide(1)->links() }}
      </div>

    </div>
  </div>

</div>

<!-- SweetAlert Delete -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const deleteButtons = document.querySelectorAll('.delete-btn');
  deleteButtons.forEach(button => {
    button.addEventListener('click', function(event) {
      event.preventDefault();
      const url = this.getAttribute('href');
      Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
    });
  });
});
</script>
@endsection
