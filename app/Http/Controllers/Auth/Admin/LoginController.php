<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
	//Where to redirect organizer after login.
	protected $redirectTo = '/admin';

	//Trait
	use AuthenticatesUsers;

	//Custom guard for organizer
	protected function guard()
	{
		return Auth::guard('admin');
	}

	//Shows organizer login form
	public function showLoginForm()
	{
		return view('auth.admin.login');
	}
}
