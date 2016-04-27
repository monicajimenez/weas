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
    	$projects =  DB::select( 
                                    DB::raw("EXEC usp_get_projects '"
                                                    .$user_id
                                                    ."','".$request_type
                                                    ."';") 
                                );
    	return $projects;
    }
}
