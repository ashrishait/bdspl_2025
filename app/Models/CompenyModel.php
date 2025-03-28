<?php
namespace App\Models;  
use CodeIgniter\Model;
use CodeIgniter\Controller;    

class CompenyModel extends Model  
{
    protected $table = 'asitek_compeny';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
    [
        'id',
        'name',      
        'email', 
        'contact_no',            
        'image',
        'active',
        'rec_time_stamp'
    ];  
    
    public function getcompanyname($companyid)
    {
        $query = $this->select('name')->where('id =', $companyid)->get();
        if ($query->getNumRows() > 0) {
            return $query->getRow()->name;
        } else {
            return null; // or any default value
        }
    }
}
