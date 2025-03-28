<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class CityModel extends Model  
{
    protected $table = 'asitek_city';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
    'state_id',           
    'city_name',           
    'active'   
    ];  
}
