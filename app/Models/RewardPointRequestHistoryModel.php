<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class RewardPointRequestHistoryModel extends Model  
{
    protected $table = 'asitek_reward_point_request_history';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
    'compeny_id',           
    'emp_id', 
    'request_reward_point',
    'comment',
    'status',          
    'active',
    'rec_time_stamp'  
    ];  
}
