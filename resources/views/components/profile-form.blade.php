@props([
    'action' => '#',
    'photo' => null,
    'default' => 'images/default.png',
])

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div>
        <label for="profile_photo" class="flex items-center font-medium">
            <i class="fas fa-camera text-gray-600 mr-2"></i>
            Upload Profile Photo
        </label>
        <input type="file" name="profile_photo" accept="image/*" class="mt-2">
    </div>

    <button type="submit" class="btn btn-primary flex items-center">
        <i class="fas fa-save mr-2"></i> Save
    </button>

    <div>
        <h4 class="flex items-center mt-6 font-semibold">
            <i class="fas fa-image text-purple-500 mr-2"></i>
            Current Profile Picture:
        </h4>
        <img src="{{ $photo ? asset($photo) : asset($default) }}"
             width="120" height="120" class="rounded-full object-cover mt-2">
    </div>
</form>