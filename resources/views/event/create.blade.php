@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('includes.panel_menu')
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <h4><b>Etkinlik Ekle</b></h4>
                        </div>
                        <div class="col-md-6 col-xs-6 pull-right text-right">
                            <a href="{{ route('event.index') }}"><button type="button" class="btn btn-primary">Tüm Etkinlikler</button></a>
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
                            <form class="form-horizontal" method="POST" action="{{ route('event.post') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 col-xs-12 control-label">Etkinlik Adı</label>
                                    <div class="col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="place" class="col-sm-3 col-xs-12 control-label">Etkinlik Yeri</label>
                                    <div class="col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" name="place" id="place" value="{{ old('place') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="quota" class="col-sm-3 col-xs-12 control-label">Maksimum Katılımcı</label>
                                    <div class="col-sm-9 col-xs-12">
                                    <input type="number" class="form-control" name="quota" id="quota" value="{{ old('quota') }}" min="0" placeholder="Sınır belirtmek istemiyorsanız boş bırakın">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="start_date" class="col-sm-3 col-xs-12 control-label">Etkinlik Başlangıç Tarihi</label>
                                    <div class="col-sm-9 col-xs-12">
                                    <input type="datetime-local" class="form-control" name="start_date" id="start_date" value="{{ old('start_date') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="finish_date" class="col-sm-3 col-xs-12 control-label">Etkinlik Bitiş Tarihi</label>
                                    <div class="col-sm-9 col-xs-12">
                                    <input type="datetime-local" class="form-control" name="finish_date" id="finish_date" value="{{ old('finish_date') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="last_attendance_date" class="col-sm-3 col-xs-12 control-label">Etkinlik Son Katılım Tarihi</label>
                                    <div class="col-sm-9 col-xs-12">
                                    <input type="datetime-local" class="form-control" name="last_attendance_date" id="last_attendance_date" value="{{ old('last_attendance_date') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="attendance_price" class="col-sm-3 col-xs-12 control-label">Katılım ücreti</label>
                                    <div class="col-sm-9 col-xs-12">
                                    <input type="number" class="form-control" name="attendance_price" id="attendance_price" value="{{ old('attendance_price') }}" min="0" placeholder="Ücretsiz ise boş bırakın">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-9 col-xs-12">
                                    <button type="submit" class="btn btn-default">Kaydet</button>
                                    </div>
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
