<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {


     
        // Check email already exists

        $department = Department::where('name', $row['department'])->first();
        if ($department) {
            $deptId = $department->id;
        } else {
            return null;
        }

        $designation = Designation::where('name', $row['designation'])->first();
        if ($designation) {
            $desId = $designation->id;
        } else {
            return null;
        }
        $isExistsSapId = Employee::whereNull('deleted_at')->where('sap_id', $row['sap_id'])->first();

        if ($isExistsSapId) {

            $email = Employee::whereNull('deleted_at')->where('email', $row['email'])->where('id','!=',$isExistsSapId->id)->first();

            if ($email) {
             
                return null;
            }
         
            $mobile = Employee::whereNull('deleted_at')->where('mobile', $row['mobile'])->first();

            if ($mobile) {
                return null;
            }  
            
            $employee = Employee::where('id',$isExistsSapId->id)->first();
         
            $employee->first_name = $row['first_name'];
            $employee->middle_name = $row['middle_name'];
            $employee->last_name = $row['last_name'];
            $employee->email = $row['email'];
            $employee->mobile = $row['mobile'];
            $employee->department_id = $deptId;
            $employee->designation_id = $desId;
            $employee->sap_id = $row['sap_id'];
            $employee->save();
            return $employee;
        } else {

            $count = Employee::where('email', $row['email'])->count();
            if ($count > 0) {
                return null;
            }

            $count = Employee::where('mobile', $row['mobile'])->count();
            if ($count > 0) {
                return null;
            }
            return new Employee([
                'first_name' => $row['first_name'],
                'middle_name' => $row['middle_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'mobile' => $row['mobile'],
                'department_id' => $deptId,
                'designation_id' => $desId,
                'sap_id' => $row['sap_id'],
            ]);
        }
    }
    public function rules(): array
    {

        return [
            'first_name' => 'required|string',
            '*.first_name' => 'required|string',
            'middle_name' => 'required|string',
            '*.middle_name' => 'required|string',
            'last_name' => 'required|string',
            '*.last_name' => 'required|string',
            // 'email' => 'required|email|unique:employees',
            // '*.email' => 'required|email|unique:employees',
            // 'mobile' => 'required|min:11|numeric|unique:employees',
            // '*.mobile' => 'required|min:11|numeric|unique:employees',
            'department' => 'required|string',
            '*.department' => 'required|string',
            'designation' => 'required|string',
            '*.designation' => 'required|string',
        ];
    }
}
