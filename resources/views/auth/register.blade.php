<x-layout.app>
    <x-container>
        <x-card title="Criar conta">
            <x-form :route="route('register')" post id="register-form">
                <x-input name="name" placeholder="Nome" value="{{ old('name') }}" />
                <x-input name="email" placeholder="E-mail" value="{{ old('email') }}" />
                <x-input name="email_confirmation" placeholder="Confirmar E-mail" />
                <x-input name="password" type="password" placeholder="Senha" />
            </x-form>

            <x-slot:actions>
                <x-a :href="route('login')">Já tenho uma conta</x-a>
                <x-button form="register-form">Criar conta</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>