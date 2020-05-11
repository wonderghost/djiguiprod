@extends('layouts.app')

@section('title')
{{$item->name}}
@endsection

@section('content')

@if(Auth::check())
<header-component type="djigui-news" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui-news" user="null"></header-component>
@endif
<news-detail details="{{$item->slug}}" url="{{url()->current()}}"></news-detail>
@endsection