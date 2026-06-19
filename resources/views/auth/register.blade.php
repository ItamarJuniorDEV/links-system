<x-layout.app>
    <x-container>
        <x-card title="Cadastro">
            <x-form :route="route('register')" post id="register-form">
                <x-input name="name" placeholder="Nome" value="{{ old('name') }}" />
                <x-input name="email" placeholder="E-mail" value="{{ old('email') }}" />
                <x-input name="email_confirmation" placeholder="Confirmar E-mail" />
                <x-input name="password" type="password" placeholder="Senha" />
            </x-form>

            <x-slot:actions>
                <x-a :href="route('login')">Já tem uma conta?</x-a>
                <x-button form="register-form">Cadastrar</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>