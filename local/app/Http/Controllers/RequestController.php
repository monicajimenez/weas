<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    }

    /**
     * Displays a list of request depending on the type in tabular format
     *
     * @param  string  $request_status
     * @return Response
     */
    public function show($request_status = "all")
    {
        // Initialization 
        $data = [];
        $data["request_status"] = substr($request_status, 1, -1); 
        $data["request_table_status_column"] = 0;

        // Formatting Data
        if( $data["request_status"] == "pending" ){
            $data["request_status_label"] = "Pending Requests";
        }
        else if( $data["request_status"] == "incoming" ){
            $data["request_status_label"] = "Incoming Requests";
        }
        else if( $data["request_status"] == "approved" ){
            $data["request_status_label"] = "Approved Requests";
        }
        else if( $data["request_status"] == "denied" ){
            $data["request_status_label"] = "Denied Requests";
        }
        else if( $data["request_status"] == "all" ){
            $data["request_status_label"] = "All Requests";
            $data["request_table_status_column"] = 1;
        }

        // Generating View
        if( ($data['request_status'] == "pending") || ($data['request_status'] == "incoming") ||
            ($data['request_status'] == "denied") || ($data['request_status'] == "approved")  ||
            ($data['request_status'] == "all") ){
            return view("request/list", $data );
        }
        else{
            echo "page not found";
        } 
    }

    /**
     * Displays the details of a request
     *
     * @param  string  $request_status
     * @return Response
     */
    public function detail($request_id = "")
    {
        if(!$request_id){
            return view('request/details');
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

}
