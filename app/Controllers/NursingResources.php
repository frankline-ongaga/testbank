<?php

namespace App\Controllers;

class NursingResources extends BaseController
{
    private const RESOURCES = [
        'care-plans' => [
            'title' => 'Nursing Care Plans',
            'label' => 'Nursing Care Plans',
            'category_id' => 6,
            'path' => 'nursing-care-plans',
            'intro' => 'Browse care plan guides organized for NCLEX learners, with quick access to assessment cues, nursing priorities, interventions, and rationales.',
        ],
        'nclex-reviews' => [
            'title' => 'Nursing NCLEX Reviews',
            'label' => 'Nursing NCLEX Reviews',
            'category_id' => 5,
            'path' => 'nursing-nclex-reviews',
            'intro' => 'Review nursing topics pulled from the NCLEX review library, built for fast refreshers before practice and exam prep sessions.',
        ],
    ];

    public function carePlans()
    {
        return $this->listing('care-plans');
    }

    public function carePlanPost(string $identifier)
    {
        return $this->post('care-plans', $identifier);
    }

    public function nclexReviews()
    {
        return $this->listing('nclex-reviews');
    }

    public function nclexReviewPost(string $identifier)
    {
        return $this->post('nclex-reviews', $identifier);
    }

    private function listing(string $key)
    {
        if ($redirect = $this->requireProductAccess('nclex', self::RESOURCES[$key]['label'])) {
            return $redirect;
        }

        $resource = self::RESOURCES[$key];
        $posts = [];
        $loadError = null;

        try {
            $posts = $this->postsForCategory((int) $resource['category_id']);
        } catch (\Throwable $e) {
            log_message('error', 'Unable to load WordPress nursing resource posts: ' . $e->getMessage());
            $loadError = 'We could not load these resources right now. Please try again shortly.';
        }

        foreach ($posts as &$post) {
            $post['excerpt'] = $this->excerpt($post);
            $post['url'] = base_url('client/' . $resource['path'] . '/' . ($post['post_name'] ?: (int) $post['ID']));
        }
        unset($post);

        $data = [
            'title' => $resource['title'],
            'resource' => $resource,
            'posts' => $posts,
            'loadError' => $loadError,
        ];

        return view('client/layout/header', $data)
            . view('client/nursing_resources/index', $data)
            . view('client/layout/footer');
    }

    private function post(string $key, string $identifier)
    {
        if ($redirect = $this->requireProductAccess('nclex', self::RESOURCES[$key]['label'])) {
            return $redirect;
        }

        $resource = self::RESOURCES[$key];
        $post = $this->findPostInCategory((int) $resource['category_id'], $identifier);
        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Resource not found');
        }

        $post['content'] = $this->formatContent((string) ($post['post_content'] ?? ''));

        $data = [
            'title' => $post['post_title'] ?: $resource['title'],
            'resource' => $resource,
            'post' => $post,
        ];

        return view('client/layout/header', $data)
            . view('client/nursing_resources/show', $data)
            . view('client/layout/footer');
    }

    private function postsForCategory(int $categoryId): array
    {
        $db = \Config\Database::connect('blog');
        $prefix = env('database.blog.prefix') ?? 'wp_';

        return $db->table($prefix . 'posts p')
            ->distinct()
            ->select('p.ID, p.post_title, p.post_name, p.post_excerpt, p.post_content, p.post_date')
            ->join($prefix . 'term_relationships tr', 'tr.object_id = p.ID', 'inner')
            ->join($prefix . 'term_taxonomy tt', 'tt.term_taxonomy_id = tr.term_taxonomy_id', 'inner')
            ->where('p.post_status', 'publish')
            ->where('p.post_type', 'post')
            ->where('tt.taxonomy', 'category')
            ->groupStart()
                ->where('tt.term_id', $categoryId)
                ->orWhere('tt.term_taxonomy_id', $categoryId)
            ->groupEnd()
            ->orderBy('p.post_date', 'DESC')
            ->limit(120)
            ->get()
            ->getResultArray();
    }

    private function findPostInCategory(int $categoryId, string $identifier): ?array
    {
        $db = \Config\Database::connect('blog');
        $prefix = env('database.blog.prefix') ?? 'wp_';

        $builder = $db->table($prefix . 'posts p')
            ->distinct()
            ->select('p.ID, p.post_title, p.post_name, p.post_excerpt, p.post_content, p.post_date')
            ->join($prefix . 'term_relationships tr', 'tr.object_id = p.ID', 'inner')
            ->join($prefix . 'term_taxonomy tt', 'tt.term_taxonomy_id = tr.term_taxonomy_id', 'inner')
            ->where('p.post_status', 'publish')
            ->where('p.post_type', 'post')
            ->where('tt.taxonomy', 'category')
            ->groupStart()
                ->where('tt.term_id', $categoryId)
                ->orWhere('tt.term_taxonomy_id', $categoryId)
            ->groupEnd()
            ->groupStart()
                ->where('p.post_name', $identifier);

        if (ctype_digit($identifier)) {
            $builder->orWhere('p.ID', (int) $identifier);
        }

        return $builder->groupEnd()
            ->limit(1)
            ->get()
            ->getRowArray() ?: null;
    }

    private function excerpt(array $post): string
    {
        $text = trim((string) ($post['post_excerpt'] ?? ''));
        if ($text === '') {
            $text = (string) ($post['post_content'] ?? '');
        }

        $text = trim(strip_tags(html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
        $text = preg_replace('/\s+/', ' ', $text) ?? '';

        return mb_strlen($text) > 180 ? mb_substr($text, 0, 177) . '...' : $text;
    }

    private function formatContent(string $content): string
    {
        $content = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $content) ?? '';
        $content = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $content) ?? '';
        $content = trim($content);

        if ($content !== '' && !preg_match('/<(p|div|ul|ol|h[1-6]|blockquote|figure|table)\b/i', $content)) {
            $paragraphs = array_filter(array_map('trim', preg_split("/\R{2,}/", $content) ?: []));
            $content = implode('', array_map(static fn ($paragraph) => '<p>' . nl2br(esc($paragraph)) . '</p>', $paragraphs));
        }

        return $content;
    }
}
