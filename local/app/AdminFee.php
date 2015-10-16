<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// additional includes
use Datetime;
use DB;

class AdminFee extends Model
{
    protected $table = 'adminfee';
    protected $primaryKey = 'admin_code';
    public $timestamps = false;

    public function addAdminFee($admin_flag= '', $amount = '',$remarks = '',$request_id = '',$user_id = '')
    {
        try {
            $this->admin_remarks = $remarks;
            $this->admin_fee = $amount;
            $this->admin_date = new DateTime('today');
            $this->admin_flag = $admin_flag;
            $this->app_code = $user_id;
            $this->rfc_code = $request_id;

            $this->save();

            if($this->admin_code)
            {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
