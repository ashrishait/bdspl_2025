<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class ClassModel extends Model  
{
    protected $table = 'asitek_class';      
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
    'class_name',
    'class_abbrevation',             
    'rec_time_stamp',           
    'active'   
    ];  
}
