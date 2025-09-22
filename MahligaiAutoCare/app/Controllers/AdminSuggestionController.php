<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Suggestion;

class AdminSuggestionController extends Controller
{
    protected Suggestion $suggestionModel;

    public function __construct()
    {
        parent::__construct();
        $this->protectRoute([], ['admin1', 'admin2']);
        $this->suggestionModel = new Suggestion();
    }

    public function index(): string
    {
        $flash = $this->sessionManager->getFlash('suggestion_status');
        $suggestions = $this->suggestionModel->all();
        return $this->render('admin/suggestions/index', [
            'title' => 'Saran & Keluhan',
            'suggestions' => $suggestions,
            'message' => $flash['message'] ?? '',
            'message_type' => $flash['type'] ?? 'info'
        ], 'admin_layout');
    }

    public function delete(Request $request, Response $response)
    {
        $id = (int)$request->body['suggestion_id'];
        if ($this->suggestionModel->delete($id)) {
            $this->sessionManager->setFlash('suggestion_status', "Saran/keluhan #{$id} berhasil dihapus.", 'success');
        } else {
            $this->sessionManager->setFlash('suggestion_status', "Gagal menghapus saran/keluhan #{$id}.", 'danger');
        }
        $response->redirect($this->request->baseUrl() . '/admin/suggestions');
    }
}