<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additonal includes


class RequestTypeApprover extends Model
{
    protected $table = 'request_line';
    protected $primaryKey = 'req_code';
    public $timestamps = false;

    /**
     * Retrieves the default approver of a ceratin request and project
     *
     * @param $request_code - (required) Request Code. Values: 'QAC', 'RFC', 'RFR'
     * @param $project_code - (required) Project Code.
     * @param $house_code - House Code
     * @return Response
     */
    public function getRequestApprover( $filing_type = '', $project_code = '', $house_code = '')
    {	
    	//Get request code depending on the request type

    	//Assign the corresponding request_code depending on what is filed
        if( $filing_type == 'QAC')
        {
            $request_code = 'Req-021';
        }
        else if( $filing_type == 'RFR')
        {
            $request_code = 'Req-014';
        }
        //Retrieve default approvers
        //Main query
        $query = $this->join('approver', 'approver.app_code', '=', 'request_line.app_code')
    				  ->join('closing', 'closing.close_code', '=', 'request_line.close_code')
    				  ->where('request_line.project_no', '=', $project_code)
    				  ->where('request_line.app_level', '!=', '1');

    	//Check if request type is RFC, if so, exclude QAC and RFR (and all other non-rfc request) in the query
    	if( $filing_type == 'RFC')
    	{
    		$query->whereNotIn('request_line.req_code', ['Req-021', 'Req-014']);
    	}
    	else
    	{
    		$query->whereIn('request_line.req_code', [$request_code]);
    	}

    	//Check if house code provided, if so include in query
    	if(strlen($house_code) > 0)
    	{
    		$query->where( ['request_line.project_no' => $project_code, 'request_line.house_code' => $house_code]);
    	}

    	//Retrieve query result
    	$request_approvers = $query->orderBy('request_line.app_level')
    							   ->get(['approver.app_code', 'approver.app_lname', 'approver.app_fname', 
    									  'request_line.app_level', 'request_line.mandatory',
    									  'closing.close_desc']);

    	return $request_approvers;
    }
}
