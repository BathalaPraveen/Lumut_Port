<style>
    #map {

        height:360px;
        width: 100%;
    }
    .keyContdetails{
        border: 2px solid #1e6dab;
    }

</style>
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
                                    <h4>ADD LOCATION</h4>
                                    <a href="<?php echo BASE_URL('master/LocationMaster/') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>


                            <div class="card-body">
                                <?php
                                $getLocid = isset($getLocationdatas->SL_AUTO_ID) && !empty($getLocationdatas->SL_AUTO_ID) ? $getLocationdatas->SL_AUTO_ID : '';
                                ?>
                                <?php echo form_open('master/LocationMaster/saveLocation/' . encryptval($getLocid), 'class="form-horizontal" id="company-profile" novalidate'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class="">  Location Details </h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">
                                    <div class="row m-t-10 m-l-10">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Specific Location ID  <span class="error">*</span></label>
                                                <?php
                                                $AutoId = isset($getLocationdatas->SPECIFIC_LOC_ID) && !empty($getLocationdatas->SPECIFIC_LOC_ID) ? $getLocationdatas->SPECIFIC_LOC_ID : $getAutoId;
                                                $cMaildatas = [
                                                    'name' => 'loc[SPECIFIC_LOC_ID]',
                                                    'class' => 'form-control',
                                                    'value' => $AutoId,
                                                    'autocomplete' => 'off',
                                                    'readonly' => TRUE
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <label class="error"><?php echo form_error('loc[SPECIFIC_LOC_ID]') ?></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Terminal Name  <span class="error">*</span></label>
                                                <?php
                                                $getTerId = isset($getLocationdatas->FK_TERMINAL_ID) && !empty($getLocationdatas->FK_TERMINAL_ID) ? $getLocationdatas->FK_TERMINAL_ID : set_value('loc[FK_TERMINAL_ID]');
                                                $termdata = array(
                                                    'id' => 'FK_TERMINAL_ID',
                                                    'class' => 'form-control select2 ',
                                                    'required' => true,
                                                    'checkselect' => 'select2'
                                                );
                                                echo form_dropdown('loc[FK_TERMINAL_ID]', $getTerminaldatas, $getTerId, $termdata);
                                                ?>
                                                <label class="error"><?php echo form_error('loc[FK_TERMINAL_ID]') ?></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Specific Location Name  <span class="error">*</span></label>
                                                <?php
                                                $getCompmob = isset($getLocationdatas->SPECIFIC_LOC_NAME) && !empty($getLocationdatas->SPECIFIC_LOC_NAME) ? $getLocationdatas->SPECIFIC_LOC_NAME : set_value('loc[SPECIFIC_LOC_NAME]');
                                                $cMobdata = array(
                                                    'name' => 'loc[SPECIFIC_LOC_NAME]',
                                                    'id' => 'SPECIFIC_LOC_NAME',
                                                    'placeholder' => 'Enter Specific Location Name ',
                                                    'class' => 'form-control',
                                                    'value' => $getCompmob,
                                                    'required' => true,
                                                    'minlength' => 3,
                                                    'maxlength' => 25,
                                                    'autocomplete' => 'off'
                                                );

                                                echo form_input($cMobdata);
                                                ?>
                                                <label class="error"><?php echo form_error('loc[SPECIFIC_LOC_NAME]') ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-l-10">
                                        <div class="col-sm-6">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Description</label>
                                                <?php
                                                $getCompaddr1 = isset($getLocationdatas->SPECIFIC_LOC_DESC) && !empty($getLocationdatas->SPECIFIC_LOC_DESC) ? $getLocationdatas->SPECIFIC_LOC_DESC : set_value('loc[SPECIFIC_LOC_DESC]');
                                                $cAddr1data = array(
                                                    'name' => 'loc[SPECIFIC_LOC_DESC]',
                                                    'id' => 'SPECIFIC_LOC_DESC',
                                                    'placeholder' => 'Enter Description',
                                                    'class' => 'form-control',
                                                    'value' => $getCompaddr1,
                                                    'rows' => 4,
                                                    'cols' => 4,
                                                    'autocomplete' => 'off'
                                                );
                                                echo form_textarea($cAddr1data);
                                                ?>
                                                <span class="error"><?php echo form_error('loc[SPECIFIC_LOC_DESC]') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="AddmoreKys"></div>

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
        $.validator.addMethod("validate_email", function (value, element) {

            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                return true;
            } else {
                return false;
            }
        }, "Please enter a valid Email.");

        $.validator.addMethod('alphanumeric', function (value) {
            return /^[A-Za-z0-9 ]*$/.test(value);
        }, "Please Enter only Alphanumeric characters");

        $.validator.addMethod('accept_address', function (value) {
            return /^[A-Za-z0-9/,. ]*$/.test(value);
        }, "Please Enter a valid address");
        $.validator.addMethod('alphanospace', function (value) {
            return /^[A-Za-z]*$/.test(value);
        }, "Please Enter only Alphabetic characters.No spaces allowed");

        $.validator.addMethod('alphaspace', function (value) {
            return /^[A-Za-z ]*$/.test(value);
        }, "Please Enter only Alphabetic characters");



        $("#company-profile").validate({
//            ignore: [],
//            success: function (error) {
//                error.removeClass("error");
//            },

            rules: {
                "loc[FK_TERMINAL_ID]": {
                    required: true
                },
                "loc[SPECIFIC_LOC_NAME]": {
                    required: true,
                   // alphaspace: true,
                    minlength: 3,
                    maxlength: 25
                },
                "loc[SPECIFIC_LOC_DESC]": {
                   // alphaspace: true,
                    minlength: 2,
                    maxlength: 255
                },
            },
            messages: {
                "loc[FK_TERMINAL_ID]": {
                    required: "Terminal Name is required"
                },
                "loc[SPECIFIC_LOC_NAME]": {
                    required: "Specific Location Name is required"
                },
                "loc[SPECIFIC_LOC_DESC]": {
                    alphaspace: "Special charaters are not allowed"
                },
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
