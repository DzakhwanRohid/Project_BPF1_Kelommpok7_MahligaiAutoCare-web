<?php
// app/Controllers/AuthController.php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\User;
use App\Models\Customer;

/**
 * AuthController mengelola otentikasi pengguna, termasuk login, registrasi, dan logout.
 * VERSI REFACTOR: Disesuaikan untuk menggunakan metode model generik dan penanganan flash message yang benar.
 */
class AuthController extends Controller
{
    protected User $userModel;
    protected Customer $customerModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->customerModel = new Customer();
    }

    /**
     * Menampilkan formulir login.
     */
    public function login(): string
    {
        if ($this->sessionManager->isLoggedIn()) {
            $redirect_url = $this->sessionManager->isAdmin() ? '/admin/dashboard' : '/';
            $this->response->redirect($this->request->baseUrl() . $redirect_url);
        }
        
        // [PERBAIKAN] Mengambil flash message dengan cara yang benar
        $flash = $this->sessionManager->getFlash('error');
        $error_message = $flash['message'] ?? '';

        return $this->render('auth/login', [
            'error_message' => $error_message, 
            'title' => 'Login Pengguna'
        ], 'auth_layout');
    }

    /**
     * Memproses pengiriman formulir login.
     */
    public function handleLogin(Request $request, Response $response): void
    {
        $username = $request->body['username'] ?? '';
        $password = $request->body['password'] ?? '';

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Login berhasil
            $this->sessionManager->set('user_id', $user['user_id']);
            $this->sessionManager->set('username', $user['username']);
            $this->sessionManager->set('role', $user['role']);
            $this->sessionManager->set('customer_id', $user['customer_id']);

            $redirect_url = ($user['role'] === 'admin1' || $user['role'] === 'admin2') ? '/admin/dashboard' : '/';
            $response->redirect($request->baseUrl() . $redirect_url);
        } else {
            $this->sessionManager->setFlash('error', 'Username atau password salah.', 'danger');
            $response->redirect($request->baseUrl() . '/login');
        }
    }

    /**
     * Menampilkan formulir registrasi.
     */
    public function register(): string
    {
        // [PERBAIKAN] Mengambil flash message dengan cara yang benar
        $flash = $this->sessionManager->getFlash('register_status');
        $message = $flash['message'] ?? '';
        $message_type = $flash['type'] ?? '';

        return $this->render('auth/register', [
            'message' => $message, 
            'message_type' => $message_type, 
            'title' => 'Daftar Akun Baru'
        ], 'auth_layout');
    }

    /**
     * Memproses pengiriman formulir registrasi.
     */
    public function handleRegister(Request $request, Response $response): void
    {
        $firstName = $request->body['first_name'] ?? '';
        $lastName = $request->body['last_name'] ?? '';
        $phoneNumber = $request->body['phone_number'] ?? '';
        $email = $request->body['email'] ?? '';
        $username = $request->body['username'] ?? '';
        $password = $request->body['password'] ?? '';
        $confirmPassword = $request->body['confirm_password'] ?? '';

        if ($password !== $confirmPassword) {
            $this->sessionManager->setFlash('register_status', 'Password dan konfirmasi password tidak cocok.', 'danger');
            $response->redirect($request->baseUrl() . '/register');
            return;
        }

        $this->customerModel->beginTransaction();
        try {
            // Cek duplikasi customer
            $existingCustomer = $this->customerModel->findByPhoneOrEmail($phoneNumber, $email);
            if ($existingCustomer) {
                throw new \Exception("Nomor telepon atau email sudah terdaftar.");
            }
            
            // Cek duplikasi username
            $existingUser = $this->userModel->findByUsername($username);
            if ($existingUser) {
                throw new \Exception("Username sudah digunakan. Silakan pilih username lain.");
            }

            // [PERUBAHAN UTAMA] Gunakan metode create() generik dengan array data
            $customerData = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone_number' => $phoneNumber,
                'email' => $email
            ];
            $customerId = $this->customerModel->create($customerData);
            if (!$customerId) {
                throw new \Exception("Gagal mendaftarkan data pelanggan.");
            }

            // [PERUBAHAN UTAMA] Gunakan metode create() generik dengan array data
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $userData = [
                'username' => $username,
                'password_hash' => $passwordHash,
                'role' => 'user',
                'customer_id' => $customerId
            ];
            $userId = $this->userModel->create($userData);
            if (!$userId) {
                throw new \Exception("Gagal membuat akun pengguna.");
            }

            $this->customerModel->commit();
            $this->sessionManager->setFlash('error', 'Registrasi berhasil! Silakan login.', 'success');
            $response->redirect($request->baseUrl() . '/login');

        } catch (\Exception $e) {
            $this->customerModel->rollback();
            $this->sessionManager->setFlash('register_status', 'Registrasi gagal: ' . $e->getMessage(), 'danger');
            $response->redirect($request->baseUrl() . '/register');
        }
    }

    /**
     * Melakukan logout pengguna.
     */
    public function logout(Request $request, Response $response): void
    {
        $this->sessionManager->logout();
        $this->sessionManager->setFlash('error', 'Anda telah berhasil logout.', 'success');
        $response->redirect($request->baseUrl() . '/login');
    }
}