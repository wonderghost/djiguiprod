@extends('layouts.app')

@section('title')
{{$item->name}}
@endsection

@section('metacontent')
<meta property="og:url"                content="{{url()->current()}}" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="{{$item->name}}" />
<meta property="og:description"        content="{{$item->name}}" />
<meta property="og:image"              content="{{asset('/news-image/'.$item->image)}}" />
@endsection

@section('content')

@if(Auth::check())
<header-component type="djigui-news" user="{{Auth::user()->name}}"></header-component>
@else 
<header-component type="djigui-news" user="null"></header-component>
@endif
<news-detail details="{{$item->slug}}" url="{{url()->current()}}"></news-detail>
@endsection