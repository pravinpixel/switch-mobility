<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Doclistings;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProjectController;
use App\Models\Workflow;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LevelReportController extends Controller
{
    protected $projectController, $empController, $doclistings;
    public function __construct(ProjectController $projectController, EmployeeController $empController, Doclistings $doclistings)
    {
        $this->projectController = $projectController;
        $this->empController = $empController;
        $this->doclistings = $doclistings;
    }
    public function index()
    {

        // Create two Carbon instances representing the dates you want to compare

        $workflowModels = Workflow::whereNull('deleted_at')->where('is_active', 1)->orderBy('id', 'desc')->get();
        $projectDataModels = array();
        $tableDatas = array();
        foreach ($workflowModels as $workflowModel) {
            $wfId = $workflowModel->id;
            $wfName = $workflowModel->workflow_name;
            $projectModels = $this->projectController->getProjectModelsByWfId($wfId);
            foreach ($projectModels as $projectModel) {

                $projectName = $projectModel->project_name;
                $projectId = $projectModel->id;
                $projectModelsArray = ['projectId' => $projectId, 'projectName' => $projectName, 'projectCode' => $projectModel->project_code];
                array_push($projectDataModels, $projectModelsArray);
                $getLastLevel = $this->doclistings->getLastLevelProject($projectId);

                $documentModel = $this->projectController->getMaindocumentFileNameById($projectId);
                $docName = "";
                if ($documentModel) {
                    $docName = $documentModel->original_name;

                    $level = "level";
                    $dynamicLevelStatusData = array();
                    $dynamicLevelStatusId = array();
                    $dynamicLevelrowResDatas = array();


                    $projectLevelModels = $this->projectController->getProjectLevelByProjectId($projectId);
                    foreach ($projectLevelModels as $projectLevelModel) {

                        $levelDate = $projectLevelModel->due_date;
                        $convertedLevelDate = \Carbon\Carbon::parse($levelDate)->format('d-m-Y');

                        $levelId = $projectLevelModel->project_level;
                        $levelApprover = "Admin";
                        $levelApproverModel = $this->projectController->getProjectLevelApproverByProjectIdAndLevelId($projectId, $levelId);
                        if ($levelApproverModel) {
                            $levelApprover = $levelApproverModel->employee_name;
                        }
                        $projectDocLevelModel = $this->projectController->getProjectLevelStausBylevelIdandProjectId($projectId, $levelId);
                        $rowresData = "";
                        if ($projectDocLevelModel) {
                            $approverType = "Approval :";
                            $statusColor = 'green-bg';
                            if ($projectDocLevelModel->status == 4) {
                                $statusColor = 'green-bg';
                                $levelDate = $projectDocLevelModel->approved_date;
                                $convertedLevelDate = \Carbon\Carbon::parse($levelDate)->format('d-m-Y');
                                $levelApprover = "Admin";
                                if ($projectDocLevelModel->approver_id) {
                                    $employeeModel = $this->empController->getEmployeeAllDataByEmpid($projectDocLevelModel->approver_id);

                                    if ($employeeModel) {
                                        $levelApprover = $employeeModel->employee_name;
                                    } else {
                                        $levelApprover = "Admin";
                                    }
                                    $approverType = "Approved By:";

                                }
                                    $rowresData = "Approved BY: " . $levelApprover . "<br>Date: " . $convertedLevelDate . "<br><a class='view-button' id='" . $projectId . "' data-id='" . $levelId . "'>View</a>";
                                
                            } else {
                                $date1 = Carbon::parse($levelDate);
                                $date2 = today();
                                $statusColor = 'yellow-bg';

                                // Compare the dates
                                if ($date1->lessThan($date2)) {
                                    $daysDifference = "-" . $date1->diffInDays($date2);
                                    $statusColor = 'red-bg';

                                    // dd($levelDate,"less",$daysDifference);
                                } elseif ($date1->greaterThan($date2)) {
                                    $daysDifference = "+" . $date1->diffInDays($date2);
                                    // dd("greater");
                                } else {
                                    $daysDifference = $date1->diffInDays($date2);
                                    //  dd("equal");
                                }
                                $pendingDays = "";
                                if ($daysDifference < 2) {
                                    // If the difference is less than 2 days, do something
                                    // For example, count and display the days
                                    $pendingDays = " $daysDifference day(s)";
                                } else {
                                    // If the difference is 2 days or more, do something else
                                    // For example, display a message with the days
                                    $pendingDays = "$daysDifference days";
                                }
                                $rowresData = "Due: " . $convertedLevelDate . "<br>" . $pendingDays . "<br>Approval: " . $levelApprover;
                            }

                            $dynamicVariablePart = $level . $levelId;

                            $dynamicVariableNameStatus = $dynamicVariablePart . 'Status';
                            $dynamicLevelStatusData[$dynamicVariableNameStatus] = $statusColor;

                            $dynamicVariableStatusId = $dynamicVariablePart . 'StatusId';
                            $dynamicLevelStatusId[$dynamicVariableStatusId] = $projectDocLevelModel->status;

                            $dynamicRowResData = $dynamicVariablePart . 'levelResData';
                            $dynamicLevelRowResDatas[$dynamicRowResData] = $rowresData;
                        }
                    }

                    $response = ['getLastLevel' => $getLastLevel, 'projectId' => $projectId, 'projectName' => $projectName, 'wfName' => $wfName, 'docName' => $docName, 'dynamicLevelRowResDatas' => $dynamicLevelRowResDatas, 'dynamicLevelStatusData' => $dynamicLevelStatusData,  'dynamicLevelStatusId' => $dynamicLevelStatusId];


                    array_push($tableDatas, $response);
                }
            }
        }
        //dd($tableDatas);
        $todayDate = date('d-m-Y');

        return view('Reports.LevelReport.list', compact('tableDatas', 'workflowModels', 'todayDate', 'projectDataModels'));
    }
    public function levelwiseReportSearchFilter(Request $request)
    {
        $workflowId = $request->wfId;
        $projectId = $request->projectId;
        $projectDataModels = array();
        $tableDatas = array();
        
        if ($projectId && $workflowId) {
            $workflowModel = Workflow::where('id', $workflowId)->first();
            $wfName = $workflowModel->workflow_name;
            $wfId = $workflowModel->id;
            $projectModels = $this->projectController->getProjectModelsByWfId($wfId, $projectId);
            foreach ($projectModels as $projectModel) {

                $projectName = $projectModel->project_name;
                $projectId = $projectModel->id;
                $projectModelsArray = ['projectId' => $projectId, 'projectName' => $projectName, 'projectCode' => $projectModel->project_code];

                $getLastLevel = $this->doclistings->getLastLevelProject($projectId);

                $documentModel = $this->projectController->getMaindocumentFileNameById($projectId);
                $docName = "";
                if ($documentModel) {
                    array_push($projectDataModels, $projectModelsArray);
                    $docName = $documentModel->original_name;

                    $level = "level";
                    $dynamicLevelStatusData = array();
                    $dynamicLevelStatusId = array();
                    $dynamicLevelrowResDatas = array();


                    $projectLevelModels = $this->projectController->getProjectLevelByProjectId($projectId);
                    foreach ($projectLevelModels as $projectLevelModel) {

                        $levelDate = $projectLevelModel->due_date;
                        $convertedLevelDate = \Carbon\Carbon::parse($levelDate)->format('d-m-Y');

                        $levelId = $projectLevelModel->project_level;
                        $levelApprover = "Admin";
                        $levelApproverModel = $this->projectController->getProjectLevelApproverByProjectIdAndLevelId($projectId, $levelId);
                        if ($levelApproverModel) {
                            $levelApprover = $levelApproverModel->employee_name;
                        }
                        $projectDocLevelModel = $this->projectController->getProjectLevelStausBylevelIdandProjectId($projectId, $levelId);
                        $rowresData = "";
                        if ($projectDocLevelModel) {
                            $approverType = "Approval :";
                            $statusColor = 'green-bg';
                            if ($projectDocLevelModel->status == 4) {
                                $statusColor = 'green-bg';
                                $levelDate = $projectDocLevelModel->approved_date;
                                $convertedLevelDate = \Carbon\Carbon::parse($levelDate)->format('d-m-Y');
                                $levelApprover = "Admin";
                                if ($projectDocLevelModel->approver_id) {
                                    $employeeModel = $this->empController->getEmployeeAllDataByEmpid($projectDocLevelModel->approver_id);

                                    if ($employeeModel) {
                                        $levelApprover = $employeeModel->employee_name;
                                    } else {
                                        $levelApprover = "Admin";
                                    }
                                    $approverType = "Approved By:";
                                }
                                    $rowresData = "Approved BY: " . $levelApprover . "<br>Date: " . $convertedLevelDate . "<br> <a class='view-button' id='" . $projectId . "' data-id='" . $levelId . "'>View</a>";
                                
                            } else {
                                $date1 = Carbon::parse($levelDate);
                                $date2 = today();
                                $statusColor = 'yellow-bg';

                                // Compare the dates
                                if ($date1->lessThan($date2)) {
                                    $daysDifference = "-" . $date1->diffInDays($date2);
                                    $statusColor = 'red-bg';

                                    // dd($levelDate,"less",$daysDifference);
                                } elseif ($date1->greaterThan($date2)) {
                                    $daysDifference = "+" . $date1->diffInDays($date2);
                                    // dd("greater");
                                } else {
                                    $daysDifference = $date1->diffInDays($date2);
                                    //  dd("equal");
                                }
                                $pendingDays = "";
                                if ($daysDifference < 2) {
                                    // If the difference is less than 2 days, do something
                                    // For example, count and display the days
                                    $pendingDays = " $daysDifference day(s)";
                                } else {
                                    // If the difference is 2 days or more, do something else
                                    // For example, display a message with the days
                                    $pendingDays = "$daysDifference days";
                                }

                                $rowresData = "Due: " . $convertedLevelDate . "<br>" . $pendingDays . "<br>Approval: " . $levelApprover;
                            }

                            $dynamicVariablePart = $level . $levelId;

                            $dynamicVariableNameStatus = $dynamicVariablePart . 'Status';
                            $dynamicLevelStatusData[$dynamicVariableNameStatus] = $statusColor;

                            $dynamicVariableStatusId = $dynamicVariablePart . 'StatusId';
                            $dynamicLevelStatusId[$dynamicVariableStatusId] = $projectDocLevelModel->status;

                            $dynamicRowResData = $dynamicVariablePart . 'levelResData';
                            $dynamicLevelRowResDatas[$dynamicRowResData] = $rowresData;
                        }
                    }

                    $response = ['getLastLevel' => $getLastLevel, 'projectId' => $projectId, 'projectName' => $projectName, 'wfName' => $wfName, 'docName' => $docName, 'dynamicLevelRowResDatas' => $dynamicLevelRowResDatas, 'dynamicLevelStatusData' => $dynamicLevelStatusData,  'dynamicLevelStatusId' => $dynamicLevelStatusId];


                    array_push($tableDatas, $response);
                }
            }
        } else if ($workflowId) {
            $workflowModel = Workflow::where('id', $workflowId)->first();
            $wfName = $workflowModel->workflow_name;
            $projectModels = $this->projectController->getProjectModelsByWfId($workflowId);
            foreach ($projectModels as $projectModel) {

                $projectName = $projectModel->project_name;
                $projectId = $projectModel->id;
                $projectModelsArray = ['projectId' => $projectId, 'projectName' => $projectName, 'projectCode' => $projectModel->project_code];

                $getLastLevel = $this->doclistings->getLastLevelProject($projectId);

                $documentModel = $this->projectController->getMaindocumentFileNameById($projectId);
                $docName = "";
                if ($documentModel) {
                    array_push($projectDataModels, $projectModelsArray);
                    $docName = $documentModel->original_name;

                    $level = "level";
                    $dynamicLevelStatusData = array();
                    $dynamicLevelStatusId = array();
                    $dynamicLevelrowResDatas = array();


                    $projectLevelModels = $this->projectController->getProjectLevelByProjectId($projectId);
                  
                    foreach ($projectLevelModels as $projectLevelModel) {

                        $levelDate = $projectLevelModel->due_date;
                        $convertedLevelDate = \Carbon\Carbon::parse($levelDate)->format('d-m-Y');

                        $levelId = $projectLevelModel->project_level;
                        $levelApprover = "Admin";
                        $levelApproverModel = $this->projectController->getProjectLevelApproverByProjectIdAndLevelId($projectId, $levelId);
                        if ($levelApproverModel) {
                            $levelApprover = $levelApproverModel->employee_name;
                        }
                        $projectDocLevelModel = $this->projectController->getProjectLevelStausBylevelIdandProjectId($projectId, $levelId);
                        $rowresData = "";
                       
                        if ($projectDocLevelModel) {
                            $approverType = "Approval :";
                            $statusColor = 'green-bg';
                           
                            if ($projectDocLevelModel->status == 4) {
                               
                                $statusColor = 'green-bg';
                                $levelDate = $projectDocLevelModel->approved_date;
                                $convertedLevelDate = \Carbon\Carbon::parse($levelDate)->format('d-m-Y');
                                $levelApprover = "Admin";
                                if ($projectDocLevelModel->approver_id) {
                                    $employeeModel = $this->empController->getEmployeeAllDataByEmpid($projectDocLevelModel->approver_id);

                                    if ($employeeModel) {
                                        $levelApprover = $employeeModel->employee_name;
                                    } else {
                                        $levelApprover = "Admin";
                                    }
                                }

                                $rowresData = "Approved BY: " . $levelApprover . "<br>Date: " . $convertedLevelDate . "<br> <a class='view-button' id='" . $projectId . "' data-id='" . $levelId . "'>View</a>";
                            } else {
                                $date1 = Carbon::parse($levelDate);
                                $date2 = today();
                                $statusColor = 'yellow-bg';

                                // Compare the dates
                                if ($date1->lessThan($date2)) {
                                    $daysDifference = "-" . $date1->diffInDays($date2);
                                    $statusColor = 'red-bg';

                                    // dd($levelDate,"less",$daysDifference);
                                } elseif ($date1->greaterThan($date2)) {
                                    $daysDifference = "+" . $date1->diffInDays($date2);
                                    // dd("greater");
                                } else {
                                    $daysDifference = $date1->diffInDays($date2);
                                    //  dd("equal");
                                }
                                $pendingDays = "";
                                if ($daysDifference < 2) {
                                    // If the difference is less than 2 days, do something
                                    // For example, count and display the days
                                    $pendingDays = " $daysDifference day(s)";
                                } else {
                                    // If the difference is 2 days or more, do something else
                                    // For example, display a message with the days
                                    $pendingDays = "$daysDifference days";
                                }

                                $rowresData = "Due: " . $convertedLevelDate . "<br>" . $pendingDays . "<br>Approval: " . $levelApprover;
                            }

                            $dynamicVariablePart = $level . $levelId;

                            $dynamicVariableNameStatus = $dynamicVariablePart . 'Status';
                            $dynamicLevelStatusData[$dynamicVariableNameStatus] = $statusColor;

                            $dynamicVariableStatusId = $dynamicVariablePart . 'StatusId';
                            $dynamicLevelStatusId[$dynamicVariableStatusId] = $projectDocLevelModel->status;

                            $dynamicRowResData = $dynamicVariablePart . 'levelResData';
                            $dynamicLevelRowResDatas[$dynamicRowResData] = $rowresData;
                        }
                    }

                    $response = ['getLastLevel' => $getLastLevel, 'projectId' => $projectId, 'projectName' => $projectName, 'wfName' => $wfName, 'docName' => $docName, 'dynamicLevelRowResDatas' => $dynamicLevelRowResDatas, 'dynamicLevelStatusData' => $dynamicLevelStatusData,  'dynamicLevelStatusId' => $dynamicLevelStatusId];


                    array_push($tableDatas, $response);
                }
            }
        } else {
            $workflowModels = Workflow::whereNull('deleted_at')->where('is_active', 1)->get();
            $projectDataModels = array();
            $tableDatas = array();
            foreach ($workflowModels as $workflowModel) {
                $wfId = $workflowModel->id;
                $wfName = $workflowModel->workflow_name;
                $projectModels = $this->projectController->getProjectModelsByWfId($wfId);
                foreach ($projectModels as $projectModel) {

                    $projectName = $projectModel->project_name;
                    $projectId = $projectModel->id;
                    $projectModelsArray = ['projectId' => $projectId, 'projectName' => $projectName, 'projectCode' => $projectModel->project_code];
                    array_push($projectDataModels, $projectModelsArray);
                    $getLastLevel = $this->doclistings->getLastLevelProject($projectId);

                    $documentModel = $this->projectController->getMaindocumentFileNameById($projectId);
                    $docName = "";
                    if ($documentModel) {
                        $docName = $documentModel->original_name;

                        $level = "level";
                        $dynamicLevelStatusData = array();
                        $dynamicLevelStatusId = array();
                        $dynamicLevelrowResDatas = array();


                        $projectLevelModels = $this->projectController->getProjectLevelByProjectId($projectId);
                        foreach ($projectLevelModels as $projectLevelModel) {

                            $levelDate = $projectLevelModel->due_date;
                            $convertedLevelDate = \Carbon\Carbon::parse($levelDate)->format('d-m-Y');

                            $levelId = $projectLevelModel->project_level;
                            $levelApprover = "Admin";
                            $levelApproverModel = $this->projectController->getProjectLevelApproverByProjectIdAndLevelId($projectId, $levelId);
                            if ($levelApproverModel) {
                                $levelApprover = $levelApproverModel->employee_name;
                            }
                            $projectDocLevelModel = $this->projectController->getProjectLevelStausBylevelIdandProjectId($projectId, $levelId);
                            $rowresData = "";
                            if ($projectDocLevelModel) {
                                $approverType = "Approval :";
                                $statusColor = 'green-bg';
                                if ($projectDocLevelModel->status == 4) {
                                    $statusColor = 'green-bg';
                                    $levelDate = $projectDocLevelModel->approved_date;
                                    $convertedLevelDate = \Carbon\Carbon::parse($levelDate)->format('d-m-Y');
                                    $levelApprover = "Admin";
                                    if ($projectDocLevelModel->approver_id) {
                                        $employeeModel = $this->empController->getEmployeeAllDataByEmpid($projectDocLevelModel->approver_id);

                                        if ($employeeModel) {
                                            $levelApprover = $employeeModel->employee_name;
                                        } else {
                                            $levelApprover = "Admin";
                                        }
                                        $approverType = "Approved By:";

                                    }
                                        $rowresData = "Approved BY: " . $levelApprover . "<br>Date: " . $convertedLevelDate . "<br><a class='view-button' id='" . $projectId . "' data-id='" . $levelId . "'>View</a>";
                                    
                                } else {
                                    $date1 = Carbon::parse($levelDate);
                                    $date2 = today();
                                    $statusColor = 'yellow-bg';

                                    // Compare the dates
                                    if ($date1->lessThan($date2)) {
                                        $daysDifference = "-" . $date1->diffInDays($date2);
                                        $statusColor = 'red-bg';

                                        // dd($levelDate,"less",$daysDifference);
                                    } elseif ($date1->greaterThan($date2)) {
                                        $daysDifference = "+" . $date1->diffInDays($date2);
                                        // dd("greater");
                                    } else {
                                        $daysDifference = $date1->diffInDays($date2);
                                        //  dd("equal");
                                    }
                                    $pendingDays = "";
                                    if ($daysDifference < 2) {
                                        // If the difference is less than 2 days, do something
                                        // For example, count and display the days
                                        $pendingDays = " $daysDifference day(s)";
                                    } else {
                                        // If the difference is 2 days or more, do something else
                                        // For example, display a message with the days
                                        $pendingDays = "$daysDifference days";
                                    }
                                    $rowresData = "Due: " . $convertedLevelDate . "<br>" . $pendingDays . "<br>Approval: " . $levelApprover;
                                }

                                $dynamicVariablePart = $level . $levelId;

                                $dynamicVariableNameStatus = $dynamicVariablePart . 'Status';
                                $dynamicLevelStatusData[$dynamicVariableNameStatus] = $statusColor;

                                $dynamicVariableStatusId = $dynamicVariablePart . 'StatusId';
                                $dynamicLevelStatusId[$dynamicVariableStatusId] = $projectDocLevelModel->status;

                                $dynamicRowResData = $dynamicVariablePart . 'levelResData';
                                $dynamicLevelRowResDatas[$dynamicRowResData] = $rowresData;
                            }
                        }

                        $response = ['getLastLevel' => $getLastLevel, 'projectId' => $projectId, 'projectName' => $projectName, 'wfName' => $wfName, 'docName' => $docName, 'dynamicLevelRowResDatas' => $dynamicLevelRowResDatas, 'dynamicLevelStatusData' => $dynamicLevelStatusData,  'dynamicLevelStatusId' => $dynamicLevelStatusId];


                        array_push($tableDatas, $response);
                    }
                }
            }
        }
        return response()->json(['projectDataModels' => $projectDataModels, 'tableDatas' => $tableDatas]);
    }
}