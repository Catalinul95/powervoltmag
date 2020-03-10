<?php

namespace App\Http\Controllers;

use Hash;
use Auth;
use App\User;
use Illuminate\Http\Request;

class MembersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);

        return view('members.index', compact('user'));
    }

    public function update(Request $request)
    {

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'numeric'],
            'password' => ['required'],
        ]);

        $user = User::find(Auth::user()->id);

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Parola introdusa este gresita.');
        }
        

        if (User::where('id', '!=', $user->id)->where('email', $request->email)->first()) {
            return back()->with('error', 'Adresa de email trebuie sa fie unica.');
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->individual = ($request->individual == 'on') ? 1: 0;

        if ($request->has('new_password') && !is_null($request->new_password)) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('message', 'Datele contului tau au fost actualizate.');
    }
}
