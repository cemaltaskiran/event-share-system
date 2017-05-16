@php
    $pageName = "Kategori";
    $pageNamePlural = "Kategoriler";
    $postRoute = route('admin.category.post');
    $indexRoute = route('admin.category.index');
@endphp
@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('includes.admin.panel_menu')
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <h4><b>{{$pageName}} Oluştur</b></h4>
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
                        <form class="form-horizontal" method="POST" action="{{ $postRoute }}">
                            <div class="col-md-12">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="col-md-4 col-xs-12 control-label">Ad</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required autofocus>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="description" class="col-md-4 col-xs-12 control-label">Açıklama</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" name="description" id="description" value="{{ old('name') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-default center-block">{{$pageName}} Oluştur</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
