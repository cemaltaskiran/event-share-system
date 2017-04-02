<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <title>Etkinlik Takip Modülü - @yield('title')</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/jquery-migrate-1.2.1.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="assets/js/superfish.js"></script>
        <script src="assets/js/jquery.mobilemenu.js"></script>
        <!--[if (gt IE 9)|!(IE)]><!-->
            <script src="assets/js/jquery.mobile.customized.min.js"></script>
        <!--<![endif]-->        
        <!--[if lt IE 8]>
            <div style=' clear: both; text-align:center; position: relative;'>
                <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
                    <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
                </a>
            </div>
        <![endif]-->
        <!--[if lt IE 9]>
            <script src="assets/js/html5shiv.js"></script>
            <link rel="stylesheet" media="screen" href="assets/css/ie.css">
        <![endif]-->
        @yield('head')
    </head>
    <body class="page1" id="top">
        <header>            
            @include('includes.menu')
        </header>
        @yield('slider')        
        <div class="content">
            @yield('content')
        </div>
        <footer>
            <div class="container_12">
                <div class="grid_12">
                    <div class="socials">
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-google-plus"></a>
                    </div>
                    <div class="copy">
                        Your Trip (c) 2014 | <a href="#">Privacy Policy</a> | Website Template Designed by <a href="http://www.templatemonster.com/" rel="nofollow">TemplateMonster.com</a>
                    </div>
                </div>
            </div>
        </footer>        
    </body>
</html>