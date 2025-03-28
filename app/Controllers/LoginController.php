<?php
namespace App\Controllers;  
use App\Models\UserModel; 
use App\Models\RollModel;
use App\Models\EmployeeModel;
use App\Models\AttendanceModel;   
use App\Models\PartyUserModel;  
use App\Models\CompenyModel;
use App\Models\LoginactivityModel;
use App\Models\VendorloginModel;
use CodeIgniter\Controller;      

class LoginController extends BaseController    
{  
//--------------------------------------------------------------------------
    private $db; 
    public function __construct()
    {
      $this->db = db_connect(); // Loading database
    }   

    public function index()   
    {  
        $session = \Config\Services::session();
        $result = $session->get();
        if ($session->has("emp_id")) {
            $Roll_id = $result["Roll_id"];
            if($Roll_id!='Vendor')
            {
                return redirect('main-dashboard');  
            }
            else
            {
                return view('login');    
            } 
        } else {
            return view('login');   
        }
    } 

    public function vendor_login()   
    {  
        $session = \Config\Services::session();
        $result = $session->get();
        if ($session->has("emp_id")) {
            $Roll_id = $result["Roll_id"];
            if($Roll_id=='Vendor')
            {
                return redirect('vendor-dashboard');     
            }
            else
            {
                return view('vendor_login');   
            }
        } else {
            return view('vendor_login');
        }
    }

    public function DirectUserLogin()  
    {    
        $session = \Config\Services::session();
        $tdate = date('Y-m-d H:i:s');
        $model =new UserModel();
        $result = $model->where(['email'=>$this->request->getVar('email'),'active'=>1,'role !='=>"Vendor"])->first();  
        if(isset($result) && $result!='')
        {
            $modelx =new EmployeeModel();  
            $daga = $modelx->where('email',$this->request->getVar('email'))->first();
            $bylogin_email=$this->request->getVar('bylogin_email');
            if(isset($daga['email'])){
                $Rollrow=new RollModel();
                $Rolldaga = $Rollrow->where('Roll_Id',$result['role'])->first();
                if(isset($Rolldaga) && $Rolldaga!='')
                {
                    $RollName=$Rolldaga['Name'];
                    $compeny_id=$result['compeny_id'];
                    $comapny= new CompenyModel();  
                    $companyn=$comapny->where('id', $compeny_id)->first();
                    $companyname = $companyn['name'];
                }
                else
                {
                    $RollName="Super Admin"; 
                    $compeny_id=0;
                    $companyname='BD EnterPrises';
                }
                $name = $daga['first_name'].' '.$daga['last_name'];
                $session->set(["emp_id" => $result['emp_id'],"name" => $name, "email" => $result['email'], "contact" => $daga['mobile'], "Role" => $RollName,"Roll_id" => $result['role'], "super" => $daga['super'], "project_id" => $daga['project_id'], "teamleader" => $daga['team_leader'], "location_tracker" => $daga['location_id'], "isLoggedIn" => 1, "bylogin_email" => $bylogin_email, "compeny_id" =>$compeny_id, "compeny_name" =>$companyname]);
                $session->set(["pdn"=>0,"cdn"=>0,"edn"=>0,"ndn"=>0,"ddn"=>0,"pdv"=>0,"bbs"=>0,"mbs"=>0,"dxd"=>0,"pagelist_mapping"=>0,"pagelist_clearbill"=>0,"pagelist_erpStystem"=>0,"pagelist_recived_bil"=>0,"pagelist_vendor"=>0]);
                if($result['role'] == 1||$result['role'] == 2||$result['role'] == 3||$result['role'] == 4||$result['role'] == 5||$result['role'] == 6||$result['role'] == 0)     
                {  
                    $datalogin = [     
                        'Company_Id' => $compeny_id,  
                        'User_Id' => $result['emp_id'],
                        'Login_Time'  => $tdate, 
                        'Emp_Role'  => $result['role'],
                        'Login_By_Admin'  => 1
                        
                    ];
                    $activitymodel =new LoginactivityModel(); 
                    $amdlinst = $activitymodel->insert($datalogin); 
                    $last_id = $activitymodel->getInsertID();
                    $session->set(["last_id" => $last_id,"login_time"=>date("H:i:s")]);
                    return redirect('main-dashboard');     
                }
            }
            else{
                $session->setFlashdata('auth_ok',0);
                return redirect('/user_details');  
            } 
        }
        else{
            $session->setFlashdata('active_deactive',1);
            return redirect('user_details');      
        }    
    } 

    public function CheckLog()  
    {    
        $session = \Config\Services::session();
        $tdate = date('Y-m-d H:i:s');
        $model =new UserModel();  
        $result = $model->where(['email'=>$this->request->getVar('email'),'active'=>1,'role !='=>"Vendor"])->first();  
        $modelx =new EmployeeModel();  
        $daga = $modelx->where('email',$this->request->getVar('email'))->first();
        $inputpass = md5($this->request->getVar('password'));   
        if(isset($result['password']) && $result['password'] == $inputpass)   
        {  
            if(isset($daga['email'])){
                $Rollrow=new RollModel();
                $Rolldaga = $Rollrow->where('Roll_Id',$result['role'])->first();
                if(isset($Rolldaga) && $Rolldaga!='')
                {
                    $RollName=$Rolldaga['Name'];
                    $compeny_id=$result['compeny_id'];
                    $comapny= new CompenyModel();  
                    $companyn=$comapny->where('id', $compeny_id)->first();
                    $companyname = $companyn['name'];
                }
                else
                {
                    $RollName="Super Admin"; 
                    $compeny_id=0;
                    $companyname='BD EnterPrises';
                }
                $name = $daga['first_name'].' '.$daga['last_name'];
                $session->set(["emp_id" => $result['emp_id'],"name" => $name, "email" => $result['email'], "contact" => $daga['mobile'], "Role" =>$RollName,"Roll_id" => $result['role'], "super" => $daga['super'], "project_id" => $daga['project_id'], "teamleader" => $daga['team_leader'], "location_tracker" => $daga['location_id'], "isLoggedIn" => 1, "compeny_id" =>$compeny_id, "compeny_name" =>$companyname]);
                $session->set(["pdn"=>0,"cdn"=>0,"edn"=>0,"ndn"=>0,"ddn"=>0,"pdv"=>0,"bbs"=>0,"mbs"=>0,"dxd"=>0,"pagelist_mapping"=>0,"pagelist_clearbill"=>0,"pagelist_erpStystem"=>0,"pagelist_recived_bil"=>0,"pagelist_vendor"=>0]);
                if($result['role'] == 1||$result['role'] == 2||$result['role'] == 3||$result['role'] == 4||$result['role'] == 5||$result['role'] == 6||$result['role'] == 0)     
                {  
                    $datalogin = [     
                        'Company_Id' => $compeny_id,  
                        'User_Id' => $result['emp_id'],
                        'Login_Time'  => $tdate, 
                        'Emp_Role'  => $result['role'],
                    ];
                    $activitymodel =new LoginactivityModel(); 
                    $amdlinst = $activitymodel->insert($datalogin); 
                    $last_id = $activitymodel->getInsertID();
                    $session->set(["last_id" => $last_id,"login_time"=>date("H:i:s")]); 
                    return redirect('main-dashboard');     
                }
            }
            else 
            {
                $session->setFlashdata('auth_ok',0);
                return redirect('/');     
            } 
        }else{
            $session->setFlashdata('auth_ok',0);
            return redirect('/');  
        } 
    } 



    public function Vendor_CheckLog()  
    {    
        $session = \Config\Services::session();
        $tdate = date('Y-m-d H:i:s');
        $PartyUserModelObj = new PartyUserModel();
        $result = $PartyUserModelObj->where(['GST_No'=>$this->request->getVar('GST_No')])->first();  
        $inputpass = md5($this->request->getVar('password'));   
        if(isset($result['password']) && $result['password'] == $inputpass)   
        {  
            $RollName=$result['role']; 
            $compeny_id=0;
            $name = $result['Name'];
            $session->set(["emp_id" => $result['id'], "name" => $name, "email" => $result['Email_Id'], "contact" => $result['Mobile_No'], "Role" =>$RollName, "Roll_id" => $result['role'], "gstin" => $result['GST_No'], "expirydate" => $result['Expiry_Date'], "active" => $result['Active'], "isLoggedIn" => 1]);
            $session->set(["pdn"=>0,"cdn"=>0,"edn"=>0,"ndn"=>0,"ddn"=>0,"pdv"=>0,"bbs"=>0,"mbs"=>0,"dxd"=>0]);
            if($result['role'] == "Vendor")     
            {  
                    $datalogin = [     
                        'User_Id' => $result['id'],
                        'Login_Time'  => $tdate, 
                    ];
                    $vmodel =new VendorloginModel(); 
                    $amdlinst = $vmodel->insert($datalogin); 
                    $last_id = $vmodel->getInsertID();
                    $session->set(["last_id" => $last_id,"login_time"=>date("H:i:s")]); 
                return redirect('vendor-dashboard');     
            }
        }else{
            $session->setFlashdata('auth_ok',0);
            return redirect('vendor_login');  
        } 
    } 
       
   //------Time Calculation function

    //------------------------------------ 

    public function logout()
    {   
        $session = \Config\Services::session(); 
        $result = $session->get();  
        $last_id = $result['last_id'];
        $emp_id = $session->get("emp_id");
        $compeny_id = $session->get("compeny_id"); 
        $role = $session->get("role"); 
        $tdate = date('Y-m-d H:i:s');
          
        $datalogin = [     
            'Logout_Time'  => $tdate, 
        ];
        $activitymodel =new LoginactivityModel(); 
        $amdlinst = $activitymodel->where('Id', $last_id)->set($datalogin)->update(); 
        $session = session();
        $session->destroy();
        return redirect('/');
    }
    
    public function vendorlogout()
    {   
        $session = \Config\Services::session(); 
        $result = $session->get();    
        $last_id = $result['last_id'];
        $tdate = date('Y-m-d H:i:s');
        $datalogin = [     
            'Logout_Time'  => $tdate, 
        ];
        $vmodel =new VendorloginModel(); 
        $amdlinst = $vmodel->where('Id', $last_id)->set($datalogin)->update(); 
        $session = session();
        $session->destroy();
        return redirect('vendor_login');
    }

    public function vendor_profile()   
    {  
        return view('vendor_profile');   
    } 
    public function vendor_profile_active()   
    {  
        return view('vendor_profile_active');   
    }
    public function profile()   
    {  
        return view('profile');   
    } 
    //--------------------------------------------------------------------------         
} 

?>