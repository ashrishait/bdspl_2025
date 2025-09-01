<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class BillRegisterModel extends Model   
{
    protected $table = 'asitek_bill_register';    
    protected $primaryKey = 'id';     
    protected $allowedFields = 
    [
        'uid', 'compeny_id', 'Add_By', 'Bill_No', 'Gate_Entry_No', 'Unit_Id', 'Vendor_Id', 'Bill_DateTime', 'Gate_Entry_Date', 'Bill_Amount', 'Remark', 'Bill_Pic', 'Department_Id', 'Department_Emp_Id', 'DateTime', 'Active', 'Bill_Acceptation_Status_By_MasterId','Bill_Acceptation_Status', 'Bill_Acceptation_DateTime', 'Bill_Acceptation_Status_Comments', 'Mapping_By_MasterId','Bill_Type', 'TargetMapping_Time_Hours', 'Mapping_Delay_On_Time', 'Mapping_Remark', 'Mapping_Master_Action','MasterId_By_Clear_Bill_Form', 'Clear_Bill_Form_Status', 'Clear_Bill_Form_DateTime', 'Clear_Bill_Form_Status_Comments', 'TargetClearBillForm_Time_Hours', 'ClearBillForm_Delay_On_Time', 'Clear_Bill_Form_AnyImage', 'ClearBillForm_Remark', 'ClearFormBill_Master_Action', 'Mapping_ERP_EmpId', 'Mapping_ERP_EmpId_By_MasterId','ERP_Status_Change_By_MasterId','ERP_Status', 'ERP_Comment', 'ERP_DateTime', 'Target_ERP_Time_Hours', 'ERP_Delay_On_Time', 'ERP_AnyImage', 'ERP_Remark', 'ERP_Master_Action', 'Mapping_Acount_EmpId','Mapping_Account_By_MasterId', 'Recived_Status_Change_By_MasterId','Recived_Status', 'Recived_Comment', 'Recived_DateTime', 'Recived_TragetTime_Hours', 'Recived_Delay_On_Time', 'Recived_AnyImage', 'Recived_Remark', 'Recived_Master_Action','Recived_Completed_By_MasterId', 'Vendor_Comment', 'Vendor_Upload_Image', 'Add_By_Vendor', 'vendor_status', 'Send_Note_By', 'Send_Note_To', 'Send_Note_Image', 'Send_Note_Remark', 'Send_Note_Status', 'Send_Note_To_Account_By', 'Send_Account_Note_Image', 'Send_Note_Account_Remark', 'Send_Note_Account_Status', 'Send_Vendor_Note_Image', 'Send_Note_Vendor_Remark', 'Send_Note_Vendor_Status', 'Vendor_Debit_Note_Update', 'Vendor_Debit_Note_Remark'      
    ]; 

    /***ADMIN***/
    public function getSumOfAllBillAmount($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';   
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function getSumOfBillAmount($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';  
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function getSumOfAcceptedBillAmount($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function getSumOfRejectedBillAmount($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function getSumOfDoneBillAmount($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }
    //*******//
    public function ClearBillFormPendingSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function ClearBillFormAcceptedSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }
    public function ClearBillFormRejectSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }
    public function ClearBillFormDoneSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }
    //*******//

    public function ERPSystemBillPendingSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function ERPSystemBillFormAcceptedSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }
    public function ERPSystemBillRejectSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function ERPSystemBillDoneSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    //*******//
    public function RecivedBillPendingSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function RecivedBillAcceptedSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function RecivedBillRejectSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function RecivedBillDoneSum($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    /******EMPLOYEE*****/
    public function getSumOfAllBillAmountEmp($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function getSumOfBillAmountEmp($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function getSumOfAcceptedBillAmountEmp($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function getSumOfRejectedBillAmountEmp($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function getSumOfDoneBillAmountEmp($compeny_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    //*******//
    public function ClearBillFormPendingSumEmp($compeny_id, $empid,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Department_Emp_Id', $empid)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function ClearBillFormAcceptedSumEmp($compeny_id, $empid,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Department_Emp_Id', $empid)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function ClearBillFormRejectSumEmp($compeny_id, $empid,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Department_Emp_Id', $empid)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function ClearBillFormDoneSumEmp($compeny_id, $empid,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Department_Emp_Id', $empid)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    //*******//
    public function ERPSystemBillPendingSumEmp($compeny_id, $emp_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Mapping_ERP_EmpId', $emp_id)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function ERPSystemBillFormAcceptedSumEmp($compeny_id, $emp_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Mapping_ERP_EmpId', $emp_id)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function ERPSystemBillRejectSumEmp($compeny_id, $emp_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Mapping_ERP_EmpId', $emp_id)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function ERPSystemBillDoneSumEmp($compeny_id, $emp_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Bill_Acceptation_Status', 4)->where('Mapping_ERP_EmpId', $emp_id)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    
    //*******//
    public function RecivedBillPendingSumEmp($compeny_id, $emp_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Mapping_Acount_EmpId', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 1)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function RecivedBillAcceptedSumEmp($compeny_id, $emp_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Mapping_Acount_EmpId', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 2)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function RecivedBillRejectSumEmp($compeny_id, $emp_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Mapping_Acount_EmpId', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 3)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }

    public function RecivedBillDoneSumEmp($compeny_id, $emp_id,$start_Date,$end_Date)
    {
        $date_format = '%Y-%m-%d';
        return $this->selectSum('Bill_Amount')->where('compeny_id', $compeny_id)->where('Mapping_Acount_EmpId', $emp_id)->where('Bill_Acceptation_Status', 4)->where('Clear_Bill_Form_Status', 4)->where('ERP_Status', 4)->where('Recived_Status', 4)->where("STR_TO_DATE(Bill_DateTime, '$date_format') BETWEEN STR_TO_DATE('$start_Date', '$date_format') AND STR_TO_DATE('$end_Date', '$date_format')")->get()->getRowArray();
    }
}
  