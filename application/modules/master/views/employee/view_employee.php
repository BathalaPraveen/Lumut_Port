<style>
   .emplBorder{
        background-color: #007bff;
    } 
</style>

<?php
//echo "<pre>";
//print_r($getEmploydetails);
//exit;
$emploID = postData($getEmploydetails,'EMP_AUTO_ID');
$emploentID = postData($getEmploydetails,'EMP_ID');
$emplName = postData($getEmploydetails,'EMP_NAME');
$emplGender = postData($getEmploydetails,'GENDER_NAME');
$emplNation = postData($getEmploydetails,'NATIONALITY_NAME');
$emplNationother = postData($getEmploydetails,'EMP_NATIONALITY_OTHER');
$emplDesig = postData($getEmploydetails,'DESIGNATION_NAME');
$emplDept = postData($getEmploydetails,'DEPT_NAME');
$emplTerminal = postData($getEmploydetails,'TERMINAL_NAME');
$emplMail = postData($getEmploydetails,'EMP_EMAIL_ID');
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
                                <h4 class="card-title">Employee Details</h4>
                                <a href="<?php echo BASE_URL('master/employee') ?>" class="btn btn-sm btn-primary float-right locatnTyptarget" ><i class="fa fa-arrow-left"></i> Back</a>
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
                                                        <td width="23%"><b>Employee No</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $emploentID; ?></td>
                                                        <td width="23%"><b>Employee Name</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $emplName; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Gender</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $emplGender; ?></td>
                                                        <td width="23%"><b>Nationality</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo (isset($emplNation) && $emplNation != 'Other') ? $emplNation : $emplNationother; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Designation</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $emplDesig; ?></td>
                                                        <td width="23%"><b>Terminal</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $emplTerminal; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Department</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $emplDept; ?></td>
                                                        <td width="23%"><b>Email ID</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $emplMail; ?></td>
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
                                                        <td colspan="4">
                                                            <?php 
                                                            if($compCertFilepath != ''){
                                                            if($emplCertimgext != '.pdf'){ ?>
                                                            <img src="<?php echo BASE_URL.$compCertFilepath ?>" style="height: 15%;">
                                                            <?php }else{ ?>
                                                            <a href="<?php echo BASE_URL.$compCertFilepath ?>" target="blank"><?php echo $emplCertimgname; ?></a>
                                                            <?php } } else{ ?>
                                                           
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

                                                <thead style="background: #aba90b;font-weight: bold;color:#ffff;text-align:center;">
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



