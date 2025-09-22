    <?php
    // autoload.php (Ditempatkan di folder root proyek, sejajar dengan folder 'app' dan 'public')

    /**
     * Autoloader Manual PSR-4
     * Secara otomatis memuat kelas berdasarkan namespace-nya.
     */
    spl_autoload_register(function ($class) {
        // Namespace prefix yang kita gunakan (misal: 'App\')
        $prefix = 'App\\';

        // Base directory untuk namespace prefix
        // Pastikan ini mengarah ke folder 'app' di mana kelas-kelas inti Anda berada
        $base_dir = __DIR__ . '/app/';

        // Apakah kelas yang diminta menggunakan prefix namespace kita?
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            // Jika tidak, biarkan autoloader lain menanganinya
            return;
        }

        // Dapatkan nama kelas relatif (tanpa prefix namespace)
        $relative_class = substr($class, $len);

        // Ubah namespace relatif ke path file
        // Ganti backslash dengan slash, tambahkan '.php'
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        // Jika file ada, muat
        if (file_exists($file)) {
            require_once $file;
        } else {
            // Opsional: untuk debugging, log atau tampilkan pesan jika file tidak ditemukan
            // echo "\n";
        }
    });

    