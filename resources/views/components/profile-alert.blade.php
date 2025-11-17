@props(['message', 'icon' => 'fas fa-check-circle', 'color' => 'text-green-500'])

<div class="alert alert-success flex items-center">
    <i class="{{ $icon }} {{ $color }} mr-2"></i> {{ $message }}
</div>