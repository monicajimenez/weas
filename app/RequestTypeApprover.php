<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class RequestTypeApprover extends Model
{
    protected $table = 'request_line';
    protected $primaryKey = 'req_code';
    public $timestamps = false;

    /**
     * Retrieves the default approver of a certain request and project
     *
     * @param $project_code - (required) Project Code
     * @param $request_type_code - required when filing request is of type 'RFR' and QAC
     * @return Response
     */
    public function getRequestApprover($project_code = '', $request_type_code = '')
    {
        return    DB::select(     
                                    DB::raw("EXEC usp_get_default_request_approvers '"
                                                    .$project_code
                                                    ."','".$request_type_code
                                                    ."';") 
                                );
    }

    /**
     * Retrieves the request types that the user is granted rights with
     *
     * @param $user_id - (required)
     * @param $request_type - required if you would like to get only specific requests. Values: 'RFR','RFC','QAC','PR'
     * @return Response
     */
    public function getUserGrantedRequestTypes($user_id,$request_type='')
    {
        $request_types =    DB::select( 
                                    DB::raw("EXEC get_user_granted_rfr_request_types '"
                                                    .$user_id
                                                    ."','".$request_type
                                                    ."';") 
                                );
        
        return $request_types;
    }
}
