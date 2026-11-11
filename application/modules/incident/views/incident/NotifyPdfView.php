

<?php
//echo '<pre>';print_r($editData);exit;


   $logo = '<img src="' . BASE_URL . 'assets/images/slider/LOGO-LUMUT-PORTju.png " style="width:250px;height:75px;">';
   if (isset($id) && $id != "") {
    $reportedName = postData($editData, 'EVENT_REPORT_NAME', $this->input->post('reported_name'));
    $reportedCompany = postData($editData, 'EVENT_REPORT_COMPANY', $this->input->post('reported_cmp'));
    $reportedDesignation = postData($editData, 'EVENT_REPORT_DESIGNATION', $this->input->post('reported_desgn'));
    $reportedActivity = postData($editData, 'EVENT_REPORT_ACTIVITY_PERFORMED', $this->input->post('reported_activity'));
    $reportedIDtype = postData($editData, 'ID_TYPE', $this->input->post('reported_ID_TYPE'));
    $reportedIDNo = postData($editData, 'IC_PASSPORT_NO', $this->input->post('reported_icpassno'));
    $reportedPhno = postData($editData, 'PHONE_NO', $this->input->post('reported_phoneno'));
} else {
    $reportedName = postData($userDetails, 'NAME', $this->input->post('reported_name'));
    $reportedCompany = postData($userDetails, 'COMPANY', $this->input->post('reported_cmp'));
    $reportedCompany = ($reportedCompany == '') ? 'Lumut Port' : $reportedCompany;
    $reportedDesignation = postData($userDetails, 'DESIGNATION', $this->input->post('reported_cmp'));
    $reportedActivity = $this->input->post('reported_activity');
    $reportedIDtype = postData($userDetails, 'ID_TYPE', $this->input->post('reported_ID_TYPE'));
    
}
  $INVESTIGATION_ACTION = $editData->INVESTIGATION_ACTION;
  $NOT_REQUIRED_REASON = $editData->NOT_REQUIRED_REASON;
  if($INVESTIGATION_ACTION == '1'){
   $invesAcrion  = 'Detail Investigation Required';
  }
  else if($INVESTIGATION_ACTION == '2'){
    $invesAcrion  = 'Detail Investigation Not Required';
  }
  else if($INVESTIGATION_ACTION == '0'){
    $invesAcrion  = 'Irrelevant';
  }
  else{
    $invesAcrion  = 'Not Yet Started';
  }

$newreportedIDNo = $detail['LocationDetail']['IC_PASSPORT_NO'];
  $newreportedPhno = $detail['LocationDetail']['PHONE_NO'];

  $reportedIDNo = $detail['SpecificLoc']['IC_PASSPORT_NO'];
  $reportedPhno = $detail['SpecificLoc']['PHONE_NO'];
$POLICE_CASE_NO = postData($editData, 'POLICE_CASE_NO', $this->input->post('POLICE_CASE_NO'));
$POLICE_OTHER_INFO = postData($editData, 'POLICE_OTHER_INFO', $this->input->post('POLICE_OTHER_INFO'));

$HOSPITAL_CASE_NO = postData($editData, 'HOSPITAL_CASE_NO', $this->input->post('HOSPITAL_CASE_NO'));
$HOSPITAL_OTHER_INFO = postData($editData, 'HOSPITAL_OTHER_INFO', $this->input->post('HOSPITAL_OTHER_INFO'));

$OTHER_CASE_NO = postData($editData, 'OTHER_CASE_NO', $this->input->post('OTHER_CASE_NO'));
$OTHER_OTHER_INFO = postData($editData, 'OTHER_OTHER_INFO', $this->input->post('OTHER_OTHER_INFO'));

$eventRelatedList = (postData($editData, 'EVENT_RELATED_TO_IDS', '') != "") ? explode(',', postData($editData, 'EVENT_RELATED_TO_IDS')) : ((!empty($this->input->post('eventRelatedTo'))) ? $this->input->post('eventRelatedTo') : []);
$eventTypeList = (postData($editData, 'EVENT_TYPE_IDS', '') != "") ? explode(',', postData($editData, 'EVENT_TYPE_IDS')) : ((!empty($this->input->post('eventType'))) ? $this->input->post('eventType') : []);
$notifyAttachments = postData($editData, 'notifyAttachments');
$personsInvolved = postData($editData, 'persons');
$desc = postData($editData, 'EVENT_DESC', $this->input->post('description'));
$immedActon = postData($editData, 'IMMEDIATE_ACTION_TAKEN', $this->input->post('immediateAction'));
$equiinvolve = postData($editData, 'EQUIPMENT_INVOLVED', $this->input->post('equipmentInvolved'));
$policecheck = postData($editData, 'POLICE', $this->input->post('police_check'));
if($policecheck == 'N'){
   $policeChecked = 'No';
}
else{
   $policeChecked = 'Yes';
}
$hospcheck = postData($editData, 'HOSPITAL', $this->input->post('hospital_check'));
if($hospcheck == 'N'){
   $hospchecked = 'No';
}
else{
   $hospchecked = 'Yes';
}
$othercheck = postData($editData, 'OTHER', $this->input->post('other_check'));
if($othercheck == 'N'){
   $otherchecked = 'No';
}
else{
   $otherchecked = 'Yes';
}
$readonly = '';
$readonly2 = false;
$required = '';
if ($role_id == 11) {
    $readonly = 'disabled';
    $readonly2 = true;
    $required = 'required';
}
$trigger = FALSE;
if ($editData != FALSE) {
    $trigger = TRUE;
    $eventDate = ($eventDate != '') ? $eventDate : '';
}
   $desiUser = $_SESSION['emp_details']->design_name;
   $currentDate = date('d-m-Y h:i:s');
   $workRelated = $detail['IncidentInvestigationData']['INCIDENT_WORK_RELATED'];

   
   $eventDate1 = postData($editData, 'eventDate', $this->input->post('eventDate'));
   //echo '<pre>';print_r($eventDate1);exit;
   //$eventDate = date('d-m-Y',strtotime($eventDate1));

   $INCIDENT_ID = postData($editData, 'INCIDENT_ID', $this->input->post('INCIDENT_ID'));
   $eventTime = postData($editData, 'EVENT_TIME', $this->input->post('eventTime'));
   //echo '<pre>';print_r($eventTime);exit;
   $locid = postData($editData, 'LOCATION_ID', $this->input->post('eventLocation'));
   $speclocid = postData($editData, 'SPECIFIC_LOCATION_ID', $this->input->post('specificLocation'));

      $speclocother = postData($editData, 'SPECIFIC_LOCATION_OTHER', $this->input->post('specificlocother'));
      if($speclocid == '-1'){
          $SpecificVal = 'Others' . '  -  '. $speclocother;
      }
      else{
         $SpecificVal =  $detail['SpecificLoc']['SPECIFIC_LOC_NAME'];
      }
   
   $employeeId = postData($editData, 'EMPLOYEE_ID', $this->input->post('employeeId'));
   $employeeName = ($editData->persons[0]->PERSON_NAME);
   $designation = ($editData->persons[0]->DESINATION);
   $employeephnNoo = ($editData->persons[0]->PHONE_NO);
   $descriptionForCompentency = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['COMPETENCY_RECORDS']:""); 
   $ImmediateCauseDescrp = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['IMMEDIATE_CAUSES']:"");
   $RootCauseOfSummary = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['POSSIBLE_ROOT_CAUSES']:"");
   $ContributingSummary = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['CONTRIBUTE_CAUSAL_FACTOR']:"");
   $RecomendationSummary = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['INVEST_PROPOSED_ACTION']:"");
   $IncidentActivity = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['ACTIVITY']:"");
   $IncidentEmpCount = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['EMP_CONT']:"");
  
   ?>
<html>

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
            .rootUps {
             width: 30%;
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
  


        </style>
        </head>


   <body>
   <htmlpageheader name="myHeader1" style="display:none">
    <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td border="0"  style="width:10%;float:left;text-align:left;"><?php echo $logo; ?></td>
            <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">INCIDENT/NOTIFICATION REPORT</td>
            </tr>
        </table>
       <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $NotifyId;?></td>
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


    <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                 Event Report To: LMTSB HSSE DIVISION   
            </td>

        </tr>
    </table>

   <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Event Date</b></td>
            <td class="title-colon">:</td>
            <td><?php echo $eventDate1; ?></td>
            <td class="tdlabel txt-uppercase"><b>Event Time</b></td>
            <td class="title-colon">:</td>
            <td><?php echo $eventTime; ?></td>

        </tr>

        <tr>
            <td class="tdlabel txt-uppercase"><b>Event Location</b></td>
            <td class="title-colon">:</td>
            <td><?php echo $detail['LocationDetail']['TERMINAL_SHORTNAME']; ?></td>
            <td class="tdlabel txt-uppercase"><b>Specific Location</b></td>
            <td class="title-colon">:</td>
            <td><?php echo $SpecificVal; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Event Related to</b></td>
            <td class="title-colon">:</td>
            <td><?php $i = 1;//echo 'M<pre>';print_r($eventTypeDt);exit;
            foreach($eventRelatedToDt as $e) {?>
             <?php if($i == count($eventRelatedToDt)) { echo $e['INCIDENT_EVENT_NAME'] . ' '; } else{ echo $e['INCIDENT_EVENT_NAME'] . ' , '; } ?>
              <?php $i++ ;} ?></td>
            <td class="tdlabel txt-uppercase"><b>Event Type</b></td>
            <td class="title-colon">:</td>
            <td><?php $i = 1; foreach($eventTypeDt as $d) {?>
             <?php if($i == count($eventTypeDt)) { echo $d['EVENT_TYPE_NAME'] . '  '; } else{ echo $d['EVENT_TYPE_NAME'] . ' , '; } ?>
              <?php $i ++;} ?></td>
            

        </tr>
        <tr>
           
            <td class="tdlabel txt-uppercase"><b>Event Description </b></td>
            <td class="title-colon">:</td>
            <td colspan="4"><?php echo $desc; ?></td>
        </tr>
        <tr>

         <td class="tdlabel txt-uppercase"><b>Immediate Action Taken </b></td>
            <td class="title-colon">:</td>
            <td colspan="4"><?php echo $immedActon; ?></td>
          </tr>
     </table>
<table style="width:100%;" class="table summ full-width innertable">
<tr>
<?php
if (isset($notifyAttachments)) {
foreach ($notifyAttachments as $key => $notifyatt) {

$filepath = BASE_URL . postData($notifyatt, 'fileset');
//echo '<pre>';print_r($filepath);exit;
?>
<td><img class="rootUps" src = "<?php echo $filepath; ?>" style="width:50%;height:50%"></td>
<?php } } ?>

</tr>

</table>

       <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                  Person(s) Involved
            </td>

        </tr>
        </table>
        
        
           <?php
                if (isset($personsInvolved)) {
                   // echo '<pre>';print_r($personsInvolved);exit;
              
              ?>
             <table style="width:100%;" class="table summ full-width innertable">
                <?php $i = 1;
              foreach ($personsInvolved as $key => $persons) { ?>
            <tr>
            <td class="tdlabel txt-uppercase"><b>Name </b></td>
            <td>:</td>
            <td ><?php echo postData($persons, 'PERSON_NAME', ''); ?></td>

            <td class="tdlabel txt-uppercase"><b>Company </b></td>
            <td>:</td>
            <td ><?php echo postData($persons, 'COMPANY', ''); ?></td>
            </tr>

             <tr>
            <td class="tdlabel txt-uppercase"><b>Designation / Occupation </b></td>
            <td>:</td>
            <td ><?php echo postData($persons, 'DESINATION', ''); ?></td>

            <td class="tdlabel txt-uppercase"><b>Activity Being Performed </b></td>
            <td>:</td>
            <td ><?php echo postData($persons, 'ACTIVITY_BEING_PERFOMED', ''); ?></td>
            </tr>
             
            <tr>
            <td class="tdlabel txt-uppercase"><b>Ic/Passport number </b></td>
            <td>:</td>
            <td ><?php echo postData($persons, 'IC_PASSPORT_NO', ''); ?></td>

            <td class="tdlabel txt-uppercase"><b>Phone no </b></td>
            <td>:</td>
            <td ><?php echo postData($persons, 'PHONE_NO', ''); ?></td>
            </tr>

            <?php $i++; } } else{ echo 'No Data Available'; }?>

           </table>

        <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                  Equipment(s) Involved 
            </td>

        </tr>
        </table>

        <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Equipment(s) Involved </b></td>
            <td>:</td>
            <td ><?php echo $equiinvolve; ?></td>
        </tr>
       
      </table>

      <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                   External Agencies 
            </td>

        </tr>
        </table>

        <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <th class="tdlabel txt-uppercase"><b>Title </b></th>
            <th >Check</th>
            <th >Case No</th>
            <th >Other Info</th>
        </tr>
        <tr>
            <td >POLICE </td>
            <td ><?php echo $policeChecked; ?></td>
            <td ><?php echo $POLICE_CASE_NO;?> </td>
            <td ><?php echo $POLICE_OTHER_INFO; ?></td>
        </tr>
        <tr>
            <td >HOSPITAL </td>
            <td ><?php echo $hospchecked; ?></td>
            <td ><?php echo $HOSPITAL_CASE_NO;?></td>
            <td ><?php echo $HOSPITAL_OTHER_INFO;?></td>
        </tr>
        <tr>
            <td >OTHER </td>
            <td ><?php echo $otherchecked; ?></td>
            <td ><?php echo $OTHER_CASE_NO;?></td>
            <td ><?php echo $OTHER_OTHER_INFO;?></td>
        </tr>
       
      </table>

       <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                    Event Reported by  
            </td>

        </tr>
        </table>

         <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Name </b></td>
            <td>:</td>
            <td ><?php echo $reportedName; ?></td>
            <td class="tdlabel txt-uppercase"><b>Company </b></td>
            <td>:</td>
            <td ><?php echo $reportedCompany; ?></td>
        </tr>

        <tr>
            <td class="tdlabel txt-uppercase"><b>Designation </b></td>
            <td>:</td>
            <td ><?php echo $reportedDesignation; ?></td>
            <td class="tdlabel txt-uppercase"><b>Activity being performed </b></td>
            <td>:</td>
            <td ><?php echo $reportedActivity; ?></td>
        </tr>

         <tr>
            <td class="tdlabel txt-uppercase"><b>ID Type </b></td>
            <?php
            if($reportedIDtype == 'NRIC'){
              $idTypes = 'IC';
            }
            else{
              $idTypes = 'Passport';
            }
               
            ?>
            <td>:</td>
            <td ><?php echo $idTypes; ?></td>
            <td class="tdlabel txt-uppercase"><b>IC/Passport No</b></td>
            <td>:</td>
            <td ><?php echo $newreportedIDNo; ?></td>
        </tr>

        <tr>
            <td class="tdlabel txt-uppercase"><b>Phone No </b></td>
            <td>:</td>
            <td ><?php echo $newreportedPhno; ?></td> 
        </tr>
       
      </table>

       <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                    Action 
            </td>

        </tr>
        </table>

         <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>INVESTIGATION ACTION</b></td>
            <td>:</td>
            <td ><?php echo $invesAcrion; ?></td>
            <?php if($NOT_REQUIRED_REASON !=''){ ?>
            <td class="tdlabel txt-uppercase"><b>INVESTIGATION NOT REQUIRED REASON</b></td>
            <td>:</td>
            <td ><?php echo $NOT_REQUIRED_REASON; ?></td>
           <?php }  ?>
        </tr>
      </table>

       <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                    GLOSSARY OF INCIDENT RELATED TERMS 
            </td>

        </tr>
        </table>


 <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <th style="text-align: left;">Health / Hygiene</th>
          <th style="text-align: left;">Safety</th>
          <th style="text-align: left;">Fire</th>
          <th style="text-align: left;">Environment</th>
          <th style="text-align: left;">Security</th>
      </tr>
      <tr>
          <td>Amputation</td>
          <td>Near Miss</td>
          <td>Near Miss</td>
          <td>Near Miss</td>
          <td>Near miss assault</td>
      </tr>
      <tr>
          <td>Caused by cauterization</td>
          <td>Equipment fail lost work day</td>
          <td>Chemical spill</td>
          <td>Chemical spill/Fumes</td>
          <td>Criminal act</td>
      </tr>
      <tr>
          <td>Caused by injury</td>
          <td>Operation fail</td>
          <td>Fire</td>
          <td>Gas Release / Fumes hazardous waste</td>
          <td>Road accident</td>
      </tr>
      <tr>
          <td>Eye injury fatality</td>
          <td>Restricted work fall</td>
          <td>Fire Alarm</td>
          <td>Marine pollution</td>
          <td>Theft</td>
      </tr>
      <tr>
          <td>Fracture</td>
          <td>Oxygen deficiency</td>
          <td>Explosion</td>
          <td>Noise</td>
          <td>Traffic Violation</td>
      </tr>
      <tr>
          <td>Occupational illness</td>
          <td>Exertion</td>
          <td>Road accident</td>
          <td>Odour</td>
          <td>Other</td>
      </tr>
      <tr>
          <td>Open wound</td>
          <td>Other</td>
          <td>Other</td>
          <td>Oil spill in land/in sea produced water</td>
          <td></td>
      </tr>
      <tr>
          <td>Soft tissue</td>
          <td></td>
          <td></td>
          <td>Solid waste(Domestic)</td>
          <td></td>
      </tr>
      <tr>
          <td>Strain/Sprain poisoning</td>
          <td></td>
          <td></td>
          <td>Solid waste(inert)</td>
          <td></td>
      </tr>
      <tr>
          <td>Other</td>
          <td></td>
          <td></td>
          <td>Other</td>
          <td></td>
      </tr>
 </table>




   <!--  -->
 </body>

</html>
 

