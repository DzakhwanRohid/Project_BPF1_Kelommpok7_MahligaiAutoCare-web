<?php
// app/Models/Customer.php
namespace App\Models;

/**
 * Model untuk tabel 'customers'.
 * VERSI REFACTOR: Menggunakan metode generik dari BaseModel.
 */
class Customer extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('customers');
        $this->setPrimaryKey('customer_id');
    }

    /**
     * [TETAP] Mencari pelanggan berdasarkan nomor telepon atau email untuk mencegah duplikasi.
     *
     * @param string $phone Nomor telepon.
     * @param string $email Email.
     * @return array|null Data pelanggan atau null jika tidak ditemukan.
     */
    public function findByPhoneOrEmail(string $phone, string $email): ?array
    {
        // Query hanya untuk memeriksa keberadaan data
        $sql = "SELECT * FROM {$this->tableName} WHERE phone_number = ? OR email = ? LIMIT 1";
        return $this->fetchAll($sql, "ss", $phone, $email)[0] ?? null;
    }

    /**
     * [TETAP] Mendapatkan jumlah total pelanggan.
     * @return int
     */
    public function getTotalCustomers(): int
    {
        $sql = "SELECT COUNT({$this->primaryKey}) as total FROM {$this->tableName}";
        $result = $this->db->query($sql);
        if ($result) {
            return (int) $result->fetch_assoc()['total'];
        }
        return 0;
    }
    /**
     * [BARU] Menghapus pelanggan beserta semua data terkaitnya (users, bookings)
     * dalam satu transaksi database untuk menjaga integritas data.
     */
    public function deleteCustomerAndRelations(int $customerId): bool
    {
        $this->beginTransaction();
        try {
            // Hapus data dari tabel 'users' yang terkait
            $this->db->query("DELETE FROM users WHERE customer_id = {$customerId}");

            // Hapus data dari tabel 'bookings' yang terkait
            // Pertama, hapus dari tabel pivot `booking_services` karena ada foreign key
            $bookingIdsResult = $this->db->query("SELECT booking_id FROM bookings WHERE customer_id = {$customerId}");
            $bookingIds = [];
            while ($row = $bookingIdsResult->fetch_assoc()) {
                $bookingIds[] = $row['booking_id'];
            }
            if (!empty($bookingIds)) {
                $this->db->query("DELETE FROM booking_services WHERE booking_id IN (" . implode(',', $bookingIds) . ")");
            }
            
            // Baru hapus dari tabel bookings
            $this->db->query("DELETE FROM bookings WHERE customer_id = {$customerId}");

            // Terakhir, hapus data pelanggan itu sendiri
            $this->delete($customerId);

            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->rollback();
            error_log("Error deleting customer relations: " . $e->getMessage());
            return false;
        }
    }
}