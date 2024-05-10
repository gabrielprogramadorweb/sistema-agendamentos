<link rel="icon" sizes="180x180" href="{{ asset('front/assets/favicon.png') }}">
<x-guest-layout>
    <img src="{{ asset('front/image/dental+.png') }}" alt="Descrição da Imagem" width="600" class="p-5" >

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos por e-mail um link de redefinição de senha que permitirá que você escolha uma nova.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Link de redefinição de senha de e-mail') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
