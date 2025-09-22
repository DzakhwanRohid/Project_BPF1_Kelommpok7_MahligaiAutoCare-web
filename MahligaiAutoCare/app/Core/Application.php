<?php
// app/Core/Application.php
namespace App\Core;

/**
 * Kelas Application adalah titik masuk utama untuk aplikasi MVC.
 * Bertanggung jawab untuk inisialisasi Router, Database, dan menjalankan aplikasi.
 */
class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $database;
    public SessionManager $sessionManager;
    public ?Controller $controller = null; // Menambahkan properti untuk menyimpan instance controller
    public static string $ROOT_DIR;
    public static Application $app;
    public array $config;

    /**
     * Konstruktor Application.
     * Menginisialisasi komponen inti dan memuat konfigurasi.
     *
     * @param string $rootPath Jalur root aplikasi.
     * @param array  $config   Array konfigurasi dari config/app.php.
     */
    public function __construct(string $rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this; // Set instance aplikasi ke properti statis untuk akses global
        $this->config = $config;

        $this->request = new Request();
        $this->response = new Response();
        $this->sessionManager = new SessionManager(); // Inisialisasi SessionManager
        $this->database = new Database($config['database']); // Inisialisasi Database dengan konfigurasi
        $this->router = new Router($this->request, $this->response);

        // Memulai sesi di awal aplikasi
        $this->sessionManager->startSession();
        require_once self::$ROOT_DIR . '/app/Helpers/ViewHelpers.php';
    }

    /**
     * Mengembalikan instance Request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Mengembalikan instance Response.
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * Mengembalikan instance Database.
     *
     * @return Database
     */
    public function getDatabase(): Database
    {
        return $this->database;
    }

    /**
     * Mengembalikan instance SessionManager.
     *
     * @return SessionManager
     */
    public function getSessionManager(): SessionManager
    {
        return $this->sessionManager;
    }

    /**
     * Mengembalikan nilai konfigurasi.
     *
     * @param string $key Kunci konfigurasi yang dicari.
     * @return mixed Nilai konfigurasi atau null jika tidak ditemukan.
     */
    public function getConfig(string $key)
    {
        return $this->config[$key] ?? null;
    }

    /**
     * Mengatur controller yang sedang aktif.
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * Mengembalikan controller yang sedang aktif.
     * @return Controller|null
     */
    public function getController(): ?Controller
    {
        return $this->controller;
    }

    /**
     * Menjalankan aplikasi.
     * Meneruskan permintaan ke router untuk diselesaikan.
     */
    public function run()
    {
        echo $this->router->resolve();
    }
 // --- METODE BARU ---
    /**
     * Mengembalikan root directory aplikasi.
     * @return string
     */
    public function getRootDir(): string
    {
        return self::$ROOT_DIR;
    }
    
}