<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class Company_Order_Product extends Model    
{
    protected $table = 'asitek_ordered_product';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
              
    'quantity',
    'revised_price',
    'total_price',
    'Order_Id',
    'Product_Id',
    'Quote_Id', 
    'Sub_Quote_Id',
    'Delivery_Date',   
    'active'   
    ];  
}
