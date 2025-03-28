<?php

namespace App\Controllers;

use App\Models\UnitModel;
use App\Models\DepartmentModel;
use App\Models\MasterActionModel;
use CodeIgniter\Controller; 

class MasterActionController extends BaseController     
{  
  
    private $db; 
    public function __construct()
    {
      $this->db = db_connect(); // Loading database
    }


   


public function add_master_action()      
    {
        $validation =  \Config\Services::validation(); 

             $model = new MasterActionModel();

             $stage_id=$this->request->getVar('stage_id');
             $no_of_action =$this->request->getVar('no_of_action');
                  $compeny_id =$this->request->getVar('compeny_id');
              $rowMasterAction1= $model->where('stage_id',$stage_id)->where('no_of_action',$no_of_action)->where('compeny_id',$compeny_id)->first();
              
          if(isset($rowMasterAction1) && $rowMasterAction1!='')
                                             
          {
               $session = \Config\Services::session();
                    $session->setFlashdata('no_of_action',1);
                    return redirect('view_master_action'); 
          }
          else
          {

            $data = [     
             'compeny_id' => $this->request->getVar('compeny_id'),
            'stage_id' => $this->request->getVar('stage_id'),
             'action_name' => $this->request->getVar('action_name'),
              'no_of_action' => $this->request->getVar('no_of_action')
            
              
            ];
              
                $insert = $model->insert($data);      
             
                if($insert){

                      

                    $session = \Config\Services::session();
                    $session->setFlashdata('emp_ok',1);
                    return redirect('view_master_action'); 
 
                }
            }
           
    }   


    public function view_master_action()  
    {   
        $session = \Config\Services::session(); 
        $result = $session->get();    
        $etm = $result['edn'];
        $compeny_id = $result['compeny_id'];
        $data['dax'] = $this->db->query("select  * from asitek_master_action where compeny_id='$compeny_id' ")->getResultArray();
        return view('view_master_action',$data);   
    } 


    public function update_master_action()      
    {
      
        
                $model = new MasterActionModel();
                $data = [     
         
            'stage_id' => $this->request->getVar('stage_id'),
            'action_name' => $this->request->getVar('action_name'),
             'no_of_action' => $this->request->getVar('no_of_action')
              
            ];
                if($model->where('id', $this->request->getVar('id'))->set($data)->update())
                {


                        
                    $session = \Config\Services::session();
                   $session->setFlashdata('data_up',1);
                    return redirect('view_master_action'); 

                   
                } 
            
    }

 public function del_master_action()   
    {  
       $session = \Config\Services::session();   
        $model = new MasterActionModel();
        $model->where('id', $this->request->getVar('id'))->delete();
        $session->setFlashdata('data_delete',1); 
        return redirect('view_master_action');        
    }











  }