<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//additional includes
use Input;

class Attachment extends Model
{
    protected $table = 'dbo.attachment';
    protected $primaryKey = 'att_code';
    public $timestamps = false;

    
    /**
     * Retrieves the given attachement
     *
     * @return Response
     */
    public function uploadAttachment($request_id = '', $user_id = '')
    {
        $attachment_storage = '/app/Attachment/'.$request_id.'/';
        $attachment = Input::file('upload_attachment');

        $attachment->move( base_path().$attachment_storage , $attachment->getClientOriginalName());
    
        $this->insert(
           ['att_name' => $attachment->getClientOriginalName(),
            'att_location' => $attachment_storage,
            'rfc_code' => $request_id,
            'atype_code' => intval(Input::get('attachment_type')),
            'app_code' => $user_id,
            ]
        );
    }

    /**
     * Retrieves the given attachment
     *
     * @return Response
     */
    public function getAttachment($attachment_code = '')
    {
    	$attachment = $this->where('att_code', $attachment_code)->first();
        $mime = $this->getMimeType($attachment->att_name);  

        if($attachment->att_file)
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$attachment->att_name.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            return hex2bin($attachment->att_file); 
        }
        else
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$attachment->att_name.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize(base_path().$attachment->att_location.$attachment->att_name));

            return readfile(base_path().$attachment->att_location.$attachment->att_name);
        }
        
    }

    public function showAttachment($attachment_code = '')
    {
        $attachment = $this->where('att_code', $attachment_code)->first();
        $mime = $this->getMimeType($attachment->att_name);   

        if($attachment->att_file)
        {
            header("Content-length:" . strlen($attachment->att_file));
            header('Content-disposition: inline');
            header('Content-type:'.$mime);

            echo hex2bin($attachment->att_file); 
        }
        else
        {
            header('Content-disposition: inline');
            header('Content-type:'.$mime);
            
            return readfile(base_path().$attachment->att_location.$attachment->att_name);
        }
    }

    /**
     * Provides the mime type of a given filename
     *
     * @return Response
     */
    public function getMimeType($filename='')
    {
            $mime_types = array(
                    "pdf"=>"application/pdf"
                    ,"exe"=>"application/octet-stream"
                    ,"zip"=>"application/zip"
                    ,"docx"=>"application/msword"
                    ,"doc"=>"application/msword"
                    ,"xls"=>"application/vnd.ms-excel"
                    ,"ppt"=>"application/vnd.ms-powerpoint"
                    ,"gif"=>"image/gif"
                    ,"png"=>"image/png"
                    ,"jpeg"=>"image/jpg"
                    ,"jpg"=>"image/jpg"
                    ,"mp3"=>"audio/mpeg"
                    ,"wav"=>"audio/x-wav"
                    ,"mpeg"=>"video/mpeg"
                    ,"mpg"=>"video/mpeg"
                    ,"mpe"=>"video/mpeg"
                    ,"mov"=>"video/quicktime"
                    ,"avi"=>"video/x-msvideo"
                    ,"3gp"=>"video/3gpp"
                    ,"css"=>"text/css"
                    ,"jsc"=>"application/javascript"
                    ,"js"=>"application/javascript"
                    ,"php"=>"text/html"
                    ,"htm"=>"text/html"
                    ,"html"=>"text/html"
            );
            return $mime_types[strtolower(pathinfo($filename, PATHINFO_EXTENSION))];
    }

    /**
     * Soft Deletes the given attachement
     *
     * @return Response
     */
    public function deleteAttachment($attachment_code = '')
    {
        $this->where(['att_code' => $attachment_code])->update(['att_delete' => 1]);
    }

}
