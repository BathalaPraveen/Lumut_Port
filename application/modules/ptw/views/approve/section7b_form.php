<div class="row">
    <div class="col-md-12">
        <label>B.VERIFICATION BY OPERATING AUTHORITY (OA)</label>
    </div>
</div>
<?php

$qaName = postData($editData, 'OA_NAME', postData($userDetails, 'NAME'),$this->input->post('qa_name'));

$qa_date = ($applicantdate != '') ? postData($editData, 'OA_DATE', $applicantdate) : $this->input->post('qa_date');
$qa_time = ($applicanttime != '') ? postData($editData, 'OA_TIME', $applicanttime) : $this->input->post('qa_time');
$qa_date = ($ptw_id > 0) ? convertDate($qa_date, PTW_DATE_FORMAT) : $qa_date;
$qa_time = ($ptw_id > 0) ? convertDate($qa_time, PTW_TIME_FORMAT) : $qa_time;
    $PTWStatus = postData($editData,'STATUS');    
    $initialChecked = ($PTWStatus > 2) ? 'checked onclick="return false"' : '';
    $qa_remark = postData($editData, 'OA_REMARKS',$this->input->post('qa_remark'));
?>


<div class="row">
    <div class="col-md-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="qa_declaration" id="qa_declaration"  value="1" <?php echo $initialChecked;?> >
            <label class="form-check-label" for="qa_declaration">
                I understand the activity/precautions and fulfilment of this permit, therefore I authorized the PA to commence with the work described in Section 1.
            </label>
        </div>
        <?php echo form_error('qa_declaration','<div class="error">','</div>') ?>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Remark </label><br>
        <div>
            <?php
            $data = array(
                'name' => 'qa_remark',
                'id' => 'qa_remark',
                'placeholder' => '',
                'class' => 'form-control',
                'autocomplete' => 'off',
                'rows' => 5,
                'cols' => 10,
                'value' => $qa_remark,
            );
            /*Status based disable*/
            $data = ($PTWStatus > 2) ? $data + $aDisableAttr: $data;
            echo form_textarea($data);
            ?> 
              <?php echo form_error('qa_remark', '<div class="error">', '</div>'); ?>
            <span class="red"></span>
        </div>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Name</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'qa_name',
                'id' => 'qa_name',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $qaName,
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
                'name' => 'qa_date',
                'id' => 'qa_date',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $qa_date,
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
                'name' => 'qa_time',
                'id' => 'qa_time',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $qa_time,
            );

            echo form_input($data);
            ?>     
        </div>
    </div>

</div>

<script>
    $(document).ready(function (){
        
        $(document).on('change','#qa_declaration',function (){
           
            $('#qa_date').val(getTodayDate());
            $('#qa_time').val(formatAMPM(new Date));
            $(this).prop('checked', true);
        }); 
        
        
        
    })
    </script>
    
    
