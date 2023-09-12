<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Doclistings;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Masters\DepartmentController;
use App\Http\Controllers\Masters\DesignationController;
use App\Http\Controllers\Masters\DocumentTypeController;
use App\Http\Controllers\Reports\DatewiseReportController;
use App\Http\Controllers\Reports\DocumentwiseReportController;
use App\Http\Controllers\Reports\LevelReportController;
use App\Http\Controllers\Reports\ProjectwiseController;
use App\Http\Controllers\Reports\UserwiseReportController;
use App\Http\Controllers\settings\RolesController;
use App\Http\Controllers\settings\UserController;
use App\Http\Controllers\Transaction\ApprovalListController;
use App\Http\Controllers\WorkflowController;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Department
Route::group([
    'middleware' => ['auth', 'is_admin', 'web']
], function () {
    Route::get('home', [HomeController::class, 'adminHome'])->name('home');
    Route::get('doclistingIndex/{type}', [Doclistings::class, 'filterindex'])->name('doclistingIndex');

    Route::resource('roles', RolesController::class);
    //Dept
    Route::resource('dashboard', DashboardController::class);
    Route::post('dashboardSearch', [DashboardController::class, 'dashboardSearch'])->name('dashboardSearch');

    Route::resource('doclisting', Doclistings::class);

    Route::post('docListingSearch', [Doclistings::class, 'docListingSearch'])->name('docListingSearch');
    Route::post('Search', [Doclistings::class, 'Search'])->name('Search')->middleware('is_admin');
    Route::resource('department', DepartmentController::class);

    Route::get('getDepartmentListData', [DepartmentController::class, 'getDepartmentListData'])->name('getDepartmentListData');
    Route::get('getDesignationListData', [DesignationController::class, 'getDesignationListData']);
    Route::get('getEmployeeListData', [EmployeeController::class, 'getEmployeeListData']);
    Route::get('getWorkflowListData', [WorkflowController::class, 'getWorkflowListData']);
    Route::get('getDocumentTypeListData', [DocumentTypeController::class, 'getDocumentTypeListData']);


    Route::post('getProjectByWorkflow', [Doclistings::class, 'getProjectByWorkflow'])->name('getProjectByWorkflow');
    Route::post('getProjectById', [Doclistings::class, 'getProjectById'])->name('getProjectById');


    Route::post('designationSearch', [DesignationController::class, 'designationSearch'])->name('designationSearch');
    Route::post('departmentValidation', [DepartmentController::class, 'departmentValidation'])->name('departmentValidation');
    Route::post('designationValidation', [DesignationController::class, 'designationValidation'])->name('designationValidation');
    Route::post('documentTypeValidation', [DocumentTypeController::class, 'validation'])->name('documentTypeValidation');

    Route::post('changedepartmentActiveStatus', [DepartmentController::class, 'changedepartmentActiveStatus'])->name('changedepartmentActiveStatus');
    Route::post('changedesignationActiveStatus', [DesignationController::class, 'changedesignationActiveStatus'])->name('changedesignationActiveStatus');
    Route::post('deptSearch', [DepartmentController::class, 'deptSearch'])->name('deptSearch');
    Route::post('doctypeSearch', [DocumentTypeController::class, 'doctypeSearch'])->name('doctypeSearch');
    Route::resource('designation', DesignationController::class);
    Route::post('changedDocumentTypeActiveStatus', [DocumentTypeController::class, 'changedDocumentTypeActiveStatus'])->name('changedDocumentTypeActiveStatus');
    Route::get('docTypeDetails', [DocumentTypeController::class, 'docTypeDetails'])->name('docTypeDetails');
    // Route::get('documentTypeEdit/{id}', [DocumentTypeController::class, 'documentTypeEdit'])->name('documentTypeEdit');

    Route::resource('documentType', DocumentTypeController::class);
    Route::resource('employees', EmployeeController::class);
    Route::get('bulkUploadCreate', [EmployeeController::class, 'bulkUploadCreate'])->name('bulkUploadCreate');
    Route::post('bulkUploadStore', [EmployeeController::class, 'bulkUploadStore'])->name('bulkUploadStore');
    Route::post('reAssignEmployee', [EmployeeController::class, 'reAssignEmployee'])->name('reAssignEmployee');
    Route::post('reAssignEmployeeUpdate', [EmployeeController::class, 'reAssignEmployeeUpdate'])->name('reAssignEmployeeUpdate');

    Route::post('employeeValidation', [EmployeeController::class, 'employeeValidation'])->name('employeeValidation');

    Route::post('changeEmployeeActiveStatus', [EmployeeController::class, 'changeActiveStatus'])->name('changeActiveStatus');
    Route::post('employeeDetailById', [EmployeeController::class, 'employeeDetailById'])->name('employeeDetailById');
    Route::post('employeeDetailByDesDept', [EmployeeController::class, 'employeeDetailByDesDept'])->name('employeeDetailByDesDept');

    Route::post('getDetailsById', [EmployeeController::class, 'getDetailsById'])->name('getDetailsById')->middleware('is_admin');
    Route::post('getEmployeeDetailByParams', [EmployeeController::class, 'getEmployeeDetailByParams'])->name('getEmployeeDetailByParams');
    Route::resource('projects', ProjectController::class);
    Route::post('employeeSearch', [EmployeeController::class, 'employeeSearch'])->name('employeeSearch');

    Route::post('projectCodeValidation', [ProjectController::class, 'projectCodeValidation'])->name('projectCodeValidation');
    Route::post('projectNameValidation', [ProjectController::class, 'projectNameValidation'])->name('projectNameValidation');
    Route::post('projectListFilters', [ProjectController::class, 'projectListFilters'])->name('projectListFilters');
    Route::post('getWorkflowByDocumentType', [ProjectController::class, 'getWorkflowByDocumentType'])->name('getWorkflowByDocumentType')->middleware('is_admin');
    Route::post('getEmployeeByWorkFlow', [ProjectController::class, 'getEmployeeByWorkFlow'])->name('getEmployeeByWorkFlow')->middleware('is_admin');
    Route::get('viewProject/{id}', [ProjectController::class, 'viewProject'])->name('viewProject')->middleware('is_admin');

    Route::post('viewDocListing', [Doclistings::class, 'viewDocListing'])->name('viewDocListing');
    Route::post('editDocument', [Doclistings::class, 'editDocument'])->name('editDocument');

    Route::post('deleteDocument', [ProjectController::class, 'deleteDocument'])->name('deleteDocument')->middleware('is_admin');
    Route::post('getProjectDetailsById', [ProjectController::class, 'getProjectDetailsById'])->name('getProjectDetailsById')->middleware('is_admin');
    Route::post('getProjectLevel', [ProjectController::class, 'getProjectLevel'])->name('getProjectLevel')->middleware('is_admin');
    Route::post('getProjectDocs', [ProjectController::class, 'getProjectDocs'])->name('getProjectDocs')->middleware('is_admin');
    Route::post('docStatus', [ProjectController::class, 'docStatus'])->name('docStatus')->middleware('is_admin');
    Route::resource('workflow', WorkflowController::class);
    Route::post('workflowSearch', [WorkflowController::class, 'search'])->name('workflowSearch');
    Route::post('getWorkflowCodeFormat', [WorkflowController::class, 'getWorkflowCodeFormat'])->name('getWorkflowCodeFormat');


    Route::post('getWorkflowById', [WorkflowController::class, 'getWorkflowById'])->name('getWorkflowById')->middleware('is_admin');
    Route::post('changeWorkflowActiveStatus', [WorkflowController::class, 'changeWorkflowActiveStatus'])->name('changeWorkflowActiveStatus');

    Route::post('getWorkflowLevels', [WorkflowController::class, 'getWorkflowLevels'])->name('getWorkflowLevels')->middleware('is_admin');
    Route::post('workflowValidation', [WorkflowController::class, 'workflowValidation'])->name('workflowValidation');

    Route::post('uploadDocumentVersion', [ProjectController::class, 'uploadDocumentVersion'])->name('uploadDocumentVersion');
    Route::resource('roles', RolesController::class);
    Route::post('roleNameValidation', [RolesController::class, 'roleNameValidation'])->name('roleNameValidation');
    Route::resource('users', UserController::class);
    Route::post('rolesSearch', [RolesController::class, 'search'])->name('rolesSearch');
    Route::post('UserSearch', [UserController::class, 'search'])->name('UserSearch');

    Route::post('getWorkflowByProjectId', [ProjectController::class, 'getWorkflowByProjectId'])->name('getWorkflowByProjectId');

    //reports
    Route::get('datewiseReportIndex', [DatewiseReportController::class, 'index'])->name('datewiseReportIndex');
    Route::post('dateWiseReportSearchFilter', [DatewiseReportController::class, 'filterSearch'])->name('dateWiseReportSearchFilter');

    //projectwiseReport 
    Route::get('projectwiseReportIndex', [ProjectwiseController::class, 'index'])->name('projectwiseReportIndex');
    Route::post('projectwiseReportSearchFilter', [ProjectwiseController::class, 'filterSearch'])->name('projectwiseReportSearchFilter');

    //docuWiseReport 
    Route::get('documentWiseReportIndex', [DocumentwiseReportController::class, 'index'])->name('documentWiseReportIndex');
    Route::post('documnetWiseReportSearchFilter', [DocumentwiseReportController::class, 'filterSearch'])->name('documnetWiseReportSearchFilter');
    //userwiseReport 
    Route::get('userWiseReportIndex', [UserwiseReportController::class, 'index'])->name('userWiseReportIndex');
    Route::post('userWiseReportSearchFilter', [UserwiseReportController::class, 'filterSearch'])->name('userWiseReportSearchFilter');
    //by dhana
    Route::post('getlevelwiseDocument', [Doclistings::class, 'getlevelwiseDocument'])->name('getlevelwiseDocument');
    Route::post('updatelevelwiseDocumentStatus', [Doclistings::class, 'updatelevelwiseDocumentStatus'])->name('updatelevelwiseDocumentStatus');

    Route::get('AssignedProject/{id}', [ProjectController::class, 'show'])->name('AssignedProject');

    Route::post('approverDownloadDocs', [Doclistings::class, 'approverDownloadDocs'])->name('approverDownloadDocs');

    Route::get('levelReportIndex', [LevelReportController::class, 'index'])->name('levelReportIndex');
    Route::post('levelwiseReportSearchFilter', [LevelReportController::class, 'levelwiseReportSearchFilter'])->name('levelwiseReportSearchFilter');


//Department
Route::post('departmentEdit', [DepartmentController::class, 'departmentEdit'])->name('departmentEdit');
Route::post('workflowEdit', [WorkflowController::class, 'workflowEdit'])->name('workflowEdit');
Route::post('projectEdit', [ProjectController::class, 'projectEdit'])->name('projectEdit');
Route::post('designationEdit', [DesignationController::class, 'designationEdit'])->name('designationEdit');
Route::post('employeeEdit', [EmployeeController::class, 'employeeEdit'])->name('employeeEdit');
Route::post('documentTypeEdit', [DocumentTypeController::class, 'documentTypeEdit'])->name('documentTypeEdit');
Route::post('privilageEdit', [RolesController::class, 'privilageEdit'])->name('privilageEdit');
Route::post('userEdit', [UserController::class, 'userEdit'])->name('userEdit');



//Approval List
Route::get('approvalListIndex', [ApprovalListController::class, 'index'])->name('approvalListIndex');
Route::post('approvedDocsView', [ApprovalListController::class, 'approvedDocsView'])->name('approvedDocsView');
Route::post('approvedDocsDownload', [ApprovalListController::class, 'approvedDocsDownload'])->name('approvedDocsDownload');

});
Route::get('/', function () {
    return redirect(route('login'));
});

// Auth::routes();
Auth::routes(['reset' => false]);
Route::get('tempOpen/{id}', [BasicController::class, 'tempOpen'])->name('tempOpen');
