<?php
namespace App\Models;  
use CodeIgniter\Model;
use CodeIgniter\Controller; 

class DepartmentnameModel extends Model  
{
    protected $table = 'asitek_departname';    
    protected $primaryKey = 'Id';     
    protected $allowedFields =
    [
        'Company_Id',    
        'Department_Name',    
        'Rec_Time_Stamp',      
        'Active',
    ];  
}
