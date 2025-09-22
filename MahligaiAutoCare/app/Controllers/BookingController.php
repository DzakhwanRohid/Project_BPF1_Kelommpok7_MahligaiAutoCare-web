<?php
// File: app/Controllers/BookingController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Customer;
use App\Core\Application;
use DateTime;
use Exception;

class BookingController extends Controller
{
    protected Booking $bookingModel;
    protected Service $serviceModel;
    protected Customer $customerModel;

    public function __construct()
    {
        parent::__construct();
        $this->protectRoute(['book', 'submitBooking', 'userBookings', 'cancelBooking']);
        $this->bookingModel = new Booking();
        $this->serviceModel = new Service();
        $this->customerModel = new Customer();
    }

    public function book(): string
    {
        $customerId = $this->sessionManager->get('customer_id');
        $customer = $this->customerModel->find($customerId);
        $services = $this->serviceModel->all();
        $flash = $this->sessionManager->getFlash('booking_error');

        return $this->render('bookings/book', [
            'title' => 'Buat Janji Temu',
            'page_title' => 'Buat Janji Temu',
            'breadcrumb_items' => [
                ['label' => 'Beranda', 'url' => $this->request->baseUrl() . '/'],
                ['label' => 'Pesan Layanan', 'url' => '#']
            ],
            'customer' => $customer,
            'services' => $services,
            'error_message' => $flash['message'] ?? '',
            'error_type' => $flash['type'] ?? 'danger'
        ]);
    }

    public function submitBooking(Request $request, Response $response)
    {
        $body = $request->body;
        $customerId = $this->sessionManager->get('customer_id');
        $serviceIds = $body['service_ids'] ?? [];
        $bookingDateStr = ($body['booking_date'] ?? '') . ' ' . ($body['booking_time'] ?? '');
        $paymentMethod = $body['payment_method'] ?? '';

        if (empty($serviceIds) || empty($body['booking_date']) || empty($body['booking_time']) || empty($paymentMethod)) {
            $this->sessionManager->setFlash('booking_error', 'Semua kolom wajib diisi, termasuk memilih minimal satu layanan.', 'danger');
            $response->redirect($request->baseUrl() . '/book');
            return;
        }

        try {
            $bookingTime = new DateTime($body['booking_time']);
            $startTime = new DateTime('08:00');
            $endTime = new DateTime('17:00');
            if ($bookingTime < $startTime || $bookingTime > $endTime) {
                $this->sessionManager->setFlash('booking_error', 'Waktu pemesanan hanya tersedia dari jam 8 Pagi hingga 5 Sore.', 'danger');
                $response->redirect($request->baseUrl() . '/book');
                return;
            }
            $bookingDate = new DateTime($bookingDateStr);
        } catch (Exception $e) {
            $this->sessionManager->setFlash('booking_error', 'Format tanggal atau waktu tidak valid.', 'danger');
            $response->redirect($request->baseUrl() . '/book');
            return;
        }

        $paymentProofPath = null;
        if (in_array($paymentMethod, ['QRIS', 'Transfer Bank'])) {
            if ($request->hasFile('payment_proof') && $request->files['payment_proof']['error'] === UPLOAD_ERR_OK) {
                $targetDir = Application::$ROOT_DIR . '/public/uploads/payment_proofs';
                $uploadedFile = $request->uploadFile('payment_proof', $targetDir);
                if ($uploadedFile) {
                    $paymentProofPath = '/uploads/payment_proofs/' . basename($uploadedFile);
                } else {
                    $this->sessionManager->setFlash('booking_error', 'Gagal mengunggah bukti pembayaran.', 'danger');
                    $response->redirect($request->baseUrl() . '/book');
                    return;
                }
            } else {
                $this->sessionManager->setFlash('booking_error', 'Bukti pembayaran wajib diunggah untuk metode pembayaran ini.', 'danger');
                $response->redirect($request->baseUrl() . '/book');
                return;
            }
        }
        
        // ================== PERBAIKAN UTAMA DI SINI ==================
        // 4. Hitung Total Harga di Server menggunakan method find() yang ada
        $totalPrice = 0;
        foreach ($serviceIds as $serviceId) {
            // Gunakan find() yang mengembalikan array
            $service = $this->serviceModel->find((int)$serviceId);

            // Akses harga sebagai elemen array
            if (is_array($service) && isset($service['price'])) {
                $totalPrice += $service['price'];
            }
        }
        // =============================================================

        $bookingData = [
            'customer_id' => $customerId,
            'booking_date' => $bookingDate->format('Y-m-d H:i:s'),
            'total_price' => $totalPrice,
            'status' => 'Pending',
            'payment_method' => $paymentMethod,
            'payment_status' => ($paymentMethod == 'Bayar di Tempat') ? 'Pending' : 'Awaiting Confirmation',
            'payment_proof' => $paymentProofPath,
            'vehicle_type' => $body['vehicle_type'] ?? 'Mobil',
            'notes' => $body['notes'] ?? null
        ];

        $result = $this->bookingModel->createBookingWithServices($bookingData, $serviceIds);

        if ($result) {
            $this->sessionManager->setFlash('booking_success', 'Pemesanan Anda berhasil dibuat! Mohon tunggu konfirmasi dari admin.', 'success');
            // Arahkan ke halaman riwayat pemesanan setelah berhasil
            $response->redirect($request->baseUrl() . '/user_bookings');
        } else {
            $this->sessionManager->setFlash('booking_error', 'Terjadi kesalahan saat memproses pemesanan Anda. Silakan coba lagi.', 'danger');
            $response->redirect($request->baseUrl() . '/book');
        }
    }

    public function userBookings(): string
    {
        $customerId = $this->sessionManager->get('customer_id');
        $bookings = $this->bookingModel->getBookingsByCustomerId($customerId);
        $flash = $this->sessionManager->getFlash('booking_success');

        return $this->render('bookings/user_bookings', [
            'title' => 'Riwayat Pemesanan Saya',
            'page_title' => 'Riwayat Pemesanan',
            'breadcrumb_items' => [
                ['label' => 'Beranda', 'url' => $this->request->baseUrl() . '/'],
                ['label' => 'Riwayat Pemesanan', 'url' => '#']
            ],
            'bookings' => $bookings,
            'success_message' => $flash['message'] ?? ''
        ]);
    }

    public function cancelBooking(Request $request, Response $response)
    {
        // Ambil ID dari body POST
        $bookingId = (int)($request->body['booking_id'] ?? 0);
        $customerId = $this->sessionManager->get('customer_id');

        $booking = $this->bookingModel->find($bookingId);

        // Akses data sebagai array
        $bookingCustomerId = $booking['customer_id'] ?? null;
        $bookingStatus = $booking['status'] ?? null;

        if ($booking && $bookingCustomerId == $customerId && in_array($bookingStatus, ['Pending', 'Confirmed'])) {
            $this->bookingModel->cancelBooking($bookingId, "Dibatalkan oleh pelanggan.");
            $this->sessionManager->setFlash('booking_success', "Pemesanan dengan ID #{$bookingId} berhasil dibatalkan.", 'success');
        } else {
            $this->sessionManager->setFlash('booking_success', "Gagal membatalkan pemesanan.", 'danger');
        }

        $response->redirect($request->baseUrl() . '/user_bookings');
    }
}