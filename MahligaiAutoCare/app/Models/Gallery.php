<?php
// app/Models/Gallery.php
namespace App\Models;

class Gallery extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->setTableName('gallery');
        $this->setPrimaryKey('gallery_id');
    }
}