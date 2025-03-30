<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class Vendor_Product extends Model    
{
    protected $table = 'asitek_vendor_product';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
              
    'product_name',
    'image',
    'price',
    'description',
    'vendor_id',   
    'active'   
    ];  
}
