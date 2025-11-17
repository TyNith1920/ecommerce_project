@props(['product'])

<div class="border rounded-lg shadow-sm hover:shadow-md p-4 bg-white">
    <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/placeholder.png') }}"
         alt="{{ $product->name }}"
         class="w-full h-48 object-cover rounded">
    <h3 class="mt-2 font-semibold text-lg">{{ $product->name }}</h3>
    <p class="text-sm text-gray-500">{{ $product->category }}</p>
    <p class="mt-1 text-blue-600 font-bold">
        {{ $product->price > 0 ? '$'.$product->price : 'Free' }}
    </p>
    <p class="text-xs text-gray-400">Available: {{ $product->quantity }}</p>

    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-3">
        @csrf
        <select name="size" class="w-full border rounded p-2 text-sm">
            @foreach($product->sizes ?? [] as $size)
                <option value="{{ $size }}">{{ $size }}</option>
            @endforeach
        </select>
        <button class="mt-3 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Add to Cart
        </button>
    </form>
</div>