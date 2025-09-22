<?php
namespace App\Controllers;

// Pastikan kelas Application diimpor dari namespace yang benar.
use App\Core\Application;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Gallery;
use App\Helpers\Uploader;

class AdminGalleryController extends Controller
{
    protected Gallery $galleryModel;

    public function __construct()
    {
        parent::__construct();
        $this->protectRoute([], ['admin1', 'admin2']); 
        $this->galleryModel = new Gallery();
    }

    public function index(): string
    {
        $flash = $this->sessionManager->getFlash('gallery_status');
        $galleries = $this->galleryModel->all(); 
        
        return $this->render('admin/gallery/index', [
            'title' => 'Manajemen Galeri',
            'galleries' => $galleries,
            'message' => $flash['message'] ?? '',
            'message_type' => $flash['type'] ?? 'info'
        ], 'admin_layout');
    }

    public function create(Request $request, Response $response)
    {
        $caption = $request->body['caption'] ?? '';
        $photoFile = $request->files['gallery_image'] ?? null;

        if (!$photoFile || $photoFile['error'] !== UPLOAD_ERR_OK) {
            $this->sessionManager->setFlash('gallery_status', 'Gagal: Anda harus memilih file gambar untuk diunggah.', 'danger');
            Application::$app->response->redirect($this->request->baseUrl() . '/admin/gallery');
            return;
        }

        try {
            $uploadDir = dirname(__DIR__, 2) . '/public/uploads/gallery/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }

            $uploader = new Uploader($uploadDir);
            $newFilename = $uploader->upload($photoFile);

            if ($newFilename) {
                $relativePath = '/uploads/gallery/' . $newFilename;
                $this->galleryModel->create([
                    'image_path' => $relativePath,
                    'caption' => $caption
                ]);
                $this->sessionManager->setFlash('gallery_status', 'Gambar berhasil ditambahkan ke galeri.', 'success');
            } else {
                throw new \Exception("Gagal mengunggah file. Periksa izin folder.");
            }
        } catch (\Exception $e) {
            $this->sessionManager->setFlash('gallery_status', 'Terjadi kesalahan: ' . $e->getMessage(), 'danger');
        }

        Application::$app->response->redirect($this->request->baseUrl() . '/admin/gallery');
    }

    public function edit(Request $request): string
    {
        // Mengambil ID langsung dari $_GET untuk memastikan nilainya terbaca.
        $id = (int)($_GET['id'] ?? 0);
        
        if ($id === 0) {
            $this->sessionManager->setFlash('gallery_status', 'ID Galeri tidak valid.', 'danger');
            Application::$app->response->redirect($this->request->baseUrl() . '/admin/gallery');
            exit; // [PERBAIKAN] Hentikan eksekusi script setelah redirect.
        }

        $gallery_item = $this->galleryModel->find($id);

        if (!$gallery_item) {
            $this->sessionManager->setFlash('gallery_status', 'Item galeri tidak ditemukan.', 'danger');
            Application::$app->response->redirect($this->request->baseUrl() . '/admin/gallery');
            exit; // [PERBAIKAN] Hentikan eksekusi script setelah redirect.
        }

        // Jika semua valid, render halaman edit.
        return $this->render('admin/gallery/edit', [
            'title' => 'Edit Item Galeri',
            'item' => $gallery_item
        ], 'admin_layout');
    }

    public function update(Request $request, Response $response)
    {
        $id = (int)($request->body['gallery_id'] ?? 0);
        $caption = $request->body['caption'] ?? '';
        $old_image_path = $request->body['old_image_path'] ?? '';
        $photoFile = $request->files['gallery_image'] ?? null;

        $dataToUpdate = ['caption' => $caption];

        if ($photoFile && $photoFile['error'] === UPLOAD_ERR_OK) {
            try {
                $uploadDir = dirname(__DIR__, 2) . '/public/uploads/gallery/';
                $uploader = new Uploader($uploadDir);
                $newFilename = $uploader->upload($photoFile);

                if ($newFilename) {
                    $dataToUpdate['image_path'] = '/uploads/gallery/' . $newFilename;
                    if ($old_image_path && file_exists(dirname(__DIR__, 2) . '/public' . $old_image_path)) {
                        @unlink(dirname(__DIR__, 2) . '/public' . $old_image_path);
                    }
                } else {
                    throw new \Exception("Gagal mengunggah file baru.");
                }
            } catch (\Exception $e) {
                $this->sessionManager->setFlash('gallery_status', 'Gagal memproses gambar baru: ' . $e->getMessage(), 'danger');
                Application::$app->response->redirect($this->request->baseUrl() . '/admin/gallery');
                return;
            }
        }
        
        if ($this->galleryModel->update($id, $dataToUpdate)) {
            $this->sessionManager->setFlash('gallery_status', 'Item galeri berhasil diperbarui.', 'success');
        } else {
            $this->sessionManager->setFlash('gallery_status', 'Gagal memperbarui item galeri atau tidak ada perubahan.', 'warning');
        }

        Application::$app->response->redirect($this->request->baseUrl() . '/admin/gallery');
    }

    public function delete(Request $request, Response $response)
    {
        $id = (int)($request->body['gallery_id'] ?? 0);
        $gallery_item = $this->galleryModel->find($id);
        
        if ($gallery_item) {
            $imagePathToDelete = null;

            if (is_object($gallery_item) && isset($gallery_item->image_path)) {
                $imagePathToDelete = $gallery_item->image_path;
            } elseif (is_array($gallery_item) && isset($gallery_item['image_path'])) {
                $imagePathToDelete = $gallery_item['image_path'];
            }

            if ($imagePathToDelete) {
                if ($this->galleryModel->delete($id)) {
                    $filePath = dirname(__DIR__, 2) . '/public' . $imagePathToDelete;
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                    $this->sessionManager->setFlash('gallery_status', 'Gambar berhasil dihapus dari galeri.', 'success');
                } else {
                    $this->sessionManager->setFlash('gallery_status', 'Gagal menghapus data gambar dari database.', 'danger');
                }
            } else {
                $this->sessionManager->setFlash('gallery_status', 'Error: Item ditemukan tapi path gambar tidak bisa dibaca.', 'danger');
            }
        } else {
            $this->sessionManager->setFlash('gallery_status', 'Gagal menghapus: Gambar tidak ditemukan di database.', 'danger');
        }
        
        Application::$app->response->redirect($this->request->baseUrl() . '/admin/gallery');
    }
}
