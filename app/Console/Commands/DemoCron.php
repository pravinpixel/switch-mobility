<?php

namespace App\Console\Commands;

use App\Mail\SendMail;
use App\Models\Project;
use App\Models\ProjectEmployee;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $projects = Project::with('employee')->where('projects.current_status', '!=', 4)->get();
        foreach ($projects as $project) {

            $projectName = $project->project_name;
            $projectCode = $project->project_code;

            $dueDate = $project->end_date;
            $todayDate = date('Y-m-d');

            $carbonDate1 = Carbon::parse($dueDate);
            $carbonDate2 = Carbon::parse($todayDate);

            Log::info("Due And Tidate date " . $dueDate . " " . $todayDate);
            Log::info("Project Model" . json_encode($project));
            if (Carbon::parse($dueDate)->greaterThan(Carbon::parse($todayDate))) {
                Log::info("Date Compare" . $dueDate . " " . $todayDate . "grater");
                $diffInDays = $carbonDate1->diffInDays($carbonDate2);
                Log::info("diff In Days If" . $diffInDays);
            } else {
                Log::info("Date  Compare" . $dueDate . " " . $todayDate . "Lessthan");
                $diffInDays = $carbonDate1->diffInDays($carbonDate2);
                Log::info("diff In Days Else " . $diffInDays);
            }
            $employeeModel = $project['employee'];
            $initiaterEmail = $employeeModel->email;
            $BccMails = explode(',', config('app.BCCEMail'));
            $emailArray = [];
            foreach ($BccMails as $key => $BccMail) {
                $emailId = trim(str_replace(['[', ']', '"',], '', $BccMail));
                array_push($emailArray, $emailId);
            }
            $ccEmail = $emailArray;
            Log::info('DemoCron > ccEmail' . json_encode($ccEmail));
            $ProjectEmployeeModels = ProjectEmployee::with('employee')->where('project_id', $project->id)->groupBy('employee_id')->get();
            $title = "Reminder notification to approver";
            foreach ($ProjectEmployeeModels as $model) {
                $employee = $model['employee'];
                $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;
                Log::info("Employee Name " . $name);
                $toMail = $employee->email;
                Log::info('Emailconroller > NewApprovalToApprover req toMail' . json_encode($toMail));
                try {

                    $mail = Mail::to($employeeModel->email)->bcc($ccEmail)->send(new SendMail("newApprovalMail", $title, $name, $project->id, $projectName, $projectCode, '', '', '', ''));

                    Log::info('Emailconroller > NewApprovalToApproverEmail Sended successfullty reponse ' . json_encode($mail));
                    return true;
                    // $mail = Mail::to($toMail)->cc($ccMail)->send(new SendMail($type,$title, $name,$projectId,$projectName, $projectCode,'','','',''));
                } catch (Exception $e) {

                    Log::info('Emailconroller > NewApprovalToApproverEmail Sended failed ' . $e);
                    return false;
                }
            }
        }
    }
}
