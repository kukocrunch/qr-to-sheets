<?php

namespace Kukocrunch\Qrtosheets\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Google_Client;
use Google_Service;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;


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
        return view('qrtosheets::site.information');
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
        $jsonConv = json_encode($request->except('_token'));

        $qr = \QrCode::size(250)->generate($jsonConv);
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
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $storagePath .= config('qrtosheets.api_key_file'); //get file provided by Google API
        $applicationName = config('qr.tosheets.api_application_name');
        $goog->setApplicationName($applicationName);
        $goog->setScopes(\Google_Service_Sheets::SPREADSHEETS);
        $goog->setAuthConfig($storagePath);
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
        return view('qrtosheets::site.qrscanner');
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
            throw new \Exception("Invalid QR code. invalid fields!");
            die();
        }

        date_default_timezone_set("Asia/Singapore");
        $client = $this->getGoogleClient();
        $service = new Google_Service_Sheets($client);
        $spreadsheetId = config('qrtosheets.spreadsheet_id'); //Spreadsheet ID
        $range = config('qrtosheets.sheet_name'); //Sheet Name;

        $valueRange = new Google_Service_Sheets_ValueRange();
        $dateLogged = date("Y-m-d H:i:s", time());

        $valueRange->setValues(["values" => [
            $request['last_name'],
            $request['first_name'],
            $this->nullToBlank($request['initials']),
            $this->nullToBlank($request['suffix_name']),
            $request['gender'],
            $request['age'],
            $request['address'],
            $request['phone_number'],
            $dateLogged
        ]]);
        $conf = ["valueInputOption" => "RAW"];

        try {
            $response = $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $conf);
            return json_encode($response);
        } catch (\Error $e) {
            Log::error('Error occurred!', [$e]);
            return json_encode($e);
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
