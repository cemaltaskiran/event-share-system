@php
    $pageName = "Kategori";
    $pageNamePlural = "Kategoriler";
    $rowNum = 2;
    $createRoute = route('category.create');
@endphp

@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('includes.panel_menu')
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
                        {!! Form::open(['route' => 'category.index', 'method' => 'GET', 'class' => '', 'role' => 'search'])  !!}
                            <div class="col-md-3 col-xs-12">
                                <div class="input-group">
                                    {!! Form::text('search', Request::get('search'), ['class' => 'form-control', 'placeholder' => $pageName.' adı girin..']) !!}
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        <div class="col-md-9 col-xs-12">
                            <div class="pull-right">
                                {{ $eventCategories->appends(Request::except('page'))->links() }}
                            </div>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($eventCategories) < 1)
                                            <tr>
                                                <td colspan="{{$rowNum}}">Hiç kayıt bulunmamaktadır.</td>
                                            </tr>
                                        @else
                                            @foreach ($eventCategories as $eventCategory)
                                                <tr>
                                                <td>{{ $eventCategory->name }}</td>
                                                <td>{{ $eventCategory->description }}</td>
                                                @php
                                                    $updateUrl = route('category.update', ['id' => $eventCategory->id]);
                                                    $deleteUrl = route('category.delete', ['id' => $eventCategory->id]);
                                                @endphp
                                                <td><a href="{{ $updateUrl }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                                                <td><a class="delete" href="{{ $deleteUrl }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
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
                                            </script>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection