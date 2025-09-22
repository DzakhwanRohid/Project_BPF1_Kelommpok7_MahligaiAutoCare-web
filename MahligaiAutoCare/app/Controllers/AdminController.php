<?php
// app/Controllers/AdminController.php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Booking;

/**
 * AdminController mengelola halaman dashboard utama admin.
 * VERSI REFACTOR: Disesuaikan untuk memanggil metode statistik dari Model.
 */
class AdminController extends Controller
{
    protected User $userModel;
    protected Customer $customerModel;
    protected Service $serviceModel;
    protected Booking $bookingModel;

    public function __construct()
    {
        parent::__construct();
        // Middleware: Hanya admin yang bisa akses semua metode di controller ini
        $this->protectRoute([], ['admin1', 'admin2']);

        $this->userModel = new User();
        $this->customerModel = new Customer();
        $this->serviceModel = new Service();
        $this->bookingModel = new Booking();
    }

    /**
     * Menampilkan halaman dashboard dengan data statistik.
     */
    public function dashboard(): string
    {
        try {
            // Ambil semua data statistik dari masing-masing model
            $totalCustomers = $this->customerModel->getTotalCustomers();
            $totalServices = $this->serviceModel->getTotalServices();
            $totalUsers = $this->userModel->getTotalUsers();
            $avgServicePrice = $this->serviceModel->getAveragePrice();
            
            $bookingStats = $this->bookingModel->getBookingStats();
            $recentBookings = $this->bookingModel->getRecentBookings(5);

        } catch (\Exception $e) {
            // Jika ada error saat mengambil data, set nilai default dan tampilkan pesan
            $this->sessionManager->setFlash('dashboard_error', 'Gagal memuat data statistik dashboard: ' . $e->getMessage(), 'danger');
            
            // Set nilai default agar view tidak error
            $totalCustomers = $totalServices = $totalUsers = 0;
            $avgServicePrice = 0.0;
            $bookingStats = ['total_bookings' => 0, 'pending_bookings' => 0, 'completed_bookings' => 0];
            $recentBookings = [];
        }

        return $this->render('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'total_customers' => $totalCustomers,
            'total_services' => $totalServices,
            'total_users' => $totalUsers,
            'avg_service_price' => $avgServicePrice,
            'total_bookings' => $bookingStats['total_bookings'],
            'pending_bookings' => $bookingStats['pending_bookings'],
            'completed_bookings' => $bookingStats['completed_bookings'],
            'recent_bookings' => $recentBookings
        ], 'admin_layout');
    }
}