<?php

namespace App\Controllers;
use App\Models\UserModel;  
use App\Models\EmployeeModel;
use App\Models\StateModel; 
use App\Models\RollModel;
use App\Models\CityModel;
use App\Models\ClassModel;      
use App\Models\DepartmentModel;   
use App\Models\DesignationModel; 
use App\Models\ChildModel; 
use App\Models\ChildExpenseModel;
use App\Models\BudgetHeadModel;   
use App\Models\ChildFeeHeadModel;
use App\Models\AttendanceModel;
use App\Models\ProjectModel; 
use App\Models\ExtraExpenseModel;
use App\Models\ChildProgress;
use App\Models\Lead_consultant_hod_mapper; 
use App\Models\asitek_lead_hod_mapper_model; 
use App\Models\LocationModel; 
use App\Models\LeadlocationModel;
use App\Models\RequestModel; 
use App\Models\EEBudgetModel; 
use App\Models\OEBudgetModel;  
use App\Models\PaymentVoucherModel; 
use App\Models\BaselineModel; 
use App\Models\MisReportModel;
use App\Models\UnitModel;  
use App\Models\CompenyModel; 
use CodeIgniter\Controller; 

class EmployeeController extends BaseController     
{  
  
    private $db; 
    public function __construct()
    {
        $this->db = db_connect(); // Loading database
    } 

    public function Userupdate_pass()
    {
        $daga = [ 
            'password'  => md5(trim($this->request->getVar('new_pass')))
        ];
        $emp_id = $this->request->getVar('id');  
        $modelup = new UserModel();
        if($modelup->where('emp_id', $emp_id)->set($daga)->update()){
            $session = \Config\Services::session();
            $session->setFlashdata('pass_up',1);
            return redirect('user_details');   
        }  
    }

    
    public function index()      
    {
        $session = \Config\Services::session(); 
        $result = $session->get();
        $compeny_id = $session->get("compeny_id");
        $model = new StateModel();  
        $data['dax']=$model->findAll(); 
        $model1 = new CityModel();  
        $data['dax1']=$model1->findAll();
        $model3 = new ClassModel();            
        $data['dax3']=$model3->findAll(); 
        $model8 = new RollModel();  
        $data['dax8']=$model8->findAll(); 
        $model9= new DepartmentModel();  
        $data['dax9']=$model9->where('compeny_id', $compeny_id)->findAll(); 
        $model14= new CompenyModel();  
        $data['dax14']=$model14->findAll();
        $model15 = new UnitModel();  
        $data['dax15']=$model15->where('compeny_id', $compeny_id)->findAll(); 
        return view('add-user',$data);  
    }
 

    public function getcity()       
    {
      if($this->request->getVar('action'))
      {
        $action = $this->request->getVar('action');
        if($action == 'get_city')                           
        {
          $cityModel = new CityModel();
          $citydata = $cityModel->where('state_id', $this->request->getVar('state_id'))->findAll();
          echo json_encode($citydata);
        }
      }
    }                                 

      public function getsamecity()       
    {
      if($this->request->getVar('action'))
      {
        $action = $this->request->getVar('action');  
        if($action == 'get_city')                           
        {
          $cityModel = new CityModel();
          $citydata = $cityModel->where('id', $this->request->getVar('city_id'))->findAll();
          echo json_encode($citydata);
        }
      }
    }

    public function store_employee()      
    {
        $validation =  \Config\Services::validation(); 
        $validation->setRules([ 
            'F_Name' => 'required|string',
            'Gender' => 'required',
            'Email_id' => 'required|valid_email|is_unique[asitek_employee.email]',
            'Mobile' => 'required|numeric|is_unique[asitek_employee.mobile]',
            'E_Password' => 'required',
            'role' => 'required',
            ],
            [   
                'F_Name' =>['required'=>'First Name Field is Required.'],
                'Gender' =>['required'=>'Gender Field is Required.'],
                'Email_id' =>[
                    'required'=>'Email Field is Required.',
                    'valid_email'=>'Please Enter Valid Email ID.',
                    'is_unique'=>'This Email is Already Exists, Please Take Another Email.'
                ],
                'Mobile' =>[
                    'required'=>'Mobile Field is Required.',
                    'numeric'=>'Mobile Number Must be Numeric Value.',
                    'is_unique'=>'This Mobile Number is Already Exists, Please Take Another Mobile Number.'
                ],
                'E_Password' =>['required'=>'Password Field is Required.'],
                'role' =>['required'=>'Role Field is Required.'],
            ]
        );   
        if(!$validation->withRequest($this->request)->run()) {    
            $errormsg['error']=$validation->getErrors();
            $this->index();  
            return view('add-user',$errormsg);   
        } 
        else {  
            $file = $this->request->getFile('E_Image'); 
            if ($file!="") 
            {
                $validation->setRules([
                    'E_Image' => 'uploaded[E_Image]|max_size[E_Image,416]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG]|max_dims[E_Image,1366,768]',
                ]);
                if(!$validation->withRequest($this->request)->run()) {    
                    $data['error']=$validation->getErrors();
                    $this->index(); 
                    return view('add-user',$data);
                }
                else{ 
                    $imageName = $file->getRandomName();
                    $file->move('public/vendors/PicUpload',$imageName);
                }
            }else{
                $imageName ="";
            }                                                                        
            $newdate = date('Y-m-d',strtotime($this->request->getVar('dob')));
            $data = [     
                'compeny_id' => $this->request->getVar('compeny_id'),  
                'unit_id' => $this->request->getVar('unit_id'),
                'first_name'  => $this->request->getVar('F_Name'), 
                'last_name' => $this->request->getVar('L_Name'),
                'gender'  => $this->request->getVar('Gender'),
                'email'  => $this->request->getVar('Email_id'),
                'mobile' => $this->request->getVar('Mobile'),
                'office_shift' => 'NA',
                'role'  => $this->request->getVar('role'),
                'department'  => $this->request->getVar('department'),
                'emp_image'  => $imageName
            ];
            $emp = new EmployeeModel();
            $empinsert = $emp->insert($data);      
            $user_id = $emp->getInsertID(); 
            $string2='HTSJJ';
            $Emp_id_no2=$string2.$user_id;
            if($empinsert){
                $daga = [ 
                    'compeny_id' => $this->request->getVar('compeny_id'),  
                    'emp_id' => $user_id,     
                    'emp_u_id' => $Emp_id_no2,
                    'email'  => $this->request->getVar('Email_id'),
                    'password' => md5($this->request->getVar('E_Password')),
                    'role'  => $this->request->getVar('role')
                ];
                $user = new UserModel();
                $uinsert = $user->insert($daga);  
                if($uinsert){
                    $emp2 = new EmployeeModel();
                    $emp2->where('id', $user_id)->set('emp_u_id',$Emp_id_no2)->update();
                    $session = \Config\Services::session();
                    $session->setFlashdata('emp_ok',1);
                    return redirect('add-user'); 
                }
            }
        }
    }   




    public function update_employee()      
    {
        $file = $this->request->getFile('E_Image'); 
        if ($file->isValid() && !$file->hasMoved() && $file !="") 
        {
            $imageName = $file->getRandomName();
            $file->move('public/vendors/PicUpload',$imageName); //PicUpload -->where image will stored
        }else{
            $imageName =$this->request->getVar('db_image');
        }
        $data = [ 
            'first_name'  => $this->request->getVar('F_Name'), 
            'last_name' => $this->request->getVar('L_Name'),
            'emp_image'  => $imageName,
            'gender'  => $this->request->getVar('Gender'),
            'email'  => $this->request->getVar('Email_id'),
            'mobile' => $this->request->getVar('Mobile'),
            'role' => $this->request->getVar('role'),
            'unit_id' => $this->request->getVar('unit_id'),  
            'department'  => $this->request->getVar('department'),
            'emp_u_id' => $this->request->getVar('Emp_id_no')
        ];
          
        $daga = [ 
            'email'  => $this->request->getVar('Email_id'),
            'role' => $this->request->getVar('role')
        ];
        $emp = new EmployeeModel();
        if($emp->where('id', $this->request->getVar('id'))->set($data)->update())
        {
            $user = new UserModel();
            if($user->where('emp_id', $this->request->getVar('id'))->set($daga)->update()){
                $session = \Config\Services::session();
                $session->setFlashdata('emp_up',1);
                return redirect('user_details'); 
            }
        } 
    }   


     


    public function user_details()  
    {   

         $session = \Config\Services::session(); 
        $result = $session->get();    
      // $location_tracker = $result['location_tracker'];
        $etm = $result['edn'];
        $compeny_id = $session->get("compeny_id"); 

        $Roll_id = $result['Roll_id'];
         if($Roll_id==0)
         {
           $data['dax'] = $this->db->query("select asitek_employee.*, asitek_user.active, asitek_state.state_name, asitek_city.city_name, asitek_class.class_name, asitek_roll.Name from asitek_employee LEFT JOIN asitek_state on asitek_employee.current_state = asitek_state.id LEFT JOIN asitek_city on asitek_employee.current_city = asitek_city.id LEFT JOIN asitek_class on asitek_employee.qualification = asitek_class.id LEFT JOIN asitek_state as sate on asitek_employee.permanent_state = sate.id LEFT JOIN asitek_city as cit on asitek_employee.permanent_city =cit.id LEFT JOIN asitek_user on asitek_employee.id=asitek_user.emp_id  LEFT JOIN asitek_roll on asitek_user.role=asitek_roll.Roll_Id where asitek_employee.role='1' ORDER BY asitek_employee.id desc limit 10 offset ".$etm)->getResultArray();  
              }
              else
              {
                 $data['dax'] = $this->db->query("select asitek_employee.*, asitek_user.active, asitek_state.state_name, asitek_city.city_name, asitek_class.class_name, asitek_roll.Name from asitek_employee LEFT JOIN asitek_state on asitek_employee.current_state = asitek_state.id LEFT JOIN asitek_city on asitek_employee.current_city = asitek_city.id LEFT JOIN asitek_class on asitek_employee.qualification = asitek_class.id LEFT JOIN asitek_state as sate on asitek_employee.permanent_state = sate.id LEFT JOIN asitek_city as cit on asitek_employee.permanent_city =cit.id LEFT JOIN asitek_user on asitek_employee.id=asitek_user.emp_id  LEFT JOIN asitek_roll on asitek_user.role=asitek_roll.Roll_Id where asitek_employee.compeny_id='$compeny_id' ORDER BY asitek_employee.id desc limit 10 offset ".$etm)->getResultArray(); 
              }          

          $model6 = new StateModel();  
          $data['dax6']=$model6->findAll();       

          $model1 = new CityModel();  
          $data['dax1']=$model1->findAll();
 
         $model3 = new ClassModel();            
         $data['dax3']=$model3->findAll();   

         $model9= new DepartmentModel();  
         $data['dax9']=$model9->where('compeny_id', $compeny_id)->findAll(); 

         $model10 = new RollModel();                  
         $data['dax10']=$model10->findAll(); 

         $model11 = new UnitModel();  
          $data['dax11']=$model11->where('compeny_id', $compeny_id)->findAll();       
          
        return view('user_details',$data);   


    }  

    


     public function set_allotes_child()   
    {  
        $session = \Config\Services::session(); 
        $child_id = $this->request->getVar('child_id');

        foreach($child_id as $index)
         {
       $builder = $this->db->table('asitek_child');  
        $builder->where('id', $index);
         $builder->set('alloted_employee', $this->request->getVar('emp_id'));
        $query = $builder->update();
        }
         
         $session->setFlashdata('allot_stu_ok',1);
        return redirect('emp_details');   
             
    }


     public function lock_emp()   
    {    
        $session = \Config\Services::session();  

         $daga = [ 
        'active'  => '0'
            ];

         $user = new UserModel();
        if($user->where('emp_id', $this->request->getVar('id'))->set($daga)->update()){  
        $session->setFlashdata('lock_emp',1);   
        return redirect('user_details');  
        }     
    }

     public function un_lock_emp()   
    {    
        $session = \Config\Services::session();  

         $daga = [ 
        'active'  => 1
            ];

         $user = new UserModel();
        if($user->where('emp_id', $this->request->getVar('id'))->set($daga)->update()){  
        $session->setFlashdata('unlock_emp',1);   
        return redirect('user_details');  
        }     
    }
           

                       

    public function employee_delete()   
    {  
       $session = \Config\Services::session();   
       $modex = new UserModel();
       $dax = $modex->where('emp_id', $this->request->getVar('id'))->first(); 

       if($dax['active']==0){
        $model = new EmployeeModel(); 
        $model->where('id', $this->request->getVar('id'))->delete();
        $session->setFlashdata('emp_delete',1); 
        }else{
          $session->setFlashdata('emp_delete',0);    
        }

        return redirect('user_details');        
    }

       public function profile($id)          
    {      
         $data['kat'] = $this->db->query("select asitek_employee.*, asitek_state.state_name, asitek_city.city_name, asitek_class.class_name, asitek_designation.designation_name, asitek_department.department_name from asitek_employee LEFT JOIN asitek_state on asitek_employee.current_state = asitek_state.id LEFT JOIN asitek_city on asitek_employee.current_city = asitek_city.id LEFT JOIN asitek_class on asitek_employee.qualification = asitek_class.id LEFT JOIN asitek_designation on asitek_employee.designation = asitek_designation.id LEFT JOIN asitek_department on asitek_employee.department = asitek_department.id LEFT JOIN asitek_state as sate on asitek_employee.permanent_state = sate.id LEFT JOIN asitek_city as cit on asitek_employee.permanent_city = cit.id where asitek_employee.id='$id'")->getResultArray();

         $data_mapper = $this->db->query("SELECT `lead_id`, `consultant_id`, `hod_id`, `created_at` FROM `asitek_lead_consultant_hod_mapper` WHERE consultant_id='$id'")->getResultArray();
         foreach ($data_mapper as $key => $value) {
             $lead_id =$value['lead_id'];
         }
         if(isset($lead_id)){
         $data['lead'] = $this->db->query("select asitek_employee.*  from asitek_employee  LEFT JOIN asitek_lead_consultant_hod_mapper as asitek_lead_consultant_hod_mapper on asitek_employee.id = asitek_lead_consultant_hod_mapper.lead_id where asitek_employee.id='$lead_id'")->getResultArray();
         }


            $model6 = new StateModel();  
          $data['dax6']=$model6->findAll();       

          $model1 = new CityModel();  
          $data['dax1']=$model1->findAll();
 
         $model3 = new ClassModel();            
         $data['dax3']=$model3->findAll();  

         $model4 = new DepartmentModel();                  
         $data['dax4']=$model4->findAll(); 

         $model5 = new DesignationModel();                  
         $data['dax5']=$model5->findAll(); 

         $model8 = new ChildModel();                  
         $data['dax8']=$model8->findAll(); 

        return view('profile',$data);
    }

      public function update_profile()      
    {
        $session = \Config\Services::session();
        $validation =  \Config\Services::validation();
        $id = $this->request->getVar('id');
        $file = $this->request->getFile('E_Image'); 
        if ($file!="") 
        {
        $validation->setRules([
                'E_Image' => 'uploaded[E_Image]|max_size[E_Image,416]|ext_in[E_Image,jpg,JPG,png,PNG,jpeg,JPEG]|max_dims[E_Image,1707,901]',
            ],   
            [                                                                        
             
             'E_Image' =>['uploaded'=>'This Field is Required.','max_size'=>'Only File Type Should be Image and Size Should be less than or equal to 415 KB.','ext_in'=>'Only Image Type JPG,PNG or JPEG Required.','max_dims'=>'Image Dimension 1707*901 Required'],
            ]);
        if(!$validation->withRequest($this->request)->run()) {    
               
            $data['error']=$validation->getErrors();
                  $this->index(); 
            $data['kat'] = $this->db->query("select asitek_employee.*, asitek_state.state_name, asitek_city.city_name, asitek_class.class_name, asitek_designation.designation_name, asitek_department.department_name from asitek_employee LEFT JOIN asitek_state on asitek_employee.current_state = asitek_state.id LEFT JOIN asitek_city on asitek_employee.current_city = asitek_city.id LEFT JOIN asitek_class on asitek_employee.qualification = asitek_class.id LEFT JOIN asitek_designation on asitek_employee.designation = asitek_designation.id LEFT JOIN asitek_department on asitek_employee.department = asitek_department.id LEFT JOIN asitek_state as sate on asitek_employee.permanent_state = sate.id LEFT JOIN asitek_city as cit on asitek_employee.permanent_city = cit.id where asitek_employee.id='$id'")->getResultArray();
             $model6 = new StateModel();  
             $data['dax6']=$model6->findAll(); 
             $model1 = new CityModel();  
             $data['dax1']=$model1->findAll();
             $model3 = new ClassModel();            
             $data['dax3']=$model3->findAll(); 
             $model4 = new DepartmentModel();                  
             $data['dax4']=$model4->findAll(); 
             $model5 = new DesignationModel();                  
             $data['dax5']=$model5->findAll();
             $model8 = new ChildModel();                  
             $data['dax8']=$model8->findAll(); 
               return view('profile',$data);
        }else{  
            $imageName = $file->getRandomName();
            $file->move('public/vendors/PicUpload',$imageName);
            }}else{
            $imageName =$this->request->getVar('db_image');
            }

            $newdate = date('Y-m-d',strtotime($this->request->getVar('dob')));
  
            $data = [     
            'emp_u_id' => $this->request->getVar('Emp_id_no'),
            'first_name'  => $this->request->getVar('F_Name'), 
            'last_name' => $this->request->getVar('L_Name'),
            'dob' => $newdate, 
            'gender'  => $this->request->getVar('Gender'),
            'blood_group' => $this->request->getVar('blood_group'),
            'email'  => $this->request->getVar('Email_id'),
            'mobile' => $this->request->getVar('Mobile'),
            'current_address'  => $this->request->getVar('Address'),
            'current_state' => $this->request->getVar('C_State'),
            'current_city'  => $this->request->getVar('C_City'),
            'current_pincode' => $this->request->getVar('C_Pincode'),
            'permanent_address'  => $this->request->getVar('PAddress'),
            'permanent_state' => $this->request->getVar('PState'),
            'permanent_city'  => $this->request->getVar('PCity'),
            'permanent_pincode' => $this->request->getVar('PPincode'),
            'aadhar_no'  => $this->request->getVar('A_Number'),
            'qualification'  => $this->request->getVar('qualification'),
            'technical_education'  => $this->request->getVar('technical_education'), 
            'role'  => $this->request->getVar('role'), 
            'department'  => $this->request->getVar('department'), 
            'emp_image'  => $imageName
            ];     
          
        $daga = [ 
        'email'  => $this->request->getVar('Email_id'),
        'role' => $this->request->getVar('role')   
            ];

                $emp = new EmployeeModel();
               
                if($emp->where('id', $this->request->getVar('id'))->set($data)->update())
                {

                $user = new UserModel();

                if($user->where('emp_id', $this->request->getVar('id'))->set($daga)->update()){
                    $session = \Config\Services::session();
                    $session->setFlashdata('pro_up',1);
                      $this->profile($this->request->getVar('id'));  
                     return view('profile');    

                    }
                }
            
    } 

    public function change_password()
    {
        return view('change_password');
    }

    public function check_old_pass()
    {
        $pass = md5(trim($this->request->getVar('oldpass')));
        $emp_id = $this->request->getVar('emp_id');
        $model = new UserModel();
        $dd = $model->where(['password'=>$pass,'emp_id'=>$emp_id])->first();
        if(isset($dd)){ 
            echo 1; 
        }else{
            echo 0;
        }    
    }

    public function update_pass()
    {
        $daga = [ 
            'password'  => md5(trim($this->request->getVar('new_pass')))
        ];
        $emp_id = $this->request->getVar('id');  
        $modelup = new UserModel();
        if($modelup->where('emp_id', $emp_id)->set($daga)->update()){
            $session = \Config\Services::session();
            $session->setFlashdata('pass_up',1);
            return redirect('change-password');   
        }  
    }


public function role_emp_mng(){

$session = \Config\Services::session();
  $umodel = new  UserModel();  
$epmodel = new EmployeeModel();

$emp_id = $this->request->getVar('id');
$up_role = $this->request->getVar('up_role');

    if($epmodel->where('id',$emp_id)->set(['role'=>$up_role])->update())
    {
        if($umodel->where('emp_id',$emp_id)->set(['role'=>$up_role])->update())
            {
                $session->setFlashdata('uprollm',1);
                return redirect('user_details'); 
            }else{
                $session->setFlashdata('uprollm',0); 
                return redirect('user_details'); 
            }
    }



}


public function role_ttx(){

$session = \Config\Services::session();  
  $umodel = new  UserModel();  
$epmodel = new EmployeeModel();

$emp_id = $this->request->getVar('id');
$up_role = $this->request->getVar('up_role');

    if($epmodel->where('id',$emp_id)->set(['role'=>$up_role])->update())
    {
        if($umodel->where('emp_id',$emp_id)->set(['role'=>$up_role])->update())
            {
                $session->setFlashdata('uprollm',1);
                return redirect('emp_details'); 
            }else{
                $session->setFlashdata('uprollm',0); 
                return redirect('consultant-section'); 
            }
    }


}






    public function user_bank_details()  
    {   
        $session = \Config\Services::session(); 
        $result = $session->get();    
        $emp_id = $session->get("emp_id");
        
        $compeny_id = $session->get("compeny_id"); 
        $data['dax'] = $this->db->query("select * from asitek_employee WHERE id=$emp_id")->getResultArray();  
          
        return view('update-bank-details',$data);   


    }  


    public function update_bankdetails()      
    {
        
        $data = [ 
            'bank_name' => $this->request->getVar('Bank_Name'),        
            'Acnt_No' => $this->request->getVar('accountno'),
            'Ifsc_Code'  => $this->request->getVar('ifsc'), 
            'Bank_Branch' => $this->request->getVar('Branch_Name'),
            'Acnt_Holder_Name'  => $this->request->getVar('accountholdername'),
            
        ];
          
        
        $emp = new EmployeeModel();
        if($emp->where('id', $this->request->getVar('empid'))->set($data)->update())
        {
            return redirect('update-bank-details'); 
        } 
    }  

    public function getstatewisecity()       
    {
      if($this->request->getVar('action'))
      {
        $action = $this->request->getVar('action');
        if($action == 'get_city')                           
        {
          $state_id = $this->request->getVar('state_id');
            $citydata = $this->db->query("SELECT asitek_city.*, asitek_state.state_name FROM asitek_city LEFT JOIN asitek_state ON asitek_city.state_id = asitek_state.id WHERE asitek_city.state_id='$state_id'")->getResultArray();

          echo json_encode($citydata);
        }
      }
    } 

//=================End Point     
}
