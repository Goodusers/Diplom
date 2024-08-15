<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pulse||@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/style/style.css">
    <link rel="shortcut icon" href="{{ asset('/image/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <script defer src="{{ mix('/js/app.js') }}"></script>
    <script src="{{asset('js/jquery-3.7.1.js')}}"></script>
    <script src="{{asset('js/maska-nomera.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>
</head>
<body>

    <div id="app">
        {{-- @yield('index') --}}
        @yield('aside')

        @yield('content')
    </div>

{{-- <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script> --}}
{{-- <div class="logotype_image">
    <img src="{{ asset('/image/logoza.ru.png') }}" alt="logo">
</div> --}}
</body>

</html>
