

<style>
   .newhr {
   margin-top: 15px;
   margin-bottom: 15px;
   border-color: white;
   }
   .rootUps {
             width: 30%;
              }
   .card-header{
   color: #fff;
   background-color: #007bff;
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
   .partsImg {
    width: 80px;
    height: 100px;
}
#review_save {
    margin-bottom: 10px;
}
.col-md-5 {
    margin-left: 10px;
}
.tthead{
        width:28%;
    }
   
</style>
<?php
   
  
//   $userName = $_SESSION['emp_details']->EMP_NAME;
   if($UserReviewed['CONT_NAME'] != ''){
     $userNameRev = $UserReviewed['CONT_NAME']; 
   }
   else{
     $userNameRev = $UserReviewed['EMP_NAME']; 
   }
  //echo 'M<pre>';print_r($userNameRev);exit;
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
   $currentDate = date('d-m-Y h:i:s');
  // echo 'M<pre>';print_r($userName);exit;
   $eventDate = postData($editData, 'eventDate', $this->input->post('eventDate'));
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
   
   // echo 'Mahi<pre>';print_r($ImmediateCauseDescrp);exit;
   // echo 'M<pre>';print_r($editData->persons[0]->PHONE_NO);exit;
   
   ?>

<div class="wrapper">
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
         <div class="" style="margin-top:10px;">
      <?php echo $this->session->flashdata('incflash'); ?>
            </div>
         <div id="accordion" class="incidentAccordion">
            <div class="row">
               <div class="col-md-12">
                  <div class="" style="margin-top:10px;">
                     <?php
                        echo $this->session->flashdata('flashmsg');
                        ?>
                  </div>
                  <div class="card card-headprimary">
                     <div class="row headingStyl">
                        <div class="col-md-12">
                           <h4><?php echo $title; ?></h4>
                           <a href="<?php echo $backUrl ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                        </div>
                     </div>
                     <div class="card-body">
                        <?php
                           $action = (isset($id) && $id != "") ? 'incident/investSave/' . $id : 'incident/investSave';
                           $attr = [
                               'class' => 'form-horizontal',
                               'id' => 'investform',
                               'autocomplete' => 'off'
                           ];
                           echo form_open_multipart($action, $attr);
                           ?>

                        <div class="card ">
                           <div class="card-header ">
                              <a class="card-link " href="javascript:void(0)" >
                              1. Basic Facts<span class="float-right"></span>
                              </a>
                           </div>
                           <div id="section_1" class="collapse multi-collapse show" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row">
                                   
                                       <table class="table table-striped">
                                          <tr>
                                       <th class="tthead">Event Date </th>
                                       <td>-</td>
                                          <td><?php echo $eventDate; ?></td>
                                       <th class="tthead">Event Time </th>
                                       <td>-</td>
                                          <td><?php echo $eventTime; ?></td>
                                       </tr>

                                       <tr>
                                       <th class="tthead">Event Location </th>
                                       <td>-</td>
                                        <td><?php echo $detail['LocationDetail']['TERMINAL_SHORTNAME']; ?></td>
                                       <th class="tthead">Specific Location </th>
                                       <td>-</td>
                                          <td><?php echo $SpecificVal;  ?></td>
                                       </tr>

                                       <tr>
                                       <th class="tthead">Work related</th>
                                       <td>-</td>
                                           <td><?php echo $detail['IncidentInvestigationData']['INCIDENT_WORK_RELATED']; ?></td>
                                            <th class="tthead">Activity</th>
                                         <td>-</td>
                                           <td><?php echo $IncidentActivity; ?></td>
                                       </tr>

                                        <tr>
                                      
                                       <th class="tthead">Employee/Contractor</th>
                                       <td>-</td>
                                           <td><?php echo $IncidentEmpCount; ?></td>
                                        </tr>
                                      </table>
                                   </div>
                                </div>
                             </div>
                          </div>



                        <!-- Mahima -->

                        <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           2. Incident Classification<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_2" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                  <table class="table table-striped">
                                          <tr>
                                       <th class="tthead">Incident Classification </th>
                                       <td>-</td>
                                          <td><?php $i = 1;
                                          if($classFyName !=''){
                                          foreach($classFyName as $c) {?>
                                            <?php if($i == count($classFyName)) { echo $c['CLASSFICATION_NAME'] . '  '; } else{ echo $c['CLASSFICATION_NAME'] . ' , '; } ?>
                                          <?php $i++; } } else
                                          {  echo 'No data available!'; } ?></td>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>


                         <div class="card ">
                           <div class="card-header ">
                              <a class="card-link " href="javascript:void(0)" >
                                 3. Supervisor/Superior details
                                 <span class="float-right">
                                   <!--  <div class="btn btn-warning btn-sm " id="addSuperDet">Add</div> -->
                                 </span>
                              </a>
                           </div>
                           <div id="section_3" class="collapse multi-collapse show" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row superiorInfo">
                                    <table class="table table-striped">
                                        <?php $n = (isset($detail['superiorAllDetails'])&&count($detail['superiorAllDetails']))?count($detail['superiorAllDetails']):1;
                                                for($i=0;$i<$n;$i++){ ?> 
                                          <tr>
                                       <th class="tthead">Employee ID </th>
                                       <td>-</td>
                                          <td><?php echo $detail['superiorAllDetails'][$i]['EMP_ID']; ?></td>
                                           <th class="tthead">Name </th>
                                       <td>-</td>
                                          <td><?php echo $detail['superiorAllDetails'][$i]['NAME']; ?></td>
                                       </tr>

                                       <tr>
                                       <th class="tthead">Phone</th>
                                       <td>-</td>
                                          <td><?php echo $detail['superiorAllDetails'][$i]['PHONE']; ?></td>
                                           <th class="tthead">Present </th>
                                       <td>-</td>
                                          <td><?php echo $detail['superiorAllDetails'][$i]['PRESENT']; ?></td>
                                       </tr>

                                    <?php } ?>

                                    </table>
                                  </div>
                              </div>
                           </div>
                        </div>





                     <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                              3a. Investigation Team
                              <span class="float-right">
                                <!--  <div class="btn btn-warning btn-sm addInvestigationDet">Add</div> -->
                              </span>
                           </a>
                        </div>
                        <div id="section_3" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row InvestigationInfo">
                                 
                                   
                                       <table class="table table-striped">
                                          <?php  

                                           $n = (isset($detail['investigationAllDetails'])&&count($detail['investigationAllDetails']))?count($detail['investigationAllDetails']):1;
                                             for($i=0;$i<$n;$i++){ ?>
                                                <tr>
                                       <th class="tthead">Employee name</th>
                                       <td>-</td>
                                          <td><?php echo $detail['investigationAllDetails'][$i]['EMP_NAME']; ?></td>
                                           <th class="tthead">Employee ID </th>
                                       <td>-</td>
                                          <td><?php echo $detail['investigationAllDetails'][$i]['EMP_ID']; ?></td>
                                       </tr>

                                        <tr>
                                       <th class="tthead">Designation</th>
                                       <td>-</td>
                                          <td><?php echo $detail['investigationAllDetails'][$i]['DESIGNATION_NAME']; ?></td>
                                           <th class="tthead">Phone No</th>
                                       <td>-</td>
                                          <td><?php echo $detail['investigationAllDetails'][$i]['PHONE_NO']; ?></td>
                                       </tr>
                                       

                                        <?php }  ?>
                                         <tr>
                                       <th class="tthead">Investigation summary</th>
                                       <td>-</td>
                                          <td>
                                              <?php if($detail['incidentTeamSummary']['FILE_NAME'] !=''){ ?>
                                              <img style="width: 200px; height: 150px;" id="docfileuploadincidentTeam" class= "docfileupload" src="<?php echo base_url().$detail['incidentTeamSummary']['FILE_PATH'].'/'.$detail['incidentTeamSummary']['FILE_NAME']?>">
                                              <?php }else { ?>
                                              <?php echo $detail['incidentTeamSummary']['INVESTIGATION_TEAM_SUMMARY']; ?>
                                                <?php } ?></td>
                                             
                                          <th class="tthead"></th>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                    </table>
                                       </div>
                                        
                                       </div>
                                    </div>
                                 </div>
                              


                     <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           4. Who informed about the incident<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_4" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                <table class="table table-striped">
                                  <tr>
                                       <th class="tthead">Employee ID</th>
                                       <td>-</td>
                                          <td><?php echo $empIdGets['USERNAME']; ?></td>
                                           <th class="tthead">Name</th>
                                       <td>-</td>
                                          <td><?php echo $evntEmplname; ?></td>
                                       </tr>

                                       <tr>
                                       <th class="tthead">Designation</th>
                                       <td>-</td>
                                          <td><?php echo $evntEmpldesign; ?></td>
                                           <th class="tthead">Phone no</th>
                                       <td>-</td>
                                          <td><?php echo $evntEmplphone; ?></td>
                                       </tr>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     


                     <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           5. Was an authority Involved<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_5" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                 <table class="table table-striped">
                                     <tr>
                                       <th class="tthead">Was an authority Involved</th>
                                       <td>-</td>
                                          <td><?php echo $detail['IncidentInvestigationData']['INC_AUTHORITY_INVOLVED']; ?></td>
                                           <th class="tthead d-none">Description</th>
                                          <td class="upting d-none">-</td>
                                          <td class="involved d-none"><?php echo $detail['IncidentInvestigationData']['AUTHORITY_INVOLVED_DETAIL']; ?></td>
                                       </div>
                                       </tr>
                                    </table>
                              </div>
                           </div>
                        </div>
                     </div>



                     <div class="card ">
                           <div class="card-header ">
                              <a class="card-link " href="javascript:void(0)" >
                                 6. Injured Person (IP) Details (provide the details of all IPs involved)
                                 <span class="float-right">
                                   <!--  <div class="btn btn-warning btn-sm addInjuredDet">Add</div> -->
                                 </span>
                              </a>
                           </div>
                           <div id="section_6" class="collapse multi-collapse show" data-parent="#accordion">
                              <div class="card-body">
                                 <table class="table table-striped">
                                    <tr>
                                       <th class="tthead">Are there any person(s) injured?</th>
                                       <td>-</td>
                                          <td><?php echo $detail['IncidentInvestigationData']['INJURED_PERSON']; ?></td>
                                          <th class="tthead"></th>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                  

                                   <?php $n = (isset($detail['injuredAllDetails'])&&count($detail['injuredAllDetails']))?count($detail['injuredAllDetails']):1;
                                                for($i=0;$i<$n;$i++){   
                                                             ?> 
                                   <div class="col-md-13 InjuredPersonHide d-none">
                                        <tr>
                                       <th class="tthead">Name</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAllDetails'][$i]['PERSON_NAME']; ?></td>

                                          <th class="tthead">Sex</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAllDetails'][$i]['SEX']; ?></td>
                                       </tr>

                                        <tr>
                                       <th class="tthead">Age</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAllDetails'][$i]['AGE']; ?></td>

                                          <th class="tthead">Job Title</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAllDetails'][$i]['JOB_TITLE']; ?></td>
                                       </tr>

                                       <tr>
                                       <th class="tthead">Citizenship</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAllDetails'][$i]['CITIZENSHIP']; ?></td>

                                          <th class="tthead">ID type</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAllDetails'][$i]['ID_TYPE']; ?></td>
                                       </tr>

                                        <tr>
                                       <th class="tthead">IC Passport No</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAllDetails'][$i]['IC_PASSPORT_NO']; ?></td>

                                          <th class="tthead">Contractor/Company Name</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAllDetails'][$i]['CONT_COMPANY_NAME']; ?></td>
                                       </tr>

                                       <tr>
                                           
                                       <th class="tthead">Injury Type</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAllDetails'][$i]['INJURY_TYPE']; ?></td>

                                          <th class="tthead">Body part effected</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAllDetails'][$i]['BODY_PART_ID']; ?></td>
                                       </tr>
                                       <tr>
                                            <td class="tdlabel txt-uppercase"><b>Sub Body Part</b></td>
                                            <td> - </td>
                                            <td ><?php echo $detail['injuredAllDetails'][$i]['SUB_ID']; ?></td>

                                        </tr>
                                       
                                    </div>

                                       
                                          <?php } ?>
                                
                                
                                 </table>
                              </div>
                          </div>
                           </div>
                 

                      <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           7. Competency Records<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_7" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row"> 
                                 <table class="table table-striped">
                                     <tr>
                                       <th class="tthead">Competency Record</th>
                                       <td>-</td>
                                          <td><?php echo $descriptionForCompentency; ?></td>
                                       </tr>
                                   </table>
                                  
                                 </div>
                                
                              </div>
                           </div>
                        </div>
                  



                     <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           8. Asset Details (Provide the details of all assets involved)<span class="float-right">
                                 <!--    <div class="btn btn-warning btn-sm addAssetDet">Add</div> -->
                                 </span>
                           </a>
                        </div>
                        <div id="section_8" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                 <table class="table table-striped">
                                     <tr>
                                       <th class="tthead">Asset Details (Provide the details of all assets involved)</th>
                                       <td>-</td>
                                          <td><?php echo $detail['injuredAssetStatus']['ASSET_DETAIL_STATUS']; ?></td>
                                           <th class="tthead"></th>
                                          <td></td>
                                          <td></td>
                                       </tr>

                                   <?php $n = (isset($detail['AssetAllDetails'])&&count($detail['AssetAllDetails']))?count($detail['AssetAllDetails']):1;
                                                for($i=0;$i<$n;$i++){   
                                                             ?> 
                                          <tr>
                                       <th class="tthead">Description</th>
                                       <td>-</td>
                                          <td><?php echo $detail['AssetAllDetails'][$i]['DESCRIPTION']; ?></td>
                                          <th class="tthead">Name of Operator/ Driver /Vessel Master</th>
                                       <td>-</td>
                                          <td><?php echo $detail['AssetAllDetails'][$i]['NAME_OF_OPERATOR_DRIVER_MASTER']; ?></td>
                                       </tr>

                                       <tr>
                                       <th class="tthead">Phone No</th>
                                       <td>-</td>
                                          <td><?php echo $detail['AssetAllDetails'][$i]['PHONE_NO']; ?></td>
                                          <th class="tthead">Owner/Company Name</th>
                                       <td>-</td>
                                          <td><?php echo $detail['AssetAllDetails'][$i]['OWNER_COMP_NAME']; ?></td>
                                       </tr>

                                        <tr>
                                       <th class="tthead">Plate No</th>
                                       <td>-</td>
                                          <td><?php echo $detail['AssetAllDetails'][$i]['PLATE_NO']; ?></td>
                                          <th class="tthead">Estimated Cost of Damage</th>
                                       <td>-</td>
                                          <td><?php echo $detail['AssetAllDetails'][$i]['EST_COST_OF_DAMAGE']; ?></td>
                                       </tr>

                                          <?php }  ?>
                                         
                                          </table>
                                      </div>
                                  </div>
                              </div>
                          </div>
                     


                   <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                              9. Persons Interviewed
                              <span class="float-right">
                                <!--  <div class="btn btn-warning btn-sm addPersonInter">Add</div> -->
                              </span>
                           </a>
                        </div>
                        <div id="section_9" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row personInfo">
                                 <table class="table table-striped">
                                    
                                          <?php $n = (isset($detail['personInterviewd'])&&count($detail['personInterviewd']))?count($detail['personInterviewd']):1;
                                             for($i=0;$i<$n;$i++){   
                                                          ?>  
                                                         <tr>
                                       <th class="tthead">Employee ID</th>
                                       <td>-</td>
                                          <td><?php echo $detail['personInterviewd'][$i]['EMP_ID']; ?></td>
                                          <th class="tthead">Name</th>
                                       <td>-</td>
                                          <td><?php echo $detail['personInterviewd'][$i]['EMP_NAME']; ?></td>
                                       </tr>

                                        <tr>
                                       <th class="tthead">Job Title</th>
                                       <td>-</td>
                                          <td><?php echo $detail['personInterviewd'][$i]['JOB_TITLE']; ?></td>
                                          <th class="tthead">Phone</th>
                                       <td>-</td>
                                          <td><?php echo $detail['personInterviewd'][$i]['PHONE']; ?></td>
                                       </tr>

                                      
                                          <?php }  ?>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>



                     <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                              10. Circumstances
                              <span class="float-right">
                                <!--  <div class="btn btn-warning btn-sm addCircumstance">Add</div> -->
                              </span>
                           </a>
                        </div>
                        <div id="section_9" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row circumstanceInfo">
                                 <table class="table table-striped">
                                          <?php
                                            $j = 1;                                                             

                                           $n = (isset($detail['circumstanceDetails'])&&count($detail['circumstanceDetails']))?count($detail['circumstanceDetails']):1;
                                             for($i=0;$i<$n;$i++){ 
                                                if($i == 0){ ?>

                                                   <tr>
                                               <td></td>
                                            <td><textarea readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrOne]" id="circumDescrOne<?php echo $i ?>">
                                                  <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC']:''?>
                                               </textarea></td>
                                          <td><i class="fas fa-arrow-right" style="font-size: 2em; "></i></td>
                                      

                                          <td><textarea  readonly class="form-control" name="circumstanceDatas[<?php echo $i ?>][circumDescrTwo]" id="circumDescrTwo<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO']:''?></textarea></td>
                                          <td><i class="fas fa-arrow-right" style="font-size: 2em;"></i></td>
                                       
                                          <td><textarea  readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrThree]" id="circumDescrThree<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE']:''?></textarea></td>
                                          <td><i class="fas fa-arrow-right" style="font-size: 2em;"></i></td>
                                       

                                          <td><textarea  readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrFour]" id="circumDescrFour<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR']:''?></textarea></td>
                                          <td><i class="fas fa-arrow-right" style="font-size: 2em;"></i></td>
                                          
                                          <td> <textarea  readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrFive]" id="circumDescrFive<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE']:''?></textarea></td>
                                          <td><i class="fas fa-arrow-down" style="font-size: 2em;"></i></td>
                                          
                                       </tr>



                                               <?php $symbolsArrow = $detail['circumstanceDetails'][$i]['COUNT_COLUMN'];
                                               } else if ( $i % 2 == 0) {
                                              
                                             //for($j=1;$j<$n;$j++){                                                             ?>  
                                        <tr>
                                          <td><i class="fas fa-arrow-right" style="font-size: 2em;"></i></td>
                                          <td><textarea  readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrOne]" id="circumDescrOne<?php echo $i ?>">
                                                  <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC']:''?>
                                               </textarea></td>
                                          <td><i class="fas fa-arrow-right" style="font-size: 2em;"></i></td>
                                       
                                          <td><textarea  readonly class="form-control" name="circumstanceDatas[<?php echo $i ?>][circumDescrTwo]" id="circumDescrTwo<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO']:''?></textarea></td>
                                          <td><i class="fas fa-arrow-right" style="font-size: 2em;"></i></td>
                                      
                                          <td><textarea readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrThree]" id="circumDescrThree<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE']:''?></textarea></td>
                                          <td><i class="fas fa-arrow-right" style="font-size: 2em;"></i></td>
                                      
                                          <td><textarea  readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrFour]" id="circumDescrFour<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR']:''?></textarea>></td>
                                          <td><i class="fas fa-arrow-right" style="font-size: 2em;"></i></td>
                                          
                                          <td> <textarea readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrFive]" id="circumDescrFive<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE']:''?></textarea></td>
                                          <td><i class="fas fa-arrow-down" style="font-size: 2em;"></i></td>
                                       </tr>







                                        <?php } else{ ?>

                                           <tr>
                                          <td><i class="fas fa-arrow-down" style="font-size: 2em;"></i></td>
                                          <td><textarea  readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrOne]" id="circumDescrOne<?php echo $i ?>">
                                                  <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC']:''?>
                                               </textarea></td>
                                          <td><i class="fas fa-arrow-left" style="font-size: 2em;"></i></td>
                                       
                                          <td><textarea readonly class="form-control" name="circumstanceDatas[<?php echo $i ?>][circumDescrTwo]" id="circumDescrTwo<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO']:''?></textarea></td>
                                           <td><i class="fas fa-arrow-left" style="font-size: 2em;"></i></td>
                                      
                                          <td><textarea readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrThree]" id="circumDescrThree<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE']:''?></textarea></td>
                                          <td><i class="fas fa-arrow-left" style="font-size: 2em;"></i></td>
                                      
                                          <td><textarea readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrFour]" id="circumDescrFour<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR']:''?></textarea></td>
                                          <td><i class="fas fa-arrow-left" style="font-size: 2em;"></i></td>
                                          
                                          <td> <textarea readonly class="form-control"  name="circumstanceDatas[<?php echo $i ?>][circumDescrFive]" id="circumDescrFive<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE']:''?></textarea></td>
                                          <td><i class="fas fa-arrow-left" style="font-size: 2em;"></i></td>
                                       </tr>




                                       <?php   } }   $j++;
                                        ?>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>


                      <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           11. Immediate Causes<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_11" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                  <table class="table table-striped">                                          
                                      <tr>
                                       
                                          <td><?php echo $ImmediateCauseDescrp; ?></td>
                                          
                                       </tr>
                                   </table>
                                 </div>
                                 
                              </div>
                           </div>
                        </div>
                   

                     <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           12. Possible Root Causes<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_12" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                   <table class="table table-striped">                                          
                                      <tr>
                                       
                                          <td><?php echo $RootCauseOfSummary; ?></td>
                                          
                                       </tr>
                                   </table>
                              </div>
                           </div>
                        </div>
                     </div> 



                       <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           13. Contributing Causal Factors<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_13" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                 <table class="table table-striped">                                          
                                      <tr>
                                       
                                          <td><?php echo $ContributingSummary; ?></td>
                                          
                                       </tr>
                                   </table>
                              </div>
                           </div>
                        </div>
                     </div> 


                     <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           14. Root cause analysis<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_14" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                 <table class="table table-striped"> 
                                   <tr>
                                    <th class="tthead">Root cause analysis</th>
                                       <td>-</td>
                                           <?php  if($detail['rootUpload']['FILE_EXT'] == 'jpg' || $detail['rootUpload']['FILE_EXT'] == 'JPG' || $detail['rootUpload']['FILE_EXT'] == 'JPEG' || $detail['rootUpload']['FILE_EXT'] == 'jpeg' || $detail['rootUpload']['FILE_EXT'] == 'PNG' || $detail['rootUpload']['FILE_EXT'] == 'png'){ ?>
                                            <td><?php if(isset($detail['rootUpload'])){?><img class="rootUps" src = "<?php echo base_url().$detail['rootUpload']['FILE_PATH'].'/'.$detail['rootUpload']['FILE_NAME']?>"><?php } ?></td>
                                          <?php } else{ ?>
                                            <td><?php if(($detail['rootUpload']['FILE_NAME']) !=''){ ?><a target="_blank" class="existing_file" href="<?php echo base_url().$detail['rootUpload']['FILE_PATH'].'/'.$detail['rootUpload']['FILE_NAME']?>"><i class="fa fa-eye"></i>&nbsp;View File</a>&nbsp;&nbsp;<?php } else { echo '-'; } ?></td>
                                          <?php } ?>
                                          <th class="tthead"></th>
                                       <td></td>
                                     <td></td>
                               </tr>
                            </table>
                                   
                              </div>
                           </div>
                        </div>
                     </div>


                     <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           15. Was the Hazard/Risk Identified ?<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_15" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                 <table class="table table-striped">                                          
                                      <tr>
                                       <th class="tthead">Was the Hazard/Risk Identified ?</th>
                                       <td>-</td>
                                          <td><?php echo $detail['IncidentInvestigationData']['HAZARD_RISK_IDENTIFY']; ?></td>
                                          <th class="tthead"></th>
                                       <td></td>
                                          <td></td>
                                       </tr>
                                   </table>
                                   
                                 </div>
                              </div>
                           </div>
                        </div>
                     


                      <div class="card ">
                           <div class="card-header ">
                              <a class="card-link " href="javascript:void(0)" >
                                 16. Action Plan (All action to be transferred to “Incident/Accident Tracking and Recording Register”
                                 <span class="float-right">
                                    <!-- <div class="btn btn-warning btn-sm addActionPlanDet">Add</div>
                                    <div class="btn btn-warning btn-sm AtarPageInsert">Report to ATAR</div> -->
                                 </span>
                              </a>
                           </div>
                           <div id="section_16" class="collapse multi-collapse show" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row ActivePlanInfo">
                                   <table class="table table-striped">                                          
                                      <?php $n = (isset($detail['activePlanAllDetails'])&&count($detail['activePlanAllDetails']))?count($detail['activePlanAllDetails']):1;
                                                for($i=0;$i<$n;$i++){   
                                                    $ActDate = $detail['activePlanAllDetails'][$i]['DATE_BY_WHEN'];
                                                  $ActplnDat = date('d-m-Y',strtotime($ActDate));
                                                  $actPln = substr($ActplnDat,6);
                                                    if($actPln == '1970'){
                                                        $actDevPln = '-';
                                                           }
                                                      else{
                                                        $actDevPln = $ActplnDat;
                                                         }
                                                             ?>  
                                                   <tr>
                                                   <th class="tthead">Corrective / Preventive</th>
                                                   <td>-</td>
                                                      <td><?php echo $detail['activePlanAllDetails'][$i]['CA_PA_DESC']; ?></td>
                                                      <th class="tthead">Responsibility (by whom?)</th>
                                                   <td>-</td>
                                                      <td><?php echo $detail['activePlanAllDetails'][$i]['EMP_NAME']; ?></td>
                                                   </tr>

                                                      <tr>
                                                   <th class="tthead">Date by when</th>
                                                   <td>-</td>
                                                      <td><?php echo $actDevPln; ?></td>
                                                      <th class="tthead"></th>
                                                   <td></td>
                                                      <td></td>
                                                   </tr>
                                           
                                          <?php } ?>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>


                        <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                              17. Attachments (Witness statement, training record, photo/sketch, division report etc)
                              <span class="float-right">
                                 <!-- <div class="btn btn-warning btn-sm addAttachDetails">Add</div> -->
                              </span>
                           </a>
                        </div>
                        <div id="section_17" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row AttachInfo">
                                 <table class="table table-striped">  
                                   
                                          <?php $n = (isset($detail['attachAllDetail'])&&count($detail['attachAllDetail']))?count($detail['attachAllDetail']):1;
                                             for($i=0;$i<$n;$i++){   
                                                          ?>  
                                                            <tr>
                                                   <th class="tthead">Attachment</th>
                                                    <td>-</td>
                                                       <?php  if($detail['attachAllDetail'][$i]['FILE_EXT'] == 'jpg' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'JPG' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'JPEG' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'jpeg' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'PNG' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'png'){ ?>
                                                      <td><?php if(isset($detail['attachAllDetail'][$i])){?><img class="rootUps" src = "<?php echo base_url().$detail['attachAllDetail'][$i]['FILE_PATH'].'/'.$detail['attachAllDetail'][$i]['FILE_NAME']?>"><?php } ?></td><br>
                                                    <?php } else{ 
                                                        ?>
                                                      <td><?php if(($detail['attachAllDetail'][$i]['FILE_NAME'])!=''){ ?><a target="_blank" class="existing_file" href="<?php echo base_url().$detail['attachAllDetail'][$i]['FILE_PATH'].'/'.$detail['attachAllDetail'][$i]['FILE_NAME']?>"><i class="fa fa-eye"></i>&nbsp;View File</a><?php } ?></td>
                                                    <?php } ?>
                                                    <th class="tthead">Description</th> 
                                                   <td>-</td>
                                                      <td><?php echo $detail['attachAllDetail'][$i]['DESCRIPTION']; ?></td>
                                                   </tr>
                                           
                                        <?php } ?>
                                 
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>

                      <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           18. This accident is avoidable?<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_18" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                               <table class="table table-striped"> 
                                 <tr>
                                       <th class="tthead">This accident is avoidable</th>
                                       <td>-</td>
                                          <td><?php echo $detail['IncidentInvestigationData']['ACCITENT_AVOIDABLE']; ?></td>
                                          <th class="tthead"></th>
                                          <td></td>
                                          <td></td>
                                       </tr> 
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>


                     <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           19. Proposed Action/Recommendation<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_19" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                 <table class="table table-striped"> 
                                     <tr>
                                       <!--  <th class="tthead">Proposed Action/Recommendation</th> -->
                                      <!--  <td>-</td> -->
                                          <td><?php echo $RecomendationSummary; ?></td>
                                          <th class="tthead"></th>
                                       <td></td>
                                          <td></td>
                                       </tr> 
                                    </table>
                                   
                                 </div>
                              </div>
                           </div>
                        </div>
                   <?php echo form_close(); ?>
                   <div class="card">
<div class="card-header ">
<a class="card-link " href="javascript:void(0)" >
Reviewed By<span class="float-right"></span>
</a>
</div>
<div id="section_20" class="collapse multi-collapse show" data-parent="#accordion">
<div class="card-body">
<div class="row">
<table class="table table-striped">
<?php if($detail['IncidentInvestigationData']['REVIEWED_REMARK'] !=''){ ?>
<tr>
<th class="tthead">User Name</th>
<td>-</td>
<td><?php echo strtoupper($userNameRev); ?></td>
<th class="tthead">Reviewed Date and Time</th>
<td>-</td>
<td><?php echo $detail['IncidentInvestigationData']['REVIEWED_DATE'] ; ?></td>
</tr>

<tr>
<th class="tthead">Remark</th>
<td>-</td>
<td><?php echo $detail['IncidentInvestigationData']['REVIEWED_REMARK']; ?></td>
<th class="tthead">Review Status</th>
<td>-</td>
<?php if($detail['IncidentInvestigationData']['REVIEWED_STATUS'] == 'R') {
$PREPARED_STATUS = 'Review Rejected';
} else { $PREPARED_STATUS = 'Review Accepted'; } ?>

<td><?php echo $PREPARED_STATUS; ?></td>

</tr>
<?php } ?>
</table>

</div>
</div>
</div>
</div>
                     <div class="card">
<div class="card-header ">
<a class="card-link " href="javascript:void(0)" >
Verified By<span class="float-right"></span>
</a>
</div>
<div id="section_21" class="collapse multi-collapse show" data-parent="#accordion">
<div class="card-body">
<div class="row">
<table class="table table-striped">
<?php if($detail['IncidentInvestigationData']['VERIFIED_REMARK'] !=''){ ?>
<tr>
<th class="tthead">User Name</th>
<td>-</td>
<td><?php echo strtoupper($userNameVer); ?></td>
<th class="tthead">Verified Date and Time</th>
<td>-</td>
<td><?php echo $detail['IncidentInvestigationData']['VERIFIED_DATE'] ; ?></td>
</tr>

<tr>
<th class="tthead">Remark</th>
<td>-</td>
<td><?php echo $detail['IncidentInvestigationData']['VERIFIED_REMARK']; ?></td>
<th class="tthead">Verify Status</th>
<td>-</td>
<?php if($detail['IncidentInvestigationData']['VERIFIED_STATUS'] == 'R') {
$VERIFIED_STATUS = 'Revert with remark';
} else { $VERIFIED_STATUS = 'Verify Accepted'; } ?>
<td><?php echo $VERIFIED_STATUS; ?></td>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
</div>
                     <div class="card">
<div class="card-header ">
<a class="card-link " href="javascript:void(0)" >
Approved By <span class="float-right"></span>
</a>
</div>
<div id="section_22" class="collapse multi-collapse show" data-parent="#accordion">
<div class="card-body">
<div class="row">
<table class="table table-striped">
<?php if($detail['IncidentInvestigationData']['APPROVED_REMARK'] !=''){ ?>
<tr>
<th class="tthead">User Name</th>
<td>-</td>
<td><?php echo strtoupper($userNameApr); ?></td>
<th class="tthead">Approved Date and Time</th>
<td>-</td>
<td><?php echo $detail['IncidentInvestigationData']['APPROVED_DATE'] ; ?></td>
</tr>


<tr>
<th class="tthead">Remark</th>
<td>-</td>
<td><?php echo $detail['IncidentInvestigationData']['APPROVED_REMARK']; ?></td>
<th class="tthead">Approve Status</th>
<td>-</td>
<?php if($detail['IncidentInvestigationData']['APPROVED_STATUS'] == 'R') {
$APPROVED_STATUS = 'Revert with remark';
} else { $APPROVED_STATUS = 'Approved'; } ?>
<td><?php echo $APPROVED_STATUS; ?></td>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
</div> 


                   


            </div>
         </div>
   </div>

   </section>


   <!-- section content-->
</div>
<!--content-wrapper-->
</div>
<!--wrapper-->
<script>
   $(document).ready(function () {
      //alert(1);

     

      var involveVal = '<?php echo $detail['IncidentInvestigationData']['INC_AUTHORITY_INVOLVED']; ?>';
      if(involveVal == 'Y'){
         $('.tthead').removeClass('d-none');
         $('.upting').removeClass('d-none');
         $('.involved').removeClass('d-none');
      }

   // text box hide and show and validate  -  Was an authority Involved
   $('[name="authorityInvol"]').change(function () {
    var authorityValue = $(this).val();
   if (authorityValue == 'Y') {
   $('.authorityInvolvedHide').removeClass('d-none');
    } else {
   $('.authorityInvolvedHide').addClass('d-none');
    }
    });

   var AuthorityValues = '<?php echo $detail['IncidentInvestigationData']['INC_AUTHORITY_INVOLVED']; ?>';
   if (AuthorityValues == 'Y') {
     $('.authorityInvolvedHide').removeClass('d-none');
  }
  else{
    $('.authorityInvolvedHide').addClass('d-none');
  }


   var InjuredPer = '<?php echo $detail['IncidentInvestigationData']['INJURED_PERSON']; ?>';
   if (InjuredPer == 'Y') {
     $('.InjuredPersonHide').removeClass('d-none');

      $(function() {
        var scntDiv = $('.injuredTable');
        var i = <?php echo (isset($detail['injuredAllDetails'])&&count($detail['injuredAllDetails']))?(count($detail['injuredAllDetails'])):1?>;
          
        $(document).on('click', '.addInjuredDet', function () {

          if (i < 10) {
                                                                                                                                               
                        $('<tr id="RowInjures'+i+'"><td><label>Name</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][injuredEmpName]" class="form-control injuredEmpName" id="injuredEmpName'+i+'" value=""></td><td class="col-md-1"><label>Sex</label><div><div class="form-check-inline"><input class="form-check-input" alt="'+i+'" type="radio" value="M" id="idInjuredMale'+i+'" name="injuredDatas['+i+'][injuredGen]" ><label class="form-check-label" for="idInjuredMale">Male</label></div></div><div class="form-check-inline"><input class="form-check-input" alt="'+i+'" type="radio" value="F" id="idInjuredFemale'+i+'" name="injuredDatas['+i+'][injuredGen]"> <label class="form-check-label" for="idInjuredFemale">Female</label></div><span class="error idtype1error"></span></td><td><label>Age</label><input type = "text" minlength="1" alt="'+i+'" maxlength="3" name= "injuredDatas['+i+'][age]" class="form-control age" id="age'+i+'" value=""></td><td><label>Job Title</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][jobTitle]" class="form-control jobTitle" id="jobTitle'+i+'" value=""></td><td><label>Citizenship</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][citizenship]" class="form-control citizenship" id="citizenship'+i+'" value=""></td><td><label>ID type</label><select class="form-control injuredIdType" alt="'+i+'"  name="injuredDatas['+i+'][injuredIdType]"><option value="">Select - Idtype </option><option value="IC" >IC</option> <option value="PASSPORT">Passport</option></select></td><td><label>IC Passport No</label><div><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][passportNo]" class="form-control passportNo" id="passportNo'+i+'" value=""></td><td><label>Contractor/Company Name</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][injuredCompanyName]" class="form-control injuredCompanyName" id="injuredCompanyName'+i+'" value=""></td><td><label>Injury Type</label><div><div><input type = "text" alt="'+i+'"  name= "injuredDatas['+i+'][InjuryType]" class="form-control InjuryType" id="InjuryType'+i+'" value=""></div></div></td><td><label>Body part effected</label><div><div><select class="form-control bodyPart" alt="'+i+'" id="bodyPart'+i+'" name= "injuredDatas['+i+'][bodyPart]"><option value="">Select - Emp </option><?php foreach($bodyPartMainData as $bm){ ?><option value="<?php echo $bm['PART_ID']?>" <?php echo (isset($detail['investigationAllDetails'][$i])&&$detail['investigationAllDetails'][$i]['BODY_PART_ID']==$bm['PART_ID'])?"selected":''?>><?php echo $bm['MAIN_BODY_PART_NAME']?></option><?php } ?></select></div></div></td> <div class="col-md-3"><td SubBody d-none><label>Sub part of Body</label><div><select class="form-control SubbodyPart" alt="'+i+'" id="SubbodyPart'+i+'" name= "injuredDatas['+i+'][SubbodyPart]"><option value="">Select -Sub -Part </option> </select></div></td></div><div class="col-md-3"><td class= "ImageHide d-none"><div><img id="partsImg'+i+'" src=""></div></td></div><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                      
    }
        i++;    
          
     });
                                                                                                                                      
});

   }
   else{
     $('.InjuredPersonHide').addClass('d-none');
   }

   // text box hide and show   -  Injured Person (IP) Details (provide the details of all IPs involved) 

   $('[name="InjuredPer"]').change(function () {
   var injuredValue = $(this).val();
   if (injuredValue == 'Y') {
   $('.InjuredPersonHide').removeClass('d-none');
        
  // Injured Person (IP) Details (provide the details of all IPs involved)   -  Multiple add
   
   $(function() {
        var scntDiv = $('.injuredTable');
        var i = <?php echo (isset($detail['injuredAllDetails'])&&count($detail['injuredAllDetails']))?(count($detail['injuredAllDetails'])):1?>;
         var z=1;
        
          
        $(document).on('click', '.addInjuredDet', function () {

          if (i < 10) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="RowInjures'+i+'"><td><label>Name</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][injuredEmpName]" class="form-control injuredEmpName" id="injuredEmpName'+i+'" value=""></td><td class="col-md-1"><label>Sex</label><div><div class="form-check-inline"><input class="form-check-input" alt="'+i+'" type="radio" value="M" id="idInjuredMale'+i+'" name="injuredDatas['+i+'][injuredGen]" ><label class="form-check-label" for="idInjuredMale">Male</label></div></div><div class="form-check-inline"><input class="form-check-input" alt="'+i+'" type="radio"  value="F" id="idInjuredFemale'+i+'" name="injuredDatas['+i+'][injuredGen]"> <label class="form-check-label" for="idInjuredFemale">Female</label></div><span class="error idtype1error"></span></td><td><label>Age</label><input type = "text" minlength="1" alt="'+i+'" maxlength="3" name= "injuredDatas['+i+'][age]" class="form-control age" id="age'+i+'" value=""></td><td><label>Job Title</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][jobTitle]" class="form-control jobTitle" id="jobTitle'+i+'" value=""></td><td><label>Citizenship</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][citizenship]" class="form-control citizenship" id="citizenship'+i+'" value=""></td><td><label>ID type</label><select class="form-control injuredIdType" alt="'+i+'" name="injuredDatas['+i+'][injuredIdType]"><option value="">Select - Idtype </option><option value="IC" >IC</option> <option value="PASSPORT">Passport</option></select></td><td><label>IC Passport No</label><div><input type = "text" alt="'+i+'"  name= "injuredDatas['+i+'][passportNo]" class="form-control passportNo" id="passportNo'+i+'" value=""></td><td><label>Contractor/Company Name</label><input type = "text" alt="'+i+'"  name= "injuredDatas['+i+'][injuredCompanyName]" class="form-control injuredCompanyName" id="injuredCompanyName'+i+'" value=""></td><td><label>Injury Type</label><div><div><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][InjuryType]" class="form-control InjuryType" id="InjuryType'+i+'" value=""></div></div></td><td><label>Body part effected</label><div><div><select class="form-control bodyPart" alt="'+i+'" id="bodyPart'+i+'" name= "injuredDatas['+i+'][bodyPart]"><option value="">Select - Emp </option><?php foreach($bodyPartMainData as $bm){ ?><option value="<?php echo $bm['PART_ID']?>" <?php echo (isset($detail['investigationAllDetails'][$i])&&$detail['investigationAllDetails'][$i]['BODY_PART_ID']==$bm['PART_ID'])?"selected":''?>><?php echo $bm['MAIN_BODY_PART_NAME']?></option><?php } ?></select></div></div></td> <div class="col-md-3"><td SubBody d-non><label>Sub part of Body</label><div><select class="form-control SubbodyPart" alt="'+i+'" id="SubbodyPart'+i+'" name= "injuredDatas['+i+'][SubbodyPart]"><option value="">Select -Sub -Part </option> </select></div></td></div> <div class="col-md-3"><td class= "ImageHide d-none"><div><img id="partsImg'+i+'" src=""></div></td></div> <div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                  
       
    }
        i++;    
          
     });
                                                                                                                                      
});


    } else {
   $('.InjuredPersonHide').addClass('d-none');
    }
    });


   var assetDetails = '<?php echo $detail['IncidentInvestigationData']['ASSET_DETAILS']; ?>';
   if (assetDetails == 'Y') {
   $('.AssetDetailsHide').removeClass('d-none');
      
       $(function() {
        var scntDiv = $('.AssetTable');
        var i = <?php echo (isset($detail['AssetAllDetails'])&&count($detail['AssetAllDetails']))?(count($detail['AssetAllDetails'])):1?>;
         var z=1;
        
          
        $(document).on('click', '.addAssetDet', function () {
                  if (i < 10) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="RowAsset'+i+'"><td><label>Description </label><div><textarea cols="5" rows="2" class="form-control"  name="assetDatas['+i+'][assetDescription]" id="assetDescription'+i+'"></textarea></div></td><td> <label>Name of Operator/ Driver /Vessel Master</label><div><input type = "text" alt="'+i+'" name= "assetDatas['+i+'][assetNameOfOperator]" class="form-control assetNameOfOperator" id="assetNameOfOperator'+i+'" value=""></div></td><td><label>Phone No</label><div><input type = "text" alt="'+i+'"  maximum="16" minimum ="16" name= "assetDatas['+i+'][assetPhone]" class="form-control assetPhone" id="assetPhone'+i+'" value=""></div></td><td><label>Owner/Company Name </label><div><input type = "text" alt="'+i+'"  name= "assetDatas['+i+'][assetOwner]" class="form-control assetOwner" id="assetOwner'+i+'" value=""></div></td><td><label>Plate No </label> <div><input type = "text" alt="'+i+'" name= "assetDatas['+i+'][assetPlate]" class="form-control assetPlate" id="assetPlate'+i+'" value=""></div></td><td><label>Estimated Cost of Damage></label><div><input type = "text" alt="'+i+'"  name= "assetDatas['+i+'][assetEstimate]" class="form-control assetEstimate" id="assetEstimate'+i+'" value=""></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                     
    }
        i++;    
          
     });
                                                                                                                                      
});
    }
    
    else{
   $('.AssetDetailsHide').addClass('d-none');
    }

   // text box hide and show   -  Asset Details (Provide the details of all assets involved) 

   $('[name="assetDetails"]').change(function () {
   var injuredValue = $(this).val();
   if (injuredValue == 'Y') {
   $('.AssetDetailsHide').removeClass('d-none');

   // Asset Details (Provide the details of all assets involved)   -  Multiple add
   

   $(function() {
        var scntDiv = $('.AssetTable');
        var i = <?php echo (isset($detail['AssetAllDetails'])&&count($detail['AssetAllDetails']))?(count($detail['AssetAllDetails'])):1?>;
         var z=1;
        
          
        $(document).on('click', '.addAssetDet', function () {
        if (i < 10) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="RowAsset'+i+'"><td><label>Description </label><div><textarea cols="5" rows="2" class="form-control"  name="assetDatas['+i+'][assetDescription]" id="assetDescription'+i+'"></textarea></div></td><td> <label>Name of Operator/ Driver /Vessel Master</label><div><input type = "text" alt="'+i+'"  name= "assetDatas['+i+'][assetNameOfOperator]" class="form-control assetNameOfOperator" id="assetNameOfOperator'+i+'" value=""></div></td><td><label>Phone No</label><div><input type = "text" alt="'+i+'"  maximum="16" minimum ="16" name= "assetDatas['+i+'][assetPhone]" class="form-control assetPhone" id="assetPhone'+i+'" value=""></div></td><td><label>Owner/Company Name </label><div><input type = "text" alt="'+i+'" name= "assetDatas['+i+'][assetOwner]" class="form-control assetOwner" id="assetOwner'+i+'" value=""></div></td><td><label>Plate No </label> <div><input type = "text" alt="'+i+'" name= "assetDatas['+i+'][assetPlate]" class="form-control assetPlate" id="assetPlate'+i+'" value=""></div></td><td><label>Estimated Cost of Damage></label><div><input type = "text" alt="'+i+'" name= "assetDatas['+i+'][assetEstimate]" class="form-control assetEstimate" id="assetEstimate'+i+'" value=""></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                      

   
    }
        i++;    
          
     });
                                                                                                                                      
});
    } else {
   $('.AssetDetailsHide').addClass('d-none');
    }
    });

    // avoid txt and number - in textbox - validation

    $(document).ready(function () {
           $(".SupervisorempName").keypress(function (e) {
               var key = e.keyCode;
               if (key >= 48 && key <= 57) {
                   e.preventDefault();
               }
           });
       });
   
   $(document).ready(function () {
           $("#empName").keypress(function (e) {
               var key = e.keyCode;
               if (key >= 48 && key <= 57) {
                   e.preventDefault();
               }
           });
       });
         
    $(document).ready(function () {
           $(".injuredEmpName").keypress(function (e) {
               var key = e.keyCode;
               if (key >= 48 && key <= 57) {
                   e.preventDefault();
               }
           });
       });

    $(document).ready(function () { 
           $("#designation").keypress(function (e) {
               var key = e.keyCode;
               if (key >= 48 && key <= 57) {
                   e.preventDefault();
               }
           });
       });
    
    $(document).ready(function () { 
           $(".jobTitle").keypress(function (e) {
               var key = e.keyCode;
               if (key >= 48 && key <= 57) {
                   e.preventDefault();
               }
           });
       });

     $(document).ready(function () { 
           $(".personName").keypress(function (e) {
               var key = e.keyCode;
               if (key >= 48 && key <= 57) {
                   e.preventDefault();
               }
           });
       });

    $(document).ready(function () { 
           $(".perJobTitle").keypress(function (e) {
               var key = e.keyCode;
               if (key >= 48 && key <= 57) {
                   e.preventDefault();
               }
           });
       });
    $(document).ready(function () { 
           $(".assetNameOfOperator").keypress(function (e) {
               var key = e.keyCode;
               if (key >= 48 && key <= 57) {
                   e.preventDefault();
               }
           });
       });



    $(function() {
        var scntDiv = $('.supervisorTable');
        var i = <?php echo (isset($detail['superiorAllDetails'])&&count($detail['superiorAllDetails']))?(count($detail['superiorAllDetails'])):1?>;
         var z=1;
        
          
        $('#addSuperDet').on('click', function() {
             if (i < 5 ) { 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="Rowhide'+i+'"><td><label>Employee ID</label><input type = "text"  alt="'+i+'" name= "superiorDatas['+i+'][supEmployeeId]" class="form-control SupervisorempIds" id="SupervisorempIds'+i+'" value=""></td><td><label>Name </label><input type = "text" name= "superiorDatas['+i+'][supEmployeeName]" class="form-control SupervisorempName" id="SupervisorempName'+i+'" value=""></td><td><label>Phone </label><input type = "text" name= "superiorDatas['+i+'][mobile]" class="form-control mobile" id="mobile'+i+'" value=""><td><label>Present</label><div><div class="form-check-inline"><input class="form-check-input" type="radio" value="Y" id="idsuperiorPresentY'+i+'" name="superiorDatas['+i+'][present]" ><label class="form-check-label" for="idsuperiorPresentY">Yes</label></div><div class="form-check-inline"><input class="form-check-input" type="radio" value="N" id="idsuperiorPresentN'+i+'"   name="superiorDatas['+i+'][present]"><label class="form-check-label" for="idsuperiorPresentN">No</label></div></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                       // alert(i);
                      
             
        
         
       }
        i++;    
          
     });
                                                                                                                                      
});

    // Delete Details

    function deleteColumnForIncident(id,table,pri_clm){
     if(id !='' && table!='' && pri_clm!=''){
     var url = "<?php echo BASE_URL() . "incident/DeleteAllDetails" ?>";
     var data = {id:id,table:table,pri_clm:pri_clm, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
        $.ajax({
                type:'POST',
                url:url,
                data:data,
                success: function(data){
                  
                  }
                });
              }
            }


    $('.supervisorTable').on('click', ".delete", function(e) {
    var id = $(this).attr('attr');
    var table = $(this).attr('attr_table');
    var alt_del = $(this).attr('alt');
    $('#Rowhide'+alt_del).hide();
    var pri_clm = $(this).attr('attr_tblid');
    $(document).on('click' , '#save' , function(){
    deleteColumnForIncident(id,table,pri_clm);
    });
    $(this).closest('tr').remove();
    e.preventDefault();
    });

    $('.InvestigationTable').on('click', ".delete", function(e) {
    var id = $(this).attr('attr');
    var table = $(this).attr('attr_table');
    var alt_del = $(this).attr('alt');
    $('#Rowperson'+alt_del).hide();
    var pri_clm = $(this).attr('attr_tblid');
    $(document).on('click' , '#save' , function(){
    deleteColumnForIncident(id,table,pri_clm);
    });
    $(this).closest('tr').remove();
    e.preventDefault();
    });

    $('.InjuredPersonHide').on('click', ".delete", function(e) {
    var id = $(this).attr('attr');
    var table = $(this).attr('attr_table');
    var alt_del = $(this).attr('alt');
    $('#RowInjures'+alt_del).hide();
    var pri_clm = $(this).attr('attr_tblid');
    $(document).on('click' , '#save' , function(){
    deleteColumnForIncident(id,table,pri_clm);
    });
    $(this).closest('tr').remove();
    e.preventDefault();
    });

    $('.AssetTable').on('click', ".delete", function(e) {
    var id = $(this).attr('attr');
    var table = $(this).attr('attr_table');
    var alt_del = $(this).attr('alt');
    $('#RowAsset'+alt_del).hide();
    var pri_clm = $(this).attr('attr_tblid');
    $(document).on('click' , '#save' , function(){
    deleteColumnForIncident(id,table,pri_clm);
    });
    $(this).closest('tr').remove();
    e.preventDefault();
    });

    $('.personInterTable').on('click', ".delete", function(e) {
    var id = $(this).attr('attr');
    var table = $(this).attr('attr_table');
    var alt_del = $(this).attr('alt');
    $('#RowInterView'+alt_del).hide();
    var pri_clm = $(this).attr('attr_tblid');
    $(document).on('click' , '#save' , function(){
    deleteColumnForIncident(id,table,pri_clm);
    });
    $(this).closest('tr').remove();
    e.preventDefault();
    });

    $('.circumstanceTable').on('click', ".delete", function(e) {
    var id = $(this).attr('attr');
    var table = $(this).attr('attr_table');
    var alt_del = $(this).attr('alt');
    $('#RowCircumstance'+alt_del).hide();
    var pri_clm = $(this).attr('attr_tblid');
    $(document).on('click' , '#save' , function(){
    deleteColumnForIncident(id,table,pri_clm);
    });
    $(this).closest('tr').remove();
    e.preventDefault();
    });

    $('.ActivePlanTable').on('click', ".delete", function(e) {
    var id = $(this).attr('attr');
    var table = $(this).attr('attr_table');
    var alt_del = $(this).attr('alt');
    $('#RowActionPlan'+alt_del).hide();
    var pri_clm = $(this).attr('attr_tblid');
    $(document).on('click' , '#save' , function(){
    deleteColumnForIncident(id,table,pri_clm);
    });
    $(this).closest('tr').remove();
    e.preventDefault();
    });

    $('.AttachTable').on('click', ".delete", function(e) {
    var id = $(this).attr('attr');
    var table = $(this).attr('attr_table');
    var alt_del = $(this).attr('alt');
    $('#RowAttach'+alt_del).hide();
    var pri_clm = $(this).attr('attr_tblid');
    $(document).on('click' , '#save' , function(){
    deleteColumnForIncident(id,table,pri_clm);
    });
    $(this).closest('tr').remove();
    e.preventDefault();
    });

    

  
   // Persons Interviewed - Multiple add
   
     $(function() {
        var scntDiv = $('.personInterTable');
        var i = <?php echo (isset($detail['personInterviewd'])&&count($detail['personInterviewd']))?(count($detail['personInterviewd'])):1?>;

        $(document).on('click', '.addPersonInter', function () {

          if (i < 10) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                        $('<tr id="RowInterView'+i+'"><td><label>Employee ID </label><input type = "text" alt="'+i+'" name= "personDatas['+i+'][perEmployeeId]" class="form-control personEmpIds" id="personEmpIds'+i+'" value=""></td><td><label>Name </label><input type = "text" name= "personDatas['+i+'][perEmployeeName]" class="form-control personName" id="personName'+i+'" value=""></td><td><label>Job Title </label><input type = "text" name= "personDatas['+i+'][personJobTitle]" class="form-control perJobTitle" id="perJobTitle'+i+'" value=""></td><td><label>Phone </label><input type = "text" name= "personDatas['+i+'][personMobile]" class="form-control perMobile" id="perMobile'+i+'" value=""></td>div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
            }
           
        i++;    
          
     });
                                                                                                                                      
});

 

   // Action Plan (All action to be transferred to “Incident/Accident Tracking and Recording Register”   -  Multiple add

   $(function() {
        var scntDiv = $('.ActivePlanTable');
        var i = <?php echo (isset($detail['activePlanAllDetails'])&&count($detail['activePlanAllDetails']))?(count($detail['activePlanAllDetails'])):1?>;
         
        $(document).on('click', '.addActionPlanDet', function () { 
             if (i < 10) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="RowActionPlan'+i+'"> <td><label>Corrective / Preventive</label><div><textarea cols="5" rows="2" class="form-control" name="activePlanDatas['+i+'][activePreventive]" id="activePreventive'+i+'"></textarea></div></td><td><label>Responsibility (by whom?)</label><div><select class="form-control activeResponName"  alt="'+i+'" name="activePlanDatas['+i+'][activeResponName]"> <option value="">Select - Emp </option><?php foreach($employeeNameDetails as $em){?><option value="<?php echo $em['EMP_AUTO_ID']?>" <?php echo (isset($detail['activePlanAllDetails'][$i])&&$detail['activePlanAllDetails'][$i]['EMP_AUTO_ID']==$em['EMP_AUTO_ID'])?"selected":''?>><?php echo $em['EMP_NAME']?></option><?php } ?></select></div></td><td><label>Date by when</label><input type="text" name="activePlanDatas['+i+'][activeDate]" class="form-control datepick" value="" autocomplete="off"/></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                     }
                      
     
        i++;    
          
     });
                                                                                                                                      
});

   

   // Attachments (Witness statement, training record, photo/sketch, division report etc)   -  Multiple add

   $(function() {
        var scntDiv = $('.AttachTable');
        var i = <?php echo (isset($detail['attachAllDetail'])&&count($detail['attachAllDetail']))?(count($detail['attachAllDetail'])):1?>;
         
        $(document).on('click', '.addAttachDetails', function () { 
       if (i < 20) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="RowAttach'+i+'"> <td><label>Upload </label><div><input type="file"  name="AttachDatas['+i+'][uploadFile]"  id="uploadFile'+i+'" class="form-control uploadFile" /><span class="AttachedDetal"></span><span class="error idtype1error"></span> </div></td><td> <label>Description</label><div><textarea cols="5" rows="2" class="form-control"  name="AttachDatas['+i+'][attachDescription]"  id="attachDescription'+i+'"></textarea></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                      
      }
        i++;    
          
     });
                                                                                                                                      
});


   // Investigation Team   -  Multiple add

   $(function() {
        var scntDiv = $('.InvestigationTable');
        var i = <?php echo (isset($detail['investigationAllDetails'])&&count($detail['investigationAllDetails']))?(count($detail['investigationAllDetails'])):1?>;
         
        $(document).on('click', '.addInvestigationDet', function () {   
       if (i < 5) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="Rowperson'+i+'"><td><label>Employee name</label><div><select class="form-control invesEmployeeName" alt="'+i+'" name="invesEmployeeInform['+i+'][employeeInvesName]"> <option value="">Select - Emp </option><?php foreach($employeeNameDetails as $em){?><option value="<?php echo $em['EMP_AUTO_ID']?>" <?php echo (isset($detail['investigationAllDetails'][$i])&&$detail['investigationAllDetails'][$i]['EMP_AUTO_ID']==$em['EMP_AUTO_ID'])?"selected":''?>><?php echo $em['EMP_NAME']?></option><?php } ?></select></div></td><td><label>Employee ID </label><div><input type = "text" alt="'+i+'" name= "invesEmployeeInform['+i+'][invesEmployeeid]" class="form-control InvesEmployeeId" id="InvesEmployeeId'+i+'" value="" readonly></div></td><td><label>Designation</label> <div><input type = "text" alt="'+i+'" name= "invesEmployeeInform['+i+'][invesDesignation]" class="form-control invesDesignation" id="invesDesignation'+i+'" value="" readonly></div> <input type = "hidden" alt="'+i+'" name= "invesEmployeeInform['+i+'][invesDesignationId]" class="form-control invesDesignationId" id="invesDesignationId'+i+'" value="" readonly></td><td><label>Phone No</label><div><input type = "text"  alt="'+i+'" name= "invesEmployeeInform['+i+'][empMobile]" class="form-control empMobile" id="empMobile'+i+'" value=""></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                      
      }
        i++;    
          
     });
                                                                                                                                      
});


  
   
   $(function() {
        var scntDiv = $('.circumstanceTable');
        
        var i = <?php echo (isset($detail['circumstanceDetails'])&&count($detail['circumstanceDetails']))?(count($detail['circumstanceDetails'])):1?>;
        var j =  i + 1 ;
        $(document).on('click', '.addCircumstance', function () {
       
        if( i == 0){

          $('<tr id="RowCircumstance'+i+'"><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrOne]" id="circumDescrOne'+i+'"></textarea></div></td><td> <label></label><div><i class="fas fa-arrow-right" style="font-size: 5em;"></i></div></td><div class="col-md-3"><td> <label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrTwo]" id="circumDescrTwo'+i+'"></textarea></div><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 5em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrThree]" id="circumDescrThree'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 5em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrFour]" id="circumDescrFour'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 5em;"></i></div></td><td> <label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrFive]" id="circumDescrFive'+i+'"></textarea></div> </td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 5em;"></i></div><input class="form-control COUNT_COLUMN"  type="hidden"  value="'+j+'" alt="'+i+'"  name="circumstanceDatas['+i+'][COUNT_COLUMN]" id="COUNT_COLUMN'+i+'" /></td>div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);

        } 

        else if ( i % 2 == 0) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="RowCircumstance'+i+'"><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrOne]" id="circumDescrOne'+i+'"></textarea></div></td><td> <label></label><div><i class="fas fa-arrow-right" style="font-size: 5em;"></i></div></td><div class="col-md-3"><td> <label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrTwo]" id="circumDescrTwo'+i+'"></textarea></div><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 5em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrThree]" id="circumDescrThree'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 5em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control" name="circumstanceDatas['+i+'][circumDescrFour]" id="circumDescrFour'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 5em;"></i></div></td><td> <label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrFive]" id="circumDescrFive'+i+'"></textarea></div> </td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 5em;"></i></div><input class="form-control COUNT_COLUMN"  type="hidden"  value="'+j+'" alt="'+i+'"  name="circumstanceDatas['+i+'][COUNT_COLUMN]" id="COUNT_COLUMN'+i+'" /></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                      
     

        
           }
           else{
                        $('<tr id="RowCircumstance'+i+'"><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrOne]" id="circumDescrOne'+i+'"></textarea></div></td><td> <label></label><div><i class="fas fa-arrow-left" style="font-size: 5em;"></i></div></td><div class="col-md-3"><td> <label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrTwo]" id="circumDescrTwo'+i+'"></textarea></div><td><label></label><div><i class="fas fa-arrow-left" style="font-size: 5em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrThree]" id="circumDescrThree'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-left" style="font-size: 5em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrFour]" id="circumDescrFour'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-left" style="font-size: 5em;"></i></div></td><td> <label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrFive]" id="circumDescrFive'+i+'"></textarea></div> </td><td><label></label><div><i class="fas fa-arrow-left" style="font-size: 5em;"></i></div><input class="form-control COUNT_COLUMN"  type="hidden"  value="'+j+'" alt="'+i+'"  name="circumstanceDatas['+i+'][COUNT_COLUMN]" id="COUNT_COLUMN'+i+'" /></td>div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);

           }

           i++; 
           j++;
     });
                                                                                                                                      
});


    //Root cause analysis - Upload file
   
   $(document).on('change','#rootCause',function(){
   
           var file = this.files[0];
           var ext = $(this).val().split('.').pop().toLowerCase();
           if($.inArray(ext, ['png','jpg','jpeg','pdf','PNG','JPG','JPEG','PDF']) == -1) {
                $(this).parents('div').find('.rootCauseAnly').html('<td style="color:red">Only jpg, jpeg, png, pdf files are allowed!</td>');
                 $(this).parents('div').find('.rootCauseAnly').show().delay(5000).fadeOut();
                 $(this).val('');
                 return false;
             }
             else
             {
             
               $(this).parents('div').find('.rootCauseAnly').html('');
             }

             if(file.size>1000000)
           {
               $(this).parents('div').find('.rootCauseAnly').html('<td style="color:red">File size must be less than 2Mb</td>');
                $(this).parents('div').find('.rootCauseAnly').show().delay(5000).fadeOut();
               $(this).val('');
               return false;
           }
             else
              {
                $(this).parents('div').find('.rootCauseAnly').html('');
              }
           
          });

   
   // Attachments  -  Upload and Validation

   $(document).on('change','input[type="file"].uploadFile',function(){
     
         var file = this.files[0];
           var ext = $(this).val().split('.').pop().toLowerCase();
           if($.inArray(ext, ['png','jpg','jpeg','pdf','PNG','JPG','JPEG','PDF']) == -1) {
                $(this).parents('tr').find('.AttachedDetal').html('<td style="color:red">Only jpg, jpeg, png, pdf files are allowed!</td>');
                 $(this).parents('tr').find('.AttachedDetal').show().delay(5000).fadeOut();
                 $(this).val('');
                 return false;
             }
             else
             {
             
               $(this).parents('tr').find('.AttachedDetal').html('');
             }
             if(file.size>1000000)
           {
               $(this).parents('tr').find('.AttachedDetal').html('<td style="color:red">File size must be less than 2Mb</td>');
                $(this).parents('tr').find('.AttachedDetal').show().delay(5000).fadeOut();
               $(this).val('');
               return false;
           }
             else
              {
                $(this).parents('tr').find('.AttachedDetal').html('');
              }

        });

   $("#investformReview").validate({
    rules: {
        'reviewdBy':{
         required:true,
        },
        'ReviewAcpRej':{
         required:true,
        },
        'verifiedBy':{
         required:true,
        },
        'VerifiedAcpRej':{
         required:true,
        },
        'approvedBy':{
         required:true,
        },
        'ApprovedAcpRej':{
         required:true,
        },
    }
   });


   // Form Validation
   $('#save').on('click' , function(){

      $("#investform").validate({
           rules: {
           	'eventDate':{
           		required:true
           	},
               'eventTime': {
                   required: true
               },
               'eventLocation': {
                   required: true
               },
               'specificLocation': {
                   required: true
               },
               'workrelated':{
               	required:true
               },
               'activity':{
               	required:true
               },
               'assetDetails':{
                  required:true,
               },
               'recommendation':{
                  required:true,
               },
               'InjuredPer':{
                  required:true,
               },
               'authorityInvol':{
                  required:true,
               },
               'accidentAvoidab':{
                  required:true,
               },
               'empcont':{
               	required:true
               },
   
               'empName': {
                   required: true,
                   
               },
               'designation': {
                   required: true
               },
               'empPhnNo': {
                   required: true,
               },
               
               'description': {
                   required: true,
                   maxlength: 500,
                   minlength: 2
               },
               'files[0]':{
               	required:true,
               },
               'hazardRisk':{
               	required:true,
               },
               'authorityInvolved':{
                  required:true,
               },
               'possibleCause':{
               	required: true,
                   maxlength: 500,
                   minlength: 2
               },
               'innvesticationSum':{
                  required:true,
               },  
               'immuediateCause':{
                  required:true,
               },
               'contributingCause':{
                  required:true,
               }, 
               'superiorDatas[0][supEmployeeId]':{
                  required:true,
               },
               'superiorDatas[0][supEmployeeName]':{
                  required:true,
               },
               'superiorDatas[0][mobile]':{
                  required:true,
               },
               'superiorDatas[0][present]':{
                  required:true,
               },
               'invesEmployeeInform[0][employeeInvesName]':{
                  required:true,
               },
               'invesEmployeeInform[0][empMobile]':{
                  required:true,
               },
               'injuredDatas[0][injuredEmpName]':{
                  required:true,
               },
               'injuredDatas[0][injuredGen]':{
                  required:true,
               },
               'injuredDatas[0][age]':{
                  required:true,
               },
               'injuredDatas[0][jobTitle]':{
                  required:true,
               },
               'injuredDatas[0][citizenship]':{
                  required:true,
               },
               'injuredDatas[0][injuredIdType]':{
                  required:true,
               },
               'injuredDatas[0][passportNo]':{
                  required:true,
               },
               'injuredDatas[0][injuredCompanyName]':{
                  required:true,
               },
               'injuredDatas[0][InjuryType]':{
                  required:true,
               },
               'injuredDatas[0][bodyPart]':{
                  required:true,
               },
               'assetDatas[0][assetDescription]':{
                  required:true,
               },
               'assetDatas[0][assetNameOfOperator]':{
                  required:true,
               },
               'assetDatas[0][assetPhone]':{
                  required:true,
               },
               'assetDatas[0][assetOwner]':{
                  required:true,
               },
               'assetDatas[0][assetPlate]':{
                  required:true,
               },
               'assetDatas[0][assetEstimate]':{
                  required:true,
               },
               'personDatas[0][perEmployeeId]':{
                  required:true,
               },
               'personDatas[0][perEmployeeName]':{
                  required:true,
               },
               'personDatas[0][personJobTitle]':{
                  required:true,
               },
               'personDatas[0][personMobile]':{
                  required:true,
               },
               'circumstanceDatas[0][circumDescrOne]':{
                  required:true,
               },
               'circumstanceDatas[0][circumDescrTwo]':{
                  required:true,
               },
               'circumstanceDatas[0][circumDescrThree]':{
                  required:true,
               },
               'circumstanceDatas[0][circumDescrFour]':{
                  required:true,
               },
               'circumstanceDatas[0][circumDescrFive]':{
                  required:true,
               },
               'activePlanDatas[0][activePreventive]':{
                  required:true,
               },
               'activePlanDatas[0][activeResponName]':{
                  required:true,
               },
               'activePlanDatas[0][activeDate]':{
                  required:true,
               },
               'AttachDatas[0][attachDescription]':{
                  required:true,
               },

           }
       });
   });
   
    
   // Auto fetch for Employee Details
   
   $(document).on('change' , '.invesEmployeeName' , function(){
     
     var employeeId = $(this).val();
     var alt = $(this).attr('alt');
     
     var url = "<?php echo BASE_URL() . "incident/FetchEmployeeDetails" ?>";
     var data = {employeeId:employeeId, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};

     $.ajax({
              type : 'post',
              url : url,
              data: data,
              cache: false,
              success : function(data)
              {
              
               var obj = jQuery.parseJSON( data );
              
                $('#InvesEmployeeId'+alt).val(obj.EMP_ID);
                $('#invesDesignation'+alt).val(obj.DESIGNATION_NAME);
                $('#invesDesignationId'+alt).val(obj.EMP_DESIGNATION_ID);
              }
          });
   
   });

  //  var MainBodyPart = '<?php echo $detail['injuredAllDetailsBody'][0]['BODY_PART_ID']; ?>';
  //  if(MainBodyPart !=''){
  //     var alt = '0';
  //     var bodyValue = $('#bodyPart'+alt).val();
  //     getSubBodyPart(bodyValue , alt);
  //  }

  // // Sub Body Part .
  
  // $(document).on('change' , '.bodyPart' , function(){
  //    var alt = $(this).attr('alt');
  //    var bodyValue = $('#bodyPart'+alt).val();
  //    getSubBodyPart(bodyValue , alt);
   
  //  });

  // function getSubBodyPart(bodyValue,alt){
     
  //    var url = "<?php echo BASE_URL() . "incident/SubBodyDetail" ?>";
  //    var data = {bodyValue:bodyValue, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};

  //    $.ajax({
  //             type : 'post',
  //             url : url,
  //             data: data,
  //             cache: false,
  //             success : function(data)
  //             {
  //             $('.SubbodyPart').html(data);
  //             //$('#SubbodyPart'+alt).html(data);
  //             }
  //         });
  // }

  $(document).on('change' , '.bodyPart' , function(){
    var alt = $(this).attr('alt');
    var bodyValue = $('#bodyPart'+alt).val();

    var url = "<?php echo BASE_URL() . "incident/SubBodyDetail" ?>";
    var data = {bodyValue:bodyValue, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
    $.ajax({
              type : 'post',
              url : url,
              data: data,
              cache: false,
              success : function(data)
              {
              $('.SubBody').removeClass('d-none');
              $('.SubbodyPart').html(data);
              //$('#SubbodyPart'+alt).html(data);
              }
          });

  });

  // var SubBodyPart = '<?php echo $detail['injuredAllDetailsBody'][0]['SUB_ID']; ?>';
  //  if(SubBodyPart !=''){
  //     var alt = '0';
  //     var SubBodyValue = $('#SubbodyPart'+alt).val();
  //     getSubBodyImage(SubBodyValue , alt);
  //  }

  // // Sub Body Part .
  
  // $(document).on('change' , '.SubbodyPart' , function(){
  //    var alt = $(this).attr('alt');
  //    var SubBodyValue = $('#SubbodyPart'+alt).val();
  //    getSubBodyImage(SubBodyValue , alt);
   
  //  });

  // // Image get

  //   function getSubBodyImage(SubBodyValue , alt){
  //    var url = "<?php echo BASE_URL() . "incident/BodyImageDetail" ?>";
  //    var data = {SubBodyValue:SubBodyValue, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
  //    $.ajax({
  //             type : 'post',
  //             url : url,
  //             data: data,
  //             cache: false,
  //             success : function(data)
  //             {
                 
  //              $('.ImageHide').removeClass('d-none');
  //              //$('#partsImg'+alt).attr('src', data);
  //              $('.partsImg').attr('src', data);
  //             }
  //         });
   
  //  }


  $(document).on('change' , '.SubbodyPart' , function(){
     var alt = $(this).attr('alt');
     var SubBodyValue = $('#SubbodyPart'+alt).val();

     var url = "<?php echo BASE_URL() . "incident/BodyImageDetail" ?>";
     var data = {SubBodyValue:SubBodyValue, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
      $.ajax({
              type : 'post',
              url : url,
              data: data,
              cache: false,
              success : function(data)
              {
                 
               $('.ImageHide').removeClass('d-none');
               $('#partsImg'+alt).attr('src', data);
               //$('.partsImg').attr('src', data);
              }
          });
   
   });

  
 // Datepicker

    $(document).on('focus',".datepick", function(){
    $(this).datepicker({
        dateFormat:"dd-mm-yy",
        changeMonth: true,
        changeYear: true,
        maxDate: "+0D",
        yearRange: "1900:+nn",
        onClose: function(dateText) {
          $("#investform").valid();
      } 
        
    });
  });

   
  // Summary Note

   $('#innvesticationSum').summernote({
    toolbar: [
       ['style', ['bold', 'italic', 'underline', 'clear']],
       ['font', ['strikethrough', 'superscript', 'subscript']],
       ['fontsize', ['fontsize']],
       ['color', ['color']],
       ['para', ['ul', 'ol', 'paragraph']],
       ['height', ['height']],
       ['fontname', ['fontname']],
       ['table', ['table']],
       ['insert', ['link', 'picture', 'video']],
     ],
       image: [
       ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
       ['float', ['floatLeft', 'floatRight', 'floatNone']],
       ['remove', ['removeMedia']]
     ],
       link: [
       ['link', ['linkDialogShow', 'unlink']]
     ],
       table: [
       ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
       ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
     ],
       fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New']
 
  });

   // datepicker

   $("#eventDate").datepicker({
       autoclose: true,
       format: 'dd-mm-yyyy',
       orientation: 'bottom',
       endDate: new Date()
   });

   // time picker 

   $('#eventTime').clockpicker({
       align: 'left',
       autoclose: true,
       donetext: 'Done'
   });
 
 
    // Check All checkbox

    $('.checkAllClass').click(function(){
       var alt = $(this).attr('alt');
       $('.incidentClass').prop('checked', this.checked);
       });

    // save Process
      $(document).on('click', '#save', function(e) {
      $('#SUMBIT_PROCESS').val('1');
      if($('#MenusForm').valid()){
      $('#investform').submit();
        }
       });

      var SUMBIT_PROCESS = '<?php echo $detail['IncidentInvestigationData']['SUMBIT_PROCESS'];?>';
      var roleId = '<?php echo $_SESSION['userinfo']->USER_DESINATION_ID; ?>';
      var deptId = '<?php echo $_SESSION['user_details']->DEPTNAMEID; ?>';
      var locationId = '<?php echo $locid; ?>';
      
       if(SUMBIT_PROCESS == '1' && roleId == "26"){
         $('.reviewed').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();

       }
       if(locationId == '1' ){
         if(SUMBIT_PROCESS == '3' && roleId == "22"){
         $('.verified').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();
       }
      }
      else if(locationId == '2' ){
         if(SUMBIT_PROCESS == '3' && roleId == "18"){
         $('.verified').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();
       }
      }
        if(SUMBIT_PROCESS == '4' && deptId == '1'){
         $('.approved').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();
       }

       $('#review_save').on('click' , function(){
          $('#investformReview').submit();
       });



   
   // Save Draft All process .

    $('#saved').on('click' , function(){
      $('#SUMBIT_PROCESS').val('0');
      $('#investform').submit();
    });


    // Validation about Moblie 

    $(document).on('keydown', '.mobile', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0-9]|&/i.test(a);
      return true;
   })
    $(document).on('keydown', '.empMobile', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0-9]|&/i.test(a);  
      return true;
   })
    $(document).on('keydown', '.employeePhones', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0-9]|&/i.test(a);
      return true;
   })
    $(document).on('keydown', '.perMobile', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0-9]|&/i.test(a);
      return true;
   })

    $(document).on('keydown', '.age', function(e) {
      var a = e.key;
      if (a.length == 1) return /[0-9]|&/i.test(a);
      return true;
   })
    $(document).on('keydown', '.assetPhone', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0-9]|&/i.test(a);
      return true;
   })

    
    // AttachedDetal file Remove .

    $(document).on('click','.remove',function(){
        $(this).hide();
        $(this).parent().children('.existing_file').hide();
        $(this).parent().children('[type="file"]').show();
        $(this).parents('tr').find('.AttachedDetal').html('<td style="color:red">This field is required</td>');

    });

    // Root file Remove

    $(document).on('click','.remove1',function(){
        $(this).hide();
        $(this).parent().children('.existing_file').hide();
        $(this).parent().children('[type="file"]').show();
        $(this).parents('div').find('.rootCauseAnly').html('<td style="color:red">This field is required</td>');

    });


    $(document).on('click' , '.AtarPageInsert' , function(){
     var investId = '<?php echo $id; ?>';
     var url = "<?php echo BASE_URL() . "incident/SendToATARDetails" ?>";
     var data = {investId:investId, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};

     $.ajax({
              type : 'post',
              url : url,
              data: data,
              cache: false,
              success : function(data)
              {
              
              window.location.reload('Incident/');
              }
          });

     
    });

    $('#specificLocation').on('change' , function(){
           var specificLocation = $(this).val();
           if(specificLocation == '-1'){
               $('#specificlocother').removeClass('d-none');
           }
           else{
               $('#specificlocother').addClass('d-none');
           }
    });

    // Classification Checked details

    <?php if(isset($checkClassify)) {

    foreach ($checkClassify as $key => $value) { ?>

     var checkValues = '<?php echo $value; ?>';

     $('input[name="CLASSFICATION_MST_ID['+checkValues+']"]').prop('checked', true);

    
    <?php  } } ?>

   
   });
</script>

