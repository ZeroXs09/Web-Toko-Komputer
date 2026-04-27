<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**

     */
    public function create()
    {
        return view('login');
    }



    public function store(LoginRequest $request): RedirectResponse
    {

        $request->authenticate();


        $request->session()->regenerate();


        if ($request->user()->role == 1) {
            return redirect()->intended(route('build'));
        }


        return redirect()->intended(route('build'));
    }

    /**
     *
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
