<?php
class Database {
    private string $host = 'localhost';
    private string $db_name = 'magic_manga';
    private string $username = 'magic_manga';
    private string $password = 'kH5dJ1sN9f';
    private ?PDO $conn = null;

    public function connect(): ?PDO {
        if ($this->conn === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            } catch (PDOException $e) {
                // Ishlab chiqarish (production) muhitida xatolikni logga yozish tavsiya etiladi
                error_log("Database Connection Error: " . $e->getMessage());
                die("Ma'lumotlar bazasiga ulanishda xatolik yuz berdi.");
            }
        }
        return $this->conn;
    }
}

// Global ulanish obyektini yaratish
$dbInstance = new Database();
$pdo = $dbInstance->connect();