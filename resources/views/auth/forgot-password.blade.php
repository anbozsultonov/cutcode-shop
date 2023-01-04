@extends('layouts.auth')

@section('tytle', 'Забыл парол')

@section('content')
    <main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
        <div class="container">
            <x-forms.auth-forms title="Забыл парол" action="{{route('password.forgot')}}" method="POST">
                @csrf
                <x-forms.text-input :isError="$errors->has('email')"
                                    name="email"
                                    type="email"
                                    placeholder="E-mail"
                                    value="{{old('email')}}"
                                    required="true"/>

                @error('email')
                <x-forms.error>
                    {{ $message }}
                </x-forms.error>
                @enderror

                <x-forms.primary-button>
                    Отправить
                </x-forms.primary-button>

                <x-slot:socialAuth></x-slot:socialAuth>

                <x-slot:buttons>
                    <div class="space-y-3 mt-5">
                        <div class="text-xxs md:text-xs">
                            <a href="{{route('login')}}" class="text-white hover:text-white/70 font-bold">
                                Вход в аккаунт
                            </a>
                        </div>
                    </div>
                </x-slot:buttons>
            </x-forms.auth-forms>
        </div>
    </main>
@endsection
