@extends('layouts.app')
@section('title', 'Авторизация')

@section('content')
    <div class="signin_block">
        <div class="signin_block_wrapper">
            <div class="text_sign_block">
                <span style="color: green; border-bottom:1px solid #000">смена пароля</span>
            </div>
            <form action="{{route('password_accepted')}}" method="post">
                @csrf
                <input type="text" name="get_code_password" id="get_code_password" autocomplete="off" placeholder="введите код">
                <input type="hidden" name="code_password" value="{{ $code_password }}" style="display: none">
                <input type="hidden" name="email" value="{{ $email }}" style="display: none">
                @error('get_code_password')
                    <div class="alertError">{{$message}}</div>
                @enderror

                <div class="button_auth">
                    <button type="submit">завершить</button>
                </div>
            </form>
        </div>
    </div>

@endsection
