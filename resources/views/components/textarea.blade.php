@props(['value'])

<div>
    <textarea {{ $attributes }} class="textarea w-full">{{ $value }}</textarea>
    @error('description')
        <span>{{ $message }}</span>
    @enderror
</div>
