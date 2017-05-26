@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('includes.user.panel_menu')
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h1>Merhaba {{ $user->name }}</h1>
                        </div>
                        @if (session('success') || $errors->any())
                            <div class="col-md-12">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissable fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('success') }}
                                    </div>
                                @elseif ($errors->any())
                                    <div class="alert alert-danger alert-dismissable fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first() }}
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="col-md-12">
                            <form action="{{route('user.update')}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="name">Ad soyad</label>
                                    <input type="text" class="form-control" name="name" id="name" value="@if(old('name')) {{old('name')}} @else {{$user->name}} @endif" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email adresiniz</label>
                                    <input type="email" class="form-control" name="email" id="email" value="@if(old('name')) {{old('email')}} @else {{$user->email}} @endif" required>
                                </div>
                                <button type="submit" class="btn btn-default">Bilgilerimi Güncelle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
