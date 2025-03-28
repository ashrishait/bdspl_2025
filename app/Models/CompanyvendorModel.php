<?php
    namespace App\Models;  
    use CodeIgniter\Model;
    
    class CompanyvendorModel extends Model  
    {
        protected $table = 'asitek_company_vendor';    
        protected $primaryKey = 'Id';     
        protected $allowedFields =
        [
            'Company_Id',           
            'Vendor_Id',           
            'Rec_Time_Stamp',
            'Active'
        ];  
    }
