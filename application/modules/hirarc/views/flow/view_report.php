<style>
    .viewpage {
        /*        font-size: 14px;*/
    }
    .newhr {
        margin-top: 15px;
        margin-bottom: 15px;
        border-color: white;
    }
    .card-header-inner{
        color: #fff;
        background-color: #007bff;
        font-weight: bold;
        text-transform: uppercase;
    }
    .card-link{
        color: #fff;
    }
    .card-header a:hover{
        color: #fff;
    }
    .red{
        color:red;
    }
    .removeItem:not(:disabled):not(.disabled).active, .removeItem:not(:disabled):not(.disabled):active, .removeItem,.removeItem:hover{
        color: #fff;
        background-color: red;
        border-color:red; 
    }
    .uppertext{
        text-transform: uppercase;
    }
    .card-header-cc {
        color: #fff;
        background-color: green;
    }
    .docLabel{
        margin-left: 15px;
    }

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {
        .datepicker {
            top:290px !important;
        }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
        .datepicker {
            top:300px !important;
        }
    }
    .tdlabel{
        width:23%;
    }
    .title-head{
        text-transform: uppercase;
    }
    .title-colon{
        width:1%;
    }
    .imagepopcombine:hover .popupgal {
        opacity: 1;
    }
    .popupgal{
        position: absolute;
        font-size: 3rem !important;
        color: #fff;
        opacity: 0;
        transition: .2s opacity ease-in-out;
        z-index: 5;
        background: #b7b7b77d;
        min-width: 82%;
        min-height: 90%;
        max-width: 90%;
        top: 0;
        text-align: center;
        border: 2px solid #007cb7;
    }
    .popupgal i{
        margin-top: 25%;
    }

</style>
<div class="wrapper">
    <?php
    $HIRARC_ID = postData($hir_details, 'HIRARC_ID');
    $COM_NAME = postData($hir_details, 'COM_NAME');
    $COM_NAME_OTH = postData($hir_details, 'OTH_COMP_NAME');
    $TERMINAL_NAME = postData($hir_details, 'TERMINAL_NAME');
    $HIRARC_FLOW_STATUS = postData($hir_details, 'HIRARC_FLOW_STATUS');
    $EMP_NAME = postData($hir_details, 'EMP_NAME');
    $rej1_reason = postData($hir_details, 'HSSE_REJ_RES');
    $DEPT_NAME = postData($hir_details, 'DEPT_NAME');
    $PRO_NAME = postData($hir_details, 'PRO_ACT_LOC');
    $HOD_ID = postData($hir_details, 'HOD_ID');
    $MAIN_AUTO_ID = postData($hir_details, 'MAIN_AUTO_ID');
    $Notify_id = postData($hir_details, 'CREATED_BY');
    global $status_drop;
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div id="accordion" class="permitAccordion">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">


                            <!-- general form elements -->
                            <div class="card card-headprimary">

                                <div class="card-header headingStyl ">

                                    <h4 class='title-head'>HIRARC Report </h4>
                                    <a href="<?php echo BASE_URL . 'hirarc/hirarc'; ?>"><button type="button" class="btn btn-primary backBtns"> Back</button></a>

                                </div> 
                                <div class="card-body">
                                    <div class="" style="margin-top:10px;">
                                        <?php echo $this->session->flashdata('locatn'); ?>
                                    </div>
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                            Report<span class="float-right"></span>

                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
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
                                            </div>
                                            <?php if ($HIRARC_FLOW_STATUS >= 2 || $HIRARC_FLOW_STATUS == '-4' || $HIRARC_FLOW_STATUS == '-3') { ?>
                                                <div class="row">
                                                    <div class="">
                                                        <h4><b>Risk Analysis Details</b></h4>
                                                    </div>
                                                    <?php if ($HIRARC_FLOW_STATUS == '-4') { ?>
                                                        <div class="col-md-12">
                                                            <label class="">Rejected Reason</label>
                                                            <p><?php echo $rej1_reason; ?></p>
                                                        </div>
                                                    <?php } ?> 
                                                    <div class="col-md-12 table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="5" class="text-center cell">Hazard Identification</td>
                                                                    <td colspan="6" class="text-center cell">Risk Analysis</td>
                                                                    <td colspan="4" class="text-center cell">Risk Control/Opportunities</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center cell">No.</td>
                                                                    <td class="cell" style="padding: 30px;text-align: center;">Process/Activity/ Area</td>
                                                                    <td class="cell" style="padding: 25px; text-align: center;">R/NR/E</td>
                                                                    <td class="cell" style="padding: 30px;text-align: center;">Hazard</td> 
                                                                    <td class="cell" style="padding: 25px;text-align: center;">Which Can Cause Effect</td>
                                                                    <td class="cell" style="padding: 25px;text-align: center;">Existing Risk Control</td>
                                                                    <td class="cell" style="padding: 25px;text-align: center;">Applicable Legal & Other Req.</td>
                                                                    <td class="cell" style="text-align: center;">(S)</td>
                                                                    <td class="cell" style="text-align: center;">(L)</td>
                                                                    <td class="cell">(RR)</td> 
                                                                    <td class="cell">Risk Level</td>
                                                                    <td class="cell">Recommended Control/Opportunities</td>
                                                                    <td class="cell">Person In-Charge</td>
                                                                    <td class="cell">Due Date</td>
                                                                    <td class="cell">Status (Open/ Close)</td>
                                                                </tr> 
                                                                <?php
                                                                if (is_array($hir_flow_details) && $hir_flow_details != '') {
                                                                    $i = 1;
                                                                    foreach ($hir_flow_details as $key => $value) {
                                                                        ?> 
                                                                        <tr>
                                                                            <td class="cell"><?php echo $i; ?></td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php echo postData($value, 'FK_PRO_ACT_NAME'); ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php echo postData($value, 'HAZ_TYPE_NAME'); ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;"> 
                                                                                <?php
                                                                                $row_id = $value->RP_AUTO_ID;
                                                                                $hirarc_id = $value->FK_HIRARC_MAIN_ID;
                                                                                $haz_data = getAllHazardDatas($row_id, $hirarc_id);
//                                                                                echo '<pre>';
//                                                                                print_r($haz_data);exit;
                                                                                if (is_array($haz_data) && !empty($haz_data)) {
                                                                                    $count = count($haz_data);
                                                                                    foreach ($haz_data as $key => $kval) {
                                                                                        if ($count == 1) {
                                                                                            echo postData($kval, 'HAZ_NAME');
                                                                                        } else {
                                                                                            echo postData($kval, 'HAZ_NAME') . ', ';
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php
                                                                                $cause_data = getAllCauseDatas($row_id, $hirarc_id);
                                                                                if (is_array($cause_data) && !empty($cause_data)) {
                                                                                    $count = count($cause_data);
                                                                                    foreach ($cause_data as $key => $cval) {
                                                                                        if ($count == 1) {
                                                                                            echo postData($cval, 'CAUSE_NAME');
                                                                                        } else {
                                                                                            echo postData($cval, 'CAUSE_NAME') . ', ';
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php
                                                                                $exit_data = getAllExitingDatas($row_id, $hirarc_id);
                                                                                if (is_array($exit_data) && !empty($exit_data)) {
                                                                                    $count = count($exit_data);
                                                                                    foreach ($exit_data as $key => $eval) {
                                                                                        if ($count == 1) {
                                                                                            echo postData($eval, 'CONTROL_NAME');
                                                                                        } else {
                                                                                            echo postData($eval, 'CONTROL_NAME') . ', ';
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php
                                                                                $legel = explode(',', postData($value, 'FK_LEGAL_ID'));
                                                                                $count = count($legel);
                                                                                foreach ($legel as $key => $val) {
                                                                                    if ($count == 1) {
                                                                                        print_r($legalDatas[$val]);
                                                                                    } else {
                                                                                        print_r($legalDatas[$val] . ',');
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php echo postData($value, 'SEVERITY'); ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php echo postData($value, 'LIKELIHOOD'); ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php echo postData($value, 'FK_RISK_RATE'); ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <div style="width: 91%;height: 20px;background-color: <?php echo postData($value, 'FK_RISK_LEVEL_COL_CODE'); ?>" id="risk_clr_1"></div>

                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php
                                                                                global $RecoCntrlDatas;
                                                                                print_r($RecoCntrlDatas[postData($value, 'RECOMMENED_CONTROL')]);
if (postData($value, 'RECOMMENED_CONTROL') != 1) {
                                                                                   $a = " - ";
                                                                                   $b = $emp_name = postData($value, 'RECOMMENED_CONTROL_TEXT');
                                                                                   echo $a.$b ;
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <?php
                                                                            if (postData($value, 'RECOMMENED_CONTROL') == 1) {
                                                                                $emp_name = '-';
                                                                                $due_date = '-';
                                                                                $status = '-';
                                                                            } else {
                                                                                $emp_name = postData($value, 'PERSON_INCHARGE');
                                                                                $due_date = (postData($value, 'DUE_DATE') != '0000-00-00') ? convertDate(postData($value, 'DUE_DATE')) : '';
                                                                                $status = $statusDatas[postData($value, 'RISK_PRO_END_STATUS')];
                                                                            }
                                                                            ?>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php echo $emp_name; ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php echo $due_date; ?>
                                                                            </td>
                                                                            <td class="cell" style="padding: 5px;">
                                                                                <?php print_r($status); ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php if ($currnt_user_login_Id != '' && $currnt_user_login_Id == $HOD_ID && $HIRARC_FLOW_STATUS == '2') {
                                                        ?> 
                                                        <div class="col-md-12 text-center">
                                                            <?php echo form_open('hirarc/update_status/' . encryptval($MAIN_AUTO_ID), 'class="form-horizontal hsubmit" id="hirarc_submit" novalidate'); ?>
                                                            <input type="hidden" name="notify_id" value="<?php echo $Notify_id; ?>" />
                                                            <button type="submit" class="btn btn-primary hod_app" name="hod_app" value="1">Approve</button>
                                                            <button type="submit" class="btn btn-warning hod_rej" name="hod_app" value="2">Reject</button>
                                                            <?php echo form_close(); ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php
                                                    $curnt_Id = getCurrentUserGroupId();
                                                    global $hirarcPermission;
                                                    if (in_array($curnt_Id, $hirarcPermission['approve']) && $HIRARC_FLOW_STATUS == '3') {
                                                        ?> 
                                                        <div class="col-md-12 text-center m-t-10">
                                                            <?php echo form_open('hirarc/update_status/' . encryptval($MAIN_AUTO_ID), 'class="form-horizontal hsubmit" id="hirarc_submit" novalidate'); ?>

                                                            <div class="col-md-8 hsse_rej d-none m-b-10">
                                                                <label class="label">Reject Reason</label>
                                                                <textarea class="form-control" name="hsse_rej" id="hsse_rej" rows="4" cols="4"></textarea>
                                                            </div>
                                                            <input type="hidden" name="notify_id" value="<?php echo $Notify_id; ?>" />
                                                            <button type="submit" class="btn btn-primary hod_app" name="hod_app" value="3">Approve</button>
                                                            <button type="submit" class="btn btn-warning hod_rej d-none" name="hod_app" value="4">Reject</button>
                                                            <button class="btn btn-warning reject">Reject</button>

                                                        </div>
                                                        <?php echo form_close(); ?>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <!-- /.card -->

                        </div>
                        <!--/.col (left) -->

                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<script>
    $(document).ready(function () {
        $('.reject').on('click', function (e) {
            e.preventDefault();
            $('.hod_app').addClass('d-none');
            $('.reject').addClass('d-none');
            $('.hod_rej').removeClass('d-none');
            $('.hsse_rej').removeClass('d-none');
        });
        $.validator.addMethod('alphaspace', function (value) {
            return /^[A-Za-z ]*$/.test(value);
        }, "Please Enter only Alphabetic characters");
        $("#hirarc_submit").validate({
            //            ignore: [],
            //            success: function (error) {
            //                error.removeClass("error");
            //            },

            rules: {
                "hsse_rej": {
                    required: true,
                    alphaspace: true
                }
            },
            messages: {
                "hsse_rej": {
                    alphaspace: "special characters are not allowed."
                }
            },
            errorPlacement: function (error, element) {

                if (element.attr('checkSelect') == 'select2') {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                    element.closest(".imgGroup").last().append(error);
                }
            }

        });
    });
</script>
