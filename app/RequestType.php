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
     * @param $user_id - (required)
     * @return Response
     */
    public function getRequestType($request_type = '', $project_type='all', $user_id = '')
    {
    	if($request_type == 'QAC' || $request_type == 'RFR' || $request_type == 'PR')
    	{
    		$query = $this->where(['request.req_group' => $request_type]);
    	}
    	else if( $request_type == 'RFC' )
    	{
    		$query = $this->whereNotIn('request.req_group', ['PR', 'QAC', 'RFR']);
    	}

        if($project_type != 'all')
        {
            $query->join('request_line', 'request_line.req_code', '=', 'request.req_code')
                  ->distinct('req_code')
                  ->where(['request_line.project_no' => $project_type, 'request_line.app_code' => $user_id]);
        }

        //Get query's result
        $request_types = $query->get(['request.req_code', 'request.req_desc']);
        
    	return $request_types;
    }
}
