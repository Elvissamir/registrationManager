<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DemoUserLoginController extends Controller
{
    public function store() {
        $demoUser = User::where('email', "demo@mail.com")->first();
    
        Auth::login($demoUser);
    
        return redirect(route('courses.index'));
    }
}
