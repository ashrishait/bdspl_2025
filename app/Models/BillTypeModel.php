<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class BillTypeModel extends Model  
{
    protected $table = 'asitek_bill_type';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
     'compeny_id',     
    'name', 
    'description',          
    'active'   
    ];  
}
