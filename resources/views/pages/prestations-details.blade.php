@extends('layouts.app')

@section('title')
Prestations
@endsection
@section('content')
@if(Auth::check())
<header-component type="djigui" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui" user="null"></header-component>
@endif
<prestation-page type="{{$slug}}"></prestation-page>
@endsection