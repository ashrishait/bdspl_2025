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
                    <h3 class="font-bold pl-2">All Sent Messages</h3>
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
                                <table class="border-separate border-spacing-2 w-full p-1 text-gray-700 table-auto hover:table-auto">
                                    <thead>
                                        <tr>
                                            <th class="border border-slate-300 p-2">Sl No</th>
                                            <th class="border border-slate-300 p-2"><b>Company Name</b></th>
                                            <th class="border border-slate-300 p-2"><b>Bill No.</b></th>
                                            <th class="border border-slate-300 p-2"><b>Comment</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $i=0;
                                    if(isset($recentchatrequest)){
                                        foreach ($recentchatrequest as $row){
                                            $i = $i+1;
                                            ?>
                                            <tr>
                                                <td class="border border-slate-300 p-2"><?php echo $i; ?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['companyname'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Bill_No'];?></td>
                                                <td class="border border-slate-300 p-2"><?php echo $row['Vendor_Comment'];?></td>
                                            </tr> 
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