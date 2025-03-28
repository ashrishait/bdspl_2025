<?php

namespace App\Models;  
use CodeIgniter\Model;
use CodeIgniter\Controller;    
class UnitModel extends Model  
{
    protected $table = 'asitek_unit';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
    'compeny_id',      
    'name', 
    'description',            
    'active'
    
    ];  
}
