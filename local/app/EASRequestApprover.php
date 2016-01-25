<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     * @param $buyers_documents - required when filing for RFC Request.
     * @param $buyers_other_documents - required when filing for RFC Request
     * @return Response
     */
    public function saveRequestApprovers($request_type_code, $request_code, $approvers, $close_codes, 
                                         $filer_remarks, $buyers_documents = [], $buyers_other_documents = '')
    {
        $approversSize = count($approvers);
        $data = [];
        
        //Delete any existing approvers in case if filer edited a request
        $this->deleteRequestApprovers($request_code);

        for($index = 0; $index < $approversSize ; $index++)
        {
            if($index != 0)
            {
                $data[$index] = [
                    'app_code' => $approvers[$index],
                    'close_code' => $close_codes[$index],
                    'rfcline_level' => $index+1,
                    'rfc_code' => $request_code,
                    'req_code' => $request_type_code,
                    'rfcline_stat' => 'Pending',
                    'rfcline_remarks' => ''
                ];
            }
            else
            {
                $data[$index] = [
                    'app_code' => $approvers[$index],
                    'close_code' => $close_codes[$index],
                    'rfcline_level' => $index+1,
                    'rfc_code' => $request_code,
                    'req_code' => $request_type_code,
                    'rfcline_stat' => 'Signed',
                    'rfcline_remarks' => $filer_remarks
                ];

                //Documents with buyer that needs to be cancelled
                if(isset($buyers_documents['a']))
                {
                    $data[$index] += ['rfcline_A' => 'y'];
                }
                if(isset($buyers_documents['b']))
                {
                    $data[$index] += ['rfcline_B' => 'y'];
                }
                if(isset($buyers_documents['c']))
                {
                    $data[$index] += ['rfcline_C' => 'y'];
                }
                if(isset($buyers_documents['d']))
                {
                    $data[$index] += ['rfcline_D' => 'y'];
                }
                if(isset($buyers_documents['others']))
                {
                    $data[$index] += ['rfcline_Others' => trim($buyers_other_documents)];
                }
            }

            $this->insert($data[$index]);
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
