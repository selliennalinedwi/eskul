<?php
// app/Config/Routes.php

namespace Config;

$routes = Services::routes();

// Load system routing
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

// Default settings
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('EkskulController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// ===================== Halaman Ekskul =====================
$routes->get('/', 'EkskulController::index');           // Home page
$routes->get('ekskul', 'EkskulController::index');     // Daftar Ekskul
$routes->get('ekskul/(:segment)', 'EkskulController::detail/$1'); // Detail Ekskul
$routes->post('ekskul/register', 'EkskulController::register');  // Register Ekskul
$routes->get('ekskul/search', 'EkskulController::search');        // Search Ekskul

// ===================== Unified Dashboard =====================
$routes->get('dashboard', 'DashboardController::index');

// ===================== Auth =====================
// Form login tampil
$routes->get('auth/login', 'AuthController::login');
// Form login proses
$routes->post('auth/login', 'AuthController::loginPost');

$routes->get('auth/register', 'AuthController::register');
$routes->post('auth/register', 'AuthController::registerPost');
$routes->get('auth/logout', 'AuthController::logout');
// Admin Dashboard
$routes->get('admin', 'AdminController::index');
$routes->get('admin/approve/(:num)', 'AdminController::approve/$1');
$routes->get('admin/reject/(:num)', 'AdminController::reject/$1');

// Kelola ekskul
$routes->get('admin/ekskul/add', 'AdminController::addEkskul');
$routes->post('admin/ekskul/add', 'AdminController::addEkskulPost');
$routes->get('admin/ekskul/edit/(:num)', 'AdminController::editEkskul/$1');
$routes->post('admin/ekskul/edit/(:num)', 'AdminController::editEkskulPost/$1');
$routes->get('admin/ekskul/delete/(:num)', 'AdminController::deleteEkskul/$1');
$routes->get('admin', 'AdminController::dashboard');
$routes->get('admin', 'AdminController::dashboard', ['filter' => 'authGuardAdmin']);

// Chatbot AJAX
$routes->post('ekskul/chatbot', 'EkskulController::chatbot');
$routes->post('ekskul/virtual-assistant', 'EkskulController::virtualAssistant');
$routes->get('admin/dashboard', 'AdminController::dashboard');
// Dashboard Guru
$routes->get('guru/dashboard', 'GuruController::dashboard', ['filter' => 'auth:guru']);

// ===================== Early Warning System =====================
$routes->get('early-warning', 'EarlyWarningController::dashboard');
$routes->get('early-warning/create', 'EarlyWarningController::createWarning');
$routes->get('early-warning/get-students', 'EarlyWarningController::getStudents');
$routes->post('early-warning/store', 'EarlyWarningController::storeWarning');
$routes->get('early-warning/view/(:num)', 'EarlyWarningController::viewWarning/$1');
$routes->get('early-warning/resolve/(:num)', 'EarlyWarningController::resolveWarning/$1');
$routes->get('early-warning/send-notifications', 'EarlyWarningController::sendPendingNotifications');

// ===================== Media/Upload Foto =====================
$routes->get('media/gallery', 'MediaController::gallery');
$routes->get('media/upload', 'MediaController::uploadForm');
$routes->post('media/upload', 'MediaController::upload');
$routes->post('media/upload-ajax', 'MediaController::uploadAjax');
$routes->get('media/view/(:num)', 'MediaController::viewPhoto/$1');
$routes->get('media/delete/(:num)', 'MediaController::deletePhoto/$1');
$routes->post('media/visibility/(:num)', 'MediaController::updateVisibility/$1');
$routes->get('media/settings', 'MediaController::settings');

// ===================== Profile Settings =====================
$routes->get('profile/settings', 'ProfileController::settings');
$routes->post('profile/update-notification-settings', 'ProfileController::updateNotificationSettings');
$routes->post('profile/test-whatsapp', 'ProfileController::testWhatsApp');
$routes->post('profile/test-email', 'ProfileController::testEmail');

// ===================== Admin Dashboard (opsional) =====================
// Bisa ditambahkan nanti: misal verifikasi pendaftaran ekskul, kelola ekskul
