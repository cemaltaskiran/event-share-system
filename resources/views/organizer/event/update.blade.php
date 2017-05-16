@php
    $arrays = $event->categories->toArray();
    $cats = array();
    foreach ($arrays as $array) {
        array_push($cats, $array["id"]);
    }
    unset($arrays);
    $pageName = "Etkinlik";
    $pageNamePlural = "Etkinlikler";
    $postRoute = route('organizer.event.update.submit', ['id' => $event->id]);
    $indexRoute = route('organizer.event.index');
@endphp
@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('includes.organizer.panel_menu')
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <h4><b>{{$pageName}} Güncelle: {{ $event->id }}</b></h4>
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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="name" class="col-md-4 col-xs-12 control-label">Ad*</label>
                                                <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" name="name" id="name" value="{{ (count(old('name')) ? old('name') : $event->name) }}" required>
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
                                                            <option value="{{$city->code}}" @if ($event->city_id == $city->code) selected @endif>{{$city->name}}</option>
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
                                                <input type="text" class="form-control" name="place" id="place" value="{{ (count(old('place')) ? old('place') : $event->place) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="quota" class="col-md-4 col-xs-12 control-label">Maksimum Katılımcı</label>
                                                <div class="col-md-8 col-xs-12">
                                                <input type="number" class="form-control" name="quota" id="quota" value="{{ (count(old('quota')) ? old('quota') : $event->quota) }}" min="0" placeholder="Sınır belirtmek istemiyorsanız boş bırakın.">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="start_date" class="col-md-4 col-xs-12 control-label">Başlangıç Tarihi*</label>
                                                <div class="col-md-8 col-xs-12">
                                                <input type="datetime-local" class="form-control" name="start_date" id="start_date" value="{{ (count(old('start_date')) ? old('start_date') : Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i:s'))  }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="finish_date" class="col-md-4 col-xs-12 control-label">Bitiş Tarihi*</label>
                                                <div class="col-md-8 col-xs-12">
                                                <input type="datetime-local" class="form-control" name="finish_date" id="finish_date" value="{{ (count(old('finish_date')) ? old('finish_date') : Carbon\Carbon::parse($event->finish_date)->format('Y-m-d\TH:i:s')) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="last_attendance_date" class="col-md-4 col-xs-12 control-label">Son Katılım Tarihi*</label>
                                                <div class="col-md-8 col-xs-12">
                                                <input type="datetime-local" class="form-control" name="last_attendance_date" id="last_attendance_date" value="{{ (count(old('last_attendance_date')) ? old('last_attendance_date') : Carbon\Carbon::parse($event->last_attendance_date)->format('Y-m-d\TH:i:s')) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="publication_date" class="col-md-4 col-xs-12 control-label">Yayına Başlama Tarihi*</label>
                                                <div class="col-md-8 col-xs-12">
                                                <input type="datetime-local" class="form-control" name="publication_date" id="publication_date" value="{{ (count(old('publication_date')) ? old('publication_date') : Carbon\Carbon::parse($event->publication_date)->format('Y-m-d\TH:i:s')) }}" required>
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
                                                        @if(old('categories'))
                                                            @foreach ($categories as $category)
                                                                <option value="{{$category->id}}" @if (in_array($category->id, old('categories'))) selected @endif>{{$category->name}}</option>
                                                            @endforeach
                                                        @else
                                                            @foreach ($categories as $category)
                                                                <option value="{{$category->id}}" @if (in_array($category->id, $cats)) selected @endif>{{$category->name}}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $min_age = null;
                                            $max_age = null;
                                            if($event->age_restriction){
                                                $array = explode(",", $event->age_restriction);
                                                $min_age = $array[0];
                                                $max_age = $array[1];
                                            }
                                        @endphp
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="min_age" class="col-md-4 col-xs-12 control-label">Yaş Kısıtlaması</label>
                                                <div class="col-md-4 col-xs-6">
                                                    <input type="number" class="form-control" name="min_age" id="min_age" placeholder="Min. Yaş" value="{{ (count(old('min_age')) ? old('min_age') : $min_age) }}">
                                                </div>
                                                <div class="col-md-4 col-xs-6">
                                                    <input type="number" class="form-control" name="max_age" id="max_age" placeholder="Maks. Yaş" value="{{ (count(old('max_age')) ? old('max_age') : $max_age) }}">
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
                                                <input type="number" class="form-control" name="attendance_price" id="attendance_price" value="{{ (count(old('attendance_price')) ? old('attendance_price') : $event->attendance_price) }}" min="0" placeholder="Ücretsiz ise boş bırakın.">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label for="footnote" class="col-md-4 col-xs-12 control-label">Dipnot</label>
                                                <div class="col-md-8 col-xs-12">
                                                    <input type="text" name="footnote" id="footnote" class="form-control" placeholder="Eklemek istemiyorsanız boş bırakın." value="{{ (count(old('footnote')) ? old('footnote') : $event->footnote) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description" class="col-md-2 col-xs-12 control-label">Açıklama*</label>
                                                <div class="col-md-10 col-xs-12">
                                                    <textarea class="form-control" name="description" id="description" rows="6" required>{{ (count(old('description')) ? old('description') : $event->description) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-12 control-label">Afiş Resmi*</label>
                                                <div class="col-md-8 col-xs-12">
                                                    <h4>Şu an ki afiş</h4>
                                                    <img class="img-responsive" style="max-width:200px" src="data:image/jpeg;base64,{{ base64_encode($event->files[0]->file) }}" alt="{{ $event->name }}">
                                                    <input type="file" name="image" id="image" class="form-control">
                                                    <span class="alert-danger">Lütfen ekleyeceğiniz resmi minimum 400x560 çözünürlüğünde ve 5/7 en-boy oranına uygun olarak seçin. Kabul edilen formatlar: PNG, JPEG, JPG (Maks: 2MB)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-12 control-label">Dosya</label>
                                                <div class="col-md-8 col-xs-12">
                                                    @if (isset($event->files[1]))
                                                        Bir tane dosyanız var. Bu dosyayı değiştirmek istiyorsanız yeni dosyanızı seçin.
                                                    @else
                                                        Daha önce dosya eklememişsiniz.
                                                    @endif
                                                    <input type="file" name="file" id="file" class="form-control">
                                                    <span class="help-block">Etkinlikle alakalı PDF formatında dosya ekleyebilirsiniz. Maks:2MB</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-default center-block">{{$pageName}} Düzenle</button>
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
