<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class BillRegisterModelDraft extends Model   
{
    protected $table = 'asitek_bill_register_draft';    
    protected $primaryKey = 'id';     
    protected $allowedFields = 
    [
        'uid', 'compeny_id', 'Add_By', 'Bill_No', 'Gate_Entry_No', 'Unit_Id', 'Vendor_Id', 'Bill_DateTime', 'Gate_Entry_Date', 'Bill_Amount', 'Remark', 'Bill_Pic', 'Department_Id', 'Department_Emp_Id', 'DateTime', 'Active', 'Bill_Acceptation_Status_By_MasterId','Bill_Acceptation_Status', 'Bill_Acceptation_DateTime', 'Bill_Acceptation_Status_Comments', 'Mapping_By_MasterId','Bill_Type', 'TargetMapping_Time_Hours', 'Mapping_Delay_On_Time', 'Mapping_Remark', 'Mapping_Master_Action','MasterId_By_Clear_Bill_Form', 'Clear_Bill_Form_Status', 'Clear_Bill_Form_DateTime', 'Clear_Bill_Form_Status_Comments', 'TargetClearBillForm_Time_Hours', 'ClearBillForm_Delay_On_Time', 'Clear_Bill_Form_AnyImage', 'ClearBillForm_Remark', 'ClearFormBill_Master_Action', 'Mapping_ERP_EmpId', 'Mapping_ERP_EmpId_By_MasterId','ERP_Status_Change_By_MasterId','ERP_Status', 'ERP_Comment', 'ERP_DateTime', 'Target_ERP_Time_Hours', 'ERP_Delay_On_Time', 'ERP_AnyImage', 'ERP_Remark', 'ERP_Master_Action', 'Mapping_Acount_EmpId','Mapping_Account_By_MasterId', 'Recived_Status_Change_By_MasterId','Recived_Status', 'Recived_Comment', 'Recived_DateTime', 'Recived_TragetTime_Hours', 'Recived_Delay_On_Time', 'Recived_AnyImage', 'Recived_Remark', 'Recived_Master_Action','Recived_Completed_By_MasterId', 'Vendor_Comment', 'Vendor_Upload_Image', 'Add_By_Vendor', 'vendor_status'      
    ]; 
}
?>