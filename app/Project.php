<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additional includes
use App\RequestType;
use DB;

class Project extends Model
{
	protected $table = 'admin.project';
    protected $primaryKey = 'proj_no';
    public $timestamps = false;

    /**
     * Gets all projects
     *
     * @param $user_id - populate if needed to get projects that the users have right over
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

        var_dump($request_type);

    	//Retrieve projects
        $query = $this->join('request_line', 'request_line.project_no', '=', 'project.project_no')
                      ->join('request', 'request.req_code', '=', 'request_line.req_code')
    				  ->where(['request.req_group' => $request_type]);

        //If only projects where the user
        //have rights as filer, append query
        if($user_id)
        {
            $query->where(['request_line.app_code' => $user_id, 'request_line.app_level' => '1'] );
        }

        //Get query's result
        $projects = $query->orderBy('project.project_no')
                        ->distinct('project.project_no')
                        ->get($query_columns);
        
        dd($projects);
    	return $projects;
    }
}
