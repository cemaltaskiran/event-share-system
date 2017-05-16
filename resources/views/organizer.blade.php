@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('includes.organizer.panel_menu')
                </div>

                <div class="panel-body">
                    <h1>Merhaba {{ Auth::user()->name }}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
