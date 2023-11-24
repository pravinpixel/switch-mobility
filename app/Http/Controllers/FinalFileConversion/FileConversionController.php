<?php

namespace App\Http\Controllers\FinalFileConversion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\File\PdfController;
use App\Models\Project;
use App\Models\ProjectDocumentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Spatie\PdfToImage\Pdf;

use Imagick;
class FileConversionController extends Controller
{
    protected $excelController, $pdfController, $ConvertController;
    public function __construct(PdfController $pdfController)
    {
       
        $this->pdfController = $pdfController;
    
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
        $LibreOfficePath = 'C:\Program Files\LibreOffice\program\soffice.exe';

        if ($extension == "xlsx" || $extension == "xls") {
            //new start
            $inputFile = $filePath;

            $outputDirectory = public_path("finalOutput/") . $projectId . "/excelToPdf";

            if (File::exists($outputDirectory)) {
                File::deleteDirectory($outputDirectory);
            }

            if (!File::exists($outputDirectory)) {
                File::makeDirectory($outputDirectory, 0755, true);
            }

            $libreOfficeCommand = "\"$LibreOfficePath\" --headless --convert-to pdf --outdir $outputDirectory $inputFile";

            // Execute the LibreOffice command
            exec($libreOfficeCommand, $output, $returnCode);
            $createdFile = $outputDirectory . '/' . $originalFilename . '.pdf';
            if ($returnCode === 0 && file_exists($createdFile)) {
              
                $ipdf = $this->pdfToImage($createdFile, $projectId);
                $pdfContoller = $this->pdfController->generatePdf($projectId);
                return response()->download($pdfContoller, $fname)->deleteFileAfterSend(true);
            } else {
               
                dd('PDF conversion failed');
            }
        } elseif ($extension == "pdf") {
          
            $pdfToImage = $this->pdfToImage($filePath, $projectId);
            $pdfContoller = $this->pdfController->generatePdf($projectId);

            return response()->download($pdfContoller, $fname)->deleteFileAfterSend(true);
        } elseif ($extension == "docx") {
           
            $inputFile = $filePath;

            $outputDirectory = public_path("finalOutput/") . $projectId . "/docxToPdf";

            if (File::exists($outputDirectory)) {
                File::deleteDirectory($outputDirectory);
            }

            if (!File::exists($outputDirectory)) {
                File::makeDirectory($outputDirectory, 0755, true);
            }
          
            $libreOfficeCommand = "\"{$LibreOfficePath}\" --headless --convert-to pdf --outdir {$outputDirectory} {$inputFile}";
            exec($libreOfficeCommand, $output, $returnCode);
            $createdFile = $outputDirectory . '/' . $originalFilename . '.pdf';
            if ($returnCode === 0 && file_exists($createdFile)) {
            
                $ipdf = $this->pdfToImage($createdFile, $projectId);
                $pdfContoller = $this->pdfController->generatePdf($projectId);
                return response()->download($pdfContoller, $fname)->deleteFileAfterSend(true);
            } else {
               
                dd('PDF conversion failed');
            }
        } else {
            dd("under construction");
        }
    }
    public function pdfToImage($inputFile, $projectId)
    {

        $outputDirectory = public_path("finalOutput/") . $projectId . "/pdfToImage";

        if (File::exists($outputDirectory)) {
            File::deleteDirectory($outputDirectory);
        }

        if (!File::exists($outputDirectory)) {
            File::makeDirectory($outputDirectory, 0755, true);
        }
     
        $pdf = new Imagick($inputFile);

        // Loop through each page and convert it to an image
        foreach ($pdf as $pageNumber => $page) {
            // Set resolution (optional)
            $page->setResolution(300, 300); // Adjust the resolution as needed
        
            // Convert PDF page to an image
            $imagePath = $outputDirectory . '/' . ($pageNumber + 1) . '.png'; // Change format if needed
            $page->setImageFormat('png'); // Change format if needed
            $page->writeImage($imagePath);
        }
      
       return true;
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

        // // Iterate through each page and convert it to an image
        foreach ($imagick as $pageNumber => $page) {
            $page->setImageFormat('png');
            $outputFile = $imageCreatedFolderPath . "/" . 'page_' . ($pageNumber + 1) . '.png';
            $page->writeImage($outputFile);
        }


        // $pdf = new Pdf($filePath);
        // $numPages = $pdf->getNumberOfPages();
        // // dd($numPages);
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
