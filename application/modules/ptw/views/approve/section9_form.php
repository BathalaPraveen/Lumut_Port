<?php 
$ackapplicantName = postData($editData, 'WORK_SUPERVISOR_NAME', postData($userDetails, 'NAME'),$this->input->post('work_supervisor_name'));

$work_supervisor_date = ($applicantdate != '') ? postData($editData, 'WORK_SUPERVISOR_DATE', $applicantdate) : $this->input->post('work_supervisor_date');
$work_supervisor_time = ($applicanttime != '') ? postData($editData, 'WORK_SUPERVISOR_TIME', $applicanttime) : $this->input->post('work_supervisor_time');
$work_supervisor_declaration =  postData($editData, 'WORK_SUPERVISOR_DECLARATION', $this->input->post('work_supervisor_declaration'))  ;
$work_supervisor_date = ($ptw_id > 0) ? convertDate($work_supervisor_date, PTW_DATE_FORMAT) : $work_supervisor_date;
$work_supervisor_time = ($ptw_id > 0) ? convertDate($work_supervisor_time, PTW_TIME_FORMAT) : $work_supervisor_time;
    $PTWStatus = postData($editData,'STATUS');    
    $initialChecked = ($PTWStatus > 4) ? ' onclick="return false"' : '';
    $checked = ($work_supervisor_declaration == 1) ? 'checked' : '';
?>
<div class="row">
    <div class="col-md-12">
         <label>A.WORK SUPERVISOR (WS)</label>
        
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="work_supervisor_declaration" id="work_supervisor_declaration"  value="1" <?php echo $initialChecked;?>  <?php echo $checked;?> >
            <label class="form-check-label" for="work_supervisor_declaration">
                I had understand the permit content and shall comply with the PTW requirement before, during and after the work is complete.
            </label>
        </div>
        <?php echo form_error('work_supervisor_declaration','<div class="error">','</div>') ?>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Work Supervisor name</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'work_supervisor_name',
                'id' => 'work_supervisor_name',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $ackapplicantName,
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
                'name' => 'work_supervisor_date',
                'id' => 'work_supervisor_date',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $work_supervisor_date,
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
                'name' => 'work_supervisor_time',
                'id' => 'work_supervisor_time',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $work_supervisor_time,
            );

            echo form_input($data);
            ?>     
        </div>
    </div>

</div>
<script>
    $(document).ready(function (){
        
 
        $(document).on('change','#work_supervisor_declaration',function (){
           
          
            $('#work_supervisor_date').val(getTodayDate());
            $('#work_supervisor_time').val(formatAMPM(new Date));
            $(this).prop('checked', true);
//            $('#work_supervisor_declaration').prop('checked', false);
        });
        
       
        
    })
    </script>
