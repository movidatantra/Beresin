<?php

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Services\BrickService;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminMitraController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminPembayaranController;
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AdminComplaintController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\MitraServiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Mitra\WithdrawController as MitraWithdrawController;


use App\Http\Controllers\WithdrawalController as AdminWithdrawalController;
use App\Http\Controllers\OrderReportController;
use App\Http\Controllers\IncomeReportController;
use App\Http\Controllers\MitraReportController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\MitraLaporanController;
use App\Http\Controllers\CustomerLaporanController;
use App\Http\Controllers\NotifikasiPelangganController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\CustomerBalanceController;
use App\Http\Controllers\WorkProofController;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);

/*
|--------------------------------------------------------------------------
| AUTH PELANGGAN & MITRA
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/register-mitra', [AuthController::class, 'showRegisterMitra']);
Route::post('/register-mitra', [AuthController::class, 'registerMitra']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::post('/send-email-otp', [AuthController::class, 'sendEmailOtp']);
Route::post('/verify-email-otp', [AuthController::class, 'verifyEmailOtp']);
Route::post('/send-phone-otp', [AuthController::class, 'sendPhoneOtp']);
Route::post('/verify-phone-otp', [AuthController::class, 'verifyPhoneOtp']);

Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/send-reset-otp', [AuthController::class, 'sendResetOtp']);
Route::post('/verify-reset-otp', [AuthController::class, 'verifyResetOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// OAUTH GOOGLE
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();
    $user = User::updateOrCreate(
        ['email' => $googleUser->email],
        [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => bcrypt('google-login'),
            'role' => 'pelanggan'
        ]
    );
    Auth::login($user);
    return redirect('/pelanggan');
});

/*
|--------------------------------------------------------------------------
| WILAYAH & UTILITAS
|--------------------------------------------------------------------------
*/
Route::get('/kabupaten/{kd_prov}', [WilayahController::class, 'getKabupaten']);
Route::get('/kecamatan/{kd_kab}', [WilayahController::class, 'getKecamatan']);
Route::get('/test-haversine', [BookingController::class, 'testHaversine']);
Route::get('/test-account', function (BrickService $brick) {
    return $brick->verifyAccount('BCA', '1234567890');
});
Route::post('/cek-rekening', [AuthController::class, 'cekRekening']);

/*
|--------------------------------------------------------------------------
| ROUTE PELANGGAN (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/pelanggan', [PelangganController::class, 'dashboard']);
    Route::get('/profile-pelanggan', [PelangganController::class, 'profile']);
    Route::post('/profile-pelanggan', [PelangganController::class, 'updateProfile']);
    Route::get('/ubah-password', [PelangganController::class, 'showChangePassword']);
    Route::post('/ubah-password', [PelangganController::class, 'changePassword']);
    Route::get('/pengaturan-akun', [PelangganController::class, 'settings']);
    Route::delete('/hapus-akun', [PelangganController::class, 'deleteAccount']);
    Route::post('/update-location', [PelangganController::class, 'updateLocation'])->name('update.location');

    // Pencarian & Detail Layanan/Mitra
    Route::get('/category/{category}', [PelangganController::class, 'category']);
    Route::get('/service/{id}', [PelangganController::class, 'show']);
    // Route::get('/mitra/{id}', [PelangganController::class, 'mitraDetail']);
    Route::get('/mitra/{id}', [PelangganController::class, 'mitraDetail'])
    ->whereNumber('id');

    // Keranjang & Checkout
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add/{id}', [CartController::class, 'add']);
    Route::post('/cart/decrease/{id}', [CartController::class, 'decrease']);
    Route::post('/cart/update-qty', [CartController::class, 'updateQty']);
    Route::get('/cart/delete/{id}', [CartController::class, 'delete']);
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'store'])->name('checkout.process');
    Route::get('/available-slots', [CheckoutController::class, 'availableSlots']);

    // Halaman Pembayaran Snap Midtrans
    Route::get('/checkout/payment/{id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
// Pembayaran menggunakan Saldo Beres.in
Route::post(
    '/checkout/payment/{id}/balance',
    [CheckoutController::class, 'payWithBalance']
)->name('checkout.pay-balance');
    // Manajemen Order Pelanggan
    Route::get('/my-orders', [PelangganController::class, 'myOrders'])->name('pelanggan.orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('pelanggan.orders.show');
    
});

/*
|--------------------------------------------------------------------------
| ROUTE MITRA (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/mitra', [MitraController::class, 'dashboard']);
    Route::get('/profile-mitra', [AuthController::class, 'profileMitra']);
    Route::post('/profile-mitra', [AuthController::class, 'updateProfileMitra']);
    
    Route::get('/booking-slots', [MitraController::class, 'schedule'])->name('mitra.schedule');
    Route::get('/pendapatan', [MitraController::class, 'pendapatan']);
    Route::get('/saldo', [MitraController::class, 'saldo']);
    Route::get('/notifikasi', [MitraController::class, 'notifikasi']);
    Route::post('/withdraw', [MitraController::class, 'withdraw'])->name('mitra.withdraw');
    Route::post('/mitra/toggle-status', [MitraController::class, 'toggleStatus']);

    // Order & Service Mitra
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/status/{id}/{status}', [OrderController::class, 'updateStatus']);
    Route::get('/orders/payment/{id}', [OrderController::class, 'verifyPayment']);
    Route::get('/history-orders', [OrderController::class, 'history']);
    Route::get('/payment-confirm/{id}', [OrderController::class, 'markAsPaid'])->name('orders.paid');
    
    Route::resource('services', ServiceController::class);
    Route::resource('mitra-services', MitraServiceController::class);
    
});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/mitra', [AdminController::class, 'mitraPending'])->name('admin.mitra');
    Route::get('/mitra/{id}', [AdminController::class, 'detailMitra'])->name('admin.mitra.detail');
    Route::post('/mitra/{id}/approve', [AdminController::class, 'approveMitra'])->name('admin.mitra.approve');
    Route::post('/mitra/{id}/reject', [AdminController::class, 'rejectMitra'])->name('admin.mitra.reject');

    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.kelola-pengguna.pelanggan');
    Route::get('/customers/{id}', [AdminCustomerController::class, 'show'])->name('admin.kelola-pengguna.pelanggan.show');
    Route::post('/customers/{id}/suspend', [AdminCustomerController::class, 'suspend'])->name('admin.kelola-pengguna.pelanggan.suspend');
    Route::post('/customers/{id}/activate', [AdminCustomerController::class, 'activate'])->name('admin.kelola-pengguna.pelanggan.activate');

    Route::get('/manage-mitra', [AdminMitraController::class, 'index'])->name('admin.kelola-pengguna.mitra');
    Route::get('/manage-mitra/{id}', [AdminMitraController::class, 'show'])->name('admin.kelola-pengguna.mitra.show');
    Route::post('/manage-mitra/{id}/suspend', [AdminMitraController::class, 'suspend'])->name('admin.kelola-pengguna.mitra.suspend');
    Route::post('/manage-mitra/{id}/activate', [AdminMitraController::class, 'activate'])->name('admin.kelola-pengguna.mitra.activate');

   // ROUTE WITHDRAWAL YANG BENAR
    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::get('/withdrawals/{id}', [AdminWithdrawalController::class, 'show'])->name('withdrawals.show');
    Route::post('/withdrawals/{id}/approve', [AdminWithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{id}/reject', [AdminWithdrawalController::class, 'reject'])->name('withdrawals.reject');
    Route::get('/payments', [AdminPembayaranController::class, 'index'])->name('admin.pembayaran');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews');
    Route::get('/reviews/{id}', [AdminReviewController::class, 'show'])->name('admin.reviews.show');

    Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('admin.complaints');
    Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('admin.complaints.show');
    Route::put('/complaints/{complaint}', [AdminComplaintController::class, 'update'])->name('admin.complaints.update');

    Route::resource('categories', CategoryController::class);

    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports');
    Route::get('/reports/orders', [AdminReportController::class, 'orders'])->name('admin.reports.orders');
    Route::get('/reports/income', [AdminReportController::class, 'income'])->name('admin.reports.income');
    Route::get('/reports/mitras', [AdminReportController::class, 'mitras'])->name('admin.reports.mitras');
    Route::get('/reports/customers', [AdminReportController::class, 'customers'])->name('admin.reports.customers');
    Route::get('/reports/services', [AdminReportController::class, 'services'])->name('admin.reports.services');
    Route::get('/reports/complaints', [AdminReportController::class, 'complaints'])->name('admin.reports.complaints');
});

/*
|--------------------------------------------------------------------------
| MIDTRANS WEBHOOK / CALLBACK
|--------------------------------------------------------------------------
*/
Route::post('/midtrans-callback', [CheckoutController::class, 'callback'])->name('midtrans.callback');
Route::get('/checkout/check-status/{id}', [CheckoutController::class, 'checkStatus']);




Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])
    ->name('notifications.readAll')
    ->middleware('auth');



Route::middleware(['auth'])->prefix('mitra')->name('mitra.')->group(function () {
    // Route untuk menampilkan halaman saldo & pencairan
    Route::get('/withdraw', [WithdrawalController::class, 'index'])->name('withdraw.index');

    // Route POST untuk memproses pengajuan pencairan
    Route::post('/withdraw', [WithdrawalController::class, 'store'])->name('withdraw');
});






// ================= ROUTE MITRA =================
Route::middleware(['auth', 'role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/saldo', [MitraWithdrawController::class, 'index'])->name('saldo');
    Route::post('/withdraw', [MitraWithdrawController::class, 'store'])->name('withdraw');
});

// ================= ROUTE ADMIN =================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::get('/withdrawals/{id}', [AdminWithdrawalController::class, 'show'])->name('withdrawals.show');
    Route::post('/withdrawals/{id}/approve', [AdminWithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{id}/reject', [AdminWithdrawalController::class, 'reject'])->name('withdrawals.reject');
});



Route::get(
    '/orders/{id}/review',
    [ReviewController::class,'create']
)->name('review.create');

Route::post(
    '/orders/{id}/review',
    [ReviewController::class,'store']
)->name('review.store');

Route::middleware(['auth'])->group(function () {

    Route::get('/reviews', [ReviewController::class, 'index'])
        ->name('mitra.reviews');

});


Route::get('/admin/reports/orders/pdf',
    [OrderReportController::class,'pdf'])
    ->name('admin.reports.orders.pdf');

Route::get('/admin/reports/orders/excel',
    [OrderReportController::class,'excel'])
    ->name('admin.reports.orders.excel');



// PENDAPATAN
Route::get('/admin/reports/income', [IncomeReportController::class, 'index'])->name('admin.reports.income');

Route::get('/admin/reports/income/pdf', [IncomeReportController::class, 'pdf'])->name('admin.reports.income.pdf');

Route::get('/admin/reports/income/excel', [IncomeReportController::class, 'excel'])->name('admin.reports.income.excel');

//MITRAS
Route::get(
    '/admin/reports/mitras/pdf',
    [MitraReportController::class,'pdf']
)->name('admin.reports.mitras.pdf');

Route::get(
    '/admin/reports/mitras/excel',
    [MitraReportController::class,'excel']
)->name('admin.reports.mitras.excel');

Route::get(
    '/admin/reports/customers/pdf',
    [CustomerReportController::class,'pdf']
)->name('admin.reports.customers.pdf');

Route::get(
    '/admin/reports/customers/excel',
    [CustomerReportController::class,'excel']
)->name('admin.reports.customers.excel');




//laporan role mitra


Route::middleware(['auth'])->group(function () {

    // Menu Laporan
    Route::get('/mitra/reports', [MitraLaporanController::class, 'index'])
        ->name('mitra.reports.index');

    // Laporan Pendapatan
    Route::get('/mitra/reports/income', [MitraLaporanController::class, 'income'])
        ->name('mitra.reports.income');

    Route::get('/mitra/reports/income/pdf', [MitraLaporanController::class, 'incomePdf'])
        ->name('mitra.reports.income.pdf');

    Route::get('/mitra/reports/income/excel', [MitraLaporanController::class, 'incomeExcel'])
        ->name('mitra.reports.income.excel');

    // Laporan Order
    Route::get('/mitra/reports/orders', [MitraLaporanController::class, 'orders'])
        ->name('mitra.reports.orders');

    // Laporan Review
    Route::get('/mitra/reports/reviews', [MitraLaporanController::class, 'reviews'])
        ->name('mitra.reports.reviews');

    // Laporan Pencairan
    Route::get('/mitra/reports/withdrawals', [MitraLaporanController::class, 'withdrawals'])
        ->name('mitra.reports.withdrawals');

});
// ===========================
// LAPORAN ORDER
// ===========================

Route::get(
    '/mitra/reports/orders',
    [MitraLaporanController::class,'orders']
)->name('mitra.reports.orders');

Route::get(
    '/mitra/reports/orders/pdf',
    [MitraLaporanController::class,'orderPdf']
)->name('mitra.reports.orders.pdf');

Route::get(
    '/mitra/reports/orders/excel',
    [MitraLaporanController::class,'orderExcel']
)->name('mitra.reports.orders.excel');

// ===============================
// LAPORAN RATING & REVIEW
// ===============================

Route::get(
    '/mitra/reports/reviews',
    [MitraLaporanController::class,'reviews']
)->name('mitra.reports.reviews');

Route::get(
    '/mitra/reports/reviews/pdf',
    [MitraLaporanController::class,'reviewPdf']
)->name('mitra.reports.reviews.pdf');

Route::get(
    '/mitra/reports/reviews/excel',
    [MitraLaporanController::class,'reviewExcel']
)->name('mitra.reports.reviews.excel');

// ==============================
// LAPORAN PENCAIRAN SALDO
// ==============================

Route::get(
    '/mitra/reports/withdrawals',
    [MitraLaporanController::class,'withdrawals']
)->name('mitra.reports.withdrawals');

Route::get(
    '/mitra/reports/withdrawals/pdf',
    [MitraLaporanController::class,'withdrawalPdf']
)->name('mitra.reports.withdrawals.pdf');

Route::get(
    '/mitra/reports/withdrawals/excel',
    [MitraLaporanController::class,'withdrawalExcel']
)->name('mitra.reports.withdrawals.excel');

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/customer/reports',
        [CustomerLaporanController::class, 'index']
    )->name('customer.reports.index');

    // LAPORAN ORDER
    Route::get(
        '/customer/reports/orders',
        [CustomerLaporanController::class, 'orders']
    )->name('customer.reports.orders');

    Route::get(
        '/customer/reports/orders/pdf',
        [CustomerLaporanController::class, 'orderPdf']
    )->name('customer.reports.orders.pdf');

    Route::get(
        '/customer/reports/orders/excel',
        [CustomerLaporanController::class, 'orderExcel']
    )->name('customer.reports.orders.excel');

    // LAPORAN PEMBAYARAN
    Route::get(
        '/customer/reports/payments',
        [CustomerLaporanController::class, 'payments']
    )->name('customer.reports.payments');

    Route::get(
        '/customer/reports/payments/pdf',
        [CustomerLaporanController::class, 'paymentPdf']
    )->name('customer.reports.payments.pdf');

    Route::get(
        '/customer/reports/payments/excel',
        [CustomerLaporanController::class, 'paymentExcel']
    )->name('customer.reports.payments.excel');

    // LAPORAN REVIEW
    Route::get(
        '/customer/reports/reviews',
        [CustomerLaporanController::class, 'reviews']
    )->name('customer.reports.reviews');

    Route::get(
        '/customer/reports/reviews/pdf',
        [CustomerLaporanController::class, 'reviewPdf']
    )->name('customer.reports.reviews.pdf');

    Route::get(
        '/customer/reports/reviews/excel',
        [CustomerLaporanController::class, 'reviewExcel']
    )->name('customer.reports.reviews.excel');

});
Route::middleware(['auth'])->group(function(){

    Route::get(
        '/notifikasi',
        [NotifikasiPelangganController::class,'index']
    )->name('pelanggan.notifications');

});

Route::middleware(['auth'])->group(function () {

    Route::post(
        '/orders/{id}/confirm',
        [OrderController::class,'confirmOrder']
    )->name('orders.confirm');

    Route::post(
        '/orders/{id}/complain',
        [OrderController::class,'complainOrder']
    )->name('orders.complain');

});
Route::middleware(['auth'])->group(function () {

    Route::get(
        '/orders/{id}/complaint',
        [ComplaintController::class, 'create']
    )->name('complaint.create');

    Route::post(
        '/orders/{id}/complaint',
        [ComplaintController::class, 'store']
    )->name('complaint.store');

});
Route::get(
    '/complaints/{id}',
    [ComplaintController::class,'show']
)->name('complaint.show');

Route::middleware(['auth'])
->group(function () {

    Route::get(

        '/admin/complaints',

        [App\Http\Controllers\Admin\ComplaintController::class,'index']

    )->name('admin.complaints');

});
Route::get(
    '/admin/complaints/{id}',
    [App\Http\Controllers\Admin\ComplaintController::class,'show']
)->name('admin.complaints.show');
// Route::post(
//     '/admin/complaints/{id}/resolve',
//     [ComplaintController::class, 'resolve']
// )->name('admin.complaints.resolve');

Route::post(
    '/admin/complaints/{id}/resolve',
    [App\Http\Controllers\Admin\ComplaintController::class, 'resolve']
)->name('admin.complaints.resolve');


Route::middleware(['auth'])->group(function () {

    Route::get(
        '/payment/{id}',
        [PaymentController::class,'show']
    )->name('payment.show');

});
Route::post('/pelanggan/payment/{id}/process', [CheckoutController::class, 'processPayment'])->name('pelanggan.payment.process');

Route::post('/checkout/save-payment-info', [CheckoutController::class, 'savePaymentInfo'])
    ->name('checkout.save-payment-info');



// PROSES REFUND


Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/refunds', [RefundController::class, 'index'])
            ->name('admin.refunds');

        Route::get('/refunds/{id}', [RefundController::class, 'show'])
            ->name('admin.refunds.show');

        Route::post('/refunds/{id}/process', [RefundController::class, 'process'])
            ->name('admin.refunds.process');

    });
// Route::get('/orders/{id}/work-proof', [OrderController::class, 'showWorkProof']);
// Route::post('/orders/{id}/work-proof', [OrderController::class, 'storeWorkProof']);

// Hapus salah satu yang duplikat, jadikan seperti ini:
Route::get('/orders/{id}/work-proof', [OrderController::class, 'showWorkProof']);
Route::post('/orders/{id}/work-proof', [OrderController::class, 'storeWorkProof']);
Route::get('/orders/{id}/work-proof/detail', [OrderController::class, 'workProofDetail']);


// Route::middleware(['auth'])->group(function () {

//     Route::get(
//         '/mitra/complaints/{id}',
//         [ComplaintController::class, 'showMitra']
//     )->name('mitra.complaints.show');

// });
Route::middleware(['auth'])->group(function () {

    Route::get(
        '/mitra/complaints/{id}',
        [ComplaintController::class, 'showMitra']
    )->name('mitra.complaints.show');

    Route::post(
        '/mitra/complaints/{id}/response',
        [ComplaintController::class, 'responseMitra']
    )->name('mitra.complaints.response');



});
Route::middleware(['auth', 'role:pelanggan'])->group(function () {

    Route::get(
        '/saldo-pelanggan',
        [CustomerBalanceController::class, 'index']
    )->name('customer.balance');

});