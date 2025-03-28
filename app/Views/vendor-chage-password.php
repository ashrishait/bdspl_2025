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
    </head>
    <body>
        <?php include('include/vendor-header.php'); ?>
        <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-12 pb-24 md:pb-5">
            <div class="bg-gray-800 pt-3">
                <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
                    <h3 class="font-bold pl-2">Add Bill</h3>
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
                                    ?>
                                </div>
                                <form method="post" action="<?php echo site_url('/vendor-change-pass'); ?>" enctype="multipart/form-data"> 
                                    <input type="hidden" name="id" id="emp_id" value="<?php echo $emp_id; ?>">
                                    <div class="flex flex-wrap items-center">
                                        <div class="form-group">
                                            <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old Password <span style="color:red;">*</span></label>
                                            <span id="hint"></span>
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="password" id="oldpassword" name="old_pass" required onkeyup="checkold(this.value);" >
                                        </div> 
                                    </div>  
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Password <span style="color:red;">*</span></label>
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="NewPassword" type="password" name="new_pass" required onkeyup="checknew(this.value);" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password <span style="color:red;">*</span></label><span id="msg"></span>
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="password" name="c_pass" id="ConfirmPassword" required onkeyup="checkcpass(this.value);" disabled>
                                        </div>
                                    </div>    
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded" disabled id="up">Submit</button>   
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
        <script>
        function checkold(str) {  
            if(str != '')   
            {   
                var emp_id = document.getElementById("emp_id").value;  
                $.ajax({       
                    url:"<?php echo base_url('/index.php/vendor-check-old-pass')?>",  
                    method:"GET",
                    data:{oldpass:str, emp_id:emp_id},  
                    dataType:"JSON",
                    success:function(data)   
                    {     
                        if(data==1){ 
                            document.getElementById("hint").style.color="green";
                            document.getElementById("hint").innerHTML = "Congratulation: Old Password match."
                            document.getElementById("NewPassword").disabled = false; 
                            document.getElementById("ConfirmPassword").disabled = false;    
                        }
                        else{
                            document.getElementById("hint").style.color="red";
                            document.getElementById("hint").innerHTML = "Failed: Old Password does not match!!"
                            document.getElementById("NewPassword").disabled = true; 
                            document.getElementById("ConfirmPassword").disabled = true;        
                        }
                    }
                });
            }
            else   
            {
                document.getElementById("hint").innerHTML = "";  
            }
        }
        </script>
        <script>  
        function checknew(str) {
            var acc = document.getElementById("NewPassword").value;
            var acd = document.getElementById("ConfirmPassword").value;
            if(acd!="")  
            if(acd==str){
                document.getElementById("msg").style.color="green";
                document.getElementById("msg").innerHTML = "Succesful: Password Confirmation." 
                document.getElementById("up").disabled = false;   
            }
            else{
                document.getElementById("msg").style.color="red";
                document.getElementById("msg").innerHTML = "Failed: Password Confirmation!!" 
                document.getElementById("up").disabled = true;          
            }  
        }
        </script>
        <script>  
            function checkcpass(str) {
                var acd = document.getElementById("NewPassword").value;
                if(acd==str){
                    document.getElementById("msg").style.color="green";
                    document.getElementById("msg").innerHTML = "Succesful: Password Confirmation." 
                    document.getElementById("up").disabled = false; 
                }
                else{
                    document.getElementById("msg").style.color="red";
                    document.getElementById("msg").innerHTML = "Failed: Password Confirmation!!"
                    document.getElementById("up").disabled = true;         
                }  
            }
        </script>
    </body>
</html>