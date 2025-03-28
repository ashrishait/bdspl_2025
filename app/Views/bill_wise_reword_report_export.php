<?php 
   use App\Models\StateModel; 
   use App\Models\CityModel;
   use App\Models\PartyUserModel;
   use App\Models\EmployeeModel;
   use App\Models\BillRegisterModel;
   use App\Models\CompenyModel;
   use App\Models\RewardPointModel;   
   $EmployeeModelObj = new EmployeeModel();
   $BillRegisterModelObj = new BillRegisterModel();
   $state = new StateModel();
   $city = new CityModel();  
   $CompenyModelObj = new CompenyModel();  
   $RewardPointModelObj = new RewardPointModel();        

  

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
      <th>#</th>
      <th class="bg-warning"><b>Bill Id </b></th>
      <th><b>UID  </b></th>
      <th><b>Compeny Name  </b></th>
     <th><b>Bill Status</b></th>
     <th><b>Total Reword</b></th>
     <th><b>Reword Details</b></th>

</tr>';

    $i=0;
    if(isset($dax)){
       foreach ($dax as $row){
          $i = $i+1;
          

            $compenyrow= $CompenyModelObj->where('id',$row['compeny_id'])->first();
            if(isset($compenyrow) && $compenyrow!='')
            {
              $compenyName= $compenyrow['name']; 
            }
            else
            {
                  $compenyName= '';  
            }
              if($row['Recived_Status']=='1'){
              $Recived_Status='Pending';
              }
               elseif($row['Recived_Status']=='2'){
              $Recived_Status= 'Accepected';
              }
              elseif($row['Recived_Status']=='3'){
                $Recived_Status= 'Reject';
              }
              elseif($row['Recived_Status']=='4'){
                 $Recived_Status= 'Done';
              }
              else
              {
               $Recived_Status= '';

              }

               $resultl2 = $RewardPointModelObj->select('sum(reward_point) as reward_point2')->where('bill_id', $row['id'])->first();
                      $TotalReword=$resultl2['reward_point2'];
             
     $html.='<tr style="border:1px solid black;">
            <td ><center>'.$i.'</center></td>
           
            <td><center>'.$row['id'].'</center></td>
         
            <td><center>'.$row['uid'].'</center></td>
            <td><center>'.$compenyName.'</center></td>
          
            <td><center>'.$Recived_Status.'</center></td>
            <td><center>'.$TotalReword.'</center></td>
            <td>

            <table>
               ' ; if($i==1) {$html.='
             <tr  style="border:.5px solid black;">
                                    
                                      
              <th><b> Empolyee Name </b></th>
              <th><b>Reward Point</b></th>
              <th><b>Reward Point Type</b></th>
              <th><b>Bill Date</b></th>
              <th><b>Reward Date</b></th>
              <th><b>Reward Status</b></th>
           </tr>
            ' ; } 
                $dax1 = $RewardPointModelObj->where('bill_id',$row['id'])->findAll();
                   if(isset($dax1)){
                   foreach ($dax1 as $index => $row2){

                        $Emprow= $EmployeeModelObj->where('id',$row2['emp_id'])->first();
                         if(isset($Emprow) && $Emprow!='')
                         {
                          $EmpName= $Emprow['first_name']." ".$Emprow['last_name'];
                         }
                         else
                         {
                             $EmpName='';
                         }


                       if($row2['status']=='1' && $row2['paid_status']=='1'){
                        $Rewordstatus='Pending';
                      }
                       elseif($row2['status']=='2' && $row2['paid_status']=='1'){
                        $Rewordstatus= 'Unpaid';
                      }
                      elseif($row2['status']=='3' && $row2['paid_status']=='1'){
                        $Rewordstatus= 'Reject';
                      }
                      elseif($row2['status']=='2' && $row2['paid_status']=='2'){
                        $Rewordstatus= 'Paid';
                      }
                      else
                      {
                        $Rewordstatus='';
                      }

                $html.='
            <tr style="border:.5px solid black;">
  
           
            <td><center>'.$EmpName.'</center></td>
         
            <td><center>'.$row2['reward_point'].'</center></td>
            <td><center>'.$row2['reward_point_type'].'</center></td>
            <td><center>'.$row['Bill_DateTime'].'</center></td>
            <td><center>'.$row2['rec_time_stamp'].'</center></td>
          
            <td><center>'.$Rewordstatus.'</center></td>           
             </tr>
              '; 
                   }
               }

            $html.='
              </table>
            </td>
            
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