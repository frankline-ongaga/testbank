<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\SubscriptionModel;
use App\Libraries\RoleSession;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;
    protected $roleSession;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Initialize session
        $this->session = session();

        $userId = (int) ($this->session->get('user_id') ?? 0);
        service('renderer')->setVar('clientHasNclexAccess', $userId > 0 && $this->hasActiveProductAccess($userId, 'nclex'));

        // Role-specific sessions are initialized in the AuthFilter to avoid double initialization
    }

    protected function productIdBySlug(string $slug): ?int
    {
        if (!$this->dbHasTable('products')) {
            return null;
        }

        $id = \Config\Database::connect()
            ->table('products')
            ->select('id')
            ->where('slug', $slug)
            ->get()
            ->getRow('id');

        return $id ? (int) $id : null;
    }

    protected function activeSubscriptionForProductSlug(int $userId, string $slug): ?array
    {
        $productId = $this->productIdBySlug($slug);
        if (!$productId) {
            return null;
        }

        return $this->activeSubscriptionForUser($userId, $productId);
    }

    protected function hasActiveProductAccess(int $userId, string $slug): bool
    {
        return (bool) $this->activeSubscriptionForProductSlug($userId, $slug);
    }

    protected function requireProductAccess(string $slug, string $label = 'this resource'): ?\CodeIgniter\HTTP\RedirectResponse
    {
        $userId = (int) (session()->get('user_id') ?? 0);
        if (!$userId) {
            $registerUrl = base_url('register') . '?product=' . rawurlencode($slug);
            return redirect()->to($registerUrl)
                ->with('error', 'Create a learner account to access ' . $label . '.');
        }

        if (!$this->hasActiveProductAccess($userId, $slug)) {
            $subscriptionUrl = base_url('client/subscription') . '?product=' . rawurlencode($slug);
            return redirect()->to($subscriptionUrl)
                ->with('error', 'Your subscription does not include ' . $label . '. Please activate the right access plan to continue.');
        }

        return null;
    }

    protected function activeSubscriptionForUser(int $userId, ?int $productId = null): ?array
    {
        $subs = new SubscriptionModel();
        $active = $subs->getActiveForUser($userId, $productId);
        if ($active) {
            return $active;
        }

        if (!filter_var((string) env('DEMO_ACCESS_ENABLED', 'false'), FILTER_VALIDATE_BOOL)) {
            return null;
        }

        if (defined('ENVIRONMENT') && ENVIRONMENT !== 'development') {
            return null;
        }

        $demoEmail = trim((string) env('DEMO_CLIENT_EMAIL', ''));
        if ($demoEmail === '') {
            return null;
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')
            ->select('email, first_name, username')
            ->where('id', $userId)
            ->get()
            ->getRowArray();

        if (!$user || strcasecmp((string) ($user['email'] ?? ''), $demoEmail) !== 0) {
            return null;
        }

        $nclexId = null;
        if ($this->dbHasTable('products')) {
            $nclexId = \Config\Database::connect()
                ->table('products')
                ->select('id')
                ->where('slug', 'nclex')
                ->get()
                ->getRow('id');
        }

        if ($productId !== null && $nclexId && (int) $productId !== (int) $nclexId) {
            return null;
        }

        $now = date('Y-m-d H:i:s');

        return [
            'id' => 0,
            'user_id' => $userId,
            'product_id' => $nclexId ? (int) $nclexId : $productId,
            'plan' => 'demo',
            'status' => 'active',
            'paypal_order_id' => 'DEMO-' . $userId,
            'amount' => 0,
            'currency' => 'USD',
            'start_at' => $now,
            'end_at' => date('Y-m-d H:i:s', strtotime('+90 days')),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    protected function activeProductIdsForUser(int $userId): array
    {
        $subs = new SubscriptionModel();
        $productIds = array_map('intval', array_column($subs->getActiveProductsForUser($userId), 'product_id'));

        $demoSubscription = $this->activeSubscriptionForUser($userId);
        if ($demoSubscription && !empty($demoSubscription['product_id'])) {
            $productIds[] = (int) $demoSubscription['product_id'];
        }

        return array_values(array_unique(array_filter($productIds)));
    }

    protected function dbHasTable(string $table): bool
    {
        try {
            return \Config\Database::connect()->tableExists($table);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
