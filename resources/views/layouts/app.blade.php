<!DOCTYPE html>
<html lang="fr">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-130660555-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());

  gtag('config', 'UA-130660555-2');
  
</script>
 

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/png" href="/img/logo-djigui.png">
     @if($cat == 'news')
        <!-- Compiled and minified CSS -->
    {{-- <link rel="stylesheet" href="/css/materialize.css"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        {{-- <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet"> --}}
    @else
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    @endif
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    @yield('metacontent')
</head>
<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v7.0&appId=2005235842908607&autoLogAppEvents=1"></script>

<div id="app">
    
    @yield('content')
    @if($cat == 'news')
    <!-- FOOTER COMPONENT -->
    <footer-news la-date="{{Date('Y')}}"></footer-news>
    <!-- // -->
    @else
    <!-- footer -->
    <footer-component></footer-component>
    <!-- // -->
    @endif
</div>

<script type="application/javascript" src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
<script type="application/javascript" src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="application/javascript" src="{{asset('js/materialize.min.js')}}"></script>
<script type="application/javascript" src="{{asset('js/materialize.js')}}"></script>

<script src="{{asset('js/app.js')}}?<?php echo filemtime('js/app.js') ?>"></script>
<script type="text/javascript">
      $('.carousel.carousel-slider').carousel({
        fullWidth: true
      });
      $(".button-collapse").sideNav();
       $('.sidenav').sidenav();
      $(".dropdown-button").dropdown();
        
</script>
</body>
</html>