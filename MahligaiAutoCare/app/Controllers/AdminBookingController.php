<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Helpers\Uploader;
use Exception;
class AdminBookingController extends Controller
{
    protected Booking $bookingModel;
    protected Customer $customerModel;
    protected Service $serviceModel;
    public function __construct()
    {
        parent::__construct();
        $this->protectRoute([], ['admin1', 'admin2']);

        $this->bookingModel = new Booking();
        $this->customerModel = new Customer();
        $this->serviceModel = new Service();
    }
    public function index(): string
    {
        $flash = $this->sessionManager->getFlash('booking_status');
        
        $bookings = $this->bookingModel->getAllWithDetails(); 
        $customers = $this->customerModel->all();
        $services = $this->serviceModel->all();

        return $this->render('admin/bookings/index', [
            'title' => 'Manajemen Pemesanan',
            'bookings' => $bookings,
            'customers' => $customers,
            'services' => $services,
            'message' => $flash['message'] ?? '',
            'message_type' => $flash['type'] ?? 'info',
        ], 'admin_layout');
    }
    public function manage(Request $request, Response $response): void
    {
        if (!$request->isPost()) {
            $response->redirect($this->request->baseUrl() . '/admin/bookings');
            return;
        }

        $body = $request->body;
        $files = $request->files;
        $action = $body['action'] ?? 'add';
        $bookingId = (int)($body['booking_id'] ?? 0);
        if (!in_array($action, ['add', 'edit']) || ($action === 'edit' && $bookingId === 0)) {
             $this->sessionManager->setFlash('booking_status', 'Aksi tidak valid.', 'danger');
             $response->redirect($this->request->baseUrl() . '/admin/bookings');
             return;
        }
        $this->bookingModel->beginTransaction();
        try {
            $customerId = (int)($body['customer_id'] ?? 0);
            if ($customerId <= 0) {
                throw new Exception("Pelanggan harus dipilih dari daftar.");
            }
            $serviceIds = $body['service_ids'] ?? [];
            if (empty($serviceIds)) {
                throw new Exception("Minimal satu layanan harus dipilih.");
            }
            $totalPrice = $this->serviceModel->calculateTotalPrice($serviceIds);
            $bookingDateTime = ($body['booking_date'] ?? '') . ' ' . ($body['booking_time'] ?? '');

            $bookingData = [
                'customer_id'    => $customerId,
                'booking_date'   => $bookingDateTime,
                'vehicle_type'   => $body['vehicle_type'] ?? null,
                'status'         => $body['status'] ?? 'Pending',
                'payment_status' => $body['payment_status'] ?? 'Pending',
                'total_price'    => $totalPrice,
                'notes'          => $body['notes'] ?? null,
            ];

            $photoFile = $files['payment_proof'] ?? null;
            if ($photoFile && $photoFile['error'] === UPLOAD_ERR_OK) {
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/payment_proofs/';
                $uploader = new Uploader($uploadDir);
                
                $newFilename = $uploader->upload($photoFile);
                if ($newFilename) {
                    $bookingData['payment_proof'] = '/uploads/payment_proofs/' . $newFilename;
                }
            }
            else if ($action === 'edit' && empty($photoFile['name'])) {
            }
            if ($action === 'add') {
                $result = $this->bookingModel->createBookingWithServices($bookingData, $serviceIds);
                $message = "Pemesanan baru berhasil ditambahkan.";
            } else { // action === 'edit'
                $result = $this->bookingModel->updateBookingWithServices($bookingId, $bookingData, $serviceIds);
                $message = "Pemesanan ID #{$bookingId} berhasil diperbarui.";
            }   

            
            if (!$result) {
                throw new Exception("Gagal menyimpan perubahan ke database.");
            }
            $this->bookingModel->commit();
            $this->sessionManager->setFlash('booking_status', $message, 'success');

        } catch (Exception $e) {
            $this->bookingModel->rollback();
            $this->sessionManager->setFlash('booking_status', 'Terjadi kesalahan: ' . $e->getMessage(), 'danger');
        }

        $response->redirect($this->request->baseUrl() . '/admin/bookings');
    }
    public function confirmPayment(Request $request, Response $response): void
    {
        $bookingId = (int)($request->body['booking_id'] ?? 0);
        if ($bookingId > 0) {
            $updateData = [
                'payment_status' => 'Confirmed',
                'status' => 'Confirmed' 
            ];
            if ($this->bookingModel->update($bookingId, $updateData)) {
                $this->sessionManager->setFlash('booking_status', 'Pembayaran untuk pesanan #' . $bookingId . ' berhasil dikonfirmasi.', 'success');
            } else {
                $this->sessionManager->setFlash('booking_status', 'Gagal mengonfirmasi pembayaran.', 'danger');
            }
        } else {
            $this->sessionManager->setFlash('booking_status', 'ID Pesanan tidak valid.', 'danger');
        }

        $response->redirect($this->request->baseUrl() . '/admin/bookings');
    }
     public function showRejectForm(Request $request, Response $response): string
    {
        $bookingId = (int)($_GET['id'] ?? 0);
        if ($bookingId <= 0) {
            $this->sessionManager->setFlash('booking_status', 'ID Pesanan tidak valid atau tidak ditemukan.', 'danger');
            $response->redirect($this->request->baseUrl() . '/admin/bookings');
            return ''; // Hentikan eksekusi
        }
        $booking = $this->bookingModel->getBookingWithDetails($bookingId);
        if (!$booking) {
            $this->sessionManager->setFlash('booking_status', "Pesanan dengan ID #{$bookingId} tidak ditemukan di database.", 'danger');
            $response->redirect($this->request->baseUrl() . '/admin/bookings');
            return ''; // Hentikan eksekusi
        }

        // 5. Jika semua aman, baru tampilkan halaman form
        return $this->render('admin/bookings/reject_form', [
            'title' => 'Tolak Pembayaran',
            'booking' => $booking
        ], 'admin_layout');
    }

    /**
     * [FIXED] Menolak pembayaran dan menyimpan alasannya.
     */
     public function rejectPayment(Request $request, Response $response): void
    {
        $bookingId = (int)($request->body['booking_id'] ?? 0);
        // Trim input dan pastikan tidak kosong sebelum digunakan
        $reason = trim($request->body['rejection_reason'] ?? '');

        if ($bookingId > 0) {
            // Jika alasan kosong setelah di-trim, gunakan alasan default
            if (empty($reason)) {
                $reason = 'Bukti pembayaran tidak valid atau tidak sesuai.';
            }

            $updateData = [
                'payment_status' => 'Rejected',
                'cancellation_reason' => $reason // Simpan alasan penolakan
            ];

            if ($this->bookingModel->update($bookingId, $updateData)) {
                $this->sessionManager->setFlash('booking_status', 'Pembayaran untuk pesanan #' . $bookingId . ' telah ditolak.', 'warning');
            } else {
                $this->sessionManager->setFlash('booking_status', 'Gagal menolak pembayaran.', 'danger');
            }
        } else {
            $this->sessionManager->setFlash('booking_status', 'ID Pesanan tidak valid saat menolak pembayaran.', 'danger');
        }

        $response->redirect($this->request->baseUrl() . '/admin/bookings');
    }
    
    /**
     * Menangani aksi tombol: Selesaikan Pemesanan.
     */
    public function completeBooking(Request $request, Response $response)
    {
        $bookingId = (int)($request->body['booking_id'] ?? 0);
        if ($bookingId > 0) {
            $updateData = ['status' => 'Completed'];
            if ($this->bookingModel->update($bookingId, $updateData)) {
                $this->sessionManager->setFlash('booking_status', "Booking #{$bookingId} telah diselesaikan.", 'success');
            } else {
                 $this->sessionManager->setFlash('booking_status', "Gagal menyelesaikan booking #{$bookingId}.", 'danger');
            }
        } else {
             $this->sessionManager->setFlash('booking_status', "ID Pesanan tidak valid.", 'danger');
        }
        $response->redirect($this->request->baseUrl() . '/admin/bookings');
    }

      /**
     * Menangani aksi: Hapus Pemesanan.
     */
    public function delete(Request $request, Response $response)
    {
        if (!$request->isPost()) {
            $response->redirect($this->request->baseUrl() . '/admin/bookings');
            return;
        }

        $bookingId = (int)($request->body['booking_id'] ?? 0);

        if ($bookingId <= 0) {
            $this->sessionManager->setFlash('booking_status', 'ID pemesanan tidak valid untuk dihapus.', 'danger');
            $response->redirect($this->request->baseUrl() . '/admin/bookings');
            return;
        }

        try {
            if ($this->bookingModel->delete($bookingId)) {
                $this->sessionManager->setFlash('booking_status', "Pemesanan ID #{$bookingId} berhasil dihapus.", 'success');
            } else {
                throw new \Exception("Terjadi kesalahan database saat menghapus.");
            }
        } catch (\Exception $e) {
            $this->sessionManager->setFlash('booking_status', "Gagal menghapus pemesanan ID #{$bookingId}. " . $e->getMessage(), 'danger');
        }

        $response->redirect($this->request->baseUrl() . '/admin/bookings');
    }
}
