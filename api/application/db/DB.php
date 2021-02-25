<?php
class DB
{
    function __construct()
    {
        $servername = "127.0.0.1";
        $username = "mysql";
        $password = "mysql";
        $dbname = "task2";
        $this->connection = new mysqli($servername, $username, $password, $dbname, 3306);
        if ($this->connection->connect_errno) {
            die("Connection failed" . $this->connection->connect_error);
        }
    }

    function __destruct()
    {
        $this->connection->close();
    }

    private function oneRecord($result)
    {
        while ($obj = $result->fetch_object()) {
            return $obj; // for one record
        }
        return null;
    }

    private function allRecords($result)
    {
        $res = array();
        while ($obj = $result->fetch_object()) { // for many records
            $res[] = $obj;
        }
        return $res;
    }

    public function save($fname, $sname, $age) {
        $query = "INSERT INTO people (fname, sname, age) VALUES ('".$fname."', '".$sname."', ".$age.")";
        $result = $this->connection->query($query);
        return true;
    }
    public function upload() {
        $query = "SELECT * FROM people WHERE age >= 18";
        $result = $this->connection->query($query);
        return $this->allRecords($result);
    }
}