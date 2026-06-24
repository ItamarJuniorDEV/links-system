<x-layout.app title="Editar link">
    <x-container>
        <x-card title="Editar link">
            <x-form :route="route('links.edit', $link)" put id="form">
                <x-input name="link" placeholder="URL do link" value="{{ old('link', $link->link) }}" />
                <x-input name="name" placeholder="Nome do link" value="{{ old('name', $link->name) }}" />
            </x-form>

            <x-slot:actions>
                <x-a :href="route('dashboard')">Cancelar</x-a>
                <x-button form="form">Salvar alterações</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>