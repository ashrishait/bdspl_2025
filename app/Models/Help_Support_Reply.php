<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class Help_Support_Reply extends Model    
{
    protected $table = 'asit_help_support_reply';    
    protected $primaryKey = 'Id';     
    protected $allowedFields =
     [
              
    'Help_Id',
    'Vendor_Message',       
    'company_id',
    'Company_Reply',
    'vendor_id',
    'Active'   
    ];  
}
