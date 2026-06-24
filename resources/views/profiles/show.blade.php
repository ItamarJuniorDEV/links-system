<x-layout.app :title="'@' . $user->handler">
    <x-container>
        <div class="w-full max-w-md mx-auto text-center space-y-6">
            <x-img src="storage/{{ $user->photo }}" alt="Foto de {{ $user->name }}" />

            <div class="space-y-1">
                <h1 class="text-2xl font-bold tracking-tight">{{ $user->name }}</h1>
                <p class="text-sm text-base-content/50">{{ '@' . $user->handler }}</p>
            </div>

            @if ($user->description)
                <p class="text-base-content/70">{{ $user->description }}</p>
            @endif

            <div class="space-y-3">
                @forelse ($links as $link)
                    <a href="{{ $link->link }}" target="_blank" rel="noopener noreferrer"
                        class="btn btn-outline btn-primary btn-block">
                        {{ $link->name }}
                    </a>
                @empty
                    <p class="text-base-content/50 py-8">Nenhum link por aqui ainda.</p>
                @endforelse
            </div>
        </div>
    </x-container>
</x-layout.app>
