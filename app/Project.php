<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additional includes
use App\RequestType;
use DB;

class Project extends Model
{
	protected $table = 'project';
    protected $primaryKey = 'proj_no';
    public $timestamps = false;

    /**
     * Gets all projects depending on the rights of the user.
     *
     * @param $user_id - (required) id of user
     * @param $return_value - sets if the response should include project number only, project description only or both
     *						1 - project no only, 2 - project desc only, 3 - both
     * @param $request_type - (required) The type of request.
     *						  Values: 'QAC', 'RFC', 'RFR'
     * @return Response
     */
    public function getProjects($user_id = '', $request_type = '', $return_value = '3')
    {	
    	//Initialization
    	$query_columns = ['project.project_no','project.project_desc'];
    	$RequestType = new RequestType;

    	//Set the needed columns 
    	if($return_value == '1')
    	{
    		$query_columns = ['project.project_no'];
    	}
    	else if($return_value == '2')
    	{
    		$query_columns = ['project.project_desc'];
    	}

    	//Retrieve request code from request type
    	$request_codes = $RequestType->getRequestType($request_type);

    	//Retrieve projects
        $projects = $this->join('request_line', 'request_line.project_no', '=', 'project.project_no')
    					->where(['request_line.app_code' => $user_id, 'request_line.app_code' => $user_id] )
    					->whereIn('request_line.req_code', $request_codes)
    					->orderBy('project_no')
    					->distinct('project_no')
    					->get($query_columns);
                        
    	return $projects;
    }
}
