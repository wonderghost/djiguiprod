@extends('layouts.app')
@section('title')
Actualites-Ajouter un article
@endsection
@section('content')

@if(Auth::check())
<header-component type="djigui" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui" user="null"></header-component>
@endif
<add-article :articles="{{ $articles }}" :deleted="{{ $deleted }}" ></add-article>
@endsection 