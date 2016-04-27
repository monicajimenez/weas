<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RequestTypeApprover;
use Response;
use Auth;

class RequestTypeApproverController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Retrieves the default approvers of a certain request type.
     * @param none, accepts json request
     * @return \Illuminate\Http\Response
     */
    public function getRequestApprover(Request $request)
    {
        //Initialization
        $RequestTypeApprover = new RequestTypeApprover;
        $filing_type = $request->filing_type;
        $project_code = $request->project_code;
        $request_type_code = $request->request_type_code;
        $user_id = trim(Auth::user()->app_code);
        
        //Get request type code (DB:req_code)
        if($filing_type == 'RFC')
        {
            $request_type_code = $request->req_ref;
        }
        
        //Retrieve default approvers
        $request_approvers = $RequestTypeApprover->getRequestApprover($project_code, $request_type_code);
 
        return Response::json($request_approvers);
    }
}
