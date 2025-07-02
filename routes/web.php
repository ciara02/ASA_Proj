<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\AzureController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\PointSystemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ISupportController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\MandaysController;
use App\Http\Controllers\ExperienceCenterController;
use App\Http\Controllers\LDAPController;
use App\Http\Controllers\EditandCloneController;
use App\Http\Controllers\EmailSending;
use App\Http\Controllers\EmailSendingController;
use App\Http\Controllers\CashAdvanceController;

//Log Out
Route::get('/getlogout', [AzureController::class, 'logout'])->name('get_logout');

///////////////////////////////// Approve and Disapprove of Email Based Approvals 


//Project Disapprove-Redirect to Disapprove page link
Route::get('/disapprove/project/{hash}', [EmailSendingController::class, 'projectdisapprovedpage'])->name('projectdisapprovedpage');
//Project Disapprove-Save-Comment
Route::post('/save-comment-project', [EmailSendingController::class, 'savecommentproject'])->name('save-comment-project');
//Disapprove
Route::get('/disapprove/{hash}', [EmailSendingController::class, 'disapprovepage'])->name('disapprove');
Route::post('/save-comment', [EmailSendingController::class, 'saveComment'])->name('save-comment');


Route::group(['middleware'=>['AuthExisted']], function(){
Route::get('/', [AzureController::class, 'login'])->name('login.page');
Route::get('/azure', [AzureController::class, 'handleRedirect'])->name('azure-auth');
Route::get('login/azure/callback', [AzureController::class, 'handleCallBack'])->name('azure.login');
});


Route::group(['middleware'=>['AuthCheck']], function(){
//LDAP
Route::get('/ldap', [LDAPController::class, 'LDAP_Engr']);

//LDAP Supervisor
Route::get('/ldapsupervisor', [LDAPController::class, 'LDAP_Supervisor']);

Route::get('/getLoggedInUser', [LDAPController::class, 'getLoggedInUser']);

// ACTIVITY REPORT
Route::get('/tab-activity', [ActivityController::class, 'index'])->name('tab-activity.index');
Route::get('/tab-activity/index/search', [ActivityController::class, 'search'])->name('tab-activity.search');

Route::get('/tab-activity/index/searchActivityReport', [ActivityController::class, 'searchActivityReport'])->name('tab-activity.searchActivityReport');

Route::get('/tab-activity/create-activity', [ActivityController::class, 'createActivity'])->name('tab-activity.create');
Route::post('/tab-activity/create-activity', [ActivityController::class, 'store'])->name('tab-activity.store');
Route::post('/tab-activity/quick-activity', [ActivityController::class, 'storeModal'])->name('tab-quick-activity.store');
Route::get('/tab-activity/create-activity/getProjectName', [ActivityController::class, 'getProjectName'])->name('tab-activity.getProjectName');
Route::get('/tab-activity/create-activity/getEngineers', [ActivityController::class, 'getEngineers']);

Route::get('/tab-activity/create-activity/getTime', [ActivityController::class, 'getTime']);
Route::get('/tab-activity/create-activity/getTime_update', [ActivityController::class, 'getTime_update']);

Route::get('/tab-activity/index/getProjName', [ActivityController::class, 'getProjName']);
Route::get('tab-activity/print', [ActivityController::class, 'print']);

Route::get('/tab-activity/index/getCompletionAcceptance', [EditandCloneController::class, 'CompletionAcceptance']);
Route::get('/tab-activity/index/getEngr', [EditandCloneController::class, 'GetEngr']);

Route::get('/tab-activity/index/getcloneReference', [EditandCloneController::class, 'getReferenceforCloning']);
Route::post('/tab-activity/index/saveclonedata', [EditandCloneController::class, 'saveCloneModal']);
Route::post('/tab-activity/index/editModal', [EditandCloneController::class, 'editModal']);

// Activity Quick Add Activity Type Modal
Route::get('/getQuickActivityTypes/{category}', [ActivityController::class, 'getQuickActivityTypes']);
// Activity Report Activity Type Modal
Route::get('/getActivityTypes/{category}', [ActivityController::class, 'getActivityTypes']);
// Activity Report Program Modal
Route::get('/getProgram/{category}', [ActivityController::class, 'getProgram']);
// Activity Report Product Code Modal
Route::get('/getProductCode/{product_line}', [ActivityController::class, 'getProductCode']);
// Activity Report Contract Details Modal
Route::get('/tab-activity/index/getContractDetails', [ActivityController::class, 'getContractDetails']);
// Activity Report Action Plan / Recommendation Modal
Route::get('/tab-activity/index/getContractDetails_actionplan', [ActivityController::class, 'ActionPlanRecommendation']);
// Activity Report Participant and Position
Route::get('/tab-activity/index/getSummaryReport', [ActivityController::class, 'getSummaryReport']);
// Activity Report Time Expected Modal
Route::get('/tab-activity/index/getSummaryReport_time', [ActivityController::class, 'getSummaryReport_time']);
// Activity Report Product Engineer Only
Route::get('/tab-activity/index/getProdEngr', [ActivityController::class, 'GetProductEngr']);
// Activity Report Copy To Engineer
Route::get('/tab-activity/index/getCopyToEngr', [ActivityController::class, 'CopyToEngineer']);
//Activity Report Product Line
Route::get('/tab-activity/index/getProdline', [ActivityController::class, 'GetProductline']);
// Activity Report Remove Program 
Route::get('/tab-activity/index/GetProgramActReport', [ActivityController::class, 'GetProgramActReport']);

// Get File 
Route::get('/tab-activity/index/getFile', [ActivityController::class, 'getFile']);
Route::get('/tab-activity/index/getDigiknowFile', [ActivityController::class, 'getDigiknowFile']);

Route::get('/tab-activity/index/getOthers', [ActivityController::class, 'getOthers']);
Route::get('/tab-activity/index/get_skills_dev', [ActivityController::class, 'get_skills_dev']);

// Activity Report Save Image
Route::post('/tab-activity/index/getImage', [EditandCloneController::class, 'GetImage']);
Route::post('/tab-activity/index/editImage', [EditandCloneController::class, 'editImage']);
Route::post('/tab-activity/index/GetDigiknowImage', [EditandCloneController::class, 'GetDigiknowImage']);
Route::post('/tab-activity/index/editDigiknowImage', [EditandCloneController::class, 'editDigiknowImage']);
Route::post('/tab-activity/index/deleteImage', [EditandCloneController::class, 'deleteImage']);

// Send Email Activity Report
Route::post('/EmailTemplate/Act-Report-Email-Forward/send', [EmailSendingController::class, 'ForwardtoEmail'])->name('forward.email');

// Send Email Activity Completion Acceptance
Route::post('/EmailTemplate/Act-Report-Email-Forward/sendtoclient', [EmailSendingController::class, 'SendtoClient'])->name('sendtoclient.email');
// Route::post('/EmailTemplate/Act-Report-Email-Forward/SendforPendingActivityAcceptance', [EmailSendingController::class, 'SendforPendingActivityAcceptance'])->name('SendforApproval.email');
Route::post('/EmailTemplate/Act-Report-Email-Forward/EditforPendingActivityAcceptance', [EmailSendingController::class, 'EditforPendingActivityAcceptance'])->name('EditApproval.email');
//Approve
Route::get('/approve/{hash}/{type}/{action}', [EmailSendingController::class, 'approve'])->name('approve');

// ACTIVITY COMPLETION ACCEPTANCE
Route::get('/tab-activity/ActivityCompletionAcceptance', [ActivityController::class, 'ActCompletionAcceptanceIndex'])->name('tab-activity-completion-acceptance.index');
Route::get('/tab-activity/getSearch', [ActivityController::class, 'getSearch'])->name('act-completion-accept.search');
Route::post('/tab-activity/getRefNumber', [ActivityController::class, 'getRefNumber']);
Route::get('/tab-activity/ActivityCompletionAcceptancePrint', [ActivityController::class, 'actCmpltAcptPrint']);
//Show Data in Datatable using AJAX
Route::get('/tab-activity/searchActCompletionAcceptanceReport', [ActivityController::class, 'searchActCompletionAcceptanceReport']);

// POINT SYSTEM
Route::get('/tab-point-system/merit-demerit', [PointSystemController::class, 'index'])->name('tab-point-system.index');
Route::get('/tab-point-system/searchSystem', [PointSystemController::class, 'searchSystem'])->name('tab-point-system.searchSystem');
Route::get('/tab-point-system/create-merit-demerit', [PointSystemController::class, 'create'])->name('tab-point-system.create-merit-demerit');
Route::post('/tab-point-system/store', [PointSystemController::class, 'store'])->name('tab-point-system.store');
Route::get('/tab-point-system/create-merit-demerit/getEngineer', [PointSystemController::class, 'getEngineers']);
Route::get('/tab-point-system/edit-merit-demerit/edit', [PointSystemController::class, 'edit'])->name('tab-point-system.edit');
Route::put('/tab-point-system/edit-merit-demerit/update', [PointSystemController::class, 'update'])->name('tab-point-system.update');
Route::get('/tab-point-system/edit-merit-demerit-approval/editForApproval', [PointSystemController::class, 'editForApproval'])->name('tab-point-system.edit-approval');
Route::put('/tab-point-system/edit-merit-demerit-approval/updateForApproval', [PointSystemController::class, 'updateForApproval'])->name('tab-point-system.update-approval');
Route::get('/tab-point-system/print-merit-demerit/', [PointSystemController::class, 'meritdemeritPrint']);
Route::post('/tab-point-system/approve', [PointSystemController::class, 'approve'])->name('tab-point-system.approve');
Route::post('/tab-point-system/disapprove', [PointSystemController::class, 'disapprove'])->name('tab-point-system.disapprove');
Route::put('/tab-point-system/levelUpdate', [PointSystemController::class, 'severityUpdate'])->name('tab-point-system.updateLevel');

Route::post('/tab-point-system/uploadPSFiles', [PointSystemController::class, 'uploadPSFiles']);
Route::post('/tab-point-system/delete-attachment', [PointSystemController::class, 'deleteAttachment'])->name('tab-point-system.delete-attachment');


// ISUPPORT SERVICES


Route::post('/tab-isupport-service/hide', [ISupportController::class, 'hide'])->name('implementation.hide');


//Cash Advance Request
Route::get('/cash-advance-request', [CashAdvanceController::class, 'showRequestForm'])->name('cash-advance.request');
Route::get('/cash-advance/approvalRequest/{hash}', [CashAdvanceController::class, 'approvalRequestView'])->name('cash-advance.request.view');
Route::get('/cash-advance/approve/{hash}', [CashAdvanceController::class, 'approve'])->name('cash-advance.request.approve');
Route::get('/cash-advance/disapprove/{hash}', [CashAdvanceController::class, 'disapprove'])->name('cash-advance.request.disapprove');
Route::post('/save-cash-advance', [CashAdvanceController::class, 'saveData'])->name('save.data');
Route::get('/get-cash-advance-request/{projectId}', [CashAdvanceController::class, 'getApprovedCashReq'])->name('get-cash-advance.request');
Route::post('/cash-advance/getCashRefNo', [CashAdvanceController::class, 'getCashRefNo'])->name('getCashRefNo.get');

//Print Download Cash Advance Request
Route::get('/cash-advance-request/print/{hash}', [CashAdvanceController::class, 'print'])->name('cash-advance.request.print');   
// Implementation menu
Route::get('/tab-isupport-service/implementation', [ISupportController::class, 'implementationIndex'])->name('tab-isupport-service.implementation.index');
Route::get('/tab-isupport-service/implementation/create', [ISupportController::class, 'implementationCreate'])->name('tab-isupport-service.implementation.create');
Route::post('/tab-isupport-service/store', [ISupportController::class, 'storeProjectOpp'])->name('tab-isupport-service.implementation.store');
Route::get('/tab-isupport-service/create/implementation/getEngineers', [ISupportController::class, 'getEngineers']);
Route::post('/tab-isupport-service/getapproversName', [ISupportController::class, 'getapproversName']);
Route::get('/tab-isupport-service/implementation/print', [ISupportController::class, 'implementationPrint'])->name('tab-isupport-service.implementation.print');

// Save Project Completion
Route::post('/EmailTemplate/Act-Report-Email-Forward/projectsavepending', [EmailSendingController::class, 'projectsavepending'])->name('project.save');

//Save Project Date
Route::post('/tab-isupport-service/implementation/saveEditProject', [ISupportController::class, 'saveEditProject'])->name('saveEditProject.save');

// Save Attachment/s
Route::post('/EmailTemplate/Act-Report-Email-Forward/SignoffAttachment', [EmailSendingController::class, 'SignoffAttachment']);

// Save Attachment/s for Project Sign Off Files
Route::post('/tab-isupport-service/signOfftAttachment', [ISupportController::class, 'signOfftAttachment']);

// Save Attachment/s for Isupport Files
Route::post('/EmailTemplate/Act-Report-Email-Forward/IsupportAttachment', [ISupportController::class, 'IsupportAttachment']);
Route::post('/EmailTemplate/Act-Report-Email-Forward/deleteAttachment', [ISupportController::class, 'deleteAttachment']);

Route::post('/tab-isupport-service/CashRequestAttachment', [ISupportController::class, 'CashRequestAttachment']);
Route::post('/tab-isupport-service/CashRequestDeleteAttachment', [ISupportController::class, 'deleteCashAdvanceAttachment']);

Route::post('/tab-isupport-service/updateProjectStatus', [ISupportController::class, 'updateProjectStatus']);

// Get Attachment
Route::get('/EmailTemplate/Act-Report-Email-Forward/RetrieveAttachment', [EmailSendingController::class, 'RetrieveAttachment']);

// Send Email 
Route::post('/EmailTemplate/Act-Report-Email-Forward/ProjectSenttoClient', [EmailSendingController::class, 'ProjectSenttoClient'])->name('project.send');

// Approve Project
Route::get('/project-approve/{hash}/{type}/{action}', [EmailSendingController::class, 'projectapprove'])->name('projectapprove'); 

//Redirect to Project Sign Off
Route::get('/EmailTemplate/Act-Report-Email-Forward/ProjectSign-Off-View', [EmailSendingController::class, 'ProjectSignOffView'])->name('completion.acceptance.approval');

//ProjectQuery
Route::get('/tab-isupport-service/getProjectCode', [ISupportController::class, 'getERPprojectCode']);
Route::get('/tab-isupport-service/getBusinessUnit', [ISupportController::class, 'getERPBusinessUnit']);

// Maintenance Agreement menu
Route::get('/tab-isupport-service/maintenance-agreement', [ISupportController::class, 'maintenanceAgreementIndex'])->name('tab-isupport-service.maintenance-agreement.index');
Route::get('/tab-isupport-service/maintenance-agreement/create', [ISupportController::class, 'maintenanceAgreementCreate'])->name('tab-isupport-service.maintenance-agreement.create');
Route::get('/tab-isupport-service/maintenance-agreement/print', [ISupportController::class, 'maintenanceAgreementPrint'])->name('tab-isupport-service.maintenance-agreement.print');
Route::post('/tab-isupport/totalMandayUsed', [ISupportController::class, 'getTotalMandaysUsed'])->name('totalmanday.get');
Route::post('/tab-isupport/MandayRefNo', [ISupportController::class, 'getMandayRefNo'])->name('MandayRefNo.get');
Route::post('/tab-isupport/PaymentStatus', [ISupportController::class, 'paymentStatus'])->name('PaymentStatus.get');

// Project Sign-off
Route::get('/tab-isupport-service/project-sign-off', [ISupportController::class, 'projectSignOffIndex'])->name('tab-isupport-service.project-sign-off.index');
Route::get('/tab-isupport-service/project-sign-off/search', [ISupportController::class, 'projectSignOffSearch'])->name('tab-isupport-service.project-sign-off.search');
Route::get('/tab-isupport-service/project-sign-off/print', [ISupportController::class, 'projectSignOffPrint'])->name('tab-isupport-service.project-sign-off.print');
Route::get('/tab-isupport-service/project-sign-off/project-signoff-modal', [ISupportController::class, 'projectSignOffModal'])->name('tab-isupport-service.project-sign-off.project-signoff-modal');
Route::put('/tab-isupport-service/update', [ISupportController::class, 'editProjectSignoffModal'])->name('tab-isupport-service.update');


// REPORT (TAB)
Route::get('/tab-report/index', [ReportController::class, 'index'])->name('tab-report.index');

Route::post('/tab-activity/getProjName', [ReportController::class, 'ProjName']);
Route::get('/tab-report/DigiKnowEngr', [ReportController::class, 'DigiKnowPerEngr'])->name('DigiKnow.Engineer');


// Manday (TAB)
Route::get('/tab-manday/index', [MandaysController::class, 'index'])->name('tab-manday.index');
Route::get('/tab-manday/getEngineers', [MandaysController::class, 'GetEngineers'])->name('Engineers.get');
Route::get('/tab-manday/getProjname', [MandaysController::class, 'GetProjName'])->name('Project-Name.get');
Route::get('/tab-manday/search', [MandaysController::class, 'getTotalMandays'])->name('search.get');

// Certification
Route::get('/tab-certifications/certifications', [CertificationController::class, 'index'])->name('tab-certifications.certification');
Route::get('/tab-certifications/print/{columnOrder?}', [CertificationController::class, 'print'])->name('tab-certifications.print');

//Experience Center
Route::get('/tab-experience-center/experience-center', [ExperienceCenterController::class, 'dashboard'])->name('tab-experience-center.experience-center');
Route::post('/tab-experience-center/experience-center/{id}', [ExperienceCenterController::class, 'store'])->name('tab-experience-center.store');
Route::get('/tab-experience-center/getExpTime', [ExperienceCenterController::class, 'getExpTime']);
Route::put('/tab-experience-center/update', [ExperienceCenterController::class, 'update'])->name('tab-experience-center.update');
Route::post('/tab-experience-center/getParticipantsName', [ExperienceCenterController::class, 'participantsName']);
Route::post('/tab-experience-center/actionPlanRecommendation', [ExperienceCenterController::class, 'actionPlanRecommendation']);
Route::get('/tab-experience-center/productLine/getProductline', [ExperienceCenterController::class, 'getProductline']);

});
