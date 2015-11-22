<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    protected $table = 'request';
    protected $primaryKey = 'req_code';
    public $timestamps = false;

    /**
     * Get all request type depending on the rights of the user.
     * @param $request_type - (required) The type of request.
     						  Values: 'QAC', 'RFC', 'RFR'
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
    		$request_type_desc = ['Request for Reopening']; 	
    	}

    	//Get request type's values
    	if($request_type == 'QAC' || $request_type == 'RFR')
    	{
    		$request_type_values = $this->where(['req_desc' => $request_type_desc])->get(['req_code']);
    	}
    	else if( $request_type == 'RFC' )
    	{
    		$request_type_values = $this->whereNotIn('req_desc', ['Qualified Accounts for Construction', 'Request for Reopening'])
    									->get(['req_code']);
    	}

    	return $request_type_values;
    }
}
