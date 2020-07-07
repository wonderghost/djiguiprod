@extends('layouts.app')

@section('title')
A Propos de nous
@endsection
@section('content')
@if(Auth::check())
<header-component type="djigui" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui" user="null"></header-component>
@endif
<about-us></about-us>
@endsection