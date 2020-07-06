@extends('layouts.app')
@section('title')
{{config('app.name')}}
@endsection
@section('content')
@if(Auth::check())
<header-component type="djigui" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui" user="null"></header-component>
@endif
<home-component></home-component>
<!-- footer -->
<footer-component></footer-component>
    <!-- // -->
@endsection
