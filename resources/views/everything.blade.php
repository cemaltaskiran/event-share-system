@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-3">
            <p class="lead">Kategoriler</p>
            <div class="list-group pre-scrollable index-category scroll-style">
                @foreach ($categories as $category)
                    <a href="#" class="list-group-item">{{ $category->name }} <span class="badge badge-default badge-pill">{{ $category->getCountItsUsed() }}</span></a>
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
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
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
        @if (count($events) > 5)
            @for ($i=0; $i < 6; $i++)
                <div class="col-md-2 col-sm-4 col-xs-6">
                    <div class="thumbnail event-box">
                        @php
                            $url = route('event.profile', ['id' => $events[$i]->id]);
                        @endphp
                        <a href="{{ $url }}"><img class="img-responsive" src="data:image/jpeg;base64,{{ base64_encode($events[$i]->files[0]->file) }}" alt="{{ $events[$i]->name }}"></a>
                        <h4 class="text-center"><a href="{{ $url }}">{{ str_limit($events[$i]->name, 25) }}</a></h4>
                    </div>
                </div>
            @endfor
        @else
            Malesef gösterilecek etkinlik yok.
        @endif
    </div>
@endsection
