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
        $categoryGroups = [];
        $loadError = null;

        try {
            $categoryContext = $this->categoryContext((int) $resource['category_id']);
            $posts = $this->postsForCategory($categoryContext);
        } catch (\Throwable $e) {
            log_message('error', 'Unable to load WordPress nursing resource posts: ' . $e->getMessage());
            $loadError = 'We could not load these resources right now. Please try again shortly.';
        }

        foreach ($posts as &$post) {
            $post['excerpt'] = $this->excerpt($post);
            $post['url'] = base_url('client/' . $resource['path'] . '/' . ($post['post_name'] ?: (int) $post['ID']));
        }
        unset($post);

        if (!empty($posts) && isset($categoryContext)) {
            $categoryGroups = $this->categoryGroups($categoryContext, $posts);
        }

        $data = [
            'title' => $resource['title'],
            'resource' => $resource,
            'posts' => $posts,
            'categoryGroups' => $categoryGroups,
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
        $post = $this->findPostInCategory($this->categoryContext((int) $resource['category_id']), $identifier);
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

    private function categoryContext(int $categoryId): array
    {
        $db = \Config\Database::connect('blog');
        $prefix = env('database.blog.prefix') ?? 'wp_';

        $rows = $db->table($prefix . 'term_taxonomy tt')
            ->select('tt.term_taxonomy_id, tt.term_id, tt.parent, t.name, t.slug')
            ->join($prefix . 'terms t', 't.term_id = tt.term_id', 'inner')
            ->where('tt.taxonomy', 'category')
            ->orderBy('t.name', 'ASC')
            ->get()
            ->getResultArray();

        $root = null;
        $termsById = [];
        $children = [];

        foreach ($rows as $row) {
            $termId = (int) $row['term_id'];
            $parentId = (int) $row['parent'];
            $row['term_id'] = $termId;
            $row['term_taxonomy_id'] = (int) $row['term_taxonomy_id'];
            $row['parent'] = $parentId;

            $termsById[$termId] = $row;
            $children[$parentId][] = $row;

            if ($termId === $categoryId || (int) $row['term_taxonomy_id'] === $categoryId) {
                $root = $row;
            }
        }

        if (!$root) {
            return [
                'root' => null,
                'termsById' => [],
                'children' => [],
                'termIds' => [$categoryId],
                'termTaxonomyIds' => [$categoryId],
                'depths' => [$categoryId => 0],
            ];
        }

        $termIds = [];
        $termTaxonomyIds = [];
        $depths = [];
        $walk = function (int $termId, int $depth) use (&$walk, &$termIds, &$termTaxonomyIds, &$depths, $children, $termsById): void {
            if (!isset($termsById[$termId]) || isset($depths[$termId])) {
                return;
            }

            $termIds[] = $termId;
            $termTaxonomyIds[] = (int) $termsById[$termId]['term_taxonomy_id'];
            $depths[$termId] = $depth;

            foreach ($children[$termId] ?? [] as $child) {
                $walk((int) $child['term_id'], $depth + 1);
            }
        };

        $walk((int) $root['term_id'], 0);

        return [
            'root' => $root,
            'termsById' => $termsById,
            'children' => $children,
            'termIds' => array_values(array_unique($termIds)),
            'termTaxonomyIds' => array_values(array_unique($termTaxonomyIds)),
            'depths' => $depths,
        ];
    }

    private function postsForCategory(array $categoryContext): array
    {
        $db = \Config\Database::connect('blog');
        $prefix = env('database.blog.prefix') ?? 'wp_';
        $termIds = $categoryContext['termIds'] ?? [];
        $termTaxonomyIds = $categoryContext['termTaxonomyIds'] ?? [];

        $builder = $db->table($prefix . 'posts p')
            ->select('p.ID, p.post_title, p.post_name, p.post_excerpt, p.post_content, p.post_date, t.term_id AS resource_term_id, t.name AS resource_category_name, t.slug AS resource_category_slug, tt.parent AS resource_category_parent')
            ->join($prefix . 'term_relationships tr', 'tr.object_id = p.ID', 'inner')
            ->join($prefix . 'term_taxonomy tt', 'tt.term_taxonomy_id = tr.term_taxonomy_id', 'inner')
            ->join($prefix . 'terms t', 't.term_id = tt.term_id', 'inner')
            ->where('p.post_status', 'publish')
            ->where('p.post_type', 'post')
            ->where('tt.taxonomy', 'category');

        $this->applyCategoryScope($builder, $termIds, $termTaxonomyIds);

        $rows = $builder
            ->orderBy('p.post_date', 'DESC')
            ->limit(500)
            ->get()
            ->getResultArray();

        $posts = [];
        foreach ($rows as $row) {
            $postId = (int) $row['ID'];
            if (!isset($posts[$postId])) {
                $posts[$postId] = [
                    'ID' => $postId,
                    'post_title' => $row['post_title'],
                    'post_name' => $row['post_name'],
                    'post_excerpt' => $row['post_excerpt'],
                    'post_content' => $row['post_content'],
                    'post_date' => $row['post_date'],
                    'categories' => [],
                ];
            }

            $termId = (int) ($row['resource_term_id'] ?? 0);
            if ($termId > 0) {
                $posts[$postId]['categories'][$termId] = [
                    'term_id' => $termId,
                    'name' => (string) ($row['resource_category_name'] ?? ''),
                    'slug' => (string) ($row['resource_category_slug'] ?? ''),
                    'parent' => (int) ($row['resource_category_parent'] ?? 0),
                ];
            }
        }

        foreach ($posts as &$post) {
            $post['categories'] = array_values($post['categories']);
            $post['assigned_term_id'] = $this->bestPostCategory($post['categories'], $categoryContext['depths'] ?? []);
        }
        unset($post);

        return array_values($posts);
    }

    private function applyCategoryScope($builder, array $termIds, array $termTaxonomyIds): void
    {
        $termIds = array_values(array_filter(array_map('intval', $termIds)));
        $termTaxonomyIds = array_values(array_filter(array_map('intval', $termTaxonomyIds)));

        $builder->groupStart();
        if (!empty($termIds)) {
            $builder->whereIn('tt.term_id', $termIds);
        }

        if (!empty($termTaxonomyIds)) {
            if (!empty($termIds)) {
                $builder->orWhereIn('tt.term_taxonomy_id', $termTaxonomyIds);
            } else {
                $builder->whereIn('tt.term_taxonomy_id', $termTaxonomyIds);
            }
        }
        $builder->groupEnd();
    }

    private function bestPostCategory(array $categories, array $depths): int
    {
        $bestTermId = 0;
        $bestDepth = -1;

        foreach ($categories as $category) {
            $termId = (int) ($category['term_id'] ?? 0);
            $depth = (int) ($depths[$termId] ?? 0);

            if ($termId > 0 && $depth >= $bestDepth) {
                $bestTermId = $termId;
                $bestDepth = $depth;
            }
        }

        return $bestTermId;
    }

    private function categoryGroups(array $categoryContext, array $posts): array
    {
        $root = $categoryContext['root'] ?? null;
        $children = $categoryContext['children'] ?? [];
        $postsByTerm = [];

        foreach ($posts as $post) {
            $termId = (int) ($post['assigned_term_id'] ?? 0);
            if ($termId > 0) {
                $postsByTerm[$termId][] = $post;
            }
        }

        if (!$root) {
            $groups = [];
            foreach ($postsByTerm as $termId => $termPosts) {
                $firstPost = $termPosts[0] ?? [];
                $firstCategory = $firstPost['categories'][0] ?? [];
                $groups[] = [
                    'term_id' => $termId,
                    'name' => $firstCategory['name'] ?? 'Resources',
                    'posts' => $termPosts,
                    'children' => [],
                    'total' => count($termPosts),
                ];
            }

            return $groups;
        }

        $buildNode = function (array $term) use (&$buildNode, $children, $postsByTerm): array {
            $termId = (int) $term['term_id'];
            $node = [
                'term_id' => $termId,
                'name' => (string) $term['name'],
                'slug' => (string) $term['slug'],
                'posts' => $postsByTerm[$termId] ?? [],
                'children' => [],
                'total' => count($postsByTerm[$termId] ?? []),
            ];

            foreach ($children[$termId] ?? [] as $child) {
                $childNode = $buildNode($child);
                if ($childNode['total'] > 0) {
                    $node['children'][] = $childNode;
                    $node['total'] += $childNode['total'];
                }
            }

            return $node;
        };

        $rootTermId = (int) $root['term_id'];
        $groups = [];

        if (!empty($postsByTerm[$rootTermId])) {
            $groups[] = [
                'term_id' => $rootTermId,
                'name' => 'General',
                'slug' => (string) ($root['slug'] ?? ''),
                'posts' => $postsByTerm[$rootTermId],
                'children' => [],
                'total' => count($postsByTerm[$rootTermId]),
            ];
        }

        foreach ($children[$rootTermId] ?? [] as $child) {
            $node = $buildNode($child);
            if ($node['total'] > 0) {
                $groups[] = $node;
            }
        }

        if (empty($groups)) {
            $rootNode = $buildNode($root);
            return $rootNode['total'] > 0 ? [$rootNode] : [];
        }

        return $groups;
    }

    private function findPostInCategory(array $categoryContext, string $identifier): ?array
    {
        $db = \Config\Database::connect('blog');
        $prefix = env('database.blog.prefix') ?? 'wp_';
        $termIds = $categoryContext['termIds'] ?? [];
        $termTaxonomyIds = $categoryContext['termTaxonomyIds'] ?? [];

        $builder = $db->table($prefix . 'posts p')
            ->distinct()
            ->select('p.ID, p.post_title, p.post_name, p.post_excerpt, p.post_content, p.post_date')
            ->join($prefix . 'term_relationships tr', 'tr.object_id = p.ID', 'inner')
            ->join($prefix . 'term_taxonomy tt', 'tt.term_taxonomy_id = tr.term_taxonomy_id', 'inner')
            ->where('p.post_status', 'publish')
            ->where('p.post_type', 'post')
            ->where('tt.taxonomy', 'category');

        $this->applyCategoryScope($builder, $termIds, $termTaxonomyIds);

        $builder->groupStart()
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
