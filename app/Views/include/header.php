<?php
use App\Models\PageaccessionModel;
use App\Models\PageModel;
$employeeModel = new PageaccessionModel();
$PageModelObj = new PageModel();

if(isset($_GET['ViewOnly']))
{
    $ViewOnly=$_GET['ViewOnly'];
}
else{
    $ViewOnly='';
}
if($Roll_id=='Vendor')
    {
        ?>
        <script type="text/javascript"> 
            alert("Page Not Access"); 
            window.location.href="<?php echo base_url(
                "/index.php/"
            ); ?>"
        </script>
        <?php   
    }
    else
    {
        if($Roll_id=='0')
        {

        } 
        elseif($Roll_id=='1')
        {

        } 
        elseif($Roll_id=='2')
        {
            $url="/".service('request')->uri->getSegment(1);
           $Pagerow= $PageModelObj->where('Page_Link',$url)->first();
            if(isset($Pagerow) && $Pagerow!='')
            {
                $pageacces= $employeeModel->where('Page_Id',$Pagerow['Id'])->where('Emp_Id',$emp_id)->first();
                if(isset($pageacces) && $pageacces!='')
                  {

                  } 
                  else{
                    if($url=="/main-dashboard")
                        {
                        ?>
                            <script type="text/javascript">
                               alert("Page Not Access"); 
                                window.location.href="<?php echo base_url(
                                    "/logout/"
                                ); ?>"
                            </script>
                            <?php 
                        }
                        else
                        {
                            if($ViewOnly==1)
                            {

                            }
                            else{

                            
                            ?>
                            <script type="text/javascript">
                               alert("Page Not Access"); 
                                window.location.href="<?php echo base_url(
                                    "/index.php/"
                                ); ?>"
                            </script>
                            <?php
                            } 
                        }
                      
                } 
            }

        } 

    }
        
?>
    
    <div class="horizontal-menu">
        <nav class="navbar top-navbar col-lg-12 col-12 p-0" style="background: #004784;border-bottom:none;border-radius:0;">
            <div class="container-fluid">
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                       <h1 style="font-weight:bold;color:#fff;">
                           <?php  
                            if($Roll_id=='0'){
                                echo $session->get("compeny_name");
                            }
                            else{
                                echo $session->get("compeny_name");
                            }?>
                       </h1>
                    </div>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a href="https://sampling.bdslp.com/" target="_blank" class="text-white">Login To Sampling Software</a>
                        </li>
                        <li class="nav-item nav-profile dropdown">
                            <?php 
                            if($Sesssion_start_Date=='')
                            {
                                echo "All Date";
                            }
                            else{
                                echo  date('d-m-Y', strtotime($Sesssion_start_Date))." To ".date('d-m-Y', strtotime($Sesssion_end_Date));
                            }
                            ?>
                        </li>
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                                <span class="nav-profile-name text-white"><?php echo ucwords($name);?> ( <?php echo ucwords($Role);?>)</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                 <a class="dropdown-item" href="<?php echo base_url('/index.php/profile');?>">
                                    <i class="mdi mdi-settings text-primary"></i>
                                   Profile
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url('/index.php/change-password');?>">
                                    <i class="mdi mdi-settings text-primary"></i>
                                    Change Password
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url('/index.php/update-bank-details');?>">
                                    <i class="mdi mdi-settings text-primary"></i>
                                    Update Bank Details
                                </a>
                                <?php 
                                $bylogin_email=$session->get("bylogin_email");
                                if($bylogin_email!='')
                                {
                                ?>
                                    

                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#bd-example-modal-lg-DirectLogin-2" title="Direct Login"><span class="mdi mdi-login-variant">Back Self Login</span></button>
                                    <?php 
                                }
                                ?>
                                <a class="dropdown-item"  href="<?php echo base_url('/index.php/logout');?>">
                                    <i class="mdi mdi-logout text-primary"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </div>
        </nav>

        <nav class="bottom-navbar">
            <div class="container-fluid">
                <div class="row" style="background: #065ca3;">
                    <?php  
                    if($Roll_id=='0'){ ?>
                        <div class="col-sm-12 py-2">
                            <ul class="nav page-navigation" style="justify-content:normal">
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/main-dashboard');?>">
                                        <i class="mdi mdi mdi-view-dashboard menu-icon"></i>
                                        <span class="menu-title">Dashboard</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-links">
                                        <i class="mdi mdi-cube-outline menu-icon"></i>
                                        <span class="menu-title">Manage Settings</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="submenu submenu2">
                                        <ul>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/view_compeny');?>">Manage Compeny </a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/add-user');?>">Add User</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/user_details');?>">View User</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/add_party_user');?>">Add Vendor</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/view_party_user');?>">View Vendor</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/add-company-in-vendor');?>">Add Vendor to Company</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/state');?>">Manage State</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/city');?>">Manage City</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/change-password');?>">Change password</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/logout');?>">Logout</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/allcompanyemployeereward');?>">
                                        <i class="mdi mdi mdi-view-dashboard menu-icon"></i>
                                        <span class="menu-title">Distribute Reward</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-links"  href="<?php echo base_url('/index.php/reword_report');?>">
                                        <i class="mdi mdi-arrow-down-bold"></i>
                                        <span class="menu-title">Reward Report</span>
                                    </a>
                                </li>
                                <li class="nav-item float-end">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/main-dashboard');?>">
                                        <i class="mdi mdi-email-mark-as-unread"></i>
                                        <span class="menu-title">Contact Us</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <?php  
                    }
                    elseif($Roll_id=='1'){ ?> 
                        <div class="col-sm-12 py-2">
                            <ul class="nav page-navigation" >
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/main-dashboard');?>">
                                        <i class="mdi mdi mdi-view-dashboard menu-icon"></i>
                                        <span class="menu-title">Dashboard</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-links">
                                        <i class="mdi mdi-image-plus"></i>
                                        <span class="menu-title">Bill Add</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="submenu submenu2">
                                        <ul>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/add_bill_register');?>">Bill Add</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/view_bill_register');?>">View Bill </a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/all_bill_mapping_list');?>">
                                        <i class="mdi mdi-clipboard-account-outline"></i>
                                        <span class="menu-title">Bill Assignment</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/all_Clear_Bill_Form_list');?>">
                                        <i class="mdi mdi-shield-check"></i>
                                        <span class="menu-title">Bill Verify </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/all_erpStystem_list');?>">
                                        <i class="mdi mdi-arrow-down-bold"></i>
                                        <span class="menu-title">Bill Entry</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-links">
                                        <i class="mdi mdi-call-received"></i>
                                        <span class="menu-title">Bill Received</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="submenu submenu2">
                                        <ul>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/all_recived_bill_list');?>">All Recived Bill</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/view_complete_bill_list');?>">View Complete  Bill</a></li>
                                            
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">

                                    <a href="#" class="nav-links">

                                         <i class="mdi mdi-arrow-down-bold"></i>

                                        <span class="menu-title">Report</span>

                                        <i class="menu-arrow"></i>

                                    </a>

                                    <div class="submenu submenu2">

                                        <ul>

                                            

                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/complete_bill_report');?>">View   Bill Report</a></li>

                                             <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/generate_bill_shipped');?>"> Generate Bill Shipped </a></li> 

                                             <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/bill_pass_pending_plot_wise');?>">View Bill Pass Pending Plot wise Details </a></li> 

                                        </ul>

                                    </div>

                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-links">
                                        <i class="mdi mdi-apps"></i>
                                        <span class="menu-title">Settings</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="submenu submenu2">
                                        <ul>
                                            <li class="nav-item"><a class="nav-link" href="<?php  echo base_url('/index.php/view_master_action');?>">Manage Master Action</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/view_unit');?>">Manage Unit</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/view_billType');?>">Manage Bill Type</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/view-department-name');?>">Manage Department Name</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/view_department');?>">Manage Department</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/add-user');?>">Add User</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/user_details');?>">View User</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/page-list');?>">Assign Pages</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/add_party_user');?>">Add Vendor</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/view_party_user');?>">View Vendor</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/add-vendor-in-organization');?>">Add Vendor for You Company</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/change-password');?>">Change password</a></li>
                                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url('/index.php/logout');?>">Logout</a></li>
                                        </ul>   
                                    </div>
                                </li>
                               <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/commission_dashboard');?>">
                                        <i class="mdi mdi-arrow-down-bold"></i>
                                        <span class="menu-title">Rewards</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/scanqr');?>">
                                        <i class="mdi mdi-qrcode"></i>
                                        <span class="menu-title">Scan QR</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/main-dashboard');?>">
                                        <i class=" mdi mdi-message-text"></i>
                                        <span class="menu-title">Contact Us</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php  }
                    else{ ?>
                        <div class="col-sm-12">
                            <ul class="nav" >
                                <?php
                                $Roll_id = $session->get("Roll_id");
                                $emp_id = $session->get("emp_id"); 
                                $compeny_id = $session->get("compeny_id"); 
                                
                                $rollpage = $employeeModel->pagelinkaccordingtoroll($emp_id);
                                $menu = $rollpage->get()->getResult();
                                if(isset($menu)){
                                    foreach ($menu as $menun){ 
                                        ?>
                                            <li class="nav-item">
                                                <a class="nav-links" href="<?php echo site_url($menun->Page_Link);?>">
                                                    <i class="mdi mdi mdi-view-dashboard menu-icon"></i>
                                                    <span class="menu-title"><?php echo $menun->Page_Name;?></span>
                                                </a>
                                            </li>
                                            
                                    <?php }
                                }
                                ?>
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/commission_dashboard');?>">
                                        <i class="mdi mdi-arrow-down-bold"></i>
                                        <span class="menu-title">Rewards</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/scanqr');?>">
                                        <i class="mdi mdi-qrcode"></i>
                                        <span class="menu-title">Scan QR</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-links" href="<?php echo base_url('/index.php/main-dashboard');?>">
                                        <i class=" mdi mdi-message-text"></i>
                                        <span class="menu-title">Contact Us</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?> 
                </div>
            </div>
        </nav>
    </div>
    



    