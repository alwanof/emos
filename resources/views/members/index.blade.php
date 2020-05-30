@extends('layouts.master')
@section('title',__('members.title'))

@section('nav')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
                <a  class="btn btn-success" href="#">
                    <i class="fas fa-plus"></i>
                </a>
            <hr>
        </div>

    </div>
</div><!-- /.container-fluid -->
@endsection
@section('content')
<!-- Default box -->
<h2>Member Index</h2>
    <members-sheet :acl="{{json_encode($acl)}}"  :lang={{ json_encode(app()->getLocale()) }} :auth="{{ json_encode(Auth::user()) }}"></members-sheet>

@endsection

@section('css')
<link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.css')}}">
@endsection

@section('js')
<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>
@endsection
