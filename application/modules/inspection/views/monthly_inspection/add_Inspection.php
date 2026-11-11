<?php
$execDesig = getUsertypdesigEmpl(4, []);


if ($getHssemaindatas->MON_INSPECTION_DATE != '') {
    $inspDate = date("d-m-Y", strtotime($getHssemaindatas->MON_INSPECTION_DATE));
} else {
    $inspDate = '';
}

$terminlID = postData($getHssemaindatas, 'MON_INSP_TER_ID');
$LOcatID = postData($getHssemaindatas, 'MON_INSP_SPE_LOC_ID');
$explLocatid = explode(",",$LOcatID);

$geteachLoctdet = getcommonSelloct($explLocatid);

//if(!empty($locApp)){
//    $geteachLoctdet = '';
//    foreach($locApp as $glKey => $glVal){
//       $geteachLoctdet  .= '<option value="'.$glVal->SL_AUTO_ID.'">'.$glVal->SPECIFIC_LOC_NAME.'</option>';
//    }
//}
//echo "<pre>";
//print_R($LOcatID);
//print_R($geteachLoctdet);
//exit;
$monLoctother = postData($getHssemaindatas, 'MON_INSP_SPE_LOC_OTHER');
$checkLID = postData($getHssemaindatas, 'MON_INSP_CHECKLIST_ID');
$verificationStatus = postData($getHssemaindatas, 'MON_INSP_APP_STATUS');
$monInspeditID = postData($getHssemaindatas, 'MON_INSP_AUTO_ID');


$disabledStat = [];
$disabldLocat = [];
$disabledStatcheck = [];
$disabledStattext = '';
$disabledStattextLocatn = '';

if ($verificationStatus >= 1 || $verificationStatus < -2) {

   $disabledStat  = ['disabled' => 'disabled'];
    $disabledStattext = 'disabled = disabled';
}
if($verificationStatus >= 1 || $verificationStatus <= -2){
    $disabledStatcheck = ['disabled' => 'disabled'];
}
if ($verificationStatus >= 1 || $verificationStatus <= -1) {
    $disabldLocat = ['disabled' => 'disabled'];
    $disabledStattextLocatn = 'disabled = disabled';
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
        background-color: #e6c86a;
        color: white;
        padding: 8px 0 1px 17px;
    }
    .emplDetoth{
        border: 1px solid #5a5a59;
        margin: 0px 30px;
    }
    .head5styl{
        text-align: center;
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
        background: #de8383;
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
        margin-left: -5%;
    }
    .checklTab tbody tr:nth-child(even){
        background-color: #fff !important;
  /*color: #fff;*/
    }
    .checklTab tbody tr:nth-child(odd){
        background-color: #f2f2f0 !important;
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
    /*custom checkbox start*/
    /* Customize the label (the container) */
    .container {
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
    .container input {
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
    .container:hover input ~ .checkmark {
        background-color: #ccc;
        border:none !important;
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked ~ .checkmark {
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
    .container input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
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
                                    <h4> HSSE Monthly Inspection</h4>
                                    <a href="<?php echo BASE_URL('inspection/Inspectionlistmonthly') ?>"><button type="button" class="btn btn-sm btn-primary backBtns"><i class="fa fa-backward"></i> Back</button></a>
                                </div>
                            </div>
                            <div class="card-body">

<?php
if (isset($getHssemaindatas->MON_INSP_AUTO_ID) && !empty($getHssemaindatas->MON_INSP_AUTO_ID)) {
    $urlAutid = encryptval($getHssemaindatas->MON_INSP_AUTO_ID);
} else {
    $urlAutid = '';
}
echo form_open_multipart('inspection/saveInspectionmonthly/' . $urlAutid, 'class="form-horizontal" id="company-profile" novalidate');
?>

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
                                                    $fininspDatedata = array_merge($inspDatedata, $disabledStat);
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
                                                    'onchange' => 'getAjaxLocation(this.value)',
                                                ];
                                                $fineLoctdata = array_merge($eLoctdata, $disabldLocat);
                                                echo form_dropdown('inspec[terminal]', $dropTermname, $terminlID, $fineLoctdata);
                                                ?>
                                                <span class="error"><?php echo form_error('inspec[terminal]') ?></span>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Location <span class="error"> * </span></label>
                                                    <?php
                                                    $eDeptdata = [
                                                        'class' => 'form-control select2',
                                                        'id' => 'location',
                                                        'checkSelect' => 'select2',
                                                        'multiple' => 'multiple',
                                                    ];
                                                    $fineDeptdata = array_merge($eDeptdata, $disabldLocat);
                                                    $fidropLocation = $dropLocation+["-1" => 'Others'];

                                                    echo form_dropdown('inspec[location][]', $fidropLocation, $explLocatid, $fineDeptdata);
                                                    ?>
                                                <span class="error"><?php echo form_error('inspec[location]') ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4 appendotherLoc"></div>

                                    </div>

                                </div>



                                <div class="emplDet m-t-10 ajaxLoaddiv" style="padding-bottom:10px">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box-header with-border" >
                                                <h5 class=""> Inspection Details </h5>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row m-t-10 m-l-10" style="text-align: center;">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-4" style="text-align: -webkit-center;">
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
                                                        $fininspChecklistdatas = array_merge($inspChecklistdatas, $disabledStatcheck);
                                                        echo form_dropdown('inspec[checklistTyp]', $dropChecklist, $checkLID, $fininspChecklistdatas);
                                                        ?>
                                                <span class="error"><?php echo form_error('inspec[checklistTyp]') ?></span>
                                                <input type="hidden" name="inspec[hidenchecklistTyp]" value="<?php echo $checkLID; ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4"></div>
                                    </div>

                                   <div class="appendChecklist">  
                                   <?php if (isset($getEditinspect) && !empty($getEditinspect)) { 
//                                       echo "<pre>";
//                                       print_R($getEditinspect);
////                                       print_R($atarDatas);
////                                       echo count($getEditinspect);
////                                       print_R($atarDatas);
//                                       exit;
                                       $atarkey = 0;
                                       foreach($getEditinspect as $editKey => $editVal){
//                                           echo "<pre>";
//                                           print_r($editVal);
//                                           echo "<br>";
//                                           if(count($getEditinspect) == 1){

                                           $expSubtypid = postData($editVal,'FK_MON_SUB_CAT_ID'); 
                                           if(postData($editVal,'subTyp') == ''){
                                               $subTypindex = $expSubtypid;
                                           }else{
                                               $subTypindex = $editKey+1;
                                           }

                                         ////Old Code
                                        //  if(postData($editVal,'subTyp') == ''){
                                         //      $subTypindex = $editKey;
                                         //  }else{
                                         //      $subTypindex = $editKey+1;
                                         //  }
                                           
                                           
                                         //  $expSubtypid = postData($editVal,'FK_MON_SUB_CAT_ID'); 
                                           $editInspectnid = postData($editVal,'FK_MON_INSP_ID'); 
                                           if($expSubtypid == ''){
                                               $expSubtypid = 0;
                                           }
//                                           $inspUserstatval = postData($editVal,'INSP_USER_STATUS');                   
                                           $expchkListid = explode(",",$editVal->checkListid);                   
                                           $expSubtypdataid = explode(",",$editVal->subTypdataID);                   
                                           $expSubtypdatadesc = explode("@",$editVal->subTypdata);                   
                                           $expRadioSD = explode(",",$editVal->scoreValue);                   
                                           $expAtarstatus = explode(",",$editVal->atarStatus);                   
                                           $expRemark = explode("@",$editVal->remaRk);                   
                                           $expBfrimg = explode(",",$editVal->fileName);                   
                                           $expBfrimgpath = explode(",",$editVal->filePath);  
                                           
                                           $expinspDetid = explode(",",$editVal->inspDetID); 
                                       ?>
                                                                    <div class="row emplDetoth" subtypRow-id="<?php echo $subTypindex; ?>" subTypDB-id="<?php echo $expSubtypid; ?>" style="margin:10px;">
                                                                         <div class="col-md-12" style='padding: 0px;'>
                                                                        
                                                                         <table class="table table-responsive table-bordered table-striped checklTab">
                                                                              <thead class="checklTabhead" style="background: #5a5a59 !important;color:#fff;text-align: center;">
                                                                             <tr>
                                                                                 <th>S.No</th>
                                                                                 <th><?php echo $editVal->subTyp ?></th>
                                                                                <th>Max Score(3)</th>
                                                                                <th>Given Score</th>
                                                                                <th>Comments</th>
                                                                                <th>Send to ATAR</th>
                                                                               
                                                                             </tr>
                                                                              </thead>
                                                                              <tbody style='text-align: center;'>
                                                                                  
                                                                                   <?php 
//                                                                                   $imgInd = 0;
                                             $goodRadkey = 0;
                                             $atarkey = $atarkey;
                                             foreach($expSubtypdataid as $datKey => $datVal){ 
                                                $editAtarID = '';
                                              
                                                 if($atarDatas[$atarkey]->ATAR_INSP_SUBCAT_ID == $datVal){
                                                     $editAtarID = postData($atarDatas[$atarkey],'ATAR_AUTO_ID');
                                                     $atarkey++;
                                                 }
                                                
                                                 $dataRowid = $datKey+1;
                                                 
                                                  $scoreZero = '';
                                                  $scoreOne = '';
                                                     $scoreTwo = '';
                                                     $scoreThree = '';
                                                     $scoreNA = '';
                                                     $attRemark = '';
                                                     $imageAppend = false;
                                                     $sendtoAtar = '';
                                                     $textCheckdisab = '';
                                                     $textCheckrequ = '';
                                                     $sendtoAtarcheckclas = '';
                                                     
                                                     $explChkListfinal = explode("@",$expchkListid[$goodRadkey]);
                                                     $explFileimg = explode("@",$expBfrimg[$goodRadkey]);
                                                    
                                                     $explScore = explode("@",$expRadioSD[$goodRadkey]);
                                                     $explatarStatus = explode("@",$expAtarstatus[$goodRadkey]);
                                                     $explgooPoorRemark = explode("@",$expRemark[$goodRadkey]);
//                                                     print_R($explScore);echo "<br>";
//                                                    print_R($explFileimg);exit;
//                                                     echo "<br>";
//                                                     echo "<br>";
//                                                     print_R($explScore[1]);
//                                                     echo "<pre>";
//                                                     print_R($explgooPoor);
//                                                     print_R($explChkListfinal);
                                                      if(!empty($expRadioSD[$goodRadkey]) && ($explScore[1] == $datVal)){
                                                         
                                                          if($verificationStatus != -1 && $verificationStatus != -2){
                                                              $textCheckdisab = 'disabled';
                                                          }
                                                              if($explScore[0] == 0){
                                                                   $scoreZero = 'selected';
                                                                   if($explatarStatus[0] == 'Y'){
                                                                       $sendtoAtar = 'checked';
                                                                       $sendtoAtarcheckclas = 'atarCheckboxsel';
                                                                   }
                                                                   
                                                                   if($verificationStatus == -1){
                                                                     
                                                                       $textCheckrequ = 'required';
                                                                   }
                                                                   
                                                              }
                                                              elseif($explScore[0] == 1){
                                                                   $scoreOne = 'selected';
                                                                   if($explatarStatus[0] == 'Y'){
                                                                    $sendtoAtar = 'checked';
                                                                    $sendtoAtarcheckclas = 'atarCheckboxsel';
                                                                   }
                                                                   if($verificationStatus == -1){
                                                                       
                                                                       $textCheckrequ = 'required';
                                                                   }
                                                                  
                                                              }elseif($explScore[0] == 2){
                                                                  $scoreTwo = 'selected';
                                                                  if($explatarStatus[0] == 'Y'){
                                                                    $sendtoAtar = 'checked';
                                                                    $sendtoAtarcheckclas = 'atarCheckboxsel';
                                                                  }
                                                                  if($verificationStatus == -1){
                                                                       
                                                                       $textCheckrequ = 'required';
                                                                   }
                                                                 
                                                              }elseif($explScore[0] == 3){
                                                                  $scoreThree = 'selected';
//                                                                   if($verificationStatus == -1){
                                                                       $textCheckdisab = 'disabled';
//                                                                    }
                                                                 
                                                              }else{
                                                                   $scoreNA = 'selected';
//                                                                    if($verificationStatus == -1){
                                                                       $textCheckdisab = 'disabled';
                                                                      
//                                                                   }
                                                              }
                                                              
                                                             $atarloctDetails =  getAtarlocationDet($editInspectnid,$datVal);
//                                                         echo "<pre>";
//                                                         print_r($atarloctDetails);
                                                         $atarnewLoca = postData($atarloctDetails,'ATAR_SPEC_LOC_ID');
                                                         $atarnewLocaother = postData($atarloctDetails,'ATAR_SPEC_LOC_OTHER');
                                                              if($explgooPoorRemark[0] != ''){
                                                                  $attRemark = $explgooPoorRemark[0];
                                                              }
                                                          $goodRadkey++;
                                                      }else{
                                                         $scoreThree = 'selected';
                                                      }
//                                                   
//                                                      if($explFileimg[1] == $datVal){
                                                      if($explFileimg[0] != ''){
                                                       if($expBfrimgpath[0] == ''){
                                                         $expBfrimgpath[0]  ='assets/images/modules/inspection/monthly/';
                                                       }
                                                          $finalImgdet = $expBfrimgpath[0].''.$explFileimg[0];
//                                                          if($explFileimg[0] != ''){
                                                          $imageAppend = true;
//                                                          }
                                                      }else{
                                                        
                                                          $finalImgdet = '';
                                                          $imageAppend = false;
                                                      }
                                                     
                                                      if($explChkListfinal[1] == $datVal){
                                                          $checkListeditid = $explChkListfinal[0];
                                                         
                                                      }else{
                                                          $checkListeditid = '';
                                                        
                                                      }
                                                    
                                                 ?>
                                                                                  
                                                                                  <tr class="subtyPData"  dataRow-id="<?php echo $datVal; ?>">
                                                                                      <td style="width:5%">
                                                                                         <?php echo $dataRowid;  ?>
                                                                                          <input type="hidden" name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $datVal; ?>][inspEditid]" <?php echo $disabledStattext; ?> value="<?php echo $checkListeditid; ?>">
                                                                                          
                                                                                          <input type="hidden" class="getSubtypdataID" value="<?php echo $expSubtypdataid[$datKey]; ?>"></td>
                                                                                      <td style="width:32%">
                                                                                          <?php echo $expSubtypdatadesc[$datKey]; ?>
                                                                                          <input type="hidden" name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $datVal; ?>][inspSubtypedata]" <?php echo $disabledStattext; ?> id="inspSubtypedata_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>" value="<?php echo $expSubtypdatadesc[$datKey]; ?>">
                                                                                      </td>
                                                                                      <td style="width:12%">3</td>
                                                                                      <td style="width:12%">
                                                                                          <select name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $datVal; ?>][inspScore]" class="form-control select2 inspScore" <?php echo $disabledStattext; ?>>
                                                                                              <option value="">Select Score</option>
                                                                                              <option value="0" <?php echo $scoreZero ?>>0</option>
                                                                                              <option value="1" <?php echo $scoreOne ?>>1</option>
                                                                                              <option value="2" <?php echo $scoreTwo ?>>2</option>
                                                                                              <option value="3" <?php echo $scoreThree ?>>3</option>
                                                                                              <option value="-1" <?php echo $scoreNA ?>>NA</option>
                                                                                          </select>
                                                                                      </td>
                                                                                      <td style="width:25%">
                                                                                          <textarea name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $datVal; ?>][inspComment]" id="inspComment_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>" class="form-control" <?php echo $textCheckdisab; ?> <?php echo $textCheckrequ; ?> rows="2" cols="5"><?php echo $attRemark; ?></textarea>
                                                                                      </td>
                                                                                      <td style="width:25%" class="checkSafety">
                                                                                    <div class="custom-control custom-checkbox mb-3">
                                                                                      
                                                                                        <input type="hidden" name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $datVal; ?>][inspAtarEditid]" value="<?php echo $editAtarID; ?>" <?php echo $disabledStattext; ?> class="hidAtareditid" id="hidAtareditid_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>">
                                                                                          <input type="checkbox" class="custom-control-input sendAtar <?php echo $sendtoAtarcheckclas; ?>" <?php echo $sendtoAtar; ?> id="inspAtar_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>"  <?php echo $textCheckdisab; ?>   name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $datVal; ?>][inspAtar]" checkboxAvail="avail">
                                                                                          <label class="custom-control-label" for="inspAtar_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>"></label>
                                                                                    </div>
                                                                                   </td>
                                                                                   </tr>
                                                                                   
                                                                                   <?php if($imageAppend){ ?>
                                                                                    <tr class="imgRowdisplay" id="imgRowdisplay_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>">
                                                                                   <?php   if($verificationStatus != -2 && $verificationStatus != -1){ ?>
                                                                                        <td style="width:5%" colspan="1"></td>
                                                                                           <td style="width:40%" colspan="2"><a data-fancybox="gallery" href="<?php echo BASE_URL . $finalImgdet; ?>">
                                                                                                <img class="lazy"  style="height: 150px;width: 250px;" data-src="<?php echo BASE_URL . $finalImgdet; ?>" >
                                                                                            </a></td>
                                                                                            <td colspan="1" style="width:12%"></td>
                                                                                            <td align="center" colspan="1" style="width:25%">
                                                                                                <?php 
                                                                                                if($sendtoAtar == 'checked'){ ?>
                                                                                                <div class="row styleBfrhead <?php echo $displNone ?>  appendAtardetails_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>" style="text-align: center;background:#e6c86a !important;">
                                                                                                    <div class="col-md-12">ATAR Location </div>
                                                                                                </div>

                                                                                                <div class="styleBfrdatas <?php echo $displNone ?> appendAtardetails_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>" style="border: 1px solid #e6c86a !important;padding: 10px;">
                                                                                                    <span class="appendAtarlocation"  id="appendAtarlocation_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>">
                                                       
                                                                                                <select <?php echo $disabledStattext; ?> name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $datVal; ?>][atarLocation]" class="form-control select2 "  style="width:71%" >
                                                                                                    <option value="">Select Location</option>
                                                                                                    <?php 
                                                                                                    $selChecked = '';
                                                                                                    $selCheckedoth = '';
                                                                                                    if(isset($geteachLoctdet) && !empty($geteachLoctdet)){
                                                                                                    foreach($geteachLoctdet as $flgKey => $flgVal){ 
                                                                                                        if($atarnewLoca == $flgVal->SL_AUTO_ID){
                                                                                                            $selChecked = 'selected';
                                                                                                        }else{
                                                                                                            $selChecked = '';
                                                                                                        }
                                                                                                        ?>
                                                                                                        <option value="<?php echo $flgVal->SL_AUTO_ID ?>" <?php echo $selChecked; ?>><?php echo $flgVal->SPECIFIC_LOC_NAME; ?></option>
                                                                                            <?php } }
                                                                                                        if($atarnewLoca == "-1"){
                                                                                                            $selCheckedoth = 'selected';
                                                                                                        }
                                                                                                    ?>
                                                                                                        <option value="-1" <?php echo $selCheckedoth; ?>>Others</option>
                                                                                                </select>
                                                                                                        </span>
                                                 <?php } ?>                                     <?php if($atarnewLoca == '-1'){ ?>
                                                                                               <span id="spanApplocother_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>">
                                                                                                <input type="text" name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $datVal; ?>][atarLocname]" <?php echo $disabledStattext; ?> style="width:71%;margin-top:10px"  class="form-control "   value="<?php echo $atarnewLocaother; ?>">
                                                                                                </span>
                                                                                                  <?php } ?>
                                                                                            </td>
                                                                                            <td style="width:25%" colspan="1">
                                                                                                  
                                                                                            </td>
                                                                                      <?php }else{ 
                                                 
                                                 ?>
                                           <td style="width:5%" colspan="1"></td>
                                            <td style="width:40%" colspan="2">
                                                <div class="appndImgrowedit" id="appendImgrow_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>"><div class="row styleBfrhead" style="text-align: center;background:#e6c86a !important">
                                            <div class="col-md-7">Image</div>
                                            </div>
                        
                                        <div class="styleBfrdatas" style="border: 1px solid #e6c86a !important;"><div class="row" style="margin: 15px;">
                                            <div class="col-md-7"> <div class="form-group imgGroup">

                                                <div class="fileinput fileinput-exists apprFileinput" style="    margin-top: -30px !important;height: 1px; " data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput"><img src="<?php echo BASE_URL . $finalImgdet; ?>" alt="" ></div>
                                                    <p class="mini-txt">(jpg, png, jpeg)</p>
                                                    <div class="file-pop">  <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src="<?php echo BASE_URL .'assets/images/photo.png' ?>" style=" width: 30%; "></span>
                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                            <!--<input type="file" name="beforeImages[]" class='beforeImgclas' accept="image/*" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please document upload is required">-->
                                                            <input type="file" name="beforeImages[]" accept="image/*" id="beforeImg_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>"  ></span>
                                                            <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="user_img[]" class="user_imgClas" value="<?php echo $finalImgdet; ?>" id="userImg_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>">
                                         </div></div>
                            </div></div></div>
                                            </td>
                                            
                                           
                                            <td style="width:12%" colspan="1" >
                                                 
                                               
                                            </td>
                                            <td align="center" style="width:25%" colspan="1">
                                              
                                               <?php if($sendtoAtar != 'checked'){ 
                                                   $displNone = 'd-none';
                                               }else{
                                                   $displNone = '';
                                               }
?>
                                                <div class="row styleBfrhead <?php echo $displNone ?>  appendAtardetails_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>" style="text-align: center;background:#e6c86a !important;">
                                                    <div class="col-md-12">ATAR Location </div>
                                                </div>
                                               
                                                <div class="styleBfrdatas <?php echo $displNone ?> appendAtardetails_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>" style="border: 1px solid #e6c86a !important;padding: 10px;">
                                                    <span class="appendAtarlocation"  id="appendAtarlocation_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>">
                                                        <?php 
                                                 if($sendtoAtar == 'checked'){ ?>
                                               
                                                <select name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $datVal; ?>][atarLocation]" class="form-control select2 atarLocationsel" id="atarLocationsel_<?php echo $expSubtypid ?>_<?php echo $datVal ?>" style="width:71%" required>
                                                    <option value="">Select Location</option>
                                                    <?php 
                                                    $selChecked = '';
                                                    $selCheckedoth = '';
                                                    if(isset($geteachLoctdet) && !empty($geteachLoctdet)){
                                                    foreach($geteachLoctdet as $flgKey => $flgVal){ 
                                                        if($atarnewLoca == $flgVal->SL_AUTO_ID){
                                                            $selChecked = 'selected';
                                                        }else{
                                                            $selChecked = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $flgVal->SL_AUTO_ID ?>" <?php echo $selChecked; ?>><?php echo $flgVal->SPECIFIC_LOC_NAME; ?></option>
                                            <?php } }
                                                        if($atarnewLoca == "-1"){
                                                            $selCheckedoth = 'selected';
                                                        }
                                                    ?>
                                                        <?php if(in_array(-1,$explLocatid)){ ?>
                                                        <option value="-1" <?php echo $selCheckedoth; ?>>Others</option>
                                                        <?php } ?>
                                                </select>
                                                <?php   } ?>
                                                    </span>
                                                    <span id="spanApplocother_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>">
                                                          <?php if($atarnewLoca == '-1'){ ?>
                                                        <input type="text" name="inspcheck[<?php echo $expSubtypid; ?>][<?php echo $datVal; ?>][atarLocname]" readonly style="width:71%;margin-top:10px" class="form-control " id="atarLocname_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>" required value="<?php echo $atarnewLocaother; ?>">
                                                          <?php } ?>
                                                </span>
                                                </div>
                                            </td>
                                            <td style="width:25%" colspan="1">
                                               
                                            </td>
                                           
                          <?php  } ?>
                                        </tr>
                                        <!--<div class="">-->
                                                                                   
                                                                                   <?php 
//                                                                                   $imgInd++;
                                                                                   } ?>
                                        <?php if(!$imageAppend){ 
                                           
                                            ?>
                                        <tr class="imgRowdisplay d-none" id="imgRowdisplay_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>">
                                            <td style="width:5%" colspan="1"></td>
                                            <td style="width:40%" colspan="2">
                                                <div class="appndImgrow" id="appendImgrow_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>">
                                            </div>
                                            </td>
                                            
                                            <td style="width:12%" colspan="1" >
                                                
                                            </td>
                                            <td align="center" style="width:25%" colspan="1">
                                                <div class="row styleBfrhead d-none appendAtardetails_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?> " style="text-align: center;background:#e6c86a !important;">
                                                    <div class="col-md-12">ATAR Location </div>
                                                </div>
                                                <div class="styleBfrdatas d-none appendAtardetails_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>" style="border: 1px solid #e6c86a !important;padding: 10px;">
                                                    
                                                <span class="appendAtarlocation" id="appendAtarlocation_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>"></span>
                                                <span id="spanApplocother_<?php echo $expSubtypid; ?>_<?php echo $datVal; ?>"></span>
                                                </div>
                                            </td>
                                            <td  style="width:25%" colspan="1"></td>
                                        </tr>
                                        <?php } ?>
                                        
                                                                                    <?php  } ?>
                                        
                                                                              </tbody>
                                                                             
                                                                         </table>
                                                                             </div>
                                                                             </div>
                                       <?php }
                                       } ?>
                                   </div>



                            <?php if (empty($getEditinspect)) { ?>
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

    echo form_dropdown('inspec[execName]', $execDesig, $verifyID, $execDatas);
    ?>
                                                        <span class="error"><?php echo form_error('inspec[execName]') ?></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
<?php } ?>

<?php
if ($getHssemaindatas->INSP_APP_STATUS == 1) {
//                                     $extraDetstyl = (!empty($getHssemaindatas)) ? '' : 'd-none';
//                                     $checkStatsafe = (isset($getHssemaindatas->INSP_SAFE_UNSAFE) && $getHssemaindatas->INSP_SAFE_UNSAFE == 1) ? 'checked' : '';
    ?>
                                     
<?php } ?>

                                </div>
                                    
                               <?php 
                               if($verificationStatus != '' && $verificationStatus != -1 && $verificationStatus != '-2'){
                              $granTotdet =  getTotalcount($monInspeditID);
                              
                              $finalGivenscore = postData($granTotdet,'givenScore');
                              $finalMaxscore = postData($granTotdet,'totalScore');
                              
                              $percentScore = ($finalGivenscore/$finalMaxscore)*100;
                                $finalPerscore = round($percentScore,0);
                                $perfStatus = monthlyInspperformanceClasify($finalPerscore);
                                ?>
                                
                                <div class='row m-t-10' style='margin-left: 20%;'>
                                <table class="table  table-bordered" style="width:75%;text-align:center;">
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
                                    </div>
                               <?php } ?>
                                    
                                    <!--accept reject cmnt start-->
                                    <?php 
                                    $accRejcomnts = postData($getHssemaindatas,'MON_INSP_APP_STATUS');
                                    if(in_array($accRejcomnts,[2,-2,3,-3,-4])){
                                    $inspRevcomnts = postData($getHssemaindatas,'MON_INSP_REVIEW_REASON');
                                    $inspVerifycomnts = postData($getHssemaindatas,'MON_INSP_VERIFY_REASON');
                                    $inspApprcomnts = postData($getHssemaindatas,'MON_INSP_APPROVER_REASON');
                                    
                                    if($accRejcomnts == -2 || $accRejcomnts == 2){
                                        $tabHeading1 = 'Reviewer Name';
                                        $rejeReasn = $inspRevcomnts;
                                        $inspRevieId = postData($getHssemaindatas,'MON_INSP_REVIEW_ID');
                                        $inspEmplname = getInspemplname($inspRevieId);
                                        
                                        $reviDatetime = getReviewdatetime($monInspeditID,$inspRevieId,$accRejcomnts);
                                        $fDatetime = date("d-m-Y H:i:s",strtotime($reviDatetime->MON_ACT_INSP_REVIEW_DATE));
                                        
                                        if($accRejcomnts == -2){
                                            $tabHeading2 = 'Reject Comment';
                                        }else{
                                            $tabHeading2 = 'Approve Comment';
                                        }
                                        
                                     }else if($accRejcomnts == -3 || $accRejcomnts == 3){
                                          $tabHeading1 = 'Verifier Name';
                                           $rejeReasn = $inspVerifycomnts;
                                           $inspVerifID = postData($getHssemaindatas,'MON_INSP_VERIFY_ID');
                                           $inspEmplname = getInspemplname($inspVerifID);
                                           
                                           $veriDatetime = getVerifierdatetime($monInspeditID,$inspVerifID,$accRejcomnts);
                                           $fDatetime = date("d-m-Y H:i:s",strtotime($veriDatetime->MON_ACT_INSP_VERIFY_DATE));
                                           if($accRejcomnts == -3){
                                                $tabHeading2 = 'Reject Comment';
                                            }else{
                                                $tabHeading2 = 'Approve Comment';
                                            }
                                     }else if($accRejcomnts == -4){
                                         $tabHeading1 = 'Approver Name';
                                          $rejeReasn = $inspApprcomnts;
                                          $inspApprocId = postData($getHssemaindatas,'MON_INSP_APPROVER_ID');
                                          $inspEmplname = getInspemplname($inspApprocId);
                                          $approDatetime = getApproverdatetime($monInspeditID,$inspApprocId,$accRejcomnts);
                                           $fDatetime = date("d-m-Y H:i:s",strtotime($approDatetime->MON_ACT_INSP_APPROVE_DATE));
                                           
                                          if($accRejcomnts == -4){
                                            $tabHeading2 = 'Reject Comment';
                                        }else{
                                            $tabHeading2 = 'Approve Comment';
                                        }
                                     }
                                    ?>
                                     <div class='row m-t-10' style='margin-left: 20%;'>
                                        <table class="table  table-bordered" style="width:75%;text-align:center;">
                                            <thead style="background:#d6eaef;">
                                                <tr>
                                                    <th><?php echo $tabHeading1; ?></th>
                                                    <th><?php echo $tabHeading2; ?></th>
                                                    <th>Date & Time</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo postData($inspEmplname,'EMP_NAME'); ?></td>
                                                    <td><?php echo $rejeReasn; ?></td>
                                                    <td><?php echo $fDatetime; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                     </div>
                                    <?php } ?>
                                    <!--accept reject cmnt end-->
                                    
    <div class="row reviewCmntdiv d-none" style="margin-left: 25%;">
        <div class="col-md-8">
            <label> Comment</label>
            <textarea name="inspec[reviewComment]" class="form-control" id="reviewComment" rows="2" cols="5"></textarea>
            <span class="error reviewErr"></span>
        </div>
    </div>
    <div class="row verifyCmntdiv d-none" style="margin-left: 25%;">
        <div class="col-md-8">
            <label> Comment</label>
            <textarea name="inspec[verifyComment]" class="form-control" id="verifyComment" rows="2" cols="5"></textarea>
            <span class="error verifyErr"></span>
        </div>
    </div>
    <div class="row approveCmntdiv d-none" style="margin-left: 25%;">
        <div class="col-md-8">
            <label> Comment</label>
            <textarea name="inspec[approveComment]" class="form-control" id="approveComment" rows="2" cols="5"></textarea>
            <span class="error approveErr"></span>
        </div>
    </div>
                                
                                <div class="form-group m-t-10" style="text-align: center;">
                                    <div class="col-sm-offset-2 col-sm-12"> 
<input type="hidden" name="inspec[Reviewstatus]" id="appReviewstatus" class="form-control" value="">
<?php
$saveSuboptn = ['',-1,-2];
$sessUsertyp = getParticsessdata('USER_TYPE_ID');
if(($verificationStatus == 1 || $verificationStatus == -3) && $sessUsertyp == 7){ 
   $data1 = array('id' => 'reviewAccept', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> APPROVE', 'class' => 'reviewBtn btn btn-success');
   $data2 = array('id' => 'reviewReject', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> REJECT', 'class' => 'reviewBtn btn btn-danger');

   echo form_button($data1);
   echo form_button($data2);
}elseif(($verificationStatus == 2 || $verificationStatus == -4) && $sessUsertyp == 8){ 
   $data1 = array('id' => 'verifyAccept', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> APPROVE', 'class' => 'verifyBtn btn btn-success');
   $data2 = array('id' => 'verifyReject', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> REJECT', 'class' => 'verifyBtn btn btn-danger');

   echo form_button($data1);
   echo form_button($data2);
}elseif($verificationStatus == 3 && $sessUsertyp == 9){ 
   $data1 = array('id' => 'approveAccept', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> APPROVE', 'class' => 'approveBtn btn btn-success');
   $data2 = array('id' => 'approveReject', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> REJECT', 'class' => 'approveBtn btn btn-danger');

   echo form_button($data1);
   echo form_button($data2);
}
elseif(in_array($verificationStatus,$saveSuboptn) && ($sessUsertyp == 6 || $sessUsertyp == 1)){ 
//    else{
    if($verificationStatus != -2){
    $data2 = array('id' => 'savein', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE', 'class' => 'submitInsp btn btn-primary ');
    
     echo form_button($data2);
    }
    $data1 = array('id' => 'submitin', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SUBMIT', 'class' => 'submitInsp btn btn-primary ');
    echo form_button($data1);
   
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
<?php 
//echo "<pre>";
//print_R($atarDatas);
//exit;
?>
<script>

    function getAjaxLocation(id) {
        var url = "<?php echo BASE_URL('common/getAjaxLocation') ?>";
        var loctId = '<?php echo $explLocatid; ?>'
        var data = {terminalID: id,loctId:loctId,multiple:true, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
        $.ajax({
            dataType: 'json',
            data: 'ajax',
            method: 'post',
            data: data,
            url: url,
            success: function (resp) {
               
                if(resp.status){
                    $("#location").html(resp.loctdatas)
                    $(".atarLocationsel").html(resp.loctdatas)
                }else{
                    $("#location").html(resp.loctdatas);
                    $(".atarLocationsel").html(resp.loctdatas)
                }
            }
        });

    }
    

    $(document).ready(function () {

        $('.lazy').lazy();
        var today = new Date(); 
         $(".singledaterangepickerbefore").daterangepicker({
            singleDatePicker: true,
            maxDate:today,
            
        locale: {
            format: 'DD-MM-YYYY',

        }
    });
    
   
        
 

        $(document).on("change","#checklistTyp", function () {
            var checklistId = $(this).val();

            
            var editDatas = <?php echo json_encode($getEditinspect); ?>;
            var parseEditdatas = JSON.parse(editDatas);
            var editatarDatas = <?php echo json_encode($atarDatas); ?>;
if(editatarDatas != ''){
var parseatarEditdatas = JSON.parse(editatarDatas);
}else{
var parseatarEditdatas = '';
}
            
            var getAtarlocatdet = <?php echo json_encode($geteachLoctdet); ?>;
            var parseatarSpeclocatdatas = JSON.parse(getAtarlocatdet);
            
//            console.log(parseEditdatas);
           
//            return false;
           
            var url = "<?php echo BASE_URL('inspection/getAjaxinspSubtyp') ?>";
            var data = {checklistId: checklistId, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
            $.ajax({
                dataType: 'json',
                data: 'ajax',
                method: 'post',
                data: data,
                url: url,
                success: function (resp) {
                    
                    var subtyp = resp.getAllsubtyp;
                    var samplImg = '<?php echo BASE_URL("/assets/images/photo.png"); ?>'
                   
//                    return false;
                    var html = '';
                    var atarkey = 0;
                    if (subtyp != '') {
                        $.each(subtyp, function (stInd, stVal) {
                           
                            var subTypID = stVal.INSP_CHECK_SUBTYP_ID;
                            if(subTypID != null){
                              //  var subTypind = parseInt(stInd) + 1;
                               var subTypind = parseInt(subTypID);
                                 var subtypName = stVal.SUBTYPENAME;
                            }else{
                                var subTypind = '0';
                                var subtypName = '';
                            }
                          
                            var subtypdatadesc = stVal.SUBTYPEDATADESC;
                           
                            var subtypdataID = stVal.SUBTYPEDATAID;
                            
                            var splitSubtypdata = subtypdatadesc.split('@');
                            var splitSubtypdataid = subtypdataID.split(',');
                            var subtypData = '';
                            var subtypDet = '';
                            var editScoresplit = '';
                            var editMonchecksplit = '';
                           
                            var editAtarsplit = '';
                            var editRemarksplit = '';
                            var editScore = '';
                            var editMonchecklistid = '';
                            var editAtarstat = '';
                            var editRemark = '';
                            var editfileName = '';
                            
                            ///////////db edit values start
                             console.log("sfds-------->"+parseatarEditdatas[stInd]);
                            if(parseEditdatas[stInd] != '' && parseEditdatas[stInd] != undefined){
                               
                               editMonchecklistid = parseEditdatas[stInd]['checkListid'];
                               editScore = parseEditdatas[stInd]['scoreValue'];
                               editfileName = parseEditdatas[stInd]['fileName'];
                                editAtarstat = parseEditdatas[stInd]['atarStatus'];
                                editRemark = parseEditdatas[stInd]['remaRk'];
                               
                            }
                             
                              
//                             var editScoresplitAt = editScoresplit.split('@');
                           
                            ///////////db edit values end

                            html += ' <div class="row emplDetoth" subtypRow-id="'+subTypind+'" subTypDB-id="'+subTypID+'" style="margin:10px;">\n\
                                     <div class="col-md-12" style="padding: 0px;">\n\
                                    <table class="table table-bordered table-striped checklTab">\n\
                                          <thead class="checklTabhead" style="background: #5a5a59 !important;color:#fff;text-align: center;">\n\
                                         <tr>\n\
                                             <th>S.No</th>\n\
                                             <th>'+subtypName+'</th>\n\
                                            <th>Max Score(3)</th>\n\
                                            <th>Given Score</th>\n\
                                            <th>Comments</th>\n\
                                            <th>Send to ATAR</th>\n\
                                          </tr>\n\
                                          </thead>';
                            html += '<tbody style="text-align: center;">';
                            atarkey = atarkey;
                            $.each(splitSubtypdata, function (daInd, daVal) {
                                
                                var splitAtscore = '';
                               var splitAtatar = '';
                               var splitAtmonCheck = '';
                               
                                 var editSubtypdataId = '';
                                 var editeddbScore = '';
                                 var editeddbMoncheckid = '';
                                 var editeddbAtar = '';
                                
                                 var indKey = parseInt(daInd) + 1;
                                 var subtypedatID = splitSubtypdataid[daInd];
                                 
                                  var editAtarID = '';
                                  var editAtarspeclocID = '';
                                  var editAtarspeclocname = '';
                                  var editfileNamesplit = '';
                                  var splitAtfilename = '';
                                  var editeddbFilename = '';
                                  var appendImgfile = '';
                                   var userImg = $("#userImg_"+subTypind+"_"+subtypedatID).val();
                                               
                                
                                if(parseEditdatas[stInd] != undefined){
                                if(checklistId == parseEditdatas[0]['FK_MON_CHK_LIST_ID']){
                                    if(editMonchecklistid != ''){
                                        editMonchecksplit = editMonchecklistid.split(',');
                                    }
//                                    alert(editScoresplit[daInd])
                                   if(editMonchecksplit != '' && editMonchecksplit[daInd] != undefined){
                                        splitAtmonCheck = editMonchecksplit[daInd].split('@');
//                                         editSubtypdataId = splitAtmonCheck[1];
                                        editeddbMoncheckid = splitAtmonCheck[0];
                                    }
                                    if(editScore != ''){
                                        editScoresplit = editScore.split(',');
                                    }
//                                    alert(editScoresplit[daInd])
                                   if(editScoresplit != '' && editScoresplit[daInd] != undefined){
                                        splitAtscore = editScoresplit[daInd].split('@');
                                         editSubtypdataId = splitAtscore[1];
                                        editeddbScore = splitAtscore[0];
                                    }
                                    if(editAtarstat != ''){
                                        editAtarsplit = editAtarstat.split(',');
                                    }
                                    if(editAtarsplit != '' && editAtarsplit[daInd] != undefined){
                                        splitAtatar = editAtarsplit[daInd].split('@');
                                         editeddbAtar = splitAtatar[0];
                                    }
                                    if(editfileName != ''){
                                        editfileNamesplit = editfileName.split(',');
                                    }
                                    if(editfileNamesplit != '' && editfileNamesplit[daInd] != undefined){
                                        splitAtfilename = editfileNamesplit[daInd].split('@');
                                         editeddbFilename = splitAtfilename[0];
                                    }
                                    
                                    if(editeddbFilename != ''){
                                        var baseUrl = '<?php echo BASE_URL; ?>'
                                        var newFilepath = 'assets/images/modules/inspection/monthly/';
                                        appendImgfile = baseUrl+''+newFilepath+''+editeddbFilename;
                                        userImg = editeddbFilename;
                                    }
                                }
//                                alert(editeddbFilename)
                            }
                            
                            if(parseatarEditdatas[atarkey] != undefined){
                             if(parseatarEditdatas[atarkey]['ATAR_INSP_SUBCAT_ID'] == subtypedatID){
                                    editAtarID = parseatarEditdatas[atarkey]['ATAR_AUTO_ID'];
                                    editAtarspeclocID = parseatarEditdatas[atarkey]['ATAR_SPEC_LOC_ID'];
                                    editAtarspeclocname = parseatarEditdatas[atarkey]['ATAR_SPEC_LOC_OTHER'];
                                    atarkey++;
                              }
                          }
//                               alert(editAtarID)
//                                var finaleditScore = editScoresplitAt[daInd];
                               
                                
                                
                                var editZeroselected = '';
                                var editOneselected = '';
                                var editTwoselected = '';
                                var editThreeselected = '';
                                var editNAselected = '';
                                var editAtarchecked = '';
                                var editRemarkfinal = '';
                               
                                var datasDisabled = 'disabled';
                                
                                if(editSubtypdataId == subtypedatID){
                                    
                                     $('.ajaxLoaddiv').load(' .ajaxLoaddiv');
                                    
                                    if(editRemark != ''){
                                        editRemarksplit = editRemark.split('@');
                                    }
                                    if(editRemarksplit != ''){
                                        editRemarkfinal = editRemarksplit[daInd];
                                    }
                                    
                                   
                                    if(editeddbScore == 0){
                                        editZeroselected = 'selected';
                                        datasDisabled = ''
                                    }
                                    else if(editeddbScore == 1){
                                        editOneselected = 'selected';
                                        datasDisabled = ''
                                    }
                                    else if(editeddbScore == 2){
                                        editTwoselected = 'selected';
                                        datasDisabled = ''
                                    }
                                    else if(editeddbScore == 3){
                                        editThreeselected = 'selected';
                                        
                                    }
                                    else {
                                        editNAselected = 'selected';
                                        
                                    }
                                    if(editeddbAtar == 'Y'){
                                        editAtarchecked = 'checked';
                                    }
                                }
//                                alert(splitAtscore[1])
//                                alert(subtypedatID)
//                                alert(finaleditScore)
                               
                                subtypData += '<tr class="subtyPData" dataRow-id="'+subtypedatID+'">\n\
                                                  <td style="width:5%">'+indKey+'\
                                                    <input type="hidden" name="inspcheck['+subTypind+']['+subtypedatID+'][inspEditid]" '+datasDisabled+' value="'+editeddbMoncheckid+'"></td>\n\
                                                  <td style="width:32%" id="dataQues_'+subTypind+'_'+subtypedatID+'">'+daVal+'<input type="hidden" name="inspcheck['+subTypind+']['+subtypedatID+'][inspSubtypedata]" id="inspSubtypedata_'+subTypind+'_'+subtypedatID+'" value="'+daVal+'"></td>\n\
                                                  <td style="width:12%">3</td>\n\
                                                  <td style="width:12%">\n\
                                                      <select name="inspcheck['+subTypind+']['+subtypedatID+'][inspScore]" checkSelect="select2" class="form-control select2 inspScore" required>\n\
                                                          <option value="">Select Score</option>\n\
                                                          <option value="0" '+editZeroselected+'>0</option>\n\
                                                          <option value="1" '+editOneselected+'>1</option>\n\
                                                          <option value="2" '+editTwoselected+'>2</option>\n\
                                                          <option value="3" '+editThreeselected+'>3</option>\n\
                                                          <option value="-1" '+editNAselected+'>NA</option>\n\
                                                      </select>\n\
                                                  </td>\n\
                                                  <td style="width:25%">\n\
                                                      <textarea name="inspcheck['+subTypind+']['+subtypedatID+'][inspComment]" required '+datasDisabled+' id="inspComment_'+subTypind+'_'+subtypedatID+'" class="form-control" rows="2" cols="5">'+editRemarkfinal+'</textarea>\n\
                                                  </td>\n\
                                                  <td style="width:25%" class="checkSafety">\n\
                                                    <div class="custom-control custom-checkbox mb-3">\n\
                                                            <input type="hidden" name="inspcheck['+subTypind+']['+subtypedatID+'][inspAtarEditid]" value="'+editAtarID+'" class="hidAtareditid" id="hidAtareditid_'+subTypind+'_'+subtypedatID+'">\n\
                                                          <input type="checkbox" class="custom-control-input sendAtar" '+editAtarchecked+' id="inspAtar_'+subTypind+'_'+subtypedatID+'"  '+datasDisabled+' name="inspcheck['+subTypind+']['+subtypedatID+'][inspAtar]" checkboxAvail="avail">\n\
                                                          <label class="custom-control-label" for="inspAtar_'+subTypind+'_'+subtypedatID+'"></label>\n\
                                                    </div>\n\
                                                   </td>\n\
                                               </tr>';
                                       if(appendImgfile != '' && (editeddbScore != 3 || editeddbScore != '-1')){
                                           subtypData += '<tr class="imgRowdisplay" id="imgRowdisplay_'+subTypind+'_'+subtypedatID+'">\n\
                                                            <td style="width:5%" colspan="1"></td>\n\
                                                            <td style="width:40%" colspan="2">\n\
                                                            <div class="appndImgrow" id="appendImgrow_'+subTypind+'_'+subtypedatID+'">\n\
                                                                <div class="row styleBfrhead" style="text-align: center;background:#e6c86a !important">\n\
                            <div class="col-md-7">Image</div>\n\
                            </div>\n\
                         <div class="styleBfrdatas" style="border: 1px solid #e6c86a !important;"><div class="row" style="margin: 15px;">\n\
                            <div class="col-md-7"> <div class="form-group imgGroup">\n\
                                <div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important;height: 1px; " data-provides="fileinput" >\n\
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" ><img src="'+appendImgfile+'"  alt="" /></div>\n\
                                                    <p class="mini-txt">(jpg, png, jpeg)</p>\n\
                                                    <div class="file-pop" >  <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src="' + samplImg + '"  style=" width: 30%; "/></span>\n\
                                                            <span class="fileinput-exists" title="Add Image"></span>\n\
                                                            <input type="file" name="beforeImages[]" id="beforeImg_'+subTypind+'_'+subtypedatID+'" accept="image/*"  class="beforeImgclas"></span>\n\
                                                            <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>\n\
                                                    </div>\n\
                                                </div>\n\
                                                <input type="hidden" name="user_img[]" class="user_imgClas" value="'+userImg+'" id="userImg_'+subTypind+'_'+subtypedatID+'">\n\
                                         </div></div></div>\n\
                            </div></div>\n\
                                                            </td>\n\
                                                    <td colspan="1" style="width:12%"></td>';
                                           if(editAtarID != ''){
                                              
                                             subtypData  += '<td align="center" colspan="1" style="width:25%" >\n\
                                                               <div class="row styleBfrhead appendAtardetails_'+subTypind+'_'+subtypedatID+'"  style="text-align: center;background:#e6c86a !important;">\n\
                                                                    <div class="col-md-12">ATAR Location </div>\n\
                                                                </div>\n\
                                                            <div class="styleBfrdatas appendAtardetails_'+subTypind+'_'+subtypedatID+' "  style="border: 1px solid #e6c86a !important;padding: 10px;">\n\
                                                                <span class="appendAtarlocation" id="appendAtarlocation_'+subTypind+'_'+subtypedatID+'"></span>\n\
                                                                <select name="inspcheck['+subTypind+']['+subtypedatID+'][atarLocation]" style="width: 71%;" id="atarLocationsel_'+subTypind+'_'+subtypedatID+'" class="form-control select2 atarLocationsel" required>\n\
                                                                '+selOptnaratlocation(parseatarSpeclocatdatas,editAtarspeclocID)+'</select>\n\
                                                            </span>';
                                    if(editAtarspeclocID == '-1'){
                                            subtypData  += '<span id="spanApplocother_'+subTypind+'_'+subtypedatID+'">\n\
                                                <input type="text" name="inspcheck['+subTypind+']['+subtypedatID+'][atarLocname]" readonly style="margin-top:10px;width:71%" class="form-control atarLocname" id="atarLocname_'+subTypind+'_'+subtypedatID+'" value="'+editAtarspeclocname+'" required></span></td>'
                                           }
                                           }else{
                                               subtypData += '<td align="center" style="width:25%" colspan="1" >\n\
                                                <div class="row styleBfrhead appendAtardetails_'+subTypind+'_'+subtypedatID+' d-none"  style="text-align: center;background:#e6c86a !important;">\n\
                                                    <div class="col-md-12">ATAR Location </div>\n\
                                                </div>\n\
                                            <div class="styleBfrdatas appendAtardetails_'+subTypind+'_'+subtypedatID+' d-none"  style="border: 1px solid #e6c86a !important;padding: 10px;">\n\
                                                <span class="appendAtarlocation" id="appendAtarlocation_'+subTypind+'_'+subtypedatID+'"></span>\n\
                                                <span id="spanApplocother_'+subTypind+'_'+subtypedatID+'"></span></div>\n\
                                            </div></td>\n\
                                            <td style="width:25%" colspan="1">\n\
                                            </td>';
                                           }
                                                       subtypData +=  '</tr>';
                                       }else{
                                         subtypData += ' <tr class="imgRowdisplay d-none" id="imgRowdisplay_'+subTypind+'_'+subtypedatID+'">\n\
                                            <td style="width:5%" colspan="1"></td>\n\
                                            <td style="width:40%" colspan="2"><div class="appndImgrow" id="appendImgrow_'+subTypind+'_'+subtypedatID+'"></div>\n\
                                            <td style="width:12%" colspan="1" ></td>\n\
                                            <td align="center" style="width:25%" colspan="1" >\n\
                                                <div class="row styleBfrhead appendAtardetails_'+subTypind+'_'+subtypedatID+' d-none"  style="text-align: center;background:#e6c86a !important;">\n\
                                                    <div class="col-md-12">ATAR Location </div>\n\
                                                </div>\n\
                                            <div class="styleBfrdatas appendAtardetails_'+subTypind+'_'+subtypedatID+' d-none"  style="border: 1px solid #e6c86a !important;padding: 10px;">\n\
                                                <span class="appendAtarlocation" id="appendAtarlocation_'+subTypind+'_'+subtypedatID+'"></span>\n\
                                                <span id="spanApplocother_'+subTypind+'_'+subtypedatID+'"></span></div>\n\
                                            </div></td>\n\
                                            <td style="width:25%" colspan="1">\n\
                                            </td>\n\
                                          </tr>';
                                       }
//                                       if()
                            });
                             html += subtypData+'</tbody>\n\
                                      </table>\n\
                                         </div>\n\
                                         </div>';
                        });
                        
                        $(".submitInsp").removeClass('d-none');
                       }

                    $(".appendChecklist").html(html);
                    $(".select2").select2();
                 
                }
            });
        });

       
        $(document).on("change", ".inspScore", function () {
          
//            alert('fdhgfhg')
            var getSubtyprow = $(this).parent().closest('.emplDetoth').attr('subtypRow-id');
            var getSubtypDBrow = $(this).parent().closest('.emplDetoth').attr('subTypDB-id');
            var getSubtypdatarow = $(this).parent().closest('.subtyPData').attr('datarow-id');
            
//            var getcheckedRadioval = $(this).find("select[name='inspcheck[" + getSubtypDBrow + "][" + getSubtypdatarow + "][inspScore]']").val();
            var getcheckedRadioval = $(this).val();
//alert(getSubtyprow)
//alert(getSubtypdatarow)
//alert(getcheckedRadioval)

            var cmntVal = $("#inspComment_"+getSubtyprow+"_"+getSubtypdatarow).val();
            var userImg = $("#userImg_"+getSubtyprow+"_"+getSubtypdatarow).val();
//            alert(userImg);
//            return false;
            var beforeDatas = '';
           
            var imgApp = 'https://www.placehold.it/230x140/EFEFEF/AAAAAA&amp;text=no+image';
            if (getcheckedRadioval < '3' && getcheckedRadioval != '-1' && getcheckedRadioval != '') {

            if(userImg != '' && userImg != undefined && userImg != 'undefined'){
                var baseUrl = '<?php echo BASE_URL(); ?>';
                 imgApp = baseUrl+''+userImg;
            }
//            alert(imgApp)
// $('.imgclasErr').html(function(i, val) { return +val+1 });

                var samplImg = '<?php echo BASE_URL("/assets/images/photo.png"); ?>'
                beforeDatas += '<div class="row styleBfrhead" style="text-align: center;background:#e6c86a !important">\n\
                            <div class="col-md-7">Image</div>\n\
                            </div>\n\
                        </div>\n\
                        <div class="styleBfrdatas" style="border: 1px solid #e6c86a !important;"><div class="row" style="margin: 15px;">\n\
                            <div class="col-md-7"> <div class="form-group imgGroup">\n\
\n\<div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important;height: 1px; " data-provides="fileinput" >\n\
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" ><img src="'+imgApp+'" alt="" /></div>\n\
                                                    <p class="mini-txt">(jpg, png, jpeg)</p>\n\
                                                    <div class="file-pop" style="">  <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src="' + samplImg + '"  style=" width: 30%; "/></span>\n\
                                                            <span class="fileinput-exists" title="Add Image"></span>\n\
                                                            <input type="file" name="beforeImages[]" id="beforeImg_'+getSubtyprow+'_'+getSubtypdatarow+'" accept="image/*"  class="beforeImgclas"></span>\n\
                                                            <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>\n\
                                                    </div>\n\
                                                </div>\n\
                                                <input type="hidden" name="user_img[]" class="user_imgClas" value="'+userImg+'" id="userImg_'+getSubtyprow+'_'+getSubtypdatarow+'">\n\
                                         </div></div>\n\
                            </div></div>';
                $("#imgRowdisplay_" + getSubtyprow + "_" + getSubtypdatarow).removeClass('d-none');
                $("#appendImgrow_" + getSubtyprow + "_" + getSubtypdatarow).html(beforeDatas);
                $("#inspAtar_"+ getSubtyprow + "_" + getSubtypdatarow).removeAttr('disabled');
                $("#inspComment_"+ getSubtyprow + "_" + getSubtypdatarow).removeAttr('disabled');
//                $("#inspComment_"+getSubtyprow+"_"+getSubtypdatarow).val('');
//                reValidate();
               
            } else {
                $("#imgRowdisplay_" + getSubtyprow + "_" + getSubtypdatarow).addClass('d-none');
                $("#appendImgrow_" + getSubtyprow + "_" + getSubtypdatarow).html(beforeDatas);
                 $("#inspAtar_"+ getSubtyprow + "_" + getSubtypdatarow).attr('disabled','disabled');
                 $("#inspAtar_"+ getSubtyprow + "_" + getSubtypdatarow).prop("checked",false);
                $("#inspComment_"+ getSubtyprow + "_" + getSubtypdatarow).attr('disabled','disabled');
              $("#inspComment_"+ getSubtyprow + "_" + getSubtypdatarow).val('');
//              $("#appendAtarlocation_"+ getSubtyprow + "_" + getSubtypdatarow).remove();
//              $(".appendAtardetails_"+ getSubtyprow + "_" + getSubtypdatarow).remove();
              $("#appendAtarlocation_"+ getSubtyprow + "_" + getSubtypdatarow).addClass('d-none');
              $(".appendAtardetails_"+ getSubtyprow + "_" + getSubtypdatarow).addClass('d-none');
            }
        });

        $('.submitInsp').on("click", function (e) {
            var safeVal = $("#safeStatus:checked").val();
             var idval = $(this).attr('id');

            if(idval != 'submitin'){
                $("#appReviewstatus").val('-1');
            }else{
                $("#appReviewstatus").val('');
            }
            
//            reValidate();
            
             var geLngth = $(".beforeImgclas").length;
             var geLngthhiden = $(".user_imgClas").length;
    
    var i;
   
    for(i=0;i< geLngth;){
        var imgeVal = $(".beforeImgclas").eq(i).val();
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
           

            if (idval == 'submitin') {

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

                                $("#company-profile").submit();
                            }
                        });
            } else {
               
                swal({
                    title: "Are you sure ",
                    text: "You want to save the Inspection",
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
                                $("#company-profile").submit();
                            }
                        });
            }
        })
        
        $(".reviewBtn").on("click",function(e){
            
             var reviewVal = $(this).attr('id');
            
            if (reviewVal == 'reviewAccept') {
                $("#appReviewstatus").val('2');
                $("#reviewAccept").removeClass('d-none');
                $("#reviewReject").addClass('d-none');
            }else{
                 $("#appReviewstatus").val('-2');
                  $("#reviewAccept").addClass('d-none');
                   $("#reviewReject").removeClass('d-none');
            }
            
            $(".reviewCmntdiv").removeClass('d-none');
            
           var varCmn = $("#reviewComment").val();
            
            e.preventDefault();
           
            
            if (reviewVal == 'reviewAccept' && varCmn != '') {

                swal({
                    title: "Are you sure ",
                    text: "<b>You want to Approve the Inspection</b>",
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

                                $("#company-profile").submit();
                            }
                        });
            }
            if (reviewVal == 'reviewAccept' && varCmn == ''){
                $(".reviewErr").html("Review Approve comment is required");
            } 
            if(reviewVal == 'reviewReject' && varCmn != '') {
               
                swal({
                    title: "Are you sure ",
                    text: "<b>You want to Reject the Inspection</b>",
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
                                $("#company-profile").submit();
                            }
                        });
            }
            if(reviewVal == 'reviewReject' && varCmn == '') {
                $(".reviewErr").html("Review Reject comment is required");
            } 
        })
        
        $(".verifyBtn").on("click",function(e){
            
             var verifyVal = $(this).attr('id');
            
            if (verifyVal == 'verifyAccept') {
                $("#appReviewstatus").val('3');
                $("#verifyAccept").removeClass('d-none');
                $("#verifyReject").addClass('d-none');
            }else{
                 $("#appReviewstatus").val('-3');
                  $("#verifyAccept").addClass('d-none');
                   $("#verifyReject").removeClass('d-none');
            }
            
            $(".verifyCmntdiv").removeClass('d-none');
            
           var varCmn = $("#verifyComment").val();
            
            e.preventDefault();
           
            
            if (verifyVal == 'verifyAccept' && varCmn != '') {

                swal({
                    title: "Are you sure ",
                    text: "<b>You want to Approve the Inspection</b>",
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

                                $("#company-profile").submit();
                            }
                        });
            } 
            if (verifyVal == 'verifyAccept' && varCmn == '') {
                $(".verifyErr").html("Verification Approve comment is required");
            } 
            if(verifyVal == 'verifyReject' && varCmn != '') {
               
                swal({
                    title: "Are you sure ",
                    text: "<b>You want to Reject the Inspection</b>",
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
                                $("#company-profile").submit();
                            }
                        });
            }
            if(verifyVal == 'verifyReject' && varCmn == '') {
                $(".verifyErr").html("Verification Reject comment is required");
            } 
        })
        $(".approveBtn").on("click",function(e){
            
             var verifyVal = $(this).attr('id');
            
            if (verifyVal == 'approveAccept') {
                $("#appReviewstatus").val('4');
                $("#approveAccept").removeClass('d-none');
                $("#approveReject").addClass('d-none');
            }else{
                 $("#appReviewstatus").val('-4');
                  $("#approveAccept").addClass('d-none');
                   $("#approveReject").removeClass('d-none');
            }
            
            $(".approveCmntdiv").removeClass('d-none');
            
           var varCmn = $("#approveComment").val();
            
            e.preventDefault();
           
            
            if (verifyVal == 'approveAccept' && varCmn != '') {

                swal({
                    title: "Are you sure ",
                    text: "<b>You want to Approve the Inspection</b>",
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

                                $("#company-profile").submit();
                            }
                        });
            }
            if(verifyVal == 'approveAccept' && varCmn == '') {
                $(".approveErr").html("Approve comment is required");
            } 
            if(verifyVal == 'approveReject' && varCmn != '') {
               
                swal({
                    title: "Are you sure ",
                    text: "<b>You want to Reject the Inspection</b>",
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
                                $("#company-profile").submit();
                            }
                        });
            } 
            if(verifyVal == 'approveReject' && varCmn == '') {
                $(".approveErr").html("Reject comment is required");
            } 
        })
        
        $(document).on("click",".sendAtar",function(){
//           var checkVal = $(this).val();
           var checkVal = $(this).prop('checked');
           var editid = '<?php echo $monInspeditID; ?>';
           var idVal = $(this).attr('id');
           var splitId = idVal.split("_");
           var typId = splitId[1];
           var subtypId = splitId[2];
           var retuTyp = false;
           
//           $(".select2").select2();
           var checkListsame = true;
           
           var newCheckval = $("#checklistTyp").val();
           var oldCheckval = $("input[name='inspec[hidenchecklistTyp]']").val();
           
          
          
           if(newCheckval != oldCheckval){
              checkListsame = false;
           }
          
            var terminal = $("#terminal").val();
            var location = $("#location").val();
            
            var locationText = $("#location option:selected").map(function () {
                    return $(this).text();
            }).get().join(',');
   
//            var locationText = $("#location").find(":selected").text();
            var locatnLength = location.length;
            var comntData = $("#inspComment_"+typId+"_"+subtypId).val();
            var subtypeDatadesc = $("#inspSubtypedata_"+typId+"_"+subtypId).val();
            var checklistScore = $("select[name='inspcheck["+typId+"]["+subtypId+"][inspScore]']").val();
            var baseUrl = '<?php echo BASE_URL(); ?>';
            var checklistId = $("input[name='inspcheck["+typId+"]["+subtypId+"][inspEditid]']").val();
            
             var atarLoselval = $("#atarLocationsel_"+typId+"_"+subtypId).val();
             var atarLonameinpval = $("#atarLocname_"+typId+"_"+subtypId).val();
//           alert(atarLoselval)
//           alert(atarLonameinpval)
            var selLocatn = '<select name="inspcheck['+typId+']['+subtypId+'][atarLocation]" style="width: 71%;" id="atarLocationsel_'+typId+'_'+subtypId+'" class="form-control select2 atarLocationsel" required>\n\
                            </select>'
             $("#appendAtarlocation_"+typId+"_"+subtypId).removeClass('d-none');
             $(".appendAtardetails_"+typId+"_"+subtypId).removeClass('d-none');
             $("#appendAtarlocation_"+typId+"_"+subtypId).html(selLocatn);
//             if(location != '' && checkVal){
             if(location != ''){
//                if(atarLoselval == '' || atarLoselval == undefined){
//                  alert('dddddddddddd')
                 var appnewLoc = '<option value="">Select Location</option>';
                 var splitLoc = locationText.split(",");
                
                 $.each(location,function(lKey,lVal){
                     appnewLoc += '<option value="'+lVal+'">'+splitLoc[lKey]+'</option>'
                 })
                $("#atarLocationsel_"+typId+"_"+subtypId).html(appnewLoc);
//                $("#appendAtarlocation_"+typId+"_"+subtypId).removeClass('d-none');
                if(atarLoselval != ''){
                    $("#atarLocationsel_"+typId+"_"+subtypId).val(atarLoselval);
                    var locOther = '<input type="text" name="inspcheck['+typId+']['+subtypId+'][atarLocname]" style="margin-top:10px;width:71%" class="form-control atarLocname" id="atarLocname_'+typId+'_'+subtypId+'" required>'
                    if(atarLoselval == '-1'){
//                       $("#atarLocationsel_"+typId+"_"+subtypId).after(locOther);
                       $("#atarLocname_"+typId+"_"+subtypId).removeClass('d-none');
                       $("#atarLocname_"+typId+"_"+subtypId).val(atarLonameinpval);
                   }
                }

            }else{
                $("#appendAtarlocation_"+typId+"_"+subtypId).addClass('d-none');
                $(".appendAtardetails_"+typId+"_"+subtypId).addClass('d-none');
                $("#atarLocname_"+typId+"_"+subtypId).addClass('d-none');
                retuTyp = true;
            }
           
//          alert(appnewLoc);
         
        if(editid != '' && checkListsame){
            
            
              var atareditId = $(this).siblings(".hidAtareditid").val();
               var url = '<?php echo BASE_URL("inspection/updateAtarinspection"); ?>';
              if(atareditId != ''){
                 if(checkVal){
                      //////////////send to atar
                    var eachAtarloc = $("#atarLocationsel_"+typId+"_"+subtypId).val();
                  var eachAtarlocother = $("#atarLocname_"+typId+"_"+subtypId).val();
                  if(eachAtarloc == ''){
                      swal('Error','ATAR Location is required','warning');
                      $(this).prop('checked', false);
                      finRet = false;
                  }  
                  if(eachAtarloc == '-1' && eachAtarlocother == ''){
                       swal('Error','ATAR Other Location is required','warning');
                      $(this).prop('checked', false);
                      finRet = false;
                  }
                  
                  
                       var datass = new FormData();
                       var imgIds = 'beforeImg_'+typId+'_'+subtypId;
                       var userImg = $('#userImg_'+typId+'_'+subtypId).val();
                       if(userImg != ""){
                           datass.append('userImg',userImg);
                       }else{
                           datass.append('beforeImages[]', $( '#'+imgIds )[0].files[0]);
                       }
                      
                        datass.append('newsend', true);
                        datass.append('checklistId', checklistId);
                        datass.append('subtypId', subtypId);
                        datass.append('terminal', terminal);
                        datass.append('location', location);
                        datass.append('inspId', editid);
                        datass.append('comntData', comntData);
                        datass.append('checklistScore', checklistScore);
                        datass.append('subtypeDatadesc', subtypeDatadesc);
                        
                        datass.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
                        
//                      var data = {atarId:atareditId,send:true,checklistId:checklistId,subtypId:subtypId,terminal:terminal,location:location,inspId:editid,comntData:comntData,checklistScore:checklistScore, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
// var data = datass;
                        swal({
                    title: "Are you sure ",
                    text: "<b>You want to send to ATAR</b>",
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
                                
                                 $.ajax({
                                    url: url,
                                     method: 'POST',
                                    "data": datass,
                                    async : false,
                                    cache:false,
                                    processData:false,
                                    contentType:false,
//                                    enctype: 'multipart/form-data',
                                   
                                    type : 'ajax',
                                    dataType : 'json',
                                    success: function(resp){
                                        unloader();
                                        var atarStatus = resp.status;
                                        var atarMsg = resp.msg;
                                        if(atarStatus){
                                            swal("Success",atarMsg,'success');
                                        }else{
                                            swal("Sorry",atarMsg,'error');
                                        }
                                        $('.ajaxLoaddiv').load(' .ajaxLoaddiv');
                                    }
                                   
                                  });
                                  
                            }else{
                                 $("#inspAtar_"+typId+"_"+subtypId).prop('checked',false);
//                                 $("#appendAtarlocation_"+typId+"_"+subtypId).remove();
                               
                            }
                        });
                   }else{
                       /////////////unsend to atar
//                       alert('unheck')
//                       alert(checklistId)
                   var data = {atarId:atareditId,unsend:true,checklistId:checklistId, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
                 swal({
                    title: "Are you sure ",
                    text: "<b>You want to unsend to ATAR</b>",
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
                                 $.ajax({
                                    url: url,
                                    data: data,
                                    async : false,
                                    cache : false,
                      //              processData: false,
                      //              contentType: false,
                                    method: 'POST',
                                    type : 'ajax',
                                    dataType : 'json',
                                    success: function(resp){
                                        unloader();
                                        var atarStatus = resp.status;
                                        var atarMsg = resp.msg;
                                        if(atarStatus){
                                            swal({
                                                title: "Success!",
                                                text: atarMsg,
                                                type: "success",
                                                timer: 3000,
                                             });
//                                            swal("Success",atarMsg,'success');
                                        }else{
                                            swal("Sorry",atarMsg,'error');
                                        }
                                        $('.ajaxLoaddiv').load(' .ajaxLoaddiv');
                                      
                                    }
                                  });
                            }else{
                                
//                              inspAtar_0_8
                                $("#inspAtar_"+typId+"_"+subtypId).prop('checked','checked');
                                $("#appendAtarlocation_"+typId+"_"+subtypId).removeClass('d-none');
                                $(".appendAtardetails_"+typId+"_"+subtypId).removeClass('d-none');
                                $("#atarLocname_"+typId+"_"+subtypId).removeClass('d-none');
                               
                             
                            }
                        });
              }
              }else{
              if(checkVal){
//                  alert('dgfdhgfhfgh')
              var finRet = true;
                  if(terminal == ''){
                      swal('Error','Terminal is required','warning');
                      $(this).prop('checked', false);
                      finRet = false;
                  }  
                  if(location == ''){
                      swal('Error','Location is required','warning');
                      $(this).prop('checked', false);
                      finRet = false;
                  }  
                  if(comntData == ''){
                      swal('Error','Comment is required','warning');
                      $(this).prop('checked', false);
                      finRet = false;
                  }  
                  
                  var eachAtarloc = $("#atarLocationsel_"+typId+"_"+subtypId).val();
                  var eachAtarlocother = $("#atarLocname_"+typId+"_"+subtypId).val();
                  var eachAtarImageval = $("#beforeImg_"+typId+"_"+subtypId).val();
                  var eachAtaruserImageval = $("#userImg_"+typId+"_"+subtypId).val();
                  if(eachAtarloc == ''){
                      swal('Error','ATAR Location is required','warning');
                      $("#inspAtar_"+typId+"_"+subtypId).addClass('atarCheckboxsel');
                      $(this).prop('checked', false);
                      finRet = false;
                  }  
                  if(eachAtarloc == '-1' && eachAtarlocother == ''){
                       swal('Error','ATAR Other Location is required','warning');
                      $(this).prop('checked', false);
                      finRet = false;
                  }
                  if((eachAtarImageval  == '' || eachAtarImageval == undefined || eachAtarImageval == 'undefined') && (eachAtaruserImageval == '' || eachAtaruserImageval == undefined || eachAtaruserImageval == 'undefined')){
                       swal('Error','Image is required','warning');
                      $(this).prop('checked', false);
                      finRet = false;
                  }
                 
                  if(finRet ){
//                  if(retuTyp ){
                      var datass = new FormData();
                       var imgIds = 'beforeImg_'+typId+'_'+subtypId;
                        var userImg = $('#userImg_'+typId+'_'+subtypId).val();
                       if(userImg != "" && userImg != 'undefined'){
                           datass.append('userImg',userImg);
                       }else{
                           datass.append('beforeImages[]', $( '#'+imgIds )[0].files[0]);
                       }
                       
//                        datass.append('beforeImages[]', $( '#'+imgIds )[0].files[0]);
                        datass.append('newsend', true);
                        datass.append('checklistId', checklistId);
                        datass.append('subtypId', subtypId);
                        datass.append('terminal', terminal);
                        datass.append('location', location);
                        datass.append('inspId', editid);
                        datass.append('comntData', comntData);
                        datass.append('checklistScore', checklistScore);
                        datass.append('subtypeDatadesc', subtypeDatadesc);
                        datass.append('speciLocatn', eachAtarloc);
                        datass.append('speciLocatnother', eachAtarlocother);
                        
                        datass.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
                        
//                      var data = {newsend:true,checklistId:checklistId,subtypId:subtypId,terminal:terminal,location:location,inspId:editid,comntData:comntData,checklistScore:checklistScore, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
                 
                  swal({
                    title: "Are you sure ",
                    text: "<b>You want to send to ATAR</b>",
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
                                $("#appendAtarlocation_"+typId+"_"+subtypId).removeClass('d-none');
                                $(".appendAtardetails_"+typId+"_"+subtypId).removeClass('d-none');
                                $("#atarLocname_"+typId+"_"+subtypId).removeClass('d-none');
                                 $.ajax({
                                    url: url,
                                    data: datass,
                                    async : false,
                                    cache : false,
                                    processData: false,
                                    contentType: false,
                                    method: 'POST',
                                    type : 'ajax',
                                    dataType : 'json',
                                    success: function(resp){
                                        unloader();
                                        var atarStatus = resp.status;
                                        var atarMsg = resp.msg;
                                        var atarID = resp.atarID;
                                        $("#hidAtareditid_"+typId+"_"+subtypId).val(atarID);
                                        if(atarStatus){
                                            swal({
                                                title: "Success!",
                                                text: atarMsg,
                                                type: "success",
                                                timer: 3000,
                                             });
//                                            swal("Success",atarMsg,'success');
                                        }else{
                                            swal("Sorry",atarMsg,'error');
                                        }
                                        $('.ajaxLoaddiv').load(' .ajaxLoaddiv');
                                    }
                                  });
                                  
                            }else{
                                $("#inspAtar_"+typId+"_"+subtypId).prop('checked',false)
                                 $("#appendAtarlocation_"+typId+"_"+subtypId).addClass('d-none');
                                 $(".appendAtardetails_"+typId+"_"+subtypId).addClass('d-none');
                                $("#atarLocname_"+typId+"_"+subtypId).addClass('d-none');
                            }
                        });
//                  }
                  }
              }else{
                    $("#inspAtar_"+typId+"_"+subtypId).removeClass('atarCheckboxsel');
                     swal({
                       title: "Are you sure you want to unsend to ATAR ?",
                       text: "<b>Once inspection submitted will be unsend to ATAR </b>",
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
                                $(this).prop("checked",false);
                            }else{
                                $(this).prop("checked",true);
                            }
                   });
              }
              }  

}else{

          if(checkVal){
//           $(this).prop("checked",false);
            finRet = true;

                if(atarLoselval == "" || atarLoselval == undefined){
                  swal('Error','ATAR Location is required','warning');
                      $(this).prop('checked', false);
                      $("#inspAtar_"+typId+"_"+subtypId).addClass('atarCheckboxsel');
                      finRet = false;
                  }  
                  if(atarLoselval == '-1' && atarLonameinpval == ''){
                       swal('Error','ATAR Other Location is required','warning');
                      $(this).prop('checked', false);
                      finRet = false;
                  }
                  if(finRet){
            swal({
                       title: "Are you sure you want to send to ATAR ?",
                       text: "<b>Once inspection submitted, will be send to ATAR </b>",
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
 //                                 $(this).prop("checked",true);
                                 $("#inspAtar_"+typId+"_"+subtypId).prop("checked",true);
                            }else{
//                               $(this).prop("checked",false);
                                  $("#inspAtar_"+typId+"_"+subtypId).prop("checked",false);
                            }
            
           })
           }
    }else{
        $("#inspAtar_"+typId+"_"+subtypId).removeClass('atarCheckboxsel');
        swal({
                       title: "Are you sure You want to unsend to ATAR ?",
                       text: "<b>Once inspection submitted,will be unsend to ATAR </b>",
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
                                $(this).prop("checked",false);
                            }else{
                                $(this).prop("checked",true);
                            }
                       

           })
    }
          }
      
        })
        
        $(document).on("change","#location", function () {
            var locval = $(this).val();
            var locvalText = $(this).text();
            var loctOther = '<?php echo $monLoctother; ?>'
            var loctOtherdisabl = '<?php echo $disabledStattextLocatn; ?>';
            var difference = [];
            var editLoctid = '<?php echo json_encode($explLocatid); ?>';
            var parsedLocid = JSON.parse(editLoctid);
           
            var diff = $(parsedLocid).not(locval).get();
            
//            $.each(diff,function(difKey,difVal){
//                
//                $(".atarLocationsel option[value='"+difVal+"']").remove();
//              
//            })
            

           var appendLoc = '';
            if (locval.indexOf("-1") >= 0){
                appendLoc += '<div class="form-group">\n\
                               <label>Other Location<span class="error"> * </span></label>\n\
                                <input type="text" '+loctOtherdisabl+' name="inspec[locationOther]" id="locationOther" class="form-control locationOther" value="'+loctOther+'">\n\
                              </div>'
               $(".appendotherLoc").html(appendLoc)
            }
        });
        
        $("#location").change();
        
        $(document).on('change','.atarLocationsel',function(){
//            alert('ATAR_STATUS')
            var idVal = $(this).attr('id');
            var locId = $(this).val();
             var splitId = idVal.split("_");
            var typId = splitId[1];
            var subtypId = splitId[2];
            var origLocother = $("#locationOther").val();
//            alert(locId)
            var locOther = '<input type="text" name="inspcheck['+typId+']['+subtypId+'][atarLocname]" value="'+origLocother+'" readonly style="margin-top:10px;width:71%" class="form-control atarLocname" id="atarLocname_'+typId+'_'+subtypId+'" required>'
            if(locId == '-1'){
                $("#atarLocname_"+typId+"_"+subtypId).removeClass('d-none');
//                $("#atarLocationsel_"+typId+"_"+subtypId).after(locOther);
                $("#spanApplocother_"+typId+"_"+subtypId).html(locOther);
            }else{
                $("#atarLocname_"+typId+"_"+subtypId).addClass('d-none');
            }
        });

    });
    
    $(document).ready(function(){
    
    /* $.validator.addMethod('filesize', function (value, element, param) {
           
            return this.optional(element) || (Math.round(element.files[0].size / (1024 * 1024)) <= 5)
        }, 'File size must be less than 5MB'); */


        $.validator.addClassRules("atarLocationsel", {
            required: true,
           
        });
        $.validator.addClassRules("atarCheckboxsel", {
            required: true,
           
        });
      
      /*  $.validator.addClassRules("beforeImgclas", {
             filesize : true
        }); */
        


        $("#company-profile").validate({
//            ignore: [],
            rules: {

                "inspec[insp_date]": {
                    required: true,
                },

                "inspec[terminal]": {
                    required: true,
                },
                "inspec[location]": {
                    required: true,
                },

                "inspec[locationOther]": {
                    required: true,
                  //  alphaspace: true,
                    maxlength: 20,
                    minlength: 3
                },
                "inspec[checklistTyp]": {
                    required: true,
                },
//                "inspcheck[atarLocation]": {
//                    required: true,
//                },
               
//                "beforeImages[]": {
//                    required: true,
//                    accept: 'jpg|jpeg|png'
//            }

//                "inspec[ovrerallNotes]": {
//                    required: true,
//                 },

            },
            messages: {

                "inspec[insp_date]": {
                    required: "Inspection Date is required",
                },

                "inspec[terminal]": {
                    required: "Terminal is required",
                },
                "inspec[location]": {
                    required: "Location is required",
                },
                "inspec[locationOther]": {
                    required: "Location Name is required",
                    
                },

                "inspec[checklistTyp]": {
                    required: "Checklist Type is required",
                    
                },

//               "inspec[ovrerallNotes]": {
//                    required: "Note is required",
//                },

            },
            errorPlacement: function (error, element) {

                if (element.attr('checkSelect') == 'select2') {
                    error.insertAfter(element.next('.select2-container'));
                }
                else if (element.attr('checkboxAvail') == 'avail') {
                    error.insertAfter(element.next('.custom-control-label'));
                } else {
                    error.insertAfter(element);
                    element.closest(".imgGroup").last().append(error);
                }
            },

        });
        
       

    })
    
   function selOptnaratlocation(locatVal,editAtid){
      
       var editLoctid = '<?php echo json_encode($explLocatid); ?>';
       var parsedLocid = JSON.parse(editLoctid)
      
       var optnVal = '';
       var optnsel = '';
       var optnselOther = '';
       $.each(locatVal,function(lKey,lVal){
           if(editAtid == lVal.SL_AUTO_ID){
               optnsel = 'selected';
           }
           else{
               optnsel = '';
           }
           optnVal += '<option value='+lVal.SL_AUTO_ID+' '+optnsel+'>'+lVal.SPECIFIC_LOC_NAME+'</option>'
       
    })
    if(jQuery.inArray("-1", parsedLocid) !== -1){
        if(editAtid == '-1'){
            optnselOther = 'selected';
        }else{
            optnselOther = '';
        }
           optnVal += '<option value="-1" '+optnselOther+'>Others</option>'
       }
       return optnVal;
   }
   
   
</script>

<!--<input type="file" name="beforeImages['+getSubtyprow+'][]" accept="image/*,.pdf,.doc" required></span>\n\-->

