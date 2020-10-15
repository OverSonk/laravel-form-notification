<?php

namespace App\Http\Controllers;

use App\Models\Notification\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use App\Traits\Upload;

class NotificationController extends Controller
{
    use Upload;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);
        $urlFile = '';
        $fileName = '';
        if( $request->hasFile('file') ) {
            $file  = $this->file($request->file('file'), 'files');
            $urlFile = $file['url'];
            $fileName = $file['name'];
        }

        $response = Notification::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subject' => $request->subject,
            'file' => $urlFile,
            'file_name' => $fileName
        ]);

        Mail::to([$response->email, env('MAIL_FROM_ADDRESS', 'example@example.com')])->send(new NotificationMail($response, $request->file('file')));

        return response()->json($response);
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'name' => "required|max:255",
            'phone' => "required|numeric",
            'email' => "required|email",
            'subject' => "required|max:255",
            'file' => 'required',
            'file.*' => 'mimes: pdf, doc, docx, xls, xlsx, png, jpg, jpeg|required'
        ]);
    }

}
