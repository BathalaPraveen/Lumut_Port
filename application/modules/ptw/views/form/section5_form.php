<?php
$applicantName = postData($editData, 'INITIAL_PA_NAME', postData($userDetails, 'NAME'),$this->input->post('initial_pa_name'));
$initial_pa_date = ($applicantdate != '') ? postData($editData, 'INITIAL_PA_DATE', $applicantdate) : $this->input->post('initial_pa_date');
$initial_pa_time = ($applicanttime != '') ? postData($editData, 'INITIAL_PA_TIME', $applicanttime) : $this->input->post('initial_pa_time');
$initial_declaration =  postData($editData, 'INITIAL_DECLARATION',$this->input->post('initial_declaration'));
$operation_authority_1 = postData($editData, 'OA1',$this->input->post('operation_authority_1'));
$operation_authority_2 =  postData($editData, 'OA2',$this->input->post('operation_authority_2'));
$OAList = getOAList('drop');
$initialChecked = ($initial_declaration == 1) ? 'checked' : '';
$initial_pa_date = ($ptw_id > 0) ? convertDate($initial_pa_date, PTW_DATE_FORMAT) : $initial_pa_date;
$initial_pa_time = ($ptw_id > 0) ? convertDate($initial_pa_time, PTW_TIME_FORMAT) : $initial_pa_time;
?>
<div class="row">
    <div class="col-md-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="initial_declaration" id="initial_declaration"  value="1" <?php echo $initialChecked;?> >
            <label class="form-check-label" for="initial_declaration">
                I understand the required Checkbox precautions specified in Section 3 in order to perform activity stipulated on section 2 and accept all responsibilities for the work stated
            </label>
        </div>
    </div>
</div>
<div class="row m-t-10">
    <div class="col-md">  
        <label >Name</label><br>
        <div>
            <?php
            $data = array(
                'name' => 'initial_pa_name',
                'id' => 'initial_pa_name',
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
                'name' => 'initial_pa_date',
                'id' => 'initial_pa_date',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $initial_pa_date,
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
                'name' => 'initial_pa_time',
                'id' => 'initial_pa_time',
                'placeholder' => '',
                'class' => 'form-control',
                'readonly' => 'readonly',
                'value' => $initial_pa_time,
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
                'id' => 'operation_authority_1',
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
                'id' => 'operation_authority_2',
                'class' => 'form-control select2bs4 select2',
               
            ];
           
            echo form_dropdown('operation_authority_2', $OAList, $operation_authority_2, $OAInfoDetails);
            ?>

        </div>
        <span class="red"></span>
    </div>
</div>
<script>
        $(document).ready(function (){
    $(document).on('change','#initial_declaration',function (){
          
            $('#initial_pa_date').val(getTodayDate());
            $('#initial_pa_time').val(formatAMPM(new Date));
            $(this).prop('checked', true);
            
        });
         })
    </script>
