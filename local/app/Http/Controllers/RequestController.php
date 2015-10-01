<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//additional includes
use App\EASRequest;
use Session;
use DB;
use Input;
use Auth;
use Form;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index( $request_status = '', Request $inputs )
    {   
        // Initialization 
        $EASRequest = new EASRequest;
        $data = [];
        $data['request_status'] = $request_status;
        $data['request_status_label'] = '';
        $data['request_table_status_column'] = 0;
        $data['search'] = $inputs->search;
        $user_id = trim(Auth::user()->app_code);
        $data['requests'] = $EASRequest->getRequest($user_id, $data['request_status'], $data['search']);

        // Format Data
        if( $data['request_status'] == 'all' )
        {
            $data['request_status_label'] = 'All Requests';
            $data['request_table_status_column'] = 1;
        }
        else
        {
            $data['request_status_label'] = studly_case($data['request_status'] . '&nbsp;Requests'); 
        }

        // Generate View
        if( ($data['request_status'] == 'pending') || ($data['request_status'] == 'incoming') ||
            ($data['request_status'] == 'denied') || ($data['request_status'] == 'approved')  ||
            ($data['request_status'] == 'on-hold') || ($data['request_status'] == 'reset')  ||
            ($data['request_status'] == 'all') )
        {
            return view('request.list', $data);
        }
        else
        {
            echo 'page not found';
        } 

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
    public function show($request_id ='')
    {

        if($request_id)
        {
            $EASRequest = new EASRequest;
            $user_id = trim(Auth::user()->app_code);
            $data = [];
            $data['details'] = $EASRequest->getRequestDetails($request_id);
            $data['signed'] = 0;
            $precedingLevel = $data['details']['user_approver']['rfcline_level']-1;
            $data['authorize_to_sign'] = 0;

            foreach( $data['details']->approvers as $approver)
            {   
                if(trim($approver->app_code) == $user_id && trim($approver->rfcline_stat) == 'Signed')
                {
                    $data['signed'] = 1;
                }
                if($approver->rfcline_level == $precedingLevel && trim($approver->rfcline_stat) == 'Signed')
                {
                    $data['authorize_to_sign'] = 1;
                }
            }
    
            return view('request.details', $data);
        }
        else
        {
            echo 'page not found';
        }
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
     * @param  int  $request_id
     * @return Response
     */
    public function update(Request $request, $request_id)
    {
        $approver_response = '';

        if(Input::get('approver_response'))
        {
            $EASRequest = new EASRequest;
            $user_id = trim(Auth::user()->app_code);
            $EASRequest->updateRequest($request_id,Input::get('approver_response'),$user_id, $request->input('remarks'));

            $data = [];
            $data['details'] = $EASRequest->getRequestDetails($request_id);

            return view('request.details', $data);
        }
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
