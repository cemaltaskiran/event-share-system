@extends('layouts.main')

@section('title'){{$title}}@endsection

@section('content')
    <div class="container_12">
        <div class="grid_12">
            <img src="assets/images/login_register_banner.jpg">
        </div>
        <div class="clear"></div>
        <div class="grid_6">
            <h3>{{$title}}</h3>
            <form action="#" method="POST" id="form" name="registerform">                
                <div>
                    <label>Adınız Soyadınız</label>
                    <input type="text" name="name_surname" required>
                </div>
                <div>
                    <label>E-Posta</label>
                    <input type="email" name="email">
                </div>
                <div>
                    <label>Şifre</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label>Cinsiyet</label>
                    <select name="gender" required>
                        <option selected="selected">Cinsiyetiniz</option>
                        <option value="Erkek">Erkek</option>
                        <option value="Kadın">Kadın</option>
                    </select>
                </div>
                <div>
                    <label>Doğum Tarihi</label>
                    <input type="date" name="bdate" required>
                </div>
                <input type="submit" name="login_submit" value="Giriş Yap" onClick="return true">
            </form>            
        </div>
    </div>
@endsection