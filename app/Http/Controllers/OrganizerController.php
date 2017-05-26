<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, Validator;

class OrganizerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:organizer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('organizer')->user();
        return view('organizer')->with('user', $user);
    }

    public function update(Request $request)
    {
        $user = Auth::guard('organizer')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput($request->only('name', 'email'))->withErrors($errors);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('organizer.index')->with('success', 'Bilgileriniz güncellendi.');


    }
}
