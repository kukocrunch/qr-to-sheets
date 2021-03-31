<?php 

return [
    'providers' => [
        /*
        * Custom Providers
        */
        \SimpleSoftwareIO\QrCode\ServiceProvider::class,
    ],
    'aliases' => [
        'QrCode' => \SimpleSoftwareIO\QrCode\Facades\QrCode::class,
    ],
    'api_key_file' => env('GOOGLE_API_FILENAME', null),
    'api_application_name' => env('SHEETS_API_APPLICATION_NAME', null),
    'spreadsheet_id' => env('SHEETS_API_SPREADSHEET_ID', null),
    'sheet_name' => env('SHEETS_SHEET_NAME','Sheet1')
];