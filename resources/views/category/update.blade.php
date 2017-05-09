@php
    $pageName = "Kategori";
    $pageNamePlural = "Kategoriler";
    $postRoute = route('category.update.submit', ['id' => $eventCategory->id]);
    $indexRoute = route('category.index');
@endphp
@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('includes.panel_menu')
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <h4><b>{{$pageName}} Güncelle: {{ $eventCategory->id }}</b></h4>
                        </div>
                        <div class="col-md-6 col-xs-6 pull-right text-right">
                            <a href="{{ $indexRoute }}"><button type="button" class="btn btn-primary">Tüm {{$pageNamePlural}}</button></a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @elseif ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <form class="form-horizontal" method="POST" action="{{ $postRoute }}">
                                {{ csrf_field() }}
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-xs-12 control-label">Ad</label>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $eventCategory->name }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="description" class="col-md-4 col-xs-12 control-label">Açıklama</label>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control" name="description" id="description" value="{{ $eventCategory->description }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">{{$pageName}} Güncelle</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
