<?php
// app/Models/User.php
namespace App\Models;

/**
 * Model untuk tabel 'users'.
 * VERSI REFACTOR: Menggunakan metode generik dari BaseModel.
 */
class User extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('users');
        $this->setPrimaryKey('user_id');
    }

    /**
     * [TETAP] Menemukan user berdasarkan username.
     *
     * @param string $username Username.
     * @return array|null Data user atau null jika tidak ditemukan.
     */
    public function findByUsername(string $username): ?array
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE username = ? LIMIT 1";
        $stmt = $this->executeStatement($sql, "s", $username);
        if ($stmt) {
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        }
        return null;
    }

    /**
     * [TETAP] Mendapatkan jumlah total user.
     * @return int
     */
    public function getTotalUsers(): int
    {
        $sql = "SELECT COUNT({$this->primaryKey}) as total FROM {$this->tableName}";
        $result = $this->db->query($sql);
        if ($result) {
            return (int) $result->fetch_assoc()['total'];
        }
        return 0;
    }
}