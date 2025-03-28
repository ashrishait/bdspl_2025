<?php

namespace App\Models;  
use CodeIgniter\Model;
use CodeIgniter\Controller;    
class MasterActionModel extends Model  
{
    protected $table = 'asitek_master_action';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
     'compeny_id',      
    'stage_id', 
    'action_name', 
    'no_of_action',           
    'active'
    
    ];  
}
