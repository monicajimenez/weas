<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//additional includes
use App\Attachment;
use Redirect;
use Auth;

class AttachmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Downloads the given resource
     *
     * @return Response
     */
    
    public function download($attachment_code = '')
    {
        if ($attachment_code)
        {
            $attachment = new Attachment;
            echo $attachment->getAttachment($attachment_code);
        }
        else
        {
            return Redirect::back()->withErrors(['Attachment code not indicated.']);   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($attachment_code = '')
    {
        if($attachment_code)
        {
            $attachment = new Attachment;
            $attachment->deleteAttachment($attachment_code);
            
            return Redirect::back()->withErrors(['Attachment deleted.']);    
        }
        else{
            return Redirect::back()->withErrors(['Attachment code not indicated.']);  
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function upload(Request $request)
    {
        if($request->upload_attachment)
        {
            $attachment = new Attachment;
            $attachment->uploadAttachment($request->request_id, trim(Auth::user()->app_code));
            
            return Redirect::back()->withErrors(['Attachment uploaded.']);    
        }

        return Redirect::back()->withErrors(['No file attached.']);     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if($id)
        {
            $attachment = new Attachment;
            $attachment->showAttachment($id);
        }
        
        return Redirect::back()->withErrors(['Attachment code not indicated.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        //
    }
}
