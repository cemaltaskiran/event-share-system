@php
    $pageName = "Şikayet Tipi";
    $pageNamePlural = "Şikayet Tipileri";
    $rowNum = 4;
    $createRoute = route('admin.complaint.type.create');
    $filters = false;
    if(app('request')->input('keyword') || app('request')->input('pager')){
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
                        <div class="col-md-6 col-xs-6 pull-right text-right">
                            <a href="{{ $createRoute }}"><button type="button" class="btn btn-primary">{{ $pageName }} Ekle</button></a>
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
                            <form method="get" action="{{ route('admin.complaint.type.index' )}}">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="keyword">Şikayet Tipi adı</label>
                                            <input type="search" class="form-control" name="keyword" id="keyword" value="{{ app('request')->input('keyword') }}" />
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
                                            <th>Açıklama</th>
                                            <th>Düzenle</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($complaintTypes) < 1)
                                            <tr>
                                                <td colspan="{{$rowNum}}">Hiç kayıt bulunmamaktadır.</td>
                                            </tr>
                                        @else
                                            @foreach ($complaintTypes as $complaintType)
                                                <tr>
                                                <td>{{ $complaintType->name }}</td>
                                                <td>{{ $complaintType->description }}</td>
                                                @php
                                                    $updateUrl = route('admin.complaint.type.update', ['id' => $complaintType->id]);
                                                    $deleteUrl = route('admin.complaint.type.delete', ['id' => $complaintType->id]);
                                                @endphp
                                                <td>
                                                    <a href="{{ $updateUrl }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                </td>
                                                <td>
                                                    <a class="delete" href="{{ $deleteUrl }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
                                                            message: 'Şikayet Tipi silindi!'
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
                                {{ $complaintTypes->appends(Request::except('page'))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
