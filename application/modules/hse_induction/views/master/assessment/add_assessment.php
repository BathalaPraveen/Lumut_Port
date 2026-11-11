<style>
    label.error {
        font-weight: 500 !important;
    }

    .with-border {
        background-color: #006eab;
        color: white;
        padding: 8px 0 1px 17px;
    }

    .emplDet {
        border: 1px solid #006eab;
    }

    #map {
        height: 360px;
        width: 100%;
    }

    .keyContdetails {
        border: 2px solid #1e6dab;
    }

    .m-t-10 {
        width: 99%;
    }

    .btn.btn-warning.btn-sm.addsubtyp {
        margin-top: 36px;
    }

    .modal-header {
        background: #007bff;
        padding: 10px;
    }

    .modal-title {
        color: white;
    }

    .form-group {
        margin-bottom: 0rem !important;
    }

    .labels {
        margin-left: 3%;
        text-transform: uppercase;
    }

    .imgupload,
    .fileinput img {
        width: 100%;
        height: 100%;
    }

    .InvestigationTable {
        overflow: auto;
        display: inline-table;
    }
</style>

<link href="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.css" rel="stylesheet">
<script src="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.js"></script>
<?php
$initialChecked1 = $initialChecked2 = $initialChecked3 = $initialChecked4 = '';
$checked = isset($editData->correct_ans) && !empty($editData->correct_ans) ? $editData->correct_ans : '';
if (!empty($checked)) {
    if ($checked == 1) {
        $initialChecked1 = 'checked';
    } elseif ($checked == 2) {
        $initialChecked2 = 'checked';
    } elseif ($checked == 3) {
        $initialChecked3 = 'checked';
    } elseif ($checked == 4) {
        $initialChecked4 = 'checked';
    }
}

$ass_id = isset($editData->id) && !empty($editData->id) ? $editData->id : '';

$opt_q = isset($editData->question_img) && !empty($editData->question_img) ? $editData->question_img : '';
$ques_name = isset($editData->question) && !empty($editData->question) ? $editData->question : '';
$opt_a = isset($editData->option_a_img) && !empty($editData->option_a_img) ? $editData->option_a_img : '';
$opt_b = isset($editData->option_b_img) && !empty($editData->option_b_img) ? $editData->option_b_img : '';
$opt_c = isset($editData->option_c_img) && !empty($editData->option_c_img) ? $editData->option_c_img : '';
$opt_d = isset($editData->option_d_img) && !empty($editData->option_d_img) ? $editData->option_d_img : '';


$option_a = isset($editData->option_a) && !empty($editData->option_a) ? $editData->option_a : '';
$option_b = isset($editData->option_b) && !empty($editData->option_b) ? $editData->option_b : '';
$option_c = isset($editData->option_c) && !empty($editData->option_c) ? $editData->option_c : '';
$option_d = isset($editData->option_d) && !empty($editData->option_d) ? $editData->option_d : '';
?>

<div class="wrapper">
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-headprimary">
                            <div class="row headingStyl">
                                <div class="col-md-12">
                                    <h4><?php echo ($ass_id != "") ? "EDIT QUESTION" : "ADD QUESTION"; ?></h4>
                                    <a href="<?php echo BASE_URL('hse_induction/master/assessment') ?>"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>
                                </div>
                            </div>
                            <div class="card-body">

                                <?php echo form_open_multipart('hse_induction/master/save_assessment/' . encryptval($ass_id), 'class="form-horizontal" id="company-profile" novalidate'); ?>
                                <input type="hidden" name="main_mas[ass_id_edit]" value="<?php echo $ass_id; ?>">

                                <div class="row m-t-10 m-l-10">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Type <span class="error"> * </span></label>
                                            <select id="type" name="type" class="form-control select2" checkSelect='select2'>
                                                <?php
                                                $typesToLoop = isset($dropType) ? $dropType : []; $selectedType = isset($editData->type) ? $editData->type : ""; foreach ($typesToLoop as $key => $value) {
                                                    $selected = ($selectedType == $key) ? 'selected' : '';
                                                    echo "<option value=\"$key\" $selected>$value</option>";
                                                }
                                                ?>
                                            </select>
                                            <span class="error"><?php echo form_error('type'); ?></span>
                                        </div>
                                    </div>
                                    <div class="emplDet m-t-10">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box-header with-border">
                                                    <h5 class=""> Questions </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-bordered InvestigationTable">
                                            <div id="test0">

                                                <tr class="Rowperson0">
                                                    <td colspan="4">
                                                        <div class="col-md-12 m-t-10">
                                                            <label>Exam Question <span class="error">*</span></label>
                                                            <a href="<?php echo BASE_URL . 'hse_induction/master/addOptimg/0' ?>" class="labels label label-danger" data-id='0' id="optimgajaxx" data-target="#optimgajax" data-toggle="modal">
                                                                <i class="fa fa-plus-circle"></i> Add Image
                                                            </a>
                                                            <input type="hidden" alt="0" name="mod_ques_image" class="form-control QN_NAME" id="mod_ques_0" value="<?php echo $opt_q; ?>">
                                                            <input type="text" alt="0" placeholder="Enter Exam Question" required="true" name="QN_NAME" class="form-control QN_NAME" id="QN_NAME" value="<?php echo $ques_name; ?>">
                                                            <div id='mod_img_0'>
                                                                <?php
                                                                if (file_exists($opt_q)) { ?>
                                                                    <img src="<?php echo BASE_URL . $opt_q; ?>" style="width:93px;height:75px;">
                                                                    <a href="javascript:void(0)"><i class='fa fa-trash del_img' data-id='0'></i></a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr class="Rowperson0">
                                                    <td>
                                                        <span class="error eventCrtError"></span>
                                                        <div class="col-md-12 m-t-10">
                                                            <label>Option A <span class="error">*</span></label>
                                                            <a href="<?php echo BASE_URL . 'hse_induction/master/addOptimg/1' ?>" class="labels label label-danger" data-id="1" id="optimgajaxx" data-target="#optimgajax" data-toggle="modal">
                                                                <i class="fa fa-plus-circle"></i> Add Image
                                                            </a>
                                                            <?php
                                                            // Check if $opt_a exists and the file exists on the server
                                                            if (!empty($opt_a) && file_exists($opt_a)) {
                                                                $filepath = BASE_URL . $opt_a; ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input crtans" alt="0" required type="radio" name="corret_ans" id="CORRECT_ANS01" value="1" <?php echo $initialChecked1; ?>>
                                                                    <label class="form-check-label" for="CORRECT_ANS01">
                                                                        <img class="rootUps" src="<?php echo $filepath; ?>" style="width:93px;height:75px;">
                                                                        <p><a href="<?php echo $filepath; ?>" target="_blank">View Image</a></p>
                                                                        <input type="hidden" name="mod_img_1" id="mod_img_AA1" value="<?php echo $opt_a; ?>">
                                                                        <input type="text" style="display: none;" alt="0" placeholder="Enter Option A" name="mod_ans_1" class="form-control OPTION_A" id="mod_ans_1" value="">
                                                                    </label>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input crtans" alt="0" required type="radio" name="corret_ans" id="CORRECT_ANS01" value="1" <?php echo $initialChecked1; ?>>
                                                                    <label class="form-check-label" for="CORRECT_ANS01"></label>
                                                                </div>
                                                                <input type="text" alt="0" required placeholder="Enter Option A" name="mod_ans_1" class="form-control OPTION_A" id="mod_ans_1" value="<?php echo $option_a; ?>">
                                                            <?php } ?>
                                                            <span class="error eventOpt1Error"></span>
                                                            <div id="mod_img_1">

                                                            </div>
                                                        </div>
                                                    </td>

                                                </tr>


                                                <tr class="Rowperson0">
                                                    <td>
                                                        <div class="col-md-12 m-t-10">
                                                            <label>Option B <span class="error">*</span></label>
                                                            <a href="<?php echo BASE_URL . 'hse_induction/master/addOptimg/2' ?>" class="labels label label-danger" data-id="2" id="optimgajaxx" data-target="#optimgajax" data-toggle="modal">
                                                                <i class="fa fa-plus-circle"></i> Add Image
                                                            </a>
                                                            <?php
                                                            if (!empty($opt_b) && file_exists($opt_b)) {
                                                                $filepath = BASE_URL . $opt_b; ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input crtans" alt="0" required type="radio" name="corret_ans" id="CORRECT_ANS02" value="2" <?php echo $initialChecked2; ?>>
                                                                    <label class="form-check-label" for="CORRECT_ANS02">
                                                                        <img class="rootUps" src="<?php echo $filepath; ?>" style="width:93px;height:75px;">
                                                                        <p><a href="<?php echo $filepath; ?>" target="_blank">View Image</a></p>
                                                                        <input type="hidden" name="mod_img_2" id="mod_img_AA2" value="<?php echo $opt_b; ?>">
                                                                        <input type="text" style="display: none;" alt="0" placeholder="Enter Option B" name="mod_ans_2" class="form-control OPTION_B" id="mod_ans_2" value="">
                                                                    </label>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input crtans" alt="0" required type="radio" name="corret_ans" id="CORRECT_ANS02" value="2" <?php echo $initialChecked2; ?>>
                                                                    <label class="form-check-label" for="CORRECT_ANS02"></label>
                                                                </div>
                                                                <input type="text" alt="0" required placeholder="Enter Option B" name="mod_ans_2" class="form-control OPTION_B" id="mod_ans_2" value="<?php echo $option_b; ?>">
                                                            <?php } ?>
                                                            <span class="error eventOpt2Error"></span>
                                                            <div id="mod_img_2">

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>



                                                <tr class="Rowperson0">
                                                    <td>
                                                        <div class="col-md-12 m-t-10">
                                                            <label>Option C <span style="color: red;">*</span></label>
                                                            <a href="<?php echo BASE_URL . 'hse_induction/master/addOptimg/3' ?>" class="labels label label-danger" data-id="3" id="optimgajaxx" data-target="#optimgajax" data-toggle="modal">
                                                                <i class="fa fa-plus-circle"></i> Add Image
                                                            </a>
                                                            <?php
                                                            if (!empty($opt_c) && file_exists($opt_c)) {
                                                                $filepath = BASE_URL . $opt_c; ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input crtans" alt="0" required type="radio" name="corret_ans" id="CORRECT_ANS03" value="3" <?php echo $initialChecked3; ?>>
                                                                    <label class="form-check-label" for="CORRECT_ANS03">
                                                                        <img class="rootUps" src="<?php echo $filepath; ?>" style="width:93px;height:75px;">
                                                                        <p><a href="<?php echo $filepath; ?>" target="_blank">View Image</a></p>
                                                                        <input type="hidden" name="mod_img_3" id="mod_img_AA3" value="<?php echo $opt_c; ?>">
                                                                        <input type="text" style="display: none;" alt="0" placeholder="Enter Option C" name="mod_ans_3" class="form-control OPTION_C" id="mod_ans_3" value="">
                                                                    </label>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input crtans" alt="0" required type="radio" name="corret_ans" id="CORRECT_ANS03" value="3" <?php echo $initialChecked3; ?>>
                                                                    <label class="form-check-label" for="CORRECT_ANS03"></label>
                                                                </div>
                                                                <input type="text" alt="0" placeholder="Enter Option C" name="mod_ans_3" class="form-control OPTION_C" id="mod_ans_3" value="<?php echo $option_c; ?>">
                                                            <?php } ?>
                                                            <div id="mod_img_3">

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>



                                                <tr class="Rowperson0">
                                                    <td>
                                                        <div class="col-md-12 m-t-10">
                                                            <label>Option D <span style="color: red;">*</span></label>
                                                            <a href="<?php echo BASE_URL . 'hse_induction/master/addOptimg/4' ?>" class="labels label label-danger" data-id="4" id="optimgajaxx" data-target="#optimgajax" data-toggle="modal">
                                                                <i class="fa fa-plus-circle"></i> Add Image
                                                            </a>
                                                            <?php
                                                            if (!empty($opt_d) && file_exists($opt_d)) {
                                                                $filepath = BASE_URL . $opt_d; ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input crtans" alt="0" required type="radio" name="corret_ans" id="CORRECT_ANS04" value="4" <?php echo $initialChecked4; ?>>
                                                                    <label class="form-check-label" for="CORRECT_ANS04">
                                                                        <img class="rootUps" src="<?php echo $filepath; ?>" style="width:93px;height:75px;">
                                                                        <p><a href="<?php echo $filepath; ?>" target="_blank">View Image</a></p>
                                                                        <input type="hidden" name="mod_img_4" id="mod_img_AA4" value="<?php echo $opt_d; ?>">
                                                                        <input type="text" style="display: none;" alt="0" placeholder="Enter Option D" name="mod_ans_4" class="form-control OPTION_D" id="mod_ans_4" value="">
                                                                    </label>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input crtans" alt="0" required type="radio" name="corret_ans" id="CORRECT_ANS04" value="4" <?php echo $initialChecked4; ?>>
                                                                    <label class="form-check-label" for="CORRECT_ANS04"></label>
                                                                </div>
                                                                <input type="text" alt="0" placeholder="Enter Option D" name="mod_ans_4" class="form-control OPTION_D" id="mod_ans_4" value="<?php echo $option_d; ?>">
                                                            <?php } ?>
                                                            <div id="mod_img_4">

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </div>

                                        </table>
                                    </div>
                                </div>


                                <div class="form-group m-t-10" style="text-align: center;">
                                    <div class="">

                                        <?php
                                        $data = array('id' => 'save', 'type' => 'submit', 'content' => 'SUBMIT', 'class' => 'btn btn-primary');
                                        echo form_button($data);
                                        ?>
                                    </div>
                                </div>
                                <!-- input states -->
                                <?php echo form_close(); ?>

                            </div>

                            <!-- /.card -->

                        </div>
                        <!--/.col (left) -->

                    </div>
                    <!-- /.row -->
                </div>
        </section>
    </div>

</div>
<div class="modal modal-info fade" id="respmodal" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '.del_img', function() {
            var id = $(this).attr('data-id');
            var altr = $(this).attr('altr');

            $("#mod_img_" + id).hide();
            $("#mod_ans_" + id).show().val('');
            $("#mod_ques_" + id).show().val('');
            $('#mod_img_' + altr + id).hide();
            $("#OPTION_" + altr + id).show().val('');
            $("#QN_NAME_" + altr + id).show().val('');
        });


        $(document).on('click', '#optimgajaxx', function(e) {
            e.preventDefault();
            $('#respmodal').modal('show').find('.modal-content').load($(this).attr('href'));
        });

        $.validator.addMethod('alphanumeric', function(value) {
            return /^[A-Za-z0-9/,.()%  ]*$/.test(value);
        }, "Please Enter valid Alphanumeric characters with allowed special charters are /,.()%");


        function initializeValidation() {
            // Destroy any existing validation
            $("#company-profile").validate().destroy();
            $("#company-profile").validate({
                ignore: [],
                success: function(error) {
                    error.removeClass("error");
                    error.addClass("d-none");
                },
                rules: {
                    "type": {
                        required: true
                    },
                    "QN_NAME": {
                        required: true
                    },
                    "mod_ans_1": {
                        required: true
                    },
                    "mod_ans_2": {
                        required: true
                    },
                    "mod_ans_3": {
                        required: true
                    },
                    "mod_ans_4": {
                        required: true
                    },

                },
                messages: {
                    "type": {
                        required: "Type is Required"
                    },
                    "QN_NAME": {
                        required: "Exam Question is Required"
                    },
                    "mod_ans_1": {
                        required: "Option A is Required"
                    },
                    "mod_ans_2": {
                        required: "Option B is Required"
                    },
                    "mod_ans_3": {
                        required: "Option C is Required"
                    },
                    "mod_ans_4": {
                        required: "Option D is Required"
                    },

                },
                errorPlacement: function(error, element) {
                    if (element.hasClass("atarfile")) {
                        element.closest(".imgGroup").append(error);
                    } else if (element.attr('checkSelect') === 'select2') {
                        error.insertAfter(element.next('.select2-container'));
                    } else if (element.attr('ckedit') === 'ckeditor') {
                        error.insertAfter(element.next('.note-editor'));
                    } else {
                        error.insertAfter(element);
                        element.closest(".imgGroup").last().append(error);
                    }
                },
                submitHandler: function(form, event) {
                    swal({
                        title: "Please wait..",
                        imageUrl: loadingImg,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    form.submit();
                },
            });
        }

        $("#save").on("click", function(e) {
            e.preventDefault(); // Prevent default form submission

            initializeValidation();

            if ($("#company-profile").valid()) {

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to submit the form.",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#company-profile").submit();
                    }
                });
            }


        });

    });
</script>


