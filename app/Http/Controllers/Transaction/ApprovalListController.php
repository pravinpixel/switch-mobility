<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\BasicController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Doclistings;
use App\Models\Department;
use App\Models\Designation;
use App\Models\DocumentType;
use App\Models\Employee;
use App\Models\Project;
use App\Models\projectDocument;
use App\Models\ProjectDocumentDetail;
use App\Models\ProjectEmployee;
use App\Models\ProjectMilestone;
use App\Models\Workflow;
use App\Models\WorkflowLevelDetail;
use App\Models\Workflowlevels;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Redirect;

use PhpOffice\PhpSpreadsheet\IOFactory;
//use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use Dompdf\Dompdf as BaseDompdf;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Imagick;
use PDF;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf as PdfWriter;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Intervention\Image\ImageManagerStatic as Image;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment as Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border as Border;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Tcpdf;

class ApprovalListController extends Controller
{
    protected $tempController, $docsController, $basic;
    public function __construct(ApprovalListTempController $tempController, Doclistings $docsController, BasicController $basic)
    {
        $this->tempController = $tempController;
        $this->docsController = $docsController;
        $this->basic = $basic;
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
        $models->orderBy('id', 'desc');
        $datas = $models->get();
        $projects = $datas;
        $employees = $this->basic->getAllEmployeByProject($projects);

      
        $departments = Department::where(['is_active' => 1])->get();
        $designation = Designation::where(['is_active' => 1])->get();
        $document_type = DocumentType::where(['is_active' => 1])->get();
        $workflow = Workflow::where(['is_active' => 1])->get();


        return view('Transaction/approvalList/index', compact('employees', 'departments', 'designation', 'document_type', 'workflow', 'projects'));
    }

    public function approvedDocsView(Request $request)
    {

        $id = $request->id;
        $lastLevel = $this->docsController->getLastLevelProject($id);


        $project_details = DB::table('projects as p')
            ->leftjoin('project_levels as pl', 'pl.project_id', '=', 'p.id')
            ->leftJoin('workflows as w', 'w.id', '=', 'p.workflow_id')
            ->leftjoin('employees as e', 'e.id', '=', 'p.initiator_id')
            ->leftjoin('departments as d', 'd.id', '=', 'e.department_id')
            ->leftjoin('document_types as doc', 'doc.id', '=', 'p.document_type_id')
            ->leftjoin('designations as des', 'des.id', '=', 'e.designation_id')
            ->where("p.id", '=', $id)
            ->select('p.ticket_no', 'p.created_at', 'p.id', 'p.project_name', 'p.project_code','e.middle_name',  'e.profile_image', 'des.name as designation', 'doc.name as document_type', 'w.workflow_code', 'w.workflow_name', 'e.first_name', 'e.last_name', 'd.name as department', 'p.is_active');
        $details = $project_details->first();


        $models = ProjectDocumentDetail::select('document_name', 'project_documents.original_name', 'project_documents.id', 'project_documents.project_id as projectId')
            ->leftjoin('project_documents', 'project_documents.id', '=', 'project_document_details.project_doc_id')
            ->where('project_document_details.project_id', $id)
            ->where('project_documents.type', 1)
            ->where('project_document_details.is_latest', 1)
            ->where('project_document_details.upload_level', $lastLevel)
            ->where('project_document_details.status', 4)
            ->groupby('project_document_details.id')
            ->get();



        $milestoneDatas = ProjectMilestone::where('project_id', $id)->get();

        return view('Transaction/approvalList/view', ['models' => $models, 'milestoneDatas' => $milestoneDatas, 'details' => $details]);
    }
    // public function approvedDocsDownload1(Request $request)
    // {

    //     $id = $request->id;

    //     $frontSheet = $this->tempController->frontPdf($id);


    //     $endSheet = $this->tempController->FooterPdf($id);


    //     $models = ProjectDocumentDetail::leftjoin('project_documents', 'project_documents.id', '=', 'project_document_details.project_doc_id')
    //         ->where('project_document_details.project_id', $id)
    //         ->where('project_documents.type', 1)
    //         ->where('project_document_details.status', 4)
    //         ->get();

    //     if (count($models)) {

    //         $destinationPath = public_path('/temp/' . $id);
    //         if (File::exists($destinationPath)) {

    //             File::deleteDirectory($destinationPath);
    //         }

    //         File::makeDirectory($destinationPath, 0777, true, true);

    //         foreach ($models as $key => $model) {



    //             $path = public_path('projectDocuments/' . $model->document_name);

    //             $extension = pathinfo($path, PATHINFO_EXTENSION);
    //             $pdf_path = $destinationPath . '/' . ($key + 1) .  "." . ($key + 1) . '.pdf';
    //             $frontSheetpath = $destinationPath . '/' . ($key + 1) . "." . ($key + 1) . "." . ($key + 1) . '.pdf';
    //             $endSheetpath = $destinationPath . '/' . ($key + 1) . '.pdf';


    //             File::copy($frontSheet, $frontSheetpath);


    //             if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

    //                 // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
    //                 // $spreadsheet = $reader->load("$path");
    //                 // Log::info("passedLine no 100 term ".$key+1);
    //                 // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
    //                 // Log::info("passedLine no 102 term ".$key+1);
    //                 // $writer->save($pdf_path);
    //                 Log::info("passedLine no 103 term " . $key + 1);
    //                 // Load the Excel file
    //                 // Load the Excel file
    //                 // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
    //                 // // Convert the Excel file to PDF
    //                 // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Dompdf');
    //                 // $writer->save($pdf_path);
    //                 // Load the Excel file
    //                 // Load the Excel file
    //                 $spreadsheet = IOFactory::load($path);

    //                 // Set the active sheet
    //                 $spreadsheet->setActiveSheetIndex(0);
    //                 // Create a PDF writer
    //                 $pdfWriter = new Dompdf($spreadsheet);
    //                 $pdfWriter->save($pdf_path);
    //                 // Set the PDF orientation and paper size
    //                 //  $pdfWriter->setPaper(BaseDompdf::PAPER_LETTER);
    //                 // $pdfWriter->setOrientation(BaseDompdf::ORIENTATION_PORTRAIT);


    //                 // Loop through all the sheets              




    //                 Log::info("passedLine no 110 term " . $key + 1);
    //             } else {

    //                 File::copy($path, $pdf_path);
    //             }
    //             File::copy($endSheet, $endSheetpath);
    //         }
    //         Log::info("passedLine no 111 ter ");

    //         $files = File::allFiles($destinationPath);
    //         // $sheetq = $this->tempController->genarate($destinationPath);

    //         $pdf = new Fpdi();

    //         // Merge all PDF files into a single file
    //         foreach ($files as $key => $file) {
    //             // dd($key);
    //             // if($key == 1){
    //             //     dd("well");
    //             // }


    //             $pageCount = $pdf->setSourceFile($file->getPathname());

    //             for ($i = 1; $i <= $pageCount; $i++) {
    //                 $template = $pdf->importPage($i);
    //                 $pdf->AddPage();

    //                 $pdf->useTemplate($template);
    //             }
    //         }
    //         Log::info("passedLine no 132 ter ");
    //         $pdf->Output('merged.pdf', 'd');
    //     } else {
    //         $msg = "Approved Docs Not Available!";
    //         return Redirect::back()->withErrors($msg);
    //     }
    // }
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
        $LibreOfficePath = config('app.LibreOfficePath');
        $environment = config('app.env');
        // // Load the Excel file
        // $spreadsheet = IOFactory::load(public_path('temp/FinancialSample.xlsx'));

        // // Create a PDF writer
        // $writer = new Dompdf($spreadsheet);

        // // Save the PDF file
        // $writer->save(public_path('temp/file1.pdf'));
        $uploadFolder = public_path('uploads');
        if (!File::exists($uploadFolder)) {
            mkdir($uploadFolder . '/', 0777, true);
        }
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

        $filePath = public_path('projectDocuments/' . $model->document_name);
        $filenameWithoutExtension = pathinfo($filePath, PATHINFO_FILENAME);
        //  dd($extension);
        if ($extension == "xlsx" || $extension == "xls") {

            $pdfLocationFolder = public_path('temp_pdf') . '/' . $request->id;

            if (File::exists($pdfLocationFolder)) {

                File::deleteDirectory($pdfLocationFolder);
            }
            if (!File::exists($pdfLocationFolder)) {
                mkdir($pdfLocationFolder . '/', 0777, true);
            }


            if ($environment === 'local') {
                $command = "\"$LibreOfficePath\" --headless --convert-to pdf --outdir " . escapeshellarg($pdfLocationFolder) . " " . escapeshellarg($filePath);
            } else {
                $command = "libreoffice --headless --convert-to pdf --outdir " . escapeshellarg($pdfLocationFolder) . " " . escapeshellarg($filePath);
            }

            exec($command, $output, $returnCode);

            $pdfPath = "";
            if ($returnCode === 0) {
                // Get the file extension
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                // Remove the file extension from the filename
                $originalFilename = basename($filePath, '.' . $extension);

                $pdfPath =  $pdfLocationFolder . '/' . $originalFilename . '.pdf';
            } else {

                dd('error', 'PDF conversion failed.');
            }

            if ($pdfPath == "") {


                dd('error', 'PDF conversion failed check Again .');
            }
        } else if ($extension == "pdf") {
            $pdfPath = public_path('projectDocuments/' . $model->document_name);
        } else if ($extension == "doc" || $extension == "docx") {

            $docsPath = public_path('projectDocuments/' . $model->document_name);

            $pdfLocationFolder = public_path('temp_pdf') . '/' . $request->id;
            if (File::exists($pdfLocationFolder)) {

                File::deleteDirectory($pdfLocationFolder);
            }
            if (!File::exists($pdfLocationFolder)) {
                mkdir($pdfLocationFolder . '/', 0777, true);
            }


            if ($environment === 'local') {
                $command = "\"$LibreOfficePath\" --headless --convert-to pdf --outdir " . escapeshellarg($pdfLocationFolder) . " " . escapeshellarg($docsPath);
            } else {
                $command = "libreoffice --headless --convert-to pdf --outdir " . escapeshellarg($pdfLocationFolder) . " " . escapeshellarg($docsPath);
            }

            exec($command, $output, $returnCode);
            $pdfPath = "";
            if ($returnCode === 0) {
                // Get the file extension
                $extension = pathinfo($docsPath, PATHINFO_EXTENSION);

                // Remove the file extension from the filename
                $originalFilename = basename($docsPath, '.' . $extension);

                $pdfPath =  $pdfLocationFolder . '/' . $originalFilename . '.pdf';
            } else {

                dd('error', 'PDF conversion failed.');
            }

            if ($pdfPath == "") {


                dd('error', 'PDF conversion failed check Again .');
            }
        } else {

            $docsPath = public_path('projectDocuments/' . $model->document_name);

            $pdfLocationFolder = public_path('temp_pdf') . '/' . $request->id;
            if (File::exists($pdfLocationFolder)) {

                File::deleteDirectory($pdfLocationFolder);
            }
            if (!File::exists($pdfLocationFolder)) {
                mkdir($pdfLocationFolder . '/', 0777, true);
            }

            $command = "\"C:\\Program Files\\LibreOffice\\program\\soffice.exe\" --headless --convert-to pdf --outdir " . escapeshellarg($pdfLocationFolder) . " " . escapeshellarg($docsPath);

            exec($command, $output, $returnCode);
            $pdfPath = "";
            if ($returnCode === 0) {
                // Get the file extension
                $extension = pathinfo($docsPath, PATHINFO_EXTENSION);

                // Remove the file extension from the filename
                $originalFilename = basename($docsPath, '.' . $extension);

                $pdfPath =  $pdfLocationFolder . '/' . $originalFilename . '.pdf';
            } else {

                dd('error', 'PDF conversion failed.');
            }

            if ($pdfPath == "") {


                dd('error', 'PDF conversion failed check Again .');
            }
        }

        $delimiter = '/';

        $lastPartFileName = Str::afterLast($pdfPath, $delimiter);
        $substringBeforeDotFileName = ($filenameWithoutExtension) ? $filenameWithoutExtension : Str::before($lastPartFileName, '.');

        $imagePath = public_path('DocumentImages/' . $id);

        if (File::exists($imagePath)) {
            File::deleteDirectory($imagePath);
        }
        File::makeDirectory($imagePath, $mode = 0777, true, true);

        $pf = $this->tempController->pdtToImage($pdfPath, $imagePath);
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
        $formatOrientationId = $project->document_orientation;
        $formatSizeId = $project->document_size;

        $pdf = new Fpdi();

        $formatOrientation = ($formatOrientationId == 1) ? "P" : "L";
        $formatPageSize = ($formatSizeId == 1) ? "A3" : "A4";

        // Merge all PDF files into a single file
        foreach ($ffiles as $key => $ffile) {


            $pageCount = $pdf->setSourceFile($ffile->getPathname());

            for ($i = 1; $i <= $pageCount; $i++) {
                $template = $pdf->importPage($i);
                // // $pdf->AddPage();
                // $pdf->AddPage('L', 'A4');
                // $pdf->useTemplate($template);

                if ($formatOrientation == "L" && $formatPageSize == "A4") {
                    $pdf->AddPage('L', 'A4');
                    $pdf->useTemplate($template, 0, 0, 280, 200);
                } elseif ($formatOrientation == "L" && $formatPageSize == "A3") {
                    $pdf->AddPage('L', 'A3');
                    $pdf->useTemplate($template, 0, 0, 420, 297);
                } elseif ($formatOrientation == "P" && $formatPageSize == "A3") {
                    $pdf->AddPage('P', 'A3');
                    $templateWidthInInches = 11.69; // 297 mm converted to inches
                    $templateHeightInInches = 16.54; // 420 mm converted to inches
                    $templateWidthInPoints = $templateWidthInInches * 72;
                    $templateHeightInPoints = $templateHeightInInches * 72;
                    $pdf->useTemplate($template, 0, 0, 297, 420);
                } else {
                    $pdf->AddPage();
                    $pdf->useTemplate($template);
                }
            }
        }
        Log::info("passedLine no 132 ter ");
        $dFilename = $substringBeforeDotFileName . '.pdf';

        return $pdf->Output($dFilename, 'd');
    }
    private function saveImageFromDrawing(Drawing $drawing, $uploadFolder)
    {
        $uploadFolder = public_path('uploads');
        if (!file_exists($uploadFolder)) {
            mkdir($uploadFolder, 0777, true);
        }
        $exactImagePath = uniqid('image_') . '.' . $drawing->getExtension();
        $imagePath = $uploadFolder . '/' . $exactImagePath;
        $ExPath = $drawing->getPath();
        // Check if the image format is supported
        $supportedFormats = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'webp'];
        $imageFormat = strtolower($drawing->getExtension());
        if (!in_array($imageFormat, $supportedFormats)) {
            // Handle unsupported format here (e.g., skip the image)
            return null;
        }
        file_put_contents($imagePath, file_get_contents($ExPath));
        // Process the image using Intervention Image
        $image = Image::make($imagePath);
        // Resize the image to fit within the original dimensions
        $originalWidth = $drawing->getWidth();
        $originalHeight = $drawing->getHeight();
        if ($originalWidth <= 0 || $originalHeight <= 0) {
            // Handle invalid dimensions here (e.g., skip the image)
            return null;
        }
        $image->fit($originalWidth, $originalHeight);
        // Perform any desired image manipulation or processing
        $image->save($imagePath);
        return $exactImagePath;
    }
    /**
     * Convert horizontal alignment from Excel to CSS
     * @param string $horizontalAlign
     * @return string
     */
    private function getHorizontalAlign($horizontalAlign)
    {
        switch ($horizontalAlign) {
            case Alignment::HORIZONTAL_LEFT:
                return 'left';
            case Alignment::HORIZONTAL_RIGHT:
                return 'right';
            case Alignment::HORIZONTAL_CENTER:
                return 'center';
            default:
                return 'left'; // Default to left alignment if not specified
        }
    }
    /**
     * Convert border style from Excel to CSS
     * @param string $borderStyle
     * @return string
     */
    private function getBorderStyle($borderStyle)
    {
        switch ($borderStyle) {
            case Border::BORDER_NONE:
                return 'none';
            case Border::BORDER_THIN:
                return 'solid';
            case Border::BORDER_DASHED:
                return 'dashed';
            case Border::BORDER_DOTTED:
                return 'dotted';
            default:
                return 'none'; // Default to no border if not specified
        }
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
            $signImageWithPath = public_path('images/Employee/' . $signImage);
            $updateDate =  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',  $model->updated_at)->format('d-m-Y');

            $resData = ['appproverName' => $appproverName, 'designation' => $designation, 'level' => $model->level, 'updatedate' => $updateDate, 'signImageWithPath' => $signImageWithPath];
            return $resData;
        });
        return $entities;
    }
    public function excelToPdf($path)
    {
        $pdfPath = public_path('dhana/rest1.pdf');
    }
    private function saveImageFromDrawing1(Drawing $drawing, $uploadFolder)
    {
        $exactImagePath = uniqid('image_') . '.' . $drawing->getExtension();
        $imagePath = $uploadFolder . '/' . $exactImagePath;

        $ExPath = $drawing->getPath();
        file_put_contents($imagePath, file_get_contents($ExPath));
        // Process the image using Intervention Image
        $image = Image::make($imagePath);
        // Perform any desired image manipulation or processing
        $image->save($imagePath);

        return $exactImagePath;
    }
}
