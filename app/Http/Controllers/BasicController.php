<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\ProjectEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class BasicController extends Controller
{

    public function savePDF($file)
    {

        $apiKey = config('app.PSPDFKIT_API_KEY');

        $apiUrl = 'https://api.pspdfkit.com/v1/convert';
        // Create a Guzzle HTTP client instance

        // Create a Guzzle HTTP client instance
        $client = new Client([
            'base_uri' => $apiUrl,
        ]);

        // Prepare the request payload
        $payload = [
            'file' => fopen($file, 'r'),
        ];
        // Make the API request to initiate the conversion
        $response = $client->request('POST', '', [
            'headers' => [
                'Authorization' => 'Token ' . $apiKey,
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($file, 'r'),
                    'filename' => basename($file),
                ],
            ],
        ]);
        dd($apiKey);
        // Make the API request to initiate the conversion
        $response = $client->request('POST', 'convert', [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
            ],
            'multipart' => [
                [
                    'name' => 'parameters',
                    'contents' => json_encode($payload),
                ],
            ],
        ]);
        // Get the response body
        $responseBody = $response->getBody()->getContents();

        // Parse the JSON response
        $responseData = json_decode($responseBody, true);

        // Get the URL of the converted PDF file
        $pdfUrl = $responseData['output']['url'];

        // Download and save the PDF file
        $pdfPath = public_path('converted.pdf');
        file_put_contents($pdfPath, file_get_contents($pdfUrl));
        dd("well dhana");
        // Configure the Guzzle HTTP client
        $client = new Client([
            'base_uri' => 'https://api.cloudconvert.com/v2/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('app.CLOUDCONVERT_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);

        // Convert the Excel file to PDF using the CloudConvert API
        $response = $client->post('convert', [
            'json' => [
                'inputformat' => 'xlsx',
                'outputformat' => 'pdf',
                'input' => 'upload',
                'file' => base64_encode(file_get_contents($file)),
            ],
        ]);
        $convertedPDF = json_decode($response->getBody()->getContents())->output->url;
        dd($convertedPDF);
    }


    public function tempOpen($id)
    {
        Session::put('tempProject', $id);
        if (Auth::check()) {
            $content = new Request(['id' => Session::get('tempProject')]);

            $transactionController = app()->make(Doclistings::class);
            return $transactionController->editDocument($content);
        } else {

            return redirect()->to('/');
        }
    }

    public function BasicFunction()
    {
        $empId = Auth::user()->emp_id;
        if ($empId) {
            $employee = Employee::where('id', $empId)->first();

            $name = $employee->first_name . " " . $employee->middle_name . " " . $employee->last_name;
            Session()->put('employeeId', $empId);
        } else {
            $name = "Admin";
            Session()->put('employeeId', "");
        }
        Session()->put('logginedUser', $name);
    }

    public function getAllEmployeByProject($projectModels)
    {
        $employeeArray = [];
        foreach ($projectModels as $key => $projectModel) {

            $models = ProjectEmployee::with('employee')
                ->where('project_id', $projectModel->id)
                // ->where('type', 2)
                ->groupBy('employee_id')
                ->get();


            foreach ($models as $model) {
                $employee = $model['employee'];
                if ($employee) {
                    array_push($employeeArray, $employee->id);
                }
            }
        }
        $employeeIds = array_unique($employeeArray);
        $employees = Employee::select('id', DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS fullName"))
            ->whereIn('id', $employeeIds)->get();

        return $employees;
    }
}
