<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Email;

class Home extends BaseController
{
    protected $designModel;
    protected $session;
    protected $validation;
    protected $email;
    protected $pager;
    
    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Load services and models
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->email = \Config\Services::email();
        $this->pager = \Config\Services::pager();
        
        // Load model
        // $this->designModel = new \App\Models\DesignModel();
        
        // Load helpers
        helper(['form', 'url']);
    }

    /**
     * Check if user is logged in and redirect
     */
    public function checkLogActivity()
    {
        if ($this->session->get('userData')) {
            return redirect()->to('client/index');
        }
    }

    /**
     * Get calculation variables for forms
     */
    public function getCalculationVariables()
    {
        $data['discipline'] = $this->designModel->getDiscipline();
        $data['level'] = $this->designModel->getLevel();
        $data['deadline'] = $this->designModel->getDeadline();
        $data['format'] = $this->designModel->getFormat();

        return $data;
    }

    /**
     * Display PHP info
     */
    public function phpInfo()
    {
        phpinfo();
    }

    /**
     * Get current time for timezone
     */
    public function getCurrentTime($timezone)
    {
        date_default_timezone_set($timezone);
        return date("Y-m-d H:i:s");
    }

    /**
     * Handle lead form submission
     */
    public function lead()
    {
        $data['title'] = "EssayPrompt 20% off coupon";
        $data['description'] = "Get a 20% discount when you make your first order.";

        $email = $this->request->getPost('email');
        $subject = "Thank you for visiting EssayPrompt";
        $message = "Thank you for visiting EssayPrompt, you have been awarded a 20% discount on your first order. Your 20% discount will take effect when you make your first order.";

        $this->sendMail($email, $subject, $message);

        $insert = [
            'lead_email' => $email,
            'lead_website' => 7,
        ];

        $this->designModel->insertLead($insert);

        $data = $this->getCalculationVariables();
        $data['message'] = "Kindly place your order below, your 20% discount will automatically take effect";

        return view('homepage/header', $data)
             . view('homepage/order_now', $data)
             . view('homepage/footer', $data);
    }

    /**
     * Blog listing and individual post pages
     */
    public function blog(...$segments)
    {
        $data = $this->getCalculationVariables();
        
        if (count($segments) > 0) {
            if (is_numeric($segments[0])) {
                // Pagination
                $data['title'] = "EssayPrompt Blog Posts";
                $data['name'] = "EssayPrompt Blog Posts";
                $data['description'] = "Browse through resources from our blog";
                
                // WordPress database connection would need to be configured in CI4
                $wordpress = \Config\Database::connect('wordpress');
                
                $query = $wordpress->table('wp_posts')
                    ->where('post_type', 'post')
                    ->where('post_status', 'publish')
                    ->orderBy('post_date', 'DESC');
                
                $total = $query->countAllResults(false);
                
                $perPage = 20;
                $page = (int)$segments[0];
                $offset = ($page - 1) * $perPage;
                
                $data['h'] = $query->limit($perPage, $offset)->get();
                
                // Pagination
                $data['pager'] = $this->pager->makeLinks($page, $perPage, $total, 'default_full');
                
                return view('homepage/header', $data)
                     . view('homepage/blog', $data)
                     . view('homepage/footer', $data);
            } else {
                // Individual blog post
                $postTitle = $segments[count($segments) - 1];
                
                $wordpress = \Config\Database::connect('wordpress');
                $data['h'] = $wordpress->table('wp_posts')
                    ->where('post_name', $postTitle)
                    ->get();
                
                if ($data['h']->getNumRows() > 0) {
                    $post = $data['h']->getRow();
                    $data['title'] = $post->post_title;
                    $data['name'] = $post->post_title;
                    $data['description'] = $post->post_excerpt;
                }
                
                return view('homepage/header', $data)
                     . view('homepage/blog_details', $data)
                     . view('homepage/footer', $data);
            }
        } else {
            // Default blog listing
            $data['title'] = "EssayPrompt Blog Posts";
            $data['name'] = "Blog Posts";
            $data['description'] = "Browse through resources from our blog";
            
            $wordpress = \Config\Database::connect('wordpress');
            $data['h'] = $wordpress->table('wp_posts')
                ->where('post_type', 'post')
                ->where('post_status', 'publish')
                ->orderBy('post_date', 'DESC')
                ->limit(20)
                ->get();
                
            return view('homepage/header', $data)
                 . view('homepage/blog', $data)
                 . view('homepage/footer', $data);
        }
    }

    /**
     * Test days calculation
     */
    public function testDays($deadline = "2020-11-21 04:00", $timezone = 'Africa/Nairobi')
    {
        $currDate = $this->getCurrentTime($timezone);
        $date1 = $currDate;
        $date2 = $deadline;
        $diff = strtotime($date2) - strtotime($date1);
        $diffInHrs = $diff / 3600;
        
        echo $diffInHrs;
    }

    /**
     * Get time calculation
     */
    public function getTimeStuff($deadline, $timezone)
    {
        $currDate = $this->getCurrentTime($timezone);
        $date1 = $currDate;
        $date2 = $deadline;
        $diff = strtotime($date2) - strtotime($date1);
        $diffInHrs = $diff / 3600;
        $days = $diffInHrs / 24;

        return $days;
    }

    /**
     * Get deadline algorithm
     */
    public function getDeadlineAlgo($deadline = 78)
    {
        $db = \Config\Database::connect();
        $records = $db->table('tbl_draft_deadline')->get()->getResult();

        $arr = [];
        foreach ($records as $record) {
            $rec = $record->deadline_duration;
            if ($rec <= $deadline) {
                array_push($arr, $rec);
            }
        }

        $correct = max($arr);
        echo $correct;
    }

    /**
     * Get price calculation via AJAX
     */
    public function getPrice()
    {
        $deadline = $this->request->getPost('deadline');
        $level = $this->request->getPost('level');
        $coupon = $this->request->getPost('coupon');
        $userId = $this->request->getPost('user_id');
        $service = $this->request->getPost('service');
        $pages = $this->request->getPost('pages');
        $timezone = $this->request->getPost('timezone');

        $deadlineId = $this->getTimeStuff($deadline, $timezone);
        $price = $this->designModel->getPrice($deadlineId, $level, $coupon, $userId, $service, $pages);

        return $this->response->setJSON(['price' => $price]);
    }

    /**
     * Paper details for samples
     */
    public function paperDetailsSamples()
    {
        $data = $this->getCalculationVariables();
        
        $postTitle = $this->request->getUri()->getSegment(3);
        $data['h'] = $this->designModel->getSample($postTitle);

        if ($data['h']->getNumRows() > 0) {
            $sample = $data['h']->getRow();
            $data['title'] = $sample->sample_title;
            $data['description'] = $sample->sample_paragraph;
        }

        return view('homepage/header', $data)
             . view('homepage/paper_details', $data)
             . view('homepage/footer');
    }

    /**
     * Home page
     */
    public function index(): string
    {
        // $data = $this->getCalculationVariables();

        $data['title'] = "Professional essay writing and editing service";
        $data['description'] = "We are a one-stop solution for all types of custom papers including case studies, lab reports, term papers, dissertation papers, thesis papers, research papers, PowerPoint presentations, projects, and much more. Our essay writing service has professional writers with several years of experience in writing papers on any topic and discipline. Some of these disciplines include statistics, finance, accounting, economics, physics, mathematics, chemistry, law, engineering, nursing, medicine, programming, computer science, and much more.";

        // Load study categories and their subcategories for dynamic homepage tabs
        $categoryModel = new \App\Models\StudyCategoryModel();
        $subcategoryModel = new \App\Models\StudySubcategoryModel();

        $categories = $categoryModel->orderBy('name', 'ASC')->findAll();
        $subcategoriesByCategoryId = [];
        if (!empty($categories)) {
            $categoryIds = array_map(static function ($c) { return $c['id']; }, $categories);
            if (!empty($categoryIds)) {
                $subs = $subcategoryModel->whereIn('category_id', $categoryIds)
                    ->orderBy('name', 'ASC')
                    ->findAll();
                foreach ($subs as $sub) {
                    $cid = $sub['category_id'];
                    if (!isset($subcategoriesByCategoryId[$cid])) {
                        $subcategoriesByCategoryId[$cid] = [];
                    }
                    $subcategoriesByCategoryId[$cid][] = $sub;
                }
            }
        }
        $data['studyCategories'] = $categories; // array of ['id','name','slug','description']
        $data['studySubcategoriesByCategoryId'] = $subcategoriesByCategoryId; // map cid => subcategory[]

        return view('homepage/header', $data)
             . view('homepage/index', $data)
             . view('homepage/footer', $data);
    }

    public function teas(): string
    {
        // $data = $this->getCalculationVariables();

        $data['title'] = "Professional essay writing and editing service";
        $data['description'] = "We are a one-stop solution for all types of custom papers including case studies, lab reports, term papers, dissertation papers, thesis papers, research papers, PowerPoint presentations, projects, and much more. Our essay writing service has professional writers with several years of experience in writing papers on any topic and discipline. Some of these disciplines include statistics, finance, accounting, economics, physics, mathematics, chemistry, law, engineering, nursing, medicine, programming, computer science, and much more.";

        return view('homepage/header', $data)
             . view('homepage/teas', $data)
             . view('homepage/footer', $data);
    }


    public function nclex(): string
    {
        // $data = $this->getCalculationVariables();

        $data['title'] = "Professional essay writing and editing service";
        $data['description'] = "We are a one-stop solution for all types of custom papers including case studies, lab reports, term papers, dissertation papers, thesis papers, research papers, PowerPoint presentations, projects, and much more. Our essay writing service has professional writers with several years of experience in writing papers on any topic and discipline. Some of these disciplines include statistics, finance, accounting, economics, physics, mathematics, chemistry, law, engineering, nursing, medicine, programming, computer science, and much more.";

        return view('homepage/header', $data)
             . view('homepage/nclex', $data)
             . view('homepage/footer', $data);
    }
    public function hesi2(): string
    {
        // $data = $this->getCalculationVariables();

        $data['title'] = "Professional essay writing and editing service";
        $data['description'] = "We are a one-stop solution for all types of custom papers including case studies, lab reports, term papers, dissertation papers, thesis papers, research papers, PowerPoint presentations, projects, and much more. Our essay writing service has professional writers with several years of experience in writing papers on any topic and discipline. Some of these disciplines include statistics, finance, accounting, economics, physics, mathematics, chemistry, law, engineering, nursing, medicine, programming, computer science, and much more.";

        return view('homepage/header', $data)
             . view('homepage/hesi2', $data)
             . view('homepage/footer', $data);
    }

    


    public function how_it_works()
    {
        // $data = $this->getCalculationVariables();

        $data['title'] = "Professional essay writing and editing service";
        $data['description'] = "We are a one-stop solution for all types of custom papers including case studies, lab reports, term papers, dissertation papers, thesis papers, research papers, PowerPoint presentations, projects, and much more. Our essay writing service has professional writers with several years of experience in writing papers on any topic and discipline. Some of these disciplines include statistics, finance, accounting, economics, physics, mathematics, chemistry, law, engineering, nursing, medicine, programming, computer science, and much more.";

        return view('homepage/header', $data)
             . view('homepage/how_it_works', $data)
             . view('homepage/footer', $data);
    }

    /**
     * Pricing page
     */
    public function pricing()
    {
        //$data = $this->getCalculationVariables();

        $data['title'] = "EssayPrompt pricing";
        $data['description'] = "EssayPrompt pricing plan is based on academic level, number of pages and urgency. Enjoy our rates that are way below market rates. Also, get to enjoy a lot of discounts in form of coupons.";

        return view('homepage/header', $data)
             . view('homepage/pricing', $data)
             . view('homepage/footer');
    }

     public function reviews()
    {
        //$data = $this->getCalculationVariables();

        $data['title'] = "EssayPrompt pricing";
        $data['description'] = "EssayPrompt pricing plan is based on academic level, number of pages and urgency. Enjoy our rates that are way below market rates. Also, get to enjoy a lot of discounts in form of coupons.";

        return view('homepage/header', $data)
             . view('homepage/reviews', $data)
             . view('homepage/footer');
    }

    /**
     * Order now page
     */
    public function orderNow(): string
    {
        $data = $this->getCalculationVariables();

        $data['disc'] = $this->request->getPost('discipline');
        $data['leve'] = $this->request->getPost('level');
        $data['dead'] = $this->request->getPost('order_deadline_id');
        $data['pago'] = $this->request->getPost('quant');

        if (isset($data['pago'])) {
            $data['page'] = $data['pago'][1];
        }

        if (isset($data['leve'])) {
            $data['leve'] = $data['leve'];
        } else {
            $data['leve'] = 3;
        }

        $data['title'] = "Order your custom essay at EssayPrompt";
        $data['description'] = "Complete a simple order form to order your custom paper.";

        return view('homepage/header', $data)
             . view('homepage/order_now', $data)
             . view('homepage/footer', $data);
    }

    /**
     * About us page
     */
    public function aboutUs(): string
    {
        $data = $this->getCalculationVariables();

        $data['title'] = "EssayPrompt writing service";
        $data['description'] = "EssayPrompt.com is an academic writing website specializing in writing essays and other academic writing assignments. We provide our services to several students worldwide looking for essay writing services and online class help services.";

        return view('homepage/header', $data)
             . view('homepage/about_us', $data)
             . view('homepage/footer');
    }

    /**
     * FAQ page
     */
    public function faq(): string
    {
        $data = $this->getCalculationVariables();

        $data['title'] = "FREQUENTLY ASKED QUESTIONS";
        $data['description'] = "EssayPrompt.com stands out from other essay writing services for a number of reasons. Top-rated academic writing professionals, high-quality custom papers that follow all directions and requirements, plagiarism-free papers, and on-time delivery are just a few of the reasons.";

        return view('homepage/header', $data)
             . view('homepage/faq', $data)
             . view('homepage/footer');
    }

    /**
     * Contact us page
     */
    public function contactUs(): string
    {
        $data = $this->getCalculationVariables();

        $data['title'] = "EssayPrompt|Contact Us";
        $data['description'] = "Contact us for any inquiries";

        return view('homepage/header', $data)
             . view('homepage/contact_us', $data)
             . view('homepage/footer');
    }

    /**
     * Process contact form
     */
    public function contactUsProcess()
    {
        // Validation rules
        $this->validation->setRules([
            'fname' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'subject' => 'required|min_length[5]|max_length[100]',
            'message' => 'required|min_length[10]|max_length[1000]',
            'g-recaptcha-response' => 'required'
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        // Verify reCAPTCHA
        $response = $this->request->getPost('g-recaptcha-response');
        $secretKey = '6LdVpcgZAAAAAK3Y2qairHtLutmJurmliaZqhmog';
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($response);
        $verify = file_get_contents($url);
        $captchaSuccess = json_decode($verify);

        if ($captchaSuccess->success == true) {
            $fname = $this->request->getPost('fname');
            $subject = $this->request->getPost('subject');
            $email = $this->request->getPost('email');
            $message = $this->request->getPost('message');

            // Send to admin
            $to = "support@EssayPrompt.com";
            $adminSubject = "REF: Customer Enquiry by $fname";
            $msg = "Hi admin,<br>
                    You have a support message:<br>
                    Customer Name: $fname <br>
                    Customer Email: $email <br>
                    Subject: $subject <br>
                    Message: $message <br>";

            $this->sendMail($to, $adminSubject, $msg);

            $data = $this->getCalculationVariables();
            $data['title'] = "EssayPrompt|Contact";
            $data['message'] = "Thank you for contacting EssayPrompt, we will revert ASAP";

            return view('homepage/header', $data)
                 . view('homepage/contact_us', $data)
                 . view('homepage/footer');
        } else {
            $data = $this->getCalculationVariables();
            $data['title'] = "EssayPrompt|Contact";
            $data['fail'] = "Kindly verify that you are not a robot";

            return view('homepage/header', $data)
                 . view('homepage/contact_us', $data)
                 . view('homepage/footer');
        }
    }

    /**
     * User login
     */
    public function loginUser()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $data = [
            'email' => $email,
            'password' => $password
        ];

        $result = $this->designModel->loginUser($data);

        if ($result === 'true') {
            $userInfo = $this->designModel->readUserInformation($email);
            
            $userData = [
                'user_fname' => $userInfo[0]->user_fname,
                'user_id' => $userInfo[0]->user_id,
                'user_email' => $userInfo[0]->user_email,
                'user_login_type' => 1,
                'user_authority' => 1,
            ];

            $this->session->set('userData', $userData);
            return redirect()->to('client/index/');

        } elseif ($result === 'wrong') {
            return view('homepage/awaiting_activation');
        } elseif ($result === 'deactivated') {
            $data['error_message'] = 'Your account has been deactivated, kindly contact support';
            return $this->showLoginError($data);
        } else {
            $data['error_message'] = 'Invalid Username or Password';
            return $this->showLoginError($data);
        }
    }

    /**
     * Show login error
     */
    private function showLoginError($data)
    {
        $data['title'] = "EssayPrompt|Client";
        return view('homepage/header', $data)
             . view('homepage/client_account', $data)
             . view('homepage/footer');
    }

    /**
     * Logout user
     */
    public function normalLogout()
    {
        $this->session->remove('userData');
        $this->session->destroy();
        return redirect()->to('/');
    }

    /**
     * Send email
     */
    public function sendMail($to, $subject, $message)
    {
        $config = [
            'protocol' => 'smtp',
            'SMTPHost' => 'ssl://smtp.zoho.com',
            'SMTPPort' => 465,
            'SMTPUser' => 'support@essayprompt.org',
            'SMTPPass' => 'Essayprompt2025!',
            'mailType' => 'html',
            'charset' => 'utf-8'
        ];

        $this->email->initialize($config);
        
        $this->email->setFrom('support@essayprompt.org');
        $this->email->setTo($to);
        $this->email->setBCC('essayloopwriters@gmail.com');
        $this->email->setReplyTo('support@essayprompt.org');
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        return $this->email->send();
    }

    /**
     * Hash password
     */
    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Complete order page
     */
    public function completeOrder(): string
    {
        $userData = $this->session->get('userData');

        $data['title'] = "Essays Loop|Complete order";
        $data['description'] = "Complete your order via Paypal";

        if ($this->session->getFlashdata('order_id')) {
            $data['order_id'] = $this->session->getFlashdata('order_id');
        }
        if ($this->session->getFlashdata('amount')) {
            $data['amount'] = $this->session->getFlashdata('amount');
        }

        return view('homepage/header', $data)
             . view('homepage/complete', $data)
             . view('homepage/footer', $data);
    }

    /**
     * Sample details page
     */
    public function sampleDetails(): string
    {
        $data = $this->getCalculationVariables();

        $postTitle = $this->request->getUri()->getSegment(2);
        $data['h'] = $this->designModel->getSample($postTitle);

        if (!empty($data['h']) && count($data['h']) > 0) {
            $data['title'] = $data['h'][0]->sample_title;
            $data['name'] = $data['h'][0]->sample_title;
            $data['description'] = $data['h'][0]->sample_paragraph;
        }

        return view('homepage/header', $data)
             . view('homepage/paper_details', $data)
             . view('homepage/footer');
    }
}