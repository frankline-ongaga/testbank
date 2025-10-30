<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Blog extends Controller
{
    public function show(string $identifier)
    {
        $db = \Config\Database::connect('blog');
        if (! $db) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Blog database not configured');
        }

        $wpPrefix = env('database.blog.prefix') ?? 'wp_';

        // Try by slug first
        $builder = $db->table($wpPrefix . 'posts')
            ->select('ID, post_title, post_name, post_content, post_excerpt, post_date')
            ->where('post_status', 'publish')
            ->where('post_type', 'post')
            ->where('post_name', $identifier)
            ->limit(1);
        $post = $builder->get()->getRowArray();

        // Fallback by ID if not found and identifier is numeric
        if (empty($post) && ctype_digit($identifier)) {
            $post = $db->table($wpPrefix . 'posts')
                ->select('ID, post_title, post_name, post_content, post_excerpt, post_date')
                ->where('post_status', 'publish')
                ->where('post_type', 'post')
                ->where('ID', (int) $identifier)
                ->limit(1)
                ->get()->getRowArray();
        }

        if (empty($post)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Blog post not found');
        }

        // Build meta description from excerpt or content fallback
        $rawExcerpt = trim((string)($post['post_excerpt'] ?? ''));
        if ($rawExcerpt === '') {
            $rawExcerpt = strip_tags((string)($post['post_content'] ?? ''));
        }
        // Normalize whitespace and clip length
        $rawExcerpt = preg_replace('/\s+/', ' ', $rawExcerpt);
        $description = trim(mb_substr($rawExcerpt, 0, 160));

        $data = [
            'title'      => $post['post_title'] ?? 'Blog',
            'post'       => $post,
            'description'=> $description,
        ];

        return view('homepage/header', $data)
            . view('homepage/blog_post', $data)
            . view('homepage/footer');
    }
}


