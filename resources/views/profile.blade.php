<x-layout.app title="Editar perfil">
    <x-container>
        <x-card title="Editar perfil">
            <x-form :route="route('profile')" put id="form" enctype="multipart/form-data">
                <div class="flex gap-4 items-center">
                    <div class="avatar">
                        <div class="w-24 rounded-box bg-base-300 ring-1 ring-base-300 overflow-hidden">
                            <img id="photo-preview"
                                src="{{ $user->photo ? asset('storage/' . $user->photo) : '' }}"
                                alt="Foto de perfil"
                                class="{{ $user->photo ? '' : 'hidden' }} w-full h-full object-cover">
                            <div id="photo-placeholder"
                                class="{{ $user->photo ? 'hidden' : '' }} w-full h-full flex items-center justify-center text-base-content/40">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-12">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 23.25a18.683 18.683 0 01-7.812-1.95.75.75 0 01-.437-.695z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <x-file-input name="photo" id="photo-input" accept="image/*" />
                </div>

                <x-input name="name" placeholder="Nome" value="{{ old('name', $user->name) }}" />
                <x-textarea name="description" placeholder="Fale um pouco sobre você" value="{{ old('description', $user->description) }}" />
                <x-input name="handler" prefix="linkssystem.com.br/" placeholder="Nome de usuário"
                    value="{{ old('handler', $user->handler) }}" />
            </x-form>

            <x-slot:actions>
                <x-a :href="route('dashboard')">Cancelar</x-a>
                <x-button form="form">Atualizar Perfil</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>

    <script>
        document.getElementById('photo-input')?.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const preview = document.getElementById('photo-preview');
            const placeholder = document.getElementById('photo-placeholder');

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            placeholder?.classList.add('hidden');
        });
    </script>
</x-layout.app>