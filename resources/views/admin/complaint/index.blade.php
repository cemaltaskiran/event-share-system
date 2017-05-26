@php
    $pageName = "Şikayet";
    $pageNamePlural = "Şikayetler";
    $rowNum = 5;
    $filters = false;
    if(app('request')->input('type') || app('request')->input('pager')){
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
                        <div class="col-md-12">
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
                            <form method="get" action="{{ route('admin.complaint.index' )}}">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="status">Okundu durumu</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="">Hepsi</option>
                                                <option value="0">Okunanlar</option>
                                                <option value="1">Okunmayanlar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="type">Şikayet Tipi</label>
                                            <select class="form-control" name="type" id="type">
                                                <option value="">Hepsi</option>
                                                @foreach ($complaintTypes as $complaintType)
                                                    <option value="{{$complaintType->id}}" @if (app('request')->input('type') == $complaintType->id) selected @endif>{{$complaintType->name}}</option>
                                                @endforeach
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
                                            <th>Şikayet Tipi</th>
                                            <th>Açıklama</th>
                                            <th>Etkinlik ID</th>
                                            <th>Kullanıcı ID</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($complaints) < 1)
                                            <tr>
                                                <td colspan="{{$rowNum}}">Hiç kayıt bulunmamaktadır.</td>
                                            </tr>
                                        @else
                                            @foreach ($complaints as $complaint)
                                                @php
                                                    $eventUrl = route('event.profile', ['id' => $complaint->event_id]);
                                                    $deleteUrl = route('admin.complaint.delete', ['id' => $complaint->id]);
                                                    $readUrl = route('admin.complaint.read', ['id' => $complaint->id]);
                                                    $unreadUrl = route('admin.complaint.unread', ['id' => $complaint->id]);
                                                @endphp
                                                <tr
                                                @if ($complaint->status == 0)
                                                    class="bg-success"
                                                @else
                                                    class="bg-warning"
                                                @endif>
                                                <td>{{ $complaint->complaintType->name }}</td>
                                                <td>{{ $complaint->description }}</td>
                                                <td><a href="{{$eventUrl}}" target="_blank">#{{ $complaint->event_id }}</a></td>
                                                <td>{{ $complaint->user_id }}</td>
                                                <td>
                                                    <a class="delete" href="{{ $deleteUrl }}" title="Sil"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                    <a class="read @if($complaint->status==0) hide @endif" href="{{ $readUrl }}" title="Okundu olarak işaretle"><i class="fa fa-star" aria-hidden="true"></i></i></a>
                                                    <a class="unread @if($complaint->status==1) hide @endif" href="{{ $unreadUrl }}" title="İşareti kaldır"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <script>
                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });
                                                $(document).on('click', 'a.delete', function(e) {
                                                    var result = confirm("Bu kaydı silmek istediğinize emin misiniz?");
                                                    if (result == true) {
                                                        e.preventDefault(); // does not go through with the link.

                                                        var $this = $(this);

                                                        $.post({
                                                            type: $this.data('method'),
                                                            url: $this.attr('href')
                                                        });
                                                        // hide row
                                                        jQuery(this).parents('tr').addClass("danger").hide("slow");
                                                        // notify user
                                                        $.notify({
                                                            // options
                                                            message: 'Kategori silindi!'
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
                                                $(document).on('click', 'a.read', function(e) {
                                                    e.preventDefault(); // does not go through with the link.

                                                    var $this = $(this);

                                                    $.post({
                                                        type: $this.data('method'),
                                                        url: $this.attr('href')
                                                    });
                                                    // hide row
                                                    jQuery(this).addClass("hide");
                                                    jQuery(this).parents("tr").removeClass("bg-warning").addClass("bg-success");
                                                    jQuery(this).siblings("a.unread").removeClass("hide");
                                                    // notify user
                                                    $.notify({
                                                        // options
                                                        message: 'İşaret değiştirildi.'
                                                    }, {
                                                        type: 'info',
                                                        delay: 3000,
                                                        animate: {
                                                            enter: 'animated fadeInDown',
                                                            exit: 'animated fadeOutUp'
                                                        },
                                                    });
                                                });
                                                $(document).on('click', 'a.unread', function(e) {
                                                    e.preventDefault(); // does not go through with the link.

                                                    var $this = $(this);

                                                    $.post({
                                                        type: $this.data('method'),
                                                        url: $this.attr('href')
                                                    });
                                                    // hide row
                                                    jQuery(this).addClass("hide");
                                                    jQuery(this).parents("tr").removeClass("bg-success").addClass("bg-warning");
                                                    jQuery(this).siblings("a.read").removeClass("hide");
                                                    // notify user
                                                    $.notify({
                                                        // options
                                                        message: 'İşaret değiştirildi.'
                                                    }, {
                                                        type: 'info',
                                                        delay: 3000,
                                                        animate: {
                                                            enter: 'animated fadeInDown',
                                                            exit: 'animated fadeOutUp'
                                                        },
                                                    });
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
                                {{ $complaints->appends(Request::except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="label bg-success color-darkgray no-bs">Şikayet okundu</span>
                            <span class="label bg-warning color-darkgray no-bs">Şikayet okunmadı</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
