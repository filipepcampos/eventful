<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $this->authorize('view', $user);
        return view('pages.profile', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function showUpdateForm($id)
    {   
        // TODO: APENAS O USER PODE EDITAR
        if (!Auth::check()) return redirect('/login');
        $user = User::find($id);
        return view('pages.updateProfile', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if (!Auth::check()) return redirect('/login');
        $user = User::find($id);
        $this->authorize('update', $user);

        $validated = $request->validated();

        if(!is_null($request->input('username'))){ 
            $user->username = $request->input('username');
        }
        
        if(!is_null($request->input('name'))){ 
            $user->name = $request->input('name');
        }
        
        if(!is_null($request->file('profile_pic'))){ 
            $user->profile_pic = $request->file('profile_pic')->store('profile_pictures');
        }
        
        if(!is_null($request->input('description'))){ 
            $user->description = $request->input('description');
        }
        
        if(!is_null($request->input('email'))){ 
            $user->email = $request->input('email');
        }
        
        if(!is_null($request->input('password'))){ 
            $user->password = $request->input('password');
        }
        
        if(!is_null($request->input('birthdate'))){ 
            $user->birthdate = $request->input('birthdate');
        }

        $user->save();
        
        return redirect('user/' . $user->id);
    }

    public function getImage($id){
        $user = User::find($id);
        $this->authorize('view', $user);
        return Storage::response($user->profile_pic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
