<?php

Route::POST('/users/sub_department_ajax', array('uses' => 'UsersController@sub_department_ajax'));
Route::get('/riskassessment/sub_department_ajax1', array('uses' => 'RiskassessmentController@sub_department_ajax1'));
Route::get('/riskassessmentdocuments/sub_department_ajax1', array('uses' => 'RiskassessmentdocumentsController@sub_department_ajax1'));
Route::POST('/users/sub_department_ajax', array('uses' => 'UsersController@sub_department_ajax'));
Route::get('/users/group_ajax/{id}', array('uses' => 'UsersController@group_ajax'));
Route::get('/users/department_ajax/{id}', array('uses' => 'UsersController@department_ajax'));
Route::get('/users/subdepartment_ajax/{id}/{id1}', array('uses' => 'UsersController@subdepartment_ajax'));
//=====================================below routes for steering management===================================//
Route::POST('/steering/sub_department_ajax', array('uses' => 'SteeringController@sub_department_ajax'));


// Route::POST('/steering/sub_department_ajax', array('uses' => 'SteeringController@sub_department_ajax'));
Route::get('/steering/group_ajax/{id}', array('uses' => 'SteeringController@group_ajax'));
Route::get('/steering/department_ajax/{id}', array('uses' => 'SteeringController@department_ajax'));
Route::post('/steering/subdepartment_ajax/{id}', array('uses' => 'SteeringController@subdepartment_ajax'));

//=====================================below routes for QA management===================================//
Route::POST('/qa/sub_department_ajax', array('uses' => 'QaController@sub_department_ajax'));


Route::POST('/qa/sub_department_ajax', array('uses' => 'QaController@sub_department_ajax'));
Route::get('/qa/group_ajax/{id}', array('uses' => 'QaController@group_ajax'));
Route::get('/qa/department_ajax/{id}', array('uses' => 'QaController@department_ajax'));
Route::get('/qa/subdepartment_ajax/{id}/{id1}', array('uses' => 'QaController@subdepartment_ajax'));

//Route::get('/users/sub_department_selected/{id}/{id1}', array('uses' => 'UsersController@sub_department_selected'));

Route::get('permission_ajax/{id}', array('uses' => 'RolecontrollerController@permission_ajax'));

Route::get('changes/get_hod_by_user_dep', 'ChangerequestController@get_hod_by_user_dep');

Route::get('changes/checkPrjApply/{id}', 'ChangerequestController@checkPrjApply');

Route::get('user', 'UserController@remind');
Route::get('send', 'PasswordsendController@index'); //For forget password page
Route::get('dashboard', 'DashboardController@index');//
Route::get('dashboard/findmember', 'DashboardController@findmember');//
Route::get('dashboard/findmemberdep_by_id/{id}', 'DashboardController@findmemberdep_by_id');//

Route::get('pages', 'PagesController@index');//
Route::get('changes', 'ChangerequestController@index');//
Route::get('advance-search', 'AdvancesearchController@index');//

Route::get('download/{searchid?}', 'ChangerequestController@download');//
Route::get('changes/get_chart1', 'ChangerequestController@get_chart1');//
Route::get('changes/get_chart2', 'ChangerequestController@get_chart2');//
Route::get('changes/get_chart3', 'ChangerequestController@get_chart3');//
Route::get('changes/parts_list', 'ChangerequestController@parts_list');//
Route::post('changes/submitrequest/{id}/{id1}/{id3}', 'ChangerequestController@submitrequest');//
Route::post('mailTask', 'emailTaskController@taskMail');
Route::get('changes/getExistingAttachment/{id}', 'ChangerequestController@getExistingAttachment');
Route::get('changes/getStockInfo/{id}', 'ChangerequestController@getStockInfo');


Route::post('deleteChangeReqAttachment/{id}/{id1}', 'ChangerequestController@deleteChangeReqAttachment');

Route::get('scm/supplier', 'ScmController@supplier');//

Route::get('scm/supplier/{id}', 'ScmController@supplier');//

Route::post('scm/supplier/{id}', 'ScmController@save_supplier');//

Route::get('scm/get_supplier_list', 'ScmController@get_supplier_list');//

Route::get('scm/schedular', 'ScmController@schedular');//

Route::get('send_schedule_email', 'ScmController@send_schedule_email');//
Route::post('save_cron_job', 'ScmController@save_cron_job');//


Route::get('pdf_report', 'AdvancesearchController@pdf_report');//
Route::post('generate_report', 'ReportsController@generate_report');//
Route::get('get_report_type', 'ReportsController@get_report_type');//

Route::post('advance-search-result', 'AdvancesearchController@advance_search_result');
Route::get('advance-search-result_view', 'AdvancesearchController@advance_search_result_result_view');
//
Route::post('advance-search/download', 'AdvancesearchController@advance_search_result_download');//
Route::get('reports', 'ReportsController@index');//
Route::get('changes/department', 'ChangerequestController@department');
Route::get('changes/department_for_rp', 'ChangerequestController@department_for_rp');

Route::get('changes/department1/{id}', 'ChangerequestController@department1');
Route::get('changes/checkProject/{id}', 'ChangerequestController@checkProject');
Route::get('changes/custCommunication/{id}', 'ChangerequestController@custCommunication');
// ---new route---
Route::get('changes/allDept', 'ChangerequestController@department_for_rp');
Route::get('changes/provisionOfDept', 'ChangerequestController@provisionOfDept');
Route::get('changes/checkProjCodeAvl/{id}', 'ChangerequestController@checkProjCodeAvl');

Route::get('changes/removeDept/{id}/{id1}', 'ChangerequestController@removeDept');
Route::get('changes/checkDeptAvl/{id}/{id1}', 'ChangerequestController@checkDeptAvl');
Route::get('changes/addDepartment/{id}/{id1}', 'ChangerequestController@addDepartment');
Route::get('changes/addDeptAndUser/{id}/{id1}/{id2}', 'ChangerequestController@addDeptAndUser');
Route::get('changes/addDepartmentByAdmin/{id}/{id1}/{id2}/{id3}', 'ChangerequestController@addDepartmentByAdmin');
Route::get('changes/adminProvisionForDept/{id}', 'ChangerequestController@adminProvisionForDept');
Route::get('changes/removeDeptByAdmin/{id}/{id1}/{id2}', 'ChangerequestController@removeDeptByAdmin');
Route::get('changes/check_filled_user/{id}', 'ChangerequestController@check_filled_user');
Route::get('changes/checkRiskAssPoint/{id}/{id1}', 'ChangerequestController@checkRiskAssPoint');
Route::get('changes/checkAdminAddDept/{id}', 'ChangerequestController@checkAdminAddDept');


Route::get('changes/sub_department', 'ChangerequestController@sub_department');
Route::get('changes/get_sub_dep', 'ChangerequestController@get_sub_dep');

Route::get('changes/get_hod_by_dep', 'ChangerequestController@get_hod_by_dep');
Route::get('changes/get_hod_by_user_dep', 'ChangerequestController@get_hod_by_user_dep');

Route::get('change/change_request_status/{id}', 'ChangerequestController@change_request_status');
Route::get('changes/get_cust_data/{id}', 'ChangerequestController@get_cust_data');
Route::get('changes/delete_cust_list/{id}', 'ChangerequestController@delete_cust_list');


Route::get('changes/change_stage', 'ChangerequestController@change_stage');
Route::get('reports/department', 'ReportsController@department');
Route::get('scm', 'ScmController@index');
Route::get('scm/view_attachments/{id}', 'ScmController@view_attachments');
Route::get('views', 'ViewController@index');
Route::get('views/{searchid?}', 'ViewController@index');
Route::get('changes/activity-monitoring-view/{id}/{id1}', 'ChangerequestController@activity_monitoring_view');

Route::post('changes/activity-monitoring-view/{id}/{id1}', 'ChangerequestController@activity_monitoring_view_next');




//Route::get('views/{id}', 'ViewController@index');
Route::get('view_search_result_by_dashboard/{id}', 'ViewController@view_search_result_by_dashboard');

Route::get('view_search_result/{id}', 'ViewController@view_search_result');
Route::get('view_risk_asses_data/{id}', 'ViewController@view_risk_asses_data');
Route::get('view_risk_team_member/{id}', 'ViewController@view_risk_team_member');
Route::get('get_request_info_by_id/{id}', 'ChangerequestController@get_request_info_by_id');
Route::get('get_request_info_by_id_for_status/{id}/{id1}', 'ChangerequestController@get_request_info_by_id_for_status');




Route::get('changes/get_team_lead', 'ChangerequestController@get_team_lead');


Route::POST('changes/checkAllCond', 'ChangerequestController@checkAllCond');
Route::POST('changes/addrequest', 'ChangerequestController@addrequest');
Route::get('changes/assigned_task_to_me_dashboard', 'ChangerequestController@assigned_task_to_me_dashboard');
Route::get('changes/assigned_task_by_me_dashboard', 'ChangerequestController@assigned_task_by_me_dashboard');

Route::get('changes/assigned_task_to_me', 'ChangerequestController@assigned_task_to_me');
Route::get('changes/assigned_task_by_me', 'ChangerequestController@assigned_task_by_me');
Route::get('changes/saved_cr_by_me', 'ChangerequestController@saved_cr_by_me');
Route::get('changes/customers', 'ChangerequestController@customers');
Route::get('changes/customers_for_edit', 'ChangerequestController@customers_for_edit');

Route::get('changes/customers_horizontal/{id}', 'ChangerequestController@customers_horizontal');
Route::get('changes/plantcode', 'ChangerequestController@plantcode');//For plant code data fetch
Route::get('changes/stakeholder', 'ChangerequestController@stakeholder');
Route::get('changes/projectMaster', 'ChangerequestController@projectMaster');
Route::get('changes/business', 'ChangerequestController@business');

Route::get('changes/getStage/{id}', 'ChangerequestController@getStage');
//For stakeholder data fetch

Route::get('changes/purposechange', 'ChangerequestController@purposechange');// for purpose change data fetch

Route::get('changes/purposechange_for_edit', 'ChangerequestController@purposechange_for_edit');// for purpose change data fetch


Route::get('changes/getdepartment/{id}', 'ChangerequestController@getdepartment');// for purpose change data fetch

Route::get('changes/getdepartment1/{id}', 'ChangerequestController@getdepartment1');// for purpose change data fetch
Route::get('changes/getchangetype', 'ChangerequestController@getchangetype');// for purpose change data fetch
Route::get('changes/getchangetype1/{id}', 'ChangerequestController@getchangetype1');// for purpose change data fetch


Route::get('changes/customer-communication-decision/{id}/{id1}', 'ChangerequestController@customer_communication_decision');// for purpose change data fetch
//Route::post('changes/customer-communication-decision/{id}/{id1}', 'ChangerequestController@save_customer_communication_decision');// for purpose change data fetch
Route::post('changes/save_customer_communication_decision/{id}/{id1}', 'ChangerequestController@save_customer_communication_decision');// for purpose change data fetch
Route::post('changes/save_customer_communication_decision_wno/{id}/{id1}', 'ChangerequestController@save_customer_communication_decision_wno');// for purpose change data fetch



Route::post('changes/save_customer_communication_list/{id}', 'ChangerequestController@save_customer_communication_list');// for purpose change data fetch
Route::get('changes/customer-communication-decision-attachments/{id}/{id1}', 'ChangerequestController@customer_communication_decision_attachments');

Route::get('changes/customer-communication-decision-attachment/{id}/{id1}', 'ChangerequestController@customer_communication_decision_attachment');

Route::post('changes/customer-communication-decision-attachment/{id}/{id1}', 'ChangerequestController@uploaddoc');
Route::post('changes/customer-communication-decision-attachments/{id}/{id1}', 'ChangerequestController@uploaddoc');// for purpose change data fetch
Route::get('changes/get_cust_data_attachments/{id}', 'ChangerequestController@get_cust_data_attachments');// for purpose change data fetch
Route::post('changes/delete_attachment_list/{id1}', 'ChangerequestController@delete_attachment_list');//
Route::post('changes/delete_attachment_list_activity_monitoring/{id}', 'ChangerequestController@delete_attachment_list_activity_monitoring');// for purpose change data fetch
Route::post('changes/submit_customer_communication_list_for_reject/{id}/{id1}', 'ChangerequestController@submit_customer_communication_list_for_reject');
//Route::post('changes/delete_attachment_list_activity_monitering/{id1}', 'ChangerequestController@delete_attachment_list_activity_monitering');//

Route::get('changes/update_customer_list_status/{id1}/{id2}/{id3}', 'ChangerequestController@update_customer_list_status');
Route::post('changes/submit_customer_communication_list/{id}', 'ChangerequestController@submit_customer_communication_list');
Route::get('changes/customer_communication_decision_status/{id}', 'ChangerequestController@customer_communication_decision_status');



Route::get('changes/get_sub_department_and_user/{id}', 'ChangerequestController@get_sub_department_and_user');

Route::get('changes/get_users_by_subdep/{id}', 'ChangerequestController@get_users_by_subdep');



Route::get('changes/change_status/{id}/{id1}', 'ChangerequestController@change_status');
Route::get('changes/get_request_details/{id}', 'ChangerequestController@get_request_details');

//Route::get('changes/get_request_info{id}', 'ChangerequestController@get_request_info');
Route::post('changes/changerequeststatus/{id}/{id1}', 'ChangerequestController@changerequeststatus');

Route::get('changes/profile', 'ChangerequestController@profile');
Route::get('changes/get_profile_info/{id}', 'ChangerequestController@get_profile_info');
Route::post('changes/set_profile_info', 'ChangerequestController@set_profile_info');
Route::get('changes/change-password', 'ChangerequestController@change_password');
Route::post('changes/change_password', 'ChangerequestController@change_user_password');

Route::get('changes/dashboard_counter', 'ChangerequestController@dashboard_counter');
Route::get('changes/{id}/edit_request', 'ChangerequestController@edit_request');
Route::get('user/logo', 'UserController@logo');
Route::get('user/login_pgdt', 'UserController@login_pgdt');

//Route::get('user/dashboardlogo', 'UserController@dashboardlogo');

Route::get('changes/get_edit_change_request/{id}/{id1}', 'ChangerequestController@get_edit_change_request');
Route::get('changes/edit_change_request/{id}', 'ChangerequestController@edit_change_request');


Route::get('changes/edit_change_request/{id}/{id1}', 'ChangerequestController@edit_change_request');

Route::get('changes/get_edit_change_request_parts/{id}', 'ChangerequestController@get_edit_change_request_parts');
Route::post('changes/delete_parts_change_request/{id}', 'ChangerequestController@delete_parts_change_request');
Route::post('changes/delete_all_parts_change_request/{id}', 'ChangerequestController@delete_all_parts_change_request');

Route::post('changes/updaterequest/{id}', 'ChangerequestController@updaterequest');

Route::get('scm/summary_sheet', 'ScmController@summary_sheet');
Route::get('changes/update-initial-information-sheet/{id}/{id1}', 'ChangerequestController@update_initial_information');


Route::get('changes/get_edit_change_request_cutmoer/{id}', 'ChangerequestController@get_edit_change_request_cutmoer');
Route::get('changes/recent_assigned_task_to_me', 'ChangerequestController@recent_assigned_task_to_me');
Route::get('changes/recent_assigned_task_by_me', 'ChangerequestController@recent_assigned_task_by_me');

Route::get('scm/summary_sheet', 'ScmController@summary_sheet');

Route::get('changes/fill_team/{id}', 'ChangerequestController@fill_team');// for purpose change data fetch
Route::POST('changes/add_dep_team/{id}', 'ChangerequestController@add_dep_team');//To add department and team member from Update initial sheet
Route::POST('changes/add_dep_team', 'ChangerequestController@add_dep_team');//To add department and team member from Update initial sheet

Route::get('changes/fetch_dep_team/{id}', 'ChangerequestController@fetch_dep_team');//To fetch department and team member in update initial sheet
Route::POST('changes/add_initial_info_sheet/{id}', 'ChangerequestController@add_initial_info_sheet');//To fetch department and team member in update initial sheet
Route::POST('changes/saveInfo_sheet/{id}/{id1}', 'ChangerequestController@saveInfo_sheet');
Route::get('changes/update-risk-analysis-sheet/{id}/{id1}', 'ChangerequestController@update_risk_analysis');// for update risk-analysis sheet

Route::get('changes/check_department_sheet_to_user_status/{id}/{id1}', 'ChangerequestController@check_department_sheet_to_user_status');// for update risk-analysis sheet




Route::get('changes/add_risk_admin_sheet_to_user/{id}/{id2}/{id3}', 'ChangerequestController@add_risk_admin_sheet_to_user');
Route::get('changes/cntRiskPoint/{id}', 'ChangerequestController@cntRiskPoint');// for update risk-analysis sheet

Route::get('changes/get_project/{id}', 'ChangerequestController@get_project');

Route::get('changes/get_change_request_details/{id}', 'ChangerequestController@get_change_request_details');
Route::get('changes/getCustomerVerification/{id}/{id2}', 'ChangerequestController@getCustomerVerification');
Route::get('changes/check_risk_admin_sheet_to_user_status/{id}/{id1}/{id2}', 'ChangerequestController@check_risk_admin_sheet_to_user_status');



Route::get('changes/get_all_data_as_ds/{id}', 'ChangerequestController@get_all_data_as_ds');// for update risk-analysis sheet

//Route::get('changes/delete_record/{id}', 'ChangerequestController@delete_record');
Route::get('changes/fetch_risk_assessment', 'ChangerequestController@fetch_risk_assessment');// to fetch risk assessment data
Route::POST('changes/update_risk_info_sheet', 'ChangerequestController@update_risk_info_sheet');// to add risk-assessment sheet
Route::get('changes/add_update_risk_analysis/{id}/{id1}/{id2}/{id3}/{id4}', 'ChangerequestController@add_update_risk_analysis');// to add risk-assessment sheet
Route::POST('changes/delete_table_data/{id}', 'ChangerequestController@delete_table_data');// for deleting risk assessment update sheet table data
Route::get('changes/edit_table_data/{id}/{id1}/{id2}', 'ChangerequestController@edit_table_data');// for deleting risk assessment update sheet table data
Route::POST('changes/update_table_record/{id}', 'ChangerequestController@update_table_record');// edit record in table for update risk assessment sheet 

Route::get('changes/approval-pending-risk-assesment/{id}/{id1}', 'ChangerequestController@approval_pending_risk_assesment');// for update risk-analysis sheet
Route::get('changes/get_sterring_committee', 'ChangerequestController@get_sterring_committee');// for deleting risk assessment update sheet table data
Route::get('changes/check_duplicate_sub_dep_id/{id}', 'ChangerequestController@check_duplicate_sub_dep_id');
Route::get('changes/fetch_sub_dep', 'ChangerequestController@fetch_sub_dep');
Route::POST('changes/add_pending_approval/{id}/{id1}', 'ChangerequestController@add_pending_approval');
Route::POST('changes/add_pending_approval_admin/{id}/{id1}', 'ChangerequestController@add_pending_approval_admin');
Route::get('changes/approve-allrisk-assesment/{id}/{id1}', 'ChangerequestController@approve_allrisk_assesment');
Route::get('changes/approve-all-risk-assesment/{id}/{id1}', 'ChangerequestController@approve_all_risk_assesment');
Route::get('changes/get_allRisk_assessment_approval/{id}', 'ChangerequestController@get_allRisk_assessment_approval');
Route::get('changes/getcustMem/{id}', 'ChangerequestController@getcustMem');
Route::get('changes/getHorizDeploy/{id}', 'ChangerequestController@getHorizDeploy');
Route::get('changes/get_risk_subdepartment', 'ChangerequestController@get_risk_subdepartment');
Route::get('changes/approval-risk-assesment-based-on-cost/{id}/{id1}', 'ChangerequestController@approval_risk_assesment_based_on_cost');
Route::get('changes/approval-risk-assessment-admin/{id}/{id1}', 'ChangerequestController@approval_risk_assesment_admin');

Route::get('changes/fetch_table_data/{id}', 'ChangerequestController@fetch_table_data');

Route::get('changes/fetch_table_data_asDept/{id}', 'ChangerequestController@fetch_table_data_asDept');

Route::get('changes/fetch_sterring_committee_department/{id}/{id1}', 'ChangerequestController@fetch_sterring_committee_department');
Route::get('changes/steering_committee_/{id}', 'ChangerequestController@steering_committee_');
Route::POST('changes/data_as_ds', 'ChangerequestController@data_as_ds');
Route::get('changes/get_QA_HOD', 'ChangerequestController@get_QA_HOD');
Route::get('changes/get_department_assessment_approval_for_cost/{id}', 'ChangerequestController@get_department_assessment_approval_for_cost');

Route::POST('changes/addapproval_assessment_based_oncost/{id}/{id1}/{id2}/{id3}/{id4}', 'ChangerequestController@addapproval_assessment_based_oncost');


Route::POST('changes/close_request/{id}', 'ChangerequestController@close_request');
Route::POST('changes/reject_risk_assessment_based_oncost/{id}/{id1}', 'ChangerequestController@reject_risk_assessment_based_oncost');
Route::get('changes/customer_verification/{id}/{id1}', 'ChangerequestController@customer_verification');
Route::get('changes/customer_verification_for_reject/{id}/{id1}', 'ChangerequestController@customer_verification_for_reject');


Route::POST('changes/customer_verify_for_reject/{id}/', 'ChangerequestController@customer_verify_for_reject');
Route::POST('changes/customer_verify/{id}', 'ChangerequestController@customer_verify');
Route::get('changes/activity-monitoring/{id}/{id1}', 'ChangerequestController@activity_monitoring');
Route::get('changes/get_allRisk_assessment_approval1/{id}', 'ChangerequestController@get_allRisk_assessment_approval1');
Route::get('changes/checkPrvOfCustComDecision/{id}', 'ChangerequestController@checkPrvOfCustComDecision');
Route::get('getActivityUpload/{id}/{id1}', 'ChangerequestController@getActivityUpload');
//Route::post('changes/activity-monitoring/{id}/{id1}', 'ChangerequestController@uploaddoc_activity_monitoring');


Route::post('changes/activity-monitoring/{id}/{id1}', 'ChangerequestController@uploaddoc_activity_monitoring_file');
//Route::post('changes/count/{id}', 'ChangerequestController@count_applicability');



Route::POST('changes/update_status/{id}', 'ChangerequestController@update_status');
Route::POST('changes/update_verification/{id}', 'ChangerequestController@update_verification');
Route::get('changes/activity-completion-sheet/{id}/{id1}', 'ChangerequestController@activity_completion_sheet');
Route::post('changes/verify_activity_completion_sheet/{id}/{id1}', 'ChangerequestController@verify_activity_completion_sheet');
Route::get('changes/horizontal-deployment/{id}/{id1}', 'ChangerequestController@horizontal_deployment');
Route::post('changes/horizontal_deployment_approval/{id}/{id1}', 'ChangerequestController@horizontal_deployment_approval');
Route::get('changes/before-after-status-option/{id}/{id1}', 'ChangerequestController@before_after_status_option');
Route::post('changes/before-after-status-option/{id}/{id1}', 'ChangerequestController@add_before_after_status_option');

Route::get('changes/change-management-closer/{id}/{id1}', 'ChangerequestController@change_management_closer');
Route::post('changes/close_cm_management/{id}/{id1}', 'ChangerequestController@close_cm_management');
Route::get('changes/get_data_in_modal/{id1}/{id2}/{id3}', 'ChangerequestController@get_data_in_modal');

Route::post('changes/submit_cat_attachments/{id}', 'ChangerequestController@submit_cat_attachments');

Route::get('changes/delete_data_in_modal/{id}/{id1}', 'ChangerequestController@delete_data_in_modal');
Route::post('changes/assign_task_to_next_step_frm_activity_monitoring/{id}/{id1}', 'ChangerequestController@assign_task_to_next_step_frm_activity_monitoring');
Route::post('changes/delete_pending_data_from_table/{id}', 'ChangerequestController@delete_pending_data_from_table');
Route::get('changes/customers_comm/{id}', 'ChangerequestController@customers_comm');
Route::get('changes/check_all_form_data_for_next_step/{id}/{id1}', 'ChangerequestController@check_all_form_data_for_next_step');
Route::get('changes/fetch_implementation_date_for_change/{id}', 'ChangerequestController@fetch_implementation_date_for_change');

Route::get('changes/get_verification_data/{id}', 'ChangerequestController@get_verification_data');

Route::get('changes/reminder_email/', 'ChangerequestController@reminder_email');

Route::get('changes/check_save_customer_communication_decision/{id}', 'ChangerequestController@check_save_customer_communication_decision');


Route::get('changes/fetch_ad_data/{id}', 'ChangerequestController@fetch_ad_data');
Route::post('changeReqUpload', 'ChangerequestController@changeReqUpload');


Route::get('modifyChangeRequest', 'modifyChangeRequestController@index');

Route::get('changerequestModify', 'modifyChangeRequestController@changerequestModify');
Route::get('getChangeRequest', 'modifyChangeRequestController@getChangeRequest');

Route::post('changeRequestModifyDetails', 'modifyChangeRequestController@changeRequestModifyDetails');
Route::get('changeRequestModifyDetails', 'modifyChangeRequestController@changeRequestedit');
Route::get('beforeAfterView/{id}', 'modifyChangeRequestController@beforeAfterView');
Route::post('changes/customer-communication-decision-attachments/{id}/{id1}', 'ChangerequestController@uploaddoc');

Route::get('changes/getCustomerCommDecision/{id}', 'ChangerequestController@getCustomerCommDecision');
Route::post('riskAssessFill', 'modifyChangeRequestController@riskAssessFill');
Route::post('checkUserDefined', 'modifyChangeRequestController@checkUserDefined');
Route::post('getCustCommDecision', 'modifyChangeRequestController@getCustCommDecision');
Route::post('getCustverification', 'modifyChangeRequestController@getCustverification');
Route::post('deptAvilable', 'modifyChangeRequestController@deptAvilable');
Route::post('getBeforeAfterStatus', 'modifyChangeRequestController@getBeforeAfterStatus');
Route::post('fetch_changed_file/{id}', 'modifyChangeRequestController@fetch_changed_file');
Route::post('total_file/{id}', 'modifyChangeRequestController@total_file');
Route::post('fetch_changed_date/{id}', 'modifyChangeRequestController@fetch_changed_date');
Route::post('deleteRecord/{id}/{id1}/{id2}', 'modifyChangeRequestController@deleteRecord');
Route::post('before_after_status_option_by_admin/{id}', 'modifyChangeRequestController@before_after_status_option_by_admin');
Route::get('before_after_status_option_by_admin/{id}', 'modifyChangeRequestController@before_after_status_option_by_admin');
Route::get('cntFile/{id}/{id1}/{id2}','ChangerequestController@cntFile');


//--------------- tracking sheet----
Route::get('tracking_sheet','trackingSheetController@index');
Route::post('trackingSheet/download', 'trackingSheetController@advance_search_result_download');//------------end--------------

Route::get('/DepartmentList/get_department/{id}', array('uses' => 'departmentListController@get_department'));

Route::get('/SteeringCommiteeMember/get_SteeringComm/{id}', array('uses' => 'SteeringCommiteeController@get_SteeringComm'));

Route::post('/projectMaster/get_User', array('uses' => 'projectMasterController@get_User'));
Route::post('/projectMaster/save_User', array('uses' => 'projectMasterController@save_User'));

Route::post('/projectMaster/deleteDepartment', array('uses' => 'projectMasterController@deleteDepartment'));
Route::post('/projectMaster/getDepartment', array('uses' => 'projectMasterController@getDepartment'));

Route::post('/projectMaster/checkProject', array('uses' => 'projectMasterController@checkProject'));


Route::POST('changes/checkCustComm/{id}/{id1}', 'ChangerequestController@checkCustComm');
Route::get('changes/getChangeReqDept/{id}', 'ChangerequestController@getChangeReqDept');

Route::get('changes/PTR_document/{id}/{id1}', 'ChangerequestController@PTR_document');


Route::Post('changes/PTR_doc_upload/{id}/{id1}', 'ChangerequestController@PTR_doc_upload');
Route::get('/changes/checkCustDrivenChange', 'ChangerequestController@checkCustDrivenChange');
Route::get('changes/checkUserActive/{id}', 'ChangerequestController@checkUserActive');
Route::post('changes/completeAllPoints/{id}/{id1}','ChangerequestController@completeAllPoints');

Route::get('pending_task','pendingTaskController@index');

Route::post('pending_task/download', 'pendingTaskController@advance_search_result_download');
Route::get('changes/uploadFileExtension','ChangerequestController@uploadFileExtension');
Route::post('changes/getDay','ChangerequestController@getDay');

Route::post('projectMaster/add_deptart','projectMasterController@add_deptart');
Route::get('changes/get_inititor_dept','ChangerequestController@get_inititor_dept');
Route::get('changes/checkDeptParam','ChangerequestController@checkDeptParam');
Route::get('changes/get_current_date','ChangerequestController@get_current_date');
Route::get('changes/get_changeSubType/{id}','ChangerequestController@get_changeSubType');
Route::post('/projectMaster/setStageSess', array('uses' => 'projectMasterController@setStageSess'));

Route::post('projectMaster/changeReqUpload1', 'projectMasterController@changeReqUpload1');

?>


