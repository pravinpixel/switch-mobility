<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectDocumentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Spatie\PdfToImage\Pdf;
use PhpOffice\PhpWord\Settings;
use Imagick;

class FileConversionController extends Controller
{
    protected $excelController, $pdfController, $ConvertController;
    public function __construct(ExcelFileConversionController $excelController, PdfController $pdfController, ConvertController $ConvertController)
    {
        $this->excelController = $excelController;
        $this->pdfController = $pdfController;
        $this->ConvertController = $ConvertController;
    }
    public function approvedDocsDownload(Request $request)
    {
        $id = $request->id;
        $model = ProjectDocumentDetail::with('documentName')->where('project_doc_id', $id)
            ->where('is_latest', 1)
            ->first();
        $extension = \File::extension($model->document_name);
        $filePath = public_path('projectDocuments/' . $model->document_name);
        $projectDocModel = $model->documentName;
        $projectId = $projectDocModel->project_id;
        $originalFilename = basename($filePath, '.' . $extension);
        $fname = $originalFilename . ".pdf";

        if ($extension == "xlsx" || $extension == "xls") {
            //new start
            $epdf = $this->ConvertController->convert($filePath, $projectId);
            $pdfToImage = $this->pdfToImageFile($epdf, $projectId);
            $pdfContoller = $this->pdfController->generatePdf($projectId);

            return response()->download($pdfContoller, $fname)->deleteFileAfterSend(true);
            //new end


            // dd("under construction1");
            // $fileC = $this->excelController->fileConverter($projectId, $filePath);
            // dd($fileC);
        } elseif ($extension == "pdf") {
            $pdfToImage = $this->pdfToImageFile($filePath, $projectId);
            $pdfContoller = $this->pdfController->generatePdf($projectId);

            return response()->download($pdfContoller, $fname)->deleteFileAfterSend(true);
        } elseif ($extension == "docx") {
            $pdfCreatedFolderPath = public_path('Temp/DocxToPdf/' . $id);
            $pdfFileName = $id . ".pdf";
            $tempPdfFilePath = $pdfCreatedFolderPath . "/" . $pdfFileName;

            if (File::exists($pdfCreatedFolderPath)) {
                File::deleteDirectory($pdfCreatedFolderPath);
            }

            if (!File::exists($pdfCreatedFolderPath)) {
                File::makeDirectory($pdfCreatedFolderPath, 0755, true);
            }

            $domPdfPath = base_path('vendor/dompdf/dompdf');
            Settings::setPdfRendererPath($domPdfPath);
            Settings::setPdfRendererName('DomPDF');

            $content = \PhpOffice\PhpWord\IOFactory::load($filePath);
            $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($content, 'PDF');
            $pdfWriter->save($tempPdfFilePath);
            $pdfToImage = $this->pdfToImageFile($tempPdfFilePath, $projectId);
            $pdfContoller = $this->pdfController->generatePdf($projectId);

            return response()->download($pdfContoller, $fname)->deleteFileAfterSend(true);
        } else {
            dd("under construction");
        }
    }

    public function pdfToImageFile($filePath, $projectId)
    {

        $imageCreatedFolderPath = public_path('Temp/Images/' . $projectId);


        if (File::exists($imageCreatedFolderPath)) {
            File::deleteDirectory($imageCreatedFolderPath);
        }

        if (!File::exists($imageCreatedFolderPath)) {
            File::makeDirectory($imageCreatedFolderPath, 0755, true);
        }
        // Set the desired image dimensions (width and height)
        $imageWidth = 800;  // Adjust the width as needed
        $imageHeight = 400; // Adjust the height as needed
        // Create Imagick object
        $imagick = new Imagick();
        $imagick->readImage($filePath);

        // Iterate through each page and convert it to an image
        foreach ($imagick as $pageNumber => $page) {
            $page->setImageFormat('png');
            $outputFile = $imageCreatedFolderPath."/" . 'page_' . ($pageNumber + 1) . '.png';
            $page->writeImage($outputFile);
        }


        // $pdf = new Pdf($filePath);
        // $numPages = $pdf->getNumberOfPages();
        // dd($numPages);
        // // Set the output directory for the images
        // $outputPath = $imageCreatedFolderPath;
        // // Convert each page of the PDF to an image
        // for ($page = 1; $page <= $numPages; $page++) {
        //     $imagePath = $outputPath . '/page_' . $page . '.png';

        //     $pdf->setPage($page)->saveImage($imagePath);
        //     //  $pdf->setPage($page)->setWidth($imageWidth)->setHeight($imageHeight)->saveImage($imagePath);
        //     //  exec("convert $imagePath -resize {$imageWidth}x{$imageHeight} $imagePath");
        // }
        return true;
    }
}
