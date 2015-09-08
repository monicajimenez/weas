<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;  

class UserController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function login(Request $request)
    {
        if( Auth::check() || ($request->input('username') && $request->input('password')) )
        {
            Auth::attempt(array(
                'app_email' => $request->input('username'),
                'password'  => $request->input('password'),
            ));

            if (Auth::check()) {
                return view('dashboard');
            } else 
            {
                return view('user.login');
            }
        }
        else
        {
            return view('user.login');
        }   
        
    }

     /**
     * Shows the user's profile.
     *
     * @return Response
     */
    public function profile()
    {
        //
        return view('user.profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
