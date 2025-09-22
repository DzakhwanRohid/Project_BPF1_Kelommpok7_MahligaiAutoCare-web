<?php
// app/Core/Controller.php
namespace App\Core;

/**
 * Kelas dasar untuk semua Controller.
 * Menyediakan fungsionalitas umum seperti rendering view.
 */
abstract class Controller
{
    protected Request $request;
    protected Response $response;
    protected SessionManager $sessionManager;

    public function __construct()
    {
        $this->request = Application::$app->getRequest();
        $this->response = Application::$app->getResponse();
        $this->sessionManager = Application::$app->getSessionManager();
    }

    /**
     * Merender view dengan data yang diberikan dan layout.
     *
     * @param string $view Nama view (misal: 'home/index'). Ini adalah nama view RELATIF terhadap app/Views/.
     * @param array $params Data yang akan diteruskan ke view dan layout.
     * @param string $layout Nama layout yang akan digunakan (misal: 'main_layout', 'auth_layout', 'admin_layout').
     * @return string Konten HTML yang dirender.
     */
    public function render(string $view, array $params = [], string $layout = 'main_layout'): string
    {
        $params['base_url'] = Application::$app->getConfig('base_url');

        // Render view content into a variable first
        $viewFullPath = Application::$ROOT_DIR . "/app/Views/$view.php";
        if (!file_exists($viewFullPath)) {
            error_log("ERROR: View file not found: " . $viewFullPath);
            return "<!-- Error: View file not found: " . htmlspecialchars($viewFullPath) . " -->";
        }

        ob_start();
        $params['currentPath'] = $this->request->getPath(); 
        extract($params);
        include_once $viewFullPath;
        $content = ob_get_clean(); // Capture view content into $content variable

        // Now render the layout, which will have $content available
        $layoutFullPath = Application::$ROOT_DIR . "/app/Views/layouts/{$layout}.php";
        if (!file_exists($layoutFullPath)) {
            error_log("ERROR: Layout file not found: " . $layoutFullPath);
            return "<!-- Error: Layout file not found: " . htmlspecialchars($layoutFullPath) . " -->";
        }

        ob_start();
        // Extract parameters again for the layout, ensuring $base_url, etc. are available
        // Note: $content is already defined in this scope.
        extract($params); 
        include_once $layoutFullPath;
        return ob_get_clean();
    }
    
    /**
     * Mengalihkan pengguna ke URL tertentu.
     * @param string $url URL tujuan.
     * @param int $statusCode Kode status HTTP.
     */
    public function redirect(string $url, int $statusCode = 302): void
    {
        $this->response->redirect($url, $statusCode);
    }

    /**
     * Menampilkan modal akses ditolak dan mengalihkan jika diperlukan.
     */
    protected function showAccessDeniedAndRedirect()
    {
        // Mengatur pesan flash
        $this->sessionManager->setFlash('error', 'Akses Ditolak! Anda tidak memiliki izin untuk mengakses halaman ini.');
        
        // Mengalihkan ke halaman login atau dashboard admin (tergantung konteks)
        // Untuk admin, kita bisa mengalihkan ke login dan biarkan pesan flash ditampilkan di sana.
        $this->response->redirect($this->request->baseUrl() . '/login');
        exit();
    }

 /**
     * [BARU] Metode terpusat untuk melindungi rute berdasarkan status login dan peran.
     * @param array $methods Nama metode di controller ini yang perlu proteksi. Kosongkan untuk melindungi semua.
     * @param array|null $roles Peran yang diizinkan. Null berarti hanya perlu login. ['guest'] berarti hanya untuk tamu.
     */
    protected function protectRoute(array $methods = [], ?array $roles = null): void
    {
        // Jika roles adalah ['guest'], hanya izinkan jika belum login
        if (is_array($roles) && in_array('guest', $roles)) {
            if ($this->sessionManager->isLoggedIn()) {
                $this->response->redirect($this->request->baseUrl() . '/');
            }
            return;
        }

        // Jika roles bukan guest, berarti harus login
        if (!$this->sessionManager->isLoggedIn()) {
            $this->sessionManager->setFlash('error', 'Anda harus login untuk mengakses halaman ini.', 'danger');
            $this->response->redirect($this->request->baseUrl() . '/login');
            return;
        }
        
        // Jika roles diset (misal: ['admin1', 'admin2']), periksa perannya
        if (is_array($roles)) {
            $userRole = $this->sessionManager->getUserRole();
            $isAllowed = false;
            foreach ($roles as $role) {
                if ($userRole === $role) {
                    $isAllowed = true;
                    break;
                }
            }
            // Super admin (admin1) selalu diizinkan jika peran admin diperlukan
            if (!$isAllowed && in_array('admin1', $roles) && $userRole === 'admin1') {
                $isAllowed = true;
            }
            if (!$isAllowed && in_array('admin2', $roles) && $userRole === 'admin1') { // Super admin bisa akses halaman admin2
                $isAllowed = true;
            }

            if (!$isAllowed) {
                $this->sessionManager->setFlash('error', 'Akses ditolak! Anda tidak punya izin.', 'danger');
                $this->response->redirect($this->request->baseUrl() . '/'); // Arahkan ke beranda
            }
        }
    }
}