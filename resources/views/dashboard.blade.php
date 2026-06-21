<x-layout.app>
    <x-container>
        <div class="absolute top-10 left-10 flex flex-col gap-4">
            <x-button color="ghost" :href="route('profile')">Editar perfil</x-button>
            <x-button color="ghost" :href="route('links.create')">Criar novo link</x-button>
            <x-button color="ghost" :href="route('logout')">Sair</x-button>
        </div>

        <div class="text-center space-y-4 w-2/3">
            <x-img src="storage/{{ $user->photo }}" alt="Foto do perfil" />

            <div class="font-bold text-2xl tracking-wide">{{ $user->name }}</div>

            <div class="font-sm opacity-80 mb-6">{{ $user->description }}</div>

            <ul class="space-y-2">
                @foreach ($links as $link)
                    <li class="flex items-center justify-center gap-2">
                        @unless ($loop->last)
                            <x-form :route="route('links.down', $link)" patch>
                                <x-button color="ghost">
                                    <x-icons.arrow-down class="w-6 h-6" />
                                </x-button>
                            </x-form>
                        @else
                            <x-button disabled color="ghost">
                                <x-icons.arrow-down class="w-6 h-6" />
                            </x-button>
                        @endunless

                        @unless ($loop->first)
                            <x-form :route="route('links.up', $link)" patch>
                                <x-button color="ghost">
                                    <x-icons.arrow-up class="w-6 h-6" />
                                </x-button>
                            </x-form>
                        @else
                            <x-button disabled color="ghost">
                                <x-icons.arrow-up class="w-6 h-6" />
                            </x-button>
                        @endunless

                        <x-button :href="route('links.edit', $link)" block outline color="info">
                            {{ $link->name }}
                        </x-button>

                        <x-form :route="route('links.destroy', $link)" delete onsubmit="return confirm('Deseja realmente excluir este link?')">

                            <x-button color="ghost">
                                <x-icons.trash class="w-6 h-6" />
                            </x-button>
                        </x-form>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-container>
</x-layout.app>