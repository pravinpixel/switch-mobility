<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Trait\CustomTCPDF;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelFileConversionController extends Controller
{
    public function fileConverter($projectId, $filePath)
    {
        $project = Project::with('docType', 'employee', 'employee.department', 'workflow')->where('id', $projectId)->first();


        $orientation = $project->document_orientation;

        if ($orientation == '1') {
            $page_orientation = 'P';
        } else {
            $page_orientation = 'L';
        }

        $docSizeType = $project->document_size;

        if ($docSizeType == '1') {
            $page_size = 'A3';
        } else {
            $page_size = 'A4';
        }

        $pdf = new CustomTCPDF($page_size, $page_orientation);

        $spreadsheet = IOFactory::load($filePath);

        //echo "<pre>"; print_r($spreadsheet); die;

        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            $pdf->AddPage($page_orientation, $page_size);
            $pdf->SetFont('times', '', 12);
            $data = $this->extractXLSXData($worksheet);
            $contentHtml = view('FileConversion.template', compact('data'))->render();
            $pdf->writeHTML($contentHtml);
            $pdf->SetAutoPageBreak(true, 10);
            $this->Footer($pdf);
        }


        $downloadFile = "app/public/test.pdf";

        $pdfFilePath = storage_path($downloadFile);
        $pdf->Output($pdfFilePath, 'D');
        $responseHeaders = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $pdfFilePath,
        ];

        return response()->file($pdfFilePath, $responseHeaders);
    }

    function extractXLSXData($worksheet)
    {
        $extractedData = [];

        // Iterate through rows and extract non-empty rows and columns
        foreach ($worksheet->getRowIterator() as $row) {
            $rowData = [];

            // Flag to check if the row has any non-empty cells
            $nonEmptyRow = false;
            foreach ($row->getCellIterator() as $cell) {
                $value = $cell->getValue();

                if (!empty($value)) {
                    $rowData[] = $value;
                    $nonEmptyRow = true;
                }
            }

            if ($nonEmptyRow) {
                $extractedData[] = $rowData;
            }
        }
        return $extractedData;
    }




    public function Footer($pdf)
    {
        $imageY = $pdf->getPageHeight() - 45;
        $pdf->SetY(-100);
        $pdf->SetLineStyle(array('width' => 0.5, 'color' => array(0, 0, 0)));

        // Add a border to the footer
        $pdf->Rect(10, $pdf->getPageHeight() - 50, $pdf->GetPageWidth() - 20, 40);

        // Set the footer font and content
        $pdf->SetFont('times', 'I', 16);
        $pdf->SetXY(10, $pdf->getPageHeight() - 50); // Adjust the X and Y coordinates
        $imagePath = public_path('logo.png');
        //$this->SetFooterMargin(100);
        for ($i = 0; $i < 3; $i++) {

            if ($i == 0) {
                $pdf->Image(public_path('sign/1.png'), 15, $imageY, 30, 0, 'PNG');
                $pdf->Rect(15, $imageY, 30, 0, 'D'); // Border for the first image
                $pdf->Rect(15, $imageY, 30, 30, 'D'); // Border for the first image
            }
            if ($i == 1) {
                $pdf->Image(public_path('sign/2.png'), 50, $imageY, 30, 0, 'PNG');
                $pdf->Rect(50, $imageY, 30, 0, 'D'); // Border for the second image
                $pdf->Rect(50, $imageY, 30, 30, 'D'); // Border for the second image
            }
            if ($i == 2) {

                $pdf->Image(public_path('sign/4.png'), 90, $imageY, 30, 0, 'PNG');
                $pdf->Rect(90, $imageY, 30, 0, 'D'); // Border for the third image
                $pdf->Rect(90, $imageY, 30, 30, 'D'); // Border for the third image
            }
        }
    }
}
