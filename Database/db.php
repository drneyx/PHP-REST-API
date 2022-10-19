<?php
use PDO;


class Dbh
{
    private string $db_host;
    private string $db_user;
    private string $db_name;
    private string $db_pass;

    /* initialize db credentials */
    public function __construct() {
        $this->db_host = "localhost";
        $this->db_name = "product";
        $this->db_user = "root";
        $this->db_pass = "root";
    }

    public function execute(string $query) {
        $conn = new PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name, $this->db_user, $this->db_pass);
        $result = $conn->query($query);
        $conn = null;
        return $result;
    }

    /* Prepare and execute statement */
    public function stmtPrepareAndExecute(string $query, array $params) {
        $conn = new PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name, $this->db_user, $this->db_pass);
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt;
        $conn = null;
        return $result;
    }

}