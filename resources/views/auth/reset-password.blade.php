<x-layout.app title="Nova senha">
    <x-container>
        <x-card title="Definir nova senha">
            <x-form :route="route('password.update')" post id="reset-form">
                <input type="hidden" name="token" value="{{ $token }}">

                <x-input name="email" placeholder="E-mail" value="{{ old('email', request('email')) }}" />
                <x-input name="password" type="password" placeholder="Nova senha" />
                <x-input name="password_confirmation" type="password" placeholder="Confirmar nova senha" />
            </x-form>

            <x-slot:actions>
                <x-a :href="route('login')">Voltar ao login</x-a>
                <x-button form="reset-form">Redefinir senha</x-button>
            </x-slot:actions>
        </x-card>
    </x-container>
</x-layout.app>
