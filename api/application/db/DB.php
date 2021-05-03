<?php
error_reporting(E_ALL);
class DB
{
    function __construct()
    {
        $username = "";
        $password = "";
        try {
            $this->connection = new PDO('mysql:host=sql201.hostronavt.ru;dbname=onavt_28045182_db',
                $username,
                $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        $query =
            $this->connection->prepare("INSERT INTO people (fname, sname, age) VALUES (:fname, :sname, :age)");
        $query->bindParam(':fname', $fname);
        $query->bindParam(':sname', $sname);
        $query->bindParam(':age', $age);
        try {
            $result = $query->execute();
        }
        catch (PDOException $e) {
            print 'Error!' . $e->getMessage();
        }
        $result = null;
        return true;
    }
    public function upload() {
        $query =
            $this->connection->prepare("SELECT * FROM people WHERE age > 18");
        try {
            $result = $query->execute();
        }
        catch (PDOException $e) {
            print 'Error!' . $e->getMessage();
        }
        $out = $this->allRecords($result);
        $result = null;
        return $out;
    }
}
