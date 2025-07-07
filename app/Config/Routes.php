<?php

namespace Config;    

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
 
/* 
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');    
$routes->setDefaultController('LoginController');  
$routes->setDefaultMethod('index');                 
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*  
 * --------------------------------------------------------------------
 * Route Definitions
 * -------------------------------------------------------------------- 
 */

$routes->get('phpinfo', function () {
    phpinfo();
});


$routes->get('/email_form', 'Email_controller::index',['filter'=>'authGuard']);
$routes->post('/send_email', 'Email_controller::send_email',['filter'=>'authGuard']);

$routes->get('/bill_wise_reword_report', 'CommissionController::bill_wise_reword_report',['filter'=>'authGuard']);
$routes->post('/bill_wise_reword_report_export', 'CommissionController::bill_wise_reword_report_export',['filter'=>'authGuard']);
 //-----------------------------commission_dashboard Routes------------------------ 


 $routes->get('/commission_dashboard', 'CommissionController::commission_dashboard',['filter'=>'authGuard']); 
$routes->post('/set_RequestRewardPoint', 'CommissionController::set_RequestRewardPoint',['filter'=>'authGuard']); 

$routes->get('/View_Request_Reward_Point_history', 'CommissionController::View_Request_Reward_Point_history',['filter'=>'authGuard']); 
$routes->post('/del_Request_Reward_Point_history', 'CommissionController::del_Request_Reward_Point_history',['filter'=>'authGuard']);

$routes->post('/Request_Reward_Point_history_StatusChange', 'CommissionController::Request_Reward_Point_history_StatusChange',['filter'=>'authGuard']);
$routes->get('/allcompanyemployeereward', 'CompenyController::allcompanyemployeereward',['filter'=>'authGuard']); 
$routes->get('/update-bank-details', 'EmployeeController::user_bank_details',['filter'=>'authGuard']); 
$routes->post('/update-details', 'EmployeeController::update_bankdetails',['filter'=>'authGuard']); 
$routes->post('/update-conversionprice', 'CompenyController::update_convrsionpoint',['filter'=>'authGuard']); 
$routes->post('/update-state-of-reward', 'CommissionController::update_state_of_reward',['filter'=>'authGuard']); 
$routes->get('/view-reward-company-wise/(:num)', 'CompenyController::viewrewardcompanywise/$1',['filter'=>'authGuard']); 
//-------------------------------------------------------------------- 


 //-----------------------------Master Action Routes------------------------ 

$routes->post('/add_master_action', 'MasterActionController::add_master_action',['filter'=>'authGuard']); 

 $routes->get('/view_master_action', 'MasterActionController::view_master_action',['filter'=>'authGuard']); 


 $routes->post('/del_master_action', 'MasterActionController::del_master_action',['filter'=>'authGuard']);
$routes->post('/update_master_action', 'MasterActionController::update_master_action',['filter'=>'authGuard']);

//-------------------------------------------------------------------- 
//-----------------------------department Routes------------------------ 
$routes->post('/add_department', 'DepartmentController::add_department',['filter'=>'authGuard']); 
$routes->get('/view_department', 'DepartmentController::view_department',['filter'=>'authGuard']); 
$routes->post('/del_Department', 'DepartmentController::del_Department',['filter'=>'authGuard']);
$routes->post('/update_Department', 'DepartmentController::update_Department',['filter'=>'authGuard']);
$routes->get('/getDepartment2','DepartmentController::getDepartment2',['filter'=>'authGuard']); 
$routes->get('/getDepartment3','DepartmentController::getDepartment3',['filter'=>'authGuard']); 

$routes->post('/add-department-name', 'DepartmentnameController::adddepartmentname',['filter'=>'authGuard']); 
$routes->get('/view-department-name', 'DepartmentnameController::viewdepartmentname',['filter'=>'authGuard']); 
$routes->post('/update-department-name', 'DepartmentnameController::updatedepartmentname',['filter'=>'authGuard']);
$routes->post('/del-department-name', 'DepartmentnameController::deldepartmentname',['filter'=>'authGuard']);


//-----------------------------Unit Routes------------------------ 

$routes->post('/add_unit', 'UnitController::add_unit',['filter'=>'authGuard']); 

 $routes->get('/view_unit', 'UnitController::view_unit',['filter'=>'authGuard']); 
 //$routes->get('/view_unit/(:any)', 'UnitController::view_unit/$1',['filter'=>'authGuard']);

 $routes->post('/del_unit', 'UnitController::del_unit',['filter'=>'authGuard']);
$routes->post('/update_unit', 'UnitController::update_unit',['filter'=>'authGuard']);

$routes->get('/getUnit','UnitController::getUnit',['filter'=>'authGuard']); 
//-------------------------------------------------------------------- 

 //-----------------------------Compeny Routes------------------------ 

$routes->post('/add_compeny', 'CompenyController::add_compeny',['filter'=>'authGuard']); 

 $routes->get('/view_compeny', 'CompenyController::view_compeny',['filter'=>'authGuard']); 


 $routes->post('/del_compeny', 'CompenyController::del_compeny',['filter'=>'authGuard']);
$routes->post('/update_compeny', 'CompenyController::update_compeny',['filter'=>'authGuard']);

//$routes->get('/getUnit','CompenyController::getUnit',['filter'=>'authGuard']); 
//-------------------------------------------------------------------- 

 //-----------------------------Bill Type Routes------------------------ 

$routes->post('/add_billtype', 'BillTypeController::add_billtype',['filter'=>'authGuard']); 

 $routes->get('/view_billType', 'BillTypeController::view_billType',['filter'=>'authGuard']); 


 $routes->post('/del_billType', 'BillTypeController::del_billType',['filter'=>'authGuard']);
$routes->post('/update_billType', 'BillTypeController::update_billType',['filter'=>'authGuard']);


//-------------------------------------------------------------------- 

  //-----------------------------Season Session_Year Routes------------------------ 

$routes->post('/add_SeasonSession_Year', 'SeasonSessionYearController::add_SeasonSession_Year',['filter'=>'authGuard']); 

 $routes->get('/view_SeasonSession_Year', 'SeasonSessionYearController::view_SeasonSession_Year',['filter'=>'authGuard']); 

 $routes->post('/del_SeasonSession_Year', 'SeasonSessionYearController::del_SeasonSession_Year',['filter'=>'authGuard']);
$routes->post('/update_SeasonSession_Year', 'SeasonSessionYearController::update_SeasonSession_Year',['filter'=>'authGuard']);
//-------------------------------------------------------------------- 
//---------------------Admin Routes 1------------------------------------------ 



$routes->get('/admin-dashboard', 'AdminController::index',['filter'=>'authGuard']); 
$routes->get('/main-dashboard', 'AdminController::main_dashboard',['filter'=>'authGuard']);
$routes->get('/vendor-dashboard', 'AdminController::vendor_dashboard',['filter'=>'authGuard']);
$routes->get('/page-list', 'AdminController::pagelist',['filter'=>'authGuard']);
$routes->post('/addpage-employee', 'AdminController::addpagetoemployee',['filter'=>'authGuard']);
$routes->post('/get_employee_pages', 'AdminController::getEmployeePages',['filter'=>'authGuard']);
$routes->post('/get-company-vendor', 'AdminController::getCompanyPages',['filter'=>'authGuard']);
$routes->get('/allmessagerequest', 'AdminController::allmessagerequest',['filter'=>'authGuard']);
$routes->get('/add-vendor-in-organization', 'AdminController::addvendorinorganization',['filter'=>'authGuard']);
$routes->post('/add-vendor-to-company', 'AdminController::addvendortocompany',['filter'=>'authGuard']);
$routes->get('/view-recent-login', 'AdminController::recentLogin',['filter'=>'authGuard']);
$routes->get('/view-recent-vendor-login', 'AdminController::recentVendorLogin',['filter'=>'authGuard']);
// $routes->post('/get-vendor-company', 'AdminController::getVendorPages',['filter'=>'authGuard']);
// $routes->get('/add-company-in-vendor', 'AdminController::addcompanyinvendor',['filter'=>'authGuard']);
// $routes->post('/add-company-to-vendor', 'AdminController::addcompanytovendor',['filter'=>'authGuard']);

$routes->post('/get-vendor-company', 'AdminController::getVendorPages', ['filter' => 'authGuard']);

$routes->get('/add-company-in-vendor', 'AdminController::addcompanyinvendor', ['filter' => 'authGuard']);

$routes->post('/add-company-to-vendor', 'AdminController::addcompanytovendor', ['filter' => 'authGuard']);

$routes->post('/fetch-vendor-companies', 'AdminController::fetchVendorCompanies', ['filter' => 'authGuard']);

$routes->post('/update-vendor-companies', 'AdminController::updateVendorCompanies', ['filter' => 'authGuard']);

$routes->post('/remove-mapped-companies', 'AdminController::removeMappedCompanies', ['filter' => 'authGuard']);
$routes->get('/view-dashboard', 'AdminController::view_dashboard',['filter'=>'authGuard']);
$routes->post('/set_startDate_endDate', 'AdminController::set_startDate_endDate',['filter'=>'authGuard']);
$routes->get('/Help_Support_list', 'AdminController::Help_Support_list',['filter'=>'authGuard']); 
$routes->get('/complete-detail-of-help-support/(:num)', 'AdminController::complete_detail_of_help_support/$1',['filter'=>'authGuard']); 
$routes->post('/Recived_Help_StatusChange', 'AdminController::Recived_Help_StatusChange',['filter'=>'authGuard']);
$routes->post('/Comment_Support_Help', 'AdminController::Comment_Support_Help',['filter'=>'authGuard']);
$routes->get('/view_compeny_add_request', 'AdminController::view_compeny_add_request',['filter'=>'authGuard']);
$routes->post('/compeny_add_request_StatusChange', 'AdminController::compeny_add_request_StatusChange',['filter'=>'authGuard']);
$routes->get('/Vendor_Product_list', 'AdminController::Vendor_Product_list',['filter'=>'authGuard']);
// $routes->get('/fetchVendorProducts/(:num)', 'AdminController::fetchVendorProducts/$1');
// $routes->get('/viewVendorProducts/(:num)', 'AdminController::viewVendorProducts/$1');
// new url added from here 5 oct 2024
$routes->get('/viewVendorSubQuotation/(:num)', 'AdminController::viewVendorSubQuotation/$1');
$routes->get('/viewVendorProductsDetails/(:num)', 'AdminController::viewVendorProductsDetails/$1');
$routes->get('/fetchVendorProducts/(:num)/(:num)', 'AdminController::fetchVendorProducts/$1/$2');
// $routes->post('/updateRevisionMessage', 'QuotationController::updateRevisionMessage');
$routes->post('/updateRevisionMessage', 'AdminController::updateRevisionMessage');
$routes->get('/viewVendorProducts/(:num)/(:num)', 'AdminController::viewVendorProducts/$1/$2');
// $routes->get('/viewVendorProducts/(:num)/(:num)', 'AdminController::viewVendorProducts/$1/$2');
$routes->post('/submitVendorOrder', 'AdminController::submitVendorOrder');
$routes->get('/Ordered_Quotation_Product_list', 'AdminController::Ordered_Quotation_Product_list',['filter'=>'authGuard']);
$routes->get('/editVendorOrder/(:num)', 'AdminController::editVendorOrder/$1',['filter'=>'authGuard']);
$routes->post('/updateVendorOrder', 'AdminController::updateVendorOrder',['filter'=>'authGuard']);
// $routes->post('/updateVendorOrder/(:num)', 'AdminController::updateVendorOrder/$1', ['filter' => 'authGuard']);
// $routes->post('/updateVendorOrder/(:num)', 'AdminController::updateVendorOrder/$1', ['filter' => 'authGuard']);
$routes->get('/getOrderProductDetails/(:num)', 'AdminController::getOrderProductDetails/$1',['filter'=>'authGuard']);
// $routes->get('/getOrderProductDetails/(:num)', 'AdminController::getOrderProductDetails/$1');
// $routes->get('/checkStatus/(:num)', 'AdminController::checkStatus/$1',['filter'=>'authGuard']);
// $routes->get('/checkStatus/(:num)/(:num)/(:num)', 'AdminController::checkStatus/$1/$2/$3', ['filter' => 'authGuard']);
// $routes->get('/checkStatus/(:num)/(:num)/(:num)', 'AdminController::checkStatus/$1/$2/$3', ['filter' => 'authGuard']);
$routes->get('/checkStatus/(:num)/(:num)/(:num)/(:num)/(:num)', 'AdminController::checkStatus/$1/$2/$3/$4/$5', ['filter' => 'authGuard']);
$routes->get('/checkDeliveredStatus/(:num)/(:num)', 'AdminController::checkDeliveredStatus/$1/$2',['filter'=>'authGuard']);
$routes->post('/deleteQuotation', 'AdminController::deleteQuotation',['filter'=>'authGuard']);



//---------------------------------------------------------------------------

//----------------Login Routes  & Default Controller---------- 
$routes->get('/', 'LoginController::index'); 
$routes->post('/authenticate', 'LoginController::CheckLog'); 
$routes->get('/logout', 'LoginController::logout',['filter'=>'authGuard']);   
$routes->post('/DirectUserLogin', 'LoginController::DirectUserLogin'); 

$routes->get('/vendor_login', 'LoginController::vendor_login'); 
$routes->post('/vendor_authenticate', 'LoginController::Vendor_CheckLog'); 
$routes->get('/vendor_profile', 'LoginController::vendor_profile',['filter'=>'authGuard']);

$routes->get('/vendor_profile_active', 'LoginController::vendor_profile_active',['filter'=>'authGuard']);
$routes->get('/profile','LoginController::profile',['filter'=>'authGuard']);
//------------------------------------------------------------       
                                                                              
//-----------------------------User(employees)/Consultant Routes------------------------ 
$routes->get('/employee-dashboard', 'EmployeeController::dashboard',['filter'=>'authGuard']); 
$routes->get('/add-user', 'EmployeeController::index',['filter'=>'authGuard']);  
$routes->get('/user_details', 'EmployeeController::user_details',['filter'=>'authGuard']); 
$routes->post('/set-employee', 'EmployeeController::store_employee',['filter'=>'authGuard']); 
$routes->post('/update-employee', 'EmployeeController::update_employee',['filter'=>'authGuard']);
$routes->post('/del-emp', 'EmployeeController::employee_delete',['filter'=>'authGuard']);  
$routes->get('/getCompenyEmpolyee','EmployeeController::getCompenyEmpolyee',['filter'=>'authGuard']); 
$routes->get('/getcityx','EmployeeController::getcity',['filter'=>'authGuard']);          
$routes->get('/getsamecityx','EmployeeController::getsamecity',['filter'=>'authGuard']); 
$routes->get('/profile/(:num)','EmployeeController::profile/$1',['filter'=>'authGuard']); 
$routes->post('/update-profile','EmployeeController::update_profile',['filter'=>'authGuard']);  
$routes->get('/change-password','EmployeeController::change_password',['filter'=>'authGuard']);
$routes->get('/check_old_pass','EmployeeController::check_old_pass',['filter'=>'authGuard']);
$routes->post('/change_pass','EmployeeController::update_pass',['filter'=>'authGuard']);
$routes->post('/lock-emp','EmployeeController::lock_emp',['filter'=>'authGuard']); 
$routes->post('/unlock-emp','EmployeeController::un_lock_emp',['filter'=>'authGuard']);   
$routes->post('/role-emp-mng','EmployeeController::role_emp_mng',['filter'=>'authGuard']);
$routes->post('/Userupdate_pass','EmployeeController::Userupdate_pass',['filter'=>'authGuard']);
$routes->get('/getstatewisecity','EmployeeController::getstatewisecity',['filter'=>'authGuard']);

$routes->get('/test', 'BillRegisterController::test',['filter'=>'authGuard']); 

//--------------------------------------------------------------------  
                               
$routes->get('/vendor-change-password','PartyUserController::vendor_change_password',['filter'=>'authGuard']);
$routes->get('/vendor-check-old-pass','PartyUserController::vendor_check_old_pass',['filter'=>'authGuard']);
$routes->post('/vendor-change-pass','PartyUserController::vendor_update_pass',['filter'=>'authGuard']);
$routes->get('/all-bill-vendor-completed-list','BillRegisterController::all_bill_vendor_completed_list',['filter'=>'authGuard']);
$routes->get('/all-vendor-rejected-list','BillRegisterController::all_vendor_rejected_list',['filter'=>'authGuard']);

//-----------------------------Bill Registe Routes------------------------   

$routes->get('/add_bill_register', 'BillRegisterController::index',['filter'=>'authGuard']); 
$routes->post('/set_bill_register', 'BillRegisterController::store_bill_register',['filter'=>'authGuard']); 
$routes->get('/view_bill_register', 'BillRegisterController::view_bill_register',['filter'=>'authGuard']); 
$routes->get('/view_bill_register_vendor_draft', 'BillRegisterController::view_bill_register_vendor_draft',['filter'=>'authGuard']);
$routes->get('/bill_edit/(:num)', 'BillRegisterController::bill_edit/$1',['filter'=>'authGuard']); 

$routes->get('/add-bill-vendor', 'BillRegisterController::add_bill_vendor',['filter'=>'authGuard']); 
$routes->post('/update-bill-vendor-comment', 'BillRegisterController::update_bill_vendor_comment',['filter'=>'authGuard']); 
$routes->post('/vendor-bill-received', 'BillRegisterController::vendor_bill_received',['filter'=>'authGuard']); 
$routes->post('/bill-draft-delete', 'BillRegisterController::bill_draft_delete',['filter'=>'authGuard']);

$routes->post('/del_bill_register', 'BillRegisterController::bill_register_delete',['filter'=>'authGuard']);
$routes->post('/update_bill_register', 'BillRegisterController::update_bill_register',['filter'=>'authGuard']);
$routes->get('/view_bill_register_print/(:any)', 'BillRegisterController::view_bill_register_print/$1',['filter'=>'authGuard']);
$routes->get('/bill_style_uid_delete/(:num)', 'BillRegisterController::bill_style_uid_delete/$1',['filter'=>'authGuard']);

$routes->get('/getDepartmentUser','BillRegisterController::getDepartmentUser',['filter'=>'authGuard']);

$routes->post('/vendor-store-bill-register', 'BillRegisterController::vendor_store_bill_register',['filter'=>'authGuard']); 
$routes->get('/view-vendor-bill', 'BillRegisterController::view_vendor_bill',['filter'=>'authGuard']); 

$routes->get('/scanqr', 'BillRegisterController::scanqr',['filter'=>'authGuard']); 

$routes->get('/page-404', 'BillRegisterController::page404',['filter'=>'authGuard']); 
$routes->get('/complete-detail-of-sigle-bill/(:num)', 'BillRegisterController::complete_detail_of_sigle_bill/$1',['filter'=>'authGuard']); 

$routes->get('/generate_bill_shipped', 'BillRegisterController::generate_bill_shipped',['filter'=>'authGuard']); 
$routes->post('/generate_bill_shipped_save', 'BillRegisterController::generate_bill_shipped_save',['filter'=>'authGuard']); 

//-----------------------------Bill Manage Mapping Routes------------------------  
$routes->get('/pending_bill_mapping', 'BillRegisterController::pending_bill_mapping',['filter'=>'authGuard']); 
$routes->post('/Bill_Acceptation_StatusChange', 'BillRegisterController::Bill_Acceptation_StatusChange',['filter'=>'authGuard']);

$routes->get('/accepted_bill_mapping', 'BillRegisterController::accepted_bill_mapping',['filter'=>'authGuard']); 

$routes->post('/Department_Mapping_BillReg', 'BillRegisterController::Department_Mapping_BillReg',['filter'=>'authGuard']);
$routes->get('/done_bill_mapping', 'BillRegisterController::done_bill_mapping',['filter'=>'authGuard']); 
$routes->get('/reject_bill_mapping', 'BillRegisterController::reject_bill_mapping',['filter'=>'authGuard']); 

$routes->get('/all_bill_mapping_list', 'BillRegisterController::all_bill_mapping_list',['filter'=>'authGuard']); 
$routes->get('/all-bill-mapping-vendor-list', 'BillRegisterController::all_bill_mapping_vendor_list',['filter'=>'authGuard']); 
$routes->get('/all-vendor-bill-compnay-wise/(:num)', 'BillRegisterController::all_vendor_bill_company_wise/$1',['filter'=>'authGuard']); 

$routes->get('/ajax','BillRegisterController::ajax',['filter'=>'authGuard']);
$routes->get('/ajax_single_mapping','BillRegisterController::ajax_single_mapping',['filter'=>'authGuard']);

$routes->get('/sigle_bill_list/(:num)', 'BillRegisterController::sigle_bill_list/$1',['filter'=>'authGuard']); 

//-----------------------------Clear_Bill_Form Routes------------------------  
$routes->get('/pending_Clear_Bill_Form', 'BillRegisterController::pending_Clear_Bill_Form',['filter'=>'authGuard']); 
$routes->post('/Clear_Bill_Form_StatusChange', 'BillRegisterController::Clear_Bill_Form_StatusChange',['filter'=>'authGuard']);

$routes->get('/accepted_Clear_Bill_Form', 'BillRegisterController::accepted_Clear_Bill_Form',['filter'=>'authGuard']); 

$routes->post('/CheckUp_Clear_Bill_Form', 'BillRegisterController::CheckUp_Clear_Bill_Form',['filter'=>'authGuard']);

$routes->post('/MasterAction_send', 'BillRegisterController::MasterAction_send',['filter'=>'authGuard']);

$routes->get('/done_Clear_Bill_Form', 'BillRegisterController::done_Clear_Bill_Form',['filter'=>'authGuard']); 
$routes->get('/reject_Clear_Bill_Form', 'BillRegisterController::reject_Clear_Bill_Form',['filter'=>'authGuard']); 


$routes->get('/all_Clear_Bill_Form_list', 'BillRegisterController::all_Clear_Bill_Form_list',['filter'=>'authGuard']);
$routes->get('/all-Clear-Bill-Form-vendor-list', 'BillRegisterController::all_Clear_Bill_Form_vendor_list',['filter'=>'authGuard']);

//-----------------------------Bill Manage ERP System Routes------------------------  


$routes->get('/ERP_System_Pending', 'BillRegisterController::ERP_System_Pending',['filter'=>'authGuard']); 

$routes->post('/ERP_StatusChange', 'BillRegisterController::ERP_StatusChange',['filter'=>'authGuard']);
$routes->get('/accepted_bill_ERPSytem', 'BillRegisterController::accepted_bill_ERPSytem',['filter'=>'authGuard']); 
$routes->post('/CheckUp_bill_ERPSytem', 'BillRegisterController::CheckUp_bill_ERPSytem',['filter'=>'authGuard']);
$routes->get('/ERP_System_Done', 'BillRegisterController::ERP_System_Done',['filter'=>'authGuard']);

$routes->get('/ERP_System_Reject', 'BillRegisterController::ERP_System_Reject',['filter'=>'authGuard']); 

$routes->post('/ERPStatus_BillReg', 'BillRegisterController::ERPStatus_BillReg',['filter'=>'authGuard']); 

$routes->get('/all_erpStystem_list', 'BillRegisterController::all_erpStystem_list',['filter'=>'authGuard']); 
$routes->get('/all-erpSystem-vendor-list', 'BillRegisterController::all_erpStystem_vendor_list',['filter'=>'authGuard']); 
//-----------------------------  Recived Bill Routes------------------------  


$routes->get('/pending_recived_bill', 'BillRegisterController::pending_recived_bill',['filter'=>'authGuard']); 

$routes->post('/RecivedBill_StatusChange', 'BillRegisterController::RecivedBill_StatusChange',['filter'=>'authGuard']);
$routes->get('/accepted_recived_bill', 'BillRegisterController::accepted_recived_bill',['filter'=>'authGuard']); 
$routes->post('/CheckUp_RecivedBill', 'BillRegisterController::CheckUp_RecivedBill',['filter'=>'authGuard']);
//$routes->get('/ERP_System_Done', 'BillRegisterController::ERP_System_Done',['filter'=>'authGuard']);

//$routes->get('/ERP_System_Reject', 'BillRegisterController::ERP_System_Reject',['filter'=>'authGuard']); 

$routes->get('/all_recived_bill_list', 'BillRegisterController::all_recived_bill_list',['filter'=>'authGuard']); 
$routes->get('/all-recived-bill-vendor-list', 'BillRegisterController::all_recived_bill_vendor_list',['filter'=>'authGuard']); 

$routes->get('/view_complete_bill_list', 'BillRegisterController::view_complete_bill_list',['filter'=>'authGuard']); 

$routes->post('/updatemodalpopup', 'BillRegisterController::onmodalpopup',['filter'=>'authGuard']); 
$routes->get('/ajaxshowform', 'BillRegisterController::ajaxshowform',['filter'=>'authGuard']); 
$routes->post('/submitformasteraction', 'BillRegisterController::submitformasteraction',['filter'=>'authGuard']); 
$routes->post('/submitbillforverification', 'BillRegisterController::submitbillforverification',['filter'=>'authGuard']); 
$routes->post('/submitbillformasterverification', 'BillRegisterController::submitBillForMasterVerification',['filter'=>'authGuard']); 
$routes->post('/sendbilltoentry', 'BillRegisterController::sendBilltoentry',['filter'=>'authGuard']); 
$routes->post('/erpacceptbill', 'BillRegisterController::erpacceptbill',['filter'=>'authGuard']); 
$routes->post('/sendtobillreceiving', 'BillRegisterController::sendToBillReceiving',['filter'=>'authGuard']);
$routes->post('/billreceivedaccept', 'BillRegisterController::billreceivedaccept',['filter'=>'authGuard']);
$routes->post('/completefromBillReceiving', 'BillRegisterController::completefromBillReceiving',['filter'=>'authGuard']);

$routes->get('/view-bill-received-list', 'BillRegisterController::view_bill_received_list',['filter'=>'authGuard']); 
$routes->get('/view-bill-entry-list', 'BillRegisterController::view_bill_entry_list',['filter'=>'authGuard']); 
$routes->get('/view-bill-verify-list', 'BillRegisterController::view_bill_verify_list',['filter'=>'authGuard']);
$routes->get('/view-bill-assignment-list', 'BillRegisterController::view_bill_assignment_list',['filter'=>'authGuard']);
$routes->get('/exportDataToExcel_Vendor', 'BillRegisterController::exportDataToExcel_Vendor',['filter'=>'authGuard']);

//-----------------------------BillRegister Excel Export Routes------------------------ 

$routes->post('/complete_bill_report_export', 'BillRegisterController::complete_bill_report_export',['filter'=>'authGuard']);
$routes->get('/export_party_user', 'PartyUserController::export_party_user',['filter'=>'authGuard']); 
$routes->get('/export_all_bill_mapping_list', 'BillRegisterController::export_all_bill_mapping_list',['filter'=>'authGuard']); 
$routes->get('/export_all_Clear_Bill_Form_list', 'BillRegisterController::export_all_Clear_Bill_Form_list',['filter'=>'authGuard']); 
$routes->get('/export_all_erpStystem_list', 'BillRegisterController::export_all_erpStystem_list',['filter'=>'authGuard']); 
$routes->get('/export_all_recived_bill_list', 'BillRegisterController::export_all_recived_bill_list',['filter'=>'authGuard']); 
$routes->get('/export_view_complete_bill_list', 'BillRegisterController::export_view_complete_bill_list',['filter'=>'authGuard']); 
$routes->get('/reword_report', 'CommissionController::reword_report',['filter'=>'authGuard']); 
$routes->get('/export_reword_report', 'CommissionController::export_reword_report',['filter'=>'authGuard']); 

//-----------------------------BillRegister Excel Export Routes------------------------ 
//-----------------------------party_user Routes------------------------ 

$routes->get('/add_party_user', 'PartyUserController::index',['filter'=>'authGuard']); 
$routes->post('/set_party_user', 'PartyUserController::store_party_user',['filter'=>'authGuard']); 
$routes->get('/view_party_user', 'PartyUserController::view_party_user',['filter'=>'authGuard']); 
$routes->post('/del_party_user', 'PartyUserController::del_party_user',['filter'=>'authGuard']);
$routes->post('/update_party_user', 'PartyUserController::update_party_user',['filter'=>'authGuard']);
$routes->get('/VendorDetails_ajax','PartyUserController::VendorDetails_ajax',['filter'=>'authGuard']);
$routes->get('/vendor-registration','PartyUserController::vendorregistration');
$routes->post('/save-vendor','PartyUserController::save_vendor');
$routes->get('/get-vendor-detail-from-ajax','PartyUserController::getvendordetailfromajax');
$routes->get('/getcityforvendorregistration','EmployeeController::getcity'); 
$routes->get('/vlogout', 'LoginController::vendorlogout',['filter'=>'authGuard']);  
$routes->get('/choose-payment', 'PartyUserController::choosepaymentmethod',['filter'=>'authGuard']);
$routes->post('/activate-vendor', 'PartyUserController::activate_vendor',['filter'=>'authGuard']);
$routes->post('/deactivate-vendor-by-admin', 'PartyUserController::deactivate_vendor_by_admin',['filter'=>'authGuard']);
$routes->post('/activate-vendor-by-admin', 'PartyUserController::activate_vendor_by_admin',['filter'=>'authGuard']);
$routes->post('/vendor-password-change-by-admin', 'PartyUserController::vendor_password_change_by_admin',['filter'=>'authGuard']);
//-------------------------------------------------------------------- 


//----------------------------Setting Routes------------------------------ 
$routes->get('/state', 'SettingController::index',['filter'=>'authGuard']);
$routes->post('/set-state', 'SettingController::store_state',['filter'=>'authGuard']);
$routes->post('/update-state', 'SettingController::update_state',['filter'=>'authGuard']);
$routes->post('/del-state', 'SettingController::delete_state',['filter'=>'authGuard']);
//------------------------ 
$routes->get('/city', 'SettingController::city',['filter'=>'authGuard']);
$routes->post('/set-city', 'SettingController::store_city',['filter'=>'authGuard']);
$routes->post('/update-city', 'SettingController::update_city',['filter'=>'authGuard']);
$routes->post('/del-city', 'SettingController::delete_city',['filter'=>'authGuard']);
//------------------------ 

$routes->get('/class', 'SettingController::class',['filter'=>'authGuard']);
$routes->post('/set-class', 'SettingController::store_class',['filter'=>'authGuard']);
$routes->post('/update-class', 'SettingController::update_class',['filter'=>'authGuard']);
$routes->post('/del-class', 'SettingController::delete_class',['filter'=>'authGuard']);
//------------------------  
$routes->get('/department', 'SettingController::department',['filter'=>'authGuard']);
$routes->post('/set-department', 'SettingController::store_department',['filter'=>'authGuard']);
$routes->post('/update-department', 'SettingController::update_department',['filter'=>'authGuard']);
$routes->post('/del-department', 'SettingController::delete_department',['filter'=>'authGuard']);
//------------------------ 
$routes->get('/designation', 'SettingController::designation',['filter'=>'authGuard']);
$routes->post('/set-designation', 'SettingController::store_designation',['filter'=>'authGuard']);
$routes->post('/update-designation', 'SettingController::update_designation',['filter'=>'authGuard']);
$routes->post('/del-designation', 'SettingController::delete_designation',['filter'=>'authGuard']);
  

//----------------------------------------------------------------------
                                                                                 
$routes->get('/complete_bill_report', 'BillRegisterController::complete_bill_report',['filter'=>'authGuard']);
//-----------------------------Monthly Bill Pass Pending Plot wise Details Routes------------------------  

$routes->get('/bill_pass_pending_plot_wise', 'BillRegisterController::bill_pass_pending_plot_wise',['filter'=>'authGuard']); 
//-----------------------------  Monthly Bill Pass Pending Plot wise deatils Routes------------------------  



 

//--------------------------Pagination Routes---------------------------------

$routes->get('/pdx','PaginationController::pdx',['filter'=>'authGuard']); 
$routes->get('/pdxm','PaginationController::pdxm',['filter'=>'authGuard']);

$routes->get('/cdx','PaginationController::cdx',['filter'=>'authGuard']); 
$routes->get('/cdxm','PaginationController::cdxm',['filter'=>'authGuard']);

$routes->get('/cdx1','PaginationController::cdx1',['filter'=>'authGuard']); 
$routes->get('/cdxm1','PaginationController::cdxm1',['filter'=>'authGuard']);

$routes->get('/edx','PaginationController::edx',['filter'=>'authGuard']); 
$routes->get('/edxm','PaginationController::edxm',['filter'=>'authGuard']);



$routes->get('/ndx','PaginationController::ndx',['filter'=>'authGuard']); 
$routes->get('/ndxm','PaginationController::ndxm',['filter'=>'authGuard']);

$routes->get('/ddx','PaginationController::ddx',['filter'=>'authGuard']); 
$routes->get('/ddxm','PaginationController::ddxm',['filter'=>'authGuard']); 

$routes->get('/pdvx','PaginationController::pdvx',['filter'=>'authGuard']); 
$routes->get('/pdvxm','PaginationController::pdvxm',['filter'=>'authGuard']); 

$routes->get('/bbsx','PaginationController::bbsx',['filter'=>'authGuard']); 
$routes->get('/bbsxm','PaginationController::bbsxm',['filter'=>'authGuard']); 
 
$routes->get('/mbsx','PaginationController::mbsx',['filter'=>'authGuard']); 
$routes->get('/mbsxm','PaginationController::mbsxm',['filter'=>'authGuard']);

$routes->get('/dad','PaginationController::dad',['filter'=>'authGuard']); 
$routes->get('/dadm','PaginationController::dadm',['filter'=>'authGuard']);

$routes->get('/next_mapping','PaginationController::next_mapping',['filter'=>'authGuard']);
$routes->get('/previous_mapping','PaginationController::previous_mapping',['filter'=>'authGuard']); 
$routes->get('/next_vendor','PaginationController::next_vendor',['filter'=>'authGuard']);
$routes->get('/previous_vendor','PaginationController::previous_vendor',['filter'=>'authGuard']); 
$routes->get('/next_clearbill','PaginationController::next_clearbill',['filter'=>'authGuard']);
$routes->get('/previous_clearbill','PaginationController::previous_clearbill',['filter'=>'authGuard']);
$routes->get('/next_erpStystem','PaginationController::next_erpStystem',['filter'=>'authGuard']);
$routes->get('/previous_erpStystem','PaginationController::previous_erpStystem',['filter'=>'authGuard']);
$routes->get('/next_recived_bil','PaginationController::next_recived_bil',['filter'=>'authGuard']);
$routes->get('/previous_recived_bil','PaginationController::previous_recived_bil',['filter'=>'authGuard']);

//----------------------------------------------------------------------------

$routes->get('/qr-codes/(:num)', 'QrCodeGeneratorController::index/$1');
$routes->get('/barcode/(:num)', 'QrCodeGeneratorController::barcode/$1');
$routes->post('/generate-barcode/(:num)', 'QrCodeGeneratorController::generatebarcode/$1');
$routes->get('/generated-barcode', 'QrCodeGeneratorController::generatedbarcode');

$routes->post('/barcodeuid', 'QrCodeGeneratorController::uidbarcode');
$routes->get('/uidsuggestion', 'QrCodeGeneratorController::getSuggestions');
$routes->post('/send_otp', 'PartyUserController::sendOTP'); 
$routes->post('/verify_otp', 'PartyUserController::verifyOTP'); 
$routes->get('/vedorsuggestion', 'PartyUserController::getvendorSuggestions'); 
$routes->get('/Vendorsuggestion', 'PartyUserController::getVendorsuggestion');

$routes->post('/send_email_otp', 'PartyUserController::sendEmailOTP');
$routes->post('/verify_email_otp', 'PartyUserController::verifyEmailOTP');

$routes->get('/number_random', 'PartyUserController::number_random');
$routes->post('/verify_Captcha_Code', 'PartyUserController::verify_Captcha_Code');

$routes->post('/Vendor_set_startDate_endDate', 'AdminController::Vendor_set_startDate_endDate',['filter'=>'authGuard']);
$routes->get('/export_all_bill_mapping_vendor_list', 'BillRegisterController::export_all_bill_mapping_vendor_list',['filter'=>'authGuard']);
$routes->post('/vendor-set-startdate-enddate-on-billpage', 'AdminController::vendor_set_startdate_enddate_on_billpage',['filter'=>'authGuard']);
$routes->post('/vendor-set-startdate-enddate-on-companypage', 'AdminController::vendor_set_startdate_enddate_on_companypage',['filter'=>'authGuard']);

//******************************************************************************************* 
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
