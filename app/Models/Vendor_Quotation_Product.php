<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class Vendor_Quotation_Product extends Model    
{
    protected $table = 'asitek_vendor_quote_product';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
              
    'price',
    'Product_Id',
    'Quote_Id', 
    'Sub_Quote_Id',  
    'active'   
    ];  
}
