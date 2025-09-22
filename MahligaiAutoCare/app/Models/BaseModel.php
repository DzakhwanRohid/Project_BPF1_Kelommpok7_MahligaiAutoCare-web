<?php
// app/Models/BaseModel.php
namespace App\Models;

use App\Core\Application;
use mysqli;
use mysqli_stmt;
use Exception;

/**
 * BaseModel adalah kelas dasar untuk semua model dalam aplikasi.
 * VERSI REFACTOR: Menyediakan fungsionalitas CRUD generik untuk mengurangi duplikasi kode.
 */
abstract class BaseModel
{
    protected mysqli $db;
    protected string $tableName;
    protected string $primaryKey = 'id'; // Default, di-override di model anak

    public function __construct()
    {
        $this->db = Application::$app->getDatabase()->getConnection();
    }

    /**
     * Mengatur nama tabel untuk model. Dipanggil di konstruktor model anak.
     */
    protected function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * Mengatur nama primary key untuk model. Dipanggil di konstruktor model anak.
     */
    protected function setPrimaryKey(string $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }

    // ===================================================================
    // METODE CRUD GENERIK (CREATE, READ, UPDATE, DELETE)
    // ===================================================================

    /**
     * [TETAP] Mengambil satu record berdasarkan ID (primary key).
     * @param int $id ID record.
     * @return array|null
     */     
     public function find(?int $id): ?array
    {
        // [PERBAIKAN] Tambahkan pengecekan di awal.
        // Jika id yang diberikan adalah null, langsung kembalikan null tanpa query ke DB.
        if (is_null($id)) {
            return null;
        }

        // Sisa kode tetap sama
        $sql = "SELECT * FROM {$this->tableName} WHERE {$this->primaryKey} = ?";
        $stmt = $this->executeStatement($sql, "i", $id);
        if ($stmt) {
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();
            return $data;
        }
        return null;
    }

    /**
     * [TETAP] Mengambil semua record dari sebuah tabel.
     * @return array
     */
    public function all(): array
    {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY {$this->primaryKey} DESC";
        $result = $this->db->query($sql);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        }
        return $data;
    }

    /**
     * [BARU & GENERIK] Menambahkan record baru ke tabel.
     * @param array $data Data yang akan disimpan dalam bentuk associative array ['column' => 'value'].
     * @return int|false Mengembalikan ID dari record yang baru dibuat, atau false jika gagal.
     */
    public function create(array $data): int|false
    {
        // Ambil nama kolom dan siapkan placeholder
        $columns = implode(', ', array_map(fn($key) => "`$key`", array_keys($data)));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)";
        
        $values = array_values($data);
        $types = '';
        foreach ($values as $value) {
            $types .= $this->getParamType($value);
        }

        $stmt = $this->executeStatement($sql, $types, ...$values);
        if ($stmt) {
            $lastId = $stmt->insert_id;
            $stmt->close();
            return $lastId;
        }
        return false;
    }

    /**
     * [BARU & GENERIK] Memperbarui record berdasarkan ID.
     * @param int $id ID record yang akan diperbarui.
     * @param array $data Data baru dalam bentuk associative array ['column' => 'value'].
     * @return bool True jika berhasil, false jika gagal.
     */
    public function update(int $id, array $data): bool
    {
        if (empty($data)) {
            return false;
        }

        $fields = [];
        $params = [];
        $types = '';

        foreach ($data as $key => $value) {
            $fields[] = "`$key` = ?";
            $types .= $this->getParamType($value);
            $params[] = $value;
        }
        
        // Tambahkan ID ke akhir parameter untuk klausa WHERE
        $params[] = $id;
        $types .= 'i';

        $sql = "UPDATE {$this->tableName} SET " . implode(', ', $fields) . " WHERE {$this->primaryKey} = ?";
        
        $stmt = $this->executeStatement($sql, $types, ...$params);
        if ($stmt) {
            // affected_rows mengembalikan 0 jika tidak ada data yg berubah, tapi query berhasil.
            // >= 0 memastikan query berhasil dieksekusi tanpa error.
            $success = $stmt->affected_rows >= 0;
            $stmt->close();
            return $success;
        }
        return false;
    }

    /**
     * [BARU & GENERIK] Menghapus record berdasarkan ID.
     * @param int $id ID record yang akan dihapus.
     * @return bool True jika berhasil, false jika gagal.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->tableName} WHERE {$this->primaryKey} = ?";
        $stmt = $this->executeStatement($sql, 'i', $id);
        if ($stmt) {
            $success = $stmt->affected_rows > 0;
            $stmt->close();
            return $success;
        }
        return false;
    }

    // ===================================================================
    // METODE PEMBANTU (HELPER) & TRANSAKSI
    // ===================================================================

    /**
     * [TETAP] Menjalankan query kustom dengan prepared statement.
     * @return mysqli_stmt|false
     */
    protected function executeStatement(string $sql, string $types = '', ...$params): mysqli_stmt|false
    {
        try {
            $stmt = $this->db->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Prepare statement gagal: " . $this->db->error);
            }

            if ($types && count($params) > 0) {
                $stmt->bind_param($types, ...$params);
            }

            if (!$stmt->execute()) {
                throw new Exception("Execute statement gagal: " . $stmt->error);
            }
            return $stmt;
        } catch (Exception $e) {
            // Log error untuk debugging
            error_log("Database Error in " . static::class . ": " . $e->getMessage() . " | SQL: " . $sql);
            return false;
        }
    }

    /**
     * [TETAP] Menjalankan query SELECT dan mengambil semua hasilnya.
     */
    public function fetchAll(string $sql, string $types = '', ...$params): array
    {
        $data = [];
        $stmt = $this->executeStatement($sql, $types, ...$params);
        if ($stmt) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $stmt->close();
        }
        return $data;
    }

    /**
     * [BARU] Helper untuk menentukan tipe parameter (s, i, d, b) untuk bind_param.
     * @param mixed $value
     * @return string
     */
    private function getParamType($value): string
    {
        if (is_int($value)) return 'i';
        if (is_float($value)) return 'd';
        if (is_double($value)) return 'd';
        return 's';
    }
    

    

    // --- Metode Transaksi ---
    public function beginTransaction(): bool { return $this->db->begin_transaction(); }
    public function commit(): bool { return $this->db->commit(); }
    public function rollback(): bool { return $this->db->rollback(); }
}