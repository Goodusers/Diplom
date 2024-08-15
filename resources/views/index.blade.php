@extends('layouts.app')
@section('title', 'Авторизация')

@section('content')
    <div class="logotype_image">
        <img src="{{ asset('/image/logoza.ru.png') }}" alt="logo">
    </div>
    <div class="signin_block">
        <div class="signin_block_wrapper">
            <div class="text_sign_block">
                <span style="color: green; border-bottom:1px solid #000">Авторизация</span>
            </div>
            <form action="{{route('auth_form')}}" method="post">
                @csrf
                <label for="email">Введите email</label>
                <input type="email" name="email" id="email" autocomplete="off" placeholder="user@gmail.com">

                @error('email')
                    <div class="alertError">{{$message}}</div>
                @enderror

                <label for="password">Введите пароль</label>
                <input type="password" name="password" id="password" autocomplete="off" placeholder="Ваш пароль">

                @error('password')
                    <div class="alertError">{{$message}}</div>
                @enderror

                <div class="button_auth">
                    <button type="submit">Продолжить</button>
                </div>
                <div class="addone_content">
                    <a href="{{route('register')}}">Нет аккаунта? Регистрация</a>
                    <div href="" class="reset-password">ЗАБЫЛ ПАРОЛЬ</div>
                </div>
            </form>
        </div>
    </div>

    <div class="model-password-rest">
        <form action="{{ url('resetPassword') }}" method="POST" class="form-password-rest">
            @csrf
            <input type="email" name="two_email" id="two_email" autocomplete="off" placeholder="user@gmail.com">
            @error('two-email')
                <div class="alertError">{{$message}}</div>
            @enderror
            <div class="button-variable">
                <button type="submit" id="emailReset">далее</button>
                <div id="emailClose">назад</div>
            </div>
        </form>
    </div>

@endsection
