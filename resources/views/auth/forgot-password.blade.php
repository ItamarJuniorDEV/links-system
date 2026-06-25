<x-layout.app title="Recuperar senha">
    <x-container>
        <x-card title="Recuperar senha">
            <p class="text-base-content/70">Informe seu e-mail e enviaremos um link para redefinir a senha.</p>

            <x-form :route="route('password.email')" post id="forgot-form">
                <x-input name="email" placeholder="E-mail" value="{{ old('email') }}" />
            </x-form>

            <x-slot:actions>
                <x-a :href="route('login')">Voltar ao login</x-a>
                <x-button form="forgot-form">Enviar link</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>
