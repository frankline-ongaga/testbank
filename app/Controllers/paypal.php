<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\DesignModel;
use App\Models\WritingModel;
use CodeIgniter\Controller;
use Config\Services;

class Paypal extends BaseController
{
    protected $paypalLib;
    protected $designModel;
    protected $adminModel;
    protected $writingModel;
    protected $session;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->session = session();
        $this->paypalLib = service('PaypalLib');
        $this->designModel = new DesignModel();
        $this->adminModel = new AdminModel();
        $this->writingModel = new WritingModel();
    }

    public function callback()
    {
        $data = $this->session->get('userData');
        $fname = $data['user_fname'] ?? '';
        $email = $data['user_email'] ?? '';

        $txn_id = $this->request->getGet('txn_id');
        $invoice_id = $this->request->getGet('invoice_id');
        $order_id = $this->request->getGet('order_id');
        $amount = $this->request->getGet('amount');
        $status = $this->request->getGet('status');

        if ($txn_id && $invoice_id && $status && $order_id && $amount) {
            $response = $this->designModel->ifcomplete($order_id);
            $back = $this->designModel->checkAffiliate($order_id)[0] ?? [];

            if ($response === 'yes') {
                $this->designModel->update_tip($order_id, [
                    'transaction_code' => $txn_id,
                    'transaction_status' => $status,
                ]);

                $subject = "Thank you for your $$amount tip";
                $message = "Dear {$back['user_fname']},<br>Thank you for the tip...<br>EssayPrompt Team";

                $this->send_mail($back['user_email'], $subject, $message);

                return view('buyer/general_notification', [
                    'notification_title' => 'Thank You',
                    'notification_content' => 'We have successfully received your tip'
                ]);
            }

            $this->designModel->insert_trans([
                'transaction_payment_type' => 1,
                'transaction_order_id' => $order_id,
                'transaction_status' => $status,
                'transaction_code' => $txn_id,
                'transaction_amount' => $amount
            ]);

            $orderUpdate = ['order_status' => 1];

            if ($back['order_type'] == 2) {
                $orderUpdate['order_technical_status'] = 2;
            } elseif ($back['order_type'] == 3) {
                $orderUpdate['order_technical_status'] = 2;
                $orderUpdate['order_status'] = 3;
            }

            $this->designModel->updateTransaction($order_id, $orderUpdate);

            if (!empty($back['affiliate_id']) && $back['affiliate_id'] != $back['user_id']) {
                $comm = $this->designModel->getAffiliateCommission();
                $mat = $this->designModel->get_refferer_details($back['affiliate_id'])[0];

                $coupon = $this->gen_random();
                $this->designModel->insertCoupon([
                    'coupon_code' => $coupon,
                    'coupon_discount' => $comm,
                    'coupon_type' => 2,
                    'user_id' => $mat['user_id'],
                    'generated_by' => 1
                ]);

                $message = "Hi {$mat['user_fname']},<br>You have been awarded a coupon: $coupon...<br>EssayPrompt Team.";
                $this->send_mail($mat['user_email'], 'Referral Discount', $message);
            }

            if (!empty($back['order_coupon'])) {
                if ($this->designModel->checkCouponType($back['order_coupon']) === 'yes') {
                    $this->designModel->updateCoupon($back['order_coupon'], ['coupon_status' => 1]);
                }
            }

            $subject = "REF#$txn_id Paypal Payment Successful";
            $message = "Hi $fname,<br>We have successfully received funds...<br>EssayPrompt.";
            $this->send_mail($email, $subject, $message);

            $this->session->setFlashdata([
                'order_id' => $order_id,
                'amount' => $amount,
                'txn_id' => $txn_id,
                'status' => $status,
                'success_msg' => "Payment received Successfully"
            ]);

            return redirect()->to(base_url("client/success"));
        } else {
            $this->session->setFlashdata('error_msg', "Payment Failed. Kindly Retry");
            return redirect()->to(base_url("client/success"));
        }
    }

    public function generate_receipt($amount, $order_id, $fname, $email)
    {
        $subject = "Receipt#$order_id generated";
        $message = "Dear $fname,<br>Thank you for payment...<br>EssayPrompt Support.";
        $this->send_mail($email, $subject, $message);
    }

    public function success()
    {
        $paypalInfo = $this->request->getGet();

        $data = [
            'item_number' => $paypalInfo['item_number'] ?? '',
            'txn_id' => $paypalInfo['tx'] ?? '',
            'payment_amt' => $paypalInfo['amt'] ?? '',
            'currency_code' => $paypalInfo['cc'] ?? '',
            'status' => $paypalInfo['st'] ?? ''
        ];

        $this->writingModel->updateTransaction($data);

        if ($this->session->has('logged_in')) {
            $data['cust_name'] = $this->session->get('logged_in')['client_name'] ?? '';
            return view('Client/success', $data);
        }

        return view('success', $data);
    }

    public function cancel()
    {
        if ($this->session->has('logged_in')) {
            $data['cust_name'] = $this->session->get('logged_in')['client_name'] ?? '';
            return view('Client/cancel', $data);
        }

        return view('cancel');
    }

    public function ipn()
    {
        $paypalInfo = $this->request->getPost();

        $result = $this->paypalLib->curlPost($this->paypalLib->paypal_url, $paypalInfo);
        $this->writingModel->updateTransaction(
            $paypalInfo['custom'],
            $paypalInfo['txn_id'],
            $paypalInfo['payment_gross'],
            $paypalInfo['payer_email'],
            $paypalInfo['payment_status']
        );
    }

    public function gen_random()
    {
        return str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function send_mail($to, $subject, $message)
    {
        $email = Services::email();

        $email->initialize([
            'protocol' => 'smtp',
            'SMTPHost' => 'ssl://smtp.zoho.com',
            'SMTPPort' => 465,
            'SMTPUser' => 'support@essayprompt.org',
            'SMTPPass' => 'Essayprompt2025!',
            'mailType' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ]);

        $html_template = file_get_contents(base_url("assets/templates/contact-us.html"));
        $html_message = str_replace("%MESSAGE%", $message, $html_template);

        $email->setFrom('support@essayprompt.org')
              ->setTo($to)
              ->setBCC('dissertationeditorswriters@gmail.com')
              ->setReplyTo('support@essayprompt.org')
              ->setSubject($subject)
              ->setMessage($html_message)
              ->send();
    }
}
