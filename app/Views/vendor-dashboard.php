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
        <?php include('include/vendor-header.php'); 
        if($active!=0){ 
            if($expirydate> $todaydate){ ?>
            <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-12 pb-24 md:pb-5">
                <div class="bg-gray-800 pt-3">
                    <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
                        <h3 class="font-bold pl-2">Dashboard</h3>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="flex flex-row flex-wrap flex-grow mt-2">
                        <div class="w-full md:w-full xl:w-full p-6">
                            <!--Metric Card-->
                            <div class="bg-gradient-to-b from-grey-200 to-grey-100 border-b-4 border-grey-600 rounded-lg shadow-xl p-5">
                                <div class="items-center">
                                    <form method="post" action="<?php echo site_url('/Vendor_set_startDate_endDate'); ?>" enctype="multipart/form-data">
                                        <div class="flex flex-wrap items-center">
                                            <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                                <div class="form-group">
                                                    <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="date" name="Sesssion_start_Date"  value="<?php echo $Sesssion_start_Date; ?>">
                                                </div> 
                                            </div> 
                                            <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                                <div class="form-group">
                                                    <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="date" name="Sesssion_end_Date"  value="<?php echo $Sesssion_end_Date; ?>">
                                                </div> 
                                            </div> 
                                            <div class="md:w-1/3 justify-center md:justify-start text-white px-2">
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded" name="btnsubmit" value="submit">submit</button>   
                                            </div>
                                        </div>  
                                    </form> 
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>                
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Metric Card-->
                        <div class="bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-xl p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-green-600"><i class="fas fa-comments fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h5 class="font-bold uppercase text-gray-600">Request</h5>
                                    <h3 class="font-bold text-3xl"><span class="text-green-500"><?= $allmessagerequest;?></span></h3>
                                    <a href="<?php echo base_url('/index.php/allmessagerequest');?>"> <i class="fas fa-arrow-circle-right"></i> </a>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                    </div>
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Metric Card-->
                        <div class="bg-gradient-to-b from-pink-200 to-pink-100 border-b-4 border-pink-500 rounded-lg shadow-xl p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-pink-600"><i class="fas fa-ban fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h5 class="font-bold uppercase text-gray-600">Rejected Bill</h5>
                                    <h3 class="font-bold text-3xl"><span class="text-pink-500"><?= $BillMappingRejectcount+$ClearBillFormRejectcount+$ERPSystemBillRejectcount+$RecivedBillRejectcount; ?></span></h3>
                                    <a href="<?php echo base_url('/index.php/all-vendor-rejected-list');?>"> <i class="fas fa-arrow-circle-right"></i> </a>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                    </div>
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Metric Card-->
                        <div class="bg-gradient-to-b from-yellow-200 to-yellow-100 border-b-4 border-yellow-600 rounded-lg shadow-xl p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-yellow-600"><i class="fas fa-list-alt fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h5 class="font-bold uppercase text-gray-600">Completed Bill</h5>
                                    <h3 class="font-bold text-3xl"><span class="text-yellow-600"><?= $RecivedBillDonecount;?></span></h3>
                                    <a href="<?php echo base_url('/index.php/all-bill-vendor-completed-list');?>"> <i class="fas fa-arrow-circle-right"></i> </a>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                    </div>
                </div>
                <div class="flex flex-row flex-wrap flex-grow mt-2">
                    <div class="w-full md:w-1/2 xl:w-1/2 p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h5 class="font-bold uppercase text-gray-600">Recent Bill Added</h5>
                            </div>
                            <div class="p-5">
                                <table class="border-separate border-spacing-2 w-full p-1 text-gray-700 table-auto hover:table-auto">
                                    <thead>
                                        <tr>
                                            <th class="border border-slate-300 p-2">Sl No</th>
                                            <th class="border border-slate-300 p-2"><b>Company Name</b></th>
                                            <th class="border border-slate-300 p-2"><b>Total No. Of Bill</b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill Updated </b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $result = $session->get();
                                    $etm = $result['ddn'];  
                                    $i=0+$etm;
                                    if(isset($dax)){
                                        foreach ($dax as $row){
                                            $i = $i+1;
                                            ?>
                                            <tr>
                                                <td class="border border-slate-300 p-2"><?php echo $i; ?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['companyname'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['bcount'];?></td>
                                                <td class="border border-slate-300 p-2"><a href="<?php echo base_url('/index.php/all-vendor-bill-compnay-wise/'.$row["compeny_id"]);?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i class="fas fa-rupee-sign"></i> <?php echo $row['bamt'];?></a></td>
                                            </tr> 
                                        <?php } 
                                        } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 xl:w-1/2 p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <h5 class="font-bold uppercase text-gray-600">Debit Note</h5>
                            </div>
                            <div class="p-5">
                                <?php
                                if(session()->has("debitnoteupdate"))
                                {   
                                    if(session("debitnoteupdate")==1)   
                                    {  
                                            echo "<div class='alert alert-success' role='alert' style='color:white;background:green;width:100%;padding:5px 10px;'>Debit Note Updated</div>";
                                    }
                                } ?>
                                <table class="border-separate border-spacing-2 w-full p-1 text-gray-700 table-auto hover:table-auto">
                                    <thead>
                                        <tr>
                                            <th class="border border-slate-300 p-2">Sl No</th>
                                            <th class="border border-slate-300 p-2"><b>Company Name</b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill No.</b></th>
                                            <th class="border border-slate-300 p-2"><b>Image</b></th>
                                            <th class="border border-slate-300 p-2"><b>Remark</b></th>
                                            <th class="border border-slate-300 p-2"><b>Action</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    if (!empty($debitnote) && is_array($debitnote)): 
                                        $i=0;
                                        foreach ($debitnote as $row): 
                                            $i=$i+0;
                                            if(isset($_GET['page']))
                                            {
                                                $ii=($_GET['page']*10)+$i+1;
                                            }
                                            else
                                            {
                                                $ii=$i+1;
                                            }
                                            ?>
                                            <tr>
                                                <td class="border border-slate-300 p-2"><?php echo $ii; ?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['companyname'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Bill_No'];?></td>
                                                <td class="border border-slate-300 p-2"><?php 
                                                    if(!empty($row['Send_Vendor_Note_Image'])){ ?>
                                                    <a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Send_Vendor_Note_Image']);?>" target="_blank"><?php if(!empty($row['Send_Vendor_Note_Image'])) { ?>link<?php } ?></a>
                                                    <?php } ?>
                                                </td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Send_Note_Vendor_Remark'];?></td>
                                                <td class="border border-slate-300 p-2">
                                                    <button class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" data-modal-toggle="authentication-modal<?php echo $row['id'];?>">
                                                        <i class="fas fa-plus fa-inverse"></i>
                                                    </button>
                                                </td>
                                            </tr> 
                                            <div id="authentication-modal<?php echo $row['id'];?>" aria-hidden="true" class="hidden overflow-x-hidden overflow-y-auto fixed h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <!-- Modal content -->
                                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                        <!-- Modal header -->
                                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                                Add Comment
                                                            </h3>
                                                            <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="authentication-modal<?php echo $row['id'];?>">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                                </svg>
                                                                <span class="sr-only">Close modal</span>
                                                            </button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <div class="p-4 md:p-5">
                                                            <form class="space-y-4" action="<?php echo site_url('/update-bill-debit-note-by-vendor'); ?>" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                <div>
                                                                    <label for="billpic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bill Pic<span style="color:red;">*</span></label>
                                                                    <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="file" name="E_Image"  id="billpic">
                                                                </div> 
                                                                <div>
                                                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Comment</label>
                                                                    <textarea id="message" name="yourcomment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                                                </div>
                                                                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-2">Send Messages</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                            $i=$i+1;
                                            ?>
                                        <?php endforeach; ?>
                                    
                                    <?php else: ?>
                                        <p></p>
                                    <?php endif; ?>        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>     
                <?php include('include/vendor-footer.php')?>
                <!-- page-body-wrapper ends -->
            </div>
            <?php } 
            else{
            ?>
            <!--
            Include Tailwind JIT CDN compiler
            More info: https://beyondco.de/blog/tailwind-jit-compiler-via-cdn
            -->
            <script src="https://unpkg.com/tailwindcss-jit-cdn"></script>
            
            <!-- Specify a custom Tailwind configuration -->
            <script type="tailwind-config">
            {
              theme: {
                extend: {
                  colors: {
                    gray: colors.blueGray,
                  }
                }
              }
            }
            </script>

            <!-- Snippet -->
            <section class="w-full flex flex-col justify-center antialiased bg-gray-50 text-gray-600 min-h-screen p-4">
                <div class="">
                    <!-- Card -->
                    <div class="max-w-2xl mx-auto bg-indigo-600 shadow-lg rounded-lg">
                        <div class="px-6 py-5">
                            <div class="flex items-start">
                                <!-- Icon -->
                                <svg class="fill-current flex-shrink-0 mr-5" width="30" height="30" viewBox="0 0 30 30">
                                    <path class="text-indigo-300" d="m16 14.883 14-7L14.447.106a1 1 0 0 0-.895 0L0 6.883l16 8Z" />
                                    <path class="text-indigo-200" d="M16 14.619v15l13.447-6.724A.998.998 0 0 0 30 22V7.619l-14 7Z" />
                                    <path class="text-indigo-500" d="m16 14.619-16-8V21c0 .379.214.725.553.895L16 29.619v-15Z" />
                                </svg>
                                <!-- Card content -->
                                <div class="flex-grow truncate">
                                    <!-- Card header -->
                                    <div class="w-full sm:flex justify-between items-center mb-3">
                                        <!-- Title -->
                                        <h2 class="text-2xl leading-snug font-extrabold text-gray-50 truncate mb-1 sm:mb-0">Welcome to Supplier Relationship Management</h2>
                                        <!-- Like and comment buttons -->
                                    </div>
                                    <!-- Card body -->
                                    <div class="flex items-end justify-between whitespace-normal">
                                        <!-- Paragraph -->
                                        <div class="max-w-md text-indigo-100">
                                            <p class="mb-2">Congratulations on successfully signing up with [Your Company Name]! We're thrilled to have you as part of our community, and your account is now just a step away from being fully activated. To activate your account and unlock the full range of features, simply follow these quick steps:</p>
                                        </div>
                                        <!-- More link -->
                                        <a class="flex-shrink-0 flex items-center justify-center text-indigo-600 w-10 h-10 rounded-full bg-gradient-to-b from-indigo-50 to-indigo-100 hover:from-white hover:to-indigo-50 focus:outline-none focus-visible:from-white focus-visible:to-white transition duration-150 ml-2" href="<?php echo base_url('/index.php/choose-payment');?>">
                                            <span class="block font-bold"><span class="sr-only">Activate Now</span> -></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- More components -->
            <div x-show="open" class="fixed bottom-0 right-0 w-full md:bottom-8 md:right-12 md:w-auto z-60" x-data="{ open: true }">
                <div class="bg-gray-800 text-gray-50 text-sm p-3 md:rounded shadow-lg flex justify-between">
                    <div>👉 <a class="hover:underline ml-1" href="#" target="_blank">For more information please contact</a></div>
                    <button class="text-gray-500 hover:text-gray-400 ml-5" @click="open = false">
                        <span class="sr-only">Close</span>
                        <svg class="w-4 h-4 flex-shrink-0 fill-current" viewBox="0 0 16 16">
                            <path d="M12.72 3.293a1 1 0 00-1.415 0L8.012 6.586 4.72 3.293a1 1 0 00-1.414 1.414L6.598 8l-3.293 3.293a1 1 0 101.414 1.414l3.293-3.293 3.293 3.293a1 1 0 001.414-1.414L9.426 8l3.293-3.293a1 1 0 000-1.414z" />
                        </svg>
                    </button>
                </div>
            </div>
            <?php }
        }
        else{ ?>
            <!--
            Include Tailwind JIT CDN compiler
            More info: https://beyondco.de/blog/tailwind-jit-compiler-via-cdn
            -->
            <script src="https://unpkg.com/tailwindcss-jit-cdn"></script>
            
            <!-- Specify a custom Tailwind configuration -->
            <script type="tailwind-config">
            {
              theme: {
                extend: {
                  colors: {
                    gray: colors.blueGray,
                  }
                }
              }
            }
            </script>

            <!-- Snippet -->
            <section class="w-full flex flex-col justify-center antialiased bg-gray-50 text-gray-600 min-h-screen p-4">
                <div class="">
                    <!-- Card -->
                    <div class="max-w-2xl mx-auto bg-indigo-600 shadow-lg rounded-lg">
                        <div class="px-6 py-5">
                            <div class="flex items-start">
                                <!-- Icon -->
                                <svg class="fill-current flex-shrink-0 mr-5" width="30" height="30" viewBox="0 0 30 30">
                                    <path class="text-indigo-300" d="m16 14.883 14-7L14.447.106a1 1 0 0 0-.895 0L0 6.883l16 8Z" />
                                    <path class="text-indigo-200" d="M16 14.619v15l13.447-6.724A.998.998 0 0 0 30 22V7.619l-14 7Z" />
                                    <path class="text-indigo-500" d="m16 14.619-16-8V21c0 .379.214.725.553.895L16 29.619v-15Z" />
                                </svg>
                                <!-- Card content -->
                                <div class="flex-grow truncate">
                                    <!-- Card header -->
                                    <div class="w-full sm:flex justify-between items-center mb-3">
                                        <!-- Title -->
                                        <h2 class="text-2xl leading-snug font-extrabold text-gray-50 truncate mb-1 sm:mb-0">Welcome to Supplier Relationship Management</h2>
                                        <!-- Like and comment buttons -->
                                    </div>
                                    <!-- Card body -->
                                    <div class="flex items-end justify-between whitespace-normal">
                                        <!-- Paragraph -->
                                        <div class="max-w-md text-indigo-100">
                                            <p class="mb-2">Congratulations on successfully signing up with [Your Company Name]! We're thrilled to have you as part of our community, and your account is now just a step away from being fully activated. To activate your account and unlock the full range of features, simply follow these quick steps:</p>
                                        </div>
                                        <!-- More link -->
                                        <a class="flex-shrink-0 flex items-center justify-center text-indigo-600 w-10 h-10 rounded-full bg-gradient-to-b from-indigo-50 to-indigo-100 hover:from-white hover:to-indigo-50 focus:outline-none focus-visible:from-white focus-visible:to-white transition duration-150 ml-2" href="<?php echo base_url('/index.php/choose-payment');?>">
                                            <span class="block font-bold"><span class="sr-only">Activate Now</span> -></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- More components -->
            <div x-show="open" class="fixed bottom-0 right-0 w-full md:bottom-8 md:right-12 md:w-auto z-60" x-data="{ open: true }">
                <div class="bg-gray-800 text-gray-50 text-sm p-3 md:rounded shadow-lg flex justify-between">
                    <div>👉 <a class="hover:underline ml-1" href="#" target="_blank">For more information please contact</a></div>
                    <button class="text-gray-500 hover:text-gray-400 ml-5" @click="open = false">
                        <span class="sr-only">Close</span>
                        <svg class="w-4 h-4 flex-shrink-0 fill-current" viewBox="0 0 16 16">
                            <path d="M12.72 3.293a1 1 0 00-1.415 0L8.012 6.586 4.72 3.293a1 1 0 00-1.414 1.414L6.598 8l-3.293 3.293a1 1 0 101.414 1.414l3.293-3.293 3.293 3.293a1 1 0 001.414-1.414L9.426 8l3.293-3.293a1 1 0 000-1.414z" />
                        </svg>
                    </button>
                </div>
            </div>
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
        <?php }
        ?>
        
        <!-- container-scroller -->
        <?php include('include/script.php'); ?>
    </body>
</html>