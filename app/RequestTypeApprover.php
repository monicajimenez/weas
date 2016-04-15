<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestTypeApprover extends Model
{
    protected $table = 'request_line';
    protected $primaryKey = 'req_code';
    public $timestamps = false;

    /**
     * Retrieves the default approver of a certain request and project
     *
     * @param $project_code - (required) Project Code.
     * @param $house_code - House Code
     * @param $request_type_code - required when filing request is of type 'RFR' and QAC
     * @param $user_id - (required)
     * @return Response
     */
    public function getRequestApprover($project_code = '', $house_code = '', $request_type_code, $user_id)
    {
        //Retrieve default approvers
        //Main query
        $query = $this->join('approver', 'approver.app_code', '=', 'request_line.app_code')
    				  ->join('closing', 'closing.close_code', '=', 'request_line.close_code')
    				  ->where('request_line.project_no', '=', $project_code)
    				  ->where('request_line.app_level', '!=', '1')
                      ->where('request_line.req_code', $request_type_code)
                      ->orWhere(function($query) use ($user_id, $project_code){
                            $query->where('request_line.app_code', '=', $user_id)
                                  ->where('request_line.app_level', '=', '1')
                                  ->where('request_line.project_no', '=', $project_code);
                      });

    	//Check if house code provided, if so include in query
    	if(strlen($house_code) > 0)
    	{
    		$query->where( ['request_line.project_no' => $project_code, 'request_line.house_code' => $house_code]);
    	}

    	//Retrieve query result
    	$request_approvers = $query->orderBy('request_line.app_level')
                                   ->distinct('app_code')
    							   ->get(['approver.app_code', 'approver.app_lname', 'approver.app_fname', 
    									  'approver.app_position', 'request_line.app_level', 'request_line.mandatory',
    									  'closing.close_desc', 'closing.close_code']);
                                   
    	return $request_approvers;
    }

    /**
     * Retrieves the request types that the user is granted rights with
     *
     * @param $user_id - (required)
     * @param $filing_type - required if you would like to get only specific requests. Values: 'RFR','RFC','QAC','PR'
     * @return Response
     */
    public function getUserGrantedRequestTypes($user_id,$filing_type='')
    {
        $query = $this->where('app_code', '=', $user_id)
                     ->where('app_level', '=', '1')
                     ->join('request', 'request.req_code', '=', 'request_line.req_code')
                     ->distinct('req_code','project_no');

        if($filing_type)
        {
            $query->where(['request_line.req_code'=>$filing_type]);
        }
         
        $query->get(['request_line.req_code', 'request.req_desc', 'request_line.project_no', 'request_line.close_code']);

        return $query;
    }
}
