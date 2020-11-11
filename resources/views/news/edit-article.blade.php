@extends('layouts.app')
@section('title')
Actualites-Editer un article
@endsection
@section('content')

{{-- @if(Auth::check())
<header-component type="djigui" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui" user="null"></header-component>
@endif --}}
{{ $articles }}
<edit-article :articles="{{ $articles }}" ></edit-article>
@endsection