<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class Vendor_Quotation extends Model    
{
    protected $table = 'asitek_vendor_quotation';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
              
    'company_id',
    'title',
    'status',
    'vendor_id',
    'rec_time_stamp',   
    'active'   
    ];  
}
