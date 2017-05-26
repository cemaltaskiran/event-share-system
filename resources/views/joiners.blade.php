<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <title>Etkinlik Takip Modülü</title>
        <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('public/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{$event->name}}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ad</th>
                                    <th>E-posta</th>
                                    <th>Doğum Tarihi</th>
                                    <th> </i</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($users))
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{Carbon\Carbon::parse($user->bdate)->format('d.m.Y')}}</td>
                                            <td> </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">
                                            Hiç katılımcı bulunmamaktadır.
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="4">
                                        Toplam katılımcı: {{count($users)}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>
