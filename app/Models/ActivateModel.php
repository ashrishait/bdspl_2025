<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class ActivateModel extends Model  
{
    protected $table = 'asitek_vemdor_recharge';    
    protected $primaryKey = 'Id';     
    protected $allowedFields =
    [
        'Vendor_Id',           
        'Subscription_Pack',           
        'Subscription_Price	',
        'Start_Date',           
        'End_Date',           
        'Rec_Time_Stamp	',
        'Active	'
    ];  
}
