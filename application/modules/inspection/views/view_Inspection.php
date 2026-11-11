

<?php
//echo "<pre>";
//print_r($InspBasicDet);
//exit;
?>
<style>
.emplDetPhoto{
        border: 1px solid #acc4d8;
        padding: 10px;
        margin: 2%;
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
                                <h4 class="title-head">HSSE Inspection Details </h4>
                                <h3 class="card-title">HSSE Inspection Details</h3>
                                <a href="<?php echo BASE_URL('inspection/Inspectionlist') ?>" class="btn btn-sm btn-primary float-right locatnTyptarget" >Back</a>
                            </div>
                            -->
                            <div class="card-header headingStyl ">

                                    <h4 class="title-head">HSSE Inspection Details </h4>
                                    <a href="<?php echo BASE_URL('inspection/Inspectionlist') ?>"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>

                                </div>


                            <div class="card-body">


                                <div class="invoice p-3 mb-3">
                                    <div class="card-header" style="background: #007bff;">
                                        <h3 class="card-title" style="color: #ffff;">Basic Details</h3>
                                    </div>
                                    <div class="row">


                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped" style="">
                                                <tbody>
                                                    <tr>
                                                        <td><b>Inspection ID</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $InspBasicDet->INSP_ID; ?></td>
                                                        <td><b>Checklist Type</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $InspBasicDet->INSP_CHECK_TYP_NAME; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Inspection Date</b></td>
                                                        <td>:</td>
                                                        <td><?php echo date('d-m-Y', strtotime($InspBasicDet->INSPECTION_DATE)); ?></td>
                                                        <td><b>Inspected By</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $InspBasicDet->hsseName; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Next Inspection Date</b></td>
                                                        <td>:</td>
                                                        <td><?php echo date('d-m-Y', strtotime($InspBasicDet->NXT_INSP_DATE)); ?></td>
                                                        <td><b>Type of Inspection</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $InspBasicDet->INSP_MOD_NAME_NUM; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Registration No</b></td>
                                                        <td>:</td>
                                                        <td><?php echo  postData($InspBasicDet,'INSP_REG_NUMBER',' -'); ?></td>
                                                        <td><b>Driver/Operator Name</b></td>
                                                        <td>:</td>
                                                        <td><?php echo postData($InspBasicDet,'INSP_DRIVER_OPT_NAME',' -'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>PMA/PMT No</b></td>
                                                        <td>:</td>
                                                        <td><?php echo postData($InspBasicDet,'INSP_PMA_PMT_NO',' -'); ?></td>
                                                        <td><b>PMA/PMT Due Date</b></td>
                                                        <td>:</td>
                                                        <td><?php 
                                                        $basicPmadate = $InspBasicDet->INSP_PMA_PMT_DUE_DATE;
                                                        if($basicPmadate != ''){
                                                        echo date('d-m-Y', strtotime($InspBasicDet->INSP_PMA_PMT_DUE_DATE)); 
                                                        }else{
                                                            echo "-";
                                                        }
                                                        ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Certificate No</b></td>
                                                        <td>:</td>
                                                        <td><?php echo postData($InspBasicDet,'INSP_CERT_NUM',' -'); ?></td>
                                                        <td><b>Colour Code</b></td>
                                                        <td>:</td>
                                                        <td><?php echo postData($InspBasicDet,'INSP_COLOUR_CODE_INS_TYPE',' -'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Terminal</b></td>
                                                        <td>:</td>
                                                        <td><?php echo postData($InspBasicDet,'TERMINAL_NAME',' -'); ?></td>
                                                        <td><b>Department</b></td>
                                                        <td>:</td>
                                                        <td><?php echo postData($InspBasicDet,'DEPT_NAME',' -'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Verified By</b></td>
                                                        <td>:</td>
                                                        <td colspan="4"><?php echo postData($InspBasicDet,'execName',' -'); ?></td>
                                                     </tr>
                                                    <tr>
                                                        <td><b>Description</b></td>
                                                        <td>:</td>
                                                        <td colspan="4"><?php echo postData($InspBasicDet,'INSP_DESC',' -'); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>




                                <div class="invoice p-3 mb-3">
                                    <div class="card-header" style="background: #007bff;">
                                        <h3 class="card-title" style="color:#ffff;text-align:center;">CheckList Details</h3>
                                    </div>
                                    <div class="row">


                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped table-bordered">

                                                <thead style="background: #94960ae0;font-weight: bold;color:#ffff;text-align:center;">
                                                     <tr style="background: #5a5a59 !important;">
                                                        <td style="width:5%">S/No</td>
                                                        <td style="width:40%" >CHECK ITEMS</td>
                                                        <td style="width:30%" colspan="3">RESULT</td>
                                                        <td style="width:30%" >REMARKS</td>
                                                        
                                                    </tr>
                                                    <tr style="background: #5a5a59 !important;">
                                                        <td style="width:5%"></td>
                                                        <td style="width:40%"></td>
                                                        <td style="width:10%">GOOD</td>
                                                        <td style="width:10%">POOR</td>
                                                        <td style="width:10%">N/A</td>
                                                        <td style="width:30%"></td>
                                                    </tr>
                                                   
                                                </thead>

                                            </table>
                                            <table class="table table-striped table-bordered" style="width:100%;text-align:center;">
                                                 <tbody>
                                                
                                                <?php
                                                $i = 1;
                                                $checkData='';
//                                                echo "<pre>";
//                                                print_R($InspectionDet);
//                                                exit;
                                                if(isset($InspectionDet) && !empty($InspectionDet)){
                                                  
                                                foreach ($InspectionDet as $insDKey => $InsData) {
                                                     $chkSubtypname = postData($InsData,'subTyp');
                                                     if($chkSubtypname != ''){
                                                        
                                                    ?>
                                                    <tr style="background-color: #94960ae0 !important;color:#fff;">
                                                            <td></td>
                                                            <td colspan="4" ><b><?php echo $chkSubtypname ?></b></td>
                                                            <td></td>
                                                        </tr>
                                                     <?php  }
                                                    
                                                 
                                                  $chkSubtypdata = postData($InsData,'subTypdata');
                                                  $chkSubtypdataID = postData($InsData,'subTypdataID');
                                                  $chkGoodpoorStat = postData($InsData,'goodPoor');
                                                  $chkStatusremark = postData($InsData,'remaRk');
                                                  $chkImgdesc = postData($InsData,'quesDesc');
                                                  $chkImgPath = postData($InsData,'filePath');
                                                  $chkImgname = postData($InsData,'fileName');
                                                 
                                                  $expSubtypdataid = explode(",",$chkSubtypdataID);
                                                  $expSubtypdatadesc = explode("@",$chkSubtypdata);
                                                  $expGPstatus = explode(",",$chkGoodpoorStat);
                                                  $expGPremark = explode(",",$chkStatusremark);
                                                  $expImagdesc = explode(",",$chkImgdesc);
                                                  $expImagname = explode(",",$chkImgname);
                                                
                                                  $cdIncr = 0;
                                                  $imgInd = 0;
                                                  foreach($expSubtypdataid as $cdKey => $cdVal){
                                                       $bfrKeyval = $cdKey+1;
                                                     $goodChecked = '';
                                                     $poorChecked = '';
                                                     $naChecked = '';
                                                     $attRemark = '';
                                                     $explgooPoorImg = false;
                                                     
                                                     $explgooPoor = explode("@",$expGPstatus[$cdIncr]);
                                                     $explgooPoorRemark = explode("@",$expGPremark[$cdIncr]);
                                                     
                                                      if(!empty($expGPstatus[$cdIncr]) && ($explgooPoor[1] == $cdVal)){
                                                          
                                                              if($explgooPoor[0] == 1){
                                                                   $goodChecked = '<i class="fa fa-check" aria-hidden="true"></i>';
                                                              }elseif($explgooPoor[0] == 2){
                                                                  $poorChecked = '<i class="fa fa-check" aria-hidden="true"></i>';
                                                                  $explgooPoorImg = true;
                                                                 $finalImgdesc = $expImagdesc[$cdIncr];
                                                                 $finalImgdesc = $expImagdesc[$cdIncr];
                                                              }else{
                                                                   $naChecked = '<i class="fa fa-check" aria-hidden="true"></i>';
                                                              }
//                                                         
                                                              if($explgooPoorRemark[0] != ''){
                                                                  $attRemark = $explgooPoorRemark[0];
                                                              }
                                                          $cdIncr++;
                                                      }else{
                                                         $goodChecked = '<i class="fa fa-check" aria-hidden="true"></i>';
                                                      }
                                                      $finalImgdet = $chkImgPath.''.$expImagname[$imgInd];
//                                                   
                                                      ?>
                                                     
                                                    
                                                        <tr>
                                                            <td style="width:5%"><?php echo $bfrKeyval; ?></td>
                                                            <td style="width:40%;text-align: left;"><?php echo $expSubtypdatadesc[$cdKey] ?></td>
                                                            <td style="width:10%"><?php echo $goodChecked; ?></td>
                                                            <td style="width:10%"><?php echo $poorChecked; ?></td>
                                                            <td style="width:10%"><?php echo $naChecked; ?></td>
                                                            <td style="width:30%"><?php echo $attRemark; ?></td>
                                                        </tr>
                                                        <?php if($explgooPoorImg){ ?>
                                                        <tr style="background: #b1cbea;color:#000000;font-weight: bold;">
                                                                <td style="width:50%" colspan="2"> Image</td>
                                                                <td style="width:55%"  colspan="4"> Description</td>
                                                            
                                                        </tr>
                                                        <tr>
                                                                <td style="width:50%" colspan="2"> 
                                                                     <a data-fancybox="gallery" href="<?php echo BASE_URL . $finalImgdet; ?>">
                                                                            <img class="lazy" style="height: 150px;width: 250px;" data-src="<?php echo BASE_URL . $finalImgdet; ?>" >
                                                                        </a>
                                                                </td>
                                                                <td style="width:55%"  colspan="4"> <?php echo $finalImgdesc; ?></td>
                                                            
                                                        </tr>
                                                        <?php 
                                                        $imgInd++;
                                                        } ?>
                                                            
                                                <?php  } 
                                                    ?>
                                               
                                                    
                                                <?php }} ?>
                                                    </tbody>        
                                            </table>
                                        </div>
                                    </div>
                                    
                                     <?php 
                                     
                                        $safunsafStat = postData($InspBasicDet,'INSP_SAFE_UNSAFE');
                                        $labSafestat = (isset($safunsafStat) && ($safunsafStat == 1)) ? 'Safe' : 'Unsafe';
                                         ?>
                                            <div class="row" style='margin-left:20px;text-align:justify;width:90%'>
                                            <div class="col-md-12">
                                               <span style='font-family:helvetica'>&#10004;</span> &nbsp;&nbsp;I have conducted an inspection and hereby declared that the mention tool / equipment / machine is <label> <?php echo $labSafestat; ?> </label> for use during the time of inspection.

                                            </div>
                                        </div>
                                    
                                    <?php if(isset($getAllmoreimages) && !empty($getAllmoreimages)){ ?>
                                    <div class="emplDetPhoto">
                                        <div class="row">
                                        <div class="col-md-10 ">
                                            <b><h5>Image Upload</h5></b>
                                        </div>
                                        </div>
                                            
                                            <div class="clearfix"></div>
                                            
                                        <div class="row appendNewimgs m-l-10 m-t-10">
                                        
                                            <?php
                                                foreach($getAllmoreimages as $amiKey => $amiVal){
                                                    $moreImgname = postData($amiVal,'INSP_NOT_IMG_FILENAME');
                                                    $moreImgpath = postData($amiVal,'INSP_NOT_IMG_FILEPATH');
                                                    $addMorimageloc = $moreImgpath.''.$moreImgname
                                                ?>
                                            
                                       <div class="col-md-4 " style="margin-top:20px;" id="removeImg_<?php echo $amiKey ?>">
                                                <a data-fancybox="gallery" href="<?php echo BASE_URL . $addMorimageloc; ?>">
                                                    <img class="lazy" style="height: 150px;width: 250px;" data-src="<?php echo BASE_URL . $addMorimageloc; ?>" >
                                                </a>
                                            </div>
                                     <?php }  ?>
                                      
                                   
                                     </div>
                                     </div>
                                    <?php } ?>
                                    
                                     <?php if(!empty(postData($InspBasicDet,'INSP_NOTE_DESC'))){ ?>
                                     <div class="row m-t-10" style='margin-left:20px;'>
                                        <div class="col-md-12">
                                            <label><b>NOTE : </b></label>
                                            <?php echo postData($InspBasicDet,'INSP_NOTE_DESC'); ?>
                                        </div>
                                    </div>
                                    <?php } ?>
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

