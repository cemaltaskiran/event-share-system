@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <p class="lead">Kategoriler</p>
            <div class="list-group pre-scrollable index-category scroll-style">
                @foreach ($categories as $category)
                    <a href="{{route('event.everything')}}?category={{$category->id}}" class="list-group-item">{{ $category->name }} <span class="badge badge-default badge-pill">{{ $category->getCountItsUsed(Carbon\Carbon::now()) }}</span></a>
                @endforeach
            </div>
        </div>
        <div class="col-md-9">
            <div class="row carousel-holder">
                <div class="col-md-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="slide-image" src="{{asset('public/images/slide1.jpg')}}" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="{{asset('public/images/slide2.jpg')}}" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="{{asset('public/images/slide3.jpg')}}" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="{{asset('public/images/slide4.jpg')}}" alt="">
                            </div>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Öne Çıkan Etkinlikler</h2>
        </div>
        @if(count($priorityEvents) + count($UEvents) + count($OEvents) > 5)
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
            @for ($i=$i; $i < count($UEvents) && $i < 6; $i++)
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
            @for ($i=$i; $i < count($OEvents) && $i < 6; $i++)
                <div class="col-md-2 col-sm-4 col-xs-6">
                    <div class="thumbnail event-box">
                        @php
                            $url = route('event.profile', ['id' => $OEvents[$i]->id]);
                        @endphp
                        <a href="{{ $url }}"><img class="img-responsive" src="data:image/jpeg;base64,{{ base64_encode($OEvents[$i]->files[0]->file) }}" alt="{{ $OEvents[$i]->name }}"></a>
                        <h4 class="text-center"><a href="{{ $url }}">{{ str_limit($OEvents[$i]->name, 25) }}</a></h4>
                    </div>
                </div>
            @endfor
        @else
            Malesef yeterli sayıda gösterilecek etkinlik sistemimizde bulunmamaktadır.
        @endif
    </div>
@endsection
