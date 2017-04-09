<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Input;
use Illuminate\Support\MessageBag;

class EventController extends Controller
{            

    protected function validateDatasOrBack(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'place' => 'required|max:255',
            'quota' => 'nullable|integer|max:4294967295|min:0',
            'start_date' => 'required|date|after_or_equal:now',
            'finish_date' => 'required|date|after_or_equal:start_date',
            'last_attendance_date' => 'required|date|before_or_equal:finish_date',
            'attendance_price' => 'nullable|integer|max:4294967295|min:0',
        ]);
        
        if ($validator->fails()) {            
            $errors = $validator->errors();            
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }

        return null;
    }

    protected function redirectBackWithSuccess(Request $request){
        return redirect()->back()->with('success', $request->name.' adlı etkinlik başarıyla kaydedildi.');
    }

    public function displayEvents(){
        $events = Event::all();

        return view('event.index')->with('events', $events);
    }

    public function showCreateForm(){
        return view('event.create');
    }

    public function store(Request $request){

        $result = $this->validateDatasOrBack($request);
        if($result){
            return $result;
        }
                
        $event = new Event;

        $event->name = $request->name;
        $event->place = $request->place;
        $event->quota = $request->quota;
        $event->start_date = $request->start_date;
        $event->finish_date = $request->finish_date;
        $event->last_attendance_date = $request->last_attendance_date;
        $event->attendance_price = $request->attendance_price;

        $event->save();

        return $this->redirectBackWithSuccess($request);
        
    }

    public function update(Request $request, $id){

        $result = $this->validateDatasOrBack($request);
        if($result){
            return $result;
        }

        $event = Event::find($id);

        $event->name = $request->name;
        $event->place = $request->place;
        $event->quota = $request->quota;
        $event->start_date = $request->start_date;
        $event->finish_date = $request->finish_date;
        $event->last_attendance_date = $request->last_attendance_date;
        $event->attendance_price = $request->attendance_price;

        $event->save();

        return $this->redirectBackWithSuccess($request);
        
    }

    public function destroy(Request $request, $id){
        Event::destroy($id);
    }
}