<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class ZohoOauth extends BaseController
{
    /**
     * Optional: initialize services
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['url']);
    }

    /**
     * OAuth callback to exchange authorization code for tokens.
     *
     * This replicates the cURL command:
     * curl "https://accounts.zoho.com/oauth/v2/token" \
     *   -d "grant_type=authorization_code" \
     *   -d "client_id=YOUR_CLIENT_ID" \
     *   -d "client_secret=YOUR_CLIENT_SECRET" \
     *   -d "redirect_uri=YOUR_REDIRECT_URI" \
     *   -d "code=YOUR_GRANT_TOKEN"
     *
     * Usage:
     * 1. Configure your Zoho client to use redirect URI:
     *    https://nclexprepcourse.org/zoho/oauth/callback
     * 2. Authorize the app in Zoho; Zoho will redirect back here with ?code=...
     * 3. This method will call Zoho's /oauth/v2/token endpoint and display the response,
     *    including the refresh_token (copy it into your .env).
     */
    public function callback()
    {
        $code = $this->request->getGet('code');
        $error = $this->request->getGet('error');

        if (!empty($error)) {
            return $this->response
                ->setStatusCode(400)
                ->setBody('Zoho returned an error: ' . esc($error));
        }

        if (empty($code)) {
            return $this->response
                ->setStatusCode(400)
                ->setBody('Missing "code" query parameter from Zoho.');
        }

        $clientId = env('ZOHO_CLIENT_ID');
        $clientSecret = env('ZOHO_CLIENT_SECRET');
        $accountsUrl = env('ZOHO_ACCOUNTS_URL') ?? 'https://accounts.zoho.com';

        if (empty($clientId) || empty($clientSecret)) {
            return $this->response
                ->setStatusCode(500)
                ->setBody('ZOHO_CLIENT_ID or ZOHO_CLIENT_SECRET is not configured in .env');
        }

        $redirectUri = base_url('zoho/oauth/callback');

        $client = \Config\Services::curlrequest();

        try {
            $tokenResponse = $client->post(rtrim($accountsUrl, '/') . '/oauth/v2/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'redirect_uri' => $redirectUri,
                    'code' => $code,
                ],
                'timeout' => 15,
            ]);

            $body = (string) $tokenResponse->getBody();
            $data = json_decode($body, true) ?: [];

            // Log raw response for debugging (server logs only)
            log_message('info', 'Zoho OAuth token exchange response: {body}', ['body' => $body]);

            $html  = "<!DOCTYPE html><html><head><meta charset=\"utf-8\">";
            $html .= "<title>Zoho OAuth Tokens</title>";
            $html .= "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f7f7f7;color:#333}pre{background:#fff;border:1px solid #ddd;padding:15px;border-radius:4px;overflow:auto}</style>";
            $html .= "</head><body>";
            $html .= "<h2>Zoho OAuth Token Response</h2>";

            if (isset($data['error'])) {
                $html .= "<p style='color:red;'><strong>Error:</strong> " . htmlspecialchars($data['error'], ENT_QUOTES, 'UTF-8') . "</p>";
                if (isset($data['error_description'])) {
                    $html .= "<p>" . nl2br(htmlspecialchars($data['error_description'], ENT_QUOTES, 'UTF-8')) . "</p>";
                }
            } else {
                if (isset($data['refresh_token'])) {
                    $html .= "<p><strong>Refresh Token (copy this into ZOHO_REFRESH_TOKEN in your .env):</strong></p>";
                    $html .= "<pre>" . htmlspecialchars($data['refresh_token'], ENT_QUOTES, 'UTF-8') . "</pre>";
                } else {
                    $html .= "<p style='color:orange;'><strong>Warning:</strong> No refresh_token was returned. Make sure you requested offline access (access_type=offline) in your Zoho authorization URL.</p>";
                }

                $html .= "<h3>Full JSON Response</h3>";
                $html .= "<pre>" . htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT), ENT_QUOTES, 'UTF-8') . "</pre>";
            }

            $html .= "</body></html>";

            return $this->response->setStatusCode(200)->setBody($html);
        } catch (\Throwable $e) {
            log_message('error', 'Zoho OAuth token exchange failed: ' . $e->getMessage());

            return $this->response
                ->setStatusCode(500)
                ->setBody('Zoho OAuth token exchange failed: ' . $e->getMessage());
        }
    }
}


