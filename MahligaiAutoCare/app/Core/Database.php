<?php
// app/Core/Database.php
namespace App\Core;

use mysqli;
use Exception;

/**
 * Kelas Database bertanggung jawab untuk mengelola koneksi ke database.
 * Ini menggantikan fungsi koneksi langsung dari db_config.php.
 */
class Database
{
    private mysqli $conn;
    private array $config;

    /**
     * Konstruktor Database.
     * Membuat koneksi ke database berdasarkan konfigurasi yang diberikan.
     *
     * @param array $dbConfig Array berisi host, username, password, dan dbname.
     */
    public function __construct(array $dbConfig)
    {
        $this->config = $dbConfig;
        $this->connect();
    }

    /**
     * Membuat koneksi ke database.
     * @throws Exception Jika koneksi database gagal.
     */
    private function connect(): void
    {
        $this->conn = new mysqli(
            $this->config['host'],
            $this->config['username'],
            $this->config['password'],
            $this->config['dbname']
        );

        if ($this->conn->connect_error) {
            // Daripada die(), lebih baik melemparkan Exception yang bisa ditangkap
            // dan ditangani dengan elegan oleh aplikasi.
            throw new Exception("Koneksi database gagal: " . $this->conn->connect_error);
        }

        // Set karakter set untuk koneksi ke UTF-8
        $this->conn->set_charset("utf8");
    }

    /**
     * Mengembalikan objek koneksi mysqli.
     *
     * @return mysqli
     */
    public function getConnection(): mysqli
    {
        // Jika koneksi terputus atau belum terhubung, coba hubungkan kembali
        if (!$this->conn || $this->conn->ping() === false) {
            $this->connect();
        }
        return $this->conn;
    }

    /**
     * Menutup koneksi database.
     */
    public function closeConnection(): void
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    /**
     * Melakukan sanitasi string untuk mencegah SQL injection (deprecated, gunakan prepared statements).
     * Disarankan untuk selalu menggunakan prepared statements.
     *
     * @param string $value String yang akan disanitasi.
     * @return string String yang sudah disanitasi.
     */
    public function escapeString(string $value): string
    {
        return $this->conn->real_escape_string($value);
    }
}
