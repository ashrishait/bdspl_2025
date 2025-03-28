<?php
use App\Models\StateModel; 
use App\Models\CityModel;
use App\Models\UserModel;  
use App\Models\EmployeeModel;
use App\Models\PartyUserModel;
use App\Models\RollModel;
$state = new StateModel();
$city = new CityModel();
$modelUser = new UserModel();
$modelEmployee = new EmployeeModel();
$PartyUserModelObj = new PartyUserModel();
$RollModelObj = new RollModel();
$today = date('Y-m-d');
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include('include/vendor-head.php'); ?>
    </head>
    <body>
        <?php include('include/vendor-header.php'); ?>
        <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-12 pb-24 md:pb-5">
            <div class="bg-gray-800 pt-3">
                <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
                    <h3 class="font-bold pl-2">Vendor Profile</h3>
                </div>
            </div>
            <div class="flex flex-wrap">
                <div class="flex flex-row flex-wrap flex-grow mt-2">
                    <div class="w-full md:w-full xl:w-full p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h5 class="font-bold uppercase text-gray-600"></h5>
                            </div>
                            <div class="p-5">
                                <div class="col-md-12 col-sm-12">
                                    <?php
                                    if(session()->has("success"))
                                    {   
                                        echo session("success");
                                    } 
                                        $Vendorrow= $PartyUserModelObj->where('id',$emp_id)->first();
                                    ?>
                                </div>
                                <form method="post" action="<?php echo site_url('/vendor-store-bill-register'); ?>" enctype="multipart/form-data"> 
                                    <input  type="hidden" name="vendor_id" value="<?php echo $emp_id;?>" >
                                    <input  type="hidden" name="Add_By" value="<?php echo $emp_id;?>" >
                                    <div class="flex flex-wrap items-center">
                                       
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">GST No<span style="color:red;"></span></label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text"  value="<?php echo $Vendorrow['GST_No']; ?>" readonly>
                                            </div> 
                                        </div>
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Mobile No<span style="color:red;"></span></label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text"   value="<?php echo $Vendorrow['Mobile_No']; ?>" readonly>
                                            </div> 
                                        </div>  
                                       
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Mobile No<span style="color:red;"></span></label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text"   value="<?php echo $Vendorrow['Mobile_No']; ?>" readonly>
                                            </div> 
                                        </div> 
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Email Id <span style="color:red;"></span></label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text"   value="<?php echo $Vendorrow['Email_Id']; ?>" readonly>
                                            </div> 
                                        </div> 
                                       

                                    </div> 
                                    <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                       
                                        <!--<button type="reset" class="btn btn-secondary">Reset</button>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('include/vendor-footer.php')?>
        </div>          
        
        <?php include('include/script.php'); ?>

      
    </body>    
</html>