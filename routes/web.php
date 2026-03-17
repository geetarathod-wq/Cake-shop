<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WebhookController;

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\WalkInOrderController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/search', [ProductController::class, 'search'])->name('search.products');

/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| 3. PAYMENT VERIFICATION
|--------------------------------------------------------------------------
*/

Route::post('/payment/verify', [CheckoutController::class, 'verifyPayment'])
    ->name('payment.verify');

/*
|--------------------------------------------------------------------------
| 4. CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    /* Cart */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/update-cart', [CartController::class, 'update'])->name('update.cart');
    Route::post('/update-cart-weight', [CartController::class, 'updateWeight'])->name('update.cart.weight');
    Route::delete('/remove-from-cart/{cartKey}', [CartController::class, 'remove'])->name('remove.from.cart');

    /* Checkout */
    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->middleware('throttle:1000,1')
        ->name('checkout.store');
    Route::get('/order/success/{order}', [CheckoutController::class, 'success'])
        ->name('order.success');

    /* Customer Orders */
    Route::get('/my-orders', [CustomerOrderController::class, 'index'])
        ->name('customer.orders');
    Route::get('/order/{order}', [CustomerOrderController::class, 'show'])
        ->name('order.details');
    Route::get('/track-order/{order}', [CustomerOrderController::class, 'track'])
        ->name('order.track');
});

/*
|--------------------------------------------------------------------------
| 5. ADMIN PANEL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |---------------------------
        | Dashboard
        |---------------------------
        */
        Route::get('/dashboard', [OrderController::class, 'dashboardStats'])
            ->name('dashboard');

        /*
        |---------------------------
        | Orders
        |---------------------------
        */
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');
        Route::patch('/orders/{order}', [OrderController::class, 'update'])
            ->name('orders.update');

        /*
        |---------------------------
        | Export Orders (Excel/PDF)
        |---------------------------
        */
        Route::get('/reports/export/pdf', [ReportController::class, 'exportPDF'])->name('reports.export.pdf');
        Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');

        /*
        |---------------------------
        | Products & Categories
        |---------------------------
        */
        Route::resource('products', AdminProductController::class)->except('show');
        Route::resource('categories', AdminCategoryController::class)->except('show');
        Route::get('/categories/{category}/products', [AdminCategoryController::class, 'products'])
            ->name('categories.products');

        /*
        |---------------------------
        | Walk-In Orders
        |---------------------------
        */
        Route::resource('walkin-orders', WalkInOrderController::class);

        /*
        |---------------------------
        | Settings
        |---------------------------
        */
        Route::get('/settings', [SettingsController::class, 'index'])
            ->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])
            ->name('settings.update');

        /*
        |---------------------------
        | Reports
        |---------------------------
        */
        Route::prefix('reports')->name('reports.')->group(function () {

            Route::get('/', [ReportController::class, 'index'])->name('index');

            /* Sales */
            Route::get('/daily-sales', [ReportController::class, 'dailySales'])->name('daily');
            Route::get('/monthly-sales', [ReportController::class, 'monthlySales'])->name('monthly');

            /* Product */
            Route::get('/product-wise', [ReportController::class, 'productWise'])->name('product-wise');
            Route::get('/product-sales', [ReportController::class, 'productWise'])->name('product-sales');
            Route::get('/category-wise', [ReportController::class, 'categoryWise'])->name('category-wise');
            Route::get('/category-sales', [ReportController::class, 'categoryWise'])->name('category-sales');
            Route::get('/top-products', [ReportController::class, 'topProducts'])->name('top-products');
            Route::get('/low-products', [ReportController::class, 'lowProducts'])->name('low-products');

            /* Orders */
            Route::get('/order-summary', [ReportController::class, 'orderSummary'])->name('order-summary');
            Route::get('/custom-cakes', [ReportController::class, 'customCakes'])->name('custom-cakes');
            Route::get('/custom-orders', [ReportController::class, 'customCakes'])->name('custom-orders');
            Route::get('/order-type', [ReportController::class, 'orderTypeComparison'])->name('order-type');
            Route::get('/delivery-pickup', [ReportController::class, 'deliveryPickup'])->name('delivery-pickup');
            Route::get('/delivery-orders', [ReportController::class, 'deliveryOrders'])->name('delivery-orders');
            Route::get('/pickup-orders', [ReportController::class, 'pickupOrders'])->name('pickup-orders');

            /* Customer */
            Route::get('/top-customers', [ReportController::class, 'topCustomers'])->name('top-customers');
            Route::get('/customer-history/{customer?}', [ReportController::class, 'customerHistory'])->name('customer-history');
            Route::get('/new-returning', [ReportController::class, 'newReturning'])->name('new-returning');
            Route::get('/customer-frequency', [ReportController::class, 'customerFrequency'])->name('customer-frequency');

            /* Inventory */
            Route::get('/inventory/usage', [ReportController::class, 'inventoryUsage'])->name('inventory.usage');
            Route::get('/material-usage', [ReportController::class, 'inventoryUsage'])->name('material-usage');
            Route::get('/inventory/low-stock', [ReportController::class, 'lowStock'])->name('inventory.low-stock');
            Route::get('/low-stock', [ReportController::class, 'lowStock'])->name('low-stock');
            Route::get('/inventory/movement', [ReportController::class, 'stockMovement'])->name('inventory.movement');
            Route::get('/stock-movement', [ReportController::class, 'stockMovement'])->name('stock-movement');

            /* Financial */
            Route::get('/financial/profit', [ReportController::class, 'profitMargin'])->name('profit');
            Route::get('/profit-margin', [ReportController::class, 'profitMargin'])->name('profit-margin');
            Route::get('/financial/discounts', [ReportController::class, 'discountReport'])->name('discounts');
            Route::get('/discount-report', [ReportController::class, 'discountReport'])->name('discount-report');
            Route::get('/financial/payment-methods', [ReportController::class, 'paymentMethods'])->name('payment-methods');

            /* Walk-in Customers */
            Route::get('/walkin-customers', [ReportController::class, 'walkinCustomers'])->name('walkin-customers');
        });
    });

/*
|--------------------------------------------------------------------------
| 6. RAZORPAY WEBHOOK
|--------------------------------------------------------------------------
*/

Route::post('/razorpay-webhook', [WebhookController::class, 'handleRazorpayWebhook'])
    ->withoutMiddleware([App\Http\Middleware\VerifyCsrfToken::class]);