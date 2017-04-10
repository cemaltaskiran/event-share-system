@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('includes.panel_menu')
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <h4><b>Etkinlikler</b></h4>
                        </div>
                        <div class="col-md-6 col-xs-6 pull-right text-right">
                            <a href="{{ route('event.create') }}"><button type="button" class="btn btn-primary">Etkinlik Ekle</button></a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
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
                        <div class="col-md-12 table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Ad</th>
                                        <th>Yer</th>
                                        <th>Maks. Katılımcı</th>
                                        <th>Başlangıç Tarihi</th>
                                        <th>Bitiş Tarihi</th>
                                        <th>Son Katılım Tarihi</th>
                                        <th>Katılım Ücreti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($events)<1)
                                        <tr>
                                            <td colspan="7">Hiç kayıt bulunmamaktadır.</td>
                                        </tr>
                                    @else
                                        @foreach ($events as $event)
                                            <tr>
                                                <td>{{ $event->name }}</td>
                                                <td>{{ $event->place }}</td>
                                                <td>{{ $event->quota }}</td>
                                                <td>{{ $event->start_date }}</td>
                                                <td>{{ $event->finish_date }}</td>
                                                <td>{{ $event->last_attendance_date }}</td>
                                                <td>{{ $event->attendance_price }}</td>
                                                @php
                                                  $updateUrl = route('event.update', ['id' => $event->id]);
                                                  $deleteUrl = route('event.delete', ['id' => $event->id]);
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
                                              if(result == true){
                                                e.preventDefault(); // does not go through with the link.

                                                var $this = $(this);

                                                $.post({
                                                    type: $this.data('method'),
                                                    url: $this.attr('href')
                                                }).done(function (k) {
                                                });
                                                // hide row
                                                jQuery(this).parents('tr').addClass("danger").hide("slow");
                                                // notify user
                                                $.notify({
                                                   // options
                                                   message: 'Etkinlik silindi!'
                                                  },{
                                                      type: 'info',
                                                      delay: 1000,
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
