<?php

namespace App\Controllers;

use App\Models\TaxonomyModel;

class TaxonomyAdmin extends BaseController
{
    protected $taxonomy;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->taxonomy = new TaxonomyModel();
    }

    // List NCLEX question categories
    public function nclex()
    {
        $data = [
            'title' => 'Question Categories',
            'terms' => $this->taxonomy->where('type', 'nclex')->orderBy('name', 'ASC')->findAll(),
        ];

        return view('admin/layout/header', $data)
            . view('admin/taxonomy/nclex_index', $data)
            . view('admin/layout/footer');
    }

    public function storeNclex()
    {
        $name = trim((string) $this->request->getPost('name'));
        if ($name === '') {
            return redirect()->back()->with('error', 'Name is required');
        }
        $this->taxonomy->insert([
            'type' => 'nclex',
            'name' => $name,
            'parent_id' => null,
        ]);
        return redirect()->to('/admin/taxonomy/nclex')->with('message', 'Category added');
    }

    public function editNclex($id)
    {
        $term = $this->taxonomy->find((int)$id);
        if (!$term || $term['type'] !== 'nclex') {
            return redirect()->to('/admin/taxonomy/nclex')->with('error', 'Category not found');
        }
        $data = [
            'title' => 'Edit Question Category',
            'term' => $term,
            'terms' => $this->taxonomy->where('type', 'nclex')->orderBy('name', 'ASC')->findAll(),
        ];
        return view('admin/layout/header', $data)
            . view('admin/taxonomy/nclex_index', $data)
            . view('admin/layout/footer');
    }

    public function updateNclex($id)
    {
        $term = $this->taxonomy->find((int)$id);
        if (!$term || $term['type'] !== 'nclex') {
            return redirect()->to('/admin/taxonomy/nclex')->with('error', 'Category not found');
        }
        $name = trim((string) $this->request->getPost('name'));
        if ($name === '') {
            return redirect()->back()->with('error', 'Name is required');
        }
        $this->taxonomy->update((int)$id, [ 'name' => $name ]);
        return redirect()->to('/admin/taxonomy/nclex')->with('message', 'Category updated');
    }

    public function deleteNclex($id)
    {
        $term = $this->taxonomy->find((int)$id);
        if ($term && $term['type'] === 'nclex') {
            $this->taxonomy->delete((int)$id);
            return redirect()->to('/admin/taxonomy/nclex')->with('message', 'Category deleted');
        }
        return redirect()->to('/admin/taxonomy/nclex')->with('error', 'Category not found');
    }
}







