<?php
// app/Controllers/HomeController.php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Suggestion;
use App\Models\Customer;
use App\Models\Service; 
use App\Models\Gallery;

/**
 * HomeController mengelola halaman publik seperti beranda, tentang, kontak, dll.
 * VERSI REFACTOR: Disesuaikan dengan model generik dan praktik MVC yang lebih baik.
 */
class HomeController extends Controller
{
    protected Suggestion $suggestionModel;
    protected Customer $customerModel;
    protected Service $serviceModel;
     protected Gallery $galleryModel;

    public function __construct()
    {
        parent::__construct();
        $this->suggestionModel = new Suggestion();
        $this->customerModel = new Customer();
        $this->serviceModel = new Service();
        $this->galleryModel = new Gallery();
    }

    public function index(): string
    {
        // BARU: Ambil data layanan untuk diteruskan ke homepage
        $services_list = $this->serviceModel->all();

        return $this->render('home/index', [
            'services_list' => $services_list // Teruskan daftar layanan ke view
            
        ]);
    }

    public function about(): string
    {
        return $this->render('home/about', [
            'page_title' => 'Tentang Kami',
            'breadcrumb_items' => [
                ['label' => 'Beranda', 'url' => $this->request->baseUrl() . '/'],
                ['label' => 'Tentang', 'url' => $this->request->baseUrl() . '/about']
            ]
        ]);
    }

    public function contact(): string
    {
        // [PERBAIKAN] Mengambil flash message dengan cara yang benar
        $flash = $this->sessionManager->getFlash('contact_message');
        $message = $flash['message'] ?? '';
        $message_type = $flash['type'] ?? '';

        $input_name = '';
        $input_email = '';
        
        // Coba isi otomatis jika user sudah login
        if ($this->sessionManager->isLoggedIn()) {
            $customerId = $this->sessionManager->get('customer_id');
            if ($customerId) {
                $customerData = $this->customerModel->find($customerId);
                // Menambahkan pengecekan is_array() untuk kekokohan ekstra (opsional)
                // Ini akan memastikan $customerData adalah array sebelum mengakses indeksnya
                if ($customerData && is_array($customerData)) { 
                    $input_name = htmlspecialchars($customerData['first_name'] . ' ' . $customerData['last_name']);
                    $input_email = htmlspecialchars($customerData['email']);
                }
            }
        }

        return $this->render('home/contact', [
            'message' => $message,
            'message_type' => $message_type,
            'input_name' => $input_name,
            'input_email' => $input_email,
            'page_title' => 'Hubungi Kami',
            'breadcrumb_items' => [
                ['label' => 'Beranda', 'url' => $this->request->baseUrl() . '/'],
                ['label' => 'Kontak', 'url' => '#']
            ]
        ]);
    }

    public function handleContact(Request $request, Response $response): void
    {
        if (!$this->sessionManager->isLoggedIn()) {
            // Mengubah flash key menjadi 'contact_message' agar konsisten dengan `contact()` method
            $this->sessionManager->setFlash('contact_message', 'Anda harus login untuk mengirim pesan.', 'danger'); 
            $response->redirect($this->request->baseUrl() . '/login');
            return;
        }

        $name = $request->body['name'] ?? '';
        $email = $request->body['email'] ?? '';
        $subject = $request->body['subject'] ?? '';
        $message_content = $request->body['message'] ?? '';
        $customerId = $this->sessionManager->get('customer_id');

        if (empty($name) || empty($email) || empty($subject) || empty($message_content)) {
            $this->sessionManager->setFlash('contact_message', 'Semua kolom wajib diisi.', 'danger');
            $response->redirect($request->baseUrl() . '/contact');
            return;
        }

        $suggestionData = [
            'customer_id' => $customerId,
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message_content,
            'created_at' => date('Y-m-d H:i:s') 
        ];
        
        $result = $this->suggestionModel->create($suggestionData);

        if ($result) {
            $this->sessionManager->setFlash('contact_message', 'Pesan Anda berhasil dikirim! Terima kasih atas masukan Anda.', 'success');
        } else {
            $this->sessionManager->setFlash('contact_message', 'Terjadi kesalahan, pesan gagal dikirim.', 'danger');
        }

        $response->redirect($request->baseUrl() . '/contact');
    }

    public function blog(): string
    {
        return $this->render('home/blog', [
            'page_title' => 'Blog Kami',
            'breadcrumb_items' => [
                ['label' => 'Beranda', 'url' => $this->request->baseUrl() . '/'],
                ['label' => 'Blog', 'url' => '#']
            ]
        ]);
    }

    public function feature(): string
    {
        return $this->render('home/feature', [
            'page_title' => 'Fitur Terbaik Kami',
            'breadcrumb_items' => [
                ['label' => 'Beranda', 'url' => $this->request->baseUrl() . '/'],
                ['label' => 'Fitur', 'url' => '#']
            ]
        ]);
    }

    public function team(): string
    {
        // Ambil semua data dari galeri
        $gallery_items = $this->galleryModel->all();

        return $this->render('home/team', [
            'page_title' => 'Galeri Kami',
            'breadcrumb_items' => [
                ['label' => 'Beranda', 'url' => $this->request->baseUrl() . '/'],
                ['label' => 'Galeri', 'url' => '#']
            ],
            'gallery_items' => $gallery_items // Kirim data galeri ke view
        ]);
    }

    public function testimonial(): string
    {
        return $this->render('home/testimonial', [
            'page_title' => 'Apa Kata Klien Kami',
            'breadcrumb_items' => [
                ['label' => 'Beranda', 'url' => $this->request->baseUrl() . '/'],
                ['label' => 'Testimonial', 'url' => '#']
            ]
        ]);
    }

    public function notFound(): string
    {
        $this->response->setStatusCode(404);
        return $this->render('home/404', [
            'page_title' => 'Halaman Tidak Ditemukan',
            'breadcrumb_items' => [
                ['label' => 'Beranda', 'url' => $this->request->baseUrl() . '/'],
                ['label' => '404 Error', 'url' => '#']
            ]
        ]);
    }
}