Route::get('send/mail', function(){

    Mail::send('email.pending_approval', ['key' => 'key-dd47546e8b2ede8ea3758195aa9976a7'], function($message)
    {
        $headers = $message->getHeaders();
        $headers->addTextHeader('MIME-Version', '1.0 \r\n');
        $headers->addTextHeader('Content-type', 'text/html; charset=iso-8859-1\r\n');

        $message->to('gregoreen.zerna@aboitiz.com', 'Gregoreen Zerna')->subject('Test Email for WEB EAS');
    });
});

Route::get('debug', function(){
    dd(Auth()->user());
});

Route::get('send/mail', function(){

    Mail::send('email.pending_approval', [], function($message)
    {
        $headers = $message->getHeaders();
        $headers->addTextHeader('MIME-Version', '1.0 \r\n');
        $headers->addTextHeader('Content-type', 'text/html; charset=iso-8859-1\r\n');

        $message->to('maria.monica.jimenez@aboitiz.com', 'Maria Monica I. Jimenez')->subject('Pending Request for your Approval');
    });
});



/*TEST*/
Route::get('userdetails', function(){
    dd(Auth()->user());
});

Route::get('send/mail', function(){

    Mail::send('email.pending_approval', [], function($message)
    {
        $headers = $message->getHeaders();
        $headers->addTextHeader('MIME-Version', '1.0 \r\n');
        $headers->addTextHeader('Content-type', 'text/html; charset=iso-8859-1\r\n');
        
        $message->to('maria.monica.jimenez@aboitiz.com', 'Maria Monica I. Jimenez')->subject('Pending Request for your Approval');
    });
});

Route::get('test/requesttypeapprover/{request_type}/{project_type}', [
    'as' => 'test_default_approvers',
    'uses' => 'RequestTypeApproverController@getRequestApproverTest' 
]);
/*END: TEST*/



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RequestTypeApprover;
use Response;

class RequestTypeApproverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Retrieves the default approvers of a certain request type.
     * @param none, accepts json request
     * @return \Illuminate\Http\Response
     */
    public function getRequestApprover(Request $request)
    {
        //Initialization
        $filing_type = $request['filing_type'];
        $project_code = $request['project_type'];
        $RequestTypeApprover = new RequestTypeApprover;

        //Retrieve default approvers
        $request_approvers = $RequestTypeApprover->getRequestApprover($filing_type, $project_code);

        return Response::json($request_approvers);
    }   

    public function getRequestApproverTest($request_type, $project_type)
    {
        //Initialization
        $RequestTypeApprover = new RequestTypeApprover;

        $request_approvers = $RequestTypeApprover->getRequestApprover($request_type, $project_type);

        return Response::json($request_approvers);
    }
}
