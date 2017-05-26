@php
    if($categories->count() > 12){
        $categories = $categories->toArray();
    }
    $filters = false;
    if(app('request')->input('keyword') || app('request')->input('orderBy') || app('request')->input('city_id') || app('request')->input('start_date') || app('request')->input('finish_date') || app('request')->input('status') || app('request')->input('pager')){
        $filters = true;
    }
    $rowNum = 5;
@endphp
@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <ul class="nav navbar-nav">
                        @if (count($categories > 12))
                            @for ($i=0; $i < 12; $i++)
                                <li><a href="{{route('event.everything')}}?category={{$categories[$i]['id']}}">{{ $categories[$i]['name'] }}</a></li>
                            @endfor
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Diğer
                                <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @for ($i=$i; $i < count($categories); $i++)
                                        <li><a href="#">{{ $categories[$i]['name'] }}</a></li>
                                    @endfor
                                </ul>
                            </li>
                        @else
                            @foreach ($categories as $category)
                                <li><a href="#">{{ $category->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Öne Çıkan Etkinlikler</h2>
        </div>
        @if (count($priorityEvents) > 5)
            @for ($i=0; $i < 6; $i++)
                <div class="col-md-2 col-sm-4 col-xs-6">
                    <div class="thumbnail event-box">
                        @php
                            $url = route('event.profile', ['id' => $priorityEvents[$i]->id]);
                        @endphp
                        <a href="{{ $url }}"><img class="img-responsive" src="data:image/jpeg;base64,{{ base64_encode($priorityEvents[$i]->files[0]->file) }}" alt="{{ $priorityEvents[$i]->name }}"></a>
                        <h4 class="text-center"><a href="{{ $url }}">{{ str_limit($priorityEvents[$i]->name, 25) }}</a></h4>
                    </div>
                </div>
            @endfor
        @elseif(count($priorityEvents) + count($UEvents) > 5)
            @for ($i=0; $i < count($priorityEvents); $i++)
                <div class="col-md-2 col-sm-4 col-xs-6">
                    <div class="thumbnail event-box">
                        @php
                            $url = route('event.profile', ['id' => $priorityEvents[$i]->id]);
                        @endphp
                        <a href="{{ $url }}"><img class="img-responsive" src="data:image/jpeg;base64,{{ base64_encode($priorityEvents[$i]->files[0]->file) }}" alt="{{ $priorityEvents[$i]->name }}"></a>
                        <h4 class="text-center"><a href="{{ $url }}">{{ str_limit($priorityEvents[$i]->name, 25) }}</a></h4>
                    </div>
                </div>
            @endfor
            @for ($i=$i; $i < 6; $i++)
                <div class="col-md-2 col-sm-4 col-xs-6">
                    <div class="thumbnail event-box">
                        @php
                            $url = route('event.profile', ['id' => $UEvents[$i]->id]);
                        @endphp
                        <a href="{{ $url }}"><img class="img-responsive" src="data:image/jpeg;base64,{{ base64_encode($UEvents[$i]->files[0]->file) }}" alt="{{ $UEvents[$i]->name }}"></a>
                        <h4 class="text-center"><a href="{{ $url }}">{{ str_limit($UEvents[$i]->name, 25) }}</a></h4>
                    </div>
                </div>
            @endfor
        @else
            Gösterilecek aktif öncelikli etkinlik malesef yok.
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Tüm Etkinlikler</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4 data-toggle="collapse" data-target="#filters" class="filter-title"><i class="fa fa-angle-right" aria-hidden="true"></i> Filtrele</h4>
        </div>
    </div>
    @if (session('success') || $errors->any())
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
        </div>
    @endif
    <div class="row collapse @if($filters) in @endif" id="filters">
        <div class="col-md-12">
            <form method="get" action="{{ route('event.everything' )}}">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="keyword">Etkinlik adı</label>
                            <input type="search" class="form-control" name="keyword" id="keyword" value="{{ app('request')->input('keyword') }}" />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="city">Şehir</label>
                            <select class="form-control" name="city" id="city">
                                <option value="">Hepsi</option>
                                @foreach ($searchableCities as $searchableCity)
                                    <option value="{{$searchableCity['code']}}" @if (app('request')->input('city') == $searchableCity['code']) selected @endif>{{$searchableCity['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="start_date">Başlangıç tarihi</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ app('request')->input('start_date') }}"/>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="finish_date">Bitiş tarihi</label>
                            <input type="date" name="finish_date" id="finish_date" class="form-control" value="{{ app('request')->input('finish_date') }}"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="orderBy">Şuna göre sırala</label>
                            <select class="form-control" name="orderBy" id="orderBy">
                                <option value="">Seçiniz</option>
                                <option value="name" @if (app('request')->input('orderBy') == "name") selected @endif>Ad</option>
                                <option value="city_id" @if (app('request')->input('orderBy') == "city_id") selected @endif>Şehir</option>
                                <option value="place" @if (app('request')->input('orderBy') == "place") selected @endif>Adres</option>
                                <option value="start_date" @if (app('request')->input('orderBy') == "start_date") selected @endif>Başlangıç Tarihi</option>
                                <option value="finish_date" @if (app('request')->input('orderBy') == "finish_date") selected @endif>Bitiş Tarihi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="pager">Gösterilecek sonuç sayısı</label>
                            <select class="form-control" name="pager" id="pager">
                                @for ($i=1; $i < 6; $i++)
                                    <option @if (app('request')->input('pager') == $i*10) selected @endif>{{ $i*10 }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="visible-md visible-lg">&#8203;</label>
                            <div>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Ara</button>
                                <a href="{{route('event.everything')}}" class="btn btn-primary">Temizle</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 well">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Ad</th>
                            <th>Şehir</th>
                            <th>Adres</th>
                            <th>Başlangıç Tarihi</th>
                            <th>Bitiş Tarihi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($events) < 1)
                            <tr class="bg-warning">
                                <td colspan="{{$rowNum}}">Hiç kayıt bulunamadı.</td>
                            </tr>
                        @else
                            @foreach ($events as $event)
                                <tr>
                                    @php
                                        $url = route('event.profile', ['id' => $event->id]);
                                    @endphp
                                    <td><a href="{{$url}}">{{$event->name}}</a></td>
                                    <td>{{ $event->city->name }}</td>
                                    <td title="{{ $event->place }}">{{ str_limit($event->place, 10) }}</td>
                                    <td>{{ Carbon\Carbon::parse($event->start_date)->format('d-m-Y H:i') }}</td>
                                    <td>{{ Carbon\Carbon::parse($event->finish_date)->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                {{ $events->appends(Request::except('page'))->links() }}
            </div>
        </div>
    </div>
@endsection
