<?php
// app/Core/Router.php
namespace App\Core;

use App\Controllers\HomeController; // Diperlukan untuk notFound()

/**
 * Kelas Router menangani pendaftaran dan resolusi rute.
 */
class Router
{
    protected array $routes = [];
    protected Request $request;
    protected Response $response;

    /**
     * Konstruktor Router.
     *
     * @param Request $request Instance permintaan.
     * @param Response $response Instance respons.
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Mendaftarkan rute GET.
     *
     * @param string $path Jalur URL.
     * @param mixed $callback Fungsi atau array [Controller::class, 'method'].
     */
    public function get(string $path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * Mendaftarkan rute POST.
     *
     * @param string $path Jalur URL.
     * @param mixed $callback Fungsi atau array [Controller::class, 'method'].
     */
    public function post(string $path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Menyelesaikan rute dan menjalankan callback yang sesuai.
     *
     * @return mixed Hasil dari callback yang dijalankan.
     */
    public function resolve()
    {
        $path = $this->request->path;
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            // Halaman tidak ditemukan, tampilkan 404
            $this->response->setStatusCode(404);
            $controller = new HomeController(); // Gunakan HomeController untuk menampilkan 404
            return $controller->notFound();
        }

        // Jika callback adalah array [Controller::class, 'method']
        if (is_array($callback)) {
            $controllerClass = $callback[0];
            $methodName = $callback[1];

            // Instansiasi Controller
            /** @var \App\Core\Controller $controller */
            $controller = new $controllerClass();
            Application::$app->setController($controller); // Set controller di Application

            // Panggil metode pada instance controller, meneruskan request dan response
            return call_user_func([$controller, $methodName], $this->request, $this->response);
        }

        // Jika callback adalah fungsi anonim
        return call_user_func($callback, $this->request, $this->response);
    }
}