<?php
$ATAR_ID = postData($editData, 'ATAR_ID');
$Reporter = postData($editData, 'Reporter');
$desig = postData($editData, 'desig');

$loc_name = postData($editData, 'loc_name');
$spec_loc_name = postData($editData, 'spec_loc_name');

$ATAR_REPORT_DATETIME = date('d-m-Y H:i:s', strtotime(postData($editData, 'ATAR_REPORT_DATETIME')));


$usee = postData($editData, 'usee');
$uact = postData($editData, 'uact');
$ATAR_USEE_WHAT_RECCOM = postData($editData, 'ATAR_USEE_WHAT_RECCOM');
$ATAR_UACT_WHAT = postData($editData, 'ATAR_UACT_WHAT');
$ATAR_SPEC_LOC_OTHER = postData($editData, 'ATAR_SPEC_LOC_OTHER');

$ATAR_HSSE_DATE_TARGET = date('d-m-Y', strtotime(postData($editData, 'ATAR_HSSE_DATE',date('d-m-Y'))));

$ATAR_ASSIGN_HOD_DATE_ACTUAL = date('d-m-Y', strtotime(postData($editData, 'ATAR_ASSIGN_HOD_DATE')));
//print_r($ATAR_ASSIGN_HOD_DATE_ACTUAL);exit;
$ATAR_ASSIGN_HOD_DESC = postData($editData, 'ATAR_ASSIGN_HOD_DESC');

$ATAR_REJECT_HSSE_DESC = postData($editData, 'ATAR_REJECT_HSSE_DESC');

$Hod = postData($editData, 'Hod');
$Hsse = postData($editData, 'Hsse');
$Unithead = postData($editData, 'Unithead');
$ATAR_ASSIGN_HSSE_DESC = postData($editData, 'ATAR_ASSIGN_HSSE_DESC');
$ATAR_APP_STATUS = postData($editData, 'ATAR_APP_STATUS');
$ATAR_ASSIGN_HOD_ID = postData($editData, 'ATAR_ASSIGN_HOD_ID');
$ATAR_MAIN_CAT_ID = postData($editData, 'ATAR_MAIN_CAT_ID');
$mainCat = postData($editData, 'mainCat');
//print_r($editData);exit;

$executiveList = getExecutiveUnitHead('drop');
$unitList = getAtarUnitHead('drop');
 $userid = getCurrentUserid();
 $user_type = getCurrentUserGroupId();
 global $atarPermission;
?>

<style>
    .viewpage {
        /*        font-size: 14px;*/
    }
    .newhr {
        margin-top: 15px;
        margin-bottom: 15px;
        border-color: white;
    }
    .card-header-inner{
        color: #fff;
        background-color: #007bff;
        font-weight: bold;
        text-transform: uppercase;
    }
    .card-link{
        color: #fff;
    }
    .card-header a:hover{
        color: #fff;
    }
    .red{
        color:red;
    }
    .removeItem:not(:disabled):not(.disabled).active, .removeItem:not(:disabled):not(.disabled):active, .removeItem,.removeItem:hover{
        color: #fff;
        background-color: red;
        border-color:red;
    }
    .uppertext{
        text-transform: uppercase;
    }
    .card-header-cc {
        color: #fff;
        background-color: green;
    }
    .docLabel{
        margin-left: 15px;
    }


    .tdlabel{
        width:23%;
    }
    .title-head{
        text-transform: uppercase;
    }
    .title-colon{
        width:1%;
    }
    .imagepopcombine:hover .popupgal {
        opacity: 1;
    }
    .popupgal{
        position: absolute;
        font-size: 3rem !important;
        color: #fff;
        opacity: 0;
        transition: .2s opacity ease-in-out;
        z-index: 5;
        background: #b7b7b77d;
        min-width: 82%;
        min-height: 90%;
        max-width: 90%;
        top: 0;
        text-align: center;
        border: 2px solid #007cb7;
    }
    .popupgal i{
        margin-top: 25%;
    }
      .imgupload{
        width: 100%;
        height: 100%;
    }
    .fileinput img{
        width: 100%;
        height: 100%;
    }
    .mini-txt{
        text-align: center;
    }

</style>
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div id="accordion" class="permitAccordion">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">


                            <!-- general form elements -->
                            <div class="card card-headprimary">

                                <div class="card-header headingStyl ">

                                    <h4 class='title-head'>ATAR [ U-See U-Act ] </h4>
                                    <a href="javascript:history.back()"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>

                                </div>
                                <div class="card-body">
                                    <?php
                                    $getstatusid = isset($editData->ATAR_AUTO_ID) && !empty($editData->ATAR_AUTO_ID) ? $editData->ATAR_AUTO_ID : '';
                
                                    $groupid = getCurrentUserGroupId(); 
                                    if((($groupid == 6 || $groupid == 7) || is_admin()) && $ATAR_APP_STATUS == 1 ){
                                        $url = 'atar/usee/saveStatus/';
                                    }else if($ATAR_APP_STATUS == 4 ||$ATAR_APP_STATUS == 7 ){
                                        $url = 'atar/usee/saveCADetails/';
                                    }else if($ATAR_APP_STATUS == 3 && $ATAR_MAIN_CAT_ID == ""){
                                        $url = 'atar/usee/saveCatDetails/';
                                    }
                                    else{
                                        $url = 'atar/usee/saveApproveDetails/';
                                    }

                                    ?>
                                    <?php echo form_open_multipart($url . $getstatusid, 'class="form-horizontal" id="company-profile" novalidate'); ?>

                                    <div class="card">
                                        <div class="card-header card-header-inner">
                                            U-See U-Act<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>ATAR ID</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($ATAR_ID != '') ? $ATAR_ID : '-'; ?></td>
                                                            <td class="tdlabel"><b>Reporter Name</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($Reporter != '') ? $Reporter : '-'; ?></td>
                                                            
                                                        </tr>

                                                        <tr>
                                                            <td class="tdlabel"><b>Position</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($desig != '') ? $desig : '-'; ?></td>

                                                            <td class="tdlabel"><b>Location</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($loc_name != '') ? $loc_name : '-'; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Specific Location</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($ATAR_SPEC_LOC_OTHER != '') ? $ATAR_SPEC_LOC_OTHER  : $spec_loc_name; ?>
                                                            </td>

                                                            <td class="tdlabel"><b>Date and Time</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($ATAR_REPORT_DATETIME != '') ? $ATAR_REPORT_DATETIME : '-'; ?></td>

                                                        </tr>
                                                        
                                                              <?php if($mainCat != '' ){ ?>
                                                        <tr>
                                                            <td class="tdlabel"><b>Category</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($mainCat != '') ? $mainCat : '-'; ?></td>
                                                        </tr>
                                                        <?php }?>

                                                            
                                                       
                                                    </table>
                                                   
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                             U-See Detail<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>U-See Type</b></td>
                                                            <td>:</td>
                                                            <td colspan="4"><?php echo ($usee != '') ? $usee : '-'; ?></td> 
                                                        </tr>

                                                        <tr>
                                                            <td class="tdlabel"><b>What did I see ?</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($ATAR_USEE_WHAT_RECCOM != '') ? $ATAR_USEE_WHAT_RECCOM : '-'; ?></td>

                                                        </tr>
                                                      
                                                    </table>
                                                    <?php if ($getuseeimage != FALSE) { ?>
                                                    <label>&nbsp;&nbsp;&nbsp;Uploaded Images :</label>
                                                    <div class="row col-md-12">
                                                        
                                                        <?php
                                               
                                                            foreach ($getuseeimage as $akey => $attachmnt) {
                                                                $filepath = postData($attachmnt, 'ATAR_FILE_PATH');
                                                                $filename = postData($attachmnt, 'ATAR_FILENAME');
                                                                $fileext = postData($attachmnt, 'ATAR_FILE_EXT');
                                                                $fileFullpath = BASE_URL . $filepath.$filename;
                                                                $displayLabel = ($filepath !='') ? '<img src="' . $fileFullpath . '"/><div class="popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>' : $filename;
                                                                ?>
                                                                <div class="col-md-3 imagepopcombine" id='imagepopcombine_<?php echo $akey; ?>'>
                                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;"><?php echo $displayLabel; ?></div>
                                                                    </div>      
                                                                </div>

                                                                <?php
                                                            }
                                                            ?>
                                                        
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                             U-Act Detail<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>U-Act Type</b></td>
                                                            <td>:</td>
                                                            <td colspan="4"><?php echo ($uact != '') ? $uact : '-'; ?></td> 
                                                        </tr>

                                                        <tr>
                                                            <td class="tdlabel"><b>What did I Do ? </b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($ATAR_UACT_WHAT != '') ? $ATAR_UACT_WHAT : '-'; ?></td>
                                                        </tr>
                                                      
                                                    </table>
                                                     <?php
                                                        if ($getuactimage != FALSE) { ?>
                                                    <label>&nbsp;&nbsp;&nbsp;Uploaded Images :</label>
                                                    <div class="row col-md-12">
                                                        
                                                        <?php
                                                      
                                                            foreach ($getuactimage as $akey => $attachmnt) {
                                                                
                                                                $filepath = postData($attachmnt, 'ATAR_FILE_PATH');
                                                                $filename = postData($attachmnt, 'ATAR_FILENAME');
                                                                $fileext = postData($attachmnt, 'ATAR_FILE_EXT');
                                                                $fileFullpath = BASE_URL . $filepath.$filename;
                                                                $displayLabel = ($filepath !='') ? '<img src="' . $fileFullpath . '"/><div class="popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>' : $filename;
                                                                ?>
                                                                <div class="col-md-3 imagepopcombine" id='imagepopcombine_<?php echo $akey; ?>'>
                                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;"><?php echo $displayLabel; ?></div>
                                                                    </div>      
                                                                </div>

                                                                <?php
                                                            }
                                                            ?>
                                                        
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                         <?php if($ATAR_APP_STATUS > 2 && $ATAR_ASSIGN_HOD_ID != 0){ ?>
                                                                   
                                     <div class="card ">
                                        <div class="card-header card-header-inner">
                                             Action Details<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>Assigned By</b></td>
                                                            <td>:</td>
                                                            <td colspan="4"><?php echo ($Hsse != '') ? $Hsse : '-'; ?></td> 
                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Unit Head</b></td>
                                                            <td>:</td>
                                                            <td colspan="4"><?php echo ($Unithead != '') ? $Unithead : '-'; ?></td> 
                                                        </tr>
                                                       
                                                        <tr>
                                                            <td class="tdlabel"><b>Assigned Person</b></td>
                                                            <td>:</td>
                                                            <td colspan="4"><?php echo ($Hod != '') ? $Hod : '-'; ?></td> 
                                                        </tr>

                                                        <tr>
                                                            <td class="tdlabel"><b>Targeted Date to complete action</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($ATAR_HSSE_DATE_TARGET != '') ? $ATAR_HSSE_DATE_TARGET : '-'; ?></td>
                                                        </tr>
                                                           <?php if($ATAR_APP_STATUS > 4 || $ATAR_APP_STATUS == 3){ ?>
                                                         <tr>
                                                            <td class="tdlabel"><b>Description entered by HOD</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($ATAR_ASSIGN_HOD_DESC != '') ? $ATAR_ASSIGN_HOD_DESC : '-'; ?></td>
                                                        </tr>
                                                      
                                                        <tr>
                                                            <td class="tdlabel"><b>Date Closed</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($ATAR_ASSIGN_HOD_DATE_ACTUAL != '') ? $ATAR_ASSIGN_HOD_DATE_ACTUAL : '-'; ?></td>
                                                        </tr>
                                                        <?php }?>
                                                        <?php if($ATAR_ASSIGN_HSSE_DESC != '' && $ATAR_APP_STATUS == 3){ ?>
                                                        <tr>
                                                            <td class="tdlabel"><b>Reason for Approval</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($ATAR_ASSIGN_HSSE_DESC != '') ? $ATAR_ASSIGN_HSSE_DESC : '-'; ?></td>
                                                        </tr>
                                                         <?php }?>
                                                            <?php if($ATAR_REJECT_HSSE_DESC != '' && $ATAR_APP_STATUS >= 5){ ?>
                                                        <tr>
                                                            <td class="tdlabel"><b>Reason for Rejection</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($ATAR_REJECT_HSSE_DESC != '') ? $ATAR_REJECT_HSSE_DESC : '-'; ?></td>
                                                        </tr>
                                                        <?php }?>
                                                       
                                                      
                                                    </table>
                                                     <?php
                                                        if ($getuafterimage != FALSE) { ?>
                                                    <label>&nbsp;&nbsp;&nbsp;Uploaded Images :</label>
                                                    <div class="row col-md-12">
                                                        
                                                        <?php
                                                      
                                                            foreach ($getuafterimage as $akey => $attachmnt) {
                                                                $filepath = postData($attachmnt, 'ATAR_FILE_PATH');
                                                                $filename = postData($attachmnt, 'ATAR_FILENAME');
                                                                $fileext = postData($attachmnt, 'ATAR_FILE_EXT');
                                                                $fileFullpath = BASE_URL . $filepath.$filename;
                                                                $displayLabel = ($filepath !='') ? '<img src="' . $fileFullpath . '"/><div class="popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>' : $filename;
                                                                ?>
                                                                <div class="col-md-3 imagepopcombine" id='imagepopcombine_<?php echo $akey; ?>'>
                                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;"><?php echo $displayLabel; ?></div>
                                                                    </div>      
                                                                </div>

                                                                <?php
                                                            }
                                                            ?>
                                                       
                                                    </div>
                                                     <?php } ?>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                         <?php } ?> 
                                    <?php if ((in_array($user_type, $atarPermission['approve']) && $ATAR_APP_STATUS == 1) || (is_admin() && $ATAR_APP_STATUS == 1)) {?>
                                     <div class="card">
                                        <div class="card-header card-header-inner">
                                             Status Details<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-4">
                                                    <label>Status <span class="error"> * </span></label>
                                                   <?php
                                                    $statusDetails = [
                                                        'id' => 'ATAR_APP_STATUSS',
                                                        'class' => 'form-control select2',
                                                        'checkSelect' => 'select2'
                                                    ];
                                                    $atarStatusType = [
                                                        '' => 'Select Status',
                                                        '4' => 'Accept',
                                                        '3' => 'Close',
                                                        '2' => 'Irrelevant'
                                                    ];
                                                    echo form_dropdown('usee[ATAR_APP_STATUSS]', $atarStatusType, $ATAR_APP_STATUS, $statusDetails);
                                                    echo form_hidden('usee[ATAR_APP_STATUS]', $ATAR_APP_STATUS);
                                                    ?>
                                                    <label class="error"><?php echo form_error('usee[ATAR_APP_STATUSS]') ?></label>
                                               
                                                </div>
                                                <div class="col-sm-4 m-b-10 status_post">
                                            
                                                        <label>Unit Head <span class="error"> * </span></label>
                                                        <?php
                                                        $exeunitdata = [
                                                            'class' => 'form-control select2',
                                                            'id' => 'ATAR_ASSIGN_UNIT_ID',
                                                            'checkSelect' => 'select2',
                                                        ];
                                                        echo form_dropdown('usee[ATAR_ASSIGN_UNIT_ID]', $unitList, $ATAR_ASSIGN_HOD_ID, $exeunitdata);
                                                        ?>
                                                        <span class="error"><?php echo form_error('usee[ATAR_ASSIGN_UNIT_ID]') ?></span>

                                                </div>
                                                
                                                <div class="col-sm-4 m-b-10 status_post">
                                            
                                                        <label>Executive / Contractor <span class="error"> * </span></label>
                                                        <?php
                                                        $exedata = [
                                                            'class' => 'form-control select2',
                                                            'id' => 'ATAR_ASSIGN_HOD_ID',
                                                            'checkSelect' => 'select2',
                                                        ];
                                                        echo form_dropdown('usee[ATAR_ASSIGN_HOD_ID]', $executiveList, $ATAR_ASSIGN_HOD_ID, $exedata);
                                                        ?>
                                                        <span class="error"><?php echo form_error('usee[ATAR_ASSIGN_HOD_ID]') ?></span>

                                                </div>
                                                 <div class="col-md-4 status_post">

                                                    <label >Target Date <span class="error"> * </span></label><br>
                                                    <div>

                                                        <?php
                                                        $data = array(
                                                            'name' => 'usee[ATAR_HSSE_DATE]',
                                                            'id' => 'ATAR_HSSE_DATE',
                                                            'placeholder' => '',
                                                            'class' => 'form-control datepicker',
                                                            'autocomplete' => 'off',
                                                            'value' => $ATAR_HSSE_DATE_TARGET,
                                                            
                                                        );

                                                        echo form_input($data);
                                                        ?>  

                                                    </div>

                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php } ?>
                                    <?php if ((in_array($user_type, $atarPermission['fix']) && $ATAR_ASSIGN_HOD_ID == $userid && ($ATAR_APP_STATUS == 4 ||$ATAR_APP_STATUS == 7 )) || (is_admin() && ($ATAR_APP_STATUS == 4 || $ATAR_APP_STATUS == 7))) {?>
                                    
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                             Action Taken<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-sm-12">
                                            <!-- textarea -->
                                                    <div class="form-group">
                                                        <label>Description<span class="error">*</span></label>
                                                        <?php
                                                        $desc = isset($ATAR_ASSIGN_HOD_DESC) && !empty($ATAR_ASSIGN_HOD_DESC) ? $ATAR_ASSIGN_HOD_DESC : "";
                                                        $cdesc = array(
                                                            'name' => 'useeafterfix[ATAR_ASSIGN_HOD_DESC]',
                                                            'id' => 'ATAR_ASSIGN_HOD_DESC',
                                                            'placeholder' => 'Enter Description',
                                                            'class' => 'form-control',
                                                            'value' => $desc,
                                                            'rows' => 4,
                                                            'cols' => 4,
                                                            'autocomplete' => 'off'
                                                        );
                                                        echo form_textarea($cdesc);
                                                        ?>
                                                        <span class="error"><?php echo form_error('useeafterfix[ATAR_ASSIGN_HOD_DESC]') ?></span>
                                                    </div>
                                        </div>
                                               <div class="col-md-12">
                                                   
                                                    <span class="btn btn-xs btn-success  float-right addMorcerti"><i class="fa fa-plus-square"> Add More</i></span>
                                                </div>
                                               <div class="col-md-12 ">

                                        <?php
                                        if (isset($getuafterimage) && !empty($getuafterimage)) {
                                            //  echo "<pre>";
                                            //   print_r($getUseeActdatas);exit;
                                            ?>

                                            <div class="othercertiDet" certiRow-id="<?php echo $useeRowval; ?>">
 <label>Image Upload </label>
                                                <div class="row m-t-10 m-l-10 addMorecompet">
                                                  
 <?php
                                                    foreach ($getuafterimage as $othKey => $othVal) {
                                                        $useeRowval = $othKey + 1;
                                                        $useeID = postData($othVal, 'ATAR_ATT_ID');
                                                        $useeimgpath = postData($othVal, 'ATAR_FILE_PATH');
                                                        $useeimgname = postData($othVal, 'ATAR_FILENAME');

                                                        if ($useeimgname != '') {
                                                            $useeFilepath = $useeimgpath.$useeimgname;;
                                                        } else {
                                                            $useeFilepath = '';
                                                        }
                                                        ?>
                                                        <div class="col-sm-4" style="margin-top:30px;">

                                                            
                                                           
                                                            <div class="form-group">

                                                                <div class="fileinput fileinput-new apprFileinput" style="margin-top: -30px !important; " data-provides="fileinput" >
                                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                                        <?php
                                                                        if ($useeFilepath != '') {
                                                                            ?>
                                                                            <img src='<?php echo BASE_URL . $useeFilepath; ?>' alt='<?php echo $useeimgname; ?>' style="height: 100%;"/>     
                                                                        <?php } ?>
                                                                    </div>
                                                                    <p class="mini-txt">(png, jpeg, jpg )</p>
                                                                    <div class="file-pop" >                                                    
                                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src='<?php echo BASE_URL("/assets/images/photo.png"); ?>'  style=" width: 30%; "/></span>
                                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                                            <input type="file" name="useeafterfix[]" class="atarfile" accept="image/*"></span>

                                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="other_user_img[]" value="<?php echo $useeFilepath; ?>">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                                <?php
                                            } else {
                                                ?>
                                                <div class="othercertiDet" certiRow-id="1">


                                                    <div class="row m-t-10 m-l-10 addMorecompet">

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Image Upload </label>
                                                                <div class="fileinput fileinput-new apprFileinput" style="margin-top: -30px !important; " data-provides="fileinput" >
                                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                                        <?php
                                                                        if ($useeFilepath != '') {
                                                                            ?>
                                                                            <img src='<?php echo BASE_URL . $useeFilepath ?>' alt='<?php echo $useeimgname; ?>' style="height: 100%;"/>     
                                                                        <?php } ?>
                                                                    </div>
                                                                    <p class="mini-txt">(png, jpeg, jpg )</p>
                                                                    <div class="file-pop" >                                                    
                                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src='<?php echo BASE_URL("/assets/images/photo.png"); ?>'  style=" width: 30%; "/></span>
                                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                                            <input type="file" name="useeafterfix[]" class="atarfile"  accept="image/*"></span>

                                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="other_user_img[]" value="<?php echo $useeFilepath; ?>">

                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>

                                            <?php } ?>



                                        </div>
                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                     <?php } ?>
                                     <?php if ((in_array($user_type, $atarPermission['approve']) && $ATAR_APP_STATUS == 5) || (is_admin() && $ATAR_APP_STATUS == 5)) {?>
                                   
                                     <div class="card ">
                                        <div class="card-header card-header-inner">
                                             Approve Details<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12">
                                                      <div class="form-group">
                                                        <label>Reason<span class="error">*</span></label>
                                                        <?php
                                                            $reason = isset($ATAR_ASSIGN_HSSE_DESC) && !empty($ATAR_ASSIGN_HSSE_DESC) ? $ATAR_ASSIGN_HSSE_DESC : "";
                                                        if($reason ==''){
                                                            $reason = isset($ATAR_REJECT_HSSE_DESC) && !empty($ATAR_REJECT_HSSE_DESC) ? $ATAR_REJECT_HSSE_DESC : "";
                                                        }
                                                        $cdesc = array(
                                                            'name' => 'useeapprove[ATAR_ASSIGN_HSSE_DESC]',
                                                            'id' => 'ATAR_ASSIGN_HSSE_DESC',
                                                            'placeholder' => 'Enter Reason',
                                                            'class' => 'form-control',
                                                            'value' => $reason,
                                                            'rows' => 4,
                                                            'cols' => 4,
                                                            'autocomplete' => 'off'
                                                        );
                                                        echo form_textarea($cdesc);
                                                        ?>
                                                        <span class="error"><?php echo form_error('useeapprove[ATAR_ASSIGN_HSSE_DESC]') ?></span>
                                                    </div>
                                                </div>
                                                
                                              
                                            </div>
                                        </div>
                                          <div class="form-group m-t-10" style="text-align: center;">
                                        <div class="col-sm-offset-2 col-sm-12"> 

                                             <input type="submit" class="btn btn-success " name="useeapprove[approve]" value="Approve"/>
                                                     <input type="submit" class="btn btn-danger " name="useeapprove[reject]" value="Reject"/>
                                               
                                        </div>
                                    </div>
                                    </div>
                                    
                                     <?php } ?>
                                    <?php if ((in_array($user_type, $atarPermission['approve'] ) && ($ATAR_APP_STATUS == 1 || $ATAR_APP_STATUS == 3) && $ATAR_MAIN_CAT_ID == '') || (is_admin() && ($ATAR_APP_STATUS == 1 || $ATAR_APP_STATUS == 3) && $ATAR_MAIN_CAT_ID == '')) {?>
                                   
                                     <div class="card cat_detail_status">
                                        <div class="card-header card-header-inner">
                                             Category Details<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                
                                                 <div class="col-sm-4 m-b-10">
                                            
                                                        <label>Category <span class="error"> * </span></label>
                                                        <?php
                                                        $catdata = [
                                                            'class' => 'form-control select2',
                                                            'id' => 'ATAR_MAIN_CAT_ID',
                                                            'checkSelect' => 'select2',

                                                        ];
                                                        echo form_dropdown('useeCat[ATAR_MAIN_CAT_ID]', $getmainCat, $ATAR_MAIN_CAT_ID, $catdata);
                                                        ?>
                                                        <span class="error"><?php echo form_error('useeCat[ATAR_MAIN_CAT_ID]') ?></span>

                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                     <?php } ?>
                                     <?php if (((in_array($user_type, $atarPermission['approve'] ) && $ATAR_APP_STATUS == 3 && $ATAR_MAIN_CAT_ID == '') 
                                            || (is_admin() && $ATAR_APP_STATUS == 3 && $ATAR_MAIN_CAT_ID == ''))
                                            || ((in_array($user_type, $atarPermission['fix']) && $ATAR_ASSIGN_HOD_ID == $userid && ($ATAR_APP_STATUS == 4 ||$ATAR_APP_STATUS == 7 ))
                                                    || (is_admin() && ($ATAR_APP_STATUS == 4 || $ATAR_APP_STATUS == 7)))
                                                    || ((in_array($user_type, $atarPermission['approve']) && $ATAR_APP_STATUS == 1) || (is_admin() && $ATAR_APP_STATUS == 1))
                                            ) {?>
                                    <div class="form-group m-t-10" style="text-align: center;">
                                        <div class="col-sm-offset-2 col-sm-12"> 

                                            <?php
                                            $data = array('id' => 'submit', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SUBMIT', 'class' => 'btn btn-primary');
                                            echo form_button($data);
                                            ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php echo form_close(); ?> 
                                </div> 
                            </div>
                            <!-- /.card -->

                        </div>
                        <!--/.col (left) -->

                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<script type="text/javascript">
function dateData(){
   
     $(".datepicker").datepicker({
            autoclose: true,
            startDate: new Date(),
            format: 'dd-mm-yyyy'
        }).on('changeDate', function (selected) {

            var minDate = new Date(selected.date.valueOf());

        });
       
}
    $(document).ready(function () {
        
        dateData();
        $(".status_post").hide();
        $('#ATAR_APP_STATUSS').on('change', function () {
          // alert(this.value);
            if (this.value == 4){
            
                $(".status_post").show();
                dateData();
            } else{
                $(".status_post").hide();
            }
        }).trigger("change");
        
        $('#ATAR_APP_STATUSS').on('change', function () {
           //alert(this.value);
            if (this.value == 2){
            
                $(".cat_detail_status").hide();
                dateData();
            } else{
                $(".cat_detail_status").show();
            }
        }).trigger("change");
        
         $.validator.addMethod('accept_address', function (value) {
            return /^[a-zA-Z0-9\/\\n\s,.'-_*()+&^$#@!% ]{1,}$/.test(value);
        }, "Please Enter a valid data");
        
          $.validator.addMethod('filesize', function (value, element, param) {
           
            return this.optional(element) || (Math.round(element.files[0].size / (1024 * 1024)) <= 5)
        }, 'File size must be less than 5MB');

        $.validator.addClassRules("atarfile", {
            accept: "png|jpe?g|gif",
            required: false,
            filesize : true
        });
        

        $("#company-profile").validate({
            ignore: [],
            success: function (error) {
                error.removeClass("error");
                error.addClass("d-none");
            },

            rules: {

                "usee[ATAR_APP_STATUSS]": {
                    required: true
                },
                "usee[ATAR_ASSIGN_HOD_ID]": {
		    required: function () {
			if ($("#ATAR_APP_STATUSS").val() == '4') {
			    return true;
			} else {
			    return false;
			}
		    }
		},
                "usee[ATAR_ASSIGN_UNIT_ID]": {
		    required: function () {
			if ($("#ATAR_APP_STATUSS").val() == '4') {
			    return true;
			} else {
			    return false;
			}
		    }
		},
//                "usee[ATAR_HSSE_DATE]": {
//                    required: true
//                },
//                "usee[ATAR_ASSIGN_HOD_ID]": {
//                    required: true
//                },
                "useeafterfix[ATAR_ASSIGN_HOD_DESC]": {
                    required: true,
                    accept_address: true
                   //  programming_char:true
                },
                "useeapprove[ATAR_ASSIGN_HSSE_DESC]": {
                    required: true,
                    accept_address: true
                    // programming_char:true
                },
                "useeCat[ATAR_MAIN_CAT_ID]": {
                   required: function () {
			if ($("#ATAR_APP_STATUSS").val() == '2') {
			    
                            return false;
			} else {
			    return true;
			}
		    }
                    
                },

            },
            messages: {
                "usee[ATAR_APP_STATUSS]": {
                    required: "Status is required"
                },
                "usee[ATAR_ASSIGN_UNIT_ID]": {
                     required: "Unit Head is required"
                },
                "usee[ATAR_ASSIGN_HOD_ID]": {
                     required: "Executive / Contractor is required"
                },
                "useeafterfix[ATAR_ASSIGN_HOD_DESC]": {
                    required: "Description is required"
                },
                 "useeapprove[ATAR_ASSIGN_HSSE_DESC]": {
                     required: "Reason is required"
                },
                 "useeCat[ATAR_MAIN_CAT_ID]": {
                     required: "Category is required"
                },

            },
            errorPlacement: function (error, element) {

                if (element.attr('checkSelect') == 'select2') {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                    element.closest(".imgGroup").last().append(error);
                }
            },submitHandler: function (form) {
                swal({
                    title: "Please wait..",
                    imageUrl: loadingImg,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                form.submit();
            }

        });
    });
</script>
<script>
    $(document).on('click', '.addMorcerti', function () {

        var baseUrl = '<?php echo BASE_URL; ?>'
        var lastUsee = $(this).parents().eq(2).next().find(".othercertiDet").last().attr("certiRow-id");

        var newUseerow = parseInt(lastUsee) + 1;
        var html = '<div class="col-sm-4" style="">\n\
  <span class="float-right removeCertinew">\n\
<i class="fa fa-trash"></i>\n\
</span>\n\
<div class="form-group">\n\
<div class="fileinput fileinput-new apprFileinput" style="" data-provides="fileinput">\n\
<div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput">\n\
</div>\n\
<p class="mini-txt">(png, jpeg, jpg )</p>\n\
<div class="file-pop">\n\
<span class="text-green btn-file">\n\
<span class="photo fileinput-new" title="Add Image">\n\
<img class="imgupload" src="' + baseUrl + '/assets/images/photo.png" style=" width: 30%; ">\n\
</span>\n\
<span class="fileinput-exists" title="Add Image">\n\
</span>\n\
<input type="file" name="useeafterfix[]" class="atarfile" accept="image/*">\n\
</span>\n\
<button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image">\n\
<i class="fa fa-times-circle-o" aria-hidden="true"></i>\n\
</button>\n\
</div>\n\
</div>\n\
<input type="hidden" name="other_user_img[]" value="">\n\
</div>\n\
</div>\n\
';
        $(".addMorecompet").append(html);

    })
    $(document).on('click', '.removeCertinew', function () {
        $(this).closest('.col-sm-4').remove();
    })
</script>
