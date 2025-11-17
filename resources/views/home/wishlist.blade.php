@extends('layouts.app') {{-- បើមិនមាន layout, អាច paste head/bootstrap ដោយខ្លួនឯង --}}

@section('title','My Wishlist')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">My Wishlist</h3>
        <a href="{{ url('shop') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Shop
        </a>
    </div>

    <div class="row g-4">
        @forelse($items as $row)
        @php $p = $row->product; @endphp
        @if($p)
        <div class="col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 position-relative">
                <a href="{{ url('product_details', $p->id) }}" class="text-decoration-none text-dark">
                    <div class="ratio ratio-4x3 bg-light">
                        <img src="{{ $p->image ? asset('products/'.$p->image) : asset('images/no-image.png') }}"
                            alt="{{ $p->title }}" class="w-100 h-100 object-fit-contain" loading="lazy">
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">{{ \Illuminate\Support\Str::limit($p->title, 60) }}</h6>
                        <div class="mb-2">
                            @if($p->discount_price && $p->discount_price < $p->price)
                                <span class="text-danger fw-bold">${{ number_format($p->discount_price,2) }}</span>
                                <del class="text-muted ms-1">${{ number_format($p->price,2) }}</del>
                                @else
                                <span class="fw-bold">${{ number_format($p->price,2) }}</span>
                                @endif
                        </div>
                        <small class="text-muted">{{ $p->category ?? 'General' }}</small>
                    </div>
                </a>
                <div class="card-footer bg-transparent border-0 pb-4 d-flex justify-content-center gap-2">
                    <form action="{{ route('wishlist.destroy', $p) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger">
                            <i class="bi bi-heartbreak me-1"></i> Remove
                        </button>
                    </form>
                    <a href="{{ url('add_to_cart', $p->id) }}" class="btn btn-primary">
                        <i class="bi bi-bag-plus me-1"></i> Add to Cart
                    </a>
                </div>
            </div>
        </div>
        @endif
        @empty
        <div class="col-12">
            <div class="text-center text-muted py-5">
                <h5>Your wishlist is empty.</h5>
                <a href="{{ url('shop') }}" class="btn btn-primary mt-3">Go shopping</a>
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $items->onEachSide(1)->links() }}
    </div>
</div>
@endsection