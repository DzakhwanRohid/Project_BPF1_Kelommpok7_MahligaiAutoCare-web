<?php
// app/Core/SessionManager.php
namespace App\Core;

/**
 * Kelas SessionManager mengelola sesi pengguna.
 * Ini menggantikan session_manager.php yang lama.
 */
class SessionManager
{
    /**
     * Memulai sesi PHP jika belum dimulai.
     */
    public function startSession(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Mengatur nilai sesi.
     *
     * @param string $key Kunci sesi.
     * @param mixed $value Nilai sesi.
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Mengambil nilai sesi.
     *
     * @param string $key Kunci sesi.
     * @param mixed $default Nilai default jika kunci tidak ditemukan.
     * @return mixed Nilai sesi atau nilai default.
     */
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Menghapus nilai sesi tertentu.
     *
     * @param string $key Kunci sesi yang akan dihapus.
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Memeriksa apakah pengguna sudah login.
     *
     * @return bool True jika pengguna sudah login, false jika tidak.
     */
    public function isLoggedIn(): bool
    {
        return $this->get('user_id') !== null;
    }

    /**
     * Mendapatkan peran pengguna yang sedang login.
     *
     * @return string Peran pengguna atau 'guest' jika tidak login.
     */
    public function getUserRole(): string
    {
        return $this->get('role', 'guest');
    }

    /**
     * Memeriksa akses admin berdasarkan peran yang dibutuhkan.
     *
     * @param string $requiredRole Peran admin yang dibutuhkan ('admin1' atau 'admin2').
     * @return bool True jika memiliki akses, false jika tidak.
     */
    public function isAdmin(string $requiredRole = 'admin1'): bool
    {
        $currentRole = $this->getUserRole();
        $adminRoles = Application::$app->getConfig('admin_roles');
        $superAdminRole = Application::$app->getConfig('super_admin_role');

        if (!$this->isLoggedIn()) {
            return false; // Tidak login, bukan admin
        }

        if ($requiredRole === $superAdminRole) {
            return $currentRole === $superAdminRole;
        } elseif (in_array($requiredRole, $adminRoles)) {
            // Untuk 'admin2' atau peran admin apa pun yang bukan super admin
            // periksa apakah peran saat ini adalah 'admin1' atau peran tertentu yang dibutuhkan
            return $currentRole === $superAdminRole || $currentRole === $requiredRole;
        }
        return false;
    }


    /**
     * Mengatur pesan flash (pesan yang hanya muncul sekali).
     *
     * @param string $key Kunci pesan flash.
     * @param string $message Pesan yang akan disimpan.
     * @param string $type Tipe pesan (success, danger, warning, info).
     */
    public function setFlash(string $key, string $message, string $type = 'info'): void
    {
        $this->set("flash_{$key}", ['message' => $message, 'type' => $type]);
    }

    /**
     * Mendapatkan pesan flash dan menghapusnya dari sesi.
     *
     * @param string $key Kunci pesan flash.
     * @return array|null Pesan flash dan tipenya, atau null jika tidak ada.
     */
    public function getFlash(string $key): ?array
    {
        $flashKey = "flash_{$key}";
        if ($this->get($flashKey)) {
            $flash = $this->get($flashKey);
            $this->remove($flashKey);
            return $flash;
        }
        return null;
    }

    /**
     * Melakukan logout pengguna.
     * Menghapus semua variabel sesi dan menghancurkan sesi.
     */
    public function logout(): void
    {
        session_unset();
        session_destroy();
    }
}
