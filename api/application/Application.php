<?php
error_reporting(E_ALL);
require_once("db/DB.php");
require("../vendor/autoload.php");

class Application
{

    function __construct()
    {
        $this->db = new DB();
        $this->client = new Google_Client();
        $this->client->setApplicationName('Google Sheets');
        $this->client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        $this->client->setAuthConfig('../mycred.json');
        $this->client->setAccessType('offline');
        $this->service = new Google_Service_Sheets($this->client);
    }

    public function saveData($params) {
        if ($params["fname"] && $params["sname"] && $params["age"]) {
            return $this->db->save($params["fname"], $params["sname"], $params["age"]);
        }
    }

    public function uploadData($params) {
        $records = $this->db->upload();
        $spreadsheetId = "1cWncchgqJ3VZN9UjGVX8q6QgDWXNfjYJHqoxgAS5QrQ";
        $range = "Sheet1";
        foreach ($records as $record) {
            $values = [
                [$record->fname, $record->sname, $record->age]
            ];
            $body = new Google_Service_Sheets_ValueRange([
                'values' => $values
            ]);
            $params = [
                'valueInputOption' => 'RAW'
            ];
            $insert = [
                'insertDataOption' => 'INSERT_ROWS'
            ];
            $result = $this->service->spreadsheets_values->append(
                $spreadsheetId,
                $range,
                $body,
                $params,
                $insert
            );
        }
        if ($result)
        {
            return true;
        }
        return false;
    }
}