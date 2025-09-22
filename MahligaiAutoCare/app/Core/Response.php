<?php
// app/Core/Response.php
namespace App\Core;

/**
 * Kelas Response mengelola tanggapan HTTP.
 */
class Response
{
    /**
     * Mengatur kode status HTTP.
     *
     * @param int $code Kode status HTTP.
     */
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    /**
     * Mengalihkan pengguna ke URL tertentu.
     *
     * @param string $url URL tujuan.
     * @param int $statusCode Kode status HTTP (default 302 Found).
     */
    public function redirect(string $url, int $statusCode = 302): void
    {
        header("Location: {$url}", true, $statusCode);
        exit();
    }

    /**
     * Mengirimkan response JSON.
     *
     * @param array $data Data yang akan di-encode ke JSON.
     * @param int $statusCode Kode status HTTP.
     */
    public function json(array $data, int $statusCode = 200): void
    {
        $this->setStatusCode($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
