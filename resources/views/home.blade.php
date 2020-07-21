@extends('layouts.master')
@section('title','Dashboard')

@section('nav')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('noticenter.title')}}</h1>

            </div>

        </div>
    </div><!-- /.container-fluid -->
@endsection
@section('content')

    <!-- Default box -->
    <div class="container">
        @can('access_admin_statistic')
            <statistic :acl="{{json_encode($acl)}}" :lang={{ json_encode(app()->getLocale()) }} :auth="{{ json_encode(Auth::user()) }}"></statistic>
            @endcan
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    @can('show_info_rest_tcio')
                    <div class="col-lg-6">
                        <info-tables :tables="{{json_encode($tables)}}" :lang={{ json_encode(app()->getLocale()) }} :auth="{{ json_encode(Auth::user()) }}"></info-tables>
                    </div>
                    <div class="col-lg-6">
                        <info-cats :cats="{{json_encode($cats)}}" :lang={{ json_encode(app()->getLocale()) }} :auth="{{ json_encode(Auth::user()) }}"></info-cats>
                    </div>
                    <div class="col-lg-6">
                        <info-items :items="{{json_encode($items)}}" :lang={{ json_encode(app()->getLocale()) }} :auth="{{ json_encode(Auth::user()) }}"></info-items>
                    </div>
                    <div class="col-lg-6">
                        <orders-card  :lang={{ json_encode(app()->getLocale()) }} :auth="{{ json_encode(Auth::user()) }}"></orders-card>

                    </div>
                    @endcan
                        @can('show_info_rest_spot_light')
                    <div class="col-lg-12">
                        <orders-details :coin="{{ json_encode($coin) }}"  :lang={{ json_encode(app()->getLocale()) }} :auth="{{ json_encode(Auth::user()) }}"></orders-details >
                    </div>
                        @endcan


                </div>
            </div>
            @can('show_info_rest_relevance')
            <div class="col-lg-6">
                <relevance-sheet :items="{{json_encode($items)}}" :lang={{ json_encode(app()->getLocale()) }} :auth="{{ json_encode(Auth::user()) }}"></relevance-sheet >
            </div>
                @endcan

        </div>
    </div>

    <!-- /.card -->


@endsection





