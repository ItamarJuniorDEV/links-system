<x-layout.app title="Meu painel">
    <x-container>
        <div class="w-full max-w-xl mx-auto space-y-8">
            {{-- Perfil --}}
            <section class="text-center space-y-3">
                <x-img src="storage/{{ $user->photo }}" alt="Foto do perfil" />

                <h1 class="text-2xl font-bold tracking-tight">{{ $user->name }}</h1>

                @if ($user->description)
                    <p class="text-base-content/70 max-w-md mx-auto">{{ $user->description }}</p>
                @endif

                @if ($user->handler)
                    <a href="{{ route('profiles.show', $user->handler) }}" target="_blank" rel="noopener"
                        class="inline-block text-sm font-medium text-primary hover:underline">
                        linkssystem.com.br/{{ $user->handler }}
                    </a>
                @endif
            </section>

            {{-- Cabeçalho da lista --}}
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-base-content/60">Meus links</h2>
                <x-button color="primary" size="sm" :href="route('links.create')">+ Novo link</x-button>
            </div>

            {{-- Lista de links --}}
            <ul class="space-y-3">
                @forelse ($links as $link)
                    <li class="flex items-center gap-2 bg-base-100 rounded-box p-2 shadow-sm">
                        {{-- Reordenar --}}
                        <div class="flex flex-col shrink-0">
                            @unless ($loop->first)
                                <x-form :route="route('links.up', $link)" patch>
                                    <x-button color="ghost" size="xs" class="btn-square" aria-label="Mover para cima">
                                        <x-icons.arrow-up class="w-4 h-4" />
                                    </x-button>
                                </x-form>
                            @else
                                <x-button disabled color="ghost" size="xs" class="btn-square" aria-label="Mover para cima">
                                    <x-icons.arrow-up class="w-4 h-4" />
                                </x-button>
                            @endunless

                            @unless ($loop->last)
                                <x-form :route="route('links.down', $link)" patch>
                                    <x-button color="ghost" size="xs" class="btn-square" aria-label="Mover para baixo">
                                        <x-icons.arrow-down class="w-4 h-4" />
                                    </x-button>
                                </x-form>
                            @else
                                <x-button disabled color="ghost" size="xs" class="btn-square" aria-label="Mover para baixo">
                                    <x-icons.arrow-down class="w-4 h-4" />
                                </x-button>
                            @endunless
                        </div>

                        {{-- Nome do link (clique para editar) --}}
                        <x-button :href="route('links.edit', $link)" block outline color="info" class="flex-1">
                            {{ $link->name }}
                        </x-button>

                        {{-- Excluir --}}
                        <x-form :route="route('links.destroy', $link)" delete
                            onsubmit="return confirm('Deseja realmente excluir este link?')">
                            <x-button color="ghost" size="sm" class="btn-square text-error" aria-label="Excluir link">
                                <x-icons.trash class="w-5 h-5" />
                            </x-button>
                        </x-form>
                    </li>
                @empty
                    <li class="text-center py-12 px-4 bg-base-100 rounded-box border border-dashed border-base-300">
                        <p class="text-base-content/60">Você ainda não tem links.</p>
                        <x-button color="primary" size="sm" :href="route('links.create')" class="mt-4">
                            Criar meu primeiro link
                        </x-button>
                    </li>
                @endforelse
            </ul>
        </div>
    </x-container>
</x-layout.app>
