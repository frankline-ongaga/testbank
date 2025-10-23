<?php

namespace App\Controllers;

use App\Models\SubscriptionModel;
use App\Models\PaymentModel;

class Subscriptions extends BaseController
{
    protected $subs;
    protected $payments;
    protected $session;

    public function __construct()
    {
        $this->subs = new SubscriptionModel();
        $this->payments = new PaymentModel();
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
        // Current user's active subscription (if any)
        $data['current_subscription'] = $userId ? $this->subs->getActiveForUser($userId) : null;
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
        $plan = $this->request->getGet('plan');
        $amount = $plan === 'monthly' ? 49.00 : 99.00;
        $days = $plan === 'monthly' ? 30 : 90;

        $userId = (int) $this->session->get('user_id');
        if (!$userId) return redirect()->to('/login');

        // Check if there's an active access pass
        $activePass = $this->subs->where('user_id', $userId)
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
            'plan' => $plan === 'monthly' ? '1-month' : '3-month',
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

        $message = $activePass 
            ? 'Access pass purchased successfully! It will start after your current pass expires.'
            : 'Access pass activated! You now have full access to the test bank.';

        return redirect()->to('/subscriptions')->with('message', $message);
    }
}