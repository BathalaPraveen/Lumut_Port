<style>
    #map {

        height:360px;
        width: 100%;
    }
    .keyContdetails{
        border: 2px solid #1e6dab;
    }

</style>
<?php
$emp_name = $this->session->emp_details->EMP_NAME;
$emp_id = $this->session->emp_details->EMP_AUTO_ID;
$HIRARC_ID = postData($hir_details, 'HIRARC_ID');
$COM_NAME = postData($hir_details, 'COM_NAME');
$COM_NAME_OTH = postData($hir_details, 'OTH_COMP_NAME');
$TERMINAL_NAME = postData($hir_details, 'TERMINAL_NAME');
$HIRARC_FLOW_STATUS = postData($hir_details, 'HIRARC_FLOW_STATUS');
$EMP_NAME = postData($hir_details, 'EMP_NAME');
$DEPT_NAME = postData($hir_details, 'DEPT_NAME');
$PRO_NAME = postData($hir_details, 'PRO_ACT_LOC');
$HOD_ID = postData($hir_details, 'HOD_ID');
$MAIN_AUTO_ID = postData($hir_details, 'MAIN_AUTO_ID');
$Notify_id = postData($hir_details, 'CREATED_BY');
global $status_drop;
global $severity;
global $likelhood;
//echo '<pre>';
//print_r($hir_flow_details);
//exit;
?>
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class=" content">
            <div class="container-fluid">

                <div class="row"> 
                    <!-- left column -->
                    <div class="col-md-12">


                        <!-- general form elements -->
                        <div class="card card-headprimary">
                            <div class="row headingStyl">
                                <div class="col-md-12">
                                    <h4>HAZARD IDENTIFICATION RISK ASSESSMENT & RISK CONTROL (HIRARC)</h4>
                                    <a href="<?php echo BASE_URL('hirarc/hirarc') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $gethazid = isset($MAIN_AUTO_ID) && !empty($MAIN_AUTO_ID) ? $MAIN_AUTO_ID : '';
                                ?>
                                <?php echo form_open('hirarc/hirarc/saverisk/' . encryptval($gethazid), 'class="form-horizontal" id="hirarc_submit" novalidate'); ?>

                                <div class="emplDet m-t-10">
                                    <div class="row" >
                                        <div class="col-md-12">
                                            <div class="box-header with-border" >
                                                <h5 class=""> RISK ASSESSMENT & RISK CONTROL (HIRARC) </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 table-responsive  m-t-10">
                                        <table class="table table-striped">
                                            <tr>
                                                <td class="tdlabel"><b>HIRARC Id</b></td>
                                                <td>:</td>
                                                <td ><?php echo ($HIRARC_ID != '') ? $HIRARC_ID : 'Nil'; ?></td>
                                                <td class="tdlabel"><b>Company Name</b></td>
                                                <td class="title-colon">:</td>
                                                <td ><?php echo ($COM_NAME != '') ? $COM_NAME : 'Nil'; ?></td>
                                            </tr>

                                            <tr>
                                                <td class="tdlabel"><b>Terminal</b></td>
                                                <td class="title-colon">:</td>
                                                <td ><?php echo ($TERMINAL_NAME != '') ? $TERMINAL_NAME : 'Nil'; ?></td>

                                                <td class="tdlabel"><b>Department</b></td>
                                                <td class="title-colon">:</td>
                                                <td ><?php echo $DEPT_NAME; ?></td>

                                            </tr> 
                                            <tr>
                                                <td class="tdlabel"><b>Process/Location / Activity</b></td>
                                                <td class="title-colon">:</td>
                                                <td ><?php echo $PRO_NAME; ?></td>

                                                <td class="tdlabel"><b>Approve By</b></td>
                                                <td class="title-colon">:</td>
                                                <td ><?php echo $EMP_NAME; ?></td>
                                            </tr>
                                            <tr>
                                                <?php if ($COM_NAME_OTH != '') { ?>
                                                    <td class="tdlabel"><b>Others</b></td>
                                                    <td>:</td>
                                                    <td ><?php echo ($COM_NAME_OTH != '') ? $COM_NAME_OTH : 'Nil'; ?></td>
                                                <?php } ?>
                                                <td class="tdlabel"><b>Status</b></td>
                                                <td class="title-colon">:</td>
                                                <td ><?php echo ($HIRARC_FLOW_STATUS != '') ? $status_drop[$HIRARC_FLOW_STATUS] : 'Nil'; ?></td>
                                            </tr>
                                        </table> 
                                    </div> 
                                    <div class="col-md-12 ">
                                        <div class="btn btn-warning float-right removetr d-none"> Remove </div>
                                        <div class="btn btn-primary float-right add_more"> Add More </div>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-bordered risk_table">
                                            <thead>
                                            <th colspan="5" class="text-center">Hazard Identification</th>
                                            <th colspan="6" class="text-center">Risk Analysis</th>
                                            <th colspan="4" class="text-center">Risk Control/Opportunities</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>No.</td>
                                                    <td style="padding: 50px;text-align: center;">Process/Activity/ Area</td>
                                                    <td style="padding: 25px; text-align: center;">R/NR/E</td>
                                                    <td style="padding: 50px;text-align: center;">Hazard</td> 
                                                    <td style="padding: 50px;text-align: center;">Which Can Cause Effect</td>
                                                    <td style="padding: 50px;text-align: center;">Existing Risk Control</td>
                                                    <td style="padding: 30px;text-align: center;">Applicable Legal & Other Req.</td>
                                                    <td style="padding: 50px;text-align: center;">(S)</td>
                                                    <td style="padding: 50px;text-align: center;">(L)</td>
                                                    <td>(RR)</td> 
                                                    <td>Risk Level</td>
                                                    <td>Recommended Control/Opportunities</td>
                                                    <td style="padding: 30px;">Person In-Charge</td>
                                                    <td style="padding: 30px;text-align: center;">Due Date</td>
                                                    <td style="padding: 30px;text-align: center;">Status (Open/ Close)</td>
                                                </tr>
                                                <?php
                                                if (is_array($hir_flow_details) && !empty($hir_flow_details)) {
                                                    $i = 1;
                                                    foreach ($hir_flow_details as $key => $value) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td>
                                                                <input type="hidden" value="<?php echo postData($value, 'RP_AUTO_ID'); ?>" name="risk[<?php echo $i; ?>][hidden_id]" />
                                                                <div class="form-group">
                                                                    <?php
                                                                    $getProcVal = isset($value->FK_PRO_ACT_NAME) && !empty($value->FK_PRO_ACT_NAME) ? $value->FK_PRO_ACT_NAME : set_value('FK_PRO_ACT_NAME');
                                                                    $procdata = array(
                                                                        'id' => 'pro_Id_' . $i,
                                                                        'class' => 'form-control proval ',
                                                                        'required' => true,
                                                                        'name' => 'risk[' . $i . '][pro_Id]'
                                                                    );
                                                                    echo form_input($procdata, $getProcVal);
                                                                    ?>
                                                                    <span class="error"><?php echo form_error('risk[' . $i . '][pro_Id]') ?></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <?php
                                                                    $getrnr_Id = isset($value->FK_HAZ_TYPE_ID) && !empty($value->FK_HAZ_TYPE_ID) ? $value->FK_HAZ_TYPE_ID : set_value('FK_HAZ_TYPE_ID');
                                                                    $rnrdata = array(
                                                                        'id' => 'rnr_Id_' . $i,
                                                                        'class' => 'form-control select2',
                                                                        'required' => true,
                                                                        'checkselect' => 'select2',
                                                                    );
                                                                    echo form_dropdown('risk[' . $i . '][rnr_Id]', $getHazaTypedatas, $getrnr_Id, $rnrdata);
                                                                    ?>
                                                                    <span class="error"><?php echo form_error('risk[' . $i . '][rnr_Id]') ?></span>
                                                                </div>
                                                            </td>
                                                            <td class="haz_upp_<?php echo $i; ?>"> 
                                                                <div class="minus_hazard_<?php echo $i; ?> float-right d-none" onclick="minus_hazard(<?php echo $i; ?>)"><i class="fa fa-minus-circle"></i></div>
                                                                <div class="add_more_hazard float-right" onclick="add_more_hazard(<?php echo $i; ?>)"><i class="fa fa-plus-circle"></i></div>
                                                                <?php
                                                                $row_id = $value->RP_AUTO_ID;
                                                                $hirarc_id = $value->FK_HIRARC_MAIN_ID;
                                                                $haz_data = getAllHazardDatas($row_id, $hirarc_id);
                                                                if (is_array($haz_data) && !empty($haz_data)) {
                                                                    foreach ($haz_data as $key => $kval) {
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <?php
                                                                            $gethazrval = isset($kval->HAZ_NAME) && !empty($kval->HAZ_NAME) ? $kval->HAZ_NAME : set_value('PRO_ACT_LOC');
                                                                            $hadata = array(
                                                                                'id' => 'haz_Id_' . $i,
                                                                                'class' => 'form-control haz_name_' . $i,
                                                                                'required' => true,
                                                                                'name' => 'risk[' . $i . '][haz_name][]'
                                                                            );
                                                                            echo form_input($hadata, $gethazrval);
                                                                            ?>
                                                                            <span class="error"><?php echo form_error('risk[' . $i . '][haz_name][]') ?></span>
                                                                        </div>
                                                                        <input type="hidden" name="risk[<?php echo $i; ?>][haz_hidden_id][]" value="<?php echo $kval->HAZ_ID; ?>" />
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td  class="cause_<?php echo $i; ?>">
                                                                <div class="minus_cause_<?php echo $i; ?> float-right d-none" onclick="minus_cause(<?php echo $i; ?>)"><i class="fa fa-minus-circle"></i></div>
                                                                <div class="float-right" onclick="add_cause(<?php echo $i; ?>)"><i class="fa fa-plus-circle"></i></div>
                                                                <?php
                                                                $cause_data = getAllCauseDatas($row_id, $hirarc_id);
                                                                if (is_array($cause_data) && !empty($cause_data)) {
                                                                    foreach ($cause_data as $key => $cval) {
                                                                        ?>
                                                                        <div class="form-group"> 
                                                                            <?php
                                                                            $cause_name = isset($cval->CAUSE_NAME) && !empty($cval->CAUSE_NAME) ? $cval->CAUSE_NAME : set_value('PRO_ACT_LOC');
                                                                            $exitdata = array(
                                                                                'id' => 'cause_Id_' . $i,
                                                                                'class' => 'form-control cause_name_' . $i,
                                                                                'required' => true,
                                                                                'name' => 'risk[' . $i . '][cause_name][]'
                                                                            );
                                                                            echo form_input($exitdata, $cause_name);
                                                                            ?>
                                                                            <span class="error"><?php echo form_error('risk[' . $i . '][cause_name][]') ?></span>
                                                                        </div>
                                                                        <input type="hidden" name="risk[<?php echo $i; ?>][cause_hidden_id][]" value="<?php echo $cval->CAUSE_AUTO_ID; ?>" />
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="risk_<?php echo $i; ?>">
                                                                <div class="minus_risk_<?php echo $i; ?> float-right d-none" onclick="minus_risk(<?php echo $i; ?>)"><i class="fa fa-minus-circle"></i></div>
                                                                <div class="float-right" onclick="add_risk(<?php echo $i; ?>)"><i class="fa fa-plus-circle"></i></div>
                                                                <?php
                                                                $exit_data = getAllExitingDatas($row_id, $hirarc_id);
                                                                if (is_array($exit_data) && !empty($exit_data)) {
                                                                    foreach ($exit_data as $key => $eval) {
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <?php
                                                                            $risk_val = isset($eval->CONTROL_NAME) && !empty($eval->CONTROL_NAME) ? $eval->CONTROL_NAME : set_value('CONTROL_NAME');
                                                                            $risksel = array(
                                                                                'id' => 'riskId_' . $i,
                                                                                'class' => 'form-control risk_name_' . $i,
                                                                                'required' => true,
                                                                                'name' => 'risk[' . $i . '][risk_name][]'
                                                                            );
                                                                            echo form_input($risksel, $risk_val);
                                                                            ?>
                                                                            <span class="error"><?php echo form_error('risk[' . $i . '][risk_name][]') ?></span>
                                                                        </div>
                                                                        <input type="hidden" name="risk[<?php echo $i; ?>][risk_hidden_id][]" value="<?php echo $eval->CONTROL_AUTO_ID; ?>" />
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <?php
                                                                    $getlegId = isset($value->FK_LEGAL_ID) && !empty($value->FK_LEGAL_ID) ? explode(',', $value->FK_LEGAL_ID) : '';
                                                                    $legdata = array(
                                                                        'id' => 'legal_Id_' . $i,
                                                                        'class' => 'form-control select2 ',
                                                                        'required' => true,
                                                                        'checkselect' => 'select2',
                                                                        'multiple' => TRUE
                                                                    );
                                                                    echo form_dropdown('risk[' . $i . '][legal][]', $legalDatas, $getlegId, $legdata);
                                                                    ?>
                                                                    <span class="error"><?php echo form_error('risk[' . $i . '][legal][]') ?></span>
                                                                </div>
                                                            </td>
        <!--                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="range" id="seve_<?php echo $i; ?>" name="risk[<?php echo $i; ?>][seve]" value="<?php echo $value->SEVERITY; ?>" min="0" max="5" onchange="getriskmatrix('<?php echo $i; ?>');">
                                                                </div>
                                                            </td>-->
                                                            <td>
                                                                <div class="form-group">
                                                                    <?php
                                                                    $res = $value->SEVERITY;
                                                                    $statusDetails = [
                                                                        'id' => 'seve_' . $i,
                                                                        'class' => 'form-control select2',
                                                                        'checkSelect' => 'select2',
                                                                        'onchange' => "getriskmatrix($i);"
                                                                    ];

                                                                    echo form_dropdown('risk[' . $i . '][seve]', $severity, $res, $statusDetails);
                                                                    ?>
                                                                </div>
                                                            </td>
        <!--                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="range" id="likel_<?php echo $i; ?>" name="risk[<?php echo $i; ?>][likel]" min="0" max="5" value="<?php echo $value->LIKELIHOOD; ?>" onchange="getriskmatrix('<?php echo $i; ?>');">
                                                                </div>
                                                            </td>-->
                                                            <td>
                                                                <div class="form-group">
                                                                    <?php
                                                                    $resli = $value->LIKELIHOOD;
                                                                    $statuslikDetails = [
                                                                        'id' => 'likel_' . $i,
                                                                        'class' => 'form-control select2',
                                                                        'checkSelect' => 'select2',
                                                                        'onchange' => "getriskmatrix($i);"
                                                                    ];

                                                                    echo form_dropdown('risk[' . $i . '][likel]', $likelhood, $resli, $statuslikDetails);
                                                                    ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="hidden" name="risk[<?php echo $i; ?>][risk_val]" id="risk_val_<?php echo $i; ?>" value="<?php echo $value->FK_RISK_RATE; ?>">
                                                                    <div id="risk_val_show_<?php echo $i; ?>"></div>
                                                                </div>                                                       
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="hidden" name="risk[<?php echo $i; ?>][color]" id="color_<?php echo $i; ?>" value="<?php echo $value->FK_RISK_LEVEL_COL_CODE; ?>">
                                                                    <div style="width: 91%;height: 20px;" id="risk_clr_<?php echo $i; ?>"></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <?php
                                                                    global $RecoCntrlDatas;
                                                                    $getcntrl_optId = isset($value->RECOMMENED_CONTROL) && !empty($value->RECOMMENED_CONTROL) ? $value->RECOMMENED_CONTROL : '';
                                                                    $cntrldata = array(
                                                                        'id' => 'cntrl_opt_' . $i,
                                                                        'class' => 'form-control select2 recmCntrl',
                                                                        'checkselect' => 'select2',
                                                                        'onchange' => 'RecommendCntrl(' . $i . ')'
                                                                    );
                                                                    echo form_dropdown('risk[' . $i . '][cntrl_opt]', $RecoCntrlDatas, $getcntrl_optId, $cntrldata);
                                                                    ?>
                                                                    <span class="error"><?php echo form_error('risk[' . $i . '][cntrl_opt]') ?></span>
                                                                </div>
                                                              
                                                                <div class="form-group">
                                                                <?php
                                                                $setDispclass = ($getcntrl_optId == '1') ? 'd-none' : '';
                                                                $getcntrltext_optId = isset($value->RECOMMENED_CONTROL_TEXT) && !empty($value->RECOMMENED_CONTROL_TEXT) ? $value->RECOMMENED_CONTROL_TEXT : '';
                                                                $cntrltextdata = array(
                                                                    'id' => 'cntrl_opt_text_'. $i,
                                                                    'class' => 'form-control  cntrlOpttext '.$setDispclass,
                                                                    'name' => 'risk['.$i.'][cntrl_opt_text]',
                                                                    'value' => $getcntrltext_optId,
                                                              );
                                                                echo form_input($cntrltextdata);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk['.$i.'][cntrl_opt_text]') ?></span>
                                                            </div>
                                                             
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <?php
                                                                    $persn_name = isset($value->PERSON_INCHARGE) && !empty($value->PERSON_INCHARGE) ? $value->PERSON_INCHARGE : '';
                                                                    $persondata = array(
                                                                        'id' => 'person_id_' . $i,
                                                                        'class' => 'form-control',
                                                                        'name' => 'risk[' . $i . '][person_name]',
                                                                        'value' => $persn_name
                                                                    );
                                                                    echo form_input($persondata);
                                                                    ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <?php
                                                                    $dueDate = isset($value->DUE_DATE) && !empty($value->DUE_DATE) && ($value->DUE_DATE != '0000-00-00') ? convertDate($value->DUE_DATE) : '';
                                                                    $duedata = array(
                                                                        'id' => 'due_date_' . $i,
                                                                        'class' => 'form-control datepicker',
                                                                        'name' => 'risk[' . $i . '][duedate]',
                                                                        'value' => $dueDate
                                                                    );
                                                                    echo form_input($duedata);
                                                                    ?>
                                                                </div> 
                                                            </td>
                                                            <td>
                                                                <div class="form-group status_<?php echo $i; ?>"/>
                                                                <?php
                                                                $getstId = isset($value->RISK_PRO_END_STATUS) && !empty($value->RISK_PRO_END_STATUS) ? $value->RISK_PRO_END_STATUS : '';
                                                                $statusdata = array(
                                                                    'id' => 'status_' . $i,
                                                                    'class' => 'form-control select2 ',
                                                                    'checkselect' => 'select2'
                                                                );
                                                                echo form_dropdown('risk[' . $i . '][status]', $statusDatas, $getstId, $statusdata);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk[' . $i . '][status]') ?></span>
                                                                </div>
                                                                <input type="text" class="form-control d-none" name="" id="status_d_<?php echo $i; ?>" value="-" readonly="true"/>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <div class="form-group">
                                                                <?php
                                                                $getProcId = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                                $procdata = array(
                                                                    'id' => 'pro_Id_1',
                                                                    'class' => 'form-control proval',
                                                                    'required' => true,
                                                                    'name' => 'risk[1][pro_Id]'
                                                                );
                                                                echo form_input($procdata, $getProcVal);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk[1][pro_Id]') ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <?php
                                                                $getrnr_Id = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                                $rnrdata = array(
                                                                    'id' => 'rnr_Id_1',
                                                                    'class' => 'form-control select2',
                                                                    'required' => true,
                                                                    'checkselect' => 'select2',
                                                                );
                                                                echo form_dropdown('risk[1][rnr_Id]', $getHazaTypedatas, $getrnr_Id, $rnrdata);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk[1][rnr_Id]') ?></span>
                                                            </div>
                                                        </td>
                                                        <td class="haz_upp_1"> 
                                                            <div class="minus_hazard_1 float-right d-none" onclick="minus_hazard(1)"><i class="fa fa-minus-circle"></i></div>
                                                            <div class="add_more_hazard float-right" onclick="add_more_hazard(1)"><i class="fa fa-plus-circle"></i></div>
                                                            <div class="form-group">
                                                                <?php
                                                                $gethazrId = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                                $hadata = array(
                                                                    'id' => 'haz_Id_1',
                                                                    'class' => 'form-control haz_name_1',
                                                                    'required' => true,
                                                                    'name' => 'risk[1][haz_name][]'
                                                                );
                                                                echo form_input($hadata, $gethazrId);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk[1][haz_name][]') ?></span>
                                                            </div>
                                                        </td>
                                                        <td  class="cause_1">
                                                            <div class="minus_cause_1 float-right d-none" onclick="minus_cause(1)"><i class="fa fa-minus-circle"></i></div>
                                                            <div class="float-right" onclick="add_cause(1)"><i class="fa fa-plus-circle"></i></div>
                                                            <div class="form-group"> 
                                                                <?php
                                                                $exit_Id = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                                $exitdata = array(
                                                                    'id' => 'cause_Id_1',
                                                                    'class' => 'form-control cause_name_1',
                                                                    'required' => true,
                                                                    'name' => 'risk[1][cause_name][]'
                                                                );
                                                                echo form_input($exitdata, $gethazrId);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk[1][cause_name][]') ?></span>
                                                            </div>
                                                        </td>
                                                        <td class="risk_1">
                                                            <div class="minus_risk_1 float-right d-none" onclick="minus_risk(1)"><i class="fa fa-minus-circle"></i></div>
                                                            <div class="float-right" onclick="add_risk(1)"><i class="fa fa-plus-circle"></i></div>
                                                            <div class="form-group">
                                                                <?php
                                                                $riskId = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                                $risksel = array(
                                                                    'id' => 'riskId_1',
                                                                    'class' => 'form-control risk_name_1',
                                                                    'required' => true,
                                                                    'name' => 'risk[1][risk_name][]'
                                                                );
                                                                echo form_input($risksel, $riskId);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk[1][risk_name][]') ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <?php
                                                                $getlegId = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                                $legdata = array(
                                                                    'id' => 'legal_Id_1',
                                                                    'class' => 'form-control select2 ',
                                                                    'required' => true,
                                                                    'checkselect' => 'select2',
                                                                    'multiple' => TRUE
                                                                );
                                                                echo form_dropdown('risk[1][legal][]', $legalDatas, $getlegId, $legdata);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk[1][legal][]') ?></span>
                                                            </div>
                                                        </td>
    <!--                                                        <td>
                                                            <div class="form-group">
                                                                <input type="range" id="seve_1" name="risk[1][seve]" min="0" max="5" onchange="getriskmatrix('1');">
                                                            </div>
                                                        </td>-->
                                                        <td>
                                                            <div class="form-group">
                                                                <?php
                                                                $res = $value->SEVERITY;
                                                                $statusDetails = [
                                                                    'id' => 'seve_1',
                                                                    'class' => 'form-control select2',
                                                                    'checkSelect' => 'select2',
                                                                    'onchange' => "getriskmatrix(1);"
                                                                ];

                                                                echo form_dropdown('risk[1][seve]', $severity, $res, $statusDetails);
                                                                ?>
                                                            </div>
                                                        </td>
    <!--                                                        <td>
                                                            <div class="form-group">
                                                                <input type="range" id="likel_1" name="risk[1][likel]" min="0" max="5" onchange="getriskmatrix('1');">
                                                            </div>
                                                        </td>-->
                                                        <td>
                                                            <div class="form-group">
                                                                <?php
                                                                $resli = $value->LIKELIHOOD;
                                                                $statuslikDetails = [
                                                                    'id' => 'likel_1',
                                                                    'class' => 'form-control select2',
                                                                    'checkSelect' => 'select2',
                                                                    'onchange' => "getriskmatrix(1);"
                                                                ];

                                                                echo form_dropdown('risk[1][likel]', $likelhood, $resli, $statuslikDetails);
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="hidden" name="risk[1][risk_val]" id="risk_val_1" value="">
                                                                <div id="risk_val_show_1"></div>
                                                            </div>                                                       
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="hidden" name="risk[1][color]" id="color_1" value="">
                                                                <div style="width: 91%;height: 20px;" id="risk_clr_1"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <?php
                                                                global $RecoCntrlDatas;
                                                                $getcntrl_optId = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                                $cntrldata = array(
                                                                    'id' => 'cntrl_opt_1',
                                                                    'class' => 'form-control select2 recmCntrl',
                                                                    'checkselect' => 'select2',
                                                                    'onchange' => 'RecommendCntrl(1)',
                                                                    'required' => TRUE
                                                                );
                                                                echo form_dropdown('risk[1][cntrl_opt]', $RecoCntrlDatas, $getstId, $cntrldata);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk[1][cntrl_opt]') ?></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <?php
                                                                $cntrltextdata = array(
                                                                    'id' => 'cntrl_opt_text_1',
                                                                    'class' => 'form-control  cntrlOpttext d-none',
                                                                    'name' => 'risk[1][cntrl_opt_text]'
                                                              );
                                                                echo form_input($cntrltextdata);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk[1][cntrl_opt_text]') ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <?php
                                                                $persnId = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                                $persondata = array(
                                                                    'id' => 'person_id_1',
                                                                    'class' => 'form-control',
                                                                    'name' => 'risk[1][person_name]',
//                                                                'value' => $emp_name
                                                                );
                                                                echo form_input($persondata);
                                                                ?>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <?php
                                                                $dueDate = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                                $persondata = array(
                                                                    'id' => 'due_date_1',
                                                                    'class' => 'form-control datepicker',
                                                                    'name' => 'risk[1][duedate]',
                                                                    'value' => $dueDate
                                                                );
                                                                echo form_input($persondata);
                                                                ?>
                                                            </div> 
                                                        </td>
                                                        <td>
                                                            <div class="form-group status_1">
                                                                <?php
                                                                $getstId = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                                $statusdata = array(
                                                                    'id' => 'status_1',
                                                                    'class' => 'form-control select2 ',
                                                                    'checkselect' => 'select2'
                                                                );
                                                                echo form_dropdown('risk[1][status]', $statusDatas, $getstId, $statusdata);
                                                                ?>
                                                                <span class="error"><?php echo form_error('risk[1][status]') ?></span>
                                                            </div>
                                                            <input type="text" class="form-control d-none" name="" id="status_d_1" value="-" readonly="true"/>
                                                        </td>

                                                    </tr>
                                                <?php }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="form-group m-t-10" style="text-align: center;">
                                        <div class="col-sm-offset-2 col-sm-10"> 
                                            <?php
                                            $data = array('id' => 'submit', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SUBMIT', 'class' => 'btn btn-primary');
                                            echo form_button($data);
                                            ?>
                                        </div>
                                    </div>

                                    <!-- input states -->
                                    <?php echo form_close(); ?>
                                </div>
                            </div>

                            <!-- /.card -->

                        </div>
                        <!--/.col (left) -->

                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
<?php
if (is_array($hir_flow_details) && !empty($hir_flow_details)) {
    $i = 1;
    foreach ($hir_flow_details as $key => $value) {
        ?>
            getriskmatrix(<?php echo $i; ?>);
            RecommendCntrl(<?php echo $i; ?>);
        <?php
        $i++;
    }
}
?>
    $('body').mouseover(function () {
    var rowCount = $('.risk_table tbody').find('tr').length;
    if (rowCount > 2) {
    $('.removetr').removeClass('d-none');
    } else {
    $('.removetr').addClass('d-none');
    }
    });
    $('.add_more').on('click', function () {
    var rowCount = $('.risk_table tbody').find('tr').length;
    if (rowCount > 2) {
    $('.removetr').removeClass('d-none');
    } else {
    $('.removetr').addClass('d-none');
    }
    if (rowCount <= 7) {
    var rnrval = [];
    var legal = [];
    var status = [];
    var sev = [];
    var li = [];
    var recntrl = [];
<?php foreach ($getHazaTypedatas as $k => $val) {
    ?>
        rnrval.push('<option value="<?php echo $k; ?>"><?php echo $val; ?></option>');
<?php } ?>;
<?php foreach ($legalDatas as $l => $lval) {
    ?>
        legal.push('<option value="<?php echo $l; ?>"><?php echo $lval; ?></option>');
<?php } ?>;
<?php foreach ($statusDatas as $s => $sval) {
    ?>
        status.push('<option value="<?php echo $s; ?>"><?php echo $sval; ?></option>');
<?php } ?>;
<?php foreach ($RecoCntrlDatas as $r => $rval) {
    ?>
        recntrl.push('<option value="<?php echo $r; ?>"><?php echo $rval; ?></option>');
<?php } ?>;
<?php foreach ($severity as $s => $seval) {
    ?>
        sev.push('<option value="<?php echo $s; ?>"><?php echo $seval; ?></option>');
<?php } ?>;
<?php foreach ($likelhood as $li => $lival) {
    ?>
        li.push('<option value="<?php echo $li; ?>"><?php echo $lival; ?></option>');
<?php } ?>;
    var appendhtml = '<tr><td>' + rowCount + '</td><td><div class="form-group"><input type="text" name="risk[' + rowCount + '][pro_Id]" value="" id="pro_Id_' + rowCount + '" class="form-control  proval" required="1"><span class="error"></span></div></td><td><select name="risk[' + rowCount + '][rnr_Id]" id="rnr_Id_' + rowCount + '" class="form-control select2" required="1" checkselect="select2" ">\n\
                                  ' + rnrval + '</select></td><td class="haz_upp_' + rowCount + '"><div class="minus_hazard_' + rowCount + ' float-right d-none" onclick="minus_hazard(' + rowCount + ')"><i class="fa fa-minus-circle"></i></div><div class="add_more_hazard float-right" onclick="add_more_hazard(' + rowCount + ')"><i class="fa fa-plus-circle"></i></div><div class="form-group"><input type="text" name="risk[' + rowCount + '][haz_name][]" value="" id="haz_Id_' + rowCount + '" class="form-control haz_name_' + rowCount + '" required="1">\n\
                                  <span class="error"></span></div></td><td class="cause_' + rowCount + '"><div class="minus_cause_' + rowCount + ' float-right d-none" onclick="minus_cause(' + rowCount + ')"><i class="fa fa-minus-circle"></i></div><div class="float-right" onclick="add_cause(' + rowCount + ')"><i class="fa fa-plus-circle"></i></div>\n\
                                  <div class="form-group"><input type="text" name="risk[' + rowCount + '][cause_name][]" value="" id="cause_Id_' + rowCount + '" class="form-control cause_name_' + rowCount + '" required="1"><span class="error"></span></div></td>\n\
                                  <td class="risk_' + rowCount + '"><div class="minus_risk_' + rowCount + ' float-right d-none" onclick="minus_risk(' + rowCount + ')"><i class="fa fa-minus-circle"></i></div><div class="float-right" onclick="add_risk(' + rowCount + ')"><i class="fa fa-plus-circle"></i></div><div class="form-group"><input type="text" name="risk[' + rowCount + '][risk_name][]" value="" id="riskId_' + rowCount + '" class="form-control risk_name_' + rowCount + '" required="1"><span class="error"></span></div></td>\n\
                                  <td>\n\
<select name="risk[' + rowCount + '][legal][]" id="legal_Id_' + rowCount + '" class="form-control select2" multiple = "TRUE" required="1" checkselect="select2">' + legal + '\n\
                                  </select></td>\n\
<td><select name="risk[' + rowCount + '][seve]" id="seve_' + rowCount + '" class="form-control select2" onchange = "getriskmatrix(' + rowCount + ')"  checkselect="select2">' + sev + '\n\
                                  </select></td>\n\
<td><select name="risk[' + rowCount + '][likel]" id="likel_' + rowCount + '" class="form-control select2" onchange = "getriskmatrix(' + rowCount + ')"  checkselect="select2">' + li + '\n\
                                  </select></td>\n\
                                  <td><input type="hidden" name="risk[' + rowCount + '][risk_val]" id="risk_val_' + rowCount + '" value=""><div id="risk_val_show_' + rowCount + '"></div></div></td>\n\
                                  <td><div class="form-group"><div style="width: 91 % ; height: 20px; " id="risk_clr_' + rowCount + '"><input type="hidden" name="risk[' + rowCount + '][color]" id="color_' + rowCount + '" value=""></div></div></td>\n\
                                  <td>\n\
                                    <div class="form-group"><select name="risk[' + rowCount + '][cntrl_opt]" required id="cntrl_opt_' + rowCount + '" onchange = "RecommendCntrl(' + rowCount + ')" class="form-control select2 recmCntrl" checkselect="select2">' + recntrl + '</select></div>\n\
                                    <div class="form-group"><input type="text" name="risk[' + rowCount + '][cntrl_opt_text]" value="" id="cntrl_opt_text_' + rowCount + '" class="form-control cntrlOpttext d-none"></div>\n\
                                  </td>\n\
                                  <td><div class="form-group"><input type="text" name="risk[' + rowCount + '][person_name]" value="" id="person_id_' + rowCount + '" class="form-control"></div></td>\n\
                                  <td><div class="form-group"><input type="text" name="risk[' + rowCount + '][duedate]" value="" id="due_date_' + rowCount + '" class="form-control datepicker"></div></td>\n\
                                  <td><div class="form-group status_' + rowCount + '"><select name="risk[' + rowCount + '][status]" id="status_' + rowCount + '" class="form-control select2" checkselect="select2">' + status + '</select></div><input type="text" class="form-control d-none" name="" id="status_d_' + rowCount + '" value=" - " readonly="true"/></td></tr>';

            $('.risk_table').append(appendhtml);
    $(".datepicker").datepicker({
    autoclose: true,
            format: 'dd-mm-yyyy',
            orientation: "bottom"
    });
    $('.select2').select2();
    var user = $('input[name^="risk"]');
    user.filter('input[name$="[pro_Id]"]').each(function () {
    $(this).rules("add", {
    required: true,
            alphaspacewithspecialchar: true,
            messages: {
            required: "Process/Activity/Area is Mandatory"
            }
    });
    });
    user.filter('input[name$="[haz_name][]"]').each(function () {
    $(this).rules("add", {
    required: true,
            alphaspacewithspecialchar: true,
            messages: {
            required: 'Hazard Name is Mandatory',
            }
    });
    });
    user.filter('input[name$="[cause_name][]"]').each(function () {
    $(this).rules("add", {
    required: true,
            alphaspacewithspecialchar: true,
            messages: {
            required: 'Cause Effect is Mandatory',
            }
    });
    });
    user.filter('input[name$="[risk_name][]"]').each(function () {
    $(this).rules("add", {
    required: true,
            alphaspacewithspecialchar: true,
            messages: {
            required: 'Existing Risk Control is Mandatory',
            }
    });
    });
    user.filter('input[name$="[person_name]"]').each(function () {
    $(this).rules("add", {
    //alphaspacewithspecialchar: true
    });
    });
    } else {
    alert('You have reached maxmimum level');
    }
    });
    $('.removetr').on('click', function () {
    var rowCount = $('.risk_table tbody').find('tr').length;
    var $last = $(".risk_table tbody").find('tr:last');
    if (rowCount > 2) {
    if ($last.is(':first-child')) {
    alert('last is the only one');
    } else {
    $last.remove();
    }
    }
    });
    $.validator.addMethod('alphanumeric', function (value) {
    return /^[A-Za-z0-9 ]*$/.test(value);
    }, "Please Enter only Alphanumeric characters");
    $.validator.addMethod('alphanospace', function (value) {
    return /^[A-Za-z]*$/.test(value);
    }, "Please Enter only Alphabetic characters.No spaces allowed");
    $.validator.addMethod('alphaspace', function (value) {
    return /^[A-Za-z ]*$/.test(value);
    }, "Please Enter only Alphabetic characters");
    $("#hirarc_submit").validate({
    errorPlacement: function (error, element) {

    if (element.attr('checkSelect') == 'select2') {
    error.insertAfter(element.next('.select2-container'));
    } else {
    error.insertAfter(element);
    element.closest(".imgGroup").last().append(error);
    }
    }
    });
    var user = $('input[name^="risk"]');
    user.filter('input[name$="[pro_Id]"]').each(function () {
    $(this).rules("add", {
    required: true,
            alphaspacewithspecialchar: true,
            messages: {
            required: "Process/Activity/Area is Mandatory"
            }
    });
    });
    user.filter('input[name$="[haz_name][]"]').each(function () {
    $(this).rules("add", {
    required: true,
            alphaspacewithspecialchar: true,
            messages: {
            required: 'Hazard Name is Mandatory',
            }
    });
    });
    user.filter('input[name$="[cause_name][]"]').each(function () {
    $(this).rules("add", {
    required: true,
            alphaspacewithspecialchar: true,
            messages: {
            required: 'Cause Effect is Mandatory',
            }
    });
    });
    user.filter('input[name$="[risk_name][]"]').each(function () {
    $(this).rules("add", {
    required: true,
            alphaspacewithspecialchar: true,
            messages: {
            required: 'Existing Risk Control is Mandatory',
            }
    });
    });
    user.filter('input[name$="[person_name]"]').each(function () {
    $(this).rules("add", {
   // alphaspacewithspecialchar: true
    });
    });
    });
    function add_more_hazard(curval) {
    var uppend = '';
    uppend = '<div class="form-group"><input type="text" name="risk[' + curval + '][haz_name][]" value=""  class="form-control haz_name_' + curval + '" required="1"></div>';
    $('.haz_upp_' + curval).append(uppend);
    $('.minus_hazard_' + curval).removeClass('d-none');
    }

    function minus_hazard(curval) {
    var cnt = $('input[name*="risk[' + curval + '][haz_name][]"]').length;
    if (cnt <= 1) {
    alert('last is the only one');
    $('.minus_hazard_' + curval).addClass('d-none');
    } else {
    $('.haz_name_' + curval).last().remove();
    }
    }

    function add_cause(curval) {
    var uppend = '';
    uppend = '<div class="form-group"><input type="text" name="risk[' + curval + '][cause_name][]" value=""  class="form-control cause_name_' + curval + '" required="1"></div>';
    $('.cause_' + curval).append(uppend);
    $('.minus_cause_' + curval).removeClass('d-none');
    }

    function minus_cause(curval) {
    var cnt = $('input[name*="risk[' + curval + '][cause_name][]"]').length;
    if (cnt <= 1) {
    alert('last is the only one');
    $('.minus_cause_' + curval).addClass('d-none');
    } else {
    $('.cause_name_' + curval).last().remove();
    }
    }

    function add_risk(curval) {
    var uppend = '';
    uppend = '<div class="form-group"><input type="text" name="risk[' + curval + '][risk_name][]" value=""  class="form-control risk_name_' + curval + '" required="1"></div>';
    $('.risk_' + curval).append(uppend);
    $('.minus_risk_' + curval).removeClass('d-none');
    }

    function minus_risk(curval) {
    var cnt = $('input[name*="risk[' + curval + '][risk_name][]"]').length;
    if (cnt <= 1) {
    alert('last is the only one');
    $('.minus_risk_' + curval).addClass('d-none');
    } else {
    $('.risk_name_' + curval).last().remove();
    }
    }

    function RecommendCntrl(recm) {
    var cnt = $('#cntrl_opt_' + recm).find(':selected').val();
    if (cnt == 1) {
    $('#person_id_' + recm).attr('readonly', true).val('-');
    $('#person_id_' + recm).attr('required', false);
//    $('#due_date_' + recm).removeClass('datepicker').attr('readonly', true).val('-');
    $('#due_date_' + recm).removeClass('datepicker').attr('disabled', true).val('-');
    $('#due_date_' + recm).attr('required', false);
    $('#status_' + recm).attr('required', false);
    $('.status_' + recm).addClass('d-none');
    $('#status_d_' + recm).removeClass('d-none');
    } else {
    $('#person_id_' + recm).attr('readonly', false);
    $('#person_id_' + recm).attr('required', true);
//    $('#due_date_' + recm).addClass('datepicker').attr('readonly', false);
    $('#due_date_' + recm).addClass('datepicker').attr('disabled', false);
    if ($('#due_date_' + recm).val() == '-') {
    $('#due_date_' + recm).val('');
    }
    if ($('#person_id_' + recm).val() == '-') {
    $('#person_id_' + recm).val('');
    }
    $('#due_date_' + recm).attr('required', true);
    $('#status_' + recm).attr('required', true);
    $('#status_d_' + recm).addClass('d-none');
    $('.status_' + recm).removeClass('d-none');
    }

$(".datepicker").datepicker({
    autoclose: true,
            format: 'dd-mm-yyyy',
            orientation: "bottom"
    });
    }
    function getriskmatrix(curval) {
    var seve_val = $('#seve_' + curval).val();
    var likel_val = $('#likel_' + curval).val();
//        alert(curval);
    //        alert(seve_val);
    //        alert(likel_val);
    if (seve_val !== '' && seve_val !== '0' && likel_val !== '' && likel_val !== '0') {
    var url = "<?php echo BASE_URL('hirarc/hirarc/getriskmatrixColor'); ?>";
    var data = {seve_val: seve_val, likel_val: likel_val, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
    $.ajax({
    type: 'ajax',
            dataType: 'json',
            method: 'post',
            data: data,
            url: url,
            success: function (res) {
            var exitsta = res.status;
            $('#risk_clr_' + curval).css('background-color', '');
            if (exitsta) {
            $('#risk_val_' + curval).val(res.risk_rate);
            $('#color_' + curval).val(res.clr_code);
            $('#risk_val_show_' + curval).html(res.risk_rate);
            $('#risk_clr_' + curval).css('background-color', res.clr_code);
            } else {
            $('#risk_val_' + curval).val(res.risk_rate);
            $('#risk_clr_' + curval).css('background-color', '');
            }

            }
    });
    } else if (seve_val !== '') {
   // alert('Choose Likelihood level');
    $('#risk_val_' + curval).val('');
    $('#color_' + curval).val('');
    $('#risk_val_show_' + curval).html('');
    $('#risk_clr_' + curval).css('background-color', '');
    } else if (likel_val !== '') {
    $('#risk_val_' + curval).val('');
    $('#color_' + curval).val('');
    $('#risk_val_show_' + curval).html('');
    $('#risk_clr_' + curval).css('background-color', '');
    }
    }

$(document).ready(function () {

    $(document).on("change",".recmCntrl",function(){
        var gteVal = $(this).val();
        var idVal = $(this).attr('id');
        var gterow = idVal.split('_')[2];
      
        if(gteVal == '2'){
            $("#cntrl_opt_text_"+gterow).removeClass('d-none');
        }else{
            $("#cntrl_opt_text_"+gterow).addClass('d-none'); 
        }
    })
});

</script>
