@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-3 col-xs-12">
            <div class="thumbnail">
                <img class="img-responsive" src="data:image/jpeg;base64,{{ base64_encode($event->files[0]->file) }}" alt="{{ $event->name }}">
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="caption-full event-details">
                <h4 class="pull-right">
                    @if ($event->attendance_price == null)
                        Ücretsiz
                    @else
                        {{ $event->attendance_price }} <i class="fa fa-try" aria-hidden="true"></i>
                    @endif
                </h4>
                <h4><b>{{ $event->name }}</b></h4>
                <p>
                    <ul class="event-attributes">
                        <li><span class="color-green"><i class="fa fa-calendar-o" aria-hidden="true"></i></span>{{$event->start_date}}</li>
                        <li><span class="color-red"><i class="fa fa-calendar" aria-hidden="true"></i></span>{{$event->finish_date}}</li>
                    </ul>
                    {{ $event->description }}
                </p>
                <p>

                </p>
            </div>
        </div>
        <div class="col-md-3 col-xs-12">
            adres bilgilieri
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="ratings">
                <p class="pull-right">3 reviews</p>
                <p>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    4.0 yıldız
                </p>
            </div>
            <div class="well">
                <div class="col-md-6 comments-head">
                    Yorumlar
                </div>
                <div class="col-md-6 text-right">
                    <a class="btn btn-success">Leave a Review</a>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        Anonymous
                        <span class="pull-right">10 days ago</span>
                        <p>This product was great in terms of quality. I would definitely buy another!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
