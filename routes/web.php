<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\applicationController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\ApplicationCoursesController;
use App\Http\Controllers\aknownledgeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\SecretariatController;
use App\Http\Controllers\UpgradeLevelController;
use App\Http\Controllers\FaqController; #SKP
use App\Http\Controllers\AssessorController; #SKP
use App\Http\Controllers\Roles\MenuController;
use App\Http\Models\Otp;
use App\Http\Controllers\application_controller\AdminApplicationController;
use App\Http\Controllers\application_controller\SuperAdminApplicationController;
use App\Http\Controllers\application_controller\TPApplicationController;
use App\Http\Controllers\application_controller\AccountApplicationController;
use App\Http\Controllers\application_controller\DesktopApplicationController;
use App\Http\Controllers\application_controller\OnsiteApplicationController;
use App\Http\Controllers\application_controller\DocApplicationController;
use App\Http\Controllers\application_controller\SecretariatDocumentVerifyController;
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
Route::get('/optimize-clear', function () {
    $exitCode = Artisan::call('optimize:clear');
    return 'Optimized successfully';
});
Route::get('/key-generate', function () {
    $exitCode = Artisan::call('key:generate');
    return 'Key generated successfully';
});
Route::get('/vendor-publish', function () {
    $exitCode = Artisan::call('vendor:publish');
    return 'Vendor published successfully';
});
Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'Migration run successfully';
});
Route::get('list_show', [AuthController::class, 'list_show']);
Route::get('state-list', [AuthController::class, 'state']);
Route::get('city-list', [AuthController::class, 'city']);
Route::get("/logout", [AuthController::class, 'logout']);
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [AuthController::class, 'landing'])->name('/');
    Route::get('/login-page', [AuthController::class, 'landingLogin'])->name('login-page');
    Route::get('/login/{slug?}', [AuthController::class, 'login'])->name('login');
    Route::post('/login_post', [AuthController::class, 'login_post']);
    Route::get('{slug}/{sulg}/register', [AuthController::class, 'register']);
    Route::Post('/register', [AuthController::class, 'commonRegistration']);
    //captcha
    //Route::get('my-captcha',[AuthController::class,'myCaptcha'])->name('myCaptcha');
    //Route::post('my-captcha',[AuthController::class,'myCaptchaPost'])->name('myCaptcha.post');
    Route::get('refresh_captcha', [AuthController::class, 'refreshCaptcha'])->name('refresh_captcha');
    //mail
    Route::post('sendOtp',  [AuthController::class, 'sendOtp'])->middleware('guest');
    Route::post('sendEmailOtp', [AuthController::class, 'sendEmailOtp'])->middleware('guest');
    Route::post('verifyOtp',  [AuthController::class, 'verifyOtp'])->middleware('guest');
    //forget password
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
});
//dashboard Route
Route::group(['middleware' => ['auth','EnsureTokenIsValid','PreventBackHistory']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');;
    Route::get('/admin-user', [adminController::class, 'user_index']);
    Route::get('/training-provider', [adminController::class, 'tp_index']);
    Route::get('/assessor-user', [adminController::class, 'assessor_user']);
    Route::get('/professional-user', [adminController::class, 'professional_user']);
    Route::get('view-user/{id?}', [adminController::class, 'user_view']);
    //level route type 4
    Route::post('/new-application', [LevelController::class, 'new_application']);
    Route::get('level-list', [LevelController::class, 'level_list']);
    Route::get('/level-first/{id?}', [LevelController::class, 'level1tp']);
    Route::get('/edit-application/{id?}', [LevelController::class, 'edit_application']);
    Route::get('/course-payment/{id?}', [LevelController::class, 'coursePayment'])->name('course.payment');
    Route::get('/level-first-upgrade/{upgrade_application_id?}/{id?}', [LevelController::class, 'level1tp_upgrade']);
    // Route::get('/level-first', [LevelController::class, 'level1tp']);
    Route::get('/level-second', [LevelController::class, 'level2tp']);
    Route::get('/level-third', [LevelController::class, 'level3tp']);
    Route::get('/level-fourth', [LevelController::class, 'level4tp']);
    Route::get('/levels', [LevelController::class, 'index']);
    Route::get('/level-view/{id}', [LevelController::class, 'level_view']);
    Route::get('/update-level/{id?}', [LevelController::class, 'update_level']);
    Route::post('/update-level_post/{id?}', [LevelController::class, 'update_level_post']);
    Route::post('/new-application-course', [LevelController::class, 'new_application_course']);
    Route::post('/application-course', [LevelController::class, 'application_course']);
    Route::post('/new-application_payment', [LevelController::class, 'new_application_payment']);
    // Route::post('/new-application',[LevelController::class,'new_application']);
    Route::get('/course-list', [LevelController::class, 'course_list']);
    Route::get('/course-edit', [LevelController::class, 'course_edit']);
    Route::post('/course-edit/{id?}', [LevelController::class, 'course_edits']);
    //admin view section
    Route::get('/admin-view/{id}', [LevelController::class, 'admin_view']);
    Route::get('admin/application/documents/{id}/summary',[applicationController::class,"applicationDocumentsSummary"]);
    Route::get('/delete-course/{id}', [LevelController::class, 'delete_course']);
    Route::post('/Assigan-application', [applicationController::class, 'Assigan_application']);
    Route::post('/assigan-secretariat-application', [applicationController::class, 'assigan_secretariat_application']);
    Route::get('/assigin-check-delete', [applicationController::class, 'assigin_check_delete']);
    //previews-application view page
    Route::get('/previews-application-first/{application_id}/{notificationId?}', [LevelController::class, 'previews_application1']);
    Route::get('/previews-application-second/{id?}', [LevelController::class, 'previews_application2']);
    Route::get('/previews-application-third/{id?}', [LevelController::class, 'previews_application3']);
    Route::get('/previews-application-fourth/{id?}', [LevelController::class, 'previews_application4']);
    Route::get('/preveious-app-status/{id?}', [LevelController::class, 'preveious_app_status']);
    Route::post('/image-app-status/{id?}', [LevelController::class, 'image_app_status']);
    Route::get('/upload-document/{id}/{course_id}', [LevelController::class, 'upload_document']);
    Route::post('/upload-document', [LevelController::class, 'uploads_document']);
    //Manage Manual
    Route::get('manage-manual', [AdminController::class, 'manage_manual'])->name('manage-manual');
    Route::post('save-manual', [AdminController::class, 'save_manual']);
    Route::get('delete-manual/{id}', [AdminController::class, 'delete_manual']);
    //payment status
    Route::get('paymentstatus/{id?}', [LevelController::class, 'paymentstatus']);
    // upgrade application
    // Route::post('upgrade-application',[LevelController::class,"upgradeApplicationLevel"]);
    //previews-application upgrade
    Route::get('/application-upgrade-second', [LevelController::class, 'application_upgrade2']);
    Route::get('/application-upgrade-third', [LevelController::class, 'application_upgrade3']);
    Route::get('/application-upgrade-fourth', [LevelController::class, 'application_upgrade4']);
    //acknowledgement letter
    Route::get('/Akment-letter', [aknownledgeController::class, 'index']);
    //Application
    Route::get('/internationl-page', [applicationController::class, 'internationl_index']);
    Route::get('/nationl-page', [applicationController::class, 'nationl_page']);
    Route::get('/internationl-accesser', [applicationController::class, 'internationl_accesser']);
    Route::get('/nationl-accesser', [applicationController::class, 'nationl_accesser']);
    Route::get('/nationl-secretariat', [SecretariatController::class, 'nationl_secretariat']);
    Route::get('/internationl-secretariat', [SecretariatController::class, 'internationl_secretariat']);
    //use index page url 
    Route::get('/admin-user', [adminController::class, 'user_index']);
    Route::get('/training-provider', [adminController::class, 'tp_index']);
    Route::get('/assessor-user', [adminController::class, 'assessor_user']);
    Route::get('/secrete-user', [adminController::class, 'secrete_user']);
    //admin
    Route::get('/adduser/{slug}', [adminController::class, 'add_user']);
    Route::post('/adduser', [adminController::class, 'aduser_post']);
    Route::get("/delete-admin/{id?}", [adminController::class, "deleteRecord"]);
    Route::get("/update-admin/{slug}/{id?}", [adminController::class, "updateRecord"]);
    Route::post("/update-admin/{id?}", [adminController::class, "updateRecord_post"]);
    Route::get('active-users/{id}', [AdminController::class, 'active_user']);
    Route::get('profile-get', [AdminController::class, 'profile']);
    Route::post('profile_submit/{id?}', [AdminController::class, 'profile_submit']);
    #SKP
    Route::get('get-faqs', [FaqController::class, 'get_faqs']);
    Route::post('get-faqs', [FaqController::class, 'get_faqs']);
    Route::get('view-faqs', [FaqController::class, 'view_faqs']);
    Route::get('send-feedback', [FaqController::class, 'send_feedback']);
    Route::post('send-feedback', [FaqController::class, 'send_feedback_submit']);
    Route::get('show-feedback', [FaqController::class, 'show_feedback']);
    Route::get('show-previous-level', [UpgradeLevelController::class, 'show_previous_level']);
    Route::get('add-faq', [FaqController::class, 'add_faq']);
    Route::post('add-faq', [FaqController::class, 'add_faq_post']);
    Route::get('update-faq/{id?}', [FaqController::class, 'update_faq']);
    Route::post('update-faq/{id?}', [FaqController::class, 'update_faq_post']);
    Route::get('activate-faq/{id?}', [FaqController::class, 'activate_faq']);
    Route::get('delete-faq/{id?}', [FaqController::class, 'delete_faq']);
    //Grievance section
    Route::get('Grievance-list', [DashboardController::class, 'Grievance_list']);
    Route::get('Grievance', [DashboardController::class, 'Grievance']);
    Route::post('Add-Grievance', [DashboardController::class, 'Add_Grievance']);
    Route::get('active-Grievance/{id?}', [DashboardController::class, 'active_Grievance']);
    Route::get('view-Grievance/{id?}', [DashboardController::class, 'view_Grievance']);
    //email-verification
    Route::get('email-verification', [DashboardController::class, 'email_verification']);
    Route::post('email-verification', [DashboardController::class, 'email_verifications']);
    Route::get('Email-domoin-delete/{id?}', [DashboardController::class, 'email_domoin_delete']);
    Route::get('show-pdf/{id?}', [applicationController::class, 'show_pdf']);
    Route::get('document-detail/{document_name}/{application_id}/{document_id}', [applicationController::class, 'documentDetails']);
    Route::get('remarks/{application_id}/{course_id}/{question_id}', [applicationController::class, 'remarksData']);
    Route::post('submit-remark',[applicationController::class,"saveRemark"]);
    Route::get('show-course-pdf/{id?}', [applicationController::class, 'show_course_pdf']);
    // Accor Routes
    Route::get('desktop-assessment12', [DashboardController::class, 'desktop_assessment']);
    Route::get('assessor-desktop-assessment', [FullCalenderController::class, 'index']);
    Route::get('assessor-onsite-assessment-page', [FullCalenderController::class, 'assessor_onsite_assessment']);
    Route::get('assessor-onsite-assessment', [FullCalenderController::class, 'onsiteassessment']);
    Route::post('fullcalenderAjax', [FullCalenderController::class, 'ajax']);
    Route::post('fullcalenderAjax_onsite', [FullCalenderController::class, 'fullcalenderAjax_onsite']);
    Route::post('add-available-date', [FullCalenderController::class, 'add_available_date']);
    Route::get('assessor-user-manuals', [AssessorController::class, 'manual_list']);
    //add courses root
    Route::post('/add-courses', [LevelController::class, 'add_courses']);
    Route::get('/Assessor-view/{id}', [LevelController::class, 'Assessor_view']);
    Route::get('/secretariat-view/{id}', [LevelController::class, 'secretariat_view']);
    Route::get('view-application-documents', [applicationController::class, 'assessor_view_docs']);
    Route::get('summery-course-report/{id}', [LevelController::class, 'summery_course_report']);
    Route::get('view-summery-report/{course}/{application}', [LevelController::class, 'view_summery_report']);
    Route::get('/accr-view-document/{id}/{course_id}', [LevelController::class, 'accr_upload_document']);
    //upgrade level route
    Route::get('document-view/{id?}', [LevelController::class, 'document_view']);
    Route::get('document-view-accessor/{id?}', [LevelController::class, 'document_view_accessor']);
    Route::post('/upgrade-level', [UpgradeLevelController::class, 'upgrade_level']);
    // new routes
    Route::get('create-course/{id?}', [LevelController::class, 'create_course']);
    Route::get('view-doc/{doc_code}/{id?}/{doc_id}/{course_id}/{question_id}', [LevelController::class, 'view_doc']);
    Route::get('admin-view-doc/{doc_code}/{id?}/{doc_id}/{course_id}/{question_id}', [LevelController::class, 'admin_view_doc']);
    Route::get('show-comment/{doc_id}', [LevelController::class, 'show_comment']);
    Route::get('document-report-toadmin/{course_id}', [LevelController::class, 'doc_to_admin']);
    Route::post('document-report-toadmin', [LevelController::class, 'doc_to_admin_sumit']);
    Route::post('add-accr-comment-view-doc', [LevelController::class, 'acc_doc_comments']);
    Route::get('/admin-view-document/{id}/{course_id}', [LevelController::class, 'admin_view_document']);
    Route::get('/document-report-by-admin/{course_id}', [LevelController::class, 'document_report_by_admin']);
    Route::post('/document-report-by-admin', [LevelController::class, 'document_report_by_admin_submit']);
    Route::get('/document-comment-admin-assessor/{course_id}', [LevelController::class, 'document_comment_admin_assessor']);
    Route::get('/document-report-verified-by-assessor/{id}/{course_id}', [LevelController::class, 'document_report_verified_by_assessor']);
    //new application
    Route::get('new-applications/{id?}', [LevelController::class, 'newApplications']);
    Route::post('new-applications', [LevelController::class, 'newApplicationSave']);
    Route::get('application-list', [LevelController::class, 'applictionTable']);
    Route::get('faq', [LevelController::class, 'faqslist']);
    Route::get('pending-payment-list', [LevelController::class, 'pendingPaymentlist']);
    Route::get('get-application-details/{id}',[applicationController::class,"applicationDetailData"]);
    Route::post('/upload-document-by-assessor',[LevelController::class,"uploadVerificationDocuments"])->name('upload-document-by-onsite-assessor');
    Route::get('submit-final-report/{id}',[LevelController::class,"submitFinalReport"]);
    Route::post('submit-final-report/{id}',[LevelController::class,"submitFinalReportPost"]);
    Route::get('application/summary/{id}',[applicationController::class,"applicationDocumentsSummaryTP"]);
    Route::post('submit-final-report-by-desktop',[LevelController::class,"submitFinalReportByDesktopAssessor"])->name('submit-final-report-by-desktop');
    Route::get('submit-report-by-desktop/{applicationId}/{courseId}',[LevelController::class,"submitReportByDesktopAssessor"])->name('submit-report-by-desktop');
    Route::get('pending-payments/{id}',[LevelController::class,"pendingPayments"])->name('pending-payments');
    Route::get('on-site/upload-document/{applicationID}/{courseID}/{questionID}/{documentID}', [applicationController::class, "uploadDocumentByOnSiteAssessor"])->name('on-site.upload-document');
    Route::post('on-site/upload-document', [applicationController::class, "uploadDocumentByOnSiteAssessorPost"])->name('on-site.upload-document.post');
    Route::get('on-site/upload-photograph/{applicationID}/{courseID}/{questionID}/{documentID}', [applicationController::class, "uploadPhotographByOnSiteAssessor"])->name('on-site.upload-photograph');
    Route::post('on-site/upload/photograph',[applicationController::class, "uploadPhotographByOnSiteAssessorPost"]);
    Route::post('payment/acknowledge',[applicationController::class,"paymentAcknowledge"])->name('payment.acknowledge');
    Route::get('on-site/view/document/{document}/{documentID}/{questionID}/{applicationID}/{courseID}/{objectElementID}',[applicationController::class,"viewDocumentData"]);
    Route::get('on-site/report',[applicationController::class,"on_site_report_format"]);
    Route::post('save-on-site-report',[applicationController::class,"saveFormDataOnSite"]);
    Route::get('opportunity-form/report',[applicationController::class,"opportunityForm"]);
    Route::post('save-on-site-report-improvment-form',[applicationController::class,"saveImprovmentForm"]);
    Route::get('on-site/report-summary',[applicationController::class,"summaryReport"]);
    Route::get('get-application-summaries',[applicationController::class,"getSummariesList"]);
    Route::post('save-selected-dates',[applicationController::class,"saveSelectedDates"]);
    Route::post('add-final-remark-onsite',[applicationController::class,"submitFinalRemark"]);
    Route::get('application/courses/{application}',[applicationController::class,"getapplicationcourses"]);
    Route::get('application/summary-report/{course}/{application}',[applicationController::class,"getSummaryReportDataTP"]);
    Route::get('admin/application/courses-list/{applicationID}',[applicationController::class,"getAdminApplicationCoursesLIst"]);
    Route::get('admin/application/summary-report/{course}/{application}',[applicationController::class,"getAdminApplicationSummary"]);
// Summary Routes
    Route::get('desktop/summary/{application_id}/{application_course_id}',[SummaryController::class,"desktopIndex"]);
    Route::get('onsite/summary/{application_id}/{application_course_id}',[SummaryController::class,"onSiteIndex"]);
    Route::get('desktop/summary/submit/{application_id}/{application_course_id}',[SummaryController::class,"desktopSubmitSummary"]);
    Route::get('desktop/final-summary/{application_id}/{application_course_id}',[SummaryController::class,"desktopFinalSubmitSummaryReport"]);
    Route::post('onsite/final-summary',[SummaryController::class,"onsiteFinalSubmitSummaryReport"]);
    Route::get('onsite/summary/submit/{application_id}/{application_course_id}',[SummaryController::class,"onSiteSubmitSummary"]);
    Route::get('desktop-application-course-summaries',[DesktopApplicationController::class,"getCourseSummariesList"]);
    Route::get('desktop-view-final_summaries',[DesktopApplicationController::class,"desktopViewFinalSummary"]);
    Route::get('onsite-application-course-summaries',[OnsiteApplicationController::class,"getCourseSummariesList"]);
    // Route::get('onsite-view-final_summaries',[OnsiteApplicationController::class,"onsiteViewFinalSummary"]);
    Route::get('application-course-summaries',[SummaryController::class,"getCourseSummariesList"]);
    Route::get('view-final_summaries',[SummaryController::class,"tpViewFinalSummary"]);
    Route::get('admin-view-final_summaries',[SummaryController::class,"adminViewFinalSummary"]);
    // Created by Brijesh sir and Suraj
/*----------------- New Application Routes------------------------*/
    Route::get('create-new-applications/{id?}',[ApplicationCoursesController::class,"createNewApplication"]);
    Route::post('store-new-applications',[ApplicationCoursesController::class,"storeNewApplication"]);
    Route::get('get-application-courses',[ApplicationCoursesController::class,"getApplicationCourses"]);
    Route::get('get-application-fees',[ApplicationCoursesController::class,"getApplicationFees"]);
    Route::get('get-application-documents',[ApplicationCoursesController::class,"getApplicationDocuments"]);
    Route::get('get-application-list', [TPApplicationController::class, 'getApplicationList'])->name('application-list');
    // =========Courses Route=========//
    Route::get('create-new-course/{id?}', [ApplicationCoursesController::class, 'createNewCourse']);
    Route::post('/store-new-application-course', [ApplicationCoursesController::class, 'storeNewApplicationCourse']);
    Route::get('/get-course-list', [ApplicationCoursesController::class, 'getCourseList']);
    Route::get('/delete-course-by-id/{id}', [ApplicationCoursesController::class, 'deleteCourseById']);
    Route::get('/show-course-payment/{id?}', [ApplicationCoursesController::class, 'showcoursePayment'])->name('course.payment');
    Route::post('/create-application-payment', [ApplicationCoursesController::class, 'newApplicationPayment']);
    Route::get('/course-edit', [ApplicationCoursesController::class, 'course_edit']);
    Route::post('/course-update/{id?}', [ApplicationCoursesController::class, 'course_update']);
    Route::get('/admin/application-list', [AdminApplicationController::class, 'getApplicationList'])->name('admin-app-list');
    Route::get('/admin/application-view/{id}', [AdminApplicationController::class, 'getApplicationView']);
    Route::get('/admin/document-list/{id}/{course_id}', [AdminApplicationController::class, 'applicationDocumentList']);
    Route::post('/admin/document-verfiy', [AdminApplicationController::class, 'adminDocumentVerify']);
    Route::post('/admin-assign-assessor', [AdminApplicationController::class, 'assignAssessor']);
    Route::get('/admin-{nc_type}/{assessor_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [AdminApplicationController::class, 'adminVerfiyDocument']);
    Route::post('/admin-payment-acknowledge',[AdminApplicationController::class,"adminPaymentAcknowledge"])->name('payment.acknowledge');
    Route::post('/admin-update-notification-status/{id}', [AdminApplicationController::class, 'updateAdminNotificationStatus']);
    Route::get('/tp/application-list', [TPApplicationController::class, 'getApplicationList']);
    Route::get('/account/application-list', [AccountApplicationController::class, 'getApplicationList']);
    Route::get('/desktop/application-list', [DesktopApplicationController::class, 'getApplicationList']);
    Route::get('/onsite/application-list', [OnsiteApplicationController::class, 'getApplicationList']);
    Route::get('/tp/application-view/{id}', [TPApplicationController::class, 'getApplicationView']);
    Route::get('/account/application-view/{id}', [AccountApplicationController::class, 'getApplicationView']);
    Route::get('/desktop/application-view/{id}', [DesktopApplicationController::class, 'getApplicationView']);
    Route::get('/onsite/application-view/{id}', [OnsiteApplicationController::class, 'getApplicationView']);
    // Doc Routes

    
    
    Route::get('doc/{id?}', [DocApplicationController::class, 'showCoursePdf']);
    
    Route::get('/secretariat-{nc_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [DocApplicationController::class, 'secretariatVerfiyDocument']);

    Route::post('/secretariat/document-verfiy', [SecretariatDocumentVerifyController::class, 'secretariatDocumentVerify']);
    Route::post('/secretariat/update-nc-flag/{application_id}/{course_id}', [SecretariatDocumentVerifyController::class, 'secretariatUpdateNCFlag']);

    Route::get('/tp-course-document-detail/{nc_type}/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [TPApplicationController::class, 'tpCourseDocumentDetails']);
    Route::post('/tp-course-submit-remark', [TPApplicationController::class, 'tpCourseSubmitRemark']);


   
   
   
   
   
   
    Route::get('/tp-upload-document/{id}/{course_id}', [TPApplicationController::class, 'upload_document']);
    Route::post('/tp-upload-document', [TPApplicationController::class, 'uploads_document']);
    Route::post('/tp-add-document', [TPApplicationController::class, 'addDocument']);
    Route::get('/tp-document-detail/{nc_type}/{assessor_type}/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [TPApplicationController::class, 'tpDocumentDetails']);
    Route::post('/tp-submit-remark', [TPApplicationController::class, 'tpSubmitRemark']);
    Route::get('/desktop/document-list/{id}/{course_id}', [DesktopApplicationController::class, 'applicationDocumentList']);
    Route::get('/onsite/document-list/{id}/{course_id}', [OnsiteApplicationController::class, 'applicationDocumentList']);
    Route::get('/desktop-{nc_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [DesktopApplicationController::class, 'secretariatVerfiyDocument']);
    Route::get('/onsite-{nc_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [OnsiteApplicationController::class, 'onsiteVerfiyDocument']);
    Route::post('/desktop/document-verfiy', [DesktopApplicationController::class, 'desktopDocumentVerify']);
    Route::post('/onsite/document-verfiy', [OnsiteApplicationController::class, 'onsiteDocumentVerify']);
    Route::post('/onsite/upload-photograph', [OnsiteApplicationController::class, 'onsiteUploadPhotograph']);
    // Payment Routes
    Route::post('/account-payment-received', [DocApplicationController::class, 'accountReceivedPayment']);
    Route::post('/account-payment-approved', [DocApplicationController::class, 'accountApprovePayment']);
    Route::get('/tp-second-payment', [TpApplicationController::class, 'secondPaymentView']);
    Route::post('/tp-second-payment', [TpApplicationController::class, 'storeSecondPayment']);
    Route::post('/tp-update-payment', [TpApplicationController::class, 'updatePaynentInfo']);
    Route::post('/account-update-payment', [AccountApplicationController::class, 'updatePaynentInfo']);
    Route::post('/account-update-notification-status/{id}', [AccountApplicationController::class, 'updateAccountNotificationStatus']);
    Route::post('/assessor-desktop-update-notification-status/{id}', [DesktopApplicationController::class, 'updateAssessorDesktopNotificationStatus']);
    Route::post('/assessor-onsite-update-notification-status/{id}', [OnsiteApplicationController::class, 'updateAssessorOnsiteNotificationStatus']);
    Route::get('tp-pending-payment-list', [TpApplicationController::class, 'pendingPaymentlist']);
    Route::post('tp-payment-transaction-validation', [TpApplicationController::class, 'paymentTransactionValidation'])->name('transaction_validation');
    Route::post('tp-payment-reference-validation', [TpApplicationController::class, 'paymentReferenceValidation'])->name('reference_validation');
/*----------------- End Here------------------------*/
});
Route::get('email-test', function(){
    $details['email'] = 'surajc414@gmail.com';
    $details['title'] = 'Traing Provider Created a New Application and Course Payment Successfully Done'; 
    $details['subject'] = 'New Application | Application ID'; 
    $details['content'] = 'New Application has been created with Application ID'; 
    dispatch(new SendEmailJob($details));
    dd('done');
});
//notification status change
Route::get('notification', [LevelController::class, 'notification']);
/*Admin Url Roles and Permissions Routes*/
Route::get('main-menu', [MenuController::class, 'index']);
Route::post('add-new-menu', [MenuController::class, 'create']);
Route::get('edit-model/{id}', [MenuController::class, 'edit_model']);
Route::post('update-model/{id}', [MenuController::class, 'update_model']);
Route::get('model-dlt/{id}', [MenuController::class, 'delete_model']);
Route::post('phone-validation', [LevelController::class, 'phoneValidaion'])->name('phone.validation');
Route::post('email-validation', [LevelController::class, 'emailValidaion'])->name('email.validation');
Route::post('payment-transaction-validation', [LevelController::class, 'paymentTransactionValidation'])->name('transaction_validation');
Route::post('payment-reference-validation', [LevelController::class, 'paymentReferenceValidation'])->name('reference_validation');
Route::post('check-payment-duplicacy',[LevelController::class,"paymentDuplicateCheck"])->name('payment.duplicate');



/*super admin routes*/
Route::get('/super-admin/application-list', [SuperAdminApplicationController::class, 'getApplicationList'])->name('superadmin-app-list');
    Route::get('/super-admin/application-view/{id}', [SuperAdminApplicationController::class, 'getApplicationView']);
    Route::get('/super-admin/document-list/{id}/{course_id}', [SuperAdminApplicationController::class, 'applicationDocumentList']);
    Route::post('/super-admin/document-verfiy', [SuperAdminApplicationController::class, 'adminDocumentVerify']);
    Route::post('/super-admin-assign-secretariat', [SuperAdminApplicationController::class, 'assignSecretariat']);
    Route::get('/super-admin-{nc_type}/{assessor_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [SuperAdminApplicationController::class, 'adminVerfiyDocument']);
    Route::post('/super-admin-payment-acknowledge',[SuperAdminApplicationController::class,"adminPaymentAcknowledge"])->name('payment.acknowledge');
    Route::post('/super-admin-update-notification-status/{id}', [SuperAdminApplicationController::class, 'updateAdminNotificationStatus']);
/*--end here--*/