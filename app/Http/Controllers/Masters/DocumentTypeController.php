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
        $document = DocumentType::select('document_types.*', 'workflows.workflow_code', 'workflows.workflow_name', 'workflows.total_levels')
            ->leftjoin('workflows', 'workflows.id', '=', 'document_types.workflow_id')
            ->whereNull('document_types.deleted_at')
            ->get();
        $work_flow = Workflow::where('is_active', 1)->get()->toArray();
        $designation_edit = Designation::where('is_active', 1)->get();
        return view('Document/list', ['document' => $document, 'workflow' => $work_flow, 'designation_edit' => $designation_edit]);
    }
    public function create()
    {
        $model = array();
        $workflow = Workflow::where('is_active', 1)->whereNull('deleted_at')->get();
        return view('Document/DocTypeDetails', compact('model', 'workflow'));
    }
    public function edit($id)
    {

        $model = DocumentType::findOrFail($id);


        $workflow = Workflow::whereNull('deleted_at')->get();
        return view('Document/DocTypeDetails', compact('model', 'workflow'));
    }
    public function validation(Request $request)
    {

        $model = DocumentType::where('name', $request->name)->where('id', '!=', $request->id)->whereNull('deleted_at')->first();

        $response = ($model) ? false : true;

        return response()->json(['response' => $response]);
    }

    public function store(Request $request)
    {


        $input = $request->all();
        if ($request->id) {
            $model = DocumentType::findOrFail($request->id);
            $msg = "Updated";
        } else {
            $msg = "stored";
            $model = new DocumentType();
        }
        $model->name = $request->name;
        $model->workflow_id = $request->workflow_id;
        $model->save();

        if ($model) {
            return redirect('documentType')->with('success', "Document Type " . $msg . " successfully.");
        } else {
            return redirect()->back()->withErrors(['error' => ['Insert Error']]);
        }
    }
    public function changedDocumentTypeActiveStatus(Request $request)
    {
        $status_update = DocumentType::where("id", $request->id)->update(["is_active" => $request->status]);
        echo json_encode($status_update);
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
    public function doctypeSearch(Request $request)
    {

        $searchData = $request->searchData;
        $model = DocumentType::select('document_types.*', 'workflows.workflow_code', 'workflows.workflow_name', 'workflows.total_levels')
            ->leftjoin('workflows', 'workflows.id', '=', 'document_types.workflow_id')
            ->where(function ($query) use ($searchData) {
                $query->where('document_types.name', 'LIKE', '%' . $searchData . '%')
                    ->orWhere('workflows.workflow_name', 'LIKE', '%' . $searchData . '%');
            })
            ->whereNull('document_types.deleted_at')
            ->get();
        
        return response()->json($model);
    }
}
