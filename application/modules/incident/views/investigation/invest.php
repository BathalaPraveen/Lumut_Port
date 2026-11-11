<style>
   .newhr {
   margin-top: 15px;
   margin-bottom: 15px;
   border-color: white;
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
.row.headingStylss {
    margin: 19px;
    color: #2768ad;
    margin-left: -10px;
}
#tesingss {
    width: 29% !important;
}
#testsInjur{
    width: 20% !important;
}
.OwnerClass{
    font-size:14px;
}
@media (min-width: 1366px) and (max-width: 768px){
  
  #testsInjur{
    width: 20% !important;
}  
}
/* @media (min-width: 1366px){
      #testsInjur{
    width: 20% !important;
} */
/*@media (max-width: 1366px){
      #testsInjur{
    width: 20% !important;
} 
 }*/
.innvesticationSum{
    width:200px !important;
    height:150px !important;
}

.immuediateCause{
    width:200px !important;
    height:150px !important;
}

.possibleCause{
    width:200px !important;
    height:150px !important;
}


.contributingCause{
    width:200px !important;
    height:150px !important;
}

#docfileuploadincidentTeam{
    width:200px !important;
    height:150px !important;
}
.AtarPageInsert {
cursor: pointer;
}
   
</style>
<?php
   
    //echo 'M<pre>';print_r($_SESSION);exit;  
   $userName = $_SESSION['emp_details']->EMP_NAME;
   $currentDate = date('d-m-Y h:i:s');
  // echo 'M<pre>';print_r($userName);exit;
   $eventDate = postData($editData, 'eventDate', $this->input->post('eventDate'));
   $INCIDENT_ID = postData($editData, 'INCIDENT_ID', $this->input->post('INCIDENT_ID'));
   $eventTime = postData($editData, 'EVENT_TIME', $this->input->post('eventTime'));
   $locid = postData($editData, 'LOCATION_ID', $this->input->post('eventLocation'));
   $speclocid = postData($editData, 'SPECIFIC_LOCATION_ID', $this->input->post('specificLocation'));
   //echo 'M<pre>';print_r($speclocid);exit; 
   $speclocother = postData($editData, 'SPECIFIC_LOCATION_OTHER', $this->input->post('specificlocother'));
   $SUMBIT_PROCESS =  $detail['IncidentInvestigationData']['SUMBIT_PROCESS'];
      
    $roleId = $_SESSION['userinfo']->USER_DESINATION_ID; 
     // alert(roleId);
     $deptId =  $_SESSION['emp_details']->EMP_DEPT_ID; 
     $userType =  $_SESSION['userinfo']->USER_TYPE_ID;
     //echo 'M<pre>';print_r($userType);exit; 
   
  
   $descriptionForCompentency = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['COMPETENCY_RECORDS']:""); 
   $ImmediateCauseDescrp = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['IMMEDIATE_CAUSES']:"");
   $RootCauseOfSummary = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['POSSIBLE_ROOT_CAUSES']:"");
   $ContributingSummary = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['CONTRIBUTE_CAUSAL_FACTOR']:"");
   $RecomendationSummary = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['INVEST_PROPOSED_ACTION']:"");
   $IncidentActivity = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['ACTIVITY']:"");
   $IncidentEmpCount = (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['EMP_CONT']:"");
   //$reportedName = postData($userDetails, 'NAME', $this->input->post('reported_name'));
   //$reportedDesignation = postData($userDetails, 'DESIGNATION', $this->input->post('reported_cmp'));

$reportedName = postData($editData, 'EVENT_REPORT_NAME', $this->input->post('reported_name'));
   $reportedDesignation = postData($editData, 'EVENT_REPORT_DESIGNATION', $this->input->post('reported_cmp'));
   //$employeephnNoo = postData($editData, 'DESIGNATION', $this->input->post('reported_cmp'));
   $employeephnNoo = postData($editData, 'PHONE_NO', $this->input->post('PHONE_NO'));
   
   $readonly='';

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
                                    <div class="col-md-3">
                                       <label>Event Date <?php echo REQUIRED; ?></label>
                                       <div>
                                          <?php
                                             $data = [
                                                 'name' => 'eventDate',
                                                 'id' => 'eventDate',
                                                 'class' => 'form-control',
                                                 'value' => $eventDate,
                                                 
                                             ];
                                             echo form_input($data);
                                             ?>                   
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <label>Event Time <?php echo REQUIRED; ?></label>
                                       <?php
                                          $data = [
                                          'name' => 'eventTime',
                                          'id' => 'eventTime',
                                          'class' => 'form-control',
                                          'value' => $eventTime,
                                          'readonly' => $readonly
                                          ];
                                          echo form_input($data);
                                          ?>
                                    </div>
                                    <div class="col-md-3">
                                       <label>Event Location <?php echo REQUIRED; ?></label>
                                       <?php
                                          $editLoc = $locid;
                                          $options = $getLoc;
                                          $extra = 'class="form-control" id="eventLocation"';
                                          echo form_dropdown('eventLocation', $options, $editLoc, $extra);
                                          ?>
                                    </div>
                                                 <div class="col-md-3">
                                                <label>Specific Location <?php echo REQUIRED; ?></label>
                                                <select  class="form-control specificLocation" name="specificLocation" id="specificLocation" >
                                                    <option value="">Select</option>
                                                </select>  
                                                
                                                 <br>
                                                 <div class="specificlocotherss d-none">
                                               <input type = "text" name= "specificlocother" class="form-control specificlocother" id="specificlocother" value="<?php echo isset($speclocother)?$speclocother:''?>">
                                                
                                                 <br>
                                                </div>
                                                </div>
                                                 
                                                
                                     
                                     

                                 </div>
                                 <div class="row">
                                    <div class="col-md-3">
                                       <label>Work related </label>
                                       <div>
                                          <div class="form-check-inline">
                                             <input class="form-check-input" type="radio" id="idworkrelatedY" name="workrelated" value="Y"<?php if(isset($detail['IncidentInvestigationData']['INCIDENT_WORK_RELATED'])){echo $detail['IncidentInvestigationData']['INCIDENT_WORK_RELATED']=='Y'?'checked':'';}?> >
                                             <label class="form-check-label" for="idworkrelatedY">
                                             Yes
                                             </label>
                                          </div>
                                          <div class="form-check-inline">
                                             <input class="form-check-input" type="radio" id="idworkrelatedN" name="workrelated" value="N"<?php if(isset($detail['IncidentInvestigationData']['INCIDENT_WORK_RELATED'])){echo $detail['IncidentInvestigationData']['INCIDENT_WORK_RELATED']=='N'?'checked':'';}?>>
                                             <label class="form-check-label" for="idworkrelatedN">
                                             No
                                             </label>
                                          </div>
                                          <span class="error idtype1error"></span>  
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row mt-2">
                                    <div class="col-md-12">
                                       <label>Activity <?php echo REQUIRED; ?></label><br>
                                       <?php
                                          $data = [
                                          'name' => 'activity',
                                          'class' => 'form-control activity',
                                          'rows' => 3,
                                          'value' => $IncidentActivity,
                                          ];
                                          echo form_textarea($data);
                                          ?>
                                    </div>
                                 </div>
                                 <div class="row mt-2">
                                    <div class="col-md-12">
                                       <label>Employee/Contractor <?php echo REQUIRED; ?></label><br>
                                       <?php
                                          $data = [
                                          'name' => 'empcont',
                                          'class' => 'form-control empcont',
                                          'rows' => 3,
                                          'value' => $IncidentEmpCount,
                                          ];
                                          echo form_textarea($data);
                                          ?>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                       <?php
                                          $data = [
                                          'name' => 'INCIDENT_ID',
                                          'id' => 'INCIDENT_ID',
                                          'class' => 'form-control',
                                           'type' => 'hidden',
                                          'value' => $INCIDENT_ID
                                          ];
                                          echo form_input($data);
                                          ?>
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
                                 <div class="col-md-12">
                                       <table>
                                        <?php $j=1; $i=1; ?>
                                        
                                        <th> Select All&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name=""  class="checkAllClass" value=""></th>
                                        

                              <?php if(isset($incidentClassification)){ 
                                  foreach($incidentClassification as $ic){
                                  if($i == 1 || $i % 3 == 1){
                                       echo '<tr>';
                                    }
                                  ?>
                                
                                    <td><input type="checkbox" name="CLASSFICATION_MST_ID[<?php echo $ic['CLASSFICATION_MST_ID']; ?>]"  id="nostyle_chk<?php echo $i  ?>" class="incidentClass" value="<?php echo $ic['CLASSFICATION_MST_ID']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ic['CLASSFICATION_NAME']; ?></td>
                                 <?php  
                                     if($i % 3 == 0){ 
                                      echo '</tr>';
                                       }  ?>
                                    <?php  $i++; }} ?>
                                 </tr>
                                 </table>


                              
                                    
                                 </div>
                                
                              </div>
                              
                              
                           </div>
                        </div>
                     </div>


                           <div class="card ">
                           <div class="card-header ">
                              <a class="card-link " href="javascript:void(0)" >
                                 3. Supervisor/Superior details
                                 <span class="float-right">
                                    <div class="btn btn-warning btn-sm " id="addSuperDet">Add</div>
                                 </span>
                              </a>
                           </div>
                           <div id="section_3" class="collapse multi-collapse show" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row superiorInfo">
                                    <table class="table table-bordered supervisorTable">
                                       
                                         
                                             <?php $n = (isset($detail['superiorAllDetails'])&&count($detail['superiorAllDetails']))?count($detail['superiorAllDetails']):1;
                                                for($i=0;$i<$n;$i++){ ?>  
                                                   <tr id="Rowhide<?php echo $i ?>">
                                                          
                                            <div class="col-md-3">                
                                             <td>
                                                <label>Employee ID <?php echo REQUIRED; ?></label>
                                                <div>
                                                   <input type = "text" alt="<?php echo $i;?>"  name= "superiorDatas[<?php echo $i ?>][supEmployeeId]" class="form-control SupervisorempIds" id="SupervisorempIds<?php echo $i ?>" value="<?php echo isset($detail['superiorAllDetails'][$i]['EMP_ID'])?$detail['superiorAllDetails'][$i]['EMP_ID']:''?>">
                                                </div>
                                                 </td>   
                                          </div>
                                                                                                                       
                                          <div class="col-md-3">
                                             <td>
                                                <label>Name <?php echo REQUIRED; ?></label>
                                                <div>
                                                    <input type = "text" alt="<?php echo $i;?>" minlength="2" maxlength="50"  name= "superiorDatas[<?php echo $i ?>][supEmployeeName]" class="form-control SupervisorempName" id="SupervisorempName<?php echo $i ?>" value="<?php echo isset($detail['superiorAllDetails'][$i]['NAME'])?$detail['superiorAllDetails'][$i]['NAME']:''?>">
                                                </div>
                                                </td>
                                          </div>
                                          
                                          <div class="col-md-3">
                                             <td>
                                                <label>Phone <?php echo REQUIRED; ?></label>
                                                <div>
                                                    <input type = "text" name= "superiorDatas[<?php echo $i ?>][mobile]" class="form-control mobile" maxlength="16" minlength="10"  id="mobile<?php echo $i ?>" value="<?php echo isset($detail['superiorAllDetails'][$i]['PHONE'])?$detail['superiorAllDetails'][$i]['PHONE']:''?>">
                                                </div>
                                             </td>
                                          </div>

                                          <div class="col-md-3">
                                             <td>
                                                <label>Present <?php echo REQUIRED; ?></label>
                                                <div>
                                                   <div class="form-check-inline">
                                                      <input class="form-check-input" type="radio" id="idsuperiorPresentY" name="superiorDatas[<?php echo $i ?>][present]"value="Y"<?php if(isset($detail['superiorAllDetails'][$i]['PRESENT'])){echo $detail['superiorAllDetails'][$i]['PRESENT']=='Y'?'checked':'';}?> >
                                                      <label class="form-check-label" for="idsuperiorPresentY">
                                                      Yes
                                                      </label>
                                                   </div>
                                                   <div class="form-check-inline">
                                                      <input class="form-check-input" type="radio" id="idsuperiorPresentN" name="superiorDatas[<?php echo $i ?>][present]" value="N"<?php if(isset($detail['superiorAllDetails'][$i]['PRESENT'])){echo $detail['superiorAllDetails'][$i]['PRESENT']=='N'?'checked':'';}?> >
                                                      <label class="form-check-label" for="idsuperiorPresentN">
                                                      No
                                                      </label>
                                                   </div>
                                                </div>
                                                 <span class="error" id="hasChecklist_error"></span>
                                             </td>
                                            
                                          </div>
                                            
                                                  <?php 
                                                  if($i==0){ ?>
                                                     
                                               <div class="col-md-3">
                                                  <td><?php echo "  -  " ; ?></td>
                                              
                                               </div>
                                              
                                                <?php  }else{?>
                                              
                                               <div class="col-md-3">
                                                <td> <button type="button" class="fa fa-trash delete" alt="<?php echo $i ?>" attr_tblid = "INCIDENT_SUP_ID" attr="<?php echo $detail['superiorAllDetails'][$i]['INCIDENT_SUP_ID'];?>" attr_table = "INCIDENT_SUPERVISOR_SUPERIOR_DETAIL" id="delete" attr_status ="SUP_STATUS" title="Delete file"></button>
                                               </td>
                                               </div>
                                             
                                          <?php }  ?>
                                              

                                          <input class="form-control INCIDENT_SUP_ID" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['superiorAllDetails'][$i])?$detail['superiorAllDetails'][$i]['INCIDENT_SUP_ID']:"")?>" alt="<?php echo $i;?>"  name="superiorDatas[<?php echo $i ?>][INCIDENT_SUP_ID]" id="INCIDENT_SUP_ID<?php echo $i ?>" />
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
                                 <div class="btn btn-warning btn-sm addInvestigationDet">Add</div>
                              </span>
                           </a>
                        </div>
                        <div id="section_3" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row InvestigationInfo">
                                 <table class="table table-bordered InvestigationTable">
                                   
                                       
                                          <?php  

                                           $n = (isset($detail['investigationAllDetails'])&&count($detail['investigationAllDetails']))?count($detail['investigationAllDetails']):1;
                                             for($i=0;$i<$n;$i++){ ?>
                                                 <tr id="Rowperson<?php echo $i ?>">
 
                                         <div class="col-md-3">
                                          <td>
                                             <label>Employee name <?php echo REQUIRED; ?></label>
                                             <div>
                                                <select class="form-control invesEmployeeName select2" alt="<?php echo $i; ?>" name="invesEmployeeInform[<?php echo $i?>][employeeInvesName]">
                                                   <option value="">Select - Emp </option>
                                                   <?php 
                                                      foreach($employeeNameDetails as $em){
                                                         ?>
                                                   <option value="<?php echo $em['EMP_AUTO_ID']?>" <?php echo (isset($detail['investigationAllDetails'][$i])&&$detail['investigationAllDetails'][$i]['EMPLOYEE_ID']==$em['EMP_AUTO_ID'])?"selected":''?>><?php echo $em['EMP_NAME']?></option>
                                                   <?php } ?>
                                                </select>
                                             </div>
                                          </td>
                                       </div>
                                       <div class="col-md-3">
                                          <td>
                                             <label>Employee ID <?php echo REQUIRED; ?></label>
                                             <div>
                                                <input type = "text" alt="<?php echo $i;?>" name= "invesEmployeeInform[<?php echo $i ?>][invesEmployeeid]" class="form-control InvesEmployeeId" id="InvesEmployeeId<?php echo $i ?>" value="<?php echo (isset($detail['investigationAllDetails'][$i])?$detail['investigationAllDetails'][$i]['EMP_ID']:"")?>" readonly>
                                             </div>
                                          </td>
                                       </div>
                                       <div class="col-md-3">
                                          <td>
                                             <label>Designation <?php echo REQUIRED; ?></label>
                                             <div>
                                                <input type = "text" alt="<?php echo $i;?>" name= "invesEmployeeInform[<?php echo $i ?>][invesDesignation]" class="form-control invesDesignation" id="invesDesignation<?php echo $i ?>" value="<?php echo (isset($detail['investigationAllDetails'][$i])?$detail['investigationAllDetails'][$i]['DESIGNATION_NAME']:"")?>" readonly>

                                                <input type = "hidden" alt="<?php echo $i;?>" name= "invesEmployeeInform[<?php echo $i ?>][invesDesignationId]" class="form-control invesDesignationId" id="invesDesignationId<?php echo $i ?>" value="<?php echo (isset($detail['investigationAllDetails'][$i])?$detail['investigationAllDetails'][$i]['DESIGNATION_ID']:"")?> " readonly>
                                             </div>
                                          </td>
                                       </div>
                                       <div class="col-md-3">
                                          <td>
                                             <label>Phone No<?php echo REQUIRED; ?></label>
                                             <div>
                                                <input type = "text" alt="<?php echo $i; ?>" name= "invesEmployeeInform[<?php echo $i ?>][empMobile]" maxlength="16" minlength="10" class="form-control empMobile" id="empMobile<?php echo $i ?>" value="<?php echo isset($detail['investigationAllDetails'][$i]['PHONE_NO'])?$detail['investigationAllDetails'][$i]['PHONE_NO']:''?>">
                                             </div>
                                             </td>
                                       </div>

                                             <?php 
                                                  if($i==0){ ?>
                                                     
                                               <div class="col-md-3">
                                                  <td><?php echo "  -  " ; ?></td>
                                              
                                               </div>
                                              
                                                <?php  }else{?>
                                              
                                               <div class="col-md-3">
                                                <td> <button type="button" class="fa fa-trash delete" alt="<?php echo $i ?>" attr_tblid = "INC_INVESTIGATION_TEAM_ID" attr="<?php echo $detail['investigationAllDetails'][$i]['INC_INVESTIGATION_TEAM_ID'];?>" attr_table = "INCIDENT_INVESTIGATION_TEAM" attr_status ="INVESTIGATION_TEAM_STATUS" id="delete" title="Delete file"></button>
                                               </td>
                                               </div>
                                             
                                          <?php }  ?>
                                             

                                          
                                        <input class="form-control INC_INVESTIGATION_TEAM_ID" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['investigationAllDetails'][$i])?$detail['investigationAllDetails'][$i]['INC_INVESTIGATION_TEAM_ID']:"")?>" alt="<?php echo $i;?>"  name="invesEmployeeInform[<?php echo $i ?>][INC_INVESTIGATION_TEAM_ID]" id="INC_INVESTIGATION_TEAM_ID<?php echo $i ?>" >

                                     </tr>
                                        <?php } ?>
                                   
                                 </table>
                              </div>
                               <div class="col-md-12">
                                          <td>
                                             <label>Investigation summary</label>
                                             <?php if($detail['incidentTeamSummary']['INVESTIGATION_TEAM_SUMMARY'] !=''){ ?>
                                             <div>
                                                 <?php if($detail['incidentTeamSummary']['FILE_NAME'] !='' && $detail['incidentTeamSummary']['FILE_PATH'] !=''){
                                                    
                                                    //echo 1;exit; ?>
                                                 <textarea  class="form-control innvesticationSum"  name="innvesticationSum" id="innvesticationSum"><img style="width: 200px; height: 150px;" id="docfileuploadincidentTeam" class= "docfileupload" src="<?php echo base_url().$detail['incidentTeamSummary']['FILE_PATH'].'/'.$detail['incidentTeamSummary']['FILE_NAME']?>"></textarea>
                                                 <input type="hidden" class="FILE_NAME" name="innvesticationSumFILE_NAME" value="<?php echo isset($detail['incidentTeamSummary']['FILE_NAME'])?$detail['incidentTeamSummary']['FILE_NAME']:''?>">
                                                 <input type="hidden" class="FILE_PATH" name="innvesticationSumFILE_PATH" value="<?php echo isset($detail['incidentTeamSummary']['FILE_PATH'])?$detail['incidentTeamSummary']['FILE_PATH']:''?>">
                                                    <a href="javascript:;" class="removeSummRy"><i class="fa fa-remove"></i>&nbsp;Remove File</a>
                                                     
                                                     <?php } else {  
                                                    //echo 2;exit;?>
                                               <textarea  class="form-control innvesticationSum" style="width: 200px; height: 150px;"  name="innvesticationSum" id="innvesticationSum"><?php echo isset($detail['incidentTeamSummary']['INVESTIGATION_TEAM_SUMMARY'])?$detail['incidentTeamSummary']['INVESTIGATION_TEAM_SUMMARY']:''?></textarea>
                                               <a href="javascript:;" class="removeSumm d-none"><i class="fa fa-remove"></i>&nbsp;Remove File</a> 

                                                <?php } ?>
                                               

                                             </div>
                                             <?php } else{ ?>
                                               <textarea  class="form-control innvesticationSum" style="width: 200px; height: 150px;"  name="innvesticationSum" id="innvesticationSum"><?php echo isset($detail['incidentTeamSummary']['INVESTIGATION_TEAM_SUMMARY'])?$detail['incidentTeamSummary']['INVESTIGATION_TEAM_SUMMARY']:''?></textarea>
                                                <a href="javascript:;" class="removeSumm d-none"><i class="fa fa-remove"></i>&nbsp;Remove File</a> 

                                                 <?php  } ?>
                                             
                                             
                                          </td>
                                         
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
                                 <div class="col-md-3">
                                    <label>Employee ID</label>
                                    <div>
                                       <?php
                                          $data = [
                                              'name' => 'employeeId',
                                              'id' => 'employeeId',
                                              'class' => 'form-control',
                                              'value' => $empIdGets['USERNAME'],
                                              'readonly' =>'readonly'
                                          ];
                                          echo form_input($data);
                                          ?>                   
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <label>Name</label>
                                    <?php
                                       $data = [
                                       'name' => 'empName',
                                       'id' => 'empName',
                                       'class' => 'form-control',
                                       'value' => $reportedName,
                                       'readonly' =>'readonly'
                                       ];
                                       echo form_input($data);
                                       ?>
                                 </div>
                                 <div class="col-md-3">
                                    <label>Designation</label>
                                    <?php
                                       $data = [
                                       'name' => 'designation',
                                       'id' => 'designation',
                                       'class' => 'form-control',
                                       'value' => $reportedDesignation,
                                       'readonly' =>'readonly'
                                       ];
                                       echo form_input($data);
                                       ?>
                                 </div>
                                 <div class="col-md-3">
                                    <label>Phone no</label>
                                    <?php
                                       $data = [
                                       'name' => 'empPhnNo',
                                       'id' => 'empPhnNo',
                                       'class' => 'form-control employeePhones',
                                       'value' => $employeephnNoo,
                                       'readonly' =>'readonly'
                                       ];
                                       echo form_input($data);
                                       ?>
                                 </div>
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
                                 <div class="col-md-3">
                                    <label></label>
                                    <div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" id="idauthorityzY" value="Y"<?php if(isset($detail['IncidentInvestigationData']['INC_AUTHORITY_INVOLVED'])){echo $detail['IncidentInvestigationData']['INC_AUTHORITY_INVOLVED']=='Y'?'checked':'';}?> name="authorityInvol" >
                                          <label class="form-check-label" for="idauthorityzY"  >
                                          Yes
                                          </label>
                                       </div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" id="idauthorityzN" value="N"<?php if(isset($detail['IncidentInvestigationData']['INC_AUTHORITY_INVOLVED'])){echo $detail['IncidentInvestigationData']['INC_AUTHORITY_INVOLVED']=='N'?'checked':'';}?> name="authorityInvol">
                                          <label class="form-check-label" for="idauthorityzN"  >
                                          No
                                          </label>
                                       </div>
                                       <span class="error idtype1error"></span>  
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-3 authorityInvolvedHide d-none">
                                 <label></label>
                                 <div>
                                   
                                        <input class="form-control authorityInvolved" type="text"  value="<?php echo (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['AUTHORITY_INVOLVED_DETAIL']:"")?>" alt="<?php echo $i;?>"  name="authorityInvolved" id="authorityInvolved" >  
                                 </div>
                              </div>
                               
                           </div>
                        </div>
                     </div>



                     <div class="card ">
                           <div class="card-header ">
                              <a class="card-link " href="javascript:void(0)" >
                                 6. Injured Person (IP) Details (provide the details of all IPs involved)
                                 <span class="float-right">
                                    <div class="btn btn-warning btn-sm addInjuredDet">Add</div>
                                 </span>
                              </a>
                           </div>
                           <div id="section_6" class="collapse multi-collapse show" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="col-md-3">
                                    <label>Are there any person(s)injured?<?php echo REQUIRED; ?></label>
                                    <div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" id="idInjuredY" name="InjuredPer" value="Y"<?php if(isset($detail['IncidentInvestigationData']['INJURED_PERSON'])){echo $detail['IncidentInvestigationData']['INJURED_PERSON']=='Y'?'checked':'';}?> >
                                          <label class="form-check-label" for="idauthorityzY">
                                          Yes
                                          </label>
                                       </div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" id="idInjuredN" name="InjuredPer" value="N"<?php if(isset($detail['IncidentInvestigationData']['INJURED_PERSON'])){echo $detail['IncidentInvestigationData']['INJURED_PERSON']=='N'?'checked':'';}?> >
                                          <label class="form-check-label" for="idauthorityzN">
                                          No
                                          </label>
                                       </div>
                                       <span class="error idtype1error"></span>  
                                    </div>
                                    <span class="error" id="InjuredPer_error"></span>
                                 </div>

                                 <div class="col-md-13 InjuredPersonHide d-none">
                                 <div class="row injuredInfo">
                                    <table class="table table-bordered injuredTable">
                                       
                                               
                                              
                                               <?php $n = (isset($detail['injuredAllDetails'])&&count($detail['injuredAllDetails']))?count($detail['injuredAllDetails']):1;
                                                for($i=0;$i<$n;$i++){   
                                                             ?> 
                                                <tbody id="UniqkIdForRw<?php echo $i; ?>">

                                               
                                       
                                                             <tr id="RowInjures<?php echo $i ?>">
                                           
                                             <td>
                                                <label>Name <?php echo REQUIRED; ?></label>
                                                <div>
                                                   <input type = "text" alt="<?php echo $i;?>" name= "injuredDatas[<?php echo $i ?>][injuredEmpName]" class="form-control injuredEmpName" maxlength ="50" id="injuredEmpName<?php echo $i ?>" value="<?php echo isset($detail['injuredAllDetails'][$i]['PERSON_NAME'])?$detail['injuredAllDetails'][$i]['PERSON_NAME']:''?>">
                                                </div>
                                                </td>    
                                          
                                                                                                                       
                                                <td>
                                                <label>Sex <?php echo REQUIRED; ?></label>
                                                <div>
                                                   <div class="form-check-inline">
                                                      <input class="form-check-input" alt="<?php echo $i;?>"  type="radio" id="idInjuredMale<?php echo $i; ?>" name="injuredDatas[<?php echo $i ?>][injuredGen]" value="M"<?php if(isset($detail['injuredAllDetails'][$i]['SEX'])){echo $detail['injuredAllDetails'][$i]['SEX']=='M'?'checked':'';}?> >
                                                      <label class="form-check-label" for="idInjuredMale">
                                                      Male
                                                      </label>
                                                   </div>
                                                   <div class="form-check-inline">
                                                      <input class="form-check-input" alt="<?php echo $i;?>" type="radio" id="idInjuredFemale<?php echo $i; ?>" name="injuredDatas[<?php echo $i ?>][injuredGen]" value="F"<?php if(isset($detail['injuredAllDetails'][$i]['SEX'])){echo $detail['injuredAllDetails'][$i]['SEX']=='F'?'checked':'';}?> >
                                                      <label class="form-check-label" for="idInjuredFemale">
                                                      Female
                                                      </label>
                                                   </div>
                                                   <span class="error idtype1error"></span>  
                                                </div>
                                             </td>
                                          

                                         
                                             <td>
                                                <label>Age <?php echo REQUIRED; ?></label>
                                                <div>
                                                   <input type = "text" minlength="1" alt="<?php echo $i;?>" maxlength="3"name= "injuredDatas[<?php echo $i ?>][age]" class="form-control age" id="age<?php echo $i ?>" value="<?php echo isset($detail['injuredAllDetails'][$i]['AGE'])?$detail['injuredAllDetails'][$i]['AGE']:''?>">
                                                </div>
                                             </td>
                                         

                                             <td> 
                                                <label>Job Title <?php echo REQUIRED; ?></label>
                                                <div>
                                                   <input type = "text" alt="<?php echo $i;?>" name= "injuredDatas[<?php echo $i ?>][jobTitle]" class="form-control jobTitle" id="jobTitle<?php echo $i ?>" value="<?php echo isset($detail['injuredAllDetails'][$i]['JOB_TITLE'])?$detail['injuredAllDetails'][$i]['JOB_TITLE']:''?>">
                                                </div>
                                             </td>
                                          

                                          
                                             <td>
                                                <label>Citizenship <?php echo REQUIRED; ?></label> 
                                                <div>
                                                   <input type = "text" alt="<?php echo $i;?>" name= "injuredDatas[<?php echo $i ?>][citizenship]" class="form-control citizenship" id="citizenship<?php echo $i ?>" value="<?php echo isset($detail['injuredAllDetails'][$i]['CITIZENSHIP'])?$detail['injuredAllDetails'][$i]['CITIZENSHIP']:''?>">
                                                </div>
                                             </td>
                                          
                                       </tr>
                                       <tr id="RowInjures<?php echo $i ?>">
                                          
                                          
                                             <td> 
                                                <label>ID type <?php echo REQUIRED; ?></label>
                                                <div>
                                                   <select class="form-control injuredIdType" alt="<?php echo $i;?>" name="injuredDatas[<?php echo $i?>][injuredIdType]">
                                                      <option value="">Select - Id type </option>
                                                      <option value="IC" <?php echo (isset($detail['injuredAllDetails'][$i])&&$detail['injuredAllDetails'][$i]['ID_TYPE']=="IC")?"selected":''?>>IC</option>
                                                      <option value="PASSPORT" <?php echo (isset($detail['injuredAllDetails'][$i])&&$detail['injuredAllDetails'][$i]['ID_TYPE']=="PASSPORT")?"selected":''?>>Passport</option>
                                                   </select>
                                                </div>
                                             </td>
                                         

                                          
                                             <td id="testsInjur">
                                                <label>IC Passport No <?php echo REQUIRED; ?></label>
                                                    <input type = "text" alt="<?php echo $i;?>"  name= "injuredDatas[<?php echo $i ?>][passportNo]" class="form-control passportNo" maxlength="15" id="passportNo<?php echo $i ?>" value="<?php echo isset($detail['injuredAllDetails'][$i]['IC_PASSPORT_NO'])?$detail['injuredAllDetails'][$i]['IC_PASSPORT_NO']:''?>">
                                             </td>
                                          

                                         
                                             <td>
                                                <label>Contractor/Company Name </label>
                                                <div> 
                                                   <input type = "text" alt="<?php echo $i;?>" maxlength="100" name= "injuredDatas[<?php echo $i ?>][injuredCompanyName]" class="form-control injuredCompanyName" id="injuredCompanyName<?php echo $i ?>" value="<?php echo isset($detail['injuredAllDetails'][$i]['CONT_COMPANY_NAME'])?$detail['injuredAllDetails'][$i]['CONT_COMPANY_NAME']:''?>">
                                                </div>
                                             </td>
                                          

                                          
                                             <td>
                                                <label>Injury Type <?php echo REQUIRED; ?></label>
                                                <div>
                                                   <input type = "text" alt="<?php echo $i;?>" maxlength="50" name= "injuredDatas[<?php echo $i ?>][InjuryType]" class="form-control InjuryType" id="InjuryType<?php echo $i ?>" value="<?php echo isset($detail['injuredAllDetails'][$i]['INJURY_TYPE'])?$detail['injuredAllDetails'][$i]['INJURY_TYPE']:''?>">
                                                </div>
                                             </td>
                                          </div>

                                          
                                             <td>
                                                <label>Body part effected <?php echo REQUIRED; ?></label>
                                                <div>
                                                 <input type = "text" alt="<?php echo $i;?>"  name= "injuredDatas[<?php echo $i ?>][bodyPart]" class="form-control bodyPart" id="bodyPart<?php echo $i ?>" value="<?php echo isset($detail['injuredAllDetails'][$i]['BODY_PART_ID'])?$detail['injuredAllDetails'][$i]['BODY_PART_ID']:''?>">
                                            </td>
                                         
                                          <tr> 
                                        <tr id="RowInjures<?php echo $i ?>">
                                            
                                         
                                           
                                            <td colspan="4">
                                                <label>Sub Body Part <?php echo REQUIRED; ?></label>
                                                <div >
                                                <input type = "text" alt="<?php echo $i;?>"  name= "injuredDatas[<?php echo $i ?>][SubbodyPart]"" class="form-control SubbodyPart" id="SubbodyPart<?php echo $i ?>" value="<?php echo isset($detail['injuredAllDetails'][$i]['SUB_ID'])?$detail['injuredAllDetails'][$i]['SUB_ID']:''?>">

                                                </td>
                                                    
                                                   
                                              <input type ="hidden" id="SubbodyPartids<?php echo $i; ?>" value="<?php echo isset($detail['injuredAllDetailsBody'][$i]['SUB_ID'])?$detail['injuredAllDetailsBody'][$i]['SUB_ID']:''?>">
                                             <input class="form-control  INC_INVEST_INJURED_PERSON_INFO_ID" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['injuredAllDetails'][$i])?$detail['injuredAllDetails'][$i]['INC_INVEST_INJURED_PERSON_INFO_ID']:"")?>" alt="<?php echo $i;?>"  name="injuredDatas[<?php echo $i ?>][INC_INVEST_INJURED_PERSON_INFO_ID]" id="INC_INVEST_INJURED_PERSON_INFO_ID<?php echo $i ?>" >
                                                                                               <input class="form-control INVEST_INJURED_PERSON_STATUS" type="hidden"  value="" name="injuredDatas[<?php echo $i ?>][INVEST_INJURED_PERSON_STATUS]" id="INVEST_INJURED_PERSON_STATUS" />

                                                
                                              
                                               <?php 
                                                  if($i==0){ ?>
                                                     
                                               <div class="col-md-3">
                                                  <td><?php echo "  -  " ; ?></td>
                                              
                                               </div>
                                              
                                                <?php  }else{?>
                                              
                                               <div class="col-md-3">
                                                <td><button type="button" class="fa fa-trash delete" alt="<?php echo $i ?>" attr_tblid = "INC_INVEST_INJURED_PERSON_INFO_ID" attr="<?php echo $detail['injuredAllDetails'][$i]['INC_INVEST_INJURED_PERSON_INFO_ID'];?>" attr_table = "INCIDENT_INVEST_INJURED_PERSON_INFO" attr_status ="INVEST_INJURED_PERSON_STATUS" id="delete" title="Delete file"></button>
                                                </td>
                                             </div>
                                             </div>
                                              </tr>
                                                                             <input class="form-control  INC_INVEST_INJURED_PERSON_INFO_ID" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['injuredAllDetails'][$i])?$detail['injuredAllDetails'][$i]['INC_INVEST_INJURED_PERSON_INFO_ID']:"")?>" alt="<?php echo $i;?>"  name="injuredDatas[<?php echo $i ?>][INC_INVEST_INJURED_PERSON_INFO_ID]" id="INC_INVEST_INJURED_PERSON_INFO_ID<?php echo $i ?>" >
                                              <input class="form-control INVEST_INJURED_PERSON_STATUS" type="hidden"  value="" name="injuredDatas[<?php echo $i ?>][INVEST_INJURED_PERSON_STATUS]" id="INVEST_INJURED_PERSON_STATUS" />

                                             </tbody> 
                                               
                                              
                                             
                                 <?php }  ?>     

                                          <?php } ?>
                                
                                              
                                 </table>
                              </div>
                          </div>
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
                                 <div class="col-md-12">
                                    <?php
                                       $data = array(
                                           'name' => 'description',
                                           'id' => 'description',
                                           'class' => 'form-control',
                                           'rows' => '2',
                                           'cols' => '40',
                                           'value' => $descriptionForCompentency,
                                         );
                                       echo form_textarea($data);
                                       ?> 
                                   
                                  
                                 </div>
                                
                              </div>
                           </div>
                        </div>
                     </div>



                     <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           8. Asset Details (Provide the details of all assets involved)<span class="float-right">
                                    <div class="btn btn-warning btn-sm addAssetDet">Add</div>
                                 </span>
                           </a>
                        </div>
                        <div id="section_8" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-3">
                                    <label></label>
                                    <div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" id="idassetDetailsY" name="assetDetails" value="Y"<?php if(isset($detail['injuredAssetStatus']['ASSET_DETAIL_STATUS'])){echo $detail['injuredAssetStatus']['ASSET_DETAIL_STATUS']=='Y'?'checked':'';}?> >
                                          <label class="form-check-label" for="idassetDetailsY">
                                          Yes
                                          </label>
                                       </div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio"  id="idassetDetailsN" name="assetDetails" value="N"<?php if(isset($detail['injuredAssetStatus']['ASSET_DETAIL_STATUS'])){echo $detail['injuredAssetStatus']['ASSET_DETAIL_STATUS']=='N'?'checked':'';}?>>
                                          <label class="form-check-label" for="idassetDetailsN">
                                          No
                                          </label>
                                       </div>
                                       <span class="error idtype1error"></span>  
                                    </div>
                                    <span class="error" id="assetDetail_error"></span>
                                 </div>

                                  <div class="col-md-13 AssetDetailsHide d-none">
                                 <div class="row AssetInfo">
                                    <table class="table table-bordered AssetTable">
                                       
                                          
                                             <?php $n = (isset($detail['AssetAllDetails'])&&count($detail['AssetAllDetails']))?count($detail['AssetAllDetails']):1;
                                                for($i=0;$i<$n;$i++){   
                                                             ?> 
                                        <tbody id="uniqAsstId<?php echo $i; ?>">
                                        
                                                             <tr id="RowAsset<?php echo $i ?>">
                                          <td>
                                                <label>Estimated Cost of Damage <?php echo REQUIRED; ?></label>
                                                <div>
                                                  <input type = "text" alt="<?php echo $i;?>" maxlength="50" name= "assetDatas[<?php echo $i ?>][assetEstimate]" class="form-control assetEstimate" id="assetEstimate<?php echo $i ?>" value="<?php echo isset($detail['AssetAllDetails'][$i]['EST_COST_OF_DAMAGE'])?$detail['AssetAllDetails'][$i]['EST_COST_OF_DAMAGE']:''?>">
                                                </div>
                                                </td>    
                                            
                                         
                                             <td id="tesingss">
                                                <label>Name of Operator/ Driver /Vessel Master <?php echo REQUIRED; ?></label>
                                                <div><br>
                                                  <input type = "text" alt="<?php echo $i;?>" name= "assetDatas[<?php echo $i ?>][assetNameOfOperator]" class="form-control assetNameOfOperator" id="assetNameOfOperator<?php echo $i ?>" value="<?php echo isset($detail['AssetAllDetails'][$i]['NAME_OF_OPERATOR_DRIVER_MASTER'])?$detail['AssetAllDetails'][$i]['NAME_OF_OPERATOR_DRIVER_MASTER']:''?>">
                                                </div>
                                                </td>    
                                        

                                        
                                             <td>
                                                <label>Phone No <?php echo REQUIRED; ?></label>
                                                <div><br>
                                                  <input type = "text" alt="<?php echo $i;?>"  maximum="16" minimum ="16"  name= "assetDatas[<?php echo $i ?>][assetPhone]" maxlength="16" minlength="10" class="form-control assetPhone" id="assetPhone<?php echo $i ?>" value="<?php echo isset($detail['AssetAllDetails'][$i]['PHONE_NO'])?$detail['AssetAllDetails'][$i]['PHONE_NO']:''?>">
                                                </div>
                                                </td>    
                                          
                                             <td>
                                                <label class="OwnerClass">Owner/Company Name <?php echo REQUIRED; ?></label>
                                                <br><br>
                                                  <input type = "text" alt="<?php echo $i;?>" maxlength="100" name= "assetDatas[<?php echo $i ?>][assetOwner]" class="form-control assetOwner" id="assetOwner<?php echo $i ?>" value="<?php echo isset($detail['AssetAllDetails'][$i]['OWNER_COMP_NAME'])?$detail['AssetAllDetails'][$i]['OWNER_COMP_NAME']:''?>">
                                                
                                                </td>    
                                          
                                              <td>
                                                <label>Plate No <?php echo REQUIRED; ?></label>
                                                <div><br>
                                                  <input type = "text" alt="<?php echo $i;?>" maxlength="20" name= "assetDatas[<?php echo $i ?>][assetPlate]" class="form-control assetPlate" id="assetPlate<?php echo $i ?>" value="<?php echo isset($detail['AssetAllDetails'][$i]['PLATE_NO'])?$detail['AssetAllDetails'][$i]['PLATE_NO']:''?>">
                                                </div>
                                                </td>    
                                          
                                          </tr> 
                                             <tr id="RowAsset<?php echo $i ?>">
                                                
                                                   <td colspan="4"> 
                                                <label>Description <?php echo REQUIRED; ?></label>
                                                <div>
                                                   <textarea class="form-control assetDescription" name="assetDatas[<?php echo $i ?>][assetDescription]" id="assetDescription<?php echo $i ?>"><?php echo isset($detail['AssetAllDetails'][$i]['DESCRIPTION'])?$detail['AssetAllDetails'][$i]['DESCRIPTION']:''?></textarea>
                                                </div>
                                                </td> 
                                                
                                         


                                           
                                            
                                                <?php 
                                                  if($i==0){ ?>
                                                     
                                              
                                                  <td><?php echo "  -  " ; ?></td>
                                              
                                              
                                              
                                                <?php  }else{?>
                                              
                                            
                                                <td> <button type="button" class="fa fa-trash delete" alt="<?php echo $i ?>" attr_tblid = "INC_ASSET_DETAIL_ID" attr="<?php echo $detail['AssetAllDetails'][$i]['INC_ASSET_DETAIL_ID'];?>" attr_table = "INCIDENT_INVEST_ASSET_DETAIL" id="delete" attr_status="ASSET_DETAIL_STATUS" title="Delete file"></button>
                                               </td>
                                              
                                             
                                          <?php }  ?>
                                             

                                            

                                           <input class="form-control INC_ASSET_DETAIL_ID" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['AssetAllDetails'][$i])?$detail['AssetAllDetails'][$i]['INC_ASSET_DETAIL_ID']:"")?>" alt="<?php echo $i;?>"  name="assetDatas[<?php echo $i ?>][INC_ASSET_DETAIL_ID]" id="INC_ASSET_DETAIL_ID<?php echo $i ?>" />

                                           </tr>
                                        
                                        </tbody>

                                            <?php } ?>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>



                   <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                              9. Persons Interviewed
                              <span class="float-right">
                                 <div class="btn btn-warning btn-sm addPersonInter">Add</div>
                              </span>
                           </a>
                        </div>
                        <div id="section_9" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row personInfo">
                                 <table class="table table-bordered personInterTable">
                                    
                                          <?php $n = (isset($detail['personInterviewd'])&&count($detail['personInterviewd']))?count($detail['personInterviewd']):1;
                                             for($i=0;$i<$n;$i++){   
                                                          ?>  
                                                          <tr id="RowInterView<?php echo $i ?>">
                                           <div class="col-md-3">
                                          <td>
                                             <label>Employee ID <?php echo REQUIRED; ?></label>
                                             <div>
                                                <input type = "text" alt="<?php echo $i;?>" name= "personDatas[<?php echo $i ?>][perEmployeeId]" class="form-control personEmpIds" id="personEmpIds<?php echo $i ?>" value="<?php echo isset($detail['personInterviewd'][$i]['EMP_ID'])?$detail['personInterviewd'][$i]['EMP_ID']:''?>">
                                             </div>
                                             </td>
                                       </div>
                                                                                                                          
                                       <div class="col-md-3">
                                          <td>
                                             <label>Name <?php echo REQUIRED; ?></label>
                                             <div>
                                                <input type = "text" name= "personDatas[<?php echo $i ?>][perEmployeeName]" class="form-control personName" id="personName<?php echo $i ?>" value="<?php echo isset($detail['personInterviewd'][$i]['EMP_NAME'])?$detail['personInterviewd'][$i]['EMP_NAME']:''?>">
                                             </div>
                                              </td>
                                       </div>
                                      
                                       <div class="col-md-3">
                                          <td>
                                             <label>Job Title <?php echo REQUIRED; ?></label>
                                             <div>
                                                <input type = "text" name= "personDatas[<?php echo $i ?>][personJobTitle]" class="form-control perJobTitle" id="perJobTitle<?php echo $i ?>" value="<?php echo isset($detail['personInterviewd'][$i]['JOB_TITLE'])?$detail['personInterviewd'][$i]['JOB_TITLE']:''?>">
                                             </div>
                                          </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label>Phone <?php echo REQUIRED; ?></label>
                                             <div>
                                                 <input type = "text" maxlength="16" minlength="10" name= "personDatas[<?php echo $i ?>][personMobile]" class="form-control perMobile" id="perMobile<?php echo $i ?>" value="<?php echo isset($detail['personInterviewd'][$i]['PHONE'])?$detail['personInterviewd'][$i]['PHONE']:''?>">
                                             </div>
                                         
                                           </td>
                                       </div>

                                                  <?php 
                                                  if($i==0){ ?>
                                                     
                                               <div class="col-md-3">
                                                  <td><?php echo "  -  " ; ?></td>
                                              
                                               </div>
                                              
                                                <?php  }else{?>
                                              
                                               <div class="col-md-3">
                                                <td> <button type="button" class="fa fa-trash delete" alt="<?php echo $i ?>" attr_tblid = "INVEST_INTERVIEWED_DETAIL_ID" attr="<?php echo $detail['personInterviewd'][$i]['INVEST_INTERVIEWED_DETAIL_ID'];?>" attr_table = "INCIDENT_INVEST_INTERVIEWED_DETAIL" id="delete" attr_status="INTERVIEWED_DETAIL_STATUS" title="Delete file"></button>
                                               </td>
                                               </div>
                                             
                                          <?php }  ?>
                                              

                                          <input class="form-control INVEST_INTERVIEWED_DETAIL_ID" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['personInterviewd'][$i])?$detail['personInterviewd'][$i]['INVEST_INTERVIEWED_DETAIL_ID']:"")?>" alt="<?php echo $i;?>"  name="personDatas[<?php echo $i ?>][INVEST_INTERVIEWED_DETAIL_ID]" id="INVEST_INTERVIEWED_DETAIL_ID<?php echo $i ?>" />
                                          </tr>





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
                              10. Circumstances
                              <span class="float-right">
                                 <div class="btn btn-warning btn-sm addCircumstance">Add</div>
                              </span>
                           </a>
                        </div>
                        <div id="section_9" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row circumstanceInfo">
                                 <table class="table table-bordered circumstanceTable">
                                          <?php
                                         // echo 'Mahi<pre>';print_r($detail['circumstanceDetails'][0]['CIRCUMSTANCE_DESC']);exit;

                                                       $j = 1;                                                             

                                           $n = (isset($detail['circumstanceDetails'])&&count($detail['circumstanceDetails']))?count($detail['circumstanceDetails']):1;
                                             for($i=0;$i<$n;$i++){ 
                                                if($i == 0){ ?>


                                                <tr id="RowCircumstance<?php echo $i ?>">
                                           <div class="col-md-3">
                                               <td></td>
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrOne"  name="circumstanceDatas[<?php echo $i ?>][circumDescrOne]" id="circumDescrOne<?php echo $i ?>">
                                                  <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC']:''?>
                                               </textarea>
                                                

                                              
                                             </div>
                                             </td>
                                           </div>
                                      

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-right" style="font-size: 2em;"></i>
                                             </div>
                                             </td> 
                                       </div>
                                                                                                                          
                                      <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrTwo" name="circumstanceDatas[<?php echo $i ?>][circumDescrTwo]" id="circumDescrTwo<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO']:''?></textarea>
                                              
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-right" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>
                                      
                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrThree"  name="circumstanceDatas[<?php echo $i ?>][circumDescrThree]" id="circumDescrThree<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE']:''?></textarea>
                                               
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-right" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>

                                        <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrFour"  name="circumstanceDatas[<?php echo $i ?>][circumDescrFour]" id="circumDescrFour<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR']:''?></textarea>
                                              
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-right" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>

                                        <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrFive"  name="circumstanceDatas[<?php echo $i ?>][circumDescrFive]" id="circumDescrFive<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE']:''?></textarea>
                                              
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-down" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>


                                                <?php 
                                                  if($i==0){ ?>
                                                     
                                               <div class="col-md-3">
                                                  <td><?php echo "  -  " ; ?></td>
                                              
                                               </div>
                                              
                                                <?php  }else{?>
                                              
                                               <div class="col-md-3">
                                                <td> <button type="button" class="fa fa-trash delete" alt="<?php echo $i ?>" attr_tblid = "INC_CIRCUMSTANCE_INFO" attr="<?php echo $detail['circumstanceDetails'][$i]['INC_CIRCUMSTANCE_INFO'];?>" attr_table = "INCIDENT_CIRCUMSTANCE_INFO" id="delete" attr_status ="CIRCUMSTANCE_STATUS" title="Delete file"></button>
                                               </td>
                                               </div>
                                             
                                          <?php }  ?>

                                       <input class="form-control COUNT_COLUMN"  type="hidden"  value="<?php echo $j ?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][COUNT_COLUMN]" id="COUNT_COLUMN<?php echo $i ?>" />


                                          <input class="form-control INC_CIRCUMSTANCE_INFO" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['circumstanceDetails'][$i])?$detail['circumstanceDetails'][$i]['INC_CIRCUMSTANCE_INFO']:"")?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][INC_CIRCUMSTANCE_INFO]" id="INC_CIRCUMSTANCE_INFO<?php echo $i ?>" />

                                               <?php $symbolsArrow = $detail['circumstanceDetails'][$i]['COUNT_COLUMN'];
                                               } else if ( $i % 2 == 0) {
                                              
                                             //for($j=1;$j<$n;$j++){                                                             ?>  
                                                          <tr id="RowCircumstance<?php echo $i ?>">
                                                              
                                           <div class="col-md-3">
                                               <td><i class="fas fa-arrow-right" style="font-size: 2em;"></i></td>
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrOne"  name="circumstanceDatas[<?php echo $i ?>][circumDescrOne]" id="circumDescrOne<?php echo $i ?>">
                                                  <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC']:''?>
                                               </textarea>

                                              
                                             </div>
                                             </td>
                                       </div>

                                        <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-right" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>
                                                                                                                          
                                      <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrTwo"  name="circumstanceDatas[<?php echo $i ?>][circumDescrTwo]" id="circumDescrTwo<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO']:''?></textarea>
                                              
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-right" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>
                                      
                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrThree" name="circumstanceDatas[<?php echo $i ?>][circumDescrThree]" id="circumDescrThree<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE']:''?></textarea>
                                               
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-right" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>

                                        <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrFour" name="circumstanceDatas[<?php echo $i ?>][circumDescrFour]" id="circumDescrFour<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR']:''?></textarea>
                                              
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-right" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>

                                        <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrFive" name="circumstanceDatas[<?php echo $i ?>][circumDescrFive]" id="circumDescrFive<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE']:''?></textarea>
                                              
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-down" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>

                                                <?php 
                                                  if($i==0){ ?>
                                                     
                                               <div class="col-md-3">
                                                  <td><?php echo "  -  " ; ?></td>
                                              
                                               </div>
                                              
                                                <?php  }else{?>
                                              
                                               <div class="col-md-3">
                                                <td> <button type="button" class="fa fa-trash delete" alt="<?php echo $i ?>" attr_tblid = "INC_CIRCUMSTANCE_INFO" attr="<?php echo $detail['circumstanceDetails'][$i]['INC_CIRCUMSTANCE_INFO'];?>" attr_table = "INCIDENT_CIRCUMSTANCE_INFO" id="delete" attr_status ="CIRCUMSTANCE_STATUS" title="Delete file"></button>
                                               </td>
                                               </div>
                                             
                                          <?php }  ?>

                                         <input class="form-control COUNT_COLUMN"  type="hidden"  value="<?php echo $j ?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][COUNT_COLUMN]" id="COUNT_COLUMN<?php echo $i ?>" />
                                              

                                          <input class="form-control INC_CIRCUMSTANCE_INFO" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['circumstanceDetails'][$i])?$detail['circumstanceDetails'][$i]['INC_CIRCUMSTANCE_INFO']:"")?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][INC_CIRCUMSTANCE_INFO]" id="INC_CIRCUMSTANCE_INFO<?php echo $i ?>" />



                                        <?php } else{ ?>
                                          <tr id="RowCircumstance<?php echo $i ?>">
                                           <div class="col-md-3">
                                               <td><i class="fas fa-arrow-down" style="font-size: 2em;"></i></td>
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrOne"  name="circumstanceDatas[<?php echo $i ?>][circumDescrOne]" id="circumDescrOne<?php echo $i ?>">
                                                  <?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC']:''?>
                                               </textarea>

                                              
                                             </div>
                                             </td>
                                       </div>

                                        <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-left" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>
                                                                                                                          
                                      <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrTwo" name="circumstanceDatas[<?php echo $i ?>][circumDescrTwo]" id="circumDescrTwo<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_TWO']:''?></textarea>
                                              
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-left" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>
                                      
                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrThree" name="circumstanceDatas[<?php echo $i ?>][circumDescrThree]" id="circumDescrThree<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_THREE']:''?></textarea>
                                               
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-left" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>

                                        <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrFour" name="circumstanceDatas[<?php echo $i ?>][circumDescrFour]" id="circumDescrFour<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FOUR']:''?></textarea>
                                              
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-left" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>

                                        <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control circumDescrFive"   name="circumstanceDatas[<?php echo $i ?>][circumDescrFive]" id="circumDescrFive<?php echo $i ?>"><?php echo isset($detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE'])?$detail['circumstanceDetails'][$i]['CIRCUMSTANCE_DESC_FIVE']:''?></textarea>
                                              
                                             </div>
                                             </td>
                                       </div>

                                       <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <div>
                                             <i class="fas fa-arrow-left" style="font-size: 2em;"></i>
                                             </div>
                                             </td>
                                       </div>


                                                <?php 
                                                  if($i==0){ ?>
                                                     
                                               <div class="col-md-3">
                                                  <td><?php echo "  -  " ; ?></td>
                                              
                                               </div>
                                              
                                                <?php  }else{?>
                                              
                                               <div class="col-md-3">
                                                <td> <button type="button" class="fa fa-trash delete" alt="<?php echo $i ?>" attr_tblid = "INC_CIRCUMSTANCE_INFO" attr="<?php echo $detail['circumstanceDetails'][$i]['INC_CIRCUMSTANCE_INFO'];?>" attr_table = "INCIDENT_CIRCUMSTANCE_INFO" id="delete" attr_status="CIRCUMSTANCE_STATUS" title="Delete file"></button>
                                               </td>
                                               </div>
                                             
                                          <?php }  ?>

                                       <input class="form-control COUNT_COLUMN"  type="hidden"  value="<?php echo $j ?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][COUNT_COLUMN]" id="COUNT_COLUMN<?php echo $i ?>" />

                                              

                                          <input class="form-control INC_CIRCUMSTANCE_INFO" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['circumstanceDetails'][$i])?$detail['circumstanceDetails'][$i]['INC_CIRCUMSTANCE_INFO']:"")?>" alt="<?php echo $i;?>"  name="circumstanceDatas[<?php echo $i ?>][INC_CIRCUMSTANCE_INFO]" id="INC_CIRCUMSTANCE_INFO<?php echo $i ?>" />

                                          

                                     <?php   } }   $j++;
                                       // } ?>
                                    </tr>
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
                                 <div class="col-md-12">
<textarea  class="form-control immuediateCause" style="width: 200px; height: 150px;"  name="immuediateCause" id="immuediateCause"><?php echo !empty($ImmediateCauseDescrp) ? $ImmediateCauseDescrp:''?></textarea>
                                    
                                 </div>
                                 
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
                                 <div class="col-md-12">
                                    <textarea  class="form-control possibleCause" style="width: 200px; height: 150px;"  name="possibleCause" id="possibleCause"><?php echo !empty($RootCauseOfSummary) ? $RootCauseOfSummary:''?></textarea>
                                 </div>
                                
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
                                 <div class="col-md-12">
                                    <textarea  class="form-control contributingCause" style="width: 200px; height: 150px;"  name="contributingCause" id="contributingCause"><?php echo !empty($ContributingSummary) ? $ContributingSummary:''?></textarea>
                                 </div>
                                
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
                                 <div class="col-md-3">
                                    <?php if(($detail['rootUpload']['FILE_NAME'] !='')){ 

                                                  ?>
                                                        
                                                         <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    
                        <?php  if($detail['rootUpload']['FILE_EXT'] == 'jpg' || $detail['rootUpload']['FILE_EXT'] == 'JPG' || $detail['rootUpload']['FILE_EXT'] == 'JPEG' || $detail['rootUpload']['FILE_EXT'] == 'jpeg' || $detail['rootUpload']['FILE_EXT'] == 'PNG' || $detail['rootUpload']['FILE_EXT'] == 'png'){ ?>
                        <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                    <img class= "docfileupload" src="<?php echo base_url().$detail['rootUpload']['FILE_PATH'].'/'.$detail['rootUpload']['FILE_NAME']?>"></div> <div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
                          <?php  if($userType != "8" && $userType != "9" ){ ?>
                            <span class=" btn btn-sm btn-primary fileinput-new">Upload attachment</span>
                          <?php }
                          ?>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" name="userfile" id="rootCause"  class='docfileupload' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                        <?php } else { ?>
                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                       </div>
                    <div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
                            <span class=" btn btn-sm btn-primary fileinput-new">Upload attachment</span>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" name="userfile" id="rootCause"  class='docfileupload' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div><br><br><br>
                     <?php if(isset($detail['rootUpload']['FILE_NAME'])) { ?>
                    <a target="_blank" class="existing_file" href="<?php echo base_url().$detail['rootUpload']['FILE_PATH'].'/'.$detail['rootUpload']['FILE_NAME']?>"><i class="fa fa-eye"></i>&nbsp;View File</a>&nbsp;&nbsp;
                        <?php } } ?>
                </div>      
            </div>
                                                        
                                                        
                                                        
                                                        
                                      

                                 <?php } else{ ?>
                                             <div>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img class="initialfilerequire" src="https://www.placehold.it/230x140/EFEFEF/AAAAAA&text=no+image" /></div>
                        <div>
                            
                                                                <div style="display: inline-block;float:left;margin-right:20px;">
                                                                    <span class="btn-file" style="display: inline-block;">
                           <span class=" btn btn-sm btn-primary fileinput-new initialfilerequire">Select image</span>
                           <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                           <input type="file" name="userfile" accept="image/*,application/pdf" id="rootCause" class="initialfilerequire">
                            </span>
                                                           
                            <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                         </div>
                                                           <span class="rootCauseAnly"></span>
                        <span class="error idtype1error"></span>
                     </div>
                                    
  </div>
                               <?php }  ?>

                               

                                 <input type="hidden" class="FILE_NAME" name="FILE_NAME" value="<?php echo isset($detail['rootUpload']['FILE_NAME'])?$detail['rootUpload']['FILE_NAME']:''?>">
                                 <input type="hidden" class="FILE_PATH" name="FILE_PATH" value="<?php echo isset($detail['rootUpload']['FILE_PATH'])?$detail['rootUpload']['FILE_PATH']:''?>">
                                 <input type="hidden" name="FILE_SIZE" value="<?php echo isset($detail['rootUpload']['FILE_SIZE'])?$detail['rootUpload']['FILE_SIZE']:''?>">
                                  <input type="hidden" name="FILE_EXT" value="<?php echo isset($detail['rootUpload']['FILE_EXT'])?$detail['rootUpload']['FILE_EXT']:''?>">



                                 <input class="form-control INVEST_ATTACHMENT_IDD" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['rootUpload'])?$detail['rootUpload']['INVEST_ATTACHMENT_ID']:"")?>" alt="<?php echo $i;?>"  name="INVEST_ATTACHMENT_IDD" id="INVEST_ATTACHMENT_IDD<?php echo $i ?>" />
                              </div>
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
                                 <div class="col-md-3">
                                    <label></label>
                                    <div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" value="Y"<?php if(isset($detail['IncidentInvestigationData']['HAZARD_RISK_IDENTIFY'])){echo $detail['IncidentInvestigationData']['HAZARD_RISK_IDENTIFY']=='Y'?'checked':'';}?> id="idhazardIdentyY" name="hazardRisk" >
                                          <label class="form-check-label" for="idhazardIdentyY">
                                          Yes
                                          </label>
                                       </div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" value="N"<?php if(isset($detail['IncidentInvestigationData']['HAZARD_RISK_IDENTIFY'])){echo $detail['IncidentInvestigationData']['HAZARD_RISK_IDENTIFY']=='N'?'checked':'';}?> id="idhazardIdentyN" name="hazardRisk">
                                          <label class="form-check-label" for="idhazardIdentyN">
                                          No
                                          </label>
                                       </div>
                                       <span class="error idtype1error"></span>  
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>






                      <div class="card ">
<div class="card-header ">
<a class="card-link " href="javascript:void(0)" >
16. Action Plan (All action to be transferred to “Incident/Accident Tracking and Recording Register”)
<span class="float-right">
<div class="btn btn-warning btn-sm addActionPlanDet">Add</div>

</span>
</a>
</div>
<div id="section_16" class="collapse multi-collapse show" data-parent="#accordion">
<div class="card-body">
<div class="row ActivePlanInfo">
<table class="table table-bordered ActivePlanTable">


<?php $n = (isset($detail['activePlanAllDetails'])&&count($detail['activePlanAllDetails']))?count($detail['activePlanAllDetails']):1;
for($i=0;$i<$n;$i++){
?>
<tr id="RowActionPlan<?php echo $i ?>">
<div class="col-md-3">
<td>
<label>Corrective / Preventive <?php echo REQUIRED; ?></label>
<div>
<textarea cols="5" rows="2" class="form-control activePreventive" alt="<?php echo $i; ?>" name="activePlanDatas[<?php echo $i ?>][activePreventive]" id="activePreventive<?php echo $i ?>"><?php echo isset($detail['activePlanAllDetails'][$i]['CA_PA_DESC'])?$detail['activePlanAllDetails'][$i]['CA_PA_DESC']:''?></textarea>
</div>
</td>
</div>

<div class="col-md-3">
<td>
<label>Responsibility (by whom?) <?php echo REQUIRED; ?></label>
<div>
<select class="form-control activeResponName" alt="<?php echo $i; ?>" name="activePlanDatas[<?php echo $i?>][activeResponName]">
<option value="">Select - Emp </option>
<?php
foreach($employeeNameDetails as $em){
?>
<option value="<?php echo $em['EMP_AUTO_ID']?>" <?php echo (isset($detail['activePlanAllDetails'][$i])&&$detail['activePlanAllDetails'][$i]['RESPOSIBILITY_ID']==$em['EMP_AUTO_ID'])?"selected":''?>><?php echo $em['EMP_NAME']?></option>
<?php } ?>
</select>
</div>
</td>
</div>

<div class="col-md-3">
<td>
<label>Date by when <?php echo REQUIRED; ?></label>
<input type="text" name="activePlanDatas[<?php echo $i ?>][activeDate]" class="form-control datepick" value="<?php if((isset($detail['activePlanAllDetails'][$i]['DATE_BY_WHEN']))&& (($detail['activePlanAllDetails'][$i]['DATE_BY_WHEN']!=0000-00-00))){echo (isset($detail['activePlanAllDetails'][$i]))?date('d-m-Y',strtotime($detail['activePlanAllDetails'][$i]['DATE_BY_WHEN'])):"";}?>" autocomplete="off"/>
</td>
</div>

<?php
if($i==0){ ?>

<div class="col-md-3">
<td><?php echo " - " ; ?></td>
<td><span title='Disabled'><div class="btn btn-warning btn-sm AtarPageInsert" title = "Enabled" id="AtarPageInsert0" attr_oldcapa = "<?php echo isset($detail['activePlanAllDetails'][$i]['CA_PA_DESC'])?$detail['activePlanAllDetails'][$i]['CA_PA_DESC']:''?>" attr_r = "<?php echo (isset($detail['activePlanAllDetails'][$i])?$detail['activePlanAllDetails'][$i]['ACTION_PLAN_ID']:"")?>" alt="0" style="pointer-events: none;">Report to ATAR</div></span></td>
<input type="hidden" id="AtarPageInsertId<?php echo $i ?>" name = "AtarPageInsertId<?php echo $i ?>" value="0">
</div>

<?php }else{?>

<div class="col-md-3">
<td> <button type="button" class="fa fa-trash delete" alt="<?php echo $i ?>" attr_tblid = "ACTION_PLAN_ID" attr="<?php echo $detail['activePlanAllDetails'][$i]['ACTION_PLAN_ID'];?>" attr_table = "INCIDENT_ACTION_PLAN" attr_status="ACTION_PLAN_STATUS" id="delete" title="Delete file"></button>
<input type="hidden" id="AtarPageInsertId<?php echo $i ?>" name = "AtarPageInsertId<?php echo $i ?>" value="0">
</td>
<td><span title='Disabled'><div class="btn btn-warning btn-sm AtarPageInsert" title = "Enabled" id="AtarPageInsert<?php echo $i ?>" alt="<?php echo $i ?>" attr_oldcapa = "<?php echo isset($detail['activePlanAllDetails'][$i]['CA_PA_DESC'])?$detail['activePlanAllDetails'][$i]['CA_PA_DESC']:''?>" attr_r = "<?php echo (isset($detail['activePlanAllDetails'][$i])?$detail['activePlanAllDetails'][$i]['ACTION_PLAN_ID']:"")?>" style="pointer-events: none;">Report to ATAR</div></span></td>
</div>


<?php } ?>


<input class="form-control ACTION_PLAN_ID" autocomplete="off" type="hidden" value="<?php echo (isset($detail['activePlanAllDetails'][$i])?$detail['activePlanAllDetails'][$i]['ACTION_PLAN_ID']:"")?>" alt="<?php echo $i;?>" name="activePlanDatas[<?php echo $i ?>][ACTION_PLAN_ID]" id="ACTION_PLAN_ID<?php echo $i ?>" />

</tr>
<?php } ?>
</table>
</div>
</div>
<div class="alert-msg"></div>
</div>




</div>
                        <div class="card ">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                              17. Attachments (Witness statement, training record, photo/sketch, division report etc)
                              <span class="float-right">
                                 <div class="btn btn-warning btn-sm addAttachDetails">Add</div>
                              </span>
                           </a>
                        </div>
                        <div id="section_17" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row AttachInfo">
                                 <table class="table table-bordered AttachTable">
                                   
                                          <?php $n = (isset($detail['attachAllDetail'])&&count($detail['attachAllDetail']))?count($detail['attachAllDetail']):1;
                                             for($i=0;$i<$n;$i++){   
                                                          ?>  
                                                           <tr id="RowAttach<?php echo $i ?>">
                                           <div class="col-md-3">
                                          <td>
                                             <label></label>
                                             <?php if(($detail['attachAllDetail'][$i]['FILE_NAME'] !='')){?> <!-- <a target="_blank" class="existing_file" href="<?php echo base_url().$detail['attachAllDetail'][$i]['FILE_PATH'].'/'.$detail['attachAllDetail'][$i]['FILE_NAME']?>"><i class="fa fa-eye"></i>&nbsp;View File</a>&nbsp;&nbsp;
                                                    <a href="javascript:;" class="remove"><i class="fa fa-remove"></i>&nbsp;Remove File</a><br> --><?php }

                                                    if(isset($detail['attachAllDetail'][$i]['FILE_PATH'])){?>

                                                       <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                     <?php  if($detail['attachAllDetail'][$i]['FILE_EXT'] == 'jpg' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'JPG' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'JPEG' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'jpeg' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'png' || $detail['attachAllDetail'][$i]['FILE_EXT'] == 'PNG'){ ?>
                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="<?php echo base_url().$detail['attachAllDetail'][$i]['FILE_PATH'].'/'.$detail['attachAllDetail'][$i]['FILE_NAME']?>"></div>
                    <div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
                             <?php  if($userType != "8" && $userType != "9" ){ ?>
                            <span class=" btn btn-sm btn-primary fileinput-new">Upload attachment</span>
                             <?php } ?>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" accept="image/*,application/pdf" name="AttachDatas[<?php echo $i ?>][uploadFile]" id="uploadFile<?php echo $i ?>" class='uploadFile' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                        <span class="AttachedDetal"></span>
                                       <span class="error idtype1error"></span> 
                    </div>
                     <?php } else{ ?><div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                    <div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
                            <span class=" btn btn-sm btn-primary fileinput-new">Upload attachment</span>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" accept="image/*,application/pdf" name="AttachDatas[<?php echo $i ?>][uploadFile]" id="uploadFile<?php echo $i ?>" class='uploadFile' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a> <span class="AttachedDetal"></span>
                                       <span class="error idtype1error"></span> <br><br>
                                      <?php if(($detail['attachAllDetail'][$i]['FILE_NAME']) !='') { ?>
                    <a target="_blank" class="existing_file" href="<?php echo base_url().$detail['attachAllDetail'][$i]['FILE_PATH'].'/'.$detail['attachAllDetail'][$i]['FILE_NAME']?>"><i class="fa fa-eye"></i>&nbsp;View PDF File</a><?php } ?>
                     <?php } ?>
                    </div>
                </div>      
            </div>

                                       <?php } 
                                          else{ ?>

                                            <div>
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="https://www.placehold.it/230x140/EFEFEF/AAAAAA&text=no+image" /></div>
                        <div>
                            
                                                                <div style="display: inline-block;float:left;margin-right:20px;">
                                                                    <span class="btn-file" style="display: inline-block;">
                           <span class=" btn btn-sm btn-primary fileinput-new initialfilerequire">Upload attachment</span>
                           <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                           <input type="file" accept="image/*,application/pdf" name="AttachDatas[<?php echo $i ?>][uploadFile]" id="uploadFile<?php echo $i ?>" class='uploadFile'>
                            </span>
                                                           
                            <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                         </div>
                                                           <span class="rootCauseAnly"></span>
                        <span class="error idtype1error"></span>
                     </div>
                                    
  </div>





                                               <!-- <div>
                                                <input type="file" required="required" <?php echo isset($detail['attachAllDetail'][$i]['uploadFile']);?> name="AttachDatas[<?php echo $i ?>][uploadFile]" id="uploadFile<?php echo $i ?>" class="form-control uploadFile" />
                                       <span class="AttachedDetal"></span>
                                       <span class="error idtype1error"></span>   -->
                                           
                                     <?php  } ?>

                                                <input type="hidden" class="FILE_NAME" name="AttachDatas[<?php echo $i?>][FILE_NAME]" value="<?php echo isset($detail['attachAllDetail'][$i]['FILE_NAME'])?$detail['attachAllDetail'][$i]['FILE_NAME']:''?>">
                                                 <input type="hidden" class="FILE_PATH" name="AttachDatas[<?php echo $i?>][FILE_PATH]" value="<?php echo isset($detail['attachAllDetail'][$i]['FILE_PATH'])?$detail['attachAllDetail'][$i]['FILE_PATH']:''?>">
                                                 <input type="hidden" name="AttachDatas[<?php echo $i?>][FILE_SIZE]" value="<?php echo isset($detail['attachAllDetail'][$i]['FILE_SIZE'])?$detail['attachAllDetail'][$i]['FILE_SIZE']:''?>">
                                                 <input type="hidden" name="AttachDatas[<?php echo $i?>][FILE_EXT]" value="<?php echo isset($detail['attachAllDetail'][$i]['FILE_EXT'])?$detail['attachAllDetail'][$i]['FILE_EXT']:''?>">

                                             </td>
                                        
                                            </div>
                                                                                                                          
                                       <div class="col-md-3">
                                          <td>
                                             <label>Description <?php echo REQUIRED; ?></label>
                                             <div>
                                               <textarea cols="5" rows="2" class="form-control attachDescription"  name="AttachDatas[<?php echo $i ?>][attachDescription]" id="attachDescription<?php echo $i ?>"><?php echo isset($detail['attachAllDetail'][$i]['DESCRIPTION'])?$detail['attachAllDetail'][$i]['DESCRIPTION']:''?></textarea>
                                             </div>
                                           </td>
                                       </div>

                                       <?php 
                                                  if($i==0){ ?>
                                                     
                                               <div class="col-md-3">
                                                  <td><?php echo "  -  " ; ?></td>
                                              
                                               </div>
                                              
                                                <?php  }else{?>
                                              
                                               <div class="col-md-3">
                                                <td> <button type="button" class="fa fa-trash delete" alt="<?php echo $i ?>" attr_tblid = "INVEST_ATTACHMENT_ID" attr="<?php echo $detail['attachAllDetail'][$i]['INVEST_ATTACHMENT_ID'];?>" attr_table = "INCIDENT_INVEST_ATTACHMENT" attr_status="ATTACHMENT_STATUS" id="delete" title="Delete file"></button>
                                               </td>
                                               </div>
                                             
                                          <?php }  ?>
                                              

                                          <input class="form-control INVEST_ATTACHMENT_ID" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['attachAllDetail'][$i])?$detail['attachAllDetail'][$i]['INVEST_ATTACHMENT_ID']:"")?>" alt="<?php echo $i;?>"  name="AttachDatas[<?php echo $i ?>][INVEST_ATTACHMENT_ID]" id="INVEST_ATTACHMENT_ID<?php echo $i ?>" />
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
                                 <div class="col-md-3">
                                    <label></label>
                                    <div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input accidentAvoid" type="radio" id="idaccidentAvoidY" value="Y"<?php if(isset($detail['IncidentInvestigationData']['ACCITENT_AVOIDABLE'])){echo $detail['IncidentInvestigationData']['ACCITENT_AVOIDABLE']=='Y'?'checked':'';}?> name="accidentAvoidab" >
                                          <label class="form-check-label" for="idaccidentAvoidY">
                                          Yes
                                          </label>
                                       </div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input accidentAvoid" type="radio" id="idaccidentAvoidN" value="N"<?php if(isset($detail['IncidentInvestigationData']['ACCITENT_AVOIDABLE'])){echo $detail['IncidentInvestigationData']['ACCITENT_AVOIDABLE']=='N'?'checked':'';}?> name="accidentAvoidab">
                                          <label class="form-check-label" for="idaccidentAvoidN">
                                          No
                                          </label>
                                       </div>
                                       <span class="error idtype1error"></span>  
                                    </div>
                                 </div>
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
                                 <div class="col-md-12">
                                    <textarea  class="form-control recommendationClass" style="width: 200px; height: 150px;"  name="recommendation" id="recommendation"><?php echo !empty($RecomendationSummary) ? $RecomendationSummary:''?></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div> 

                     <input class="form-control INCIDENT_INVESTIGATION_ID" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['INCIDENT_INVESTIGATION_ID']:"")?>" alt="<?php echo $i;?>"  name="INCIDENT_INVESTIGATION_ID" id="INCIDENT_INVESTIGATION_ID" />

                     <input class="form-control SUMBIT_PROCESS" type="hidden"  value="" name="SUMBIT_PROCESS" id="SUMBIT_PROCESS" />
                     <input class="form-control STATUS_PROCESS" type="hidden"  value="" name="STATUS_PROCESS" id="STATUS_PROCESS" />


                      <div class="col-md-offset-5 col-md-9">
                        <button type="submit" id="save" attr_sub = "1" class="btn btn-info">Submit</button>
                        <button type="submit" id="saved" attr_drft= "0" class="btn btn-info">Save Draft</button>
                     </div>
                     <?php echo form_close(); ?>
                     <div class="row headingStylss d-none">
                        <div class="col-md-12">
                           <h4><?php echo 'Workflow and Approval process'; ?></h4>
                        </div>
                     </div>
                      <?php
                           $action = (isset($id) && $id != "") ? 'incident/investSaveReview/' . $id : 'incident/investSaveReview';
                           $attr = [
                               'class' => 'form-horizontal',
                               'id' => 'investformReview',
                               'autocomplete' => 'off'
                           ];
                           echo form_open_multipart($action, $attr);
                           ?>
                      <div class="card  reviewed d-none">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           Reviewed By<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_20" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-5  ">
                                    <label>User Name</label>
                                    <div>
                                   <?php
                                             $data = [
                                                 'name' => 'RevuserName',
                                                 'id' => 'RevuserName',
                                                 'class' => 'form-control',
                                                 'value' => $userName,
                                                  'readonly' => 'readonly'
                                             ];
                                             echo form_input($data);
                                             ?>    
                                          </div>
                                 </div>
                                 <div class="col-md-3">
                                    <label>Current Date and Time</label>
                                    <div>
                                   <?php
                                             $data = [
                                                 'name' => 'RevCurrentDate',
                                                 'id' => 'RevCurrentDate',
                                                 'class' => 'form-control',
                                                 'value' => $currentDate,
                                                  'readonly' => 'readonly'
                                             ];
                                             echo form_input($data);
                                             ?>    
                                          </div>
                                 </div>
                              </div>
                              <div calss="row">
                                 <div class="col-md-3">
                                    <label>Remark</label>
                                    <?php
                                       $data = array(
                                           'name' => 'reviewdBy',
                                           'id' => 'reviewdBy',
                                           'class' => 'form-control',
                                           'rows' => '3',
                                           'cols' => '40',
                                           'style' => 'width:418%',
                                           'value' => ''
                                         );
                                       echo form_textarea($data);
                                       ?> 
                                 </div>

                                <div class="col-md-9">
                                 <div class="form-check-inline">
                                          <input class="form-check-input ReviewAccept" type="radio" id="idReviewAcceptA" value="A" name="ReviewAcpRej" >
                                          <label class="form-check-label" for="idReviewAcceptA">
                                          Review Accept
                                          </label>
                                       </div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input ReviewReject" type="radio" id="idReviewRejectR" value="R" name="ReviewAcpRej" >
                                          <label class="form-check-label" for="idReviewRejectR">
                                          Review Reject
                                          </label>
                                       </div>
                                    </div>
                                   <span class="error eventReviewAcceptError"></span>
                              </div>
                           </div>
                        </div>
                     </div> 


                      <div class="card verified d-none">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           Verified By<span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_21" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-3">
                                     <label>User Name</label>
                                    <div>
                                   <?php
                                             $data = [
                                                 'name' => 'VeruserName',
                                                 'id' => 'VeruserName',
                                                 'class' => 'form-control',
                                                 'value' => $userName,
                                                  'readonly' => 'readonly'
                                             ];
                                             echo form_input($data);
                                             ?>    
                                          </div>
                                 </div>
                                 <div class="col-md-3">
                                    <label>Current Date and Time</label>
                                    <div>
                                   <?php
                                             $data = [
                                                 'name' => 'VerCurrentDate',
                                                 'id' => 'VerCurrentDate',
                                                 'class' => 'form-control',
                                                 'value' => $currentDate,
                                                  'readonly' => 'readonly'
                                             ];
                                             echo form_input($data);
                                             ?>    
                                          </div>
                                 </div>
                              </div>
                              <div calss="row">
                                 <div class="col-md-3">
                                    <label>Remark</label>
                                    <?php
                                       $data = array(
                                           'name' => 'verifiedBy',
                                           'id' => 'verifiedBy',
                                           'class' => 'form-control',
                                           'rows' => '3',
                                           'cols' => '40',
                                           'style' => 'width:418%',
                                           'value' => ''
                                         );
                                       echo form_textarea($data);
                                       ?> 
                                 </div>
                                 <div class="col-md-9">
                                 <div class="form-check-inline">
                                          <input class="form-check-input VerifiedAccept" type="radio" id="idVerifiedAcceptA" value="A" name="VerifiedAcpRej" >
                                          <label class="form-check-label" for="idVerifiedAcceptA">
                                          Verify Accept
                                          </label>
                                       </div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input VerifiedReject" type="radio" id="idVerifiedRejectR" value="R" name="VerifiedAcpRej" >
                                          <label class="form-check-label" for="idVerifiedRejectR">
                                          Revert
                                          </label>
                                       </div>
                                       
                                    </div>
                                  <span class="error eventVerifiedAcceptError"></span>
                              </div>
                           </div>
                        </div>
                     </div> 
                      


                     <div class="card approved d-none">
                        <div class="card-header ">
                           <a class="card-link " href="javascript:void(0)" >
                           Approved By <span class="float-right"></span>
                           </a>
                        </div>
                        <div id="section_22" class="collapse multi-collapse show" data-parent="#accordion">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-md-3">
                                     <label>User Name</label>
                                    <div>
                                   <?php
                                             $data = [
                                                 'name' => 'AppuserName',
                                                 'id' => 'AppuserName',
                                                 'class' => 'form-control',
                                                 'value' => $userName,
                                                  'readonly' => 'readonly'
                                             ];
                                             echo form_input($data);
                                             ?>    
                                          </div>
                                 </div>
                                 <div class="col-md-3">
                                    <label>Current Date and Time</label>
                                    <div>
                                   <?php
                                             $data = [
                                                 'name' => 'AppCurrentDate',
                                                 'id' => 'AppCurrentDate',
                                                 'class' => 'form-control',
                                                 'value' => $currentDate,
                                                  'readonly' => 'readonly'
                                             ];
                                             echo form_input($data);
                                             ?>    
                                          </div>
                                 </div>
                              </div>
                              <div calss="row">
                                 <div class="col-md-3">
                                    <label>Remark</label>
                                    <?php
                                       $data = array(
                                           'name' => 'approvedBy',
                                           'id' => 'approvedBy',
                                           'class' => 'form-control',
                                           'rows' => '3',
                                           'cols' => '40',
                                           'style' => 'width:418%',
                                           'value' => ''
                                         );
                                       echo form_textarea($data);
                                       ?> 
                                 </div>
                                 <div class="col-md-9">
                                 <div class="form-check-inline">
                                          <input class="form-check-input ApprovedAccept" type="radio" id="idApprovedAcceptA" value="A" name="ApprovedAcpRej" >
                                          <label class="form-check-label" for="idApprovedAcceptA">
                                          Approve
                                          </label>
                                       </div>
                                       <div class="form-check-inline">
                                          <input class="form-check-input ApprovedReject" type="radio" id="idApprovedRejectR" value="R" name="ApprovedAcpRej" >
                                          <label class="form-check-label" for="idApprovedRejectR">
                                          Revert
                                          </label>
                                       </div>
                                       
                                    </div>
                                  <span class="error evenApprovedAcceptError"></span>
                              </div>
                           </div>
                        </div>
                     </div> 
                     <input class="form-control INCIDENT_INVESTIGATION_IDD" autocomplete="off" type="hidden"  value="<?php echo (isset($detail['IncidentInvestigationData'])?$detail['IncidentInvestigationData']['INCIDENT_INVESTIGATION_ID']:"")?>" alt="<?php echo $i;?>"  name="INCIDENT_INVESTIGATION_IDD" id="INCIDENT_INVESTIGATION_IDD" />

                     <div class="col-md-offset-9 col-md-11 Approvesubmit d-none">
                                    <button type="submit" id="review_save" attr_sub = "1" class="btn btn-info">Submit</button>
                                    </div>
                                    <?php echo form_close(); ?>
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
      // alert(1);
//       $.validator.messages.accept = 'Accepts only jpg, jpeg, png';
// $.validator.addClassRules("initialfilerequire", {
//     accept: "png|jpeg|jpg|PNG|JPEG|JPG",
//     required: true
// }); 



var form = $('#investform');

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
                                                                                                                                               
      $('<tbody id="UniqkIdForRw'+i+'"><tr id="RowInjures'+i+'"><td class="aligNameInjur"><label>Name</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][injuredEmpName]" maxlength="50" class="form-control injuredEmpName" id="injuredEmpName'+i+'" value=""></td><td><label>Sex</label><div><div class="form-check-inline"><input class="form-check-input" alt="'+i+'" type="radio" value="M" id="idInjuredMale'+i+'" name="injuredDatas['+i+'][injuredGen]" ><label class="form-check-label" for="idInjuredMale">Male</label></div></div><div class="form-check-inline"><input class="form-check-input" alt="'+i+'" type="radio"  value="F" id="idInjuredFemale'+i+'" name="injuredDatas['+i+'][injuredGen]"> <label class="form-check-label" for="idInjuredFemale">Female</label></div><span class="error idtype1error"></span></td><td><label>Age</label><input type = "text" minlength="1" alt="'+i+'" maxlength="3" name= "injuredDatas['+i+'][age]" class="form-control age" id="age'+i+'" value=""></td><td><label>Job Title</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][jobTitle]" class="form-control jobTitle" id="jobTitle'+i+'" value=""></td><td><label>Citizenship</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][citizenship]" class="form-control citizenship" id="citizenship'+i+'" value=""></td><tr><tr id="RowInjures'+i+'"><td><label>ID type</label><select class="form-control injuredIdType" alt="'+i+'" name="injuredDatas['+i+'][injuredIdType]"><option value="">Select - Id type </option><option value="IC" >IC</option> <option value="PASSPORT">Passport</option></select></td><td id="testsInjur"><label>IC Passport No</label><input type = "text" alt="'+i+'"  name= "injuredDatas['+i+'][passportNo]" maxlength="15" class="form-control passportNo" id="passportNo'+i+'" value=""></td><td><label>Contractor/Company Name</label><input type = "text" alt="'+i+'" maxlength="100" name= "injuredDatas['+i+'][injuredCompanyName]" class="form-control injuredCompanyName" id="injuredCompanyName'+i+'" value=""></td><td><label>Injury Type</label><input type = "text" alt="'+i+'" maxlength="50" name= "injuredDatas['+i+'][InjuryType]" class="form-control InjuryType" id="InjuryType'+i+'" value=""></td><td><label>Body part effected</label><div><input type = "text" alt="'+i+'"  name= "injuredDatas['+i+'][bodyPart]" class="form-control bodyPart" id="bodyPart'+i+'" value=""></div></td><tr><tr id="RowInjures'+i+'"><td colspan="4"><label>Sub Body Part</label><div><input type = "text" alt="'+i+'"  name= "injuredDatas['+i+'][SubbodyPart]"" class="form-control SubbodyPart" id="SubbodyPart'+i+'" value=""></div></td><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></tr><tbody>').appendTo(scntDiv);
                      
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
      $('<tbody id="UniqkIdForRw'+i+'"><tr id="RowInjures'+i+'"><td class="aligNameInjur"><label>Name</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][injuredEmpName]" maxlength="50" class="form-control injuredEmpName" id="injuredEmpName'+i+'" value=""></td><td><label>Sex</label><div><div class="form-check-inline"><input class="form-check-input" alt="'+i+'" type="radio" value="M" id="idInjuredMale'+i+'" name="injuredDatas['+i+'][injuredGen]" ><label class="form-check-label" for="idInjuredMale">Male</label></div></div><div class="form-check-inline"><input class="form-check-input" alt="'+i+'" type="radio"  value="F" id="idInjuredFemale'+i+'" name="injuredDatas['+i+'][injuredGen]"> <label class="form-check-label" for="idInjuredFemale">Female</label></div><span class="error idtype1error"></span></td><td><label>Age</label><input type = "text" minlength="1" alt="'+i+'" maxlength="3" name= "injuredDatas['+i+'][age]" class="form-control age" id="age'+i+'" value=""></td><td><label>Job Title</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][jobTitle]" class="form-control jobTitle" id="jobTitle'+i+'" value=""></td><td><label>Citizenship</label><input type = "text" alt="'+i+'" name= "injuredDatas['+i+'][citizenship]" class="form-control citizenship" id="citizenship'+i+'" value=""></td><tr><tr id="RowInjures'+i+'"><td><label>ID type</label><select class="form-control injuredIdType" alt="'+i+'" name="injuredDatas['+i+'][injuredIdType]"><option value="">Select - Id type </option><option value="IC" >IC</option> <option value="PASSPORT">Passport</option></select></td><td id="testsInjur"><label>IC Passport No</label><input type = "text" alt="'+i+'"  name= "injuredDatas['+i+'][passportNo]" maxlength="15" class="form-control passportNo" id="passportNo'+i+'" value=""></td><td><label>Contractor/Company Name</label><input type = "text" alt="'+i+'" maxlength="100" name= "injuredDatas['+i+'][injuredCompanyName]" class="form-control injuredCompanyName" id="injuredCompanyName'+i+'" value=""></td><td><label>Injury Type</label><input type = "text" alt="'+i+'" maxlength="50" name= "injuredDatas['+i+'][InjuryType]" class="form-control InjuryType" id="InjuryType'+i+'" value=""></td><td><label>Body part effected</label><div><input type = "text" alt="'+i+'"  name= "injuredDatas['+i+'][bodyPart]" class="form-control bodyPart" id="bodyPart'+i+'" value=""></div></td><tr><tr id="RowInjures'+i+'"><td colspan="4"><label>Sub Body Part</label><div><input type = "text" alt="'+i+'"  name= "injuredDatas['+i+'][SubbodyPart]"" class="form-control SubbodyPart" id="SubbodyPart'+i+'" value=""></div></td><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></tr><tbody>').appendTo(scntDiv);
      
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tbody id="uniqAsstId'+i+'"><tr id="RowAsset'+i+'"><td><label>Estimated Cost of Damage</label><div><input type = "text" alt="'+i+'" maxlength="50" name= "assetDatas['+i+'][assetEstimate]" class="form-control assetEstimate" id="assetEstimate'+i+'" value=""></div></td><td id="tesingss"><label>Name of Operator/ Driver /Vessel Master</label><div><br><input type = "text" alt="'+i+'" name= "assetDatas['+i+'][assetNameOfOperator]" class="form-control assetNameOfOperator" id="assetNameOfOperator'+i+'" value=""></div></td><td><label>Phone No</label><div><br><input type = "text" alt="'+i+'"  maxlength="16" minlength="10" name= "assetDatas['+i+'][assetPhone]" class="form-control assetPhone" id="assetPhone'+i+'" value=""></div></td><td><label>Owner/Company Name </label><div><br><input type = "text" alt="'+i+'" maxlength="100"  name= "assetDatas['+i+'][assetOwner]" class="form-control assetOwner" id="assetOwner'+i+'" value=""></div></td><td><label>Plate No </label> <div><br><input type = "text" alt="'+i+'" maxlength="20" name= "assetDatas['+i+'][assetPlate]" class="form-control assetPlate" id="assetPlate'+i+'" value=""></div></td><tr id="RowAsset'+i+'"><td colspan="4"><label>Description </label><div><br><textarea cols="5" rows="2" class="form-control assetDescription"  name="assetDatas['+i+'][assetDescription]" id="assetDescription'+i+'"></textarea></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr><tbody>').appendTo(scntDiv);
                     
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                         $('<tbody id="uniqAsstId'+i+'"><tr id="RowAsset'+i+'"><td><label>Estimated Cost of Damage</label><div><input type = "text" alt="'+i+'" maxlength="50" name= "assetDatas['+i+'][assetEstimate]" class="form-control assetEstimate" id="assetEstimate'+i+'" value=""></div></td><td id="tesingss"><label>Name of Operator/ Driver /Vessel Master</label><div><br><input type = "text" alt="'+i+'"  name= "assetDatas['+i+'][assetNameOfOperator]" class="form-control assetNameOfOperator" id="assetNameOfOperator'+i+'" value=""></div></td><td><label>Phone No</label><div><br><input type = "text" alt="'+i+'"  maxlength="16" minlength="10" name= "assetDatas['+i+'][assetPhone]" class="form-control assetPhone" id="assetPhone'+i+'" value=""></div></td><td><label>Owner/Company Name </label><div><br><input type = "text" alt="'+i+'" maxlength="100" name= "assetDatas['+i+'][assetOwner]" class="form-control assetOwner" id="assetOwner'+i+'" value=""></div></td><td><label>Plate No </label><br><div><input type = "text" alt="'+i+'" maxlength="20" name= "assetDatas['+i+'][assetPlate]" class="form-control assetPlate" id="assetPlate'+i+'" value=""></div></td><tr><tr id="RowAsset'+i+'"><td colspan="4"><label>Description </label><div><textarea cols="5" rows="2" class="form-control assetDescription"  name="assetDatas['+i+'][assetDescription]" id="assetDescription'+i+'"></textarea></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr><tbody>').appendTo(scntDiv);
                      

   
    }
        i++;    
          
     });
                                                                                                                                      
});
    } else {
   $('.AssetDetailsHide').addClass('d-none');
    }
    });

    // avoid txt and number - in textbox - validation

    
    
   
    $(document).on('keydown', '.InjuryType', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
    
       
   
   $(document).ready(function () {
           $("#empName").keypress(function (e) {
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
    
    
   
   $(document).on('keydown', '.personName', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   
   $(document).on('keydown', '.perJobTitle', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   
//    $(document).on('keydown', '.assetNameOfOperator', function(e) {
//      var a = e.key;
//      if (a.length == 1) return /[A-Z/.,]|&/i.test(a);
//      return true;
//   })
    


    $(function() {
        var scntDiv = $('.supervisorTable');
        var i = <?php echo (isset($detail['superiorAllDetails'])&&count($detail['superiorAllDetails']))?(count($detail['superiorAllDetails'])):1?>;
         var z=1;
        
          
        $('#addSuperDet').on('click', function() {
             if (i < 5 ) { 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="Rowhide'+i+'"><td><label>Employee ID</label><input type = "text"  alt="'+i+'" name= "superiorDatas['+i+'][supEmployeeId]" class="form-control SupervisorempIds" id="SupervisorempIds'+i+'" value=""></td><td><label>Name </label><input type = "text" name= "superiorDatas['+i+'][supEmployeeName]" maxlength="50" class="form-control SupervisorempName" id="SupervisorempName'+i+'" value=""></td><td><label>Phone </label><input type = "text" name= "superiorDatas['+i+'][mobile]" class="form-control mobile" id="mobile'+i+'" maxlength = "16" minlength="10" value=""><td><label>Present</label><div><div class="form-check-inline"><input class="form-check-input" type="radio" value="Y" id="idsuperiorPresentY" name="superiorDatas['+i+'][present]" ><label class="form-check-label" for="idsuperiorPresentY">Yes</label></div><div class="form-check-inline"><input class="form-check-input" type="radio" value="N" id="idsuperiorPresentN"   name="superiorDatas['+i+'][present]"><label class="form-check-label" for="idsuperiorPresentN">No</label></div></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                       // alert(i);
                      
             
        
         
       }
        i++;    
          
     });
                                                                                                                                      
});

    // Delete Details

   function deleteColumnForIncident(id,table,pri_clm,alt_status){
if(id !='' && table!='' && pri_clm!='' && alt_status!=''){
// alert(id);
// alert(table);
// alert(pri_clm);
var url = "<?php echo BASE_URL() . "incident/DeleteAllDetails" ?>";
var data = {id:id,table:table,pri_clm:pri_clm,alt_status:alt_status, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
$.ajax({
type:'POST',
async: false,
url:url,
data:data,
success: function(data){

}
});
}
}
            function deleteColumnForIncidentinjuredTable(id,table,pri_clm,alt_status){
if(id !='' && table!='' && pri_clm!='' && alt_status !=''){
// alert(id);
// alert(table);
// alert(pri_clm);
var url = "<?php echo BASE_URL() . "incident/DeleteAllDetailsPerson" ?>";
var data = {id:id,table:table,pri_clm:pri_clm,alt_status:alt_status, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
$.ajax({
type:'POST',
async: false,
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
    var alt_status = $(this).attr('attr_status');
    $('#Rowhide'+alt_del).hide();
    var pri_clm = $(this).attr('attr_tblid');
    $(document).on('click' , '#save' , function(){
    //$('#save').on('click' , function(){
    deleteColumnForIncident(id,table,pri_clm,alt_status);
    });
    $(document).on('click' , '#saved' , function(){
    deleteColumnForIncident(id,table,pri_clm,alt_status);    
    });
    $(this).closest('tr').remove();
    e.preventDefault();
    });


    $('.InvestigationTable').on('click', ".delete", function(e) {
//alert(2);
var id = $(this).attr('attr');
var table = $(this).attr('attr_table');
var alt_del = $(this).attr('alt');
var alt_status = $(this).attr('attr_status');
$('#Rowperson'+alt_del).hide();
var pri_clm = $(this).attr('attr_tblid');
$(document).on('click', '#save', function(e) {
//$('#save').on('click' , function(){

deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(document).on('click' , '#saved' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(this).closest('tr').remove();
e.preventDefault();
});

    $('.injuredTable').on('click', ".delete", function(e) {
var INVEST_INJURED_PERSON_STATUS = $('#INVEST_INJURED_PERSON_STATUS').val('N');
var id = $(this).attr('attr');
var table = $(this).attr('attr_table');
var alt_del = $(this).attr('alt');
var alt_status = $(this).attr('attr_status');
$('#UniqkIdForRw'+alt_del).hide();
var pri_clm = $(this).attr('attr_tblid');
$(document).on('click', '#save', function(e) {
// alert(1);
//$('#save').on('click' , function(){
deleteColumnForIncidentinjuredTable(id,table,pri_clm,alt_status);
});
$(document).on('click' , '#saved' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(this).closest('tr').remove();
e.preventDefault();
});

    $('.AssetTable').on('click', ".delete", function(e) {
var id = $(this).attr('attr');
var table = $(this).attr('attr_table');
var alt_del = $(this).attr('alt');
var alt_status = $(this).attr('attr_status');
$('#uniqAsstId'+alt_del).hide();
var pri_clm = $(this).attr('attr_tblid');
$(document).on('click', '#save', function(e) {
// $('#save').on('click' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(document).on('click' , '#saved' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(this).closest('tr').remove();
e.preventDefault();
});

   $('.personInterTable').on('click', ".delete", function(e) {
var id = $(this).attr('attr');
var table = $(this).attr('attr_table');
var alt_del = $(this).attr('alt');
var alt_status = $(this).attr('attr_status');
$('#RowInterView'+alt_del).hide();
var pri_clm = $(this).attr('attr_tblid');
$(document).on('click', '#save', function(e) {
// $('#save').on('click' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(document).on('click' , '#saved' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(this).closest('tr').remove();
e.preventDefault();
});

    $('.circumstanceTable').on('click', ".delete", function(e) {
var id = $(this).attr('attr');
var table = $(this).attr('attr_table');
var alt_del = $(this).attr('alt');
var alt_status = $(this).attr('attr_status');
$('#RowCircumstance'+alt_del).hide();
var pri_clm = $(this).attr('attr_tblid');
$(document).on('click', '#save', function(e) {
//$('#save').on('click' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(document).on('click' , '#saved' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(this).closest('tr').remove();
e.preventDefault();
});

   $('.ActivePlanTable').on('click', ".delete", function(e) {
// alert(1);
var id = $(this).attr('attr');
var table = $(this).attr('attr_table');
var alt_del = $(this).attr('alt');
var alt_status = $(this).attr('attr_status');
$('#RowActionPlan'+alt_del).hide();
var pri_clm = $(this).attr('attr_tblid');
$(document).on('click', '#save', function(e) {
// alert(1);
//$('#save').on('click' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(document).on('click' , '#saved' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(this).closest('tr').remove();
e.preventDefault();
});

    $('.AttachTable').on('click', ".delete", function(e) {
var id = $(this).attr('attr');
var table = $(this).attr('attr_table');
var alt_del = $(this).attr('alt');
var alt_status = $(this).attr('attr_status');
$('#RowAttach'+alt_del).hide();
var pri_clm = $(this).attr('attr_tblid');
$(document).on('click', '#save', function(e) {
// $('#save').on('click' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
});
$(document).on('click' , '#saved' , function(){
deleteColumnForIncident(id,table,pri_clm,alt_status);
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                        $('<tr id="RowInterView'+i+'"><td><label>Employee ID </label><input type = "text" alt="'+i+'" name= "personDatas['+i+'][perEmployeeId]" class="form-control personEmpIds" id="personEmpIds'+i+'" value=""></td><td><label>Name </label><input type = "text" name= "personDatas['+i+'][perEmployeeName]" class="form-control personName" id="personName'+i+'" value=""></td><td><label>Job Title </label><input type = "text" name= "personDatas['+i+'][personJobTitle]" class="form-control perJobTitle" id="perJobTitle'+i+'" value=""></td><td><label>Phone </label><input type = "text" maxlength = "16" minlength="10" name= "personDatas['+i+'][personMobile]" class="form-control perMobile" id="perMobile'+i+'" value=""></td>div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
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

$('<tr id="RowActionPlan'+i+'"> <td><label>Corrective / Preventive</label><div><textarea cols="5" rows="2" alt="'+i+'" class="form-control activePreventive" name="activePlanDatas['+i+'][activePreventive]" id="activePreventive'+i+'"></textarea></div></td><td><label>Responsibility (by whom?)</label><div><select class="form-control activeResponName" alt="'+i+'" name="activePlanDatas['+i+'][activeResponName]"> <option value="">Select - Emp </option><?php if(isset($employeeNameDetails)){ foreach($employeeNameDetails as $em){?><option value="<?php echo $em['EMP_AUTO_ID']?>" <?php echo (isset($detail['activePlanAllDetails'][$i])&&$detail['activePlanAllDetails'][$i]['EMP_AUTO_ID']==$em['EMP_AUTO_ID'])?"selected":''?>><?php echo $em['EMP_NAME']?></option><?php } } ?></select></div></td><td><label>Date by when</label><input type="text" name="activePlanDatas['+i+'][activeDate]" class="form-control datepick" value="" autocomplete="off"/></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td><td><span title="Disabled"><div class="btn btn-warning btn-sm AtarPageInsert" style="pointer-events: none;" title = "Enabled" id="AtarPageInsert'+i+'" alt="'+i+'" >Report to ATAR</div> <input type="hidden" id="AtarPageInsertId'+i+'" name = "AtarPageInsertId'+i+'" value="0"></span></td></div></tr>').appendTo(scntDiv);
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="RowAttach'+i+'"> <td><label></label><div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="https://www.placehold.it/230x140/EFEFEF/AAAAAA&text=no+image" /></div><div><div style="display: inline-block;float:left;margin-right:5px;"><span class="btn-file" style="display: inline-block;"><span class="btn-file"><span class=" btn btn-sm btn-primary fileinput-new">Upload attachment</span><span class="btn btn-sm btn-warning fileinput-exists">Change</span><input type="file" accept="image/*,application/pdf" name="AttachDatas['+i+'][uploadFile]" id="uploadFile'+i+'" class="uploadFile"> </span></span><span class="error idtype1error"></span> </div></td><td><label>Description</label><div><textarea cols="5" rows="2" class="form-control attachDescription"  name="AttachDatas['+i+'][attachDescription]"  id="attachDescription'+i+'"></textarea></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                      
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="Rowperson'+i+'"><td><label>Employee name</label><div><select class="form-control invesEmployeeName select2" alt="'+i+'" name="invesEmployeeInform['+i+'][employeeInvesName]"> <option value="">Select - Emp </option><?php foreach($employeeNameDetails as $em){?><option value="<?php echo $em['EMP_AUTO_ID']?>" <?php echo (isset($detail['investigationAllDetails'][$i])&&$detail['investigationAllDetails'][$i]['EMP_AUTO_ID']==$em['EMP_AUTO_ID'])?"selected":''?>><?php echo $em['EMP_NAME']?></option><?php } ?></select></div></td><td><label>Employee ID </label><div><input type = "text" alt="'+i+'" name= "invesEmployeeInform['+i+'][invesEmployeeid]" class="form-control InvesEmployeeId" id="InvesEmployeeId'+i+'" value="" readonly></div></td><td><label>Designation</label> <div><input type = "text" alt="'+i+'" name= "invesEmployeeInform['+i+'][invesDesignation]" class="form-control invesDesignation" id="invesDesignation'+i+'" value="" readonly></div> <input type = "hidden" alt="'+i+'" name= "invesEmployeeInform['+i+'][invesDesignationId]" class="form-control invesDesignationId" id="invesDesignationId'+i+'" value="" readonly></td><td><label>Phone No</label><div><input type = "text"  alt="'+i+'" name= "invesEmployeeInform['+i+'][empMobile]" maxlength="16" minlength="10" class="form-control empMobile" id="empMobile'+i+'" value=""></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
          $(".select2").select2();            
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

          $('<tr id="RowCircumstance'+i+'"><td></td><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrOne]" id="circumDescrOne'+i+'"></textarea></div></td><td> <label></label><div><i class="fas fa-arrow-right" style="font-size: 2em;"></i></div></td><div class="col-md-3"><td> <label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrTwo]" id="circumDescrTwo'+i+'"></textarea></div><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 2em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrThree]" id="circumDescrThree'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 2em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrFour]" id="circumDescrFour'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 2em;"></i></div></td><td> <label></label><div><textarea cols="5" rows="2" class="form-control"  name="circumstanceDatas['+i+'][circumDescrFive]" id="circumDescrFive'+i+'"></textarea></div> </td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 2em;"></i></div><input class="form-control COUNT_COLUMN"  type="hidden"  value="'+j+'" alt="'+i+'"  name="circumstanceDatas['+i+'][COUNT_COLUMN]" id="COUNT_COLUMN'+i+'" /></td>div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);

        } 

        else if ( i % 2 == 0) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="RowCircumstance'+i+'"><td> <label></label><div><i class="fas fa-arrow-right" style="font-size: 2em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control circumDescrOne"  name="circumstanceDatas['+i+'][circumDescrOne]" id="circumDescrOne'+i+'"></textarea></div></td><td> <label></label><div><i class="fas fa-arrow-right" style="font-size: 2em;"></i></div></td><div class="col-md-3"><td> <label></label><div><textarea cols="5" rows="2" class="form-control circumDescrTwo"  name="circumstanceDatas['+i+'][circumDescrTwo]" id="circumDescrTwo'+i+'"></textarea></div><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 2em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control circumDescrThree"  name="circumstanceDatas['+i+'][circumDescrThree]" id="circumDescrThree'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 2em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control circumDescrFour" name="circumstanceDatas['+i+'][circumDescrFour]" id="circumDescrFour'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-right" style="font-size: 2em;"></i></div></td><td> <label></label><div><textarea cols="5" rows="2" class="form-control circumDescrFive"  name="circumstanceDatas['+i+'][circumDescrFive]" id="circumDescrFive'+i+'"></textarea></div> </td><td><label></label><div><i class="fas fa-arrow-down" style="font-size: 2em;"></i></div><input class="form-control COUNT_COLUMN"  type="hidden"  value="'+j+'" alt="'+i+'"  name="circumstanceDatas['+i+'][COUNT_COLUMN]" id="COUNT_COLUMN'+i+'" /></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                      
     

        
           }
           else{
                        $('<tr id="RowCircumstance'+i+'"><td> <label></label><div><i class="fas fa-arrow-down" style="font-size: 2em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control circumDescrOne"  name="circumstanceDatas['+i+'][circumDescrOne]" id="circumDescrOne'+i+'"></textarea></div></td><td> <label></label><div><i class="fas fa-arrow-left" style="font-size: 2em;"></i></div></td><div class="col-md-3"><td> <label></label><div><textarea cols="5" rows="2" class="form-control circumDescrTwo"  name="circumstanceDatas['+i+'][circumDescrTwo]" id="circumDescrTwo'+i+'"></textarea></div><td><label></label><div><i class="fas fa-arrow-left" style="font-size: 2em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control circumDescrThree"  name="circumstanceDatas['+i+'][circumDescrThree]" id="circumDescrThree'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-left" style="font-size: 2em;"></i></div></td><td><label></label><div><textarea cols="5" rows="2" class="form-control circumDescrFour"  name="circumstanceDatas['+i+'][circumDescrFour]" id="circumDescrFour'+i+'"></textarea></div></td><td><label></label><div><i class="fas fa-arrow-left" style="font-size: 2em;"></i></div></td><td> <label></label><div><textarea cols="5" rows="2" class="form-control circumDescrFive"  name="circumstanceDatas['+i+'][circumDescrFive]" id="circumDescrFive'+i+'"></textarea></div> </td><td><label></label><div><i class="fas fa-arrow-left" style="font-size: 2em;"></i></div><input class="form-control COUNT_COLUMN"  type="hidden"  value="'+j+'" alt="'+i+'"  name="circumstanceDatas['+i+'][COUNT_COLUMN]" id="COUNT_COLUMN'+i+'" /></td>div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);

           }

           i++; 
           j++;
     });
                                                                                                                                      
});


    //Root cause analysis - Upload file
   
   $(document).on('change','.initialfilerequire',function(){
   //alert(2);
   
           var file = this.files[0];
           //alert(file);
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
         //alphanumeric:true,
        },
        'ReviewAcpRej':{
         required:true,
        // alphanumeric:true,
        },
        'verifiedBy':{
         required:true,
        // alphanumeric:true,
        },
        'VerifiedAcpRej':{
         required:true,
       //  alphanumeric:true,
        },
        'approvedBy':{
         required:true,
        // alphanumeric:true,
        },
        'ApprovedAcpRej':{
         required:true,
        // alphanumeric:true,
        },
    },
    messages:{
        'reviewdBy':{
         required:'Remark is required',
         
        },
        'ReviewAcpRej':{
         required:'Review Status is Required',
         
        },
        'verifiedBy':{
         required:'Remark is required',
        
        },
        'VerifiedAcpRej':{
         required:'Verified Status is Required',
        
        },
        'approvedBy':{
         required:'Remark is required',
        
        },
        'ApprovedAcpRej':{
         required:'Approved Status is Required',
         
        },
    },
     errorPlacement: function (error, element) {
		console.log(element.attr('name'));
		if (element.attr('name') == 'ApprovedAcpRej') {
		    error.appendTo('span.evenApprovedAcceptError');
		} else if (element.attr('name') == 'VerifiedAcpRej') {
		    error.appendTo('span.eventVerifiedAcceptError');
		} else if (element.attr('name') == 'ReviewAcpRej') {
		    error.appendTo('span.eventReviewAcceptError');
		} else {
		    error.appendTo(element.closest('div'));
		}
	    },
   });


   // Form Validation
  
   //});
   
       
     
       
//        $(document).on('click','#save',function(){
//      // alert(1);
//    
//       });
//       
       
//       $("#investform").validate({ 
//           rules: {
//            
//               'workrelated':{
//                
//                programming_char:true,
//               },
//               'activity':{
//                 
//                  programming_char:true,
//               },
//               'assetDetails':{
//                 
//                  programming_char:true,
//               },
//               'recommendation':{ 
//                 
//                  programming_char:true,
//               },
//               'specificlocother':{
//                  
//                  programming_char:true,
//               },
//               'InjuredPer':{
//                  
//                  programming_char:true,
//               },
//               'authorityInvol':{
//                 
//                  programming_char:true,
//               },
//               'accidentAvoidab':{
//                 
//                  programming_char:true,
//               },
//               'empcont':{
//                 
//                programming_char:true,
//               },
//   
//               'empName': {
//                   
//                   programming_char:true,
//                   
//               },
//               'designation': {
//                  
//                   programming_char:true,
//               },
//               'empPhnNo': {
//                  
//                   programming_char:true,
//               },
//               
//               'description': {
//                   
//                   maxlength: 500,
//                   minlength: 2,
//                   programming_char:true,
//               },
//               'files[0]':{
//                 
//                programming_char:true,
//               },
//               'hazardRisk':{
//                 
//                programming_char:true,
//               },
//               'authorityInvolved':{
//                
//                  programming_char:true,
//               },
//               'possibleCause':{
//                  
//                   maxlength: 500,
//                   minlength: 2,
//                   programming_char:true,
//               },
//                
//               'immuediateCause':{
//                 
//                  programming_char:true,
//                  
//               },
//               'contributingCause':{
//                  
//                  programming_char:true,
//               }, 
//               'superiorDatas[0][supEmployeeId]':{
//                  
//                  programming_char:true,
//               },
//               'superiorDatas[0][supEmployeeName]':{
//                 
//                  programming_char:true,
//               },
//               'superiorDatas[0][mobile]':{
//                 
//                  programming_char:true,
//               },
//               'superiorDatas[0][present]':{
//                  
//                  programming_char:true,
//               },
//               'invesEmployeeInform[0][employeeInvesName]':{
//                  
//                  programming_char:true,
//               },
//               'invesEmployeeInform[0][empMobile]':{
//                  
//                  programming_char:true,
//               },
//               'injuredDatas[0][injuredEmpName]':{
//                
//                  programming_char:true,
//               },
//               'injuredDatas[0][injuredGen]':{
//                  
//                  programming_char:true,
//               },
//               'injuredDatas[0][age]':{
//                  
//                  programming_char:true,
//               },
//               'injuredDatas[0][jobTitle]':{
//                  
//                  programming_char:true,
//               },
//               'injuredDatas[0][citizenship]':{
//                  
//                  programming_char:true,
//               },
//               'injuredDatas[0][injuredIdType]':{
//                  
//                  programming_char:true,
//               },
//               'injuredDatas[0][passportNo]':{
//                  
//                  programming_char:true,
//               },
//               'injuredDatas[0][injuredCompanyName]':{
//                 
//                  programming_char:true,
//               },
//               'injuredDatas[0][InjuryType]':{
//                  
//                  programming_char:true,
//               },
//               'injuredDatas[0][bodyPart]':{
//                 
//                  programming_char:true,
//               },
//               'assetDatas[0][assetDescription]':{
//                  
//                  programming_char:true,
//               },
//               'assetDatas[0][assetNameOfOperator]':{
//                 
//                  programming_char:true,
//               },
//               'assetDatas[0][assetPhone]':{
//                  
//                  programming_char:true,
//               },
//               'assetDatas[0][assetOwner]':{
//                 
//                  programming_char:true,
//               },
//               'assetDatas[0][assetPlate]':{
//                  
//                  programming_char:true,
//               },
//               'assetDatas[0][assetEstimate]':{
//                 
//                  programming_char:true,
//               },
//               'personDatas[0][perEmployeeId]':{
//                 
//                  programming_char:true,
//               },
//               'personDatas[0][perEmployeeName]':{
//                  
//                  programming_char:true,
//               },
//               'personDatas[0][personJobTitle]':{
//                  
//                  programming_char:true,
//               },
//               'personDatas[0][personMobile]':{
//                  
//                  programming_char:true,
//               },
//               'circumstanceDatas[0][circumDescrOne]':{
//                 
//                  programming_char:true,
//               },
//               'circumstanceDatas[0][circumDescrTwo]':{
//                  
//                  programming_char:true,
//               },
//               'circumstanceDatas[0][circumDescrThree]':{
//                  
//                  programming_char:true,
//               },
//               'circumstanceDatas[0][circumDescrFour]':{
//                  
//                  programming_char:true,
//               },
//               'circumstanceDatas[0][circumDescrFive]':{
//                  
//                  programming_char:true,
//               },
//               'activePlanDatas[0][activePreventive]':{
//                  
//                  programming_char:true,
//               },
//               'activePlanDatas[0][activeResponName]':{
//                 
//                  programming_char:true,
//               },
//               'activePlanDatas[0][activeDate]':{
//                 
//                  programming_char:true,
//               },
//               'AttachDatas[0][attachDescription]':{
//                 
//                  programming_char:true,
//               },
//               
//               'injuredDatas[0][SubbodyPart]':{
//                  
//                   programming_char:true,
//               },
//
//           },
//         
//           
//           
//       });
       
       $.validator.addMethod('alphanumeric', function (value) {
            return /^[A-Za-z0-9/,.()%  ]*$/.test(value);
        }, "Please Enter valid Alphanumeric characters with allowed special charters are /,.");
       
       $(document).on('click','#saved',function(){
   
   //alert(1);
   $("#investform").validate({ 
           rules: {
            'eventDate':{
               required:false,
                        
            },
               'eventTime': {
                   required: false,
                   
               },
               'eventLocation': {
                   required: false,
               },
               'specificLocation': {
                   required: false,
               },
               'workrelated':{
                  required:false,
               // alphanumeric:true,
               },
               'activity':{
                  required:false,
               //   alphanumeric:true,
               },
               'assetDetails':{
                  required:false,
                //  alphanumeric:true,
               },
               'recommendation':{
                  required:false,
               //   alphanumeric:true,
               },
               'specificlocother':{
                   required:false,
               //   alphanumeric:true,
               },
               'InjuredPer':{
                  required:false,
                //  alphanumeric:true,
               },
               'authorityInvol':{
                  required:false,
               //   alphanumeric:true,
               },
               'accidentAvoidab':{
                  required:false,
               //   alphanumeric:true,
               },
               'empcont':{
                  required:false,
              //  alphanumeric:true,
               },
   
               'empName': {
                   required: false,
                //   alphanumeric:true,
                   
               },
               'designation': {
                   required: false,
               //    alphanumeric:true,
               },
               'empPhnNo': {
                   required: false,
              //     alphanumeric:true,
               },
               
               'description': {
                   required: false,
                   maxlength: 500,
                   minlength: 2,
             //      alphanumeric:true,
               },
               'files[0]':{
                  required:false,
            //    alphanumeric:true,
               },
               'hazardRisk':{
                  required:false,
            //    alphanumeric:true,
               },
               'authorityInvolved':{
                  required:false,
           //       alphanumeric:true,
               },
               'possibleCause':{
                  required: false,
                   maxlength: 500,
                   minlength: 2,
              //     alphanumeric:true,
               },
                
               'immuediateCause':{
                  required:false,
              //    alphanumeric:true,
                  
               },
               'contributingCause':{
                  required:false,
              //    alphanumeric:true,
               }, 
               'superiorDatas[0][supEmployeeId]':{
                  required:false,
              //    alphanumeric:true,
               },
               'superiorDatas[0][supEmployeeName]':{
                  required:false,
             //     alphanumeric:true,
               },
               'superiorDatas[0][mobile]':{
                  required:false,
             //     alphanumeric:true,
               },
               'superiorDatas[0][present]':{
                  required:false,
              //    alphanumeric:true,
               },
               'invesEmployeeInform[0][employeeInvesName]':{
                  required:false,
              //    alphanumeric:true,
               },
               'invesEmployeeInform[0][empMobile]':{
                  required:false,
              //    alphanumeric:true,
               },
               'injuredDatas[0][injuredEmpName]':{
                  required:false,
              //    alphanumeric:true,
               },
               'injuredDatas[0][injuredGen]':{
                  required:false,
              //    alphanumeric:true,
               },
               'injuredDatas[0][age]':{
                  required:false,
               //   alphanumeric:true,
               },
               'injuredDatas[0][jobTitle]':{
                  required:false,
              //    alphanumeric:true,
               },
               'injuredDatas[0][citizenship]':{
                  required:false,
              //    alphanumeric:true,
               },
               'injuredDatas[0][injuredIdType]':{
                  required:false,
              //    alphanumeric:true,
               },
               'injuredDatas[0][passportNo]':{
                  required:false,
              //    alphanumeric:true,
               },
               'injuredDatas[0][injuredCompanyName]':{
                  required:false,
               //   alphanumeric:true,
               },
               'injuredDatas[0][InjuryType]':{
                  required:false,
               //   alphanumeric:true,
               },
               'injuredDatas[0][bodyPart]':{
                  required:false,
             //     alphanumeric:true,
               },
               'assetDatas[0][assetDescription]':{
                  required:false,
              //    alphanumeric:true,
               },
               'assetDatas[0][assetNameOfOperator]':{
                  required:false,
              //    alphanumeric:true,
               },
               'assetDatas[0][assetPhone]':{
                  required:false,
              //    alphanumeric:true,
               },
               'assetDatas[0][assetOwner]':{
                  required:false,
               //   alphanumeric:true,
               },
               'assetDatas[0][assetPlate]':{
                  required:false,
               //   alphanumeric:true,
               },
               'assetDatas[0][assetEstimate]':{
                  required:false,
               //   alphanumeric:true,
               },
               'personDatas[0][perEmployeeId]':{
                  required:false,
               //   alphanumeric:true,
               },
               'personDatas[0][perEmployeeName]':{
                  required:false,
                //  alphanumeric:true,
               },
               'personDatas[0][personJobTitle]':{
                  required:false,
               //   alphanumeric:true,
               },
               'personDatas[0][personMobile]':{
                  required:false,
               //   alphanumeric:true,
               },
               'circumstanceDatas[0][circumDescrOne]':{
                  required:false,
               //   alphanumeric:true,
               },
               'circumstanceDatas[0][circumDescrTwo]':{
                  required:false,
              //    alphanumeric:true,
               },
               'circumstanceDatas[0][circumDescrThree]':{
                  required:false,
              //    alphanumeric:true,
               },
               'circumstanceDatas[0][circumDescrFour]':{
                  required:false,
               //   alphanumeric:true,
               },
               'circumstanceDatas[0][circumDescrFive]':{
                  required:false,
               //   alphanumeric:true,
               },
               'activePlanDatas[0][activePreventive]':{
                  required:false,
               //   alphanumeric:true,
               },
               'activePlanDatas[0][activeResponName]':{
                  required:false,
               //   alphanumeric:true,
               },
               'activePlanDatas[0][activeDate]':{
                  required:false,
               //   alphanumeric:true,
               },
               'AttachDatas[0][attachDescription]':{
                  required:false,
                //  alphanumeric:true,
               },
               'userfile':{
                   required:false,
               },
               'injuredDatas[0][SubbodyPart]':{
                   required:false,
                //   alphanumeric:true,
               },

           },
         
           
           
       });
   });
   
    // save Process
      $(document).on('click', '#save', function(e) {
        var recommendation =  $('#recommendation').val();
        
      $('#SUMBIT_PROCESS').val('1');
      $('#STATUS_PROCESS').val('13');
      if(recommendation !=''){
      if($('#investform').valid()){
          //alert(1);
          swal({
         title: "Please wait..",
         imageUrl: loadingImg,
         showConfirmButton: false,
         allowOutsideClick: false
     });
      $('#investform').submit();
        }
    }
    else{
      //  alert(1);
          $("#investform").validate({ 
           rules: {
            'eventDate':{
               required:true,
                        
            },
               'eventTime': {
                   required: true,
                   
               },
               'eventLocation': {
                   required: true,
               },
               'specificLocation': {
                   required: true,
               },
               'workrelated':{
                  required:false,
               // programming_char:true,
               },
               'activity':{
                  required:true,
              //  alphanumeric:true,
               },
               'assetDetails':{
                  required:true,
               //   programming_char:true,
               },
               'specificlocother':{
                   required:true,
               //   programming_char:true,
               },
               'recommendation':{
                  required:true,
                //  alphanumeric:true,
               },
               'InjuredPer':{
                  required:false,
                //  programming_char:true,
               },
               'authorityInvol':{
                  required:false,
               //   programming_char:true,
               },
               'accidentAvoidab':{
                  required:false,
               //   programming_char:true,
               },
               'empcont':{
                  required:true,
               // alphanumeric:true,
               },
   
               'empName': {
                   required: true,
                //   programming_char:true,
                   
               },
               'designation': {
                   required: true,
               //    programming_char:true,
               },
               'empPhnNo': {
                   required: true,
                //   programming_char:true,
               },
               
               'description': {
                   required: false,
                   maxlength: 500,
                   minlength: 2,
                 //  alphanumeric:true,
               },
               'files[0]':{
                  required:true,
             //   programming_char:true,
               },
               'hazardRisk':{
                  required:false,
             //   programming_char:true,
               },
               'authorityInvolved':{
                  required:true,
             //     alphanumeric:true,
               },
               'possibleCause':{
                  required: false,
                   maxlength: 500,
                   minlength: 2,
                 //  alphanumeric:true,
               },
                
               'immuediateCause':{
                  required:true,
               //   alphanumeric:true,
                  
               },
               'contributingCause':{
                  required:false,
               //   alphanumeric:true,
               }, 
               'superiorDatas[0][supEmployeeId]':{
                  required:true,
                //  alphanumeric:true,
               },
               'superiorDatas[0][supEmployeeName]':{
                  required:true,
                //  alphanumeric:true,
               },
               'superiorDatas[0][mobile]':{
                  required:true,
                //  alphanumeric:true,
               },
               'superiorDatas[0][present]':{
                  required:true,
                //  alphanumeric:true,
               },
               'invesEmployeeInform[0][employeeInvesName]':{
                  required:true,
                //  alphanumeric:true,
               },
               'invesEmployeeInform[0][empMobile]':{
                  required:true,
                //  alphanumeric:true,
               },
               'injuredDatas[0][injuredEmpName]':{
                  required:true,
                //  alphanumeric:true,
               },
               'injuredDatas[0][injuredGen]':{
                  required:true,
                //  alphanumeric:true,
               },
               'injuredDatas[0][age]':{
                  required:true,
                //  alphanumeric:true,
               },
               'injuredDatas[0][jobTitle]':{
                  required:true,
                //  alphanumeric:true,
               },
               'injuredDatas[0][citizenship]':{
                  required:true,
                //  alphanumeric:true,
               },
               'injuredDatas[0][injuredIdType]':{
                  required:true,
                //  alphanumeric:true,
               },
               'injuredDatas[0][passportNo]':{
                  required:true,
                //  alphanumeric:true,
               },
               'injuredDatas[0][injuredCompanyName]':{
                  required:true,
               //   alphanumeric:true,
               },
               'injuredDatas[0][InjuryType]':{
                  required:true,
                //  alphanumeric:true,
               },
               'injuredDatas[0][bodyPart]':{
                  required:true,
                 // alphanumeric:true,
               },
               'assetDatas[0][assetDescription]':{
                  required:true,
                //  alphanumeric:true,
               },
               'assetDatas[0][assetNameOfOperator]':{
                  required:true,
                //  alphanumeric:true,
               },
               'assetDatas[0][assetPhone]':{
                  required:true,
                //  alphanumeric:true,
               },
               'assetDatas[0][assetOwner]':{
                  required:true,
                 // alphanumeric:true,
               },
               'assetDatas[0][assetPlate]':{
                  required:true,
                //  alphanumeric:true,
               },
               'assetDatas[0][assetEstimate]':{
                  required:true,
                 // alphanumeric:true,
               },
               'personDatas[0][perEmployeeId]':{
                  required:true,
                 // alphanumeric:true,
               },
               'personDatas[0][perEmployeeName]':{
                  required:true,
                //  alphanumeric:true,
               },
               'personDatas[0][personJobTitle]':{
                  required:true,
                //  alphanumeric:true,
               },
               'personDatas[0][personMobile]':{
                  required:true,
                //  alphanumeric:true,
               },
               'circumstanceDatas[0][circumDescrOne]':{
                  required:false,
                //  alphanumeric:true,
               },
               'circumstanceDatas[0][circumDescrTwo]':{
                  required:false,
                //  alphanumeric:true,
               },
               'circumstanceDatas[0][circumDescrThree]':{
                  required:false,
                //  alphanumeric:true,
               },
               'circumstanceDatas[0][circumDescrFour]':{
                  required:false,
               //   alphanumeric:true,
               },
               'circumstanceDatas[0][circumDescrFive]':{
                  required:false,
                //  alphanumeric:true,
               },
               'activePlanDatas[0][activePreventive]':{
                  required:true,
                 // alphanumeric:true,
               },
               'activePlanDatas[0][activeResponName]':{
                  required:true,
                //  alphanumeric:true,
               },
               'activePlanDatas[0][activeDate]':{
                  required:true,
                //  alphanumeric:true,
               },
               'AttachDatas[0][attachDescription]':{
                  required:true,
                //  alphanumeric:true,
               },
               'userfile':{
                   required:false,
               },
               'injuredDatas[0][SubbodyPart]':{
                   required:true,
                  // alphanumeric:true,
               },

           },
           errorPlacement: function (error, element) {
               
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('span'));
                }else if (element.attr('name') == 'superiorDatas[0][present]') {
                    error.appendTo('span#hasChecklist_error');
                    
                } 
                else if (element.attr('name') == 'assetDetails') {
                    error.appendTo('span#assetDetail_error');
                    
                }
                
              else {
                    error.insertAfter(element);
                }

            },
           messages:{
              'eventDate':{
               required:'Event Date is required',
                        
            },
               'eventTime': {
                   required: 'Event Time is required',
                   
               },
               'eventLocation': {
                   required: 'Event Location is required',
               },
               'specificLocation': {
                   required: 'Specific Location is required',
               },
               
               'activity':{
                  required:'Activity is required', 
               
               },
              
               'empcont':{
                  required:'Employee/Contractor is required',
               
               },
   
               
               'userfile':{
                   required:'Root cause analysis is required',
               },
               
              
               'immuediateCause':{
                  required:'Immediate Causes is required',
                 
                  
               },
                
               'superiorDatas[0][supEmployeeId]':{
                  required:'Employee ID is required',
                
               },
               'superiorDatas[0][supEmployeeName]':{
                  required:'Name is required',
                  
               },
               'superiorDatas[0][mobile]':{
                  required:'Phone is required',
                
               },
               'superiorDatas[0][present]':{
                  required:'Present is required',
                 
               },
               'invesEmployeeInform[0][employeeInvesName]':{
                  required:'Employee name is required',
                 
               },
               'invesEmployeeInform[0][empMobile]':{
                  required:'Phone No is required',
                  
               },
               'injuredDatas[0][injuredEmpName]':{
                  required:'Name is required',
                
               },
               'injuredDatas[0][injuredGen]':{
                  required:'Sex is required',
                 
               },
               'injuredDatas[0][age]':{
                  required:'Age is required',
                 
               },
               'injuredDatas[0][jobTitle]':{
                  required:'Job Title is required',
                 
               },
               'injuredDatas[0][citizenship]':{
                  required:'Citizenship is required',
                 
               },
               'injuredDatas[0][injuredIdType]':{
                  required:'ID type is required',
                 
               },
               'injuredDatas[0][passportNo]':{
                  required:'IC Passport No is required',
                 
               },
               'injuredDatas[0][injuredCompanyName]':{
                  required:'Contractor/Company Name is required',
                
               },
               'injuredDatas[0][InjuryType]':{
                  required:'Injury Type is required',
                 
               },
               'injuredDatas[0][bodyPart]':{
                  required:'Body part effected is required',
                  
               },
               'assetDatas[0][assetDescription]':{
                  required:'Description is required',
                 
               },
               'assetDatas[0][assetNameOfOperator]':{
                  required:'Name of Operator/ Driver /Vessel Master is required',
                 
               },
               'assetDatas[0][assetPhone]':{
                  required:'Phone No is required',
                  
               },
               'assetDatas[0][assetOwner]':{
                  required:'Owner/Company Name is required',
                
               },
               'assetDatas[0][assetPlate]':{
                  required:'Plate No is required',
                 
               },
               'assetDatas[0][assetEstimate]':{
                  required:'Estimated Cost of Damage is required',
                  
               },
               'personDatas[0][perEmployeeId]':{
                  required:'Employee ID is required',
                 
               },
               'personDatas[0][perEmployeeName]':{
                  required:'Name is required',
                 
               },
               'personDatas[0][personJobTitle]':{
                  required:'Job Title is required',
                 
               },
               'personDatas[0][personMobile]':{
                  required:'Phone is required',
                 
               },
               
               'activePlanDatas[0][activePreventive]':{
                  required:'Corrective / Preventive is required',
                 
               },
               'activePlanDatas[0][activeResponName]':{
                  required:'Responsibility (by whom?) is required',
                 
               },
               'activePlanDatas[0][activeDate]':{
                  required:'Date by when is required',
                
               },
               'AttachDatas[0][attachDescription]':{
                  required:'Description is required',
                 
               }, 
               'recommendation':{
                  required:'Proposed Action/Recommendation is required',
                
               },
               'injuredDatas[0][SubbodyPart]':{
                   required:'Sub Body Part is Required',
                   programming_char:true,
               }
           },

       });
    }
       }); 
       
// Save Draft All process .

    $('#saved').on('click' , function(){
      $('#SUMBIT_PROCESS').val('0');
      swal({
         title: "Please wait..",
         imageUrl: loadingImg,
         showConfirmButton: false,
         allowOutsideClick: false
     });
      $('#investform').submit();
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


  
 
  
 // Datepicker

    $(document).on('focus',".datepick", function(){
    $(this).datepicker({
        dateFormat:"dd-mm-yy",
        changeMonth: true,
        changeYear: true,
        maxDate: "+0D",
        yearRange: "1900:+nn",
        autoclose: true,
        onClose: function(dateText) {
          $("#investform").valid();
      } 
        
    });
  });

   
  // Summary Note

   $('#innvesticationSum').summernote({ 
    toolbar: [
       ['style', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript','picture','ul', 'ol','color' ,]],
     ],
     
  });

 $('#recommendation').summernote({ 
    toolbar: [
       ['style', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript','ul', 'ol','color' ,]],
     ],
     
  });

   $('#immuediateCause').summernote({ 
    toolbar: [
       ['style', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript','ul', 'ol','color' ,]],
     ],
     
  });

   $('#possibleCause').summernote({ 
    toolbar: [
       ['style', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript','ul', 'ol','color' ,]],
     ],
     
  });

   $('#contributingCause').summernote({ 
    toolbar: [
       ['style', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript','ul', 'ol','color' ,]],
     ],
     
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

   

      var SUMBIT_PROCESS = '<?php echo $detail['IncidentInvestigationData']['SUMBIT_PROCESS'];?>';
      
      var roleId = '<?php echo $_SESSION['userinfo']->USER_DESINATION_ID; ?>';
     // alert(roleId);
      var deptId = '<?php echo $_SESSION['emp_details']->EMP_DEPT_ID; ?>';
      var userType = '<?php echo $_SESSION['userinfo']->USER_TYPE_ID;?>';
      //alert(userType);
      
      var locationId = '<?php echo $locid; ?>'; 
      //alert(locationId);
      
      if(userType == "6" || userType == "7"){
         
          $('#save').show();
         $('#saved').show();
      }
      else{ 
          $('.activity').attr('style','pointer-events: none;');
          $('.empcont').attr('style','pointer-events: none;');
          $('.checkAllClass').attr('style','pointer-events: none;');
          $('#idsuperiorPresentY').attr('style','pointer-events: none;');
          $('#idsuperiorPresentN').attr('style','pointer-events: none;');
          //$('#innvesticationSum').attr('style','pointer-events: none;');
          $('#description').attr('style','pointer-events: none;');
          $('#idassetDetailsY').attr('style','pointer-events: none;');
          $('#idassetDetailsN').attr('style','pointer-events: none;');
          $('.assetEstimate').attr('style','pointer-events: none;');
          $('.assetNameOfOperator').attr('style','pointer-events: none;');
          $('.assetPhone').attr('style','pointer-events: none;');
          $('.assetOwner').attr('style','pointer-events: none;');
          $('.assetPlate').attr('style','pointer-events: none;');
          $('.assetDescription').attr('style','pointer-events: none;');
          $('.personEmpIds').attr('style','pointer-events: none;');
          $('.personName').attr('style','pointer-events: none;');
          $('.perJobTitle').attr('style','pointer-events: none;');
          $('.perMobile').attr('style','pointer-events: none;');
          $('.circumDescrOne').attr('style','pointer-events: none;');
          $('.circumDescrTwo').attr('style','pointer-events: none;');
          $('.circumDescrThree').attr('style','pointer-events: none;');
          $('.circumDescrFour').attr('style','pointer-events: none;');
          $('.circumDescrFive').attr('style','pointer-events: none;');
          $('.circumDescrOne').attr('style','pointer-events: none;');
          //$('#immuediateCause').attr('style','pointer-events: none;');
         // $('#possibleCause').attr('style','pointer-events: none;');
          //$('#contributingCause').attr('style','pointer-events: none;');
          $('#rootCause').attr('style','pointer-events: none;');
          $('.initialfilerequire').attr('style','pointer-events: none;');
          $('.docfileupload').attr('style','pointer-events: none;');
          $('.uploadFile').attr('style','pointer-events: none;');
          $('#idhazardIdentyY').attr('style','pointer-events: none;');
          $('#idhazardIdentyN').attr('style','pointer-events: none;');
          $('.activePreventive').attr('style','pointer-events: none;');
          $('.activeResponName').attr('style','pointer-events: none;');
          $('.attachDescription').attr('style','pointer-events: none;');
          $('.datepick').attr('style','pointer-events: none;');
          $('#idaccidentAvoidY').attr('style','pointer-events: none;');
          $('#idaccidentAvoidN').attr('style','pointer-events: none;');
        //  $('#recommendation').attr('style','pointer-events: none;');
          $('#eventDate').attr('style','pointer-events: none;');
          $('#eventLocation').attr('style','pointer-events: none;');
          $('#eventTime').attr('style','pointer-events: none;');
          $('#specificLocation').attr('style','pointer-events: none;');
          $('#specificlocother').attr('style','pointer-events: none;');
          $('#idworkrelatedY').attr('style','pointer-events: none;');
          $('#idworkrelatedN').attr('style','pointer-events: none;');
          $('.incidentClass').attr('style','pointer-events: none;');
          $('.SupervisorempIds').attr('style','pointer-events: none;');
          $('.SupervisorempName').attr('style','pointer-events: none;');
          $('.mobile').attr('style','pointer-events: none;');
          $('.invesEmployeeName').attr('style','pointer-events: none;');
          $('.empMobile').attr('style','pointer-events: none;');
          $('#idauthorityzY').attr('style','pointer-events: none;');
          $('#idauthorityzN').attr('style','pointer-events: none;');
          $('#idInjuredY').attr('style','pointer-events: none;');
          $('#idInjuredN').attr('style','pointer-events: none;');
          $('.injuredEmpName').attr('style','pointer-events: none;');
          $('.age').attr('style','pointer-events: none;');
          $('.jobTitle').attr('style','pointer-events: none;');
          $('.citizenship').attr('style','pointer-events: none;');
          $('.injuredIdType').attr('style','pointer-events: none;');
          $('.passportNo').attr('style','pointer-events: none;');
          $('.injuredCompanyName').attr('style','pointer-events: none;');
          $('.InjuryType').attr('style','pointer-events: none;');
          $('.bodyPart').attr('style','pointer-events: none;');
          $('.SubbodyPart').attr('style','pointer-events: none;');
          
           
           $('#save').hide();
           $('#saved').hide();
           $('#addSuperDet').hide();
           $('.addInvestigationDet').hide();
           $('.addInjuredDet').hide();
           $('.addAssetDet').hide();
           $('.addPersonInter').hide();
           $('.addCircumstance').hide();
           $('.addActionPlanDet').hide();
           $('.AtarPageInsert').hide();
           $('.addAttachDetails').hide();
           
           if(locationId == '1' ){
         if(SUMBIT_PROCESS == '3' && roleId == "22" && userType == "8"){
         $('.verified').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('.row headingStylss').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();
       }
      }
       else if(locationId == '2' ){
           //alert(1);
         if(SUMBIT_PROCESS == '3' && roleId == "18" && userType == "8"){
           //alert(2);
         $('.verified').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('.row headingStylss').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();
       }
      }
      if(SUMBIT_PROCESS == '4' && deptId == '1' && userType == "9"){
         $('.approved').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('.row headingStylss').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();
       }

      } 
      //alert(deptId);
      
       if(SUMBIT_PROCESS == '1' && roleId == "26" && userType == "7"){
         $('.reviewed').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('.row headingStylss').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();
         $('.activity').attr('style','pointer-events: none;');
          $('.empcont').attr('style','pointer-events: none;');
          $('.checkAllClass').attr('style','pointer-events: none;');
          $('#idsuperiorPresentY').attr('style','pointer-events: none;');
          $('#idsuperiorPresentN').attr('style','pointer-events: none;');
          //$('#innvesticationSum').attr('style','pointer-events: none;');
          $('#description').attr('style','pointer-events: none;');
          $('#idassetDetailsY').attr('style','pointer-events: none;');
          $('#idassetDetailsN').attr('style','pointer-events: none;');
          $('.assetEstimate').attr('style','pointer-events: none;');
          $('.assetNameOfOperator').attr('style','pointer-events: none;');
          $('.assetPhone').attr('style','pointer-events: none;');
          $('.assetOwner').attr('style','pointer-events: none;');
          $('.assetPlate').attr('style','pointer-events: none;');
          $('.assetDescription').attr('style','pointer-events: none;');
          $('.personEmpIds').attr('style','pointer-events: none;');
          $('.personName').attr('style','pointer-events: none;');
          $('.perJobTitle').attr('style','pointer-events: none;');
          $('.perMobile').attr('style','pointer-events: none;');
          $('.circumDescrOne').attr('style','pointer-events: none;');
          $('.circumDescrTwo').attr('style','pointer-events: none;');
          $('.circumDescrThree').attr('style','pointer-events: none;');
          $('.circumDescrFour').attr('style','pointer-events: none;');
          $('.circumDescrFive').attr('style','pointer-events: none;');
          $('.circumDescrOne').attr('style','pointer-events: none;');
        //  $('#immuediateCause').attr('style','pointer-events: none;');
        //  $('#possibleCause').attr('style','pointer-events: none;');
         // $('#contributingCause').attr('style','pointer-events: none;');
          $('#rootCause').attr('style','pointer-events: none;');
          $('.initialfilerequire').attr('style','pointer-events: none;');
          $('.docfileupload').attr('style','pointer-events: none;');
          $('.uploadFile').attr('style','pointer-events: none;');
          $('#idhazardIdentyY').attr('style','pointer-events: none;');
          $('#idhazardIdentyN').attr('style','pointer-events: none;');
          $('.activePreventive').attr('style','pointer-events: none;');
          $('.activeResponName').attr('style','pointer-events: none;');
          $('.attachDescription').attr('style','pointer-events: none;');
          $('.datepick').attr('style','pointer-events: none;');
          $('#idaccidentAvoidY').attr('style','pointer-events: none;');
          $('#idaccidentAvoidN').attr('style','pointer-events: none;');
         // $('#recommendation').attr('style','pointer-events: none;');
          $('#eventDate').attr('style','pointer-events: none;');
          $('#eventLocation').attr('style','pointer-events: none;');
          $('#eventTime').attr('style','pointer-events: none;');
          $('#specificLocation').attr('style','pointer-events: none;');
          $('#specificlocother').attr('style','pointer-events: none;');
          $('#idworkrelatedY').attr('style','pointer-events: none;');
          $('#idworkrelatedN').attr('style','pointer-events: none;');
          $('.incidentClass').attr('style','pointer-events: none;');
          $('.SupervisorempIds').attr('style','pointer-events: none;');
          $('.SupervisorempName').attr('style','pointer-events: none;');
          $('.mobile').attr('style','pointer-events: none;');
          $('.invesEmployeeName').attr('style','pointer-events: none;');
          $('.empMobile').attr('style','pointer-events: none;');
          $('#idauthorityzY').attr('style','pointer-events: none;');
          $('#idauthorityzN').attr('style','pointer-events: none;');
          $('#idInjuredY').attr('style','pointer-events: none;');
          $('#idInjuredN').attr('style','pointer-events: none;');
          $('.injuredEmpName').attr('style','pointer-events: none;');
          $('.age').attr('style','pointer-events: none;');
          $('.jobTitle').attr('style','pointer-events: none;');
          $('.citizenship').attr('style','pointer-events: none;');
          $('.injuredIdType').attr('style','pointer-events: none;');
          $('.passportNo').attr('style','pointer-events: none;');
          $('.injuredCompanyName').attr('style','pointer-events: none;');
          $('.InjuryType').attr('style','pointer-events: none;');
          $('.bodyPart').attr('style','pointer-events: none;');
          $('.SubbodyPart').attr('style','pointer-events: none;');
          
           
           $('#save').hide();
           $('#saved').hide();
           $('#addSuperDet').hide();
           $('.addInvestigationDet').hide();
           $('.addInjuredDet').hide();
           $('.addAssetDet').hide();
           $('.addPersonInter').hide();
           $('.addCircumstance').hide();
           $('.addActionPlanDet').hide();
           $('.AtarPageInsert').hide();
           $('.addAttachDetails').hide();


       }
       if(SUMBIT_PROCESS == '4' && deptId == '1' && userType == "9"){
         $('.approved').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('.row headingStylss').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();
       }
       if(locationId == '1' ){
         if(SUMBIT_PROCESS == '3' && roleId == "22" && userType == "8"){
         $('.verified').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('.row headingStylss').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();
       }
      }
       else if(locationId == '2' ){
          // alert(1);
         if(SUMBIT_PROCESS == '3' && roleId == "18" && userType == "8"){
            // alert(2);
         $('.verified').removeClass('d-none');
         $('.Approvesubmit').removeClass('d-none');
         $('.row headingStylss').removeClass('d-none');
         $('#save').hide();
         $('#saved').hide();
       }
      }
        

       $('#review_save').on('click' , function(){
           if($('#investformReview').valid()){
           swal({
         title: "Please wait..",
         imageUrl: loadingImg,
         showConfirmButton: false,
         allowOutsideClick: false
     });
          $('#investformReview').submit();
      }
       });



   
   // Save Draft All process .

//    $('#saved').on('click' , function(){
//      
//    });


    // Validation about Moblie 

    
   $(document).on('keydown', '.assetOwner', function(e) { 
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.assetPlate', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })  
   $(document).on('keydown', '.assetEstimate', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   
   $(document).on('keydown', '.personEmpIds', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   
   $(document).on('keyup', '.age', function(e) {
         var alt = $(this).attr('alt');
         var ageValue = $('#age'+alt).val();
                  if (ageValue > 100) {
                      alert('Age Value Must Less Than 100');
                     $("#age"+alt).val('');
                  }
           }); 
  
 
   $(document).on('keydown', '.assetNameOfOperator', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.SupervisorempIds', function(e) {
      //injuredCompanyName1 alert(1);
      var a = e.key;
      if (a.length == 1) return /[A-Z0-9/.,%()]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.injuredCompanyName', function(e) {
      //injuredCompanyName1 alert(1);
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.passportNo', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Z0-9/.,%()]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.injuredEmpName', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.jobTitle', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.citizenship', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.SupervisorempName', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Z/.,%() ]|&/i.test(a);
      return true;
   })
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
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.assetDescription', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]/i.test(a); 
      return true;
   })
   $(document).on('keydown', '.activePreventive', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0%().?,-9 A-Z_-]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.circumDescrOne', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0%().?,-9 A-Z_-]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.circumDescrTwo', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0%().?,-9 A-Z_-]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.circumDescrThree', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0%().?,-9 A-Z_-]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.circumDescrFour', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0%().?,-9 A-Z_-]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.circumDescrFive', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0%().?,-9 A-Z_-]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.attachDescription', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0%().?,-9 A-Z_-]|&/i.test(a);
      return true;
   })
//   $(document).on('keydown', '.activity', function(e) {
//      var a = e.key;
//      if (a.length == 1) return /[+0.?,-9A-Z_-]|&/i.test(a);
//      return true;
//   })
//   $(document).on('keydown', '.empcont', function(e) {
//      var a = e.key;
//      if (a.length == 1) return /[+0.?,-9A-Z_-]|&/i.test(a);
//      return true;
//   })
//   $(document).on('keydown', '#authorityInvolved', function(e) {
//      var a = e.key;
//      if (a.length == 1) return /[+0.?,-9A-Z_-]|&/i.test(a);
//      return true;
//   })
//   $(document).on('keydown', '#description', function(e) {
//      var a = e.key;
//      if (a.length == 1) return /[+0.?,-9A-Z_-]|&/i.test(a);
//      return true;
//   })
//   $(document).on('keydown', '#immuediateCause', function(e) {  
//      var a = e.key;
//      if (a.length == 1) return /[+0.?,-9A-Z_-]|&/i.test(a);
//      return true;
//   })
//   $(document).on('keydown', '#possibleCause', function(e) {  
//      var a = e.key;
//      if (a.length == 1) return /[+0.?,-9A-Z_-]|&/i.test(a);
//      return true;
//   })
//   $(document).on('keydown', '#contributingCause', function(e) {  
//      var a = e.key;
//      if (a.length == 1) return /[+0.?,-9A-Z_-]|&/i.test(a);
//      return true;
//   })
//   $(document).on('keydown', '#recommendation', function(e) {  
//      var a = e.key;
//      if (a.length == 1) return /[+0.?,-9A-Z_-]|&/i.test(a);
//      return true;
//   })
   $(document).on('keydown', '.bodyPart', function(e) {  
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   $(document).on('keydown', '.SubbodyPart', function(e) {  
      var a = e.key;
      if (a.length == 1) return /[A-Za-z0-9/,.()%&_<>\- ]|&/i.test(a);
      return true;
   })
   

   
    // AttachedDetal file Remove .

    $(document).on('click','.remove',function(){
        $(this).hide();
        $(this).parent().children('.existing_file').hide();
        $(this).parent().children('[type="file"]').show();
        $(this).parents('tr').find('.AttachedDetal').html('<td style="color:red">Upload is required</td>');

    });

    // Root file Remove

    $(document).on('click','.remove1',function(){
        $(this).hide();
        $(this).parent().children('.existing_file').hide();
        $(this).parent().children('[type="file"]').show();
        $(this).parents('div').find('.rootCauseAnly').html('<td style="color:red">Root cause analysis is required</td>');

    });
    
    
   $(document).on('click','.note-icon-picture',function(){ 
      $('.removeSumm').removeClass('d-none');
//      $('#innvesticationSum').summernote('reset');
//        $('#docfileuploadincidentTeam').summernote('reset');
   });
    
   $(document).on('click','.removeSumm',function(){ 
      $('.note-icon-picture').trigger('click');
        $('#innvesticationSum').summernote('reset');
        $('#docfileuploadincidentTeam').summernote('reset');
        $('#innvesticationSum').code('');
        $('#docfileuploadincidentTeam').code('');
        $('#innvesticationSum').val("");
        $('.innvesticationSum').val("");
       $('#docfileuploadincidentTeams').attr('src', '');
       $('#docfileuploadincidentTeam').attr('src', '');
       
       $('#innvesticationSum').summernote('reset');
       $('#docfileuploadincidentTeam').summernote('reset');
       $('#innvesticationSum').val('');
       $('.note-toolbar card-header').hide();
       $('.note-control-selection-bg').hide();
       $('.note-editable card-block').hide();
       $('.note-editable card-block').hide();
        $('#docfileuploadincidentTeam').hide();
        $('#docfileuploadincidentTeams').hide();
        
        $('#innvesticationSum').hide();
        $('#innvesticationSum').addClass('d-none');
        $('#docfileuploadincidentTeam').addClass('d-none');
        $('.docfileupload').addClass('d-none');
        
    }); 
    $(document).on('click','.removeSummRy',function(){ 
       $('.note-toolbar card-header').hide();
       $('.note-control-selection-bg').hide();
       $('.note-editable card-block').hide();
       $('.note-editable card-block').hide();
        $('#docfileuploadincidentTeam').hide();
        $('#docfileuploadincidentTeams').hide();
        $('#innvesticationSum').hide();
        $('#innvesticationSum').addClass('d-none');
        $('#docfileuploadincidentTeam').addClass('d-none');
        $('.docfileupload').addClass('d-none');
        
    }); 

    $(document).on('click' , '.AtarPageInsert' , function(){
		$('.test').removeClass('d-none');
		var investId = '<?php echo $id; ?>';
		var alt = $(this).attr('alt');
		var activePreventive = $('#activePreventive'+alt).val();
		var attr_r = $(this).attr('attr_r');
		var attr_oldcapa = $(this).attr('attr_oldcapa');
		$("#AtarPageInsertId"+alt).val(1);
		// alert(activePreventive);return false;
		var url = "<?php echo BASE_URL() . "incident/SendToATARDetails" ?>";
		var data = {investId:investId, activePreventive:activePreventive,attr_r:attr_r,attr_oldcapa:attr_oldcapa,'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
		$("#AtarPageInsert"+alt).attr('style','pointer-events: none;');
		$( "#AtarPageInsert"+alt ).tooltip({
		content: "<strong>Hi!</strong>",
		track:true
		});
		$.ajax({
		type : 'post',
		url : url,
		data: data,
		cache: false,
		success : function(data)
		{
		$('.alert-msg').html('<span style="color:green;">ATAR Send Successfully!</span>');
		$(".alert-msg").show().delay(2500).fadeOut();
		setTimeout(function(){
		$('#draggable3').modal('toggle');
		$(".modal-fade").modal("hide");
		$(".modal-backdrop").remove();
		setTimeout(function(){
		}, 500);
		}, 1000);
		}

});
});

$(document).on('keyup','.activePreventive',function(){

var alt = $(this).attr('alt');
var valOfcaPa = $(this).val();
// $("#AtarPageInsertId"+alt).val(0);
var AtarPageInsertId = $('#AtarPageInsertId'+alt).val();
//alert(valOfcaPa);
if(valOfcaPa == '' && AtarPageInsertId == '1'){
//alert(1);
$("#AtarPageInsert"+alt).attr('style','pointer-events: none;');
$( "#AtarPageInsert"+alt ).tooltip({
content: "<strong>Hi!</strong>",
track:true
});
}
else if(AtarPageInsertId == '1'){
$("#AtarPageInsert"+alt).attr('style','pointer-events: none;');
$( "#AtarPageInsert"+alt ).tooltip({
content: "<strong>Hi!</strong>",
track:true
});
}
else{
$("#AtarPageInsert"+alt).attr('style','pointer-events: auto;');
$( "#AtarPageInsert"+alt ).tooltip({
content: "<strong>Hi!</strong>",
track:true
});
}
});

    var specificLocation = '<?php echo $speclocid; ?>'; 
     if(specificLocation === '-1'){
              // alert(2);
               $('.specificlocotherss').removeClass('d-none');
           }
           else{
               //alert(1);
               $('.specificlocotherss').addClass('d-none');
           }

    $('#specificLocation').on('change' , function(){
           var specificLocation = $(this).val();
           
           if(specificLocation === '-1'){
              // alert(2);
               $('.specificlocotherss').removeClass('d-none');
           }
           else{
               //alert(1);
               $('.specificlocotherss').addClass('d-none');
           }
    });
    
    
   var eventLocation = '<?php echo $locid; ?>';
   //alert(eventLocation); 
      if(eventLocation !=''){
          getSpecificLocatDetailss(eventLocation); 
      }
        
        $(document).on('change','#eventLocation', function(){
            var eventLocation = $(this).val();
            getSpecificLocatDetailss(eventLocation);
          });
          
            //alert(1);
           
           function getSpecificLocatDetailss(eventLocation){
               
           var url = "<?php echo BASE_URL() . "incident/SpecificLocatDetails" ?>";
           var data = {eventLocation:eventLocation, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
           
           $.ajax({
              type : 'post',
              url : url,
              data: data,
              cache: false,
              success : function(data) 
              {
              $('#specificLocation').html(data);
              var specificLocation = '<?php echo $speclocid; ?>';
              //alert(specificLocation); 
                   if (specificLocation != '') {
                       $('#specificLocation').val(specificLocation); 
                       $('#specificLocation option[value=' + specificLocation + ']').attr('selected', 'selected');
                   } 
              
              }
          });
           }
      

    // Classification Checked details

    <?php if(isset($checkClassify)) {

    foreach ($checkClassify as $key => $value) { ?>

     var checkValues = '<?php echo $value; ?>';

     $('input[name="CLASSFICATION_MST_ID['+checkValues+']"]').prop('checked', true);

    
    <?php  } } ?>

   
   });
</script>

