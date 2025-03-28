<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class SeasionYearModel extends Model  
{
    protected $table = 'asitek_seasion_year';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
          
   'name',           
    'active',
    'type'  
    ];  
}
