<?php 
use App\Models\StateModel; 
use App\Models\CityModel;
use App\Models\CreateStyleFabriModel;
use App\Models\CreateStyleAccasseriesModel; 
use App\Models\BillRegisterModel; 
use App\Models\EmployeeModel;
use App\Models\MerchantTypeModel; 
use App\Models\bill_register_create_style_asingModel; 
use App\Models\OriginSourceModel; 
use App\Models\BuyerModel;
use App\Models\GarmentTypeModel;
use App\Models\SeasionYearModel;
$state = new StateModel();
$city = new CityModel();
$CreateStyleFabriobj = new CreateStyleFabriModel();
$BillRegister = new BillRegisterModel();
$modelEmployee = new EmployeeModel();
$MerchantTypeModelObj = new MerchantTypeModel();
$bill_register_create_style_asingModelObj = new bill_register_create_style_asingModel();
$OriginSourceModelObj = new OriginSourceModel();
$BuyerModelObj = new BuyerModel();
$GarmentTypeModelObj = new GarmentTypeModel();
$SeasionYearModelObj = new SeasionYearModel();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
</head>
<body>

 <?php 

  $html = '<table class="table table-striped table-hover table-bordered border-primary text-center">
              <tr>
                                                           <th><b>___#___</b></th>
                                                            <th><b>_________Garment.Pic__________</b></th>
                                                            <th><b>Style No</b></th>
                                                            <th><b>Style Name</b></th>
                                                            <th><b>StyleId/Sr.No.</b></th>
                                                            <th><b>Origin Source</b></th>
                                                            <th><b>MoodBoard Number</b></th>
                                                            
                                                             <th><b>Designer Name</b></th>
                                                             <th><b>Buyer Name</b></th>
                                                             <th><b>Garment Type</b></th>
                                                             <th><b>Marchent</b></th>
                                                             <th><b>Seasion Year</b></th>
                                                             <th><b>Session Year</b></th>
                                                             <th><b>Print</b></th>
                                                             <th><b> Hard Work</b></th>
                                                             <th><b>Computer Embercity</b></th>
                                                         
              </tr>';
            

                                                     
                                                        $i=0;
                                                        if(isset($dax)){
                                                            foreach ($dax as $row){
                                                                
                                                                $i = $i+1;
                                                              $Front_Image= base_url('public/vendors/PicUploadStyleImage/'.$row['Front_Image']);
                                                                  $Back_Image= base_url('public/vendors/PicUploadStyleImage/'.$row['Back_Image']);
                                                                   $Detail_Image= base_url('public/vendors/PicUploadStyleImage/'.$row['Detail_Image']);
                                                                   
                                                             
                                                                            $Asingdata= $bill_register_create_style_asingModelObj->where('Sr_No',$row['Create_Style_Id'])->first();
                                                                            if(isset($Asingdata) && $Asingdata!='')
                                                                            {
                                                                               $Asingdata2=" (Bill Added)";
                                                                            }
                                                                            else
                                                                            {
                                                                                
                                                                                 $Asingdata2= " (Not Added)";
                                                                            }
                                                                             $OriginSourcedagas= $OriginSourceModelObj->where('id',$row['Origin_Source'])->first();
                                                                            if(isset($OriginSourcedagas) && $OriginSourcedagas!='')
                                                                            {
                                                                               $OriginSourcedagasname=$OriginSourcedagas['name'];
                                                                            }
                                                                            
                                                                            $dagas2= $BuyerModelObj->where('id',$row['Buyer_Type'])->first();
                                                                            if(isset($dagas2) && $dagas2!='')
                                                                            {
                                                                                
                                                                               $Buyer_Type= $dagas2['name'];
                                                                            }
                                                                            
                                                                            
                                                                            
                                                                            
                                                                             $dagas= $modelEmployee->where('id',$row['Designer_Type'])->first();
                                                                if(isset($dagas) && $dagas!='')
                                                                {
                                                                   $Designer_Type=$dagas['first_name'].', '.$dagas['last_name'];
                                                                }
                                                                
                                                                
                                                                $dagas3= $GarmentTypeModelObj->where('id',$row['Garment_Type'])->first();
                                                                            if(isset($dagas3) && $dagas3!='')
                                                                            {
                                                                                
                                                                               $Garment_Type= $dagas3['Garment_Type_Name'];
                                                                            }
                                                                
                                                                    $dagas33= $MerchantTypeModelObj->where('id',$row['Marchent'])->first();
                                                                if(isset($dagas33) && $dagas33!='')
                                                                {
                                                                   
                                                                $Merchant=$dagas33['name'];
                                                                }
                                                                else
                                                                {
                                                                 $Merchant='';
                                                                }


                                                                
                                                                    $dagas333= $SeasionYearModelObj->where('id',$row['Seasion_Year'])->first();
                                                                if(isset($dagas333) && $dagas333!='')
                                                                {
                                                                   
                                                                $Seasion_Year=$dagas333['name'];
                                                                }
                                                                else
                                                                {
                                                                 $Seasion_Year='';
                                                                } 
      
                                                             $dagas4= $SeasionYearModelObj->where('id',$row['Session_Year'])->first();
                                                                if(isset($dagas4) && $dagas4!='')
                                                                {
                                                                   
                                                                $Session_Year=$dagas4['name'];
                                                                }
                                                                else
                                                                {
                                                                 $Session_Year='';
                                                                } 
                                                                    $html.='<tr style="height:100px">
                                                                  <td><center>'.$i.'</center></td>
                                                                  <td>
                                                              
                                                                  <a href="'.$Front_Image.'" target="_blank"><img src="'.$Front_Image.'" height="70" width="70" ></a>
                                                                  

                                                                         <a href="'.$Back_Image.'" target="_blank"><img src="'.$Back_Image.'" height="70" width="70"></a>
                                                                          
                                                                          <a href="'.$Detail_Image.'" target="_blank"><img src="'.$Detail_Image.'" height="90" width="90"></a>
                                                                  
                                                                  </td>
                                                                <td><center>'.$row['Style_Number'].'</center></td>
                                                                  <td><center>'.$row['Style_Name'].'</center></td>
                                                                  <td><center>'.$row['Create_Style_Id'].$Asingdata2.'</center></td>
                                                                 <td><center>'.$OriginSourcedagasname.'</center></td>
                                                                <td><center>'.$row['Modal_Based_Number'].'</center></td>
                                                                 
                                                                    <td><center>'.$Designer_Type.'</center></td>
                                                                    <td><center>'.$Buyer_Type.'</center></td>
                                                                    <td><center>'.$Garment_Type.'</center></td>
                                                                     <td><center>'.$Merchant.'</center></td>

                                                                      <td><center>'.$Seasion_Year.'</center></td>
                                                                    <td><center>'.$Session_Year.'</center></td>
                                                                <td><center>'.$row['Print'].'</center></td>
                                                                <td><center>'.$row['Hard_Work'].'</center></td>
                                                                <td><center>'.$row['Computer_Embercity'].'</center></td>
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