<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//additional includes
use App\User;
use Auth;  
use Redirect;

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
     * Show the form for user log in.
     *
     * @return Response
     */
    public function login(Request $request)
    {
        if( Auth::check())
        {
            return Redirect::route('dashboard');
        }
        else if(($request->input('username') && $request->input('password')))
        {
            if(Auth::attempt(['app_email' => $request->input('username'),'password'  => $request->input('password')]))
            {
                Auth::login(Auth::user(), true);
                return Redirect::route('dashboard');        
            }
            else 
            {
                return Redirect::back()->withErrors(['Invalid email or password.']);  
            }           
        }
        else if( ($request->input('username') && !$request->input('password')) || 
                 (!$request->input('username') && $request->input('password'))  )
        {
            return view('user.login')->withErrors(['Email and Password is required.']);  
        }
        else
        {
            return view('user.login');
        }    
    }

    /**
     * Enables user to log out. 
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();

        if(Auth::check())
        {
            return Redirect::route('request.index', ['request_status' => 'pending']);
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
        $user['details'] = Auth::user();

        return view('user.profile', $user);
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
