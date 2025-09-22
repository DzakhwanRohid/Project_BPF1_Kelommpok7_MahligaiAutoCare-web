<?php
// /app/Helpers/Uploader.php

namespace App\Helpers;

use Exception;

class Uploader
{
    private string $uploadDir;
    private array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    private int $maxSizeMb = 5; // Ukuran maksimum file dalam MB

    public function __construct(string $uploadDir)
    {
        // Pastikan direktori diakhiri dengan slash
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0775, true);
        }
    }

    public function setAllowedExtensions(array $extensions): void
    {
        $this->allowedExtensions = $extensions;
    }

    public function setMaxSize(int $megabytes): void
    {
        $this->maxSizeMb = $megabytes;
    }

    /**
     * Mengelola upload file.
     * @param array $fileData Data file dari $_FILES['nama_input']
     * @return string|null Nama file baru jika berhasil diupload, null jika tidak ada file.
     * @throws Exception jika terjadi error saat upload.
     */
    public function upload(array $fileData): ?string
    {
        // Cek jika tidak ada file atau ada error upload bawaan PHP
        if (!isset($fileData) || $fileData['error'] !== UPLOAD_ERR_OK) {
            // Jika tidak ada file yang diupload, kembalikan null (bukan error)
            if (isset($fileData) && $fileData['error'] === UPLOAD_ERR_NO_FILE) {
                return null;
            }
            // Jika ada error lain, lemparkan exception
            throw new Exception($this->getUploadErrorMessage($fileData['error'] ?? UPLOAD_ERR_NO_FILE));
        }

        // Validasi ukuran file
        $maxSizeBytes = $this->maxSizeMb * 1024 * 1024;
        if ($fileData['size'] > $maxSizeBytes) {
            throw new Exception("Ukuran file melebihi batas maksimum ({$this->maxSizeMb} MB).");
        }

        // Validasi ekstensi file
        $fileExtension = strtolower(pathinfo($fileData['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $this->allowedExtensions)) {
            throw new Exception("Format file tidak diizinkan. Hanya: " . implode(', ', $this->allowedExtensions));
        }

        // Buat nama file yang unik untuk mencegah penimpaan
        $newFilename = uniqid('proof_', true) . '.' . $fileExtension;
        $targetPath = $this->uploadDir . $newFilename;

        // Pindahkan file yang di-upload
        if (!move_uploaded_file($fileData['tmp_name'], $targetPath)) {
            throw new Exception("Gagal memindahkan file yang di-upload.");
        }

        return $newFilename;
    }

    private function getUploadErrorMessage(int $errorCode): string
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'File yang di-upload melebihi direktif upload_max_filesize di php.ini.';
            case UPLOAD_ERR_FORM_SIZE:
                return 'File yang di-upload melebihi direktif MAX_FILE_SIZE yang ditentukan dalam form HTML.';
            case UPLOAD_ERR_PARTIAL:
                return 'File hanya ter-upload sebagian.';
            case UPLOAD_ERR_NO_FILE:
                return 'Tidak ada file yang di-upload.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Folder sementara tidak ditemukan.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Gagal menulis file ke disk.';
            case UPLOAD_ERR_EXTENSION:
                return 'Ekstensi PHP menghentikan proses upload file.';
            default:
                return 'Terjadi error upload yang tidak diketahui.';
        }
    }
}