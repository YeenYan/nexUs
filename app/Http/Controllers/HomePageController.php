<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{


    public function landingPage()
    {
        return inertia('HomePage/LandingPage');
    }

    public function signupPage()
    {
        return inertia('HomePage/SignupPage');
    }

    public function loginPage()
    {
        return inertia('HomePage/LoginPage');
    }
}
