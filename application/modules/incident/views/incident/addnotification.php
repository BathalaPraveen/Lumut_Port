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
     .rootUps {
    width: 220%;
    height: 100%;
}
.sizeChnRq {
    font-size: 15.5px;
}
.sizeChnRqq {
    font-size: 15px;
}
</style>
<?php
//echo 'M<pre>';
//print_r($editData);exit;
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
    $reportedIDNo = postData($userDetails, 'ID_NUMBER', $this->input->post('reported_icpassno'));
    $reportedPhno = postData($userDetails, 'PHONE_NUMBER', $this->input->post('reported_phoneno'));
}
//$SPECIFIC_LOCATION_ID = postData($editData,'SPECIFIC_LOCATION_ID',$this->input->post('SPECIFIC_LOCATION_ID'));
$SPECIFIC_LOCATION_OTHER = postData($editData,'SPECIFIC_LOCATION_OTHER',$this->input->post('SPECIFIC_LOCATION_OTHER'));
$ReportedId = $_SESSION['userinfo']->USERNAME;
$eventDate = postData($editData, 'eventDate', $this->input->post('eventDate'));
$POLICE_CASE_NO = postData($editData, 'POLICE_CASE_NO', $this->input->post('POLICE_CASE_NO'));
$POLICE_OTHER_INFO = postData($editData, 'POLICE_OTHER_INFO', $this->input->post('POLICE_OTHER_INFO'));
$HOSPITAL_CASE_NO = postData($editData, 'HOSPITAL_CASE_NO', $this->input->post('HOSPITAL_CASE_NO'));
$HOSPITAL_OTHER_INFO = postData($editData, 'HOSPITAL_OTHER_INFO', $this->input->post('HOSPITAL_OTHER_INFO'));

$OTHER_CASE_NO = postData($editData, 'OTHER_CASE_NO', $this->input->post('OTHER_CASE_NO'));
$OTHER_OTHER_INFO = postData($editData, 'OTHER_OTHER_INFO', $this->input->post('OTHER_OTHER_INFO'));
//echo '<pre>';print_r($POLICE_CASE_NO);exit; 
$eventTime = postData($editData, 'EVENT_TIME', $this->input->post('eventTime'));
$locid = postData($editData, 'LOCATION_ID', $this->input->post('eventLocation'));
$speclocid = postData($editData, 'SPECIFIC_LOCATION_ID', $this->input->post('specificLocation'));
$speclocother = postData($editData, 'SPECIFIC_LOCATION_OTHER', $this->input->post('specificlocother'));
$eventRelatedList = (postData($editData, 'EVENT_RELATED_TO_IDS', '') != "") ? explode(',', postData($editData, 'EVENT_RELATED_TO_IDS')) : ((!empty($this->input->post('eventRelatedTo'))) ? $this->input->post('eventRelatedTo') : []);
$eventTypeList = (postData($editData, 'EVENT_TYPE_IDS', '') != "") ? explode(',', postData($editData, 'EVENT_TYPE_IDS')) : ((!empty($this->input->post('eventType'))) ? $this->input->post('eventType') : []);
$notifyAttachments = postData($editData, 'notifyAttachments');
$personsInvolved = postData($editData, 'persons');
$desc = postData($editData, 'EVENT_DESC', $this->input->post('description'));
$immedActon = postData($editData, 'IMMEDIATE_ACTION_TAKEN', $this->input->post('immediateAction'));
$equiinvolve = postData($editData, 'EQUIPMENT_INVOLVED', $this->input->post('equipmentInvolved'));
$policecheck = postData($editData, 'POLICE', $this->input->post('police_check'));
$policecheckY = ($policecheck == 'Y') ? 'checked' : '';
$policecheckN = ($policecheck == 'N') ? 'checked' : '';
$hospcheck = postData($editData, 'HOSPITAL', $this->input->post('hospital_check'));
$hospcheckY = ($hospcheck == 'Y') ? 'checked' : '';
$hospcheckN = ($hospcheck == 'N') ? 'checked' : '';
$othercheck = postData($editData, 'OTHER', $this->input->post('other_check'));
$othercheckY = ($othercheck == 'Y') ? 'checked' : '';
$othercheckN = ($othercheck == 'N') ? 'checked' : '';
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
?>
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <section class="content">
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
				$action = (isset($id) && $id != "") ? 'incident/initialsave/' . $id : 'incident/initialsave';
				$attr = [
				    'class' => 'form-horizontal',
				    'id' => 'notifyform',
				    'autocomplete' => 'off'
				];
				echo form_open_multipart($action, $attr);
				?>
				<div class="card ">
                                    <div class="card-header ">
                                        <a class="card-link " href="javascript:void(0)" >
                                            Event Report To: LMTSB HSSE DIVISION<span class="float-right"></span>
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
							'value' => $eventDate
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
							'readonly' => true,
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
                                                <select  class="form-control specificLocation"  name="specificLocation" id="specificLocation" >
                                                    <option value="">Select</option>
                                                </select>  
                                                <br>
                                                 <div class="specificlocotherss d-none">
                                               <input type = "text"  name= "specificlocother" class="form-control specificlocother" id="specificlocother" value="<?php echo isset($SPECIFIC_LOCATION_OTHER)?$SPECIFIC_LOCATION_OTHER:''?>">
                                                
                                                 <br>
                                                
                                                </div>
                                            </div>
                                                
                                     
                                               
                                                
                                                
						
					   
						<div class="col-md-12">
						    <label>Event Related to <?php echo REQUIRED; ?></label>
						    <!-- Button trigger modal -->
						    <span data-toggle="modal" data-target="#eventrelatedmodal" title="Glossary of incident related terms"><i class="fa fa-arrow-down text-primary"></i></span><br>
						    <?php
						    foreach ($getEventRelate as $key => $value) {
							$listID = postData($value, 'INCIDENT_EVENT_ID');
							$listName = postData($value, 'INCIDENT_EVENT_NAME');
							$checked = (in_array($listID, $eventRelatedList)) ? 'checked' : '';
							?>
    						    <div class="form-check-inline">
    							<input class="form-check-input" type="checkbox" value="<?php echo $listID; ?>" name="eventRelatedTo[]" id="eventRelatedCheck<?php echo $listID; ?>" <?php echo $checked; ?>>
    							<label class="form-check-label" for="eventRelatedCheck<?php echo $listID; ?>">
								<?php echo $listName; ?>
    							</label>
    						    </div>
							<?php
						    }
						    ?>
						    <span class="error eventrelateError"></span>
						</div>
					    </div>
					    <div class="row mt-2">
						<div class="col-md-12">
						    <label>Event Type <?php echo REQUIRED; ?></label><br>
						    <?php
						    foreach ($getEventType as $key => $value) {
							$checked = (in_array($key, $eventTypeList)) ? 'checked' : '';
							?>
    						    <div class="form-check-inline">
    							<input class="form-check-input" type="checkbox" value="<?php echo $key; ?>" name="eventType[]" id="eventTypeCheck<?php echo $key; ?>"  <?php echo $checked; ?>>
    							<label class="form-check-label" for="eventTypeCheck<?php echo $key; ?>">
								<?php echo $value; ?>
    							</label>
    						    </div>
							<?php
						    }
						    ?>
						    <span class="error eventtypeError"></span>
						</div>
					    </div>
					    <div class="row mt-2">
						<div class="col-md-12">
						    <label>Event Description <?php echo REQUIRED; ?></label><br>
						    <?php
						    $data = [
							'name' => 'description',
							'class' => 'form-control',
							'rows' => 3, 
							'value' => $desc
						    ];
						    echo form_textarea($data);
						    ?>
                                                    <?php echo form_error('description', '<div class="error">', '</div>'); ?> 
                                                  <span class="red "></span>
                                                                                                        

						</div>
					    </div>
					    <div class="row mt-2">
						<div class="col-md-12">
						    <label>Upload Photo<?php echo REQUIRED; ?></label>	
						    <div class="btn btn-primary btn-sm addImage">Add +</div>					    
						</div>
					    </div>
					    <div class="row fileuploadrow">
						<?php
                                                //echo '<pre>';print_r($notifyAttachments);exit; 
						if ($notifyAttachments) {
						    foreach ($notifyAttachments as $key => $notifyatt) {
							$filepath = BASE_URL . postData($notifyatt, 'fileset');
							?>
							
                                                
                                                         <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img class="rootUps" src="<?php echo $filepath; ?>"></div>
                    <div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
                            <span class=" btn btn-sm btn-primary fileinput-new">Upload attachment</span>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" name="photos[]" accept="image/*" class="initialfilerequire" accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                        <span class="AttachedDetal"></span>
                                       <span class="error idtype1error"></span> 
                    </div>
                </div>      
            </div>
                                                
							<?php
						    }
						} else {
						    ?>
    						<div class="col-md-3">
    						    <div class="fileinput fileinput-new" data-provides="fileinput">
    							<div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="https://www.placehold.it/230x140/EFEFEF/AAAAAA&text=no+image" /></div>
    							    <div style="display: inline-block;float:left;margin-right:5px;">
                                                             <span class="btn-file" style="display: inline-block;">
    								<span class=" btn btn-sm btn-primary fileinput-new">Upload attachment</span>
    								<span class="btn btn-sm btn-warning fileinput-exists">Change</span>
    								<input type="file" name="photos[]" accept="image/*" class="initialfilerequire" accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="true" data-msg-required="Please upload document">
    							    </span>
    							    <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
    							</div>
    						    </div>
    						    <span class="error fileuploaderror"></span>
    						</div>
						    <?php
						}
						?>
					    </div>
                                            

                                            
					    <div class="row mt-2">
						<div class="col-md-12">
						    <label>Immediate Action Taken</label><br>
						    <?php
						    $data = [
							'name' => 'immediateAction',
							'id' => 'immediateAction',
							'class' => 'form-control',
							'rows' => 3,
							'value' => $immedActon
						    ];
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
					    Person(s) Involved <span class="float-right"><div class="btn btn-warning btn-sm addPerson">Add +</div></span>
                                        </a>
                                    </div>
                                    <div id="section_2" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
					    <div class="row">
						<div class="col-md-12 personsections">
						    <?php
						    if ($personsInvolved) {
							$i = 1;
                                                        $j = 0;
							foreach ($personsInvolved as $key => $persons) {
                                                            //echo 'M<pre>';print_r($persons);exit;
							    $pcheckIC = (postData($persons, 'ID_TYPE') == 'ICNO') ? 'checked' : '';
							    $pcheckPSP = (postData($persons, 'ID_TYPE') == 'Passport') ? 'checked' : '';
							    ?>
							    <table class="table table-bordered personstable">
                                                                <tbody id="UniqueRwId<?php echo $i; ?>">
								<tr id="RowHidePerson<?php echo $i; ?>">
								    <td><label class="sizeChnRq">Name <?php echo REQUIRED; ?></label></td>
								    <td>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][name]',
										'id' => 'personsname1',
										'class' => 'form-control personsname',
                                                                                'minlength' => '2',
                                                                                'maxlength' => '50',
										'value' => postData($persons, 'PERSON_NAME', '')
									    ];
									    echo form_input($data);
									    ?>
									</div>

								    </td>
								    <td><label class="sizeChnRq">Company <?php echo REQUIRED; ?></label></td>
								    <td>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][cmp]',
										'id' => 'personscmp1',
										'class' => 'form-control personscmp',
										'value' => postData($persons, 'COMPANY', '')
									    ];
									    echo form_input($data);
									    ?>
									</div>
								    </td>
								    <td rowspan="4" style="vertical-align: middle;">

								    </td>
								</tr>
								<tr>
								    <td><label class="sizeChnRqq">Designation/Occupation<?php echo REQUIRED; ?></label></td>
								    <td>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][desgn]',
										'id' => 'personsdesgn1',
										'class' => 'form-control personsdesgn',
										'value' => postData($persons, 'DESINATION', '')
									    ];
									    echo form_input($data);
									    ?>
									</div>
								    </td>
								    <td><label class="sizeChnRq">Activity Being Performed<?php echo REQUIRED; ?></label></td>
								    <td>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][activity]',
										'id' => 'personsactvty1',
										'class' => 'form-control personsactvty',
										'rows' => 3,
										'value' => postData($persons, 'ACTIVITY_BEING_PERFOMED', '')
									    ];
									    echo form_textarea($data);
									    ?>
									</div>
								    </td>
								</tr>
<!--								<tr>
								    <td colspan="4" class="text-center">
									<label>Person's Details <?php echo REQUIRED; ?></label>
								    </td>
								</tr>-->
								<tr>
								    <td><label class="sizeChnRq">Ic/Passport number <?php echo REQUIRED; ?></label></td>
								    <td>
									<div class="form-check-inline">
									    <input class="form-check-input" type="radio" value="ICNO" id="idtype1ICNO" name="persons[<?php echo $i; ?>][idtype]" <?php echo $pcheckIC; ?>>
									    <label class="form-check-label" for="idtype1ICNO">
										IC
									    </label>
									</div>
									<div class="form-check-inline">
									    <input class="form-check-input" type="radio" value="Passport" id="idtype1pass" name="persons[<?php echo $i; ?>][idtype]" <?php echo $pcheckPSP; ?>>
									    <label class="form-check-label" for="idtype1pass">
										Passport
									    </label>
									</div>
									<span class="error idtype1error"></span>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][idcard]',
										'id' => 'personsidcard1',
										'class' => 'form-control personsidcard',
                                                                                'maxlength' => '15',
										'value' => postData($persons, 'IC_PASSPORT_NO', '')
									    ];
									    echo form_input($data);
									    ?>
									</div>
								    </td>
								    <td><label class="sizeChnRq">Phone no <?php echo REQUIRED; ?></label></td>
								    <td>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][phone]',
										'id' => 'personsphone1',
										'class' => 'form-control personsphone',
                                         'maxlength' => '16',
                                         'minlength' => '10',
										'value' => postData($persons, 'PHONE_NO', '')
									    ];
									    echo form_input($data);
									    ?>
									</div>
								    </td>
                                                            
                                              								</tr>
                                                                                                        <tbody>
							    </table>
							    <?php
							    $i++;
                                                            $j++;
							}
						    } else {
							?>
    						    <table class="table table-bordered personstable">
    							<tr>
    							    <td><label class="sizeChnRq">Name <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][name]',
									    'id' => 'personsname1',
									    'class' => 'form-control personsname',
                                                                            'minlength' => '2',
                                                                             'maxlength' => '50',
									];
									echo form_input($data);
									?>
    								</div>

    							    </td>
    							    <td><label class="sizeChnRq">Company <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][cmp]',
									    'id' => 'personscmp1',
									    'class' => 'form-control personscmp'
									];
									echo form_input($data);
									?>
    								</div>
    							    </td>
    							    <td rowspan="4" style="vertical-align: middle;">
    								

    							    </td>
    							</tr>
    							<tr>
    							    <td><label class="sizeChnRqq">Designation/Occupation <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][desgn]',
									    'id' => 'personsdesgn1',
									    'class' => 'form-control personsdesgn'
									];
									echo form_input($data);
									?>
    								</div>
    							    </td>
    							    <td><label class="sizeChnRq">Activity Being Performed <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][activity]',
									    'id' => 'personsactvty1',
									    'class' => 'form-control personsactvty',
									    'rows' => 3
									];
									echo form_textarea($data);
									?>
    								</div>
    							    </td>
    							</tr>
<!--    							<tr>
    							    <td colspan="4" class="text-center">
    								<label>Person's Details <?php echo REQUIRED; ?></label>
    							    </td>
    							</tr>-->
    							<tr>
    							    <td><label class="sizeChnRq">Ic/Passport number <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div class="form-check-inline">
    								    <input class="form-check-input" type="radio" value="ICNO" id="idtype1ICNO" name="persons[1][idtype]">
    								    <label class="form-check-label" for="idtype1ICNO">
    									IC
    								    </label>
    								</div>
    								<div class="form-check-inline">
    								    <input class="form-check-input" type="radio" value="Passport" id="idtype1pass" name="persons[1][idtype]">
    								    <label class="form-check-label" for="idtype1pass">
    									Passport
    								    </label>
    								</div>
    								<span class="error idtype1error"></span>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][idcard]',
									    'id' => 'personsidcard1',
									    'class' => 'form-control personsidcard',
                                                                            'maxlength' => '15'
									];
									echo form_input($data);
									?>
    								</div>
    							    </td>
    							    <td><label class="sizeChnRq">Phone no <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][phone]',
									    'id' => 'personsphone1',
									    'class' => 'form-control personsphone',
                                                                            'maxlength' => '16',
                                                                            'minlength' => '10',
									];
									echo form_input($data);
									?>
    								</div>
    							    </td>
                                                            
    							</tr>
                                                        <tbody>
    						    </table>
							<?php
						    }
						    ?>

						</div>
					    </div>			    
                                        </div>
                                    </div>
                                </div>
				<div class="card ">
                                    <div class="card-header ">
                                        <a class="card-link " href="javascript:void(0)" >
					    Equipment(s) Involved <span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_3" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
					    <div class="row">
						<div class="col-md-12">
						    <?php
						    $data = [
							'name' => 'equipmentInvolved',
							'id' => 'equipmentInvolved',
							'class' => 'form-control',
							'rows' => 3,
							'value' => $equiinvolve
						    ];
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
					    External Agencies <span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_4" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
					    <div class="row">
						<div class="col-md-3">
						    <label>Title</label>
						</div>
						<div class="col-md-3">
						    <label>Check </label>
						</div>
						<div class="col-md-3">
						    <label>Case No.</label>
						</div>
						<div class="col-md-3">
						    <label>Other Info</label>
						</div>
					    </div>
					    <div class="row">
						<div class="col-md-3">
						    <label>Police</label>
						</div>
						<div class="col-md-3">
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" value="Y" id="policecheckY" name="police_check" <?php echo $policecheckY; ?>>
							<label class="form-check-label" for="policecheckY">
							    Yes
							</label>
						    </div>
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" value="N" id="policecheckN" name="police_check" <?php echo $policecheckN; ?>>
							<label class="form-check-label" for="policecheckN">
							    No
							</label>
						    </div>
                                                    <span class="error idPolicecheck"></span>
						</div>
						<div class="col-md-3 policedivs d-none">
						    <?php
						    $data = [
							'name' => 'police_caseno',
							'id' => 'police_caseno',
							'class' => 'form-control',
                                                        'value' => $POLICE_CASE_NO 
						    ];
						    echo form_input($data);
						    ?>
						</div>
						<div class="col-md-3 policedivs d-none">
						    <?php
						    $data = [
							'name' => 'police_otherinifo',
							'id' => 'police_otherinifo',
							'class' => 'form-control',
							'rows' => 3,
                                                        'value' => $POLICE_OTHER_INFO 
						    ];
						    echo form_textarea($data);
						    ?>
						</div>
					    </div>			    
					    <div class="row mt-2">
						<div class="col-md-3">
						    <label>Hospital</label>
						</div>
						<div class="col-md-3">
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" value="Y" id="hospitalcheckY" name="hospital_check" <?php echo $hospcheckY; ?>>
							<label class="form-check-label" for="hospitalcheckY">
							    Yes
							</label>
						    </div>
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" value="N" id="hospitalcheckN" name="hospital_check" <?php echo $hospcheckN; ?>>
							<label class="form-check-label" for="hospitalcheckN">
							    No
							</label>
						    </div>
                                                    <span class="error idHospitalcheck"></span>
						</div>
						<div class="col-md-3 hospitaldivs d-none">
						    <?php
						    $data = [
							'name' => 'hospital_caseno',
							'id' => 'hospital_caseno',
							'class' => 'form-control',
                                                        'value' => $HOSPITAL_CASE_NO
						    ];
						    echo form_input($data);
						    ?>
						</div>
						<div class="col-md-3 hospitaldivs d-none">
						    <?php
						    $data = [
							'name' => 'hospital_otherinifo',
							'id' => 'hospital_otherinifo',
							'class' => 'form-control',
							'rows' => 3,
                                                        'value' => $HOSPITAL_OTHER_INFO
						    ];
						    echo form_textarea($data);
						    ?>
						</div>
					    </div>			    
					    <div class="row mt-2">
						<div class="col-md-3">
						    <label>Other</label>
						</div>
						<div class="col-md-3">
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" value="Y" id="othercheckY" name="other_check" <?php echo $othercheckY; ?>>
							<label class="form-check-label" for="othercheckY">
							    Yes
							</label>
						    </div>
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" value="N" id="othercheckN" name="other_check" <?php echo $othercheckN; ?>>
							<label class="form-check-label" for="othercheckN">
							    No
							</label>
						    </div>
                                                    <span class="error idOthercheck"></span>
						</div>
						<div class="col-md-3 otherdivs d-none">
						    <?php
						    $data = [
							'name' => 'other_caseno',
							'id' => 'other_caseno',
							'class' => 'form-control',
                                                        'value' => $OTHER_CASE_NO
						    ];
						    echo form_input($data);
						    ?>
						</div>
						<div class="col-md-3 otherdivs d-none">
						    <?php
						    $data = [
							'name' => 'other_otherinifo',
							'id' => 'other_otherinifo',
							'class' => 'form-control',
							'rows' => 3,
                                                        'value' => $OTHER_OTHER_INFO
						    ];
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
					    Event Reported by
                                        </a>
                                    </div>
                                    <div id="section_5" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
					    <div class="row">						
						<div class="col-md-3">
						    <label>Name</label>
						    <?php
						    $data = [
							'name' => 'reported_name',
							'id' => 'reported_name',
							'class' => 'form-control',
							'readonly' => true,
							'value' => $reportedName
						    ];
						    echo form_input($data);
						    ?>
						</div>
						<div class="col-md-3">
						    <label>Company</label>
						    <?php
						    $data = [
							'name' => 'reported_cmp',
							'id' => 'reported_cmp',
							'class' => 'form-control',
							'readonly' => true,
							'value' => $reportedCompany
						    ];
						    echo form_input($data);
						    ?>
						</div>
						<div class="col-md-3">
						    <label>Designation</label>
						    <?php
						    $data = [
							'name' => 'reported_desgn',
							'id' => 'reported_desgn',
							'class' => 'form-control',
							'readonly' => true,
							'value' => $reportedDesignation
						    ];
						    echo form_input($data);
						    ?>
						</div>
						<div class="col-md-3">
						    <label>Activity being performed</label>
						    <?php
						    $data = [
							'name' => 'reported_activity',
							'id' => 'reported_activity',
							'class' => 'form-control',
							'rows' => 3,
							'readonly' => true,
							'value' => $reportedActivity
						    ];
						    echo form_textarea($data);
						    ?>
						</div>
					    </div>			    			    
					     <div class="row">
						<div class="col-md-3">
						    <label>ID Type <?php echo REQUIRED; ?></label><br>
						    <?php
						    $nricno = ($reportedIDtype == 'NRIC') ? 'checked' : '';
						    $passno = ($reportedIDtype == 'Passport') ? 'checked' : '';
						    ?>
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" value="NRIC" id="reportedidtypeICNO" name="reported_ID_TYPE" <?php echo $nricno; ?>  <?php echo $readonly; ?>>
							<label class="form-check-label" for="reportedidtypeICNO">
							    IC
							</label>
						    </div>
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" value="Passport" id="reportedidtypepass" name="reported_ID_TYPE" <?php echo $passno; ?>  <?php echo $readonly; ?>>
							<label class="form-check-label" for="reportedidtypepass">
							    Passport
							</label>
						    </div>
                                                    <span class="error idreportType"></span>
						</div>
						<div class="col-md-3">
						    <label>IC/Passport No.<?php echo REQUIRED; ?></label>
						    <?php
						    $data = [
							'name' => 'reported_icpassno',
							'id' => 'reported_icpassno',
							'class' => 'form-control',
                                                        'maxlength' => '15',
							'value' => $reportedIDNo,
							$required
						    ];
						    if ($readonly2) {
							$data['readonly'] = true;
						    }
						    echo form_input($data);
						    ?>
						</div>
						<div class="col-md-3">
						    <label>Phone No.<?php echo REQUIRED; ?></label>
						    <?php
						    $data = [
							'name' => 'reported_phoneno',
							'id' => 'reported_phoneno',
							'class' => 'form-control',
							'required' => true,
							'value' => $reportedPhno,
                            'maxlength' => '16',
                            'minlength' => '10',
						    ];
						    echo form_input($data);
						    ?>
						</div>
					    </div>			    			    
                                        </div>
                                    </div>
                                </div>
				<div class="row">
				    <div class="col-md-12 text-center">
					<button type="submit" class="btn btn-primary " id="save">Submit</button>
					<button type="reset" class="btn btn-danger ">Reset</button>
					<a href="<?php echo BASE_URL . 'incident'; ?>" class="btn btn-warning ">Cancel</a>
				    </div>
				</div>
				<?php
				echo form_close();
				?>
			    </div>
			</div>			
		    </div>
		</div>
	    </div>
	</section>
	<!-- /.content -->
    </div>
</div>
<!----- popup starts----->
<div class="modal modal-info fade" id="eventrelatedmodal" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
	    <?php $this->load->view('eventRelatedDisplay'); ?>
        </div>
    </div>
</div>
<!----- popup ends----->
<style>
    .fileupload-exists .fileupload-new, .fileupload-new .fileupload-exists {
	display: none;
    }
</style>
<script>
    $(document).ready(function () {
//        $(document).ready(function () {
//          // $(".personsname").keypress(function (e) {
//               $(document).on('keydown', '.personsname', function(e) {
//               var key = e.keyCode;
//               if (key >= 48 && key <= 57) {
//                   e.preventDefault();
//               }
//           });
//       });
      // $(document).on('keydown', '.personsname', function(e) {
     // var a = e.key;
     // if (a.length == 1) return /[A-Z/.,%)(]|&/i.test(a);
      //return true;
 //  }); 
//       $(document).ready(function () {
//          // $(".personsdesgn").keypress(function (e) {
//           $(document).on('keydown', '.personsdesgn', function(e) {
//               //alert(10);
//               var key = e.keyCode;
//               if (key >= 48 && key <= 57) {
//                   e.preventDefault();
//               }
//           });
//       });
       
      // $(document).on('keydown', '.personscmp', function(e) {
      //var a = e.key;
     // if (a.length == 1) return /[A-Z0-9/.,%)(]|&/i.test(a);
     // return true;
  // }); 
   
  // $(document).on('keydown', '.personsdesgn', function(e) {
     // var a = e.key;
     // if (a.length == 1) return /[A-Z/.,%)(]|&/i.test(a);
    //  return true;
   //}); 
  // $(document).on('keydown', '.personsactvty', function(e) {
    //  var a = e.key;
    //  if (a.length == 1) return /[A-Z/.,%)(]|&/i.test(a);
    //  return true;
  // }); 
	//$(document).on('keydown', '.personsname,.personscmp,.personsdesgn,.personsactvty', function(e) {
      // $.validator.addMethod('alphanumericssss', function (value) {
        //    return /^[A-Za-z0-9/,.()%&_<>\- ]*$/.test(value);
       // }, "Please Enter valid Alphanumeric characters with allowed special charters are /,.()%&_<>\- ");

      // });
   
//       $(document).ready(function () {
//          //$(".personsactvty").keypress(function (e) {
//                $(document).on('keydown', '.personsactvty', function(e) {
//               var key = e.keyCode;
//               if (key >= 48 && key <= 57) {
//                   e.preventDefault();
//               }
//           });
//       });
       $(document).on('keydown', '.personsphone', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0-9]|&/i.test(a);
      return true;
   });
   
   $(document).on('keydown', '.personsidcard', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Z0-9/.,%)(]|&/i.test(a);
      return true;
   });  
   
   $(document).on('keydown', '#reported_icpassno', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Z0-9/.,%)(]|&/i.test(a);
      return true;
   }); 
   
   $(document).on('keydown', '#reported_phoneno', function(e) {
      var a = e.key;
      if (a.length == 1) return /[+0-9]|&/i.test(a);
      return true;
   });
   $(document).on('keydown', '#police_caseno', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Z0-9/.,%)(]|&/i.test(a);
      return true;
   });$(document).on('keydown', '#hospital_caseno', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Z0-9/.,%)(]|&/i.test(a);
      return true;
   });$(document).on('keydown', '#other_caseno', function(e) {
      var a = e.key;
      if (a.length == 1) return /[A-Z0-9/.,%)(]|&/i.test(a);
      return true;
   });
   
   
	var html = '<div class="col-md-3"><div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="https://www.placehold.it/230x140/EFEFEF/AAAAAA&text=no+image" /></div><div>\n\n\<div style="display: inline-block;float:left;margin-right:5px;"><span class="btn-file" style="display: inline-block;"><span class="btn-file"><span class=" btn btn-sm btn-primary fileinput-new">Select image</span><span class="btn btn-sm btn-warning fileinput-exists">Change</span><input type="file" name="photos[]"  accept="image/*" class=""> </span></span><span class="btn btn-sm btn-danger deleteFile">Delete</span></div></div></div></div>';
	$('.addImage').click(function () {
	    var count = $('.fileuploadrow .col-md-3').length;
	    if (count < 5) {
		$('.fileuploadrow').append(html);
	    }
	});
	$(document).on('click', '.deleteFile', function () {
	    $(this).closest('.col-md-3').remove();
	});
	$("#eventDate").datepicker({
	    autoclose: true,
	    format: 'dd-mm-yyyy',
	    orientation: 'bottom',
	    endDate: new Date()
	});
	$('#eventTime').clockpicker({
	    align: 'left',
	    autoclose: true,
	    donetext: 'Done'
	});
	
	$('#personsactvty1').change(function () {
	    var vals = $(this).val();
	    $('#reported_activity').val(vals);
	    $('#reported_activity').html(vals);
	});
	$(document).on('click', '.addPerson', function () {
	    var count = $('.personsections table.personstable').length + 1;
	    var tbhtml = '<table class="table table-bordered personstable"><tbody id="UniqueRwId<?php echo $i; ?>"><tr id="RowHidePerson'+count+'"><td><label>Name</label></td> <td><input type="text" name="persons[' + count + '][name]" value="" id="personsname' + count + '" minlength="2" maxlength="50" class="form-control personsname"></td> <td><label>Company</label></td><td><input type="text" name="persons[' + count + '][cmp]" value="" id="personscmp' + count + '" class="form-control personscmp"> </td><td rowspan="4" style="vertical-align: middle;"><span class="addPerson"></span><br><span class="removePerson"><i class="fa fa-trash trash"></i></span></td></tr><tr> <td><label>Designation / Occupation</label></td><td><input type="text" name="persons[' + count + '][desgn]" value="" id="personsdesgn' + count + '" class="form-control personsdesgn"></td><td><label>Activity Being Performed</label></td> <td><textarea name="persons[' + count + '][activity]" cols="40" rows="3" id="personsactvty' + count + '" class="form-control personsactvty"></textarea> </td></tr> <tr> <td><label>Ic/Passport number</label></td><td><div class="form-check-inline"><input class="form-check-input" type="radio" value="ICNO" id="idtype' + count + 'ICNO" name="persons[' + count + '][idtype]"><label class="form-check-label" for="idtype' + count + 'ICNO">IC </label></div><div class="form-check-inline"> <input class="form-check-input" type="radio" value="Passport" id="idtype' + count + 'pass" name="persons[' + count + '][idtype]"><label class="form-check-label" for="idtype' + count + 'pass">Passport</label></div><input type="text" name="persons[' + count + '][idcard]" value="" id="personsidcard' + count + '" maxlength ="15" class="form-control personsidcard"> </td><td><label>Phone no</label></td><td><input type="text" name="persons[' + count + '][phone]" value="" id="personsphone1" maxlength="16" minlength = "10" class="form-control personsphone"></td></tr></tbody></table>';
	    if (count <= 10) {
		$('.personsections').append(tbhtml);
	    }
	}); 
	$(document).on('click', '.removePerson', function () {
	    $(this).closest('table.personstable').remove();
	});
        var policecheck = '<?php echo $policecheck;?>';
        if (policecheck === 'Y') {
		$('.policedivs').removeClass('d-none');
	    } else {
		$('.policedivs').addClass('d-none');
	    }
        var hospcheck = '<?php echo $hospcheck;?>';
        if (hospcheck === 'Y') {
		$('.hospitaldivs').removeClass('d-none');
	    } else {
		$('.hospitaldivs').addClass('d-none');
	    }
         var othercheck = '<?php echo $othercheck;?>';
         if (othercheck === 'Y') {
		$('.otherdivs').removeClass('d-none');
	    } else {
		$('.otherdivs').addClass('d-none');
	    }
        //alert(policecheck);

	$('[name="police_check"]').change(function () {
	    var vals = $(this).val();
	    if (vals === 'Y') {
		$('.policedivs').removeClass('d-none');
	    } else {
		$('.policedivs').addClass('d-none');
	    }
	});
	$('[name="police_check"]').change(function () {
	    var vals = $(this).val();
	    if (vals === 'Y') {
		$('.policedivs').removeClass('d-none');
	    } else {
		$('.policedivs').addClass('d-none');
	    }
	});
	$('[name="hospital_check"]').change(function () {
	    var vals = $(this).val();
	    if (vals === 'Y') {
		$('.hospitaldivs').removeClass('d-none');
	    } else {
		$('.hospitaldivs').addClass('d-none');
	    }
	});
	$('[name="other_check"]').change(function () {
	    var vals = $(this).val();
	    if (vals === 'Y') {
		$('.otherdivs').removeClass('d-none');
	    } else {
		$('.otherdivs').addClass('d-none');
	    }
	});
	$.validator.messages.accept = 'Accepts only jpg, jpeg, png, gif images';
	$.validator.addClassRules("initialfilerequire", {
	    accept: "png|jpe?g|gif",
	    required: false
	});
        $.validator.addMethod('alphanumeric', function (value) {
            return /^[A-Za-z0-9/,.()%  ]*$/.test(value);
        }, "Please Enter valid Alphanumeric characters with allowed special charters are /,.");
	$("#notifyform").validate({
	    rules: {
		"eventDate": {
		    required: true
		},
		"eventTime": {
		    required: true
		},
		"eventLocation": {
		    required: true
		},
		"specificLocation": {
		    required: true
		},
                "immediateAction":{
                 // alphanumeric:true,
                },
                "equipmentInvolved":{
                  //alphanumeric:true,
                 // required: true
                },
                "police_otherinifo":{
                  // alphanumeric:true,
                },
                "hospital_otherinifo":{
                  // alphanumeric:true,
                },
                "other_otherinifo":{
                   //alphanumeric:true, 
                },
                "reported_phoneno":{
                    required: true,
                },
                
		"specificlocother": {
                   // programming_char:true,
		    required: function () {
			if ($("#specificLocation").val() == '-1') {
			    return true;
			} else {
			    return false;
			}
		    }
                    
		},
		"eventRelatedTo[]": {
		    required: true
		},
		"eventType[]": {
		    required: true
		},
		"description": {
		    required: true
                   // alphanumeric:true,
		},
		"persons[1][name]": {
		    required: true,
		//alphanumericssss: true
		}, 
		"persons[1][cmp]": {
		    required: true,
//alphanumericssss: true
		},
		"persons[1][desgn]": {
		    required: true,
//alphanumericssss: true
		},
		"persons[1][activity]": {
		    required: true,
//alphanumericssss: true
		},
		"persons[1][idtype]": {
		    required: true
		},
		"persons[1][idcard]": {
		    required: true
		},
		"persons[1][phone]": {
		    required: true
		},
                'reported_ID_TYPE':{
                    required: true
                },
                'reported_icpassno':{
                   required: true 
                },
                
                
                
                
                
	    },
	    messages: {
		"eventDate": {
		    required: 'Event Date is required'
		},
		"eventTime": {
		    required: 'Event Time is required'
		},
		"eventLocation": {
		    required: 'Event Location is required'
		},
		"specificLocation": {
		    required: 'Specific Location is required'
		},
		"specificlocother": {
		    required: 'Specific Location is required'
		},
		"eventRelatedTo[]": {
		    required: 'Event Related to is required'
		},
		"eventType[]": {
		    required: 'Event Type is required'
		},
		"description": {
		    required: 'Event Description is required'
		},
		"persons[1][name]": {
		    required: 'Person Name is required'
		},
		"persons[1][cmp]": {
		    required: 'Person Company is required'
		},
		"persons[1][desgn]": {
		    required: 'Person Designation is required'
		},
		"persons[1][activity]": {
		    required: 'Activity Being Performed is required'
		},
		"persons[1][idtype]": {
		    required: 'ID type is required'
		},
		"persons[1][idcard]": {
		    required: 'ID Card is required'
		},
		"persons[1][phone]": {
		    required: 'Phone number is required'
		},
                "reported_phoneno":{
                    required: 'Phone no is required'
                },
//                "equipmentInvolved":{
//                  
//                  required: 'Equipment(s) Involved is required'
//                },
                
                'reported_ID_TYPE':{
                    required: 'ID Type is required'
                },
                'reported_icpassno':{
                   required: 'IC/Passport No is required' 
                },
                
	    },
	    errorPlacement: function (error, element) {
		console.log(element.attr('name'));
		if (element.attr('name') == 'eventRelatedTo[]') {
		    error.appendTo('span.eventrelateError');
		} else if (element.attr('name') == 'eventType[]') {
		    error.appendTo('span.eventtypeError');
		} else if (element.attr('name') == 'persons[1][idtype]') {
		    error.appendTo('span.idtype1error');
		}
                else if (element.attr('name') == 'reported_ID_TYPE') {
		    error.appendTo('span.idreportType');
		}
                
                else {
		    error.appendTo(element.closest('div'));
		}
	    },
	    submitHandler: function (form) {
                swal({
         title: "Please wait..",
         imageUrl: loadingImg,
         showConfirmButton: false,
         allowOutsideClick: false
     });
		form.submit();
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
                   if (specificLocation != '') {
                       $('#specificLocation').val(specificLocation); 
                       $('#specificLocation option[value=' + specificLocation + ']').attr('selected', 'selected');
                   } 
              
              }
          });
           }
           
           // Delete Details

    function deleteColumnForIncident(id,table,pri_clm){
     if(id !='' && table!='' && pri_clm!=''){
//         alert(id);
//         alert(table);
//         alert(pri_clm); 
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
            
    $('.personstable').on('click', ".delete", function(e) {
    //alert(1);
    var id = $(this).attr('attr');
    //alert(id);
    var table = $(this).attr('attr_table');
    //alert(table);
    var alt_del = $(this).attr('alt');
    //alert(alt_del); 
    $('#UniqueRwId'+alt_del).hide();
    var pri_clm = $(this).attr('attr_tblid');
    $(document).on('click' , '#save' , function(){
    //$('#save').on('click' , function(){
    deleteColumnForIncident(id,table,pri_clm);
    });
    $(this).closest('tr').remove();
    e.preventDefault();
    });
      
      
      
        
    });
    
</script>
