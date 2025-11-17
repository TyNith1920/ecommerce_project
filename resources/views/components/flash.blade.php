@if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-2 rounded">
        {{ session('success') }}
    </div>
@endif