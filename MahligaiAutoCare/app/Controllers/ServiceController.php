<?php
// app/Controllers/ServiceController.php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Service;

/**
 * ServiceController mengelola daftar layanan yang ditampilkan kepada publik.
 */
class ServiceController extends Controller
{
    protected Service $serviceModel;

    public function __construct()
    {
        parent::__construct();
        $this->serviceModel = new Service();
    }

    public function index(): string
    {
        $services = $this->serviceModel->all();
        $message = $this->sessionManager->getFlash('message')['message'] ?? '';
        $message_type = $this->sessionManager->getFlash('message')['type'] ?? '';

        return $this->render('services/index', [
            'services_list' => $services,
            'message' => $message,
            'message_type' => $message_type,
            'page_title' => 'Layanan Kami',
            'breadcrumb_items' => [
                ['label' => 'Beranda', 'url' => $this->request->baseUrl() . '/'],
                ['label' => 'Layanan', 'url' => $this->request->baseUrl() . '/services']
            ]
        ]);
    }
}
