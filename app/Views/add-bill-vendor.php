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
                                    if(session()->has("success"))
                                    {   
                                        echo session("success");
                                    } 
                                    ?>
                                </div>
                                <form method="post" action="<?php echo site_url('/vendor-store-bill-register'); ?>" enctype="multipart/form-data"> 
                                    <input  type="hidden" name="vendor_id" value="<?php echo $emp_id;?>" >
                                    <input  type="hidden" name="Add_By" value="<?php echo $emp_id;?>" >
                                    <div class="flex flex-wrap items-center">
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company<span style="color:red;">*</span></label>
                                                <select name="company_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="select-country" data-live-search="true"> 
                                                    <option value="">Select Company</option>
                                                    <?php
                                                    if(isset($company)){
                                                        foreach ($company as $row14){ ?>
                                                            <option value="<?php echo $row14->id; ?>"><?php echo ucwords($row14->name); ?></option>
                                                        <?php 
                                                        }
                                                    }?> 
                                                </select>
                                            </div> 
                                        </div>  
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bill No<span style="color:red;">*</span></label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="Bill_No" placeholder="Bill No">
                                            </div> 
                                        </div>
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bill Date<span style="color:red;">*</span></label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="date" name="Bill_DateTime" placeholder="" max="<?php echo $today;?>" id="Bill_DateTime">
                                            </div> 
                                        </div>
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bill Total Amt<span style="color:red;">*</span></label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="Bill_Amount" placeholder="Bill Total Amt"  oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                                            </div> 
                                        </div>  
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2" >
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit<span style="color:red;">*</span></label>
                                                <select name="Unit_Id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="Unit_Id">
                                                        <option value="">-Select -</option>   <?php
                                                        if(isset($dax15)){
                                                        foreach ($dax15 as $row15){ ?>
                                                            <option value="<?php echo $row15['id']; ?>"><?php echo ucwords($row15['name']); ?></option>
                                                    <?php }} ?>        
                                                </select>
                                            </div>
                                        </div>
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gate Entry No<span style="color:red;">*</span></label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="Gate_Entry_No" placeholder="Gate Entry No" >
                                            </div> 
                                        </div>
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group">
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gate Entry Date<span style="color:red;"></span></label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="date" name="Gate_Entry_Date" placeholder="" max="<?php echo $today;?>">
                                            </div> 
                                        </div> 
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <div class="form-group"> 
                                                <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark<span style="color:red;"></span></label>
                                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="Remark" placeholder="Remark if Any">
                                            </div> 
                                        </div>
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                            <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bill Pic<span style="color:red;">*</span></label>
                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="file" name="E_Image"  id="billpic">
                                        </div>  
                                        <div class="md:w-1/3 justify-center md:justify-start text-white px-2" style="display: none;">
                                            <div class="form-group">
                                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                                                <select name="Department_Id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" style="padding: 0.875rem 1.375rem"  id="department" > 
                                                    <option value="">-Select Department-</option>
                                                    <?php
                                                        if(isset($dax9)){
                                                            foreach ($dax9 as $row){ ?>
                                                                <option value="<?php echo $row['id']; ?>" ><?php echo ucwords($row['name']); ?></option>
                                                            <?php 
                                                            }
                                                        } 
                                                    ?>    
                                                </select>
                                            </div> 
                                        </div>  
                                    </div> 
                                    <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">Submit</button>   
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

        <script>  
            $(document).ready(function () {
                $('#select-country').change(function(){ 
                    var company_id = $('#select-country').val();  
                    var action = 'get_unit';   
                    if(company_id != '')
                    {   
                        $.ajax({     
                            url:"<?php echo base_url('/index.php/getUnit')?>",
                            method:"GET",
                            data:{company_id:company_id, action:action},  
                            dataType:"JSON",
                            success:function(data)  
                            {        
                                var html = '<option value="">Select Unit</option>';
            
                                for(var count = 0; count < data.length; count++)
                                {
                                    html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
                                }
            
                                $('#Unit_Id').html(html);
                            }
                        });
                    }
                    else   
                    {
                        $('#Unit_Id').val('');
                    }
                });
            });
        </script>
        <script>
        // Get the input element
        var dateInput = document.getElementById('Bill_DateTime');
        // Get today's date
        var today = new Date();
        // Set the fixed date you want to block dates before
        var fixedDate = new Date('2024-04-01');
        // Set the minimum date allowed (fixed date)
        dateInput.min = fixedDate.toISOString().split('T')[0];
        // Update the input value to the fixed date if today is before the fixed date
        if (today < fixedDate) {
          dateInput.value = fixedDate.toISOString().split('T')[0];
        }

        // Add an event listener to update the input value if the user tries to select a date before the fixed date
        dateInput.addEventListener('input', function() {
          var selectedDate = new Date(this.value);
          if (selectedDate < fixedDate) {
              this.value = fixedDate.toISOString().split('T')[0];
          }
        });
      </script>
    </body>    
</html>