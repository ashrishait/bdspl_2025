<?php

namespace App\Controllers;

use App\Models\UnitModel;
use App\Models\DepartmentModel;
use App\Models\asitek_unit;
use CodeIgniter\Controller; 

class UnitController extends BaseController     
{  
    private $db; 
    public function __construct()
    {
      $this->db = db_connect(); // Loading database
    }

    public function getUnit()       
    {
        if($this->request->getVar('action'))
        {
            $action = $this->request->getVar('action');
            if($action == 'get_unit')                           
            {
                $cityModel = new UnitModel();
                $citydata = $cityModel->where('compeny_id', $this->request->getVar('company_id'))->findAll();
                echo json_encode($citydata);
            }
        }
    }  


    public function add_unit()      
    {
        $validation =  \Config\Services::validation(); 

             $model = new UnitModel();
          
            $data = [     
             'compeny_id' => $this->request->getVar('compeny_id'),
            'name' => $this->request->getVar('namee'),
             'description' => $this->request->getVar('description')
            
              
            ];
              
                $insert = $model->insert($data);      
             
                if($insert){

                      

                    $session = \Config\Services::session();
                    $session->setFlashdata('emp_ok',1);
                    return redirect('view_unit'); 
 
                }
           
    }   


 public function view_unit()  
    {   

         $session = \Config\Services::session(); 
        $result = $session->get();    
      
        $etm = $result['edn'];
           $compeny_id = $result['compeny_id'];
       
      
        $data['dax'] = $this->db->query("select  * from asitek_unit where compeny_id='$compeny_id' ORDER BY id ASC ")->getResultArray();
     $model9= new DepartmentModel();  
    $data['dax9']=$model9->findAll();
        return view('view_unit',$data);   


    } 


    public function update_unit()      
    {
      
        
                $model = new UnitModel();
                $data = [     
         
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description')
              
            ];
                if($model->where('id', $this->request->getVar('id'))->set($data)->update())
                {


                        
                    $session = \Config\Services::session();
                   $session->setFlashdata('data_up',1);
                    return redirect('view_unit'); 

                   
                } 
            
    }

 public function del_unit()   
    {  
       $session = \Config\Services::session();   
        $model = new UnitModel();
        $model->where('id', $this->request->getVar('id'))->delete();
        $session->setFlashdata('data_delete',1); 
        return redirect('view_unit');        
    }











  }