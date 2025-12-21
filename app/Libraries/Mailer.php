<?php

namespace App\Libraries;

use Config\Services;

class Mailer
{
    /**
     * Send an email using Zoho Mail REST API with OAuth 2.0 (no SMTP).
     *
     * This integrates the flow described in Zoho's OAuth 2.0 guide:
     * https://www.zoho.com/mail/help/api/using-oauth-2.html
     *
     * Expected .env keys:
     *   ZOHO_CLIENT_ID        = <Zoho OAuth client id>
     *   ZOHO_CLIENT_SECRET    = <Zoho OAuth client secret>
     *   ZOHO_REFRESH_TOKEN    = <long-lived refresh token>
     *   ZOHO_MAIL_ACCOUNT_ID  = <numeric Zoho Mail account id>
     *
     * Optional .env keys:
     *   ZOHO_ACCOUNTS_URL     = https://accounts.zoho.com
     *   ZOHO_MAIL_API_BASE    = https://mail.zoho.com
     *   EMAIL_FROM_ADDRESS    = you@yourdomain.com
     *   EMAIL_FROM_NAME       = "NCLEX Test Bank"
     */
    public static function send(string $to, string $subject, string $message, ?string $bcc = null, ?string $replyTo = null): bool
    {
        $accessToken = self::getAccessToken();
        if ($accessToken === null) {
            // Error already logged
            return false;
        }

        $accountId  = env('ZOHO_MAIL_ACCOUNT_ID');
        $apiBase    = rtrim(env('ZOHO_MAIL_API_BASE') ?? 'https://mail.zoho.com', '/');
        $from       = env('EMAIL_FROM_ADDRESS') ?: '';
        $fromName   = env('EMAIL_FROM_NAME') ?? 'NCLEX Test Bank';

        if (empty($accountId) || $from === '') {
            log_message('error', 'ZOHO_MAIL_ACCOUNT_ID or EMAIL_FROM_ADDRESS not configured for Mailer.');
            return false;
        }

        $endpoint = $apiBase . '/api/accounts/' . $accountId . '/messages';

        // Build payload per Zoho Mail API example:
        // https://www.zoho.com/mail/help/api/using-oauth-2.html
        // {
        //   "fromAddress": "your_email@yourdomain.com",
        //   "toAddress": "recipient@domain.com",
        //   "subject": "Test Email",
        //   "content": "Hello, this is a test email."
        // }
        $payload = [
            'fromAddress' => $from,
            'toAddress'   => $to,
            'subject'     => $subject,
            'content'     => $message,
        ];

        // Add BCC if configured (use parameter or fallback to .env)
        $globalBcc = env('EMAIL_BCC');
        $bccAddress = $bcc ?: $globalBcc;
        if (!empty($bccAddress)) {
            $payload['bccAddress'] = $bccAddress;
        }

        // Add Reply-To if configured (use parameter or fallback to .env)
        $replyAddress = $replyTo ?: env('EMAIL_REPLY_TO');
        if (!empty($replyAddress)) {
            $payload['replyTo'] = $replyAddress;
        }

        try {
            $client = Services::curlrequest();
            $response = $client->post($endpoint, [
                'headers' => [
                    'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ],
                'json'    => $payload,
                'timeout' => 10,
            ]);

            $status = $response->getStatusCode();
            if ($status >= 200 && $status < 300) {
                return true;
            }

            log_message('error', 'Zoho Mail API error: HTTP {code} - {body}', [
                'code' => $status,
                'body' => (string) $response->getBody(),
            ]);
            return false;
        } catch (\Throwable $e) {
            log_message('error', 'Zoho Mail send failed: {message}', ['message' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Get a short-lived access token using the refresh token flow.
     *
     * Docs: https://www.zoho.com/mail/help/api/using-oauth-2.html#alink6
     */
    private static function getAccessToken(): ?string
    {
        $clientId     = env('ZOHO_CLIENT_ID');
        $clientSecret = env('ZOHO_CLIENT_SECRET');
        $refreshToken = env('ZOHO_REFRESH_TOKEN');
        $accountsUrl  = rtrim(env('ZOHO_ACCOUNTS_URL') ?? 'https://accounts.zoho.com', '/');

        if (empty($clientId) || empty($clientSecret) || empty($refreshToken)) {
            log_message('error', 'Zoho OAuth env vars (ZOHO_CLIENT_ID / ZOHO_CLIENT_SECRET / ZOHO_REFRESH_TOKEN) are not fully configured.');
            return null;
        }

        try {
            $client = Services::curlrequest();
            $response = $client->post($accountsUrl . '/oauth/v2/token', [
                'form_params' => [
                    'refresh_token' => $refreshToken,
                    'grant_type'    => 'refresh_token',
                    'client_id'     => $clientId,
                    'client_secret' => $clientSecret,
                ],
                'timeout' => 10,
            ]);

            $status = $response->getStatusCode();
            if ($status < 200 || $status >= 300) {
                log_message('error', 'Zoho OAuth token refresh failed: HTTP {code} - {body}', [
                    'code' => $status,
                    'body' => (string) $response->getBody(),
                ]);
                return null;
            }

            $data = json_decode((string) $response->getBody(), true);
            if (!is_array($data) || empty($data['access_token'])) {
                log_message('error', 'Zoho OAuth token refresh returned invalid JSON: {body}', [
                    'body' => (string) $response->getBody(),
                ]);
                return null;
            }

            return (string) $data['access_token'];
        } catch (\Throwable $e) {
            log_message('error', 'Zoho OAuth token request failed: {message}', ['message' => $e->getMessage()]);
            return null;
        }
    }
}
