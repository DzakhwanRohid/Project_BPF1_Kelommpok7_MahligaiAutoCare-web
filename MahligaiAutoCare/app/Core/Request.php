<?php
// app/Core/Request.php
namespace App\Core;

use App\Core\Application;

/**
 * Kelas Request mengelola semua data permintaan HTTP (GET, POST, URI, dll.).
 */
class Request
{
    public string $path;
    public string $method;
    public array $body;
    public array $files;

    /**
     * Konstruktor Request.
     * Menginisialisasi jalur, metode, dan isi permintaan.
     */
    public function __construct()
    {
        $this->path = $this->getPath();
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->body = $this->getBody(); // Call getBody here
        $this->files = $_FILES;
    }

    /**
     * Mengambil jalur URL saat ini.
     *
     * @return string Jalur URL.
     */
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        // Hapus BASE_URL dari path jika ada
        $baseUrl = Application::$app->getConfig('base_url');
        // Mendapatkan path relatif terhadap BASE_URL
        $parsedUrl = parse_url($baseUrl);
        $basePath = $parsedUrl['path'] ?? '';
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }

        $position = strpos($path, '?');
        if ($position === false) {
            return $path === '' ? '/' : $path; // Pastikan '/' jika path kosong
        }
        return substr($path, 0, $position);
    }

    /**
     * Mengambil metode HTTP (GET, POST, dll.).
     *
     * @return string Metode HTTP dalam huruf kecil.
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Mengambil isi permintaan (GET dan POST data).
     *
     * @return array Isi permintaan.
     */
    public function getBody(): array
    {
        $body = [];
        if ($this->method === 'get') {
            // Iterate directly over $_GET and sanitize appropriately
            foreach ($_GET as $key => $value) {
                if (is_array($value)) {
                    // For array inputs, apply filter to each element
                    $body[$key] = filter_var_array($value, FILTER_SANITIZE_SPECIAL_CHARS);
                } else {
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        if ($this->method === 'post') {
            // Iterate directly over $_POST and sanitize appropriately
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    // For array inputs, apply filter to each element
                    $body[$key] = filter_var_array($value, FILTER_SANITIZE_SPECIAL_CHARS);
                } else {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        return $body;
    }

    /**
     * Mengembalikan URL dasar aplikasi.
     *
     * @return string URL dasar aplikasi.
     */
    public function baseUrl(): string
    {
        return Application::$app->getConfig('base_url');
    }
     /**
     * Memeriksa apakah request adalah POST.
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method === 'post';
    }

    /**
     * Memeriksa apakah ada file yang diunggah dengan nama input tertentu.
     * @param string $key Nama input file (e.g., 'payment_proof').
     * @return bool
     */
    public function hasFile(string $key): bool
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] === UPLOAD_ERR_OK;
    }
    /**
     * Mengembalikan data file yang diunggah untuk nama input tertentu.
     * @param string $key Nama input file.
     * @return array|null Data file atau null jika tidak ada.
     */
    public function getFile(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }
    /**
 * Mengunggah file ke direktori tujuan yang ditentukan.
 *
 * @param string $fileInputName Nama input file dari form (e.g., 'payment_proof').
 * @param string $targetDirectory Direktori tujuan untuk menyimpan file.
 * @param string $prefix Nama awalan untuk file (opsional).
 * @return string|false Nama file yang disimpan (termasuk awalan) jika berhasil, false jika gagal.
 */
public function uploadFile(string $fileInputName, string $targetDirectory, string $prefix = ''): string|false
{
    if (!$this->hasFile($fileInputName)) {
        return false; // Tidak ada file atau ada error upload
    }

    $file = $this->getFile($fileInputName);
    $fileName = $prefix . uniqid() . '_' . basename($file['name']); // Nama unik untuk menghindari bentrok
    $targetFilePath = rtrim($targetDirectory, '/') . '/' . $fileName;

    // Pastikan direktori tujuan ada dan dapat ditulis
    if (!is_dir($targetDirectory)) {
        mkdir($targetDirectory, 0775, true); // Buat direktori jika belum ada
    }
    if (!is_writable($targetDirectory)) {
        error_log("Upload directory is not writable: " . $targetDirectory);
        return false; // Direktori tidak bisa ditulis
    }

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        return $fileName; // Mengembalikan nama file yang disimpan
    }

    error_log("Failed to move uploaded file from {$file['tmp_name']} to {$targetFilePath}. Error: " . $file['error']);
    return false; // Gagal memindahkan file
}
        /**
     * Memeriksa apakah request adalah GET.
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->method === 'get';
    }
    public function isAjax(): bool
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

    // Tambahkan metode lain yang mungkin Anda butuhkan, seperti has(), getParam(), dll.
}