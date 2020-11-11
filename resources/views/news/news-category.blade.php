@extends('layouts.app')

@section('title')
{{$data['category']->name}}
@endsection
@section('content')

@if(Auth::check())
<header-component type="djigui-news" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui-news" user="null"></header-component>
@endif
<category-news category-slug="{{$data['category']->slug}}" category-name="{{$data['category']->name}}"></category-news>
@endsection