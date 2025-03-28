<?php
namespace App\Models;  
use CodeIgniter\Model;
   
class LoginactivityModel extends Model  
{
    protected $table = 'asitek_activity_log';      
    protected $primaryKey = 'Id';     
    protected $allowedFields =
    [
        'Company_Id',
        'User_Id',             
        'Login_Time',           
        'Logout_Time',
        'Emp_Role',
        'Login_By_Admin'     
    ];  

    public function getRecentLogins($perPage)
    {
        // Fetch recent login data from the database
        $query = $this->select('asitek_activity_log.Company_Id, asitek_activity_log.User_Id, asitek_activity_log.Login_Time, asitek_activity_log.Logout_Time, asitek_activity_log.Emp_Role, asitek_activity_log.Login_By_Admin, asitek_employee.first_name, asitek_employee.last_name, asitek_compeny.name')->join('asitek_employee', 'asitek_employee.id = asitek_activity_log.User_Id')->join('asitek_compeny', 'asitek_activity_log.Company_Id = asitek_compeny.id')->orderBy('asitek_activity_log.Login_Time', 'DESC')->paginate($perPage); 
        return $query;
    }
}
