<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Api extends Controller
{
    protected $helpers = ['url', 'form', 'json_output_helper'];

    public function __construct()
    {
        ini_set('memory_limit', '-1');
        ini_set('upload_max_filesize', '0M');
        ini_set('post_max_size', '0M');
    }

    public function get_categories_content($categoryId = null)
    {
        $categoryMap = [
            1  => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=6',  'title' => 'Getting Started'],
            2  => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=8',  'title' => 'Using the Education through Listening facilitation approach'],
            3  => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=10', 'title' => 'How to use this SGC tool'],
            4  => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=15', 'title' => 'Introduction to Motherhood'],
            5  => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=21', 'title' => 'Signs of Pregnancy'],
            6  => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=27', 'title' => 'Where and when to get ANC check up?'],
            7  => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=35', 'title' => 'Birth Plan'],
            8  => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=44', 'title' => 'Danger Signs'],
            9  => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=48', 'title' => 'Risks of not delivering in Hospital'],
            10 => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=51', 'title' => 'Breast Feeding'],
            11 => ['url' => 'http://safe.writers-corp.net/wp-json/wp/v2/posts/?include=55', 'title' => 'Care of Mother and Baby after Delivery'],
        ];

        if (!isset($categoryMap[$categoryId])) {
            return $this->failNotFound("Invalid category ID.");
        }

        $info = $categoryMap[$categoryId];
        $response = $this->fetchDataFromUrl($info['url']);

        if (!$response || !isset($response[0]['content']['rendered'])) {
            return $this->failServerError("Failed to retrieve content.");
        }

        $result = [
            ['title' => $info['title'], 'content' => $response[0]['content']['rendered']]
        ];

        $status = ["fetch_status" => "0"];

        json_output($result, $status, JSON_UNESCAPED_SLASHES);
    }

    private function fetchDataFromUrl(string $url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}
