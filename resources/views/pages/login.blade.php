@extends('layouts.main')

@php
    $title = "Giriş Yap";
@endphp

@section('title'){{$title}}@endsection

@section('content')
    <div class="container_12">
        <div class="grid_12">
            <img src="assets/images/login_register_banner.jpg">
        </div>
        <div class="clear"></div>
        <div class="grid_6 prefix_3">
            <h3>{{$title}}</h3>
            <form role="form" method="POST" id="form" action="{{ route('login') }}">
                {{ csrf_field() }}
                
                <div>
                    <label for="email">E-Posta</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div>
                    <label for="password">Şifre</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Hatırla
                    </label>
                </div>
                <input type="submit" name="login_submit" value="Giriş Yap" onClick="return true">
                <a href="{{ route('password.request') }}">
                    Şifrenizi mi unuttunuz?
                </a>          
            </form>            
        </div>        
    </div>
@endsection