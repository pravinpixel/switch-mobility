<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Workflow;
use App\Models\Workflowlevels;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function Departments()
    {
        $departments = Department::where('is_active', 1)->get()->toArray();
        return view('Departments/list', ['departments' => $departments]);
    }
    public function store_department(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        $id = Department::updateOrInsert(
            ['id' => $request->id],
            $input
        );
        if ($id) {
            return redirect('departments')->with('success', "Department Stored successfully.");
        } else {
            return redirect()->back()->withErrors(['error' => ['Insert Error']]);
        }
    }

    public function deleteDepartment(Request $request)
    {
        $id = $request->id;
        $department_update = Department::where("id", $id)->update(["is_active" => 0]);
        echo json_encode($department_update);
    }


    public function Designation()
    {
        $designation = Designation::where('is_active', 1)->get()->toArray();
        return view('Designation/list', ['designation' => $designation]);
    }
    public function store_designation(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        $id = Designation::updateOrInsert(
            ['id' => $request->id],
            $input
        );
        if ($id) {
            return redirect('designation')->with('success', "Designation Stored successfully.");
        } else {
            return redirect()->back()->withErrors(['error' => ['Insert Error']]);
        }
    }

    public function deleteDesignation(Request $request)
    {
        $id = $request->id;
        $designation_update = Designation::where("id", $id)->update(["is_active" => 0]);
        echo json_encode($designation_update);
    }

    public function Document()
    {
        $document = DocumentType::where('is_active', 1)->get()->toArray();

        return view('Document/list', ['document' => $document]);
    }

    public function storeDocument(Request $request)
    {
        $input = $request->all();
        if ($request->id == "") {
            $check = DocumentType::where('name', $request->name)->pluck('id')->first();
        } else {
            $check = null;
        }
        if ($check == null) {
            unset($input['_token']);
            $id = DocumentType::updateOrInsert(
                ['id' => $request->id],
                $input
            );
            if ($id) {
                return redirect('documentType')->with('success', "Document Stored successfully.");
            } else {
                return redirect()->back()->withErrors(['error' => ['Insert Error']]);
            }
        } else {
            return redirect('documentType')->with('error', "Document Type already exists.");
        }
    }

    public function deleteDocument(Request $request)
    {
        $id = $request->id;
        $document_update = DocumentType::where("id", $id)->update(["is_active" => 0]);
        echo json_encode($document_update);
    }
}
