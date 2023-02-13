<?php

namespace App\Http\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee_all = $this->get_all_employee();
        $employees = Employee::where('is_active', 1)->get()->toArray();
        $departments = Department::where('is_active', 1)->get()->toArray();
        $designation = Designation::where('is_active', 1)->get()->toArray();
        return view('Employee/list', ['employee_all' => $employee_all, 'employee' => $employees, 'departments' => $departments, 'designation' => $designation]);
    }


    public function get_all_employee()
    {
        $employees = DB::table('employees as e')
            ->select('*', 'd.id as department_id', 'd.name as department_name', 'de.id as designation_id', 'de.name as designation_name', 'e.is_active as employee_status')
            ->join('departments as d', 'd.id', '=', 'e.department_id')
            ->join('designations as de', 'de.id', '=', 'e.designation_id')
            ->get();
        return $employees;
    }

    public function getDetailsById(Request $request)
    {
        $id = $request->emp_id;
        $employees = DB::table('employees as e')
            ->select('*', 'd.name as department_name', 'de.name as designation_name', 'e.is_active as employee_status')
            ->join('departments as d', 'd.id', '=', 'e.department_id')
            ->join('designations as de', 'de.id', '=', 'e.designation_id')
            ->where('e.id', '=', $id)
            ->get();
        echo json_encode($employees);
    }
    public function store(Request $request)
    {

        if ($request->hasFile('profile_image')) {

            $image = $request->file('profile_image');
            $profile_image = "p" . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $profile_image);
            $new_excel_path = $_SERVER['DOCUMENT_ROOT'].'/images/'.$profile_image;
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheet = $reader->load("$new_excel_path");
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
            $pdf_path = $destinationPath.'/'. "fds" . '.pdf';
            echo '<br>';
            echo $pdf_path;
            $writer->save($pdf_path);
            die();
        } else {
            $profile_image = DB::table('employees')->where(['id' => $request->id])->value('profile_image');
        }

        if ($request->hasFile('sign_image')) {
            $image = $request->file('sign_image');
            $sign_image = "s" . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $sign_image);
        } else {
            $sign_image = DB::table('employees')->where(['id' => $request->id])->value('sign_image');
        }

        $input = $request->all();
        unset($input['_token']);
        $input['profile_image'] = $profile_image;
        $input['sign_image'] = $sign_image;
        $id = Employee::updateOrInsert(
            ['id' => $request->id],
            $input
        );
        if ($id) {
            return redirect('employees')->with('success', "Employee Stored successfully.");
        } else {
            return redirect()->back()->withErrors(['error' => ['Insert Error']]);
        }
    }


    public function destroy($id)
    {

        $employee_update = Employee::where("id", $id)->update(["delete_flag" => 0]);
        echo json_encode($employee_update);
    }
}
