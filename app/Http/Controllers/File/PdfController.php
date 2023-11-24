<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PDF;

class PdfController extends Controller
{
    public function generatePdf($projectId)
    {
        $projectData = $this->projectDataById($projectId);
        $projectApprovers = $this->projectApprovers($projectId);
        // dd($projectApprovers[0]);

        $pageSize = $projectData['pageSize'];
        $pageOrientation = $projectData['pageOrientation'];

        $filaName = "Print.a4-p";
        if ($pageSize == "A4" && $pageOrientation == "P") {
            $filaName = "Print.a4-p";
        } elseif ($pageSize == "A4" && $pageOrientation == "L") {
            $filaName = "Print.a4-l";
        } elseif ($pageSize == "A3" && $pageOrientation == "P") {
            $filaName = "Print.a3-p";
        } else {
            $filaName = "Print.a3-l";
        }

        $pdfFileName =  uniqid() . '.pdf';

        $imagePaths = [];

        $imageDirectory = public_path("finalOutput/") . $projectId . "/pdfToImage";

        // Replace with the actual path to your image directory
        $imagePaths = [];

        // Get all files in the directory
        $files = glob($imageDirectory . DIRECTORY_SEPARATOR . '*');

        // Sort the files in ascending order
        sort($files, SORT_NATURAL);

        // Extract file paths
        foreach ($files as $file) {
            $imagePaths[] = $file;
        }
       
        $pdf = PDF::loadView($filaName, compact('imagePaths', 'projectData', 'projectApprovers'));
        $pdfFileName = uniqid() . '.pdf'; // Unique filename

        $imageCreatedFolderPath = public_path('pdf/' . $projectId);
        if (File::exists($imageCreatedFolderPath)) {
            File::deleteDirectory($imageCreatedFolderPath);
        }

        if (!File::exists($imageCreatedFolderPath)) {
            File::makeDirectory($imageCreatedFolderPath, 0755, true);
        }
        $pdfPath = public_path('pdf/' . $projectId . "/" . $pdfFileName);
        // Save the PDF to the specified path
        $pdf->save($pdfPath);
        return $pdfPath;
        // header('Content-Type: application/pdf');

        // // Output the PDF content directly to the browser
        // readfile($pdfPath);
    }

    public function projectDataById($projectId)
    {
        $project = Project::with('docType', 'employee', 'employee.department', 'workflow')
            ->where('id', $projectId)->first();
        // $projectApprovers = $this->projectApprovers($projectId);

        $docModel  = $project->docType;

        $employeeModel  = $project->employee;

        $departmentModel  = $employeeModel->department;

        $workflowModel  = $project->workflow;

        $timestamp = strtotime($project->created_at);
        $date = date('d-m-Y', $timestamp);

        $docName = ($docModel) ? $docModel->name : "";
        $workflowName = ($workflowModel) ? $workflowModel->workflow_name : "";
        $workflowCode = ($workflowModel) ? $workflowModel->workflow_code : "";
        $department  = ($departmentModel) ? $departmentModel->name : "";
        $employeeName = ($employeeModel) ? $employeeModel->first_name . " " . $employeeModel->last_name : "";
        $ticketNumber = $project->ticket_no;
        $projectCode = $project->project_code;
        $projectName = $project->project_name;

        $orientation = $project->document_orientation;

        if ($orientation == '1') {
            $pageOrientation = 'P';
        } else {
            $pageOrientation = 'L';
        }

        $docSizeType = $project->document_size;

        if ($docSizeType == '1') {
            $pageSize = 'A3';
        } else {
            $pageSize = 'A4';
        }
        //dd($ticketNumber,$projectCode,$projectName,$date,$docName,$workflowName,$workflowCode,$department,$employeeName);
        $approverCount = 11;

        $data = [

            'ticketNo'         => $ticketNumber,
            'projectCode'      => $projectCode,
            'projectName' => $projectName,
            'date'        => $date,
            'docName'         => $docName,
            'workflowData'      => $workflowName . "(" . $workflowCode . ")",
            'department'        => $department,
            'initiater' => $employeeName,
            "pageSize" => $pageSize,
            "pageOrientation" => $pageOrientation,
            "approverCount" => $approverCount
        ];

        return $data;
    }
    public function projectApprovers($projectId)
    {

        $models = ProjectEmployee::with('employee', 'employee.designation')->where('project_id', $projectId)->where('type', 2)->groupby('project_employees.employee_id')->orderby('project_employees.level')->limit(11)->get();

        $entities = collect($models)->map(function ($model) {

            $empModel = $model['employee'];
            $appproverName = "";
            $designation = "";
            if ($empModel) {
                $designationModel = $empModel['designation'];
                $appproverName = $empModel['first_name'] . $empModel['last_name'];
                if ($designationModel) {
                    $designation = $designationModel->name;
                }
            }
            $signImage = ($empModel->sign_image) ? $empModel->sign_image : "noimage.png";
            $signImageWithPath = 'images/Employee/' . $signImage;
            $filePath = public_path($signImageWithPath);

            if (!file_exists($filePath)) {

                $signImageWithPath = 'images/Employee/noimage.png';
            }

            $updateDate =  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $model->updated_at)->format('d-m-Y');

            $resData = ['appproverName' => $appproverName, 'designation' => $designation, 'level' => $model->level, 'updatedate' => $updateDate, 'signImageWithPath' => $signImageWithPath];
            return $resData;
        });
        return $entities;
    }
}
