@extends('layouts.app')
@section('title')
Actualites-Ajouter un article
@endsection
@section('content')

@if(Auth::check())
<header-component type="djigui-news" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui-news" user="null"></header-component>
@endif
<add-article></add-article>
@endsection