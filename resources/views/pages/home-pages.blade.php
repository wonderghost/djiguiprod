@extends('layouts.app')

@section('title')
Admin/Gestion des Pages
@endsection
@section('content')
@if(Auth::check())
<header-component type="djigui" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui" user="null"></header-component>
@endif
<manage-page></manage-page>
@endsection