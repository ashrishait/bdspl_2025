<?php

namespace App\Controllers;

use App\Models\UnitModel;
use App\Models\DepartmentModel;
use App\Models\BillTypeModel;
use CodeIgniter\Controller; 

class BillTypeController extends BaseController     
{  
  
    private $db; 
    public function __construct()
    {
      $this->db = db_connect(); // Loading database
    }




public function add_billtype()      
    {
        $validation =  \Config\Services::validation(); 

             $model = new BillTypeModel();
          
            $data = [     
             'compeny_id' => $this->request->getVar('compeny_id'),
            'name' => $this->request->getVar('namee'),
             'description' => $this->request->getVar('description')
            
              
            ];
              
                $insert = $model->insert($data);      
             
                if($insert){

                      

                    $session = \Config\Services::session();
                    $session->setFlashdata('emp_ok',1);
                    return redirect('view_billType'); 
 
                }
           
    }   


 public function view_billType()  
    {   

         $session = \Config\Services::session(); 
        $result = $session->get();    
      
        $etm = $result['edn'];
         $compeny_id = $result['compeny_id'];
       
      
        $data['dax'] = $this->db->query("select  * from asitek_bill_type  where compeny_id='$compeny_id' ORDER BY id ASC ")->getResultArray();
     $model9= new DepartmentModel();  
    $data['dax9']=$model9->findAll();
        return view('view_billType',$data);   


    } 


    public function update_billType()      
    {
      
        
                $model = new BillTypeModel();
                $data = [     
           
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description')
              
            ];
                if($model->where('id', $this->request->getVar('id'))->set($data)->update())
                {


                        
                    $session = \Config\Services::session();
                   $session->setFlashdata('data_up',1);
                    return redirect('view_billType'); 

                   
                } 
            
    }

 public function del_billType()   
    {  
       $session = \Config\Services::session();   
        $model = new BillTypeModel();
        $model->where('id', $this->request->getVar('id'))->delete();
        $session->setFlashdata('data_delete',1); 
        return redirect('view_billType');        
    }











  }