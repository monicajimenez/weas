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

    public function getDepartment($user_id)
    {
        $department = $this->select('department.dept_name')
                            ->where(['approver.app_code' => $user_id])
                            ->join('department', 'department.dept_code', '=', 'approver.dept_code')
                            ->first();
                            
        return $department;
    }

    public function getApprover()
    {
        $approvers = $this->get(['app_code', 'app_fname', 'app_lname', 'app_position']);

        return $approvers;
    }
}
