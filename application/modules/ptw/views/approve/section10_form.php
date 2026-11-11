<?php 
$work_complete_name = postData($editData, 'WORK_COMPLETE_NAME', postData($userDetails, 'NAME'),$this->input->post('work_complete_name'));

$work_complete_date = ($applicantdate != '') ? postData($editData, 'WORK_COMPLETE_DATE', $applicantdate) : $this->input->post('work_complete_date');
$work_complete_time = ($applicanttime != '') ? postData($editData, 'WORK_COMPLETE_TIME', $applicanttime) : $this->input->post('work_complete_time');
$work_complete_declaration =  postData($editData, 'WORK_COMPLETION', $this->input->post('work_complete_declaration'))  ;
$work_complete_date = ($ptw_id > 0) ? convertDate($work_complete_date, PTW_DATE_FORMAT) : $work_complete_date;
$work_complete_time = ($ptw_id > 0) ? convertDate($work_complete_time, PTW_TIME_FORMAT) : $work_complete_time;
    $PTWStatus = postData($editData,'STATUS');    
    $initialChecked = ($PTWStatus == 7) ? ' onclick="return false"' : '';
    $checked = ($work_complete_declaration == 1) ? 'checked' : '';
    $permitsancformAttachment = FALSE;
    $permitsancformAttachment1 = FALSE;
    $permit_number =  postData($editData, 'LIVE_PERMIT_NO','');
?>
<div class="row">
    <div class="col-md-12">
         <label>WORK SUPERVISOR (WS) / PERFORMING AUTHORITY (PA)</label>
        
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="work_complete_declaration" id="work_complete_declaration"  value="1" <?php echo $initialChecked;?>  <?php echo $checked;?> >
            <label class="form-check-label" for="work_complete_declaration">
                Job Task Completed. Worksite has been restored to safe condition.
            </label>
        </div>
        <?php echo form_error('work_complete_declaration','<div class="error">','</div>') ?>
         <span class="red work_complete_declaration_error"></span>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md-12"> 
        
        <label >Upload Permit Sanctioning form</label> &nbsp;&nbsp;<a class="btn btn-primary" href="<?php echo BASE_URL.'/ptw/permit/generateSancFormPdf/'.$editId;?>" class="" title="PDF" target="_blank"><i class="fa fa-download" aria-hidden="true" style="color:#FFF;"></i>Download</a> <br>
         <?php 
         $fileSectionName ='permit_sactioning_form';
         $fileAppendSectionName ='permitsancformfileuploadrow';
         $defaultImg = DEFAULT_IMG_PNG;
         
         ?>
            <div class="btn btn-primary btn-sm additionalDoc" data-ref="<?php echo $fileSectionName;?>" data-refbind="<?php echo $fileAppendSectionName;?>" data-max="10" data-classname="permitsanctformupload" data-accept="image/*,application/pdf" data-acceptmsg="Accepts only pdf,jpg, jpeg, png images">Add +</div>								    
            <div class="clearfix"></div>
            <br/>
             <div class="row <?php echo $fileAppendSectionName;?>">
            <?php if($permitsancformAttachment != FALSE){ 
                foreach($permitsancformAttachment as $attachmnt){
                    $filepath = postData($attachmnt,'SD_FILE_PATH');
                    $filename = postData($attachmnt,'SD_FILENAME');
                    $fileext= postData($attachmnt,'SD_FILE_EXT');
                    $is_image= postData($attachmnt,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $displayLabel = ($is_image == 1) ? '<img src="'.$fileFullpath.'"/>' : $filename;
                   ?>
                 <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><?php echo $displayLabel;?></div>
                    <div>
                        <span class="btn-file">
                            <span class=" btn btn-sm btn-primary fileinput-new">Select image</span>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" name="<?php echo $fileSectionName;?>[]"  class='permitsanctformupload' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png images" data-rule-required ="true"  data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists remove" data-dismiss="fileinput">Remove</a>
                    </div>
                    <span class="error red r1"></span>
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
                            <span class=" btn btn-sm btn-primary fileinput-new">Select image</span>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" name="<?php echo $fileSectionName;?>[]" class='permitsanctformupload' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png images" data-rule-required ="true"  data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists remove" data-dismiss="fileinput">Remove</a>
                        <span class="error red r1"></span>
                    </div>
                </div>	    
            </div>
            <?php } ?>
        </div>
                                           
        <span class="">Allowed file types (pdf,jpg, jpeg, png)</span><br>
        <span class="red formfileerror"></span>
      
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md-12"> 
        
        <label >Upload Toolbox Talk Form</label> <br>
         <?php 
         $fileSectionName ='permit_sactioning_form1';
         $fileAppendSectionName ='permitsancformfileuploadrow1';
         $defaultImg = DEFAULT_IMG_PNG;
         
         ?>
            <div class="btn btn-primary btn-sm additionalDoc1" data-ref="<?php echo $fileSectionName;?>" data-refbind="<?php echo $fileAppendSectionName;?>" data-max="10" data-classname="permitsanctformupload1" data-accept="image/*,application/pdf" data-acceptmsg="Accepts only pdf,jpg, jpeg, png images">Add +</div>								    
            <div class="clearfix"></div>
            <br/>
             <div class="row <?php echo $fileAppendSectionName;?>">
            <?php if($permitsancformAttachment1 != FALSE){ 
                foreach($permitsancformAttachment1 as $attachmnt){
                    $filepath = postData($attachmnt,'SD_FILE_PATH');
                    $filename = postData($attachmnt,'SD_FILENAME');
                    $fileext= postData($attachmnt,'SD_FILE_EXT');
                    $is_image= postData($attachmnt,'IS_IMAGE');
                    $fileFullpath = BASE_URL.$filepath.$filename;
                    $displayLabel = ($is_image == 1) ? '<img src="'.$fileFullpath.'"/>' : $filename;
                   ?>
                 <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><?php echo $displayLabel;?></div>
                    <div>
                        <span class="btn-file">
                            <span class=" btn btn-sm btn-primary fileinput-new">Select image</span>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" name="<?php echo $fileSectionName;?>[]"  class='permitsanctformupload1' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png images" data-rule-required ="true"  data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists remove" data-dismiss="fileinput">Remove</a>
                    </div>
                    <span class="error red r2"></span>
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
                            <span class=" btn btn-sm btn-primary fileinput-new">Select image</span>
                            <span class="btn btn-sm btn-warning fileinput-exists">Change</span>
                            <input type="file" name="<?php echo $fileSectionName;?>[]" class='permitsanctformupload1' accept="image/*,application/pdf" data-msg-accept = "Accepts only pdf,jpg, jpeg, png images" data-rule-required ="true"  data-msg-required="Please upload document">
                        </span>
                        <a href="#" class="btn btn-sm btn-danger fileinput-exists remove" data-dismiss="fileinput">Remove</a>
                        <span class="error red r2"></span>
                    </div>
                </div>	    
            </div>
            <?php } ?>
        </div>
                                           
        <span class="">Allowed file types (pdf,jpg, jpeg, png)</span><br>
        <span class="red formfileerror"></span>
      
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Name</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'work_complete_name',
                'id' => 'work_complete_name',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $work_complete_name,
            );

            echo form_input($data);
            ?>     
        </div>
    </div>
    <div class="col-md">  
        <label >Date</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'work_complete_date',
                'id' => 'work_complete_date',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => '',
            );

            echo form_input($data);
            ?>     
        </div>
    </div>
    <div class="col-md">  
        <label >Time</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'work_complete_time',
                'id' => 'work_complete_time',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => '',
            );

            echo form_input($data);
            ?>     
        </div>
    </div>

</div>

<script>
    $(document).ready(function (){
        
         $(document).on('click', '.additionalDoc', function () {
          var dref = $(this).attr('data-ref');
          var drefbind = $(this).attr('data-refbind');
          var dmaxfile = $(this).attr('data-max');
          var dclassName = $(this).attr('data-classname');
          var daccept = $(this).attr('data-accept');
          var dacceptmsg = $(this).attr('data-acceptmsg');
          var classAttr = '';
          var acceptAttr = '';
          var acceptMsgAttr = '';
          if (typeof dclassName !== typeof undefined && dclassName !== false) {
              classAttr = 'class="'+dclassName+'"';
          }
          if (typeof daccept !== typeof undefined && daccept !== false) {
              acceptAttr = 'accept="'+daccept+'"';
          }
          if (typeof dacceptmsg !== typeof undefined && dacceptmsg !== false) {
              acceptMsgAttr = 'data-msg-accept ="'+dacceptmsg+'"';
          }
         
             var count = $('.'+drefbind+' .col-md-3').length;
             var html = '<div class="col-md-3"><div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="'+defaultImg+'" /></div><div style="display: inline-block;float:left;margin-right:5px;"><span class="btn-file" style="display: inline-block;"><span class=" btn btn-sm btn-primary fileinput-new">Select image</span><span class="btn btn-sm btn-warning fileinput-exists">Change</span><input type="file" name="'+dref+'[]" '+classAttr+' '+acceptAttr+' '+acceptMsgAttr+'> </span><a href="#" class="btn btn-sm btn-danger fileinput-exists remove" data-dismiss="fileinput">Remove</a><span class="btn btn-sm btn-danger deleteFile">Delete</span><span class="error red r1"></span></div></div></div>';
	   if(dmaxfile != -1 && count > 0 && count < dmaxfile){
              
               $('.'+drefbind).append(html);
           }else if(dmaxfile == -1 && count > 0){
               $('.'+drefbind).append(html);
           }
	    
	});
        
         $(document).on('click', '.additionalDoc1', function () {
          var dref = $(this).attr('data-ref');
          var drefbind = $(this).attr('data-refbind');
          var dmaxfile = $(this).attr('data-max');
          var dclassName = $(this).attr('data-classname');
          var daccept = $(this).attr('data-accept');
          var dacceptmsg = $(this).attr('data-acceptmsg');
          var classAttr = '';
          var acceptAttr = '';
          var acceptMsgAttr = '';
          if (typeof dclassName !== typeof undefined && dclassName !== false) {
              classAttr = 'class="'+dclassName+'"';
          }
          if (typeof daccept !== typeof undefined && daccept !== false) {
              acceptAttr = 'accept="'+daccept+'"';
          }
          if (typeof dacceptmsg !== typeof undefined && dacceptmsg !== false) {
              acceptMsgAttr = 'data-msg-accept ="'+dacceptmsg+'"';
          }
         
             var count = $('.'+drefbind+' .col-md-3').length;
             var html = '<div class="col-md-3"><div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="'+defaultImg+'" /></div><div style="display: inline-block;float:left;margin-right:5px;"><span class="btn-file" style="display: inline-block;"><span class=" btn btn-sm btn-primary fileinput-new">Select image</span><span class="btn btn-sm btn-warning fileinput-exists">Change</span><input type="file" name="'+dref+'[]" '+classAttr+' '+acceptAttr+' '+acceptMsgAttr+'> </span><a href="#" class="btn btn-sm btn-danger fileinput-exists remove" data-dismiss="fileinput">Remove</a><span class="btn btn-sm btn-danger deleteFile1">Delete</span><span class="error red r2"></span></div></div></div>';
	   if(dmaxfile != -1 && count > 0 && count < dmaxfile){
              
               $('.'+drefbind).append(html);
           }else if(dmaxfile == -1 && count > 0){
               $('.'+drefbind).append(html);
           }
	    
	});
        
        $(document).on('click', '.deleteFile', function () {
	    $(this).closest('.col-md-3').remove();
	});
        $(document).on('click', '.deleteFile1', function () {
	    $(this).closest('.col-md-3').remove();
	});
        
        $.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (Math.round(element.files[0].size / (1024 * 1024)) <= 5)
}, 'File size must be less than 5MB');

        $.validator.messages.accept = 'Accepts only pdf,jpg, jpeg, png images';
        $.validator.addClassRules("permitsanctformupload", {
	    accept: "pdf|png|jpe?g",
	    required: true,
            filesize:true
	});
        $.validator.addClassRules("permitsanctformupload1", {
	    accept: "pdf|png|jpe?g",
	    required: true,
            filesize:true
	});
        
        $('#close_form').validate({
	rules: {

	    "work_complete_declaration": {
		required: true,
	    },
	    "permit_sactioning_form[]": {
		required: true,
	    },
	    "permit_sactioning_form1[]": {
		required: true,
	    },
	   
	    
	   
	},
	messages: {
	    "work_complete_declaration": {
		required: "Please select the Option",
	    },
	    "permit_sactioning_form[]": {
		required: "Please upload permit sanctioning form",
	    },
	    "permit_sactioning_form1[]": {
		required: "Please upload toolbox talk form",
	    },
           
	   
	},
        success: function(label,element) {
                label.parent().removeClass('error');
		label.remove();
					
	},
        highlight: function(element) {
            $(element).parent('div').addClass('error');
        },
        unhighlight: function(element) {
            $(element).parent('div').removeClass('error');
        },
        errorPlacement: function (error, element) {
            if (element.hasClass('select2')) {
               error.insertAfter(element.next('span')); 
           } else if (element.attr('name') == 'work_complete_declaration') {
                    error.appendTo('span.work_complete_declaration_error');
           }else if (element.attr('name') == 'permit_sactioning_form[]') {
                    error.appendTo('span.r1');
           }else if (element.attr('name') == 'permit_sactioning_form1[]') {
                    error.appendTo('span.r2');
           }else {
               error.insertAfter(element);
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
 
        $(document).on('change','#work_complete_declaration',function (){
           
          
            $('#work_complete_date').val(getTodayDate());
            $('#work_complete_time').val(formatAMPM(new Date));
            $(this).prop('checked', true);
           
        });
        
       
        
    })
    </script>

