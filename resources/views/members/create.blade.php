@extends('layouts.master')
@section('title',__('member.title'))

@section('nav')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('member.title') }}</h1>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection
@section('content')
    <!-- Default box -->
    <h2>Member Create</h2>

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.css')}}">
@endsection

@section('js')
    <script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>
@endsection

