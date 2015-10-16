<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additional includes
use DB;

class EASRequest extends Model
{
    protected $table = 'rfc';
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
    public function getRequest($user_id = '', $request_status = '', $search = '')
    {
        if (!$request_status && !$user_id)
        {
            return $requests->error = 'Invalid Parameters';

        }
        
        // Initialization
        $requests = '';
        $queryRequestStatuses =  ['pending', 'on-hold', 'reset', 'incoming', 'approved', 'denied', 'cancelled'];
        $queryColumns = ['rfc_code', 'rfc_name', 'project_no', 'lot_no', 'rfc_scheme', 'rfc_stat','rfc_DOR', 'rfc_alertdate'];
        $paginationLenght = 10;

        //Retrive App Codes
        $requestIDs = DB::table('rfc_line')->where('app_code', '=', $user_id)->lists('rfc_code');

        //Retrieve Request Details
        if($request_status != 'all' && $request_status != 'Unsigned')
        {
            if($search)
            {
                $requests = $this->where(['rfc.rfc_stat' => $request_status])
                                ->whereIn('rfc_code', $requestIDs)
                                ->where(function($query) use ($search){
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
                $requests = $this->where(['rfc.rfc_stat' => $request_status])
                                ->whereIn('rfc_code', $requestIDs)
                                ->paginate($paginationLenght, $queryColumns);
                                
            }
        }
        else if($request_status == 'Unsigned')
        {

            $requestIDs = DB::select(
                            (
                                ";WITH LIST(list_rfc_code, list_previousStatus, list_app_code, list_level, list_stat)
                                AS
                                (
                                    SELECT l.rfc_code, LAG(l.rfcline_stat) OVER(ORDER BY l.rfc_code, l.rfcline_level) previousStatus,
                                    l.app_code, l.rfcline_level, l.rfcline_stat
                                    FROM
                                    rfc_line AS l
                                    INNER JOIN rfc AS r
                                    ON r.rfc_code = l.rfc_code
                                    WHERE r.rfc_stat = 'pending'
                                    AND l.rfc_code IN
                                    (
                                        SELECT rfc_code 
                                        FROM rfc_line
                                        WHERE rfc_line.app_code = '$user_id'
                                    )
                                )

                                SELECT r.rfc_code
                                FROM LIST
                                INNER JOIN rfc as r
                                ON r.rfc_code = list.list_rfc_code
                                WHERE list.list_app_code = '$user_id'
                                AND list.list_previousStatus = 'Signed'
                                AND list.list_stat = 'Pending';"
                            )
                        );

            if($search)
            {
                $requests = $this->whereIn('rfc_code', array_fetch($requestIDs, 'rfc_code'))
                                ->where(function($query) use ($search){
                                    $query->orWhere('rfc_code', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_name', 'LIKE', '%'.$search.'%')
                                        ->orWhere('project_no', 'LIKE', '%'.$search.'%')
                                        ->orWhere('lot_no', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_scheme', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_stat', 'LIKE', '%'.$search.'%');
                                })
                                ->paginate($paginationLenght,  
                                            ['rfc.rfc_code', 'rfc.rfc_name', 'rfc.project_no', 'rfc.lot_no', 'rfc.rfc_scheme',
                                             'rfc.rfc_stat','rfc.rfc_DOR', 'rfc.rfc_alertdate']
                                            ); 
            }
            else
            {
                $requests = $this->whereIn('rfc_code', array_fetch($requestIDs, 'rfc_code'))
                                ->paginate($paginationLenght,  
                                                ['rfc.rfc_code', 'rfc.rfc_name', 'rfc.project_no', 'rfc.lot_no', 'rfc.rfc_scheme',
                                                 'rfc.rfc_stat','rfc.rfc_DOR', 'rfc.rfc_alertdate']
                                          ); 
            }
        }
        else
        {
            if($search)
            {
                 $requests = $this->whereIn('rfc_code', $requestIDs)
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
                $requests = $this->whereIn('rfc_code', $requestIDs)
                                ->whereRaw( 'rfc_stat IN (?,?,?,?,?,?,?)', $queryRequestStatuses)
                                ->paginate($paginationLenght, $queryColumns);
            }   
        }

        //Set pagination path
        if ($request_status == 'Unsigned')
        {
            $requests->setPath(route('dashboard'));
        }
        else
        {
            $requests->setPath(route('request.index', ['requestStatus' => $request_status]));
        }

        return $requests;
    }

    /**
     * Retrieves the information of a request
     *
     * @return Response
     */
    public function getRequestDetails($requestID = '', $user_id)
    {
        $details = $this->where(['rfc.rfc_code' => $requestID])
                        ->join('request', 'request.req_code', '=', 'rfc.req_code')
                        ->first();
        $details->bank = $this->where(['rfc.rfc_code' => $requestID])
                                ->join('bank','bank.bank_code','=','rfc.bank_code')
                                ->whereNotNull('rfc.bank_code')
                                ->first();
        $details->approvers = $this->select('approver.app_fname', 'approver.app_lname', 'approver.app_position', 'approver.app_code',
                                    'rfc_line.rfcline_stat', 'rfc_line.rfcline_level', 'rfc_line.rfcline_remarks','closing.close_desc')
                                    ->where(['rfc.rfc_code' => $requestID])
                                    ->join('rfc_line', 'rfc_line.rfc_code', '=', 'rfc.rfc_code')
                                    ->join('approver', 'approver.app_code', '=', 'rfc_line.app_code')
                                    ->join('closing', 'closing.close_code', '=', 'rfc_line.close_code')
                                    ->orderBy('rfc_line.rfcline_level')
                                    ->get();
        $details->user_approver = $this->select('rfc_line.rfcline_stat', 'rfc_line.rfcline_level', 'rfc_line.rfcline_remarks','rfc_line.close_code')
                                    ->where(['rfc_line.rfc_code' => $requestID, 'rfc_line.app_code' => $user_id])
                                    ->join('rfc_line', 'rfc_line.rfc_code', '=', 'rfc.rfc_code')
                                    ->first();
        $details->attachments = DB::table('attachment')->where('attachment.rfc_code','=',$requestID)
                                    ->where(function($query){
                                        $query->orWhere('attachment.att_delete', '!=', '1')
                                            ->orWhereNull('attachment.att_delete');
                                    })
                                    ->get(['attachment.att_file','attachment.att_name','app_code','att_code']);

        if(str_contains($requestID,'RFC') == '1')
        {
            $details->admin_fees = DB::table('adminfee')->where(['rfc_code' => $requestID])->get();

        }

        return $details;
    }

    /**
     * Updates the status of a request
     * depending on the approver's response
     * (deny, on-hold, approved, etc)
     * @return Response
     */
    public function updateRequest($requestID,$approverResponse, $user_id, $remarks='')
    {
        //Update rfc_line table to reflect the user's specific response
        DB::table('rfc_line')->where(['rfc_code' => $requestID, 'app_code' => $user_id])->update(['rfcline_stat' => $approverResponse, 'rfcline_remarks' => $remarks]);
        
        //Initialization of need variables in order to update rfc table
        $approvers_level = DB::table('rfc_line')->where(['rfc_code' => $requestID, 'app_code' => $user_id])->first(['rfcline_level']);
        $max_level = DB::table('rfc_line')->where(['rfc_code' => $requestID])->max('rfcline_level');

        if($max_level == $approvers_level->rfcline_level)
        {
            if($approverResponse == 'Signed')
            {
                $approverResponse = 'Approved';
            }   

            $this->where(['rfc_code' => $requestID])->update(['rfc_stat' => $approverResponse]);    
        }
    }

    /**
     * Gets requests statistics 
     * (Total number of requests, pending requests, 
     * approved requests, and denied requests)
     * @return Response
     */
    public function getRequestStatistics($user_id = '')
    {
        //Retrive Request IDs
        $requestIDs = DB::table('rfc_line')->where('app_code', '=', $user_id)->lists('rfc_code');

        //Get total number of requests per type
        $statistics = $this->select(DB::raw('rfc_stat, count(*) as total'))
                                ->whereIn('rfc_code', $requestIDs)
                                ->groupBy('rfc_stat')
                                ->get();


        $unsigned_requests = $this->select(DB::raw('count(*) as total'))
                                ->whereIn('rfc_code', $requestIDs)  
                                ->get();
                                
        return $statistics;
    }

    public function getUnsignedRequestStatistics($user_id = '')
    {

        $statistics = DB::select(
                    (
                        ";WITH LIST(list_rfc_code, list_previousStatus, list_app_code, list_level, list_stat)
                        AS
                        (
                            SELECT l.rfc_code, LAG(l.rfcline_stat) OVER(ORDER BY l.rfc_code, l.rfcline_level) previousStatus,
                            l.app_code, l.rfcline_level, l.rfcline_stat
                            FROM
                            rfc_line AS l
                            INNER JOIN rfc AS r
                            ON r.rfc_code = l.rfc_code
                            WHERE r.rfc_stat = 'pending'
                            AND l.rfc_code IN
                            (
                                SELECT rfc_code 
                                FROM rfc_line
                                WHERE rfc_line.app_code = '$user_id'
                            )
                        )

                        SELECT count(r.rfc_code) as total
                        FROM LIST
                        INNER JOIN rfc as r
                        ON r.rfc_code = list.list_rfc_code
                        WHERE list.list_app_code = '$user_id'
                        AND list.list_previousStatus = 'Signed'
                        AND list.list_stat = 'Pending';"
                    )
                );
                
        return $statistics[0];
    }
 
}
