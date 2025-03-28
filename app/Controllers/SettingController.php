<?php

namespace App\Controllers; 
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\ClassModel;  
use App\Models\DepartmentModel;
use App\Models\DesignationModel;  
use App\Models\ActivityModel;
use CodeIgniter\Controller;  




class SettingController extends BaseController 
{

    private $db;
    public function __construct()
    {
      $this->db = db_connect(); // Loading database
    } 

    public function index()  
      {   
        $model = new StateModel();
        $data['dax'] = $model->orderBy('state_name', 'asc')->findAll();       
        return view('state',$data);
      } 
        

      public function store_state()  
    {   
         $validation =  \Config\Services::validation(); 

          $validation->setRules([ 
                'state_name' => 'required|string',
                'state_abbrevation' => 'required|string'                  
            ],
            [   
             'state_name' =>['required'=>'State Name Field is Required.'],
             'state_abbrevation' =>['required'=>'State Abbrevation Field is Required.']
  
            ]);

          if(!$validation->withRequest($this->request)->run()) {    
               
                $errormsg['error']=$validation->getErrors();
                 $this->index();
                return view('state',$errormsg);  

            } else { 

            $data = [  
            'country_id' => $this->request->getVar('country'),   
            'state_name' => $this->request->getVar('state_name'),
            'state_abbrevation'  => $this->request->getVar('state_abbrevation')
            ];

              $model = new StateModel();
                if($model->insert($data)){
                    $session = \Config\Services::session();
                    $session->setFlashdata('state_ok',1);
                    $this->index(); 
                    return redirect('state');    
                }
        }
    }

          public function update_state()  
        {   
         
            $id = $this->request->getVar('id');
            $data = [  
            'country_id' => $this->request->getVar('country'),              
            'state_name' => $this->request->getVar('state_name'),
            'state_abbrevation'  => $this->request->getVar('state_abbrevation')
            ];

              $model = new StateModel();
                if($model->where('id', $id)->set($data)->update()){
                    $session = \Config\Services::session();
                    $session->setFlashdata('state_up',1);
                    $this->index(); 
                    return redirect('state');    
                }
        
          }
  
        public function delete_state()   
        {      
        $model = new StateModel(); 
        $model->where('id', $this->request->getVar('id'))->delete();
        return redirect('state');       
        }



    
    public function city()  
    {   
        $model = new StateModel();
        $data['dax'] = $model->orderBy('state_name', 'asc')->findAll(); 

        $data['dax1'] = $this->db->query("select asitek_city.*, asitek_state.state_name from asitek_city, asitek_state where asitek_state.id = asitek_city.state_id ORDER BY asitek_state.state_name, asitek_city.city_name")->getResultArray();

        return view('city',$data);  
    }

          
 public function store_city()  
    {   
         $validation =  \Config\Services::validation(); 

          $validation->setRules([ 
                'state_id' => 'required',
                'city_name' => 'required|string'                  
            ],
            [   
             'state_id' =>['required'=>'State Name Field is Required.'],
             'city_name' =>['required'=>'City Name Field is Required.']
  
            ]);

          if(!$validation->withRequest($this->request)->run()) {    
               
                $errormsg['error']=$validation->getErrors();
                 $this->city();
                return view('city',$errormsg);  

            } else { 

            $data = [     
            'state_id' => $this->request->getVar('state_id'),
            'city_name'  => $this->request->getVar('city_name')
            ];

              $model = new CityModel();
                if($model->insert($data)){
                    $session = \Config\Services::session();
                    $session->setFlashdata('city_ok',1);
                    $this->city(); 
                    return redirect('city');    
                }
        }
    }

          public function update_city()  
        {   
         
            $id = $this->request->getVar('id');
            $data = [               
            'state_id' => $this->request->getVar('state_id'),
            'city_name'  => $this->request->getVar('city_name')
            ];

              $model = new CityModel();
                if($model->where('id', $id)->set($data)->update()){
                    $session = \Config\Services::session();
                    $session->setFlashdata('city_up',1);
                    $this->city(); 
                    return redirect('city');    
                }
        
          }
  
        public function delete_city()   
        {      
        $model = new CityModel(); 
        $model->where('id', $this->request->getVar('id'))->delete();
        return redirect('city');       
        }

public function class()  
    {   
        $model = new ClassModel();
        $data['dax'] = $model->findAll(); 

       return view('class',$data);  
    }

          
 public function store_class()  
    {   
         $validation =  \Config\Services::validation(); 

          $validation->setRules([ 
                'class_name' => 'required'                  
            ],
            [   
             'class_name' =>['required'=>'Class Name Field is Required.']
  
            ]);

          if(!$validation->withRequest($this->request)->run()) {    
               
                $errormsg['error']=$validation->getErrors();
                 $this->class();
                return view('class',$errormsg);  

            } else { 

            $data = [     
            'class_name' => $this->request->getVar('class_name'),
            'class_abbrevation'  => $this->request->getVar('class_abbrevation')
            ];

              $model = new ClassModel();
                if($model->insert($data)){
                    $session = \Config\Services::session();
                    $session->setFlashdata('class_ok',1);
                    $this->class(); 
                    return redirect('class');    
                }
        }
    }

          public function update_class()  
        {   
         
            $id = $this->request->getVar('id');
            $data = [               
            'class_name' => $this->request->getVar('class_name'),
            'class_abbrevation'  => $this->request->getVar('class_abbrevation')
            ];

              $model = new ClassModel();
                if($model->where('id', $id)->set($data)->update()){
                    $session = \Config\Services::session();
                    $session->setFlashdata('class_up',1);
                    $this->class(); 
                    return redirect('class');    
                }
        
          }
  
        public function delete_class()   
        {      
        $model = new ClassModel(); 
        $model->where('id', $this->request->getVar('id'))->delete();
        return redirect('class');       
        }

      public function department()  
    {   
        $model = new DepartmentModel();
        $data['dax'] = $model->findAll(); 

       return view('department',$data);  
    }

          
 public function store_department()  
    {   
         $validation =  \Config\Services::validation(); 

          $validation->setRules([ 
                'department_name' => 'required'                  
            ],
            [   
             'department_name' =>['required'=>'Department Name Field is Required.']
  
            ]);

          if(!$validation->withRequest($this->request)->run()) {    
               
                $errormsg['error']=$validation->getErrors();
                 $this->department();
                return view('department',$errormsg);  

            } else { 

            $data = [     
            'department_name' => $this->request->getVar('department_name')
            ];

              $model = new DepartmentModel();
                if($model->insert($data)){
                    $session = \Config\Services::session();
                    $session->setFlashdata('department_ok',1);
                    $this->department(); 
                    return redirect('department');    
                }
        }
    }

          public function update_department()  
        {   
         
            $id = $this->request->getVar('id');
            $data = [               
            'department_name' => $this->request->getVar('department_name')
            ];

              $model = new DepartmentModel();
                if($model->where('id', $id)->set($data)->update()){
                    $session = \Config\Services::session();
                    $session->setFlashdata('department_up',1);
                    $this->department(); 
                    return redirect('department');    
                }
        
          }
  
        public function delete_department()   
        {      
        $model = new DepartmentModel(); 
        $model->where('id', $this->request->getVar('id'))->delete();
        return redirect('department');       
        }
  
    public function designation()  
    {   
        $model = new DesignationModel();
        $data['dax'] = $model->findAll(); 

       return view('designation',$data);  
    }

          
 public function store_designation()  
    {   
         $validation =  \Config\Services::validation(); 

          $validation->setRules([ 
                'designation_name' => 'required'                  
            ],
            [   
             'designation_name' =>['required'=>'Designation Name Field is Required.']
  
            ]);

          if(!$validation->withRequest($this->request)->run()) {    
               
                $errormsg['error']=$validation->getErrors();
                 $this->designation();
                return view('designation',$errormsg);  

            } else { 

            $data = [     
            'designation_name' => $this->request->getVar('designation_name')
            ];

              $model = new DesignationModel();
                if($model->insert($data)){
                    $session = \Config\Services::session();
                    $session->setFlashdata('designation_ok',1);
                    $this->designation(); 
                    return redirect('designation');    
                }
        }
    }

          public function update_designation()  
        {   
         
            $id = $this->request->getVar('id');
            $data = [               
            'designation_name' => $this->request->getVar('designation_name')
            ];

              $model = new DesignationModel();
                if($model->where('id', $id)->set($data)->update()){
                    $session = \Config\Services::session();
                    $session->setFlashdata('designation_up',1);
                    $this->designation(); 
                    return redirect('designation');    
                }
        
          }
  
        public function delete_designation()   
        {      
        $model = new DesignationModel(); 
        $model->where('id', $this->request->getVar('id'))->delete();
        return redirect('designation');       
        }
 


}
