<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\NoteModel;
use App\Models\StudySubcategoryModel;
use App\Models\StudyCategoryModel;
use App\Models\TestModel;

class Sitemap extends Controller
{
    public function index()
    {
        helper('url');

        $urls = [];
        $nowIso = date('c');

        // Core pages
        $urls[] = [ 'loc' => base_url('/'), 'lastmod' => $nowIso, 'changefreq' => 'daily', 'priority' => '1.0' ];
        $urls[] = [ 'loc' => base_url('how_it_works'), 'lastmod' => $nowIso, 'changefreq' => 'monthly', 'priority' => '0.7' ];
        $urls[] = [ 'loc' => base_url('pricing'), 'lastmod' => $nowIso, 'changefreq' => 'weekly', 'priority' => '0.7' ];
        $urls[] = [ 'loc' => base_url('reviews'), 'lastmod' => $nowIso, 'changefreq' => 'monthly', 'priority' => '0.6' ];
        $urls[] = [ 'loc' => base_url('notes'), 'lastmod' => $nowIso, 'changefreq' => 'daily', 'priority' => '0.8' ];
        $urls[] = [ 'loc' => base_url('client/tests'), 'lastmod' => $nowIso, 'changefreq' => 'daily', 'priority' => '0.9' ];
        $urls[] = [ 'loc' => base_url('client/study'), 'lastmod' => $nowIso, 'changefreq' => 'daily', 'priority' => '0.8' ];
        $urls[] = [ 'loc' => base_url('login/student'), 'lastmod' => $nowIso, 'changefreq' => 'yearly', 'priority' => '0.3' ];
        $urls[] = [ 'loc' => base_url('register'), 'lastmod' => $nowIso, 'changefreq' => 'yearly', 'priority' => '0.4' ];

        // Study notes (published)
        $noteModel = new NoteModel();
        $notes = $noteModel->where('status', 'published')->orderBy('updated_at', 'DESC')->findAll();
        foreach ($notes as $n) {
            $lastmod = !empty($n['updated_at']) ? date('c', strtotime($n['updated_at'])) : $nowIso;
            $urls[] = [
                'loc' => base_url('notes/' . (int)$n['id']),
                'lastmod' => $lastmod,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // Study questions listing per subcategory (client public path used earlier)
        $subModel = new StudySubcategoryModel();
        $subs = $subModel->orderBy('name')->findAll();
        foreach ($subs as $s) {
            $urls[] = [
                'loc' => base_url('client/study/subcategory/' . (int)$s['id'] . '/questions'),
                'lastmod' => $nowIso,
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        // Study categories list pages (to aid discovery)
        $catModel = new StudyCategoryModel();
        $cats = $catModel->orderBy('name')->findAll();
        foreach ($cats as $c) {
            $urls[] = [
                'loc' => base_url('client/study/' . (int)$c['id'] . '/subcategories'),
                'lastmod' => $nowIso,
                'changefreq' => 'weekly',
                'priority' => '0.5',
            ];
        }

        // Free tests (publicly accessible testbank entries)
        try {
            $testModel = new TestModel();
            $freeTests = $testModel->getActiveFreeTests();
            foreach ($freeTests as $t) {
                $urls[] = [
                    'loc' => base_url('free/test/' . (int)$t['id']),
                    'lastmod' => !empty($t['updated_at']) ? date('c', strtotime($t['updated_at'])) : $nowIso,
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
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
                    $urls[] = [
                        'loc' => $loc,
                        'lastmod' => !empty($p['post_date']) ? date('c', strtotime($p['post_date'])) : $nowIso,
                        'changefreq' => 'weekly',
                        'priority' => '0.7',
                    ];
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
}


