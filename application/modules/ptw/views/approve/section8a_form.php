<?php 
$stop_work_name = postData($editData, 'STOPWORKORDER_NAME', postData($userDetails, 'NAME'),$this->input->post('stop_work_name'));
$stop_comments = postData($editData, 'STOPWORKORDER_REASON', $this->input->post('stop_comments'));

$stop_work_date = ($applicantdate != '') ? postData($editData, 'STOPWORKORDER_DATE', $applicantdate) : $this->input->post('stop_work_date');
$stop_work_time = ($applicanttime != '') ? postData($editData, 'STOPWORKORDER_TIME', $applicanttime) : $this->input->post('stop_work_time');
$stop_cancel_declaration =  postData($editData, 'STOPWORKORDER_DECLARATION', $this->input->post('stop_cancel_declaration'))  ;
$stop_work_date = ($ptw_id > 0) ? convertDate($stop_work_date, PTW_DATE_FORMAT) : $stop_work_date;
$stop_work_time = ($ptw_id > 0) ? convertDate($stop_work_time, PTW_TIME_FORMAT) : $stop_work_time;
    $PTWStatus = postData($editData,'STATUS');    
    $initialChecked = (in_array($PTWStatus, [8,9,10])) ? ' onclick="return false"' : '';
    $checked = ($stop_cancel_declaration == 1) ? 'checked' : '';
?>

<div class="row">
    <div class="col-md-12">
         <label>A.STOP WORK ORDER</label>
        
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="stop_cancel_declaration" id="stop_cancel_declaration"  value="1" <?php echo $checked;?> <?php echo $initialChecked;?>  >
            <label class="form-check-label" for="stop_cancel_declaration">Permit Stoppage/Cancel Permit
            </label>
        </div>
        <?php echo form_error('stop_cancel_declaration','<div class="error">','</div>') ?>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Name</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'stop_work_name',
                'id' => 'stop_work_name',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $stop_work_name,
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
                'name' => 'stop_work_date',
                'id' => 'stop_work_date',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $stop_work_date,
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
                'name' => 'stop_work_time',
                'id' => 'stop_work_time',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $stop_work_time,
            );

            echo form_input($data);
            ?>     
        </div>
    </div>

</div>

<div class="row m-t-10">
    <div class="col-md">  
        <label >Comments <span class="red"> *</span> </label><br>
        <div>
            <?php
            $data = array(
                'name' => 'stop_comments',
                'id' => 'stop_comments',
                'placeholder' => '',
                'class' => 'form-control',
                'autocomplete' => 'off',
                'rows' => 5,
                'cols' => 10,
                'value' =>$stop_comments,
            );
            /*Status based disable*/
            $data = ($PTWStatus >=8 || $PTWStatus == 7) ? $data + ['readonly'=>'readonly']: $data;
            echo form_textarea($data);
            ?> 
              <?php echo form_error('stop_comments', '<div class="error">', '</div>'); ?>
            <span class="red"></span>
        </div>
    </div>
</div>
<input type="hidden" id="submitaction" name="submitaction" value=""/>


<script>
    $(document).ready(function (){
                
        $('#stop_cancel_form').validate({
	rules: {

	    "stop_cancel_declaration": {
		required: true,
	    },
	    "stop_comments": {
		required: true,
	    },
	   
	    
	   
	},
	messages: {
	    "stop_cancel_declaration": {
		required: "Please select the Option",
	    },
	    "stop_comments": {
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
           } else {
               error.insertAfter(element);
           }
             
        },
	submitHandler: function (form) {
            var submitButtonName =  $(this.submitButton).attr("name");
            $('#submitaction').val(submitButtonName);
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
    
       
 
        $(document).on('change','#stop_cancel_declaration',function (){
           // $('.stop_cancel_declaration').prop('checked', false);
            $('#stop_work_date').val(getTodayDate());
            $('#stop_work_time').val(formatAMPM(new Date));
            $(this).prop('checked', true);
            $('input[name="stop"]').removeAttr('disabled');
            $('input[name="cancel"]').removeAttr('disabled');
        });
        
       
        
    })
    </script>
