<?php

use App\Http\Controllers\ActivationController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\UserInterfaceController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\PageLayoutController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FunctionController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\NumberAssigner;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\VerificationController;

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

// Main Page Route
Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('home')->middleware('auth');


/* Route Dashboards */
Route::group(['prefix' => 'dashboard'], function () {
    Route::get('analytics', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics');
    Route::get('ecommerce', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard-ecommerce');
});
/* Route Dashboards */

/* Route Apps */
Route::group(['prefix' => 'app'], function () {
    Route::get('email', [AppsController::class, 'emailApp'])->name('app-email');
    Route::get('chat', [AppsController::class, 'chatApp'])->name('app-chat');
    Route::get('todo', [AppsController::class, 'todoApp'])->name('app-todo');
    Route::get('calendar', [AppsController::class, 'calendarApp'])->name('app-calendar');
    Route::get('kanban', [AppsController::class, 'kanbanApp'])->name('app-kanban');
    Route::get('invoice/list', [AppsController::class, 'invoice_list'])->name('app-invoice-list');
    Route::get('invoice/preview', [AppsController::class, 'invoice_preview'])->name('app-invoice-preview');
    Route::get('invoice/edit', [AppsController::class, 'invoice_edit'])->name('app-invoice-edit');
    Route::get('invoice/add', [AppsController::class, 'invoice_add'])->name('app-invoice-add');
    Route::get('invoice/print', [AppsController::class, 'invoice_print'])->name('app-invoice-print');
    Route::get('ecommerce/shop', [AppsController::class, 'ecommerce_shop'])->name('app-ecommerce-shop');
    Route::get('ecommerce/details', [AppsController::class, 'ecommerce_details'])->name('app-ecommerce-details');
    Route::get('ecommerce/wishlist', [AppsController::class, 'ecommerce_wishlist'])->name('app-ecommerce-wishlist');
    Route::get('ecommerce/checkout', [AppsController::class, 'ecommerce_checkout'])->name('app-ecommerce-checkout');
    Route::get('file-manager', [AppsController::class, 'file_manager'])->name('app-file-manager');
    Route::get('access-roles', [AppsController::class, 'access_roles'])->name('app-access-roles');
    Route::get('access-permission', [AppsController::class, 'access_permission'])->name('app-access-permission');
    Route::get('user/list', [AppsController::class, 'user_list'])->name('app-user-list');
    Route::get('user/view/account', [AppsController::class, 'user_view_account'])->name('app-user-view-account');
    Route::get('user/view/security', [AppsController::class, 'user_view_security'])->name('app-user-view-security');
    Route::get('user/view/billing', [AppsController::class, 'user_view_billing'])->name('app-user-view-billing');
    Route::get('user/view/notifications', [AppsController::class, 'user_view_notifications'])->name('app-user-view-notifications');
    Route::get('user/view/connections', [AppsController::class, 'user_view_connections'])->name('app-user-view-connections');
});
/* Route Apps */

/* Route UI */
Route::group(['prefix' => 'ui'], function () {
    Route::get('typography', [UserInterfaceController::class, 'typography'])->name('ui-typography');
});
/* Route UI */

/* Route Icons */
Route::group(['prefix' => 'icons'], function () {
    Route::get('feather', [UserInterfaceController::class, 'icons_feather'])->name('icons-feather');
});
/* Route Icons */

/* Route Cards */
Route::group(['prefix' => 'card'], function () {
    Route::get('basic', [CardsController::class, 'card_basic'])->name('card-basic');
    Route::get('advance', [CardsController::class, 'card_advance'])->name('card-advance');
    Route::get('statistics', [CardsController::class, 'card_statistics'])->name('card-statistics');
    Route::get('analytics', [CardsController::class, 'card_analytics'])->name('card-analytics');
    Route::get('actions', [CardsController::class, 'card_actions'])->name('card-actions');
});
/* Route Cards */

/* Route Components */
Route::group(['prefix' => 'component'], function () {
    Route::get('accordion', [ComponentsController::class, 'accordion'])->name('component-accordion');
    Route::get('alert', [ComponentsController::class, 'alert'])->name('component-alert');
    Route::get('avatar', [ComponentsController::class, 'avatar'])->name('component-avatar');
    Route::get('badges', [ComponentsController::class, 'badges'])->name('component-badges');
    Route::get('breadcrumbs', [ComponentsController::class, 'breadcrumbs'])->name('component-breadcrumbs');
    Route::get('buttons', [ComponentsController::class, 'buttons'])->name('component-buttons');
    Route::get('carousel', [ComponentsController::class, 'carousel'])->name('component-carousel');
    Route::get('collapse', [ComponentsController::class, 'collapse'])->name('component-collapse');
    Route::get('divider', [ComponentsController::class, 'divider'])->name('component-divider');
    Route::get('dropdowns', [ComponentsController::class, 'dropdowns'])->name('component-dropdowns');
    Route::get('list-group', [ComponentsController::class, 'list_group'])->name('component-list-group');
    Route::get('modals', [ComponentsController::class, 'modals'])->name('component-modals');
    Route::get('pagination', [ComponentsController::class, 'pagination'])->name('component-pagination');
    Route::get('navs', [ComponentsController::class, 'navs'])->name('component-navs');
    Route::get('offcanvas', [ComponentsController::class, 'offcanvas'])->name('component-offcanvas');
    Route::get('tabs', [ComponentsController::class, 'tabs'])->name('component-tabs');
    Route::get('timeline', [ComponentsController::class, 'timeline'])->name('component-timeline');
    Route::get('pills', [ComponentsController::class, 'pills'])->name('component-pills');
    Route::get('tooltips', [ComponentsController::class, 'tooltips'])->name('component-tooltips');
    Route::get('popovers', [ComponentsController::class, 'popovers'])->name('component-popovers');
    Route::get('pill-badges', [ComponentsController::class, 'pill_badges'])->name('component-pill-badges');
    Route::get('progress', [ComponentsController::class, 'progress'])->name('component-progress');
    Route::get('spinner', [ComponentsController::class, 'spinner'])->name('component-spinner');
    Route::get('toast', [ComponentsController::class, 'toast'])->name('component-bs-toast');
});
/* Route Components */

/* Route Extensions */
Route::group(['prefix' => 'ext-component'], function () {
    Route::get('sweet-alerts', [ExtensionController::class, 'sweet_alert'])->name('ext-component-sweet-alerts');
    Route::get('block-ui', [ExtensionController::class, 'block_ui'])->name('ext-component-block-ui');
    Route::get('toastr', [ExtensionController::class, 'toastr'])->name('ext-component-toastr');
    Route::get('sliders', [ExtensionController::class, 'sliders'])->name('ext-component-sliders');
    Route::get('drag-drop', [ExtensionController::class, 'drag_drop'])->name('ext-component-drag-drop');
    Route::get('tour', [ExtensionController::class, 'tour'])->name('ext-component-tour');
    Route::get('clipboard', [ExtensionController::class, 'clipboard'])->name('ext-component-clipboard');
    Route::get('plyr', [ExtensionController::class, 'plyr'])->name('ext-component-plyr');
    Route::get('context-menu', [ExtensionController::class, 'context_menu'])->name('ext-component-context-menu');
    Route::get('swiper', [ExtensionController::class, 'swiper'])->name('ext-component-swiper');
    Route::get('tree', [ExtensionController::class, 'tree'])->name('ext-component-tree');
    Route::get('ratings', [ExtensionController::class, 'ratings'])->name('ext-component-ratings');
    Route::get('locale', [ExtensionController::class, 'locale'])->name('ext-component-locale');
});
/* Route Extensions */

/* Route Page Layouts */
Route::group(['prefix' => 'page-layouts'], function () {
    Route::get('collapsed-menu', [PageLayoutController::class, 'layout_collapsed_menu'])->name('layout-collapsed-menu');
    Route::get('full', [PageLayoutController::class, 'layout_full'])->name('layout-full');
    Route::get('without-menu', [PageLayoutController::class, 'layout_without_menu'])->name('layout-without-menu');
    Route::get('empty', [PageLayoutController::class, 'layout_empty'])->name('layout-empty');
    Route::get('blank', [PageLayoutController::class, 'layout_blank'])->name('layout-blank');
});
/* Route Page Layouts */

/* Route Forms */
Route::group(['prefix' => 'form'], function () {
    Route::get('input', [FormsController::class, 'input'])->name('form-input');
    Route::get('input-groups', [FormsController::class, 'input_groups'])->name('form-input-groups');
    Route::get('input-mask', [FormsController::class, 'input_mask'])->name('form-input-mask');
    Route::get('textarea', [FormsController::class, 'textarea'])->name('form-textarea');
    Route::get('checkbox', [FormsController::class, 'checkbox'])->name('form-checkbox');
    Route::get('radio', [FormsController::class, 'radio'])->name('form-radio');
    Route::get('custom-options', [FormsController::class, 'custom_options'])->name('form-custom-options');
    Route::get('switch', [FormsController::class, 'switch'])->name('form-switch');
    Route::get('select', [FormsController::class, 'select'])->name('form-select');
    Route::get('number-input', [FormsController::class, 'number_input'])->name('form-number-input');
    Route::get('file-uploader', [FormsController::class, 'file_uploader'])->name('form-file-uploader');
    Route::get('quill-editor', [FormsController::class, 'quill_editor'])->name('form-quill-editor');
    Route::get('date-time-picker', [FormsController::class, 'date_time_picker'])->name('form-date-time-picker');
    Route::get('layout', [FormsController::class, 'layouts'])->name('form-layout');
    Route::get('wizard', [FormsController::class, 'wizard'])->name('form-wizard');
    Route::get('validation', [FormsController::class, 'validation'])->name('form-validation');
    Route::get('repeater', [FormsController::class, 'form_repeater'])->name('form-repeater');
});
/* Route Forms */

/* Route Tables */
Route::group(['prefix' => 'table'], function () {
    Route::get('', [TableController::class, 'table'])->name('table');
    Route::get('datatable/basic', [TableController::class, 'datatable_basic'])->name('datatable-basic');
    Route::get('datatable/advance', [TableController::class, 'datatable_advance'])->name('datatable-advance');
});
/* Route Tables */

/* Route Pages */
Route::group(['prefix' => 'page'], function () {
    Route::get('account-settings-account', [PagesController::class, 'account_settings_account'])->name('page-account-settings-account');
    Route::get('account-settings-security', [PagesController::class, 'account_settings_security'])->name('page-account-settings-security');
    Route::get('account-settings-billing', [PagesController::class, 'account_settings_billing'])->name('page-account-settings-billing');
    Route::get('account-settings-notifications', [PagesController::class, 'account_settings_notifications'])->name('page-account-settings-notifications');
    Route::get('account-settings-connections', [PagesController::class, 'account_settings_connections'])->name('page-account-settings-connections');
    Route::get('profile', [PagesController::class, 'profile'])->name('page-profile');
    Route::get('faq', [PagesController::class, 'faq'])->name('page-faq');
    Route::get('knowledge-base', [PagesController::class, 'knowledge_base'])->name('page-knowledge-base');
    Route::get('knowledge-base/category', [PagesController::class, 'kb_category'])->name('page-knowledge-base');
    Route::get('knowledge-base/category/question', [PagesController::class, 'kb_question'])->name('page-knowledge-base');
    Route::get('pricing', [PagesController::class, 'pricing'])->name('page-pricing');
    Route::get('api-key', [PagesController::class, 'api_key'])->name('page-api-key');
    Route::get('blog/list', [PagesController::class, 'blog_list'])->name('page-blog-list');
    Route::get('blog/detail', [PagesController::class, 'blog_detail'])->name('page-blog-detail');
    Route::get('blog/edit', [PagesController::class, 'blog_edit'])->name('page-blog-edit');

    // Miscellaneous Pages With Page Prefix
    Route::get('coming-soon', [MiscellaneousController::class, 'coming_soon'])->name('misc-coming-soon');
    Route::get('not-authorized', [MiscellaneousController::class, 'not_authorized'])->name('misc-not-authorized');
    Route::get('maintenance', [MiscellaneousController::class, 'maintenance'])->name('misc-maintenance');
    Route::get('license', [PagesController::class, 'license'])->name('page-license');
});

/* Modal Examples */
Route::get('/modal-examples', [PagesController::class, 'modal_examples'])->name('modal-examples');

/* Route Pages */
Route::get('/error', [MiscellaneousController::class, 'error'])->name('error');

/* Route Authentication Pages */
Route::group(['prefix' => 'auth'], function () {
    Route::get('login-basic', [AuthenticationController::class, 'login_basic'])->name('auth-login-basic');
    Route::get('login-cover', [AuthenticationController::class, 'login_cover'])->name('auth-login-cover');
    Route::get('register-basic', [AuthenticationController::class, 'register_basic'])->name('auth-register-basic');
    Route::get('register-cover', [AuthenticationController::class, 'register_cover'])->name('auth-register-cover');
    Route::get('forgot-password-basic', [AuthenticationController::class, 'forgot_password_basic'])->name('auth-forgot-password-basic');
    Route::get('forgot-password-cover', [AuthenticationController::class, 'forgot_password_cover'])->name('auth-forgot-password-cover');
    Route::get('reset-password-basic', [AuthenticationController::class, 'reset_password_basic'])->name('auth-reset-password-basic');
    Route::get('reset-password-cover', [AuthenticationController::class, 'reset_password_cover'])->name('auth-reset-password-cover');
    Route::get('verify-email-basic', [AuthenticationController::class, 'verify_email_basic'])->name('auth-verify-email-basic');
    Route::get('verify-email-cover', [AuthenticationController::class, 'verify_email_cover'])->name('auth-verify-email-cover');
    Route::get('two-steps-basic', [AuthenticationController::class, 'two_steps_basic'])->name('auth-two-steps-basic');
    Route::get('two-steps-cover', [AuthenticationController::class, 'two_steps_cover'])->name('auth-two-steps-cover');
    Route::get('register-multisteps', [AuthenticationController::class, 'register_multi_steps'])->name('auth-register-multisteps');
    Route::get('lock-screen', [AuthenticationController::class, 'lock_screen'])->name('auth-lock_screen');
});
/* Route Authentication Pages */

/* Route Charts */
Route::group(['prefix' => 'chart'], function () {
    Route::get('apex', [ChartsController::class, 'apex'])->name('chart-apex');
    Route::get('chartjs', [ChartsController::class, 'chartjs'])->name('chart-chartjs');
    Route::get('echarts', [ChartsController::class, 'echarts'])->name('chart-echarts');
});
/* Route Charts */

// map leaflet
Route::get('/maps/leaflet', [ChartsController::class, 'maps_leaflet'])->name('map-leaflet');

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

Route::get('login', [AuthenticationController::class, 'login_cover'])->name('login');
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::post('auth-login', [AuthenticationController::class, 'login'])->name('auth.login');



Route::group(['prefix' => 'admin','middleware'=>'auth'], function () {
    //    ROLE
    Route::get('role', [AdminController::class, 'role'])->name('role');
    Route::post('role-add', [AdminController::class, 'roleadd'])->name('role.add');
    //    ROLE
    //    Product
    Route::get('product', [AdminController::class, 'product'])->name('product');
    Route::post('product-add', [AdminController::class, 'productadd'])->name('product.add');
    Route::get('product-edit/{id}', [AdminController::class, 'product_edit'])->name('product.edit');
    Route::post('product-edit-update', [AdminController::class, 'productedit'])->name('product.edit.update');
    //    Product
    Route::get('plans', [AdminController::class, 'plans'])->name('plan');
    Route::get('plan-edit/{id}', [AdminController::class, 'plan_edit'])->name('plan.edit');
    Route::post('plan-add', [AdminController::class, 'planadd'])->name('plan.add');
    Route::post('plan-edit-update', [AdminController::class, 'planedit'])->name('plan.edit.update');
    //    Users
    Route::get('users', [AdminController::class, 'users'])->name('users');
    Route::get('users-edit/{id}', [AdminController::class, 'users_edit'])->name('user.edit');
    Route::post('users-add', [AdminController::class, 'usersadd'])->name('user.add');
    Route::post('users-edit-update', [AdminController::class, 'usersedit'])->name('user.edit.update');
    Route::get('DeleteUser/{id}', [AdminController::class, 'DeleteUser'])->name('user.destroy');

    //    Users
    Route::get('call-center', [AdminController::class, 'call_center'])->name('call.center');
    Route::get('call-center-edit/{id}', [AdminController::class, 'call_center_edit'])->name('call.center.edit');
    Route::post('call-center-add', [AdminController::class, 'cc_add'])->name('cc.add');
    Route::post('call-center-edit-update', [AdminController::class, 'cc_edit'])->name('cc.edit.update');
    //    Users
    Route::get('view-all-leads', [LeadController::class, 'AllLeads'])->name('all.leads');
    Route::get('view-wifi-leads', [LeadController::class, 'ViewWifiLead'])->name('wifi.leads');
    Route::get('view-inprocess-leads', [LeadController::class, 'ViewInProcessLead'])->name('ViewInProcessLead');
    Route::get('add-home-wifi', [LeadController::class, 'HomeWifiForm'])->name('HomeWifiForm');
    Route::get('add-new', [LeadController::class, 'AddNewForm'])->name('AddNewForm');
    Route::post('home-wifi-submit', [LeadController::class, 'HomeWifiSubmit'])->name('HomeWifiSubmit');
    Route::post('new-lead-submit', [LeadController::class, 'NewLeadSubmit'])->name('NewLeadSubmit');
    //
    Route::post('ocr_name_new', [FunctionController::class, 'ocr_name_new'])->name('ocr-name.submit');
    //
    Route::get('SendWhatsApp', [FunctionController::class, 'SendWhatsApp'])->name('SendWhatsApp');
    //
    Route::get('training', [TrainingController::class, 'training'])->name('training');
    Route::get('training-edit/{id}', [TrainingController::class, 'training_edit'])->name('training.edit');
    Route::post('training-add', [TrainingController::class, 'trainingadd'])->name('training.add');
    Route::post('training-edit-update', [TrainingController::class, 'trainingedit'])->name('training.edit.update');
    //
    Route::get('view-mnp-leads', [LeadController::class, 'ViewMNPLead'])->name('ViewMNPLead');
    Route::get('add-mnp-wifi', [LeadController::class, 'MNPForm'])->name('MNPForm');
    Route::post('DesignerVerification', [LeadController::class, 'DesignerVerification'])->name('designer.verification');
    Route::post('lead-submit', [LeadController::class, 'LeadSubmitVerification'])->name('submit.verification');
    Route::post('lead-submit-proceed', [LeadController::class, 'LeadSubmitProceed'])->name('submit.proceed');
    //
    Route::post('re-lead-submit', [LeadController::class, 'ReLeadSubmitVerification'])->name('resubmit.verification');
    Route::post('re-lead-submit-proceed', [LeadController::class, 'ReLeadSubmitProceed'])->name('resubmit.proceed');
    //
    Route::get('view-lead/{id}', [LeadController::class, 'ViewLead'])->name('view.lead');
    Route::get('edit-lead/{id}', [LeadController::class, 'EditLead'])->name('edit.lead');
    //
    Route::post('ChatRequest', [LeadController::class, 'ChatRequest'])->name('chat.post');
    // Route::post('ChatRequest', 'ChatController@ChatPost')->name('chat.post');
    //
});
Route::group(['prefix' => 'trainer'], function () {
    //    ROLE
    Route::get('page/{id}', [TrainingController::class, 'page'])->name('training.page');
    //
    Route::get('AddQuestionBank', [ExamController::class, 'AddQuestionBank'])->name('AddQuestionBank')->middleware('auth');
    Route::get('quiz-edit/{slug}', [ExamController::class, 'EditQuiz'])->name('edit.quiz')->middleware('auth');
    Route::get('AllQuestionBank', [ExamController::class, 'AllQuestionBank'])->name('AllQuestionBank')->middleware('auth');
    Route::post('QuizDelete', [ExamController::class, 'QuizDelete'])->name('quiz.delete');
    Route::post('upload_image', [ExamController::class, 'upload_image'])->name('upload.image')->middleware('auth');
    Route::post('QuizAdd', [ExamController::class, 'QuizAdd'])->name('QuizAdd')->middleware('auth');
    Route::post('QuizUpdate', [ExamController::class, 'QuizUpdate'])->name('QuizUpdate')->middleware('auth');
    // Blog Categories
    Route::get('quiz-category', [ExamController::class, 'category'])->name('exam.category.index')->middleware('auth');
    Route::get('edit-category/{id}', [ExamController::class, 'editcategory'])->name('edit.category.index')->middleware('auth');
    Route::get('add-category', [ExamController::class, 'addcategory'])->name('addcategory')->middleware('auth');
    Route::post('quiz-category-create', [ExamController::class, 'CategoryCreate'])->name('exam.category.create')->middleware('auth');
    Route::post('QuizEditCategoryData', [ExamController::class, 'EditCategoryData'])->name('exam.edit.category.data');
    Route::post('QuizEditBlogCategory', [ExamController::class, 'EditBlogCategory'])->name('exam.EditBlogCategory');
    Route::post('QuizCategoryDelete', [ExamController::class, 'CategoryDelete'])->name('exam.category.delete');
    //
    Route::get('QuestionStart', [ExamController::class, 'QuestionStart'])->name('QuestionStart')->middleware('auth');

    //
});
Route::group(['prefix' => 'verification','middleware' => 'auth'], function () {
    //    ROLE
    Route::get('verification-lead/{id}', [VerificationController::class, 'VerificationLead'])->name('verification.lead');
    Route::get('processing-lead/{id}', [VerificationController::class, 'ProcessingLead'])->name('processing.lead');
    Route::post('verifyLead', [VerificationController::class, 'verifyLead'])->name('verifyLead');
    Route::post('proceedlead', [VerificationController::class, 'proceedlead'])->name('proceedlead');
    Route::post('RejectLeads', [VerificationController::class, 'RejectLeads'])->name('RejectLeads');
    Route::post('RejectLeadsPre', [VerificationController::class, 'RejectLeadsPre'])->name('RejectLeadsPre');
    Route::post('followupleads', [VerificationController::class, 'followupleads'])->name('followupleads');
    Route::post('VerifyPostPaidLeads', [VerificationController::class, 'VerifyPostPaidLeads'])->name('VerifyPostPaidLeads');
    Route::post('VerifyPostPaidLeadsNew', [VerificationController::class, 'VerifyPostPaidLeadsNew'])->name('VerifyPostPaidLeadsNew');
    Route::post('VerifyPostPaidLeadsProcess', [VerificationController::class, 'VerifyPostPaidLeadsProcess'])->name('VerifyPostPaidLeadsProcess');
});
Route::group(['prefix' => 'designer'], function () {
    //    ROLE
    Route::get('all-design-lead', [DesignerController::class, 'all_lead_designer'])->name('all_lead_designer');
    Route::get('design-lead/{id}', [DesignerController::class, 'DesignerLead'])->name('DesignerLead');
});
Route::group(['prefix' => 'activator','middleware'=>'auth'], function () {
    //    ROLE
    Route::get('in-process-lead', [ActivationController::class, 'inprocesslead'])->name('inprocesslead');
    Route::get('in-process-lead-hw', [ActivationController::class, 'inprocessleadhomewifi'])->name('inprocessleadhomewifi');
    Route::get('mnp-process-lead', [ActivationController::class, 'mnpprocesslead'])->name('mnpprocesslead');
    Route::get('inprocess-lead/{id}', [ActivationController::class, 'inprocessleadview'])->name('inprocessleadview');
    Route::get('inprocess-lead-hw/{id}', [ActivationController::class, 'inprocessleadviewhw'])->name('inprocessleadviewhw');
    Route::get('pre-process-lead/{id}', [ActivationController::class, 'preprocessleadview'])->name('preprocessleadview');
    Route::post('ProceedMNP', [ActivationController::class, 'ProceedMNP'])->name('proceed.mnp');
    Route::post('ProceedP2P', [ActivationController::class, 'ProceedP2P'])->name('proceed.p2p');
    Route::post('ProceedHW', [ActivationController::class, 'ProceedHW'])->name('proceed.hw');
    Route::post('ActiveMNP', [ActivationController::class, 'ActiveMNP'])->name('active.mnp');
});
Route::group(['prefix' => 'report','middleware'=>'auth'], function () {
    //    ROLE
    Route::get('tl-card', [ReportController::class, 'tlcard'])->name('tl.scorecard');
    Route::get('tl-report/{id}', [ReportController::class, 'tlreport'])->name('tlreport');
    Route::get('main-report', [ReportController::class, 'mainreport'])->name('main.report');
    //    ROLE
});
Route::group(['prefix' => 'call','middleware'=>'auth'], function () {
    //    ROLE
    // Route::get('my-call-log', 'NumberController@my_call_log')->name('my_call_log')->middleware('auth');

    Route::get('my-call-log', [NumberAssigner::class, 'my_call_log'])->name('my_call_log');
    Route::get('tl-call-log', [NumberAssigner::class, 'tl_call_log'])->name('tl_call_log');
    Route::get('MyLogDashboard', [NumberAssigner::class, 'MyLogDashboard'])->name('MyCallLogDashboard');
    Route::post('submit_feedback_number', [NumberAssigner::class, 'submit_feedback_number'])->name('number.feedback.submit');
    Route::post('submit_feedback_number_tl', [NumberAssigner::class, 'submit_feedback_number_tl'])->name('number.feedback.submit.tl');
    Route::post('loadmnpdatacc', [NumberAssigner::class, 'loadmnpdatacc'])->name('loadmnpdatacc');
    Route::get('call-table-data/{status}', [NumberAssigner::class, 'dashboard_status'])->name('mnp.status');
    Route::get('agent-log', [NumberAssigner::class, 'agent_mnp_log'])->name('agent_mnp_log');
    // Route::get('agent-log', [NumberAssigner::class, 'agent_mnp_log'])->name('agent_mnp_log');
    Route::get('FollowUpDashboard', [NumberAssigner::class, 'FollowUpDashboard'])->name('FollowUpDashboard');
    // Route::get('/FollowUpDashboard', 'MNPDashboardController@admin_dashboard')->name('MNPDashboard')->middleware('auth');;

    // Route::get('/MNP-table-data/{status}', 'MNPDashboardController@dashboard_status')->name('mnp.status')->middleware('auth');;
    // Route::get('/agent-mnp-log', 'MNPDashboardController@agent_mnp_log')->name('agent_mnp_log')->middleware('auth');;


    //
    // Route::get('/MNP-Dashboard', 'MNPDashboardController@admin_dashboard')->name('MNPDashboard')->middleware('auth');;
    // Route::get('/MNP-user-Dashboard', 'MNPDashboardController@user_dashboard')->name('UserDashboard')->middleware('auth');;
    // Route::get('/MNP-table-data/{status}', 'MNPDashboardController@dashboard_status')->name('mnp.status')->middleware('auth');;

    // Route::get('/MasterMNPDashboard', 'MNPDashboardController@MasterMNPDashboard')->name('MasterMNPDashboard')->middleware('auth');;
    // Route::post('/mnp-admin-load', 'MNPDashboardController@mnploadajax')->name('mnpload.ajax')->middleware('auth');;
    // Route::get('/agent-mnp-log', 'MNPDashboardController@agent_mnp_log')->name('agent_mnp_log')->middleware('auth');;

    // Route::get('/MNPCallCenterData/{cc}', 'MNPDashboardController@mnpcallcenterdata')->name('mnpcallcenterdata')->middleware('auth');;
    // Route::post('/loadmnpdatacc', 'MNPDashboardController@loadmnpdatacc')->name('loadmnpdatacc')->middleware('auth');;
    //
});
//
Route::group(['prefix' => 'WhatsApp','middleware'=>'auth'], function () {
    //    ROLE
    // Route::post('MyWhatsApp', 'Wha@MyWhatsApp')->name('my_call_log')->middleware('auth');

    Route::post('MyWhatsApp', [WhatsAppController::class, 'MyWhatsApp'])->name('my.whatsapp.message');
    // Route::get('MyLogDashboard', [NumberAssigner::class, 'my_call_log'])->name('my_call_log');
    // Route::post('submit_feedback_number', [NumberAssigner::class, 'submit_feedback_number'])->name('number.feedback.submit');
});

Route::group(['prefix' => 'Uploader','middleware'=>'auth'], function () {
    //    ROLE
    // Route::post('MyWhatsApp', 'Wha@MyWhatsApp')->name('my_call_log')->middleware('auth');
    // Route::get('/NumberAssignerManager', 'NumberAssigner@NumberAssignerManager')->name('NumberAssignerManager')->middleware('auth');

    Route::get('NumberAssignerManager', [NumberAssigner::class, 'NumberAssignerManager'])->name('NumberAssignerManager');
    Route::get('NumberAssignerUser', [NumberAssigner::class, 'NumberAssignerUser'])->name('NumberAssignerUser');
    Route::post('bulk_importer/assigner', [NumberAssigner::class, 'assigner'])->name('bulk.assigner');
    Route::post('bulk_importer/assigner-user', [NumberAssigner::class, 'assigner_user'])->name('bulk.assigner.user');
    // Route::post('/bulk_importer/assigner', 'NumberAssigner@assigner')->name('bulk.assigner')->middleware('auth');
    // Route::post('/bulk_importer/assigner-user', 'NumberAssigner@assigner_user')->name('bulk.assigner.user')->middleware('auth');
    // Route::get('MyLogDashboard', [NumberAssigner::class, 'my_call_log'])->name('my_call_log');
    // Route::post('submit_feedback_number', [NumberAssigner::class, 'submit_feedback_number'])->name('number.feedback.submit');
});

Route::get('ScanWhatsApp', [FunctionController::class, 'ScanWhatsApp'])->name('ScanWhatsApp');
Route::get('ImportExcel', [ImportExcelController::class, 'ImportExcel'])->name('ImportExcel');
Route::get('TransferNumber', [NumberAssigner::class, 'TransferNumber'])->name('TransferNumber');
Route::post('import', [ImportExcelController::class, 'import'])->name('import.excel');
Route::get('ActivationSheet', [ReportController::class, 'ActivationSheet'])->name('ActivationSheet');
Route::get('AllActivationSheet', [ReportController::class, 'AllActivationSheet'])->name('AllActivationSheet');
Route::get('TestNumber', [ReportController::class, 'TestNumber'])->name('TestNumber');
Route::get('TestWhatsApp', [ReportController::class, 'TestWhatsApp'])->name('TestWhatsApp');
// Route::get('/ScanWhatsApp', 'WhatsAppController@ScanWhatsApp')->name('ScanWhatsApp');
Route::get('MostImport', [ImportExcelController::class, 'MostImport'])->name('MostImport');
Route::post('MostImportImport', [ImportExcelController::class, 'MostImportImport'])->name('MostImportImport');
Route::get('MyGame', [ImportExcelController::class, 'MyGame'])->name('MyGame');
// Route::post('customer-feedbac-submit', 'NumberController@submit_feedback_number')->name('number.feedback.submit')->middleware('auth');


// Route::group(['prefix' => 'uploader'], function () {
//     Route::post('/import-upload-bank', 'UploadController@import_data_excel')->name('import.uploader.excel')->middleware('auth');
//     Route::get('/NumberAssignerManager', 'NumberAssigner@NumberAssignerManager')->name('NumberAssignerManager')->middleware('auth');
//     Route::get('/NumberAssignerUser', 'NumberAssigner@NumberAssignerUser')->name('NumberAssignerUser')->middleware('auth');
// });
