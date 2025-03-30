<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class Help_Support extends Model    
{
    protected $table = 'asit_help_support';    
    protected $primaryKey = 'Id';     
    protected $allowedFields =
     [
              
    'company_id',
    'vendor_id',
    'Title',
    'Status',   
    'Active'   
    ];  
}
