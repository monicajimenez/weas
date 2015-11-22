<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additional includes
use App\Project;
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
     * @param user_id - not empty when request that needs to be retrieve is that of the user only.
     * @param request_status - may be 'all' or that of a specific request.
     * @param search - not empty when user uses the search functionality in request list.
     * @return Response
     */
    public function getRequest($user_id = '', $request_status = '', $search = '')
    {
        // Check Validity of Params
        if (!$request_status)
        {
            return false;
        }

        // Initialization
        $requests = '';
        $queryColumns = ['rfc_code', 'rfc_name', 'project_no', 'lot_no', 'rfc_scheme', 'rfc_stat','rfc_DOR', 'rfc_alertdate'];
        $paginationLenght = 10;

        //Retrieve Request Details
        //Retrieve specific (pending,on-hold, etc) requests.
        if($request_status != 'all' && $request_status != 'Unsigned')
        {
            $data = $this->getSpecificRequestTypes($user_id,$request_status, $search);
            $requests = $data->paginate($paginationLenght, $queryColumns);
        }
        //Retrieve unsigned request by user
        else if($request_status == 'Unsigned')
        {
            $pendingData = $this->getUnsignedRequest($user_id, $search, 'Pending');
            $onHoldData = $this->getUnsignedRequest($user_id, $search, 'On-Hold');

            $pendingRequests = $pendingData->paginate($paginationLenght,  
                                            ['rfc.rfc_code', 'rfc.rfc_name', 'rfc.project_no', 'rfc.lot_no', 'rfc.rfc_scheme',
                                             'rfc.rfc_stat','rfc.rfc_DOR', 'rfc.rfc_alertdate'], 'pending_request_page'
                                      );

            $onHoldRequests = $onHoldData->paginate($paginationLenght,  
                                            ['rfc.rfc_code', 'rfc.rfc_name', 'rfc.project_no', 'rfc.lot_no', 'rfc.rfc_scheme',
                                             'rfc.rfc_stat','rfc.rfc_DOR', 'rfc.rfc_alertdate'], 'onhold_request_page'
                                      );

            $requests['pending_requests'] = $pendingRequests;
            $requests['onhold_requests'] = $onHoldRequests;
        }
        //Retrieve all requests
        else
        {
            $data = $this->getAllRequests($user_id, $search, $paginationLenght);
            $requests = $data->paginate($paginationLenght, $queryColumns);
        }

        //Set pagination path
        if ($request_status == 'Unsigned')
        {
            $pendingRequests->setPath(route('dashboard'));
        }
        else
        {
            $requests->setPath(route('request.index', ['requestStatus' => $request_status]));
        }

        return $requests;
    }

    /**
     * Retrieves a list of requests of the given request status
     *
     * @param $request_status - (required) status of request
     * @param $user_id - populate when you want to get user specific requests
     * @return Response
     */
    public function getSpecificRequestTypes($user_id = '', $request_status = '', $search = '')
    {
        //Retrieve user specific requests if per user_id is populated
        if($user_id)
        {
            $requestIDs = DB::table('rfc_line')->where('app_code', '=', $user_id)->lists('rfc_code');
        }

        //Retrieve specific requests basing on search keyword
        if($search)
        {
            //Retrieve specific requests containing the search keyword
            if(!$user_id)
            {
                $requests = $this->where(['rfc.rfc_stat' => $request_status])
                            ->where(function($query) use ($search){
                                $query->orWhere('rfc_code', 'LIKE', '%'.$search.'%')
                                    ->orWhere('rfc_name', 'LIKE', '%'.$search.'%')
                                    ->orWhere('project_no', 'LIKE', '%'.$search.'%')
                                    ->orWhere('lot_no', 'LIKE', '%'.$search.'%')
                                    ->orWhere('rfc_scheme', 'LIKE', '%'.$search.'%')
                                    ->orWhere('rfc_stat', 'LIKE', '%'.$search.'%');
                            });
            }
            //Retrieve specific, 'user assigned' requests containing the search keyword
            else
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
                            });
            }
            
        } 
        //Retrieve all specifc requests
        else
        {
            //Retrieve specific type of requests from all users
            if(!$user_id)
            {
                $requests = $this->where(['rfc.rfc_stat' => $request_status]);
            }
            //Retrieve specific type of requests from user
            else
            {
                $requests = $this->where(['rfc.rfc_stat' => $request_status])
                            ->whereIn('rfc_code', $requestIDs);
            }               
        }

        return $requests;
    }

    /**
     * Retrieves a list of unsigned user requests
     *
     * @param $user_id - (required) id of user
     * @return Response
     */
    public function getUnsignedRequest($user_id = '', $search = '', $status = '')
    {
        //Retrieve all request ids assigned to current user
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
                                AND list.list_stat = '$status';"
                            )
                        );

        //Retrieve all unsigned requests basing on the search keyword
        if($search)
        {
            $requests =  $this->whereIn('rfc_code', array_fetch($requestIDs, 'rfc_code'))
                            ->where(function($query) use ($search){
                                $query->orWhere('rfc_code', 'LIKE', '%'.$search.'%')
                                    ->orWhere('rfc_name', 'LIKE', '%'.$search.'%')
                                    ->orWhere('project_no', 'LIKE', '%'.$search.'%')
                                    ->orWhere('lot_no', 'LIKE', '%'.$search.'%')
                                    ->orWhere('rfc_scheme', 'LIKE', '%'.$search.'%')
                                    ->orWhere('rfc_stat', 'LIKE', '%'.$search.'%');
                            });
        }
        //Retrieve all unsigned requests
        else
        {
            $requests =  $this->whereIn('rfc_code', array_fetch($requestIDs, 'rfc_code'));
        }

        return $requests;
    }

    /**
     * Retrieves a list of all requests
     *
     * @param $user_id - populate when you want to get requests of current user only
     * @return Response
     */
    public function getAllRequests($user_id = '', $search = '')
    {
        //Retrieve user specific requests if user_id is populated
        if($user_id)
        {
            $requestIDs = DB::table('rfc_line')->where('app_code', '=', $user_id)->lists('rfc_code');
        }

        //Retrieve all types requests basing on search keyword
        if($search)
        {
            //Retrieve all types of requests from all users containing the search keyword
            if(!$user_id)
            {
                 $requests = $this->where(function($query) use ($search){
                                    $query->orWhere('rfc_code', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_name', 'LIKE', '%'.$search.'%')
                                        ->orWhere('project_no', 'LIKE', '%'.$search.'%')
                                        ->orWhere('lot_no', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_scheme', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_stat', 'LIKE', '%'.$search.'%');
                                }); 
            }
            //Retrieve all types of requests from current user containing the search keyword
            else
            {
                 $requests = $this->whereIn('rfc_code', $requestIDs)
                                ->Where(function($query) use ($search){
                                    $query->orWhere('rfc_code', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_name', 'LIKE', '%'.$search.'%')
                                        ->orWhere('project_no', 'LIKE', '%'.$search.'%')
                                        ->orWhere('lot_no', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_scheme', 'LIKE', '%'.$search.'%')
                                        ->orWhere('rfc_stat', 'LIKE', '%'.$search.'%');
                                }); 

            }
        }  
        //Retrieve all types requests
        else
        {
            $queryRequestStatuses =  ['pending', 'on-hold', 'reset', 'incoming', 'approved', 'denied', 'cancelled'];

            //Retrieve all types of requests from all users
            if(!$user_id)
            {
                $requests = $this->whereRaw( 'rfc_stat IN (?,?,?,?,?,?,?)', $queryRequestStatuses);
            }
            //Retrieve all types of requests from current users
            else
            {
                $requests = $this->whereIn('rfc_code', $requestIDs)
                                ->whereRaw( 'rfc_stat IN (?,?,?,?,?,?,?)', $queryRequestStatuses);
            }
        }

        return $requests;
    }

    /**
     * Retrieves the information of a request
     *
     * @param $request_id - (required) id of request
     * @param $user_id - (required) id of current user
     * @return Response
     */
    public function getRequestDetails($request_id = '', $user_id)
    {
        $details = $this->where(['rfc.rfc_code' => $request_id])
                        ->join('request', 'request.req_code', '=', 'rfc.req_code')
                        ->first();
        $details->bank = $this->where(['rfc.rfc_code' => $request_id])
                                ->join('bank','bank.bank_code','=','rfc.bank_code')
                                ->whereNotNull('rfc.bank_code')
                                ->first();
        $details->approvers = $this->select('approver.app_fname', 'approver.app_lname', 'approver.app_position', 'approver.app_code',
                                    'rfc_line.rfcline_stat', 'rfc_line.rfcline_level', 'rfc_line.rfcline_remarks','closing.close_desc')
                                    ->where(['rfc.rfc_code' => $request_id])
                                    ->join('rfc_line', 'rfc_line.rfc_code', '=', 'rfc.rfc_code')
                                    ->join('approver', 'approver.app_code', '=', 'rfc_line.app_code')
                                    ->join('closing', 'closing.close_code', '=', 'rfc_line.close_code')
                                    ->orderBy('rfc_line.rfcline_level')
                                    ->get();
        $details->user_approver = $this->select('rfc_line.rfcline_stat', 'rfc_line.rfcline_level', 'rfc_line.rfcline_remarks','rfc_line.close_code')
                                    ->where(['rfc_line.rfc_code' => $request_id, 'rfc_line.app_code' => $user_id])
                                    ->join('rfc_line', 'rfc_line.rfc_code', '=', 'rfc.rfc_code')
                                    ->first();
        $details->attachments = DB::table('attachment')->where('attachment.rfc_code','=',$request_id)
                                    ->where(function($query){
                                        $query->orWhere('attachment.att_delete', '!=', '1')
                                            ->orWhereNull('attachment.att_delete');
                                    })
                                    ->get(['attachment.att_file','attachment.att_name','app_code','att_code']);

        if(str_contains($request_id,'RFC') == '1')
        {
            $details->admin_fees = DB::table('adminfee')->where(['rfc_code' => $request_id])->get();

        }
        
        return $details;
    }

    /**
     * Updates the status of a request depending on the approver's response
     * (deny, on-hold, approved, etc)
     *
     * @param $request_id - (required)
     * @param $approver_response (required)
     * @param $user_id - (required)
     * @param $remarkds - (required) 
     * @return Response
     */
    public function updateRequest($request_id, $approver_response, $user_id, $remarks='')
    {
        //Update rfc_line table to reflect the user's specific response
        DB::table('rfc_line')->where(['rfc_code' => $request_id, 'app_code' => $user_id])->update(['rfcline_stat' => $approver_response, 'rfcline_remarks' => $remarks]);
        
        //Initialization of need variables in order to update rfc table
        $approvers_level = DB::table('rfc_line')->where(['rfc_code' => $request_id, 'app_code' => $user_id])->first(['rfcline_level']);
        $max_level = DB::table('rfc_line')->where(['rfc_code' => $request_id])->max('rfcline_level');

        if($max_level == $approvers_level->rfcline_level)
        {
            if($approver_response == 'Signed')
            {
                $approver_response = 'Approved';
            }   

            $this->where(['rfc_code' => $request_id])->update(['rfc_stat' => $approver_response]);    
        }
    }

    /**
     * Gets requests statistics of current user (Total number of requests, pending requests, 
     * approved requests, and denied requests)
     *
     * @param $user_id - (required) id of user
     * @param $request_status - populate when you want to get the total 
     *                      of that specific status. Otherwise, total of each statuses
     *                      in bulk will be provided.
     * @return Response
     */
    public function getRequestStatistics($user_id = '', $request_status = '')
    {
        //Retrieve all user assigned requests statistics in bulk
        if(!$request_status && $user_id)
        {
            //Retrive Request IDs
            $request_ids = DB::table('rfc_line')->where('app_code', '=', $user_id)->lists('rfc_code');

            //Get total number of requests per type
            $statistics = $this->select(DB::raw('rfc_stat, count(*) as total'))
                                    ->whereIn('rfc_code', $request_ids)
                                    ->groupBy('rfc_stat')
                                    ->get();
        }
        //Retrieve total number of a specific request type
        else
        {
            if($request_status != 'all')
            {
                $statistics = $this->select(DB::raw('count(*) as total'))
                                    ->where(['rfc_stat' => $request_status])
                                    ->groupBy('rfc_stat')
                                    ->get();  
                $statistics = $statistics[0]['total'];
            } 
            else
            {
                $statistics = $this->select(DB::raw('count(*) as total'))
                                    ->get();  
                $statistics = $statistics[0]['total'];
            }
        }
                
        return $statistics;
    }

    /**
     * Gets total count of unsigned requests of current user
     *
     * @param $user_id - (required) id of user
     * @return Response
     */
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
                        AND 
                        (   list.list_stat = 'Pending' OR
                            list.list_stat = 'On-Hold'
                        )"
                    )
                );
                
        return $statistics[0];
    }
}
