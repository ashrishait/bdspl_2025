<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class Company_Add_Request extends Model    
{
    protected $table = 'asitek_company_requests';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
              
    'company_id',
    'vendor_id',
    'status',
    'comment',    
    ];  
}
