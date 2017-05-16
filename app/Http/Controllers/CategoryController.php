<?php

namespace App\Http\Controllers;

use App\Event;
use App\Category;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Input;
use Illuminate\Support\MessageBag;

class CategoryController extends Controller
{

    protected function validateDatasOrBack(Request $request){

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

    public function displayCategories(Request $request){
        $page = $request->page;
        $validator = Validator::make($request->all(), [
            'keyword' => 'nullable|max:255',
            'pager' => 'nullable|integer|min:10|max:50',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput(Input::all())->withErrors($errors);
        }
        $eventCategories = Category::where(function($query) use ($request){
            // Filter by search keyword
            if(($keyword = $request->get("keyword"))){
                $query->where('name', 'like', '%'.$keyword.'%');
            }
        })->orderBy("name", "asc");
        if(!$pager = $request->pager){
            $pager = 10;
        }
        $eventCategories = $eventCategories->paginate($pager);

        if($page > ceil($eventCategories->total()/$pager)){
            return redirect()->route('admin.category.index');
        }
        return view('admin.category.index')->with('eventCategories', $eventCategories);
    }

    public function showCreateForm(){
        return view('admin.category.create');
    }

    public function showUpdateForm($id){
        $eventCategory = Category::find($id);
        if($eventCategory){
            return view('admin.category.update')->with('eventCategory', $eventCategory);
        }
        $errors = "Güncellemek istediğiz etkinlik bulunamadı.";
        return redirect()->route('admin.category.index')->withErrors($errors);
    }

    public function store(Request $request){

      $result = $this->validateDatasOrBack($request);
      if($result){
          return $result;
      }

      $eventCategory = new Category;

      $eventCategory->name = $request->name;
      $eventCategory->description = $request->description;

      $eventCategory->save();

      return redirect()->back()->with('success', $request->name." adlı kategori başarıyla kaydedildi.");

    }

    public function update(Request $request, $id){

        $result = $this->validateDatasOrBack($request);
        if($result){
            return $result;
        }

        $eventCategory = Category::find($id);

        $eventCategory->name = $request->name;
        $eventCategory->description = $request->description;

        $eventCategory->save();

        return redirect()->back()->with('success', $request->name." adlı kategori başarıyla güncellendi.");

    }

    public function destroy($id){
        $eventCategory = Category::find($id);
        if($eventCategory){
          $name = $eventCategory->name;
          $eventCategory->delete();
          return redirect()->route('admin.category.index')->with('success', $name." adlı kategori başarıyla silindi.");
        }
        $errors = "Silmek istediğizi kategori bulunamadı.";
        return redirect()->route('admin.category.index')->withErrors($errors);

    }

}
