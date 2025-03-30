<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class Company_Quotation_Order extends Model    
{
    protected $table = 'asitek_quotation_order';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
              
    'order_date',
    'company_id',
    'vendor_id',
    'Quoate_Id', 
    'Sub_Quote_Id', 
    'active'   
    ];  
}
