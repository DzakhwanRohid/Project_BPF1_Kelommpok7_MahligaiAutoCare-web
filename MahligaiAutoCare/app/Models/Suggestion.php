<?php
// app/Models/Suggestion.php
namespace App\Models;

/**
 * Model untuk tabel 'suggestions_complaints'.
 * VERSI REFACTOR: Cukup extend BaseModel, tidak perlu metode tambahan.
 */
class Suggestion extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('suggestions_complaints');
        $this->setPrimaryKey('suggestion_id');
    }
}