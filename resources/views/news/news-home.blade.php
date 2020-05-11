@extends('layouts.app')
@section('title')
Actualites
@endsection
@section('content')

@if(Auth::check())
<header-component type="djigui-news" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui-news" user="null"></header-component>
@endif
<news-home></news-home>
@endsection