<?php

namespace App\Exports;

use App\Models\MyModel;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\Exportable;

class MyExportExcel implements FromCollection
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return MyModel::all();
    }
}
