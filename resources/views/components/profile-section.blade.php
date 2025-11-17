@props(['title', 'icon', 'color' => 'text-gray-700'])

<h2 class="text-2xl font-semibold flex items-center mb-4">
    <i class="{{ $icon }} {{ $color }} mr-2"></i> {{ $title }}
</h2>