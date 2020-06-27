@extends('layouts.master')
@section('title',__('orders.new_order'))

@section('nav')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('orders.new_order') }}</h1>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection
@section('content')
    <!-- Default box -->
    <inner-orders :acl="{{json_encode($acl)}}"  :actor="{{json_encode($actor)}}" :lang={{ json_encode(app()->getLocale()) }} :auth="{{ json_encode(Auth::user()) }}" ></inner-orders>

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.css')}}">
@endsection

@section('js')
    <script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>



@endsection
