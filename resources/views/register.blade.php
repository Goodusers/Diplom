@extends('layouts.app')
@section('title', 'Регистрация')

@section('content')
<div class="logotype_image">
    <img src="{{ asset('/image/logoza.ru.png') }}" alt="logo">
</div>
    <div class="signin_block">
        <div class="signin_block_wrapper">
            <div class="text_sign_block">
                <span style="color: green; border-bottom:1px solid #000">Регистрация</span>
            </div>

            <form action="{{route('register_form')}}" method="post">
                @csrf
                <label for="username">Введите имя</label>
                <input type="text" name="username" id="username" autocomplete="off" placeholder="Пользователь">

                @error('username')
                    <div class="alertError">{{$message}}</div>
                @enderror

                <label for="email">Введите email</label>
                <input type="email" name="email" id="email" autocomplete="off" placeholder="user@gmail.com">

                @error('email')
                    <div class="alertError">{{$message}}</div>
                @enderror

                <label for="phone">Введите номер телефона</label>
                <input type="tel" name="phone" id="phone" autocomplete="off" placeholder="Ваш номер">

                @error('phone')
                    <div class="alertError">{{$message}}</div>
                @enderror

                <label for="city">Введите свой город</label>
                <input type="text" name="city" id="city" autocomplete="off" placeholder="Ваш город">

                @error('city')
                    <div class="alertError">{{$message}}</div>
                @enderror

                <label for="password">Введите пароль</label>
                <input type="password" name="password" id="password" autocomplete="off" placeholder="Ваш пароль">

                @error('password')
                    <div class="alertError">{{$message}}</div>
                @enderror

                <label for="password-repeat">Повторите пароль</label>
                <input type="password" name="password-repeat" id="password-repeat" autocomplete="off" placeholder="Повторите пароль">

                @error('password-repeat')
                    <div class="alertError">{{$message}}</div>
                @enderror

                <div class="button_auth">
                    <button type="submit">Продолжить</button>
                </div>
                <div class="addone_content">
                    <a href="{{route('index')}}">Войти</a>
                </div>
            </form>
        </div>
    </div>


@endsection
