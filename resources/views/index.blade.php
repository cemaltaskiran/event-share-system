@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <p class="lead">Etkinlik Kategorileri</p>
                <div class="list-group">
                    <a href="#" class="list-group-item">Category 1</a>
                    <a href="#" class="list-group-item">Category 2</a>
                    <a href="#" class="list-group-item">Category 3</a>
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
                <div class="row">
                    <div class="col-md-12">
                        <h2>Öne Çıkan Etkinlikler</h2>
                    </div>
                    @for ($i=0; $i < 6; $i++)
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="thumbnail">
                                <img src="http://placehold.it/320x150" alt="{{ $events[$i]->name }}">
                                <div class="caption">
                                    <h4 class="pull-right">
                                        @if ($events[$i]->attendance_price == null)
                                            Ücretsiz
                                        @else
                                            {{ $events[$i]->attendance_price }} TL
                                        @endif
                                        @php
                                            $url = route('event.profile', ['id' => $events[$i]->id]);
                                        @endphp
                                    </h4>
                                    <h4><a href="{{ $url }}">{{ $events[$i]->name }}</a>
                                    </h4>
                                    <p>
                                        <b>Başlangıç Tarihi:</b> {{ Carbon\Carbon::parse($events[$i]->start_date)->format('Y-m-d H:i') }}<br />
                                        <b>Bitiş Tarihi:</b> {{ Carbon\Carbon::parse($events[$i]->finish_date)->format('Y-m-d H:i') }}<br />
                                        <b>Son Katılım Tarihi:</b> {{ Carbon\Carbon::parse($events[$i]->last_attendance_date)->format('Y-m-d H:i') }}
                                    </p>
                                </div>
                                <div class="ratings">
                                    <p class="pull-right">15 değerlendirme</p>
                                    <p>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
@endsection
