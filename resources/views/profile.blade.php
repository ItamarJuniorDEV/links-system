<x-layout.app>
    <x-container>
        <x-card title="Perfil">
            <x-form :route="route('profile')" put id="form" enctype="multipart/form-data">
                <div class="flex gap-2 items-center">
                    <x-img src="storage/{{ $user->photo }}" alt="Foto de perfil" />

                    <x-file-input name="photo" />
                </div>

                <x-input name="name" placeholder="Nome" value="{{ old('name', $user->name) }}" />
                <x-textarea name="description" value="{{ old('description', $user->description) }}" />
                <x-input name="handler" prefix="biolinks.com.br/" placeholder="Nome de usuário"
                    value="{{ old('handler', $user->handler) }}" />
            </x-form>

            <x-slot:actions>
                <x-a :href="route('dashboard')">Cancelar</x-a>
                <x-button form="form">Atualizar Perfil</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>