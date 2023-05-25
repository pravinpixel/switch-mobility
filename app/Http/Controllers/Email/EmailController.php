<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectController;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use \App\Mail\SendMail;
use App\Models\Designation;
use App\Models\Project;
use App\Models\ProjectEmployee;

class EmailController extends Controller
{

    protected $projectController;
    public function __construct(ProjectController $projectController) {
        $this->projectController = $projectController;
    }
    public function statusChange($projectId,$level)
    {
       dd($projectId);
        $projectData = $this->projectController->getProjectDetailsByPrimaryId($projectId);

        dd($projectData);
        $defaultMailers = config('app.BCCmail');
    }
    public function SendProjectInitiaterEmail($type,$initiaterId,$projectId, $projectName, $projectCode)
    {

        $employee = Employee::where('id', $initiaterId)->first();
        $toMail = $employee->email;
        $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;

        $ccMail = "dhanaraj7927@gmail.com";
        $title = "New Project assigned to Initiator";

        $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));


        return true;
    }
    public function SendStatusChangeEmail($projectId, $approverId, $level, $status)
    {
        
        $projectModel = Project::where('id', $projectId)->first();
        $initiaterId = $projectModel->initiator_id;
       
        $projectName = $projectModel->project_name;
        $projectCode = $projectModel->project_code;

       
        if ($status == 2) {
            $cStatus = "Declined";
        } else if ($status == 3) {
            $cStatus = "Change Request";
        } else if ($status == 4) {
            $cStatus = "Approved";
        } else {
            $cStatus = "Waiting For Approval";
        }
        $ccMail = $this->getEmployeeemail($projectId);



        $ApproverEmployee = Employee::with('designation')->where('id', $approverId)->first();
        $approvername = $ApproverEmployee->first_name . "" . $ApproverEmployee->middle_name . " " . $ApproverEmployee->last_name;
        $approverCode = $ApproverEmployee->sap_id;
        $designation = $ApproverEmployee['designation'];
        $designationName = $designation->name;

        $employee = Employee::where('id', $initiaterId)->first();
        $toMail = $employee->email;
        $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;

        $title = "Change Status Project";
        $approverData = $approvername . "(" . $approverCode . ")" . "(" . $designationName . ")";

        $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail(2, $title, $name, $projectId,$projectName, $projectCode,$level, $cStatus,  $approverData,''));
        return true;
    }
    public function SendApprovedStatusChangeEmail($projectId, $approverId, $level, $status)
    {
        
        $projectModel = Project::where('id', $projectId)->first();
        $initiaterId = $projectModel->initiator_id;
       
        $projectName = $projectModel->project_name;
        $projectCode = $projectModel->project_code;

       
        if ($status == 2) {
            $cStatus = "Declined";
        } else if ($status == 3) {
            $cStatus = "Change Request";
        } else if ($status == 4) {
            $cStatus = "Approved";
        } else {
            $cStatus = "Waiting For Approval";
        }
        $ccMail = $this->getEmployeeemail($projectId);



        $ApproverEmployee = Employee::with('designation')->where('id', $approverId)->first();
        $approvername = $ApproverEmployee->first_name . "" . $ApproverEmployee->middle_name . " " . $ApproverEmployee->last_name;
        $approverCode = $ApproverEmployee->sap_id;
        $designation = $ApproverEmployee['designation'];
        $designationName = $designation->name;

        $employee = Employee::where('id', $initiaterId)->first();
        $toMail = $employee->email;
        $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;

        $title = "Final Approved document generated notification";
        $approverData = $approvername . "(" . $approverCode . ")" . "(" . $designationName . ")";

        $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail(3, $title, $name,$projectId,$projectName, $projectCode,$level, $cStatus,  $approverData,''));
        return true;
    }
    public function getEmployeeemail($projectId)
    {
        $models = ProjectEmployee::with('employee')->where('project_id', $projectId)->groupBy('employee_id')->get();
        $emailArray = ['dhanaraj7927@gmail.com'];
        foreach ($models as $model) {
            $employee = $model['employee'];
            $email = $employee->email;

            $emailArray[] = $email;
        }
        return $emailArray;
    }
}
