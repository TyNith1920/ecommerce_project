@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-bold mb-4">Your cart</h1>

<div class="space-y-3">
    @forelse(session('cart', []) as $key => $item)
        <div class="flex items-center justify-between bg-white p-3 rounded border">
            <div class="flex items-center gap-3">
                <img src="{{ $item['image'] ? asset('storage/'.$item['image']) : asset('images/placeholder.png') }}"
                     class="w-16 h-16 object-cover rounded" alt="">
                <div>
                    <p class="font-semibold">{{ $item['name'] }}</p>
                    <p class="text-sm text-gray-500">Size: {{ $item['size'] }} • Qty: {{ $item['qty'] }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <p class="font-bold text-blue-600">${{ number_format($item['price'] * $item['qty'], 2) }}</p>
                <form action="{{ route('cart.remove', $key) }}" method="POST">
                    @method('DELETE') @csrf
                    <button class="text-red-600 hover:underline">Remove</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-gray-500">Your cart is empty.</p>
    @endforelse
</div>
@endsection