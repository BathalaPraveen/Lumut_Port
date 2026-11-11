

<?php
   $logo = '<img src="' . BASE_URL . 'assets/images/slider/LOGO-LUMUT-PORTju.png " style="width:250px;height:75px;">';
   if($UserPrepared['CONT_NAME'] != ''){
     $userNamePre = $UserPrepared['CONT_NAME']; 
   }
   else{
     $userNamePre = $UserPrepared['EMP_NAME']; 
   }
   if($UserReviewed['CONT_NAME'] != ''){
     $userNameRev = $UserReviewed['CONT_NAME']; 
   }
   else{
     $userNameRev = $UserReviewed['EMP_NAME']; 
   }
   if($UserVerified['CONT_NAME'] != ''){
     $userNameVer = $UserVerified['CONT_NAME']; 
   }
   else{
     $userNameVer = $UserVerified['EMP_NAME']; 
   }
   if($UserApproved['CONT_NAME'] != ''){
     $userNameApr = $UserApproved['CONT_NAME']; 
   }
   else{
     $userNameApr = $UserApproved['EMP_NAME']; 
   }
   if($UserPrepared['DESIGNATION_NAME'] !=''){
     $userDesPre = $UserPrepared['DESIGNATION_NAME']; 
   }
   else{
    $userDesPre = $UserPrepared['CON_DESC']; 
   }
   if($UserReviewed['DESIGNATION_NAME'] !=''){
     $userDesRev = $UserReviewed['DESIGNATION_NAME']; 
   }
   else{
    $userDesRev = $UserReviewed['CON_DESC']; 
   }
   if($UserVerified['DESIGNATION_NAME'] !=''){
     $userDesVer = $UserVerified['DESIGNATION_NAME']; 
   }
   else{
    $userDesVer = $UserVerified['CON_DESC']; 
   }
   if($UserApproved['DESIGNATION_NAME'] !=''){
     $userDesApv = $UserApproved['DESIGNATION_NAME']; 
   }
   else{
    $userDesApv = $UserApproved['CON_DESC']; 
   }
   $desiUser = $_SESSION['emp_details']->design_name;
   $currentDate = date('d-m-Y h:i:s');
   $workRelated = $detail['IncidentInvestigationData']['INCIDENT_WORK_RELATED'];

   if($workRelated == 'Y'){
    $wrkRlt = 'Yes';
   }
   else{
    $wrkRlt = 'No';
   }
   $Presents  = $detail['superiorAllDetails'][$i]['PRESENT'];
   if($Presents == 'Y'){
     $pres = 'Yes';
   }
   else{
     $pres = 'No';
   }
   $involveds = $detail['IncidentInvestigationData']['INC_AUTHORITY_INVOLVED'];
   if($involveds == 'Y'){
     $invsAut = 'Yes';
   }
   else{
     $invsAut = 'No';
   }
   $injured = $detail['IncidentInvestigationData']['INJURED_PERSON'];
   if($injured == 'Y'){
     $injAut = 'Yes';
   }
   else{
    $injAut = 'No';
   }
   $Hazardss = $detail['IncidentInvestigationData']['HAZARD_RISK_IDENTIFY'];
   if($Hazardss == "Y"){
    $Hazards = "Yes";
   }
   else{
    $Hazards = "No";
   }
   $accAviod = $detail['IncidentInvestigationData']['ACCITENT_AVOIDABLE'];
   if($accAviod == 'Y'){
    $avoidable = 'Yes';
   }
   else{
    $avoidable = 'No';
   }
  // echo 'M<pre>';print_r($detail);exit;
//   echo 'M<pre>';print_r($detail);exit;
   $eventDate1 = postData($editData, 'eventDate', $this->input->post('eventDate'));
   $eventDate = date('d-m-Y',strtotime($eventDate1));

   $INCIDENT_ID = postData($editData, 'INCIDENT_ID', $this->input->post('INCIDENT_ID'));
   $eventTime = postData($editData, 'EVENT_TIME', $this->input->post('eventTime'));
   $locid = postData($editData, 'LOCATION_ID', $this->input->post('eventLocation'));
   $speclocid = postData($editData, 'SPECIFIC_LOCATION_ID', $this->input->post('specificLocation'));
   $speclocother = postData($editData, 'SPECIFIC_LOCATION_OTHER', $this->input->post('specificlocother'));
   
      if($speclocid == '-1'){
          $SpecificVal = 'Others' . '  -  '. $speclocother;
      }
      else{
         $SpecificVal =  $detail['SpecificLoc']['SPECIFIC_LOC_NAME'];
      }
      
$evntEmplname = postData($editData,'EVENT_REPORT_NAME');
$evntEmpldesign = postData($editData,'EVENT_REPORT_DESIGNATION');
$evntEmplphone = postData($editData,'PHONE_NO');   


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
            .innertableb{
                margin-left: 20.5% !important;
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
  
.box_design{
    border: 1px solid black;
}

        </style>
        </head>


   <body>
    <htmlpageheader name="myHeader1" style="display:none"> 
    <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td border="0"  style="width:10%;float:left;text-align:left;"><?php echo $logo; ?></td>

                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">HSSE INCIDENT/ACCIDENT INVESTIGATION REPORT</td>
                
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
            <td style="width:100%;background-color: #FFFF00;;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                1. Basic Facts  
            </td>

        </tr>
    </table>

    <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Event Date</b></td>
            <td>:</td>
            <td ><?php echo $eventDate; ?></td>
            <td class="tdlabel txt-uppercase"><b>Event Time</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $eventTime; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Event Location</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $detail['LocationDetail']['TERMINAL_SHORTNAME']; ?></td>
            <td class="tdlabel txt-uppercase"><b>Specific Location</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $SpecificVal; ?></td>

        </tr>
        <tr>
         <td class="tdlabel txt-uppercase"><b>Work related</b></td>
         <td>-</td>
             <td>
			<?php echo (isset($detail['IncidentInvestigationData']['INCIDENT_WORK_RELATED']) && $detail['IncidentInvestigationData']['INCIDENT_WORK_RELATED'] == 'Y') ? 'Yes' : 'No'; ?>
			</td>
              <td class="tdlabel txt-uppercase"><b>Activity</b></td>
           <td>-</td>
             <td><?php echo $IncidentActivity; ?></td>
         </tr>

          <tr>
        
         <td class="tdlabel txt-uppercase"><b>Employee/Contractor</b></td>
         <td>-</td>
             <td><?php echo $IncidentEmpCount; ?></td>
          </tr>

      </table>
      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                2.  Incident Classification   
            </td>

        </tr>
        
    </table>
   
   <table style="width:100%;" class="table summ full-width innertable">
          
             <?php $i = 1; //echo '<pre>';print_r($incidentClassification);exit;
              foreach($incidentClassification as $key => $ic){ 

                if($i == 1 || $i % 3 == 1){
                  echo '<tr>';
                }

                    $CHECKED = (postData($ic , 'CHECKED' , 0) == 1 ? 'Yes' : 'No');
                ?>
                <th><?php echo $ic['CLASSFICATION_NAME']; ?></th> 

                <td><?php echo $CHECKED; ?></td> 

          <?php  
          if($i % 3 == 0){
            echo '</tr>';
          } $i++; }  ?>
        </tr>
          
      </table>  
   

      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                3.  Supervisor/Superior Detail    
            </td>

        </tr>
        
    </table>
     <table style="width:100%;" class="table summ full-width innertable">
       <?php $n = (isset($detail['superiorAllDetails'])&&count($detail['superiorAllDetails']))?count($detail['superiorAllDetails']):1;
                   for($i=0;$i<$n;$i++){ ?> 
        <tr>
            <td class="tdlabel txt-uppercase"><b>Employee ID</b></td>
            <td>:</td>
            <td ><?php echo $detail['superiorAllDetails'][$i]['EMP_ID']; ?></td>
            <td class="tdlabel txt-uppercase"><b>Name</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $detail['superiorAllDetails'][$i]['NAME']; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Phone</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $detail['superiorAllDetails'][$i]['PHONE']; ?></td>
            <td class="tdlabel txt-uppercase"><b>Present</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $pres; ?></td>

        </tr>
       
         <?php } ?>
      </table>

      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                3(a) . Investigation Team     
            </td>

        </tr>
        
    </table>
	 <?php $n = (isset($detail['investigationAllDetails'])&&count($detail['investigationAllDetails']))?count($detail['investigationAllDetails']):1;
               for($i=0;$i<$n;$i++){ ?> 
    <table style="width:100%;" class="table summ full-width innertable">
      
        <tr>
            <td class="tdlabel txt-uppercase"><b>Employee name</b></td>
            <td>:</td>
            <td ><?php echo $detail['investigationAllDetails'][$i]['EMP_NAME']; ?></td>
            <td class="tdlabel txt-uppercase"><b>Employee ID</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $detail['investigationAllDetails'][$i]['EMP_ID']; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Designation</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $detail['investigationAllDetails'][$i]['DESIGNATION_NAME']; ?></td>
            <td class="tdlabel txt-uppercase"><b>Phone No</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $detail['investigationAllDetails'][$i]['PHONE_NO']; ?></td>

        </tr>
  
</table>
<?php } ?>
<table style="width:100%;" class="table summ full-width innertable">
         <tr>
            <td class="tdlabel txt-uppercase"><b>Investigation summary</b></td>
            <td class="title-colon">:</td>
            <td colspan="4"><?php if($detail['incidentTeamSummary']['FILE_NAME'] !=''){ ?>
                <img style="width: 200px; height: 150px;" id="docfileuploadincidentTeam" class= "docfileupload" src="<?php echo base_url().$detail['incidentTeamSummary']['FILE_PATH'].'/'.$detail['incidentTeamSummary']['FILE_NAME']?>">
                 <?php }else { ?>
                <?php echo $detail['incidentTeamSummary']['INVESTIGATION_TEAM_SUMMARY']; ?><?php } ?></td>
        </tr>
      </table>

      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                4.  Who Informed about the Incident     
            </td>

        </tr>
      </table>

      <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Employee ID</b></td>
            <td>:</td>
            <td ><?php echo $empIdGets['USERNAME']; ?></td>
            <td class="tdlabel txt-uppercase"><b>Name</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $evntEmplname; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Designation</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $evntEmpldesign; ?></td>
            <td class="tdlabel txt-uppercase"><b>Phone no</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $evntEmplphone; ?></td>

        </tr>
        
      </table>

      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                5.  Was an authority Involved      
            </td>

        </tr>
      </table>

       <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Was an authority Involved</b></td>
            <td>:</td>
            <td ><?php echo $invsAut; ?></td>
            <td class="tdlabel txt-uppercase"><b>Description</b></td>
            <td class="title-colon">:</td>
            <td>
 <?php echo (isset($detail['IncidentInvestigationData']['AUTHORITY_INVOLVED_DETAIL']) && !empty($detail['IncidentInvestigationData']['AUTHORITY_INVOLVED_DETAIL'])) ? $detail['IncidentInvestigationData']['AUTHORITY_INVOLVED_DETAIL'] : '-'; ?>
			</td>

        </tr>
       
      </table>

      

      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                6. Are there any person(s) injured ?
   
            </td>

        </tr>
      </table>

      <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>ARE THERE ANY PERSON(S) INJURED ?</b></td>
            <td>:</td>
            <td >
		<?php echo (isset($detail['IncidentInvestigationData']['INJURED_PERSON']) && $detail['IncidentInvestigationData']['INJURED_PERSON'] == 'Y') ? 'Yes' : 'No' ?>
		</td>

          
          </tr>
          
          <?php $n = (isset($detail['injuredAllDetails'])&&count($detail['injuredAllDetails']))?count($detail['injuredAllDetails']):1;
                                                for($i=0;$i<$n;$i++){   
						$injuPersnstatus = $detail['IncidentInvestigationData']['INJURED_PERSON'];
                                                             ?> 
<!--         </table>
          <table style="width:100%;" class="table summ full-width innertable">      -->
         <tr>
            <td class="tdlabel txt-uppercase"><b>Name</b></td>
            <td>:</td>
            <td >
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['PERSON_NAME']) && !empty($detail['injuredAllDetails'][$i]['PERSON_NAME']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['PERSON_NAME'] : '-';
              // echo $detail['injuredAllDetails'][$i]['PERSON_NAME']; 
              ?>
                
              </td>
            <td class="tdlabel txt-uppercase"><b>Sex</b></td>
            <td class="title-colon">:</td>
            <td >
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['SEX']) && !empty($detail['injuredAllDetails'][$i]['SEX']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['SEX'] : '-';
              // echo $detail['injuredAllDetails'][$i]['SEX'];
               ?>
                
              </td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Age</b></td>
            <td class="title-colon">:</td>
            <td >
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['AGE']) && !empty($detail['injuredAllDetails'][$i]['AGE']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['AGE'] : '-';
              // echo $detail['injuredAllDetails'][$i]['AGE']; 
              ?>
                
              </td>
            <td class="tdlabel txt-uppercase"><b>Job Title</b></td>
            <td class="title-colon">:</td>
            <td >
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['JOB_TITLE']) && !empty($detail['injuredAllDetails'][$i]['JOB_TITLE']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['JOB_TITLE'] : '-';
              // echo $detail['injuredAllDetails'][$i]['JOB_TITLE'];
               ?>
                
              </td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Citizenship</b></td>
            <td class="title-colon">:</td>
            <td >
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['CITIZENSHIP']) && !empty($detail['injuredAllDetails'][$i]['CITIZENSHIP']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['CITIZENSHIP'] : '-';
              // echo $detail['injuredAllDetails'][$i]['CITIZENSHIP']; 
              ?>
                
              </td>
            <td class="tdlabel txt-uppercase"><b>ID type</b></td><td class="title-colon">:</td>
            <td >
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['ID_TYPE']) && !empty($detail['injuredAllDetails'][$i]['ID_TYPE']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['ID_TYPE'] : '-';
              // echo $detail['injuredAllDetails'][$i]['ID_TYPE']; ?>
                
              </td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>IC Passport No</b></td>
            <td class="title-colon">:</td>
            <td >
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['IC_PASSPORT_NO']) && !empty($detail['injuredAllDetails'][$i]['IC_PASSPORT_NO']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['IC_PASSPORT_NO'] : '-';
              // echo $detail['injuredAllDetails'][$i]['CITIZENSHIP'];
               ?>
                
              </td>
            <td class="tdlabel txt-uppercase"><b>Contractor/Company Name</b></td><td class="title-colon">:</td>
            <td >
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['CONT_COMPANY_NAME']) && !empty($detail['injuredAllDetails'][$i]['CONT_COMPANY_NAME']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['CONT_COMPANY_NAME'] : '-';
              // echo $detail['injuredAllDetails'][$i]['CONT_COMPANY_NAME'];
               ?>
                
              </td>

        </tr>
        
        <tr>
            <td class="tdlabel txt-uppercase"><b>Injury Type</b></td>
            <td class="title-colon">:</td>
            <td >
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['INJURY_TYPE']) && !empty($detail['injuredAllDetails'][$i]['INJURY_TYPE']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['INJURY_TYPE'] : '-';
              // echo $detail['injuredAllDetails'][$i]['INJURY_TYPE'];
               ?>
                
              </td>
            <td class="tdlabel txt-uppercase"><b>Body part effected</b></td><td class="title-colon">:</td>
            <td > 
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['BODY_PART_ID']) && !empty($detail['injuredAllDetails'][$i]['BODY_PART_ID']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['BODY_PART_ID'] : '-';
              // echo $detail['injuredAllDetails'][$i]['BODY_PART_ID']; 
              ?>
                
              </td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Sub Body Part</b></td>
            <td class="title-colon">:</td>
            <td >
              <?php 
              echo (isset($detail['injuredAllDetails'][$i]['SUB_ID']) && !empty($detail['injuredAllDetails'][$i]['SUB_ID']) && $injuPersnstatus == 'Y') ? $detail['injuredAllDetails'][$i]['SUB_ID'] : '-';
              // echo $detail['injuredAllDetails'][$i]['SUB_ID']; 
              ?>
                
              </td>

        </tr>
      
               <?php } ?>
         
       
      </table>
      
       
     

      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                7.  Competency Records (i.e. HSSE Induction, other HSE Training, Toolbox Talks, 3rd Party Certification, Training Assessments)
   
            </td>

        </tr>
      </table>

      <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Competency Records</b></td>
            <td>:</td>
            <td ><?php echo $descriptionForCompentency; ?></td>
        </tr>
       
      </table>

      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                8. Asset Details (Provide the details of all assets involved)
   
            </td>

        </tr>
      </table>

      <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Asset Details (Provide the details of all assets involved)</b></td>
            <td>:</td>
            <td >
<?php echo (isset($detail['injuredAssetStatus']['ASSET_DETAIL_STATUS']) && $detail['injuredAssetStatus']['ASSET_DETAIL_STATUS'] == 'Y') ? 'Yes' : 'No'; ?>
		</td>

         
          </tr>
           <?php $n = (isset($detail['AssetAllDetails'])&&count($detail['AssetAllDetails']))?count($detail['AssetAllDetails']):1;
                                                for($i=0;$i<$n;$i++){   
                                                             ?> 
<!--         </table>
          <table style="width:100%;" class="table summ full-width innertable">      -->
        <tr>
            <td class="tdlabel txt-uppercase"><b>Description</b></td>
            <td>:</td>
            <td >
<?php echo (isset($detail['AssetAllDetails'][$i]['DESCRIPTION']) && !empty($detail['AssetAllDetails'][$i]['DESCRIPTION'])) ? $detail['AssetAllDetails'][$i]['DESCRIPTION'] : '-'; ?>
		</td>
            <td class="tdlabel txt-uppercase"><b>Name of Operator/ Driver /Vessel Master</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $detail['AssetAllDetails'][$i]['NAME_OF_OPERATOR_DRIVER_MASTER']; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Phone No</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $detail['AssetAllDetails'][$i]['PHONE_NO']; ?></td>
            <td class="tdlabel txt-uppercase"><b>Owner/Company Name</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $detail['AssetAllDetails'][$i]['OWNER_COMP_NAME']; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Plate No</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $detail['AssetAllDetails'][$i]['PLATE_NO']; ?></td>
            <td class="tdlabel txt-uppercase"><b>Estimated Cost of Damage</b></td><td class="title-colon">:</td>
            <td ><?php echo $detail['AssetAllDetails'][$i]['EST_COST_OF_DAMAGE']; ?></td>

        </tr>
       
      
               <?php } ?>
         
       
      </table>

        <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                9. Persons Interviewed 
   
            </td>

        </tr>
      </table>

<?php $n = (isset($detail['personInterviewd'])&&count($detail['personInterviewd']))?count($detail['personInterviewd']):1;
                                             for($i=0;$i<$n;$i++){   
                                                          ?> 
      <table style="width:100%;" class="table summ full-width innertable">
       
          
                
        <tr>
            <td class="tdlabel txt-uppercase" width="10%"><b>Employee ID</b></td>
            <td width="1%">:</td>
            <td width="30%"><?php echo $detail['personInterviewd'][$i]['EMP_ID']; ?></td>
            <td class="tdlabel txt-uppercase" width="10%"><b>Name</b></td>
            <td class="title-colon" width="1%">:</td>
            <td width="30%"><?php echo $detail['personInterviewd'][$i]['EMP_NAME']; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase" width="10%"><b>Job Title</b></td>
            <td class="title-colon" width="1%">:</td>
            <td width="30%"><?php echo $detail['personInterviewd'][$i]['JOB_TITLE']; ?></td>
            <td class="tdlabel txt-uppercase" width="10%"><b>Phone</b></td>
            <td class="title-colon" width="1%">:</td>
            <td width="30%"><?php echo $detail['personInterviewd'][$i]['PHONE']; ?></td>

        </tr>
          
        
      </table>
 <?php } ?>

      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                10. Circumstances (Provide short description of the incident and sequences of events)
   
            </td>

        </tr>
      </table>


    <table style="width:100%;" class="table summ full-width innertable">
         <?php

                                                       $j = 1;  
                                                       
                                                       $z = 0;

                                           $n = (isset($detail['circumstanceDetails'])&&count($detail['circumstanceDetails']))?count($detail['circumstanceDetails']):1;
                                             for($i=0;$i<$n;$i++){
                                                if($i == 0){ ?>


                                                <tr id="RowCircumstance<?php echo $i ?>">
                                                     <td style="width:10% !important;"></td>
                                                     
                                                     <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'] !=''){ ?>
                                         
                                                     <td class="box_design" style="width:10% !important;">
                                             
                                                <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC']:''?>
                                           
                                             </td>
                                       
                                          <?php } ?>
                                       
                                             <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'] !=''){ ?>    
                                             
                                          <td style="width:10%;">
                                             <p style="font-size:50px;">&#8658;</p>
                                             </td>
                                             
                                                     
                                     
                                                                                                                     
                                     
                                          <td class="box_design" style="width:10%;">
                                            <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO']:''?>
                                         
                                             </td>
                                     
                                          <?php } ?>
                                             
                                              <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'] !=''){ ?>
                                     
                                          <td style="width:10%;">
                                             <p style="font-size:50px;">&#8658;</p>
                                             </td>
                                                       
                                             
                                             
                                             
                                          <td class="box_design" style="width:10%;">
                                            <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE']:''?>
                                             </td>
                                             
                                             <?php } ?>
                                             
                                             <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'] !=''){ ?>
                                     
                                          <td style="width:10%;">
                                            <p style="font-size:50px;">&#8658;</p>
                                             </td>
                                             
                                             
                                             
                                             

                                       
                                          <td class="box_design" style="width:10%;">
                                            <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR']:''?>
                                           
                                             </td>
                                             
                                             <?php } ?>
                                             
                                             
                                              <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'] !=''){ ?>
                                     
                                          <td style="width:10%;">
                                            <p style="font-size:50px;">&#8658;</p>
                                             </td>
                                           
                                          <td class="box_design" style="width:10%;">
                                            <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE']:''?>
                                           
                                             </td>
                                             
                                             <?php } ?>
                                       <?php $z = $i+1;
                                       
                                        $newcirdesc = (isset($detail['circumstanceDetails'][$z]['CIRCUMSTANCE_DESC_FIVE']) && !empty($detail['circumstanceDetails'][$z]['CIRCUMSTANCE_DESC_FIVE'])) ? '0' : '1';
                                     //echo 'M<pre>';print_r($newcirdesc);exit;
 
                                   
                                     if($newcirdesc == '0') { ?>


                                   
                                          <td style="width:10%;">
                                           <p style="text-align:left;font-size:50px;">&#8659;</p>
                                             </td>
                                             
                                     <?php } ?>
                                       

                                       <input class="form-control COUNT_COLUMN"  type="hidden"  value="<?php echo $j ?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][COUNT_COLUMN]" id="COUNT_COLUMN<?php echo $i ?>" />


                                          <input class="form-control INC_CIRCUMSTANCE_INFO" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['circumstanceDetails'][$i])?$detail['circumstanceDetails'][$i]['INC_CIRCUMSTANCE_INFO']:"")?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][INC_CIRCUMSTANCE_INFO]" id="INC_CIRCUMSTANCE_INFO<?php echo $i ?>" />

                                               <?php $symbolsArrow = $detail['circumstanceDetails'][$i]['COUNT_COLUMN'];
                                              $z++; } else if ( $i % 2 == 0) {
                                             
                                             //for($j=1;$j<$n;$j++){                                                             ?>  
                                                          <tr id="RowCircumstance<?php echo $i ?>">
                                                             
                                                             
                                                            <?php
                                                            if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'] !=''){
                                                               
                                                            $z = $i+1;
//                                      echo '<pre>';print_r($i);
//                                      echo '<pre>';print_r($z);
                                     // echo '<pre>';print_r($detail['circumstanceDetails']);exit;
                                       
                                         
                                     $newcirdesc = (isset($detail['circumstanceDetails'][$z]['CIRCUMSTANCE_DESC_FIVE']) && !empty($detail['circumstanceDetails'][$z]['CIRCUMSTANCE_DESC_FIVE'])) ? '0' : '1';
                                       // echo '<pre>';print_r($newcirdesc);exit;
                                      if($newcirdesc == '0') { ?>
                                                             
                                                             
                                              <td>
                                            <p style="font-size:50px;">&#8658;</p>
                                             </td>      
                                             
                                             <?php } else { ?>
                                             
                                              <td>
                                            <p style="font-size:50px;">&#8658;</p>
                                             </td>
                                             <?php } ?>
                                             
                                             
                                           
                                          <td class="box_design">
                                                  <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'])? $detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC']:''?>
                                               
                                             </td>
                                        <?php } ?>

                                        <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'] !=''){ ?>
                                          <td>
                                            <p style="font-size:50px;">&#8658;</p>
                                             </td>
                                             
                                           
                                             
                                             
                                       
                                                                                                                         
                                     
                                          <td class="box_design">
                                           <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO']:''?>
                                             
                                           
                                             </td>
                                       
                                        <?php } ?>
                                             
                                      <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'] !=''){ ?>
                                             
                                          <td>
                                            <p style="font-size:50px;">&#8658;</p>
                                             </td>
                                             
                                           
                                     
                                           
                                       
                                          <td class="box_design">
                                            <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE']:''?>
                                             
                                             </td>
                                        <?php } ?>
                                             
                                              <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'] !=''){ ?>

                                       
                                          <td>
                                             <p style="font-size:50px;">&#8658;</p>
                                             </td>
                                             
                                         
                                     
                                       
                                       
                                          <td class="box_design">
                                             <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR']:''?>
                                             
                                           
                                             </td>
                                       
                                               <?php } ?>  
                                             
                                             
                                              <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'] !=''){ ?>
                                                         
                                       
                                          <td>
                                             <p style="font-size:50px;">&#8658;</p>
                                             </td>
                                     
                                       
                                             
                                             
                                           

                                       
                                          <td class="box_design">
                                            <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE']:''?>
                                             </td>
                                     
                                        <?php } ?>

                                     <?php  if($newcirdesc == '0') { ?>
                                     
                                          <td>
                                            <p style="text-align:left;font-size:50px;">&#8659;</p>
                                             </td>
                                             
                                              <?php } ?>
                                             
                                           
                                             
                                         
                                       


                                         <input class="form-control COUNT_COLUMN"  type="hidden"  value="<?php echo $j ?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][COUNT_COLUMN]" id="COUNT_COLUMN<?php echo $i ?>" />
                                             

                                          <input class="form-control INC_CIRCUMSTANCE_INFO" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['circumstanceDetails'][$i])?$detail['circumstanceDetails'][$i]['INC_CIRCUMSTANCE_INFO']:"")?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][INC_CIRCUMSTANCE_INFO]" id="INC_CIRCUMSTANCE_INFO<?php echo $i ?>" />

                                          </tr>


                                        <?php  $z++;  } else{
                                           
                                           
                                            if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_STATUS'] != 'N'){?>
                                         
                                         
                                          <tr id="RowCircumstance<?php echo $i ?>">
                                             
                                              <?php $z = $i+1;
                                              $newcirdesc = (isset($detail['circumstanceDetails'][$z]['CIRCUMSTANCE_DESC']) && !empty($detail['circumstanceDetails'][$z]['CIRCUMSTANCE_DESC'])) ? '0' : '1';
                                      if($newcirdesc == '0') { ?>
                                             
                                             
                                           
                                          <td>
                                            <p style="text-align:left;font-size:50px;">&#8659;</p>
                                             </td>
                                             
                                      <?php } else { ?>
                                          <td>
                                            <p style="text-align:left;font-size:50px;"></p>
                                             </td>
                                     <?php } ?>
                                       
                                          <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'] !=''){ ?>
                                         
                                          <td class="box_design">
                                                 <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC']:''?>

                                                                  </td>
                                       
                                          <td>
                                             <p style="font-size:50px;">&#8656;</p>
                                             </td>
                                             
                                          <?php } else { ?>
                                             <td >

                                             </td>
                                       
                                          <td>
                                             <p style="font-size:50px;"></p>
                                             </td>
                                      <?php } ?>
                                             
                                              <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'] !=''){ ?>
                                       
                                          <td class="box_design">
                                             <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO']:''?>

                                             
                                             </td>
                                     
                                          <td>
                                             <p style="font-size:50px;">&#8656;</p>
                                             </td>
                                             
                                              <?php } else { ?>
                                             <td >

                                             </td>
                                       
                                          <td>
                                             <p style="font-size:50px;"></p>
                                             </td>
                                      <?php } ?>
                                             
                                             <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'] !=''){ ?>
                                     
                                          <td class="box_design">
                                             <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE']:''?>
                                             </td>
                                       
                                          <td>
                                             <p style="font-size:50px;">&#8656;</p>
                                             </td>
                                             
                                              <?php } else { ?>
                                             <td >

                                             </td>
                                       
                                          <td>
                                             <p style="font-size:50px;"></p>
                                             </td>
                                      <?php } ?>
                                             
                                             <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'] !=''){ ?>
                                       
                                          <td class="box_design">
                                            <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR']:''?>

                                             </td>
                                       
                                          <td>
                                             <p style="font-size:50px;">&#8656;</p>
                                             </td>
                                             
                                             <?php } else { ?>
                                             <td >

                                             </td>
                                       
                                          <td>
                                             <p style="font-size:50px;"></p>
                                             </td>
                                      <?php } ?>
                                             
                                             
                                     <?php if($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'] !=''){ ?>
                                          <td class="box_design">
                                             <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE']:''?>

                                             </td>
                                       
                                          <td>
                                             <p style="font-size:50px;">&#8656;</p>
                                             </td>
                                             
                                             
                                      <?php } else { ?>
                                             <td >

                                             </td>
                                       
                                          <td>
                                             <p style="font-size:50px;"></p>
                                             </td>
                                      <?php } ?>
                                     

                                       


                                       <input class="form-control COUNT_COLUMN"  type="hidden"  value="<?php echo $j ?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][COUNT_COLUMN]" id="COUNT_COLUMN<?php echo $i ?>" />

                                             

                                          <input class="form-control INC_CIRCUMSTANCE_INFO" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['circumstanceDetails'][$i])?$detail['circumstanceDetails'][$i]['INC_CIRCUMSTANCE_INFO']:"")?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][INC_CIRCUMSTANCE_INFO]" id="INC_CIRCUMSTANCE_INFO<?php echo $i ?>" />

                                           </tr>

                                            <?php   }$z++; } }   $j++;
                                       // } ?>
                                 </tr>
                               </table>
    <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                11. Immediate Causes
   
            </td>

        </tr>
        </table>
        <table style="width:100%;padding-bottom: 10px;">
           <tr style="width:100%;" class="table summ full-width innertable">
            <td style="font-size:12px;  text-align: justify;border:1px solid grey;"><?php echo $ImmediateCauseDescrp; ?></td>
            
          </tr>
      </table>

    <table style="width:400%;padding-bottom: 10px;">
        <tr>
           
            <td style="background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                12. Possible Root Causes
            </td>
           
          </tr>
          
   </table>
   <table style="width:100%;padding-bottom: 10px;">
        <tr style="width:100%;" class="table summ full-width innertable">
            <td style="font-size:12px;  text-align: justify;border:1px solid grey;"><?php echo $RootCauseOfSummary; ?></td>
           
          </tr>
          
    </table>
    <table style="width:400%;padding-bottom: 10px;">
        <tr>
           
            <td style="background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                13. Contributing Causal Factors
            </td>
          </tr>
          
   </table>
   <table style="width:100%;padding-bottom: 10px;">
   
        <tr style="width:100%;" class="table summ full-width innertable">
            
            <td style="font-size:12px;  text-align: justify;border:1px solid grey;"><?php echo $ContributingSummary; ?></td>
          </tr>
          
    </table>

     <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                14. Root Cause Analysis
            </td>

        </tr>
    </table>

    <table style="width:100%" class="table summ full-width innertable">
        <tr>
         <?php  if($detail['rootUpload']['FILE_EXT'] == 'jpg' || $detail['rootUpload']['FILE_EXT'] == 'JPG' || $detail['rootUpload']['FILE_EXT'] == 'JPEG' || $detail['rootUpload']['FILE_EXT'] == 'jpeg' || $detail['rootUpload']['FILE_EXT'] == 'PNG' || $detail['rootUpload']['FILE_EXT'] == 'png'){ ?>
            <td style=""><?php if(isset($detail['rootUpload'])){?><img class="rootUps" src = "<?php echo base_url().$detail['rootUpload']['FILE_PATH'].'/'.$detail['rootUpload']['FILE_NAME']?>" style="width:100%;height:50%;"><?php } ?></td>
          <?php } else{ ?>
            <td ><?php if(($detail['rootUpload']['FILE_NAME']) !=''){ ?><a target="_blank" class="existing_file" href="<?php echo base_url().$detail['rootUpload']['FILE_PATH'].'/'.$detail['rootUpload']['FILE_NAME']?>"><i class="fa fa-eye"></i>&nbsp;View File</a>&nbsp;&nbsp;<?php } else { echo '-'; } ?></td>
          <?php } ?>

        </tr> 
        
      </table>

      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:60%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                15. Was the Hazard/Risk Identified?
            </td>
            <td style="width:50%;"> <?php echo $Hazards; ?></td>

        </tr>
    </table>

    <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                16. Action Plan (All action to be transferred to “Incident/Accident Tracking and Recording Register”
            </td>

        </tr>
    </table>

     <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            
           <?php $n = (isset($detail['activePlanAllDetails'])&&count($detail['activePlanAllDetails']))?count($detail['activePlanAllDetails']):1;
                                                for($i=0;$i<$n;$i++){   
                    $dateOfActionPlan = $detail['activePlanAllDetails'][$i]['DATE_BY_WHEN'];
                    $ActionPlanDt = date('d-m-Y',strtotime($dateOfActionPlan));
                    $actPln = substr($ActionPlanDt,6);
                    if($actPln == '1970'){
                        $actDevPln = '-';
                    }
                    else{
                       $actDevPln = $ActionPlanDt;
                    }
                                                             ?>  
                
        <tr>
            <th class="tdlabel txt-uppercase"><b>Corrective / Preventive </b></th>
            <th class="tdlabel txt-uppercase"><b>Responsibility (by whom?)</b></th>
            <th class="tdlabel txt-uppercase"><b>Date (by when?)</b></th>
        </tr>
        <tr>
            
           <td ><?php echo $detail['activePlanAllDetails'][$i]['CA_PA_DESC']; ?></td> 
           
            <td ><?php echo $detail['activePlanAllDetails'][$i]['EMP_NAME']; ?></td>
            
            <td ><?php echo $actDevPln; ?></td> 

        </tr>
        
       <?php } ?>
         </tr>
       
      </table>

       <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                17. Attachments (Witness statement, training record, photo/sketch, division report etc)
            </td>

        </tr>
      </table>
       <table style="width:100%;" class="table summ full-width innertable">
        <tr>
          <?php //echo '<pre>';print_r($detail['attachAllDetail']);exit;
          $j = 1; $n = (isset($detail['attachAllDetail'])&&count($detail['attachAllDetail']))?count($detail['attachAllDetail']):1;
                                             for($i=0;$i<$n;$i++){   
                                                          ?>  
                  
                </tr>
                <tr>
                  <td><u>Photo <?php echo $j; ?></u></td>
                  <?php  if($detail['attachAllDetail'][$i]['FILE_EXT'] == 'jpg' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'JPG' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'JPEG' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'jpeg' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'png' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'PNG'){ ?>
            <td><?php if(isset($detail['attachAllDetail'][$i])){?><img class="rootUps" src = "<?php echo base_url().$detail['attachAllDetail'][$i]['FILE_PATH'].'/'.$detail['attachAllDetail'][$i]['FILE_NAME']?>" style="height:50%;width:70%;"><?php } ?>


</td>
<td>
<div style="margin-top:10%;">

<?php echo $detail['attachAllDetail'][$i]['DESCRIPTION']; ?>
</div></td>
          <?php } else{ ?>
             <td><?php if(($detail['attachAllDetail'][$i]['FILE_NAME'])!=''){ ?><a target="_blank" class="existing_file" href="<?php echo base_url().$detail['attachAllDetail'][$i]['FILE_PATH'].'/'.$detail['attachAllDetail'][$i]['FILE_NAME']?>"><i class="fa fa-eye"></i>&nbsp;View File</a><?php }else { echo '-'; } ?></td>
                  
          <?php } ?>
                 
                </tr>    
         <?php $j++; }?><p>&#8203;</p>
      </table>

      <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:60%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                18. This accident is avoidable? 
            </td>
            <td style="width:50%;"> <?php echo $avoidable; ?></td>

        </tr>
    </table>

     <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:60%;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                19. Proposed Action/Recommendation
            </td>
           

        </tr>
        </table>
        <table style="width:100%;padding-bottom: 10px;">
        <tr >
           <td style="width:50%;border:1px solid grey;padding-top:10px;padding-left:10px;"> <?php echo $RecomendationSummary; ?></td>
        </tr>
    </table>


    <table style="padding-bottom: 10px;width:500%;  padding-top: 60px;font-weight:bold;">
  <tr>
    <th style="text-align:center;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">Prepared by</th>
    <th style="text-align:center;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">Reviewed by</th>
    <th style="text-align:center;background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">Verified by</th>
  </tr>
</table>
 <table class="table summ full-width innertable">
  <tr>
    <th style="font-size:10px;" >Job Position</th>
    <?php if($userDesPre != ''){ ?>
    <td style="width: 25%;font-size:10px;"><?php echo strtoupper($userDesPre); ?></td>
   <?php  } else{ ?>
    <td style="font-size:10px;"><?php echo '-'; ?></td>
   <?php } ?>
    <th style="font-size:10px;">Job Position</th>
    <?php if($userDesRev != ''){ ?> 
    <td style="width: 25.5%;font-size:10px;"><?php echo strtoupper($userDesRev); ?></td>
      <?php  } else{ ?> 
      <td style="font-size:10px;"><?php echo strtoupper('Review Incomplete!'); ?></td>
      <?php } ?> 
    <th style="font-size:10px;">Job Position</th>
    <?php if($userDesVer != ''){ ?>
    <td style="font-size:10px;"><?php echo strtoupper($userDesVer); ?></td>
     <?php  } else{ ?> 
      <td style="font-size:10px;"><?php echo strtoupper('Verified Incomplete!'); ?></td>
      <?php } ?> 
  </tr>
  <tr>
    <th style="font-size:10px;"> Name</th>
    <td style="font-size:10px;" ><?php echo strtoupper($userNamePre); ?></td>
    <th style="font-size:10px;">Name</th>
    <td style="font-size:10px;font-size:10px;"><?php echo strtoupper($userNameRev); ?></td>
    <th style="font-size:10px;">Name</th>
    <td style="font-size:10px;font-size:10px;"><?php echo strtoupper($userNameVer);?></td>
  </tr>
  <tr>
<th style="font-size:10px;">Prepared Date & Time</th>
<?php if($userDesPre != ''){ ?>
<td style="font-size:10px;" ><?php echo $detail['IncidentInvestigationData']['PREPARED_DATE']; ?></td>
<?php }else{ ?>
<td style="font-size:10px;"><?php echo '-'; ?></td>
<?php } ?>
<th style="font-size:10px;"> Reviewed Date & Time</th>
<?php if($userDesRev != ''){ ?>
<td style="font-size:10px;font-size:10px;"><?php echo $detail['IncidentInvestigationData']['REVIEWED_DATE']; ?></td>
<?php } else{ ?>
<td style="font-size:10px;"><?php echo '-'; ?></td>
<?php } ?>
<th style="font-size:10px;"> Verified Date & Time</th>
<?php if($userDesVer != ''){ ?>
<td style="font-size:10px;font-size:10px;"><?php echo $detail['IncidentInvestigationData']['VERIFIED_DATE'];?></td>
<?php } else{ ?>
<td style="font-size:10px;"><?php echo '-'; ?></td>
<?php } ?>
</tr>
<tr>
<th style="font-size:10px;"></th>
<td style="font-size:10px;"></td>
<th style="font-size:10px;"> Reviewed Remark</th>
<?php if($detail['IncidentInvestigationData']['REVIEWED_REMARK'] != ''){ ?>
<td style="font-size:10px;font-size:10px;"><?php echo $detail['IncidentInvestigationData']['REVIEWED_REMARK']; ?></td>
<?php } else{ ?>
<td style="font-size:10px;"><?php echo '-'; ?></td>
<?php } ?>
<th style="font-size:10px;"> Verified Remark</th>
<?php if($detail['IncidentInvestigationData']['VERIFIED_REMARK'] != ''){ ?>
<td style="font-size:10px;font-size:10px;"><?php echo $detail['IncidentInvestigationData']['VERIFIED_REMARK'];?></td>
<?php } else{ ?>
<td style="font-size:10px;"><?php echo '-'; ?></td>
<?php } ?>
</tr>
</table>


<table style="width:100%;padding-bottom: 10px; padding-left: 20%;padding-right: 20%;">
  <tr>
    <th style="background-color: #FFFF00;color:black;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">Approved by</th>
  </tr>
  </table>
  <table style="width:75%;" class="table summ full-width innertableb">
  <tr>
    <th style="font-size:10px;">JobPosition</th>
     <?php if($userDesApv != ''){ ?>
    <td style="font-size:10px;"><?php echo strtoupper($userDesApv); ?></td>
    <?php  } else{ ?> 
      <td style="font-size:10px;"><?php echo strtoupper('Approved Incomplete!'); ?></td>
      <?php } ?> 
  </tr>
   <tr>
    <th style="font-size:10px;">Name</th>
    <td style="font-size:10px;"><?php echo strtoupper($userNameApr); ?></td>
  </tr>
  <tr>
<th style="font-size:10px;">Approved Date & Time</th>
<?php if($userDesApv != ''){ ?>
<td style="font-size:10px;"><?php echo $detail['IncidentInvestigationData']['APPROVED_DATE'];?></td>
<?php } else{ ?>
<td style="font-size:10px;"><?php echo '-'; ?></td>
<?php } ?>
</tr>
<tr>
<th style="font-size:10px;">Approved Remark</th>
<?php if($detail['IncidentInvestigationData']['APPROVED_REMARK'] != ''){ ?>
<td style="font-size:10px;"><?php echo $detail['IncidentInvestigationData']['APPROVED_REMARK'];?></td>
<?php } else{ ?>
<td style="font-size:10px;"><?php echo '-'; ?></td>
<?php } ?>
</tr>
</table>
 </body>

</html>
 
