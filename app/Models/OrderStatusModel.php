<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class OrderStatusModel extends Model    
{
    protected $table = 'asitek_order_status';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
              
    'Delivered_quantity',
    'delivered_date',
    'company_id',
    'vendor_id',
    'Product_Id',
    'Order_Id',  
    'Quoate_Id',
    'sub_quote_id', 
    'active'   
    ];  
}
