<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\ProjectEmployee;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use \App\Mail\SendMail;

class AutoRemainderMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:raminMail';

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
        $projects = Project::with('employee')->where('projects.current_status','!=',4)->get();
        foreach($projects as $project){

            $projectName = $project->project_name;
            $projectCode = $project->project_code;

            $dueDate = $project->end_date;
            $todayDate = date('Y-m-d');

            $carbonDate1 = Carbon::parse($dueDate);
            $carbonDate2 = Carbon::parse($todayDate);

            Log::info("well dhana".$dueDate." ". $todayDate);
            Log::info("well dhana".json_encode($project));
            if (Carbon::parse($dueDate)->greaterThan(Carbon::parse($todayDate))) {
                Log::info("well dhana".$dueDate." ". $todayDate."grater");
                $diffInDays = $carbonDate1->diffInDays($carbonDate2);
                Log::info("diffInDays dhana".$diffInDays);
            } else {
                Log::info("well dhana".$dueDate." ". $todayDate."Lessthan");
                $diffInDays = $carbonDate1->diffInDays($carbonDate2);
                Log::info("diffInDays dhana".$diffInDays);
            }
            $employeeModel = $project['employee'];
            $initiaterEmail = $employeeModel->email;
            $ccEmail = ['rajdhana238@gmail.com',$initiaterEmail];

            $ProjectEmployeeModels = ProjectEmployee::with('employee')->where('project_id', $project->id)->groupBy('employee_id')->get();
            $title ="Reminder notification to approver";
            foreach ($ProjectEmployeeModels as $model) {
                $employee = $model['employee'];
                $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;
                Log::info("Employee Name". $name);
                $toMail = $employee->email;
                $mail = Mail::to($toMail)->cc($ccEmail)->send(new SendMail(4, $title, $name, $projectName, $projectCode,"", "","",$diffInDays));
                Log::info("mailStatus". json_encode($mail));
            }

          

        }


       
        return 0;
    }
}
