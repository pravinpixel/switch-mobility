<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writer;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use setasign\Fpdi\Fpdi;

class ConvertController extends Controller
{
    public function convert($filePath, $projectId)
    {


        $pdfCreatedFolderPath = public_path('temp/xlToPdf/' . $projectId);
        if (File::exists($pdfCreatedFolderPath)) {
            File::deleteDirectory($pdfCreatedFolderPath);
        }

        // Create the folder
        File::makeDirectory($pdfCreatedFolderPath, 0755, true);

        // Define the PDF path
        $pdfCreatedFolderPathOriginal = public_path('temp/xlToPdforiginal/' . $projectId);

        if (File::exists($pdfCreatedFolderPathOriginal)) {
            File::deleteDirectory($pdfCreatedFolderPathOriginal);
        }

        // Create the folder
        File::makeDirectory($pdfCreatedFolderPathOriginal, 0755, true);

        $pdfPath = "{$pdfCreatedFolderPathOriginal}/{$projectId}.pdf";

        try {


            // $spreadsheet = IOFactory::load($filePath);
            // $worksheetIterator = $spreadsheet->getWorksheetIterator();

            // foreach ($worksheetIterator as $worksheet) {
            //     //  Log::info("arrayfor" . $worksheetIterator->key());
            //     $spreadsheetForSheetNew = [""];
            //     $spreadsheetForSheetNew = $spreadsheet->copy();

            //     $spreadsheetForSheetNew->setActiveSheetIndex($worksheetIterator->key());

            //     // Generate the PDF for the current worksheet
            //     $pdfFile = $pdfCreatedFolderPath . "/" . $worksheet->getTitle() . '.pdf';

            //     $writer = new Mpdf($spreadsheetForSheetNew);
            //     $writer->save($pdfFile);
            // }



            // $ffiles = File::allFiles($pdfCreatedFolderPath);
            // $pdf = new Fpdi();
            // foreach ($ffiles as $key => $ffile) {


            //     $pageCount = $pdf->setSourceFile($ffile->getPathname());


            //     for ($i = 1; $i <= $pageCount; $i++) {
            //         $template = $pdf->importPage($i);

            //         $pdf->AddPage();
            //         $pdf->useTemplate($template);
            //     }
            // }


            // $pdf->Output($pdfPath, 'F');
         

            // Load Excel file and create PDF
            $spreadsheet = IOFactory::load($filePath);
            $writer = new Dompdf($spreadsheet);
            $writer->save($pdfPath);

            // Check if PDF was created successfully
            if (File::exists($pdfPath)) {
                return $pdfPath;
            } else {
                // Handle the case where the PDF was not created successfully
                return redirect()->route('404'); // Adjust the route accordingly
            }
        } catch (\Exception $e) {
            // Handle exceptions during the PDF creation process
            return redirect()->route('404'); // Adjust the route accordingly
        }
    }
}
