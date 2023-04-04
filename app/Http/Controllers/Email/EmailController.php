<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use \App\Mail\SendMail;

class EmailController extends Controller
{
    public function SendProjectInitiaterEmail($initiaterId, $projectName, $projectCode)
    {

        $employee = Employee::where('id', $initiaterId)->first();
        $toMail = $employee->email;
        $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;

        $ccMail = "dhanaraj7927@gmail.com";
        $title = "New Project assigned to Initiator";

        $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($title, $name, $projectName, $projectCode));


        return true;
    }
}
