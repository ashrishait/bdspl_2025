<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class RewardPointModel extends Model    
{
    protected $table = 'asitek_reward_point';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
              
    'bill_id','compeny_id','emp_id','reward_point','reward_point_type','status','paid_status','action','rec_time_stamp'   
    ];  
}
