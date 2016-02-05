<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//additional includes
use App\Http\Controllers\EmailController;
use App\Project;
use App\RequestTypeApprover;
use App\EASRequest;
use App\Email;
use App\RequestType;
use Validator;
use Input;
use Auth;
use Form;
use Redirect;
use Response;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param String request_status
     * @param Request inputs
     * @return Response
     */
    public function index( $request_status = '', Request $inputs )
    {   
        // Initialization 
        $EASRequest = new EASRequest;
        $data = [];
        $data['request_status'] = $request_status;
        $data['request_status_label'] = '';
        $data['request_table_status_column'] = 0;
        $data['search'] = $inputs->search;

        //Retrieval of Requests
        $data['requests'] = $EASRequest->getRequest( '' , $data['request_status'], $data['search']);

        //Retrieve requests count
        $data['total'] = $EASRequest->getRequestStatistics('', $data['request_status']);

        //Check if with error then redirect back if any.
        if(!$data['requests'])
        {
            return Redirect::back()->withErrors(['Page not found.']);
        }

        // Format Data
        if( $data['request_status'] == 'all' )
        {
            $data['request_status_label'] = 'All Requests';
            $data['request_table_status_column'] = 1;
        }
        else
        {
            $data['request_status_label'] = studly_case($data['request_status'] . '&nbsp;Requests'); 
        }

        // Generate View
        if( ($data['request_status'] == 'pending') || ($data['request_status'] == 'incoming') ||
            ($data['request_status'] == 'denied') || ($data['request_status'] == 'approved')  ||
            ($data['request_status'] == 'on-hold') || ($data['request_status'] == 'reset')  ||
            ($data['request_status'] == 'all') )
        {
            return view('request.list', $data);
        }
        else
        {
            return Redirect::back()->withErrors(['Page not found.']); 
        } 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($filing_type = '')
    {
        //Initialization
        $projects = new Project;    
        $EASRequest = new EASRequest;
        $RequestType = new RequestType;
        $RequestTypeApprover = new RequestTypeApprover;
        $data['filing_type'] = $filing_type;
        $user_id = trim(Auth::user()->app_code);

        //Retrieve user granted projects
        $data['projects'] = $projects->getProjects($user_id, $filing_type, '3');

        //Additional variables per request type, if any.
        if($filing_type == 'RFR')
        {
            $data['granted_request_types'] = $RequestTypeApprover->getUserGrantedRequestTypes($user_id);
        }

        return view('request.file', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //Initialization
        $EASRequest = new EASRequest;
        $Email = new Email;
        $user_id = trim(Auth::user()->app_code);

        //Checking data passed
        if($request->filing_type == 'RFC')
        {
            $validator = Validator::make($request->all(), [
                'lot_code' => 'required',
                'date_reserved' => 'required',
                'model_type' => 'required',
                'lot_area' => 'required',
                'floor_area' => 'required',
                'owners_name' => 'required',
                'payment_scheme' => 'required',
                'approvers' => 'required',
                'close_codes' => 'required',
                'date_filed' => 'required',
                'project_type' => 'required',
            ]);
        }
        else if($request->filing_type == 'QAC')
        {
            $validator = Validator::make($request->all(), [
                'date_filed' => 'required',
                'lot_code' => 'required',
                'date_reserved' => 'required',
                'model_type' => 'required',
                'lot_area' => 'required',
                'floor_area' => 'required',
                'owners_name' => 'required',
                'payment_scheme' => 'required',
                'contract_amount' => 'required',
                'approvers' => 'required',
                'close_codes' => 'required',
                'remarks' => 'required',
            ]);
        }
        else if($request->filing_type == 'RFR')
        {
            if($request->nature_reopening['0'] == 'Code-001')
            {
                $validator = Validator::make($request->all(), [
                    'nature_reopening' => 'required',
                    'date_filed' => 'required',
                    'project_type' => 'required',
                    'lot_code' => 'required',
                    'date_reserved' => 'required',
                    'model_type' => 'required',
                    'lot_area' => 'required',
                    'floor_area' => 'required',
                    'owners_name' => 'required',
                    'reasons' => 'required',
                    'approvers' => 'required',
                    'close_codes' => 'required',
                    'first_reminder' => 'required',
                    'second_reminder' => 'required',
                    'notice_of_forfeiture' => 'required',
                    'number_of_amortization_paid' => 'required',
                    'remarks' => 'required',
                ]);
            }
            else if($request->nature_reopening['0'] == 'Code-002')
            {
                $validator = Validator::make($request->all(), [
                    'nature_reopening' => 'required',
                    'date_filed' => 'required',
                    'rfc_ref_no' => 'required',
                    'lot_code' => 'required',
                    'date_reserved' => 'required',
                    'model_type' => 'required',
                    'lot_area' => 'required',
                    'floor_area' => 'required',
                    'owners_name' => 'required',
                    'reasons' => 'required',
                    'approvers' => 'required',
                    'close_codes' => 'required',
                    'remarks' => 'required',
                ]);

            }
        }

        //Redirect back if with errors
        if ($validator->fails()) 
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        //Save request
        $request_id = $EASRequest->saveRequest($request->all(), $user_id);

        //Get updated details
        $data = [];
        $data['details'] = $EASRequest->getRequestDetails($request_id, $user_id);

        //Email Appropriate recipients
        $mail = new EmailController;
        $mail->send($data['details'], 'Signed');

        return Redirect::back()->withErrors(['Request saved.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $request_id
     * @return Response
     */
    public function show($request_id ='')
    {
        if($request_id)
        {
            $EASRequest = new EASRequest;
            $user_id = trim(Auth::user()->app_code);
            $data = [];
            $data['details'] = $EASRequest->getRequestDetails($request_id, $user_id);
            $data['signed'] = 0;
            $precedingLevel = $data['details']['user_approver']['rfcline_level']-1;
            $data['authorize_to_sign'] = 0;
            $data['filing_type'] = substr($data['details']['rfc_code'], 0, 3);

            foreach( $data['details']->approvers as $approver)
            {   
                if(trim($approver->app_code) == $user_id && 
                    (trim($approver->rfcline_stat) == 'Signed' || trim($approver->rfcline_stat) == 'Denied') )
                {

                    $data['signed'] = 1;
                }
                if( $approver->rfcline_level == $precedingLevel &&
                    (trim($approver->rfcline_stat) == 'Signed' || trim($approver->rfcline_stat) == 'Denied') )
                {
                    $data['authorize_to_sign'] = 1;
                }
            }

            return view('request.details', $data);
        }
        else
        {
            return Redirect::back()->withErrors(['Page not found.']); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $request_id (required)
     * @param $filing_type (required) values 'RFC', 'RFR' and 'QAC'
     * @param $action_type values 'edit' -> for viewing an empty or filled form, 'update' -> for viewing newly saved request form
     * @return Response
     */
    public function edit($request_id, $filing_type, $action_type = 'edit')
    {
        if($request_id)
        {   
            $EASRequest = new EASRequest;
            $projects = new Project;
            $user_id = trim(Auth::user()->app_code);
            $data = [];
            $data['filing_type'] = $filing_type;
            $data['details'] = $EASRequest->getRequestDetails($request_id, $user_id);
            $data['signed'] = 0;
            $precedingLevel = $data['details']['user_approver']['rfcline_level']-1;
            $data['uneditable_fields'] = [];

            //Retrieve user granted projects
            $data['projects'] = $projects->getProjects($user_id, $data['filing_type'], '3');

            //Additional variables per request type, if any.
            if($data['filing_type'] == 'RFR')
            {
                $RequestTypeApprover = new RequestTypeApprover;
                $data['granted_request_types'] = $RequestTypeApprover->getUserGrantedRequestTypes($user_id);

                if($data['details']['re_nature'] == 'Forfeiture')
                {
                    $data['rfr_type'] = 'forfeiture';
                    $data['uneditable_fields']['rfc_ref_no'] = '1';
                }
                else
                {
                    $data['rfr_type'] = 'rfc';
                    $request_description = explode('-', $data['details']['re_nature']);
                    $data['default_req_reference'] = $data['details']['rfc_refno'] . ' : ' . $request_description[1];
                    $data['uneditable_fields']['project_type'] = '1';
                    $data['uneditable_fields']['lot_code'] = '1';
                }

            }
            else if($data['filing_type'] == 'RFC')
            {
                $RequestType = new RequestType; 
                $data['req_refs'] =  $RequestType->getRequestType( 'RFC');
            }
            
            if($action_type == 'update')
            {
                return view('request.edit', $data)->withErrors(['Request saved.']);
            }
            
            return view('request.edit', $data);   
        }
        
        return Redirect::back()->withErrors(['Page not found.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        //Initialize input properties
        if($request->filing_type == 'RFC')
        {
            $validator = Validator::make($request->all(), [
                        'approver_response' => 'required',
                        'notes' => 'required', 
                        //In RFC, no remarks field is needed because the notes fields acts both as notes and remarks
                    ]);         
        }
        else if($request->filing_type == 'RFR' || $request->filing_type == 'QAC')
        {
            $validator = Validator::make($request->all(), [
                        'approver_response' => 'required',
                        'remarks' => 'required',
                    ]);
        }

        //Redirect back if with input errors
        if ($validator->fails()) 
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        //Initialization
        $approver_response = $request->approver_response;   
        $EASRequest = new EASRequest;
        $user_id = trim(Auth::user()->app_code);

        if($approver_response == 'Denied' || $approver_response == 'Signed' || $approver_response == 'On-Hold')
        {
            //Update the request
            $EASRequest->respondRequest($request->request_code, $approver_response, $user_id, trim($request->remarks));

            //Get updated details
            $data = [];
            $data['details'] = $EASRequest->getRequestDetails($request->request_code, $user_id);

            //Email Appropriate recipients
            $mail = new EmailController;
            $mail->send($data['details'], $approver_response); 

            return $this->show(trim($data['details']['rfc_code']));
        }
        else if($approver_response == 'Edit')
        {
            //Update the request
            $EASRequest->updateRequest($request->request_code, $user_id, $request->all(), $request->filing_type);

            //Get updated details
            $data = [];
            $data['details'] = $EASRequest->getRequestDetails($request->request_code, $user_id);

            //Email Appropriate recipients
            $mail = new EmailController;
            $mail->send($data['details'], $approver_response);

            return $this->edit( trim($data['details']['rfc_code']), $request->filing_type, 'update');
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getRFCRequestRefence(Request $request)
    {   
        //Initialization
        $request_code = $request['request_code'];
        $project_no = $request['project_no'];
        $EASRequest = new EASRequest;

        return Response::json($EASRequest->getRFCRef($request_code, $project_no));
    }

    public function testgetRFCRequestRefence($request_code, $project_no)
    {   
        //Initialization
        $EASRequest = new EASRequest;

        return Response::json($EASRequest->getRFCRef($request_code, $project_no));
    }
}
