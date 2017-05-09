@php
    $routeName = Route::currentRouteName();
@endphp
<nav class="navbar navbar-default" style="margin-bottom:0!important;">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li @if ($routeName == "home.index") class="active" @endif><a href="{{ route('home.index') }}">Anasayfa</a></li>
            <li @if ($routeName == "event.index" || $routeName == "event.create" || $routeName == "event.update") class="active" @endif><a href="{{ route('event.index') }}">Etkinlikler</a></li>
            <li @if ($routeName == "category.index" || $routeName == "category.create" || $routeName == "category.update") class="active" @endif><a href="{{ route('category.index') }}">Kategoriler</a></li>
        </ul>
    </div>
</nav>
