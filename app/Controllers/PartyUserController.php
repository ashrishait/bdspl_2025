<?php

namespace App\Controllers;
use App\Models\UserModel;  
use App\Models\EmployeeModel;
use App\Models\StateModel; 
use App\Models\GarmentTypeModel;
use App\Models\BuyerModel;
use App\Models\DesignerModel;
use App\Models\SeasionYearModel;
use App\Models\RollModel;
use App\Models\CityModel;
use App\Models\ClassModel;      
use App\Models\DepartmentModel;  
use App\Models\DesignationModel; 
use App\Models\ChildModel; 
use App\Models\ChildExpenseModel;
use App\Models\BudgetHeadModel;   
use App\Models\CreateStyleFabriModel;
use App\Models\CreateStyleAccasseriesModel; 
use App\Models\CreateStylemodel;  
use App\Models\BillTypeModel;
use App\Models\BillRegisterModel;
use App\Models\PartyUserModel;
use App\Models\ActivateModel;
use App\Models\OTPModel;
use CodeIgniter\Controller; 

class PartyUserController extends BaseController     
{  
  
    private $db; 
    public function __construct()
    {
        $this->db = db_connect(); // Loading database
    }

    public function VendorDetails_ajax()       
    {
        $session = \Config\Services::session(); 
        $result = $session->get();
        $compeny_id = $session->get("compeny_id"); 
        $GST_No=$this->request->getVar('GST_No');
        $PartyUserModelObj= new PartyUserModel();
        $PartyUserrow= $PartyUserModelObj->where('GST_No',$GST_No)->first();
        if(isset($PartyUserrow) && $PartyUserrow!='')
        {
           ?>
            <table class="table table-hover border">
                <thead>
                    <tr>
                       
                        <th>Name</th>
                        <th>Mobile_No</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $PartyUserrow['Name']; ?></td>
                        <td><?php echo $PartyUserrow['Mobile_No']; ?></td>
                    </tr>
                </tbody>
            </table>
            <span style="padding: 5px; color:red;"> Your GSTIN is already Registered, Please Contact to Admin. </span>
            <?php
        }
        else
        {
            ?>
            <span style="padding: 5px ;color:green;">GSTIN Not Registered. Continue..</span>
            <?php
        }
    }

    public function index()      
    {
        $model = new StateModel();  
        $data['dax']=$model->orderBy('state_name', 'ASC')->findAll(); 
        $model1 = new CityModel();  
        $data['dax1']=$model1->orderBy('city_name', 'ASC')->findAll();
        return view('add_party_user',$data);  
    }


    public function store_party_user()      
    {
        $validation =  \Config\Services::validation(); 
        $session = \Config\Services::session();
        $PartyUser = new PartyUserModel();
        $GST_No  = $this->request->getVar('GST_No');
        $row= $PartyUser->where('GST_No',$GST_No)->first(); 
        if(isset($row) && $row!='')
        {
            $session->setFlashdata('emp_ok',2);
            return redirect('add_party_user'); 
        }
        else
        {
            $data = [  
                'compeny_id'  => $this->request->getVar('compeny_id'),   
                'GST_No'  => $this->request->getVar('GST_No'), 
                'Name'  => $this->request->getVar('Name'), 
                'Mobile_No'  => $this->request->getVar('Mobile_No'), 
                'Email_Id' => $this->request->getVar('Email_Id'),
                'role'  => "Vendor", 
                'password' => md5($this->request->getVar('E_Password')),
                'current_address'  => $this->request->getVar('Address'),
                'current_state' => $this->request->getVar('C_State'),
                'current_city'  => $this->request->getVar('C_City'),
                'current_pincode' => $this->request->getVar('C_Pincode'),
                'permanent_address'  => $this->request->getVar('PAddress'),
                'permanent_state' => $this->request->getVar('PState'),
                'permanent_city'  => $this->request->getVar('PCity'),
                'permanent_pincode' => $this->request->getVar('PPincode')
            ];
            $PartyUserinsert = $PartyUser->insert($data);      
            if($PartyUserinsert){
                $session->setFlashdata('emp_ok',1);
                return redirect('add_party_user'); 
            }
        }
    }   

    public function view_party_user()  
    {   
        $session = \Config\Services::session(); 
        $result = $session->get();    
        if(isset($_GET['GST_No']))
        {
            $GST_No = $_GET['GST_No'];
        }  
        else {
            $GST_No = "";
        }
        $PartyUserModelObj = new PartyUserModel();
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 50;
        if(empty($GST_No))
        {
            $users = $PartyUserModelObj->orderBy('Name', 'asc')->paginate($perPage);
        }
        else{
            $users = $PartyUserModelObj->where("GST_No", $GST_No)->paginate($perPage);
        }
        $startSerial = ($page - 1) * $perPage + 1;
        $model6 = new StateModel();  
        $dax6=$model6->findAll();       
        $model1 = new CityModel();  
        $dax1=$model1->findAll();
        $data = [
            'users' => $users,
            'pager' => $PartyUserModelObj->pager,
            'startSerial' => $startSerial,
            'nextPage' => $page + 1,
            'previousPage' => ($page > 1) ? $page - 1 : null,
            'dax6' => $dax6,  
            'dax1' => $dax1, 
        ];
        return view('view_party_user',$data);   
    } 


    public function export_party_user(){
        $session = \Config\Services::session();
        $result = $session->get();    
        $GST_No = ''; 
        // Excel file name for download 
        $fileName = "Vendor" . date('Y-m-d') . ".xls";     
        // Column names 
        $fields = array('S.No', 'GST No', 'Name', 'Mobile No', 'Email Id'); 
        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 
        // Fetch records from database
        $PartyUserModelObj = new PartyUserModel();
        if(empty($GST_No))
        {      
            $data = $PartyUserModelObj->orderBy('Name', 'asc')->findAll(); 
        }
        else{
            $data = $PartyUserModelObj->where("GST_No", $GST_No)->orderBy('Name', 'asc')->findAll();
        }   
        $i=0;
        if(isset($data)){ 
            // Output each row of the data 
            foreach($data as $row)
            { 
                $i=$i+1;
                if(isset($row['GST_No'])){$GST_No = $row['GST_No'];} else{ $GST_No = 'NA';}
                if(isset($row['Name'])){$Name = $row['Name'];}else{ $Name = 'NA';}
                if(isset($row['Mobile_No'])){$Mobile_No = $row['Mobile_No'];} else{ $Mobile_No = 'NA';}
                if(isset($row['Email_Id'])){$Email_Id = $row['Email_Id'];}else{ $Email_Id = 'NA';}
                $lineData = array($i, $GST_No, $Name, $Mobile_No, $Email_Id);
                // array_walk(str_replace('"', '""',(preg_replace("/\r?\n/", "\\n",(preg_replace("/\t/", "\\t", $lineData))))); 
                $excelData .= implode("\t", array_values($lineData)) . "\n";   
            } 
        }
        else{ 
            $session->setFlashdata('excel',1);
        } 
        // Headers for download 
        header("Content-Type: application/vnd.ms-excel"); 
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        echo $excelData; 
        exit;
        return redirect('app-list');
    }

    public function update_party_user()      
    {
        $model = new PartyUserModel();
        $session = \Config\Services::session();
        $GST_No=$this->request->getVar('GST_No'); 
        $data = $model->where('GST_No',$GST_No)->first();
        if(isset($data) && $data!='')
        {
            $data = [     
                'Name'  => $this->request->getVar('Name'), 
                'Mobile_No'  => $this->request->getVar('Mobile_No'), 
                'Email_Id' => $this->request->getVar('Email_Id'),
                'current_address'  => $this->request->getVar('Address'),
                'current_state' => $this->request->getVar('C_State'),
                'current_city'  => $this->request->getVar('C_City'),
                'current_pincode' => $this->request->getVar('C_Pincode'),
                'permanent_address'  => $this->request->getVar('PAddress'),       
                'permanent_state' => $this->request->getVar('PState'),
                'permanent_city'  => $this->request->getVar('PCity'),
                'permanent_pincode' => $this->request->getVar('PPincode')
            ];
            if($model->where('id', $this->request->getVar('id'))->set($data)->update())
            {
                $session->setFlashdata('emp_up',1);
                return redirect('view_party_user'); 
            }
       }
        else{
            $data = [     
                'GST_No'  => $this->request->getVar('GST_No'), 
                'Name'  => $this->request->getVar('Name'), 
                'Mobile_No'  => $this->request->getVar('Mobile_No'), 
                'Email_Id' => $this->request->getVar('Email_Id'),
                'current_address'  => $this->request->getVar('Address'),
                'current_state' => $this->request->getVar('C_State'),
                'current_city'  => $this->request->getVar('C_City'),
                'current_pincode' => $this->request->getVar('C_Pincode'),
                'permanent_address'  => $this->request->getVar('PAddress'),       
                'permanent_state' => $this->request->getVar('PState'),
                'permanent_city'  => $this->request->getVar('PCity'),
                'permanent_pincode' => $this->request->getVar('PPincode')
            ];
            if($model->where('id', $this->request->getVar('id'))->set($data)->update())
            {
                $session->setFlashdata('emp_up',2);
                return redirect('view_party_user'); 
            }
        }  
    }

    public function del_party_user()   
    {  
        $session = \Config\Services::session();   
        $model = new PartyUserModel();
        $model->where('id', $this->request->getVar('id'))->delete();
        $session->setFlashdata('emp_delete',1); 
        return redirect('view_party_user');        
    }


    public function vendor_change_password()
    {
        return view('vendor-chage-password');
    }

    public function vendor_check_old_pass()
    {
        $pass = md5(trim($this->request->getVar('oldpass')));
        $emp_id = $this->request->getVar('emp_id');
        $model = new PartyUserModel();
        $dd = $model->where(['password'=>$pass,'id'=>$emp_id])->first();
        if(isset($dd)){ 
            echo 1; 
        }else{
            echo 0;
        }    
    }

    public function vendor_update_pass()
    {
        $daga = [ 
            'password'  => md5(trim($this->request->getVar('new_pass')))
        ];
        $emp_id = $this->request->getVar('id');  
        $modelup = new PartyUserModel();
        if($modelup->where('id', $emp_id)->set($daga)->update()){
            $session = \Config\Services::session();
            $session->setFlashdata('pass_up',1);
            return redirect('vendor-change-password');   
        }  
    }
    
    public function vendorregistration()      
    {
        $model = new StateModel();  
        $data['dax']=$model->orderBy('state_name', 'ASC')->findAll(); 
        $model1 = new CityModel();  
        $data['dax1']=$model1->findAll();
        return view('vendor-registration', $data);  
    }
    
    public function save_vendor()      
    {
        $validation =  \Config\Services::validation(); 
        $session = \Config\Services::session();
        $result = $session->get();   
        $PartyUser = new PartyUserModel();
        $otpModel = new OTPModel();
        $GST_No  = $this->request->getVar('GST_No');
        $datagst = $PartyUser->where('GST_No',$GST_No)->first();
        $Enter_Captcha_Code  = $this->request->getVar('Enter_Captcha_Code');
        $session_captchCode=$result['session_captchCode'];
        if(isset($datagst) && $datagst!='')
        {
            $session->setFlashdata('GSTNoalreadyexist',3);
            return redirect('vendor-registration');   
        }
        else{
            if($Enter_Captcha_Code==$session_captchCode)
            {
                $validation->setRules([ 
                    'GST_No' => 'required|string|is_unique[asitek_party_user.GST_No]',
                    'Mobile_No' => 'required|numeric|is_unique[asitek_party_user.Mobile_No]',
                    'Email_Id' => 'required|valid_email|is_unique[asitek_party_user.Email_Id]',
                ]);   
                if(!$validation->withRequest($this->request)->run()) {  
                    $errormsg['error']=$validation->getErrors();
                    $this->index();  
                    return view('vendor-registration',$errormsg);   
                } 
                else { 
                    $row= $otpModel->where('mobile_no',$this->request->getVar('Mobile_No'))->where('status',"completed")->first();  
                    if(isset($row) && $row!='')
                    {
                        $data = [  
                            'compeny_id'  => $this->request->getVar('compeny_id'),   
                            'GST_No'  => $this->request->getVar('GST_No'), 
                            'Name'  => $this->request->getVar('Name'), 
                            'Mobile_No'  => $this->request->getVar('Mobile_No'), 
                            'Email_Id' => $this->request->getVar('Email_Id'),
                            'role'  => "Vendor", 
                            'password' => md5($this->request->getVar('E_Password')),
                            'current_address'  => $this->request->getVar('Address'),
                            'current_state' => $this->request->getVar('C_State'),
                            'current_city'  => $this->request->getVar('C_City'),
                            'current_pincode' => $this->request->getVar('C_Pincode'),
                            'permanent_address'  => $this->request->getVar('C_State'),
                            'permanent_state' => $this->request->getVar('C_State'),
                            'permanent_city'  => $this->request->getVar('C_City'),
                            'permanent_pincode' => $this->request->getVar('C_Pincode'),
                            'Active' => 0
                        ];
                        $PartyUserinsert = $PartyUser->insert($data);      
                        if($PartyUserinsert){
                            echo $completed='complated';
                            echo $Mobile_No=$this->request->getVar('Mobile_No');
                            $otpModel->where('mobile_no', $Mobile_No)->set('status', $completed)->update();
                            $session->setFlashdata('emp_ok',1);
                            return redirect('vendor-registration'); 
                        }
                    }
                    else
                    {
                        $session->setFlashdata('emp_ok',2);
                        return redirect('vendor-registration'); 
                    }
                }
            }
            else{
                $session->setFlashdata('Captcha_Code_Check',2);
                return redirect('vendor-registration');   
            }
        }
    }   
    
    public function choosepaymentmethod()      
    {
        return view('choosepayment');  
    }
    
    public function activate_vendor()      
    {
        $validation =  \Config\Services::validation(); 
        $session = \Config\Services::session();
        $activatemodel = new ActivateModel();
        $PartyUser = new PartyUserModel();
        $GST_No  = $this->request->getVar('GST_No');
        $row= $PartyUser->where('GST_No',$GST_No)->first(); 
        if(isset($row['Expiry_Date']) && $row['Expiry_Date']!='')
        {
            $todaydate=date('Y-m-d');
            if($row['Expiry_Date']>$todaydate){
                $fromdate = $row['Expiry_Date'];
            }
            else{
                $fromdate = $todaydate;
            }
            if($this->request->getVar('planname')==1){
                $planname = 'Trial Pack';
                $validity = 'One Month';
                $enddate = date('Y-m-d', strtotime($fromdate . ' +1 month'));
            }
            $data = [  
                'Vendor_Id'  => $this->request->getVar('vendid'),   
                'Subscription_Pack'  => $planname, 
                'Subscription_Price'  => $this->request->getVar('amount'), 
                'Start_Date'  => $fromdate, 
                'End_Date' => $enddate,
            ];
            $activateaccount = $activatemodel->insert($data);      
            if($activateaccount){
                $PartyUser->where('id', $this->request->getVar('vendid'))->set($daga)->update();
                $session->setFlashdata('emp_ok',1);
                $session->set(["expirydate" => $enddate, "active" => 1]);
                return redirect('vendor-dashboard'); 
            }
        }
        else
        {
            $todaydate=date('Y-m-d');
            if($this->request->getVar('planname')==1){
                $planname = 'Trial Pack';
                $validity = 'One Month';
                $enddate = date('Y-m-d', strtotime($todaydate . ' +1 month'));
            }
            $data = [  
                'Vendor_Id'  => $this->request->getVar('vendid'),   
                'Subscription_Pack'  => $planname, 
                'Subscription_Price'  => $this->request->getVar('amount'), 
                'Start_Date'  => $todaydate, 
                'End_Date' => $enddate,
            ];
            $daga = [  
                'Expiry_Date'  => $enddate,
                'Active' => 1
            ];
            $activateaccount = $activatemodel->insert($data);      
            if($activateaccount){
                $PartyUser->where('id', $this->request->getVar('vendid'))->set($daga)->update();
                $session->setFlashdata('emp_ok',1);
                $session->set(["expirydate" => $enddate, "active" => 1]);
                return redirect('vendor-dashboard'); 
            }
        }
    } 
    
    
    public function deactivate_vendor_by_admin()      
    {
        $validation =  \Config\Services::validation(); 
        $session = \Config\Services::session();
        $PartyUser = new PartyUserModel();
        $todaydate=date('Y-m-d');
        $daga = [  
            'Active' => 0
        ];
            
        $PartyUser->where('id', $this->request->getVar('id'))->set($daga)->update();
        $session->setFlashdata('emp_ok',1);
        return redirect('view_party_user'); 
    } 
    
    public function activate_vendor_by_admin()      
    {
        $validation =  \Config\Services::validation(); 
        $session = \Config\Services::session();
        $PartyUser = new PartyUserModel();
        $todaydate=date('Y-m-d');
        $daga = [  
            'Active' => 1,
            'Expiry_Date'=>$this->request->getVar('expirydate')
        ];
            
        $PartyUser->where('id', $this->request->getVar('id'))->set($daga)->update();
        $session->setFlashdata('emp_ok',1);
        return redirect('view_party_user'); 
    } 

    public function vendor_password_change_by_admin()      
    {
        $validation =  \Config\Services::validation(); 
        $session = \Config\Services::session();
        $PartyUser = new PartyUserModel();
        $todaydate=date('Y-m-d');
        $pass = $this->request->getVar('vpassword');
        $upass = md5($pass);
        $daga = [  
            'password'=>$upass
        ];
            
        $PartyUser->where('id', $this->request->getVar('id'))->set($daga)->update();
        $session->setFlashdata('pass_ok',1);
        return redirect('view_party_user'); 
    } 

    public function getvendordetailfromajax()       
    {
        $session = \Config\Services::session(); 
        $result = $session->get();
        $compeny_id = $session->get("compeny_id"); 
        $GST_No=$this->request->getVar('GST_No');
        $PartyUserModelObj= new PartyUserModel();
        $PartyUserrow= $PartyUserModelObj->where('GST_No',$GST_No)->first();
        if(isset($PartyUserrow) && $PartyUserrow!='')
        {
           ?>
            <table class="table table-hover border">
                <thead>
                    <tr>
                       
                        <th>Name</th>
                        <th>Mobile_No</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $PartyUserrow['Name']; ?></td>
                        <td><?php echo $PartyUserrow['Mobile_No']; ?></td>
                    </tr>
                </tbody>
            </table>
            <span style="padding: 5px; color:red;"> Your GSTIN is already Registered, Please Contact to Admin. </span>
            <?php
        }
        else
        {
            ?>
            <span style="padding: 5px ;color:green;">GSTIN Not Registered. Continue..</span>
            <?php
        }
    }


    public function sendOTP()
    {
        $otpModel = new OTPModel();
        $mobileNo = $this->request->getPost('whatsapp');
        $storedOTP = $otpModel->where('mobile_no', $mobileNo)->where('status', 'completed')->first();
        if ($storedOTP >0) {
            return json_encode(['status' => 'false']);
        } 
        else {
            // Your code here
            $whatsapp = $this->request->getPost('whatsapp');
            // Generate OTP
            $otp = rand(100000, 999999);
            // Insert OTP into the database
            $otpModel = new OTPModel();
            $otpModel->insert([
                'mobile_no' => $whatsapp,
                'otp' => $otp
            ]);
            //Send WhatsApp message
            $wpmsg = "Hi , your otp is, " . $otp.". For a detailed walkthrough of the portal's features and functionalities, we have prepared a training video. Please visit bdslp.com and click on 'Promo' to watch the video. This will help you understand how to utilize the portal effectively for your billing needs.";
            $url = "https://int.chatway.in/api/send-msg?username=bdenterprise&number=+91".$whatsapp."&message=".$wpmsg."&token=OVdmRlR6d3BsdUptRWJPNFhtdGwvZz09";
            $url = preg_replace("/ /", "%20", $url);
            $response = file_get_contents($url);

            return json_encode(['status' => 'success']);
        }
    }


     // Controller function to verify OTP
    public function verifyOTP()
    {
        $otp = $this->request->getPost('otp');
        $mobileNo = $this->request->getPost('whatsapp');

        // Retrieve OTP from the database based on the user's WhatsApp number
        $otpModel = new OTPModel();
        $storedOTP = $otpModel->where('mobile_no', $mobileNo)->where('status', 'pending')->orderBy('created_at', 'DESC')->first();
        if ($storedOTP && $storedOTP['otp'] == $otp) {
            $otpModel->update($storedOTP['id'], ['status' => 'verified']);
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'error']);
        }
    }

    public function sendEmailOTP()
    {
        $email = \Config\Services::email();
        $emailAddress = $this->request->getPost('email');
        $mobileNo = $this->request->getPost('whatsapp');
        // Generate Email OTP (e.g., using rand() function)
        $emailOTP = rand(100000, 999999);
        // Update the existing row with the Email OTP and user's email
        $otpModel = new OTPModel();
        $existingOTP = $otpModel->where('mobile_no', $mobileNo)->where('status', 'verified')->orderBy('created_at', 'DESC')->first();
        if ($existingOTP) {
            // Update the existing row with the new email and Email OTP
            $otpModel->update($existingOTP['id'], [
                'email' => $emailAddress,
                'email_otp' => $emailOTP,
                // Optionally update other fields or status if needed
            ]);
            $wpmsg = "Hi , your otp is, " . $emailOTP;
            $email->setFrom("streamlinepro09@gmail.com", "Supplier Relationship Management");
            $email->setTo($emailAddress);
            $email->setSubject("OTP Verification | Supplier Relationship Management");
            $email->setmailType("html");
            $email->setMessage($wpmsg); //your message here
            
            // Send email
            if ($email->send()) {
                return json_encode(['success' => true, 'message' => 'Email OTP sent successfully']);
            } else {
                return json_encode(['success' => false, 'message' => 'Failed to send Email OTP']);
            }
        } else {
            // Handle if no existing row is found for the mobile number
            return json_encode(['error' => 'No pending OTP entry found for this mobile number.']);
        }
    }

    // Controller function to verify Email OTP
    public function verifyEmailOTP() {
        $emailOTP = $this->request->getPost('email_otp');
        $email = $this->request->getPost('email');
        $mobileNo = $this->request->getPost('whatsapp'); // Assuming you have a hidden input field for mobile number

        // Retrieve the existing OTP entry based on the mobile number and status
        $otpModel = new \App\Models\OTPModel();
        $existingOTP = $otpModel->where('mobile_no', $mobileNo)->where('status', 'verified')->orderBy('created_at', 'DESC')->first();
        if(!empty($existingOTP)){
            if ($existingOTP['email_otp'] == $emailOTP) {
                // Email OTP verification successful
                // Update status in the database to verified
                $otpModel->update($existingOTP['id'], [
                    'status' => 'completed',
                    // Optionally update other fields in the same row if needed
                ]);
                return json_encode(['status' => 'success']);
            } else {
                // Email OTP verification failed
                return json_encode(['status' => 'error']);
            }
        }
        else {
            // Email OTP verification failed
            return json_encode(['status' => 'error']);
        }
    }

    public function number_random()
    {
        $session = \Config\Services::session();
        $random_number =   rand(100000, 999999);
        $session->set(["session_captchCode" =>$random_number ]);
        echo $random_number;
    }

    public function verify_Captcha_Code()
    {
        $session = \Config\Services::session();
        $result = $session->get();   
        $Enter_Captcha_Code  = $this->request->getVar('Enter_Captcha_Code');
        $session_captchCode=$result['session_captchCode'];
        if ($Enter_Captcha_Code == $session_captchCode) {
            return json_encode(['status' => 'success']);
        } 
        else {
            return json_encode(['status' => 'error']);
        }
    }

    public function getvendorSuggestions()
    {
        $query      = $this->request->getVar('query'); // Get the entered text from the input field
        $data = $this->db->query("SELECT * from asitek_party_user WHERE (GST_No LIKE '%$query%' OR Name LIKE '%$query%') ORDER BY id DESC LIMIT 20")->getResult();  // Adjust the column name based on your database structure
        return $this->response->setJSON($data);
    }
}