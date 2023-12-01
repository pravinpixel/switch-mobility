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
        $ccMailIds = $this->getPreviousLevelEmployees($projectId, $level);

        Log::info('Email Controller> statusChange inside Function requests ' .  " projectId = " . $projectId . " level = " . $level . " status = " . $status);
        if ($status == 4) {
            $type = "Approved";
        } elseif ($status == 3) {
            $type = "Change request";
        } else {
            $type = "Declined";
        }
        $projectData = $this->projectDetailByProjectId($projectId);

        Log::info('Email Controller> statusChange projectData ' . json_encode($projectData));

        $employeeModel = $projectData->employee;
        $toMail = $employeeModel->email;
        Log::info('Email Controller> toMail ' . json_encode($toMail));

        $name = $employeeModel->first_name . " " . $employeeModel->last_name;
        Log::info('Email Controller> toname ' . json_encode($name));
        $bccMailIds = $this->BccMailLooping();
        Log::info('Email Controller> bccMailIds  ' . json_encode($bccMailIds));

        $subject = $type . " Notification | " . $projectData->project_name . " - " . $projectData->project_code;
        Log::info('Email Controller> subject ' . json_encode($subject));

        $projectName = $projectData->project_name;
        $projectCode = $projectData->project_code;
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";
        Log::info('Email Controller> empId ' . json_encode($empId));
        $approverData = "admin";
        if ($empId) {
            $ApproverEmployee = Employee::with('designation')->where('id', $empId)->first();
            $approvername = $ApproverEmployee->first_name . "" . $ApproverEmployee->middle_name . " " . $ApproverEmployee->last_name;
            $approverCode = $ApproverEmployee->sap_id;
            $designation = $ApproverEmployee['designation'];
            $designationName = $designation->name;
            $approverData = $approvername . "(" . $approverCode . ")" . "(" . $designationName . ")";
        }
        Log::info('Email Controller> approverData ' . json_encode($approverData));
        try {
            $mail = Mail::to($toMail)->bcc($bccMailIds)->cc($ccMailIds)->send(new SendMail("statusChange", $subject, $name, $projectId, $projectName, $projectCode, $level, $type, $approverData, ''));
            Log::info('Email Controller> Email Sended  ' . json_encode($mail));

            return true;
            // $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));
        } catch (Exception $e) {

            Log::info('Email Controller> mail mot sended catch ' . json_encode($e));
            return false;
        }
    }
    public function SendProjectInitiaterEmail($type, $initiaterId, $projectId, $projectName, $projectCode)
    {
        Log::info('Email Controller> SendProjectInitiaterEmail inside Function requests ' . "Type = " . $type . " initiaterId = " . $initiaterId . " projectId = " . $projectId . " projectName = " . $projectName . " projectCode = " . $projectCode);

        $employee = Employee::where('id', $initiaterId)->first();
        $toMail = $employee->email;
        $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;

        Log::info('Email Controller> SendProjectInitiaterEmail toMail ' . json_encode($toMail));
        Log::info('Email Controller> SendProjectInitiaterEmail Initiater Name ' . json_encode($name));

        $bccMailIds = $this->BccMailLooping();
        $title = "New Project assigned to Initiator";

        Log::info('Email Controller> SendProjectInitiaterEmail bccMailIds ' . json_encode($bccMailIds));
        Log::info('Email Controller> SendProjectInitiaterEmail title' . json_encode($title));

        try {
            $mail = Mail::to($toMail)->bcc($bccMailIds)->send(new SendMail($type, $title, $name, $projectId, $projectName, $projectCode, '', '', '', ''));
            Log::info('Email Controller> SendProjectInitiaterEmail Mail Sended Success fully' . json_encode($mail));
            return true;
            // $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));
        } catch (Exception $e) {

            Log::info('Email Controller> SendProjectInitiaterEmail response Failed' . json_encode($e));
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

                Log::info('Emailconroller > NewApprovalToApproverEmail Sended successfullty reponse ' . json_encode($mail));
                return true;
                // $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));
            } catch (Exception $e) {

                Log::info('Emailconroller > NewApprovalToApproverEmail Sended failed ' . $e);
                return false;
            }
        }
    }
    public function getPreviousLevelEmployees($projectId, $level)
    {
        Log::info('email getPreviousLevelEmployees projectId ' . $projectId);
        Log::info('email getPreviousLevelEmployees level ' . $level);
        $models =  ProjectEmployee::with('employee')
            ->where('project_id', $projectId)
            ->where('level', '<', $level)
            ->where('type', 2)
            ->get();
        $mailIds = array();
        foreach ($models as $model) {
            $empModel = $model->employee;
            $email = $empModel->email;
            array_push($mailIds, $email);
        }

        Log::info('    public function getPreviousLevelEmployees($projectId, $level)
        return' . json_encode($mailIds));
        return $mailIds;
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
        Log::info("Email controller -> finalApprovementProject initiating " . $projectId);
        $projectData = $this->projectDetailByProjectId($projectId);
        $employeeModel = $projectData->employee;
        $toMail = $employeeModel->email;
        $name = $employeeModel->first_name . " " . $employeeModel->last_name;
        Log::info("Email controller -> finalApprovementProject name " . $name);
        Log::info("Email controller -> finalApprovementProject toMail " . $toMail);

        $envbccMailIds = $this->BccMailLooping();
        $approverMails = $this->getEmployeeemail($projectId);

        $BccMailIds = array_unique(array_merge($envbccMailIds, $approverMails), SORT_REGULAR);

        $projectName = $projectData->project_name;
        $projectCode = $projectData->project_code;
        $projectNameAndCode = $projectData->project_name . " - " . $projectData->project_code;
        $subject = "Final Approved document generated notification | " . $projectNameAndCode;

        Log::info("Email controller -> finalApprovementProject subject " . $subject);
        Log::info("Email controller -> finalApprovementProject projectNameAndCode " . $projectNameAndCode);

        try {
            $mail = Mail::to($employeeModel->email)->bcc($BccMailIds)->send(new SendMail("finalApprovalMail", $subject, $name, $projectId, $projectName, $projectCode, '', '', '', ''));

            Log::info("Email controller -> finalApprovementProject Mail Sended Correctly ");
            return true;
            // $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));
        } catch (Exception $e) {


            Log::info("Email controller -> finalApprovementProject Mail Sended Failed " . json_encode($e));
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

    public function userAddMail($employeeId,$password)
    {

        $ApproverEmployee = Employee::where('id', $employeeId)->first();

        $approvername = $ApproverEmployee->first_name . "" . $ApproverEmployee->middle_name . " " . $ApproverEmployee->last_name;
        $approverCode = $ApproverEmployee->sap_id;
        $toMail = $ApproverEmployee->email;
        $title = "New user Add";



        try {
            $mail = Mail::to($toMail)->send(new SendMail("newUserAdd", $title, $approvername, $approverCode, $password, "", "", "",  "", ""));

            Log::info("Email controller -> finalApprovementProject Mail Sended Correctly ");
            return true;
            // $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));
        } catch (Exception $e) {


            Log::info("Email controller -> finalApprovementProject Mail Sended Failed " . json_encode($e));
            return false;
        }
    }
    public function getEmployeeemail($projectId)
    {
        $models = ProjectEmployee::with('employee')->where('project_id', $projectId)->where('type', 2)->groupBy('employee_id')->get();
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
