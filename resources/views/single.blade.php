@php
    // check quota
    $maxJoin = false;
    if($event->quota != null){
        if($event->quota <= count($event->users()->get())){
            $maxJoin = true;
        }
    }

    // check if user is authorized
    $user = false;
    $isJoined = false;
    $ageFail = false;
    if($user = Auth::user()){
        // Initialization
        $userHasComment = false;
        $userHasComplaint = false;
        $overtime = false;

        // routes
        $joinToEventRoute = route('user.event.join.submit', ['id' => $event->id]);
        $unjoinFromEventRoute = route('user.event.unjoin.submit', ['id' => $event->id]);
        $fileDownloadRoute = route('user.event.download', ['id' => $event->id]);

        // check if user has joined earlier
        if($event->users()->where('user_id', $user->id)->first()){
            $isJoined = true;
        }

        // check if user has comment on this event
        if($user->comments()->where('event_id', $event->id)->first()){
            $userHasComment = true;
        }
        else{
            $commentRoute = route('user.comment.send', ['id' => $event->id]);
        }

        // check if user has complaint on this EventController
        if($event->complaints()->where('user_id', $user->id)->first()){
            $userHasComplaint = true;
        }
        else{
            $complaintRoute = route('user.complaint.send', ['id' => $event->id]);
        }

        // check if attendace date over
        if($event->last_attendance_date < Carbon\Carbon::now()){
            $overtime = true;
        }

        if($event->age_restriction != null){
            $now = Carbon\Carbon::now();
            $ages = explode(",", $event->age_restriction);

            if($now->subYears($ages[0]) < $user->bdate || $now->subYears($ages[1]) > $user->bdate){
                $ageFail = true;
            }
        }
    }
    // check if event has comments
    $commentNum = count($event->comments()->get());
    if($commentNum > 0){
        $comments = $event->comments()->get();
        $totalRate = 0;
        foreach ($comments as $comment) {
            // calculate total rate
            $totalRate += $comment->rate;
        }
        // calculate overall rate
        $overallRate = ceil($totalRate / $commentNum);
    }
@endphp
@extends('layouts.main')
@section('content')
    <div class="row">
        @if (session('success') || $errors->any())
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('success') }}
                    </div>
                @elseif ($errors->any())
                    <div class="alert alert-danger alert-dismissable fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
        @endif
        @if ($event->footnote || isset($ages))
            <div class="col-md-12">
                <div class="alert alert-info">
                    @if ($event->footnote)
                    <p><strong>Dipnot: </strong>{{ $event->footnote }}</p>
                    @endif
                    @if (isset($ages))
                    <p><strong>Yaş Kısıtlaması: </strong>{{ $ages[0] }} - {{ $ages[1] }}</p>
                    @endif
                </div>
            </div>
        @endif
        <div class="col-md-3 col-sm-4 col-xs-12">
            <div class="thumbnail">
                <img class="img-responsive" src="data:image/jpeg;base64,{{ base64_encode($event->files[0]->file) }}" alt="{{ $event->name }}">
            </div>
        </div>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <div class="caption-full event-details">
                <h4 class="pull-right">
                    @if ($event->attendance_price == null)
                        Ücretsiz
                    @else
                        {{ $event->attendance_price }} <i class="fa fa-try" aria-hidden="true"></i>
                    @endif
                </h4>
                <h4><b>{{ $event->name }}</b></h4>
                    <ul class="event-attributes">
                        <li><span class="color-green"><i class="fa fa-calendar-o" aria-hidden="true"></i> Başlangıç Tarihi</span>{{Carbon\Carbon::parse($event->start_date)->format('d-m-Y H:i')}}</li>
                        <li><span class="color-red"><i class="fa fa-calendar" aria-hidden="true"></i> Bitiş Tarihi</span>{{Carbon\Carbon::parse($event->finish_date)->format('d-m-Y H:i')}}</li>
                        <li><span class="color-blue"><i class="fa fa-map-marker" aria-hidden="true"></i> Adres</span>{{$event->place}} - {{$event->city->name}}</li>
                    </ul>
                @php
                    $address = strtr($event->place, array(
                        " " => "+",
                        "ü" => "u",
                        "ğ" => "g",
                        "ç" => "c",
                        "ö" => "o",
                        "ş" => "s",
                        "Ü" => "U",
                        "Ç" => "C",
                        "Ö" => "O",
                        "Ş" => "S",
                        "İ" => "I",
                    ));
                @endphp
                <div class="google-maps">
                    <iframe
            		  frameborder="0" style="border:0" width="600" height="450"
            		  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCGXWRWpIzEvYgH_KTTLD6XGIcGM5lSpRo&q={{$address}}">
            		</iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                        <h4>Açıklamalar</h4>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-right">
                        <div class="row">
                            @if ($user)
                                <div class="col-md-6 col-xs-6">
                                    @if ($maxJoin)
                                        <button type="button" class="btn btn-primary disabled" title="Maksimum katılımcıya ulaşıldı"><i class="fa fa-plus" aria-hidden="true"></i> Maksimum katılımcıya ulaşıldı</button>
                                    @elseif ($overtime)
                                        <button type="button" class="btn btn-primary disabled" title="Son katılım tarihi geçti"><i class="fa fa-plus" aria-hidden="true"></i> Son katılım tarihi geçti</button>
                                    @elseif ($ageFail)
                                        <button type="button" class="btn btn-primary disabled" title="Bu etkinlik sizin yaşınıza uygun değil"><i class="fa fa-plus" aria-hidden="true"></i> Bu etkinlik sizin yaşınıza uygun değil</button>
                                    @elseif (!$isJoined)
                                        <form action="{{ $joinToEventRoute }}" method="post">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary" title="Etkinliğe Katıl"><i class="fa fa-plus" aria-hidden="true"></i> Etkinliğe Katıl</button>
                                        </form>
                                    @else
                                        <form action="{{ $unjoinFromEventRoute }}" method="post">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger unjoin-event" title="Etkinlikten Ayrıl"><i class="fa fa-minus" aria-hidden="true"></i> Etkinlikten Ayrıl</button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary disabled" title="Katılmak için kullanıcı girişi yapmalısınız"><i class="fa fa-plus" aria-hidden="true"></i> Katılmak için kullanıcı girişi yapmalısınız</button>
                                </div>
                            @endif
                            @if ($user)
                                <div class="col-md-6 col-xs-6">
                                    @if (!$userHasComplaint)
                                        <!-- Trigger the modal with a button -->
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#complaintModal"><i class="fa fa-exclamation" aria-hidden="true"></i> Şikayet Et</button>

                                        <!-- Modal -->
                                        <div class="modal fade text-left" id="complaintModal" role="dialog">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Şikayet Et</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{$complaintRoute}}" method="post">
                                                            {{ csrf_field() }}
                                                            <div class="form-group">
                                                                <label for="type">Şikayet Tipi:</label>
                                                                <select class="form-control" name="type" id="type" required>
                                                                    <option value="">Seçiniz</option>
                                                                    @foreach ($complaintTypes as $type)
                                                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">Açıklama:</label>
                                                                <textarea name="description" rows="2" class="form-control" placeholder="Boş Bırakabilirsiniz">{{old('description')}}</textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-default">Gönder</button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <button type="button" class="btn btn-success disabled" title="Şikayet Edildi"><i class="fa fa-exclamation" aria-hidden="true"></i> Şikayet Edildi</button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    @if (count($event->files) > 1 && $user)
                        <div class="col-md-12 event-file">
                            <p>
                                <a href="{{ $fileDownloadRoute }}" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Etkinliğin dosyasını göster</a>
                            </p>
                        </div>
                    @endif
                    <div class="col-md-12 description">
                        {!!$event->description!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @if ($commentNum > 0)
                <div class="ratings">
                    <p class="pull-right">{{ $commentNum }} değerlendirme</p>
                    <p>
                        @for ($i=0; $i < $overallRate; $i++)
                            <i class="fa fa-star" aria-hidden="true"></i>
                        @endfor
                        @for ($i=$i; $i < 5; $i++)
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                        @endfor
                        {{$totalRate/$commentNum}} yıldız
                    </p>
                </div>
            @else
                <div class="ratings">
                    <p class="pull-right">{{ $commentNum }} değerlendirme</p>
                    <p>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        0 yıldız
                    </p>
                </div>
            @endif
            <div class="well">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <h4>Değerlendirmeler</h4>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                        <a href="#comment" class="btn btn-success"><i class="fa fa-star" aria-hidden="true"></i> Değerlendir</a>
                    </div>
                </div>
                <hr />
                <div class="row">
                    @if ($commentNum > 0)
                        @foreach ($comments as $comment)
                            <div class="col-md-12">
                                @for ($i=0; $i < $comment->rate; $i++)
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                @endfor
                                @for ($i=$i; $i < 5; $i++)
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                @endfor
                                {{$comment->user->name}}
                                <span class="pull-right">{{Carbon\Carbon::parse($comment->created_at)->format('d-m-Y H:i')}}</span>
                                <p>{{$comment->comment}}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            Bu etkinlik hiç değerlendirme almamış.
                        </div>
                    @endif
                </div>
            </div>
            @if ($isJoined)
                @if ($userHasComment)
                    <div class="row" id="comment">
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    Bu etkinliği daha önce değerlendirdiniz.
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="row">
                        <form action="{{ $commentRoute }}" method="post" id="comment">
                            <div class="col-md-12">
                                <div class="lead">
                                    <div id="stars" class="starrr"></div>Bu etkinliğe oy ver
                                    <input type="number" name="count" id="count" value="" class="form-control hidden">
                            	</div>
                            </div>
                            <div class="col-md-12">
                                {{ csrf_field() }}
                                <textarea name="comment" class="form-control" rows="4" placeholder="Değerlendirmeniz" required>{{ old('comment') }}</textarea>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="submit" name="button" class="btn btn-default">Gönder</button>
                            </div>
                        </form>
                    </div>
                @endif
            @else
                <div class="row" id="comment">
                        <div class="col-md-12">
                            <div class="alert alert-warning">
                                Değerlendirme yapmak için etkinliğe katılmanız gerekiyor.
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
    <script>
        $(".description").shorten({
            showChars: 750,
            moreText: 'Devamını gör..',
            lessText: 'Küçült'
        });
        $(".unjoin-event").click(function() {
            if(confirm("Etkinlikten ayırılırsanız eğer varsa değerlendirmeleriniz silinecektir. Onaylıyor musunuz?")){
                return true;
            }
            return false;
        });
        // Starrr plugin (https://github.com/dobtco/starrr)
        var __slice = [].slice;

        (function($, window) {
          var Starrr;

          Starrr = (function() {
            Starrr.prototype.defaults = {
              rating: void 0,
              numStars: 5,
              change: function(e, value) {}
            };

            function Starrr($el, options) {
              var i, _, _ref,
                _this = this;

              this.options = $.extend({}, this.defaults, options);
              this.$el = $el;
              _ref = this.defaults;
              for (i in _ref) {
                _ = _ref[i];
                if (this.$el.data(i) != null) {
                  this.options[i] = this.$el.data(i);
                }
              }
              this.createStars();
              this.syncRating();
              this.$el.on('mouseover.starrr', 'span', function(e) {
                return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
              });
              this.$el.on('mouseout.starrr', function() {
                return _this.syncRating();
              });
              this.$el.on('click.starrr', 'span', function(e) {
                return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
              });
              this.$el.on('starrr:change', this.options.change);
            }

            Starrr.prototype.createStars = function() {
              var _i, _ref, _results;

              _results = [];
              for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
                _results.push(this.$el.append("<span class='fa fa-star-o'></span>"));
              }
              return _results;
            };

            Starrr.prototype.setRating = function(rating) {
              if (this.options.rating === rating) {
                rating = void 0;
              }
              this.options.rating = rating;
              this.syncRating();
              return this.$el.trigger('starrr:change', rating);
            };

            Starrr.prototype.syncRating = function(rating) {
              var i, _i, _j, _ref;

              rating || (rating = this.options.rating);
              if (rating) {
                for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
                  this.$el.find('span').eq(i).removeClass('fa-star-o').addClass('fa-star');
                }
              }
              if (rating && rating < 5) {
                for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
                  this.$el.find('span').eq(i).removeClass('fa-star').addClass('fa-star-o');
                }
              }
              if (!rating) {
                return this.$el.find('span').removeClass('fa-star').addClass('fa-star-o');
              }
            };

            return Starrr;

          })();
          return $.fn.extend({
            starrr: function() {
              var args, option;

              option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
              return this.each(function() {
                var data;

                data = $(this).data('star-rating');
                if (!data) {
                  $(this).data('star-rating', (data = new Starrr($(this), option)));
                }
                if (typeof option === 'string') {
                  return data[option].apply(data, args);
                }
              });
            }
          });
        })(window.jQuery, window);

        $(function() {
          return $(".starrr").starrr();
        });

        $( document ).ready(function() {

          $('#stars').on('starrr:change', function(e, value){
            $('#count').val(value);
          });

          $('#stars-existing').on('starrr:change', function(e, value){
            $('#count-existing').html(value);
          });
        });
    </script>
@endsection
