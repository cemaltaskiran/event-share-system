@extends('layouts.main')

@php
    $title = "Üye Paneli";
@endphp

@section('title'){{$title}}@endsection

@section('content')
    <div class="container_12">
        <div class="grid_12">
            <img src="assets/images/login_register_banner.jpg">
        </div>        
        <div class="grid_3 mt20">
            @include('includes.dashboard_menu')
        </div>        
    </div>
@endsection