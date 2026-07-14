<?php

namespace App\Controllers;

use CodeIgniter\Controller;
class Sitemap extends Controller
{
    public function index()
    {
        helper('url');

        $urls = [];
        $seen = [];
        $nowIso = date('c');
        $addUrl = static function (array $url) use (&$urls, &$seen): void {
            if (empty($url['loc']) || isset($seen[$url['loc']])) {
                return;
            }

            $seen[$url['loc']] = true;
            $urls[] = $url;
        };

        // Core pages (public, non-auth, indexable)
        $addUrl([ 'loc' => base_url('/'), 'lastmod' => $nowIso, 'changefreq' => 'daily', 'priority' => '1.0' ]);
        $addUrl([ 'loc' => base_url('pricing'), 'lastmod' => $nowIso, 'changefreq' => 'weekly', 'priority' => '0.8' ]);
        $addUrl([ 'loc' => base_url('tutoring'), 'lastmod' => $nowIso, 'changefreq' => 'monthly', 'priority' => '0.7' ]);
        $addUrl([ 'loc' => base_url('ati-teas-7'), 'lastmod' => $nowIso, 'changefreq' => 'monthly', 'priority' => '0.8' ]);
        $addUrl([ 'loc' => base_url('hesi'), 'lastmod' => $nowIso, 'changefreq' => 'monthly', 'priority' => '0.8' ]);
        $addUrl([ 'loc' => base_url('login/student'), 'lastmod' => $nowIso, 'changefreq' => 'yearly', 'priority' => '0.3' ]);
        $addUrl([ 'loc' => base_url('register'), 'lastmod' => $nowIso, 'changefreq' => 'yearly', 'priority' => '0.5' ]);

        // Public test landing pages for all active products/tests.
        try {
            $db = \Config\Database::connect();
            $tests = $db->table('tests')
                ->select('id, title, updated_at')
                ->where('status', 'active')
                ->orderBy('id', 'DESC')
                ->get()
                ->getResultArray();

            foreach ($tests as $t) {
                $addUrl([
                    'loc' => base_url('practice-test/' . (int)$t['id'] . '/' . $this->slugify($t['title'] ?? 'practice-test')),
                    'lastmod' => !empty($t['updated_at']) ? date('c', strtotime($t['updated_at'])) : $nowIso,
                    'changefreq' => 'weekly',
                    'priority' => '0.75',
                ]);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Public question landing pages. To protect premium content, only index
        // questions that belong to at least one active free test.
        try {
            $db = \Config\Database::connect();
            $questions = $db->table('questions q')
                ->select('q.id, q.stem, q.updated_at')
                ->join('test_questions tq', 'tq.question_id = q.id', 'inner')
                ->join('tests t', 't.id = tq.test_id', 'inner')
                ->where('q.is_active', 1)
                ->where('t.status', 'active')
                ->where('t.is_free', 1)
                ->groupBy(['q.id', 'q.stem', 'q.updated_at'])
                ->orderBy('q.id', 'DESC')
                ->get()
                ->getResultArray();

            foreach ($questions as $q) {
                $addUrl([
                    'loc' => base_url('practice-question/' . (int)$q['id'] . '/' . $this->slugify($q['stem'] ?? 'practice-question')),
                    'lastmod' => !empty($q['updated_at']) ? date('c', strtotime($q['updated_at'])) : $nowIso,
                    'changefreq' => 'monthly',
                    'priority' => '0.65',
                ]);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Mock question pages are organized by study subcategory.
        try {
            $db = \Config\Database::connect();
            $mockQuestionPages = $db->table('mock_questions mq')
                ->select('mq.subcategory_id, MAX(COALESCE(mq.updated_at, mq.created_at)) AS lastmod')
                ->join('study_subcategories s', 's.id = mq.subcategory_id', 'inner')
                ->groupBy('mq.subcategory_id')
                ->orderBy('mq.subcategory_id', 'DESC')
                ->get()
                ->getResultArray();

            foreach ($mockQuestionPages as $page) {
                $addUrl([
                    'loc' => base_url('client/mock-questions/subcategory/' . (int)$page['subcategory_id'] . '/questions'),
                    'lastmod' => !empty($page['lastmod']) ? date('c', strtotime($page['lastmod'])) : $nowIso,
                    'changefreq' => 'monthly',
                    'priority' => '0.55',
                ]);
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Blog posts (from WordPress DB)
        try {
            $blogDB = \Config\Database::connect('blog');
            if ($blogDB) {
                $wpPrefix = env('database.blog.prefix') ?? 'wp_';
                $posts = $blogDB->table($wpPrefix . 'posts')
                    ->select('ID, post_name, post_date')
                    ->where('post_status', 'publish')
                    ->where('post_type', 'post')
                    ->orderBy('post_date', 'DESC')
                    ->limit(1000)
                    ->get()->getResultArray();
                foreach ($posts as $p) {
                    $slug = trim($p['post_name'] ?? '');
                    $loc = !empty($slug) ? base_url('blog/' . $slug) : base_url('blog/' . (int)$p['ID']);
                    $addUrl([
                        'loc' => $loc,
                        'lastmod' => !empty($p['post_date']) ? date('c', strtotime($p['post_date'])) : $nowIso,
                        'changefreq' => 'weekly',
                        'priority' => '0.7',
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // Skip blog on error
        }

        // Build XML
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');
        foreach ($urls as $u) {
            $url = $xml->addChild('url');
            $url->addChild('loc', htmlspecialchars($u['loc'], ENT_QUOTES | ENT_XML1, 'UTF-8'));
            if (!empty($u['lastmod'])) { $url->addChild('lastmod', $u['lastmod']); }
            if (!empty($u['changefreq'])) { $url->addChild('changefreq', $u['changefreq']); }
            if (!empty($u['priority'])) { $url->addChild('priority', $u['priority']); }
        }

        return $this->response
            ->setHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->setBody($xml->asXML());
    }

    private function slugify(string $value): string
    {
        $value = trim(strip_tags(html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
        $value = preg_replace('/\s+/', ' ', $value) ?? '';
        $value = preg_replace('/^[\s\.\-:;]+/', '', $value) ?? '';
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
        $value = trim($value, '-');
        $value = substr($value, 0, 90);

        return $value !== '' ? $value : 'item';
    }
}
