<?php

namespace App\Controllers;

use App\Models\SeasionYearModel;
use CodeIgniter\Controller; 

class SeasonSessionYearController extends BaseController     
{  
  
    private $db; 
    public function __construct()
    {
      $this->db = db_connect(); // Loading database
    }


  


public function add_SeasonSession_Year()      
    {
        $validation =  \Config\Services::validation(); 

             $model = new SeasionYearModel();
          
            $data = [     
         
            'name' => $this->request->getVar('namee'),
             'type' => $this->request->getVar('typee')
            
              
            ];
              
                $insert = $model->insert($data);      
             
                if($insert){

                      

                    $session = \Config\Services::session();
                    $session->setFlashdata('emp_ok',1);
                    return redirect('view_SeasonSession_Year'); 
   
                    
                }
           
    }   


 public function view_SeasonSession_Year()  
    {   

         $session = \Config\Services::session(); 
        $result = $session->get();    
      
        $etm = $result['edn'];
        
       
      
        $data['dax'] = $this->db->query("select  * from asitek_seasion_year  ORDER BY id ASC ")->getResultArray();

        return view('view_SeasonSession_Year',$data);   


    } 


    public function update_SeasonSession_Year()      
    {
      
        
                $model = new SeasionYearModel();
                $data = [     
         
            'name' => $this->request->getVar('name'),
            'type' => $this->request->getVar('type')
              
            ];
                if($model->where('id', $this->request->getVar('id'))->set($data)->update())
                {


                        
                    $session = \Config\Services::session();
                   $session->setFlashdata('data_up',1);
                    return redirect('view_SeasonSession_Year'); 

                   
                } 
            
    }

 public function del_SeasonSession_Year()   
    {  
       $session = \Config\Services::session();   
        $model = new SeasionYearModel();
        $model->where('id', $this->request->getVar('id'))->delete();
        $session->setFlashdata('data_delete',1); 
        return redirect('view_SeasonSession_Year');        
    }











  }