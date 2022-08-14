<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('login');
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
            $credentials = $request->validate([
                "username" => "required",
                "password" => "required"
            ]);
            
            $user = User::where("username", $request->username)->first();

            $passwordIsMatch = app('hash')->check($request->password??'', $user->password??'');
            
            //check if user not available in local database then send request to api server
            if (!$passwordIsMatch) {
                $post = Helper::Guzzle(
                    "https://devel.bebasbayar.com/web/test_programmer.php", 
                    [], 
                    [ 'Accept' => 'application/json' ],
                    ["user" => $request->username, 'password' => $request->password], 
                    "POST");

                    //save new record user from api server when status true
                    if ($post['rc'] != '01') {
                        User::create([
                            "username" => $request->username,
                            "password" => Hash::make($request->password)
                        ]);
                    }

            } else {
                $post['rc'] = '00';
            }
            

            if ($post['rc'] == '01') {

                //redirect to login and give massage from api server
                return redirect()->route('login.index')->with("Erorr", $post['rd']);
            } else {
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect()->intended('dashboard');
                }
            }
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\users  $users
     * @return \Illuminate\Http\Response
     */
    public function show(users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, users $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(users $users)
    {
        //
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('login');
    }
}
