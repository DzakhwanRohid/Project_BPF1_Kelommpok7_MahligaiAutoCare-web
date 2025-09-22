<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Customer;

class AdminCustomerController extends Controller
{
    protected Customer $customerModel;

    public function __construct()
    {
        parent::__construct();
        $this->protectRoute([], ['admin1', 'admin2']);
        $this->customerModel = new Customer();
    }

    public function index(): string
    {
        $flash = $this->sessionManager->getFlash('customer_status');
        $customers = $this->customerModel->all();
        return $this->render('admin/customers/index', [
            'title' => 'Manajemen Pelanggan',
            'customers' => $customers,
            'message' => $flash['message'] ?? '',
            'message_type' => $flash['type'] ?? 'info'
        ], 'admin_layout');
    }

    public function create(Request $request, Response $response)
    {
        $data = [
            'first_name' => $request->body['first_name'],
            'last_name' => $request->body['last_name'],
            'phone_number' => $request->body['phone_number'],
            'email' => $request->body['email']
        ];
        
        if ($this->customerModel->create($data)) {
            $this->sessionManager->setFlash('customer_status', 'Pelanggan baru berhasil ditambahkan.', 'success');
        } else {
            $this->sessionManager->setFlash('customer_status', 'Gagal menambahkan pelanggan.', 'danger');
        }
        $response->redirect($this->request->baseUrl() . '/admin/customers');
    }

    public function update(Request $request, Response $response)
    {
        $id = (int)$request->body['customer_id'];
        $data = [
            'first_name' => $request->body['first_name'],
            'last_name' => $request->body['last_name'],
            'phone_number' => $request->body['phone_number'],
            'email' => $request->body['email']
        ];

        if ($this->customerModel->update($id, $data)) {
            $this->sessionManager->setFlash('customer_status', "Data pelanggan #{$id} berhasil diperbarui.", 'success');
        } else {
            $this->sessionManager->setFlash('customer_status', "Gagal memperbarui data pelanggan #{$id}.", 'danger');
        }
        $response->redirect($this->request->baseUrl() . '/admin/customers');
    }

    public function delete(Request $request, Response $response)
    {
        $id = (int)$request->body['customer_id'];
        
        // Panggil metode baru yang menghapus semua data terkait
        if ($this->customerModel->deleteCustomerAndRelations($id)) {
            $this->sessionManager->setFlash('customer_status', "Pelanggan #{$id} dan semua data terkaitnya berhasil dihapus.", 'success');
        } else {
            $this->sessionManager->setFlash('customer_status', "Gagal menghapus pelanggan #{$id}.", 'danger');
        }
        $response->redirect($this->request->baseUrl() . '/admin/customers');
    }
}