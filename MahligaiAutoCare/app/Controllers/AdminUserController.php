<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\User;
use App\Models\Customer;

class AdminUserController extends Controller
{
    protected User $userModel;
    protected Customer $customerModel;

    public function __construct()
    {
        parent::__construct();
        $this->protectRoute([], ['admin1']); // Hanya super admin
        $this->userModel = new User();
        $this->customerModel = new Customer();
    }

    public function index(): string
    {
        $flash = $this->sessionManager->getFlash('user_status');
        $users = $this->userModel->all();
        $customers = $this->customerModel->all();
        return $this->render('admin/users/index', [
            'title' => 'Manajemen Pengguna',
            'users' => $users,
            'customers' => $customers,
            'message' => $flash['message'] ?? '',
            'message_type' => $flash['type'] ?? 'info'
        ], 'admin_layout');
    }

    public function create(Request $request, Response $response)
    {
        if (empty($request->body['password'])) {
            $this->sessionManager->setFlash('user_status', 'Password wajib diisi untuk pengguna baru.', 'danger');
            $response->redirect($this->request->baseUrl() . '/admin/users');
            return;
        }

        $data = [
            'username' => $request->body['username'],
            'password_hash' => password_hash($request->body['password'], PASSWORD_DEFAULT),
            'role' => $request->body['role'],
            'customer_id' => ($request->body['customer_id'] == '0') ? null : (int)$request->body['customer_id']
        ];
        
        if ($this->userModel->create($data)) {
            $this->sessionManager->setFlash('user_status', 'Pengguna baru berhasil ditambahkan.', 'success');
        } else {
            $this->sessionManager->setFlash('user_status', 'Gagal menambahkan pengguna.', 'danger');
        }
        $response->redirect($this->request->baseUrl() . '/admin/users');
    }
    
    public function update(Request $request, Response $response)
    {
        $id = (int)$request->body['user_id'];
        $data = [
            'username' => $request->body['username'],
            'role' => $request->body['role'],
            'customer_id' => ($request->body['customer_id'] == '0') ? null : (int)$request->body['customer_id']
        ];

        // Update password hanya jika diisi
        if (!empty($request->body['password'])) {
            $data['password_hash'] = password_hash($request->body['password'], PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $data)) {
            $this->sessionManager->setFlash('user_status', "Pengguna #{$id} berhasil diperbarui.", 'success');
        } else {
            $this->sessionManager->setFlash('user_status', "Gagal memperbarui pengguna #{$id}.", 'danger');
        }
        $response->redirect($this->request->baseUrl() . '/admin/users');
    }

    public function delete(Request $request, Response $response)
    {
        $id = (int)$request->body['user_id'];

        if ($id == $this->sessionManager->get('user_id')) {
            $this->sessionManager->setFlash('user_status', 'Anda tidak dapat menghapus akun Anda sendiri.', 'danger');
        } else {
            if ($this->userModel->delete($id)) {
                $this->sessionManager->setFlash('user_status', "Pengguna #{$id} berhasil dihapus.", 'success');
            } else {
                $this->sessionManager->setFlash('user_status', "Gagal menghapus pengguna #{$id}.", 'danger');
            }
        }
        $response->redirect($this->request->baseUrl() . '/admin/users');
    }
}