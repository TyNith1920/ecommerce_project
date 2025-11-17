@extends('layouts.app')

@section('content')
<div class="container space-y-6">

    <x-profile-section title="My Profile" icon="fas fa-user" color="text-blue-500" />

    @if(session('success'))
        <x-profile-alert :message="session('success')" />
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="form-group">
            <label for="profile_photo" class="flex items-center">
                <i class="fas fa-camera text-gray-600 mr-2"></i>
                Upload Profile Photo
            </label>
            <input type="file" name="profile_photo" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary flex items-center">
            <i class="fas fa-save mr-2"></i> Save
        </button>
    </form>

    <div>
        <h4 class="flex items-center mt-6">
            <i class="fas fa-image text-purple-500 mr-2"></i>
            Current Profile Picture:
        </h4>
        <img src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : asset('images/default.png') }}"
             width="120" height="120" class="rounded-full object-cover mt-2">
    </div>
</div>
@endsection