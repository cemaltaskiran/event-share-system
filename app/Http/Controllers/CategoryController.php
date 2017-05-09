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

    public function showIndex(){
		$eventCategories = Category::orderBy("id", "asc")->get();

		return view('index')->with('eventCategories', $eventCategories);
	}

    public function displayCategories(Request $request){

        $page = $request->get("page");
        $eventCategories = Category::where(function($query) use ($request){
            // Filter by search keyword
            if(($search = $request->get("search"))){
                $query->where('name', 'like', '%'.$search.'%');
            }
        })
        ->orderBy("name", "asc")->paginate(10);
        if($page > ceil($eventCategories->total()/10)){
            return redirect()->route('category.index');
        }
        return view('category.index')->with('eventCategories', $eventCategories);
    }

    public function showCreateForm(){
      return view('category.create');
    }

    public function showUpdateForm($id){
        $eventCategory = Category::find($id);
        if($eventCategory){
            return view('category.update')->with('eventCategory', $eventCategory);
        }
        $errors = "Güncellemek istediğiz etkinlik bulunamadı.";
        return redirect()->route('category.index')->withErrors($errors);
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
          return redirect()->route('category.index')->with('success', $name." adlı kategori başarıyla silindi.");
        }
        $errors = "Silmek istediğizi kategori bulunamadı.";
        return redirect()->route('category.index')->withErrors($errors);

    }

}
