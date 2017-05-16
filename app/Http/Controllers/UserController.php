<?php

namespace App\Http\Controllers;

use
    App\Event,
    App\Category,
    App\City,
    Illuminate\Http\Request,
    Validator,
    Redirect,
    Input,
    Illuminate\Support\MessageBag,
    Carbon\Carbon,
    Auth;

class UserController extends Controller
{

    protected function getSearchableCities(){
        $user = Auth::user();
        $events = $user->events()->orderBy("start_date", "desc")->get();
        $searchableCities = array();
        foreach ($events as $event) {
            if(!in_array($event->city, $searchableCities)){
                array_push($searchableCities, $event->city);
            }
        }
        return $searchableCities;
    }

    public function joinedEvents(Request $request){

        $user = Auth::user();
        $page = $request->page;
        $validator = Validator::make($request->all(), [
            'keyword' => 'nullable|max:255',
            'city' => 'nullable|integer|min:1|max:81',
            'start_date' => 'nullable|date',
            'finish_date' => 'nullable|date',
            'status' => 'nullable|integer|min:1|max:5',
            'pager' => 'nullable|integer|min:10|max:50',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        if($request->start_date && $request->finish_date && ($request->start_date >= $request->finish_date)){
            $errors = "Başlangıç Tarihi, Bitiş Tarihinden yüksek olamaz.";
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        $events = $user->events()->where(function($query) use ($request){
            $now = Carbon::now();
            /* Filter by search keyword */
                if(($keyword = $request->keyword)){
                    $query->where([['name', 'like', '%'.$keyword.'%']]);
                }
            /* Filter by city */
                if(($city = $request->city)){
                    $query->where([['city_id', '=', $city]]);
                }
            /* Filter by status */
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
            $searchableCities = $this->getSearchableCities();
            return view('user.event.joined')->with([
                'events' => $events,
                'searchableCities' => $searchableCities,
                ]);
        }
        return redirect()->route('user.event.joined');
    }
}
