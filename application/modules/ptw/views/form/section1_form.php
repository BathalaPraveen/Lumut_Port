<?php 
$applicationName =  postData($editData, 'APPLICANT_NAME',postData($userDetails, 'NAME'));
$designationName =  postData($editData, 'DESIGNATION_NAME',postData($userDetails, 'DESIGNATION'));
$companyName =  postData($editData, 'COMPANY_NAME',postData($userDetails, 'COMPANY'));
$sectionDiv =  postData($editData, 'SECTION_NAME',postData($userDetails, 'DEPTNAME'));
$locationId = postData($editData, 'LOCATION',$this->input->post('location'));
$speclocationName = postData($editData, 'SPECIFIC_WORKSITE',$this->input->post('specific_location'));
$startDate = postData($editData, 'START_DATE',$this->input->post('start_date'));
$endDate = postData($editData, 'END_DATE',$this->input->post('end_date'));
$areaClass = postData($editData, 'AREA_OF_CLASSIFICATION',$this->input->post('area_classification'));
$workDesc = postData($editData, 'WORK_DESCRIPTION',$this->input->post('work_description'));
$specWorkInst = postData($editData, 'SPECIFIC_WORK_INSTRUCTION',$this->input->post('special_work_instruction'));
$specWorkInstOption = postData($editData, 'SPECIFIC_WORK_INSTRUCTION_OPTION',$this->input->post('specialworkinstruction_option'));
$trigger = FALSE;
if($editData != FALSE){
    $trigger = TRUE;
    $startDate = ($startDate !='') ? date('m/d/Y', strtotime($startDate)): '';
    $endDate = ($endDate !='') ? date('m/d/Y', strtotime($endDate)): '';
}

$showSpeciWorkIstClass = ($specWorkInstOption == 1) ? 'display:block' : 'display:none';

$sc1fName = postData($editData,'SEC1_FILENAME');
$sc1fPath = postData($editData,'SEC1_FILEPATH');

$sec1Imgupl = (isset($sc1fName) && !empty($sc1fName)) ? BASE_URL.''.$sc1fPath.''.$sc1fName : '';
?>
<style>
    .fileinput img{
        width: 100%;
        height: 100%;
    }
</style>
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
            );

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
                'style' => 'width:100%',
            ];
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
                'maxlength' => 100,
                'class' => 'form-control',
                'value' => $speclocationName,
            );

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
 <?php
    $isImgrequ = (isset($sc1fName) & !empty($sc1fName)) ? '' : 'required';
    ?>
 <div class="col-md-6">  
        <label class="" style="margin-left:4%">Image Upload <span class="red">*</span></label><br>
        	<div class="form-group">

                                                                <div class="fileinput fileinput-new apprFileinput" style="margin-top: -30px !important; " data-provides="fileinput" >
                                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                                        <?php
                                                                        if ($sec1Imgupl != '') {
                                                                            ?>
                                                                            <img src='<?php echo $sec1Imgupl ?>' alt='' style="height: 100%;"/>     
                                                                        <?php } ?>
                                                                    </div>
                                                                    <p class="mini-txt">(png, jpeg, jpg )</p>
                                                                    <div class="file-pop" style="margin-left:17% !important">                                                    
                                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src='<?php echo BASE_URL("/assets/images/photo.png"); ?>'  style=" width: 30%; "/></span>
                                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                                            <input type="file" name="addmoreImages[]" <?php echo $isImgrequ; ?> class='inspecptwFile' accept="image/jpg,image/png,image/jpeg"></span>

                                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="user_img[]" class="user_imgClas" value="<?php echo $finalImgdet; ?>" id="userImg">

                                                            </div>
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
      <input type="radio" class="form-check-input specialworkinstruction_option" name="specialworkinstruction_option" value="1" <?php echo ($specWorkInstOption == 1) ? "checked":'';?> >Applicable
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
      <input type="radio" class="form-check-input specialworkinstruction_option" name="specialworkinstruction_option" value="0" <?php echo ($specWorkInstOption == 0) ? "checked":'';?>>Not Applicable
  </label>
</div>
         </div>
</div>

<div class="row m-t-10 showApplicable " style="<?php echo $showSpeciWorkIstClass;?>">
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
                    $displayLabel = ($is_image == 1) ? '<img src="'.$fileFullpath.'"/>' : $filename;
                   ?>
                 <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><?php echo $displayLabel;?></div>
                    <div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
                            <span class=" btn btn-sm btn-primary fileinput-new">Upload attachment</span>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" name="<?php echo $fileSectionName;?>[]"  class='docfileupload' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                </div>	    
            </div>
                 <?php
                }
            ?>
            <?php }else { ?>
            <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="<?php echo $defaultImg;?>"></div>
                    <div style="display: inline-block;float:left;margin-right:5px;">
                        <span class="btn-file" style="display: inline-block;">
                            <span class=" btn btn-sm btn-primary fileinput-new">Upload attachment</span>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" name="<?php echo $fileSectionName;?>[]" class='docfileupload' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png, gif images" data-rule-required="false" data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                </div>	    
            </div>
            <?php } ?>
        </div>
                                           
        <span class="">Allowed file types (pdf,jpg, jpeg, png)</span><br>
        <span class="red fileerror"></span>
      
    </div>
</div>
<?php 
if($editData != FALSE){
    ?>
<script>
$(document).ready(function() {
        var startDate = new Date('<?php echo $startDate;?>');
        var endDate = new Date('<?php echo $endDate;?>');
        var diffTime = endDate.getTime() - startDate.getTime();
        var diffInDay = diffTime / (1000*3600*24);
        if(diffInDay < 6){
             endDate = addDays('<?php echo $startDate;?>',6);
        }
       
        $('#end_date').datepicker('setStartDate', startDate);
        $('#end_date').datepicker('setEndDate', endDate);
});
</script>
<?php
}
?>

<script>
$(document).ready(function() {

 $.validator.addMethod('filesizeptw', function (value, element, param) {
           
            return this.optional(element) || (Math.round(element.files[0].size / (1024 * 1024)) <= 5)
        }, 'File size must be less than 5MB');

        $.validator.addClassRules("inspecptwFile", {
//            accept: "png|jpe?g|gif",
            //required: true,
            filesizeptw : true
        });
        
        $("#start_date").datepicker({
	    autoclose: true,
            startDate: new Date()
	}).on('changeDate', function (selected) {
	    var minDate = new Date(selected.date.valueOf());
	     $('#end_date').datepicker('setStartDate', minDate);
             var maxDate = addDays(selected.date.valueOf(),6);
             console.log(maxDate);
	     $('#end_date').datepicker('setEndDate', maxDate);
	});
        $("#end_date").datepicker({
	    autoclose: true,
            startDate: new Date()
            
	}).on('changeDate', function (selected) {
	    var minDate = new Date(selected.date.valueOf());
	    
	});
        
        $(document).on('change','.specialworkinstruction_option',function(){
            if($(this).is(':checked') && $(this).val() == 1){
               
               $('.showApplicable').show();
               
            }else{
                $('.showApplicable').hide();
            }
        })
        
        
        
         
})
</script>

