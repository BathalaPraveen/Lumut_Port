<?php


$execDesig = getExecutiveHSSE('drop');


if($getHssemaindatas->INSPECTION_DATE != ''){
    $inspDate = date("d-m-Y",strtotime($getHssemaindatas->INSPECTION_DATE));
}else{
    $inspDate = '';
}

if($getHssemaindatas->NXT_INSP_DATE != ''){
    $inspnextDate = date("d-m-Y",strtotime($getHssemaindatas->NXT_INSP_DATE));
}else{
    $inspnextDate = '';
}

$modelNo = postData($getHssemaindatas,'INSP_MOD_NAME_NUM');
$RegnNo = postData($getHssemaindatas,'INSP_REG_NUMBER');
$driverName = postData($getHssemaindatas,'INSP_DRIVER_OPT_NAME');
$pmatNo = postData($getHssemaindatas,'INSP_PMA_PMT_NO');
if($getHssemaindatas->INSP_PMA_PMT_DUE_DATE !=''){
    $pmatDate = date("d-m-Y",strtotime($getHssemaindatas->INSP_PMA_PMT_DUE_DATE));
}else{
   $pmatDate = ''; 
}
$certifNo = postData($getHssemaindatas,'INSP_CERT_NUM');
$colorCodeval = postData($getHssemaindatas,'INSP_COLOUR_CODE_INS_TYPE');
$inspDescrp = postData($getHssemaindatas,'INSP_DESC');
$terminlID = postData($getHssemaindatas,'INSP_TER_ID');
$deparID = postData($getHssemaindatas,'INSP_DEPT_ID');
$checkLID = postData($getHssemaindatas,'INSP_CHECKLIST_ID');
$verifyID = postData($getHssemaindatas,'INSP_VERIFY_ID');
$verificationStatus = postData($getHssemaindatas,'INSP_APP_STATUS');
$noteDescr = postData($getHssemaindatas,'INSP_NOTE_DESC');

$disabledStat = [];
if($verificationStatus >= 1){
    $disabledStat = ['disabled' => 'disabled'];
    $disabledStattext = 'disabled = disabled';
}
?>

<style>
    .headingStyl{
        margin: 17px 0 0 17px;
        color: #2768ad;
    }
    .card-headprimary{
        border-top: 4px solid #f3b909;
    }
    label.error{
        font-weight:500 !important;
    }
    .with-border{
        background-color:#007bff;
        color:white;
        padding: 8px 0 1px 17px;
    }
    .backBtns{
        float:right !important;
        margin-top:-44px !important;
    }
    .backStylrow{
            background: #5a5a59;
            padding: 8px;
            color: #fff;
            text-align: center;
            font-weight: bold;
    }
    .withoth-border {
        /*background-color: #e6c86a;*/
        background-color: #8fb4ec;
        color: white;
        padding: 8px 0 1px 17px;
    }
    .emplDetoth{
        border: 1px solid #8fb4ec;
        /*margin: 0px 30px;*/
    }
    .head5styl{
            /*text-align: center;*/
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
    }
    .styleBfrhead{
        background: #2768ad;
        padding: 7px;
        color: #fff;
        font-weight: bold;
        margin: 14px;
    }
    .styleBfrdatas{
        border: 1px solid #2768ad;
        margin: -12px 15px 0px 15px;
    }
    disabled{
        cursor: pointer;
    }
    .nodataRow{
        background: #ef1818;
        padding: 10px;
    }
    .subchapDatarej{
        margin-top: 15px;
    }

     .btn{
        font-weight:bold !important;
    }
    .rejctRow{
            border: 2px solid #1e6dab;
            padding: 10px;
    }
    .extraDet .autho{
        margin-top: 20px;
        margin-left: 10px;
    }
/*    .onSelectimg{
        height: 100%;
        width: 100%;
    }*/
    .imgupload{
        width: 100%;
        height: 100%;
    }
    .fileinput img{
        width: 100%;
        height: 100%;
    }
/*    .emplDetoth.subtyPData:last-child {
        border-bottom: 0 !important;
    }*/
   
   /*custom checkbox start*/
   /* Customize the label (the container) */
.container.checkSafety {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 17px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  font-weight: 600 !important;
}

/* Hide the browser's default checkbox */
.container.checkSafety input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border: 3px solid #d6d2d2;
}

/* On mouse-over, add a grey background color */
.container.checkSafety:hover input ~ .checkmark {
  background-color: #ccc;
  border:none !important;
}

/* When the checkbox is checked, add a blue background */
.container.checkSafety input:checked ~ .checkmark {
  background-color: #2196F3;
  border:none !important;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container.checkSafety input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container.checkSafety .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
    /*custom checkbox end*/
    
  .removenewimageset{
        position: absolute;
        top: 0;
        color: #d13838;
        cursor: pointer;
    }
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
                            <div class="row headingStyl">
                                <div class="col-md-12">
                                    <h4> HSSE Inspection</h4>
                                    <a href="<?php echo BASE_URL('inspection/inspectionlist') ?>"><button type="button" class="btn btn-sm btn-primary backBtns"><i class="fa fa-backward"></i> Back</button></a>
                                </div>
                            </div>
                            <div class="card-body">
                                
                                <?php 
                                if(isset($getHssemaindatas->INSP_AUTO_ID) && !empty($getHssemaindatas->INSP_AUTO_ID)){
                                    $urlAutid = encryptval($getHssemaindatas->INSP_AUTO_ID);
                                }else{
                                    $urlAutid = '';
                                }
                                echo form_open_multipart('inspection/saveInspection/'.$urlAutid , 'class="form-horizontal" id="company-profile" novalidate'); ?>

                                <div class="emplDet">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class=""> Basic Details </h5>
                                        </div>

                                    </div>
                                </div>

                                <div class="row m-t-10 m-l-10 m-r-10">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Inspection ID <span class="error"> * </span></label>
                                            <?php
                                            
                                            $inspIDdatas = [
                                                'name' => 'inspec[inspec_id]',
                                                'id' => 'inspec_id',
                                                'class' => 'form-control',
                                                'value' => $inspidUniq,
                                                'required' => true,
                                                'autocomplete' => 'off',
                                                'readonly' => true,
                                            ];
                                            echo form_input($inspIDdatas);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Inspection Date <span class="error"> * </span></label>
                                            <?php
                                            $inspDatedata = array(
                                                'name' => 'inspec[insp_date]',
                                                'id' => 'insp_date',
                                                'class' => 'form-control singledaterangepicker',
                                                'required' => true,
                                                'autocomplete' => 'off',
                                                'value' => $inspDate
                                            );
                                            $fininspDatedata = array_merge($inspDatedata,$disabledStat);
                                            echo form_input($fininspDatedata);
                                            ?>
                                         </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Inspected By <span class="error"> * </span></label>
                                            <?php
                                            $inspBydata = array(
                                                'name' => 'inspec[insp_by]',
                                                'id' => 'insp_by',
                                                'class' => 'form-control',
                                                'value' => $sessUser,
                                                'readonly' => true,
                                                'autocomplete' => 'off'
                                            );

                                            echo form_input($inspBydata);
                                            ?>
                                        </div>
                                    </div>

                                </div>
                                    
                                 <div class="row m-t-10 m-l-10 m-r-10">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Next Inspection Date <span class="error"> * </span></label>
                                            <?php
                                            
                                            $inspNextdatedatas = [
                                                'name' => 'inspec[next_inspDate]',
                                                'id' => 'next_inspDate',
                                                'class' => 'form-control singledaterangepickerafter',
                                                'value' => $inspnextDate,
                                                'required' => true,
                                                'autocomplete' => 'off',
                                               
                                            ];
                                           $fininspNextdatedatas = array_merge($inspNextdatedatas,$disabledStat);
                                            echo form_input($fininspNextdatedatas);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Type of Inspection <span class="error"> * </span></label>
                                            <?php
                                            $inspModalnodata = array(
                                                'name' => 'inspec[modal_no]',
                                                'id' => 'modal_no',
                                                'class' => 'form-control',
                                                'required' => true,
                                                'autocomplete' => 'off',
                                                'value' => $modelNo
                                            );
                                            $fininspModalnodata = array_merge($inspModalnodata,$disabledStat);
                                            echo form_input($fininspModalnodata);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Registration No </label>
                                            <?php
                                            $inspRegnodata = array(
                                                'name' => 'inspec[reg_no]',
                                                'id' => 'reg_no',
                                                'class' => 'form-control',
                                                'value' => $RegnNo,
                                                'autocomplete' => 'off'
                                            );
                                            $fininspRegnodata = array_merge($inspRegnodata,$disabledStat);
                                            echo form_input($fininspRegnodata);
                                            ?>
                                         </div>
                                    </div>

                                </div>
                                <div class="row m-t-10 m-l-10 m-r-10">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Driver/Operator Name </label>
                                            <?php
                                            
                                            $inspDrivernamedatas = [
                                                'name' => 'inspec[driver_name]',
                                                'id' => 'driver_name',
                                                'class' => 'form-control',
                                                'value' => $driverName,
                                                'autocomplete' => 'off',
                                            ];
                                            $fininspDrivernamedatas = array_merge($inspDrivernamedatas,$disabledStat);
                                            echo form_input($fininspDrivernamedatas);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> PMA/PMT No </label>
                                            <?php
                                            $inspPmtnodata = array(
                                                'name' => 'inspec[pmt_no]',
                                                'id' => 'pmt_no',
                                                'class' => 'form-control',
                                                'autocomplete' => 'off',
                                                'value' => $pmatNo
                                            );
                                            $fininspPmtnodata = array_merge($inspPmtnodata,$disabledStat);
                                            echo form_input($fininspPmtnodata);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> PMA/PMT Due Date </label>
                                            <?php
                                            $inspPmtdatedata = array(
                                                'name' => 'inspec[pmt_date]',
                                                'id' => 'pmt_date',
                                                'class' => 'form-control singledaterangepickerafterpma',
                                                'value' => $pmatDate,
                                                 'autocomplete' => 'off'
                                            );
                                            $fininspPmtdatedata = array_merge($inspPmtdatedata,$disabledStat);
                                            echo form_input($fininspPmtdatedata);
                                            ?>
                                         </div>
                                    </div>

                                </div>
                                <div class="row m-t-10 m-l-10 m-r-10">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Certificate No </label>
                                            <?php
                                            
                                            $inspCertnodatas = [
                                                'name' => 'inspec[cert_no]',
                                                'id' => 'cert_no',
                                                'class' => 'form-control',
                                                'value' => $certifNo,
                                                'autocomplete' => 'off',
                                            ];
                                            $fininspCertnodatas = array_merge($inspCertnodatas,$disabledStat);
                                            echo form_input($fininspCertnodatas);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Colour Code </label>
                                            <?php
                                            $inspColordata = array(
                                                'name' => 'inspec[color_code]',
                                                'id' => 'color_code',
                                                'class' => 'form-control',
                                                'autocomplete' => 'off',
                                                'value' => $colorCodeval
                                            );
                                             $fininspColordata = array_merge($inspColordata,$disabledStat);
                                            echo form_input($fininspColordata);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Description </label>
                                            <?php
                                            $inspDescdata = array(
                                                'name' => 'inspec[descr]',
                                                'id' => 'descr',
                                                'class' => 'form-control',
                                                'value' => $inspDescrp,
                                                'autocomplete' => 'off',
                                                'rows' => 2,
                                                'cols' => 5,
                                            );
                                            $fininspDescdata = array_merge($inspDescdata,$disabledStat);
                                            echo form_textarea($fininspDescdata);
                                            ?>
                                         </div>
                                    </div>

                                </div>
                                   
                                    </div>
                                
                                
                                <div class="emplDet m-t-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class=""> Location Details </h5>
                                        </div>

                                    </div>
                                </div>

                                <div class="row m-t-10 m-l-10 m-r-10">

                                   <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Terminal <span class="error"> * </span></label>
                                                <?php
                                                $eLoctdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'terminal',
                                                    'checkSelect' => 'select2',
                                                    'onchange' => 'getAjaxDepartment(this.value)',
                                                ];
                                                $fineLoctdata = array_merge($eLoctdata,$disabledStat);
                                                echo form_dropdown('inspec[terminal]', $dropTermname, $terminlID, $fineLoctdata);
                                                ?>
                                                <span class="error"><?php echo form_error('inspec[terminal]') ?></span>
                                            </div>
                                        </div>
                                    
                                    <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Department <span class="error"> * </span></label>
                                                <?php
                                                $eDeptdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'depart',
                                                    'checkSelect' => 'select2',
                                                    'required' => true
                                                    
                                                ];
                                                $fineDeptdata = array_merge($eDeptdata,$disabledStat);
                                                echo form_dropdown('inspec[depart]', $dropDepart, $deparID, $fineDeptdata);
                                                ?>
                                                <span class="error"><?php echo form_error('inspec[depart]') ?></span>
                                            </div>
                                        </div>

                                </div>
                               
                                </div>
                                
                            
                                
                                 <div class="emplDet m-t-10 " style="padding-bottom:10px">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class=""> Inspection Details </h5>
                                        </div>

                                    </div>
                                </div>

                                <div class="row m-t-10 m-l-10" style="text-align: center;">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Checklist Type <span class="error"> * </span></label>
                                            <?php
                                            
                                            $inspChecklistdatas = [
                                                'id' => 'checklistTyp',
                                                'class' => 'form-control select2 editValdatas',
                                                'required' => true,
                                                'checkSelect' => 'select2',
                                                'autocomplete' => 'off',
                                               
                                            ];
                                            $fininspChecklistdatas = array_merge($inspChecklistdatas,$disabledStat);
                                            echo form_dropdown('inspec[checklistTyp]', $dropChecklist,$checkLID,$fininspChecklistdatas);
                                            ?>
                                            <span class="error"><?php echo form_error('inspec[checklistTyp]') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div>
                                    
                                <?php 
                             
//                                    $editInspid = postData($getHssemaindatas,'INSP_AUTO_ID');
//                                  echo "<pre>";
//                                  print_R($getEditinspect);
//                                  exit;
                                if(isset($getEditinspect) && (!empty($getEditinspect))){ ?>
                                     
                                <div class="row marginStyl backStylrow">
                                    <div class="col-sm-1">S No</div>
                                    <div class="col-sm-5">Description</div>
                                    <div class="col-sm-1">Good</div>
                                    <div class="col-sm-1">Poor</div>
                                    <div class="col-sm-1">NA</div>
                                    <div class="col-sm-3">Remarks</div>
                                </div>
                                     
                                 <?php
                                    
                                     foreach($getEditinspect as $editKey => $editVal){
//                                         print_r($editKey);
//                                         print_r($editVal);exit;
//                                        
                                           $subTypindex = $editKey+1;
                                           
                                           $expSubtypid = postData($editVal,'FK_SUB_CAT_ID');                   
                                           $inspUserstatval = postData($editVal,'INSP_USER_STATUS');                   
                                           $expSubtypdataid = explode(",",$editVal->subTypdataID);                   
                                           $expSubtypdatadesc = explode("@",$editVal->subTypdata);                   
                                           $expRadioSD = explode(",",$editVal->goodPoor);                   
                                           $expRemark = explode(",",$editVal->remaRk);                   
                                           $expBfrimg = explode(",",$editVal->fileName);                   
                                           $expBfrimgpath = explode(",",$editVal->filePath);                   
                                           $expBfrdesc = explode(",",$editVal->quesDesc);
                                           
                                         
                                           if(isset($expBfrdesc) && !empty($expBfrdesc)){
                                               foreach($expBfrdesc as $ebdKey => $ebdVal){
                                                   if($ebdVal != ''){
                                                       $finalexpBfrdesc[] = $ebdVal;
                                                   }
                                               }
                                           }else{
                                               $finalexpBfrdesc = $expBfrdesc;
                                           }
                                          
                                           $expinspDetid = explode(",",$editVal->inspDetID); 
                                          
                                     ?>
                                     
                                         <div class="emplDetoth marginStyl" subtyprow-id="<?php echo $subTypindex; ?>" subtypdb-id="<?php echo $editVal->INSP_SUBTYP_ID; ?>" style="margin-top:10px;">
                                <?php if($editVal->subTyp != ''){ ?>
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="box-header withoth-border">
                                            <h5 class="head5styl"><?php echo $editVal->subTyp ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                             <?php $imgInd = 0;
                                             $goodRadkey = 0;
                                             foreach($expSubtypdataid as $datKey => $datVal){ 
                                                
                                                 $dataRowid = $datKey+1;
                                                 
                                                  $goodChecked = '';
                                                     $poorChecked = '';
                                                     $naChecked = '';
                                                     $attRemark = '';
                                                     $imageAppend = false;
                                                     
                                                     $explgooPoor = explode("-",$expRadioSD[$goodRadkey]);
                                                     $explgooPoorRemark = explode("-",$expRemark[$goodRadkey]);
                                                     
                                                      if(!empty($expRadioSD[$goodRadkey]) && ($explgooPoor[1] == $datVal)){
                                                          
                                                              if($explgooPoor[0] == 1){
                                                                   $goodChecked = 'checked';
                                                              }elseif($explgooPoor[0] == 2){
                                                                  $poorChecked = 'checked';
                                                                  $imageAppend = true;
                                                              }else{
                                                                   $naChecked = 'checked';
                                                              }
//                                                         
                                                              if($explgooPoorRemark[0] != ''){
                                                                  $attRemark = $explgooPoorRemark[0];
                                                              }
                                                          $goodRadkey++;
                                                      }else{
                                                         $goodChecked = 'checked';
                                                      }

                                              
                                                 $finalImgdet = $expBfrimgpath[0].''.$expBfrimg[$imgInd];
                                                
//                                                 print_r($datVal);
                                                
                                                 ?>
                                <div class="row marginStyl subtyPData" datarow-id="<?php echo $dataRowid; ?>" style="text-align: center;padding: 7px;border-bottom: 1px solid #8fb4ec;">
                                    <div class="col-sm-1"><?php echo $dataRowid; ?><input type="hidden" class="getSubtypdataID" value="<?php echo $expSubtypdataid[$datKey]; ?>"></div>
                                    <div class="col-sm-5" style="text-align: justify;"><?php echo $expSubtypdatadesc[$datKey]; ?></div>
                                         <div class="col-sm-1 custom-control custom-radio clickRadio">
                                            <input type="radio" <?php echo $disabledStattext ?> class="custom-control-input getRadioval editValdatas"  id="inspStatyes_<?php echo $subTypindex; ?>_<?php echo $expSubtypdataid[$datKey]; ?>" <?php echo $goodChecked; ?> name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $expSubtypdataid[$datKey]; ?>][inspStat]" value="1">
                                            <label class="custom-control-label" for="inspStatyes_<?php echo $subTypindex; ?>_<?php echo $expSubtypdataid[$datKey]; ?>"></label>
                                          </div>
                                          <div class="col-sm-1 custom-control custom-radio clickRadio">
                                            <input type="radio" <?php echo $disabledStattext ?> class="custom-control-input getRadioval editValdatas" id="inspStatno_<?php echo $subTypindex; ?>_<?php echo $expSubtypdataid[$datKey]; ?>" <?php echo $poorChecked ?> name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $expSubtypdataid[$datKey]; ?>][inspStat]" value="2">
                                            <label class="custom-control-label" for="inspStatno_<?php echo $subTypindex; ?>_<?php echo $expSubtypdataid[$datKey]; ?>"></label>
                                          </div>
                                        <div class="col-sm-1 custom-control custom-radio clickRadio">
                                        <input type="radio" <?php echo $disabledStattext ?> class="custom-control-input getRadioval editValdatas" id="inspStatna_<?php echo $subTypindex; ?>_<?php echo $expSubtypdataid[$datKey]; ?>" <?php echo $naChecked; ?> name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $expSubtypdataid[$datKey]; ?>][inspStat]" value="3">
                                        <label class="custom-control-label" for="inspStatna_<?php echo $subTypindex; ?>_<?php echo $expSubtypdataid[$datKey]; ?>"></label>
                                        </div>
                                    <div class="col-sm-3"><textarea name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $expSubtypdataid[$datKey]; ?>][inspRemark]" class="form-control editValdatas" <?php echo $disabledStattext; ?>><?php echo $attRemark; ?></textarea></div>
                                    </div>
                                             <?php if($imageAppend){ 
                                                
                                                 ?>
                                             <div class="appndImgrow " id="appendImgrow_<?php echo $subTypindex; ?>_<?php echo $expSubtypdataid[$datKey]; ?>">
                                                     <div class="row styleBfrhead" style="text-align:center">
                                                        <div class="col-md-6"> Image</div>
                                                        <div class="col-md-6"> Description</div>
                                                       
                                                        <!--<div class="col-md-2">Action</div>-->
                                                        </div>
                                                    
                                                        <div class="styleBfrdatas " style="margin-bottom: 10px;">
                                                            <div class="row" style="margin: 15px;">
                                                            <div class="col-md-6 text-center"> 
                                                               
                                                                        <a data-fancybox="gallery" href="<?php echo BASE_URL . $finalImgdet; ?>">
                                                                            <img class="lazy" style="height: 150px;width: 250px;" data-src="<?php echo BASE_URL . $finalImgdet; ?>" >
                                                                        </a>
                                                               
                                                            </div>
                                                            <div class="col-md-6">
                                                                <textarea name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $expSubtypdataid[$datKey]; ?>][beforeDescription]" rows="6" cols="6"  class="form-control editValdatas" <?php echo $disabledStattext; ?>><?php echo $finalexpBfrdesc[$imgInd]  ?></textarea>
                                                            </div>
                                                          </div>
                                                           
                                                        </div>
                                                 </div>
                                            <?php $imgInd++;
                                             }   }  ?>
 </div>
                               
                                    
                                     <?php }
//                                     exit;
                                     } ?>
                                     <div class="appendChecklist"></div>
                                     
                                     <?php if(empty($getEditinspect)){ ?>
                                     <div class="row targetDet marginStyl justify-content-center d-none" style="margin-top:10px;text-align:center">
                                         <div class="col-md-8 emplDet " style="border:1px solid #4b545c !important">
                                         <div class="row ">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" style="background-color: #4b545c !important;">
                                            <h5 class=""> Executive Details </h5>
                                        </div>

                                    </div>
                                </div>
                                            <div class="row m-b-10 m-t-10 ">
                                        <div class="col-md-2 "></div>
                                        <div class="col-md-8 ">
                                            <label>Assign Executive <span class="error"> * </span></label>
                                            <?php 
                                            $execDatas = [
                                                'class' => 'form-control select2',
                                                'id' => 'execName',
                                                'checkSelect' => 'select2',
                                            ];
                                           
                                            echo form_dropdown('inspec[execName]',$execDesig,$verifyID,$execDatas);
                                            ?>
                                            <span class="error"><?php echo form_error('inspec[execName]') ?></span>
                                        </div>
                                        
                                    </div>
                                </div>
                                </div>
                                     <?php } ?>
                                     
                                      <?php
                                     if($getHssemaindatas->INSP_APP_STATUS == ''){
//                                     $extraDetstyl = (!empty($getHssemaindatas)) ? '' : 'd-none';
//                                     $checkStatsafe = (isset($getHssemaindatas->INSP_SAFE_UNSAFE) && $getHssemaindatas->INSP_SAFE_UNSAFE == 1) ? 'checked' : '';
                                     ?>
                                     <div class="extraDet d-none">
                                      <div class="row autho" style="margin-left:15%">
                                         <div class="col-md-12">
                                            <span class=" checkSafety">
                                               I have conducted an inspection and hereby declared that the mention tool / equipment / machine is:
                                               <div class="custom-control custom-radio clickRadio">
                                                         <input type="radio" class="custom-control-input getRadioval" checked id="safeStatus_yes" name="inspec[safeStatus]" value="1">
                                                <label class="custom-control-label" for="safeStatus_yes">Safe </label> for use during the time of Inspection
                                                </div>
                                               <div class="custom-control custom-radio clickRadio">
                                                         <input type="radio" class="custom-control-input getRadioval"  id="safeStatus_no" name="inspec[safeStatus]" value="2">
                                                <label class="custom-control-label" for="safeStatus_no">Not Safe </label> for use during the time of Inspection
                                                </div>
                                               <!--<input type="checkbox"   name="inspec[safeStatus]"  id="safeStatus">-->
                                               <!--<span class="checkmark"></span>-->
                                            </span>
                                        </div>
                                     </div>
                                     
                                     
<!--                                     <div class="row m-t-10">
                                         <div class="col-md-12">
                                             <div class="col-md-1 text-right"><label> Note : </label></div>
                                            <div class="col-md-8 text-left"> <textarea rows="3" cols="8" class="form-control" name="inspec[ovrerallNotes]" id="ovrerallNotes"><?php echo $noteDescr; ?></textarea>
                                         </div>
                                     </div>
                                     </div>-->

                                        <div class="emplDetPhoto">
                                        <div class="row">
                                        <div class="col-md-10">
                                            <b><h5>Image Upload</h5></b>
                                        </div>
                                            <div class="btn btn-xs btn-success float-right  addMorimg" ><i class="fa fa-plus-circle "> Add More</i></div>
                                            <!--<div class="col-md-2 addMorimg"><span class="btn btn-xs"><i class="fa fa-plus-circle "></i> Add More</span></div>-->
                                        </div>
                                            
                                            <div class="clearfix"></div>
                                            
                                        <div class="row appendNewimgs m-l-10 m-t-10">
                                        <div class="col-md-4 " id="removeImg_1">
                                            	<div class="form-group imgGroup">
                                                    <div class="fileinput fileinput-new apprFileinput" style="margin-top: -30px !important; " data-provides="fileinput" >
                                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                                     </div>
                                                                    <p class="mini-txt">(png, jpeg, jpg )</p>
                                                                    <div class="file-pop" style="top:30% !important">                                                    
                                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src='<?php echo BASE_URL("/assets/images/photo.png"); ?>'  style=" width: 30%; "/></span>
                                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                                            <input type="file" name="addmoreImages[]"  class='inspecptwFile' accept="image/jpg,image/png,image/jpeg" id="beforeImg_1"></span>

                                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="user_img[]" class="user_imgClas" value="<?php echo $finalImgdet; ?>" id="userImg_1">
                                                </div>
                                            <div class="removenewimageset" title='Remove Section' remove-id="1"><i class="fa fa-times-circle"></i></div>
                                        </div>
                                      
                                     </div>
                                     </div>
                                     
                                     <?php }else{ 
                                         
                                         $safeUnsafstatus = postData($getHssemaindatas,'INSP_SAFE_UNSAFE');
                                         
                                         if($safeUnsafstatus == 1){
                                             $checkStat = 'checked';
                                         
                                         ?>
<!--                                        <div class="row m-t-10">
                                         <div class="col-md-12">
                                            <label class="container checkSafety">
                                               I have conducted an inspection and hereby declared that the mention tool / equipment / machine is safe for use during the time of inspection.
                                               <input type="checkbox"   <?php echo $checkStat; ?> disabled>
                                               <span class="checkmark"></span>
                                            </label>
                                        </div>
                                     </div>-->
                                         <?php } ?>
                                     
                                     <?php 
                                      $safeUnsafstatus = postData($getHssemaindatas,'INSP_SAFE_UNSAFE');
                                     $inspChekedYes = (isset($safeUnsafstatus) && $safeUnsafstatus == 1) ? 'checked' : '';
                                     $inspChekedNo = (isset($safeUnsafstatus) && $safeUnsafstatus == 2) ? 'checked' : '';
                                     ?>


                                     
                                      <div class="extraDet ">
                                      <div class="row autho" style="margin-left:15%">
                                         <div class="col-md-12">
                                            <span class=" checkSafety">
                                              <label> I have conducted an inspection and hereby declared that the mention tool / equipment / machine is: </label>
                                               <div class="custom-control custom-radio clickRadio">
                                                         <input type="radio" disabled class="custom-control-input getRadioval" <?php echo $inspChekedYes ?> id="safeStatus_yes" name="inspec[safeStatus]" value="1">
                                                <label class="custom-control-label" for="safeStatus_yes">Safe </label> for use during the time of Inspection
                                                </div>
                                               <div class="custom-control custom-radio clickRadio">
                                                         <input type="radio" disabled class="custom-control-input getRadioval" <?php echo $inspChekedNo; ?> id="safeStatus_no" name="inspec[safeStatus]" value="2">
                                                <label class="custom-control-label" for="safeStatus_no">Not Safe </label> for use during the time of Inspection
                                                </div>
                                               <!--<input type="checkbox"   name="inspec[safeStatus]"  id="safeStatus">-->
                                               <!--<span class="checkmark"></span>-->
                                            </span>
                                        </div>
                                     </div>
                                     </div>

					<?php if(isset($getAllmoreimages) && !empty($getAllmoreimages)){ ?>
                                    <div class="emplDetPhoto">
                                        <div class="row">
                                        <div class="col-md-10">
                                            <b><h5>Image Upload</h5></b>
                                        </div>
                                        </div>
                                            
                                            <div class="clearfix"></div>
                                            
                                        <div class="row appendNewimgs m-l-10 m-t-10">
                                        
                                            
                                               <?php foreach($getAllmoreimages as $amiKey => $amiVal){
                                                    $moreImgname = postData($amiVal,'INSP_NOT_IMG_FILENAME');
                                                    $moreImgpath = postData($amiVal,'INSP_NOT_IMG_FILEPATH');
                                                    $addMorimageloc = $moreImgpath.''.$moreImgname
                                                ?>
                                       <div class="col-md-4" style="margin-top:20px;" id="removeImg_<?php echo $amiKey ?>">
                                                <a data-fancybox="gallery" href="<?php echo BASE_URL . $addMorimageloc; ?>">
                                                    <img class="lazy" style="height: 150px;width: 250px;" data-src="<?php echo BASE_URL . $addMorimageloc; ?>" >
                                                </a>
                                            </div>
                                     <?php }  ?>
                                      
                                   
                                     </div>
                                     </div>
                                    <?php } ?>
                                      <div class="row m-t-10">
                                         <!--<div class="col-md-12">-->
                                             <div class="col-md-1 text-right"><label> Note : </label></div>
                                            <div class="col-md-8 text-left"> <textarea rows="3" cols="8" class="form-control"  name="inspec[ovrerallNotes]" id="ovrerallNotes"><?php echo $noteDescr; ?></textarea>
                                         <!--</div>-->
                                     </div>
                                     </div>
                                   
                                     <?php } ?>
                               
 </div>
                                <div class="form-group m-t-10" style="text-align: center;">
                                    <div class="col-sm-offset-2 col-sm-12"> 

                                        <?php
                                        if($verificationStatus == 1){
//                                            $data = array('id' => 'verifyin', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SUBMIT', 'class' => 'submitInsp btn btn-primary');
                                            $data = array('id' => 'submitin', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SUBMIT', 'class' => 'submitInsp btn btn-primary');
                                        
                                             echo form_button($data);
                                        }elseif($verificationStatus == ''){
//                                            $data = array('id' => 'submitin', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SUBMIT', 'class' => 'submitInsp btn btn-primary');
                                            $data = array('id' => 'verifyin', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SUBMIT', 'class' => 'submitInsp btn btn-primary');
                                        
                                             echo form_button($data);
                                        }
                                       
                                        ?>
                                    </div>
                                </div>
                                <!-- input states -->
                                <?php echo form_close(); ?>
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
   
   function getAjaxDepartment(id) {
        var url = "<?php echo BASE_URL('common/getAjaxDepartment') ?>";
        var data = {terminalID: id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
        $.ajax({
            dataType: 'json',
            data: 'ajax',
            method: 'post',
            data: data,
            url: url,
            success: function (resp) {
                $("#depart").html(resp.deptdatas)
            }
        });
      
    }
    
    $(document).ready(function(){
        
         $('.lazy').lazy();
         
         var today = new Date(); 
         $(".singledaterangepickerafter").daterangepicker({
            
            singleDatePicker: true,
            minDate:today,
           
        locale: {
            format: 'DD-MM-YYYY',
        
        }
    });
         $(".singledaterangepickerafterpma").daterangepicker({
             autoUpdateInput: false,
            singleDatePicker: true,
            minDate:today,
           
        locale: {
            format: 'DD-MM-YYYY',
        
        }
    });
    
    $('#pmt_date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY'));
  });
    
         $(".singledaterangepickerbefore").daterangepicker({
            singleDatePicker: true,
            maxDate:today,
            
        locale: {
            format: 'DD-MM-YYYY',

        }
    });
    
       $.validator.addMethod('filesize', function (value, element, param) {
           
            return this.optional(element) || (Math.round(element.files[0].size / (1024 * 1024)) <= 5)
        }, 'File size must be less than 5MB');

        $.validator.addClassRules("inspecFile", {
//            accept: "png|jpe?g|gif",
            required: true,
            filesize : true
        });
        
        $.validator.addMethod('filesizeptw', function (value, element, param) {
           
            return this.optional(element) || (Math.round(element.files[0].size / (1024 * 1024)) <= 5)
        }, 'File size must be less than 5MB');

        $.validator.addClassRules("inspecptwFile", {
//            accept: "png|jpe?g|gif",
            required: true,
            filesizeptw : true
        });
       
      $("#company-profile").validate({
//            success: function (error) {
//                error.removeClass("error");
//                error.addClass("d-none");
//            },
            rules: {
                
                "inspec[insp_date]": {
                    required: true,
                 },
                "inspec[next_inspDate]": {
                    required: true,
                },
                "inspec[terminal]": {
                    required: true,
                 },
               
                "inspec[modal_no]": {
                    required: true,
//                    alphanumeric: true,
                    //alphanumericwithspecialchar: true,
                    maxlength: 25,
                    minlength: 3
                 },
                "inspec[reg_no]": {
//                     alphanumeric: true,
                    // alphanumericwithspecialchar: true,
                     maxlength: 15,
                    minlength: 3
                 },
                "inspec[driver_name]": {
//                    alphaspace: true,
                   // alphaspacewithspecialchar : true,
                    maxlength: 50,
                    minlength: 3
                 },
                "inspec[pmt_no]": {
//                    alphanumeric: true,
                   // alphanumericwithspecialchar: true,
                    maxlength: 25,
                    minlength: 3
                 },
                "inspec[cert_no]": {
//                    alphanumeric: true,
                  //  alphanumericwithspecialchar: true,
                    maxlength: 15,
                    minlength: 3
                 },
                "inspec[descr]": {
                   // descrptns: true,
                    maxlength: 200,
                    minlength: 3
                 },
                "inspec[depart]": {
                    required: true,
                 },
                "inspec[color_code]": {
                    color_code: true,
                 },
                "inspec[checklistTyp]": {
                    required: true,
                 },
                "inspec[execName]": {
                    required: true,
                 },
//                "inspec[ovrerallNotes]": {
//                    required: true,
//                 },
               
              },
            messages: {
              
               "inspec[insp_date]": {
                    required: "Inspection Date is required",
                },
               "inspec[next_inspDate]": {
                    required: "Next Inspection Date is required",
                },
               "inspec[modal_no]": {
                    required: "Type of Inspection is required",
                },
               "inspec[terminal]": {
                    required: "Terminal is required",
                },
               "inspec[depart]": {
                    required: "Department is required",
                },
               "inspec[checklistTyp]": {
                    required: "Checklist Type is required",
                },
               "inspec[execName]": {
                    required: "Executive Name is required",
                },
//               "inspec[ovrerallNotes]": {
//                    required: "Note is required",
//                },
               
            },
            errorPlacement: function(error,element) {
               
                if(element.attr('checkSelect') == 'select2'){
                    error.insertAfter(element.next('.select2-container'));
                }else{
                    error.insertAfter(element);
                    element.closest(".imgGroup").last().append(error);
                }
            },
             submitHandler: function (form,e) {
                 var safeVal = $("input[name='inspec[safeStatus]']:checked").val();
                 
                 var geLngth = $(".inspecFile").length;
             var geLngthhiden = $(".user_imgClas").length;
    
    var i;
   
    for(i=0;i< geLngth;){
        var imgeVal = $(".inspecFile").eq(i).val();
        var imgeValhiden = $(".user_imgClas").eq(i).val();
       
        if(imgeVal == '' && (imgeValhiden == '' || imgeValhiden == 'undefined')){
          
            swal("Error",'Image is required','error');
            return false;
        }else{
            i++;
//            return false;
        }
    }
                 
                e.preventDefault();
            var idval = $(".submitInsp").attr('id');
          
            if(idval == 'submitin'){
               
                swal({
                title: "Are you sure ",
                text: "<b>You want to submit the Inspection</b>",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                closeButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true,
                 html: true,
            },
            function (isConfirm) {
                if (isConfirm) {
                   loader();
                    form.submit();
                    unloader();
                }
            });
            }else{
                var swalText = '';
                if(safeVal == '1'){
                    swalText = "<b>Have you Verified the Equipment is safe to use ?</b>";
                }else{
                    swalText = "<b>Have you Verified the Equipment is unsafe to use ?</b>";
                }
                swal({
                title: "Are you sure ",
                text: swalText,
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                closeButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true,
                 html: true,
            },
            function (isConfirm) {
                if (isConfirm) {
                     loader();
                    form.submit();
                }
            });
            }
             }
            
        });
        
         $("#checklistTyp").on("change",function(){
        var checklistId = $(this).val();

        
        var url = "<?php echo BASE_URL('inspection/getAjaxinspSubtyp') ?>";
        var data = {checklistId: checklistId, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
        $.ajax({
            dataType: 'json',
            data: 'ajax',
            method: 'post',
            data: data,
            url: url,
            success: function (resp) {
               console.log(resp.getAllsubtyp)
               
                var subtyp = resp.getAllsubtyp;
                var html = '';
               if(subtyp != ''){
                    $(".targetDet").removeClass('d-none');
                     $("#submitin").removeClass("d-none");
                   html = ' <div class="row marginStyl backStylrow" >\n\
                                    <div class="col-sm-1">S No</div>\n\
                                    <div class="col-sm-5">Check Items</div>\n\
                                    <div class="col-sm-1">Good</div>\n\
                                    <div class="col-sm-1">Poor</div>\n\
                                    <div class="col-sm-1">NA</div>\n\
                                    <div class="col-sm-3">Remarks</div>\n\
                                    </div>';
               $.each(subtyp,function(stInd,stVal){
                   var subTypind = parseInt(stInd)+1;
                   var subtypdatadesc = stVal.SUBTYPEDATADESC;
                   var subtypdataID = stVal.SUBTYPEDATAID;
                   var subTypID = stVal.INSP_CHECK_SUBTYP_ID;
                   var splitSubtypdata = subtypdatadesc.split('@');
                   var splitSubtypdataid = subtypdataID.split(',');
                   var subtypData = '';
                   console.log(splitSubtypdataid)
                    $.each(splitSubtypdata,function(daInd,daVal){
                        var indKey = parseInt(daInd)+1;
                        
                         var subtypedatID = splitSubtypdataid[daInd];
                      subtypData += '<div class="row marginStyl subtyPData" dataRow-id="'+subtypedatID+'" style="text-align: center;padding: 7px;border-bottom: 1px solid #8fb4ec;">\n\
                                    <div class="col-sm-1">'+indKey+'<input type="hidden" class="getSubtypdataID" value="'+subtypedatID+'"></div>\n\
                                    <div class="col-sm-5" style="text-align: justify !important;">'+daVal+'</div>\n\
 <div class="col-sm-1 custom-control custom-radio clickRadio ">\n\
    <input type="radio" class="custom-control-input getRadioval" checked id="inspStatyes_'+subTypind+'_'+subtypedatID+'" name="inspcheck['+subTypID+']['+subtypedatID+'][inspStat]" value="1">\n\
    <label class="custom-control-label" for="inspStatyes_'+subTypind+'_'+subtypedatID+'"></label>\n\
  </div>\n\
  <div class="col-sm-1 custom-control custom-radio clickRadio " align="center">\n\
    <input type="radio" class="custom-control-input getRadioval" id="inspStatno_'+subTypind+'_'+subtypedatID+'" name="inspcheck['+subTypID+']['+subtypedatID+'][inspStat]" value="2">\n\
    <label class="custom-control-label" for="inspStatno_'+subTypind+'_'+subtypedatID+'"></label>\n\
  </div>\n\
<div class="col-sm-1 custom-control custom-radio clickRadio " align="center">\n\
<input type="radio" class="custom-control-input getRadioval" id="inspStatna_'+subTypind+'_'+subtypedatID+'" name="inspcheck['+subTypID+']['+subtypedatID+'][inspStat]"   value="3">\n\
<label class="custom-control-label" for="inspStatna_'+subTypind+'_'+subtypedatID+'"></label>\n\
</div>\n\
                                    <div class="col-sm-3"><textarea name="inspcheck['+subTypID+']['+subtypedatID+'][inspRemark]" class="form-control"></textarea></div>\n\
                                    </div><div class="appndImgrow" id="appendImgrow_'+subTypind+'_'+subtypedatID+'"></div>';
                   });
                 
                   html += '<div class="emplDetoth marginStyl" subtypRow-id="'+subTypind+'" subTypDB-id="'+subTypID+'" style="margin-top:10px;">\n\
                                      <div class="row ">';
                              if(stVal.INSP_CHECK_SUBTYP_NAME != null){
                              html += '<div class="col-md-12">\n\
                                        <div class="box-header withoth-border" >\n\
                                            <h5 class="head5styl">'+stVal.INSP_CHECK_SUBTYP_NAME+'</h5>\n\
                                        </div>\n\
                                    </div>';
                              }
                              html +=  '</div>'+subtypData+'\n\
                                <div class="row m-t-10 m-l-10">\n\
                                </div>\n\
                                </div>\n\
                                ';
                   
               });
               $(".extraDet").removeClass("d-none");
             
                }else{
                 $(".targetDet").addClass('d-none');
                    html += '<div class="row nodataRow marginStyl text-center"><div class="col-md-12"><label style="color:#fff">No Subtype found</label></div></div>'
                    $("#submitin").addClass("d-none");
                    $(".extraDet").addClass("d-none");
                   }
                    $(".appendChecklist").html(html);
                    
                   
            }
        });
        });
        
        $(document).on("click",".clickRadio",function(){
        
        var getSubtyprow =   $(this).closest('.emplDetoth').attr('subtypRow-id');
        var getSubtypDBrow =   $(this).closest('.emplDetoth').attr('subTypDB-id');
        var getSubtypdatarow =   $(this).closest('.subtyPData').attr('datarow-id');
//        alert(getcheckedRadioval)
        var getcheckedRadioval = $(this).find("input[name='inspcheck["+getSubtypDBrow+"]["+getSubtypdatarow+"][inspStat]']:checked").val();
        var beforeDatas = '';
//       var verifStatus = '<?php echo $verificationStatus; ?>'
       var imgApp = 'http://www.placehold.it/230x140/EFEFEF/AAAAAA&amp;text=no+image';
        if(getcheckedRadioval == '2'){
           
      var samplImg = '<?php echo BASE_URL("/assets/images/photo.png"); ?>'
     
       beforeDatas += '<div class="row styleBfrhead" style="text-align: center;">\n\
                            <div class="col-md-4">Image</div>\n\
                            <div class="col-md-6">Description\n\
                            </div>\n\
                        </div>\n\
                        <div class="styleBfrdatas"><div class="row" style="margin: 15px;">\n\
                            <div class="col-md-4"> <div class="form-group imgGroup">\n\
\n\<div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important;height: 1px; " data-provides="fileinput" >\n\
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" ><img src="'+imgApp+'"  alt="" /></div>\n\
                                                    <p class="mini-txt">( gif, jpg, png, jpeg)</p>\n\
                                                    <div class="file-pop" >  <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src="'+samplImg+'"  style=" width: 30%; "/></span>\n\
                                                            <span class="fileinput-exists" title="Add Image"></span>\n\
                                                            <input type="file" name="beforeImages[]" accept="image/*" class="inspecFile" required></span>\n\
                                                            <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>\n\
                                                    </div>\n\
                                                </div>\n\
                                                <input type="hidden" name="user_img[]" value="" class="user_imgClas">\n\
                                         </div></div>\n\
                            <div class="col-md-8"><textarea name="inspcheck['+getSubtypDBrow+']['+getSubtypdatarow+'][beforeDescription]" rows="6" cols="6" class="form-control" id="check_'+getSubtyprow+'_'+getSubtypdatarow+'" required></textarea>\n\
                            </div>\n\
                            </div></div>';
        $("#appendImgrow_"+getSubtyprow+"_"+getSubtypdatarow).html(beforeDatas);
    }else{
       if(getcheckedRadioval != undefined){
        $("#appendImgrow_"+getSubtyprow+"_"+getSubtypdatarow).html(beforeDatas);
    }
    }
        });
        
        $(document).on('click','.addMorimg',function(){
        var imgsSrc = '<?php echo BASE_URL .'assets/images/photo.png' ?>';
        var getImgcount =  $(".appendNewimgs").children().length;
          var newImgcount = parseInt(getImgcount)+1;
        var addMorimg = '';
        addMorimg += '<div class="col-md-4" id="removeImg_'+newImgcount+'">\n\
                                            <div class="form-group imgGroup">\n\
                                                    <div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important;height: 1px; " data-provides="fileinput">\n\
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput"></div>\n\
                                                    <p class="mini-txt">(jpg, png, jpeg)</p>\n\
                                                    <div class="file-pop" style="top:30% !important">  <span class="text-green btn-file"><span class="photo fileinput-new"  title="Add Image"><img class="imgupload" src="'+imgsSrc+'" style=" width: 30%; "></span>\n\
                                                            <span class="fileinput-exists" title="Add Image"></span>\n\
                                                            <input type="file" name="addmoreImages[]" class="inspecptwFile" accept="image/jpg,image/png,image/jpeg" id="beforeImg_'+newImgcount+'"  ></span>\n\
                                                            <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>\n\
                                                    </div>\n\
                                                </div>\n\
                                                <input type="hidden" name="user_img[]" class="user_imgClas" value="" id="userImg_'+newImgcount+'">\n\
                                         </div>\n\
                                            <div class="removenewimageset" title="Remove Section" remove-id="'+newImgcount+'"><i class="fa fa-times-circle"></i></div>\n\
                                        </div>';
    $(".appendNewimgs").append(addMorimg);
//    $(".appendMorimages").append(addMorimg);
        })
        
         $(document).on('click',".removenewimageset",function(){
           var remId = $(this).attr('remove-id');
         
           var getImgcount =  $(".appendNewimgs").children().length;
          
           if(getImgcount > 1){
           $("#removeImg_"+remId).remove();
       }else{
           swal('Sorry','Atleast one Image is required','warning')
       }
           
        })
    
    });
</script>


<!--<input type="file" name="beforeImages['+getSubtyprow+'][]" accept="image/*,.pdf,.doc" required></span>\n\-->

