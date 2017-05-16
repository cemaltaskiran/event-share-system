<?php

namespace App\Http\Controllers;

Use App\Complaint;
Use App\ComplaintType;
Use App\Event;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Input;
use Auth;
use Illuminate\Support\MessageBag;

class ComplaintController extends Controller
{
    /**
     * Gets complaint types.
     *
     * @return \App\ComplaintType
     */
    protected function getTypes()
    {
        return ComplaintType::orderBy('name', 'asc')->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page;
        $validator = Validator::make($request->all(), [
            'status'    => 'nullable|min:0|max:1',
            'type'      => 'nullable|min:1|max:'.count($this->getTypes()),
            'pager'     => 'nullable|integer|min:10|max:50',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }

        $complaints = Complaint::where(function($query) use ($request){
            // Filter by complaint types
            if(($type = $request->get("type"))){
                $query->where('type_id', '=', $type);
            }

        })->orderBy("id", "desc");
        if(!$pager = $request->pager){
            $pager = 10;
        }
        $complaints = $complaints->paginate($pager);

        if($page > ceil($complaints->total()/$pager)){
            return redirect()->route('admin.complaint.index');
        }
        $complaintTypes = $this->getTypes();
        return view('admin.complaint.index')->with([
            'complaints' => $complaints,
            'complaintTypes' => $complaintTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $complaint = Complaint::find($id);
        if($complaint){
          $id = $complaint->id;
          $complaint->delete();
          return redirect()->route('admin.complaint.index')->with('success', $id." numaralı şikayet başarıyla silindi.");
        }
        $errors = "Silmek istediğizi şikayet bulunamadı.";
        return redirect()->route('admin.complaint.index')->withErrors($errors);
    }

    public function sendComplaintment(Request $request, $id)
    {
        $event = Event::find($id);
        if($event && Auth::user()){
            $user = Auth::user();
            if(!$event->complaints()->where('user_id', $user->id)->first()){

                $validator = Validator::make($request->all(), [
                    'type'          => 'required|min:1|max:'.count($this->getTypes()),
                    'description'   => 'nullable|string|max:255',
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors();
                    return redirect()->back()->withInput(Input::all())->withErrors($errors);
                }

                $complaint = new Complaint;
                $complaint->type_id = $request->type;
                $complaint->event_id = $event->id;
                $complaint->user_id = $user->id;
                $complaint->description = $request->description;
                $complaint->save();

                return redirect()->back()->with('success', "Şikayetiniz iletildi.");
            }
        }
    }

    public function setRead($id)
    {
        $complaint = Complaint::find($id);
        if($complaint){
          $complaint->status = 0;
          $complaint->save();
          return redirect()->back()->with('success', $id." numaralı şikayet okundu olarak işaretlendi.");
        }
        $errors = "Şikayet bulunamadı.";
        return redirect()->route('admin.complaint.index')->withErrors($errors);
    }

    public function setUnread($id)
    {
        $complaint = Complaint::find($id);
        if($complaint){
          $complaint->status = 1;
          $complaint->save();
          return redirect()->back()->with('success', $id." numaralı şikayet okundu olarak işaretlendi.");
        }
        $errors = "Şikayet bulunamadı.";
        return redirect()->route('admin.complaint.index')->withErrors($errors);
    }
}
