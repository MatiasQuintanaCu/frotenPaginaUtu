<?php
class Database {

    private $host = "utuserver.giize.com";
    private $port = '3310';
    private $db_name = "mas_flores";
    private $username = "root";
    private $password = "S@randi";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Nunca imprimas el error real en producción
            // Loggea el error en un archivo en el servidor
            error_log("Connection error: " . $exception->getMessage());
            // Devuelve nulo o maneja el error de forma segura
            return null;
        }
        return $this->conn;
    }
}
?>