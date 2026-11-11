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
    .initialfilerequire {
  pointer-events: none;
}
</style>

<?php
//echo '<pre>';print_r($editData);exit;
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
$statuss = postData($editData, 'STATUS', $this->input->post('STATUS'));
$eventDate = postData($editData, 'eventDate', $this->input->post('eventDate'));
$eventTime = postData($editData, 'EVENT_TIME', $this->input->post('eventTime'));
$POLICE_CASE_NO = postData($editData, 'POLICE_CASE_NO', $this->input->post('POLICE_CASE_NO'));
$POLICE_OTHER_INFO = postData($editData, 'POLICE_OTHER_INFO', $this->input->post('POLICE_OTHER_INFO'));

$HOSPITAL_CASE_NO = postData($editData, 'HOSPITAL_CASE_NO', $this->input->post('HOSPITAL_CASE_NO'));
$HOSPITAL_OTHER_INFO = postData($editData, 'HOSPITAL_OTHER_INFO', $this->input->post('HOSPITAL_OTHER_INFO'));

$OTHER_CASE_NO = postData($editData, 'OTHER_CASE_NO', $this->input->post('OTHER_CASE_NO'));
$OTHER_OTHER_INFO = postData($editData, 'OTHER_OTHER_INFO', $this->input->post('OTHER_OTHER_INFO'));
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
$INVESTIGATION_ACTION = $editData->INVESTIGATION_ACTION;
$INCIDENT_ID = $editData->INCIDENT_ID;
//echo '<pre>';print_r($INVESTIGATION_ACTION);exit; 
$NOT_REQUIRED_REASON = $editData->NOT_REQUIRED_REASON;
  
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
				$action = (isset($id) && $id != "") ? 'incident/investRequired/' . $id : 'incident/investRequired';
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
							'value' => $eventDate,
							'readonly' =>  'readonly'
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
							'readonly' =>  'readonly'
						    ];
						    echo form_input($data);
						    ?>
						</div>
						<div class="col-md-3">
						    <label>Event Location <?php echo REQUIRED; ?></label>
						    <?php
						    $editLoc = $locid;
						    $options = $getLoc;
						    $extra = 'class="form-control" id="eventLocation" readonly = "readonly"';
						    echo form_dropdown('eventLocation', $options, $editLoc, $extra);
						    ?>
						</div>
						<div class="col-md-3">
						    <label>Specific Location <?php echo REQUIRED; ?></label>
						    <?php
						    $editLoc = $speclocid;
						    $extra = 'class="form-control" id="specificLocation" readonly = "readonly"';
						    $getSpecLoc = $getSpecLoc + ['-1' => 'Other'];
						    echo form_dropdown('specificLocation', $getSpecLoc, $editLoc, $extra);
						    ?>
						    <br>
						    <?php
						    $dnone = ($speclocid == -1) ? '' : 'd-none';
						    $data = [
							'name' => 'specificlocother',
							'id' => 'specificlocother',
							'readonly' =>  'readonly',
							'class' => 'form-control ' . $dnone,
							'value' => $speclocother
						    ];
						    echo form_input($data);
						    ?>
						</div>
					    </div>    
					    <div class="row mt-2">
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
    							<input class="form-check-input eventRelatedCheck" readonly = "readonly" type="checkbox" value="<?php echo $listID; ?>" name="eventRelatedTo[]" id="eventRelatedCheck<?php echo $listID; ?>" <?php echo $checked; ?>>
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
    							<input class="form-check-input eventTypeCheck" readonly = "readonly" type="checkbox" value="<?php echo $key; ?>" name="eventType[]" id="eventTypeCheck<?php echo $key; ?>"  <?php echo $checked; ?>>
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
							'readonly' => 'readonly',
							'value' => $desc
						    ];
						    echo form_textarea($data);
						    ?>
						</div>
					    </div>
					    <div class="row mt-2">
						<div class="col-md-12">
						    <label>Upload Photo</label>	
						   <!--  <div class="btn btn-primary btn-sm addImage">Add +</div>	 -->				    
						</div>
					    </div>
					    <div class="row fileuploadrow">
						<?php
						if ($notifyAttachments) {
						    foreach ($notifyAttachments as $key => $notifyatt) {
							$filepath = BASE_URL . postData($notifyatt, 'fileset');
							?>
							<div class="col-md-3">
							    <div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-preview img-thumbnail" readonly="readonly" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="<?php echo $filepath; ?>" /></div>

							    </div>
							    <span class="error fileuploaderror"></span>
							</div>
							<?php
						    }
						} else {
						    ?>
    						<div class="col-md-3">
    						    <div class="fileinput fileinput-new" data-provides="fileinput">
    							<div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="" /></div>
    							<div>
    							    <span class="btn-file">
<!--    								<span class=" btn btn-sm btn-primary fileinput-new">Select image</span>
    								<span class="btn btn-sm btn-warning fileinput-exists">Change</span>-->
    								<input type="file" name="photos[]" accept="image/*" class="initialfilerequire">
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
							'readonly' => 'readonly',
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
					    Person(s) Involved
                                        </a>
                                    </div>
                                    <div id="section_2" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
					    <div class="row">
						<div class="col-md-12 personsections">
						    <?php
						    //echo '<pre>';print_r($personsInvolved);exit;
						    if ($personsInvolved) {
							$i = 1;
							foreach ($personsInvolved as $key => $persons) {
							    $pcheckIC = (postData($persons, 'ID_TYPE') == 'ICNO') ? 'checked' : '';
							    $pcheckPSP = (postData($persons, 'ID_TYPE') == 'Passport') ? 'checked' : '';
							    ?>
							    <table class="table table-bordered personstable">
								<tr>
								    <td><label>Name <?php echo REQUIRED; ?></label></td>
								    <td>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][name]',
										'id' => 'personsname1',
										'readonly' => 'readonly',
										'class' => 'form-control',
										'value' => postData($persons, 'PERSON_NAME', '')
									    ];
									    echo form_input($data);
									    ?>
									</div>

								    </td>
								    <td><label>Company <?php echo REQUIRED; ?></label></td>
								    <td>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][cmp]',
										'id' => 'personscmp1',
										'readonly' => 'readonly',
										'class' => 'form-control',
										'value' => postData($persons, 'COMPANY', '')
									    ];
									    echo form_input($data);
									    ?>
									</div>
								    </td>
								    <td rowspan="4" style="vertical-align: middle;">
									<!-- <span class="addPerson"><i class="fa fa-plus text-primary"></i></span> -->

								    </td>
								</tr>
								<tr>
								    <td><label>Designation / Occupation <?php echo REQUIRED; ?></label></td>
								    <td>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][desgn]',
										'id' => 'personsdesgn1',
										'readonly' => 'readonly',
										'class' => 'form-control',
										'value' => postData($persons, 'DESINATION', '')
									    ];
									    echo form_input($data);
									    ?>
									</div>
								    </td>
								    <td><label>Activity Being Performed <?php echo REQUIRED; ?></label></td>
								    <td>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][activity]',
										'id' => 'personsactvty1',
										'class' => 'form-control',
										'readonly' => 'readonly',
										'rows' => 3,
										'value' => postData($persons, 'ACTIVITY_BEING_PERFOMED', '')
									    ];
									    echo form_textarea($data);
									    ?>
									</div>
								    </td>
								</tr>
								<tr>
								    <td colspan="4" class="text-center">
									<label>Person's Details <?php echo REQUIRED; ?></label>
								    </td>
								</tr>
								<tr>
								    <td><label>Ic/Passport number <?php echo REQUIRED; ?></label></td>
								    <td>
									<div class="form-check-inline">
									    <input class="form-check-input " type="radio" readonly="readonly" value="ICNO" id="idtype1ICNO" name="persons[<?php echo $i; ?>][idtype]" <?php echo $pcheckIC; ?>>
									    <label class="form-check-label" for="idtype1ICNO">
										IC
									    </label>
									</div>
									<div class="form-check-inline">
									    <input class="form-check-input" type="radio" readonly="readonly" value="Passport" id="idtype1pass" name="persons[<?php echo $i; ?>][idtype]" <?php echo $pcheckPSP; ?>>
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
										'class' => 'form-control',
										'readonly' => 'readonly',
										'value' => postData($persons, 'IC_PASSPORT_NO', '')
									    ];
									    echo form_input($data);
									    ?>
									</div>
								    </td>
								    <td><label>Phone no <?php echo REQUIRED; ?></label></td>
								    <td>
									<div>
									    <?php
									    $data = [
										'name' => 'persons[' . $i . '][phone]',
										'id' => 'personsphone1',
										'class' => 'form-control',
										'readonly' => 'readonly',
										'value' => postData($persons, 'PHONE_NO', '')
									    ];
									    echo form_input($data);
									    ?>
									</div>
								    </td>
								</tr>
							    </table>
							    <?php
							    $i++;
							}
						    } else {
							?>
    						    <table class="table table-bordered personstable">
    							<tr>
    							    <td><label>Name <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][name]',
									    'id' => 'personsname1',
                                                                            'readonly'=>true,
									    'class' => 'form-control'
									];
									echo form_input($data);
									?>
    								</div>

    							    </td>
    							    <td><label>Company <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][cmp]',
									    'id' => 'personscmp1',
									    'class' => 'form-control',
                                                                            'readonly'=>true,
									];
									echo form_input($data);
									?>
    								</div>
    							    </td>
    							    <td rowspan="4" style="vertical-align: middle;">
    								<!-- <span class="addPerson"><i class="fa fa-plus text-primary"></i></span> -->

    							    </td>
    							</tr>
    							<tr>
    							    <td><label>Designation / Occupation <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][desgn]',
									    'id' => 'personsdesgn1',
									    'class' => 'form-control',
                                                                            'readonly'=>true,
									];
									echo form_input($data);
									?>
    								</div>
    							    </td>
    							    <td><label>Activity Being Performed <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][activity]',
									    'id' => 'personsactvty1',
									    'class' => 'form-control',
									    'rows' => 3,
                                                                            'readonly'=>true,
									];
									echo form_textarea($data);
									?>
    								</div>
    							    </td>
    							</tr>
    							<tr>
    							    <td colspan="4" class="text-center">
    								<label>Person's Details <?php echo REQUIRED; ?></label>
    							    </td>
    							</tr>
    							<tr>
    							    <td><label>Ic/Passport number <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div class="form-check-inline">
    								    <input class="form-check-input" readonly="readonly" type="radio" value="ICNO" id="idtype1ICNO" name="persons[1][idtype]">
    								    <label class="form-check-label" for="idtype1ICNO">
    									IC
    								    </label>
    								</div>
    								<div class="form-check-inline">
    								    <input class="form-check-input" readonly="readonly" type="radio" value="Passport" id="idtype1pass" name="persons[1][idtype]">
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
									    'class' => 'form-control',
                                                                            'readonly'=>true,
									];
									echo form_input($data);
									?>
    								</div>
    							    </td>
    							    <td><label>Phone no <?php echo REQUIRED; ?></label></td>
    							    <td>
    								<div>
									<?php
									$data = [
									    'name' => 'persons[1][phone]',
									    'id' => 'personsphone1',
									    'class' => 'form-control',
                                                                            'readonly'=>true,
									];
									echo form_input($data);
									?>
    								</div>
    							    </td>
    							</tr>
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
							'readonly' => 'readonly',
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
						    <label>Check</label>
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
							<input class="form-check-input" type="radio" value="Y" readonly="readonly" id="policecheckY" name="police_check" <?php echo $policecheckY; ?>>
							<label class="form-check-label" for="policecheckY">
							    Yes
							</label>
						    </div>
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" value="N" readonly="readonly" id="policecheckN" name="police_check" <?php echo $policecheckN; ?>>
							<label class="form-check-label" for="policecheckN">
							    No
							</label>
						    </div>
						</div>
						<div class="col-md-3 policedivs d-none">
						    <?php
						    $data = [
							'name' => 'police_caseno',
							'id' => 'police_caseno',
							'class' => 'form-control',
                                                        'readonly' => true,
                                                        'value'=> $POLICE_CASE_NO
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
                                                        'readonly' => true,
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
							<input class="form-check-input" type="radio" readonly="readonly" value="Y" id="hospitalcheckY" name="hospital_check" <?php echo $hospcheckY; ?>>
							<label class="form-check-label" for="hospitalcheckY">
							    Yes
							</label>
						    </div>
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" readonly="readonly" value="N" id="hospitalcheckN" name="hospital_check" <?php echo $hospcheckN; ?>>
							<label class="form-check-label" for="hospitalcheckN">
							    No
							</label>
						    </div>
						</div>
						<div class="col-md-3 hospitaldivs d-none">
						    <?php
						    $data = [
							'name' => 'hospital_caseno',
							'id' => 'hospital_caseno',
							'class' => 'form-control',
							'readonly' => true,
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
							'readonly' => true,
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
							<input class="form-check-input" type="radio" readonly="readonly" value="Y" id="othercheckY" name="other_check" <?php echo $othercheckY; ?>>
							<label class="form-check-label" for="othercheckY">
							    Yes
							</label>
						    </div>
						    <div class="form-check-inline">
							<input class="form-check-input" type="radio" readonly="readonly" value="N" id="othercheckN" name="other_check" <?php echo $othercheckN; ?>>
							<label class="form-check-label" for="othercheckN">
							    No
							</label>
						    </div>
						</div>
						<div class="col-md-3 otherdivs d-none">
						    <?php
						    $data = [
							'name' => 'other_caseno',
							'id' => 'other_caseno',
							'class' => 'form-control',
                                                        'readonly' => true,
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
                                                        'readonly' => true, 
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
						    <label>ID Type</label><br>
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
						</div>
						<div class="col-md-3">
						    <label>IC/Passport No.</label>
						    <?php
						    $data = [
							'name' => 'reported_icpassno',
							'id' => 'reported_icpassno',
							'class' => 'form-control',
							'readonly' => 'readonly',
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
						    <label>Phone No.</label>
						    <?php
						    $data = [
							'name' => 'reported_phoneno',
							'id' => 'reported_phoneno',
							'class' => 'form-control',
							'readonly' => 'readonly',
							'required' => true,
							'value' => $reportedPhno
						    ];
						    echo form_input($data);
						    ?>
						</div>
					    </div>			    			    
                                        </div>
                                    </div>
                                </div>


                                <div class="card testing d-none">
                                    <div class="card-header ">
                                        <a class="card-link " href="javascript:void(0)" >
					    Action
                                        </a>
                                    </div>
                                    <div id="section_5" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
					    <div class="row">						
						
						            <div class="row">

						               <div class="col-md-5">
							           <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" value="1" id="idRejected" name="INVESTIGATION_ACTION" >
                                          <label class="form-check-label" for="idRejected">
                                          Detail Investigation Required
                                          </label>
                                       </div>
                                       </div>

                                       <div class="col-md-7">
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" value="2" id="idNotRejected" name="INVESTIGATION_ACTION">
                                          <label class="form-check-label" for="idNotRejected">
                                          Detail Investigation Not Required
                                          </label>
                                       </div>
                                       <textarea class="form-control rejectedReason d-none" name="NOT_REQUIRED_REASON" id="rejectedReason"></textarea>
					</div>

						                <div class="col-md-3">
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" value="0" id="idIrreverent" name="INVESTIGATION_ACTION">
                                          <label class="form-check-label" for="idIrreverent">
                                          Irrelevant
                                          </label>
                                       </div>
						                </div>
				<input class="form-control INCIDENT_ID" autocomplete="off" type="hidden"  value="<?php echo (isset($INCIDENT_ID)?$INCIDENT_ID:"")?>"  name="INCIDENT_ID" id="INCIDENT_ID" />
	                

                                        </div>

                                    </div>
                                     <span class="error eventrelateErrorDetail"></span>
                                </div>
                            </div>
                        </div>









				<div class="row subHide d-none">
				    <div class="col-md-12 text-center">
					<button type="submit" class="btn btn-primary">Submit</button>
					<!-- <button type="reset" class="btn btn-danger ">Reset</button> -->
					<a href="<?php echo BASE_URL . 'incident'; ?>" class="btn btn-warning ">Cancel</a>
				    </div>
				</div>
                                
                                <div class="card viewActionPart d-none">
                                    <div class="card-header ">
                                        <a class="card-link " href="javascript:void(0)" >
					    Action
                                        </a>
                                    </div>
                                    <div id="section_5" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
					    <div class="row">						
						
						            <div class="row">

						               <div class="col-md-5">
							           <div class="form-check-inline">
                                                                       <input class="form-check-input" type="radio" value="1"<?php if(isset($INVESTIGATION_ACTION)){echo $INVESTIGATION_ACTION=='1'?'checked':'';}?> readonly="readonly" id="idRejectedd">
                                          <label class="form-check-label" for="idRejected">
                                          Detail Investigation Required
                                          </label>
                                       </div>
                                       </div>

                                       <div class="col-md-7">
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" value="2"<?php if(isset($INVESTIGATION_ACTION)){echo $INVESTIGATION_ACTION=='2'?'checked':'';}?> id="idNotRejectedd" readonly="readonly">
                                          <label class="form-check-label" for="idNotRejected">
                                          Detail Investigation Not Required
                                          </label>
                                       </div>
                                       <textarea class="form-control rejectedReason d-none" readonly="readonly" id="rejectedReason"><?php echo (isset($NOT_REQUIRED_REASON)?$NOT_REQUIRED_REASON:"")?></textarea>
					</div>

						                <div class="col-md-3">
                                       <div class="form-check-inline">
                                          <input class="form-check-input" type="radio" value="0"<?php if(isset($INVESTIGATION_ACTION)){echo $INVESTIGATION_ACTION=='0'?'checked':'';}?> id="idIrreverentd" readonly="readonly">
                                          <label class="form-check-label" for="idIrreverent">
                                          Irrelevant
                                          </label>
                                       </div>
						                </div>
						                

                                        </div>

                                    </div>
                                     <span class="error eventrelateErrorDetail"></span>
                                </div>
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

    	$('#eventLocation').attr('style','pointer-events: none;');
    	$('#specificLocation').attr('style','pointer-events: none;');
    	$('.eventRelatedCheck').attr('style','pointer-events: none;');
    	$('.eventTypeCheck').attr('style','pointer-events: none;');
    	$('#idtype1ICNO').attr('style','pointer-events: none;');
    	$('#idtype1pass').attr('style','pointer-events: none;');
    	$('#policecheckY').attr('style','pointer-events: none;'); 
        $('#policecheckN').attr('style','pointer-events: none;'); 
    	$('#othercheckY').attr('style','pointer-events: none;');
        $('#othercheckN').attr('style','pointer-events: none;'); 
    	$('#hospitalcheckY').attr('style','pointer-events: none;');
        $('#hospitalcheckN').attr('style','pointer-events: none;'); 
    	$('#reportedidtypepass').attr('style','pointer-events: none;');
        $('.initialfilerequire').attr('style','pointer-events: none;');
        $('#reportedidtypeICNO').attr('style','pointer-events: none;');
        


    	/**/
	var html = '<div class="col-md-3"><div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="https://www.placehold.it/230x140/EFEFEF/AAAAAA&text=no+image" /></div><div><span class="btn-file"><span class=" btn btn-sm btn-primary fileinput-new">Select image</span><span class="btn btn-sm btn-warning fileinput-exists">Change</span><input type="file" name="photos[]"  accept="image/*" class=""> </span><a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a><span class="btn btn-sm btn-danger deleteFile">Delete</span></div></div></div>';
	$('.addImage').click(function () {
	    var count = $('.fileuploadrow .col-md-3').length;
	    if (count < 5) {
		$('.fileuploadrow').append(html);
	    }
	});
	$(document).on('click', '.deleteFile', function () {
	    $(this).closest('.col-md-3').remove();
	});
        $('[name="INVESTIGATION_ACTION"]').change(function () {
        
	//$(document).on('click', '#idNotRejected', function () {
            var invesActns = $(this).val();
            if(invesActns == '2'){
            $('.rejectedReason').removeClass('d-none');
             }
             else{
                 $('.rejectedReason').addClass('d-none');
             }
         });
         
        var investActins = '<?php echo $INVESTIGATION_ACTION; ?>';
        if(investActins == '2'){
            $('.rejectedReason').removeClass('d-none');
             }
             else{
                 $('.rejectedReason').addClass('d-none');
             }
         
        
         
    
	$('[name="specificLocation"]').change(function () {
	    var vals = $(this).val();
	    if (vals === '-1') {
		$('#specificlocother').removeClass('d-none');
	    } else {
		$('#specificlocother').addClass('d-none');
	    }
	});
	$('#personsactvty1').change(function () {
	    var vals = $(this).val();
	    $('#reported_activity').val(vals);
	    $('#reported_activity').html(vals);
	});
	$(document).on('click', '.addPerson', function () {
	    var count = $('.personsections table.personstable').length + 1;
	    var tbhtml = '<table class="table table-bordered personstable"><tbody><tr><td><label>Name</label></td> <td><input type="text" name="persons[' + count + '][name]" value="" id="personsname' + count + '" class="form-control"></td> <td><label>Company</label></td><td><input type="text" name="persons[' + count + '][cmp]" value="" id="personscmp' + count + '" class="form-control"> </td><td rowspan="4" style="vertical-align: middle;"><span class="addPerson"><i class="fa fa-plus text-primary"></i></span><br><span class="removePerson"><i class="fa fa-trash trash"></i></span></td></tr><tr> <td><label>Designation / Occupation</label></td><td><input type="text" name="persons[' + count + '][desgn]" value="" id="personsdesgn' + count + '" class="form-control"></td><td><label>Activity Being Performed</label></td> <td><textarea name="persons[' + count + '][activity]" cols="40" rows="3" id="personsactvty' + count + '" class="form-control"></textarea> </td></tr><tr><td colspan="4" class="text-center"><label>Person`s Details</label> </td></tr><tr> <td><label>Ic/Passport number</label></td><td><div class="form-check-inline"><input class="form-check-input" type="radio" value="ICNO" id="idtype' + count + 'ICNO" name="persons[' + count + '][idtype]"><label class="form-check-label" for="idtype' + count + 'ICNO">IC </label></div><div class="form-check-inline"> <input class="form-check-input" type="radio" value="Passport" id="idtype' + count + 'pass" name="persons[' + count + '][idtype]"><label class="form-check-label" for="idtype' + count + 'pass">Passport</label></div><input type="text" name="persons[' + count + '][idcard]" value="" id="personsidcard' + count + '" class="form-control"> </td><td><label>Phone no</label></td><td><input type="text" name="persons[' + count + '][phone]" value="" id="personsphone1" class="form-control"></td></tr></tbody></table>';
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
            
            var statusss = '<?php echo $statuss; ?>';
            if(statusss == 1){
              $('.testing').removeClass('d-none');  
              $('.subHide').removeClass('d-none');
              $('.viewActionPart').addClass('d-none');
            }
            else{
                $('.testing').addClass('d-none');
                $('.subHide').addClass('d-none');
                $('.viewActionPart').removeClass('d-none');
                $('#idRejectedd').attr('style','pointer-events: none;');
                $('#idNotRejectedd').attr('style','pointer-events: none;');
                $('#idIrreverentd').attr('style','pointer-events: none;'); 
            }
           

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
		    required: false
		},
		"eventTime": {
		    required: false
		},
		"eventLocation": {
		    required: false
		},
		"specificLocation": {
		    required: false
		},
		'INVESTIGATION_ACTION':{
			required:true,
		},
                'NOT_REQUIRED_REASON':{
                    required:true,
                    alphanumeric:true,
                },
		"specificlocother": {
		 //    required: function () {
			// if ($("#specificLocation").val() == '-1') {
			//     return true;
			// } else {
			//     return false;
			// }
		 //    }
		},

		"eventRelatedTo[]": {
		    required: false
		},
		"eventType[]": {
		    required: false
		},
		"description": {
		    required: false
		},
		"persons[1][name]": {
		    required: false
		},
		"persons[1][cmp]": {
		    required: false
		},
		"persons[1][desgn]": {
		    required: false
		},
		"persons[1][activity]": {
		    required: false
		},
		"persons[1][idtype]": {
		    required: false
		},
		"persons[1][idcard]": {
		    required: false
		},
		"persons[1][phone]": {
		    required: false
		}
	    },
	    messages: {
		"eventDate": {
		    required: 'Date is required'
		},
		"eventTime": {
		    required: 'Time is required'
		},
		"eventLocation": {
		    required: 'Location is required'
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
		    required: 'Description is required'
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
		}
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
		else if(element.attr('name') == 'INVESTIGATION_ACTION'){
			error.appendTo('span.eventrelateErrorDetail');
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
    });
</script>
