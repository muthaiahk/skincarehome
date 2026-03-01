<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\WebAuthController;

Route::get('/', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Auto-generated Routes from legacy PHP files
Route::get('/add-app', function () { return view('add_app'); })->name('add-app');
Route::get('/add-billing', function () { return view('add_billing'); })->name('add-billing');
Route::get('/add-branch', function () { return view('add_branch'); })->name('add-branch');
Route::get('/add-brand', function () { return view('add_brand'); })->name('add-brand');
Route::get('/add-designation', function () { return view('add_designation'); })->name('add-designation');
Route::get('/add-dpt', function () { return view('add_dpt'); })->name('add-dpt');
Route::get('/add-inventory', function () { return view('add_inventory'); })->name('add-inventory');
Route::get('/add-lead', function () { return view('add_lead'); })->name('add-lead');
Route::get('/add-lead-source', function () { return view('add_lead_source'); })->name('add-lead-source');
Route::get('/add-lead-status', function () { return view('add_lead_status'); })->name('add-lead-status');
Route::get('/add-payment', function () { return view('add_payment'); })->name('add-payment');
Route::get('/add-pc', function () { return view('add_pc'); })->name('add-pc');
Route::get('/add-permission', function () { return view('add_permission'); })->name('add-permission');
Route::get('/add-product', function () { return view('add_product'); })->name('add-product');
Route::get('/add-product-category', function () { return view('add_product_category'); })->name('add-product-category');
Route::get('/add-role', function () { return view('add_role'); })->name('add-role');
Route::get('/add-sales', function () { return view('add_sales'); })->name('add-sales');
Route::get('/add-staff', function () { return view('add_staff'); })->name('add-staff');
Route::get('/add-tc', function () { return view('add_tc'); })->name('add-tc');
Route::get('/add-treatment', function () { return view('add_treatment'); })->name('add-treatment');
Route::get('/add-t-management', function () { return view('add_t_management'); })->name('add-t-management');
Route::get('/appointment', function () { return view('appointment'); })->name('appointment');
Route::get('/attendance', function () { return view('attendance'); })->name('attendance');
Route::get('/billing', function () { return view('billing'); })->name('billing');
Route::get('/body', function () { return view('body'); })->name('body');
Route::get('/branch', function () { return view('branch'); })->name('branch');
Route::get('/brand', function () { return view('brand'); })->name('brand');
Route::get('/company', function () { return view('company'); })->name('company');
Route::get('/consultation', function () { return view('consultation'); })->name('consultation');
Route::get('/customer', function () { return view('customer'); })->name('customer');
Route::get('/customer7-02', function () { return view('customer7-02'); })->name('customer7-02');
Route::get('/department', function () { return view('department'); })->name('department');
Route::get('/designation', function () { return view('designation'); })->name('designation');
Route::get('/edit-app', function () { return view('edit_app'); })->name('edit-app');
Route::get('/edit-atd', function () { return view('edit_atd'); })->name('edit-atd');
Route::get('/edit-billing', function () { return view('edit_billing'); })->name('edit-billing');
Route::get('/edit-branch', function () { return view('edit_branch'); })->name('edit-branch');
Route::get('/edit-brand', function () { return view('edit_brand'); })->name('edit-brand');
Route::get('/edit-company', function () { return view('edit_company'); })->name('edit-company');
Route::get('/edit-customer', function () { return view('edit_customer'); })->name('edit-customer');
Route::get('/edit-designation', function () { return view('edit_designation'); })->name('edit-designation');
Route::get('/edit-dpt', function () { return view('edit_dpt'); })->name('edit-dpt');
Route::get('/edit-inventory', function () { return view('edit_inventory'); })->name('edit-inventory');
Route::get('/edit-lead', function () { return view('edit_lead'); })->name('edit-lead');
Route::get('/edit-lead-source', function () { return view('edit_lead_source'); })->name('edit-lead-source');
Route::get('/edit-lead-status', function () { return view('edit_lead_status'); })->name('edit-lead-status');
Route::get('/edit-payment', function () { return view('edit_payment'); })->name('edit-payment');
Route::get('/edit-pc', function () { return view('edit_pc'); })->name('edit-pc');
Route::get('/edit-permission', function () { return view('edit_permission'); })->name('edit-permission');
Route::get('/edit-product', function () { return view('edit_product'); })->name('edit-product');
Route::get('/edit-product-category', function () { return view('edit_product_category'); })->name('edit-product-category');
Route::get('/edit-role', function () { return view('edit_role'); })->name('edit-role');
Route::get('/edit-staff', function () { return view('edit_staff'); })->name('edit-staff');
Route::get('/edit-tc', function () { return view('edit_tc'); })->name('edit-tc');
Route::get('/edit-treatment', function () { return view('edit_treatment'); })->name('edit-treatment');
Route::get('/edit-t-management', function () { return view('edit_t_management'); })->name('edit-t-management');
Route::get('/email', function () { return view('email'); })->name('email');
Route::get('/followup', function () { return view('followup'); })->name('followup');
Route::get('/followup-history', function () { return view('followup_history'); })->name('followup-history');
Route::get('/general', function () { return view('general'); })->name('general');
Route::get('/inventory', function () { return view('inventory'); })->name('inventory');
Route::get('/invoice', function () { return view('invoice'); })->name('invoice');
Route::get('/lead', function () { return view('lead'); })->name('lead');
Route::get('/lead-source copy', function () { return view('lead_source copy'); })->name('lead-source copy');
Route::get('/lead-source', function () { return view('lead_source'); })->name('lead-source');
Route::get('/lead-status', function () { return view('lead_status'); })->name('lead-status');
Route::get('/mark-atd', function () { return view('mark_atd'); })->name('mark-atd');
Route::get('/notification-view', function () { return view('notification_view'); })->name('notification-view');
Route::get('/payment', function () { return view('payment'); })->name('payment');
Route::get('/product', function () { return view('product'); })->name('product');
Route::get('/product-c', function () { return view('product_c'); })->name('product-c');
Route::get('/product-category', function () { return view('product_category'); })->name('product-category');
Route::get('/report-app', function () { return view('report_app'); })->name('report-app');
Route::get('/report-atd', function () { return view('report_atd'); })->name('report-atd');
Route::get('/report-lead', function () { return view('report_lead'); })->name('report-lead');
Route::get('/report-pay', function () { return view('report_pay'); })->name('report-pay');
Route::get('/report-stock', function () { return view('report_stock'); })->name('report-stock');
Route::get('/role-permission', function () { return view('role_permission'); })->name('role-permission');
Route::get('/sales', function () { return view('sales'); })->name('sales');
Route::get('/staff', function () { return view('staff'); })->name('staff');
Route::get('/test', function () { return view('test'); })->name('test');
Route::get('/treatment', function () { return view('treatment'); })->name('treatment');
Route::get('/treatment-management', function () { return view('treatment_management'); })->name('treatment-management');
Route::get('/t-category', function () { return view('t_category'); })->name('t-category');
Route::get('/user-profile', function () { return view('user_profile'); })->name('user-profile');
Route::get('/view-app', function () { return view('view_app'); })->name('view-app');
Route::get('/view-branch', function () { return view('view_branch'); })->name('view-branch');
Route::get('/view-brand', function () { return view('view_brand'); })->name('view-brand');
Route::get('/view-customer', function () { return view('view_customer'); })->name('view-customer');
Route::get('/view-designation', function () { return view('view_designation'); })->name('view-designation');
Route::get('/view-dpt', function () { return view('view_dpt'); })->name('view-dpt');
Route::get('/view-inventory', function () { return view('view_inventory'); })->name('view-inventory');
Route::get('/view-lead', function () { return view('view_lead'); })->name('view-lead');
Route::get('/view-lead-source', function () { return view('view_lead_source'); })->name('view-lead-source');
Route::get('/view-lead-status', function () { return view('view_lead_status'); })->name('view-lead-status');
Route::get('/view-payment', function () { return view('view_payment'); })->name('view-payment');
Route::get('/view-pc', function () { return view('view_pc'); })->name('view-pc');
Route::get('/view-permission', function () { return view('view_permission'); })->name('view-permission');
Route::get('/view-product', function () { return view('view_product'); })->name('view-product');
Route::get('/view-product-category', function () { return view('view_product_category'); })->name('view-product-category');
Route::get('/view-role', function () { return view('view_role'); })->name('view-role');
Route::get('/view-staff', function () { return view('view_staff'); })->name('view-staff');
Route::get('/view-tc', function () { return view('view_tc'); })->name('view-tc');
Route::get('/view-treatment', function () { return view('view_treatment'); })->name('view-treatment');
Route::get('/view-t-management', function () { return view('view_t_management'); })->name('view-t-management');

