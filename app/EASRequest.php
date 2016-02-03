<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additional includes
use App\Project;
use DB;
use App\EASRequestApprover;

class EASRequest extends Model
{
    protected $table = 'rfc';
    protected $primaryKey = 'rfc_code';
    public $timestamps = false;

    public function requestType()
    {
        return $this->hasOne('App\RequestType', 'req_code');

    }

    //Overriden function
    protected function insertAndSetId( \Illuminate\Database\Eloquent\Builder $query, $attributes)
    {
        $id = $query->insertGetId($attributes, $keyName = $this->getKeyName());
    }

    /**
     * Retrieves a list of requests
     *
     * @param user_id - not empty when request that needs to be retrieve is that of the user only.
     * @param request_status - (required) may be 'all' (used for filing requests and retrieving the RFC reference) 
     *                      or that of a specific request ('Unsigned', 'Pending', 'Approved').
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
            $pending_requests = $this->getUnsignedRequest($user_id, $search, 'Pending');
            $onhold_requests = $this->getUnsignedRequest($user_id, $search, 'On-Hold');
            $filed_requests = $this->getUnsignedFiledRequest($user_id);

            $pending_requests = $pending_requests->paginate($paginationLenght,  
                                            ['rfc.rfc_code', 'rfc.rfc_name', 'rfc.project_no', 'rfc.lot_no', 'rfc.rfc_scheme',
                                             'rfc.rfc_stat','rfc.rfc_DOR', 'rfc.rfc_alertdate'], 'pending_request_page'
                                      );

            $onhold_requests = $onhold_requests->paginate($paginationLenght,  
                                                    ['rfc.rfc_code', 'rfc.rfc_name', 'rfc.project_no', 
                                                     'rfc.lot_no', 'rfc.rfc_scheme', 'rfc.rfc_stat',
                                                     'rfc.rfc_DOR', 'rfc.rfc_alertdate'], 
                                                    'onhold_request_page'
                                                    );

            $filed_requests = $filed_requests->paginate($paginationLenght,  
                                                      ['rfc.rfc_code', 'rfc.project_no', 'rfc.lot_no', 
                                                       'rfc.rfc_scheme', 'rfc.rfc_DOR', 'rfc.rfc_alertdate'],
                                                       'filed_request_page'
                                                      );

            $requests['pending_requests'] = $pending_requests;
            $requests['onhold_requests'] = $onhold_requests;
            $requests['filed_requests'] = $filed_requests;

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
            $pending_requests->setPath(route('dashboard'));
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
     * @param $status - (required) Values: 'Pending', 'On-Hold'
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
                                    'rfc_line.rfcline_stat', 'rfc_line.rfcline_level', 'rfc_line.rfcline_remarks','closing.close_desc',
                                    'closing.close_code')
                                    ->where(['rfc.rfc_code' => $request_id])
                                    ->join('rfc_line', 'rfc_line.rfc_code', '=', 'rfc.rfc_code')
                                    ->join('approver', 'approver.app_code', '=', 'rfc_line.app_code')
                                    ->join('closing', 'closing.close_code', '=', 'rfc_line.close_code')
                                    ->orderBy('rfc_line.rfcline_level')
                                    ->get();
        $details->user_approver = $this->select('rfc_line.rfcline_stat', 'rfc_line.rfcline_level', 'rfc_line.rfcline_remarks','rfc_line.close_code',
                                                'rfc_line.rfcline_A', 'rfc_line.rfcline_B', 'rfc_line.rfcline_C', 'rfc_line.rfcline_D', 'rfc_line.rfcline_Others')
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
    public function respondRequest($request_id, $approver_response, $user_id, $remarks='')
    {
        //Update rfc_line table to reflect the user's specific response
        DB::table('rfc_line')->where(['rfc_code' => $request_id, 'app_code' => $user_id])->update(['rfcline_stat' => $approver_response, 'rfcline_remarks' => $remarks]);
        
        //Initialization of needed variables in order to update rfc table
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
     * Updates the request depending on the changes made
     *
     * @param $request_id - (required)
     * @param $user_id (required)
     * @param $data - (required) 
     * @param $request_type - (required) Values: 'RFR', 'RFC' or 'QAC'
     * @return Response
     */
    public function updateRequest($request_id, $user_id, $data, $request_type)
    {
        $EASRequestApprover = new EASRequestApprover;

        //Get value of remarks from user input
        if($request_type == 'RFC')
        {
            //In RFC, no remarks field is needed because the notes fields acts both as notes and remarks
            $remarks = $data['notes'];
        }
        else if($request_type == 'RFR' || $request_type == 'QAC')
        {
            $remarks = $data['remarks'];
        }

        //Update rfc_line table to reflect the user new response
        DB::table('rfc_line')->where(['rfc_code' => $request_id, 'app_code' => $user_id])->update(['rfcline_remarks' => $remarks]);
        
        //Update actual request with new values
        $user = $this->find($request_id);

        //Get request code depending on the request type except for RFCs
        //Assign the corresponding request_code depending on what is filed
        if( $request_type == 'QAC')
        {
            $user->req_code ='Req-021';
            $user->rfc_scheme = $data['payment_scheme'];
            $user->rfc_contamt = (float)str_replace(',','',$data['contract_amount']);
        }
        else if( $request_type == 'RFR')
        {
            $user->re_reasons = $data['reasons'];

            if( $data['nature_of_reopening'] == 'forfeiture')
            {
                $user->re_nature = 'Forfeiture';
                $user->re_first = date('m/d/Y', strtotime($data['first_reminder']));
                $user->re_second = date('m/d/Y', strtotime($data['second_reminder']));
                $user->re_notice = date('m/d/Y', strtotime($data['notice_of_forfeiture']));
                $user->re_amort = $data['number_of_amortization_paid'];
                /*must have Due Date and Date Received*/
            }
            else
            {
                $nature_and_req_code  = explode(':', $data['rfc_ref_no']);
                $user->rfc_refno = $nature_and_req_code[0]; 
                $user->re_nature = 'RFC - ' . $nature_and_req_code[1];
            }
        }
        else if( $request_type == 'RFC')
        {
            $user->rfc_from = $data['from'];
            $user->rfc_to = $data['to'];
            $user->rfc_scheme = $data['payment_scheme'];
            $user->rfc_note = $remarks;
        }

        $user->project_no = $data['project_type'];
        $user->rfc_model = $data['model_type'];
        $user->lot_no = $data['lot_code'];
        $user->rfc_landarea = $data['lot_area']; /*to check*/
        $user->rfc_floorarea = $data['floor_area'];
        $user->rfc_name = $data['owners_name']; /*to check*/
        $user->sales_date = date('Y-m-d', strtotime($data['date_reserved']));

        //Save request
        $user->save();

        //Save approver
        if( $data['filing_type'] == 'RFC')
        {
            $EASRequestApprover->saveRequestApprovers($user->req_code, $request_id, $data['approvers'], 
                                                    $data['close_codes'], $remarks, $data['attachment_type'],
                                                    $data['other_attachment']);
        }
        else
        {
            $EASRequestApprover->saveRequestApprovers($user->req_code, $request_id, $data['approvers'], 
                                                    $data['close_codes'], $remarks);
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

    /**
     * Gets the RFC Reference number for filing an RFR
     * under Request for Change option
     *
     * @param $request_code - (required) the specific type of request
     *                        (ex: Req-001, Req-002, etc)
     * @return Response
     */
     public function getRFCRef( $request_code, $project_no)
     {  
        return $this->where(['req_code' => $request_code, 'project_no' => $project_no])
                    ->get(['rfc_code', 'rfc_name', 'lot_no']);
     } 

    /**
     * Saves a new request
     *
     * @param $data - (required) Form data
     * @param $user_id - (required) id of user
     * @return Response
     */
    public function saveRequest($data, $user_id)
    {  
        $EASRequestApprover = new EASRequestApprover;
        $latest_request_code = $this->where('rfc_code', 'LIKE', $data['filing_type'].'%')->orderBy('rfc_DOR', 'desc')->orderBy('rfc_code','desc')->first(['rfc_code']);
        $latest_request_code = explode('-', $latest_request_code->rfc_code);

        //Get request code depending on the request type except for RFCs
        //Assign the corresponding request_code depending on what is filed
        if( $data['filing_type'] == 'QAC')
        {
            $this->rfc_code = 'QAC-' . (string)((int)trim($latest_request_code['1']) + 1);
            $this->req_code ='Req-021';
            $this->rfc_scheme = $data['payment_scheme'];
            $this->rfc_contamt = (float)str_replace(',','',$data['contract_amount']);
            $remarks = $data['remarks'];

        }
        else if( $data['filing_type'] == 'RFR')
        {
            $this->rfc_code = 'RFR-' . (string)((int)trim($latest_request_code['1']) + 1);
            $this->req_code ='Req-014';
            $this->re_reasons = $data['reasons'];
            $remarks = $data['remarks'];

            if( $data['nature_reopening']['0'] == 'Code-001')
            {
                $this->re_nature = 'Forfeiture';
                $this->re_first = date('m/d/Y', strtotime($data['first_reminder']));
                $this->re_second = date('m/d/Y', strtotime($data['second_reminder']));
                $this->re_notice = date('m/d/Y', strtotime($data['notice_of_forfeiture']));
                $this->re_amort = $data['number_of_amortization_paid'];
                $this->re_nature = 'Forfeiture';
            }
            else if( $data['nature_reopening']['0'] == 'Code-002')
            {
                $nature_and_req_code  = explode(':', $data['rfc_ref_no']);
                $this->rfc_refno = $nature_and_req_code[0]; 
                $this->re_nature = 'RFC - ' . $nature_and_req_code[1];
            }
        }
        else if( $data['filing_type'] == 'RFC')
        {
            $this->rfc_code = 'RFC-' . (string)((int)trim($latest_request_code['1']) + 1);
            $request_code  = explode('+', $data['req_ref']);
            $this->req_code = $request_code['0'];
            $this->rfc_from = $data['from'];
            $this->rfc_to = $data['to'];
            $this->rfc_scheme = $data['payment_scheme'];
            $this->rfc_note = $data['req_note'];
            $remarks = $this->rfc_note;
        }

        $this->rfc_DOR =  date('Y-m-d h:i:s', strtotime($data['date_filed']));
        $this->project_no = $data['project_type'];
        $this->lot_no = $data['lot_code'];
        $this->rfc_model = $data['model_type'];
        $this->rfc_landarea = $data['lot_area']; /*to check*/
        $this->rfc_floorarea = $data['floor_area'];
        $this->rfc_name = $data['owners_name']; /*to check*/
        $this->app_code = $user_id;
        $this->rfc_stat= 'Pending';
        $this->sales_date = date('Y-m-d', strtotime($data['date_reserved']));

        //Save request
        $this->save();

        //Save approver
        if( $data['filing_type'] == 'RFC')
        {
            $EASRequestApprover->saveRequestApprovers($this->req_code, $this->rfc_code, $data['approvers'], 
                                                    $data['close_codes'], $remarks, $data['attachment_type'],
                                                    $data['other_attachment']);
        }
        else
        {
            $EASRequestApprover->saveRequestApprovers($this->req_code, $this->rfc_code, $data['approvers'], 
                                                    $data['close_codes'], $remarks);
        }

        return $this->rfc_code;
    }

        /*  this->business_id = $data['req_note'];
        $this->app_code = $data['req_note'];
        $this->rfc_stat = $data['req_note'];
        $this->sales_date = $data['req_note'];

        $this->nature = $data['req_note'];
        $this->duedate = $data['req_note'];
        $this->aprvdate = $data['req_note'];
        $this->refno = $data['req_note'];
        $this->contamt = $data['req_note'];
        $this->unittype = $data['req_note'];
        $this->turnover = $data['req_note'];
        $this->amount = $data['req_note'];
        $this->bank_code = $data['req_note'];
        $this->rfc_noa = $data['req_note'];
        $this->con_code = $data['req_note'];
        $this->aprvdate = $data['req_note'];
        $this->rfc_alertdate = $data['req_note'];

        $this->first = $data['req_note'];
        $this->second = $data['req_note'];
        $this->notice = $data['req_note'];
        $this->amort = $data['req_note'];*/

    /**
     * Saves a new request
     *
     * @param $user_id - (required) id of user
     * @return Response
     */
    public function getUnsignedFiledRequest($user_id)
    {
        $paginationLenght = 10;

        $filed_request = $this->where(['rfc.app_code' => $user_id, 
                                       'rfc.rfc_stat' => 'Pending',
                                       'rfc_line.rfcline_level' => '2', 
                                       'rfc_line.rfcline_stat' => 'Pending'])
                              ->join('rfc_line', 'rfc_line.rfc_code', '=', 'rfc.rfc_code');

        return $filed_request;
    }
}
