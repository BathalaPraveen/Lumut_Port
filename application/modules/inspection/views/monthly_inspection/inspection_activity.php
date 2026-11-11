

<?php
//echo "<pre>";
//print_r($activityDet);
//exit;
?>
<style>
    .imgAppend{
        width:60%;
            height: 50%;
    }
    .imgDiv{
        border:1px solid black;
        padding:20px;
    }
    .cmntSpan{
        display:block;
        margin-top:10px;
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

<!--                            <div class="card-header">
                                <h3 class="card-title">Monthly Inspection Details</h3>
                                <a href="<?php echo BASE_URL('inspection/Inspectionlistmonthly') ?>" class="btn btn-sm btn-primary float-right locatnTyptarget" >Back</a>
                            </div>-->
                            
                                <div class="card-header headingStyl ">

                                    <h4 class="title-head"> Inspection Activity </h4>
                                    <a href="<?php echo BASE_URL('inspection/Inspectionlistmonthly') ?>"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>

                                </div>

                            <div class="card-body">


                                <div class="invoice p-3 mb-3">
                                    <div class="card-header" style="background: #007bff;">
                                        <h3 class="card-title" style="color: #ffff;"><?php echo $activityDet[0]->MON_INSP_ID ?></h3>
                                    </div>
                                    <div class="row">


                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped" style="">
                                                <tbody>
                                                    
                                                     <tr>
                                                        <td><b>Inspection prepared by</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $activityDet[0]->HSSEname ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td>
                                                            <?php echo date("d-m-Y H:i:s",strtotime($activityDet[0]->MON_ACT_INSP_HSSE_DATE)); ?>
                                                            
                                                        </td>
                                                    </tr>
                                                    <?php if(isset($activityDet) && !empty($activityDet)){ 
                                                            foreach($activityDet as $acKey => $acVal){
                                                                $reviewName = postData($acVal,'revName');
                                                                $verifyName = postData($acVal,'verifName');
                                                                $approvName = postData($acVal,'apprName');
                                                                $hssEName = postData($acVal,'HSSEname');
                                                                
                                                                $inspAccrej = postData($acVal,'MON_ACT_INSP_ACC_REJ_STATUS');
                                                                if($reviewName != ''){
                                                                    $reviewDate = date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_REVIEW_DATE));
                                                                            if($inspAccrej == 1){
                                                            ?>
                                                    <tr>
                                                        <td><b>Inspection Review approved by</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $reviewName; ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $reviewDate; ?></td>
                                                    </tr>
                                                                <?php }else{ ?>
                                                    <tr>
                                                         <td><b>Inspection Review rejected by</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $reviewName; ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $reviewDate; ?></td>
                                                    </tr>
                                                               <?php }
                                                               if($hssEName != '' && $inspAccrej == '0' && $acKey != 0){ ?>
                                                    <tr>
                                                        <td><b>Inspection Re-prepared by</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $hssEName; ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td>
                                                            <?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_HSSE_DATE)); ?>
                                                           
                                                        </td>
                                                    </tr>
                                                             <?php  }
                                                                } ?>
                                                   <!--hsse-->
                                                   <?php if($hssEName != '' && $inspAccrej == '0' && $acKey != 0){ ?>
                                                    <tr>
                                                        <td><b>Inspection Re-prepared by</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $hssEName; ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td>
                                                            <?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_HSSE_DATE)); ?>
                                                           
                                                        </td>
                                                    </tr>
                                                   <?php } ?>
                                                   <!--verifier-->
                                                 <?php   if($verifyName != ''){
                                                        if($inspAccrej == 1){ ?>
                                                    <tr>
                                                        <td><b>Inspection Verified by</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $verifyName; ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td><?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_VERIFY_DATE)); ?></td>
                                                    </tr>
                                                      <?php  }else{ ?>
                                                    <tr>
                                                        <td><b>Inspection Verify rejected by</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $verifyName; ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td><?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_VERIFY_DATE)); ?></td>
                                                    </tr>
                                                     <?php }
                                                                    
                                                    } ?>
                                                    
                                                    <!--approver-->
                                                    <?php if($approvName != ''){
                                                        if($inspAccrej == 1){ ?>
                                                    <tr>
                                                        <td><b>Inspection Approved by</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $approvName; ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td><?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_APPROVE_DATE)); ?></td>
                                                    </tr>
                                                      <?php  }else{ ?>
                                                    <tr>
                                                        <td><b>Inspection Approve rejected by</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $approvName; ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td><?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_APPROVE_DATE)); ?></td>
                                                    </tr>
                                                     <?php }
                                                    }
                                                              } } ?>
                                                </tbody>
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
<script>
$(document).ready(function(){
        
         $('.lazy').lazy();
         });

</script>
