<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additional includes
use DB;

class EASRequest extends Model
{
    protected $table = 'dbo.rfc';
    protected $primaryKey = 'rfc_code';
    public $timestamps = false;

    public function requestType()
    {
        return $this->hasOne('App\RequestType', 'req_code');

    }

    /**
     * Retrieves a list of requests
     *
     * @return Response
     */
    public function getRequest($userID = '', $requestStatus = '', $search = '')
    {
        if (!$requestStatus && !$userID)
        {
            return $requests->error = 'Invalid Parameters';

        }
        
        // Initialization
        $requests = '';
        $queryRequestStatuses =  ['pending', 'on-hold', 'reset', 'incoming', 'approved', 'denied', 'cancelled'];
        $queryColumns = ['rfc_code', 'rfc_name', 'project_no', 'lot_no', 'rfc_scheme', 'rfc_stat','rfc_DOR', 'rfc_alertdate'];
        $paginationLenght = 10;

        //Retrive App Codes
        $requestIDs = DB::table('rfc_line')->where('app_code', '=', $userID)->lists('rfc_code');

        //Retrieve Request Details
        if($requestStatus != 'all')
        {
            if($search)
            {
                $requests = $this->where(['rfc.rfc_stat' => $requestStatus])
                                ->whereIn('rfc_code', $requestIDs)
                                ->Where(function($query) use ($search){
                                    $query->orWhere('rfc_code', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_name', 'LIKE', '%'.$search.'%')
                                        ->orWhere('project_no', 'LIKE', '%'.$search.'%')
                                        ->orWhere('lot_no', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_scheme', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_stat', 'LIKE', '%'.$search.'%');
                                })
                                ->paginate($paginationLenght, $queryColumns); 
            } 
            else
            {
                $requests = $this->where(['rfc.rfc_stat' => $requestStatus])->whereIn('rfc_code', $requestIDs)->paginate($paginationLenght);
                                
            }
        }
        else
        {
            if($search)
            {
                 $requests = $this->where(['app_code' => $userID])
                                ->whereIn('rfc_code', $requestIDs)
                                ->Where(function($query) use ($search){
                                    $query->orWhere('rfc_code', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_name', 'LIKE', '%'.$search.'%')
                                        ->orWhere('project_no', 'LIKE', '%'.$search.'%')
                                        ->orWhere('lot_no', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_scheme', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_stat', 'LIKE', '%'.$search.'%');
                                })->paginate($paginationLenght, $queryColumns); 
            }   
            else
            {
                $requests = $this->where( 'app_code', '=', $userID)
                                ->whereIn('rfc_code', $requestIDs)
                                ->whereRaw( 'rfc_stat IN (?,?,?,?,?,?,?)', $queryRequestStatuses)
                                ->paginate($paginationLenght, $queryColumns);
            }   
        }

        //Set pagination path
        $requests->setPath(route('request.index', ['requestStatus' => $requestStatus]));

        return $requests;
    }

    /**
     * Retrieves the information of a request
     *
     * @return Response
     */
    public function getRequestDetails($requestID = '')
    {
        $details = $this->where(['rfc.rfc_code' => $requestID])->first();
        $details->bank = $this->where(['rfc.rfc_code' => $requestID])
                                ->join('bank','bank.bank_code','=','rfc.bank_code')
                                ->whereNotNull('rfc.bank_code')
                                ->first();
        $details->approvers = $this->select('approver.app_fname', 'approver.app_lname', 'approver.app_position', 'approver.app_code',
                                    'rfc_line.rfcline_stat', 'rfc_line.rfcline_level', 'rfc_line.rfcline_remarks','rfc_line.close_code')
                                    ->where(['rfc.rfc_code' => $requestID])
                                    ->join('rfc_line', 'rfc_line.rfc_code', '=', 'rfc.rfc_code')
                                    ->join('approver', 'approver.app_code', '=', 'rfc_line.app_code')
                                    ->orderBy('rfc_line.rfcline_level', 'asc')
                                    ->get();
        $details->user_approver = $this->select('rfc_line.rfcline_stat', 'rfc_line.rfcline_level', 'rfc_line.rfcline_remarks','rfc_line.close_code')
                                    ->where(['rfc.rfc_code' => $requestID, 'rfc_line.app_code' => session('user_id')])
                                    ->join('rfc_line', 'rfc_line.rfc_code', '=', 'rfc.rfc_code')
                                    ->first();
        $details->attachments = DB::table('attachment')->where('attachment.rfc_code','=',$requestID)->get(['attachment.att_file','attachment.att_name','app_code','att_code']);

        return $details;
    }

    /**
     * Retrieves the information of a request
     *
     * @return Response
     */
    public function updateRequest($requestID,$approverResponse, $user_id, $remarks='')
    {
        DB::table('rfc_line')->where(['rfc_code' => $requestID, 'app_code' => $user_id])->update(['rfcline_stat' => $approverResponse, 'rfcline_remarks' => $remarks]);
        $approvers_level = DB::table('rfc_line')->where(['rfc_code' => $requestID, 'app_code' => $user_id])->first(['rfcline_level']);
        $max_level = DB::table('rfc_line')->where(['rfc_code' => $requestID])->max('rfcline_level');

        if($max_level == $approvers_level)
        {
            if($approverResponse == 'Signed')
            {
                $approverResponse = 'Approved';
            }   

            $this->where(['rfc_code' => $requestID])->update(['rfc_stat' => $approverResponse]);    
        }
        
    }
 
}
