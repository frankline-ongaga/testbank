<?php

namespace App\Controllers;

use App\Models\SubscriptionModel;
use App\Models\PaymentModel;
use App\Models\ExamProductModel;
use App\Libraries\Mailer;

class Subscriptions extends BaseController
{
    protected $subs;
    protected $payments;
    protected $products;
    protected $session;

    public function __construct()
    {
        $this->subs = new SubscriptionModel();
        $this->payments = new PaymentModel();
        $this->products = new ExamProductModel();
        $this->session = session();
    }

    public function index()
    {
        $data['title'] = 'Access Plans';

        // Admin view: show access passes overview and payments
        $roles = $this->session->get('roles');
        if ($roles && in_array('admin', $roles)) {
            $data['active_count'] = $this->subs->where('status', 'active')->countAllResults();
            $data['expired_count'] = $this->subs->where('status', 'expired')->countAllResults();
            $data['total_revenue'] = $this->payments->selectSum('amount')->get()->getRow()->amount ?? 0;
            $data['recent_payments'] = $this->payments->orderBy('id', 'DESC')->findAll(10);
            $data['recent_subscriptions'] = $this->subs->orderBy('id', 'DESC')->findAll(10);
            // Use admin layout
            return view('admin/layout/header', $data)
                . view('admin/subscriptions', $data)
                . view('admin/layout/footer');
        }

        // Client portal specific view
        $currentPortal = $this->session->get('current_role');
        $userId = (int) ($this->session->get('user_id') ?? 0);
        $data['products'] = $this->products->getActiveProducts();
        $currentSubscription = $userId ? $this->activeSubscriptionForUser($userId) : null;
        $currentSubscriptions = $userId ? $this->subs->getActiveProductsForUser($userId) : [];
        if (empty($currentSubscriptions) && $currentSubscription && !empty($currentSubscription['product_id'])) {
            $product = $this->products->find((int) $currentSubscription['product_id']);
            $currentSubscription['product_name'] = $product['name'] ?? 'NCLEX';
            $currentSubscription['product_slug'] = $product['slug'] ?? 'nclex';
            $currentSubscriptions[] = $currentSubscription;
        }
        $data['current_subscriptions'] = $currentSubscriptions;
        $data['current_subscription'] = $currentSubscription;
        if ($currentPortal === 'client') {
            return view('client/layout/header', $data)
                . view('client/subscriptions/index', $data)
                . view('client/layout/footer');
        }

        // Instructor portal (optional): fall back to client pricing but instructor layout
        if ($currentPortal === 'instructor') {
            return view('instructor/layout/header', $data)
                . view('client/subscriptions/index', $data)
                . view('instructor/layout/footer');
        }

        // Public fallback
        return view('homepage/header', $data)
            . view('subscriptions/index', $data)
            . view('homepage/footer');
    }

    public function success()
    {
        $orderId = $this->request->getGet('orderID');
        $plan = (string) $this->request->getGet('plan');
        $productSlug = (string) ($this->request->getGet('product') ?: 'nclex');
        $product = $this->products->findBySlug($productSlug);

        if (!$product || ($product['status'] ?? '') !== 'active') {
            return redirect()->to('/subscriptions')->with('error', 'Please choose a valid product.');
        }

        $isMonthly = in_array($plan, ['monthly', '1-month'], true);
        $isQuarterly = in_array($plan, ['quarterly', '3-month'], true);
        if (!$isMonthly && !$isQuarterly) {
            return redirect()->to('/subscriptions')->with('error', 'Please choose a valid access plan.');
        }

        $amount = $isMonthly ? (float) $product['monthly_price'] : (float) $product['quarterly_price'];
        $days = $isMonthly ? 30 : 90;
        $storedPlan = $isMonthly ? '1-month' : '3-month';

        $userId = (int) $this->session->get('user_id');
        if (!$userId) return redirect()->to('/login');

        // Check if there's an active access pass for this product.
        $activePass = $this->subs->where('user_id', $userId)
            ->where('product_id', (int) $product['id'])
            ->where('status', 'active')
            ->where('end_at >', date('Y-m-d H:i:s'))
            ->first();

        $start = date('Y-m-d H:i:s');
        // If there's an active pass, start the new one after it ends
        if ($activePass) {
            $start = date('Y-m-d H:i:s', strtotime($activePass['end_at']));
        }
        
        $end = date('Y-m-d H:i:s', strtotime($start . " +$days days"));

        // Record the access pass
        $passId = $this->subs->insert([
            'user_id' => $userId,
            'product_id' => (int) $product['id'],
            'plan' => $storedPlan,
            'status' => 'active',
            'paypal_order_id' => $orderId,
            'amount' => $amount,
            'currency' => 'USD',
            'start_at' => $start,
            'end_at' => $end,
        ], true);

        // Record the payment
        $this->payments->insert([
            'user_id' => $userId,
            'subscription_id' => $passId,
            'paypal_order_id' => $orderId,
            'status' => 'COMPLETED',
            'amount' => $amount,
            'currency' => 'USD',
        ]);

        // Send payment confirmation email (non-blocking)
        try {
            $userEmail = (string) ($this->session->get('user_email') ?? '');
            $userName  = (string) ($this->session->get('username') ?? 'Student');

            if ($userEmail !== '') {
                $planLabel = $isMonthly ? '1-Month' : '3-Month';
                $productName = (string) ($product['name'] ?? 'NCLEX Prep Course');

                $startFormatted = date('M j, Y', strtotime($start));
                $endFormatted   = date('M j, Y', strtotime($end));

                $subject = "Your {$planLabel} {$productName} access is confirmed";

                $testsUrl = base_url('client/tests');
                $message = "Hi {$userName},<br><br>"
                    . "Thank you for your payment via PayPal. Your {$productName} {$planLabel} access is now confirmed.<br><br>"
                    . "<strong>Order ID:</strong> {$orderId}<br>"
                    . "<strong>Amount:</strong> $" . number_format($amount, 2) . " USD<br>"
                    . "<strong>Access period:</strong> {$startFormatted} &ndash; {$endFormatted}<br><br>"
                    . "You can now log in and start practicing here:<br>"
                    . "<a href=\"{$testsUrl}\">{$testsUrl}</a><br><br>"
                    . "If you have any questions, just reply to this email or contact us:<br>"
                    . "WhatsApp: +1 (206) 350-4565<br>"
                    . "Email: support@nclexprepcourse.org<br><br>"
                    . "NCLEX Prep Course Team";

                Mailer::send($userEmail, $subject, $message);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Failed to send payment confirmation email: {message}', ['message' => $e->getMessage()]);
        }

        $message = $activePass 
            ? $product['name'] . ' access purchased successfully! It will start after your current pass expires.'
            : $product['name'] . ' access activated! You now have full access to the matching test bank.';

        return redirect()->to('/subscriptions')->with('message', $message);
    }
}
