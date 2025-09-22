<?php
// public/index.php

use App\Core\Application;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\BookingController;
use App\Controllers\ServiceController;
use App\Controllers\AdminController;
use App\Controllers\AdminBookingController;
use App\Controllers\AdminCustomerController;
use App\Controllers\AdminServiceController;
use App\Controllers\AdminSuggestionController;
use App\Controllers\AdminUserController;
use App\Controllers\AdminReportController;
use App\Controllers\AdminGalleryController;
// Autoloader
require_once __DIR__ . '/../autoload.php';

// Konfigurasi
$config = require_once __DIR__ . '/../config/app.php';

// Inisialisasi Aplikasi
$app = new Application(dirname(__DIR__), $config);

// === PENDAFTARAN SEMUA RUTE (URL) APLIKASI ===

// --- Rute Halaman Publik (GET) ---
$app->router->get('/', [HomeController::class, 'index']);
$app->router->get('/about', [HomeController::class, 'about']);
$app->router->get('/services', [ServiceController::class, 'index']);
$app->router->get('/contact', [HomeController::class, 'contact']);
$app->router->get('/feature', [HomeController::class, 'feature']);
$app->router->get('/team', [HomeController::class, 'team']);
$app->router->get('/testimonial', [HomeController::class, 'testimonial']);
$app->router->get('/blog', [HomeController::class, 'blog']);
$app->router->post('/contact', [HomeController::class, 'handleContact']); // Tambahkan baris ini

// --- Rute Otentikasi (GET & POST) ---
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'handleLogin']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'handleRegister']);
$app->router->get('/logout', [AuthController::class, 'logout']);

// --- Rute Booking oleh User (GET & POST) ---
$app->router->get('/book', [BookingController::class, 'book']);
$app->router->post('/book', [BookingController::class, 'submitBooking']);
$app->router->get('/user_bookings', [BookingController::class, 'userBookings']);
$app->router->post('/booking/cancel', [BookingController::class, 'cancelBooking']);

// --- Rute Halaman Admin (GET & POST) ---
// Dashboard
$app->router->get('/admin/dashboard', [AdminController::class, 'dashboard']);

// Manajemen Booking Admin
// =================================================================
// RUTE UNTUK MANAJEMEN BOOKING ADMIN
// =================================================================
$app->router->get('/admin/bookings', [AdminBookingController::class, 'index']);
$app->router->post('/admin/bookings/manage', [AdminBookingController::class, 'manage']);

// PASTIKAN BARIS INI ADA: Rute untuk menampilkan halaman tolak pembayaran
$app->router->get('/admin/bookings/reject', [AdminBookingController::class, 'showRejectForm']);

// Rute untuk memproses form penolakan (yang ini sudah ada)
$app->router->post('/admin/bookings/reject-payment', [AdminBookingController::class, 'rejectPayment']);

$app->router->post('/admin/bookings/confirm-payment', [AdminBookingController::class, 'confirmPayment']);
$app->router->post('/admin/bookings/complete', [AdminBookingController::class, 'completeBooking']);
$app->router->post('/admin/bookings/delete', [AdminBookingController::class, 'delete']);

// Manajemen Customers
$app->router->get('/admin/customers', [AdminCustomerController::class, 'index']);
$app->router->post('/admin/customers/create', [AdminCustomerController::class, 'create']);
$app->router->post('/admin/customers/update', [AdminCustomerController::class, 'update']);
$app->router->post('/admin/customers/delete', [AdminCustomerController::class, 'delete']);

// Manajemen Service
$app->router->get('/admin/services', [AdminServiceController::class, 'index']);
$app->router->post('/admin/services/create', [AdminServiceController::class, 'create']);
$app->router->post('/admin/services/update', [AdminServiceController::class, 'update']);
$app->router->post('/admin/services/delete', [AdminServiceController::class, 'delete']);

// Manajemen User
$app->router->get('/admin/users', [AdminUserController::class, 'index']);
$app->router->post('/admin/users/create', [AdminUserController::class, 'create']);
$app->router->post('/admin/users/update', [AdminUserController::class, 'update']);
$app->router->post('/admin/users/delete', [AdminUserController::class, 'delete']);

// Manajemen Saran/Kontak
$app->router->get('/admin/suggestions', [AdminSuggestionController::class, 'index']);
$app->router->post('/admin/suggestions/delete', [AdminSuggestionController::class, 'delete']);
//Gallery
$app->router->get('/admin/gallery', [AdminGalleryController::class, 'index']);
$app->router->post('/admin/gallery/create', [AdminGalleryController::class, 'create']);
$app->router->post('/admin/gallery/delete', [AdminGalleryController::class, 'delete']);
$app->router->get('/admin/gallery/edit', [AdminGalleryController::class, 'edit']);
$app->router->post('/admin/gallery/update', [AdminGalleryController::class, 'update']);

// Laporan
$app->router->get('/admin/reports/bookings', [AdminReportController::class, 'bookings']);
$app->router->get('/admin/reports/service_stats', [AdminReportController::class, 'serviceStats']);


// Menjalankan Aplikasi
$app->run();