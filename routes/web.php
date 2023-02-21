<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Doclistings;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProjectController;

use App\Http\Controllers\Masters\DepartmentController;
use App\Http\Controllers\Masters\DesignationController;
use App\Http\Controllers\Masters\DocumentTypeController;

use App\Http\Controllers\settings\RolesController;
use App\Http\Controllers\settings\UserController;
use App\Http\Controllers\WorkflowController;
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
    'middleware' => ['auth','is_admin','web']
], function () {
    Route::get('home', [HomeController::class, 'adminHome'])->name('home');
    Route::resource('roles', RolesController::class);
    //Dept
    Route::resource('dashboard', DashboardController::class);
    Route::resource('doclisting', Doclistings::class);
    Route::post('docListingSearch', [Doclistings::class, 'docListingSearch'])->name('docListingSearch');
    Route::post('Search', [Doclistings::class, 'Search'])->name('Search')->middleware('is_admin');
    Route::resource('department', DepartmentController::class);
    Route::post('departmentValidation', [DepartmentController::class, 'departmentValidation'])->name('departmentValidation');

    Route::post('changedepartmentActiveStatus', [DepartmentController::class, 'changedepartmentActiveStatus'])->name('changedepartmentActiveStatus');
    Route::post('changedesignationActiveStatus', [DesignationController::class, 'changedesignationActiveStatus'])->name('changedesignationActiveStatus');
    
    Route::resource('designation', DesignationController::class);
    Route::resource('documentType', DocumentTypeController::class);
    Route::resource('employees', EmployeeController::class);
    Route::post('changeEmployeeActiveStatus', [EmployeeController::class, 'changeActiveStatus'])->name('changeActiveStatus');
    Route::post('employeeDetailById', [EmployeeController::class, 'employeeDetailById'])->name('employeeDetailById');
    Route::post('employeeDetailByDesDept', [EmployeeController::class, 'employeeDetailByDesDept'])->name('employeeDetailByDesDept');

    Route::post('getDetailsById', [EmployeeController::class, 'getDetailsById'])->name('getDetailsById')->middleware('is_admin');
    Route::post('getEmployeeDetailByParams', [EmployeeController::class, 'getEmployeeDetailByParams'])->name('getEmployeeDetailByParams');
    Route::resource('projects', ProjectController::class);
    Route::post('employeeSearch', [EmployeeController::class, 'employeeSearch'])->name('employeeSearch');

    Route::post('projectCodeValidation', [ProjectController::class, 'projectCodeValidation'])->name('projectCodeValidation');
    Route::post('projectNameValidation', [ProjectController::class, 'projectNameValidation'])->name('projectNameValidation');
    
    Route::post('getWorkflowByDocumentType', [ProjectController::class, 'getWorkflowByDocumentType'])->name('getWorkflowByDocumentType')->middleware('is_admin');
    Route::post('getEmployeeByWorkFlow', [ProjectController::class, 'getEmployeeByWorkFlow'])->name('getEmployeeByWorkFlow')->middleware('is_admin');
    Route::get('viewProject/{id}', [ProjectController::class, 'viewProject'])->name('viewProject')->middleware('is_admin');
    Route::post('deleteDocument', [ProjectController::class, 'deleteDocument'])->name('deleteDocument')->middleware('is_admin');
    Route::post('getProjectDetailsById', [ProjectController::class, 'getProjectDetailsById'])->name('getProjectDetailsById')->middleware('is_admin');
    Route::post('getProjectLevel', [ProjectController::class, 'getProjectLevel'])->name('getProjectLevel')->middleware('is_admin');
    Route::post('getProjectDocs', [ProjectController::class, 'getProjectDocs'])->name('getProjectDocs')->middleware('is_admin');
    Route::post('docStatus', [ProjectController::class, 'docStatus'])->name('docStatus')->middleware('is_admin');
    Route::resource('workflow', WorkflowController::class);
    Route::post('getWorkflowById', [WorkflowController::class, 'getWorkflowById'])->name('getWorkflowById')->middleware('is_admin');
    Route::post('changeWorkflowActiveStatus', [WorkflowController::class, 'changeWorkflowActiveStatus'])->name('changeWorkflowActiveStatus');
   
    Route::post('getWorkflowLevels', [WorkflowController::class, 'getWorkflowLevels'])->name('getWorkflowLevels')->middleware('is_admin');
    Route::post('workflowValidation', [WorkflowController::class, 'workflowValidation'])->name('workflowValidation');

    Route::post('uploadDocumentVersion', [ProjectController::class, 'uploadDocumentVersion'])->name('uploadDocumentVersion');
    Route::resource('roles', RolesController::class);
    Route::post('roleNameValidation', [RolesController::class, 'roleNameValidation'])->name('roleNameValidation');
    Route::resource('users', UserController::class);

    Route::post('getWorkflowByProjectId', [ProjectController::class, 'getWorkflowByProjectId'])->name('getWorkflowByProjectId');


});
// Route::get('departments', [MasterController::class, 'Departments'])->name('departments')->middleware('is_admin');
// Route::post('store_department', [MasterController::class, 'store_department'])->name('store_department')->middleware('is_admin');
// Route::post('deleteDepartment', [MasterController::class, 'deleteDepartment'])->name('deleteDepartment')->middleware('is_admin');
// Designation
// Route::get('designation', [MasterController::class, 'Designation'])->name('designation')->middleware('is_admin');
// Route::post('store_designation', [MasterController::class, 'store_designation'])->name('store_designation')->middleware('is_admin');
// Route::post('deleteDesignation', [MasterController::class, 'deleteDesignation'])->name('deleteDesignation')->middleware('is_admin');
//Document Tpe
// Designation
// Route::get('document', [MasterController::class, 'Document'])->name('document')->middleware('is_admin');
// Route::post('storeDocument', [MasterController::class, 'storeDocument'])->name('storeDocument')->middleware('is_admin');
// Route::post('deleteDocument', [MasterController::class, 'deleteDocument'])->name('deleteDocument')->middleware('is_admin');

//Emplpoyee
// Route::get('employee', [EmployeeController::class, 'Employee'])->name('employee')->middleware('is_admin');
// Route::post('storeEmployee', [EmployeeController::class, 'storeEmployee'])->name('storeEmployee')->middleware('is_admin');
// Route::post('deleteEmployee', [EmployeeController::class, 'deleteEmployee'])->name('deleteEmployee')->middleware('is_admin');

//Project
//Route::get('project', [ProjectController::class, 'Project'])->name('project')->middleware('is_admin');
// Route::post('storeProject', [ProjectController::class, 'storeProject'])->name('storeProject')->middleware('is_admin');
// Route::post('deleteProject', [ProjectController::class, 'deleteProject'])->name('deleteProject')->middleware('is_admin');

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();

