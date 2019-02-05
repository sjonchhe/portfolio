<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Mail\SendMail;
use Session;

class MailController extends Controller
{
    
public function send()
{
	Mail::send(new SendMail());
	/*notificationMsg('success','Email sent Successfully'); */
	Session::flash('success','Email Sent Successfully');
	return back();
}

}
