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
$checked = ($gas_test_declaration == 1) ? 'checked' : '';
$checkedClass = ($gas_test_declaration == 1) ? 'dislay:block;' : 'display:none;';
$csDate = ($ptw_id > 0) ? convertDate($csDate, PTW_DATE_FORMAT) : $csDate;
$csTime = ($ptw_id > 0) ? convertDate($csTime, PTW_TIME_FORMAT) : $csTime;

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
                        );

                        echo form_input($data);
                ?></td>
                    
                    
                </tr>
                <tr>
                    <td>Time</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][time]',
                            'id' => 'confined_space_time-1',
                            'placeholder' => '',
                            'class' => 'form-control',
                            'readonly' => 'readonly',
                            'value' => $csTime,
                        );

                        echo form_input($data);
                ?></td>
                    
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
                            'min'=>'-10',
                            'max'=>'10',
                        );
                        if($i != 0){
                           $data['readonly'] = 'readonly';
                        }
                        echo form_input($data);
                ?></td>
                    
                </tr>
                
                <tr>
                    <td>% O2 (19.5 ≤ O2 ≤ 23.5%)</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][O2]',
                            'id' => 'confined_space_O2-1',
                            'placeholder' => '',
                            'class' => 'form-control',
                            'value' => $csO2,
                            'type'=>'number',
                            'step'=>'0.1',
                            'min'=>'19.5',
                            'max'=>'23.5',
                        );
                        if($i != 0){
                           $data['readonly'] = 'readonly';
                        }
                        echo form_input($data);
                ?></td>
                    
                </tr>
                
                <tr>
                    <td>H2S (≤10 ppm)</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][H2S]',
                            'id' => 'confined_space_H2S-1',
                            'placeholder' => '',
                            'class' => 'form-control',
                            'value' => $csH2S,
                            'type'=>'number',
                            'step'=>'0.1',
                            'min'=>'-10',
                            'max'=>'10',
                        );
                        if($i != 0){
                           $data['readonly'] = 'readonly';
                        }
                        echo form_input($data);
                ?></td>
                    
                </tr>
                
                <tr>
                    <td>CO (≤ 25 ppm)</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][CO]',
                            'id' => 'confined_space_CO-1',
                            'placeholder' => '',
                            'class' => 'form-control',
                            'value' => $csCO,
                            'type'=>'number',
                            'step'=>'0.1',
                             'min'=>'-25',
                            'max'=>'25',
                        );
                        if($i != 0){
                           $data['readonly'] = 'readonly';
                        }
                        echo form_input($data);
                ?></td>
                    
                </tr>
                <tr>
                    <td>AGT's Name</td>
                    <td><?php
                        $data = array(
                            'name' => 'confined_space[-1][agt_name]',
                            'id' => 'confined_space_agt_name-1',
                            'placeholder' => '',
                            'class' => 'form-control alphaspacedot',
                            'value' => $csAgtname,
                           
                        );
                        if($i != 0){
                           $data['readonly'] = 'readonly';
                        }
                        echo form_input($data);
                ?></td>
                   
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
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
