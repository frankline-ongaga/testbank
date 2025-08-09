<?php

namespace App\Controllers;

use App\Models\DesignModelWriter;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;
use Config\Services;

class Homewriter extends BaseController
{
    protected $session;
    protected $validation;
    protected $designModelWriter;
    protected $userModel;

    public function __construct()
    {
        helper(['form', 'url']);

        $this->session = session();
        $this->validation = Services::validation();

        $this->designModelWriter = new DesignModelWriter();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = $this->get_logins();
        $data['title'] = "99Content|Home";
        $data['keywords'] = "Platinum private lending, loans, emergency loans, platinum loans, boda boda loans, personal loans ";
        $data['description'] = "Mobitech Technologies is a leading provider of Bulk SMS services, USSD, Shortcodes and Mpesa integration services...";

        return view('homepage/index', $data);
    }

    public function pricing()
    {
        $data = $this->get_logins();
        $data['title'] = "99Content|Pricing";
        $data['keywords'] = "Mobitech Technologies,USSD,SMS,Bulk SMS,Mpesa Payments,Shortcodes,Nairobi";
        $data['description'] = "Mobitech Technologies Limited was established in 2012...";

        return view('homepage/pricing', $data);
    }

    public function about()
    {
        $data['title'] = "Platinum Private Lending|About us";
        $data['keywords'] = "Mobitech Technologies,pricing,plans,USSD,SMS,Bulk SMS,Mpesa Payments,Shortcodes,Nairobi, Kenya";
        $data['description'] = "Mobitech Technologies provides well researched, tailored pricing plans...";

        return view('about', $data);
    }

    public function faq()
    {
        $data = $this->get_logins();
        $data['title'] = "Platinum Private Lending|FAQs";
        $data['keywords'] = "Mobitech Technologies,USSD,SMS,Bulk SMS,Mpesa Payments,Shortcodes,Nairobi, Kenya";
        $data['description'] = "Mobitech Technologies provides one of the most robust bulk sms services...";

        return view('homepage/faq', $data);
    }

    public function contactus()
    {
        $data = $this->get_logins();
        $data['title'] = "Platinum Private Lending|Contact us";
        $data['keywords'] = "Mobitech Technologies,contact us,email,info@mobitechtechnologies.com,USSD,SMS,Bulk SMS,Mpesa Payments,Shortcodes,Nairobi";
        $data['description'] = "Mobitech Technologies is located at Commercial centre, Westlands, Nairobi Kenya...";

        return view('homepage/contactus', $data);
    }

    public function contactus_process()
    {
        $data['fname'] = $this->request->getPost('fname');
        $data['lname'] = $this->request->getPost('lname');
        $data['email'] = $this->request->getPost('email');
        $data['message'] = $this->request->getPost('message');

        $email = Services::email();
        $email->initialize([
            'mailType' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'wordWrap' => true
        ]);

        $email->setFrom('info@mobitechtechnologies.com');
        $email->setTo($data['email']);
        $email->setSubject("New query received");
        $email->setMessage(view('webquote_admin', $data));

        if ($email->send()) {
            $data['success'] = "Hello, we have received your message, we will get back to you ASAP";
        } else {
            $data['error'] = "oops something went wrong";
        }

        $data['title'] = "Mobitech Technologies|Contact us";
        $data['keywords'] = "Mobitech Technologies,contact us,email,info@mobitechtechnologies.com...";
        $data['description'] = "Mobitech Technologies is located at Commercial centre...";

        return view('contactus', $data);
    }

    public function add_user()
    {
        $token = bin2hex(random_bytes(16));
        $fname = $this->request->getPost('writer_fname');
        $lname = $this->request->getPost('writer_lname');
        $email = $this->request->getPost('writer_email');
        $pass = $this->request->getPost('new_password');
        $password = $this->hash_password($pass);

        $user_array = [
            'user_fname' => $fname,
            'user_lname' => $lname,
            'user_token' => $token,
            'user_authority' => 2,
            'user_email' => $email,
            'user_password' => $password,
            'user_added' => $this->current_time(),
        ];

        if ($this->user_exist_status($email) !== 'true') {
            $user_id = $this->designModelWriter->insert_writer($user_array);
            $this->add_initial_balance($user_id);

            $link = base_url("home/user_activation/{$user_id}/{$token}");

            $subject = "#{$user_id}: Welcome to 99 Writers";
            $message = "Hi {$fname},<br> Welcome to 99 Writers. Click the link below to activate your account.<br>
                <a href='{$link}'>{$link}</a><br>
                Your login credentials are:<br>
                Email: {$email} <br>
                Password: {$pass}<br><br>
                Kind regards.<br>
                99 Content Team.";

            $this->send_mail($email, $subject, $message);

            return view('homepage/registration_success');
        } else {
            return view('homepage/user_exists');
        }
    }

    public function user_activation($id = null, $token = null)
    {
        $user = $this->designModelWriter->get_token($id);
        if ($user && $user->user_token === $token) {
            $data = ['user_status' => 1];
            $this->designModelWriter->user_activation($id, $data);

            $subject = "#{$id}: User activation successful";
            $message = "Hi {$user->user_fname}, your account has been successfully activated.<br>
                        You can now start writing great content for your clients.<br>
                        Regards,<br>
                        99 Content Team.";

            $this->send_mail($user->user_email, $subject, $message);

            return view('homepage/login', ['user_activation' => 'Your account has been successfully activated, kindly login below']);
        } else {
            return view('homepage/activation_failed');
        }
    }

    public function send_mail($to, $subject, $message)
    {
        $email = Services::email();
        $email->setFrom('dispatch@essayloop.com', '99 Writers');
        $email->setTo($to);
        $email->setReplyTo('support@essayloop.com');
        $email->setSubject($subject);
        $email->setMessage($message);

        return $email->send();
    }

    public function add_initial_balance($user_id)
    {
        $this->designModelWriter->insert_initial_bal(['user_id' => $user_id]);
    }

    public function user_exist_status($email)
    {
        return $this->designModelWriter->user_exist_status($email);
    }

    public function current_time(): string
    {
        date_default_timezone_set('America/New_York');
        return date('Y-m-d H:i:s');
    }

    private function hash_password($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private function get_logins()
    {
        return [];
    }
}
