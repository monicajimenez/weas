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

    	if(!$recipients)
    	{
    		return false;
    	}

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
		$recipients = DB::select( 
									DB::raw("EXEC usp_get_email_recipients '"
													.$user_id
													."','".$request_details->rfc_code
													."','".$request_details->approver_level
													."','".$approver_response
													."';") 
								);

		if(isset($recipients[0]->flag_no_approver))
		{
			return null;
		}

    	return $recipients;
    }

    //
    public function isFinalApprover($rfc_code, $user_id)
    {
    	$recipients = DB::select( 
									DB::raw("EXEC usp_is_final_approver '"
													.$user_id
													."','".$rfc_code
													."';") 
								);

		if(is_null($recipients) || !$recipients)
		{	
    		return true;
		}

		return false;
    }
}
