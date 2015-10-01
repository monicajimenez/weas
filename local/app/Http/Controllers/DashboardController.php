<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// user added includes
use App\EASRequest;
use Session;
use Input;
use Auth;
use Form;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index( Request $inputs )
    {
        // Initialization 
        $EASRequest = new EASRequest;
        $data = [];
        $data['request_status'] = 'Pending';
        $data['request_status_label'] = 'Dashboard';
        $data['request_table_status_column'] = 0;
        $data['search'] = $inputs->search;
        $user_id = trim(Auth::user()->app_code);
        $data['requests'] = $EASRequest->getRequest($user_id, $data['request_status'], $data['search']);
        $data['statistics'] = $this->getRequestsStatistics();

        // Generate View
        return view('dashboard', $data);
    }

    public function getRequestsStatistics()
    {
        // Initialization
        $EASRequest = new EASRequest;
        $user_id = trim(Auth::user()->app_code);
        
        return $EASRequest->getRequestStatistics($user_id);;
    }
   
}
