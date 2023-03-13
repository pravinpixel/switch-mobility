<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Http\Request;

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

        $models = Project::with('workflow', 'employee', 'employee.department')

            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate]);
            })

            ->whereNull('deleted_at')
            ->get();

        $entities = $this->projectController->ReportDataLooping($models);
        return response()->json(['entities' => $entities]);
    }
}
