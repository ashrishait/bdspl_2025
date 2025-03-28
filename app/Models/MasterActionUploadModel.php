<?php

namespace App\Models;  
use CodeIgniter\Model;
use CodeIgniter\Controller;    
class MasterActionUploadModel extends Model  
{
    protected $table = 'asitek_master_action_upload';    
    protected $primaryKey = 'id';     
    protected $allowedFields =
    [
      'uploaded_by',
      'compeny_id',  
      'bill_id',      
      'master_action_id', 
      'image_upload',
      'remark',            
      'active'
    ];  
}
