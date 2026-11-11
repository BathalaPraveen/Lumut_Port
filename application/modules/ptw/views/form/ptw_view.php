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

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {
        .datepicker {
            top:290px !important;
        }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
        .datepicker {
            top:300px !important;
        }
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
    
</style>
<div class="wrapper">
    <?php
    $permitNumber = postData($editData, 'LIVE_PERMIT_NO');
    $applicantNumber = postData($editData, 'APPLICANT_NAME');
    $companyName = postData($editData, 'COMPANY_NAME', '-');
    $sectionName = postData($editData, 'SECTION_NAME');
    $specificLocationName = postData($editData, 'SPECIFIC_WORKSITE');
    $locName = postData($editData, 'LOCATION_NAME');
    $startDate = postData($editData, 'START_DATE');
    $endDate = postData($editData, 'END_DATE');
    $displayStartDate = convertDate($startDate, PTW_DATE_FORMAT);
    $displayEndDate = convertDate($endDate, PTW_DATE_FORMAT);
    $areaClsName = postData($editData, 'AREA_OF_CLASSIFICATION_NAME', '-');
    $workDesc = postData($editData, 'WORK_DESCRIPTION', '-');
    $specificWorkInst = postData($editData, 'SPECIFIC_WORK_INSTRUCTION', '-');
    $specificWorkInstOption = postData($editData, 'SPECIFIC_WORK_INSTRUCTION_OPTION', 0);
    $sectionAttachment = postData($additionalData, 'sectionAttachment');
    $hazardActivity = postData($additionalData, 'hazardActivity');
    $checkFalse = '&#10005;';
    $checkTrue = '&#10004;';
    $designationName = postData($editData, 'APPLICANT_DESIGNATION_NAME', '-');

    $hazardActivityHirarcInfo = postData($additionalData, 'hazardActivityHirarcInfo');
    $showsection6 = FALSE;
    $PTWStatus = postData($editData,'STATUS');

$sc1fName = postData($editData,'SEC1_FILENAME');
$sc1fPath = postData($editData,'SEC1_FILEPATH');

$sec1Imgupl = (isset($sc1fName) && !empty($sc1fName)) ? BASE_URL.''.$sc1fPath.''.$sc1fName : '';
    ?>

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
                                    <div class="row">
                                    <div class="col-md-6">
                                    <h4 class='title-head'>View <?php echo $permitTypeName; ?> </h4></div>
                                    <div class="col-md-6  float-right " >
                                    <a href="<?php echo $backURL ?>"><button type="button" class="btn btn-primary float-right"><i class="fa fa-arrow-left"></i> Back</button></a>
                                    
                                    <?php  if($PTWStatus >=6){?>
                                     <a class="btn btn-primary float-right" style="margin-right:10px;"  href="<?php echo BASE_URL.'/ptw/permit/generateSancFormPdf/'.$editId;?>" class="" title="PDF" target="_blank"><i class="fa fa-download" aria-hidden="true" style="color:#FFF;"></i>&nbsp;Download Sanctioning form </a>
                                     <?php } ?>
                                     </div>
                                        </div>
                                </div>
                                <div class="card-body">
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                            Section 1 – Requisition – Permit Applicant of Performing Authority (PA)<span class="float-right"></span>

                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>Permit No</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo $permitNumber; ?></td>
                                                            <td class="tdlabel"><b>Applicant Name</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $applicantNumber; ?></td>

                                                        </tr>
                                                        
                                                        <tr>
                                                            <td class="tdlabel"><b>Designation</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $designationName; ?></td>
                                                            
                                                            <td class="tdlabel"><b>Section/Division</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $sectionName; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Location</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $locName; ?></td>
                                                            <td class="tdlabel"><b>Specific Location</b></td><td class="title-colon">:</td>
                                                            <td ><?php echo $specificLocationName; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Company Name</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo $companyName; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Start Date</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $displayStartDate; ?></td>
                                                            <td class="tdlabel"><b>End Date</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $displayEndDate; ?></td>

                                                        </tr>
                                                        <tr>
            <td colspan="6"><b>Blanket Permit valid for 7 days only (inclusive Sunday & Public Holiday)</b></td>
        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Area Classification</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo $areaClsName; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Work Description </b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo $workDesc; ?></td>

                                                        </tr>
                                                        <?php if($specificWorkInstOption == 1){?>
                                                        <tr>
                                                            <td class="tdlabel"><b>Special Work Instruction </b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo $specificWorkInst; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Document Upload </b></td>


                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel" colspan="6">
                                                                <?php
                                                                $fileSectionName = 'section_upload_documents';
                                                                $fileAppendSectionName = 'sectionfileuploadrow';
                                                                $defaultImg = DEFAULT_IMG_PNG;
                                                                ?>

                                                                <div class="row <?php echo $fileAppendSectionName; ?>">
                                                                    <?php
                                                                    if ($sectionAttachment != FALSE) {
                                                                        foreach ($sectionAttachment as $akey => $attachmnt) {
                                                                            $filepath = postData($attachmnt, 'SEC_FILE_PATH');
                                                                            $filename = postData($attachmnt, 'SEC_FILENAME');
                                                                            $fileext = postData($attachmnt, 'SEC_FILE_EXT');
                                                                            $is_image = postData($attachmnt, 'IS_IMAGE');
                                                                            $fileFullpath = BASE_URL . $filepath . $filename;
                                                                            $fileIcon = '';
                    switch ($fileext) {
                        case '.pdf':
                            $fileIcon = '<img src="'.ICON_PATH.'pdf-icon.png'.'"/>';

                            break;

                        default:
                            break;
                    }
                   
                 
                                                                            $displayLabel = ($is_image == 1) ? '<img src="' . $fileFullpath . '"/><div class="popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>' : $fileIcon.' <a href="'.$fileFullpath.'" target="_new" title="Click to view file"> '.$filename.'</a>';
                                                                            ?>
                                                                            <div class="col-md-3 imagepopcombine" id='imagepopcombine_<?php echo $akey; ?>'>
                                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;"><?php echo $displayLabel; ?></div>

                                                                                </div>	    
                                                                            </div>

                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    <?php }else{
                                                                        echo '<div style="padding-left:30px;">No Document Upload</div>';
                                                                    } ?>

                                                                </div>
                                                            </td>


                                                        </tr>
                                                        <?php }else{ ?>
                                                         <tr>
                                                            <td class="tdlabel"><b>Special Work Instruction </b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4">N/A</td>

                                                        </tr>
                                                        <?php } ?>
<?php if(isset($sc1fName) && !empty($sc1fName)){ ?>
							<tr>
                                                            <td class="tdlabel"><b> Image Upload </b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4">
                                                                <a data-fancybox="gallery" href="<?php echo $sec1Imgupl; ?>">
            <img class="lazy" style="height: 150px;width: 250px;" data-src="<?php echo $sec1Imgupl; ?>" >
        </a>
                                                            </td>

                                                        </tr>
<?php } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card ">
<div class="card-header card-header-inner">
    Section 2 - Hazardous Activities<span class="float-right"></span>
</div>
<div class="card-body">

    <?php
    $hazardActivityHirarcInfo = postData($additionalData, 'hazardActivityHirarcInfo');
    $hazardActivityOther = postData($additionalData, 'hazardActivityOther');
    $hzActivityInfo = postData($additionalData, 'hzActivityInfo');
    $aConfinedSpaceList = [];



    if (empty($hirarc_type)) {
        $hirarc_type = 2;
    }

    $hirarcReports = postData($hazardActivityHirarcInfo, 'hirarcIds');
    $hirarc_reports = ($ptw_id > 0 ) ? ($hirarcReports != FALSE) ? explode(',', $hirarcReports) : [] : $this->input->post('hirarc_reports');

    $hazardActivityCheckListInfo = postData($additionalData, 'hazardActivityCheckListInfo');

    $aHzCheckList = [];

    if ($hazardActivityCheckListInfo != FALSE && count($hazardActivityCheckListInfo) > 0) {
        foreach ($hazardActivityCheckListInfo as $hazActItem => $hazActVal) {
            $Hzid = postData($hazActVal, 'WH_REF_ID');
            $HzCheckList = postData($hazActVal, 'checkListIds');
            $aHzCheckList[$Hzid] = explode(',', $HzCheckList);
        }
    }


    if ($hazardActivity != FALSE && count($hazardActivity) > 0) {
        foreach ($hazardActivity as $key => $val) {
            $hazardActId = postData($val, 'HZRDAC_ID');
            $checkedList = [];
            $getHazActInfo = getHazardActivities($permitType, $hazardActId);
           
            if (array_key_exists($hazardActId, $aHzCheckList)) {
                $checkedList = $aHzCheckList[$hazardActId];
            }
            ?>
            <div class="row m-t-10">
                <div class="col-md">  
                    <label ><?php echo postData($val, 'CAT_NAME'); ?></label><br>
                  
                </div>
            </div>
            <?php
            /* Section A,B,C start
             * $hazardActId = 1 --> for section A
             * $hazardActId = 2 --> for section B
             * $hazardActId = 3 --> for section C
             */
            
            if ($hazardActId == 1 || $hazardActId == 2 || $hazardActId == 3) {
                $formclass = "";
                switch ($hazardActId) {
                    case 1:
                        $formName = 'hazardActivities_routine[]';
                        $formIdName = 'hazardActivities_routine';
                        $formclass = "hazardDiv hazardRoutineDiv";
                        $formerrorclass = "hazardRoutineDiv_error";
                        $formerrorFname = "hazardActivities_routine";
                        break;
                    case 2:
                        $formName = 'hazardActivities_cc[]';
                        $formIdName = 'hazardActivities_cc';
                        $formclass = "hazardDiv hazardAddCCDiv";
                        $formerrorclass = "hazardAddCCDiv_error";
                        $formerrorFname = "hazardActivities_cc";
                        break;
                    case 3:
                        $formName = 'hazardActivities_additional_doc[]';
                        $formIdName = 'hazardActivities_additional_doc';
                        $formclass = "hazardDiv hazardAddDocDiv";
                        $formerrorclass = "hazardAddDocDiv_error";
                        $formerrorFname = "hazardActivities_additional_doc";
                        break;

                    default:
                        $formclass = "";
                        break;
                }

                $otherHazActRoutine = isset($hazardActivityOther[$hazardActId][-1]) ? $hazardActivityOther[$hazardActId][-1] : FALSE;
                $aOtherHazardDesc = isset($hazardActivityOther[$hazardActId][26]) ? $hazardActivityOther[$hazardActId][26] : [];

                $other_hazard_desc = ($aOtherHazardDesc != FALSE && is_array($aOtherHazardDesc) && isset($aOtherHazardDesc[0])) ? $aOtherHazardDesc[0] : '-';
                ?>

                <div class="row ">
                    <div class="col-md">  

                        <div>
                            <?php
                            if ($getHazActInfo != FALSE && count($getHazActInfo) > 0) {
                                $getHazActPost = ($checkedList != FALSE && count($checkedList) > 0) ? $checkedList : $this->input->post($formerrorFname);
                                foreach ($getHazActInfo as $key => $val) {
                                    $hazAddId = postData($val, 'HZRDA_ID');
                                    $hazChecklist = postData($val, 'HZRDA_CHKLST');
                                    $hazName = postData($val, 'HZRDA_NAME');
                                    $hazDeclaration = postData($val, 'HAZARD_DECLARATION');
                                    $requireClass = '';
                                    $req = false;
                                    $reqString = '';
                                    if ((in_array($hazAddId, [24, 25]))) {
                                        $req = true;

                                        $formName = 'hazardActivities_additional_doc[' . $hazAddId . ']';
                                        $reqString = '<span class="red">*</span>';
                                    } else if ($hazAddId == 26) {
                                        $formName = 'hazardActivities_additional_doc[' . $hazAddId . ']';
                                    }
                                    $checked = ($getHazActPost != FALSE && in_array($hazAddId, $getHazActPost)) ? TRUE : FALSE;
                                    $checkedLabel = ($checked) ? $checkTrue : $checkFalse;
                                    $showHideClass = ($checked) ? '' : 'display:none;';

                                    $hzAttachmentInfo = (isset($hzActivityInfo[$hazardActId][$hazAddId]['attachment'])) ? $hzActivityInfo[$hazardActId][$hazAddId]['attachment'] : FALSE;
                                    
                                    $hzclearance_certificate_checklist = (isset($hzActivityInfo[$hazardActId][$hazAddId]['clearance_certificate_checklist'])) ? $hzActivityInfo[$hazardActId][$hazAddId]['clearance_certificate_checklist'] : [];
                               $hzclearance_certificate_Attachment = (isset($hzActivityInfo[$hazardActId][$hazAddId]['clearance_certificate_attachment'])) ? $hzActivityInfo[$hazardActId][$hazAddId]['clearance_certificate_attachment'] : [];
                               $hzConfinedSpace = (isset($hzActivityInfo[$hazardActId][$hazAddId]['confined_space'])) ? $hzActivityInfo[$hazardActId][$hazAddId]['confined_space'] : [];
                          
                               
                               if($hzConfinedSpace != FALSE && count($hzConfinedSpace) > 0){
                                   foreach($hzConfinedSpace as $row){
                                       $csId = postData($row,'WHA_REF_ID');
                                       $csDate = postData($row,'CS_DATE');
                                       $csTime = postData($row,'CS_TIME');
                                       $csLel = postData($row,'CS_LEL');
                                       $csO2 = postData($row,'CS_O2');
                                       $csH2S = postData($row,'CS_H2S');
                                       $csCo = postData($row,'CS_CO');
                                       $csAGTName = postData($row,'CS_AGT_NAME');
                                       $aConfinedSpaceList[$csId]=[
                                           'date'=>$csDate,
                                           'time'=>$csTime,
                                           'lel'=>$csLel,
                                           'O2'=>$csO2,
                                           'H2S'=>$csH2S,
                                           'CO'=>$csCo,
                                           'agt_name'=>$csAGTName,
                                       ];
                                   }
                               }
                               
                               $confinedEntryCounts = ($aConfinedSpaceList != FALSE && is_array($aConfinedSpaceList)) ? count($aConfinedSpaceList) : 0;
                               
                                    if($checked){
                                    ?>
                            
                                    <div class="form-check">
                                        <?php echo $checkedLabel; ?>

                                        <label class="form-check-label" for="<?php echo $formIdName . $key; ?>">
                                            <?php echo $hazName; ?> <?php echo $reqString; ?>
                                        </label>
                                    </div>

                                    <div class="additional_doc docLabel" id="add_<?php echo $formIdName; ?>_<?php echo $hazAddId; ?>"  style="<?php echo $showHideClass; ?>">
                                        <?php
                                        /* Section HIRARC start */
                                        if ($hazAddId == 24) {

                                            $hzTypeInfo = isset($hzActivityInfo[$hazardActId][$hazAddId]['info']) ? $hzActivityInfo[$hazardActId][$hazAddId]['info'] : [];
                                            $editHTData = postData($hzTypeInfo, 'HIRAC_TYPE');

                                            switch ($editHTData) {
                                                case 'EMP':
                                                    $hirarc_type = 1;

                                                    break;
                                                case 'CONT':
                                                    $hirarc_type = 2;

                                                    break;

                                                default:
                                                    $hirarc_type = $this->input->post('hirarc_type');
                                                    break;
                                            }
                                            $showHideEmpClass = ($hirarc_type == 1) ? '' : 'display:none';
                                            $showHideContClass = ($hirarc_type == 2) ? '' : 'display:none';
                                            $hirarcType = [
                                                '' => 'Select Option',
                                                '1' => 'Employee',
                                                '2' => 'Contractors'
                                            ];
                                            ?>
<!--                                            <div class="row m-t-10">
                                                <div class="col-md-6">  
                                                    <?php echo isset($hirarcType[$hirarc_type]) ? $hirarcType[$hirarc_type] : ''; ?>
                                                </div>
                                            </div>-->
                                            <div class="row m-t-10  hirarc_upload_doc hirarc_upload_doc_1" style="<?php echo $showHideEmpClass; ?>">

                                                <div class="col-md-12"> 
                                                    <label >HIRARC ID</label><br>
                                                    <?php  if ($hazardActivityHirarcInfo != FALSE && count($hazardActivityHirarcInfo) > 0) { ?>
                                                    <table class="table   table-striped">
                                                        <thead class="">
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>HIRARC ID</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                           
                                                                $i = 0;
                                                                foreach ($hazardActivityHirarcInfo as $row) {
                                                                    $hid = postData($row, 'HIRARC_ID');
                                                                    $mid = postData($row, 'MAIN_AUTO_ID');
                                                                     $action =  " " . anchor(BASE_URL.'hirarc/hirarc/pdf_report/'. encryptval($mid), '<i class="fa fa-eye"></i>', array('title' => 'view','target'=>'_new'));
                                                                    $i++;
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo $hid; ?></td>
                                                                        <td><?php echo $action;?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                    <?php }else{
                                                        echo '<p style="padding-left:10px;">N/A</p>';
                                                    } ?>
                                                </div>

                                            </div>

                                            <div class="row m-t-10  hirarc_upload_doc hirarc_upload_doc_2 " >

                                                <div class="col-md-12">

                                                    <label >Document Upload </label>
                                                    <?php 
                                                    if($hzAttachmentInfo != FALSE && count($hzAttachmentInfo) > 0){
                                                    echo displayPTWHZAttachment($hzAttachmentInfo);} else{
                                                                        echo '<div style="padding-left:30px;">No Document Upload</div>';
                                                                    }
                                                    ?>
                                                </div>  
                                            </div>

                                            <?php
                                            /* Section HIRARC End */
                                        } else {
                                            if ($hazAddId == 26) { /* Section Other start */
                                                ?>
                                                <div class="row m-t-10">
                                                    <div class="col-md-6">
                                                        <ol>
                                                            <li><?php echo $other_hazard_desc; ?></li>
                                                        </ol>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            /* Section Other end */
                                            if (in_array($hazardActId, [3])) {
                                                ?>
                                                <div class="row m-t-10 ">
                                                    <div class="col-md-12">

                                                        <label >Document Upload </label>
                                                        <?php echo displayPTWHZAttachment($hzAttachmentInfo); ?>
                                                    </div>  
                                                </div>
                                                <?php
                                            }else if($hazChecklist == 'Y') { // Cheklist is Yes the photo upload will shown // Critical
                                            $checklistInfo = getHazardActivitiesChecklist($hazAddId);
                                             $showClass = ($hazAddId == 19) ? 'display:block;': 'display:none;';
                                            echo form_hidden('hazActClearanceCert['.$hazAddId.']','Y');
                                                                                        

             $checkListCC = postData($hzclearance_certificate_checklist,'checklistIds');                   $aCheckListCC   = ($checkListCC != FALSE) ? explode(',',$checkListCC):[];    
                                        
                                            ?>
                                    
                                    <div class="card m-t-10">
                                    <div class="card-header card-header-cc uppertext ">
                                        <?php echo $hazName.' CLEARANCE CERTIFICATE';
?>
                                    </div>
                                   
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                <div class="form-check">
                                                   
                                    <label class="form-check-label" for="<?php echo 'cc_declaration_'.$hazAddId; ?>"><?php echo $checkTrue;?> <?php echo $hazDeclaration;?></label>
                                </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row m-t-10">
                                                <div class="col-md-12">
                                                    <label>Checklist : </label>
                                                  <?php if($checklistInfo != FALSE && count($checklistInfo) > 0){
                                                      foreach($checklistInfo as $ckey => $cval){
                                                          $checklistName = 'checklist_'.$hazAddId.'[]';
                                                          $checklistIdName = 'checklist_'.$hazAddId.'_';
                                                          $checkListId = postData($cval,'HZRDA_ITEM_ID');
                                                          $checkListName = postData($cval,'HZRDA_CHKL_NAME');
                                                           $checked = (in_array($checkListId,$aCheckListCC)) ? TRUE : FALSE;
                                                           $chckedLabel = ($checked) ? $checkTrue : $checkFalse;
                                                           if($checked){
       
                                                      ?>
                                                    <div class="form-check">
                                                    <label class="form-check-label" for="<?php echo $checklistIdName.$ckey; ?>"> <?php echo $chckedLabel;?> <?php echo $checkListName;?></label>
                                                    
                                </div>
                                                    <span class="ccchecklist_error red" id="ccchecklist_error"></span>
                                                           <?php } } } ?>
                                            
                                             </div>
                                                
                                            </div>
                                            
                                            
                                            
                                             <div class="row m-t-10 ">
                                      <div class="col-md-12">
                                           
                                                <label >Photo Upload </label>
                                               				    
                                                <div class="clearfix"></div>
                                                
                                                <?php 
                                                if($hzclearance_certificate_Attachment != FALSE && count($hzclearance_certificate_Attachment) > 0){
                                                    
                                                echo displayPTWHZCCAttachment($hzclearance_certificate_Attachment);
                                                } else {
                                                    echo '<div style="padding-left:30px;">No Photo Upload</div>';
                                                }?>
                                            </div>  
                                    </div>
                                        </div>
                                   
                                </div>
                                    
                                    <?php if($hazAddId == 19){
                                        $showsection6 = TRUE;
                                       
                                        } ?>
                                      <?php
                                      
                                            }
                                    }
                                        ?>
                                    </div>
                                    <?php
                                    }
                                }
                            }
                            /* Section A other start */
                            if ($hazardActId == 1) {
                                $checked = ($getHazActPost != FALSE && in_array(-1, $getHazActPost)) ? TRUE : FALSE;
                                $checkedLabel = ($checked) ? $checkTrue : $checkFalse;
                                $showHideClass = ($checked) ? '' : 'display:none;';
                                if($checked){
                                ?>
                                <div class="form-check">
                                    <?php echo $checkedLabel; ?>
                                    <label class="form-check-label" for="<?php echo $formIdName; ?>-1">Others</label>
                                </div>
                                <div class="additional_doc docLabel" id="add_<?php echo $formIdName; ?>_-1" style="<?php echo $showHideClass; ?>" >
                                    <ol>
                                        <?php
                                        if ($otherHazActRoutine != FALSE && count($otherHazActRoutine) > 0) {
                                            foreach ($otherHazActRoutine as $rkey => $rval) {
                                                ?>
                                                <li> <?php echo $rval; ?></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ol>
                                </div>  
                                <?php
                                }
                            }
                            /* Section A other End */
                            ?>

                        </div>
                    </div>


                </div>
                <?php
            }
        }
    }
    ?>

</div>
                                    </div>
<div class="card ">
    <div class="card-header card-header-inner">
        Section 3 - WORKSITE PREPARATION/PRECAUTIONS (Select appropriate boxes)<span class="float-right"></span>
    </div>
    <div class="card-body">
        <?php
        $gas_tester_name = $this->input->post('gas_tester_name');
        $other_isolation_desc = $this->input->post('other_isolation_desc');
        $WPPcategoryLst = getWPPCategoryList();

        $wppCheckListInfo = postData($additionalData, 'wppCheckListInfo');
        $wppViewInfo = postData($additionalData, 'wppInfo');


        $aWPPCheckList = [];

        if ($wppCheckListInfo != FALSE && count($wppCheckListInfo) > 0) {
            foreach ($wppCheckListInfo as $wppItem => $wppVal) {
                $wppCid = postData($wppVal, 'WSP_CATEGORY_ID');
                $wppCheckList = postData($wppVal, 'checkListIds');
                $aWPPCheckList[$wppCid] = explode(',', $wppCheckList);
            }
        }

        if ($WPPcategoryLst != FALSE && count($WPPcategoryLst) > 0) {
            foreach ($WPPcategoryLst as $key => $wppcat) {
                $wppId = postData($wppcat, 'WPPC_ID');
                $wppItemList = getWPPCategoryItemList($wppId, $permitType);
                $headerCheckListName = '  <div class="row m-t-10">
                    <div class="col-md">  
                        <label >'.postData($wppcat, "WPPC_NAME").'</label><br>

                    </div>
                </div>';
                ?>
                
                <?php
                $nDatacount = 0;
                if ($wppItemList != FALSE && count($wppItemList) > 0) {
                    $hci = 0;
                    foreach ($wppItemList as $wkey => $wval) {
                        $hci++;
                        $wppItemId = postData($wval, 'WPPI_ID');
                        $wppName = postData($wval, 'WPPI_NAME');
                        $formIdName = 'wpp_checklist_';
                        $formName = 'wpp_checklist_' . $wppId . '[]';

                        $checkListItem = isset($aWPPCheckList[$wppId]) ? $aWPPCheckList[$wppId] : [];
                        $checkedLabel = (in_array($wppItemId, $checkListItem)) ? $checkTrue : $checkFalse;
                        $wppchecked = (in_array($wppItemId, $checkListItem)) ? TRUE : FALSE;
                        $wppRequireClass = ($wppchecked) ? 'display:block' : 'display:none';
                        $WPPAttachmentInfo = (isset($wppViewInfo[$wppId][$wppItemId]['attachment'])) ? $wppViewInfo[$wppId][$wppItemId]['attachment'] : FALSE;
                        $WPPCheckInfo = (isset($wppViewInfo[$wppId][$wppItemId]['info'])) ? $wppViewInfo[$wppId][$wppItemId]['info'] : FALSE;
                        if($wppchecked){
                            $nDatacount = $nDatacount+1;
                            if($hci ==1){
                               echo $headerCheckListName; 
                            }
                        ?>
                        <div class="form-check">
                            <?php echo $checkedLabel; ?>

                            <label class="form-check-label" for="<?php echo $formIdName . $wppItemId; ?>">
                                <?php echo $wppName; ?> 
                            </label>
                        </div>
                        

                        <?php
                        }
                    }
                    ?>
                    <?php
                }
                ?>

                <?php
//                if($nDatacount == 0){
//                    $noDataHtml = '<div class=" m-t-10" style="padding-left:40px;">
//                    <div class="col-md" >  
//                        <label >No Data Selection</label><br>
//
//                    </div>
//                </div>';
//                    echo $noDataHtml;
//                }
            }
            
        }
        ?>
    </div>
</div>

<div class="card ">
    <div class="card-header card-header-inner">
        SECTION 4 - PERSONAL PROTECTIVE EQUIPMENT (Select appropriate boxes)<span class="float-right"></span>
    </div>
    <div class="card-body">
        <?php
        $PPEcategoryLst = getPPECategoryList();

        $ppeCheckListInfo = postData($additionalData, 'ppeCheckListInfo');
        $ppeViewInfo = postData($additionalData, 'ppeInfo');


        $aPPECheckList = [];

        if ($ppeCheckListInfo != FALSE && count($ppeCheckListInfo) > 0) {
            foreach ($ppeCheckListInfo as $ppeItem => $ppeVal) {
                $ppeCid = postData($ppeVal, 'PPE_CAT_ID');
                $ppeCheckList = postData($ppeVal, 'checkListIds');
                $aPPECheckList[$ppeCid] = explode(',', $ppeCheckList);
            }
        }


        if ($PPEcategoryLst != FALSE && count($PPEcategoryLst) > 0) {
         $ppeTotalCatCount = count($PPEcategoryLst);
            $ppeCont = 0;
            
        $otherPPE = isset($ppeViewInfo[-1]) ? $ppeViewInfo[-1] : [];
        $aOtherPPEInfo = isset($otherPPE[-1]) ? $otherPPE[-1] : [];
        $otherPPEInfo = postData($aOtherPPEInfo, 'info');
        $otherPPEAttachment = postData($aOtherPPEInfo, 'attachment');
        $other_ppe_desc = postData($otherPPEInfo, 'PPE_ITEM_OTHER');

            foreach ($PPEcategoryLst as $key => $ppecat) {
                 $ppeCont++;
                $PPEId = postData($ppecat, 'PPEC_ID');
                $PPEName = postData($ppecat, 'PPEC_NAME');
                $PPEItemList = getPPECategoryItemList($PPEId);
                $ppeHeadChecklistName = '<div class="row m-t-10">
                    <div class="col-md">  
                        <label >'.$PPEName.'</label><br>

                    </div>
                </div>';
                ?>
                
                <?php
                $noPPEDataCount = 0;
                if ($PPEItemList != FALSE && count($PPEItemList) > 0) {
                    $ppeCheckLoop = 0;
                    foreach ($PPEItemList as $PPEkey => $PPEval) {
                        $ppeCheckLoop++;
                        $PPEItemId = postData($PPEval, 'PPEI_ID');
                        $PPEName = postData($PPEval, 'PPEI_NAME');
                        $PPEMAND = postData($PPEval, 'PPEI_MANDATE');
                        $formIdName = 'ppe_checklist_';
                        $formName = 'PPE_ref_id[' . $PPEId . '][checklist][]';

                        $ppeCheckItemList = isset($aPPECheckList[$PPEId]) ? $aPPECheckList[$PPEId] : [];


                        $checked = ((in_array($PPEItemId, $ppeCheckItemList))) ? TRUE : FALSE;
                        $checkedLabel = ($checked) ? $checkTrue : $checkFalse;
                        $ppeRequireClass = ($checked) ? '' : 'display:none;';
                        $readOnlyCheck = 'onclick="return false;"';
                        if($checked){
                            $noPPEDataCount = $noPPEDataCount+1;
                            if($ppeCheckLoop == 1){
                                 echo $ppeHeadChecklistName;
                            }
                        ?>
                        <div class="form-check">
                            <?php echo $checkedLabel; ?>

                            <label class="form-check-label" for="<?php echo $formIdName . $PPEItemId; ?>">
                                <?php echo $PPEName; ?> 
                            </label>
                        </div>
                        <div class="additional_ppe_doc" id="add_<?php echo $formIdName; ?>_<?php echo $PPEItemId; ?>"  style="<?php echo $ppeRequireClass; ?>"></div>
                        <?php
                        }
                    }
                }
                ?>



                <?php
                 if($ppeCont == $ppeTotalCatCount){
                    if($noPPEDataCount == 0){
                        $ppeCheckItemList = isset($aPPECheckList[-1]) ? $aPPECheckList[-1] : [];
        $checked = ((in_array(-1, $ppeCheckItemList))) ? TRUE : FALSE;
        $checkedLabel = ($checked) ? $checkTrue : $checkFalse;
                        if($checked){
                            $noPPEDataCount = $noPPEDataCount+1;
                        }
                    }
                }
                
//                 if($noPPEDataCount == 0){
//                    $noDataHtml = '<div class=" m-t-10" style="padding-left:40px;">
//                    <div class="col-md" >  
//                        <label >No Data Selection</label><br>
//
//                    </div>
//                </div>';
//                    echo $noDataHtml;
//                }
            }
            
           
        }

        
        $formName = 'PPE_ref_id[-1][checklist][]';
        $ppeCheckItemList = isset($aPPECheckList[-1]) ? $aPPECheckList[-1] : [];
        $checked = ((in_array(-1, $ppeCheckItemList))) ? TRUE : FALSE;
        $checkedLabel = ($checked) ? $checkTrue : $checkFalse;
        $ppeRequireClass = ($checked) ? '' : 'display:none;';
        $readOnlyCheck = 'onclick="return false;"';
        if($checked){
        ?>
        <div class="form-check">
            <?php echo $checkedLabel; ?>
            <label class="form-check-label" for="<?php echo $formIdName . '-1'; ?>">Others</label>
        </div>
        <div class="additional_ppe_doc" id="add_<?php echo $formIdName; ?>_-1"  style="<?php echo $ppeRequireClass; ?>">

            <div class="row m-t-10">
                <div class="col-md-6">
                    <ol>
                        <li><?php echo $other_ppe_desc; ?></li>
                    </ol>
                </div>
            </div>

            <div class="row m-t-10 ">

                <div class="col-md-12">

                    <label >Upload Photo </label>

                    <div class="clearfix"></div>
                    <br/>
                    <?php 
                     if($otherPPEAttachment != FALSE && count($otherPPEAttachment) > 0){
                                                 echo displayPPEAttachment($otherPPEAttachment);} else{
                                                                        echo '<div style="padding-left:30px;">No Upload Photo</div>';
                                                                    }
                   ?>
                </div>  
            </div>


        </div>
        <?php } ?>
    </div>
</div>

<div class="card ">
    <div class="card-header card-header-inner">
        SECTION 5 - JOINT VISIT BEFORE WORK COMMENCES<span class="float-right"></span>
    </div>
    <div class="card-body">
        <?php
        $applicantName = postData($editData, 'INITIAL_PA_NAME', '-');
        $initial_pa_date = postData($editData, 'INITIAL_PA_DATE',0);
        $initial_pa_time = postData($editData, 'INITIAL_PA_TIME',0);
        $initial_declaration = postData($editData, 'INITIAL_DECLARATION', '-');
        $operation_authority_1 = postData($editData, 'OA1', '-');
        $operation_authority_2 = postData($editData, 'OA2', '-');
        $OA1_Name = postData($editData, 'OA1_NAME', '-');
        $OA2_Name = postData($editData, 'OA2_NAME', '-');

        $initialChecked = ($initial_declaration == 1) ? $checkTrue : $checkFalse;
        $initial_pa_date = ($initial_pa_date > 0) ? convertDate($initial_pa_date, PTW_DATE_FORMAT) : $initial_pa_date;
        $initial_pa_time = ($initial_pa_time > 0) ? convertDate($initial_pa_time, PTW_TIME_FORMAT) : $initial_pa_time;
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-check">
                    <label class="form-check-label" for="initial_declaration">
                        <?php echo $initialChecked; ?> I understand the required Checkbox precautions specified in Section 3 in order to perform activity stipulated on section 2 and accept all responsibilities for the work stated
                    </label>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Assigned Operating Authority 1</th>
                            <th>Assigned Operating Authority 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $applicantName; ?></td>
                            <td><?php echo $initial_pa_date; ?></td>
                            <td><?php echo $initial_pa_time; ?></td>
                            <td><?php echo $OA1_Name; ?></td>
                            <td><?php echo $OA2_Name; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

  <?php if($showsection6){
                                      
        $sectionData = [
            'confinedEntryCounts'=>$confinedEntryCounts,
            'confinedSpaceList'=>$aConfinedSpaceList
        ];
      $confineLoopEntryCount = $confinedEntryCounts;
      $confinedSpaceList =  $aConfinedSpaceList;
  
$csPreEntryList = isset($confinedSpaceList[-1])? $confinedSpaceList[-1] : [];
$csDate = postData($csPreEntryList,'date','');
$csTime = postData($csPreEntryList,'time','');
$csLel = postData($csPreEntryList,'lel','');
$csO2 = postData($csPreEntryList,'O2','');
$csH2S = postData($csPreEntryList,'H2S','');
$csCO = postData($csPreEntryList,'CO','');
$csAgtname = postData($csPreEntryList,'agt_name','');
$csDate = convertDate($csDate, PTW_DATE_FORMAT);
$csTime = convertDate($csTime, PTW_TIME_FORMAT);
$confineLoopTotalCount = ($confineLoopEntryCount == 8) ?  7 : $confineLoopEntryCount-1;

$PTWStatus = postData($editData,'STATUS'); 
$conditionDisplayStatus = ($PTWStatus >=6)? TRUE : FALSE;
 ?>
                                    
                                    <div class="card" id="confinedspace" style="<?php echo $showClass;?>">
                                    <div class="card-header card-header-inner">
                                        <a class="card-link " href="javascript:void(0)">
                                            SECTION 6 - WORKING IN CONFINED SPACE<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_6" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                           
<div class="row">
    <div class="col-md-12">
        <label>A) GAS TEST MONITORING (Select appropriate boxes)</label>
    </div>
</div>

<div class="row m-t-10" style="margin-left:10px;">
    <div class="col-md-12">
        <div class="form-check">
            
            <label class="form-check-label" for="gas_test_declaration">
             <?php echo $checkTrue;?>   GAS TEST
            </label>
        </div>
        
    </div>
</div>

<div class="row"  id="confinedspaceentry">
    <div class="col-md-12">
        <label>Gas Test Result</label>
        <table class="table">
            <thead>
                <tr>
                    <th>Confined Space Condition</th>
                    <th>Pre-Entry Result</th>
                    <?php 
                    if($conditionDisplayStatus){
                    for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <th>Execution # <?php echo $i+1;?></th>
                    <?php }} ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Date</td>
                    <td><?php echo $csDate;?></td>
                     <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                    $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
$csCurDate = postData($csCurrentInfo,'date',date('Y-m-d'));
$csCurDate = convertDate($csCurDate, PTW_DATE_FORMAT);

                       echo $csCurDate;
                ?> </td>
                    <?php } }?>
                    
                    
                </tr>
                <tr>
                    <td>Time</td>
                    <td><?php echo $csTime; ?></td>
                     <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                    $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                   
                    $csCurTime = postData($csCurrentInfo,'time',date('H:i:s'));
                    $csCurTime = convertDate($csCurTime, PTW_TIME_FORMAT);
                    echo $csCurTime;
                ?> </td>
                    <?php } }?>
                    
                </tr>
                
                 <tr>
                    <td>% LEL (≤ 10%)</td>
                    <td><?php echo $csLel;   ?></td>
                    
                    <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                     $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                   
                    $csCurLel= postData($csCurrentInfo,'lel',FALSE);
                     echo $csCurLel;
                ?> </td>
                    <?php } }?>
                    
                </tr>
                
                <tr>
                    <td>% O2 (19.5 ≤ O2 ≤ 23.5%)</td>
                    <td><?php echo $csO2; ?></td>
                     <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                     <td><?php
                     $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                     $csCurO2= postData($csCurrentInfo,'O2',FALSE);
                     echo $csCurO2;
                ?></td>
                      <?php } }?>
                    
                </tr>
                
                <tr>
                    <td>H2S (≤10 ppm)</td>
                    <td><?php echo $csH2S;  ?></td>
                     <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                    $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                     $csCurH2S= postData($csCurrentInfo,'H2S',FALSE);
                      echo $csCurH2S;
                ?></td>
                     <?php } }?>
                    
                </tr>
                
                <tr>
                    <td>CO (≤ 25 ppm)</td>
                    <td><?php
                       echo $csCO;
                ?></td>
                     <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                    $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                     $csCurCO= postData($csCurrentInfo,'CO',FALSE);
                      echo $csCurCO;
                ?></td>
                    <?php } }?>
                    
                </tr>
                <tr>
                    <td>AGT's Name</td>
                    <td><?php
                        echo $csAgtname;
                ?></td>
                    <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                    $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                     $csCurAgtName= postData($csCurrentInfo,'agt_name',FALSE);
                      echo $csCurAgtName;
                ?></td>
                    <?php } }?>
                   
                </tr>
            </tbody>
        </table>
        </div>
                                           
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <?php } ?>
 <!-- Section 7 Verification-->
<?php 
$applicantName = postData($editData, 'SHO_HSE_NAME');
$qaName = postData($editData, 'OA_NAME');
if($applicantName !='' || $qaName !=''){
?>
<div class="card ">
    <div class="card-header card-header-inner">
        Section 7 – Verification <span class="float-right"></span>
    </div>
    <div class="card-body">
        <label>A.Verification by SHO/HSE Executive</label>
        <?php
        $applicantName = postData($editData, 'SHO_HSE_NAME', '-');

        $verification_hse_date = postData($editData, 'SHO_HSE_DATE');
        $verification_hse_time = postData($editData, 'SHO_HSE_TIME');
        $verification_hse_date = ($verification_hse_date > 0) ? convertDate($verification_hse_date, PTW_DATE_FORMAT) : $initial_pa_date;
        $verification_hse_time = ($verification_hse_time > 0) ? convertDate($verification_hse_time, PTW_TIME_FORMAT) : $initial_pa_time;

        $PTWStatus = postData($editData, 'STATUS');

        $hse_verify = postData($editData, 'SHO_HSE_VERIFY');
        $hse_remark = postData($editData, 'SHO_HSE_REMARKS', '-');
        global $aHseVerify;

        $hseReject = postData($editData, 'HSE_REJECT');
        $OAReject = postData($editData, 'OA_REJECT');
        ?>
        <div class="row">

            <div class="col-md-12">
                <label>I have inspected the work area and found to be;</label>
                <?php
                if ($aHseVerify != FALSE && count($aHseVerify) > 0) {

                    foreach ($aHseVerify as $key => $val) {
                        if($hse_verify == $key){
                        $checkedLabel = ($hse_verify != '' && $hse_verify == $key ) ? $checkTrue : $checkFalse;
                        ?>

                        <div class="form-check">
                            <?php echo $checkedLabel; ?>
                            <label class="form-check-label" for="hse_verify_<?php echo $key; ?>"><?php echo $val; ?></label>
                        </div>
                        <?php
                        }
                    }
                }
                ?>

            </div>
        </div>
        <div class="row m-t-10">
            <div class="col-md">  
                <label >Remark </label><br>
                <?php echo $hse_remark;?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>SHO/HSSE Executive name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Assigned Operating Authority 1</th>
                            <th>Assigned Operating Authority 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($hse_verify != '' && $hse_verify != FALSE){?>
                        <tr>
                            <td><?php echo $applicantName; ?></td>
                            <td><?php echo $verification_hse_date; ?></td>
                            <td><?php echo $verification_hse_time; ?></td>
                            <td><?php echo $OA1_Name; ?></td>
                            <td><?php echo $OA2_Name; ?></td>
                        </tr>
                        <?php }else{ ?>
                        <tr><td colspan="5" align="center">No record found</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
  <?php if($qaName !=''){ ?>      
<div class="row">
        <div class="col-md-12">
        <label>B.VERIFICATION BY OPERATING AUTHORITY (OA)</label>
    </div>
</div>
        <?php



$qa_date = postData($editData, 'OA_DATE',0);
$qa_time = postData($editData, 'OA_TIME',0);
$qa_date = ($qa_date > 0) ? convertDate($qa_date, PTW_DATE_FORMAT) : $qa_date;
$qa_time = ($qa_time > 0) ? convertDate($qa_time, PTW_TIME_FORMAT) : $qa_time;
    $PTWStatus = postData($editData,'STATUS');    
    $initialChecked = ($PTWStatus >= 4) ? $checkTrue :$checkFalse;
    $qa_remark = postData($editData, 'OA_REMARKS','-');
?>


<div class="row">
    <div class="col-md-12">
        <div class="form-check">
           
            <label class="form-check-label" for="qa_declaration">
                <?php echo $initialChecked;?> I understand the activity/precautions and fulfilment of this permit, therefore I authorized the PA to commence with the work described in Section 1.
            </label>
        </div>
      
    </div>
</div>
        <div class="row m-t-10">
            <div class="col-md">  
                <label >Remark </label><br>
                <?php echo $qa_remark;?>
            </div>
        </div>
        
         <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($PTWStatus >= 4) {?>
                        <tr>
                            <td><?php echo $qaName; ?></td>
                            <td><?php echo $qa_date; ?></td>
                            <td><?php echo $qa_time; ?></td>
                           
                        </tr>
                        <?php }else{ ?>
                        <tr><td colspan="3" align="center">No record found</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
  <?php } ?>
    </div>
</div>
<?php } ?>
  <!-- Section 8  Permit Stoppage & reactivate permit-->
 <?php 
 $reactivateName = postData($editData, 'REACTIVATER_NAME');
 $stop_work_name = postData($editData, 'STOPWORKORDER_NAME');
 if($reactivateName !='' || $stop_work_name !='' ){
 ?>
 <div class="card ">
    <div class="card-header card-header-inner">
        SECTION 8 - PERMIT STOPPAGE - RE-ACTIVATE PERMIT <span class="float-right"></span>
    </div>
     <div class="card-body">
         <label>A.STOP WORK ORDER</label>
         <?php 

$stop_comments = postData($editData, 'STOPWORKORDER_REASON', '-');

$stop_work_date =  postData($editData, 'STOPWORKORDER_DATE',0);
$stop_work_time = postData($editData, 'STOPWORKORDER_TIME',0);
$stop_cancel_declaration =  postData($editData, 'STOPWORKORDER_DECLARATION', '-')  ;
$stop_work_date = ($stop_work_date > 0) ? convertDate($stop_work_date, PTW_DATE_FORMAT) : $stop_work_date;
$stop_work_time = ($stop_work_time > 0) ? convertDate($stop_work_time, PTW_TIME_FORMAT) : $stop_work_time;
    $PTWStatus = postData($editData,'STATUS');    
   
    $checked = ($stop_cancel_declaration == 1) ? $checkTrue : $checkFalse;
?>
<div class="row">
    <div class="col-md-12">
        <div class="form-check">
           
            <label class="form-check-label" for="stop_cancel_declaration"><?php echo $checked;?> Permit Stoppage/Cancel Permit
            </label>
        </div>
        
    </div>
</div>
         <div class="row m-t-10">
    <div class="col-md">  
        <label >Comments  </label><br>
        <div>
           <?php echo $stop_comments;?>
        </div>
    </div>
</div>
         <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($stop_work_name !='') {?>
                        <tr>
                            <td><?php echo $stop_work_name; ?></td>
                            <td><?php echo $stop_work_date; ?></td>
                            <td><?php echo $stop_work_time; ?></td>
                           
                        </tr>
                        <?php }else{ ?>
                        <tr><td colspan="3" align="center">No record found</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
  <br/>  
<?php 

$reactivate_comments = postData($editData, 'REACTIVATE_REASON', '-');

$reactivate_date = postData($editData, 'REACTIVATER_DATE',0);
$reactivate_time = postData($editData, 'REACTIVATER_TIME',0);
$reactivate_cancel_declaration =  postData($editData, 'REACTIVATE_DECLARATION','-')  ;
$reactivate_date = ($reactivate_date > 0) ? convertDate($reactivate_date, PTW_DATE_FORMAT) : $reactivate_date;
$reactivate_time = ($reactivate_time > 0) ? convertDate($reactivate_time, PTW_TIME_FORMAT) : $reactivate_time;
    $PTWStatus = postData($editData,'STATUS');    
    $checkedLabel = ($reactivate_cancel_declaration == 1) ? $checkTrue : $checkFalse;
    if($reactivate_cancel_declaration == 1){
?>

<div class="row">
    <div class="col-md-12">
         <label>B.RE-ACTIVATE PERMIT</label>
        
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-check">
           
            <label class="form-check-label" for="reactivate_cancel_declaration"><?php echo $checkedLabel;?> Permit Stoppage/Cancel Permit
            </label>
        </div>
        
    </div>
    
</div>
   <div class="row m-t-10">
    <div class="col-md">  
        <label >Comments  </label><br>
        <div>
           <?php echo $reactivate_comments;?>
        </div>
    </div>
</div>
         <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($reactivateName !='') {?>
                        <tr>
                            <td><?php echo $reactivateName; ?></td>
                            <td><?php echo $reactivate_date; ?></td>
                            <td><?php echo $reactivate_time; ?></td>
                           
                        </tr>
                        <?php }else{ ?>
                        <tr><td colspan="3" align="center">No record found</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
     <br/> 
     
 <?php } ?>
     </div>
</div>
     <?php
 }
 ?>
  
  <?php 
$ackapplicantName = postData($editData, 'WORK_SUPERVISOR_NAME');

$work_supervisor_date = postData($editData, 'WORK_SUPERVISOR_DATE',0);
$work_supervisor_time = postData($editData, 'WORK_SUPERVISOR_TIME',0);
$work_supervisor_declaration =  postData($editData, 'WORK_SUPERVISOR_DECLARATION',0);
$work_supervisor_date = ($work_supervisor_date > 0) ? convertDate($work_supervisor_date, PTW_DATE_FORMAT) : $work_supervisor_date;
$work_supervisor_time = ($work_supervisor_time > 0) ? convertDate($work_supervisor_time, PTW_TIME_FORMAT) : $work_supervisor_time;
    $PTWStatus = postData($editData,'STATUS');    

    $checkedLabel = ($work_supervisor_declaration == 1) ? $checkTrue :$checkFalse;
    if($work_supervisor_declaration == 1){
?>
  <div class="card ">
    <div class="card-header card-header-inner">
         SECTION 9 - PERMIT RECIPIENT <span class="float-right"></span>
    </div>
    <div class="card-body">
        <label>WORK SUPERVISOR (WS)</label>
        <div class="row">
    <div class="col-md-12">
        <div class="form-check">
           
            <label class="form-check-label" for="work_supervisor_declaration">
              <?php echo $checkedLabel;?>  I had understand the permit content and shall comply with the PTW requirement before, during and after the work is complete.
            </label>
        </div>
       
    </div>
</div>
        
        <div class="row m-t-10">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($work_supervisor_declaration == 1) {?>
                        <tr>
                            <td><?php echo $ackapplicantName; ?></td>
                            <td><?php echo $work_supervisor_date; ?></td>
                            <td><?php echo $work_supervisor_time; ?></td>
                           
                        </tr>
                        <?php }else{ ?>
                        <tr><td colspan="3" align="center">No record found</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        
      </div>
      
      
      </div>
  
    
  <?php } ?>
  <?php 
$work_complete_name = postData($editData, 'WORK_COMPLETE_NAME');

$work_complete_date = postData($editData, 'WORK_COMPLETE_DATE',0);
$work_complete_time = postData($editData, 'WORK_COMPLETE_TIME', 0);
$work_complete_declaration =  postData($editData, 'WORK_COMPLETION', 0);
$work_complete_date = ($work_complete_date > 0) ? convertDate($work_complete_date, PTW_DATE_FORMAT) : $work_complete_date;
$work_complete_time = ($work_complete_time > 0) ? convertDate($work_complete_time, PTW_TIME_FORMAT) : $work_complete_time;
    $PTWStatus = postData($editData,'STATUS');    
   
    $checkedLabel = ($work_complete_declaration == 1) ? $checkTrue : $checkFalse;
    $permitsancformAttachment = postData($additionalData,'ptwSancFormInfo');
    $permitsancformAttachment1 = postData($additionalData,'ptwSancFormInfo1');
    if($work_complete_declaration == 1){
?>
  <div class="card ">
    <div class="card-header card-header-inner">
         SECTION 10 - COMPLETION OF WORK (PERMIT CLOSURE) <span class="float-right"></span>
    </div>
      <div class="card-body">
          <label>WORK SUPERVISOR (WS) / PERFORMING AUTHORITY (PA)</label>
          
          <div class="row">
    <div class="col-md-12">
        <div class="form-check">
            
            <label class="form-check-label" for="work_complete_declaration">
               <?php echo $checkedLabel;?> Job Task Completed. Worksite has been restored to safe condition.
            </label>
        </div>
       
    </div>
</div>
          
          <div class="row m-t-10">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($work_complete_declaration == 1) {?>
                        <tr>
                            <td><?php echo $work_complete_name; ?></td>
                            <td><?php echo $work_complete_date; ?></td>
                            <td><?php echo $work_complete_time; ?></td>
                           
                        </tr>
                        <?php }else{ ?>
                        <tr><td colspan="3" align="center">No record found</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
      </div>
      </div>
  
  <div class="card ">
    <div class="card-header card-header-inner">
         SECTION 11 - PERMIT SANCTIONING & TOOLBOX TALK  <span class="float-right"></span>
    </div>
      <div class="card-body">
        <div class="row m-t-10">
    <div class="col-md-12"> 
        <label >Upload Permit Sanctioning Form</label><br>
        </div>
              
              </div> 
          <?php echo displayPTWCloseAttachment($permitsancformAttachment);?>
           <div style="clear:both"></div>
            <div class="row m-t-10">
    <div class="col-md-12"> 
        <label >Upload Toolbox Talk Form</label><br>
        </div>
              
              </div>
           <?php echo displayPTWCloseAttachment1($permitsancformAttachment1);?>
          </div>
      
      
      </div>
    <?php } ?>
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
<script>
$(document).ready(function (){
        $('.lazy').lazy();
        });
</script>

