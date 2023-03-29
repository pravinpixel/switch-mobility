<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectDocumentDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;
use setasign\Fpdi\Fpdi;
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

        dd("under Construction");
    }
    public function approvedDocsDownload(Request $request)
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



                $path = $_SERVER['DOCUMENT_ROOT'] . '/projectDocuments/' . $model->document_name;
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $pdf_path = $destinationPath . '/' . ($key + 1) .  "." . ($key + 1) . '.pdf';
                $frontSheetpath = $destinationPath . '/' . ($key + 1) . "." . ($key + 1) . "." . ($key + 1) . '.pdf';
                $endSheetpath = $destinationPath . '/' . ($key + 1) . '.pdf';
             
              
         
             

                  File::copy($frontSheet, $frontSheetpath);
           

                if ($extension == "xlsx" || $extension == "xls") {

                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
                    $spreadsheet = $reader->load("$path");

                    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');

                    $writer->save($pdf_path);
                } else {

                    File::copy($path, $pdf_path);
                }
                File::copy($endSheet, $endSheetpath);
            }

            $files = File::allFiles($destinationPath);


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

            $pdf->Output('merged.pdf', 'I');
        } else {
            dd("no data");
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
}
