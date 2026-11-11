<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:250px;height:75px;">';
$logo1 = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="float:right;width:200px;height:35px;">';
$permitNumber = postData($editData, 'LIVE_PERMIT_NO');
$applicantNumber = postData($editData, 'APPLICANT_NAME');
$companyName = postData($editData, 'COMPANY_NAME', '-');
$designationName = postData($editData, 'APPLICANT_DESIGNATION_NAME', '-');
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
$sectionAttachment = postData($additionalData, 'sectionAttachment');
$hazardActivity = postData($additionalData, 'hazardActivity');
$checkFalse = '<span style="font-family:arial">&#10005;</span>';
$checkTrue = '<span style="font-family:arial">&#10004;</span>';

$specificWorkInstOption = postData($editData, 'SPECIFIC_WORK_INSTRUCTION_OPTION', 0);

$hazardActivityHirarcInfo = postData($additionalData, 'hazardActivityHirarcInfo');

$sc1fName = postData($editData,'SEC1_FILENAME');
$sc1fPath = postData($editData,'SEC1_FILEPATH');

$sec1Imgupl = (isset($sc1fName) && !empty($sc1fName)) ? BASE_URL.''.$sc1fPath.''.$sc1fName : '';

?>

<html>
    <head>
        <style>
            *{
                font-family:calibri; color:#333; font-size:11px; line-height:15px;
            }
            @page {
                size: auto;
                margin-header: 0mm;
                margin-footer: 3mm;
                odd-header-name: html_myHeader1;
                even-header-name: html_myHeader2;
                odd-footer-name: html_myFooter1;
                even-footer-name: html_myFooter2;
            }

            @page noheader {
                odd-header-name: _blank;
                even-header-name: _blank;
                odd-footer-name: _blank;
                even-footer-name: _blank;
            }
            .full-width{
                width:100%;
                font-size: 11px;
            }
            .bg-grey{
                background-color:#f1f1f1; 
                border:1px solid #333;
            }
            .padding-5{
                padding:5px;
            }
            .innertable td{
                padding: 5px 10px 5px; 
            }
            .max-width{
                width:95%;
                margin: 0 auto;
            }
            .bg-light-gr{
                background: #00bcd5;
                color: #fff;
            }
            .bg-light-green{
                background: #8cc34b;
                color: #fff;
            }
            .bg-dark-green{
                background: #009688;
                color: #fff;
            }
            .witness{
                margin-bottom: 20px;
            }
            .witness.even tr td .btn{
                background: #8cc34b !important;
                color: #fff;
            }
            .witness.odd tr td .btn{
                background: #009688 !important;
                color: #fff;
            }
            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }
            .bg-light-blue-active{
                background-color: #357ca5 !important;
            }
            .pull-right{
                text-align:right;
            }
            .innertable{
                margin-bottom: 10px;
            }
            h3{
                font-size:0.9em;
                font-weight:bold;
            }
            .uppertext{
        text-transform: uppercase;
    }
            p{
                font-size:11px;
            }
            p.desc{
                font-size:1em; 
                text-indent: 30px!important;
            }
            .table{
                border:1px solid #bfbebe;
            }

            .inj_per tr:nth-child(odd){
                background-color : rgba(63, 147, 187, 0.10) !important;
            }
            .inj_det tr:nth-child(odd){
                background-color : rgba(59, 188, 212, 0.10) !important;
            }
            .witns tr:nth-child(odd){
                background-color : rgba(241, 146, 52, 0.10) !important;
            }
            .summ tr:nth-child(odd){
                background-color : rgb(228, 228, 228) !important;
            }

            .table td {
                padding:6px;
            }
            
            .boxtitle {

                font-weight: bold;
                color: #333 !important;
            }
            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {

                text-align: justify;
            }
            .texthide{
                display:none;
            }  
            body {
                color-adjust: exact;
                -webkit-print-color-adjust: exact;

            }
            .label_high{
                background-color: #ff0000 !important;

            }
            .label_low{
                background-color: #008f11 !important;
            }
            .label_medium{
                background-color: #f2ff00 !important;
            }

            .labels {

                padding: 10px;
                font-weight: bold;

                text-transform: uppercase;
            }


            .web
            {

                width:100%;
                border-collapse:collapse;
                font-size:11px;
                line-height:25px
            }
            .web td  
            {
                font-size:11px;
                border:1px solid #D9E9F4;
                padding:5px 5px 5px 5px;
            }

            .web tr:nth-child(odd){
                background-color : rgba(63, 147, 187, 0.10) !important;
            }
            .web th 
            {
                font-size:12px;
                text-align:left;
                padding:3px 0px 3px 10px;
                color:#ffffff;
                background-color:#316191;
                border:1px solid #316191;
            }
            .web tr.alt td 
            {
                color:#000000;
                background-color:#316191;
            }



            .panelheading {
                font-size: 11px;
            }
            .panel-body {
                padding: 15px;
            }
            .col-md-3-p {
                width: 22% !important;
            }
            .col-md-12 {
                width: 100% !important;
            }
            .box-header {

                display: block;
                padding: 10px;
                position: relative;
            }

            .box-header.with-border {
                border-radius: 0px !important;
            }
            .box-header.with-border {
                border-bottom: 1px solid #007cb7 !important;
            }

            .col-print{
                padding:20px !important;
            }

            .row {
                margin-right: -10px;
                margin-left: -10px;
            }

            .col-md-6-p {
                width: 42% !important;
            }
            .web td p.fjust{
                text-align: justify !important;
            }
            .web td h5.fright{

                text-align: right !important;
            }
            .txt-uppercase{
                text-transform: uppercase;
               
            }
            .col-md-3-pdf{
               margin: 5px;
    float: left;
    width: 45% !important;
    border: 2px solid #000;
    padding: 5px;
            }
            
             .tab-border table, .tab-border table th, .tab-border table td {
  border: 1px solid black;
  border-collapse: collapse;
}
.tab-border table th, .tab-border table td {
  padding: 15px;
}
.fsize{
    font-size: 11px;
}
    
.doc-border table, .doc-border table th, .doc-border table td {
  border: 1px solid black;
  border-collapse: collapse;
  text-align: center;
}
.doc-border table th, .doc-border table td {
  padding: 5px;
}
.tcenter{
     text-align: center;
}   
.mt10{
    margin-top:10px;
}
  


        </style>

    </head>    
    <body style="font-family:'calibri';">        
    <htmlpageheader name="myHeader1" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">PERMIT TO WORK</td>


            </tr> 

        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $permitNumber;?></td>
            </tr>
        </table>

    </htmlpageheader>
    <htmlpageheader name="myHeader2" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">PERMIT TO WORK</td>


            </tr> 

        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $permitNumber;?></td>
            </tr>
        </table>

    </htmlpageheader>

    <htmlpagefooter name="myFooter1" style="display:none">
        <table width="100%" style="width:100%;border:0;background-color: #FFF;border-top: 4px solid #000;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td width="33%">
                    <span style="font-style: italic;">{DATE d-m-Y}</span>
                </td>
                <td width="33%" align="center" style="font-weight: bold; font-style: italic;">

                </td>
                <td width="33%" style="text-align: right;">
                    {PAGENO}/{nbpg}
                </td>
            </tr>
        </table>
    </htmlpagefooter>

    <htmlpagefooter name="myFooter2" style="display:none">
        <table width="100%" style="width:100%;border:0;background-color: #FFF;border-top: 4px solid #000;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td width="33%">My document</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
            </tr>
        </table>
    </htmlpagefooter>  


    <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                SECTION 1 – REQUISITION – PERMIT APPLICANT OF PERFORMING AUTHORITY (PA)
            </td>

        </tr>
    </table>

    <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Permit No</b></td>
            <td>:</td>
            <td ><?php echo $permitNumber; ?></td>
            <td class="tdlabel txt-uppercase"><b>Applicant's Name</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $applicantNumber; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Designation</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $designationName; ?></td>
            <td class="tdlabel txt-uppercase"><b>Section/Division</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $sectionName; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Location</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $locName; ?></td>
            <td class="tdlabel txt-uppercase"><b>Specific Location</b></td><td class="title-colon">:</td>
            <td ><?php echo $specificLocationName; ?></td>

        </tr>
        <tr>
             <td class="tdlabel txt-uppercase"><b>Company Name</b></td>
            <td class="title-colon">:</td>
            <td colspan="4"><?php echo $companyName; ?></td>
        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Date Start</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $displayStartDate; ?></td>
            <td class="tdlabel txt-uppercase"><b>Completion Date</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $displayEndDate; ?></td>

        </tr>
        <tr>
            <td colspan="6"><b>Blanket Permit valid for 7 days only (inclusive Sunday & Public Holiday)</b></td>
        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Area Classification</b></td>
            <td class="title-colon">:</td>
            <td colspan="4"><?php echo $areaClsName; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Work Description </b></td>
            <td class="title-colon">:</td>
            <td colspan="4"><?php echo $workDesc; ?></td>

        </tr>
        
        
        <?php if($specificWorkInstOption == 1){?>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Special Work Instruction </b></td>
            <td class="title-colon">:</td>
            <td colspan="4"><?php echo $specificWorkInst; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Document Upload </b></td>
            <td class="title-colon">:</td>
            <td colspan="4">
                <ol>
                <?php 
             if ($sectionAttachment != FALSE) {
                 $i=0;
                        foreach ($sectionAttachment as $akey => $attachmnt) {
                            $i++;
                            $filepath = postData($attachmnt, 'SEC_FILE_PATH');
                            $filename = postData($attachmnt, 'SEC_FILENAME');
                            $fileext = postData($attachmnt, 'SEC_FILE_EXT');
                            $is_image = postData($attachmnt, 'IS_IMAGE');
                            $fileFullpath = BASE_URL . $filepath . $filename;
                            
                            $displayLabel = ($is_image == 1) ? '<img  src="' . $fileFullpath . '" width="200px" height="150px" style="vertical-align: top;padding-top:10px;padding-bottom:10px;" />' : $filename;
                            ?>

                    <li><a href='<?php echo $fileFullpath;?>' target="_new" title="Click to view file"><?php echo $filename;?></a></li>

                            <?php
                        }
                        ?>
                    <?php } ?>
                </ol>
            </td>

        </tr>
        <?php } else { ?>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Special Work Instruction </b></td>
            <td class="title-colon">:</td>
            <td colspan="4">N/A</td>

        </tr>
        <?php } ?>
	<?php if(isset($sc1fName) && !empty($sc1fName)){ ?>
	<tr>
            <td class="tdlabel txt-uppercase"><b> Image Upload </b></td>
            <td class="title-colon">:</td>
            <td colspan="4">
               <a href='<?php echo $sec1Imgupl;?>' target="_new" title="Click to view Image">Click here to view Image</a>
            </td>
        </tr>
	<?php } ?>
    </table>
    
    <!-- Section 2 -->
    
    <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;" class="txt-uppercase">
                Section 2 - Hazardous Activities<span class="float-right"></span>
            </td>

        </tr>
    </table>
    <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        

        <div class="box-body " style="padding:15px 0;">
    
    <?php
    $hazardActivityHirarcInfo = postData($additionalData, 'hazardActivityHirarcInfo');
    $hazardActivityOther = postData($additionalData, 'hazardActivityOther');
    $hzActivityInfo = postData($additionalData, 'hzActivityInfo');




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
            <div  style="padding:20px;">
                <div class="col-md-6">  
                    <b> <label ><?php echo postData($val, 'CAT_NAME'); ?></label></b><br>
                   
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

            <div class="" style="padding-left:15px;">
                    <div class="col-md-6" style="padding-left:20px;">  

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
<!--                                        <div class="" style="padding-left:15px;">
                                                <div class="col-md-6">  
                                                    <?php echo isset($hirarcType[$hirarc_type]) ? $hirarcType[$hirarc_type] : ''; ?>
                                                </div>
                                            </div>-->
                                            <div class="" style="<?php echo $showHideEmpClass; ?>;" >

                                                <div class="col-md-12" style="padding-left:15px;"> 
                                                    <label >HIRARC ID</label><br>
<?php
                                                            if ($hazardActivityHirarcInfo != FALSE && count($hazardActivityHirarcInfo) > 0) {
?>
                                                    <table style="width:80%;" class="table summ full-width innertable tcenter">
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
                                                            <?php } else {
                                                     echo '<p style="padding-left:10px;">N/A</p>';
                                                            }?>
                                                </div>

                                            </div>

                                            <div class="row" style="padding-left:15px;">

                                                <div class="col-md-12" style="padding-left:15px;">

                                                    <label >Document Upload </label>
                                                    <?php echo displayPTWHZPDFAttachment($hzAttachmentInfo); ?>
                                                </div>  
                                            </div>

                                            <?php
                                            /* Section HIRARC End */
                                        } else {
                                            if ($hazAddId == 26) { /* Section Other start */
                                                ?>
                                                <div class="" style="padding-left:15px;">
                                                    <div class="col-md-6">
                                                        <ol style="padding-left:30px;">
                                                            <li><?php echo $other_hazard_desc; ?></li>
                                                        </ol>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            /* Section Other end */
                                            if (in_array($hazardActId, [3])) {
                                                ?>
                                                <div class="row" style="padding-left:15px;">
                                                    <div class="col-md-12">

                                                        <label >Document Upload </label>
                                                        <?php echo displayPTWHZPDFAttachment($hzAttachmentInfo); ?>
                                                    </div>  
                                                </div>
                                            <?php } else if($hazChecklist == 'Y') { // Cheklist is Yes the photo upload will shown // Critical
                                            $checklistInfo = getHazardActivitiesChecklist($hazAddId);
                                             $showClass = ($hazAddId == 19) ? 'display:block;': 'display:none;';
                                            echo form_hidden('hazActClearanceCert['.$hazAddId.']','Y');
                                                                                        

             $checkListCC = postData($hzclearance_certificate_checklist,'checklistIds');                   $aCheckListCC   = ($checkListCC != FALSE) ? explode(',',$checkListCC):[];    
                                        
                                            ?>
                                        <div style="padding-left:10px;margin-right: 10px;margin-top: 10px;margin-bottom: 10px;">
                                 
                                        <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
                                             <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;" class="txt-uppercase">
                 <?php echo $hazName.' CLEARANCE CERTIFICATE';?>
            </td>

        </tr>
    </table>
                                            
                                            <div class="box-body" style="padding-left:15px;">
                                                
                                                <div class="row" style="margin:10px 0px;">
                                                <div class="col-md-12">
                                                <div class="form-check">
                                                   
                                    <label class="form-check-label" for="<?php echo 'cc_declaration_'.$hazAddId; ?>"><?php echo $checkTrue;?> <?php echo $hazDeclaration;?></label>
                                </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row m-t-10" style="margin:10px 0px;">
                                                <div class="col-md-12">
                                                    <label><b>Checklist :</b> </label>
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
                                            
                                            
                                            
                                             <div class="row m-t-10 " style="margin:10px 0px;">
                                      <div class="col-md-12">
                                           
                                          <label ><b>Photo Upload</b> </label>
                                               				    
                                                <div class="clearfix"></div>
                                                
                                                <?php 
                                                if($hzclearance_certificate_Attachment != FALSE && count($hzclearance_certificate_Attachment) > 0){
                                                    
                                                echo displayPTWHZCCPDFAttachment($hzclearance_certificate_Attachment);
                                                } else {
                                                    echo '<div style="padding-left:30px;">No Photo Upload</div>';
                                                }?>
                                            </div>  
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
                            <div class="form-check" >
                                    <?php echo $checkedLabel; ?>
                                    <label class="form-check-label" for="<?php echo $formIdName; ?>-1">Others</label>
                                </div>
                                <div class="additional_doc docLabel" id="add_<?php echo $formIdName; ?>_-1" style="<?php echo $showHideClass; ?>;padding-left:35px;margin-left:20px;" >
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
    <div style="clear:both"></div>
    <table style="width:100%;padding-bottom: 10px;margin-top:10px;">
        <tr>
            <td class="txt-uppercase" style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                Section 3 - WORKSITE PREPARATION/PRECAUTIONS (Select appropriate boxes)
            </td>

        </tr>
    </table>   
     <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        

        <div class="box-body" style="padding:15px 0;">
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
                
                $headerCheckListName = '  <div class="" style="padding-left:15px;">
                    <div  style="padding-left:20px;">  
                        <label ><b>'.postData($wppcat, "WPPC_NAME").'</b></label><br>

                    </div>
                </div>';
                ?>
              
                <?php
                $noData = FALSE;
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
            <div class="form-check" style="padding-left:35px;">
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
            }
        }
        ?>
     </div>
        </div>  
    
    <div style="clear:both"></div>
    <table style="width:100%;padding-bottom: 10px;margin-top:10px;">
        <tr>
            <td class="txt-uppercase" style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                SECTION 4 - PERSONAL PROTECTIVE EQUIPMENT (Select appropriate boxes)
            </td>

        </tr>
    </table>   
     <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        
        <div class="box-body" style="padding:15px 0;">
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
                $ppeHeadChecklistName = '<div class=" mt10" style="padding-left:20px;">
                    <div class="col-md" >  
                        <label ><b>'.$PPEName.'</b></label><br>

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
                        $ppeRequireClass = ($checked) ? 'display:block' : 'display:none;';
                        $readOnlyCheck = 'onclick="return false;"';
                        if($checked){
                            $noPPEDataCount = $noPPEDataCount+1;
                            if($ppeCheckLoop == 1){
                                 echo $ppeHeadChecklistName;
                            }
                           
                        ?>
                        <div class="form-check" style="padding-left:30px;">
                            <?php echo $checkedLabel; ?>

                            <label class="form-check-label" for="<?php echo $formIdName . $PPEItemId; ?>">
                                <?php echo $PPEName; ?> 
                            </label>
                        </div>
                        <div class="additional_ppe_doc" id="add_<?php echo $formIdName; ?>_<?php echo $PPEItemId; ?>"  style="<?php echo $ppeRequireClass; ?>;padding-left:30px;"></div>
                        <?php
                        }
                    }
                }
                
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
                
                
                ?>



                <?php
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
        <div class="form-check" style="padding-left:30px;">
            <?php echo $checkedLabel; ?>
            <label class="form-check-label" for="<?php echo $formIdName . '-1'; ?>">Others</label>
        </div>
        <div class="additional_ppe_doc" id="add_<?php echo $formIdName; ?>_-1"  style="<?php echo $ppeRequireClass; ?>;padding-left:20px;"> 

            <div class=" m-t-10"  style="padding-left:40px;">
                <div class="col-md-6">
                    <ol>
                        <li><?php echo $other_ppe_desc; ?></li>
                    </ol>
                </div>
            </div>

            <div class=" m-t-10 " style="padding-left:40px;">

                <div class="col-md-12">

                    <label >Upload Photo </label>

                    <div class="clearfix"></div>
                    <br/>
                    <?php echo displayPPEPDFAttachment($otherPPEAttachment); ?>
                </div>  
            </div>


        </div>
        <?php } ?>
        </div>
      </div> 
    
    <div style="clear:both"></div>
    <table style="width:100%;padding-bottom: 10px;margin-top:10px;">
        <tr>
            <td class="txt-uppercase" style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                SECTION 5 - JOINT VISIT BEFORE WORK COMMENCES
            </td>

        </tr>
    </table>   
     <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        

        <div class="box-body" style="padding:15px 0;">
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
        <div class="row" style="padding-left:20px;">
            <div class="col-md-12">
                <div class="form-check">
                    <label class="form-check-label" for="initial_declaration">
                        <?php echo $initialChecked; ?> I understand the required Checkbox precautions specified in Section 3 in order to perform activity stipulated on section 2 and accept all responsibilities for the work stated
                    </label>
                </div>
            </div>
        </div>
        <br/>
        <div class="row" style="padding-left:20px;">
            <div class="col-md-12">
                <table style="width:97%;" class="table summ full-width innertable tcenter">
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
   
     <div style="clear:both"></div>
    <table style="width:100%;padding-bottom: 10px;margin-top:10px;">
        <tr>
            <td class="txt-uppercase" style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                SECTION 6 - WORKING IN CONFINED SPACE<span class="float-right"></span>
            </td>

        </tr>
    </table>
      <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        

        <div class="box-body" style="padding:15px 10px;">
            
<div class="row" style="padding-left:20px;margin-top: 10px;">
        <div class="col-md-12">
              <label><b>A) GAS TEST MONITORING (Select appropriate boxes)</b></label>
    </div>
</div>
                                    

<div class="row m-t-10" style="margin-left:10px;margin-top: 5px;margin-bottom: 5px;">
    <div class="col-md-12">
        <div class="form-check">
            
            <label class="form-check-label" for="gas_test_declaration">
             <?php echo $checkTrue;?>   GAS TEST
            </label>
        </div>
        
    </div>
</div>

            <div class="row"  id="confinedspaceentry" style="padding-left:25px;padding-right: 10px;">
    <div class="col-md-12 doc-border">
        <label style="">Gas Test Result</label>
        <table class="table" style="margin:10px 0px;">
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
                                    <?php } ?>
<!-- Section 7 Verification-->
<?php 
$applicantName = postData($editData, 'SHO_HSE_NAME');
$qaName = postData($editData, 'OA_NAME');
if($applicantName !='' || $qaName !=''){
?>
    <div style="clear:both"></div>
    <table style="width:100%;padding-bottom: 10px;margin-top:10px;">
        <tr>
            <td class="txt-uppercase" style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                Section 7 – Verification
            </td>

        </tr>
    </table>   
     <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        

        <div class="box-body" style="padding:15px 10px;">
            
<div class="row" style="padding-left:20px;margin-top: 10px;">
        <div class="col-md-12">
              <label><b>A.Verification by SHO/HSE Executive</b></label>
    </div>
</div>
          
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
            <div class="row" style="padding-left:30px;margin-top:10px;">

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
        <div class="row m-t-10" style="padding-left:30px;margin-top:15px;margin-bottom: 15px;">
            <div class="col-md">  
                <label ><b>Remark</b> </label><br>
                <?php echo $hse_remark;?>
            </div>
        </div>
        
        <div class="row" style="padding-left:30px;">
            <div class="col-md-12">
                <table  style="width:97%;" class="table summ full-width innertable tcenter">
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
<div class="row" style="padding-left:20px;margin-top: 10px;">
        <div class="col-md-12">
            <label><b>B.VERIFICATION BY OPERATING AUTHORITY (OA)</b></label>
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


<div class="row" style="padding-left:30px;margin-top: 10px;margin-bottom: 10px;">
    <div class="col-md-12">
        <div class="form-check">
           
            <label class="form-check-label" for="qa_declaration">
                <?php echo $initialChecked;?> I understand the activity/precautions and fulfilment of this permit, therefore I authorized the PA to commence with the work described in Section 1.
            </label>
        </div>
      
    </div>
</div>
            <div class="row m-t-10" style="padding-left:30px;margin-top:15px;margin-bottom: 15px;">
            <div class="col-md">  
                <label ><b>Remark</b> </label><br>
                <?php echo $qa_remark;?>
            </div>
        </div>
        
         <div class="row" style="padding-left:30px;">
            <div class="col-md-12">
                <table  style="width:97%;" class="table summ full-width innertable tcenter">
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
    <div style="clear:both"></div>
    <table style="width:100%;padding-bottom: 10px;margin-top:10px;">
        <tr>
            <td class="txt-uppercase" style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                SECTION 8 - PERMIT STOPPAGE - RE-ACTIVATE PERMIT
            </td>

        </tr>
    </table>   
    <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        
        <div class="box-body" style="padding:15px 10px;">
            
            <div class="row" style="padding-left:20px;">
                    <div class="col-md-12">
                          <label><b>A.STOP WORK ORDER</b></label>
                </div>
            </div>
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
<div class="row" style="padding-left:30px;">
    <div class="col-md-12">
        <div class="form-check">
           
            <label class="form-check-label" for="stop_cancel_declaration"><?php echo $checked;?> Permit Stoppage/Cancel Permit
            </label>
        </div>
        
    </div>
</div>
         <div class="row m-t-10" style="padding-left:30px;margin-top: 10px;margin-bottom: 10px;">
    <div class="col-md">  
        <label ><b>Comments</b>  </label><br>
        <div>
           <?php echo $stop_comments;?>
        </div>
    </div>
</div>
         <div class="row" style="padding-left:30px;">
            <div class="col-md-12">
                <table style="width:97%;" class="table summ full-width innertable tcenter">
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

  <div class="row" style="padding-left:20px;">
                    <div class="col-md-12">
                          <label><b>B.RE-ACTIVATE PERMIT</b></label>
                </div>
  </div>

<div class="row" style="padding-left:30px;">
    <div class="col-md-12">
        <div class="form-check">
           
            <label class="form-check-label" for="reactivate_cancel_declaration"><?php echo $checkedLabel;?> Permit Stoppage/Cancel Permit
            </label>
        </div>
        
    </div>
    
</div>
   <div class="row m-t-10" style="padding-left:30px;margin-top: 10px;margin-bottom: 10px;">
    <div class="col-md">  
        <label ><b>Comments</b>  </label><br>
        <div>
           <?php echo $reactivate_comments;?>
        </div>
    </div>
</div>
         <div class="row" style="padding-left:30px;">
            <div class="col-md-12">
                <table style="width:97%;" class="table summ full-width innertable tcenter">
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
     <div style="clear:both"></div>
    <table style="width:100%;padding-bottom: 10px;margin-top:10px;">
        <tr>
            <td class="txt-uppercase" style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                SECTION 9 - PERMIT RECIPIENT
            </td>

        </tr>
    </table>   
    <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        
        <div class="box-body" style="padding:15px 10px;">
            <div class="row" style="padding-left:20px; margin-bottom: 10px;">
                    <div class="col-md-12">
                          <label><b>WORK SUPERVISOR (WS)</b></label>
                </div>
            </div>
            
             <div class="row" style="padding-left:30px;margin-bottom: 10px;">
    <div class="col-md-12">
        <div class="form-check">
           
            <label class="form-check-label" for="work_supervisor_declaration">
              <?php echo $checkedLabel;?>  I had understand the permit content and shall comply with the PTW requirement before, during and after the work is complete.
            </label>
        </div>
       
    </div>
</div>
        
        <div class="row m-t-10" style="padding-left:30px;">
            <div class="col-md-12">
                <table style="width:97%;" class="table summ full-width innertable tcenter">
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
     <div style="clear:both"></div>
    <table style="width:100%;padding-bottom: 10px;margin-top:10px;">
        <tr>
            <td class="txt-uppercase" style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                 SECTION 10 - COMPLETION OF WORK (PERMIT CLOSURE)
            </td>

        </tr>
    </table>   
    <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        
        <div class="box-body" style="padding:15px 10px;">
            <div class="row" style="padding-left:20px; margin-bottom: 10px;">
                    <div class="col-md-12">
                          <label><b>WORK SUPERVISOR (WS) / PERFORMING AUTHORITY (PA)</b></label>
                </div>
            </div>
            
            <div class="row" style="padding-left:30px;margin-bottom: 10px;">
    <div class="col-md-12">
        <div class="form-check">
            
            <label class="form-check-label" for="work_complete_declaration">
               <?php echo $checkedLabel;?> Job Task Completed. Worksite has been restored to safe condition.
            </label>
        </div>
       
    </div>
</div>
           
          
          <div class="row m-t-10" style="padding-left:30px;margin-top: 10px;">
            <div class="col-md-12">
                <table style="width:97%;" class="table summ full-width innertable tcenter">
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
     
     <div style="clear:both"></div>
    <table style="width:100%;padding-bottom: 10px;margin-top:10px;">
        <tr>
            <td class="txt-uppercase" style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                 SECTION 11 - PERMIT SANCTIONING & TOOLBOX TALK
            </td>

        </tr>
    </table>   
    <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        
        <div class="box-body" style="padding:15px 10px;">
            <div class="row m-t-10" style="padding-left:30px;margin-bottom: 10px;">
    <div class="col-md-12"> 
        <label >Upload Permit Sanctioning Form</label><br/>
        </div>
              
              </div>
            <div class="row m-t-10" style="padding-left:30px;margin-bottom: 10px;">
            <?php echo displayPTWClosePDFAttachment($permitsancformAttachment);?>
                 </div>
        </div>
        </div>
      <div style="clear:both"></div>
      <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        
        <div class="box-body" style="padding:15px 10px;">
            <div class="row m-t-10" style="padding-left:30px;margin-bottom: 10px;">
    <div class="col-md-12"> 
        <label >Upload Toolbox Talk Form</label><br/>
        </div>
              
              </div>
            <div class="row m-t-10" style="padding-left:30px;margin-bottom: 10px;">
            <?php echo displayPTWClosePDFAttachment1($permitsancformAttachment1);?>
                 </div>
        </div>
        </div>
 <?php } ?>
        </body>
</html>

