@extends('layouts.main')

@php
    $title = "Üye ol"
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
            <form id="form" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                
                <div>
                    <label for="name_surname">Adınız Soyadınız</label>
                    <input type="text" name="name_surname" required>
                </div>
                <div>
                    <label for="email">E-Posta</label>
                    <input type="email" name="email" required>
                </div>
                <div>
                    <label for="password">Şifre</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label for="password_confirmation">Şifre Tekrar</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <div>
                    <label for="gender">Cinsiyet</label>
                    <select name="gender" required>                        
                        <option value="Erkek">Erkek</option>
                        <option value="Kadın">Kadın</option>
                    </select>
                </div>
                <div>
                    <label for="bdate">Doğum Tarihi</label>
                    <input type="date" name="bdate" max="2010-12-31" required>
                </div>
                <input type="submit" name="login_submit" value="Giriş Yap" onClick="return true">
            </form>            
        </div>
    </div>
@endsection