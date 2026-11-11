<?php

$HMP_ID = postData($editData, 'HMP_ID');
$HMP_NAME = postData($editData, 'HMP_NAME');
$HMP_START_DATE = date('d-m-Y', strtotime(postData($editData, 'HMP_START_DATE')));
$HMP_END_DATE = date('d-m-Y', strtotime(postData($editData, 'HMP_END_DATE')));
$HMP_DESC = postData($editData, 'HMP_DESC');
$loc_name = postData($editData, 'loc_name');
$dept_name = postData($editData, 'dept_name');
$unithead = postData($editData, 'unithead');
$executive = postData($editData, 'executive');
$HMP_APP_STATUS = postData($editData, 'HMP_APP_STATUS');
$HMP_APP_START_DATE = date('d-m-Y', strtotime(postData($editData, 'HMP_APP_START_DATE')));
$HMP_APP_END_DATE = date('d-m-Y', strtotime(postData($editData, 'HMP_APP_END_DATE')));
$HMP_APP_STATUS = postData($editData, 'HMP_APP_STATUS');

//print_r($editData);exit;
$hmpPermission = [
    'add' => [6, 7]
];
?>

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

                                    <h4 class='title-head'>View Program </h4>
                                    <a href="<?php echo BASE_URL('hmp/hmp/hmpInfo') ?>"><button type="button" class="btn btn-primary backBtns"> Back</button></a>

                                </div>
                                <div class="card-body">
                                    <?php
                                    $getstatusid = isset($editData->HMP_AUTO_ID) && !empty($editData->HMP_AUTO_ID) ? $editData->HMP_AUTO_ID : '';
                               // print_r($getstatusid);exit;
                                    ?>
                                    <?php echo form_open('hmp/hmp/saveStatus/' . $getstatusid, 'class="form-horizontal" id="company-profile" novalidate'); ?>

                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                            HSSE Program Detail<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>Program ID</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($HMP_ID != '') ? $HMP_ID : '-'; ?></td>
                                                            <td class="tdlabel"><b>Program Name</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($HMP_NAME != '') ? $HMP_NAME : '-'; ?></td>

                                                        </tr>

                                                        <tr>
                                                            <td class="tdlabel"><b>Program Start Date</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($HMP_START_DATE != '') ? $HMP_START_DATE : '-'; ?></td>

                                                            <td class="tdlabel"><b>Program End Date</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($HMP_END_DATE != '') ? $HMP_END_DATE : '-'; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="tdlabel"><b>Program Description</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($HMP_DESC != '') ? $HMP_DESC : '-'; ?></td>
                                                        </tr>

                                                    </table>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                            Location and Department<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>Terminal</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($loc_name != '') ? $loc_name : '-'; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Department</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($dept_name != '') ? $dept_name : '-'; ?></td>

                                                        </tr>

                                                    </table>


                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                            Employee Detail<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>Unit Head</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($unithead != '') ? $unithead : '-'; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Executive</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($executive != '') ? $executive : '-'; ?></td>

                                                        </tr>

                                                    </table>


                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $user_type = getCurrentUserGroupId();
                                 //   print_r($user_type);exit;
                                    if ((in_array($user_type, $hmpPermission['add']) && $HMP_APP_STATUS == 1) || (in_array($user_type, $hmpPermission['add']) && $HMP_APP_STATUS == 4) || is_admin()) {
                                                   ?>
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                            Status<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-4 ">
                                                    <label >Status </label><br>
                                                    <?php
                                                    $statusDetails = [
                                                        'id' => 'HMP_APP_STATUSS',
                                                        'class' => 'form-control select2',
                                                        'checkSelect' => 'select2'
                                                    ];
                                                    $atarStatusType = [
                                                        '1' => 'Pending',
                                                        '2' => 'Completed',
                                                        '3' => 'Overdue',
                                                        '4' => 'Postpone'
                                                    ];
                                                    echo form_dropdown('pro[HMP_APP_STATUSS]', $atarStatusType, $HMP_APP_STATUS, $statusDetails);
                                                    echo form_hidden('pro[HMP_APP_STATUS]', $HMP_APP_STATUS);
                                                    ?>
                                                    <label class="error"><?php echo form_error('pro[HMP_APP_STATUSS]') ?></label>
                                                </div>

                                                <div class="col-md-4 status_post">

                                                    <label >Start Date </label><br>
                                                    <div>

                                                        <?php
                                                        $data = array(
                                                            'name' => 'pro[HMP_APP_START_DATE]',
                                                            'id' => 'HMP_APP_START_DATESS',
                                                            'placeholder' => '',
                                                            'class' => 'form-control',
                                                            'autocomplete' => 'off',
                                                            'value' => $HMP_APP_START_DATE,
                                                        );

                                                        echo form_input($data);
                                                        ?>  

                                                    </div>

                                                </div>
                                                <div class="col-md-4 status_post">

                                                    <label >End Date </label><br>
                                                    <div>

                                                        <?php
                                                        $data = array(
                                                            'name' => 'pro[HMP_APP_END_DATE]',
                                                            'id' => 'HMP_APP_END_DATESS',
                                                            'placeholder' => '',
                                                            'class' => 'form-control',
                                                            'autocomplete' => 'off',
                                                            'value' => $HMP_APP_END_DATE,
                                                        );

                                                        echo form_input($data);
                                                        ?>  

                                                    </div>

                                                </div>



                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group m-t-10" style="text-align: center;">
                                        <div class="col-sm-offset-2 col-sm-12"> 

                                            <?php
                                            $data = array('id' => 'submit', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SUBMIT', 'class' => 'btn btn-primary');
                                            echo form_button($data);
                                            ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php echo form_close(); ?> 
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
<script type="text/javascript">
function dateData(){
   
       $("#HMP_APP_START_DATESS").datepicker({
            autoclose: true,
            startDate: new Date(),
            format: 'dd-mm-yyyy'
        }).on('changeDate', function (selected) {

            var minDate = new Date(selected.date.valueOf());
            $('#HMP_APP_END_DATESS').datepicker('setStartDate', minDate);

        });
        $("#HMP_APP_END_DATESS").datepicker({
            autoclose: true,
            startDate: new Date(),
            format: 'dd-mm-yyyy'
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());

        });
       
}
    $(document).ready(function () {
        $(".status_post").hide();
        dateData();
        $('#HMP_APP_STATUSS').on('change', function () {
          //  alert(this.value);
            if (this.value == 4){
                $(".status_post").show();
                dateData();
            } else{
                $(".status_post").hide();
            }
        }).trigger("change");

      




        $("#company-profile").validate({
            ignore: [],
            success: function (error) {
                error.removeClass("error");
                error.addClass("d-none");
            },

            rules: {

                "pro[HMP_APP_STATUSS]": {
                    required: true
                },

            },
            messages: {
                "pro[HMP_ID]": {
                    required: "Status is required"
                },

            },
            errorPlacement: function (error, element) {

                if (element.attr('checkSelect') == 'select2') {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                    element.closest(".imgGroup").last().append(error);
                }
            },submitHandler: function (form) {
                swal({
                    title: "Please wait..",
                    imageUrl: loadingImg,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                form.submit();
            }

        });
    });
</script>
