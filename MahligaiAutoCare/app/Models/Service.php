<?php
// app/Models/Service.php
namespace App\Models;
use Exception;
/**
 * Model untuk tabel 'services'.
 * VERSI REFACTOR: Menggunakan metode generik dari BaseModel.
 */
class Service extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('services');
        $this->setPrimaryKey('service_id');
    }

    /**
     * [TETAP] Mengambil rata-rata harga semua layanan.
     *
     * @return float Rata-rata harga layanan.
     */
    public function getAveragePrice(): float
    {
        $result = $this->db->query("SELECT AVG(price) as avg_price FROM {$this->tableName}");
        if ($result) {
            return (float)($result->fetch_assoc()['avg_price'] ?? 0.00);
        }
        return 0.00;
    }

    /**
     * [TETAP] Mendapatkan jumlah total layanan.
     * @return int
     */
    public function getTotalServices(): int
    {
        $sql = "SELECT COUNT({$this->primaryKey}) as total FROM {$this->tableName}";
        $result = $this->db->query($sql);
        if ($result) {
            return (int) $result->fetch_assoc()['total'];
        }
        return 0;
    }
     public function getServicePrice(int $serviceId): ?float
    {
        // Kueri langsung ke database untuk mengambil hanya kolom harga
        $sql = "SELECT price FROM {$this->tableName} WHERE {$this->primaryKey} = ? LIMIT 1";
        
        $stmt = $this->executeStatement($sql, 'i', $serviceId);

        if ($stmt) {
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $stmt->close();

            // Jika data ditemukan, kembalikan harga sebagai float
            if ($data && isset($data['price'])) {
                return (float)$data['price'];
            }
        }

        // Jika layanan tidak ditemukan, kembalikan null
        return null;
    }
   
    public function calculateTotalPrice(array $serviceIds): float
    {
        if (empty($serviceIds)) {
            return 0;
        }

        $placeholders = implode(',', array_fill(0, count($serviceIds), '?'));
        
        // PERBAIKAN: Gunakan $this->tableName dan $this->primaryKey
        $sql = "SELECT SUM(price) as total FROM {$this->tableName} WHERE {$this->primaryKey} IN ($placeholders)";
        
        try {
            $stmt = $this->db->prepare($sql);
            // Dinamis membuat tipe data string (contoh: "iii" untuk 3 integer)
            $types = str_repeat('i', count($serviceIds));
            $stmt->bind_param($types, ...$serviceIds);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            
            return (float)($result['total'] ?? 0);

        } catch (Exception $e) {
            error_log("Error in calculateTotalPrice: " . $e->getMessage());
            return 0;
        }
    }
}
