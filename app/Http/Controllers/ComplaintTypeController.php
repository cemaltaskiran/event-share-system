<?php

namespace App\Http\Controllers;

Use App\ComplaintType;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Input;
use Illuminate\Support\MessageBag;

class ComplaintTypeController extends Controller
{
    /**
     * Validate datas from create or update form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function validateDatasOrBack(Request $request)
    {

        if(!$request->id){
            // If Insert
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|unique:categories',
                'description' => 'nullable|max:255'
            ]);
        }
        else {
            // If Update
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255|unique:categories,name,'.$request->id,
                'description' => 'nullable|max:255'
            ]);
        }


        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }

        return null;
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
            'keyword' => 'nullable|max:255',
            'pager' => 'nullable|integer|min:10|max:50',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }

        $complaintTypes = ComplaintType::where(function($query) use ($request){
            // Filter by search keyword
            if(($keyword = $request->get("keyword"))){
                $query->where('name', 'like', '%'.$keyword.'%');
            }
        })->orderBy("name", "asc");
        if(!$pager = $request->pager){
            $pager = 10;
        }
        $complaintTypes = $complaintTypes->paginate($pager);

        if($page > ceil($complaintTypes->total()/$pager)){
            return redirect()->route('admin.complaint.type.index');
        }
        return view('admin.complaint.type.index')->with('complaintTypes', $complaintTypes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.complaint.type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->validateDatasOrBack($request);
        if($result){
            return $result;
        }

        $complaintType = new ComplaintType;

        $complaintType->name = $request->name;
        $complaintType->description = $request->description;

        $complaintType->save();

        return redirect()->back()->with('success', $request->name." adlı şikayet tipi başarıyla kaydedildi.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $complaintType = ComplaintType::find($id);
        if($complaintType){
            return view('admin.complaint.type.update')->with('complaintType', $complaintType);
        }
        $errors = "Güncellemek istediğiz etkinlik bulunamadı.";
        return redirect()->route('admin.complaint.type.index')->withErrors($errors);
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
        $result = $this->validateDatasOrBack($request);
        if($result){
            return $result;
        }

        $complaintType = ComplaintType::find($id);

        $complaintType->name = $request->name;
        $complaintType->description = $request->description;

        $complaintType->save();

        return redirect()->back()->with('success', $request->name." adlı şikayet tipi başarıyla güncellendi.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $complaintType = ComplaintType::find($id);
        if($complaintType){
          $name = $complaintType->name;
          $complaintType->delete();
          return redirect()->route('admin.complaint.type.index')->with('success', $name." adlı şikayet tipi başarıyla silindi.");
        }
        $errors = "Silmek istediğizi kategori bulunamadı.";
        return redirect()->route('admin.complaint.type.index')->withErrors($errors);
    }
}
