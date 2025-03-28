<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class BillShippedModel extends Model  
{
    protected $table = 'asitek_bill_shipped';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
    'compeny_id',           
    'Year',           
    'Month',
    'TotalAmount', 
    'BillPassAmount ',           
    'BalanceAmount',           
    'BalanceToShipAmount',
    'DateTime',
    'Active'  
    ];  
}
