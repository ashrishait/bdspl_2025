<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class PartyUserModel extends Model  
{
    protected $table = 'asitek_party_user';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
    [
        'compeny_id',
        'GST_No',   
        'Name',   
        'Mobile_No',           
        'Email_Id',
        'role',
        'password',
        'current_address',
        'current_state',
        'current_city',
        'current_pincode',
        'permanent_address',
        'permanent_state',
        'permanent_city',
        'permanent_pincode',           
        'Active',       
        'DateTime',
        'Expiry_Date'
    ];  
}
