<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/png" href="/img/logo-djigui.png">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
</head>
<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v7.0&appId=2005235842908607&autoLogAppEvents=1"></script>

<div id="app">
    @yield('content')
    <!-- footer -->
    <footer-component></footer-component>
    <!-- // -->
</div>

<script type="application/javascript" src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
<script type="application/javascript" src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="{{asset('js/app.js')}}?<?php echo filemtime('js/app.js') ?>"></script>
</body>
</html>