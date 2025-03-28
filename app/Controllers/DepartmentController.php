<?php
namespace App\Controllers;
use App\Models\DepartmentModel;
use App\Models\UnitModel; 
use App\Models\BillTypeModel;
use App\Models\DepartmentnameModel;
use CodeIgniter\Controller; 

class DepartmentController extends BaseController     
{  
  
    private $db; 
    public function __construct()
    {
      $this->db = db_connect(); // Loading database
    }


    public function getDepartment2()       
    {
        $session = \Config\Services::session(); 
        $result = $session->get();
        $compeny_id = $session->get("compeny_id"); 
        if($this->request->getVar('action'))
        {
            $action = $this->request->getVar('action');
            if($action == 'get_Department2')                           
            {
                $cityModel = new DepartmentModel();
                $citydata = $cityModel->where('compeny_id', $compeny_id)->where('bill_type_id', $this->request->getVar('state_id'))->findAll();
                echo json_encode($citydata);
            }
        }
    }  


    public function add_department()      
    {
        $validation =  \Config\Services::validation(); 
        $model = new DepartmentModel();
        $data = [   
            'compeny_id' => $this->request->getVar('compeny_id'),  
            'bill_type_id' => $this->request->getVar('bill_type_id'),
            'name' => $this->request->getVar('namee'),
            'Mapping_Time_Hours' => $this->request->getVar('Mapping_Time_Hours'),
            'ClearBill_Form_Time_Hours' => $this->request->getVar('ClearBill_Form_Time_Hours'),
            'ERP_Time_Hours' => $this->request->getVar('ERP_Time_Hours'),
            'BillRecived_Time_Hours' => $this->request->getVar('BillRecived_Time_Hours'),
            'sub_department' => $this->request->getVar('sub_department'),
            'description' => $this->request->getVar('description')
        ];
        $insert = $model->insert($data);      
        if($insert){
            $session = \Config\Services::session();
            $session->setFlashdata('emp_ok',1);
            return redirect('view_department'); 
        }
    }   


    public function view_department()  
    {   
        $session = \Config\Services::session(); 
        $result = $session->get();    
        $etm = $result['edn'];
        $compeny_id = $result['compeny_id'];
        $data['dax'] = $this->db->query("select  * from asitek_department where compeny_id='$compeny_id'  ORDER BY id ASC ")->getResultArray();
        $model9= new UnitModel();  
        $data['dax9']=$model9->findAll();
        $model10= new BillTypeModel();  
        $data['dax10']=$model10->where('compeny_id', $compeny_id)->findAll();
        $depmodel= new DepartmentnameModel();  
        $data['depname']=$depmodel->where('Company_Id', $compeny_id)->findAll();
        return view('view_department',$data);   
    } 


    public function update_Department()      
    {
        $model = new DepartmentModel();
        $data = [     
            'bill_type_id' => $this->request->getVar('bill_type_id'),
            'name' => $this->request->getVar('name'),
            'Mapping_Time_Hours' => $this->request->getVar('Mapping_Time_Hours'),
            'ClearBill_Form_Time_Hours' => $this->request->getVar('ClearBill_Form_Time_Hours'),
            'ERP_Time_Hours' => $this->request->getVar('ERP_Time_Hours'),
            'BillRecived_Time_Hours' => $this->request->getVar('BillRecived_Time_Hours'),
            'sub_department' => $this->request->getVar('sub_department'),
            'description' => $this->request->getVar('description')
        ];
        if($model->where('id', $this->request->getVar('id'))->set($data)->update())
        {
            $session = \Config\Services::session();
            $session->setFlashdata('data_up',1);
            return redirect('view_department'); 
        } 
    }

    public function del_Department()   
    {  
        $session = \Config\Services::session();   
        $model = new DepartmentModel();
        $model->where('id', $this->request->getVar('id'))->delete();
        $session->setFlashdata('data_delete',1); 
        return redirect('view_department');        
    }
}