<?php

namespace core;

class database
{
    public $serverName = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "pms";
    public $connection;

    function __construct()
    {
        $this->connect();
    }

    function connect()
    {
        $this->connection = new \mysqli($this->serverName, $this->username, $this->password, $this->dbname);
        if ($this->connection->connect_error) {
            die("Connection failed " . $this->connection->connect_error);
        }
        return $this->connection;
    }

    function disconnect()
    {
        \mysqli_close($this->connection);
        echo "<script type='text/javascript'>alert(\"Disconnected\");</script>";
    }
}