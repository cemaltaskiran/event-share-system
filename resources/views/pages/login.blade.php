@extends('layouts.main')

@section('title'){{$title}}@endsection

@section('content')
    <div class="container_12">
        <div class="grid_12">
            <img src="../images/login_register_banner.jpg">
        </div>
        <div class="clear"></div>
        <div class="grid_6">
            <h3>{{$title}}</h3>
            <form action="" method="GET" id="form" name="loginform">                
                <div>
                    <label>E-Posta</label>
                    <input type="email" name="email">
                </div>
                <div>
                    <label>Şifre</label>
                    <input type="password" name="password">
                </div>
                <input type="submit" name="login_submit" value="Giriş Yap" onClick="return true">
            </form>            
        </div>        
    </div>
@endsection