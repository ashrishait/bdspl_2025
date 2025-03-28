<?php 
use App\Models\StateModel; 
use App\Models\CityModel;
use App\Models\UnitModel;
use App\Models\RollModel;
use App\Models\EmployeeModel;
use App\Models\PartyUserModel;
use App\Models\BillRegisterModel;
use App\Models\DepartmentModel;
use App\Models\BillTypeModel;
use App\Models\MasterActionModel;
$BillTypeModelObj = new BillTypeModel();
$state = new StateModel();
$city = new CityModel();
$UnitModelObj = new UnitModel();
$RollModelObj = new RollModel();
$EmployeeModelObj = new EmployeeModel();
$PartyUserModelObj = new PartyUserModel();
$BillRegisterModelObj = new BillRegisterModel();
$DepartmentModelObj = new DepartmentModel();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include('include/vendor-head.php'); ?>
    </head>
    <body>
        <?php include('include/vendor-header.php'); ?>
        <?php 
        if($expirydate==null||$expirydate=='0000-00-00'){ ?>
        <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-12 pb-24 md:pb-5">
            <div class="bg-gray-800 pt-3">
                <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
                    <h3 class="font-bold pl-2">Activate Your Account</h3>
                </div>
            </div>
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/2 xl:w-1/3 p-6 mx-auto">
                    <div class="relative flex flex-col bg-clip-border rounded-xl bg-gradient-to-tr from-gray-900 to-gray-800 text-white shadow-gray-900/20 shadow-md w-full max-w-[20rem] p-8">
                      <div class="relative pb-8 m-0 mb-8 overflow-hidden text-center text-gray-700 bg-transparent border-b rounded-none shadow-none bg-clip-border border-white/10">
                        <p class="block font-sans text-sm antialiased font-normal leading-normal text-white uppercase">
                          Trial Pack
                        </p>
                        <h1 class="flex justify-center gap-1 mt-6 font-sans antialiased font-normal tracking-normal text-white text-7xl">
                          <span class="mt-2 text-4xl"><i class="fas fa-rupee-sign"></i></span>0
                          <span class="self-end text-4xl">for one month</span>
                        </h1>
                      </div>
                      
                      <div class="p-0 mt-12">
                        <form method="post" action="<?php echo site_url('/activate-vendor'); ?>">
                            <input type="hidden" name="vendid" value="<?php echo $emp_id;?>">
                            <input type="hidden" name="planname" value="1">
                            <input type="hidden" name="amount" value="0">
                            <button type="submit" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Activate Account</button>
                            </button>   
                        </form>  
                      </div>
                    </div> 
                </div>
            </div>
        </div>    
        <?php }
        else{ ?>
            <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-12 pb-24 md:pb-5">
                <div class="bg-gray-800 pt-3">
                    <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
                        <h3 class="font-bold pl-2">Activate Your Account</h3>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6 mx-auto">
                        <div class="relative flex flex-col bg-clip-border rounded-xl bg-gradient-to-tr from-gray-900 to-gray-800 text-white shadow-gray-900/20 shadow-md w-full max-w-[20rem] p-8">
                          <div class="relative pb-8 m-0 mb-8 overflow-hidden text-center text-gray-700 bg-transparent border-b rounded-none shadow-none bg-clip-border border-white/10">
                            <p class="block font-sans text-sm antialiased font-normal leading-normal text-white uppercase">
                              One Month Pack
                            </p>
                            <h1 class="flex justify-center gap-1 mt-6 font-sans antialiased font-normal tracking-normal text-white text-7xl">
                              <span class="mt-2 text-4xl"><i class="fas fa-rupee-sign"></i></span>0
                              <span class="self-end text-4xl">for one month</span>
                            </h1>
                          </div>
                          
                          <div class="p-0 mt-12">
                            <form method="post" action="<?php echo site_url('/activate-vendor'); ?>">
                                <input type="hidden" name="vendid" value="<?php echo $emp_id;?>">
                                <input type="hidden" name="planname" value="1">
                                <input type="hidden" name="amount" value="0">
                                <button type="submit" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Activate Account</button>
                            </form> 
                          </div>
                        </div> 
                    </div>
                </div>
            </div> 
        <?php }
        ?>   
        <!-- container-scroller -->
        <?php include('include/script.php'); ?>
        <script>
            /*Toggle dropdown list*/
            function toggleDD(myDropMenu) {
                document.getElementById(myDropMenu).classList.toggle("invisible");
            }
            /*Filter dropdown options*/
            function filterDD(myDropMenu, myDropMenuSearch) {
                var input, filter, ul, li, a, i;
                input = document.getElementById(myDropMenuSearch);
                filter = input.value.toUpperCase();
                div = document.getElementById(myDropMenu);
                a = div.getElementsByTagName("a");
                for (i = 0; i < a.length; i++) {
                    if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                    } else {
                        a[i].style.display = "none";
                    }
                }
            }

            // Close the dropdown menu if the user clicks outside of it
            window.onclick = function(event) {
                if (!event.target.matches('.drop-button') && !event.target.matches('.drop-search')) {
                    var dropdowns = document.getElementsByClassName("dropdownlist");
                    for (var i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (!openDropdown.classList.contains('invisible')) {
                            openDropdown.classList.add('invisible');
                        }
                    }
                }
            }
        </script> 
    </body>
</html>