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
                                    <h4>ADD CAUSE EFFECT</h4>
                                    <a href="<?php echo BASE_URL('hirarc/master/causeAffect/') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>


                            <div class="card-body">
                                <?php
                                $gethazid = isset($getCausedatas[0]->FK_HAZ_ID) && !empty($getCausedatas[0]->FK_HAZ_ID) ? $getCausedatas[0]->FK_HAZ_ID : '';
                                ?>
                                <?php echo form_open('hirarc/master/savecauseAffect/' . encryptval($gethazid), 'class="form-horizontal" id="cause_submit" novalidate'); ?>
                                <div class="col-md-12">
                                    <div class="row m-t-10 m-l-10">

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Hazard Name  <span class="error">*</span></label>
                                                <?php
                                                $getTerId = isset($getCausedatas[0]->FK_HAZ_ID) && !empty($getCausedatas[0]->FK_HAZ_ID) ? $getCausedatas[0]->FK_HAZ_ID : set_value('loc[FK_PRO_ID]');
                                                $termdata = array(
                                                    'id' => 'FK_HAZ_ID',
                                                    'class' => 'form-control select2 ',
                                                    'required' => true,
                                                    'checkselect' => 'select2'
                                                );
                                                echo form_dropdown('cau[FK_HAZ_ID]', $getHazardNamedatas, $getTerId, $termdata);
                                                ?>
                                                <label class="error"><?php echo form_error('cau[FK_HAZ_ID]'); ?></label>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row float-right">
                                        <div class="col-md-12">
                                            <button type="button " class="btn btn-sm btn-warning addsubtyp"><i class="fa fa-plus-circle"></i> Add Cause Effect</button>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="emplDet m-t-10">
                                        <div class="row" >
                                            <div class="col-md-12">
                                                <div class="box-header with-border" >
                                                    <h5 class=""> Cause Effect Name </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (!empty($getCausedatas)) {
                                            foreach ($getCausedatas as $sbKey => $sbVal) {
                                                $inKey = $sbKey + 1;
                                                ?>
                                                <div class="row m-t-10 m-l-10 remRowid" id="remRowid_<?php echo $inKey; ?>" row-id="<?php echo $inKey; ?>">

                                                    <div class="col-sm-11">
                                                        <div class="form-group">
                                                            <!--<label> Checklist Subtype <span class="error"> * </span></label>-->
                                                            <?php
                                                            $getsubtypeval = isset($sbVal->CAUSE_NAME) && !empty($sbVal->CAUSE_NAME) ? $sbVal->CAUSE_NAME : '';
                                                            $getsubtypeid = isset($sbVal->CAUSE_AUTO_ID) && !empty($sbVal->CAUSE_AUTO_ID) ? $sbVal->CAUSE_AUTO_ID : '';

                                                            $cMaildatas = [
                                                                'name' => 'cau[cau_name][]',
                                                                'id' => 'hazId_' . $inKey,
                                                                'class' => 'form-control',
                                                                'value' => $getsubtypeval,
                                                                'required' => true,
                                                                'autocomplete' => 'off',
                                                            ];
                                                            echo form_input($cMaildatas);
                                                            ?>
                                                            <span class="error"><?php echo form_error('cau[cau_name][]') ?></span>
                                                        </div>
                                                        <input type="hidden" name="cau[CAUSE_AUTO_ID][]" value="<?php echo $getsubtypeid; ?>">
                                                    </div>
                                                    <div class="col-md-1 trashRem" id="trash_<?php echo $inKey; ?>" trash-id="<?php echo $inKey; ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </div>


                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>

                                            <div class="row m-t-10 m-l-10 remRowid" id="remRowid_1" row-id="1">

                                                <div class="col-sm-11">
                                                    <div class="form-group">
                                                        <?php
                                                        $cMaildatas = [
                                                            'name' => 'cau[cau_name][]',
                                                            'id' => 'hazId_1',
                                                            'class' => 'form-control',
                                                            'required' => true,
                                                            'autocomplete' => 'off',
                                                        ];
                                                        echo form_input($cMaildatas);
                                                        ?>
                                                        <span class="error"><?php echo form_error('cau[cau_name][]') ?></span>
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-md-1 trashRem" id="trash_1" trash-id="1">
                                                                                                    <i class="fa fa-trash"></i>
                                                                                                </div>-->


                                            </div>
                                        <?php } ?>
                                        <div class="newSubtypes">
                                        </div>
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
        $.validator.addMethod('alphanumeric', function (value) {
            return /^[A-Za-z0-9 ]*$/.test(value);
        }, "Please Enter only Alphanumeric characters");
        
        $.validator.addMethod('alphanospace', function (value) {
            return /^[A-Za-z]*$/.test(value);
        }, "Please Enter only Alphabetic characters.No spaces allowed");

        $.validator.addMethod('alphaspace', function (value) {
            return /^[A-Za-z ]*$/.test(value);
        }, "Please Enter only Alphabetic characters");



        $("#cause_submit").validate({
//            ignore: [],
//            success: function (error) {
//                error.removeClass("error");
//            },

            rules: {
                "cau[FK_HAZ_ID]": {
                    required: true
                },
                "cau[cau_name][]": {
                    required: true,
                    alphaspace: true,
                    minlength: 3,
                    maxlength: 150
                }
            },
            messages: {
                "cau[FK_HAZ_ID]": {
                    required: "Hazard Name is required"
                },
                "cau[cau_name][]": {
                    required: "Cause Affect Name is required",
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
        $(".addsubtyp").on("click", function (e) {
            e.preventDefault();
            var html = '';
            var rowID = $('.row').last().attr('row-id');
            var finalRowid = parseInt(rowID) + 1;
            html = '<div class="row m-t-10 m-l-10 remRowid" id="remRowid_' + finalRowid + '" row-id="' + finalRowid + '">\n\
                        <div class="col-sm-11">\n\
                                        <div class="form-group">\n\
                                            <input type="text" name="cau[cau_name][]" value="" id="hazId_' + finalRowid + '" class="form-control" required autocomplete="off" >\n\
                                            <span class="error"></span>\n\
                                        </div>\n\
                                    </div>\n\
<div class="col-md-1 trashRem" id="trash_' + finalRowid + '" trash-id="' + finalRowid + '">\n\
<i class="fa fa-trash"></i>\n\
</div>\n\
                    </div>';
            $(".newSubtypes").append(html)
        });

        $(document).on('click', ".trashRem", function () {
            var trashId = $(this).attr("trash-id");
            var count = $(".emplDet").find('.remRowid').length;
            if (count != 1) {
                $("#remRowid_" + trashId).remove();
            } else {
                swal('Sorry', 'Atleast one Checklist Subtype is required', 'error');
            }
        });
    });
</script>
