@extends('layouts.main')

@section('content')
    <div class="row text-center">
        <div class="col-md-12">
            <h1 class="not-found">404</h1>
        </div>
        <div class="col-md-12">
            <h2>{{$errors}}</h2>
        </div>
        <div class="col-md-12">
            <h3><a href="#" onclick="window.history.back();">Geri</a></h3>
        </div>
    </div>
@endsection
