<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additional includes
use DB;
use Mail;

class Email extends Model
{
	//
    public function sendMail($request_details, $approver_response, $user_id)
    {
    	//Get recipients
    	$recipients = $this->getRecipients( $request_details, $approver_response, $user_id);

    	//Check if the request is approved by all
    	if($this->isFinalApprover($request_details->rfc_code, $user_id))
    	{
    		$request_details['status'] = 'completed';
    	}
    	else
    	{
    		$request_details['status'] = $approver_response;
    	}

    	//Set email subject
    	if($request_details['status'] == 'completed')
    	{
			$subject = $request_details->rfc_code.': Request Signed by all Users';
    	}
		else if($request_details['status'] == 'Signed')
		{
			$subject = $request_details->rfc_code.': Pending Request for your Approval';
		}
		else if($request_details['status'] == 'On-Hold')
		{
			$subject = $request_details->rfc_code.': Request On-Hold';
		}
		else if($request_details['status'] == 'Denied')
		{
			$subject = $request_details->rfc_code.': Request Denied';
		}
		else if($request_details['status'] == 'Reset')
		{
			$subject = $request_details->rfc_code.': Request Reset by Administrator';
		}
		else if($request_details['status'] == 'Filed')
		{
			$subject = $request_details->rfc_code.': Request received by System';
		}
		else if($request_details['status'] == 'Edit')
		{
			$subject = $request_details->rfc_code.': Request Edited by Filer';
		}
		
		//Extract Email and Approver's Name into separate arrays
		foreach( $recipients as $recipient)
		{
			$recipientsEmail[] = $recipient->app_email;
			$recipientsName[] =  $recipient->app_fname.' '.$recipient->app_lname;
		}
		
		//Send Email
    	Mail::send('email.request_alert', $request_details->toArray(), function($message) use($subject, $recipientsEmail, $recipientsName)
	    {
	        $headers = $message->getHeaders();
	        $message->to($recipientsEmail, $recipientsName)
	        		->subject($subject);
	    });

	    return true;
    }

    //
    public function getRecipients( $request_details, $approver_response, $user_id)
    {
    	//For all other statuses except 'Signed'
    	if( $approver_response != 'Signed')
    	{
    		
    		foreach( $request_details->approvers as $approver)
    		{
    			$recipients[] =  $approver->app_code;
    		}

    		$recipients = DB::table('approver')->whereIn('app_code', $recipients)->get(['app_email','app_fname', 'app_lname']);
    	}
    	//For Signed requests
    	else if( $approver_response == 'Signed')
    	{
    		$recipients = DB::select(
                    (
                        ";WITH APP(rfc_code, nextApprover, currentApprover, nextStatus)
						AS
						(
						    SELECT l.rfc_code, LEAD(l.app_code) OVER(ORDER BY l.rfc_code, l.rfcline_level) nextApprover,
							l.app_code AS currentApprover, LEAD(l.rfcline_stat) OVER(ORDER BY l.rfc_code, l.rfcline_level) nextStatus
						    FROM
						    rfc_line AS l
						    WHERE l.rfc_code = '$request_details->rfc_code'
						)

						SELECT nextApprover
						FROM APP
						WHERE currentApprover = '$user_id'
						AND nextStatus = 'Pending';"
                    )
                );

    		//Check if the approver is the final approver, if so email all.
    		if(is_null($recipients) || !$recipients)
    		{	
	    		foreach( $request_details->approvers as $approver)
	    		{
	    			$recipients[] =  $approver->app_code;
	    		}

	    		$recipients = DB::table('approver')->whereIn('app_code', $recipients)->get(['app_email','app_fname', 'app_lname']);
    		}
    		else
    		{
    			$recipients = DB::table('approver')->where('app_code', $recipients[0]->nextApprover)->get(['app_email','app_fname', 'app_lname']);
    		}
    	}

    	return $recipients;
    }

    public function isFinalApprover($rfc_code, $user_id)
    {
    	$recipients = DB::select(
                    (
                        ";WITH APP(rfc_code, nextApprover, currentApprover, nextStatus)
						AS
						(
						    SELECT l.rfc_code, LEAD(l.app_code) OVER(ORDER BY l.rfc_code, l.rfcline_level) nextApprover,
							l.app_code AS currentApprover, LEAD(l.rfcline_stat) OVER(ORDER BY l.rfc_code, l.rfcline_level) nextStatus
						    FROM
						    rfc_line AS l
						    WHERE l.rfc_code = '$rfc_code'
						)

						SELECT nextApprover
						FROM APP
						WHERE currentApprover = '$user_id'
						AND nextStatus = 'Pending';"
                    )
                );

		if(is_null($recipients) || !$recipients)
		{	
    		return true;
		}

		return false;
    }
}
