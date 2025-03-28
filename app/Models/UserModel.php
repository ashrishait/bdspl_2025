<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class UserModel extends Model  
{
    protected $table = 'asitek_user';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
    'compeny_id',    
    'emp_id',   
    'emp_u_id',           
    'email',           
    'password',       
    'role',
    'active'   
    ];  
}
