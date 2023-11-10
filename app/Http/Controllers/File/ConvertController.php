<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writer;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Dompdf\Dompdf;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class ConvertController extends Controller
{
    public function convert($filePath, $projectId)
    {
        $xlToPdfPath = public_path('pdf/ExcelToPdf/' . $projectId);
        if (File::exists($xlToPdfPath)) {
            File::deleteDirectory($xlToPdfPath);
        }

        if (!File::exists($xlToPdfPath)) {
            File::makeDirectory($xlToPdfPath, 0755, true);
        }

        $outputFile = public_path('pdf/mergepdf/' . $projectId);
        if (File::exists($outputFile)) {
            File::deleteDirectory($outputFile);
        }

        if (!File::exists($outputFile)) {
            File::makeDirectory($outputFile, 0755, true);
        }
        // Load the Excel file
        $spreadsheet = IOFactory::load($filePath);

        // Get the number of tabs in the Excel file
        $tabCount = $spreadsheet->getSheetCount();
        for ($i = 0; $i < $tabCount; $i++) {
            // Get the content of the current tab
            $sheet = $spreadsheet->getSheet($i);
            $content = $sheet->toArray();

            // Create a new PDF instance
            $dompdf = new Dompdf();

            // Generate the PDF from the tab content
            $html = '<html><body>';
            foreach ($content as $row) {
                $html .= '<p>' . implode(', ', $row) . '</p>';
            }
            $html .= '</body></html>';

            $dompdf->loadHtml($html);
            $dompdf->render();

            // Save the PDF file
            $output = public_path('pdf/ExcelToPdf/' . $projectId . "/" . ($i + 1) . '.pdf');
            file_put_contents($output, $dompdf->output());
        }

        $pdfFolder = $xlToPdfPath;

        $imagefiles = File::allFiles($pdfFolder);
        $pdfFiles = [];
        foreach ($imagefiles as $key => $imagefile) {
            $pathName = $imagefile->getPathname();
            array_push($pdfFiles, $pathName);
        }

        $pdf = new Fpdi();

        // Iterate through each PDF file and merge it with the main PDF
        foreach ($pdfFiles as $file) {
            $pageCount = $pdf->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->AddPage();
                $pdf->useTemplate($templateId);
            }
        }

        $mergepdf = $outputFile . "/merge.pdf";

        // Save the merged PDF to the storage
        $pdf->Output($mergepdf, 'F');
        return $mergepdf;
    }
}
