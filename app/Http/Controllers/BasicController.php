<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BasicController extends Controller
{
    public function tempOpen($id)
    {
        Session::put('tempProject', $id);
        if (Auth::check()) {
            $content = new Request(['id' => Session::get('tempProject')]);

            $transactionController = app()->make(Doclistings::class);
            return $transactionController->editDocument($content);
        } else {
           
            return redirect()->route('login',);
        }
    }

    public function BasicFunction()
    {
        $empId = Auth::user()->emp_id;
        if ($empId) {
          $employee = Employee::where('id', $empId)->first();
         
          $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;
          Session()->put('employeeId', $empId);
        } else {
          $name = "Admin";
          Session()->put('employeeId', "");
        }
        Session()->put('logginedUser', $name);
    }
}
