<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectDocumentDetail;
use App\Models\ProjectEmployee;
use App\Models\ProjectMilestone;
use App\Models\Workflow;
use App\Models\WorkflowLevelDetail;
use App\Models\Workflowlevels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;


use Illuminate\Support\Facades\Redirect;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use Dompdf\Dompdf as BaseDompdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Imagick;
use PDF;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf as PdfWriter;

class ApprovalListController extends Controller
{
    protected $tempController;
    public function __construct(ApprovalListTempController $tempController)
    {
        $this->tempController = $tempController;
    }

    public function index()
    {
        $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";

        $models = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
        if ($empId) {
            $models->whereHas('projectEmployees', function ($q) use ($empId) {
                if ($empId != "") {
                    $q->where('employee_id', '=', $empId);
                }
            });
        }

        $models->whereNull('deleted_at');
        $datas = $models->get();


        return view('Transaction/approvalList/index', compact('datas'));
    }

    public function approvedDocsView(Request $request)
    {

        $id = $request->id;


        $project_details = DB::table('projects as p')
            ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
            ->leftJoin('workflows as w', 'w.id', '=', 'p.workflow_id')
            ->leftjoin('employees as e', 'e.id', '=', 'p.initiator_id')
            ->leftjoin('departments as d', 'd.id', '=', 'e.department_id')
            ->leftjoin('document_types as doc', 'doc.id', '=', 'p.document_type_id')
            ->leftjoin('designations as des', 'des.id', '=', 'e.designation_id')
            ->where("p.id", '=', $id)
            ->select('p.ticket_no', 'p.created_at', 'p.id', 'p.project_name', 'p.project_code', 'e.profile_image', 'des.name as designation', 'doc.name as document_type', 'w.workflow_code', 'w.workflow_name', 'e.first_name', 'e.last_name', 'd.name as department', 'p.is_active');
        $details = $project_details->first();


        $models = ProjectDocumentDetail::select('project_documents.original_name', 'project_documents.id')->leftjoin('project_documents', 'project_documents.id', '=', 'project_document_details.project_doc_id')
            ->where('project_document_details.project_id', $id)
            ->where('project_documents.type', 1)
            ->where('project_document_details.status', 4)
            ->get();


        $milestoneDatas = ProjectMilestone::where('project_id', $id)->get();

        return view('Transaction/approvalList/view', ['models' => $models, 'milestoneDatas' => $milestoneDatas, 'details' => $details]);
    }
    public function approvedDocsDownload1(Request $request)
    {

        $id = $request->id;

        $frontSheet = $this->tempController->frontPdf($id);


        $endSheet = $this->tempController->FooterPdf($id);


        $models = ProjectDocumentDetail::leftjoin('project_documents', 'project_documents.id', '=', 'project_document_details.project_doc_id')
            ->where('project_document_details.project_id', $id)
            ->where('project_documents.type', 1)
            ->where('project_document_details.status', 4)
            ->get();

        if (count($models)) {

            $destinationPath = public_path('/temp/' . $id);
            if (File::exists($destinationPath)) {

                File::deleteDirectory($destinationPath);
            }

            File::makeDirectory($destinationPath, 0777, true, true);

            foreach ($models as $key => $model) {



                $path = public_path('projectDocuments/' . $model->document_name);

                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $pdf_path = $destinationPath . '/' . ($key + 1) .  "." . ($key + 1) . '.pdf';
                $frontSheetpath = $destinationPath . '/' . ($key + 1) . "." . ($key + 1) . "." . ($key + 1) . '.pdf';
                $endSheetpath = $destinationPath . '/' . ($key + 1) . '.pdf';


                File::copy($frontSheet, $frontSheetpath);


                if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

                    // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
                    // $spreadsheet = $reader->load("$path");
                    // Log::info("passedLine no 100 term ".$key+1);
                    // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
                    // Log::info("passedLine no 102 term ".$key+1);
                    // $writer->save($pdf_path);
                    Log::info("passedLine no 103 term " . $key + 1);
                    // Load the Excel file
                    // Load the Excel file
                    // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
                    // // Convert the Excel file to PDF
                    // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Dompdf');
                    // $writer->save($pdf_path);
                    // Load the Excel file
                    // Load the Excel file
                    $spreadsheet = IOFactory::load($path);

                    // Set the active sheet
                    $spreadsheet->setActiveSheetIndex(0);
                    // Create a PDF writer
                    $pdfWriter = new Dompdf($spreadsheet);
                    $pdfWriter->save($pdf_path);
                    // Set the PDF orientation and paper size
                    //  $pdfWriter->setPaper(BaseDompdf::PAPER_LETTER);
                    // $pdfWriter->setOrientation(BaseDompdf::ORIENTATION_PORTRAIT);


                    // Loop through all the sheets              




                    Log::info("passedLine no 110 term " . $key + 1);
                } else {

                    File::copy($path, $pdf_path);
                }
                File::copy($endSheet, $endSheetpath);
            }
            Log::info("passedLine no 111 ter ");

            $files = File::allFiles($destinationPath);
            // $sheetq = $this->tempController->genarate($destinationPath);

            $pdf = new Fpdi();

            // Merge all PDF files into a single file
            foreach ($files as $key => $file) {
                // dd($key);
                // if($key == 1){
                //     dd("well");
                // }


                $pageCount = $pdf->setSourceFile($file->getPathname());

                for ($i = 1; $i <= $pageCount; $i++) {
                    $template = $pdf->importPage($i);
                    $pdf->AddPage();

                    $pdf->useTemplate($template);
                }
            }
            Log::info("passedLine no 132 ter ");
            $pdf->Output('merged.pdf', 'I');
        } else {
            $msg = "Approved Docs Not Available!";
            return Redirect::back()->withErrors($msg);
        }
    }
    public function fileDownload($path, $key)
    {

        $headers = array(
            'Content-Type: application/pdf',
        );
        $fileName = "Documents" . ($key + 1) . ".pdf";

        return response()->download($path, $fileName);
    }
    public function approvedDocsDownload(Request $request)
    {


        // // Load the Excel file
        // $spreadsheet = IOFactory::load(public_path('temp/FinancialSample.xlsx'));

        // // Create a PDF writer
        // $writer = new Dompdf($spreadsheet);

        // // Save the PDF file
        // $writer->save(public_path('temp/file1.pdf'));

        $id = $request->id;
        $model = ProjectDocumentDetail::with('documentName')->where('project_doc_id', $id)
            ->where('is_latest', 1)
            ->first();
        $projectDocModel = $model->documentName;
        $projectId = $projectDocModel->project_id;
        $project = Project::with('docType', 'employee', 'employee.department', 'workflow')->where('id', $projectId)->first();
        $projectApprovers = $this->projectApprovers($projectId);

        $docModel  = $project->docType;

        $employeeModel  = $project->employee;

        $departmentModel  = $employeeModel->department;

        $workflowModel  = $project->workflow;

        $timestamp = strtotime($project->created_at);
        $date = date('d-m-Y', $timestamp);

        $docName = ($docModel) ? $docModel->name : "";
        $workflowName = ($workflowModel) ? $workflowModel->workflow_name : "";
        $workflowCode = ($workflowModel) ? $workflowModel->workflow_code : "";
        $department  = ($departmentModel) ? $departmentModel->name : "";
        $employeeName = ($employeeModel) ? $employeeModel->first_name . " " . $employeeModel->last_name : "";
        $extension = \File::extension($model->document_name);

        if ($extension == "xlsx") {

            $xltoPdf = public_path('/xlToPdf' . '/' . $request->id);
            $newPdfName = "temp.pdf";
            $pdfPath = $xltoPdf . '/' . $newPdfName;

            if (File::exists($xltoPdf)) {

                File::deleteDirectory($xltoPdf);
            }
            File::makeDirectory($xltoPdf, $mode = 0777, true, true);
            $xlPath = public_path('projectDocuments/' . $model->document_name);

            $spreadsheet = IOFactory::load($xlPath);

            // Create a PDF Writer
            $writer = new PdfWriter($spreadsheet);

            // Save the PDF file
            $writer->save($pdfPath);
          
        } else {
            $pdfPath = public_path('projectDocuments/' . $model->document_name);
        }


        $imagePath = public_path('DocumentImages/' . $id);
        if (File::exists($imagePath)) {

            File::deleteDirectory($imagePath);
        }
        File::makeDirectory($imagePath, $mode = 0777, true, true);

        $imagick = new Imagick();
        $imagick->readImage($pdfPath);
        $imagick->setImageFormat('png');


        foreach ($imagick as $pageNumber => $page) {
            // Set the image quality (0-100, where 100 is the best quality)
            $page->setImageCompressionQuality(100);
            // Save each page as an image
            $currentPath = 'img' . ($pageNumber + 1) . '.png';
            $imgpath1 = $imagePath . '/' . $currentPath;

            $page->writeImage($imgpath1);

            // $model = new Accounting();
            // $model->path = $currentPath;
            // $model->save();
        }
        // Close the Imagick object
        $imagick->clear();
        $imagick->destroy();
        $imagefiles = File::allFiles($imagePath);
        $pdfPath1 = storage_path('app/finalPdf');

        if (File::exists($pdfPath1)) {

            File::deleteDirectory($pdfPath1);
        }

        foreach ($imagefiles as $key => $imagefile) {
            $pathName = $imagefile->getPathname();

            $data = [
                'imagePath' => $pathName,
                'logo'    => public_path('assets/media/logos/limage.png'),
                'ticketNo'         => ($project) ? $project->ticket_no : "",
                'projectCode'      => ($project) ? $project->project_code : "",
                'projectName' => ($project) ? $project->project_name : "",
                'date'        => $date,
                'docName'         => $docName,
                'workflowCode'      => $workflowCode,
                'workflowName' => $workflowName,
                'department'        => $department,
                'initiater' => $employeeName,
                'projectApprovers' => $projectApprovers
            ];

            $pdf = PDF::loadView('pdf.pdf', $data);
            $fname = "invoice" . ($key + 1) . ".pdf";
            // Set margins to 0
            // Set margin option to 0
            // $pdf->setOption('margin-top', 0);
            // $pdf->setOption('margin-right', 0);
            // $pdf->setOption('margin-bottom', 0);
            // $pdf->setOption('margin-left', 0);
            Storage::put('finalPdf/' . $fname, $pdf->output());
        }
        $ffiles = File::allFiles(storage_path('app/finalPdf'));
        // $sheetq = $this->tempController->genarate($destinationPath);

        $pdf = new Fpdi();

        // Merge all PDF files into a single file
        foreach ($ffiles as $key => $ffile) {
            // dd($key);
            // if($key == 1){
            //     dd("well");
            // }


            $pageCount = $pdf->setSourceFile($ffile->getPathname());

            for ($i = 1; $i <= $pageCount; $i++) {
                $template = $pdf->importPage($i);
                $pdf->AddPage();

                $pdf->useTemplate($template);
            }
        }
        Log::info("passedLine no 132 ter ");
        return $pdf->Output('ApprovedDocs.pdf', 'I');
    }

    public function projectApprovers($projectId)
    {

        $models = ProjectEmployee::with('employee', 'employee.designation')->where('project_id', $projectId)->where('type', 2)->groupby('project_employees.employee_id')->orderby('project_employees.level')->limit(11)->get();

        $entities = collect($models)->map(function ($model) {

            $empModel = $model['employee'];
            $appproverName = "";
            $designation = "";
            if ($empModel) {
                $designationModel = $empModel['designation'];
                $appproverName = $empModel['first_name'] . $empModel['last_name'];
                if ($designationModel) {
                    $designation = $designationModel->name;
                }
            }
            $signImage = ($empModel->sign_image) ? $empModel->sign_image : "noimage.png";
            $signImageWithPath = public_path('images/employee/' . $signImage);
            $updateDate =  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $model->updated_at)->format('d-m-Y');

            $resData = ['appproverName' => $appproverName, 'designation' => $designation, 'level' => $model->level, 'updatedate' => $updateDate, 'signImageWithPath' => $signImageWithPath];
            return $resData;
        });
        return $entities;
    }
}
