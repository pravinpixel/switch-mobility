<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentwiseReportController extends Controller
{
    public function index()
    {
        return view('Reports/DocumentwiseReport/list');
}
public function filterSearch(Request $request){
    dd($request->all());
}
}