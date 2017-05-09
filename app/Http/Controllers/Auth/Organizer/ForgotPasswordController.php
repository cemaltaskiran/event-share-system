<?php

namespace App\Http\Controllers\Auth\Organizer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
	use SendsPasswordResetEmails;

    //Shows form to request password reset
    public function showLinkRequestForm()
    {
        return view('auth.organizer.passwords.email');
    }

	//Password Broker for Seller Model
    public function broker()
    {
         return Password::broker('organizers');
    }
}
