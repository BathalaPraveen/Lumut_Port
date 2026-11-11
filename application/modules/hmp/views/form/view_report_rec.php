

<?php
//echo "<pre>";
//print_r($getEmploydetails);
//exit;
$REC_ID = postData($editData,'REC_ID');
$REC_NAME = postData($editData,'REC_NAME');
$REC_MOD_NAME = postData($editData,'REC_MOD_NAME');
$REC_DESC = postData($editData,'REC_DESC');
$REC_LOC_NAME = postData($editData,'REC_LOC_NAME');
$EMP_NAME = postData($editData,'EMP_NAME');
$terName = postData($editData,'loc_name');
if($editData->REC_REC_DATE != ''){
$recdate = date('d-m-Y',strtotime($editData->REC_REC_DATE));
}else{
   $recdate = ''; 
}
if($editData->REC_EXP_DATE != ''){
$expdate = date('d-m-Y',strtotime($editData->REC_EXP_DATE));
}else{
   $expdate = ''; 
}
$recStatus = postData($editData,'REC_MAIN_STATUS');

if($emplCertStatus == 1){
    $finStatus = 'Valid';
}else{
    $finStatus = 'Expired';
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
                                <h4 class="card-title">Record Master Details</h4>
                                <a href="<?php echo BASE_URL('hmp/rec/recInfo') ?>" class="btn btn-sm btn-primary float-right locatnTyptarget" ><i class="fa fa-arrow-left"></i> Back</a>
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
                                                        <td width="23%"><b>Record ID</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $REC_ID; ?></td>
                                                        <td width="23%"><b>Record Name</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $REC_NAME; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Terminal</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $terName; ?></td>
                                                        <td width="23%"><b>Record Date</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $recdate; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Expiry Date</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $expdate; ?></td>
                                                        <td width="23%"><b>Model Name/No</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $REC_MOD_NAME; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Location Detail</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $REC_LOC_NAME; ?></td>
                                                        <td width="23%"><b>Recorded By</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $EMP_NAME; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width=""><b>Description</b></td>
                                                        <td>:</td>
                                                        <td width=""><?php echo $REC_DESC; ?></td>
                                                        <td width=""></td>
                                                        <td></td>
                                                        <td width=""></td>
                                                    </tr>
                                                    
                                                 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                
                


                                <div class="invoice p-3 mb-3">
                                    <div class="card-header emplBorder" >
                                        <h3 class="card-title" style="color:#ffff;text-align:center;">Document Details</h3>
                                    </div>
                                    <div class="row">


                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">

                                                <thead style="background: #94960ae0;font-weight: bold;color:#ffff;text-align:center;">
                                                    <tr>
                                                        <td style="width:20%">S/No</td>
                                                        <td style="width:40%">Document</td>
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
                                                     $fileExtn = postData($InsData,'REC_FILE_EXT');
                                                   $bfrKeyval = $insDKey-1;
                                                  
                                                    ?>
                                                <tbody>
                                                   
                                                        <tr>
                                                            <td style="width:20%"><?php echo $i++; ?></td>
                                                            <?php if($InsData->REC_FILENAME != ''){ ?>
                                                            <td style="width:40%">
                                                                 <?php if($fileExtn != '.pdf'){ ?>
                                                                <img src="<?php echo BASE_URL.$InsData->REC_FILE_PATH.''.$InsData->REC_FILENAME; ?>" style="height:15%" alt="<?php echo $InsData->REC_FILENAME; ?>">
                                                                <?php }else{ ?>
                                                                <a href="<?php echo BASE_URL.$InsData->REC_FILE_PATH.''.$InsData->REC_FILENAME; ?>" target="blank"><?php echo $InsData->REC_FILENAME; ?></a>
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



