<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteAttachmentModel extends Model
{
    protected $table = 'note_attachments';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'note_id',
        'filename',
        'original_name',
        'file_type',
        'file_size'
    ];

    protected $validationRules = [
        'note_id' => 'required|numeric',
        'filename' => 'required',
        'original_name' => 'required',
        'file_type' => 'required',
        'file_size' => 'required|numeric'
    ];

    public function getAttachmentsByNoteId($noteId)
    {
        return $this->where('note_id', $noteId)->findAll();
    }
}

