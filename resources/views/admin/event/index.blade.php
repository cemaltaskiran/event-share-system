@php
    $pageName = "Etkinlik";
    $pageNamePlural = "Etkinlikler";
    $rowNum = 8;
    $filters = false;
    if(app('request')->input('keyword') || app('request')->input('city') || app('request')->input('start_date') || app('request')->input('finish_date') || app('request')->input('status') || app('request')->input('pager')){
        $filters = true;
    }
@endphp
@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('includes.admin.panel_menu')
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <h4><b>{{$pageNamePlural}}</b></h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 data-toggle="collapse" data-target="#filters" class="filter-title"><i class="fa fa-angle-right" aria-hidden="true"></i> Filtrele</h4>
                        </div>
                    </div>
                    <div class="row collapse @if($filters) in @endif" id="filters">
                        <div class="col-md-12">
                            <form method="get" action="{{ route('admin.event.index' )}}">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="keyword">Etkinlik adı</label>
                                            <input type="search" class="form-control" name="keyword" id="keyword" value="{{ app('request')->input('keyword') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="city">Şehir</label>
                                            <select class="form-control" name="city" id="city">
                                                <option value="">Hepsi</option>
                                                @foreach ($searchableCities as $searchableCity)
                                                    <option value="{{$searchableCity['code']}}" @if (app('request')->input('city') == $searchableCity['code']) selected @endif>{{$searchableCity['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="start_date">Başlangıç tarihi</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ app('request')->input('start_date') }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="finish_date">Bitiş tarihi</label>
                                            <input type="date" name="finish_date" id="finish_date" class="form-control" value="{{ app('request')->input('finish_date') }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="status">Etkinlik durumu</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="">Hepsi</option>
                                                <option value="1" @if (app('request')->input('status') == 1) selected @endif>Başlamamış</option>
                                                <option value="2" @if (app('request')->input('status') == 2) selected @endif>Devam ediyor</option>
                                                <option value="3" class="bg-success" @if (app('request')->input('status') == 3) selected @endif>Bitmiş</option>
                                                <option value="4" class="bg-warning" @if (app('request')->input('status') == 4) selected @endif>İptal edilmiş</option>
                                                <option value="5" class="bg-danger" @if (app('request')->input('status') == 5) selected @endif>Askıya alınmış</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="pager">Gösterilecek sonuç sayısı</label>
                                            <select class="form-control" name="pager" id="pager">
                                                @for ($i=1; $i < 6; $i++)
                                                    <option @if (app('request')->input('pager') == $i*10) selected @endif>{{ $i*10 }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="visible-md visible-lg">&#8203;</label>
                                            <div>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Ara</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        @if (session('success') || $errors->any())
                            <div class="col-md-12">
                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @elseif ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                                @endif
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ad</th>
                                            <th>Şehir</th>
                                            <th>Adres</th>
                                            <th>Başlangıç Tarihi</th>
                                            <th>Bitiş Tarihi</th>
                                            <th>Son Katılım Tarihi</th>
                                            <th>Yayın Tarihi</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($events) < 1)
                                            <tr class="bg-primary">
                                                <td colspan="{{$rowNum}}">Hiç kayıt bulunamadı.</td>
                                            </tr>
                                        @else
                                            @foreach ($events as $event)
                                                <tr
                                                    @if ($event->status == 3)
                                                        class="bg-danger"
                                                    @elseif ($event->status == 4)
                                                        class="bg-warning"
                                                    @elseif ($event->finish_date <= Carbon\Carbon::now())
                                                        class="bg-success"
                                                    @endif>
                                                    <td><a href="{{route('event.profile', ['id' => $event->id])}}" target="_blank">{{ $event->name }}</a></td>
                                                    <td>{{ $event->city->name }}</td>
                                                    <td title="{{ $event->place }}">{{ str_limit($event->place, 10) }}</td>
                                                    <td>{{ Carbon\Carbon::parse($event->start_date)->format('d-m-Y H:i') }}</td>
                                                    <td>{{ Carbon\Carbon::parse($event->finish_date)->format('d-m-Y H:i') }}</td>
                                                    <td>{{ Carbon\Carbon::parse($event->last_attendance_date)->format('d-m-Y H:i') }}</td>
                                                    <td>{{ Carbon\Carbon::parse($event->publication_date)->format('d-m-Y H:i') }}</td>
                                                    @php
                                                        $updateUrl = route('admin.event.update', ['id' => $event->id]);
                                                        $freezeUrl = route('admin.event.freeze', ['id' => $event->id]);
                                                        $unfreezeUrl = route('admin.event.unfreeze', ['id' => $event->id]);
                                                        $cancelUrl = route('admin.event.cancel', ['id' => $event->id]);
                                                    @endphp
                                                    <td>
                                                        <a href="{{ $updateUrl }}" class="update"><i class="fa fa-pencil" aria-hidden="true" title="Düzenle"></i></a>
                                                        <a href="{{ $freezeUrl }}" class="freeze @if($event->status==3 || $event->status==4) hide @endif"><i class="fa fa-lock" aria-hidden="true" title="Askıya al"></i></a>
                                                        <a href="{{ $unfreezeUrl }}" class="unfreeze @if($event->status!=3) hide @endif"><i class="fa fa-unlock" aria-hidden="true" title="Askından al"></i></a>
                                                        <a href="{{ $cancelUrl }}" class="cancel @if($event->status==4) hide @endif"><i class="fa fa-times" aria-hidden="true" title="İptal Et"></i></a>
                                                        @if ($event->status==4)
                                                            <i class="fa fa-ban text-warning" aria-hidden="true" title="Bu etkinlik sizin tarafınızdan iptal edilmiştir"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <script>
                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });
                                                $(document).on('click', 'a.freeze', function(e) {
                                                    var result = confirm("Bu kaydı dondurmak istediğinize emin misiniz?");
                                                    if (result == true) {
                                                        e.preventDefault(); // does not go through with the link.

                                                        var $this = $(this);

                                                        $.post({
                                                            type: $this.data('method'),
                                                            url: $this.attr('href')
                                                        });
                                                        // hide row
                                                        jQuery(this).addClass("hide");
                                                        jQuery(this).siblings("a.unfreeze").removeClass("hide");
                                                        jQuery(this).parents("tr").addClass('bg-danger');
                                                        // notify user
                                                        $.notify({
                                                            // options
                                                            message: 'Etkinlik başarıyla donduruldu!'
                                                        }, {
                                                            type: 'info',
                                                            delay: 3000,
                                                            animate: {
                                                                enter: 'animated fadeInDown',
                                                                exit: 'animated fadeOutUp'
                                                            },
                                                        });
                                                    }
                                                    return false;
                                                });
                                                $(document).on('click', 'a.unfreeze', function(e) {
                                                    var result = confirm("Bu kaydın dondurmasını kaldırmak istediğinize emin misiniz?");
                                                    if (result == true) {
                                                        e.preventDefault(); // does not go through with the link.

                                                        var $this = $(this);

                                                        $.post({
                                                            type: $this.data('method'),
                                                            url: $this.attr('href')
                                                        });
                                                        // hide row
                                                        jQuery(this).addClass("hide");
                                                        jQuery(this).siblings("a.freeze").removeClass("hide");
                                                        jQuery(this).parents("tr").removeClass('bg-danger');
                                                        // notify user
                                                        $.notify({
                                                            // options
                                                            message: 'Etkinlik, yayın yarihinden sonra yayınlanacak şekilde ayarlandı.'
                                                        }, {
                                                            type: 'info',
                                                            delay: 3000,
                                                            animate: {
                                                                enter: 'animated fadeInDown',
                                                                exit: 'animated fadeOutUp'
                                                            },
                                                        });
                                                    }
                                                    return false;
                                                });
                                                $(document).on('click', 'a.cancel', function(e) {
                                                    var result = confirm("İptal işlemi geri alınamaz bir işlemdir devam etmek istiyor musunuz?");
                                                    if (result == true) {
                                                        e.preventDefault(); // does not go through with the link.

                                                        var $this = $(this);

                                                        $.post({
                                                            type: $this.data('method'),
                                                            url: $this.attr('href')
                                                        });
                                                        // hide row
                                                        jQuery(this).addClass("hide");
                                                        jQuery(this).siblings().addClass("hide");
                                                        jQuery(this).siblings("a.update").removeClass("hide");
                                                        jQuery(this).parents("tr").addClass('bg-warning');
                                                        jQuery(this).parents("td").html('<i class="fa fa-ban text-warning" aria-hidden="true" title="Bu etkinlik sizin tarafınızdan iptal edilmiştir"></i>');
                                                        // notify user
                                                        $.notify({
                                                            // options
                                                            message: 'Etkinlik başarıyla iptal edildi!'
                                                        }, {
                                                            type: 'info',
                                                            delay: 3000,
                                                            animate: {
                                                                enter: 'animated fadeInDown',
                                                                exit: 'animated fadeOutUp'
                                                            },
                                                        });
                                                    }
                                                    return false;
                                                });
                                            </script>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                {{ $events->appends(Request::except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="label bg-success color-darkgray no-bs">Etkinlik bitti</span>
                            <span class="label bg-warning color-darkgray no-bs">Etkinlik iptal edildi</span>
                            <span class="label bg-danger color-darkgray no-bs">Etkinlik yönetici tarafından askıya alındı</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
