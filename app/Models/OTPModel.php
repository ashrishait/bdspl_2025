<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class OTPModel extends Model  
{
    protected $table = 'otp_verification';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
    [
       'mobile_no', 'email', 'otp', 'email_otp', 'status', 'created_at'
    ];  
}
