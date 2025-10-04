<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'author_id',
        'category_id',
        'subcategory_id',
        'title',
        'content',
        'status',
        'is_featured'
    ];

    protected $validationRules = [
        'title' => 'required|min_length[3]',
        'content' => 'required|min_length[10]',
        'category_id' => 'required|numeric',
        'status' => 'required|in_list[draft,published]'
    ];

    public function getNotesWithCategory($status = 'published', $subcategoryId = null)
    {
        $builder = $this->select('notes.*, note_categories.name as category_name, users.username as author_name')
                        ->join('note_categories', 'note_categories.id = notes.category_id')
                        ->join('users', 'users.id = notes.author_id')
                        ;

        if ($status !== null) {
            $builder->where('notes.status', $status);
        }

        if (!empty($subcategoryId)) {
            $builder->where('notes.subcategory_id', (int)$subcategoryId);
        }

        return $builder->orderBy('notes.is_featured', 'DESC')
                       ->orderBy('notes.created_at', 'DESC')
                       ->findAll();
    }

    public function getAuthorNotes($authorId, $subcategoryId = null)
    {
        $builder = $this->select('notes.*, note_categories.name as category_name')
                        ->join('note_categories', 'note_categories.id = notes.category_id')
                        ->where('notes.author_id', (int)$authorId);
        if (!empty($subcategoryId)) {
            $builder->where('notes.subcategory_id', (int)$subcategoryId);
        }
        return $builder->orderBy('notes.created_at', 'DESC')->findAll();
    }
}