<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminEditController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', function() {
    return view('home.index');
})->name('default');

Route::get('/about', function() {
    return view('home.about-us');
})->name('about');

Route::get('/contact', function() {
    return view('home.contact-us');
})->name('contact');

Route::get('/services', function() {
    return view('home.services');
})->name('services');

Route::get('/faq', function() {
    return view('home.faq');
})->name('faq');

Route::get('/login', function () {
    return view('user.login');
})->name('login');
Route::post('/send-otp', [LoginController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otpmobile', [LoginController::class, 'verifyOtpmobile'])->name('verify.otpmobile');

Route::get('/signup', function () {
    return view('user.signup'); // Show signup form
})->name('signup');
Route::post('/signup', [SignupController::class, 'signup']);
Route::post('/checkotp', [SignUpController::class, 'checkotp']);

Route::get('/vendor', function() {
    return view('user.vendor_registration'); // Replace with actual registration view
})->name('vendor.register');
Route::view('/vendor-registration', 'user.vendor_registration');
Route::post('/fetch-vendor-data', [VendorController::class, 'fetchVendorData'])->name('fetch.vendor.data');
Route::post('/register-vendor', [VendorController::class, 'registerVendor'])->name('register.vendor');

Route::post('/register-vendormanual', [VendorController::class, 'registerVendorNoGst'])->name('register.vendormanual');

//Route::post('/register-vendor', [VendorController::class, ''])->name('register.vendor');
Route::post('/verify-otp', [VendorController::class, 'verifyOtp'])->name('verify.otp');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/update-vendor', [HomeController::class, 'updateVendor'])->name('update.vendor');

Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
Route::get('/eenquiry', [HomeController::class, 'inquiry'])->name('inquiry.show');
Route::get('/user/logout', [LoginController::class, 'logout'])->name('user.logout');

Route::get('/subscribe/show', [HomeController::class, 'subscribe'])->name('subscribe.show');
Route::post('/subscribed', [SubscriberController::class, 'store'])->name('subscribed.store');

Route::get('/unsubscribe/show', [HomeController::class, 'unsubscribe'])->name('unsubscribe.show');
Route::post('/unsubscribe', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe.store');
Route::get('/unsubscribee', [SubscriberController::class, 'unsubscribe'])->name('unsubscribee');
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return response()->json(['message' => 'Logged out successfully']);
})->name('logout');

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);

Route::get('/admin/dashboard', [AdminLoginController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/admin/vendors', [DashboardController::class, 'vendorList'])->name('admin.vendors');
Route::get('/admin/vendors/data', [DashboardController::class, 'getVendors'])->name('admin.vendors.data');

Route::get('/admin/subscribers', [DashboardController::class, 'showSubscribers'])->name('Subscribers');

Route::get('/admin/unsubscribers', [DashboardController::class, 'UnSubscribers'])->name('UnSubscribers');

Route::get('/admin/inquiry', [DashboardController::class, 'Inquiries'])->name('Inquiry');

Route::get('/admin/edit-profile', [AdminEditController::class, 'editProfile'])->name('admin.editProfile');
Route::post('/admin/update-profile', [AdminEditController::class, 'updateProfile'])->name('admin.updateProfile');
Route::post('/admin/reset-password', [AdminLoginController::class, 'resetPassword'])->name('admin.reset.password');


Route::get('/unsubscribe/{email}', [SubscriberController::class, 'delete']);
Route::post('/send-message', [MessageController::class, 'store'])->name('send.message');