@extends('layouts.menu.pwa')
@section('title',__('menu.front_title'))
@section('content')

<div id="app" >

    <theme-pwa :colors="{{json_encode($colors)}}"   :cats="{{json_encode($cats)}}" :rest="{{json_encode($restaurant)}}"  :sess="{{json_encode($session)}}" :tbl="{{json_encode($table)}}"></theme-pwa>

</div>
@stop
@section('css')

<style>
    .efade{
       background-image: linear-gradient(180deg,#000000 0%,rgba(0,0,0,0));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position:relative;
    display:inline-block;
    }

    .efade > span{
        display: none;
    }
</style>
@stop


