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
                                    <h4>ADD GTS LOCATION POINT</h4>
                                    <a href="<?php echo BASE_URL('gts/qr_code') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $gethazid = isset($getgtslocdatas->UNIQ_ID) && !empty($getgtslocdatas->UNIQ_ID) ? $getgtslocdatas->UNIQ_ID : '';
                                ?>
                                <?php echo form_open('gts/qr_code/saveqrcode/' . encryptval($gethazid), 'class="form-horizontal" id="gts_submit" novalidate'); ?>

                                <div class="emplDet m-t-10">
                                    <div class="row" >
                                        <div class="col-md-12">
                                            <div class="box-header with-border" >
                                                <h5 class=""> GTS Location Point </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name='EditID' value="<?php echo $gethazid; ?>">
                                    <input type="hidden" name='pointID' value="<?php
                                    echo isset($getgtslocdatas->POINT_ID) && !empty($getgtslocdatas->POINT_ID) ? $getgtslocdatas->POINT_ID : '';
                                    ?>">
                                    <div class="row col-md-12 m-t-10">
                                        <div class="col-md-4 form-group">
                                            <label>Terminal name<span class="error">*</span></label>
                                            <?php
                                            $getTerId = isset($getgtslocdatas->TERM_ID) && !empty($getgtslocdatas->TERM_ID) ? $getgtslocdatas->TERM_ID : set_value('gts[TERM_ID]');
                                            $termdata = array(
                                                'id' => 'TERMIN_ID',
                                                'class' => 'form-control select2 ',
                                                'required' => true,
                                                'checkselect' => 'select2'
                                            );
                                            echo form_dropdown('gts[TERMIN_ID]', $getterminalNamedatas, $getTerId, $termdata);
                                            ?>
                                            <label class="error TERMIN_ID" ></label>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>GTS Point <span class="error">*</span></label>
                                            <?php
                                            $getpointId = isset($getgtslocdatas->UNIQ_ID) && !empty($getgtslocdatas->UNIQ_ID) ? $getgtslocdatas->UNIQ_ID : $gethazid;
                                            $gtsdata = array(
                                                'id' => 'gts_point',
                                                'class' => 'form-control select2 ',
                                                'required' => true,
                                                'checkselect' => 'select2'
                                            );
                                            echo form_dropdown('gts[gts_point]', $gtspointdatas, $gethazid, $gtsdata);
                                            ?>
                                            <label class="error gts_point" ></label>
                                        </div>
                                    </div>
                                    <div class="form-group m-t-10 text-center">
                                        <div class="col-sm-offset-2 col-sm-10"> 
                                            <?php
                                            $data = array('id' => 'submit', 'type' => 'submit', 'content' => '<i class="fa fa-qrcode" aria-hidden="true"></i> Generate QrCode', 'class' => 'btn btn-primary');
                                            echo form_button($data);
                                            ?>
                                        </div>
                                    </div>
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
        $('.print').on('click', function () {
            window.print();
        });
        $('#TERMIN_ID').on('change', function () {
            var id = $(this).val();
            var editId = "<?php echo $gethazid; ?>";
            var url = "<?php echo BASE_URL('gts/qr_code/getAjaxpoint') ?>";
            var data = {terId: id ,editId: editId, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
            $.ajax({
                dataType: 'json',
                method: 'post',
                data: data,
                url: url,
                success: function (resp) {
                    $("#gts_point").html(resp.pointdatas)
                }
            });
        }).trigger('change');

        $.validator.addMethod('alphanumeric', function (value) {
            return /^[A-Za-z0-9 ]*$/.test(value);
        }, "Please Enter only Alphanumeric characters");

        $.validator.addMethod('alphanospace', function (value) {
            return /^[A-Za-z]*$/.test(value);
        }, "Please Enter only Alphabetic characters.No spaces allowed");

        $.validator.addMethod('alphaspace', function (value) {
            return /^[A-Za-z ]*$/.test(value);
        }, "Please Enter only Alphabetic characters");



        $("#gts_submit").validate({
            //            ignore: [],
            //            success: function (error) {
            //                error.removeClass("error");
            //            },

            rules: {
                "gts[TERMIN_ID]": {
                    required: true
                },
                "gts[gts_point]": {
                    required: true
                },

            },
            messages: {
                "gts[TERMIN_ID]": {
                    required: "Terminal name is required"
                },
                "gts[gts_point]": {
                    required: "GTS Point is required"
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
//            submitHandler: function (form) {
//                var formDatas = $('form').serialize();
//                var url = "<?php echo BASE_URL('gts/qr_code/saveqrcode'); ?>";
//                var data = formDatas;
//                $.ajax({
//                    type: 'ajax',
//                    dataType: 'json',
//                    method: 'post',
//                    data: data,
//                    url: url,
//                    success: function (resp) {
//                        var errMsgs = resp.status;
//                        if (errMsgs == 'error') {
//                        } else if (errMsgs) {
//                            swal('Success', 'QR Code has been generated successfully', 'success');
//                            window.location.reload();
//                        } else {
//                            swal('Sorry', 'Unable to generate QR Code! Try again later.', 'error');
//                            window.location.reload();
//                        }
//                    }
//                });
//            }

        });
    });
</script>
