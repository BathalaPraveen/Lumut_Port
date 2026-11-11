<?php 
$reactivateName = postData($editData, 'REACTIVATER_NAME', postData($userDetails, 'NAME'),$this->input->post('reactivate_name'));
$reactivate_comments = postData($editData, 'REACTIVATE_REASON', $this->input->post('reactivate_comments'));

$reactivate_date = ($applicantdate != '') ? postData($editData, 'REACTIVATER_DATE', $applicantdate) : $this->input->post('reactivate_date');
$reactivate_time = ($applicanttime != '') ? postData($editData, 'REACTIVATER_TIME', $applicanttime) : $this->input->post('reactivate_time');
$reactivate_cancel_declaration =  postData($editData, 'REACTIVATE_DECLARATION', $this->input->post('reactivate_cancel_declaration'))  ;
if($reactivate_cancel_declaration ==0){
    $reactivate_cancel_declaration = $this->input->post('reactivate_cancel_declaration');
}
$reactivate_date = ($ptw_id > 0) ? convertDate($reactivate_date, PTW_DATE_FORMAT) : $reactivate_date;
$reactivate_time = ($ptw_id > 0) ? convertDate($reactivate_time, PTW_TIME_FORMAT) : $reactivate_time;
    $PTWStatus = postData($editData,'STATUS');    
    $initialChecked = (in_array($PTWStatus, [9,10])) ? ' onclick="return false"' : '';
    $checked = ($reactivate_cancel_declaration == 1) ? 'checked' : '';
?>

<div class="row">
    <div class="col-md-12">
         <label>B.RE-ACTIVATE PERMIT</label>
        
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="reactivate_cancel_declaration" id="reactivate_cancel_declaration"  value="1" <?php echo $checked;?> <?php echo $initialChecked;?>  >
            <label class="form-check-label" for="reactivate_cancel_declaration">Permit Stoppage/Cancel Permit
            </label>
        </div>
        <?php echo form_error('reactivate_cancel_declaration','<div class="error">','</div>') ?>
        <span class="red reactivate_cancel_declaration_error"></span>
    </div>
    
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Name</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'reactivate_name',
                'id' => 'reactivate_name',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $reactivateName,
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
                'name' => 'reactivate_date',
                'id' => 'reactivate_date',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $reactivate_date,
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
                'name' => 'reactivate_time',
                'id' => 'reactivate_time',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $reactivate_time,
            );

            echo form_input($data);
            ?>     
        </div>
    </div>

</div>

<div class="row m-t-10">
    <div class="col-md">  
        <label >Comments <span class="red"> *</span></label><br>
        <div>
            <?php
            $data = array(
                'name' => 'reactivate_comments',
                'id' => 'reactivate_comments',
                'placeholder' => '',
                'class' => 'form-control',
                'autocomplete' => 'off',
                'rows' => 5,
                'cols' => 10,
                'value' =>$reactivate_comments,
            );
            /*Status based disable*/
            $data = ($PTWStatus ==10 ||  $PTWStatus == 7) ? $data + $aDisableAttr: $data;
            echo form_textarea($data);
            ?> 
              <?php echo form_error('reactivate_comments', '<div class="error">', '</div>'); ?>
            <span class="red"></span>
        </div>
    </div>
</div>
<input type="hidden" id="submitreaction" name="submitreaction" value=""/>

<script>
    $(document).ready(function (){
        
        $('#reactivate_cancel_form').validate({
	rules: {

	    "reactivate_cancel_declaration": {
		required: true,
	    },
	    "reactivate_comments": {
		required: true,
	    },
	   
	    
	   
	},
	messages: {
	    "reactivate_cancel_declaration": {
		required: "Please select the Option",
	    },
	    "reactivate_comments": {
		required: "Please enter your comments",
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
           }else if(element.attr('name') == 'reactivate_cancel_declaration') {
                error.appendTo('span.reactivate_cancel_declaration_error');
           }
           else {
               error.insertAfter(element);
           }
             
        },
	submitHandler: function (form) {
             var submitButtonName =  $(this.submitButton).attr("name");
            $('#submitreaction').val(submitButtonName);
             swal({
                title: "Are you sure",
                text: "You want to "+submitButtonName,
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                closeButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            swal({
                                title: "Please wait..",
                                imageUrl: loadingImg,
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                            
                            form.submit();
                           
                        } 
                    });
	}
    });
 
        $(document).on('change','#reactivate_cancel_declaration',function (){
           // $('.stop_cancel_declaration').prop('checked', false);
            $('#reactivate_date').val(getTodayDate());
            $('#reactivate_time').val(formatAMPM(new Date));
            $(this).prop('checked', true);
            
        });
        
       
        
    })
    </script>
