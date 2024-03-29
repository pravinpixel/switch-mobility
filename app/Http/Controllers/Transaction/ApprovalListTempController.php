<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectEmployee;
use Carbon\Carbon;

use Illuminate\Support\Facades\File;

use Spatie\PdfToImage\Pdf;


class ApprovalListTempController extends Controller
{

    public function pdtToImage($pdfPath, $storePath)
    {

        // $pdf = new Pdf($pdfPath);
        // $pdf->saveImage($storePath);
        $pdf = new Pdf($pdfPath);

        // Get the total number of pages in the PDF
        $totalPages = $pdf->getNumberOfPages();
        // Convert each page of the PDF to an image
        for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++) {
            // Generate a unique filename for each image (you can modify this as needed)
            $imageFilename = 'page_' . $pageNumber . '.png';

            // Set the page number to be converted
            $pdf->setPage($pageNumber);

            // Save the image
            $pdf->saveImage($storePath . '/' . $imageFilename);
        }
        return true;
    }

    public function WordToPdf($docxFilePath, $id)
    {
        $outputDirectory = public_path('xlToPdf') . '/temp' . $id;
        $pdfFilePath = $outputDirectory . '.pdf';

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
        $Content = \PhpOffice\PhpWord\IOFactory::load($docxFilePath);
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
        $PDFWriter->save($outputDirectory);

        dd("wellls");
        return true;
    }
    public function frontPdf($id)
    {
        // $empId = (Auth::user()->emp_id != null) ? Auth::user()->emp_id : "";

        // $models = Project::with('workflow', 'employee', 'employee.department', 'projectEmployees');
        // if ($empId) {
        //     $models->whereHas('projectEmployees', function ($q) use ($empId) {
        //         if ($empId != "") {
        //             $q->where('employee_id', '=', $empId);
        //         }
        //     });
        // }

        // $models->whereNull('deleted_at');
        // $datas = $models->get();

        $project = Project::with('docType', 'employee', 'employee.department', 'workflow')->where('id', $id)->first();
        $docModel  = $project->docType;

        $employeeModel  = $project->employee;

        $departmentModel  = $employeeModel->department;

        $workflowModel  = $project->workflow;

        $timestamp = strtotime($project->created_at);
        $date = date('Y-m-d H:i:s', $timestamp);

        $docName = ($docModel) ? $docModel->name : "";
        $workflowName = ($workflowModel) ? $workflowModel->workflow_name : "";
        $workflowCode = ($workflowModel) ? $workflowModel->workflow_code : "";
        $department  = ($departmentModel) ? $departmentModel->name : "";
        $employeeName = ($employeeModel) ? $employeeModel->first_name . " " . $employeeModel->last_name : "";


        $data = [
            'imagePath'    => public_path('assets/media/logos/limage.png'),
            'ticketNo'         => $project->ticket_no,
            'projectCode'      => $project->project_code,
            'projectName' => $project->project_name,
            'date'        => $date,
            'docName'         => $docName,
            'workflowCode'      => $workflowCode,
            'workflowName' =>  $workflowName,
            'department'        => $department,
            'initiater' => $employeeName
        ];
        $path = public_path('front' . $id . '.pdf');

        if (file_exists($path)) {
            File::delete($path);
        }
        $pdf = PDF::loadView('pdf.pdfHeaderFormat', $data);
        $pdf->save($path);


        return $path;
    }
    public function FooterPdf($id)
    {

        $models = ProjectEmployee::with('employee', 'employee.designation',  'employee.department', 'projectlevel')->where('project_id', $id)->get();

        $entities = collect($models)->map(function ($model) {

            $employeeModel = $model['employee'];
            $levelModel = $model['projectlevel'];
            $date =  ($levelModel) ? $levelModel->due_date : "";
            if ($date) {
                $newDateFormat = Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
            } else {
                $newDateFormat = "";
            }
            $designationModel = ($employeeModel) ? $employeeModel['designation'] : "";
            $departmentModel = ($employeeModel) ? $employeeModel['department'] : "";
            $designation = ($designationModel) ? $designationModel->name : "";
            $department = ($departmentModel) ? $departmentModel->name : "";
            $signImage = ($employeeModel->sign_image) ? $employeeModel->sign_image : "noimage.png";
            $signImageWithPath = public_path('images/employee/' . $signImage);
            //dd($signImageWithPath);
            $employeeName =  ($employeeModel) ? $employeeModel->first_name . " " . $employeeModel->middle_name . " " . $employeeModel->last_name : "";

            $data = [
                'imagePath'    => public_path('assets/media/logos/limage.png'),
                'signImagePath'    =>  $signImageWithPath,
                'employeeName'     => $employeeName,
                'designation'      => $designation,
                'date'        => $newDateFormat,
                'level' => $model->level,
                'department' => $department
            ];

            return $data;
        });
        $imagePath =  public_path('assets/media/logos/limage.png');
        $path = public_path('back' . $id . '.pdf');

        if (file_exists($path)) {
            File::delete($path);
        }

        $pdf = PDF::loadView('pdf.pdfFooterFormat', compact('entities', 'imagePath'));
        $pdf->save($path);
        return $path;
    }

    //     public function approvedDocsView(Request $request)
    //     {

    //         // Load existing PDF file
    //         $path = public_path() . '/projectDocuments/WF2023-03-22-23/main_document/MainDocument-v2.pdf';
    //         $mpdf = new Mpdf();

    //         $pagecount = $mpdf->SetSourceFile($path);
    //         for ($i = 1; $i <= $pagecount; $i++) {
    //             $tplId = $mpdf->ImportPage($i);
    //             $mpdf->UseTemplate($tplId);

    //             $mpdf->WriteHTML('<div class="top-bar"> <img src="limage.png" alt="Left Image" > <h1>Online Approval Management</h1> </div> <div class="container"> <div class="top-row"> <div class="element"> <p><b>Ticket Number</b></p> <p>wfh-212-123</p> </div> <div class="element"> <p><b>Ticket Number</b></p> <p>wfh-212-123</p> </div> <div class="element"> <p><b>Ticket Number</b></p> <p>wfh-212-123</p> </div> </div> <div class="bottom-row"> <div class="element"> <p><b>Ticket Number</b></p> <p>wfh-212-123</p> </div> <div class="element"> <p><b>Ticket Number</b></p> <p>wfh-212-123</p> </div> <div class="element"> <p><b>Ticket Number</b></p> <p>wfh-212-123</p> </div> </div> </div>');
    //             $mpdf->SetHTMLFooter('<div style="text-align: center;">Footer Text</div>');
    //             if ($i < $pagecount) {
    //                 $mpdf->AddPage();
    //             }
    //         }
    //         $mpdf->Output($path, 'F');
    //         return response()->download($path);

    // dd($pagecount);


    //         $dompdf = new Dompdf($options);
    //         $dompdf->loadHtml('
    //             <html>
    //                 <head>
    //                 <style>
    //                 /* Header styles */
    //                 @page {
    //                     margin-top: 50px;
    //                 }
    //                 #header {
    //                     position: fixed;
    //                     top: 0;
    //                     left: 0;
    //                     right: 0;
    //                     height: 50px;
    //                     background-color: #ccc;
    //                     text-align: center;
    //                     line-height: 50px;
    //                 }

    //                 /* Footer styles */
    //                 #footer {
    //                     position: fixed;
    //                     bottom: 0;
    //                     left: 0;
    //                     right: 0;
    //                     height: 50px;
    //                     background-color: #ccc;
    //                     text-align: center;
    //                     line-height: 50px;
    //                 }
    //             </style>
    //                 </head>
    //                 <body>
    //                 <!-- Header -->
    // <div id="header">
    //     <h1>My Header</h1>
    // </div>

    // <!-- Footer -->
    // <div id="footer">
    //     <p>My Footer</p>
    // </div>
    //                 </body>
    //             </html>
    //         ');

    //         // Render the PDF
    //         $dompdf->render();
    //         $dompdf->stream('document.pdf', array('Attachment' => false));
    //     }
    //     public function approvedDocsDownload(Request $request)
    //     {
    //         $id = $request->id;
    //         $models = ProjectDocumentDetail::where('project_id', $id)->where('status', 4)->get();
    //         $path = public_path() . '/projectDocuments/WF2023-03-22-23/main_document/MainDocument-v2.pdf';
    //         $filePath = $path;

    //         // Create a new instance of Dompdf
    //         $dompdf = new Dompdf();

    //         // Set the options for Dompdf
    //         $options = new Options();
    //         $options->setIsHtml5ParserEnabled(true);
    //         $dompdf->setOptions($options);

    //         // $html1 = view('pdf.pdfFormat', compact('path'));
    //         // dd()
    //         $html = view('pdf.pdfFormat', compact('path'))->render(); // Replace "pdf_content" with your actual view file
    //         $dompdf->loadHtml($html);

    //         // Add the header and footer
    //         $header = view('pdf.pdf-header')->render(); // Replace "pdf_header" with your actual header view file
    //         $footer = view('pdf.pdf-footer')->render(); // Replace "pdf_footer" with your actual footer view file
    //         $dompdf->setPaper('A4', 'portrait');
    //         $dompdf->set_option('header-html', $header);
    //         $dompdf->set_option('footer-html', $footer);

    //         // Output the PDF to the browser or save it to a file
    //         $dompdf->stream('document.pdf');

    //         dd("well");


    //         $outputFilePath = public_path("sample_output.pdf");
    //         $this->fillPDFFile($filePath, $outputFilePath);

    //         return response()->file($outputFilePath);





    //         $pdf = PDF::loadView('pdf.pdfFormat', [
    //             'title' => 'CodeAndDeploy.com Laravel Pdf Tutorial',
    //             'description' => $content,
    //             'footer' => 'by <a href="https://codeanddeploy.com">codeanddeploy.com</a>'
    //         ]);

    //         return $pdf->download('sample.pdf');


    //         // $pdf = PDFMerger::init();

    //         // foreach ($models as $key => $value) {
    //         //     $path = public_path().'/projectDocuments/'.$value->document_name;


    //         //     $pdf->addPDF($path, 'all');
    //         // }

    //         // $fileName = time().'.pdf';

    //         // $pdf->merge();
    //         // $pdf->save(public_path($fileName));
    //         // return response()->download(public_path($fileName));
    //     }
    //     public function fillPDFFile($file, $outputFilePath)
    //     {
    //         $fpdi = new FPDI;

    //         $count = $fpdi->setSourceFile($file);

    //         for ($i = 1; $i <= $count; $i++) {

    //             $template = $fpdi->importPage($i);
    //             $size = $fpdi->getTemplateSize($template);
    //             $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
    //             $fpdi->useTemplate($template);

    //             $fpdi->SetFont("helvetica", "", 15);
    //             $fpdi->SetTextColor(153, 0, 153);
    //             $fpdi->SetTitle('Online Approval Management');
    //             $left = 70;
    //             $top = 10;
    //             $n = '<div style="height:100px; width:100px; background:#000000"></div>';
    //             $text = "Online Approval Management";
    //             $fpdi->WriteHtml('You can<br><p align="center">center a line</p>and add a horizontal rule:<br><hr>');
    //             $fpdi->Text($left, $top, $n);
    //         }

    //         return $fpdi->Output($outputFilePath, 'F');
    //     }
}
