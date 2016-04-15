<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';
    protected $primaryKey = 'dept_code';
    public $timestamps = false;

    /**
     * Get all departments
     * @return Response
     */
    public function getDepartments()
    {
        //Get query's result
        $departments = $this->get(['dept_code', 'dept_name','dept_initial']);

    	return $departments;
    }
}
