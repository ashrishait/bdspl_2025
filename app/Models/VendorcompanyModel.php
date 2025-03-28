<?php
    namespace App\Models;  
    use CodeIgniter\Model;
    
    class VendorcompanyModel extends Model  
    {
        protected $table = 'asitek_vendor_company';    
        protected $primaryKey = 'Id';     
        protected $allowedFields =
        [
            'Vendor_Id',           
            'Company_Id',           
            'Rec_Time_Stamp',
            'Active'
        ];  
    }
