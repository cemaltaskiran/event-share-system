@php
    $prefix = "organizer";
    $routeName = Route::currentRouteName();
@endphp
<nav class="navbar navbar-default" style="margin-bottom:0!important;">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li @if ($routeName == $prefix.".index") class="active" @endif><a href="{{ route($prefix.'.index') }}">Anasayfa</a></li>
            <li class="dropdown @if ($routeName == $prefix.".event.index" || $routeName == $prefix.".event.create" || $routeName == $prefix.".event.update") active @endif">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Etkinlik<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route($prefix.'.event.index') }}">Oluşturduğun Etkinlikler</a></li>
                    <li><a href="{{ route($prefix.'.event.create') }}">Etkinlik Oluştur</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
