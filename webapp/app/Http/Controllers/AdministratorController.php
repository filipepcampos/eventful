<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function home()
    {
        if(Auth::check()){
            return view('pages.admin');
        }
        return redirect('/login');
    }

    public function users(){
        $users = User::paginate(24);
        return view('pages.adminUserList', ['users' => $users]);
    }
}
