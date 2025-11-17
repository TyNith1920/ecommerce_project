@props(['icon', 'label', 'color' => 'text-gray-700'])

<div class="flex items-center space-x-2 py-2">
    <i class="{{ $icon }} {{ $color }} text-lg"></i>
    <span class="font-medium">{{ $label }}</span>
</div>