<?php
namespace App\Models;  
use CodeIgniter\Model;
   
class VendorloginModel extends Model  
{
    protected $table = 'asitek_vendor_activity_log';      
    protected $primaryKey = 'Id';     
    protected $allowedFields =
    [
        'User_Id',             
        'Login_Time',           
        'Logout_Time',
           
    ];  
}
