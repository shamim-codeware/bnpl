<?php

use App\Service\ApiService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmiController;
use App\Http\Controllers\ErpController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EnqueryController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\ShowRoomController;
use App\Http\Controllers\UpazillaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CreditScorController;
use App\Http\Controllers\DueEnquiryController;
use App\Http\Controllers\EnquiryTypeController;
use App\Http\Controllers\PackageItemController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\CustomerInfoController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\HirePurchaseController;
use App\Http\Controllers\InterestRateController;
use App\Http\Controllers\PurchaseModeController;
use App\Http\Controllers\ShowRoomUserController;
use App\Http\Controllers\EnquirySourceController;
use App\Http\Controllers\EnquiryStatusController;
use App\Http\Controllers\GuaranterInfoController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ExternalReportController;
use App\Http\Controllers\FollowUpMethodController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\PaymentCollectionController;
use App\Http\Controllers\CustomerProfessionController;
use App\Http\Controllers\DownPaymentSettingController;
use App\Http\Controllers\ExportHirepurchaseController;
use App\Http\Controllers\IncentiveConfigurationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('test-api', function (ApiService $ApiService) {
    $installment_no = 2;
    $data =  $ApiService->FineApi("BNPLR0070", 1000, $installment_no);
});

Route::get('user-marge', [DashboardController::class, 'userMarge']);
Route::get('clear', function () {
    Artisan::call('cache:clear');
    // echo "Cache cleared
    Artisan::call('view:clear');
    // echo "View cleared
    Artisan::call('config:cache');
    // echo "Config cleared
    Artisan::call('route:cache');
    // echo "Route cleared
    \dd("done");
});

Route::get('api-marge', [HirePurchaseController::class, 'apiMarge']);
Route::get('installment', function () {
    $title = "Customer Type";
    $description = "Some description for the page";
    return view('installment.test.index', compact("title", "description"));
});
// Route::get('installment/credit-score/steps',function(){
//    $title = "Customer Type";
//         $description = "Some description for the page";
//   return view('installment.credit_score.steps',compact("title","description"));
// });
// Route::get('installment/hire-purchase/application',function(){
//    $title = "Customer Type";
//         $description = "Some description for the page";
//   return view('installment.hire_purchase.application',compact("title","description"));
// });
Route::get('installment/guaranter', function () {
    $title = "Customer Type";
    $description = "Some description for the page";
    return view('installment.guaranter.guaranter', compact("title", "description"));
});

// Route::get('installment-list',function(){
//    $title = "Customer Type";
//         $description = "Some description for the page";
//   return view('installment_list',compact("title","description"));
// });

Route::get('installment/product/details', function () {
    $title = "Customer Type";
    $description = "Some description for the page";
    return view('installment.product_details.details', compact("title", "description"));
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forget_password');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('payment/colllection', function () {
        $title = "Customer Type";
        $description = "Some description for the page";
        return view('installment.payment.payment_collection', compact("title", "description"));
    });

    Route::get('/generate-notifications', [NotificationsController::class, 'GenerateNotification']);

    //Route::get('/due-enquery',[DueEnquiryController::class]);
    Route::get('home', [DashboardController::class, 'index'])->name('home');
    Route::match(['get', 'post'], 'marquee-notifications', [DashboardController::class, 'getTransactionMarquee'])
        ->name('home-notifications');
    //  Route::get('enquiry', [EnquiryController::class, 'index'])->name('enquiry');
    Route::get('notifications', [NotificationsController::class, 'notifications'])->name('notifications');
    Route::get('clear-all', [NotificationsController::class, 'ClearAll'])->name('clearAll');
    Route::get('notifications-details/{id}/{notification_id}', [NotificationsController::class, 'NotificaionDetails']);

    Route::get('pre-booking',           [EnquiryController::class, 'preBooking'])->name('pre-booking');
    Route::post('store-enquiry',        [EnquiryController::class, 'Store']);
    Route::post('customer-enquiry',     [EnquiryController::class, 'CustomerEnquiry']);
    Route::post('source-awareness',     [EnquiryController::class, 'SourcesOfAwreness']);
    Route::post('find-upazila',         [ShowRoomController::class, 'FindUpazila']);
    Route::get('follow-up',             [FollowUpController::class, 'index'])->name('follow-up');
    Route::get('attend-follow-up/{id}', [FollowUpController::class, 'show']);
    Route::post('child-status',         [FollowUpController::class, 'ChildStatus']);
    Route::post('update-follow/{id}',   [FollowUpController::class, 'update']);
    // User
    Route::get('user/profile/{id}',         [UserController::class, 'Profile'])->name('user.profile');
    Route::post('user/profile-update/{id}', [UserController::class, 'UpdateProfile'])->name('user.profile.update');
    Route::get('change-password/{id}',      [UserController::class, 'ChangePassword']);
    Route::post('update-password',          [UserController::class, 'UpdatePassword'])->name('password.update');

    Route::get('user-pass-change/{id}',      [UserController::class, 'UserPasswordChange'])->name('password.change');
    Route::post('update-password-user/{id}',  [UserController::class, 'UpdatePasswordUser'])->name('password.update.user');
    // Enquiry status parent assign
    Route::get('enquiry-status-setting',        [EnquiryStatusController::class, 'statusSetting'])->name('enquiry-status-settings');
    Route::post('enquiry-status-parent-assign', [EnquiryStatusController::class, 'parentAssign'])->name('parent-assign');
    Route::get('status-type/{type_id}',         [EnqueryController::class, 'statusType'])->name('status-type');
    // Role Permission

    Route::get('source-permission',     [RoleController::class, 'SourcePermission'])->name('source-permission');
    Route::get('check-permission/{user_id}',          [RoleController::class, 'CehckPermission'])->name('check-permission');
    Route::post('source-assign', [RoleController::class, 'SourceAssign']);

    Route::get('menu-permission',          [RoleController::class, 'menuPermission'])->name('menu-permission');
    Route::get('menu-assign/{role_id}',    [RoleController::class, 'menuAssign'])->name('menu-assign');
    Route::post('menu-permission-assign',  [RoleController::class, 'menuPermissionAssign'])->name('menu-permission-assign');

    Route::get('menu-entry',  [RoleController::class, 'menu_entry']);
    // All resources route here

    Route::get('user-export', [UserController::class, 'export'])->name('user.export');
    Route::get('user-export-active', [UserController::class, 'Activeexport'])->name('active.user.export');

    Route::get('customer-export', [CustomerController::class, 'export']);
    Route::get('passed-over-enquiries-export', [EnqueryController::class, 'Passedexport']);
    Route::get('showroom-export', [ShowRoomController::class, 'ShowroomExport']);
    Route::get('enquiry-export', [EnqueryController::class, 'export'])->name('enquiry.export');
    Route::get('pending-enquiries-export', [EnqueryController::class, 'PendingEnquiryExport']);

    //erp Api View

    Route::get('unsent-erp-list', [ErpController::class, 'UnsendErpList'])->name('unsent.erp.list');

    Route::get('erp-view/{id}', [ErpController::class, 'ErpView']);
    Route::get('sale-cancel/{id}', [ErpController::class, 'SaleCancel']);
    Route::post('cancel-action/{id}', [ErpController::class, 'CancelAction']);
    Route::post('resend-erp', [ErpController::class, 'ResendErp']);
    //Hire Purchase Export
    Route::get('hire-purchase-export', [ExportHirepurchaseController::class, 'export'])->name('hire-purchase.export');
    Route::get('all-bnpl-list-export', [ExportHirepurchaseController::class, 'Allexport'])->name('all-bnpl-purchase.export');
    Route::get('current-outstanding-export', [ExportHirepurchaseController::class, 'currentOutstandingExport'])->name('current-outstanding.export');
    Route::get('due-on-next-month-export', [ExportHirepurchaseController::class, 'dueOnNextMonthExport'])->name('due-on-next-month.export');

    //Transaction List Export
    Route::get('transaction-list-export', [PaymentCollectionController::class, 'TransactionListExport'])->name('transaction-list.export');

    Route::post('/calculate-amount', [PaymentCollectionController::class, 'calculateAmountBiaAjax']);
    //payment collection route
    Route::get('loan-details/{id}', [PaymentCollectionController::class, 'LoanDetails']);
    Route::post('payment-collection', [PaymentCollectionController::class, 'PaymentCollection']);
    //Transaction List
    Route::get('transaction-list', [PaymentCollectionController::class, 'TransactionList']);
    Route::get('transaction-list-show', [PaymentCollectionController::class, 'TransactionListShow']);

    //pending Hire purchase List

    Route::get('pending-sales', [HirePurchaseController::class, 'PendingSale']);
    Route::get('sale-pending', [HirePurchaseController::class, 'SalePending']);

    Route::get('all-purchase-pending-action', [HirePurchaseController::class, 'PendingSaleView']);
    Route::get('all-purchase-sale-pending-action', [HirePurchaseController::class, 'SalePendingView']);

    Route::get('edit', [HirePurchaseController::class, 'PendingSale']);

    Route::get('approve-sale/{id}', [HirePurchaseController::class, 'ApproveSale']);
    Route::post('reject-sale/{id}', [HirePurchaseController::class, 'RejectSale']);

    //installment list

    Route::get('installment-list/{id}', [HirePurchaseController::class, 'InstallmentList']);

    Route::get('/incentive-configuration-status/{id}', [IncentiveConfigurationController::class, 'toggleStatus'])
        ->name('incentive-configuration.status');
    Route::post('/general-incentive-config', [IncentiveConfigurationController::class, 'storeGeneralConfig'])->name('general-incentive-config.store');

    Route::middleware(['check.permission'])->group(function () {
        Route::resources([
            'enquiry-type'        => EnquiryTypeController::class,
            'enquiry-source'      => EnquirySourceController::class,
            'customer-type'       => CustomerTypeController::class,
            'purchase-mode'       => PurchaseModeController::class,
            'follow-up-method'    => FollowUpMethodController::class,
            'enquiry-status'      => EnquiryStatusController::class,
            'zones'               => ZoneController::class,
            'show-rooms'          => ShowRoomController::class,
            'enquiry'             => EnqueryController::class,
            'roles'               => RoleController::class,
            'customer'            => CustomerController::class,
            'user'                => UserController::class,
            'customer-profession' => CustomerProfessionController::class,
            'upazila'             => UpazillaController::class,
            'product'             => ProductController::class,
            'package'             => PackageController::class,
            'package-product'     => PackageItemController::class,
            'category'            => ProductCategoryController::class,
            'brand'               => BrandController::class,
            'sizes'               => SizeController::class,
            'group'               => ProductTypeController::class,
            'incentive-configuration'    => IncentiveConfigurationController::class,
            'menus'               => MenuController::class,
            'credit-score'        => CreditScorController::class,
            'hire-purchase'       => HirePurchaseController::class,
            'guarantor'           => GuaranterInfoController::class,
            'show-room-user'      => ShowRoomUserController::class,
            'down-payment-settings' => DownPaymentSettingController::class,
            'interest-rate'       => InterestRateController::class,
            'banks'               => BankController::class,
        ]);

        //Report Controller
        Route::get('monthly-report', [ReportController::class, 'MonthlyReport']);

        Route::get('due-on-next-month', [ReportController::class, 'DueOnNextmonth']);
        Route::get('installment-penalty', [PenaltyController::class, 'index'])->name('penalty.index');
        Route::post('installment-penalty/post', [PenaltyController::class, 'store'])->name('penalty.store');
        //Full Paid Customer
        Route::get('full-paid-customer',          [ReportController::class, 'fullPaidCustomer']);
        Route::get('current-outstanding',         [ReportController::class, 'currentOutstanding']);
        Route::get('zone-overview',               [ReportController::class, 'zoneOverview']);
        Route::get('showroom-credit',             [CreditScorController::class, 'showroomCredit'])->name('showroom.credit');

        //external Report alist
        Route::get('cancelled-bnpl-sales', [ExternalReportController::class, 'CancelBnplSale'])->name('cancelled-bnpl-sales');

        Route::get('incentive-report', [ExternalReportController::class, 'IncentiveReport'])->name('incentive-report');

        //all Bnpl
        Route::get('all-bnpl-orders', [ExternalReportController::class, 'AllBnplSale'])->name('all-bnpl-sales');
        //Defaulter Report
        Route::get('defaulter-customers', [ExternalReportController::class, 'DefaulterReport'])->name('defaulter-report');
    });

    Route::get('all-bnpl-sales-action', [ExternalReportController::class, 'AllBnplSaleAction'])->name('all-bnpl-sales-action');
    Route::get('all-bnpl-sales-export', [ExternalReportController::class, 'AllBnplSaleExport'])->name('all-bnpl-sales-export');


    Route::get('defaulter-report-action', [ExternalReportController::class, 'DefaulterReportAction'])->name('defaulter-report-action');
    Route::get('defaulter-report-export', [ExternalReportController::class, 'DefaulterReportExport'])->name('defaulter-report-export');


    Route::get('cancelled-bnpl-sales-action', [ExternalReportController::class, 'CancelBnplSaleAction'])->name('cancelled-bnpl-sales-action');
    Route::get('cancelled-bnpl-sales-export', [ExternalReportController::class, 'CancelBnplSaleExport'])->name('cancelled-bnpl-sales-export');

    Route::get('incentive-report-action', [ExternalReportController::class, 'IncentiveReportAction'])->name('incentive-report-action');
    Route::get('incentive-report-export', [ExternalReportController::class, 'IncentiveReportExport'])->name('incentive-report-export');
    //Report Action
    Route::get('monthly-report', function () {
        $title = "Monthly Report";
        $description = "Monthly Report for BNPL orders";
        return view('report.monthly_report', compact("title", "description"));
    });
    Route::get('monthly-report-action', [ReportController::class, 'MonthlyReportAction']);
    Route::post('showroom-credit', [CreditScorController::class, 'showroomCreditStore'])->name('showroom.credit.store');
    Route::get('full-paid-customer-details', [ReportController::class, 'getFullPaidCustomer']);
    Route::get('current-outstanding-details', [ReportController::class, 'getCurrentOutstanding']);
    Route::get('due-on-next-month-get-data', [ReportController::class, 'DueOnNextmonthGetData']);
    Route::get('zone-overview-get-data', [ReportController::class, 'zoneOverviewGetData']);

    //Emi Calculatorcredit-score
    Route::get('emi-calculator', [EmiController::class, 'index']);
    Route::get('calculate-data/{id}', [EmiController::class, 'Calculation']);

    //show room credit
    Route::get('show-room-credit', [ShowRoomController::class, 'ShowRoomCredit'])->name('show-room-credit');
    Route::get('view-customer-info/{id}', [HirePurchaseController::class, 'show']);
    //show room permission
    // Role Permission
    Route::get('zone-permission',  [RoleController::class, 'ZonePermission'])->name('zone-permission');
    Route::post('zone-assign', [RoleController::class, 'ZoneAssign']);

    Route::get('check-zone-permission/{user_id}',          [RoleController::class, 'CehckZonePermission'])->name('check-zone-permission');
    //purchase list
    Route::get('all-purchase-action', [HirePurchaseController::class, 'AllPurchaseAction']);
    Route::get('all-purchase', [HirePurchaseController::class, 'AllPurchase']);
    //guarantor info
    Route::get('view-guarantor-info/{id}', [GuaranterInfoController::class, 'ViewGuarantor']);
    // Route::get('view-guarantor-info/{id}',[GuaranterInfoController::class,'ViewGuarantor']);
    //notifications seen
    Route::get('notificatoins-seen/{id}', [NotificationsController::class, 'NotificationSeen']);
    //product details
    Route::get('product_details/{id}', [HirePurchaseController::class, 'ProductDetails']);
    Route::get('hire-purchase-product-edit/{id}', [HirePurchaseController::class, 'Product_edit']);
    Route::post('hire-purchase-product-update/{id}', [HirePurchaseController::class, 'Product_update']);

    Route::get('product_edit/{id}', [HirePurchaseController::class, 'HirepurchaseEdit']);

    Route::post('product_update', [HirePurchaseController::class, 'HirepurchaseUpdate']);
    //get pr+ice
    Route::post('get-price', [ProductController::class, 'GetPrice']);
    //get zone credit
    Route::get('get-credit', [ZoneController::class, 'getCredit']);


    Route::get('active-user-manager', [UserController::class, 'ActiveUserManager'])->name('user.active.manager');
    Route::get('active-user-executive', [UserController::class, 'ActiveUserExecutive'])->name('user.active.executive');
    Route::get('active-user-admin', [UserController::class, 'ActiveUserAdmin'])->name('user.active.admin');
    // Enquiry settings
    Route::get('/enquiry-status-settings', [EnquiryStatusController::class, 'statusSetting'])->name('enquiry-status-setting');
    // Ajax enquiry
    Route::get('enquiries',             [EnqueryController::class, 'enquiries'])->name('enquiries');
    Route::get('passed-over',           [EnqueryController::class, 'passedOver'])->name('passed-over');
    Route::get('pending-enquiry',       [EnqueryController::class, 'Pending'])->name('pending-enquiry');
    Route::get('pending-enquiries',   [EnqueryController::class, 'PendingEnquiry'])->name('pending-enquiries');
    Route::get('passed-over-enquiries', [EnqueryController::class, 'passedOverEnquiries'])->name('passed-over-enquiries');
    Route::post('select-executive',     [EnquiryController::class, 'SelectExecutive']);
    Route::post('select-showroom',      [DashboardController::class, 'SelectShowroom']);
    Route::post('todays-followup',      [DashboardController::class, 'TodaysfollowUp']);
    Route::any('enquiry-statistics', [DashboardController::class, 'EnquiryStatistics']);
    Route::post('source-statistics', [DashboardController::class, 'SourceStatistics']);
    Route::get('collection-chart-data', [DashboardController::class, 'getCollectionChartData']);

    Route::post('query-type',      [ProductTypeController::class, 'QueryType']);
    Route::post('query-category',      [ProductCategoryController::class, 'QueryCategory']);
    Route::post('query-product',      [ProductController::class, 'QueryProduct']);
    Route::post('/check-status', [FollowUpController::class, 'StatusCheck']);
    Route::post('/check-status-all', [FollowUpController::class, 'CheckStatusAll']);

    // Status
    Route::get('enquiry-type-status/{id}',        [EnquiryTypeController::class, 'status'])->name('enquiry-type-status');
    Route::get('enquiry-source-status/{id}',      [EnquirySourceController::class, 'status'])->name('enquiry-source-status');
    Route::get('purchase-mode-status/{id}',       [PurchaseModeController::class, 'status'])->name('purchase-mode-status');
    Route::get('follow-up-method-status/{id}',    [FollowUpMethodController::class, 'status'])->name('follow-up-method-status');
    Route::get('customer-profession-status/{id}', [CustomerProfessionController::class, 'status'])->name('customer-profession-status');
    Route::get('customer-status/{id}',            [CustomerController::class, 'status'])->name('customer-status');
    Route::get('zone-status/{id}',                [ZoneController::class, 'status'])->name('zone-status');
    Route::get('role-status/{id}',                [RoleController::class, 'status'])->name('role-status');
    Route::get('user-status/{id}',                [UserController::class, 'status'])->name('user-status');
    Route::get('showroom-status/{id}',            [ShowRoomController::class, 'status'])->name('showroom-status');
    Route::get('product-status/{id}',            [ProductController::class, 'status'])->name('product-status');
    Route::get('data-backup', [BackupController::class, 'DataBackup']);
    Route::get('backup-product', [BackupController::class, 'DataProductBackup']);
});

Route::get('/lang/{lang}', [LanguageController::class, 'switchLang'])->name('switch_lang');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::post('/api/save-draft', [HirePurchaseController::class, 'saveDraft'])->name('save-draft');
Route::get('/api/load-draft', [HirePurchaseController::class, 'loadDraft'])->name('load-draft');

Route::get('/api/packages/{id}/items', [PackageItemController::class, 'getPackageItems'])->name('packages.items');
