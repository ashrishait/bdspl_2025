<?php
    namespace App\Models;  
    use CodeIgniter\Model;
    
    class PageModel extends Model  
    {
        protected $table = 'asitek_page';    
        protected $primaryKey = 'Id';     
        protected $allowedFields =
        [
            'Page_Name',           
            'Page_Link',           
            'Is_Submenu',
            'Parent_Name'
        ];  
    }
