<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/style/style.css">
    <title>НЕДОСТУПНО</title>
</head>
<body>  
    <div class="account_blocked_user">
        <img src="{{ asset('../image/block-user.png') }}" alt="block-user">
        <h1>ВЫ ЗАБЛОКИРОВАНЫ!!!</h1>
        <p>Ваш аккаунт был заблокирован администратором </p> <p>за нарушение правил пользования интернет-ресурсом Pulse</p>
        <a href="{{ route('logout') }}"> Выйти </a>
    </div>
</body>
</html>