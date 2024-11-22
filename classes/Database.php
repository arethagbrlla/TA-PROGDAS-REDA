<?php
// File: classes/Database.php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'db_warung_bakso';
    private $connection;

    // Konstruktor
    public function __construct() {
        $this->connect();
    }

    // Metode koneksi ke database
    private function connect() {
        $this->connection = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if ($this->connection->connect_error) {
            throw new Exception("Koneksi gagal: " . $this->connection->connect_error);
        }
    }

    // Metode untuk menjalankan query
    public function query($sql) {
        return $this->connection->query($sql);
    }
        public function prepare($sql) {
            return $this->connection->prepare($sql);
    }
}
?>