<?php

namespace App\Http\Controllers;

use
    App\Event,
    App\Category,
    App\City,
    App\Comment,
    App\ComplaintType,
    App\Priority,
    Illuminate\Http\Request,
    Validator,
    Redirect,
    Input,
    Illuminate\Support\MessageBag,
    Carbon\Carbon,
    Auth,
    Image;

class EventController extends Controller
{
    protected function getPEvents(){
        $now = Carbon::now();
        return Event::where([
            ['status', '=', 1],
            ['finish_date', '>', $now],
            ['publication_date', '<', $now],
            ['eventable_type', '=', 'Organizer'],
        ])->limit(6)->orderBy("start_date", "asc")->get();
    }

    protected function getUEvents(){
        $now = Carbon::now();
        return Event::where([
            ['status', '=', 1],
            ['finish_date', '>', $now],
            ['publication_date', '<', $now],
            ['eventable_type', '=', 'User'],
        ])->limit(6)->orderBy("start_date", "asc")->get();
    }

    protected function getOldEvents(){
        $now = Carbon::now();
        return Event::where([
            ['status', '=', 1],
            ['finish_date', '<', $now],
        ])->limit(6)->orderBy("finish_date", "desc")->get();
    }

    protected function getPrefix(){
        if(Auth::guard('organizer')->check()){
            return "organizer";
        }
        elseif(Auth::guard('admin')->check()){
            return "admin";
        }
        else{
            return "user";
        }
    }

    protected function checkIfEventOwnedByCreator($id){
        if(Auth::guard('organizer')->check()){
            $userId = Auth::guard('organizer')->user()->id;
            $event = Event::where([
                ['id', '=', $id],
                ['eventable_id', '=', $userId],
                ['eventable_type', '=', 'Organizer'],
                ])->first();
        }
        else{
            $userId = Auth::user()->id;
            $event = Event::where([
                ['id', '=', $id],
                ['eventable_id', '=', $userId],
                ['eventable_type', '=', 'User'],
                ])->first();
        }
        $prefix = $this->getPrefix();
        if(!$event){
            $errors = "Erişmek istediğiz etkinlik bulunamadı.";
            return redirect()->route($prefix.'.event.index')->withErrors($errors);
        }
        if ($event->status == 3) {
            $errors = "Erişmek istediğiz etkinlik yönetici tarafından dondurulduğu için bu etkinliğe ulaşamıyorsunuz.";
            return redirect()->route($prefix.'.event.index')->withErrors($errors);
        }
        if ($event->status == 4) {
            $errors = "Erişmek istediğiz etkinlik sizin tarafınızdan iptal edildiği için bu etkinliğe ulaşamıyorsunuz.";
            return redirect()->route($prefix.'.event.index')->withErrors($errors);
        }
        return null;
    }

    protected function getCities(){
        return City::orderBy('id', 'asc')->get();
    }

    protected function getCategories(){
        return Category::orderBy('name', 'asc')->get();
    }

    protected function getSearchableCities($userId, $model){
        $events = Event::where([
            ['eventable_id', '=', $userId],
            ['eventable_type', '=', $model]
        ])->orderBy("start_date", "desc")->get();
        $searchableCities = array();
        foreach ($events as $event) {
            if(!in_array($event->city, $searchableCities)){
                array_push($searchableCities, $event->city);
            }
        }
        return $searchableCities;
    }

    public function showIndex(){
        $priorityEvents = $this->getPEvents();
        $UEvents = $this->getUEvents();
        $OEvents = $this->getOldEvents();
        $categories = $this->getCategories();

		return view('index')->with([
            'priorityEvents'=> $priorityEvents,
            'UEvents' => $UEvents,
            'OEvents' => $OEvents,
            'categories' => $categories
        ]);
	}

    public function displayAdminEvents(Request $request){
        $page = $request->page;
        $validator = Validator::make($request->all(), [
            'keyword'       => 'nullable|max:255',
            'city'          => 'nullable|integer|min:1|max:81',
            'start_date'    => 'nullable|date',
            'finish_date'   => 'nullable|date',
            'status'        => 'nullable|integer|min:1|max:5',
            'pager'         => 'nullable|integer|min:10|max:50',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        if($request->start_date && $request->finish_date && ($request->start_date >= $request->finish_date)){
            $errors = "Başlangıç Tarihi, Bitiş Tarihinden yüksek olamaz.";
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        $events = Event::where(function($query) use ($request){
            $now = Carbon::now();
            /* Filter by search keyword */
                if(($keyword = $request->keyword)){
                    $query->where([['name', 'like', '%'.$keyword.'%']]);
                }
            /* Filter by city */
                if(($city = $request->city)){
                    $query->where([['city_id', '=', $city]]);
                }
            /* Filteer by status */
                if($status = $request->status){
                    if($status == 1){
                        $query->where([
                            ['start_date', '>', $now],
                            ['status', '<>', 3],
                            ['status', '<>', 4],
                        ]);
                    }
                    elseif($status == 2){
                        $query->where([
                            ['start_date', '<=', $now],
                            ['finish_date', '>', $now],
                            ['status', '<>', 3],
                            ['status', '<>', 4],
                        ]);
                    }
                    elseif($status == 3){
                        $query->where([
                            ['finish_date', '<=', $now],
                            ['status', '<>', 3],
                            ['status', '<>', 4],
                        ]);
                    }
                    elseif($status == 4){
                        $query->where([['status', '=', 4]]);
                    }
                    elseif($status == 5){
                        $query->where([['status', '=', 3]]);
                    }
                }
            /* Filter by dates */
                if($start = $request->start_date && $finish = $request->finish_date){
                    $start = $request->start_date;
                    $finish = $request->finish_date.' 23:45:00';
                    $query->where([
                            ['start_date', '=>', $start]
                        ])
                        ->orWhere([
                            ['finish_date', '<=', $finish]
                        ]);
                }
                elseif($start = $request->start_date && !($finish = $request->finish_date)){
                    $start = $request->start_date;
                    $query->where([
                        ['start_date', '>=', $start]
                    ]);
                }
                elseif(!($start = $request->start_date) && $finish = $request->finish_date){
                    $finish = $request->finish_date.' 23:45:00';
                    $query->where([
                        ['finish_date', '<=', $finish]
                    ]);
                }

        })->orderBy("start_date", "desc")->orderBy('status', 'asc');
        if(!$pager = $request->pager){
            $pager = 10;
        }
        $events = $events->paginate($pager);
        if($page <= ceil($events->total()/$pager)){
            $searchableCities = City::all();
            return view('admin.event.index')->with([
                'events' => $events,
                'searchableCities' => $searchableCities,
                ]);
        }
        return redirect()->route('admin.event.index');
    }

    public function displayUserEvents(Request $request){
        $userId = Auth::user()->id;
        $page = $request->page;
        $validator = Validator::make($request->all(), [
            'keyword'       => 'nullable|max:255',
            'city'          => 'nullable|integer|min:1|max:81',
            'start_date'    => 'nullable|date',
            'finish_date'   => 'nullable|date',
            'status'        => 'nullable|integer|min:1|max:5',
            'pager'         => 'nullable|integer|min:10|max:50',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        if($request->start_date && $request->finish_date && ($request->start_date >= $request->finish_date)){
            $errors = "Başlangıç Tarihi, Bitiş Tarihinden yüksek olamaz.";
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        $events = Event::where(function($query) use ($request){
            $now = Carbon::now();
            /* Filter by search keyword */
                if(($keyword = $request->keyword)){
                    $query->where([['name', 'like', '%'.$keyword.'%']]);
                }
            /* Filter by city */
                if(($city = $request->city)){
                    $query->where([['city_id', '=', $city]]);
                }
            /* Filteer by status */
                if($status = $request->status){
                    if($status == 1){
                        $query->where([
                            ['start_date', '>', $now],
                            ['status', '<>', 3],
                            ['status', '<>', 4],
                        ]);
                    }
                    elseif($status == 2){
                        $query->where([
                            ['start_date', '<=', $now],
                            ['finish_date', '>', $now],
                            ['status', '<>', 3],
                            ['status', '<>', 4],
                        ]);
                    }
                    elseif($status == 3){
                        $query->where([
                            ['finish_date', '<=', $now],
                            ['status', '<>', 3],
                            ['status', '<>', 4],
                        ]);
                    }
                    elseif($status == 4){
                        $query->where([['status', '=', 4]]);
                    }
                    elseif($status == 5){
                        $query->where([['status', '=', 3]]);
                    }
                }
            /* Filter by dates */
                if($start = $request->start_date && $finish = $request->finish_date){
                    $start = $request->start_date;
                    $finish = $request->finish_date.' 23:45:00';
                    $query->where([
                            ['start_date', '=>', $start]
                        ])
                        ->orWhere([
                            ['finish_date', '<=', $finish]
                        ]);
                }
                elseif($start = $request->start_date && !($finish = $request->finish_date)){
                    $start = $request->start_date;
                    $query->where([
                        ['start_date', '>=', $start]
                    ]);
                }
                elseif(!($start = $request->start_date) && $finish = $request->finish_date){
                    $finish = $request->finish_date.' 23:45:00';
                    $query->where([
                        ['finish_date', '<=', $finish]
                    ]);
                }

        })->where([
            ['eventable_id', '=', $userId],
            ['eventable_type', '=', 'User']
        ])->orderBy("start_date", "desc")->orderBy('status', 'asc');
        if(!$pager = $request->pager){
            $pager = 10;
        }
        $events = $events->paginate($pager);
        if($page <= ceil($events->total()/$pager)){
            $searchableCities = $this->getSearchableCities($userId, 'User');
            return view('user.event.index')->with([
                'events' => $events,
                'searchableCities' => $searchableCities,
                ]);
        }
        return redirect()->route('user.event.index');
    }

    public function displayOragnizerEvents(Request $request){
        $userId = Auth::guard('organizer')->user()->id;
        $page = $request->page;
        $validator = Validator::make($request->all(), [
            'keyword'       => 'nullable|max:255',
            'city'          => 'nullable|integer|min:1|max:81',
            'start_date'    => 'nullable|date',
            'finish_date'   => 'nullable|date',
            'status'        => 'nullable|integer|min:1|max:5',
            'pager'         => 'nullable|integer|min:10|max:50',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        if($request->start_date && $request->finish_date && ($request->start_date >= $request->finish_date)){
            $errors = "Başlangıç Tarihi, Bitiş Tarihinden yüksek olamaz.";
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        $events = Event::where(function($query) use ($request){
            $now = Carbon::now();
            /* Filter by search keyword */
                if(($keyword = $request->keyword)){
                    $query->where([['name', 'like', '%'.$keyword.'%']]);
                }
            /* Filter by city */
                if(($city = $request->city)){
                    $query->where([['city_id', '=', $city]]);
                }
            /* Filteer by status */
                if($status = $request->status){
                    if($status == 1){
                        $query->where([
                            ['start_date', '>', $now],
                            ['status', '<>', 3],
                            ['status', '<>', 4],
                        ]);
                    }
                    elseif($status == 2){
                        $query->where([
                            ['start_date', '<=', $now],
                            ['finish_date', '>', $now],
                            ['status', '<>', 3],
                            ['status', '<>', 4],
                        ]);
                    }
                    elseif($status == 3){
                        $query->where([
                            ['finish_date', '<=', $now],
                            ['status', '<>', 3],
                            ['status', '<>', 4],
                        ]);
                    }
                    elseif($status == 4){
                        $query->where([['status', '=', 4]]);
                    }
                    elseif($status == 5){
                        $query->where([['status', '=', 3]]);
                    }
                }
            /* Filter by dates */
                if($start = $request->start_date && $finish = $request->finish_date){
                    $start = $request->start_date;
                    $finish = $request->finish_date.' 23:45:00';
                    $query->where([
                            ['start_date', '=>', $start]
                        ])
                        ->orWhere([
                            ['finish_date', '<=', $finish]
                        ]);
                }
                elseif($start = $request->start_date && !($finish = $request->finish_date)){
                    $start = $request->start_date;
                    $query->where([
                        ['start_date', '>=', $start]
                    ]);
                }
                elseif(!($start = $request->start_date) && $finish = $request->finish_date){
                    $finish = $request->finish_date.' 23:45:00';
                    $query->where([
                        ['finish_date', '<=', $finish]
                    ]);
                }

        })->where([
            ['eventable_id', '=', $userId],
            ['eventable_type', '=', 'Organizer']
        ])->orderBy("start_date", "desc")->orderBy('status', 'asc');
        if(!$pager = $request->pager){
            $pager = 10;
        }
        $events = $events->paginate($pager);
        if($page <= ceil($events->total()/$pager)){
            $searchableCities = $this->getSearchableCities($userId, 'Organizer');
            return view('organizer.event.index')->with([
                'events' => $events,
                'searchableCities' => $searchableCities,
                ]);
        }
        return redirect()->route('organizer.event.index');
    }

    public function showCreateForm(){
        $categories = $this->getCategories();
        $cities = $this->getCities();
        $prefix = $this->getPrefix();

        return view($prefix.'.event.create', ['categories' => $categories, 'cities' => $cities]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name'                  => 'required|max:255',
            'city'                  => 'required|integer|min:1|max:81',
            'place'                 => 'required|max:255',
            'quota'                 => 'nullable|integer|max:4294967295|min:1',
            'start_date'            => 'required|date|after_or_equal:now',
            'finish_date'           => 'required|date|after_or_equal:start_date',
            'last_attendance_date'  => 'required|date|before_or_equal:finish_date',
            'publication_date'      => 'required|date|before_or_equal:start_date',
            'min_age'               => 'nullable|required_with:max_age|integer|min:0',
            'max_age'               => 'nullable|required_with:min_age|integer|greater_than_field:min_age',
            'attendance_price'      => 'nullable|integer|max:4294967295|min:0',
            'categories'            => 'required|array|min:1',
            'footnote'              => 'nullable|max:255',
            'description'           => 'required|min:10|max:65535',
            'image'                 => 'required|image|dimensions:min_width=400,min_height=560,ratio=5/7|mimes:jpeg,jpg,png,gif|max:2000',
            'file'                  => 'nullable|file|mimes:pdf|max:2000'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // dd($request->all());
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
      $status = 1;
      $age = null;
      $footnote = null;

      if($request->min_age != ''){
          $age = $request->min_age.','.$request->max_age;
      }

      if($request->footnote != ''){
          $footnote = $request->footnote;
      }

      $event = new Event;
      $event->name = $request->name;
      $event->city_id = $request->city;
      $event->place = $request->place;
      $event->start_date = $request->start_date;
      $event->finish_date = $request->finish_date;
      $event->last_attendance_date = $request->last_attendance_date;
      $event->publication_date = $request->publication_date;
      $event->description = $request->description;
      $event->footnote = $footnote;
      $event->status = $status;
      $event->quota = $request->quota;
      $event->age_restriction = $age;
      $event->attendance_price = $request->attendance_price;
      (Auth::guard('organizer')->check()) ? $event->eventable_id = Auth::guard('organizer')->user()->id : $event->eventable_id = Auth::user()->id;
      (Auth::guard('organizer')->check()) ? $event->eventable_type = "Organizer" : $event->eventable_type = "User";
      $event->save();

      /* Save categories */
        $event->categories()->sync($request->categories, false);

      /* Save image */
          $img = Image::make(Input::file('image'));
          if($img->width() > 400){
              $img->resize(400, 560);
          }
          $img->encode('jpg');
          $img->save('tmp_'.$event->id.'.jpg');
          $image = new \App\EventFile([
              'file' => $img,
              'file_type_id' => 1
          ]);
          $event->files()->save($image);
          $img->destroy();
          unlink('tmp_'.$event->id.'.jpg');

      /* Save file */
          if($request->file != ""){
              $filePath = (string) $request->file('file')->storeAs('pdf', 'tmp_'.$event->id.'.pdf');
              $filePath = "storage/app/".$filePath;
              $fileContent = file_get_contents($filePath);
              $file = new \App\EventFile([
                  'file' => $fileContent,
                  'file_type_id' => 2
              ]);
              $event->files()->save($file);
              unlink($filePath);
          }


      return redirect()->back()->with('success', $request->name." adlı etkinlik başarıyla kaydedildi.");

    }

    public function showCreatorUpdateForm($id){
        $event = $this->checkIfEventOwnedByCreator($id);
        if(!$event){
            $event = Event::find($id);
            $categories = $this->getCategories();
            $cities = $this->getCities();
            $prefix = $this->getPrefix();
            return view($prefix.'.event.update', ['event' => $event, 'categories' => $categories, 'cities' => $cities]);
        }
        return $event;
    }

    public function showAdminUpdateForm($id){
        $event = Event::find($id);
        if($event){
            $categories = $this->getCategories();
            $cities = $this->getCities();
            return view('admin.event.update', ['event' => $event, 'categories' => $categories, 'cities' => $cities]);
        }
        $errors = "Aradığınız etkinlik sistemde bulunmamaktadır.";
        return redirect()->route('admin.event.index')->withErrors($errors);
    }

    public function update(Request $request, $id){
        $event = $this->checkIfEventOwnedByCreator($id);
        if($event){
            return $event;
        }
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|max:255',
            'city'                  => 'required|integer|min:1|max:81',
            'place'                 => 'required|max:255',
            'quota'                 => 'nullable|integer|max:4294967295|min:1',
            'start_date'            => 'required|date|after_or_equal:now',
            'finish_date'           => 'required|date|after_or_equal:start_date',
            'last_attendance_date'  => 'required|date|before_or_equal:finish_date',
            'publication_date'      => 'required|date|before_or_equal:start_date',
            'min_age'               => 'nullable|required_with:max_age|integer|min:0',
            'max_age'               => 'nullable|required_with:min_age|integer|greater_than_field:min_age',
            'attendance_price'      => 'nullable|integer|max:4294967295|min:0',
            'categories'            => 'required|array|min:1',
            'footnote'              => 'nullable|max:255',
            'description'           => 'required|min:10|max:65535',
            'image'                 => 'nullable|image|dimensions:min_width=400,min_height=560,ratio=5/7|mimes:jpeg,jpg,png,gif|max:2000',
            'file'                  => 'nullable|file|mimes:pdf|max:2000'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }

        $status = 0;
        $age = null;
        $footnote = null;

        if($request->min_age != ''){
            $age = $request->min_age.','.$request->max_age;
        }

        if($request->footnote != ''){
            $footnote = $request->footnote;
        }

        $now = Carbon::now();
        $now = $now->getTimestamp();
        if($now > strtotime($request->publication_date)){
            $status = 1;
        }
        $event = Event::find($id);
        $event->name = $request->name;
        $event->city_id = $request->city;
        $event->place = $request->place;
        $event->start_date = $request->start_date;
        $event->finish_date = $request->finish_date;
        $event->last_attendance_date = $request->last_attendance_date;
        $event->publication_date = $request->publication_date;
        $event->description = $request->description;
        $event->footnote = $footnote;
        $event->status = $status;
        $event->quota = $request->quota;
        $event->age_restriction = $age;
        $event->attendance_price = $request->attendance_price;
        $event->save();

        /* Save categories */
            $event->categories()->sync($request->categories, false);

        /* Save image */
            if($request->image != ""){
                $img = Image::make(Input::file('image'));
                if($img->width() > 400){
                    $img->resize(400, 560);
                }
                $img->encode('jpg');
                $img->save('tmp_'.$event->id.'.jpg');
                $image = \App\EventFile::where([
                    'event_id' => $event->id,
                    'file_type_id' => 1
                ])->get();
                $image->file = $img;
                $image-save();
                $img->destroy();
                unlink('tmp_'.$event->id.'.jpg');
            }

        /* Save file */
            if($request->file != ""){
                $filePath = (string) $request->file('file')->storeAs('pdf', 'tmp_'.$event->id.'.pdf');
                $filePath = "storage/app/".$filePath;
                $fileContent = file_get_contents($filePath);
                $file = \App\EventFile::where([
                    'event_id' => $event->id,
                    'file_type_id' => 2
                ])->get();
                if(count($file)){
                    $file->file = $fileContent;
                    $file->save();
                }
                else{
                    $file = new \App\EventFile([
                        'file' => $fileContent,
                        'file_type_id' => 2
                    ]);
                    $event->files()->save($file);
                }

                unlink($filePath);
            }

        return redirect()->back()->with('success', $request->name." adlı etkinlik başarıyla güncellendi.");

    }

    public function updateByAdmin(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name'                  => 'required|max:255',
            'city'                  => 'required|integer|min:1|max:81',
            'place'                 => 'required|max:255',
            'quota'                 => 'nullable|integer|max:4294967295|min:1',
            'start_date'            => 'required|date|after_or_equal:now',
            'finish_date'           => 'required|date|after_or_equal:start_date',
            'last_attendance_date'  => 'required|date|before_or_equal:finish_date',
            'publication_date'      => 'required|date|before_or_equal:start_date',
            'min_age'               => 'nullable|required_with:max_age|integer|min:0',
            'max_age'               => 'nullable|required_with:min_age|integer|greater_than_field:min_age',
            'attendance_price'      => 'nullable|integer|max:4294967295|min:0',
            'categories'            => 'required|array|min:1',
            'footnote'              => 'nullable|max:255',
            'description'           => 'required|min:10|max:65535',
            'image'                 => 'nullable|image|dimensions:min_width=400,min_height=560,ratio=5/7|mimes:jpeg,jpg,png,gif|max:2000',
            'file'                  => 'nullable|file|mimes:pdf|max:2000'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }

        $status = 0;
        $age = null;
        $footnote = null;

        if($request->min_age != ''){
            $age = $request->min_age.','.$request->max_age;
        }

        if($request->footnote != ''){
            $footnote = $request->footnote;
        }

        $now = Carbon::now();
        $now = $now->getTimestamp();
        if($now > strtotime($request->publication_date)){
            $status = 1;
        }
        $event = Event::find($id);
        $event->name = $request->name;
        $event->city_id = $request->city;
        $event->place = $request->place;
        $event->start_date = $request->start_date;
        $event->finish_date = $request->finish_date;
        $event->last_attendance_date = $request->last_attendance_date;
        $event->publication_date = $request->publication_date;
        $event->description = $request->description;
        $event->footnote = $footnote;
        $event->status = $status;
        $event->quota = $request->quota;
        $event->age_restriction = $age;
        $event->attendance_price = $request->attendance_price;
        $event->save();

        /* Save categories */
            $event->categories()->sync($request->categories, false);

        /* Save image */
            if($request->image != ""){
                $img = Image::make(Input::file('image'));
                if($img->width() > 400){
                    $img->resize(400, 560);
                }
                $img->encode('jpg');
                $img->save('tmp_'.$event->id.'.jpg');
                $image = \App\EventFile::where([
                    'event_id' => $event->id,
                    'file_type_id' => 1
                ])->get();
                $image->file = $img;
                $image-save();
                $img->destroy();
                unlink('tmp_'.$event->id.'.jpg');
            }

        /* Save file */
            if($request->file != ""){
                $filePath = (string) $request->file('file')->storeAs('pdf', 'tmp_'.$event->id.'.pdf');
                $filePath = "storage/app/".$filePath;
                $fileContent = file_get_contents($filePath);
                $file = \App\EventFile::where([
                    'event_id' => $event->id,
                    'file_type_id' => 2
                ])->get();
                if(count($file)){
                    $file->file = $fileContent;
                    $file->save();
                }
                else{
                    $file = new \App\EventFile([
                        'file' => $fileContent,
                        'file_type_id' => 2
                    ]);
                    $event->files()->save($file);
                }

                unlink($filePath);
            }

        return redirect()->back()->with('success', $request->name." adlı etkinlik başarıyla güncellendi.");

    }

    public function destroy($id){
        $event = Event::find($id);
        if($event){
          $name = $event->name;
          $event->delete();
          return redirect()->route('event.index')->with('success', $name." adlı etkinlik başarıyla silindi.");
        }
        $errors = "Silmek istediğizi etkinlik bulunamadı.";
        return redirect()->route('event.index')->withErrors($errors);

    }

    public function freezeByCreator($id){
        $event = $this->checkIfEventOwnedByCreator($id);
        if(!$event){
            $event = Event::find($id);
            $event->status = 2;
            $event->save();
            return redirect()->route('event.index')->with('success', $name." adlı etkinlik başarıyla donduruldu.");
        }
        return $event;
    }

    public function unfreezeByCreator($id){
        $event = $this->checkIfEventOwnedByCreator($id);
        if(!$event){
            $event = Event::find($id);
            $event->status = 1;
            $event->save();
            return redirect()->route('event.index')->with('success', $name." adlı etkinlik, yayın yarihinden sonra yayınlanacak durumda ayarlandı.");
        }
        return $event;
    }

    public function freezeByAdmin($id){
        $event = Event::find($id);
        if($event){
            $event->status = 3;
            $event->save();
            return redirect()->route('event.index')->with('success', $name." adlı etkinlik başarıyla donduruldu.");
        }
    }

    public function unfreezeByAdmin($id){
        $event = Event::find($id);
        if($event){
            $event->status = 1;
            $event->save();
            return redirect()->route('event.index')->with('success', $name." adlı etkinlik, yayın yarihinden sonra yayınlanacak durumda ayarlandı.");
        }
    }

    public function cancel($id){
        $event = $this->checkIfEventOwnedByCreator($id);
        if(!$event){
            $event = Event::find($id);
            $event->status = 4;
            $event->save();
            return redirect()->route('event.index')->with('success', $name." adlı etkinlik iptal edildi.");
        }
        return $event;
    }

    public function cancelByAdmin($id){

        if(Auth::guard('admin')->check()){
            $event = Event::find($id);
            $event->status = 4;
            $event->save();
            return redirect()->route('event.index')->with('success', $name." adlı etkinlik iptal edildi.");
        }

        $errors = "Yetkiniz dışında hareket ediyor yada böyle bir etkinlik yok.";
        return redirect()->back()->withErrors($errors);

    }

    public function profile($id){
        $event = Event::where([
            ['id', '=', $id],
            ['status', '=', 1],
            ['publication_date', '<=', Carbon::now()],
        ])->first();

        if($event){
            $complaintTypes = ComplaintType::orderBy('name')->get();
            return view('single')->with([
                'event' => $event,
                'complaintTypes' => $complaintTypes,
            ]);
        }
        $errors = "Malesef böyle bir etkinlik sistemimizde kayılı değil.";
        return view('404')->with('errors', $errors);
    }

    public function joinToEvent($id){
        $event = Event::find($id);
        if($event->quota != null && $event->quota <= count($event->users()->get())){
            $errors = "Malesef etkinlik maksimum katılımcı sayısına ulaştı.";
            return redirect()->back()->withErrors($errors);
        }
        elseif($event && Auth::user() && !$event->users()->where('user_id', Auth::user()->id)->first()){
            $user = Auth::user();
            $event->users()->attach($user->id);
            return redirect()->back()->with('success', $event->name." adlı etkinliğe katıldınız.");
        }
        $errors = "Malesef istediğiniz işlemi yapamadık.";
        return view('404')->with('errors', $errors);
    }

    public function unjoinFromEvent($id){
        $event = Event::find($id);
        if($event && Auth::user() && $event->users()->where('user_id', Auth::user()->id)->first()){
            $user = Auth::user();
            $event->users()->detach($user->id);
            if($comment = $event->comments()->where('user_id', $user->id)->first()){
                $comment->delete();
            }
            return redirect()->back()->with('success', $event->name." adlı etkinlikten ayrıldınız.");
        }
        $errors = "Malesef istediğiniz işlemi yapamadık.";
        return view('404')->with('errors', $errors);
    }

    public function download($id){
        $event = Event::find($id);

        $file = $event->files[1]->file;

        echo'
        <html>
            <body style="background-color: rgb(38,38,38); height: 100%; width: 100%; overflow: hidden; margin: 0">
                <object data="data:application/pdf;base64,'.base64_encode($file).'" type="application/pdf" style="height:100%;width:100%"></object>
            </body>
        </html>
        ';

    }

    public function sendComment(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'comment'   => 'required|max:255',
            'count'     => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }

        $event = Event::find($id);
        if($event && Auth::user()){
            $user = Auth::user();
            // create comment
            $comment = new Comment();
            $comment->event_id = $id;
            $comment->user_id = $user->id;
            $comment->comment = $request->comment;
            $comment->rate = $request->count;
            $comment->save();

            return redirect()->back()->with('success', "Yorumunuz kaydedildi.");
        }
        $errors = "Malesef istediğiniz işlemi yapamadık.";
        return view('404')->with('errors', $errors);
    }

    public function everything(Request $request){

        $page = $request->page;
        $validator = Validator::make($request->all(), [
            'keyword'       => 'nullable|max:255',
            'city'          => 'nullable|integer|min:1|max:81',
            'start_date'    => 'nullable|date',
            'finish_date'   => 'nullable|date',
            'orderBy'       => 'nullable|string|min:1|max:30',
            'pager'         => 'nullable|integer|min:10|max:50',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        if($request->start_date && $request->finish_date && ($request->start_date >= $request->finish_date)){
            $errors = "Başlangıç Tarihi, Bitiş Tarihinden yüksek olamaz.";
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        $orderBy = "start_date";
        $now = Carbon::now();
        if($request->category){
            $category_id = $request->category;
            $cat = Category::find($category_id);
            $events = $cat->events();
        }
        else {
            $events = Event::where(function($query) use ($request){
                /* Filter by search keyword */
                    if(($keyword = $request->keyword)){
                        $query->where([['name', 'like', '%'.$keyword.'%']]);
                    }
                /* Filter by city */
                    if(($city = $request->city)){
                        $query->where([['city_id', '=', $city]]);
                    }
                /* Filter by dates */
                    if($start = $request->start_date && $finish = $request->finish_date){
                        $start = $request->start_date;
                        $finish = $request->finish_date.' 23:45:00';
                        $query->where([
                                ['start_date', '=>', $start]
                            ])
                            ->orWhere([
                                ['finish_date', '<=', $finish]
                            ]);
                    }
                    elseif($start = $request->start_date && !($finish = $request->finish_date)){
                        $start = $request->start_date;
                        $query->where([
                            ['start_date', '>=', $start]
                        ]);
                    }
                    elseif(!($start = $request->start_date) && $finish = $request->finish_date){
                        $finish = $request->finish_date.' 23:45:00';
                        $query->where([
                            ['finish_date', '<=', $finish]
                        ]);
                    }
            });
        }
        $events = $events->where([
            ['status', '=', 1],
            ['finish_date', '>', $now],
            ['publication_date', '<', $now],
        ]);
        if($request->get('orderBy')){
            $events = $events->orderBy($request->get('orderBy'), "asc");
        }
        else {
            $events = $events->orderBy("start_date", "asc");
        }
        if(!$pager = $request->pager){
            $pager = 10;
        }
        $events = $events->paginate($pager);
        if($page <= ceil($events->total()/$pager)){
            $priorityEvents = $this->getPEvents();
            $UEvents = $this->getUEvents();
            $OEvents = $this->getOldEvents();
            $searchableCities = City::all();
            $categories = $this->getCategories();
            return view('everything')->with([
                'events' => $events,
                'categories' => $categories,
                'searchableCities' => $searchableCities,
                'priorityEvents' => $priorityEvents,
                'UEvents' => $UEvents,
                'OEvents' => $OEvents,
                ]);
        }
        return view('everything');
    }

    public function joiners($id)
    {
        $event = $this->checkIfEventOwnedByCreator($id);
        if(!$event){
            $event = Event::find($id);
            $users = $event->users;
            return view('joiners')->with([
                'event' => $event,
                'users' => $users,
            ]);
        }
        return $event;
    }

}
