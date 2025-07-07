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
            <div class="flex flex-wrap">
                <div class="flex flex-row flex-wrap flex-grow mt-2">
                    <div class="w-full md:w-full xl:w-full p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="px-5 tableFixHead">
                                <table class="border-separate w-full p-1 text-gray-700 table-auto hover:table-auto" id="myTable">
                                    <thead>
                                        <tr>
                                            <th class="border border-slate-300 p-2">#</th>
                                            <th class="border border-slate-300 p-2"><b>Upload Date Time</b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill Pic</b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill Id</b></th>
                                            <th class="border border-slate-300 p-2"><b>Company Name</b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill No</b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill Amount</b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill Date</b></th>
                                            <th class="border border-slate-300 p-2"><b>Gate</b></th> 
                                            <th class="border border-slate-300 p-2"><b>Gate Entry Date</b></th>
                                            <th class="border border-slate-300 p-2"><b>Remark</b></th>
                                            <th class="border border-slate-300 p-2"><b>Action</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 

                                    if(isset($billdrftlist)){
                                        foreach ($billdrftlist as $index => $row)
                                        {
                                            ?>
                                            <tr>
                                                <td class="border border-slate-300 p-2"><?= $startSerial++ ?></td>
                                                <td class="border border-slate-300 p-2"><?php echo date('d-m-Y H:i:s', strtotime($row['DateTime']))?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['DateTime'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['uid'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['companyname'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Bill_No'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Bill_Amount'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Bill_DateTime'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Gate_Entry_No'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Gate_Entry_Date'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Remark'];?></td>
                                                <td class="border border-slate-300 p-2">
                                                    <button class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" type="button" data-modal-toggle="received-modal<?php echo $row['id'];?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                    </button>
                                                </td>
                                            </tr> 
                                            <div id="received-modal<?php echo $row['id'];?>" aria-hidden="true" class="hidden overflow-x-hidden overflow-y-auto fixed h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <!-- Modal content -->
                                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                        <!-- Modal header -->
                                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                                Delete Bill Draft
                                                            </h3>
                                                            <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="received-modal<?php echo $row['id'];?>">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="p-4 md:p-5">
                                                            <h4>Are you sure you want to delete this record</h4>
                                                            <form class="space-y-4" action="<?php echo site_url('/bill-draft-delete'); ?>" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                
                                                                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-2">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } 
                                    } 
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <?php if ($pager) :?>
                                <?= $pager->links() ?>
                            <?php endif ?>
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