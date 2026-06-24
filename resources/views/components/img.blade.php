@props(['src' => null, 'alt' => ''])

@php
    // O src chega como "storage/<arquivo>"; sem foto, fica apenas "storage/".
    $hasImage = $src && ! str($src)->endsWith('/');
@endphp

<div class="avatar {{ $hasImage ? '' : 'avatar-placeholder' }}">
    @if ($hasImage)
        <div class="w-24 rounded-box bg-base-300 ring-1 ring-base-300">
            <img loading="lazy" src="{{ $src }}" alt="{{ $alt }}">
        </div>
    @else
        <div class="w-24 rounded-box bg-base-300 ring-1 ring-base-300 text-base-content/40 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12">
                <path fill-rule="evenodd"
                    d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 23.25a18.683 18.683 0 01-7.812-1.95.75.75 0 01-.437-.695z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    @endif
</div>
