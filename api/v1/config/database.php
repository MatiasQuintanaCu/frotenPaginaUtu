<?php

class Database {

    private $host;
    private $port = "3306";
    private $db_name = "Pagina_utu";
    private $username = "root";
    private $password;
    public $conn;
    
public function __construct() {
    if (file_exists('/.dockerenv')) {
        $this->host = "mysql";
        $this->username = "utu_user";  // ← Cambiar de root a utu_user
        $this->password = "123456";
    } else {
        $this->host = "localhost";
        $this->username = "root";
        $this->password = "";
    }
}

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password,
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"]
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            http_response_code(503);
            return null;
        }
        return $this->conn;
    }
}
?>