@extends('layouts.master')
@section('title',__('members.title'))

@section('content')
<!-- Default box -->
<h1>
    <a  class="btn btn-success" href="#">
        <i class="fas fa-plus"></i>
    </a>
    {{__('members.title')}}
</h1>
    <members-sheet :acl="{{json_encode($acl)}}"  :lang={{ json_encode(app()->getLocale()) }} :auth="{{ json_encode(Auth::user()) }}"></members-sheet>

@endsection

@section('css')
<link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.css')}}">
@endsection

@section('js')
<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>
@endsection
