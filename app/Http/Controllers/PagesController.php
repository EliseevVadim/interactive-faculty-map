<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    public function openAdminPage()
    {
        if(is_null(Auth::user()))
            return redirect()->route('openAdminAuthPage');
        return view('adminPage');
    }

    public function openAdminAuthPage()
    {
        return view('adminAuthorizationPage');
    }
}
