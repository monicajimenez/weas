<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

//additional includes
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'approver';
    protected $primaryKey = 'app_code';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = ['firstname', 'lastname', 'department'];*/

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['department', 'remember_token'];


    public function getAuthPassword() 
    {
        return $this->app_password;
    }

    /**
     * Returns the department of user
     * @param $user_id - (required)
     *
     * @return department
     */
    public function getDepartment($user_id)
    {
        $department = $this->where(['approver.app_code' => $user_id])
                           ->join('department', 'department.dept_code', '=', 'approver.dept_code')
                           ->first(['department.dept_name','department.dept_code','department.dept_initial']);
                            
        return $department;
    }

    /**
     * Returns list of approvers
     *
     * @return approvers
     */
    public function getApprover()
    {
        $approvers = $this->get(['app_code', 'app_fname', 'app_lname', 'app_position']);
 
        return $approvers;
    }

    /**
     * Returns all team members of the department the user belongs
     * @param $user_id = (required)
     *
     * @return approvers
     */
    public function getCoTeamMembers($user_id = '')
    {
        $department = $this -> getDepartment($user_id);
        $co_team_members = $this->where(['dept_code' => $department->dept_code])
                         ->get(['app_code', 'app_fname', 'app_lname', 'app_position']);

        return $co_team_members;
    }
}
