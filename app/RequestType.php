<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    protected $table = 'request';
    protected $primaryKey = 'req_code';
    public $timestamps = false;

    /**
     * Get all request types belonging to a certain category
     * @param $request_type - (required) The type of request you want to query.
     * 						  Values: 'QAC', 'RFC', 'RFR'
     * @return Response
     */
    public function getRequestType($request_type = '')
    {
    	//Initialization
    	$request_type_desc = [];

    	//Get request type's description
    	if($request_type == 'QAC')
    	{
    		$request_type_desc = ['Qualified Accounts for Construction'];
    	}
    	else if($request_type == 'RFR')
    	{ 
    		$request_type_desc = ['Forfeiture/Discontinue the purchase']; 	
    	}

    	//Get request type's values
    	if($request_type == 'QAC' || $request_type == 'RFR')
    	{
    		$request_type_values = $this->where(['req_desc' => $request_type_desc])->get(['req_code']);
    	}
    	else if( $request_type == 'RFC' )
    	{
    		$request_type_values = $this->whereNotIn('req_desc', ['Qualified Accounts for Construction', 'Request for Reopening', 'Forfeiture/Discontinue the purchase'])
    									->get(['req_code', 'req_desc']);
    	}

    	return $request_type_values;
    }
}
