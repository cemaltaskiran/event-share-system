<?php

namespace App\Http\Controllers\Auth\Organizer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Organizer;
use Validator;
use Auth;

class RegisterController extends Controller
{
	protected $redirectPath = 'organizer';

	public function showRegisterForm()
	{
		return view('auth.organizer.register');
	}

	public function create(Request $request)
    {
		// Validates data
		$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:organizers',
			'address' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

		// If validation unsuccesfull return back
		if ($validator->fails()) {
            $errors = $validator->errors();
            // dd($request->all());
            return redirect()->back()->withInput($request->only('name', 'email', 'address'))->withErrors($errors);
        }

		// Create organizer
		$organizer = new Organizer;
		$organizer->name = $request->name;
		$organizer->email = $request->email;
		$organizer->address = $request->address;
		$organizer->password = bcrypt($request->password);
		$organizer->save();

		// Authenticates organizer
		if(Auth::guard('organizer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
			//Redirects organizers
			return redirect($this->redirectPath);
		}
    }

	//Get the guard to authenticate Organizer
	protected function guard()
	{
		return Auth::guard('organizer');
	}
}
