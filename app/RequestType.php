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
     * @param $project_type - Values: Actual project_no or 'all'
     * @return Response
     */
    public function getRequestType($request_type = '', $project_type='all')
    {
    	//Initialization
    	$request_type_code = [];
        $where_project = [] ;

    	//Get request type's code
    	if($request_type == 'QAC')
    	{
    		$request_type_code = ['Req-021'];
    	}
    	else if($request_type == 'RFR')
    	{ 
    		$request_type_code = ['Req-014']; 	
    	}

        //Where Clause
        if($project_type != 'all')
        {
            $where_project = ['request_line.project_no' => $project_type];
        }

    	//Get request type's values
    	if($request_type == 'QAC' || $request_type == 'RFR')
    	{
    		$sub_query = $this->where(['request.req_code' => $request_type_code]);
    	}
    	else if( $request_type == 'RFC' )
    	{
    		$sub_query = $this->whereNotIn('request.req_desc', ['Qualified Accounts for Construction', 'Request for Reopening', 
                                                     'Forfeiture/Discontinue the purchase']);
    	}

        $query = $sub_query->join('request_line', 'request_line.req_code', '=', 'request.req_code')
                                     ->where($where_project)
                                     ->distinct('req_code')                               
                                     ->get(['request.req_code', 'request.req_desc']);
    	return $query;
    }
}
