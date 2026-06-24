@props(['title' => null, 'actions' => null])

<div class="card bg-base-100 w-full max-w-md mx-auto shadow-xl">
    <div class="card-body">
        @if ($title)
            <h1 class="card-title text-xl mb-4">{{ $title }}</h1>
        @endif

        {{ $slot }}

        @if ($actions)
            <div class="card-actions flex items-center justify-between mt-6">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
