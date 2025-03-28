<?php
    namespace App\Models;
    use CodeIgniter\Model;
    class PageaccessionModel extends Model
    {
        protected $table = 'asitek_emp_page_access';
        protected $primaryKey = 'id';
        protected $allowedFields = ['Company_Id', 'Add_By', 'Page_Id', 'Emp_Id'];
        
        
        public function pagelinkaccordingtoroll($empid){
            $buildercard = $this->db->table("asitek_emp_page_access as pa");
            $buildercard->select('pa.*, ap.Page_Link, ap.Page_Name');
            $buildercard->join('asitek_page as ap', 'ap.Id = pa.Page_Id');
            return $buildercard->where('pa.Emp_Id', $empid);
        }
        
        
    }
