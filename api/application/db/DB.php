<?php
error_reporting(E_ALL);
class DB
{
    function __construct()
    {
        $username = "onavt_28045182";
        $password = "boot2216";
        try {
            $this->connection = new PDO('mysql:host=sql201.hostronavt.ru;dbname=onavt_28045182_db',
                $username,
                $password);
        }
        catch (PDOException $e) {
            print 'Error!:'.$e->getMessage().'<br/>';
            die();
        }
    }

    function __destruct()
    {
        $this->connection = null;
    }

    private function oneRecord($result)
    {
        while ($obj = $result->fetchObject()) {
            return $obj; // for one record
        }
        return null;
    }

    private function allRecords($result)
    {
        $res = array();
        while ($obj = $result->fetchObject()) { // for many records
            $res[] = $obj;
        }
        return $res;
    }

    public function save($fname, $sname, $age) {
        $query = "INSERT INTO people (fname, sname, age) VALUES ('".$fname."', '".$sname."', ".$age.")";
        try {
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $this->connection->query($query);
        }
        catch (PDOException $e) {
            print 'Error!' . $e->getMessage();
        }
        $result = null;
        return true;
    }
    public function upload() {
        $query = "SELECT * FROM people WHERE age > 18";
        try {
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $this->connection->query($query);
        }
        catch (PDOException $e) {
            print 'Error!' . $e->getMessage();
        }
        $out = $this->allRecords($result);
        $result = null;
        return $out;
    }
}