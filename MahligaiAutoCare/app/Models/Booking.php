<?php
// app/Models/Booking.php
namespace App\Models;
use Exception;
use DateTime;

/**
 * Model untuk tabel 'bookings'.
 * VERSI REFACTOR: Disederhanakan untuk menggunakan BaseModel,
 * namun tetap mempertahankan metode transaksional dan query kompleks.
 */
class Booking extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('bookings');
        $this->setPrimaryKey('booking_id');
    }

    // =================================================================================
    // FUNGSI INTI CRUD UNTUK BOOKING (dengan tabel pivot)
    // =================================================================================

    /**
     * Membuat pemesanan baru beserta layanan-layanan yang dipilih dalam satu transaksi.
     * @param array $bookingData Data untuk tabel 'bookings'.
     * @param array $serviceIds Array berisi ID layanan yang dipilih.
     * @return int|false ID pemesanan baru atau false jika gagal.
     */
     public function createBookingWithServices(array $bookingData, array $serviceIds): int|false
    {
        $this->beginTransaction();
        try {
            // Gunakan metode create generik dari BaseModel untuk membuat booking utama
            $bookingId = $this->create($bookingData);
            if (!$bookingId) {
                throw new Exception("Gagal membuat data booking utama.");
            }

            // Tambahkan relasi ke tabel pivot 'booking_services'
            if (!empty($serviceIds)) {
                $sqlPivot = "INSERT INTO booking_services (booking_id, service_id) VALUES (?, ?)";
                $stmtPivot = $this->db->prepare($sqlPivot); // Ini akan mengembalikan mysqli_stmt
                if ($stmtPivot === false) {
                     // Tambahkan detail error dari mysqli untuk debugging
                     throw new Exception("Prepare statement untuk booking_services gagal: " . $this->db->error);
                }

                // *** PERBAIKAN PENTING DI SINI ***
                // Deklarasikan variabel untuk binding di luar loop
                $bId = null;
                $sId = null;
                // Bind parameter ke variabel ini sekali
                $stmtPivot->bind_param("ii", $bId, $sId);

                foreach ($serviceIds as $serviceId) {
                    // Perbarui nilai variabel yang sudah di-bind di setiap iterasi
                    $bId = $bookingId;
                    $sId = (int)$serviceId;
                    if (!$stmtPivot->execute()) {
                        throw new Exception("Gagal menambahkan layanan ke booking. Detail: " . $stmtPivot->error);
                    }
                }
                $stmtPivot->close();
            }

            $this->commit();
            return $bookingId;

        } catch (Exception $e) {
            $this->rollback();
            error_log("Error createBookingWithServices: " . $e->getMessage());
            return false;
        }
    }
    /**
     * Memperbarui pemesanan beserta layanan-layanannya dalam satu transaksi.
     * @param int   $bookingId  ID pemesanan yang akan diupdate.
     * @param array $bookingData Data baru untuk tabel 'bookings'.
     * @param array $serviceIds Array baru berisi ID layanan.
     * @return bool True jika berhasil, false jika gagal.
     */
   public function updateBookingWithServices(int $bookingId, array $bookingData, array $serviceIds): bool
    {
        $this->beginTransaction();
        try {
            // Update data booking utama jika ada
            if (!empty($bookingData)) {
                $this->update($bookingId, $bookingData);
            }

            // Hapus semua relasi layanan yang lama
            // Pastikan metode executeStatement di BaseModel berfungsi dengan mysqli prepared statements
            $this->executeStatement("DELETE FROM booking_services WHERE booking_id = ?", "i", $bookingId);

            // Tambahkan kembali relasi layanan yang baru
            if (!empty($serviceIds)) {
                $sqlPivot = "INSERT INTO booking_services (booking_id, service_id) VALUES (?, ?)";
                $stmtPivot = $this->db->prepare($sqlPivot); // Ini akan mengembalikan mysqli_stmt
                if ($stmtPivot === false) {
                    throw new Exception("Prepare statement untuk update booking_services gagal: " . $this->db->error);
                }

                // *** PERBAIKAN PENTING DI SINI ***
                // Deklarasikan variabel untuk binding di luar loop
                $bId = null;
                $sId = null;
                // Bind parameter ke variabel ini sekali
                $stmtPivot->bind_param("ii", $bId, $sId);

                foreach ($serviceIds as $serviceId) {
                    // Perbarui nilai variabel yang sudah di-bind di setiap iterasi
                    $bId = $bookingId;
                    $sId = (int)$serviceId;
                    if (!$stmtPivot->execute()) {
                        throw new Exception("Gagal memperbarui layanan untuk booking. Detail: " . $stmtPivot->error);
                    }
                }
                $stmtPivot->close();
            }

            $this->commit();
            return true;

        } catch (Exception $e) {
            $this->rollback();
            error_log("Error updateBookingWithServices: " . $e->getMessage());
            return false;
        }
    }
 public function getBookingWithDetails(int $bookingId): ?array
    {
        $sql = "SELECT 
                    b.*, 
                    c.first_name, c.last_name,
                    CONCAT(c.first_name, ' ', c.last_name) as customer_name,
                    c.phone_number as customer_phone,
                    GROUP_CONCAT(s.service_name SEPARATOR ', ') as service_names,
                    GROUP_CONCAT(s.service_id) as service_ids,
                    b.total_price -- Mengambil total harga dari tabel booking
                FROM bookings b
                JOIN customers c ON b.customer_id = c.customer_id
                LEFT JOIN booking_services bs ON b.booking_id = bs.booking_id
                LEFT JOIN services s ON bs.service_id = s.service_id
                WHERE b.booking_id = ?
                GROUP BY b.booking_id";
        
        // fetchAll akan mengembalikan array berisi hasil. Karena kita mencari satu, ambil elemen pertama.
        $results = $this->fetchAll($sql, "i", $bookingId);
        return $results[0] ?? null; // Kembalikan hasil pertama atau null jika tidak ada
    }
    // =================================================================================
    // FUNGSI PENGAMBILAN DATA (READ) YANG SPESIFIK & KOMPLEKS
    // Metode ini dipertahankan karena memerlukan JOIN ke tabel lain.
    // =================================================================================

    /**
     * Mengambil semua pemesanan dengan detail pelanggan dan gabungan nama layanan.
     * @return array
     */
    public function getAllWithDetails(): array
    {
        $sql = "SELECT 
                    b.*, 
                    c.first_name, c.last_name,
                    CONCAT(c.first_name, ' ', c.last_name) as customer_name,
                    c.phone_number as customer_phone,
                    GROUP_CONCAT(s.service_name SEPARATOR ', ') as service_names,
                    GROUP_CONCAT(s.service_id) as service_ids,
                    SUM(s.price) as calculated_price
                FROM bookings b
                JOIN customers c ON b.customer_id = c.customer_id
                LEFT JOIN booking_services bs ON b.booking_id = bs.booking_id
                LEFT JOIN services s ON bs.service_id = s.service_id
                GROUP BY b.booking_id
                ORDER BY b.booking_date DESC";
        return $this->fetchAll($sql);
    }

    /**
     * Mengambil pemesanan berdasarkan ID pelanggan dengan detail gabungan layanan.
     * @param int $customerId
     * @return array
     */
    public function getBookingsByCustomerId(int $customerId): array
    {
        $sql = "SELECT 
                    b.*,
                    GROUP_CONCAT(s.service_name SEPARATOR ', ') as service_names
                FROM bookings b
                LEFT JOIN booking_services bs ON b.booking_id = bs.booking_id
                LEFT JOIN services s ON bs.service_id = s.service_id
                WHERE b.customer_id = ?
                GROUP BY b.booking_id
                ORDER BY b.booking_date DESC";
        return $this->fetchAll($sql, "i", $customerId);
    }
    
    /**
     * Mengambil daftar pemesanan terbaru untuk dashboard.
     * @param int $limit
     * @return array
     */
    public function getRecentBookings(int $limit = 5): array
    {
        $sql = "SELECT 
                    b.booking_id, 
                    CONCAT(c.first_name, ' ', c.last_name) as customer_name, 
                    b.booking_date,
                    b.status,
                    GROUP_CONCAT(s.service_name SEPARATOR ', ') as service_names
                FROM {$this->tableName} b
                JOIN customers c ON b.customer_id = c.customer_id
                LEFT JOIN booking_services bs ON b.booking_id = bs.booking_id
                LEFT JOIN services s ON bs.service_id = s.service_id
                GROUP BY b.booking_id
                ORDER BY b.booking_date DESC
                LIMIT ?";
        return $this->fetchAll($sql, "i", $limit);
    }


    // =================================================================================
    // FUNGSI UNTUK LAPORAN (REPORTS)
    // =================================================================================

    public function getServicePopularity(): array
    {
        $sql = "SELECT
                    s.service_name,
                    COUNT(bs.service_id) AS total_bookings_count
                FROM services s
                LEFT JOIN booking_services bs ON s.service_id = bs.service_id
                GROUP BY s.service_id, s.service_name
                ORDER BY total_bookings_count DESC";
        return $this->fetchAll($sql);
    }

    public function getServiceRevenue(): array
    {
        $sql = "SELECT
                    s.service_name,
                    SUM(s.price) AS total_revenue
                FROM booking_services bs
                JOIN services s ON bs.service_id = s.service_id
                JOIN bookings b ON bs.booking_id = b.booking_id
                WHERE b.status = 'Completed'
                GROUP BY s.service_id, s.service_name
                ORDER BY total_revenue DESC";
        return $this->fetchAll($sql);
    }

    public function getBookingStats(): array
    {
        $sql = "SELECT status, COUNT(*) as count FROM {$this->tableName} GROUP BY status";
        $results = $this->fetchAll($sql);
        
        $stats = [
            'total_bookings' => 0, 'pending_bookings' => 0, 'confirmed_bookings' => 0,
            'completed_bookings' => 0, 'cancelled_bookings' => 0,
        ];
        $statusCounts = [];

        foreach ($results as $row) {
            $statusKey = strtolower($row['status']) . '_bookings';
            if (array_key_exists($statusKey, $stats)) {
                $stats[$statusKey] = $row['count'];
            }
            $stats['total_bookings'] += $row['count'];
            $statusCounts[$row['status']] = $row['count'];
        }
        $stats['booking_status_counts'] = $statusCounts;
        return $stats;
    }


    // =================================================================================
    // FUNGSI UNTUK MENGUBAH STATUS BOOKING
    // Metode ini menyembunyikan detail implementasi dari Controller.
    // =================================================================================

    /**
     * Mengubah status pemesanan menjadi "Cancelled" oleh user atau admin.
     */
    public function cancelBooking(int $bookingId, string $reason): bool
    {
        $data = [
            'status' => 'Cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => (new DateTime())->format('Y-m-d H:i:s')
        ];
        return $this->update($bookingId, $data);
    }

    /**
     * Mengkonfirmasi pembayaran dan status pemesanan.
     */
    public function confirmPayment(int $bookingId): bool
    {
        $data = [
            'payment_status' => 'Confirmed',
            'status' => 'Confirmed'
        ];
        return $this->update($bookingId, $data);
    }

    /**
     * Menolak pembayaran, yang juga otomatis membatalkan pemesanan.
     */
    public function rejectPayment(int $bookingId, string $reason): bool
    {
        $data = [
            'payment_status' => 'Rejected',
            'status' => 'Cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => (new DateTime())->format('Y-m-d H:i:s')
        ];
        return $this->update($bookingId, $data);
    }

    /**
     * Menyelesaikan pemesanan.
     */
    public function completeBooking(int $bookingId): bool
    {
        $data = [
            'status' => 'Completed',
            'payment_status' => 'Confirmed' // Asumsi pembayaran lunas saat selesai
        ];
        return $this->update($bookingId, $data);
    }
}