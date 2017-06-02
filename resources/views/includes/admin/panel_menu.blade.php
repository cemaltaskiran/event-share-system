@php
    $prefix = "admin";
    $routeName = Route::currentRouteName();
@endphp
<nav class="navbar navbar-default" style="margin-bottom:0!important;">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li @if ($routeName == $prefix.".index") class="active" @endif><a href="{{ route($prefix.'.index') }}">Anasayfa</a></li>
            <li class="dropdown @if ($routeName == $prefix.".event.index" || $routeName == $prefix.".event.update") active @endif">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Etkinlik<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route($prefix.'.event.index') }}">Tüm Etkinlikler</a></li>
                </ul>
            </li>
            <li class="dropdown @if ($routeName == $prefix.".category.index" || $routeName == $prefix.".category.create" || $routeName == $prefix.".category.update") active @endif">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Kategori<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route($prefix.'.category.index') }}">Tüm Kategoriler</a></li>
                    <li><a href="{{ route($prefix.'.category.create') }}">Kategori Oluştur</a></li>
                </ul>
            </li>
            <li class="dropdown @if ($routeName == $prefix.".complaint.index" || $routeName == $prefix.".complaint.type.index" || $routeName == $prefix.".complaint.type.create" || $routeName == $prefix.".complaint.type.update") active @endif">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Şikayet<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route($prefix.'.complaint.index') }}">Tüm Şikayetler</a></li>
                    <li><a href="{{ route($prefix.'.complaint.type.index') }}">Tüm Şikayet Tipileri</a></li>
                    <li><a href="{{ route($prefix.'.complaint.type.create') }}">Şikayet Tipi Oluştur</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
