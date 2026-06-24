@props(['name', 'prefix' => null])

<div class="w-full">
    <label @class(['input flex items-center gap-2 w-full', 'input-error' => $errors->has($name)])>
        @if ($prefix)
            <span class="text-base-content/60">{{ $prefix }}</span>
        @endif

        <input class="grow" name="{{ $name }}" {{ $attributes }} />
    </label>

    @error($name)
        <p class="text-sm text-error mt-1">{{ $message }}</p>
    @enderror
</div>
