@php
    $pageName = "Etkinlik";
    $pageNamePlural = "Etkinlikler";
    $postRoute = route('user.event.post');
    $indexRoute = route('user.event.index');
@endphp
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
                        <form class="form-horizontal" method="POST" name="form" action="{{ $postRoute }}" enctype="multipart/form-data">
                            <div class="col-md-12">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="col-md-4 col-xs-12 control-label">Ad*</label>
                                            <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="city" class="col-md-4 col-xs-12 control-label">Şehir*</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="single-city form-control" name="city" id="city" required>
                                                    <option></option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{$city->code}}" @if (old('city') == $city->code) selected @endif>{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="place" class="col-md-4 col-xs-12 control-label">Adres*</label>
                                            <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control" name="place" id="place" value="{{ old('place') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="quota" class="col-md-4 col-xs-12 control-label">Maksimum Katılımcı</label>
                                            <div class="col-md-8 col-xs-12">
                                            <input type="number" class="form-control" name="quota" id="quota" value="{{ old('quota') }}" min="0" placeholder="Sınır belirtmek istemiyorsanız boş bırakın.">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="start_date" class="col-md-4 col-xs-12 control-label">Başlangıç Tarihi*</label>
                                            <div class="col-md-8 col-xs-12">
                                            <input type="datetime-local" class="form-control" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="finish_date" class="col-md-4 col-xs-12 control-label">Bitiş Tarihi*</label>
                                            <div class="col-md-8 col-xs-12">
                                            <input type="datetime-local" class="form-control" name="finish_date" id="finish_date" value="{{ old('finish_date') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="last_attendance_date" class="col-md-4 col-xs-12 control-label">Son Katılım Tarihi*</label>
                                            <div class="col-md-8 col-xs-12">
                                            <input type="datetime-local" class="form-control" name="last_attendance_date" id="last_attendance_date" value="{{ old('last_attendance_date') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="publication_date" class="col-md-4 col-xs-12 control-label">Yayına Başlama Tarihi*</label>
                                            <div class="col-md-8 col-xs-12">
                                            <input type="datetime-local" class="form-control" name="publication_date" id="publication_date" value="{{ old('publication_date') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="categories" class="col-md-4 col-xs-12 control-label">Kategori*</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="multiple-cats form-control" multiple="multiple" name="categories[]" id="categories" required>
                                                    @foreach ($categories as $category)
                                                        <option value="{{$category->id}}" @if (in_array($category->id, old('categories', []))) selected @endif>{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="min_age" class="col-md-4 col-xs-12 control-label">Yaş Kısıtlaması</label>
                                            <div class="col-md-4 col-xs-6">
                                                <input type="number" class="form-control" name="min_age" id="min_age" placeholder="Min. Yaş" value="{{old('min_age')}}">
                                            </div>
                                            <div class="col-md-4 col-xs-6">
                                                <input type="number" class="form-control" name="max_age" id="max_age" placeholder="Maks. Yaş" value="{{old('max_age')}}">
                                            </div>
                                            <div class="col-md-offset-4 col-md-8 col-xs-12">
                                                <span class="help-block hidden-xs">Sınır belirtmek istemiyorsanız boş bırakın.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="attendance_price" class="col-md-4 col-xs-12 control-label">Katılım ücreti</label>
                                            <div class="col-md-8 col-xs-12">
                                            <input type="number" class="form-control" name="attendance_price" id="attendance_price" value="{{ old('attendance_price') }}" min="0" placeholder="Ücretsiz ise boş bırakın.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="footnote" class="col-md-4 col-xs-12 control-label">Dipnot</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" name="footnote" id="footnote" class="form-control" placeholder="Eklemek istemiyorsanız boş bırakın." value="{{old('footnote')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="col-md-2 col-xs-12 control-label">Açıklama*</label>
                                            <div class="col-md-10 col-xs-12">
                                                <textarea class="form-control" name="description" id="description" required>{{old('description')}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Afiş Resmi*</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="file" name="image" id="image" class="form-control" required>
                                                <span class="alert-danger">Lütfen ekleyeceğiniz resmi minimum 400x560 çözünürlüğünde ve 5/7 en-boy oranına uygun olarak seçin. Kabul edilen formatlar: PNG, JPEG, JPG, GIF (Maks: 2MB)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Dosya</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="file" name="file" id="file" class="form-control">
                                                <span class="help-block">Etkinlikle alakalı PDF formatında dosya ekleyebilirsiniz. Maks:2MB</span>
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
    <script type="text/javascript">
        $(".single-city").select2({
            placeholder: "Seçiniz",
            allowClear: true,
            theme: "bootstrap",
        });
        $(".multiple-cats").select2({
            placeholder: "Birden fazla kategori seçebilirsiniz.",
            theme: "bootstrap",
        });
        CKEDITOR.replace( 'description' );
    </script>
@endsection
