<div class="row">
    <div class="col-md-12">
        <label>A.Verification by SHO/HSE Executive</label>
    </div>
</div>
<?php
$applicantName = postData($editData, 'SHO_HSE_NAME', postData($userDetails, 'NAME'),$this->input->post('verification_hse_name'));

$operation_authority_1 = postData($editData, 'OA1',$this->input->post('operation_authority_1'));
$operation_authority_2 =  postData($editData, 'OA2',$this->input->post('operation_authority_2'));

$verification_hse_date = ($applicantdate != '') ? postData($editData, 'SHO_HSE_DATE', $applicantdate) : $this->input->post('verification_hse_date');
$verification_hse_time = ($applicanttime != '') ? postData($editData, 'SHO_HSE_TIME', $applicanttime) : $this->input->post('verification_hse_time');
$verification_hse_date = ($ptw_id > 0) ? convertDate($verification_hse_date, PTW_DATE_FORMAT) : $initial_pa_date;
$verification_hse_time = ($ptw_id > 0) ? convertDate($verification_hse_time, PTW_TIME_FORMAT) : $initial_pa_time;

$PTWStatus = postData($editData,'STATUS');

$hse_verify =  postData($editData, 'SHO_HSE_VERIFY',$this->input->post('hse_verify'));
$hse_remark = postData($editData, 'SHO_HSE_REMARKS',$this->input->post('hse_remark'));
global $aHseVerify;

$hseReject = postData($editData, 'HSE_REJECT');
$OAReject = postData($editData, 'OA_REJECT');

        
?>
<div class="row">
   
    <div class="col-md-12">
         <label>I have inspected the work area and found to be;</label>
        <?php if($aHseVerify != FALSE && count($aHseVerify) > 0){
            
            foreach($aHseVerify as $key => $val){
                $checked = ($hse_verify !='' && $hse_verify == $key ) ? 'checked ' : '';
                $checkLabel = ($hse_verify !='' && $hse_verify != $key && $PTWStatus > 1 ) ? 'onclick="return false;"' : '';
                
                
                ?>
       
        <div class="form-check">
            <input class="form-check-input hse_verify" type="checkbox" name="hse_verify" id="hse_verify_<?php echo $key;?>" <?php echo $checked;?> <?php echo $checkLabel;?> value="<?php echo $key;?>"  >
            <label class="form-check-label" for="hse_verify_<?php echo $key;?>"><?php echo $val;?></label>
        </div>
         <?php
            }
        }
        ?>
        <span class="red hse_verify_error"></span>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Remark </label><br>
        <div>
            <?php
            $data = array(
                'name' => 'hse_remark',
                'id' => 'hse_remark',
                'placeholder' => '',
                'class' => 'form-control',
                'autocomplete' => 'off',
                'rows' => 5,
                'cols' => 10,
                'value' => $hse_remark,
            );
            /*Status based disable*/
            $data = ($PTWStatus > 1) ? $data + $aDisableAttr: $data;
            echo form_textarea($data);
            ?> 
              <?php echo form_error('hse_remark', '<div class="error">', '</div>'); ?>
            <span class="red"></span>
        </div>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >SHO/HSSE Executive name</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'verification_hse_name',
                'id' => 'verification_hse_name',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $applicantName,
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
                'name' => 'verification_hse_date',
                'id' => 'verification_hse_date',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $verification_hse_date
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
                'name' => 'verification_hse_time',
                'id' => 'verification_hse_time',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $verification_hse_time
            );

            echo form_input($data);
            ?>     
        </div>
    </div>

</div>
<div class="row m-t-10">
    <div class="col-md-4"> 
        <label >Operating Authority 1 <span class="red">*</span></label><br>
        <div>
            <?php
            $OAInfoDetails = [
                'id' => 'operation_authority_verify_1',
                'class' => 'form-control select2bs4 select2',
               
            ];
            
            echo form_dropdown('operation_authority_1', $OAList, $operation_authority_1, $OAInfoDetails);
            ?>

        </div>
        <span class="red"></span>
    </div>
    <div class="col-md-4"> 
        <label >Operating Authority 2 <span class="red">*</span></label><br>
        <div>
            <?php
            $OAInfoDetails = [
                'id' => 'operation_authority_verify_2',
                'class' => 'form-control select2bs4 select2',
               
            ];
           
            echo form_dropdown('operation_authority_2', $OAList, $operation_authority_2, $OAInfoDetails);
            ?>

        </div>
        <span class="red"></span>
    </div>
</div>

<script>
    $(document).ready(function() {
        
       
       
         $('#approve_form').validate({
	rules: {

	    "hse_verify": {
		required: true,
	    },
	   
	    
	   
	},
	messages: {
	    "hse_verify": {
		required: "Please select the Option",
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
           
           }else {
                error.appendTo('span.hse_verify_error');
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
    })
</script>


<script>
    $(document).ready(function (){
        
 
        $(document).on('change','.hse_verify',function (){
           
            $('.hse_verify').prop('checked', false);
            $('#verification_hse_date').val(getTodayDate());
            $('#verification_hse_time').val(formatAMPM(new Date));
            $(this).prop('checked', true);
        });
        
       
        
    })
    </script>
    
    
