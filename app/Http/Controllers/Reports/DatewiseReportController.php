<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class DatewiseReportController extends Controller
{
    public function index()
    {
        return view('Reports/DatewiseReport/list');
    }
    public function filterSearch(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $models = Project::with('workflow', 'employee', 'employee.department')

            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate]);
            })

            ->whereNull('deleted_at')
            ->get();

        $entities = collect($models)->map(function ($model) {
            $workflowModel = $model['workflow'];
            $employeeModel = $model['employee'];
            $departmentModel = "";
            if ($employeeModel) {
                $departmentModel = $employeeModel->department;
            }

            $projectId = $model->id;
            $projectCode = $model->project_code;
            $projectName = $model->project_name;
            $workflowCode = $workflowModel->workflow_code;
            $workflowName = $workflowModel->workflow_name;
            $initiater = $employeeModel->first_name . "" . $employeeModel->last_name;
            $department = ($departmentModel) ? $departmentModel->name : "";
            $data = ['projectId' => $projectId, 'workflowName' => $workflowName, 'projectCode' => $projectCode, 'projectName' => $projectName, 'workflowCode' => $workflowCode, 'initiater' => $initiater, 'department' => $department];

            return $data;
        });
        return response()->json(['entities' => $entities]);
    }
}
