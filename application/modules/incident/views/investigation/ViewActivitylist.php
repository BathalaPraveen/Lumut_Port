

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
/*tthead{
        width:28%;
    }*/
   
</style>
<?php
   
  //echo 'M<pre>';print_r($activityList);exit;
   $userName = $_SESSION['emp_details']->EMP_NAME;
   $currentDate = date('d-m-Y h:i:s');
  // echo 'M<pre>';print_r($userName);exit;
   $eventDate = postData($editData, 'eventDate', $this->input->post('eventDate'));
   $INCIDENT_ID = postData($editData, 'INCIDENT_ID', $this->input->post('INCIDENT_ID'));
   $eventTime = postData($editData, 'EVENT_TIME', $this->input->post('eventTime'));
   $locid = postData($editData, 'LOCATION_ID', $this->input->post('eventLocation'));
   $speclocid = postData($editData, 'SPECIFIC_LOCATION_ID', $this->input->post('specificLocation'));

      if($speclocid == '-1'){
          $SpecificVal = 'Others';
      }
      else{
         $SpecificVal =  $detail['SpecificLoc']['SPECIFIC_LOC_NAME'];
      }
   $speclocother = postData($editData, 'SPECIFIC_LOCATION_OTHER', $this->input->post('specificlocother'));
   
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
                           <a href="<?php echo BASE_URL('incident') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                        </div>
                     </div>
                     <div class="card-body">
                        
                        <div class="card ">
                           <div class="card-header ">
                              <a class="card-link " href="javascript:void(0)" >
                              1. Activity Audits<span class="float-right"></span>
                              </a>
                           </div>
                           <div id="section_1" class="collapse multi-collapse show" data-parent="#accordion">
                              <div class="card-body">
                                 <div class="row">
                                   
                                       <table class="table table-striped">
                                          <tr>
                                            <th class="tthead">INCIDENT ID</th>
                                            <th class="tthead">USER ID</th>
                                            <th class="tthead">User Name </th>
                                            <th class="tthead">MODULE</th>
                                            <th class="tthead">PROCESS</th>
                                            <th class="tthead">DATE</th>
                                            </tr>
                                          <?php  foreach($activityList as $al) { ?>
                                            <tr>
                                           <td> <?php echo $al['INCIDENT_NOTIFY_ID']; ?></td>
                                           <td> <?php echo $al['ID']; ?></td>
                                          <?php if($al['UserNameEmp'] != ""){ ?>
                                            <td> <?php echo $al['UserNameEmp']; ?></td>
                                              <?php } else{ ?>
                                            <td> <?php echo $al['UserNameCon']; ?></td>
                                             <?php } ?>
                                      
                                          <td><?php echo $al['MODULE']; ?></td>
                                          <td><?php echo $al['PROCESS']; ?></td>
                                          <td><?php $createOn = date('d-m-Y H:i:s',strtotime($al['CREATED_ON']));
                                           echo $createOn; ?></td>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="Rowhide'+i+'"><td><label>Employee id</label><input type = "text"  alt="'+i+'" name= "superiorDatas['+i+'][supEmployeeId]" class="form-control SupervisorempIds" id="SupervisorempIds'+i+'" value=""></td><td><label>Name </label><input type = "text" name= "superiorDatas['+i+'][supEmployeeName]" class="form-control SupervisorempName" id="SupervisorempName'+i+'" value=""></td><td><label>Phone </label><input type = "text" name= "superiorDatas['+i+'][mobile]" class="form-control mobile" id="mobile'+i+'" value=""><td><label>Present</label><div><div class="form-check-inline"><input class="form-check-input" type="radio" value="Y" id="idsuperiorPresentY'+i+'" name="superiorDatas['+i+'][present]" ><label class="form-check-label" for="idsuperiorPresentY">Yes</label></div><div class="form-check-inline"><input class="form-check-input" type="radio" value="N" id="idsuperiorPresentN'+i+'"   name="superiorDatas['+i+'][present]"><label class="form-check-label" for="idsuperiorPresentN">No</label></div></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                        $('<tr id="RowInterView'+i+'"><td><label>Employee id </label><input type = "text" alt="'+i+'" name= "personDatas['+i+'][perEmployeeId]" class="form-control personEmpIds" id="personEmpIds'+i+'" value=""></td><td><label>Name </label><input type = "text" name= "personDatas['+i+'][perEmployeeName]" class="form-control personName" id="personName'+i+'" value=""></td><td><label>Job Title </label><input type = "text" name= "personDatas['+i+'][personJobTitle]" class="form-control perJobTitle" id="perJobTitle'+i+'" value=""></td><td><label>Phone </label><input type = "text" name= "personDatas['+i+'][personMobile]" class="form-control perMobile" id="perMobile'+i+'" value=""></td>div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                        $('<tr id="Rowperson'+i+'"><td><label>Employee name</label><div><select class="form-control invesEmployeeName" alt="'+i+'" name="invesEmployeeInform['+i+'][employeeInvesName]"> <option value="">Select - Emp </option><?php foreach($employeeNameDetails as $em){?><option value="<?php echo $em['EMP_AUTO_ID']?>" <?php echo (isset($detail['investigationAllDetails'][$i])&&$detail['investigationAllDetails'][$i]['EMP_AUTO_ID']==$em['EMP_AUTO_ID'])?"selected":''?>><?php echo $em['EMP_NAME']?></option><?php } ?></select></div></td><td><label>Employee Id </label><div><input type = "text" alt="'+i+'" name= "invesEmployeeInform['+i+'][invesEmployeeid]" class="form-control InvesEmployeeId" id="InvesEmployeeId'+i+'" value="" readonly></div></td><td><label>Designation</label> <div><input type = "text" alt="'+i+'" name= "invesEmployeeInform['+i+'][invesDesignation]" class="form-control invesDesignation" id="invesDesignation'+i+'" value="" readonly></div> <input type = "hidden" alt="'+i+'" name= "invesEmployeeInform['+i+'][invesDesignationId]" class="form-control invesDesignationId" id="invesDesignationId'+i+'" value="" readonly></td><td><label>Phone No</label><div><input type = "text"  alt="'+i+'" name= "invesEmployeeInform['+i+'][empMobile]" class="form-control empMobile" id="empMobile'+i+'" value=""></div></td><div class="col-md-3"><td><button type="button" alt="'+i+'" class="fa fa-trash delete" id="delete" title="Delete file"></button></td></div></tr>').appendTo(scntDiv);
                      
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

