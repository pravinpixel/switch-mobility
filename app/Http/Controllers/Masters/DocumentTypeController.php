<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Project;
use App\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $document = $this->get_all_document_type();
        $work_flow = Workflow::where('is_active', 1)->get()->toArray();
        $designation_edit = Designation::where('is_active', 1)->get();
        return view('Document/list', ['document' => $document, 'workflow' => $work_flow, 'designation_edit' => $designation_edit]);
    }

    public function get_all_document_type()
    {
        $document = DB::table('document_types as d')
            ->select('*', 'd.id as document_type_id')
            ->join('workflows as wl', 'wl.id', '=', 'd.workflow_id')
            ->where('d.is_active', 1)
            ->whereNull('d.deleted_at')
            ->get();
        return $document;
    }

    public function store(Request $request)
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
            return redirect('documentType')->with('error', "Document Type Already Exists.");
        }
    }


    public function destroy($id)
    { 
        $checkChildData = Project::where('document_type_id', $id)->first();
        if ($checkChildData) {
            $data = [
                "message" => "Failed",
                "data" => "Document Type already exist.cannot delete."
            ];
        } else {
            $model = DocumentType::where("id", $id)->delete();
            $data = [
                "message" => "Success",
                "data" => "Document Type Deleted Successfully."
            ];
        }
        return response()->json($data);
    }
}
