<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class StateModel extends Model    
{
    protected $table = 'asitek_state';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
    'country_id',           
    'state_name',
    'state_abbrevation',           
    'active'   
    ];  
}
