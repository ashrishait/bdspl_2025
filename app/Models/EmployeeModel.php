<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class EmployeeModel extends Model   
{
    protected $table = 'asitek_employee';    
    protected $primaryKey = 'id';     
    protected $allowedFields = 
    [
        'compeny_id', 'unit_id', 'emp_jio_id', 'project_id', 'location_id', 'emp_u_id', 'first_name', 'last_name', 'emp_image', 'dob', 'gender', 'blood_group', 'email', 'mobile', 'current_address', 'current_state', 'current_city', 'current_pincode', 'permanent_address', 'permanent_state', 'permanent_city', 'permanent_pincode', 'aadhar_no', 'qualification', 'technical_education', 'office_shift', 'role', 'department', 'designation', 'basic_salary', 'hourly_rate', 'payslip_type', 'rec_time_stamp', 'actives', 'super', 'team_leader' , 'bank_name', 'Acnt_No', 'Ifsc_Code', 'Bank_Branch', 'Acnt_Holder_Name', 'eligible_for_debit_note'       
    ]; 

  
}
  