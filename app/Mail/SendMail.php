<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title,$projectId;
    public $name, $projectName, $projectCode, $type, $level, $status, $approverData,$difDate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $title, $name,$projectId, $projectName, $projectCode, $level = null, $status = null, $approverData = null,$difDate = null)
    {
        $this->type = $type;
        $this->projectId = $projectId;
        $this->title = $title;
        $this->name = $name;
        $this->projectName = $projectName;
        $this->projectCode = $projectCode;
        $this->level = $level;
        $this->status = $status;
        $this->approverData = $approverData;
        $this->difDate = $difDate;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $type = $this->type;
        $projectId = $this->projectId;
        
        $empName = $this->name;
        $projectName =  $this->projectName;
        $projectCode =  $this->projectCode;
        $status = $this->status;
        $level = $this->level;
        $approverData = $this->approverData;
        $difDate = $this->difDate;

        Log::info('Send Email type '.$type);

        if ($type == 1) {
            return $this->subject($this->title)
                ->view('Email.initiatorMail', compact('projectId','empName', 'projectName', 'projectCode'));
        }
       else if ($type == "newUserAdd") {
      
            return $this->subject($this->title)
                ->view('Email.NewUserAddMail', compact('empName','projectId','projectName'));
        }
         elseif($type == "newApprovalMail") {
            
            return $this->subject($this->title)
                ->view('Email.newApprovalMail', compact('projectId','empName', 'projectName', 'projectCode','status','level','approverData'));
        }
        
        elseif($type == "statusChange") {
            
            return $this->subject($this->title)
                ->view('Email.changeDocsStatus', compact('projectId','empName', 'projectName', 'projectCode','status','level','approverData'));
        }elseif($type == "finalApprovalMail") {
            
            return $this->subject($this->title)
            ->view('Email.finalApprovalMail', compact('projectId','empName', 'projectName', 'projectCode'));
        }elseif($type == "reAssignMail") {
            
            return $this->subject($this->title)
            ->view('Email.reAssignMail', compact('projectId','empName', 'projectName', 'projectCode'));
        }
        else{
         
            return $this->subject($this->title)
            ->view('Email.remainderNotify', compact('projectId','empName', 'projectName', 'projectCode','status','level','approverData','difDate'));
        }
    }
}
