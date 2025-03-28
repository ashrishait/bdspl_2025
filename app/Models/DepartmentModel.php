<?php

namespace App\Models;  
use CodeIgniter\Model;
use CodeIgniter\Controller;    
class DepartmentModel extends Model  
{
    protected $table = 'asitek_department';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
    'compeny_id',    
   'bill_type_id',      
   'name',
   'Mapping_Time_Hours',
   'ClearBill_Form_Time_Hours',
   'ERP_Time_Hours',
   'BillRecived_Time_Hours',
   'sub_department', 
   'description',            
    'active'
    
    ];  
}
