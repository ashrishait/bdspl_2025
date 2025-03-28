<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class PointconversionModel extends Model   
{
    protected $table = 'asitek_reward_conversion';    
    protected $primaryKey = 'Id';     
    protected $allowedFields = 
    [
        'Conversion_Point', 'Rec_Time_Stamp', 'Active'    
    ]; 
}