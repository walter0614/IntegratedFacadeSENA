<?php
class Connection
{
    public static $servername = "localhost";
    public static $username = "root";
    public static $password = "";
    public static $dbname = "integrated_facade_db";
    public $conn;

    function OpenConnection()
    {
        try {
            $this->conn = new mysqli(Connection::$servername, Connection::$username, Connection::$password, Connection::$dbname);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo ("Error!" . $e);
        }
        return $this;
    }

    function Query($sql, $parameters = [])
    {
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            mysqli_report(MYSQLI_REPORT_ALL);
            throw new Exception('Error en prepare: ' . $stmt);
        }

        switch (count($parameters)) {
            case 1:
                $stmt->bind_param("i", $parameters[0]);
                break;
            case 2:
                $stmt->bind_param("is", $parameters[0], $parameters[1]);
                break;
            case 3:
                $stmt->bind_param("is", $parameters[0], $parameters[1], $parameters[2]);
                break;
            case 4:
                $stmt->bind_param("is", $parameters[0], $parameters[1], $parameters[2], $parameters[3]);
                break;
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        if (isset($result->num_rows) && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
        }
        return $data;
    }

    function Close()
    {
        $this->conn->close();
    }
}
