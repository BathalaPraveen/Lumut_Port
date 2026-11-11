

<?php
//echo "<pre>";
//print_r($InspBasicDet);
//exit;
$specLtnid = explode(",",postData($InspBasicDet,'MON_INSP_SPE_LOC_ID'));
$specLtnname = postData($InspBasicDet,'specLoctn');
$specLtnother = postData($InspBasicDet,'MON_INSP_SPE_LOC_OTHER');
if(in_array("-1",$specLtnid)){
    $finalSpectlctn = $specLtnname.','.$specLtnother;
}else{
    $finalSpectlctn = $specLtnname;
}
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

                                    <h4 class="title-head">Monthly Inspection Details </h4>
                                    <a href="<?php echo BASE_URL('inspection/Inspectionlistmonthly') ?>"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>

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
                                                        <td><?php echo $InspBasicDet->MON_INSP_ID; ?></td>
                                                        <td><b>Checklist Type</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $InspBasicDet->INSP_CHECK_TYP_NAME; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Inspection Date</b></td>
                                                        <td>:</td>
                                                        <td><?php echo date('d-m-Y', strtotime($InspBasicDet->MON_INSPECTION_DATE)); ?></td>
														 <td><b>Terminal</b></td>
                                                        <td>:</td>
                                                        <td><?php echo postData($InspBasicDet,'TERMINAL_NAME',' -'); ?></td>
													</tr>
													
													 <tr>
                                                        <td><b> Location</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $finalSpectlctn; ?></td>
                                                        <td><b>Inspected By</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $InspBasicDet->EMP_NAME ?></td>
                                                    </tr>
													
													 <tr>
													 <?php if($activityDet[0]->revName !=''){ ?>
                                                        <td><b>Reviewed By</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $activityDet[0]->revName; ?></td>
													 <?php } ?>
													 <?php if($activityDet[0]->verifName !=''){ ?>
                                                        <td><b>Verified By</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $activityDet[0]->verifName; ?></td>
													 <?php }  ?>
                                                    </tr>
													<tr>
													  <?php if($activityDet[0]->apprName !=''){ ?>
                                                        <td><b>Approved By</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $activityDet[0]->apprName; ?></td>
													  <?php }  ?>
                                                      
                                                    </tr>
															
                                                   
                                                </tbody> 
                                            </table>
                                        </div>
                                    </div>
                                </div>




                                <div class="invoice p-3 mb-3">
<!--                                    <div class="card-header" style="background: #15519b;">
                                        <h3 class="card-title" style="color:#ffff;text-align:center;">CheckList Details</h3>
                                    </div>-->
                                    <?php  
//                                    echo "<pre>";
//                                    print_R($InspectionDet);
//                                    exit;
                                    if(isset($InspectionDet) && !empty($InspectionDet)){ 
                                        $i = 1;
                                        $checkData='';
                                        $finalMaxscore = 0;
                                        $finalGivenscore = 0;
										//echo '<pre>';print_r($InspectionDet);exit;
                                        foreach ($InspectionDet as $insDKey => $InsData) {
//                                             $finalMaxscore = $finalMaxscore+$calculateMaxscore;
//                                             $finalGivenscore = $finalGivenscore+$calculateGivenscore;
                                                     $chkSubtypname = postData($InsData,'subTyp');
                                                     
                                                     
                                                     $chkSubtypname = postData($InsData,'subTyp');
                                                       
                                                   
                                                  $chkSubtypdata = postData($InsData,'subTypdata');
                                                 
                                                  $chkSubtypdataID = postData($InsData,'subTypdataID');
                                                  $expRadioSD = explode(",",$InsData->scoreValue);                   
                                                    $expRemark = explode(",",$InsData->remaRk); 
                                                  $chkImgdesc = postData($InsData,'quesDesc');
                                                  $chkImgPath = explode(",",$InsData->filePath);
                                                  $chkImgname = explode(",",$InsData->fileName);
                                                  
                                                   $expSubtypid = postData($editVal,'FK_MON_SUB_CAT_ID'); 
                                                   $editInspectnid = postData($InsData,'FK_MON_INSP_ID'); 
                                                   
//                                           $inspUserstatval = postData($editVal,'INSP_USER_STATUS');                   
                                           
                                           $expinspDetid = explode(",",$editVal->inspDetID); 
                                                 
                                                  $expSubtypdataid = explode(",",$chkSubtypdataID);
                                                  $expSubtypdatadesc = explode("@",$chkSubtypdata);
                                                  
                                                    
                                        ?>
                                    <div class="row">


                                        <div class="col-12 table-responsive">
                                          <?php //   if($chkSubtypname != ''){ ?>
                                            <table class="table table-striped table-bordered">

                                                <thead style="background: #94960ae0;font-weight: bold;color:#ffff;text-align:center;">
                                                     <tr style="background: #5a5a59 !important;">
                                                        <td style="width:5%">S/No</td>
                                                        <td style="width:50%" ><?php echo $chkSubtypname; ?></td>
                                                        <td style="width:10%" >MAX SCORE</td>
                                                        <td style="width:10%" >GIVEN SCORE</td>
                                                        <td style="width:30%" >COMMENTS</td>
                                                    </tr>
                                                </thead>

                                            </table>
                                        <?php // } ?>
                                            <table class="table table-striped table-bordered" style="width:100%;text-align:center;">
                                                 <tbody>
                                                
                                                <?php
                                               
                                                  $goodRadkey = 0;
                                                  $imgInd = 0;
                                                  
                                                  $calculateGivenscore = 0;
                                                  $calculateMaxscore = 0;
                                                  foreach($expSubtypdataid as $cdKey => $cdVal){
                                                       
                                                       $bfrKeyval = $cdKey+1;
                                                     $scoreZero = '';
                                                    $scoreOne = '';
                                                     $scoreTwo = '';
                                                     $scoreThree = '';
                                                     $scoreNA = '';
                                                     $scoreValue = '';
                                                     $attRemark = '';
                                                    $explgooPoorImg = false;
                                                     
                                                    $maximumScore = 3;
//                                                     $explChkListfinal = explode("@",$expchkListid[$goodRadkey]);
                                                     $explFileimg = explode("@",$chkImgname[$goodRadkey]);
                                                     $explScore = explode("@",$expRadioSD[$goodRadkey]);
                                                     $explgooPoorRemark = explode("@",$expRemark[$goodRadkey]);
                                                   
                                                     
                                                       if(!empty($expRadioSD[$goodRadkey]) && ($explScore[1] == $cdVal)){
                                                          
                                                              if($explScore[0] == 0){
                                                                   $scoreValue = '0';
                                                                   
                                                              }
                                                              elseif($explScore[0] == 1){
                                                                   $scoreValue = 1;
                                                                  
                                                              }elseif($explScore[0] == 2){
                                                                  $scoreValue = 2;
                                                                 
                                                              }elseif($explScore[0] == 3){
                                                                  $scoreValue = 3;
                                                                 
                                                              }else{
                                                                   $scoreValue = 'NA';
                                                              }
                                                         $atarloctDetails =  getAtarlocationDet($editInspectnid,$cdVal);
//                                                         echo "<pre>";
//                                                         print_r($atarloctDetails);
                                                         $atarnewLoca = postData($atarloctDetails,'ATAR_SPEC_LOC_ID');
                                                         $atarnewLocaother = postData($atarloctDetails,'ATAR_SPEC_LOC_OTHER');
                                                              if($explgooPoorRemark[0] != ''){
                                                                  $attRemark = $explgooPoorRemark[0];
                                                              }
                                                          $goodRadkey++;
                                                      }else{
                                                         $scoreValue = 3;
                                                      }
                                                      if($explFileimg[1] == $datVal){
                                                          $finalImgdet = $expBfrimgpath[0].''.$explFileimg[0];
                                                          $imageAppend = true;
                                                      }else{
                                                          $finalImgdet = '';
                                                          $imageAppend = false;
                                                      }
                                                      
                                                      if($explChkListfinal[1] == $datVal){
                                                          $checkListeditid = $explChkListfinal[0];
                                                         
                                                      }else{
                                                          $checkListeditid = '';
                                                        
                                                      }
                                                      if($scoreValue != 'NA'){
                                                        $calculateGivenscore = $calculateGivenscore+$scoreValue;
                                                        $calculateMaxscore = $calculateMaxscore+$maximumScore;
                                                      }
                                                     
//                                                   
                                                      ?>
                                                     
                                                    
                                                        <tr>
                                                            <td style="width:5%"><?php echo $bfrKeyval; ?></td>
                                                            <td style="width:50%;text-align: left;"><?php echo $expSubtypdatadesc[$cdKey] ?></td>
                                                            <td style="width:10%">
                                                                <?php if($scoreValue == 'NA'){ 
                                                                    echo $scoreValue;
                                                                }else{ 
                                                                    echo 3;
                                                                } ?>

                                                            </td>
                                                            <td style="width:10%"><?php echo $scoreValue; ?></td>
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
                                                 
                                                     $finalMaxscore = $finalMaxscore+$calculateMaxscore;
                                                     $finalGivenscore = $finalGivenscore+$calculateGivenscore;
                                                    ?>
                                                        <tr>
                                                            <td></td>
                                                            <td><b>Total Points awarded:</b> </td>
                                                            <td><b><?php echo $calculateMaxscore; ?></b></td>
                                                            <td><b><?php echo $calculateGivenscore; ?></b></td>
                                                            <td></td>
                                                        </tr>
                                                 
                                                    </tbody>        
                                            </table>
                                        </div>
                                    </div>
                                    
                                        <?php } 
                                       
                                                        }
                                        
                                        ?>
                                </div>
                                <?php 
                                $percentScore = ($finalGivenscore/$finalMaxscore)*100;
                                $finalPerscore = round($percentScore,0);
                                $perfStatus = monthlyInspperformanceClasify($finalPerscore);
                                ?>
                                <table class="table  table-bordered" style="width:100%;text-align:center;">
                                    <thead style="background: #d6eaef;">
                                        <tr>
                                            <th>Grand Total</th>
                                            <th>Max Score</th>
                                            <th>Score</th>
                                            <th>% Mark</th>
                                            <th>Performance Classification</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="background: <?php echo postData($perfStatus,'color');  ?>">
                                            <td>Total Points</td>
                                            <td><?php echo $finalMaxscore; ?></td>
                                            <td><?php echo $finalGivenscore; ?></td>
                                           
                                            <td><?php echo $finalPerscore; ?></td>
                                            <td><?php echo postData($perfStatus,'status');  ?></td>
                                           
                                        </tr>
                                    </tbody>
                                 </table>
                                
                                <?php 
//                                echo "<pre>";
//                               print_R($InspectionDet);
//                                echo count($InspectionDet[0]->fileName);
//                                exit;
                                if(isset($InspectionDet) && !empty($InspectionDet)){  
                                    $initCheckpic = explode("@",$InspectionDet[0]->fileName);
                                   
                             //   if($initCheckpic[0] != ''){ 
                                    ?>
                                <div class="row" style="margin-top:20px">
                                    <div class="col-md-12">
                                        <h4>PHOTO ATTACHMENTS</h4>
                                    </div>
                                </div>
								 
                                <div class="imgDiv">
								<div>
								<table class="table table-bordered supervisorTable">
								  <thead style="background: #5a5a59;font-weight: bold;color:#ffff;text-align:center;">
								  <th style="width:70%;text-align:center;">Image</th>
								  <th style="width:30%;text-align:center;">Description</th>
								   </thead>
                               </table>
							   </div>
							   
								<div style="padding:7px;">
								  <?php 
									
                                        foreach($InspectionDet as $inKey => $inVal){
                                            $filename = postData($inVal,'fileName');
                                            $imgRemark = postData($inVal,'remaRk');
                                             $expFilename = explode(",",$filename); 
                                           
                                             ?>
                                         <div class="row" style="text-align: center;">
										 
                                      
                                   <table class="table table-bordered supervisorTable">
								 
								   
								   <tbody>
								    <?php 
									
									   foreach($expFilename as $fikey => $fiVal){
                                           
                                            $filepath = 'assets/images/modules/inspection/monthly/';
                                            $expFilenameAt = explode("@",$fiVal);
                                            $expRemark = explode(",",$imgRemark);
                                            $finalFilename = $expFilenameAt[0];
                                            $subtypDataid = $expFilenameAt[1];
                                            $appenImg = '';
                                          
                                            if($finalFilename != ''){
                                            if($finalFilename != ''){
                                                $appenImg = BASE_URL.''.$filepath.''.$finalFilename;
                                            }
                                        ?>
								   <tr>
								   <td style="width:70%;"><img src="<?php echo $appenImg ?>" class="imgAppend"></td>
								   <td style="width:30%;text-align:center;"><span class="cmntSpan"><?php echo $expRemark[$fikey]; ?></span></td>
								   </tr>
								     <?php 
                                            
                                       } } ?>
								   </tbody>
								   </table>
                                       <!-- <div class="col-md-6">
                                            <img src="<?php echo $appenImg ?>" class="imgAppend">
                                        </div>
										
                                      <div class="col-md-3">
									   <span class="cmntSpan"><?php echo $expRemark[$fikey]; ?></span>
									</div> -->
                                          
                                             </div>
                                          <?php  } ?>
								</div>
                                    
                                  
            
                                </div> 
                                <?php } //} ?>
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

