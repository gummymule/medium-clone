@props(['user', 'size' => 'w-12 h-12'])

{{-- User Avatar --}}

@if ($user->image)
    <img src="{{ $user->imageUrl() }}" alt="{{ $user->name }}" class="{{ $size }} rounded-full">   
@else
    <img src="/default-avatar.png" alt="dummy" class="{{ $size }} rounded-full">
@endif