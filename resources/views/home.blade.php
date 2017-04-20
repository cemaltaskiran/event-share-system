@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('includes.panel_menu')
                </div>

                <div class="panel-body">
                    <h1>Merhaba {{ Auth::user()->name_surname }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
