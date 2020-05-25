@extends('layouts.menu')
@section('title',__('menu.front_title'))
@section('content')

    <menu-feeds :rest="{{json_encode($restaurant)}}" :sess="{{json_encode($session)}}" :tbl="{{json_encode($table)}}"></menu-feeds>
    @stop
@section('cover')
    <img class="img-thumbnail" src="{{$restaurant->avatar}}" width="150">
    @stop

@section('sidenav')
    <menu-categories :rest="{{$restaurant->id}}" ></menu-categories>
    @stop
