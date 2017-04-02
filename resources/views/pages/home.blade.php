@extends('layouts.main')

@php
    $title = "Anasayfa";
@endphp

@section('title'){{$title}}@endsection

@section('head')
    <link rel="stylesheet" href="assets/css/camera.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <script src="assets/js/jquery.easing.1.3.js"></script>
    <script src="assets/js/owl.carousel.js"></script>
    <script src="assets/js/camera.js"></script>
    <script src="assets/js/jquery.equalheights.js"></script>    
    <script>
        $(document).ready(function() {
            jQuery('#camera_wrap').camera({
                loader: false,
                pagination: false,                                        
                thumbnails: false,                    
                caption: true,
                navigation: true,
                fx: 'mosaic'
            });
            /*carousel*/
            var owl = $("#owl");
            owl.owlCarousel({
                items: 2, //10 items above 1000px browser width
                itemsDesktop: [995, 2], //5 items between 1000px and 901px
                itemsDesktopSmall: [767, 2], // betweem 900px and 601px
                itemsTablet: [700, 2], //2 items between 600 and 0
                itemsMobile: [479, 1], // itemsMobile disabled - inherit from itemsTablet option
                navigation: true,
                pagination: false
            });
        });
    </script>
    <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        th, td {
            border: none;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2}
    </style>
@endsection

@section('slider')
    @include('includes.slider')
@endsection

@section('content')
    <div class="container_12">
        <div class="grid_2">
            <div class="banner">
                <img class="banner_img" src="assets/images/ban_img1.jpg" alt="">
                <div class="label">
                    <div class="title">13. RLC Günleri</div>
                    <div class="date">28 Şubat - 2 Mart</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="grid_2">
            <div class="banner">
                <img class="banner_img" src="assets/images/ban_img2.jpg" alt="">
                <div class="label">
                    <div class="title">12. İltek Günleri</div>
                    <div class="date">28 - 31 Mart</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="grid_2">
            <div class="banner">
                <img class="banner_img" src="assets/images/ban_img3.jpg" alt="">
                <div class="label">
                    <div class="title">TOSFED Gözetmen Eğitim Semineri</div>
                    <div class="date">10 Şubat</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="grid_2">
            <div class="banner">
                <img class="banner_img" src="assets/images/ban_img1.jpg" alt="">
                <div class="label">
                    <div class="title">13. RLC Günleri</div>
                    <div class="date">28 Şubat - 2 Mart</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="grid_2">
            <div class="banner">
                <img class="banner_img" src="assets/images/ban_img2.jpg" alt="">
                <div class="label">
                    <div class="title">12. İltek Günleri</div>
                    <div class="date">28 - 31 Mart</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="grid_2">
            <div class="banner">
                <img class="banner_img" src="assets/images/ban_img3.jpg" alt="">
                <div class="label">
                    <div class="title">TOSFED Gözetmen Eğitim Semineri</div>
                    <div class="date">10 Şubat</div>
                    <a href="#">Sayfaya git</a>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="grid_12">
            <h2>{{date('d.m.Y H:i')}}</h2>
            <div class="hidden" style="overflow-x:auto;">
                <table>
                    <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    <th>Points</th>
                    </tr>
                    <tr>
                    <td>Jill</td>
                    <td>Smith</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    <td>50</td>
                    </tr>
                    <tr>
                    <td>Eve</td>
                    <td>Jackson</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    <td>94</td>
                    </tr>
                    <tr>
                    <td>Adam</td>
                    <td>Johnson</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    <td>67</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection