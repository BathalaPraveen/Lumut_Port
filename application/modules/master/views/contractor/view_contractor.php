

<?php
//echo "<pre>";
//print_r($getEmploydetails);
//exit;
$cntrentID = postData($getEmploydetails,'CONT_ID');
$contName = postData($getEmploydetails,'CONT_NAME');
$cmpnName = postData($getEmploydetails,'CONT_COMPANY');
$cntrGender = postData($getEmploydetails,'GENDER_NAME');
$cntrNation = postData($getEmploydetails,'NATIONALITY_NAME');
$cntrNationother = postData($getEmploydetails,'CONT_NATIONALITY_OTHER');
$cntrDesig = postData($getEmploydetails,'CONT_DESIGNATION');
$cntrMail = postData($getEmploydetails,'CONT_EMAIL_ID');
$cntrPhone = postData($getEmploydetails,'CONT_PHONE_NO');
$emplCertiname = postData($getEmploydetails,'CERT_NAME');
if($getEmploydetails->CERT_START_DATE != ''){
$emplStartdate = date('d-m-Y',strtotime($getEmploydetails->CERT_START_DATE));
}else{
   $emplStartdate = ''; 
}
if($getEmploydetails->CERT_END_DATE != ''){
$emplEnddate = date('d-m-Y',strtotime($getEmploydetails->CERT_END_DATE));
}else{
   $emplEnddate = ''; 
}
$emplCertpath = postData($getEmploydetails,'CERT_PATH');
$emplCertimgname = postData($getEmploydetails,'CERT_FILE_NAME');
$emplCertimgext = postData($getEmploydetails,'CERT_EXT');
$emplCertStatus = postData($getEmploydetails,'CERT_STATUS');
$cntrSpec = postData($getEmploydetails,'CONT_SPECIAL');
$cntrAdres = postData($getEmploydetails,'CONT_ADDRESS');
$cntrCity = postData($getEmploydetails,'CONT_CITY');
$cntrCntry = postData($getEmploydetails,'CONT_COUNTRY');
$cntrPostal = postData($getEmploydetails,'CONT_POSTAL_CODE');
$cntrDOB = date("d-m-Y",strtotime($getEmploydetails->CONT_DOB));
$cntrNRIC = postData($getEmploydetails,'CONT_ID_NUMBER');

if($emplCertStatus == 'Y'){
    $finStatus = 'Eligible';
}else{
    $finStatus = 'Not Eligible';
}
$compCertFilepath = '';
if($emplCertimgname != ''){
    $compCertFilepath = $emplCertpath.$emplCertimgname;
}
?>
<style>
.emplBorder{
        background-color: #007bff;
    }
</style>
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">


                        <!-- general form elements -->
                        <div class="card card-headprimary">

                            <div class="card-header">
                                <h4 class="card-title">Contractor Details</h4>
                                <a href="<?php echo BASE_URL('master/contractor') ?>" class="btn btn-sm btn-primary float-right locatnTyptarget" ><i class="fa fa-arrow-left"></i> Back</a>
                            </div>


                            <div class="card-body">


                                <div class="invoice p-3 mb-3">
                                    <div class="card-header emplBorder" >
                                        <h3 class="card-title" style="color: #ffff;">Basic Details</h3>
                                    </div>
                                    <div class="row">


                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped" style="">
                                                <tbody>
                                                    <tr>
                                                        <td width="23%"><b>Contractor ID</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrentID; ?></td>
                                                        <td width="23%"><b>Company Name</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cmpnName; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Contractor Name</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $contName; ?></td>
                                                        <td width="23%"><b>Gender</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrGender; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Date of Birth</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrDOB; ?></td>
                                                        <td width="23%"><b>Mail ID</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrMail; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Phone Number</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrPhone; ?></td>
                                                        <td width="23%"><b>Address</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrAdres; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Company Specialization</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrSpec; ?></td>
                                                        <td width="23%"><b>Designation</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrDesig; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>NRIC/Passport No</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrNRIC; ?></td>
                                                        <td width="23%"><b>Nationality</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo (isset($cntrNation) && $cntrNation != 'Other') ? $cntrNation : $cntrNationother; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>City</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrCity ; ?></td>
                                                        <td width="23%"><b>Country</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrCntry; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Postal Code</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrPostal; ?></td>
                                                       
                                                    </tr>
                                                 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="invoice p-3 mb-3">
                                    <div class="card-header emplBorder" >
                                        <h3 class="card-title" style="color: #ffff;">Competency Details</h3>
                                    </div>
                                    <div class="row">


                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped" style="">
                                                <tbody>
                                                    <tr>
                                                        <td width="23%"><b>Competency Certificate Name</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $emplCertiname; ?></td>
                                                        <td width="23%"><b>Competency Certificate Status</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $finStatus; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Start Date</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $emplStartdate; ?></td>
                                                        <td width="23%"><b>End Date</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $emplEnddate; ?></td>
                                                    </tr>
                                                    <tr >
                                                        <td width="23%"><b>Competency Certificate</b></td>
                                                        <td >:</td>
                                                        <td >
                                                            <?php 
                                                            if($compCertFilepath != ''){
                                                            if($emplCertimgext != '.pdf'){ ?>
                                                            <img src="<?php echo BASE_URL.$compCertFilepath ?>" style="height: 15%;">
                                                            <?php }else{ ?>
                                                            <a href="<?php echo BASE_URL.$compCertFilepath ?>" target="blank"><?php echo $emplCertimgname; ?></a>
                                                            <?php }} else{ ?>
                                                           
                                                            <?php } ?>
                                                        </td>
                                                        
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>




                                <div class="invoice p-3 mb-3">
                                    <div class="card-header emplBorder" >
                                        <h3 class="card-title" style="color:#ffff;text-align:center;">Other Competency Details</h3>
                                    </div>
                                    <div class="row">


                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">

                                                <thead style="background: #94960ae0;font-weight: bold;color:#ffff;text-align:center;">
                                                    <tr>
                                                        <td style="width:20%">S/No</td>
                                                        <td style="width:20%">Certificate Name</td>
                                                        <td style="width:10%">Start Date</td>
                                                        <td style="width:10%">End Date</td>
                                                        <td style="width:40%">Certificate</td>
                                                    </tr>
                                                </thead>

                                            </table>
                                            <table class="table table-striped" style="width:100%;text-align:center;">
                                                
                                                
                                                <?php
                                                $i = 1;
                                                $checkData='';
//                                                echo "<pre>";
//                                                print_R($getOthercertdet);
//                                                exit;
                                                if(isset($getOthercertdet) && !empty($getOthercertdet)){
                                                foreach ($getOthercertdet as $insDKey => $InsData) {
                                                     $fileExtn = postData($InsData,'CERT_EXT');
                                                   $bfrKeyval = $insDKey-1;
                                                  
                                                    ?>
                                                <tbody>
                                                   
                                                        <tr>
                                                            <td style="width:20%"><?php echo $i++; ?></td>
                                                            <td style="width:20%;"><?php echo $InsData->CERT_NAME; ?></td>
                                                            <td style="width:10%"><?php echo date("d-m-Y",strtotime($InsData->CERT_START_DATE)); ?></td>
                                                            <td style="width:10%"><?php echo date("d-m-Y",strtotime($InsData->CERT_END_DATE)); ?></td>
                                                           <?php if($InsData->CERT_FILE_NAME != ''){ ?>
                                                            <td style="width:40%">
                                                                 <?php if($fileExtn != '.pdf'){ ?>
                                                                <img src="<?php echo BASE_URL.$InsData->CERT_PATH.''.$InsData->CERT_FILE_NAME; ?>" style="height:15%" alt="<?php echo $InsData->CERT_FILE_NAME; ?>">
                                                                <?php }else{ ?>
                                                                <a href="<?php echo BASE_URL.$InsData->CERT_PATH.''.$InsData->CERT_FILE_NAME; ?>" target="blank"><?php echo $InsData->CERT_FILE_NAME; ?></a>
                                                                <?php } ?>
                                                                
                                                            </td>
                                                           <?php }else{ ?>
                                                            <td style="width:40%"> - </td>
                                                           <?php } ?>
                                                        </tr>
                                                        </tbody>
                                                    
                                                <?php }}else{ ?>
                                                       <tr> <td  colspan="4">No data Available<td> </tr>
                                                <?php } ?>
                                                           
                                            </table>
                                        </div>
                                    </div>
                                </div>




                            </div>
                        </div>

                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->



