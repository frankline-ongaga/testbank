<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);

// Static Pages
$routes->get('/', 'Home::index');

// Authentication Routes
$routes->get('login', 'Auth::showLogin');
$routes->get('login/student', 'Auth::showLoginStudent');
$routes->post('login/student', 'Auth::loginStudent');
$routes->get('login/instructor', 'Auth::showLoginInstructor');
$routes->post('login/instructor', 'Auth::loginInstructor');
$routes->get('login/admin', 'Auth::showLoginAdmin');
$routes->post('login/admin', 'Auth::loginAdmin');
$routes->get('register', 'Auth::showRegister');
$routes->post('register', 'Auth::register');
$routes->get('forgot', 'Auth::showForgotPassword');
$routes->post('forgot', 'Auth::sendReset');
$routes->get('reset/(:any)', 'Auth::showReset/$1');
$routes->post('reset/(:any)', 'Auth::doReset/$1');
$routes->get('logout', 'Auth::logout');

// Admin Routes
$routes->group('admin', function($routes) {
    // Dashboard
    $routes->get('/', 'Admin::index');
    $routes->get('profile', 'Admin::profile');
    
    // Users Management
    // Friendly aliases
    $routes->get('users', 'Admin::viewUsers');
    $routes->get('users/create', 'Admin::addUser');
    $routes->post('users/store', 'Admin::saveUser');
    $routes->get('users/edit/(:num)', 'Admin::editUser/$1');
    $routes->post('users/update/(:num)', 'Admin::updateUser/$1');
    $routes->get('users/delete/(:num)', 'Admin::deleteUser/$1');

    // Backward-compatible routes
    $routes->get('viewUsers', 'Admin::viewUsers');
    $routes->get('addUser', 'Admin::addUser');
    $routes->post('saveUser', 'Admin::saveUser');
    $routes->get('editUser/(:num)', 'Admin::editUser/$1');
    $routes->post('updateUser', 'Admin::updateUser');
    $routes->get('deleteUser/(:num)', 'Admin::deleteUser/$1');
    
    // Analytics
    $routes->get('analytics', 'Analytics::index');
    $routes->get('analytics/categories', 'Analytics::categories');
    
    // Questions Management
    $routes->get('questions', 'Questions::index');
    $routes->get('questions/create', 'Questions::create');
    $routes->post('questions/store', 'Questions::store');
    $routes->get('questions/edit/(:num)', 'Questions::edit/$1');
    $routes->post('questions/update/(:num)', 'Questions::update/$1');
    $routes->get('questions/delete/(:num)', 'Questions::delete/$1');
    $routes->get('questions/preview/(:num)', 'Questions::preview/$1');
    $routes->get('questions/pending', 'Questions::pending');
    $routes->get('questions/approve/(:num)', 'Questions::approve/$1');
    $routes->get('questions/reject/(:num)', 'Questions::reject/$1');
    
    // Tests Management
    $routes->get('tests', 'Tests::index');
    $routes->get('tests/create', 'Tests::create');
    $routes->post('tests/store', 'Tests::store');
    $routes->get('tests/edit/(:num)', 'Tests::edit/$1');
    $routes->post('tests/update/(:num)', 'Tests::update/$1');
    $routes->get('tests/delete/(:num)', 'Tests::delete/$1');
    $routes->get('tests/activate/(:num)', 'Tests::activate/$1');
    
    // Subscriptions Management
    $routes->get('subscriptions', 'Subscriptions::index');
    $routes->get('subscriptions/view/(:num)', 'Subscriptions::view/$1');
    $routes->post('subscriptions/update/(:num)', 'Subscriptions::update/$1');
    
    // Study Notes Management
    $routes->get('notes', 'Notes::index');
    $routes->get('notes/create', 'Notes::create');
    $routes->post('notes/store', 'Notes::store');
    $routes->post('notes/upload-image', 'Notes::uploadImage');
    $routes->get('notes/edit/(:num)', 'Notes::edit/$1');
    $routes->post('notes/update/(:num)', 'Notes::update/$1');
    $routes->get('notes/delete/(:num)', 'Notes::delete/$1');
    $routes->get('notes/(:num)', 'Notes::view/$1');
    
    // Study Library Management
    $routes->get('study', 'StudyAdmin::index');
    $routes->get('study/category/create', 'StudyAdmin::createCategory');
    $routes->post('study/category/store', 'StudyAdmin::storeCategory');
    $routes->get('study/(:num)/subcategories', 'StudyAdmin::subcategories/$1');
    $routes->get('study/(:num)/subcategory/create', 'StudyAdmin::createSubcategory/$1');
    $routes->post('study/(:num)/subcategory/store', 'StudyAdmin::storeSubcategory/$1');
    $routes->get('study/subcategory/(:num)/questions', 'StudyAdmin::questions/$1');
    $routes->get('study/subcategory/(:num)/question/create', 'StudyAdmin::createQuestion/$1');
    $routes->post('study/subcategory/(:num)/question/store', 'StudyAdmin::storeQuestion/$1');
    $routes->get('study/question/(:num)/edit', 'StudyAdmin::editQuestion/$1');
    $routes->post('study/question/(:num)/update', 'StudyAdmin::updateQuestion/$1');
    $routes->get('study/question/(:num)/delete', 'StudyAdmin::deleteQuestion/$1');
    // Manage custom question categories under a subcategory
    $routes->get('study/subcategory/(:num)/qcategories', 'StudyAdmin::listQuestionCategories/$1');
    $routes->get('study/subcategory/(:num)/qcategories/create', 'StudyAdmin::createQuestionCategory/$1');
    $routes->post('study/subcategory/(:num)/qcategories/store', 'StudyAdmin::storeQuestionCategory/$1');
    $routes->get('study/qcategories/(:num)/edit', 'StudyAdmin::editQuestionCategory/$1');
    $routes->post('study/qcategories/(:num)/update', 'StudyAdmin::updateQuestionCategory/$1');
    $routes->get('study/qcategories/(:num)/delete', 'StudyAdmin::deleteQuestionCategory/$1');
    $routes->get('study/subcategory/(:num)/edit', 'StudyAdmin::editSubcategory/$1');
    $routes->post('study/subcategory/(:num)/update', 'StudyAdmin::updateSubcategory/$1');
    $routes->get('study/subcategory/(:num)/delete', 'StudyAdmin::deleteSubcategory/$1');
});

// Instructor Routes
$routes->group('instructor', function($routes) {
    $routes->get('/', 'Instructor::index');
    $routes->get('profile', 'Instructor::profile');
    $routes->post('updateProfile', 'Instructor::updateProfile');
    
    // Instructor Tests Management
    $routes->get('tests', 'Tests::index');
    $routes->get('tests/create', 'Tests::create');
    $routes->post('tests/store', 'Tests::store');
    $routes->get('tests/edit/(:num)', 'Tests::edit/$1');
    $routes->post('tests/update/(:num)', 'Tests::update/$1');
    
    // Instructor Questions Management
    $routes->get('questions', 'Questions::index');
    $routes->get('questions/create', 'Questions::create');
    $routes->post('questions/store', 'Questions::store');
    
    // Instructor Analytics
    $routes->get('analytics', 'Analytics::index');
    $routes->get('analytics/categories', 'Analytics::categories');
    
    // Instructor Study Notes Management
    $routes->get('notes', 'Notes::index');
    $routes->get('notes/create', 'Notes::create');
    $routes->post('notes/store', 'Notes::store');
    $routes->get('notes/edit/(:num)', 'Notes::edit/$1');
    $routes->post('notes/update/(:num)', 'Notes::update/$1');
    $routes->get('notes/delete/(:num)', 'Notes::delete/$1');
    $routes->get('notes/(:num)', 'Notes::view/$1');
});

// Client/Student Routes
$routes->group('client', function($routes) {
    $routes->get('/', 'Client::index');
    $routes->get('profile', 'Client::profile');
    $routes->post('updateProfile', 'Client::updateProfile');
    
    // Student Tests
    $routes->get('tests', 'Tests::index');
    $routes->get('tests/start/(:num)', 'TakeTest::start/$1');
    $routes->get('tests/take/(:num)', 'TakeTest::show/$1');
    $routes->post('tests/submit/(:num)', 'TakeTest::submit/$1');
    $routes->get('tests/results/(:num)', 'TakeTest::results/$1');
    
    // Student Analytics
    $routes->get('analytics', 'Analytics::index');
    $routes->get('analytics/categories', 'Analytics::categories');
    
    // Study Notes
    $routes->get('notes', 'Notes::index');
    $routes->get('notes/(:num)', 'Notes::view/$1');

    // Subscription (client aliases)
    $routes->get('subscription', 'Subscriptions::index');
    $routes->get('subscriptions', 'Subscriptions::index');
    
    // Study Library
    $routes->get('study', 'Study::index');
    $routes->get('study/(:num)/subcategories', 'Study::subcategories/$1');
    $routes->get('study/subcategory/(:num)/questions', 'Study::questions/$1');
});

// Subscription Routes
$routes->get('subscriptions', 'Subscriptions::index');
$routes->get('subscriptions/success', 'Subscriptions::success');

// Public Routes
$routes->get('notes', 'Notes::index');
$routes->get('pricing', 'Home::pricing');
$routes->get('how_it_works', 'Home::how_it_works');
$routes->get('terms', 'Home::terms');
$routes->get('privacy', 'Home::privacy');
$routes->get('about_us', 'Home::about_us');
$routes->get('refund_policy', 'Home::refund_policy');
$routes->get('blog', 'Home::blog');
$routes->get('reviews', 'Home::reviews');

// API Routes
$routes->get('api/category/(:num)', 'Api::get_categories_content/$1');