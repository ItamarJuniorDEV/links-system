<x-layout.app>
    <x-container>
        <x-card title="Criar novo link">
            <x-form :route="route('links.create')" post id="form">
                <x-input name="link" placeholder="URL do link" value="{{ old('link') }}" />
                <x-input name="name" placeholder="Nome do link" value="{{ old('name') }}" />
            </x-form>

            <x-slot:actions>
                <x-a :href="route('dashboard')">Cancelar</x-a>
                <x-button form="form">Criar link</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>