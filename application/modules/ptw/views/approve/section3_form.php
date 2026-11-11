<?php
$gas_tester_name = $this->input->post('gas_tester_name');
$other_isolation_desc = $this->input->post('other_isolation_desc');
$WPPcategoryLst = getWPPCategoryList();

$wppCheckListInfo = postData($additionalData,'wppCheckListInfo');
$wppViewInfo = postData($additionalData,'wppInfo');


$aWPPCheckList = [];

if($wppCheckListInfo != FALSE && count($wppCheckListInfo) > 0){
    foreach($wppCheckListInfo as $wppItem => $wppVal){
        $wppCid = postData($wppVal,'WSP_CATEGORY_ID');
        $wppCheckList = postData($wppVal,'checkListIds');
        $aWPPCheckList[$wppCid] = explode(',',$wppCheckList);
    }
}

if($WPPcategoryLst != FALSE && count($WPPcategoryLst) > 0){
    foreach($WPPcategoryLst as $key => $wppcat){
        $wppId = postData($wppcat,'WPPC_ID');
        $wppItemList = getWPPCategoryItemList($wppId,$permitType);
        ?>
        <div class="row m-t-10">
            <div class="col-md">  
                <label ><?php echo postData($wppcat, 'WPPC_NAME'); ?></label><br>
              
            </div>
        </div>
<?php
        if($wppItemList != FALSE && count($wppItemList) > 0){
            foreach ($wppItemList as $wkey => $wval){
                $wppItemId = postData($wval,'WPPI_ID');
                $wppName = postData($wval,'WPPI_NAME');
                $formIdName = 'wpp_checklist_';
                $formName = 'wpp_checklist_'.$wppId.'[]';
                
                $checkListItem = isset($aWPPCheckList[$wppId]) ? $aWPPCheckList[$wppId] : [];
                $checkedLabel = (in_array($wppItemId, $checkListItem)) ? 'checked ' : '';
                $wppchecked = (in_array($wppItemId, $checkListItem)) ? TRUE : FALSE;
                $wppRequireClass= ($wppchecked) ? 'display:block': 'display:none';
                 $WPPAttachmentInfo = (isset($wppViewInfo[$wppId][$wppItemId]['attachment'])) ? $wppViewInfo[$wppId][$wppItemId]['attachment'] : FALSE;
                  $WPPCheckInfo = (isset($wppViewInfo[$wppId][$wppItemId]['info'])) ? $wppViewInfo[$wppId][$wppItemId]['info'] : FALSE;
                ?>
                <div class="form-check">
                                    <input class="form-check-input wpp_checkbox " <?php echo $checkedLabel;?> onclick ="return false;" type="checkbox" name="<?php echo $formName; ?>" id="<?php echo $formIdName . $wppItemId; ?>" value="<?php echo $wppItemId; ?>" data-dynamicref="add_<?php echo $formIdName; ?>_<?php echo $wppItemId; ?>" data-id="<?php echo $wppItemId; ?>" >
                        
                                    <label class="form-check-label" for="<?php echo $formIdName . $wppItemId; ?>">
                                        <?php echo $wppName; ?> 
                                    </label>
                   </div>
                <div class="additional_wpp_doc" id="add_<?php echo $formIdName; ?>_<?php echo $wppItemId; ?>"  style="<?php echo $wppRequireClass;?>">
                    
      <?php 
                if($wppItemId == WPP_BASIC_REQ_OTHER_ID){ // other Id for section A basic requiremnt
                     $other_basic_req = ($WPPCheckInfo != FALSE) ? postData($WPPCheckInfo,'WSP_ITEM_LABEL') : $this->input->post('other_basic_req');
                    
                ?>
                             <div class="row m-t-10">
                                  <div class="col-md-6">
                                      <?php
                                          $data = array(
                                              'name' => 'other_basic_req',
                                              'id' => 'other_basic_req',
                                              'placeholder' => '',
                                              'class' => 'form-control',
                                              'autocomplete' => 'off',
                                              'disabled' => 'disabled',
                                              'readonly' => 'readonly',
                                              'value' => $other_basic_req,
                                          );

                                          echo form_input($data);
                                          ?> 
                                  </div>
                                  </div>
            <?php  
                }
                ?>
                    
                    <?php 
                if($wppItemId == WPP_ISOLATION_CRITICAL_OTHER_ID){ // other Id for section A basic requiremnt
                    $other_isolation_desc = ($WPPCheckInfo != FALSE) ? postData($WPPCheckInfo,'WSP_ITEM_LABEL') : $this->input->post('other_isolation_desc');
                    
                ?>
                             <div class="row m-t-10">
                                  <div class="col-md-6">
                                      <?php
                                          $data = array(
                                              'name' => 'other_isolation_desc',
                                              'id' => 'other_isolation_desc',
                                              'placeholder' => '',
                                              'class' => 'form-control',
                                              'autocomplete' => 'off',
                                              'disabled' => 'disabled',
                                              'readonly' => 'readonly',
                                              'value' => $other_isolation_desc,
                                          );

                                          echo form_input($data);
                                          ?> 
                                  </div>
                                  </div>
            <?php  
                }
                ?>
                    
                    
                    
            <?php 
                if($wppItemId == WPP_BASIC_REQ_GASTESTER_ID){ // Gast tester Id for section A basic requiremnt
                $gas_tester_name = ($WPPCheckInfo != FALSE) ? postData($WPPCheckInfo,'WSP_ITEM_LABEL') : $this->input->post('gas_tester_name');     
                ?>
                             <div class="row m-t-10">
                                  <div class="col-md-6">
                                      <label>Name</label>
                                      <?php
                                          $data = array(
                                              'name' => 'gas_tester_name',
                                              'id' => 'gas_tester_name',
                                              'placeholder' => '',
                                              'class' => 'form-control',
                                              'autocomplete' => 'off',
                                               'disabled' => 'disabled',
                                              'readonly' => 'readonly',
                                              'value' => $gas_tester_name,
                                          );

                                          echo form_input($data);
                                          ?> 
                                  </div>
                                  </div>
            <?php  
                }
                ?>
                    
                    
     
</div>

<?php
            }
            ?>
<?php
        }
        ?>
<span class="red wpp_checklist_<?php echo $wppId;?>_error"></span>
<?php
    }
}
?>

<script>
    $(document).ready(function () {
        
        $(document).on('change', '.wpp_checkbox', function () {
            var dref = $(this).attr('data-dynamicref');
            if ($(this).is(':checked')) {
                $('#' + dref).show();
            } else {
                $('#' + dref).hide();
            }
        });

    })
</script>

