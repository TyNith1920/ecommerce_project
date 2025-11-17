@extends('admin.body')

@section('title', 'Cart Management')

@section('content')
<div class="container-fluid py-4">
  <div class="card shadow-lg border-0" style="background: var(--card-bg);">
    <div class="card-body">

      <h2 class="text-gradient mb-4 text-center">🛒 Cart Items</h2>

      <div class="table-responsive">
        <table class="table table-dark table-hover align-middle text-center">
          <thead class="table-primary">
            <tr>
              <th>User</th>
              <th>Product</th>
              <th>Image</th>
              <th>Size</th>
              <th>Color</th>
              <th>Qty</th>
              <th>Total Price</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($cart as $item)
              <tr>
                <td>{{ $item->user?->name ?? 'N/A' }}</td>
                <td>{{ $item->product?->title ?? 'N/A' }}</td>
                <td>
                  @if($item->product?->image)
                    <img src="{{ asset('products/'.$item->product->image) }}" width="60" class="rounded shadow">
                  @else
                    <span class="text-muted">No Image</span>
                  @endif
                </td>
                <td>{{ $item->size ?? '-' }}</td>
                <td>{{ $item->color ?? '-' }}</td>
                <td>{{ $item->quantity ?? 1 }}</td>
                <td>
                  @if($item->product)
                    ${{ number_format($item->product->price * ($item->quantity ?? 1), 2) }}
                  @else
                    N/A
                  @endif
                </td>
                <td>
                  <a href="{{ url('admin/cart/edit/'.$item->id) }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-edit"></i> Edit
                  </a>
                  <a href="{{ url('admin/cart/delete/'.$item->id) }}" 
                     class="btn btn-sm btn-danger"
                     onclick="return confirm('Are you sure to delete this item?')">
                    <i class="fa fa-trash"></i> Delete
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-muted py-3">
                  <i class="fa fa-box-open"></i> No items in cart.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
@endsection
