<?php

namespace App\Http\Controllers;

use App\Event;
use App\Category;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Input;
use Illuminate\Support\MessageBag;
use DateTime;
use Auth;
use Image;

class EventController extends Controller
{

    public function showIndex(){
		$events = Event::orderBy("id", "desc")->get();
        $categories = \App\Category::orderBy("name", "asc")->get();

		return view('index')->with([
            'events'=> $events,
            'categories' => $categories
        ]);
	}

    public function displayEvents(Request $request){

        $page = $request->get("page");
        $events = Event::where(function($query) use ($request){
            // Filter by search keyword
            if(($search = $request->get("search"))){
                $query->where('name', 'like', '%'.$search.'%');
            }
        })
        ->orderBy("id", "desc")->paginate(10);
        if($page > ceil($events->total()/10)){
            return redirect()->route('event.index');
        }
        return view('event.index')->with('events', $events);
    }

    public function showCreateForm(){
        $categories = Category::orderBy('name', 'asc')->get();
        $file = file_get_contents(asset('public/cities.xml'));
        $cities = new \SimpleXMLElement($file);

        return view('event.create', ['categories' => $categories, 'cities' => $cities]);
    }

    public function showUpdateForm($id){
        $event = Event::find($id);
        if($event){
            $categories = Category::orderBy('name', 'asc')->get();
            $file = file_get_contents(asset('public/cities.xml'));
            $cities = new \SimpleXMLElement($file);
            return view('event.update', ['event' => $event, 'categories' => $categories, 'cities' => $cities]);
        }
        $errors = "Güncellemek istediğiz etkinlik bulunamadı.";
        return redirect()->route('event.index')->withErrors($errors);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'city' => 'required|integer|min:1|max:81',
            'place' => 'required|max:255',
            'quota' => 'nullable|integer|max:4294967295|min:0',
            'start_date' => 'required|date|after_or_equal:now',
            'finish_date' => 'required|date|after_or_equal:start_date',
            'last_attendance_date' => 'required|date|before_or_equal:finish_date',
            'publication_date' => 'required|date|before_or_equal:start_date',
            'min_age' => 'nullable|required_with:max_age|integer|min:0',
            'max_age' => 'nullable|required_with:min_age|integer|greater_than_field:min_age',
            'attendance_price' => 'nullable|integer|max:4294967295|min:0',
            'categories' => 'required|array|min:1',
            'footnote' => 'nullable|max:255',
            'description' => 'required|min:10|max:65535',
            'image' => 'required|image|dimensions:min_width=400,min_height=560,ratio=5/7|mimes:jpeg,jpg,png,gif|max:2000',
            'file' => 'nullable|file|mimes:pdf|max:2000'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // dd($request->all());
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

      $now = new DateTime();
      $now = $now->getTimestamp();
      if($now > strtotime($request->publication_date)){
          $status = 1;
      }

      $event = new Event;
      $event->name = $request->name;
      $event->city = $request->city;
      $event->place = $request->place;
      $event->start_date = $request->start_date;
      $event->finish_date = $request->finish_date;
      $event->last_attendance_date = $request->last_attendance_date;
      $event->publication_date = $request->publication_date;
      $event->description = $request->description;
      $event->footnote = $footnote;
      $event->status = $status;
      $event->creator_id = Auth::user()->id;
      $event->quota = $request->quota;
      $event->age_restriction = $age;
      $event->attendance_price = $request->attendance_price;
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

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'city' => 'required|integer|min:1|max:81',
            'place' => 'required|max:255',
            'quota' => 'nullable|integer|max:4294967295|min:0',
            'start_date' => 'required|date|after_or_equal:now',
            'finish_date' => 'required|date|after_or_equal:start_date',
            'last_attendance_date' => 'required|date|before_or_equal:finish_date',
            'publication_date' => 'required|date|before_or_equal:start_date',
            'min_age' => 'nullable|required_with:max_age|integer|min:0',
            'max_age' => 'nullable|required_with:min_age|integer|greater_than_field:min_age',
            'attendance_price' => 'nullable|integer|max:4294967295|min:0',
            'categories' => 'required|array|min:1',
            'footnote' => 'nullable|max:255',
            'description' => 'required|min:10|max:65535',
            'image' => 'nullable|image|dimensions:min_width=400,min_height=560,ratio=5/7|mimes:jpeg,jpg,png,gif|max:2000',
            'file' => 'nullable|file|mimes:pdf|max:2000'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // dd($request->all());
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

        $now = new DateTime();
        $now = $now->getTimestamp();
        if($now > strtotime($request->publication_date)){
            $status = 1;
        }

        $event = Event::find($id);
        $event->name = $request->name;
        $event->city = $request->city;
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

    public function profile($id){
        $event = Event::find($id);
        if($event){
            return view('single')->with('event', $event);
        }
        $errors = "Malesef böyle bir etkinlik sistemimizde kayılı değil.";
        echo "<h1>".$errors."</h1><br /><h3><a href='".route('homepage')."'>Anasayfa</a></h3>";
    }

}
