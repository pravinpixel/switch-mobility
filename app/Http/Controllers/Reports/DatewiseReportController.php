<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatewiseReportController extends Controller
{
    protected $projectController;
    public function __construct(ProjectwiseController $projectController)
    {
        $this->projectController = $projectController;
    }
    protected $service;

    public function index()
    {
        return view('Reports/DatewiseReport/list');
    }
    public function filterSearch(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";
        $modeldatas = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');

        $modeldatas->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate]);
        });
        if ($empId) {
            $modeldatas->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }
        $modeldatas->whereNull('deleted_at');
        $models= $modeldatas->get();

        $entities = $this->projectController->ReportDataLooping($models);
        return response()->json(['entities' => $entities]);
    }
}
