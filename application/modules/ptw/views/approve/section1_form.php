<?php 
$permit_number =  postData($editData, 'LIVE_PERMIT_NO','');
$applicationName =  postData($editData, 'APPLICANT_NAME','');
$designationName =  postData($editData, 'DESIGNATION_NAME','');
$companyName =  postData($editData, 'COMPANY_NAME','');
$sectionDiv =  postData($editData, 'SECTION_NAME','');
$locationId = postData($editData, 'LOCATION',$this->input->post('location'));
$speclocationName = postData($editData, 'SPECIFIC_WORKSITE',$this->input->post('specific_location'));
$startDate = postData($editData, 'START_DATE',$this->input->post('start_date'));
$endDate = postData($editData, 'END_DATE',$this->input->post('end_date'));
$areaClass = postData($editData, 'AREA_OF_CLASSIFICATION',$this->input->post('area_classification'));
$workDesc = postData($editData, 'WORK_DESCRIPTION',$this->input->post('work_description'));
$specWorkInst = postData($editData, 'SPECIFIC_WORK_INSTRUCTION',$this->input->post('special_work_instruction'));
$specWorkInstOption = postData($editData, 'SPECIFIC_WORK_INSTRUCTION_OPTION',0);
$trigger = FALSE;
if($editData != FALSE){
    $trigger = TRUE;
    $startDate = ($startDate !='') ? date('m/d/Y', strtotime($startDate)): '';
    $endDate = ($endDate !='') ? date('m/d/Y', strtotime($endDate)): '';
}
$disable = TRUE;
$showSpeciWorkIstClass = ($specWorkInstOption == 1) ? 'display:block' : 'display:none';

$sc1fName = postData($editData,'SEC1_FILENAME');
$sc1fPath = postData($editData,'SEC1_FILEPATH');

$sec1Imgupl = (isset($sc1fName) && !empty($sc1fName)) ? BASE_URL.''.$sc1fPath.''.$sc1fName : '';

?>
<div class="row m-t-10">
    <div class="col-md-6">  
        <label >Permit Number</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'permit_number',
                'id' => 'permit_number',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $permit_number,
               
            );
            
            $data = $data + $aDisableAttr;

            echo form_input($data);
            ?>     
        </div>
    </div>
  </div>  
<div class="row m-t-10">
    <div class="col-md">  
        <label >Applicant Name</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'applicant_name',
                'id' => 'applicant_name',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $applicationName,
                'disable' => $disable,
            );
            
            $data = $data + $aDisableAttr;

            echo form_input($data);
            ?>     
        </div>
    </div>
    <div class="col-md">  
        <label >Designation</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'designation',
                'id' => 'designation',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $designationName,
            );
            
            $data = $data + $aDisableAttr;

            echo form_input($data);
            ?>     
        </div>
    </div>

</div>

<div class="row m-t-10">
    <div class="col-md">  
        <label >Company Name</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'company_name',
                'id' => 'company_name',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' =>$companyName,
            );
            $data = $data + $aDisableAttr;
            echo form_input($data);
            ?>     
        </div>
    </div>
    <div class="col-md">  
        <label >Section/Division</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'department_name',
                'id' => 'department_name',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $sectionDiv,
            );
            $data = $data + $aDisableAttr;
            echo form_input($data);
            ?>     
        </div>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Location <span class="red">*</span></label><br>
        <div>
            <?php
            $locDetails = [
                'id' => 'location',
                'class' => 'form-control select2bs4 select2',
            ];
            $locDetails = $locDetails + $aDisableAttr;
            echo form_dropdown('location', $locationDetails, $locationId, $locDetails);
            ?>
            <?php echo form_error('location', '<div class="error">', '</div>'); ?>
           <span class="red"></span>
        </div>
        
    </div>
    <div class="col-md">  
        <label >Specific Location <span class="red">*</span></label><br>
        <div>
            <?php
            $data = array(
                'name' => 'specific_location',
                'id' => 'specific_location',
                'placeholder' => '',
                'class' => 'form-control',
                'value' => $speclocationName,
            );
            $data = $data + $aDisableAttr;
            echo form_input($data);
            ?>  
             <?php echo form_error('specific_location', '<div class="error">', '</div>'); ?>
            <span class="red"></span>
        </div>
         
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Start Date <span class="red">*</span></label><br>
        <div>

            <?php
            $data = array(
                'name' => 'start_date',
                'id' => 'start_date',
                'placeholder' => '',
                'class' => 'form-control',
                 'autocomplete' => 'off',
                'value' => $startDate,
            );

            echo form_input($data);
            ?>  
            <?php echo form_error('start_date', '<div class="error">', '</div>'); ?>
            <span class="red"></span><br/>
            <small>Blanket Permit valid for 7 days only(inclusive Sunday & Public Holiday)</small>
            
        </div>
    </div>
    <div class="col-md">  
        <label >End Date <span class="red">*</span></label><br>
        <div>
            <?php
            $data = array(
                'name' => 'end_date',
                'id' => 'end_date',
                'placeholder' => '',
                'class' => 'form-control',
                 'autocomplete' => 'off',
                'value' => $endDate,
            );

            echo form_input($data);
            ?> 
            <?php echo form_error('end_date', '<div class="error">', '</div>'); ?>
            <span class="red"></span><br/>
            <small>Blanket Permit valid for 7 days only(inclusive Sunday & Public Holiday)</small>
            
        </div>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md-6">  
        <label >Area Classification <span class="red">*</span></label><br>
        <div>
            <?php
            if ($areaClassification != FALSE && count($areaClassification) > 0) {
                foreach ($areaClassification as $key => $val) {
                   $areacheckId = postData($val, 'CLS_ID');
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="area_classification" id="areaClass<?php echo $key; ?>" <?php echo ($areaClass == $areacheckId) ? 'checked' : '';?>  value="<?php echo $areacheckId; ?>" >
                        <label class="form-check-label" for="areaClass<?php echo $key; ?>">
                            <?php echo postData($val, 'CLS_NAME'); ?>
                        </label>
                    </div>
                <?php
                }
            }
            ?>
             <?php echo form_error('area_classification', '<div class="error">', '</div>'); ?>
            <span class="red area_classification_error"></span>
        </div>
    </div>
	<div class="col-md-6">  
        <label class="" style="margin-left:4%">Image Upload <span class="red">*</span></label><br>
        <a data-fancybox="gallery" href="<?php echo $sec1Imgupl; ?>">
            <img class="lazy" style="height: 150px;width: 250px;" data-src="<?php echo $sec1Imgupl; ?>" >
        </a>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Work Description <span class="red">*</span></label><br>
        <div>
            <?php
            $data = array(
                'name' => 'work_description',
                'id' => 'work_description',
                'placeholder' => '',
                'class' => 'form-control',
                'required' => true,
                'autocomplete' => 'off',
                'rows' => 5,
                'cols' => 10,
                'value' => $workDesc,
            );

            echo form_textarea($data);
            ?> 
             <?php echo form_error('work_description', '<div class="error">', '</div>'); ?>
            <span class="red "></span>
        </div>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md"> 
         <label >Special Work Instruction </label> <span class="red">*</span><br>
<div class="form-check-inline">
  <label class="form-check-label">
      <input type="radio" class="form-check-input specialworkinstruction_option" name="specialworkinstruction_option" readonly value="1" onclick='return false' <?php echo ($specWorkInstOption == 1) ? "checked ":'';?> >Applicable
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
      <input type="radio" class="form-check-input specialworkinstruction_option" name="specialworkinstruction_option" value="0" readonly onclick='return false' <?php echo ($specWorkInstOption == 0) ? "checked ":'';?>>Not Applicable
  </label>
</div>
         </div>
</div>
<div class="row m-t-10 showApplicable" style="<?php echo $showSpeciWorkIstClass;?>">
    <div class="col-md">  
        <label >Special Work Instruction </label><br>
        <div>
            <?php
            $data = array(
                'name' => 'special_work_instruction',
                'id' => 'special_work_instruction',
                'placeholder' => '',
                'class' => 'form-control',
                'autocomplete' => 'off',
                'rows' => 5,
                'cols' => 10,
                'value' => $specWorkInst,
            );

            echo form_textarea($data);
            ?> 
              <?php echo form_error('special_work_instruction', '<div class="error">', '</div>'); ?>
            <span class="red"></span>
        </div>
    </div>
</div>
<div class="row m-t-10 showApplicable" style="<?php echo $showSpeciWorkIstClass;?>">
    <div class="col-md-12"> 
        <label >Document Upload </label><br>
         <?php 
         $fileSectionName ='section_upload_documents';
         $fileAppendSectionName ='sectionfileuploadrow';
         $defaultImg = DEFAULT_IMG_PNG;
         
         ?>
<!--            <div class="btn btn-primary btn-sm additionalDoc" data-ref="<?php echo $fileSectionName;?>" data-refbind="<?php echo $fileAppendSectionName;?>" data-max="5">Add +</div>								    -->
            <div class="clearfix"></div>
            <br/>
             <div class="row <?php echo $fileAppendSectionName;?>">
            <?php if($sectionAttachment != FALSE){ 
                foreach($sectionAttachment as $attachmnt){
                    $filepath = postData($attachmnt,'SEC_FILE_PATH');
                    $filename = postData($attachmnt,'SEC_FILENAME');
                    $fileext= postData($attachmnt,'SEC_FILE_EXT');
                    $is_image= postData($attachmnt,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
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
                 <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;"><?php echo $displayLabel;?></div>
                    <div>
                        
                    </div>
                </div>	    
            </div>
                 <?php
                }
            ?>
            <?php } ?>
            
        </div>
                                           
        <span class="">Allowed file types (pdf,jpg, jpeg, png)</span><br>
        <span class="red fileerror"></span>
      
    </div>
</div>
<script>
    $(document).ready(function (){
	$('.lazy').lazy();

        $('.select2').prop("disabled", true);
        $('#start_date').prop("disabled", true);
        $('#end_date').prop("disabled", true);
        $('input[name="area_classification"]' ).prop("readonly", true);
        $('input[name="area_classification"]' ).attr("onClick", 'return false');
        $('textarea[name="work_description"]' ).prop("readonly", true).prop("disabled", true);
        $('textarea[name="special_work_instruction"]' ).prop("readonly", true).prop("disabled", true);
        
    })
    </script>

