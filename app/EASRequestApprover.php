<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class EASRequestApprover extends Model
{
    protected $table = 'rfc_line';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Saves approvers of new request
     *
     * @param $request_type_code - (required) DB Column 'req_code'
     * @param $request_code - (required) DB Column 'rfc_code'
     * @param $approvers - (required) an array containing the approvers
     * @param $close_codes - (required) corresponding close codes of approvers
     * @param $filer_remarks - (required) 
     * @param $user_id - (required) user id of user
     * @param $buyers_documents - required when filing for RFC Request.
     * @param $buyers_other_documents - required when filing for RFC Request
     * @return Response
     */
    public function saveRequestApprovers($request_type_code, $request_code, $approvers, $close_codes, 
                                         $filer_remarks, $user_id, $buyers_documents = [], $buyers_other_documents = '')
    {
        $approversSize = count($approvers);
        $data = [];
        
        //Delete any existing approvers in case if filer edited a request
        $this->deleteRequestApprovers($request_code);

        //Save the filer as the first approver
        $filer = DB::table('request_line')->where('app_code', '=', $user_id)
                                          ->where('req_code', '=', $request_type_code)
                                          ->get(['app_code','close_code']);
                                        
        $data[0] = [
                    'app_code' => $filer[0]->app_code,
                    'close_code' => $filer[0]->close_code,
                    'rfcline_level' => 1,
                    'rfc_code' => $request_code,
                    'req_code' => $request_type_code,
                    'rfcline_stat' => 'Pending',
                    'rfcline_remarks' => $filer_remarks
                ];

        //Documents with buyer that needs to be cancelled, true to RFCs only
        if(isset($buyers_documents['a']))
        {
            $data[0] += ['rfcline_A' => 'y'];
        }
        if(isset($buyers_documents['b']))
        {
            $data[0] += ['rfcline_B' => 'y'];
        }
        if(isset($buyers_documents['c']))
        {
            $data[0] += ['rfcline_C' => 'y'];
        }
        if(isset($buyers_documents['d']))
        {
            $data[0] += ['rfcline_D' => 'y'];
        }
        if(isset($buyers_documents['others']))
        {
            $data[0] += ['rfcline_Others' => trim($buyers_other_documents)];
        }

        $this->insert($data[0]);

        //Save the rest of the approvers
        for($index = 0; $index < $approversSize ; $index++)
        {
            $data[$index+1] = [
                'app_code' => $approvers[$index],
                'close_code' => $close_codes[$index],
                'rfcline_level' => $index+2,
                'rfc_code' => $request_code,
                'req_code' => $request_type_code,
                'rfcline_stat' => 'Pending',
                'rfcline_remarks' => ''
            ];

            $this->insert($data[$index+1]);
        }

        return true;
    }
    
    /**
     * Deletes the approvers of new request (hard delete)
     *
     * @param $request_code - (required) DB Column 'rfc_code'
     * @return Response
     */
    public function deleteRequestApprovers($request_code)
    {
        $approvers = $this->where([ 'rfc_code' => $request_code])->delete();
    }
}
