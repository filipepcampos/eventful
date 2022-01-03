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

    public function blockUser(Request $request, $id){
        $user = User::find($id);
        $motive = $request->input('block_motive');
        if($motive != null){
            $user->block_motive = $motive;
            $user->save();
            return response(null, 200);
        }
        return response(null, 403);
    }

    public function unblockUser(Request $request, $id){
        $user = User::find($id);
        $user->block_motive = null;
        $user->save();
        return response(null, 200);
    }
}
