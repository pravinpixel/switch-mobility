<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Spatie\PdfToText\Pdf;

class ConvertExcelToPdfJob implements ShouldQueue
{use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function handle()
    {
        $file = $this->argument('file');
        $spreadsheet = IOFactory::load($file);
        $pdf = new Pdf();

        foreach ($spreadsheet->getSheetNames() as $sheetName) {
            $sheet = $spreadsheet->getSheetByName($sheetName);
            $pdf->addPage($sheet->toHtml());
        }

        $pdf->save('output.pdf');

        // Apply custom styling to the PDF
        $pdf->setOptions([
            'user-style-sheet' => public_path('css/custom.css'),
        ]);

        $pdf->save('output.pdf');

        $this->info('PDF generated successfully!');
    }
}
