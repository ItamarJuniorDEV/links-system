<x-layout.app>
    <x-container>
        <x-card title="Editing link :: id {{ $link->id }}">
            <x-form :route="route('links.edit', $link)" put id="form">
                <x-input name="link" placeholder="Link" value="{{ old('link', $link->link) }}" />
                <x-input name="name" placeholder="Name" value="{{ old('name', $link->name) }}" />
            </x-form>

            <x-slot:actions>
                <x-a :href="route('dashboard')">Cancelar</x-a>
                <x-button form="form">Salvar alterações</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>