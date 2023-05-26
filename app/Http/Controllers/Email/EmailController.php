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
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{


    public function statusChange($projectId, $level, $status)
    {
        if ($status == 4) {
            $type = "Approved";
        } elseif ($status == 3) {
            $type = "Change request";
        } else {
            $type = "Declined";
        }
        $projectData = $this->projectDetailByProjectId($projectId);

        $employeeModel = $projectData->employee;
        $toMail = $employeeModel->email;
        $name = $employeeModel->first_name . " " . $employeeModel->last_name;
        $bccMailIds = $this->BccMailLooping();
        $subject = $type . " Notification | " . $projectData->project_name . " - " . $projectData->project_code;
        $projectName = $projectData->project_name;
        $projectCode = $projectData->project_code;
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";
        $approverData = "admin";
        if ($empId) {
            $ApproverEmployee = Employee::with('designation')->where('id', $empId)->first();
            $approvername = $ApproverEmployee->first_name . "" . $ApproverEmployee->middle_name . " " . $ApproverEmployee->last_name;
            $approverCode = $ApproverEmployee->sap_id;
            $designation = $ApproverEmployee['designation'];
            $designationName = $designation->name;
            $approverData = $approvername . "(" . $approverCode . ")" . "(" . $designationName . ")";
        }

        try {
            $mail = Mail::to($toMail)->bcc($bccMailIds)->send(new SendMail("statusChange", $subject, $name, $projectId, $projectName, $projectCode, $level, $type, $approverData, ''));
            return true;
            // $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));
        } catch (Exception $e) {

            Log::info('email response New Project' . json_encode($e));
            return false;
        }
    }
    public function SendProjectInitiaterEmail($type, $initiaterId, $projectId, $projectName, $projectCode)
    {

        $employee = Employee::where('id', $initiaterId)->first();
        $toMail = $employee->email;
        $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;


        $bccMailIds = $this->BccMailLooping();
        $title = "New Project assigned to Initiator";


        try {
            $mail = Mail::to($toMail)->bcc($bccMailIds)->send(new SendMail($type, $title, $name, $projectId, $projectName, $projectCode, '', '', '', ''));
            return true;
            // $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));
        } catch (Exception $e) {

            Log::info('email response New Project' . json_encode($e));
            return false;
        }
    }
    public function NewApprovalToApprover($projectId, $level)
    {
        Log::info('Emailconroller > NewApprovalToApprover projectId ' . $projectId);
        Log::info('Emailconroller > NewApprovalToApprover level ' . $level);
        $approverDatas = $this->getApproverMailByProjectIdAndLevel($projectId, $level);
        $projectData = $this->projectDetailByProjectId($projectId);

        $bccMailIds = $this->BccMailLooping();
        $subject = "New Approval notification for Approval | " . $projectData->project_name . " - " . $projectData->project_code;

        $projectName = $projectData->project_name;
        $projectCode = $projectData->project_code;
        $projectNameAndCode = $projectData->project_name . " - " . $projectData->project_code;
        $approverModels = $this->getApproverMailByProjectIdAndLevel($projectId, $level);
        Log::info('Emailconroller > NewApprovalToApprover ' . json_encode($approverModels));
        foreach ($approverModels as $approverModel) {
            $employeeModel = $approverModel->employee;

            $name = $employeeModel->first_name . " " . $employeeModel->last_name;
            $response = ['name' => $name, 'email' => $employeeModel->email];
            Log::info('Emailconroller > NewApprovalToApprover reponse' . json_encode($response));
            try {
                $mail = Mail::to($employeeModel->email)->bcc($bccMailIds)->send(new SendMail("newApprovalMail", $subject, $name, $projectId, $projectName, $projectCode, '', '', '', ''));
                return true;
                // $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));
            } catch (Exception $e) {

                Log::info('email response New Project' . json_encode($e));
                return false;
            }
        }
    }

    public function getApproverMailByProjectIdAndLevel($projectId, $level)
    {
        Log::info('email getApproverMailByProjectIdAndLevel projectId ' . $projectId);
        Log::info('email getApproverMailByProjectIdAndLevel level ' . $level);
        $models =  ProjectEmployee::with('employee')->where('project_id', $projectId)->where('level', $level)->where('type', 2)->get();
        Log::info('getApproverMailByProjectIdAndLevelretun return' . json_encode($models));
        return $models;
    }

    public function finalApprovementProject($projectId)
    {

        $projectData = $this->projectDetailByProjectId($projectId);
        $employeeModel = $projectData->employee;
        $toMail = $employeeModel->email;
        $name = $employeeModel->first_name . " " . $employeeModel->last_name;

        $envbccMailIds = $this->BccMailLooping();
        $approverMails = $this->getEmployeeemail($projectId);        
       
        $BccMailIds =array_unique(array_merge($envbccMailIds,$approverMails), SORT_REGULAR);
     
        $projectName = $projectData->project_name;
        $projectCode = $projectData->project_code;
        $projectNameAndCode = $projectData->project_name . " - " . $projectData->project_code;
        $subject = "Final Approved document generated notification | " . $projectNameAndCode;

      
        try {
            $mail = Mail::to($employeeModel->email)->bcc($BccMailIds)->send(new SendMail("finalApprovalMail", $subject, $name, $projectId, $projectName, $projectCode, '', '', '', ''));
            return true;
            // $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));
        } catch (Exception $e) {

            Log::info('email response New Project' . json_encode($e));
            return false;
        }
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

        $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail(2, $title, $name, $projectId, $projectName, $projectCode, $level, $cStatus,  $approverData, ''));
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

        $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail(3, $title, $name, $projectId, $projectName, $projectCode, $level, $cStatus,  $approverData, ''));
        return true;
    }
    public function getEmployeeemail($projectId)
    {
        $models = ProjectEmployee::with('employee')->where('project_id', $projectId)->where('type',2)->groupBy('employee_id')->get();
        $emailArray = [];
        foreach ($models as $model) {
            $employee = $model['employee'];
            $email = $employee->email;

            $emailArray[] = $email;
        }
        return $emailArray;
    }
    public function BccMailLooping()
    {
        $BccMails = explode(',', config('app.BCCEMail'));
        $emailArray = [];
        foreach ($BccMails as $key => $BccMail) {
            $emailId = trim(str_replace(['[', ']', '"',], '', $BccMail));
            array_push($emailArray, $emailId);
        }
        return $emailArray;
    }


    public function projectDetailByProjectId($projectId)
    {
        return Project::with('employee')->where('id', $projectId)->first();
    }
    public function employeeDetailById($empId)
    {
        dd($empId);
    }
}
