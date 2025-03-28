<?php
use App\Models\StateModel; 
use App\Models\CityModel;
use App\Models\UserModel;  
use App\Models\EmployeeModel;
use App\Models\CreateStylemodel;
use App\Models\PartyUserModel;
use App\Models\RollModel;
$state = new StateModel();
$city = new CityModel();
$modelUser = new UserModel();
$modelEmployee = new EmployeeModel();
$PartyUserModelObj = new PartyUserModel();
$RollModelObj = new RollModel();

                                                     
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include('include/vendor-head.php'); ?>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
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
                                    if(session()->has("pass_up"))
                                    {   
                                        if(session("pass_up")==1)      
                                        {  
                                            echo "<div class='alert alert-success' role='alert'> Password Updation Successful. </div>";
                                        }
                                        else{
                                            echo "<div class='alert alert-danger' role='alert'> Problem in Updation! </div>";
                                        }
                                    } 
                                    $Vendorrow= $PartyUserModelObj->where('id',$emp_id)->first();
                              
                                    ?>
                                </div>


                                <form method="post" action="<?php echo site_url('/vendor-change-pass'); ?>" enctype="multipart/form-data"> 
                                    <input type="hidden" name="id" id="emp_id" value="<?php echo $emp_id; ?>">
                                    <div class="row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your GST No <span style="color:red;"></span></label>
                                            <input  type="text" class="form-control" name=""   value="<?php echo $Vendorrow['GST_No']; ?>" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Mobile No <span style="color:red;"></span></label>
                                            <input  type="text" class="form-control" name=""   value="<?php echo $Vendorrow['Mobile_No']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Email Id <span style="color:red;"></span></label>
                                            <input  type="text" class="form-control" name=""   value="<?php echo $Vendorrow['Email_Id']; ?>" readonly>
                                        </div>
                                    </div>
                                     <div class="col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Expiry Date<span style="color:red;"></span></label>
                                            <input  type="text" class="form-control" name=""   value="<?php echo $Vendorrow['Expiry_Date']; ?>" readonly>
                                        </div>
                                    </div>    
                                      </div>  
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <br>
                                          <!--  <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded" disabled id="up">Submit</button>  --> 
                                        </div>
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