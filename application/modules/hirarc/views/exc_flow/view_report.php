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
    $DEPT_NAME = postData($hir_details, 'DEPT_NAME');
    $PRO_NAME = postData($hir_details, 'PRO_NAME');
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
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                            Report Datas<span class="float-right"></span>

                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>HIRARC Id</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($HIRARC_ID != '') ? $HIRARC_ID : 'Nil'; ?></td>
                                                            <td class="tdlabel"><b>Company</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($COM_NAME != '') ? $COM_NAME : 'Nil'; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Company Name</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($COM_NAME_OTH != '') ? $COM_NAME_OTH : 'Nil'; ?></td>
                                                            <td class="tdlabel"><b>Status</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($HIRARC_FLOW_STATUS != '') ? $status_drop[$HIRARC_FLOW_STATUS] : 'Nil'; ?></td>
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
                                                    </table>
                                                </div>
                                                <?php // if($currnt_user_Id != '' && $currnt_user_Id == $HOD_ID) {
                                                ?>
                                                <div class="col-md-12 text-center">
                                                    <?php echo form_open('hirarc/update_status/' . encryptval($MAIN_AUTO_ID), 'class="form-horizontal hsubmit" id="hirarc_submit" novalidate'); ?>
                                                    <input type="hidden" name="notify_id" value="<?php echo $Notify_id; ?>" />
                                                    <button type="submit" class="btn btn-primary hod_app" name="hod_app" value="1">Approve</button>
                                                    <button type="submit" class="btn btn-warning hod_rej" name="hod_app" value="2">Reject</button>
                                                    <?php echo form_close(); ?>
                                                </div>
                                                <?php // } ?>
                                            </div>
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
//    $(document).ready(function () {
//        $('.hsubmit').on('submit', function (e) {
//            e.preventDefault();
//            var val1 = $(".hod_app").val();
//            var val2 = $(".hod_rej").val();
//            alert(val2);
//            alert(val1);
//            if (val == '1') {
//                swal({
//                    title: "Are you sure?",
//                    text: "You Want to approve HIRARC form",
//                    icon: "warning",
//                    showCancelButton: true,
//                    confirmButtonText: "Yes",
//                    cancelButtonText: "No",
//                    closeOnConfirm: true,
//                    closeOnCancel: false
//                }),
//                        function (isConfirm) {
//                            if (isConfirm) {
//                                $('.hsubmit').submit();
//                            }
//                        }
//            } else {
//                swal({
//                    title: "Are you sure?",
//                    text: "You Want to Reject HIRARC form",
//                    icon: "warning",
//                    showCancelButton: true,
//                    confirmButtonText: "Yes",
//                    cancelButtonText: "No",
//                    closeOnConfirm: true,
//                    closeOnCancel: false
//                }),
//                        function (isConfirm) {
//                            if (isConfirm) {
//                                $('.hsubmit').submit();
//                            }
//                        }
//            }
//        });
//    });
</script>