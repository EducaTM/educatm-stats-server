<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data['users'] = User::all();
        return view('users.index', $data);
    }

    public function disable(Request $request, $id){
        $user = User::findOrFail($id);
        $user->disabled = true;
        $user->save();
        return back()->with('success', 'User has been disabled!');
    }

    public function enable(Request $request, $id){
        $user = User::findOrFail($id);
        $user->disabled = false;
        $user->save();
        return back()->with('success', 'User has been enabled!');
    }

    public function edit(Request $request, $id){
        $data["user"] = User::findOrFail($id);

        return view('users.edit', $data);
    }

    public function update(Request $request, $id){

        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        return back()->with('success', 'Update successful!');
    }
}
