<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class InformationController extends Controller
{


    /**
     *
     * Display information
     *
     * @return view
     *
     */
    public function index()
    {
        return view('site.information');
    }

    /**
     *
     * Generating QR Code from POST data received
     *
     * @param Request $request
     *
     * @return $qr
     *
     */
    public function generate(Request $request)
    {
        $json_conv = json_encode($request->except('_token'));

        $qr = \QrCode::size(250)->generate($json_conv);
        return $qr;
    }

    /**
     *
     * Connect to Google Sheets API
     *
     * @return $goog
     *
     */
    private function getGoogleClient()
    {
        $goog = new Google_Client();
        $storage_path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $storage_path .= "sheets-to-qr-scan-175c5984413b.json"; //get file provided by Google API
        $goog->setApplicationName('TestQR Sheets API PHP Quickstart');
        $goog->setScopes(\Google_Service_Sheets::SPREADSHEETS);
        $goog->setAuthConfig($storage_path);
        $goog->setAccessType('offline');

        return $goog;
    }

    /**
     *
     * Display QR Scanner
     * note : site must be viewed in HTTPS in order to make camera api run.
     *
     * @return view
     */
    public function scanner()
    {
        return view('site.qrscanner');
    }

    /**
     *
     * Saving valid QR Code, then save it to Google Sheets
     *
     * @param Request $request
     *
     * @return string $response
     */
    public function saveQrToSheets(Request $request)
    {

        if (!isset($request['last_name']) || !isset($request['first_name']) || !isset($request['address']) || !isset($request['phone_number'])) {
            throw new \Exception("Invalid QR code.");
            die();
        }

        date_default_timezone_set("Asia/Singapore");
        $client = $this->getGoogleClient();
        $service = new Google_Service_Sheets($client);
        $spreadsheetId = "1WpBNs_h3biKOTHSbNOHhHL8v65VW0XhmV0h2b_3SYTI"; //Spreadsheet ID
        $range = 'Sheet1'; //Sheet Name;

        $valueRange = new Google_Service_Sheets_ValueRange();
        $date_logged = date("Y-m-d H:i:s", time());

        $valueRange->setValues(["values" => [
            $request['last_name'],
            $request['first_name'],
            $this->nullToBlank($request['initials']),
            $this->nullToBlank($request['suffix_name']),
            $request['gender'],
            $request['age'],
            $request['address'],
            $request['phone_number'],
            $date_logged
        ]]);

        $conf = ["valueInputOption" => "RAW"];

        try {
            $response = $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $conf);
            return $response;
        } catch (\Error $e) {
            dd('something went wrong');
        }
    }

    /**
     *
     * If null value was parsed, then convert it to blank
     *
     * @param string $value
     *
     * @return string
     */

    private function nullToBlank($value)
    {
        if (is_null($value)) {
            return "";
        } else {
            return $value;
        }
    }
}
