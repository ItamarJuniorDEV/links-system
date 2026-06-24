@props(['value' => null, 'name' => 'description'])

<div>
    <textarea name="{{ $name }}" {{ $attributes->class(['textarea w-full']) }}>{{ $value }}</textarea>
    @error($name)
        <p class="text-sm text-error mt-1">{{ $message }}</p>
    @enderror
</div>
