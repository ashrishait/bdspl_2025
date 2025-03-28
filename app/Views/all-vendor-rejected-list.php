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
use App\Models\MasterActionUploadModel;
$MasterActionUploadModelObj = new MasterActionUploadModel();
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    </head>
    <body>
        <?php include('include/vendor-header.php'); ?>
        <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-12 pb-24 md:pb-5">
            <div class="bg-gray-800 pt-3">
                <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
                    <h3 class="font-bold pl-2">All Rejected Bill</h3>
                </div>
            </div>
            <div class="flex flex-wrap">
                <div class="flex flex-row flex-wrap flex-grow mt-2">
                    <div class="w-full md:w-full xl:w-full p-6">
                        <!--Graph Card-->
                        <div class="bg-white border-transparent rounded-lg shadow-xl">
                            <div class="bg-gradient-to-b from-gray-300 to-gray-100 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                                <button type="button" class="block text-white bg-green-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="exportTableToExcel('myTable', 'table_export')">Export to Excel</button>
                            </div>
                            <div class="p-5">
                                <table class="border-separate border-spacing-2 w-full p-1 text-gray-700 table-auto hover:table-auto" id="myTable">
                                    <thead>
                                        <tr>
                                            <th class="border border-slate-300 p-2">#</th>
                                            <th class="border border-slate-300 p-2"><b>Bill Receive Date</b></th>
                                            <th class="border border-slate-300 p-2"><b>Uid</b></th>
                                            <th class="border border-slate-300 p-2"><b>Company Name</b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill Copy </b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill No. </b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill Amount</b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill Date</b></th>
                                            <th class="border border-slate-300 p-2"><b>Employee Name</b></th>
                                            <th class="border border-slate-300 p-2"><b>Last Comment</b></th> 
                                            <th class="border border-slate-300 p-2"><b>Last Status</b></th>
                                            <th class="border border-slate-300 p-2"><b>Your Comment</b></th>
                                            <th class="border border-slate-300 p-2"><b>Upload</b></th>
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
                                            $Departmentrow= $DepartmentModelObj->where('compeny_id', $compeny_id)->where('id',$row['Department_Id'])->first();
                                            ?>
                                            <tr>
                                                <td class="border border-slate-300 p-2"><?php echo $i; ?></td>
                                                <td class="border border-slate-300 p-2"><?php echo date('d-m-Y H:i:s', strtotime($row['DateTime']))?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['uid'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['companyname'];?></td>
                                                <td class="border border-slate-300 p-2"><a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);?>" target="_blank">link</a></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Bill_No']; ?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Bill_Amount']; ?></td>
                                                <td class="border border-slate-300 p-2"><?php echo date('d-m-Y', strtotime($row['Bill_DateTime']))?></td>
                                                <td class="border border-slate-300 p-2"><?php 
                                                    if($row['Bill_Acceptation_Status']=='1' || $row['Bill_Acceptation_Status']=='2' || $row['Bill_Acceptation_Status']=='3'){ 
                                                        echo $row['first_name']; ?> <?php echo $row['last_name'];
                                                    }
                                                    elseif($row['Bill_Acceptation_Status']=='4' && $row['Clear_Bill_Form_Status']=='1' || $row['Clear_Bill_Form_Status']=='2' || $row['Clear_Bill_Form_Status']=='3'){ 
                                                        $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
                                                        if(isset($MappingEmprow) && $MappingEmprow!='')
                                                        {
                                                          echo $MappingEmprow['first_name']; 
                                                          echo " ".$MappingEmprow['last_name'];
                                                        }
                                                    }
                                                    elseif($row['Clear_Bill_Form_Status']=='4' && $row['ERP_Status']=='1' || $row['ERP_Status']=='2' || $row['ERP_Status']=='3'){ 
                                                        $MappingEmprow= $EmployeeModelObj->where('id',$row['Mapping_ERP_EmpId'])->first();
                                                        if(isset($MappingEmprow) && $MappingEmprow!='')
                                                        {
                                                          echo $MappingEmprow['first_name']; 
                                                          echo " ".$MappingEmprow['last_name'];
                                                        }
                                                    }
                                                    elseif($row['ERP_Status']=='4'){ 
                                                        $MappingEmprow= $EmployeeModelObj->where('id',$row['Mapping_Acount_EmpId'])->first();
                                                        if(isset($MappingEmprow) && $MappingEmprow!='')
                                                        {
                                                          echo $MappingEmprow['first_name']; 
                                                          echo " ".$MappingEmprow['last_name'];
                                                        }
                                                    }
                                                    
                                                    ?>
                                                </td>
                                                <td class="border border-slate-300 p-2">
                                                    <?php if($row['Bill_Acceptation_Status']=='1'){ 
                                                        echo $row['Remark'];
                                                    }
                                                    elseif($row['Bill_Acceptation_Status']=='2'){ 
                                                        echo $row['Bill_Acceptation_Status_Comments'];
                                                    }
                                                    elseif($row['Bill_Acceptation_Status']=='3')
                                                    { 
                                                        echo $row['Bill_Acceptation_Status_Comments'];
                                                    }
                                                    else{ 
                                                        if($row['Clear_Bill_Form_Status']=='1'){ 
                                                           echo $row['Mapping_Remark'];
                                                        }
                                                        elseif($row['Clear_Bill_Form_Status']=='2')
                                                        { 
                                                            $MasterActionmadelObj = new MasterActionModel();
                                                            $rowMasterAction2= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',3)->where('no_of_action',$row['ClearFormBill_Master_Action'])->first();
                                                            
                                                            if(isset($rowMasterAction2) && $rowMasterAction2!='')
                                                            {
                                                                $rowMasterActionUpload= $MasterActionUploadModelObj->where('compeny_id', $compeny_id)->where('bill_id',$row['id'])->where('master_action_id',$rowMasterAction2['id'])->first();
                                                                if(isset($rowMasterActionUpload) && $rowMasterActionUpload!='') {  
                                                                    echo $rowMasterActionUpload['remark'];
                                                                }
                                                                else{
                                                                    echo $row['Clear_Bill_Form_Status_Comments'];
                                                                }
                                                            }
                                                            else{
                                                                
                                                            }
                                                        }
                                                        elseif($row['Clear_Bill_Form_Status']=='3'){
                                                            echo $row['Clear_Bill_Form_Status_Comments'];
                                                        }
                                                        else{ 
                                                            if($row['ERP_Status']=='1'){ 
                                                                echo $row['ERP_Remark']; 
                                                            }
                                                            elseif($row['ERP_Status']=='2'){ 
                                                                $MasterActionmadelObj = new MasterActionModel();
                                                                $rowMasterActionerp= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',4)->where('no_of_action',$row['ERP_Master_Action'])->first();
                                                                if(isset($rowMasterActionerp) && $rowMasterActionerp!='')
                                                                {
                                                                    $rowMasterActionUploaderp= $MasterActionUploadModelObj->where('compeny_id', $compeny_id)->where('bill_id',$row['id'])->where('master_action_id',$rowMasterActionerp['id'])->first();
                                                                    if(isset($rowMasterActionUploaderp) && $rowMasterActionUploaderp!='') {  
                                                                        echo $rowMasterActionUploaderp['remark'];
                                                                    }
                                                                    else{
                                                                        echo $row['ERP_Comment'];
                                                                    }
                                                                }
                                                            }
                                                            elseif($row['ERP_Status']=='3'){ 
                                                                echo $row['ERP_Comment'];
                                                            }
                                                            else{ 
                                                                if($row['Recived_Status']=='1'){ 
                                                                    echo $row['Recived_Remark'];
                                                                }
                                                                elseif($row['Recived_Status']=='2'){ 
                                                                    $MasterActionmadelObj = new MasterActionModel();
                                                                    $rowMasterActionrec= $MasterActionmadelObj->where('compeny_id', $compeny_id)->where('stage_id',5)->where('no_of_action',$row['Recived_Master_Action'])->first();
                                                                    if(isset($rowMasterActionrec) && $rowMasterActionrec!='')
                                                                    {
                                                                        $rowMasterActionUploadrec= $MasterActionUploadModelObj->where('compeny_id', $compeny_id)->where('bill_id',$row['id'])->where('master_action_id',$rowMasterActionrec['id'])->first();
                                                                        if(isset($rowMasterActionUploadrec) && $rowMasterActionUploadrec!='') {  
                                                                            echo $rowMasterActionUploadrec['remark'];
                                                                        }
                                                                        else{
                                                                            echo $row['Recived_Comment'];
                                                                        }
                                                                    }
                                                                    
                                                                }
                                                                elseif($row['Recived_Status']=='3'){ 
                                                                    echo $row['Recived_Comment']; 
                                                                }
                                                                else{ echo "Done"; }
                                                            }
                                                        }
                                                    } ?>
                                                </td>
                                                <td class="border border-slate-300 p-2">
                                                    <?php if($row['Bill_Acceptation_Status']=='1'){ 
                                                        echo "Pending @ Bill Mapper"; ?>
                                                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                            <div class="bg-red-600 h-2.5 rounded-full" style="width: 20%"></div>
                                                        </div>
                                                        <p>1/5</p>
                                                    <?php }
                                                    elseif($row['Bill_Acceptation_Status']=='2'){ 
                                                        echo "Accepted @ Bill Mapper"; ?>
                                                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                            <div class="bg-red-600 h-2.5 rounded-full" style="width: 20%"></div>
                                                        </div>
                                                        <p>1/5</p>
                                                    <?php }
                                                    elseif($row['Bill_Acceptation_Status']=='3')
                                                    { 
                                                        echo "Rejected @ Bill Mapper"; ?>
                                                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                            <div class="bg-red-600 h-2.5 rounded-full" style="width: 20%"></div>
                                                        </div>
                                                        <p>1/5</p>
                                                    <?php }
                                                    else{ 
                                                        if($row['Clear_Bill_Form_Status']=='1'){ 
                                                            echo "Pending  @ Clear Bill Stage"; ?>
                                                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                                <div class="bg-orange-600 h-2.5 rounded-full" style="width: 40%"></div>
                                                            </div>
                                                            <p>2/5</p>
                                                        <?php }
                                                        elseif($row['Clear_Bill_Form_Status']=='2')
                                                        { 
                                                            echo "Accepted  @ Clear Bill Stage"; ?>
                                                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                                <div class="bg-orange-600 h-2.5 rounded-full" style="width: 40%"></div>
                                                            </div>
                                                            <p>2/5</p>
                                                        <?php }
                                                        elseif($row['Clear_Bill_Form_Status']=='3'){
                                                            echo "Rejected  @ Clear Bill Stage"; ?>
                                                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                                <div class="bg-orange-600 h-2.5 rounded-full" style="width: 40%"></div>
                                                            </div>
                                                            <p>2/5</p>
                                                        <?php }
                                                        else{ 
                                                            if($row['ERP_Status']=='1'){ 
                                                                echo "Pending  @ ERP Stage"; ?>
                                                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 60%"></div>
                                                                </div>
                                                                <p>3/5</p>
                                                            <?php }
                                                            elseif($row['ERP_Status']=='2'){ 
                                                                echo "Accepted  @ ERP Stage"; ?>
                                                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 60%"></div>
                                                                </div>
                                                                <p>3/5</p>
                                                            <?php }
                                                            elseif($row['ERP_Status']=='3'){ 
                                                                echo "Rejected  @ ERP Stage"; ?>
                                                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 60%"></div>
                                                                </div>
                                                                <p>3/5</p>
                                                            <?php }
                                                            else{ 
                                                                if($row['Recived_Status']=='1'){ 
                                                                    echo "Pending @ Clear Bill"; ?>
                                                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                                        <div class="bg-green-300 h-2.5 rounded-full" style="width: 80%"></div>
                                                                    </div>
                                                                    <p>4/5</p>
                                                                    
                                                                <?php }
                                                                elseif($row['Recived_Status']=='2'){ 
                                                                    echo "Accepted @ Clear Bill"; ?>
                                                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                                        <div class="bg-green-300 h-2.5 rounded-full" style="width: 80%"></div>
                                                                    </div>
                                                                    <p>4/5</p>
                                                                <?php }
                                                                elseif($row['Recived_Status']=='3'){ 
                                                                    echo "Rejected @ Clear Bill"; ?>
                                                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                                        <div class="bg-green-300 h-2.5 rounded-full" style="width: 80%"></div>
                                                                    </div>
                                                                    <p>4/5</p>
                                                                <?php }
                                                                else{ 
                                                                    echo "Done"; ?>
                                                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-3">
                                                                        <div class="bg-green-800 h-2.5 rounded-full" style="width: 100%"></div>
                                                                    </div>
                                                                    <p>5/5</p>
                                                                <?php }
                                                            }
                                                        }
                                                    } ?>
                                                </td>
                                                <td class="border border-slate-300 p-2">
                                                    <?php echo $row['Vendor_Comment']; ?>
                                                    <button class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" data-modal-toggle="authentication-modal<?php echo $row['id'];?>">
                                                        <i class="fas fa-comments fa-inverse"></i>
                                                    </button>
                                                </td>
                                                <td class="border border-slate-300 p-2"><a href="<?php echo base_url('public/vendors/PicUpload/'.$row['Vendor_Upload_Image']);?>" target="_blank">
                                                    <?php if(!empty($row['Vendor_Upload_Image'])){ echo "link";}?></a>
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
                                                            <form class="space-y-4" action="<?php echo site_url('/update-bill-vendor-comment'); ?>" method="post" enctype="multipart/form-data">
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
                                            <div id="received-modal<?php echo $row['id'];?>" aria-hidden="true" class="hidden overflow-x-hidden overflow-y-auto fixed h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <!-- Modal content -->
                                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                        <!-- Modal header -->
                                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                                Received Payment
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
                                                            <form class="space-y-4" action="<?php echo site_url('/vendor-bill-received'); ?>" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                                
                                                                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-2">Received Payment</button>
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
                        </div>
                    </div>
                </div>    
            </div>
            <?php include('include/vendor-footer.php')?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

            <script>
                function exportTableToExcel(tableId, filename = 'export') {
                    var tableSelect = document.getElementById(tableId);
            
                    // Create a new worksheet
                    var ws = XLSX.utils.table_to_sheet(tableSelect);
            
                    // Create a workbook and add the worksheet
                    var wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            
                    // Save the workbook as an Excel file
                    XLSX.writeFile(wb, filename + '.xlsx');
                }
            </script>
        </div>    
    </body>
</html>