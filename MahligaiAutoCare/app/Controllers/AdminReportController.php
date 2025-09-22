<?php
// app/Controllers/AdminReportController.php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Booking;

/**
 * AdminReportController mengelola laporan di sisi admin.
 * VERSI REFACTOR: Lebih bersih dan menggunakan metode statistik dari model.
 */
class AdminReportController extends Controller
{
    protected Booking $bookingModel;

    public function __construct()
    {
        parent::__construct();
        // Hanya super admin (admin1) yang boleh mengakses laporan
        $this->protectRoute([], ['admin1']);
        $this->bookingModel = new Booking();
    }

    /**
     * Menampilkan laporan daftar semua pemesanan.
     */
    public function bookings(): string
    {
        $flash = $this->sessionManager->getFlash('report_status');
        $bookingsReport = [];
        $message = $flash['message'] ?? '';
        $message_type = $flash['type'] ?? 'info';

        try {
            $bookingsReport = $this->bookingModel->getAllWithDetails();
        } catch (\Exception $e) {
            $message = "Gagal memuat laporan pemesanan: " . $e->getMessage();
            $message_type = 'danger';
        }

        return $this->render('admin/reports/bookings', [
            'title' => 'Laporan Pemesanan',
            'bookings_report' => $bookingsReport,
            'message' => $message,
            'message_type' => $message_type
        ], 'admin_layout');
    }

    /**
     * Menampilkan laporan statistik layanan.
     */
    public function serviceStats(): string
    {
        $flash = $this->sessionManager->getFlash('report_status');
        $serviceStats = [];
        $bookingStatusCounts = [];
        $message = $flash['message'] ?? '';
        $message_type = $flash['type'] ?? 'info';

        try {
            $serviceStats['popularity'] = $this->bookingModel->getServicePopularity();
            $serviceStats['revenue'] = $this->bookingModel->getServiceRevenue();
            $bookingStatusCounts = $this->bookingModel->getBookingStats()['booking_status_counts'];

        } catch (\Exception $e) {
            $message = "Gagal memuat statistik layanan: " . $e->getMessage();
            $message_type = 'danger';
        }

        return $this->render('admin/reports/service_stats', [
            'title' => 'Laporan Statistik Layanan',
            'service_stats' => $serviceStats,
            'booking_status_counts' => $bookingStatusCounts,
            'message' => $message,
            'message_type' => $message_type
        ], 'admin_layout');
    }
}