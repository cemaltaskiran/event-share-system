@extends('layouts.main')

@section('title')
    {{$title}}
@endsection

@section('slider')
    @include('includes.slider')
@endsection

@section('content')
    <div class="container_12">
        <div class="grid_4">
            <div class="banner">
                <img class="banner_img" src="images/ban_img1.jpg" alt="">
                <div class="label">
                    <div class="title">13. RLC Günleri</div>
                    <div class="date">28 Şubat - 2 Mart</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="grid_4">
            <div class="banner">
                <img class="banner_img" src="images/ban_img2.jpg" alt="">
                <div class="label">
                    <div class="title">12. İltek Günleri</div>
                    <div class="date">28 Mart - 31 Mart</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="grid_4">
            <div class="banner">
                <img class="banner_img" src="images/ban_img3.jpg" alt="">
                <div class="label">
                    <div class="title">TOSFED Gözetmen Eğitim Semineri</div>
                    <div class="date">10 Şubat</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="grid_4">
            <div class="banner">
                <img class="banner_img" src="images/ban_img1.jpg" alt="">
                <div class="label">
                    <div class="title">13. RLC Günleri</div>
                    <div class="date">28 Şubat - 2 Mart</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="grid_4">
            <div class="banner">
                <img class="banner_img" src="images/ban_img2.jpg" alt="">
                <div class="label">
                    <div class="title">12. İltek Günleri</div>
                    <div class="date">28 Mart - 31 Mart</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="grid_4">
            <div class="banner">
                <img class="banner_img" src="images/ban_img3.jpg" alt="">
                <div class="label">
                    <div class="title">TOSFED Gözetmen Eğitim Semineri</div>
                    <div class="date">10 Şubat</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
    </div>
@endsection