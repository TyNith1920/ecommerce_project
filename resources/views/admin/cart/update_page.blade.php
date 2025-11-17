@extends('admin.body')

@section('title', 'Update Cart Item')

@section('content')
<div class="container-fluid py-4">

  <div class="card shadow-lg border-0" style="background: var(--card-bg); color: var(--text-color);">
    <div class="card-body">

      <h2 class="text-gradient mb-4">
        <i class="fa fa-shopping-cart"></i> Update Cart Item
      </h2>

      <form action="{{ route('admin.cart.update', $cart->id) }}" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 700px;">
        @csrf

        <div class="mb-3">
          <label class="form-label fw-bold">User</label>
          <input type="text" class="form-control bg-transparent text-light border-secondary" value="{{ $cart->user->name ?? 'N/A' }}" disabled>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Product</label>
          <input type="text" class="form-control bg-transparent text-light border-secondary" value="{{ $cart->product->title ?? 'N/A' }}" disabled>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Color</label>
            <input type="text" name="color" value="{{ $cart->color }}" class="form-control bg-transparent text-light border-secondary" placeholder="Enter color">
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Size</label>
            <input type="text" name="size" value="{{ $cart->size }}" class="form-control bg-transparent text-light border-secondary" placeholder="Enter size">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Quantity</label>
          <input type="number" name="quantity" value="{{ $cart->quantity }}" class="form-control bg-transparent text-light border-secondary" min="1">
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary px-5 py-2">Update Cart</button>
          <a href="{{ route('admin.cart.index') }}" class="btn btn-secondary px-4 ms-2">Back</a>
        </div>

      </form>

    </div>
  </div>

</div>
@endsection
