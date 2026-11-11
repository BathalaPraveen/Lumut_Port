<?php 
$PTWStatus = postData($editData,'STATUS'); 

$confinedPreEntryDate = date(PTW_DATE_FORMAT);
$confinedPreEntryTime = date(PTW_TIME_FORMAT);
$confineLoopEntryCount = $confinedEntryCounts;
$conditionDisplayStatus = (in_array($PTWStatus, [6]))? TRUE : FALSE;
$csPreEntryList = isset($confinedSpaceList[-1])? $confinedSpaceList[-1] : [];
$csDate = postData($csPreEntryList,'date',$confinedPreEntryDate);
$csTime = postData($csPreEntryList,'time',$confinedPreEntryTime);
$csLel = postData($csPreEntryList,'lel','');
$csO2 = postData($csPreEntryList,'O2','');
$csH2S = postData($csPreEntryList,'H2S','');
$csCO = postData($csPreEntryList,'CO','');
$csAgtname = postData($csPreEntryList,'agt_name','');
$gas_test_declaration =($csPreEntryList != FALSE && count($csPreEntryList) > 0) ? 1: $this->input->post('gas_test_declaration');
$checked = ($gas_test_declaration == 1) ? 'checked onclick="return false;"' : '';
$checkedClass = ($gas_test_declaration == 1) ? 'dislay:block;' : 'display:none;';
$csDate = ($ptw_id > 0) ? convertDate($csDate, PTW_DATE_FORMAT) : $csDate;
$csTime = ($ptw_id > 0) ? convertDate($csTime, PTW_TIME_FORMAT) : $csTime;

$confineLoopTotalCount = ($confineLoopEntryCount == 8) ?  7 : $confineLoopEntryCount;
?>
<div class="row">
    <div class="col-md-12">
        <label>A) GAS TEST MONITORING (Select appropriate boxes)</label>
    </div>
</div>

<div class="row m-t-10" style="margin-left:10px;">
    <div class="col-md-12">
        <div class="form-check">
            <input class="form-check-input gastest" type="checkbox" name="gas_test_declaration" id="gas_test_declaration"   value="1" <?php echo $checked;?>  >
            <label class="form-check-label" for="gas_test_declaration">
               GAS TEST
            </label>
        </div>
        
    </div>
</div>

<div class="row" style="margin-left:10px;<?php echo $checkedClass;?>" id="confinedspaceentry">
    <div class="col-md-12">
        <label>Gas Test Result</label>
        <table class="table">
            <thead>
                <tr>
                    <th>Confined Space Condition</th>
                    <th>Pre-Entry Result</th>
                    <?php 
                    if($conditionDisplayStatus){
                    for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <th>Execution # <?php echo $i+1;?></th>
                    <?php }} ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Date</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][date]',
                            'id' => 'confined_space_date-1',
                            'placeholder' => '',
                            'class' => 'form-control',
                            'readonly' => 'readonly',
                            'value' => $csDate,
                            'disabled' => 'disabled',
                        );

                        echo form_input($data);
                ?></td>
                     <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                    $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
$csCurDate = postData($csCurrentInfo,'date',date('Y-m-d'));
$csCurDate = ($ptw_id > 0) ? convertDate($csCurDate, PTW_DATE_FORMAT) : $csCurDate;

                        $data = array(
                            'name' => 'confined_space['.$i.'][date]',
                            'id' => 'confined_space_date'.$i,
                            'placeholder' => '',
                            'class' => 'form-control cspace',
                            'readonly' => 'readonly',
                            'value' => $csCurDate,
                        );
                        if(postData($csCurrentInfo,'date',FALSE) != FALSE ){
                           $data['disabled'] = 'disabled'; 
                        }

                        echo form_input($data);
                ?> </td>
                    <?php } }?>
                    
                    
                </tr>
                <tr>
                    <td>Time</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][time]',
                            'id' => 'confined_space_time-1',
                            'placeholder' => '',
                            'class' => 'form-control cspace',
                            'readonly' => 'readonly',
                            'value' => $csTime,
                            'disabled' => 'disabled',
                        );

                        echo form_input($data);
                ?></td>
                     <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                    $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                   
                    $csCurTime = postData($csCurrentInfo,'time',date('H:i:s'));
                    $csCurTime = ($ptw_id > 0) ? convertDate($csCurTime, PTW_TIME_FORMAT) : $csCurTime;
                        $data = array(
                            'name' => 'confined_space['.$i.'][time]',
                            'id' => 'confined_space_time'.$i,
                            'placeholder' => '',
                            'class' => 'form-control cspace',
                            'readonly' => 'readonly',
                            'value' => $csCurTime,
                        );
                         if(postData($csCurrentInfo,'time',FALSE) != FALSE ){
                           $data['disabled'] = 'disabled'; 
                        }

                        echo form_input($data);
                ?> </td>
                    <?php } }?>
                    
                </tr>
                
                 <tr>
                    <td>% LEL (≤ 10%)</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][lel]',
                            'id' => 'confined_space_lel-1',
                            'placeholder' => '',
                            'class' => 'form-control',
                            'value' => $csLel,
                            'type'=>'number',
                            'step'=>'0.1',
                            'min'=>'0',
                            'max'=>'10',
                             'readonly' => 'readonly',
                             'disabled' => 'disabled',
                        );
                        
                        echo form_input($data);
                ?></td>
                    
                    <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                     $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                   
                    $csCurLel= postData($csCurrentInfo,'lel',FALSE);
                   
                         $data = array(
                            'name' => 'confined_space['.$i.'][lel]',
                            'id' => 'confined_space_lel'.$i,
                            'placeholder' => '',
                            'class' => 'form-control cspace',
                            'value' => $csCurLel,
                            'type'=>'number',
                            'step'=>'0.1',
                            'min'=>'0',
                            'max'=>'10',
                            
                        );
                        if($csCurLel != FALSE){
                           $data['readonly'] = 'readonly';
                           $data['disabled'] = 'disabled';
                        }
                        echo form_input($data);
                ?> </td>
                    <?php } }?>
                    
                </tr>
                
                <tr>
                    <td>% O2 (19.5 ≤ O2 ≤ 23.5%)</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][O2]',
                            'id' => 'confined_space_O2-1',
                            'placeholder' => '',
                            'class' => 'form-control cspace',
                            'value' => $csO2,
                            'type'=>'number',
                            'step'=>'0.1',
                            'min'=>'19.5',
                            'max'=>'23.5',
                             'readonly' => 'readonly',
                             'disabled' => 'disabled',
                        );
                        
                        echo form_input($data);
                ?></td>
                     <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                     <td><?php
                     $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                     $csCurO2= postData($csCurrentInfo,'O2',FALSE);
                        $data = array(
                            'name' => 'confined_space['.$i.'][O2]',
                            'id' => 'confined_space_O2'.$i,
                            'placeholder' => '',
                            'class' => 'form-control cspace',
                            'value' => $csCurO2,
                            'type'=>'number',
                            'step'=>'0.1',
                            'min'=>'19.5',
                            'max'=>'23.5',
                        );
                        if($csCurO2 != FALSE){
                            $data['readonly'] = 'readonly';
                           $data['disabled'] = 'disabled';
                        }
                        echo form_input($data);
                ?></td>
                      <?php } }?>
                    
                </tr>
                
                <tr>
                    <td>H2S (≤10 ppm)</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][H2S]',
                            'id' => 'confined_space_H2S-1',
                            'placeholder' => '',
                            'class' => 'form-control cspace',
                            'value' => $csH2S,
                            'type'=>'number',
                            'step'=>'0.1',
                            'min'=>'0',
                            'max'=>'10',
                             'readonly' => 'readonly',
                             'disabled' => 'disabled',
                        );
                        
                        echo form_input($data);
                ?></td>
                     <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                    $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                     $csCurH2S= postData($csCurrentInfo,'H2S',FALSE);
                        $data = array(
                            'name' => 'confined_space['.$i.'][H2S]',
                            'id' => 'confined_space_H2S'.$i,
                            'placeholder' => '',
                            'class' => 'form-control cspace',
                            'value' => $csCurH2S,
                            'type'=>'number',
                            'step'=>'0.1',
                            'min'=>'0',
                            'max'=>'10',
                        );
                        if($csCurH2S != FALSE){
                           $data['readonly'] = 'readonly';
                           $data['disabled'] = 'disabled';
                        }
                        echo form_input($data);
                ?></td>
                     <?php } }?>
                    
                </tr>
                
                <tr>
                    <td>CO (≤ 25 ppm)</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][CO]',
                            'id' => 'confined_space_CO-1',
                            'placeholder' => '',
                            'class' => 'form-control cspace',
                            'value' => $csCO,
                            'type'=>'number',
                            'step'=>'0.1',
                             'min'=>'0',
                            'max'=>'25',
                             'readonly' => 'readonly',
                             'disabled' => 'disabled',
                        );
                       
                        echo form_input($data);
                ?></td>
                     <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                    $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                     $csCurCO= postData($csCurrentInfo,'CO',FALSE);
                        $data = array(
                            'name' => 'confined_space['.$i.'][CO]',
                            'id' => 'confined_space_CO'.$i,
                            'placeholder' => '',
                            'class' => 'form-control cspace',
                            'value' => $csCurCO,
                            'type'=>'number',
                            'step'=>'0.1',
                             'min'=>'0',
                            'max'=>'25',
                        );
                        if($csCurCO != FALSE){
                           $data['readonly'] = 'readonly';
                           $data['disabled'] = 'disabled';
                        }
                        echo form_input($data);
                ?></td>
                    <?php } }?>
                    
                </tr>
                <tr>
                    <td>AGT's Name</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][agt_name]',
                            'id' => 'confined_space_agt_name-1',
                            'placeholder' => '',
                            'class' => 'form-control alphaspacedot cspace',
                            'value' => $csAgtname,
                             'readonly' => 'readonly',
                             'disabled' => 'disabled',
                           
                        );
                       
                        echo form_input($data);
                ?></td>
                    <?php if($conditionDisplayStatus){ for($i=0;$i<$confineLoopTotalCount;$i++){?>
                    <td><?php
                    $csCurrentInfo = isset($confinedSpaceList[$i])? $confinedSpaceList[$i] : [];
                     $csCurAgtName= postData($csCurrentInfo,'agt_name',FALSE);
                        $data = array(
                            'name' => 'confined_space['.$i.'][agt_name]',
                            'id' => 'confined_space_agt_name'.$i,
                            'placeholder' => '',
                            'class' => 'form-control alphaspacedot',
                            'value' => $csCurAgtName,
                           
                        );
                        if($csCurAgtName != FALSE){
                           $data['readonly'] = 'readonly';
                           $data['disabled'] = 'disabled';
                        }
                        echo form_input($data);
                ?></td>
                    <?php } }?>
                   
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var cspaceLoop = <?php echo $confineLoopEntryCount;?>;
        var csval = parseInt(cspaceLoop)-1;
       
        $('#confined_space_form').validate({
	rules: {

	     "confined_space[0][lel]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 0){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[0][O2]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 0){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[0][H2S]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 0){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[0][CO]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 0){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[0][agt_name]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 0){
                            return true;
                        }else{
                            return false;
                        }

                    },
                }, "confined_space[1][lel]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 1){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[1][O2]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 1){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[1][H2S]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 1){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[1][CO]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 1){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[1][agt_name]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 1){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                 "confined_space[2][lel]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 2){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[2][O2]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 2){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[2][H2S]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 2){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[2][CO]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 2){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[2][agt_name]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 2){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                 "confined_space[3][lel]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 3){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[3][O2]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 3){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[3][H2S]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 3){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[3][CO]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 3){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[3][agt_name]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 3){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                 "confined_space[4][lel]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 4){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[4][O2]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 4){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[4][H2S]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 4){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[4][CO]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 4){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[4][agt_name]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 4){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                 "confined_space[5][lel]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 5){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[5][O2]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 5){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[5][H2S]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 5){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[5][CO]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 5){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[5][agt_name]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 5){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                 "confined_space[6][lel]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 6){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[6][O2]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 6){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[6][H2S]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 6){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[6][CO]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 6){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[6][agt_name]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == 6){
                            return true;
                        }else{
                            return false;
                        }

                    },
                }
                
	    
	   
	},
	messages: {
	   
           
	   
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
            
            swal({
                title: "Please wait..",
                imageUrl: loadingImg,
                showConfirmButton: false,
                allowOutsideClick: false
               });
               form.submit();
	}
    });
    
    $(document).on('blur change', '.cspace', function () {
         $('input[name="confinedSpace"]').removeAttr('disabled');
    });
    
        $(document).on('change', '#gas_test_declaration', function () {
               var cval = $(this).val();
            if ($(this).is(':checked')) {
                $('#confinedspaceentry').show();
               
            } else {
                $('#confinedspaceentry').hide();
            }
        });
        
    })
    </script>
