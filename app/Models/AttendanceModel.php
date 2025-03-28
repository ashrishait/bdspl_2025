<?php

namespace App\Models;  
use CodeIgniter\Model;
   
class AttendanceModel extends Model  
{
    protected $table = 'asitek_attendance';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
     [
    'emp_id',   
    'countryname',           
    'region_name',           
    'city',       
    'latitute',
    'longitutde',   
    'ipaddress',           
    'zipcode',           
    'rec_time_stamp',       
    'country_code',
    'region_code',
    'status',
    'end',
    'login_time',
    'logout_time',     
    'total_time'       
    ];  


public function getRow($Employee_Id){
        return $this->where('emp_id',$Employee_Id)->first();
    }

}
