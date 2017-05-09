<?php

namespace App\Http\Controllers\Auth\Organizer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    protected $redirectTo = '/organizer';

    use ResetsPasswords;

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.organizer.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

	public function broker()
    {
        return Password::broker('organizers');
    }

    protected function guard()
    {
        return Auth::guard('organizer');
    }
}
