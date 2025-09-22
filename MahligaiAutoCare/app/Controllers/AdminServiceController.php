<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Service;
use App\Models\Booking;

class AdminServiceController extends Controller
{
    protected Service $serviceModel;
    protected Booking $bookingModel;

    public function __construct()
    {
        parent::__construct();
        $this->protectRoute([], ['admin1']); // Hanya super admin
        $this->serviceModel = new Service();
        $this->bookingModel = new Booking();
    }

    public function index(): string
    {
        $flash = $this->sessionManager->getFlash('service_status');
        $services = $this->serviceModel->all();
        return $this->render('admin/services/index', [
            'title' => 'Manajemen Layanan',
            'services' => $services,
            'message' => $flash['message'] ?? '',
            'message_type' => $flash['type'] ?? 'info'
        ], 'admin_layout');
    }
    
    public function create(Request $request, Response $response)
    {
        $data = [
            'service_name' => $request->body['service_name'],
            'description' => $request->body['description'],
            'price' => (float)$request->body['price']
        ];
        
        if ($this->serviceModel->create($data)) {
            $this->sessionManager->setFlash('service_status', 'Layanan baru berhasil ditambahkan.', 'success');
        } else {
            $this->sessionManager->setFlash('service_status', 'Gagal menambahkan layanan.', 'danger');
        }
        $response->redirect($this->request->baseUrl() . '/admin/services');
    }

    public function update(Request $request, Response $response)
    {
        $id = (int)$request->body['service_id'];
        $data = [
            'service_name' => $request->body['service_name'],
            'description' => $request->body['description'],
            'price' => (float)$request->body['price']
        ];

        if ($this->serviceModel->update($id, $data)) {
            $this->sessionManager->setFlash('service_status', "Layanan #{$id} berhasil diperbarui.", 'success');
        } else {
            $this->sessionManager->setFlash('service_status', "Gagal memperbarui layanan #{$id}.", 'danger');
        }
        $response->redirect($this->request->baseUrl() . '/admin/services');
    }

    public function delete(Request $request, Response $response)
    {
        $id = (int)$request->body['service_id'];
        
        // Logika aman: periksa apakah layanan terikat pada booking
        $bookings = $this->bookingModel->fetchAll("SELECT booking_id FROM booking_services WHERE service_id = ?", "i", $id);
        
        if (!empty($bookings)) {
            $this->sessionManager->setFlash('service_status', "Gagal menghapus! Layanan #{$id} masih digunakan pada pemesanan yang ada.", 'danger');
        } else {
            if ($this->serviceModel->delete($id)) {
                $this->sessionManager->setFlash('service_status', "Layanan #{$id} berhasil dihapus.", 'success');
            } else {
                $this->sessionManager->setFlash('service_status', "Gagal menghapus layanan #{$id}.", 'danger');
            }
        }
        $response->redirect($this->request->baseUrl() . '/admin/services');
    }
}