<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class Vendor_Sub_Quotation extends Model    
{
    protected $table = 'asitek_vendor_Sub_quotation';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
              
    'company_id',
    'Quote_Id',
    'title',
    'status',
    'vendor_id',
    'Revise_Quotation_Message',  
    'rec_time_stamp',   
    'active'   
    ];  
}
