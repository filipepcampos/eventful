<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:admin')->except('logout');
    }

    public function home()
    {
        if(Auth::guard('admin')->check()){
            return view('pages.admin');
        }
        return redirect('/admin/login');
    }

    public function users(){
        $users = User::paginate(24);
        return view('pages.adminUserList', ['users' => $users]);
    }
}
