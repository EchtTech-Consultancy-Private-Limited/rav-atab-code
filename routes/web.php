<?php
use App\Http\Controllers\application_controller\DownloadPDFCertificateController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\application_controller\DashboardController;
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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\application_controller\DownLoadPDFFinalSummaryController;
use App\Http\Controllers\application_controller\RenewalController;
use App\Http\Controllers\application_controller\SurveillanceController;
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
Route::get('/certificate-demo', function () {
    
    return view('certificate.certificate');
});

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


/*--------------------Start Online Payment Process----------------------------*/
//Route::post('/payment/process', [PaymentController::class, 'processPayment']);
Route::get('makepayment/{id?}',[PaymentController::class,'makePayment'])->name('makepayment');
Route::post('paymentresponse',[PaymentController::class,'paymentResponseSuccessFailer'])->name('paymentresponse');

/*--------------------End Online Payment Process----------------------------*/


Route::group(['middleware' => ['guest']], function () {
    //Route::get('/', [AuthController::class, 'landing'])->name('/');
    Route::get('/captcha-code', [AuthController::class, 'generateCaptcha'])->name('captcha-code');
    Route::get('/', [AuthController::class, 'landingLogin'])->name('/');
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
    Route::post('sendEmailOtp', [AuthController::class, 'sendEmcreate-application-paymentailOtp'])->name('otp')->middleware('guest');
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


    /*final summary report download*/ 
    Route::get('/onsite/download/pdf/{application_id}',[DownLoadPDFFinalSummaryController::class,'downloadFinalSummaryOnsiteAssessor'])->name('onsitepdfdownload');
    Route::get('/onsite/download/pdf/first/visit/{application_id}',[DownLoadPDFFinalSummaryController::class,'downloadFinalSummaryOnsiteAssessorFirstVisit'])->name('onsitepdfdownloadFirstVisit');
    Route::get('/desktop/download/pdf/{application_id}',[DownLoadPDFFinalSummaryController::class,'downloadFinalSummaryDesktopAssessor'])->name('desktoppdfdownload');
  
    Route::get('/admin/desktop/download/pdf/{applicaion_id}',[DownLoadPDFFinalSummaryController::class,'adminDownloadPdfDesktop'])->name('admindesktoppdfdownload');
    Route::get('/admin/onsite/download/pdf/{applicaion_id}',[DownLoadPDFFinalSummaryController::class,'adminDownloadPdfOnsite'])->name('adminonsitepdfdownload');
    Route::get('/download/pdf/certificate/{applicaion_id}',[DownloadPDFCertificateController::class,'downloadPDFCertificate']);
    Route::get('/download/pdf/aiia_scope/certificate/{applicaion_id}',[DownloadPDFCertificateController::class,'downloadPDFAIIAScopeCertificate']);
    
    /*end here*/ 
     


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
    Route::get('/internationl-page', [SuperAdminApplicationController::class, 'getInternationApplicationList']);
    Route::get('/nationl-page', [applicationController::class, 'nationl_page']);
    Route::get('/international-assessor/desktop', [DesktopApplicationController::class, 'getInternationalApplicationList']);
    Route::get('/international-assessor/onsite', [OnsiteApplicationController::class, 'getInternationalApplicationList']);
    Route::get('/nationl-accesser', [applicationController::class, 'nationl_accesser']);
    Route::get('/nationl-secretariat', [SecretariatController::class, 'nationl_secretariat']);
    Route::get('/internationl-secretariat', [AdminApplicationController::class, 'getInternationalApplicationList']);
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
    Route::post('/desktop/upload/signed-copy', [DesktopApplicationController::class, 'uploadSignedCopy']);
    Route::post('/onsite/upload/signed-copy', [OnsiteApplicationController::class, 'uploadSignedCopy']);
// Summary Routes
    Route::get('desktop/summary/{application_id}/{application_course_id}',[SummaryController::class,"desktopIndex"]);
    Route::get('onsite/summary/{application_id}/{application_course_id}',[SummaryController::class,"onSiteIndex"]);
    Route::get('desktop/summary/submit/{application_id}/{application_course_id}',[SummaryController::class,"desktopSubmitSummary"]);
    Route::post('desktop/final-summary/{application_id}/{application_course_id}',[SummaryController::class,"desktopFinalSubmitSummaryReport"]);
    Route::post('onsite/final-summary',[SummaryController::class,"onsiteFinalSubmitSummaryReport"]);
    Route::get('onsite/summary/submit/{application_id}/{application_course_id}',[SummaryController::class,"onSiteSubmitSummary"]);
    Route::get('desktop-application-course-summaries',[DesktopApplicationController::class,"getCourseSummariesList"]);
    Route::get('desktop-view-final_summaries',[DesktopApplicationController::class,"desktopViewFinalSummary"]);
    Route::get('onsite-application-course-summaries',[OnsiteApplicationController::class,"getCourseSummariesList"]);
    // Route::get('onsite-view-final_summaries',[OnsiteApplicationController::class,"onsiteViewFinalSummary"]);
    Route::get('application-course-summaries',[SummaryController::class,"getCourseSummariesList"]);
    Route::get('view-final_summaries',[SummaryController::class,"tpViewFinalSummary"]);
    Route::get('admin-view-final_summaries',[SummaryController::class,"adminViewFinalSummary"]);
    Route::post('/create/ofi',[SummaryController::class,"createOFI"]);
    // Created by Brijesh sir and Suraj
/*----------------- New Application Routes------------------------*/
    Route::get('create-new-applications/{id?}',[ApplicationCoursesController::class,"createNewApplication"]);
    Route::get('create-level-2-new-applications/{id?}',[ApplicationCoursesController::class,"createLevel2NewApplication"]);
    Route::get('create-level-3-new-applications/{id?}',[ApplicationCoursesController::class,"createLevel3NewApplication"]);
    Route::post('store-new-applications',[ApplicationCoursesController::class,"storeNewApplication"]);
    Route::post('store-level-2-new-applications',[ApplicationCoursesController::class,"storeLevel2NewApplication"]);
    Route::post('store-level-3-new-applications',[ApplicationCoursesController::class,"storeLevel3NewApplication"]);
    Route::get('get-application-courses',[ApplicationCoursesController::class,"getApplicationCourses"]);
    Route::get('get-application-fees',[ApplicationCoursesController::class,"getApplicationFees"]);
    Route::get('get-application-documents',[ApplicationCoursesController::class,"getApplicationDocuments"]);
    Route::get('get-application-list', [TPApplicationController::class, 'getApplicationList'])->name('application-list');
    // =========Courses Route=========//
    Route::get('create-new-course/{id?}', [ApplicationCoursesController::class, 'createNewCourse']);
    Route::get('create-level-2-new-course/{id?}', [ApplicationCoursesController::class, 'createLevel2NewCourse']);
    Route::get('create-level-3-new-course/{id?}', [ApplicationCoursesController::class, 'createLevel3NewCourse']);
    Route::post('/store-new-application-course', [ApplicationCoursesController::class, 'storeNewApplicationCourse']);
    Route::post('/store-level-2-new-application-course', [ApplicationCoursesController::class, 'storeLevel2NewApplicationCourse']);
    Route::post('/store-level-3-new-application-course', [ApplicationCoursesController::class, 'storeLevel3NewApplicationCourse']);
    Route::get('/get-course-list', [ApplicationCoursesController::class, 'getCourseList']);
    Route::get('/delete-course-by-id/{id}', [ApplicationCoursesController::class, 'deleteCourseById']);
    Route::get('/show-course-payment/{id?}', [ApplicationCoursesController::class, 'showcoursePayment']);
    Route::post('/create-application-payment', [ApplicationCoursesController::class, 'newApplicationPayment']);
    Route::get('/course-edit', [ApplicationCoursesController::class, 'course_edit']);
    Route::post('/course-update/{id?}', [ApplicationCoursesController::class, 'course_update']);
    Route::get('/admin/application-list', [AdminApplicationController::class, 'getApplicationList'])->name('admin-app-list');
    Route::get('/admin/application-view/{id}', [AdminApplicationController::class, 'getApplicationView']);
    Route::get('/admin/application-view-level-2/{id}', [AdminApplicationController::class, 'getApplicationViewLevel2']);
    Route::get('/admin/application-view-level-3/{id}', [AdminApplicationController::class, 'getApplicationViewLevel3']);



    Route::get('/admin/application-payment-fee-list', [AdminApplicationController::class, 'getApplicationPaymentFeeList']);
    Route::get('/admin/application-payment-fee-view/{id}', [AdminApplicationController::class, 'getApplicationPaymentFeeView']);
    Route::post('/admin/raise/payment/query', [AdminApplicationController::class, 'raisePaymentQuery']);


    Route::get('/admin/approve-course/{id}/{course_id}', [AdminApplicationController::class, 'approveCourseRejectBySecretariat']);
    Route::get('/admin/reject-course/{id}/{course_id}', [AdminApplicationController::class, 'adminRejectCourse']);
    Route::get('/admin/document-list/{id}/{course_id}', [AdminApplicationController::class, 'applicationDocumentList']);
    Route::post('/admin/document-verfiy', [AdminApplicationController::class, 'adminDocumentVerify']);
    Route::post('/admin-assign-assessor', [AdminApplicationController::class, 'assignAssessor']);
    Route::post('/admin-assign-assessor-onsite', [AdminApplicationController::class, 'assignAssessorOnsite']);
    Route::get('/admin-{nc_type}/{assessor_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [AdminApplicationController::class, 'adminVerfiyDocument']);
    Route::post('/admin-payment-acknowledge',[AdminApplicationController::class,"adminPaymentAcknowledge"]);
    Route::post('/admin-update-notification-status/{id}', [AdminApplicationController::class, 'updateAdminNotificationStatus']);
    Route::get('/{level_type?}/tp/application-list/', [TPApplicationController::class, 'getApplicationList'])->name('upgrade.application-list');
    Route::get('/account/application-list', [AccountApplicationController::class, 'getApplicationList']);
    Route::get('/desktop/application-list', [DesktopApplicationController::class, 'getApplicationList']);
    Route::get('/onsite/application-list', [OnsiteApplicationController::class, 'getApplicationList']);
    Route::get('/tp/application-view/{id}', [TPApplicationController::class, 'getApplicationView']);
    Route::get('/account/application-view/{id}', [AccountApplicationController::class, 'getApplicationView']);
    Route::get('/desktop/application-view/{id}', [DesktopApplicationController::class, 'getApplicationView']);
    Route::get('/onsite/application-view/{id}', [OnsiteApplicationController::class, 'getApplicationView']);
    Route::post('/desktop-revert-doc-list-action', [DesktopApplicationController::class, 'revertCourseDocListActionDesktop']);
    Route::post('/onsite-revert-doc-list-action', [OnsiteApplicationController::class, 'revertCourseDocListActionOnsite']);


    Route::get('/account/application-payment-fee-list', [AccountApplicationController::class, 'getApplicationPaymentFeeList']);
    Route::get('/account/application-payment-fee-view/{id}', [AccountApplicationController::class, 'getApplicationPaymentFeeView']);


    Route::get('/tp/application-payment-fee-list/', [TPApplicationController::class, 'getApplicationPaymentFeeList']);

    Route::get('/tp/application-payment-fee-view/{id}', [TPApplicationController::class, 'getApplicationPaymentFeeView']);

    Route::get('/tp/show-course-additional-payment/{id}', [ApplicationCoursesController::class, 'showcourseAdditionalPayment']);
    Route::post('/tp/get-total-amount',[ApplicationCoursesController::class, 'getTotalAmount']);

    // Doc Routes

    
    //new scope
    Route::get('doc/{id?}', [DocApplicationController::class, 'showCoursePdf']);
    Route::get('mom/doc/{doc_name}/{app_id}', [DocApplicationController::class, 'momPdf']);

    Route::get('desktop/doc/{doc_name}/{app_id}', [DesktopApplicationController::class, 'sigendCopyDesktop']);
    Route::get('onsite/doc/{doc_name}/{app_id}', [OnsiteApplicationController::class, 'sigendCopyOnsite']);

    Route::post('/secretariat-revert-course-doc-action', [SecretariatDocumentVerifyController::class, 'revertCourseDocAction']);
    
    Route::post('/secretariat-revert-doc-list-action', [SecretariatDocumentVerifyController::class, 'revertCourseDocListAction']);


    Route::post('/tp-revert-course-doc-action', [TPApplicationController::class, 'revertTPCourseDocAction']);
    Route::post('/tp-revert-doc-list-action', [TPApplicationController::class, 'revertTPCourseDocListAction']);


    Route::post('/secretariat-revert-course-reject', [SecretariatDocumentVerifyController::class, 'revertCourseRejectAction']);

    
    Route::get('/secretariat-{nc_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [DocApplicationController::class, 'secretariatVerfiyDocument']);

    Route::post('/secretariat/document-verfiy', [SecretariatDocumentVerifyController::class, 'secretariatDocumentVerify']);
    Route::post('/secretariat/update-nc-flag/{application_id}/{course_id?}', [SecretariatDocumentVerifyController::class, 'secretariatUpdateNCFlag']);
    Route::post('/super-admin/update-nc-flag/{application_id}/{course_id?}', [SuperAdminApplicationController::class, 'superAdminUpdateNCFlag']);

    Route::post('/secretariat/reject-course/{application_id}/{course_id}', [SecretariatDocumentVerifyController::class, 'secretariatRejectCourse']);

    Route::get('send-admin-approval/{application_id}', [SecretariatDocumentVerifyController::class, 'sendAdminApproval']);

    Route::get('send-admin-approval-doc-list/{application_id}', [SecretariatDocumentVerifyController::class, 'sendAdminApprovalDocList']);


    Route::get('/tp-course-document-detail/{nc_type}/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [TPApplicationController::class, 'tpCourseDocumentDetails']);
    Route::post('/tp-course-submit-remark', [TPApplicationController::class, 'tpCourseSubmitRemark']);
    Route::post('/tp-course-add-document', [TPApplicationController::class, 'addCourseDocument']);

    Route::get('/account-{nc_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [AccountApplicationController::class, 'accountantVerfiyDocument']);
   
    
    Route::get('/upgrade-new-application/{application_id?}/{prev_refid?}',[TPApplicationController::class,"upgradeNewApplication"]);
    Route::post('/upgrade-store-new-applications',[TPApplicationController::class,"storeNewApplication"]);
    Route::get('/upgrade-create-new-course/{id?}/{refid?}', [TPApplicationController::class, 'upgradeCreateNewCourse']);
    Route::post('/upgrade-store-new-application-course', [TPApplicationController::class, 'upgradeStoreNewApplicationCourse']);
    Route::get('/upgrade-show-course-payment/{id?}', [TPApplicationController::class, 'upgradeShowcoursePayment']);
    Route::post('/upgrade-create-application-payment', [TPApplicationController::class, 'upgradeNewApplicationPayment']);
    Route::get('/upgrade/tp/application-view/{id}', [TPApplicationController::class, 'upgradeGetApplicationView']);

    Route::post('/additional-application-payment-fee', [TPApplicationController::class, 'newAdditionalApplicationPaymentFee']);

    
    Route::get('/upgrade-level-3-new-application/{application_id?}/{prev_refid?}',[TPApplicationController::class,"upgradeNewApplicationLevel3"]);
    Route::post('/upgrade-level-3-store-new-applications',[TPApplicationController::class,"storeNewApplicationLevel3"]);
    Route::get('/upgrade-level-3-create-new-course/{id?}/{refid?}', [TPApplicationController::class, 'upgradeCreateNewCourseLevel3']);
    Route::post('/upgrade-level-3-store-new-application-course', [TPApplicationController::class, 'upgradeStoreNewApplicationCourseLevel3']);
    Route::get('/upgrade-level-3-show-course-payment/{id?}', [TPApplicationController::class, 'upgradeShowcoursePaymentLevel3']);
    Route::post('/upgrade-level-3-create-application-payment', [TPApplicationController::class, 'upgradeNewApplicationPaymentLevel3']);
    Route::get('/upgrade/level-3/tp/application-view/{id}', [TPApplicationController::class, 'upgradeGetApplicationViewLevel3']);


/*Deskotop*/
Route::post('/desktop/update-nc-flag/{application_id}/{course_id}', [DesktopApplicationController::class, 'desktopUpdateNCFlag']);
Route::post('/desktop/generate/final-summary', [DesktopApplicationController::class, 'generateFinalSummary']);

   //end here
   

   
    Route::post('/tp-delete-course/{id}/{course_id}', [TPApplicationController::class, 'deleteCourse']);

    Route::get('/tp-upload-document/{id}/{course_id}', [TPApplicationController::class, 'upload_document']);
    Route::get('/tp-upload-document-level-2/{id}/{course_id}', [TPApplicationController::class, 'upload_documentlevel2']);
    Route::post('/tp-upload-document', [TPApplicationController::class, 'uploads_document']);
    Route::post('/tp-add-document', [TPApplicationController::class, 'addDocument']);
    Route::post('/tp-add-document-level-2', [TPApplicationController::class, 'addDocumentLevel2']);
    Route::get('/tp-document-detail/{nc_type}/{assessor_type}/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [TPApplicationController::class, 'tpDocumentDetails']);

    Route::get('/tp-document-detail-level-2/{nc_type}/{assessor_type}/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [TPApplicationController::class, 'tpDocumentDetailsLevel2']);

    Route::post('/tp-submit-remark', [TPApplicationController::class, 'tpSubmitRemark']);
    Route::get('/desktop/document-list/{id}/{course_id}', [DesktopApplicationController::class, 'applicationDocumentList']);
    Route::get('/onsite/document-list/{id}/{course_id}', [OnsiteApplicationController::class, 'applicationDocumentList']);
    
    Route::get('/desktop-{nc_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [DesktopApplicationController::class, 'desktopVerfiyDocument']);

    Route::post('/desktop/update-nc-flag-doc-list/{application_id}/{course_id?}', [DesktopApplicationController::class, 'desktopUpdateNCFlagDocList']);
    Route::post('/tp/update-nc-flag/{application_id}/{course_id?}', [TPApplicationController::class, 'tpUpdateNCFlagDocList']);
    Route::post('/tp/update-flag/course-doc/{application_id}', [TPApplicationController::class, 'tpUpdateNCFlagCourseDoc']);


    // Route::get('/desktop-{nc_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [DesktopApplicationController::class, 'secretariatVerfiyDocument']);

    Route::get('/onsite-{nc_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [OnsiteApplicationController::class, 'onsiteVerfiyDocument']);
    Route::post('/desktop/document-verfiy', [DesktopApplicationController::class, 'desktopDocumentVerify']);
    Route::post('/onsite/document-verfiy', [OnsiteApplicationController::class, 'onsiteDocumentVerify']);
    Route::post('/onsite/upload-photograph', [OnsiteApplicationController::class, 'onsiteUploadPhotograph']);
    Route::post('/onsite/update-nc-flag-doc-list/{application_id}/{course_id?}', [OnsiteApplicationController::class, 'onsiteUpdateNCFlagDocList']);
    Route::post('/onsite/update-nc-flag-doc-list/course/{application_id}/{course_id?}', [OnsiteApplicationController::class, 'onsiteUpdateNCFlagDocListCourse']);

    Route::post('/onsite/generate/final-summary', [OnsiteApplicationController::class, 'onsiteGenerateFinalSummary']);
    
Route::post('/secretariat/upload-mom', [SecretariatDocumentVerifyController::class, 'uploadMoM']);
Route::post('/admin/return/mom', [AdminApplicationController::class, 'adminReturnMom']);
/*Secretariat nc's 44 documents route*/ 
// Route::get('/secretariat/document-list/{id}/{course_id}', [SecretariatDocumentVerifyController::class, 'applicationDocumentList']);
Route::get('/secretariat/document-list/{id}/{course_id}', [SecretariatDocumentVerifyController::class, 'applicationDocumentListDAOA']);

Route::get('/secretariat-{nc_type}/verify-doc-level-2/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [SecretariatDocumentVerifyController::class, 'secretariatVerfiyDocumentLevel2']);

Route::post('/secretariat/document-verfiy-level-2', [SecretariatDocumentVerifyController::class, 'secretariatDocumentVerifyLevel2']);

Route::get('secretariat/summary/{application_id}/{application_course_id}',[SummaryController::class,"secretariatIndex"]);
Route::get('secretariat/summary/submit/{application_id}/{application_course_id}',[SummaryController::class,"secretariatSubmitSummary"]);
Route::post('secretariat/final-summary/{application_id}/{application_course_id}',[SummaryController::class,"secretariatFinalSubmitSummaryReport"]);

Route::get('/admin/application-course-summaries',[SummaryController::class,"getCourseSummariesListSecretariat"]);
Route::get('admin/view-final-summary',[SummaryController::class,"adminViewFinalSummarySecretariat"]);
Route::get('super-admin/application-course-summaries',[SummaryController::class,"getCourseSummariesListSecretariatSuperAdmin"]);
Route::get('super-admin/view-final-summary',[SummaryController::class,"ViewFinalSummarySecretariatsuperAdmin"]);

Route::post('/secretariat/update-nc-flag-doc-list/{application_id}/{course_id?}', [SecretariatDocumentVerifyController::class, 'secretariatUpdateNCFlagDocList']);
/*end here*/ 




    // Payment Routes
    Route::post('/account-payment-received', [DocApplicationController::class, 'accountReceivedPayment']);
    Route::post('/account-payment-approved', [DocApplicationController::class, 'accountApprovePayment']);


    Route::post('/account-additional-payment-received', [DocApplicationController::class, 'accountReceivedPaymentAdditional']);
    Route::post('/account-additional-payment-approved', [DocApplicationController::class, 'accountApprovePaymentAdditional']);

    Route::post('/account-additional-payment-received', [DocApplicationController::class, 'accountReceivedAdditionalPayment']);
    Route::post('/account-additional-payment-approved', [DocApplicationController::class, 'accountApproveAdditionalPayment']);





    Route::get('/tp-second-payment', [TpApplicationController::class, 'secondPaymentView']);
    Route::post('/tp-second-payment', [TpApplicationController::class, 'storeSecondPayment']);
    Route::post('/tp-update-payment', [TpApplicationController::class, 'updatePaynentInfo']);
    Route::post('/account-update-payment', [AccountApplicationController::class, 'updatePaynentInfo']);

    Route::post('/account-update-additional-payment', [AccountApplicationController::class, 'updateAdditionalPaynentInfo']);
    
    Route::post('/account-update-notification-status/{id}', [AccountApplicationController::class, 'updateAccountNotificationStatus']);
    Route::post('/assessor-desktop-update-notification-status/{id}', [DesktopApplicationController::class, 'updateAssessorDesktopNotificationStatus']);
    Route::post('/assessor-onsite-update-notification-status/{id}', [OnsiteApplicationController::class, 'updateAssessorOnsiteNotificationStatus']);
    Route::get('{level_type?}/tp-pending-payment-list', [TpApplicationController::class, 'pendingPaymentlist']);
    Route::post('tp-payment-transaction-validation', [TpApplicationController::class, 'paymentTransactionValidation'])->name('transaction_validation');
    Route::post('tp-payment-reference-validation', [TpApplicationController::class, 'paymentReferenceValidation'])->name('reference_validation');


    Route::post('tp-additional-payment-transaction-validation', [TpApplicationController::class, 'paymentAdditionalTransactionValidation'])->name('additional_transaction_validation');

    Route::post('tp-additional-payment-reference-validation', [TpApplicationController::class, 'paymentAdditionalReferenceValidation'])->name('additional_reference_validation');
/*----------------- End Here------------------------*/
 
    Route::get('thank-you', [AdminApplicationController::class, 'thankYou']);
    Route::get('error-response', [AdminApplicationController::class, 'errorResponse']);

    
});
Route::get('email-test', function(){
    $details['email'] = 'surajc414@gmail.com';
    $details['title'] = 'Traing Provider Created a New Application and Course Payment Successfully Done'; 
    $details['subject'] = 'New Application | Application ID'; 
    $details['content'] = 'New Application has been created with Application ID'; 
     if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
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
Route::post('payment-transaction-validation', [LevelController::class, 'paymentTransactionValidation']);
Route::post('payment-reference-validation', [LevelController::class, 'paymentReferenceValidation']);
Route::post('check-payment-duplicacy',[LevelController::class,"paymentDuplicateCheck"])->name('payment.duplicate');



/*super admin routes*/
Route::get('/super-admin/application-list', [SuperAdminApplicationController::class, 'getApplicationList'])->name('superadmin-app-list');
Route::get('/super-admin/pending-application-list', [SuperAdminApplicationController::class, 'getPendingApplicationList'])->name('superadmin-app-pending-list');
Route::get('/super-admin/application-view/{id}', [SuperAdminApplicationController::class, 'getApplicationView']);
Route::get('/super-admin/payment-fee-list', [SuperAdminApplicationController::class, 'getApplicationPaymentFeeList']);

Route::get('/super-admin/application-payment-fee-view/{id}', [SuperAdminApplicationController::class, 'getApplicationPaymentFeeView']);
Route::get('/super-admin/document-list/{id}/{course_id}', [SuperAdminApplicationController::class, 'applicationDocumentList']);
Route::post('/super-admin/document-verfiy', [SuperAdminApplicationController::class, 'adminCourseDocumentVerify']);

Route::post('/super-admin-assign-secretariat', [SuperAdminApplicationController::class, 'assignSecretariat']);
Route::get('/super-admin-{nc_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [SuperAdminApplicationController::class, 'adminVerfiyDocument']);

/*Secretariat nc's super admin*/ 
Route::get('/super-admin/document-list-level-2/{id}/{course_id}', [SuperAdminApplicationController::class, 'applicationDocumentListLevel2']);
Route::post('/super-admin/document-verfiy-level-2', [SuperAdminApplicationController::class, 'adminDocumentVerifyLevel2']);    
Route::get('/super-admin-{nc_type}/verify-doc-level-2/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [SuperAdminApplicationController::class, 'adminVerfiyDocumentLevel2']);
Route::get('/super-admin-{nc_type}/{assessor_type}/verify-doc/{doc_sr_code}/{doc_name}/{application_id}/{doc_unique_code}/{application_courses_id}', [SuperAdminApplicationController::class, 'superAdminVerfiyDocumentLevel2']);
/*end here*/ 

Route::post('/super-admin-payment-acknowledge',[SuperAdminApplicationController::class,"adminPaymentAcknowledge"]);
Route::post('/super-admin-update-notification-status/{id}', [SuperAdminApplicationController::class, 'updateAdminNotificationStatus']);
Route::post('/super-admin-approved-application/', [SuperAdminApplicationController::class, 'approvedApplication']); 
Route::post('/super-admin-reject-application/{application_id}', [SuperAdminApplicationController::class, 'rejectApplication']); 
Route::post('/super-admin-approved-course', [SuperAdminApplicationController::class, 'approveCourseRejectBySecretariat']); 
Route::post('/super-admin-reject-course', [SuperAdminApplicationController::class, 'adminRejectCourse']); 

/*--end here--*/

Route::post('/super-admin/assign-extra-dates', [SuperAdminApplicationController::class, 'assignExtraDates']); 

/********Surveillance */
Route::get('/surveillance-create',[SurveillanceController::class,"index"])->name('surveillance-create');
Route::post('/surveillance',[SurveillanceController::class,"surveillanceCreate"]);
Route::get('surveillance/level-first', [SurveillanceController::class, 'level1tp']);
Route::get('surveillance/level-second', [SurveillanceController::class, 'level2tp']);
Route::get('surveillance/level-third', [SurveillanceController::class, 'level3tp']);
Route::get('create-new-applications/surveillance',[SurveillanceController::class,"createNewApplication"]);
Route::get('create-level-2-new-applications/surveillance',[SurveillanceController::class,"createNewApplication"]);
Route::get('create-level-3new-applications/surveillance',[SurveillanceController::class,"createNewApplication"]);
Route::get('/surveillance-new-course/{id?}/{refid?}', [SurveillanceController::class, 'surveillanceNewCourse']);

/********Renewal */
Route::get('/renewal-create',[RenewalController::class,"index"])->name('renewal-create');
Route::get('renewal/level-first', [RenewalController::class, 'level1tp']);
Route::get('renewal/level-second', [RenewalController::class, 'level2tp']);
Route::get('renewal/level-third', [RenewalController::class, 'level3tp']);
Route::post('/renewal',[RenewalController::class,"renewalCreate"]);
Route::get('renewal/create-new-applications',[RenewalController::class,"createNewApplication"]);
Route::get('renewal/create-level-2-new-applications',[RenewalController::class,"createLevel2NewApplication"]);
Route::get('renewal/create-level-3-new-applications',[RenewalController::class,"createLevel3NewApplication"]);
Route::get('/renewal-new-course/{id?}/{refid?}', [RenewalController::class, 'renewalNewCourse']);
Route::post('/renewal-store-new-application-course', [RenewalController::class, 'renewalStoreNewApplicationCourse']);

/*qr code generation*/
