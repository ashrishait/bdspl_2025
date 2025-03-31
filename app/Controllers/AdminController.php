<?php
namespace App\Controllers;
use App\Models\StateModel; 
use App\Models\CityModel; 
use App\Models\ClassModel; 
use App\Models\EmployeeModel;  
use App\Models\PageModel;
use App\Models\PageaccessionModel;
use App\Models\BillRegisterModel;
use App\Models\CompanyvendorModel;
use App\Models\PartyUserModel;
use App\Models\LoginactivityModel;
use App\Models\CompenyModel;
use App\Models\VendorcompanyModel;
use App\Models\VendorloginModel;

use App\Models\Help_Support_Reply;

use App\Models\Help_Support;

use App\Models\Company_Add_Request;

use App\Models\Vendor_Quotation_Product;

use App\Models\Company_Order_Product;

use App\Models\Company_Quotation_Order;

use App\Models\Vendor_Product;

use App\Models\OrderStatusModel;

use App\Models\Vendor_Quotation;

use App\Models\Vendor_Sub_Quotation;

use Google\Client;
use CodeIgniter\Controller; 

class AdminController extends BaseController  
{
    private $db;
    public function __construct()
    {
        $this->db = db_connect(); // Loading database
    } 
    //********************************************************************** 
  
    public function set_startDate_endDate()      
    {
        $session = \Config\Services::session(); 
        $result = $session->get();  
        if ($this->request->getMethod() === 'post' && !empty($this->request->getPost())) {
            $btnsubmit = $this->request->getPost('btnsubmit');
            if ($btnsubmit === 'submit') {
                $Sesssion_start_Date=$this->request->getVar('Sesssion_start_Date');
                $Sesssion_end_Date=$this->request->getVar('Sesssion_end_Date');
                $session->set(["Sesssion_start_Date" => $Sesssion_start_Date,"Sesssion_end_Date" => $Sesssion_end_Date]);
            } elseif ($btnsubmit === 'reset') {
                $Sesssion_start_Date='';
                $Sesssion_end_Date='';
                $session->set(["Sesssion_start_Date" => $Sesssion_start_Date,"Sesssion_end_Date" => $Sesssion_end_Date]);
            }
        }
        return redirect('main-dashboard'); 
    }

    //***************************************************************************  
    public function index()  
    {
        $session = \Config\Services::session(); 
        $result = $session->get();    
        $emp_id = $result['emp_id'];
        $location_tracker = $result['location_tracker'];  
        return view('admin_dashboard');    
    } 
     
    //=================Finance Reporting

    public function main_dashboard()
    {
        $session = \Config\Services::session(); 
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id"); 
        $compeny_id = $session->get("compeny_id"); 
        $today = Date("Y-m-d");
        $previous_date = date('Y-m-d', strtotime('-30 days')); 
        //    *************** Start Date Code 
        if ($session->has('Sesssion_start_Date')) {
            if(!empty($result['Sesssion_start_Date'])) {
                $start_Date = $result['Sesssion_start_Date']; 
            } else {
                $start_Date = '2019-05-06';    
            }
        }
        else {
            $start_Date = '2019-05-06';    
        }
        if ($session->has('Sesssion_end_Date')) {
            if(!empty($result['Sesssion_end_Date'])) {
                $end_Date = $result['Sesssion_end_Date']; 
            } else {
                $end_Date = '9019-05-06';    
            }
        }
        else {
            $end_Date = '9019-05-06';    
        }
        $date_format = '%Y-%m-%d';  
        //     ***************End  Date Code      
        $model = new BillRegisterModel();
        if($Roll_id==0)
        {
            $data['compenycount'] = $this->db->table('asitek_compeny')->countAllResults();
            $data['admin_usercount'] = $this->db->table('asitek_employee')->where('role', 1)->countAllResults(); 
            $data['VendorUsercount'] = $this->db->table('asitek_party_user')->countAllResults();
            $data['Company_Add_Request'] = $this->db->table('asitek_company_requests')->countAllResults(); 
            return view('main_dashboard', $data); 
        }
        elseif($Roll_id==1)
        {
            $data['usercount'] = $this->db->table('asitek_employee')->where('compeny_id', $compeny_id)->countAllResults();  
            $data['VendorUsercount'] = $this->db->table('asitek_party_user')->countAllResults();
            $data['AddVendorInUsercount'] = $this->db->table('asitek_company_vendor')->where('Company_Id', $compeny_id)->countAllResults();
            $data['allBillcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
            $data['allBillSum'] = $model->getSumOfAllBillAmount($compeny_id,$start_Date,$end_Date);
            
            // Bill Mapping Count Start
            $data['BillMappingPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['BillMappingPendinSum'] = $model->getSumOfBillAmount($compeny_id,$start_Date,$end_Date);
            $data['BillMappingAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['BillMappingAcceptedSum'] = $model->getSumOfAcceptedBillAmount($compeny_id,$start_Date,$end_Date);
            $data['BillMappingRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['BillMappingRejectedSum'] = $model->getSumOfRejectedBillAmount($compeny_id,$start_Date,$end_Date);
            $data['BillMappingDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['BillMappingDoneSum'] = $model->getSumOfDoneBillAmount($compeny_id,$start_Date,$end_Date);
            // Bill Mapping Count End

            // Clear Bill Form Count Start
            $data['ClearBillFormPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ClearBillFormPendingSum'] = $model->ClearBillFormPendingSum($compeny_id,$start_Date,$end_Date);
            $data['ClearBillFormAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ClearBillFormAcceptedSum'] = $model->ClearBillFormAcceptedSum($compeny_id,$start_Date,$end_Date);
            $data['ClearBillFormRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ClearBillFormRejectSum'] = $model->ClearBillFormRejectSum($compeny_id,$start_Date,$end_Date);
            $data['ClearBillFormDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ClearBillFormDoneSum'] = $model->ClearBillFormDoneSum($compeny_id,$start_Date,$end_Date);
            // Clear Bill Form Count End

            // ERP System Bill Count Start
            $data['ERPSystemBillPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();  
            $data['ERPSystemBillPendingSum'] = $model->ERPSystemBillPendingSum($compeny_id,$start_Date,$end_Date);
            $data['ERPSystemBillFormAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ERPSystemBillFormAcceptedSum'] = $model->ERPSystemBillFormAcceptedSum($compeny_id,$start_Date,$end_Date);
            $data['ERPSystemBillRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ERPSystemBillRejectSum'] = $model->ERPSystemBillRejectSum($compeny_id,$start_Date,$end_Date);
            $data['ERPSystemBillDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ERPSystemBillDoneSum'] = $model->ERPSystemBillDoneSum($compeny_id,$start_Date,$end_Date);
            // ERP System Bill Count End

            //all_recived_bill_list Count Start
            $data['RecivedBillPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();  
            $data['RecivedBillPendingSum'] = $model->RecivedBillPendingSum($compeny_id,$start_Date,$end_Date);
            $data['RecivedBillAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
            $data['RecivedBillAcceptedSum'] = $model->RecivedBillAcceptedSum($compeny_id,$start_Date,$end_Date);
            $data['RecivedBillRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
            $data['RecivedBillRejectSum'] = $model->RecivedBillRejectSum($compeny_id,$start_Date,$end_Date);
            $data['RecivedBillDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
            $data['RecivedBillDoneSum'] = $model->RecivedBillDoneSum($compeny_id,$start_Date,$end_Date);

            $data['Help_Support'] = $this->db->table('asit_help_support')->where('company_id', $compeny_id)->countAllResults(); 
            $data['Vendor_Quotation_Product'] = $this->db->table('asitek_vendor_quotation')->where('company_id', $compeny_id)->countAllResults(); 
            $data['Vendor_Orderder_Product'] = $this->db->table('asitek_quotation_order')->where('company_id', $compeny_id)->countAllResults(); 
            
            return view('main_dashboard', $data);
            // all_recived_bill_list Count End
        }
        elseif($Roll_id==2)
        {
            $data['allBillcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Add_By',  $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
            $data['BillMappingPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['BillMappingPendinSum'] = $model->getSumOfBillAmountEmp($compeny_id,$start_Date,$end_Date);
            $data['BillMappingAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['BillMappingAcceptedSum'] = $model->getSumOfAcceptedBillAmountEmp($compeny_id,$start_Date,$end_Date);
            $data['BillMappingRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['BillMappingRejectedSum'] = $model->getSumOfRejectedBillAmountEmp($compeny_id,$start_Date,$end_Date);
            $data['BillMappingDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
            $data['BillMappingDoneSum'] = $model->getSumOfDoneBillAmountEmp($compeny_id,$start_Date,$end_Date);
            // Clear Bill Form Count Start
            $data['ClearBillFormPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 1)->where('Department_Emp_Id', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();  
            $data['ClearBillFormPendingSum'] = $model->ClearBillFormPendingSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['ClearBillFormAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 2)->where('Department_Emp_Id', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ClearBillFormAcceptedSum'] = $model->ClearBillFormAcceptedSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['ClearBillFormRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 3)->where('Department_Emp_Id', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ClearBillFormRejectSum'] = $model->ClearBillFormRejectSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['ClearBillFormDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('Department_Emp_Id', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
            $data['ClearBillFormDoneSum'] = $model->ClearBillFormDoneSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['ERPSystemBillPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 1)->where('Mapping_ERP_EmpId', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
            $data['ERPSystemBillPendingSum'] = $model->ERPSystemBillPendingSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['ERPSystemBillFormAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 2)->where('Mapping_ERP_EmpId', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ERPSystemBillFormAcceptedSum'] = $model->ERPSystemBillFormAcceptedSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['ERPSystemBillRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 3)->where('Mapping_ERP_EmpId', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ERPSystemBillRejectSum'] = $model->ERPSystemBillRejectSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['ERPSystemBillDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Mapping_ERP_EmpId', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['ERPSystemBillDoneSum'] = $model->ERPSystemBillDoneSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['RecivedBillPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 1)->where('Mapping_Acount_EmpId', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();  
            $data['RecivedBillPendingSum'] = $model->RecivedBillPendingSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['RecivedBillAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 2)->where('Mapping_Acount_EmpId', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['RecivedBillAcceptedSum'] = $model->RecivedBillAcceptedSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['RecivedBillRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 3)->where('Mapping_Acount_EmpId', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
            $data['RecivedBillRejectSum'] = $model->RecivedBillRejectSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            $data['RecivedBillDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 4)->where('Mapping_Acount_EmpId', $emp_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
            $data['RecivedBillDoneSum'] = $model->RecivedBillDoneSumEmp($compeny_id, $emp_id,$start_Date,$end_Date);
            
            return view('main_dashboard', $data);

        }
        
        else
        {
            return view('main_dashboard');  
        }
    }
    //===========================================================================

    public function vendor_dashboard()
    {
        $session = \Config\Services::session(); 
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id"); 
        $compeny_id = $session->get("compeny_id"); 
        $today = Date("Y-m-d");
        $previous_date = date('Y-m-d', strtotime('-30 days'));  
        $data['allBillcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->countAllResults();
        // Bill Mapping Count Start
        $data['BillMappingPendingcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 1)->countAllResults();  
        $data['BillMappingAcceptedcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 2)->countAllResults(); 
        $data['BillMappingRejectcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 3)->countAllResults(); 
        $data['BillMappingDonecount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->countAllResults(); 
        // Bill Mapping Count End
        // Clear Bill Form Count Start
        $data['ClearBillFormPendingcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 1)->countAllResults();  
        $data['ClearBillFormAcceptedcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 2)->countAllResults(); 
        $data['ClearBillFormRejectcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 3)->countAllResults(); 
        $data['ClearBillFormDonecount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->countAllResults(); 
        // Clear Bill Form Count End
        // ERP System Bill Count Start
        $data['ERPSystemBillPendingcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 1)->countAllResults();  
        $data['ERPSystemBillFormAcceptedcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 2)->countAllResults(); 
        $data['ERPSystemBillRejectcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 3)->countAllResults(); 
        $data['ERPSystemBillDonecount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->countAllResults(); 
        // ERP System Bill Count End
        //all_recived_bill_list Count Start
        $data['RecivedBillPendingcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 1)->countAllResults();  
        $data['RecivedBillAcceptedcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 2)->countAllResults(); 
        $data['RecivedBillRejectcount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 3)->countAllResults(); 
        $data['RecivedBillDonecount'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 4)->countAllResults(); 
        
        $data['dax'] = $this->db->query("SELECT asitek_bill_register.compeny_id, SUM(asitek_bill_register.Bill_Amount) AS bamt, COUNT(asitek_bill_register.id) AS bcount, asitek_compeny.name AS companyname FROM asitek_bill_register JOIN asitek_vendor_company ON asitek_vendor_company.Company_Id = asitek_bill_register.compeny_id JOIN asitek_compeny ON asitek_bill_register.compeny_id = asitek_compeny.id WHERE asitek_vendor_company.Vendor_Id = '$emp_id' AND asitek_bill_register.Vendor_Id = '$emp_id' GROUP BY asitek_bill_register.compeny_id;;")->getResultArray();
        
        $data['allmessagerequest'] = $this->db->table('asitek_bill_register')->where('Vendor_Id', $emp_id)->where('Vendor_Comment!=', '')->countAllResults(); 
        
        $data['recentchatrequest'] = $this->db->query("SELECT asitek_bill_register.compeny_id, asitek_bill_register.Bill_No, asitek_bill_register.Vendor_Comment, asitek_compeny.name as companyname FROM `asitek_bill_register` JOIN asitek_compeny on asitek_bill_register.compeny_id = asitek_compeny.id WHERE asitek_bill_register.Vendor_Id='$emp_id' AND Vendor_Comment!='';")->getResultArray();
        
        return view('vendor-dashboard', $data);
        // all_recived_bill_list Count End
        
    }          
    public function pagelist()  
    {
        $session = \Config\Services::session(); 
        $result = $session->get();  
        $company_id = $session->get("compeny_id");
        $model = new PageModel();  
        $data['page']=$model->findAll();  
        $empmodel = new EmployeeModel();
        $data['emp']= $empmodel->where('compeny_id',$company_id)->orderBy('first_name', 'ASC')->findAll();
        return view('pagelist', $data);    
    } 
    
    public function addpagetoemployee()
    {
        // Assuming you have loaded the necessary helper and library in the constructor
        $session = \Config\Services::session(); 
        $result = $session->get();  
        
        $data = [
            'Company_Id' => $this->request->getPost('compeny_id'),
            'Add_By' => $this->request->getPost('Add_By'),
            'Emp_Id' => $this->request->getPost('empid'),
        ];
    
        $selectedPages = $this->request->getPost('pageid');
    
        // Insert data into the asitek_emp_page_access table
        $employeeModel = new PageaccessionModel();
    
        // Fetch existing records for the employee from the database
        $existingRecords = $employeeModel->where('Emp_Id', $data['Emp_Id'])->findAll();
        
        // Create an array of existing page IDs
        $existingPageIds = array_column($existingRecords, 'Page_Id');
        
        // Find deselected pages (existing pages not in selectedPages)
        $deselectedPages = array_diff($existingPageIds, $selectedPages);
    
        // Delete records for deselected pages
        if (!empty($deselectedPages)) {
            $employeeModel->where('Emp_Id', $data['Emp_Id'])->whereIn('Page_Id', $deselectedPages)->delete();
        }
    
        // Insert records for selected pages
        foreach ($selectedPages as $pageId) {
            // Check if the record already exists
            $existingRecord = $employeeModel->where('Emp_Id', $data['Emp_Id'])->where('Page_Id', $pageId)->first();
            
            if (empty($existingRecord)) {
                $data['Page_Id'] = $pageId;
                $employeeModel->insert($data);
            }
        }

        // Redirect or do something else after the insertion
        $session->setFlashdata('success', "<div class='alert alert-success' role='alert'> Form Submition Successful. </div>");
        return redirect('page-list'); 
    }
    
    public function getEmployeePages()
    {
        $employeeId = $this->request->getPost('employee_id');

        // Fetch data for the checkboxes based on the selected employee
        $selectedPages = $this->getSelectedPages($employeeId);

        return $this->response->setJSON($selectedPages);
    }

    // Existing helper function to fetch selected pages for a specific employee from the database
    private function getSelectedPages($employeeId)
    {
        $employeeModel = new PageaccessionModel();
        $selectedPages = $employeeModel->where('Emp_Id', $employeeId)->findAll();

        // Extract page IDs from the result
        $pageIds = array_column($selectedPages, 'Page_Id');

        return $pageIds;
    }
    
    public function allmessagerequest()
    {
        $session = \Config\Services::session(); 
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id"); 
        $compeny_id = $session->get("compeny_id"); 
        $today = Date("Y-m-d");


           //    *************** Start Date Code 
        if ($session->has('Sesssion_start_Date')) {
            if(!empty($result['Sesssion_start_Date'])) {
                $start_Date = $result['Sesssion_start_Date']; 
            } else {
                $start_Date = '2019-05-06';    
            }
        }
        else {
            $start_Date = '2019-05-06';    
        }
        if ($session->has('Sesssion_end_Date')) {
            if(!empty($result['Sesssion_end_Date'])) {
                $end_Date = $result['Sesssion_end_Date']; 
            } else {
                $end_Date = '9019-05-06';    
            }
        }
        else {
            $end_Date = '9019-05-06';    
        }
        $date_format = '%Y-%m-%d';  
        //     ***************End  Date Code  


        $data['recentchatrequest'] = $this->db->query("SELECT asitek_bill_register.compeny_id, asitek_bill_register.Bill_No, asitek_bill_register.Vendor_Comment, asitek_compeny.name as companyname FROM `asitek_bill_register` JOIN asitek_compeny on asitek_bill_register.compeny_id = asitek_compeny.id WHERE asitek_bill_register.Vendor_Id='$emp_id' AND Vendor_Comment!='' AND STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format');")->getResultArray();
        
        return view('allmessagerequest', $data);
        // all_recived_bill_list Count End
        
    }   


    public function getCompanyPages()
    {
        $compeny_id = $this->request->getPost('compeny_id');
        // Fetch data for the checkboxes based on the selected employee
        $selectedvendor = $this->getSelectedVendor($compeny_id);
        return $this->response->setJSON($selectedvendor);
    }

    // Existing helper function to fetch selected pages for a specific employee from the database
    private function getSelectedVendor($companyid)
    {
        $model = new CompanyvendorModel();
        $selectedPages = $model->where('Company_Id', $companyid)->findAll();
        // Extract page IDs from the result
        $pageIds = array_column($selectedPages, 'Vendor_Id');

        return $pageIds;
    }
    public function addvendorinorganization()  
    {
        $session = \Config\Services::session(); 
        $result = $session->get();  
        $company_id = $session->get("compeny_id");
        $model = new PartyUserModel();  
        $data['vendor']=$model->orderBy('Name', 'ASC')->findAll();  
        return view('vendorlist', $data);    
    } 

    public function addvendortocompany()
    {
        // Assuming you have loaded the necessary helper and library in the constructor
        $session = \Config\Services::session(); 
        $result = $session->get();  
        
        $data = [
            'Company_Id' => $this->request->getPost('compeny_id'),
            'Add_By' => $this->request->getPost('Add_By'),
        ];
    
        $selectedPages = $this->request->getPost('vendorid');
    
        // Insert data into the asitek_emp_page_access table
        $model = new CompanyvendorModel();
    
        // Fetch existing records for the employee from the database
        $existingRecords = $model->where('Company_Id', $data['Company_Id'])->findAll();
        
        // Create an array of existing page IDs
        $existingPageIds = array_column($existingRecords, 'Vendor_Id');
        
        // Find deselected pages (existing pages not in selectedPages)
        $deselectedPages = array_diff($existingPageIds, $selectedPages);
    
        // Delete records for deselected pages
        if (!empty($deselectedPages)) {
            $model->where('Company_Id', $data['Company_Id'])->whereIn('Vendor_Id', $deselectedPages)->delete();
        }
    
        // Insert records for selected pages
        foreach ($selectedPages as $pageId) {
            // Check if the record already exists
            $existingRecord = $model->where('Company_Id', $data['Company_Id'])->where('Vendor_Id', $pageId)->first();
            
            if (empty($existingRecord)) {
                $data['Vendor_Id'] = $pageId;
                $model->insert($data);
            }
        }

        // Redirect or do something else after the insertion
        $session->setFlashdata('success', "<div class='alert alert-success' role='alert'> Vendor is added in your organization. </div>");
        return redirect('add-vendor-in-organization'); 
    }

    // public function recentLogin()
    // {
    //     // Load the LoginModel
    //     $loginModel = new LoginactivityModel();
    //     // Fetch recent login data from the model
    //     $logins = $loginModel->getRecentLogins();
    //     // Pass the data to the view
    //     return view('recent_login', ['logins' => $logins]);
    // }

    // public function recentVendorLogin()
    // {
    //     // Load the LoginModel
    //     $VendorloginModel = new VendorloginModel();
    //     // Fetch recent login data from the model
    //     $data["dax"] = $VendorloginModel->orderBy('Id', 'DESC')->findAll();
    //     // Pass the data to the view
    //     return view('recent_vendor_login', $data);
    // }

    public function recentLogin()

    {
        // Load the LoginModel
        $loginModel = new LoginactivityModel();
        // Fetch recent login data from the model
        // Get the current page from the query string, default to 1 if not provided
        $page = $this->request->getVar('page') ?? 1;
        // Number of records per page
        $perPage = 50;
        // Fetch records for the current page
        //$users = $VendorModel->paginate($perPage);
        $logins = $loginModel->getRecentLogins($perPage);
        // Calculate the starting serial number for the current page
        $startSerial = ($page - 1) * $perPage + 1;
        $data = [
            'logins' => $logins,
            'pager' => $loginModel->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
        ];
        return view('recent_login',  $data);
    }

    public function recentVendorLogin()
    {
        $VendorModel = new VendorloginModel();
        // Get the current page from the query string, default to 1 if not provided
        $page = $this->request->getVar('page') ?? 1;
        // Number of records per page
        $perPage = 50;
        // Fetch records for the current page
        $users = $VendorModel->orderBy('Id', 'desc')->paginate($perPage);
        // Calculate the starting serial number for the current page
        $startSerial = ($page - 1) * $perPage + 1;
        $data = [
            'users' => $users,
            'pager' => $VendorModel->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
        ];
        return view('recent_vendor_login', $data);
    }

    public function getVendorPages()
    {
        $vendorid = $this->request->getPost('employee_id');

        // Fetch data for the checkboxes based on the selected employee
        $selectedPages = $this->getSelectedCompany($vendorid);

        return $this->response->setJSON($selectedPages);
    }

    // Existing helper function to fetch selected pages for a specific employee from the database
    private function getSelectedCompany($employeeId)
    {
        $model = new VendorcompanyModel();
        $selectedPages = $model->where('Vendor_Id', $employeeId)->findAll();

        // Extract page IDs from the result
        $pageIds = array_column($selectedPages, 'Company_Id');

        return $pageIds;
    }

    public function addcompanyinvendor()  
    {
        $session = \Config\Services::session(); 
        $company_id = $session->get("compeny_id");
        
        // Fetch all vendors
        $vmodel = new PartyUserModel();  
        $data['vendor'] = $vmodel->orderBy('Name', 'ASC')->findAll();
        
        return view('companylist', $data);    
    }

    public function fetchVendorCompanies()
    {
        $vendorId = $this->request->getPost('vendorId');
        
        if (!$vendorId) {
            log_message('error', 'Vendor ID is missing.');
            return $this->response->setJSON(['error' => 'Vendor ID is required']);
        }

        $vendorCompanyModel = new VendorcompanyModel();
        $companyModel = new CompenyModel();

        // Fetch companies already added to the vendor
        $addedCompanies = $vendorCompanyModel->where('Vendor_Id', $vendorId)->findAll();
        if ($addedCompanies === false) {
            log_message('error', 'Error fetching added companies.');
            return $this->response->setJSON(['error' => 'Error fetching added companies']);
        }

        $addedCompanyIds = array_column($addedCompanies, 'Company_Id');

        // Fetch companies not added to the vendor
        if (!empty($addedCompanyIds)) {
            $notAddedCompanies = $companyModel->whereNotIn('id', $addedCompanyIds)
                                              ->orderBy('name', 'ASC')
                                              ->findAll();
            if ($notAddedCompanies === false) {
                log_message('error', 'Error fetching not added companies.');
                return $this->response->setJSON(['error' => 'Error fetching not added companies']);
            }
        } else {
            $notAddedCompanies = $companyModel->orderBy('name', 'ASC')->findAll();
            if ($notAddedCompanies === false) {
                log_message('error', 'Error fetching all companies.');
                return $this->response->setJSON(['error' => 'Error fetching all companies']);
            }
        }

        // Fetch names for added companies
        $companyIds = array_column($addedCompanies, 'Company_Id');
        if (!empty($companyIds)) {
            $allCompanies = $companyModel->whereIn('id', $companyIds)->findAll();
            if ($allCompanies === false) {
                log_message('error', 'Error fetching all companies.');
                return $this->response->setJSON(['error' => 'Error fetching all companies']);
            }
        } else {
            $allCompanies = [];
        }

        $allCompaniesMap = [];
        foreach ($allCompanies as $comp) {
            $allCompaniesMap[$comp['id']] = $comp['name'];
        }

        // Debugging
        log_message('info', 'Added Companies: ' . json_encode($addedCompanies));
        log_message('info', 'Not Added Companies: ' . json_encode($notAddedCompanies));

        // Prepare response data
        $data = [
            'not_added_companies' => array_map(function($company) {
                return [
                    'id' => $company['id'],
                    'name' => $company['name']
                ];
            }, $notAddedCompanies),
            'added_companies' => array_map(function($company) use ($allCompaniesMap) {
                return [
                    'Company_Id' => $company['Company_Id'],
                    'Company_Name' => isset($allCompaniesMap[$company['Company_Id']]) ? $allCompaniesMap[$company['Company_Id']] : null
                ];
            }, $addedCompanies)
        ];

        log_message('info', 'Fetched vendor companies successfully.');
        return $this->response->setJSON($data);
    }


    public function addcompanytovendor()
    {
        // Assuming you have loaded the necessary helper and library in the constructor
        $session = \Config\Services::session(); 
        $result = $session->get();  
        
        $data = [
            'Vendor_Id' => $this->request->getPost('vendorid'),
            'Add_By' => $this->request->getPost('Add_By'),
        ];
        
        // Initialize $selectedPages as an empty array if it's not set or not an array
        $selectedPages = $this->request->getPost('companyid') ?? [];

        // Check if $selectedPages is an array
        if (!is_array($selectedPages)) {
            // Log the error and handle it accordingly
            log_message('error', '$selectedPages is not an array in addcompanytovendor.');
            // You might want to redirect or display an error message to the user
            return;
        }

        // Insert data into the asitek_emp_page_access table
        $model = new VendorcompanyModel();
        
        // Fetch existing records for the employee from the database
        $existingRecords = $model->where('Vendor_Id', $data['Vendor_Id'])->findAll();
        
        if ($existingRecords === null) {
            // Log the error and handle it accordingly
            log_message('error', 'No existing records found in addcompanytovendor.');
            // You might want to redirect or display an error message to the user
            return;
        }
        
        // Create an array of existing page IDs
        $existingPageIds = array_column($existingRecords, 'Company_Id');
        
        // Find deselected pages (existing pages not in selectedPages)
        $deselectedPages = array_diff($existingPageIds, $selectedPages);
        
        // Delete records for deselected pages
        if (!empty($deselectedPages)) {
            $model->where('Vendor_Id', $data['Vendor_Id'])->whereIn('Company_Id', $deselectedPages)->delete();
        }
        
        // Insert records for selected pages
        foreach ($selectedPages as $pageId) {
            // Check if the record already exists
            if (!in_array($pageId, $existingPageIds)) {
                $data['Company_Id'] = $pageId;
                $model->insert($data);
            }
        }

        // Redirect or do something else after the insertion
        $session->setFlashdata('success', "<div class='alert alert-success' role='alert'> Form Submission Successful. </div>");
        return redirect('add-company-in-vendor'); 
    }


    public function view_dashboard()
    {
        $session = \Config\Services::session(); 
        $result = $session->get(); 
        $Roll_id = $session->get("Roll_id");
        $emp_id = $session->get("emp_id"); 
        $compeny_id = $session->get("compeny_id"); 
        $today = Date("Y-m-d");
        $previous_date = date('Y-m-d', strtotime('-30 days'));  
        $model = new BillRegisterModel();
        //    *************** Start Date Code 
        if ($session->has('Sesssion_start_Date')) {
            if(!empty($result['Sesssion_start_Date'])) {
                $start_Date = $result['Sesssion_start_Date']; 
            } else {
                $start_Date = '2019-05-06';    
            }
        }
        else {
            $start_Date = '2019-05-06';    
        }
        if ($session->has('Sesssion_end_Date')) {
            if(!empty($result['Sesssion_end_Date'])) {
                $end_Date = $result['Sesssion_end_Date']; 
            } else {
                $end_Date = '9019-05-06';    
            }
        }
        else {
            $end_Date = '9019-05-06';    
        }
        $date_format = '%Y-%m-%d';  

        //     ***************End  Date Code   
        $data['usercount'] = $this->db->table('asitek_employee')->where('compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['VendorUsercount'] = $this->db->table('asitek_party_user')->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
        $data['allBillcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
        $data['allBillSum'] = $model->getSumOfAllBillAmount($compeny_id,$start_Date,$end_Date);
        // Bill Mapping Count Start
        $data['BillMappingPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();  
        $data['BillMappingPendinSum'] = $model->getSumOfBillAmount($compeny_id,$start_Date,$end_Date);
        $data['BillMappingAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['BillMappingAcceptedSum'] = $model->getSumOfAcceptedBillAmount($compeny_id,$start_Date,$end_Date);
        
        $data['BillMappingRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['BillMappingRejectedSum'] = $model->getSumOfRejectedBillAmount($compeny_id,$start_Date,$end_Date);
        
        $data['BillMappingDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['BillMappingDoneSum'] = $model->getSumOfDoneBillAmount($compeny_id,$start_Date,$end_Date);
        
        // Bill Mapping Count End
        // Clear Bill Form Count Start
        $data['ClearBillFormPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['ClearBillFormPendingSum'] = $model->ClearBillFormPendingSum($compeny_id,$start_Date,$end_Date);
        $data['ClearBillFormAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['ClearBillFormAcceptedSum'] = $model->ClearBillFormAcceptedSum($compeny_id,$start_Date,$end_Date);
        $data['ClearBillFormRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['ClearBillFormRejectSum'] = $model->ClearBillFormRejectSum($compeny_id,$start_Date,$end_Date);
        $data['ClearBillFormDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['ClearBillFormDoneSum'] = $model->ClearBillFormDoneSum($compeny_id,$start_Date,$end_Date);
        
        // Clear Bill Form Count End
        // ERP System Bill Count Start
        $data['ERPSystemBillPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();  
        $data['ERPSystemBillPendingSum'] = $model->ERPSystemBillPendingSum($compeny_id,$start_Date,$end_Date);
        $data['ERPSystemBillFormAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['ERPSystemBillFormAcceptedSum'] = $model->ERPSystemBillFormAcceptedSum($compeny_id,$start_Date,$end_Date);
        $data['ERPSystemBillRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['ERPSystemBillRejectSum'] = $model->ERPSystemBillRejectSum($compeny_id,$start_Date,$end_Date);
        $data['ERPSystemBillDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults(); 
        $data['ERPSystemBillDoneSum'] = $model->ERPSystemBillDoneSum($compeny_id,$start_Date,$end_Date);
        
        // ERP System Bill Count End
        //all_recived_bill_list Count Start
        $data['RecivedBillPendingcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();  
        $data['RecivedBillPendingSum'] = $model->RecivedBillPendingSum($compeny_id,$start_Date,$end_Date);
        $data['RecivedBillAcceptedcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
        $data['RecivedBillAcceptedSum'] = $model->RecivedBillAcceptedSum($compeny_id,$start_Date,$end_Date);
        $data['RecivedBillRejectcount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
        $data['RecivedBillRejectSum'] = $model->RecivedBillRejectSum($compeny_id,$start_Date,$end_Date);
        $data['RecivedBillDonecount'] = $this->db->table('asitek_bill_register')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status',  4)->where('ERP_Status', 4)->where('Recived_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->countAllResults();
        $data['RecivedBillDoneSum'] = $model->RecivedBillDoneSum($compeny_id,$start_Date,$end_Date);
        
        return view('viewdashboard', $data);
        
    }

    public function Vendor_set_startDate_endDate()      
    {
        $session = \Config\Services::session(); 
        $result = $session->get();  
      
        $Sesssion_start_Date=$this->request->getVar('Sesssion_start_Date');
        $Sesssion_end_Date=$this->request->getVar('Sesssion_end_Date');
        $session->set(["Sesssion_start_Date" => $Sesssion_start_Date,"Sesssion_end_Date" => $Sesssion_end_Date]);
        return redirect('vendor-dashboard'); 
    }

    public function vendor_set_startdate_enddate_on_billpage()      
    {
        $session = \Config\Services::session(); 
        $result = $session->get();  
      
        $Sesssion_start_Date=$this->request->getVar('Sesssion_start_Date');
        $Sesssion_end_Date=$this->request->getVar('Sesssion_end_Date');
        $session->set(["Sesssion_start_Date" => $Sesssion_start_Date,"Sesssion_end_Date" => $Sesssion_end_Date]);
        return redirect('all-bill-mapping-vendor-list'); 
    }
    public function vendor_set_startdate_enddate_on_companypage()
    {
        $session = \Config\Services::session(); 
        $result = $session->get();  
        $compeny_id = $this->request->getVar('compeny_id');
        $Sesssion_start_Date = $this->request->getVar('Sesssion_start_Date');
        $Sesssion_end_Date = $this->request->getVar('Sesssion_end_Date');
        $session->set(["Sesssion_start_Date" => $Sesssion_start_Date, "Sesssion_end_Date" => $Sesssion_end_Date]);

        return redirect()->to('all-vendor-bill-compnay-wise/' . $compeny_id); 
    }


    public function Help_Support_list()  
    {   
        // Initialize session
        $session = \Config\Services::session(); 
        $result = $session->get();    
        $etm = $result['edn'];
        $compeny_id = $session->get("compeny_id"); 
        $Roll_id = $result['Roll_id'];
        
        // Initialize model
        $Help_Support_obj = new Help_Support();
        
        // Pagination setup
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 20;
        $startSerial = ($page - 1) * $perPage + 1;

        // Build the query
        $builder = $Help_Support_obj->select('asit_help_support.*, asitek_compeny.name, asitek_party_user.Name, GST_No')
            ->join('asitek_compeny', 'asit_help_support.company_id = asitek_compeny.id', 'left')
            ->join('asitek_party_user', 'asit_help_support.vendor_id = asitek_party_user.id', 'left')
           
            ->orderBy('asit_help_support.Id', 'ASC');

        // Add where condition if Roll_id is not 0
        if ($Roll_id != 0) {
            $builder->where('asit_help_support.company_id', $compeny_id);
        }
        
        // Execute the query with pagination
        $users = $builder->paginate($perPage); 

        // Pass data to view
        $data = [
            'users' => $users,
            'pager' => $Help_Support_obj->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
        ];   

        // Load the view with data
        return view('help_support_details', $data);   
    }


public function complete_detail_of_help_support($billid)
{
    $session = \Config\Services::session();
    $compeny_id = $session->get("compeny_id");

    // Initialize model
    $Help_Support_obj = new Help_Support_Reply();
    
    // Pagination setup
    $page = $this->request->getVar('page') ?? 1;
    $perPage = 20;
    $startSerial = ($page - 1) * $perPage + 1;

    // Build query with joins
    $builder = $Help_Support_obj->select('asit_help_support_reply.*, asitek_compeny.name, asitek_party_user.Name, asitek_party_user.GST_No, asit_help_support.Title, asit_help_support.Status')
        ->join('asitek_compeny', 'asit_help_support_reply.company_id = asitek_compeny.id', 'left')
        ->join('asitek_party_user', 'asit_help_support_reply.vendor_id = asitek_party_user.id', 'left')
        ->join('asit_help_support', 'asit_help_support_reply.Help_Id = asit_help_support.Id', 'left')
        ->where('asit_help_support_reply.Company_Id', $compeny_id)
        ->where('asit_help_support_reply.Help_Id', $billid)
        ->orderBy('asit_help_support_reply.Id', 'ASC');

    // Execute the query with pagination
    $users = $builder->paginate($perPage, 'default', $page);

    // Prepare data for the view
    $data = [
        'users' => $users,
        'pager' => $Help_Support_obj->pager,
        'startSerial' => $startSerial,
        'nextPage' => $page + 1,
        'previousPage' => ($page > 1) ? $page - 1 : null,
    ];

    return view("help_support_full_details.php", $data);
}



public function Recived_Help_StatusChange()
{
    $session = \Config\Services::session();
    $model = new Help_Support();
    $id = $this->request->getVar("id");
    $Recived_Status = $this->request->getVar("Recived_Status");


    date_default_timezone_set("Asia/Kolkata");
    $Recived_DateTime = date("Y-m-d H:i:s");

    // Prepare the data for the update
    $data = [
        "Status" => $Recived_Status,
        "Rec_Time_Stamp" => $Recived_DateTime,
    ];

    // Check if the record exists
    $bill = $this->db->query("SELECT Status FROM asit_help_support WHERE Id = ?", [$id])->getRow(); // Use parameter binding to prevent SQL injection

    if ($bill) {
        // Perform the update
        if ($model->where("Id", $id)->set($data)->update()) {
            $session->setFlashdata("active_deactive", 1);
            return redirect()->to("Help_Support_list");
        } else {
            // Handle the update failure case
            $session->setFlashdata("error", "Failed to update the status.");
            return redirect()->back();
        }
    } else {
        // Handle the case where the record does not exist
        $session->setFlashdata("error", "Record not found.");
        return redirect()->back();
    }
}



public function Comment_Support_Help()
{
    $session = \Config\Services::session();
    $model = new Help_Support_Reply();
    $id = $this->request->getVar("id");
    $Recived_Comment = $this->request->getVar("Recived_Comment");


    date_default_timezone_set("Asia/Kolkata");
    $Recived_DateTime = date("Y-m-d H:i:s");

    // Prepare the data for the update
    $data = [
        "Company_Reply" => $Recived_Comment,
        "Rec_Time_Stamp" => $Recived_DateTime,
    ];

    // Check if the record exists
    $bill = $this->db->query("SELECT Company_Reply FROM asit_help_support_reply WHERE Id = ?", [$id])->getRow(); // Use parameter binding to prevent SQL injection

    if ($bill) {
        // Perform the update
        if ($model->where("Id", $id)->set($data)->update()) {
            $session->setFlashdata("active_deactive", 1);
            return redirect()->to("Help_Support_list");
        } else {
            // Handle the update failure case
            $session->setFlashdata("error", "Failed to update the status.");
            return redirect()->back();
        }
    } else {
        // Handle the case where the record does not exist
        $session->setFlashdata("error", "Record not found.");
        return redirect()->back();
    }
}




public function view_compeny_add_request()  
{   
    // Initialize session
    $session = \Config\Services::session(); 
    $result = $session->get();    
    $etm = $result['edn'];
    $compeny_id = $session->get("compeny_id"); 
    $Roll_id = $result['Roll_id'];

    // Initialize model
    $Company_Add_Request_obj = new Company_Add_Request();
    
    // Pagination setup
    $page = $this->request->getVar('page') ?? 1;
    $perPage = 20;
    $startSerial = ($page - 1) * $perPage + 1;

    // Build the query
    $builder = $Company_Add_Request_obj->select('asitek_company_requests.*, asitek_compeny.name, asitek_party_user.Name, GST_No')
        ->join('asitek_compeny', 'asitek_company_requests.compeny_id = asitek_compeny.id', 'left')
        ->join('asitek_party_user', 'asitek_company_requests.vendor_id = asitek_party_user.id', 'left')
       
        ->orderBy('asitek_company_requests.Id', 'ASC');

    // Add where condition if Roll_id is not 0
    if ($Roll_id != 0) {
        $builder->where('asitek_company_requests.company_id', $compeny_id);
    }
    
    // Execute the query with pagination
    $users = $builder->paginate($perPage); 

    // Pass data to view
    $data = [
        'users' => $users,
        'pager' => $Company_Add_Request_obj->pager,
        'startSerial' => $startSerial,
        'nextPage' => $page + 1,
        'previousPage' => ($page > 1) ? $page - 1 : null,
    ];   

    // Load the view with data
    return view('Company_add_request_details', $data);   
}



public function compeny_add_request_StatusChange()
{
    $session = \Config\Services::session();
    $model = new Company_Add_Request();
    $id = $this->request->getVar("id");
    $Recived_Status = $this->request->getVar("Recived_Status");


    date_default_timezone_set("Asia/Kolkata");
    $Recived_DateTime = date("Y-m-d H:i:s");

    // Prepare the data for the update
    $data = [
        "status" => $Recived_Status,
        "rec_time_stamp" => $Recived_DateTime,
    ];

    // Check if the record exists
    $bill = $this->db->query("SELECT status FROM asitek_company_requests WHERE id = ?", [$id])->getRow(); // Use parameter binding to prevent SQL injection

    if ($bill) {
        // Perform the update
        if ($model->where("Id", $id)->set($data)->update()) {
            $session->setFlashdata("active_deactive", 1);
            return redirect()->to("view_compeny_add_request");
        } else {
            // Handle the update failure case
            $session->setFlashdata("error", "Failed to update the status.");
            return redirect()->back();
        }
    } else {
        // Handle the case where the record does not exist
        $session->setFlashdata("error", "Record not found.");
        return redirect()->back();
    }
}



public function Vendor_Product_list()  
{   
    // Initialize session
    $session = \Config\Services::session(); 
    $result = $session->get();    
    $etm = $result['edn'];
    $compeny_id = $session->get("compeny_id"); 
    $Roll_id = $result['Roll_id'];

    // Fetch vendors
    $model14 = new PartyUserModel();
    $dax14 = $model14->where('compeny_id', $compeny_id)->findAll();

    // Get filter inputs from request
    $vendor_id = $this->request->getVar('vendor_id');
    $date_from = $this->request->getVar('date_from');
    $date_to = $this->request->getVar('date_to');

    // Initialize models
    $Vendor_Quotation_Product = new Vendor_Quotation_Product();
    $PartyUserModel = new PartyUserModel();

    // Pagination setup
    $page = $this->request->getVar('page') ?? 1;
    $perPage = 20;
    $startSerial = ($page - 1) * $perPage + 1;

    // Build the query
    $builder = $Vendor_Quotation_Product->select('asitek_vendor_quotation.id AS quotation_id,asitek_vendor_quotation.title AS Title, asitek_vendor_quotation.vendor_id, SUM(asitek_vendor_quote_product.price) AS Sum_of_count_product_price, COUNT(asitek_vendor_quote_product.id) AS count_of_product')
        ->join('asitek_vendor_quotation', 'asitek_vendor_quote_product.Quote_Id = asitek_vendor_quotation.id', 'left')
        ->groupBy('asitek_vendor_quotation.id, asitek_vendor_quotation.vendor_id')
        ->orderBy('asitek_vendor_quotation.id', 'ASC');

    // Apply filter conditions
    if ($vendor_id) {
        $builder->where('asitek_vendor_quotation.vendor_id', $vendor_id);
    }
    if ($date_from && $date_to) {
        $builder->where("asitek_vendor_quote_product.rec_time_stamp >=", $date_from);
        $builder->where("asitek_vendor_quote_product.rec_time_stamp <=", $date_to);
    }

    // Add where condition if Roll_id is not 0
    if ($Roll_id != 0) {
        $builder->where('asitek_vendor_quotation.company_id', $compeny_id);
    }

    // Execute the query with pagination
    $resultSet = $builder->paginate($perPage);

    // Process data for each row
    $users = [];
    foreach ($resultSet as $row) {
        $Partyrow = $PartyUserModel->where('id', $row['vendor_id'])->first();
        $vendorName = isset($Partyrow) ? $Partyrow['Name'] : '';

        // Prepare data for view
        $users[] = [
            'id' => $row['quotation_id'],  // Use the grouped quotation ID
            'title' => $row['Title'],
            'vendor_name' => $vendorName,
            'Sum_of_count_product_price' => $row['Sum_of_count_product_price'],
            'count_of_product' => $row['count_of_product']
        ];
    }

    // Pass data to view
    $data = [
        'users' => $users,
        'dax14' => $dax14,  // Include vendor data
        'pager' => $Vendor_Quotation_Product->pager,
        'startSerial' => $startSerial,
        'nextPage' => $page + 1,
        'previousPage' => ($page > 1) ? $page - 1 : null,
        'vendor_id' => $vendor_id,
        'date_from' => $date_from,
        'date_to' => $date_to,
    ];   

    // Load the view with data
    return view('Vendor_Product_list', $data);   
}



public function fetchVendorProducts($quoteId, $subQuoteId)
{

    $builder = $this->db->table('asitek_vendor_quote_product');
    $builder->select('asitek_vendor_quote_product.*, asitek_vendor_product.product_name, asitek_vendor_product.image, asitek_vendor_product.price, asitek_vendor_product.description');
    $builder->join('asitek_vendor_product', 'asitek_vendor_quote_product.Product_Id = asitek_vendor_product.id', 'left');
    $builder->where([
        'asitek_vendor_quote_product.Quote_Id' => $quoteId,
        'asitek_vendor_quote_product.Sub_Quote_Id' => $subQuoteId,
        'asitek_vendor_quote_product.active' => 1,
    ]);

    $query = $builder->get();
    $result = $query->getResultArray();

    if ($query->getNumRows() > 0) {
        return $this->response->setJSON(['success' => true, 'products' => $result]);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'No products found.']);
    }
}
public function viewVendorProducts($subQuoteId, $quoteId)
{
    // Initialize session
    $session = \Config\Services::session(); 
    $result = $session->get();    
    $etm = $result['edn'];
    $company_id = $session->get("compeny_id"); 
    $Roll_id = $result['Roll_id'];

    // Load the Vendor_Quotation_Product model
    $Vendor_Quotation_Product = new \App\Models\Vendor_Quotation_Product(); 

    // Step 1: Fetch all products for the given Sub_Quote_Id and Quote_Id
    $productsQuery = $Vendor_Quotation_Product->select('Product_Id, Product_Price as quoted_price') // Changed here
        ->where('Quote_Id', $quoteId)
        ->where('Sub_Quote_Id', $subQuoteId)
        ->where('active', 1)
        ->findAll();

    // Check if products exist for the given Sub_Quote_Id and Quote_Id
    if (empty($productsQuery)) {
        return "No products found for the given Quote and Sub-Quote IDs.";
    }

    // Step 2: Fetch product details from asitek_vendor_product table based on Product_Id
    $productIds = array_column($productsQuery, 'Product_Id'); // Extract Product IDs

    $Vendor_Product = new \App\Models\Vendor_Product(); // Assuming Vendor_Product is the model for asitek_vendor_product table
    $productDetails = $Vendor_Product->select('id, product_name, image, price as product_price, description, vendor_id, active')
        ->whereIn('id', $productIds)
        ->where('active', 1)
        ->findAll();

    // Check if any product details are found
    if (empty($productDetails)) {
        return "No active products found for the given product IDs.";
    }

    // Step 3: Combine the product details with the price from asitek_vendor_quote_product
    $products = [];
    foreach ($productsQuery as $quoteProduct) {
        foreach ($productDetails as $productDetail) {
            if ($quoteProduct['Product_Id'] == $productDetail['id']) {
                $products[] = array_merge($productDetail, ['quoted_price' => $quoteProduct['quoted_price']]); // Use the new alias
            }
        }
    }

    $data = [
        'products' => $products,
        'quotation_id' => $quoteId,
        'sub_quotation_id' => $subQuoteId,
    ];

    // Load the view and pass data
    return view('vendor_products_view', $data); 
}







public function submitVendorOrder()
{
    // Initialize session
    $session = \Config\Services::session(); 
    $result = $session->get();    
    $compeny_id = $session->get("compeny_id"); 
    $Roll_id = $result['Roll_id'];

    // Get the form data
    $quotation_id = $this->request->getPost('quotation_id');
    $quantities = $this->request->getPost('quantities');
    $total_prices = $this->request->getPost('total_prices');
    $product_ids = $this->request->getPost('product_ids');
    $vendor_id = $this->request->getPost('vendor_id'); 
    $sub_quotation_id = $this->request->getPost('sub_quotation_id'); 
    $delivery_dates = $this->request->getPost('delivery_dates');

    // Load models
    $quotationOrderModel = new Company_Quotation_Order();
    $orderProductModel = new Company_Order_Product();

    // Insert into `asitek_quotation_order`
    $orderData = [
        'order_date' => date('Y-m-d'),
        'company_id' => $compeny_id,
        'vendor_id' => $vendor_id,
        'active' => 1,
        'Quoate_Id' => $quotation_id,
        'Sub_Quote_Id' => $sub_quotation_id,
    ];

    // Insert order and check for success
    if (!$quotationOrderModel->insert($orderData)) {
        log_message('error', print_r($quotationOrderModel->errors(), true));
        return redirect()->back()->with('error', 'Failed to insert quotation order.');
    }

    $order_id = $quotationOrderModel->getInsertID(); // Get the ID of the inserted order

    // Insert into `asitek_ordered_product`
    foreach ($quantities as $index => $quantity) {
        if ($quantity > 0) { // Only insert rows with Quantity > 0
            // Ensure that product_ids, total_prices, and delivery_dates arrays are valid
            $productId = $product_ids[$index] ?? null; // Using null coalescing operator to avoid undefined index notice
            $totalPrice = $total_prices[$index] ?? 0;
            $deliveryDate = $delivery_dates[$index] ?? null;

            // Check if productId is valid
            if ($productId && $totalPrice > 0 && $deliveryDate) {
                $productData = [
                    'quantity' => $quantity,
                    'revised_price' => $totalPrice / $quantity, // Calculate the price per unit
                    'total_price' => $totalPrice,
                    'active' => 1,
                    'Order_Id' => $order_id,
                    'Product_Id' => $productId, // Assuming you are passing product IDs from the form
                    'Sub_Quote_Id' => $sub_quotation_id,
                    'Quote_Id' => $quotation_id,
                    'Delivery_Date' => $deliveryDate,
                ];

                // Insert product data and check for success
                if (!$orderProductModel->insert($productData)) {
                    log_message('error', print_r($orderProductModel->errors(), true));
                    // Optionally, you could decide whether to continue inserting the next items or break out of the loop
                }
            } else {
                log_message('error', "Invalid product ID, total price, or delivery date for index $index");
            }
        }
    }

    $session->setFlashdata('success', "Form Submission Successful.");
    return redirect('Vendor_Product_list'); 
}
public function Ordered_Quotation_Product_list()
{
    // Initialize session
    $session = \Config\Services::session();
    $result = $session->get();
    $compeny_id = $session->get("compeny_id");
    $Roll_id = $result['Roll_id'];

    // Get filter inputs from request
    $vendor_id = $this->request->getVar('vendor_id');
    $date_from = $this->request->getVar('date_from');
    $date_to = $this->request->getVar('date_to');

    // Initialize models
    $OrderedProductModel = new Company_Order_Product(); // Assuming this is the model for asitek_ordered_product

    // Pagination setup
    $page = $this->request->getVar('page') ?? 1;
    $perPage = 20;

    // Build the query to retrieve data with a join on asitek_quotation_order
    $builder = $OrderedProductModel->select('
        asitek_ordered_product.id AS id,
        asitek_ordered_product.Order_Id AS order_id,
        asitek_ordered_product.Quote_Id AS quotation_id,
        asitek_ordered_product.Sub_Quote_Id AS sub_quotation_id,
        asitek_ordered_product.Product_Id AS product_id,
        asitek_ordered_product.quantity AS order_quantity,
        asitek_ordered_product.revised_price AS product_price,
        asitek_ordered_product.total_price AS total_price,
        asitek_ordered_product.Delivery_Date AS delivery_date,
        asitek_ordered_product.rec_time_stamp AS order_date,
        asitek_quotation_order.company_id AS company_id
    ')
    ->join('asitek_quotation_order', 'asitek_quotation_order.id = asitek_ordered_product.Order_Id') // Join on Order_Id
    ->groupBy('asitek_ordered_product.id, 
               asitek_ordered_product.Order_Id, 
               asitek_ordered_product.Quote_Id, 
               asitek_ordered_product.Sub_Quote_Id,
               asitek_ordered_product.Product_Id, 
               asitek_ordered_product.quantity, 
               asitek_ordered_product.revised_price, 
               asitek_ordered_product.total_price, 
               asitek_ordered_product.Delivery_Date, 
               asitek_ordered_product.rec_time_stamp,
               asitek_quotation_order.company_id')
    ->orderBy('asitek_ordered_product.id', 'ASC');

    // Apply filter conditions
    if ($vendor_id) {
        $builder->where('asitek_ordered_product.vendor_id', $vendor_id);
    }
    if ($date_from && $date_to) {
        $builder->where("asitek_ordered_product.rec_time_stamp >=", $date_from);
        $builder->where("asitek_ordered_product.rec_time_stamp <=", $date_to);
    }

    // Add where condition if Roll_id is not 0
    if ($Roll_id != 0) {
        $builder->where('asitek_quotation_order.company_id', $compeny_id);
    }

    // Execute the query with pagination
    $resultSet = $builder->paginate($perPage);

    // Process data for each row
    $users = [];
    $companyId = null; // Initialize variable to hold company_id
    foreach ($resultSet as $row) {
        // Prepare data for view
        $users[] = [
            'id' => $row['id'], // Pass the "id"
            'order_id' => $row['order_id'], // Pass the "order_id"
            'quotation_id' => $row['quotation_id'],
            'sub_quotation_id' => $row['sub_quotation_id'],
            'product_id' => $row['product_id'], // Change to "product_id"
            'order_quantity' => $row['order_quantity'],
            'product_price' => number_format($row['product_price'], 2),
            'total_price' => number_format($row['total_price'], 2),
            'order_date' => $row['order_date'],
            'delivery_date' => $row['delivery_date'],
        ];
        // Store the company_id (assuming it's the same for all rows)
        $companyId = $row['company_id'];
    }

    // Pagination metadata
    $startSerial = ($page - 1) * $perPage + 1; // Calculate the starting serial number

    // Pass data to view
    $data = [
        'users' => $users,
        'pager' => $OrderedProductModel->pager,
        'startSerial' => $startSerial,
        'nextPage' => $page + 1,
        'previousPage' => ($page > 1) ? $page - 1 : null,
        'vendor_id' => $vendor_id,
        'date_from' => $date_from,
        'date_to' => $date_to,
        'company_id' => $companyId, // Add company_id to the data array
    ];

    // Load the view with data
    return view('Ordered_Product_list', $data);
}
public function editVendorOrder($id)
{
    // Initialize models
    $quotationOrderModel = new Company_Quotation_Order();
    $orderProductModel = new Company_Order_Product();
    $vendorProductModel = new Vendor_Product(); // Initialize Vendor_Product model

    // Fetch order details
    $order = $quotationOrderModel->find($id);

    // Fetch ordered products details
    $orderProducts = $orderProductModel->where('id', $id)->findAll();

    // Fetch product names, images, and delivery date using Product_Id from Vendor_Product model
    foreach ($orderProducts as &$product) {
        $vendorProduct = $vendorProductModel->find($product['Product_Id']);
        if ($vendorProduct) {
            $product['Product_Name'] = $vendorProduct['product_name']; // Add product name to the product details
            $product['image'] = $vendorProduct['image']; // Add product image to the product details
            $product['description'] = $vendorProduct['description']; // Add product description to the product details
            $product['price'] = $vendorProduct['price']; // Add product price to the product details
            $product['revised_price'] = $product['revised_price']; // Fetch revised price from the order product
            $product['delivery_date'] = $product['Delivery_Date']; // Add delivery date from order products
        } else {
            $product['Product_Name'] = 'Unknown Product'; // Fallback in case product is not found
            $product['image'] = 'default.jpg'; // Fallback image if product is not found
            $product['description'] = 'No description available'; // Fallback description
            $product['price'] = 0; // Fallback price
            $product['revised_price'] = 0; // Fallback revised price
            $product['delivery_date'] = 'N/A'; // Fallback delivery date
        }
    }

    $data = [
        'order' => $order,
        'orderProducts' => $orderProducts,
    ];

    // Load the edit view with the data
    return view('edit_vendor_order', $data);
}
public function updateVendorOrder() {
    // Load the model for ordered products and vendor products
    $orderedProductModel = new Company_Order_Product();
    $vendorProductModel = new Vendor_Product(); // Ensure this model is initialized to fetch product prices

    // Retrieve the input data
    $productIds = $this->request->getPost('product_ids');
    $orderIds = $this->request->getPost('order_ids');
    $quotationIds = $this->request->getPost('quotation_ids');
    $subQuotationIds = $this->request->getPost('sub_quotation_ids');
    $quantities = $this->request->getPost('quantities');
    $deliveryDates = $this->request->getPost('delivery_dates');
    $orderIdProducts = $this->request->getPost('order_id_product'); // Get unique IDs for products
    $grandTotal = (float) $this->request->getPost('grand_total_price'); // Get the grand total from the input

    // Initialize success flag
    $updateSuccessful = true;

    // Loop through each product and update the corresponding row
    foreach ($productIds as $index => $productId) {
        // Fetch the vendor product to get the revised price
        $vendorProduct = $vendorProductModel->find($productId);
        $revisedPrice = isset($vendorProduct['revised_price']) ? $vendorProduct['revised_price'] : 0; // Get the revised price
        
        // Ensure quantity is a valid number
        $quantity = isset($quantities[$index]) ? (float) $quantities[$index] : 0;

        // Calculate the total price based on quantity and revised price
        $totalPrice = number_format($quantity * $revisedPrice, 2, '.', ''); // Ensure proper formatting

        $data = [
            'quantity' => $quantity,
            'Delivery_Date' => $deliveryDates[$index],
            'total_price' => $grandTotal // Use calculated total price based on revised price
        ];

        // Update the ordered product using the unique ID
        $updateResult = $orderedProductModel->update($orderIdProducts[$index], $data); // Use unique ID here
        if (!$updateResult) {
            $updateSuccessful = false;
            break; // Exit the loop if any update fails
        }
    }

    // After all updates, you may want to update the grand total separately if needed
    // This assumes you have a grand total field in your orders or related table
    // Uncomment and adjust the following code if you want to save the grand total elsewhere
    /*
    $grandTotalData = [
        'grand_total' => $grandTotal // Replace 'grand_total' with the actual field name if different
    ];
    $orderedProductModel->updateGrandTotal($orderId, $grandTotalData); // Implement this method if necessary
    */

    // Set a session message based on success or failure
    if ($updateSuccessful) {
        session()->setFlashdata('success', 'Order updated successfully.');
    } else {
        session()->setFlashdata('error', 'Error updating order.');
    }

    return redirect('Ordered_Quotation_Product_list'); 
}





public function getOrderProductDetails($order_id)
{
    // Initialize models
    $orderProductModel = new Company_Order_Product();
    $vendorProductModel = new Vendor_Product();

    // Fetch order products
    $orderProducts = $orderProductModel->where('Order_Id', $order_id)->findAll();

    // Fetch product names and details using Product_Id from Vendor_Product model
    foreach ($orderProducts as &$product) {
        $vendorProduct = $vendorProductModel->find($product['Product_Id']);
        if ($vendorProduct) {
            $product['Product_Name'] = $vendorProduct['product_name'];
            $product['description'] = $vendorProduct['description'];
            $product['image'] = $vendorProduct['image'];
            $product['price'] = $vendorProduct['price'];
        } else {
            $product['Product_Name'] = 'Unknown Product';
            $product['description'] = 'No description available';
            $product['image'] = 'default.jpg';
            $product['price'] = 0;
        }
        $product['total_price'] = $product['price'] * $product['quantity'];
    }

    // Return the data as JSON
    return $this->response->setJSON($orderProducts);
}

public function checkStatus($order_id, $quotation_id, $sub_quotation_id, $company_id, $product_id)
{
    // Load models
    $quotationOrderModel = new Company_Quotation_Order();
    $orderProductModel = new Company_Order_Product();
    $vendorProductModel = new Vendor_Product();
    $orderStatusModel = new OrderStatusModel();
    
    // Fetch order details using the order_id
    $order = $quotationOrderModel->find($order_id);
    if (!$order) {
        return redirect()->to('/error_page')->with('error', 'Order not found');
    }

    // Fetch order products with pagination
    $orderProducts = $orderProductModel->where('Order_Id', $order_id)->paginate(10);
    if (empty($orderProducts)) {
        return redirect()->to('/error_page')->with('error', 'No products found for this order');
    }

    // Fetch product details and delivery details
    foreach ($orderProducts as &$product) {
        $vendorProduct = $vendorProductModel->find($product['Product_Id']);

        // Set product details
        if ($vendorProduct) {
            $product['Product_Name'] = $vendorProduct['product_name'];
            $product['image'] = $vendorProduct['image'];
            $product['description'] = $vendorProduct['description'];
            $product['price'] = $vendorProduct['price'];
        } else {
            $product['Product_Name'] = 'Unknown Product';
            $product['image'] = 'default.jpg';
            $product['description'] = 'No description available';
            $product['price'] = 0;
        }

        // Fetch all delivery details for this product
        $product['Delivery_Details'] = $orderStatusModel->where([
            'Order_Id' => $order_id,
            'sub_quote_id' => $sub_quotation_id,
            'Quoate_Id' => $quotation_id,  
            'Product_Id' => $product['Product_Id'],
            'company_id' => $company_id
        ])->findAll();
    }


    // Prepare data for view
    $data = [
        'order_id' => $order_id,
        'quotation_id' => $quotation_id,
        'sub_quotation_id' => $sub_quotation_id,
        'order' => $order,
        'orderProducts' => $orderProducts,
        'pager' => $orderProductModel->pager,
    ];

    return view('product_order_status', $data);
}




public function checkDeliveredStatus($order_id, $product_id)
{
    // Initialize session
    $session = \Config\Services::session();
    $result = $session->get();
    $etm = $result['edn'];
    $compeny_id = $session->get("compeny_id");
    $Roll_id = $result['Roll_id'];
    
    // Load the models
    $orderStatusModel = new OrderStatusModel();
    $orderedProductModel = new Company_Order_Product(); // Ensure this model exists

    // Pagination setup
    $page = $this->request->getVar('page') ?? 1; // Current page
    $perPage = 10;  // Number of items per page

    // Fetch delivered status records based on Order_Id and Product_Id with pagination
    $deliveryRecords = $orderStatusModel
        ->where('Order_Id', $order_id)
        ->where('Product_Id', $product_id)
        ->paginate($perPage, 'deliveryRecordsGroup', $page);

    // Fetch ordered quantity
    $orderedQuantity = $orderedProductModel
        ->where('Order_Id', $order_id)
        ->where('Product_Id', $product_id)
        ->first();

    // Calculate total ordered quantity
    $totalOrderedQuantity = $orderedQuantity ? $orderedQuantity['quantity'] : 0;

    // Get the pager instance
    $pager = $orderStatusModel->pager;

    // Prepare data for the view
    $data = [
        'order_id' => $order_id,
        'product_id' => $product_id,
        'deliveryRecords' => $deliveryRecords,
        'totalOrderedQuantity' => $totalOrderedQuantity,
        'pager' => $pager, // Pass the pager to the view
        'startSerial' => ($page - 1) * $perPage + 1, // Serial number calculation
    ];

    // Load the view
    return view('order_delivered_status', $data);
}




public function deleteQuotation()
    {
        $id = $this->request->getPost('id');

        if (!$id) {
            return redirect()->to('/Vendor_Product_list')->with('error', 'Invalid ID');
        }

        // Load models
        $orderStatusModel = new OrderStatusModel(); // Model for `asitek_order_status`
        $quotationOrderModel = new Company_Quotation_Order(); // Model for `asitek_quotation_order`
        $quoteProductModel = new Vendor_Quotation_Product(); // Model for `asitek_vendor_quote_product`
        $vendorQuotationModel = new Vendor_Quotation(); // Model for `asitek_vendor_quotation`

        // Begin transaction
        $this->db->transBegin();

        try {
            // Delete records from asitek_vendor_quote_product table
            $quoteProductModel->where('Quote_Id', $id)->delete();

            // Delete records from asitek_quotation_order table
            $quotationOrderModel->where('Quoate_Id', $id)->delete();

            // Delete records from asitek_order_status table
            $orderStatusModel->where('Order_Id', $id)->delete();

            // Delete the main record from asitek_vendor_quotation table
            $vendorQuotationModel->delete($id);

            // Check if the transaction was successful
            if ($this->db->transStatus() === FALSE) {
                // Rollback transaction in case of error
                $this->db->transRollback();
                $error = $this->db->error(); // Get the last error
                return redirect()->to('/Vendor_Product_list')->with('error', 'Failed to delete records. ' . $error['message']); 
            } else {
                // Commit transaction if everything is fine
                $this->db->transCommit();
                return redirect()->to('/Vendor_Product_list')->with('success', 'Vendor quotation deleted successfully'); 
            }
        } catch (\Exception $e) {
            // Rollback transaction in case of exception
            $this->db->transRollback();
            return redirect()->to('/Vendor_Product_list')->with('error', $e->getMessage()); 
        }
    }




public function viewVendorSubQuotation($quoteId)
{
    // Initialize session
    $session = \Config\Services::session(); 
    $compeny_id = $session->get("compeny_id");
    $Roll_id = $session->get("Roll_id");

    // Load the Vendor_Sub_Quotation and PartyUserModel models
    $Vendor_Sub_Quotation = new Vendor_Sub_Quotation();
    $PartyUserModel = new PartyUserModel();

    // Number of items per page
    $perPage = 10;
    $page = $this->request->getVar('page') ?? 1;
    $startSerial = ($page - 1) * $perPage + 1;

    // Get filter inputs from the request
    $vendor_id = $this->request->getVar('vendor_id');
    $date_from = $this->request->getVar('date_from');
    $date_to = $this->request->getVar('date_to');
    $search = $this->request->getVar('search'); // Optional search field

    // Build the query with join
    $builder = $Vendor_Sub_Quotation->select('asitek_vendor_Sub_quotation.*, asitek_party_user.Name as vendor_name')
        ->join('asitek_party_user', 'asitek_vendor_Sub_quotation.vendor_id = asitek_party_user.id', 'left') // Join with PartyUserModel
        ->where('asitek_vendor_Sub_quotation.Quote_Id', $quoteId) // Change to filter by Quote_Id
        ->where('asitek_vendor_Sub_quotation.active', 1)
        ->where('asitek_vendor_Sub_quotation.company_id', $compeny_id);

    // Apply vendor filter
    if (!empty($vendor_id)) {
        $builder->where('asitek_vendor_Sub_quotation.vendor_id', $vendor_id);
    }

    // Apply date range filter
    if (!empty($date_from) && !empty($date_to)) {
        $builder->where("asitek_vendor_Sub_quotation.rec_time_stamp >=", $date_from);
        $builder->where("asitek_vendor_Sub_quotation.rec_time_stamp <=", $date_to);
    }

    // Apply general search if necessary
    if (!empty($search)) {
        $builder->like('asitek_vendor_Sub_quotation.title', $search); // Replace 'some_field' with a valid column
    }

    // If Roll_id is not 0, apply company filter
    if ($Roll_id != 0) {
        $builder->where('asitek_vendor_Sub_quotation.company_id', $compeny_id);
    }

    // Execute the query with pagination
    $records = $builder->paginate($perPage, 'vendorSubQuotation'); // 'vendorSubQuotation' is a custom group name for pagination

    // Get the pager instance
    $pager = $Vendor_Sub_Quotation->pager;

    // Prepare data for the view
    $data = [
        'records' => $records,      // The paginated result
        'pager' => $pager,          // Pager instance for pagination links
        'quoteId' => $quoteId,      // Pass quote ID for reference
        'vendor_id' => $vendor_id,  // Pass vendor_id back to the view
        'date_from' => $date_from,  // Pass date_from back to the view
        'date_to' => $date_to,      // Pass date_to back to the view
        'search' => $search,        // Pass search back to the view
        'startSerial' => $startSerial // For numbering items
    ];

    // Load the view
    return view('Vendor_Product_list_sub_quotation', $data);
}

public function updateRevisionMessage()
{
    // Get input data from the request
    $id = $this->request->getPost('id');
    $message = $this->request->getPost('Revise_Quotation_Message');
    $vendorId = $this->request->getPost('vendor_id');

    // Validate input to ensure required fields are present
    if (empty($id) || empty($message) || empty($vendorId)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid data provided.']);
    }

    $vendorSubQuotationModel = new Vendor_Sub_Quotation();

    // Check if the record exists
    $subQuotation = $vendorSubQuotationModel->find($id);

    if ($subQuotation) {
        // Record found, proceed with the update
        $subQuotation['Revise_Quotation_Message'] = $message;

        if ($vendorSubQuotationModel->update($id, $subQuotation)) {
            // Send Firebase notification on successful update
            $this->sendFirebaseNotification($vendorId, $message);

            return $this->response->setJSON(['success' => true, 'message' => 'Revision message updated successfully.']);
        } else {
            // Log an error in case of failure
            log_message('error', "Failed to update sub-quotation with ID $id.");
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update revision message.']);
        }
    } else {
        // If no existing record found, insert a new record
        $data = [
            'id' => $id,
            'Revise_Quotation_Message' => $message,
        ];

        if ($vendorSubQuotationModel->insert($data)) {
            // Send Firebase notification on successful insert
            $this->sendFirebaseNotification($vendorId, $message);

            return $this->response->setJSON(['success' => true, 'message' => 'Revision message added successfully.']);
        } else {
            // Log an error in case of failure
            log_message('error', "Failed to insert sub-quotation with ID $id.");
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to insert revision message.']);
        }
    }
}

private function sendFirebaseNotification($vendorId, $message)
{
    // Use PartyUserModel to get the Firebase token for the vendor
    $partyUserModel = new PartyUserModel();
    $vendor = $partyUserModel->find($vendorId);

    // Check if the vendor has a valid Firebase token
    if ($vendor && !empty($vendor['firebase_token'])) {
        $firebaseToken = $vendor['firebase_token'];

        // Firebase notification payload
        $payload = [
            'to' => $firebaseToken,
            'notification' => [
                'title' => 'Message for quotation revise',
                'body' => $message,
            ],
            'priority' => 'high'
        ];

        // Debugging: Print the payload
        

        // Send the notification using Firebase REST API
        $this->sendFirebasePushNotification($payload);
    } else {
        // Log if no valid Firebase token is found
        log_message('error', "No Firebase token found for vendor ID $vendorId.");
    }
}

private function getFirebaseAccessToken()
{
    // Update the path to point to writable/upload directory
    $serviceAccountPath = WRITEPATH . 'uploads/supply-management-system-01-firebase-adminsdk-hqqnk-e32a58c386.json';
    
    //echo "Service Account Path: " . $serviceAccountPath . "\n";  // Log file path
    
    if (!file_exists($serviceAccountPath)) {
        echo "File not found\n";  // Log message
        log_message('error', 'Service account file not found at: ' . $serviceAccountPath);
        return null;
    }

    try {
        
echo "Creating client instance...\n";
$client = new Client();
echo "Client instance created.\n";

echo "Setting Auth Config...\n";
$client->setAuthConfig($serviceAccountPath);
echo "Auth config set.\n";

echo "Adding scope...\n";
$client->addScope('https://www.googleapis.com/auth/firebase.messaging');
echo "Scope added.\n";
        // Fetch access token
        $token = $client->fetchAccessTokenWithAssertion();
        echo 'Token: ' . json_encode($token) . "\n";  // Log the token
        return $token['access_token'] ?? null;
    } catch (\Exception $e) {
        echo "Token Failed: " . $e->getMessage() . "\n";  // Enhanced error message
        log_message('error', 'Error fetching Firebase access token: ' . $e->getMessage());
        return null;
    }
}


private function sendFirebasePushNotification($payload)
{
    // Get the Firebase access token
    $accessToken = $this->getFirebaseAccessToken();
    echo $accessToken;
die('END');

    print_r($accessToken);

    if (empty($accessToken)) {
        log_message('error', 'Failed to retrieve Firebase access token.');
        return;
    }

    $url = 'https://fcm.googleapis.com/v1/projects/supply-management-system-01/messages:send';  // Firebase v1 API endpoint
    $headers = [
        'Authorization: Bearer ' . $accessToken,  // Use the OAuth 2.0 access token for Authorization
        'Content-Type: application/json'
    ];

    // Debugging: Print the headers
    

    // Initialize cURL request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);  // Timeout after 10 seconds

    // Execute cURL request
    $response = curl_exec($ch);
    curl_close($ch);

    // Debugging: Print the Firebase response
    print_r($response);
    die();

    // Log Firebase response for debugging
    log_message('info', 'Firebase response: ' . $response);
}






public function removeMappedCompanies()
{
    $companyIds = $this->request->getPost('companyIds');
    
    if (!$companyIds) {
        return $this->response->setJSON(['error' => 'No companies selected']);
    }

    $vendorId = $this->request->getPost('vendorId'); // Ensure you pass the vendor ID

    $model = new VendorcompanyModel();
    
    // Remove selected companies for the vendor
    $model->where('Vendor_Id', $vendorId)
          ->whereIn('Company_Id', $companyIds)
          ->delete();

    return $this->response->setJSON(['success' => 'Companies removed successfully']);
}

public function updateVendorCompanies()
{
    $session = \Config\Services::session(); 
    $vendorId = $this->request->getPost('vendorId'); 
    $companyIds = $this->request->getPost('companyIds') ?? []; 

    // Check if $companyIds is an array
    if (!is_array($companyIds)) {
        log_message('error', '$companyIds is not an array in updateVendorCompanies.');
        return $this->response->setJSON(['error' => 'Invalid input for company IDs.']);
    }

    $model = new VendorcompanyModel();
    
    // Get the current companies associated with the vendor
    $existingCompanies = $model->where('Vendor_Id', $vendorId)->findAll();
    
    // Check if existing companies were found
    if ($existingCompanies === null) {
        log_message('error', 'No existing records found for vendor ID: ' . $vendorId);
        return $this->response->setJSON(['error' => 'No existing records found for this vendor.']);
    }

    // Extract IDs of currently associated companies
    $existingCompanyIds = array_column($existingCompanies, 'Company_Id');
    
    // Log existing company IDs
    log_message('info', 'Existing Company IDs: ' . json_encode($existingCompanyIds));

    // Determine which companies need to be removed
    $companiesToRemove = array_intersect($existingCompanyIds, $companyIds);
    
    log_message('info', 'Companies to Remove: ' . json_encode($companiesToRemove));

    // Only proceed with deletion if there are companies to remove
    if (!empty($companiesToRemove)) {
        try {
            // Perform deletion
            $deletedRows = $model->where('Vendor_Id', $vendorId)
                                  ->whereIn('Company_Id', $companiesToRemove)
                                  ->delete(); // This line will delete rows

            // Check how many rows were deleted
            if ($deletedRows) {
                log_message('info', 'Deleted companies: ' . json_encode($companiesToRemove) . ' for Vendor ID: ' . $vendorId);
                return $this->response->setJSON(['success' => true]);
            } else {
                log_message('info', 'No companies deleted for Vendor ID: ' . $vendorId . ' with IDs: ' . json_encode($companiesToRemove));
                return $this->response->setJSON(['success' => false, 'message' => 'No companies were deleted.']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error removing companies: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error removing companies.']);
        }
    } else {
        log_message('info', 'No companies to remove for Vendor ID: ' . $vendorId);
        return $this->response->setJSON(['success' => true, 'message' => 'No companies were removed.']);
    }
}


}
   