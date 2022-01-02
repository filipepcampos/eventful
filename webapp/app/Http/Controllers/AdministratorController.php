<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function home(){
        if(Auth::guard('admin')->check()){
            dd('admin');
        }
        dd('hello :)');
    }
}
