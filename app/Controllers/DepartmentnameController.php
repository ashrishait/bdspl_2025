<?php
namespace App\Controllers;
use App\Models\DepartmentnameModel;
use CodeIgniter\Controller; 

class DepartmentnameController extends BaseController     
{  
  
    private $db; 
    public function __construct()
    {
      $this->db = db_connect(); // Loading database
    }


    public function adddepartmentname()      
    {
        $validation =  \Config\Services::validation(); 
        $model = new DepartmentnameModel();
        $data = [   
            'Company_Id' => $this->request->getVar('compeny_id'), 
            'Department_Name' => $this->request->getVar('depname') 
        ];
        $insert = $model->insert($data);      
        if($insert){
            $session = \Config\Services::session();
            $session->setFlashdata('emp_ok',1);
            return redirect('view-department-name'); 
        }
    }   


    public function viewdepartmentname()  
    {   
        $session = \Config\Services::session(); 
        $result = $session->get();    
        $etm = $result['edn'];
        $compeny_id = $result['compeny_id'];
        $data['dax'] = $this->db->query("select  * from asitek_departname where Company_Id='$compeny_id'  ORDER BY id DESC ")->getResultArray();
        return view('departmentname',$data);   
    } 


    public function updatedepartmentname()      
    {
        $model = new DepartmentnameModel();
        $data = [     
            'Department_Name' => $this->request->getVar('name') 
        ];
        if($model->where('Id', $this->request->getVar('id'))->set($data)->update())
        {
            $session = \Config\Services::session();
            $session->setFlashdata('data_up',1);
            return redirect('view-department-name'); 
        } 
    }

    public function deldepartmentname()   
    {  
        $session = \Config\Services::session();   
        $model = new DepartmentnameModel();
        $model->where('Id', $this->request->getVar('id'))->delete();
        $session->setFlashdata('data_delete',1); 
        return redirect('view-department-name');        
    }
}