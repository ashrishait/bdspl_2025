<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class RollModel extends Model    
{
    protected $table = 'asitek_roll';    
    protected $primaryKey = 'Roll_Id';     
    protected $allowedFields =
     [
              
    'Name',
              
    'Active'   
    ];  
}
