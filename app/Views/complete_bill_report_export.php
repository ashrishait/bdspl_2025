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
   $MasterActionModelObj = new MasterActionModel();

   
   ?>

<!DOCTYPE html>
<html>
<head>
<title></title>

<style>

    </style>
</head>
<body>

<?php 

$html = '<table style="border:1px solid black;">
 <tr  style="border:1px solid black;">
    <td>#</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="border: none;"> <center><b>Assignment</b> </center></td>
    <td style="border: none;"> </td>
    <td style="border: none;"></td>
    <td style="border: none;"></td>
    <td style="border-right: none;"><center><b>Bill.Verify</b> </center></td>
    <td style="border: none;"></td>
    <td style="border: none;"></td>
    <td  style="border-right: none;"><center><b>Bill.Entry</b> </center></td>
    <td style="border: none;"></td>
    <td style="border: none;"></td>
    <td  style="border-right: none;"><center><b>Bill.Received </b> </center></td>
    <td style="border: none;"></td>
    <td style="border: none;"></td>
</tr>

<tr  style="border:1px solid black;">
    <th>#</th>
    <th><b>Add By Name & Id </b> </th>
    <th><b>Bill.Pic</b></th>
    <th><b>Unit</b></th>
    <th><b>U.Id</b></th>
    <th><b>Vendor</b></th>
    <th><b>Bill No</b></th>
    <th><b>BillDate</b></th>
    <th><b>Gate Entry No</b></th>
    <th><b>Gate Entry Date</b></th>
    <th><b>Bill Type</b></th>
    <th><b>Amount</b></th>
    <th><b>Accept Date</b> </th>
    <th><b>Accept By Name & Ids</b></th>
    <th><b>Assign By Name & Ids </b></th>
    <th><b>Assign To Name & Ids</b></th>
    <th><b>Accept Date</b></th>
    <th><b> Master Action Name & Ids</b></th>
    <th><b>Send  By Name & Ids</b></th>
    <!--<th><b>Send Id To</b></th>-->
    <th><b>Accept Date </b></th>
    <th><b> Master Action Name & Ids </b></th>
    <th><b>Send Id By Name & Ids </b></th>
    <th><b>Accept Date </b></th>
    <th><b> Master Action Name & Ids </b></th>
    <th><b>Compelet By Name & Ids </b></th>

</tr>';

    $i=0;
    if(isset($dax)){
       foreach ($dax as $row){
          $i = $i+1;
          $MappingEmprow= $EmployeeModelObj->where('id',$row['Add_By'])->first();
            if(isset($MappingEmprow) && $MappingEmprow!='')
            {
              
               $Add_By=$MappingEmprow['first_name']. ' '.$MappingEmprow['last_name']. ' , '.$MappingEmprow['email'];
            }
            else
            {
              $Add_By='';  
            }   

            $Bill_Pic =base_url('public/vendors/PicUpload/'.$row['Bill_Pic']);
            $Unitrow= $UnitModelObj->where('id',$row['Unit_Id'])->first();
            if(isset($Unitrow) && $Unitrow!='')
            {
                $Unit_Name=$Unitrow['name']; 
            }
            else{
               $Unit_Name='';
            }

            $Vendorrow= $PartyUserModelObj->where('id',$row['Vendor_Id'])->first();
            if(isset($Vendorrow) && $Vendorrow!='')
            {
                $Vendor_Name= $Vendorrow['Name']; 
            } 
            else
            {
                $Vendor_Name='';
            }

            $Bill_DateTime=   date('d/m/Y', strtotime($row['Bill_DateTime']));
            $gateentry_DateTime=   date('d/m/Y', strtotime($row['Gate_Entry_Date']));

            $MappingEmprow= $EmployeeModelObj->where('id',$row['Bill_Acceptation_Status_By_MasterId'])->first();
            if(isset($MappingEmprow) && $MappingEmprow!='')
            {
                $Bill_Acceptation_Status_By_MasterId= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name']. ' , '.$MappingEmprow['email'];
            }   
            else{
                $Bill_Acceptation_Status_By_MasterId= '';
            } 

            $MappingEmprow= $EmployeeModelObj->where('id',$row['Mapping_By_MasterId'])->first();
            if(isset($MappingEmprow) && $MappingEmprow!='')
            {
               $Mapping_By_MasterId= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'].' , '.$MappingEmprow['email'];
            } 
            else{
                $Mapping_By_MasterId='';
            }

            $MappingEmprow= $EmployeeModelObj->where('id',$row['Department_Emp_Id'])->first();
            if(isset($MappingEmprow) && $MappingEmprow!='')
            {
                $Department_Emp_Id= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'].' , '.$MappingEmprow['email'];
            }
            else{
                $Department_Emp_Id='';
            }

            $MappingEmprow= $EmployeeModelObj->where('id',$row['MasterId_By_Clear_Bill_Form'])->first();
            if(isset($MappingEmprow) && $MappingEmprow!='')
            {
                $MasterId_By_Clear_Bill_Form= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'].' , '.$MappingEmprow['email'];
            } 
            else{
                    $MasterId_By_Clear_Bill_Form='';
            } 

            $MappingEmprow= $EmployeeModelObj->where('id',$row['Mapping_ERP_EmpId_By_MasterId'])->first();
            if(isset($MappingEmprow) && $MappingEmprow!='')
            {
                $Mapping_ERP_EmpId_By_MasterId= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'].' ,'.$MappingEmprow['email'];
            }
            else{
                $Mapping_ERP_EmpId_By_MasterId='';
            }

             $MappingEmprow= $EmployeeModelObj->where('id',$row['ERP_Status_Change_By_MasterId'])->first();
            if(isset($MappingEmprow) && $MappingEmprow!='')
            {
                $ERP_Status_Change_By_MasterId= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'].' , '.$MappingEmprow['email'];
            } 
            else{
                $ERP_Status_Change_By_MasterId='';
            }  

              $MappingEmprow= $EmployeeModelObj->where('id', $row['Mapping_Account_By_MasterId'])->first();
            if(isset($MappingEmprow) && $MappingEmprow!='')
            {
                $Mapping_Account_By_MasterId= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'].' , '.$MappingEmprow['email'];
            } 
            else  {
                $Mapping_Account_By_MasterId='';
            } 

             $MappingEmprow= $EmployeeModelObj->where('id',$row['Recived_Status_Change_By_MasterId'])->first();
            if(isset($MappingEmprow) && $MappingEmprow!='')
            {
                $Recived_Status_Change_By_MasterId= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'].' , '.$MappingEmprow['email'];
            }   
            else{
                $Recived_Status_Change_By_MasterId='';
            }  

            $MappingEmprow= $EmployeeModelObj->where('id',$row['Recived_Completed_By_MasterId'])->first();
            if(isset($MappingEmprow) && $MappingEmprow!='')
            {
                $Recived_Completed_By_MasterId= $MappingEmprow['first_name'].' '.$MappingEmprow['last_name'].' '.$MappingEmprow['email'];
            }
            else{
                $Recived_Completed_By_MasterId='';
            }    

            $billtyperow= $BillTypeModelObj->where('id',$row['Bill_Type'])->first();
            if(isset($billtyperow) && $billtyperow!='')
            {
                $billtypeexport = $billtyperow['name']; 
            }
            else{
                $billtypeexport = '';
            }


     $html.='<tr style="border:1px solid black;">
            <td ><center>'.$i.'</center></td>
            <td><center>'.$Add_By .'</center></td>
            <td><center><a href='.$Bill_Pic.'>Link</a></center></td>
            <td><center>'.$Unit_Name.'</center></td>
            <td><center>'.$row['uid'].'</center></td>
            <td><center>'.$Vendor_Name.'</center></td>
            <td><center>'.$row['Bill_No'].'</center></td>
            <td><center>'.$Bill_DateTime.'</center></td>
            <td><center>'.$row['Gate_Entry_No'].'</center></td>
            <td><center>'.$gateentry_DateTime.'</center></td>
            <td><center>'.$billtypeexport.'</center></td>
            <td><center>'.$row['Bill_Amount'].'</center></td>
            <td><center>'.$row['Bill_Acceptation_DateTime'].'</center></td>
            <td><center>'.$Bill_Acceptation_Status_By_MasterId.'</center></td>
            <td><center>'.$Mapping_By_MasterId.'</center></td>
            <td><center>'.$Department_Emp_Id.'</center></td>
            <td><center>'.$row['Clear_Bill_Form_DateTime'].'</center></td>
            <td><center>'.$MasterId_By_Clear_Bill_Form.'</center></td>
            <td><center>'.$Mapping_ERP_EmpId_By_MasterId.'</center></td>
            <td><center>'.$row['ERP_DateTime'].'</center></td>
            <td><center>'.$ERP_Status_Change_By_MasterId .'</center></td>
            <td><center>'.$Mapping_Account_By_MasterId .'</center></td>
            <td><center>'.$row['Recived_DateTime'].'</center></td>
            <td><center>'.$Recived_Status_Change_By_MasterId.'</center></td>
           <td><center>'.$Recived_Completed_By_MasterId.'</center></td>
        </tr> '; 
         } 
     } 

$html.='</table>';
header('Content-Type:application/xls');
header('Content-Disposition:attatchment;filename=file.xls');
echo $html;


?>

</table>

</body>
</html>