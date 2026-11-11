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

    .file-pop {
        top: 48% !important;
        margin-left: 28% !important;
    }

    .bootimgheight {
        margin-top: 0 !important;
    }

    p {
        margin-bottom: 0 !important;
    }
</style>

<link href="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.css" rel="stylesheet">
<script src="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.js"></script>


<div class="wrapper">
    <div class="content-wrapper">
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php
                echo $this->session->flashdata('uploadflash');
                $this->session->unset_userdata('uploadflash'); ?>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-md-12">
                                    <h3 class="card-title">Ppt / Video</h3>
                                    <a href="<?php echo BASE_URL('hse_induction/master/ppt') ?>"><button type="button" class="btn btn-sm btn-primary backBtns d-none"> Back</button></a>
                                </div>
                            </div>
                            <div class="card-body">
                               
                                <?php echo form_open_multipart('hse_induction/master/save_ppt', 'class="form-horizontal" id="company-profile" novalidate'); ?>
                                <input type="hidden" id="upload_id_edit" name="main_mas[upload_id_edit]" value="">

                                <div class="row m-l-10">

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

                                    <div class="col-sm-12">
                                        <!-- ( <b>Note : </b> Only png, jpg, jpeg, ppt, pptx, mp4, avi, mov, mkv, pdf, doc, docx, xls, xlsx are allowed ) -->
                                    </div>
                                    <div class="col-sm-4 input_fields">
                                        <div class="form-group ">

                                            <label style="margin-top: 10px;"> Uploaded File : <span class="error"></span></label>

                                            <span id="file_view_link">-</span>


                                        </div>
                                        <label style="margin-top: 0px;"> Upload New File<span class="error"></span></label>
                                        <div class="form-group ">
                                            <div class="fileinput fileinput-new apprFileinput imgGroup" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput">
                                                    <?php


                                                    // if (!empty($useeFilepath)) {
                                                    ?>
                                                    <!-- <img src="<?php // echo BASE_URL . $useeFilepath; 
                                                                    ?>" alt="<?php // echo !empty($useeimgname) ? $useeimgname : 'Uploaded Image'; 
                                                                                ?>" style="height: 100%;" /> -->
                                                    <?php // } else { 
                                                    ?>

                                                    <img src="" alt="Image Preview" style="height: 100%; display: none;" />
                                                    <?php // } 
                                                    ?>

                                                </div>
                                                <!-- <p>(Image, PPT, Video, PDF, Word, Excel)</p> -->
                                                <p>(png, jpg, jpeg, ppt, pptx, mp4, pdf, doc, docx, xls, xlsx)</p>
                                                <div class="file-pop">
                                                    <span class="text-green btn-file">
                                                        <span class="photo fileinput-new" title="Add Image">
                                                            <img class="imgupload" src="<?php echo BASE_URL('/assets/images/photo.png'); ?>" style="width: 30%;" />
                                                        </span>
                                                        <input type="file" name="upload_file" class="atarfile">
                                                    </span>
                                                    <button type="button" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image">
                                                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" id="other_user_img" name="other_user_img" value="">

                                        </div>
                                    </div>



                                </div>


                                <div class="form-group m-t-10 input_fields" style="text-align: center;">
                                    <div class="">

                                        <?php
                                        $data = array('id' => 'save', 'type' => 'submit', 'content' => 'Upload', 'class' => 'btn btn-primary');
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


<script type="text/javascript">
    $('.input_fields').hide();

    $(document).ready(function() {

        $(document).on('change', '#type', function() {
            var type = $(this).val();
            if (type != '') {
                getFileDetails(type);
                $('.input_fields').show();
            } else {
                $('.input_fields').hide();
            }
        });


        function getFileDetails(type) {

            var url = "<?php echo BASE_URL() . "hse_induction/master/getFileDetails" ?>";

            var data = {
                type: type,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            };

            $.ajax({
                type: 'post',
                url: url,
                data: data,
                cache: false,
                success: function(data) {
                    var fileData = JSON.parse(data);
                    var baseUrl = "<?php echo BASE_URL(); ?>";

                    
                    if (fileData.id !== undefined && fileData.id !== '') {
                        $('#upload_id_edit').val(fileData.id);
                    } else {
                        $('#upload_id_edit').val('');
                    }

                    if (fileData.upload_file !== undefined && fileData.upload_file !== '') {
                        $('#other_user_img').val(fileData.upload_file);

                        var link = '<a href="' + baseUrl + fileData.upload_file + '" target="_blank">View</a>';
                        $('#file_view_link').html(link);
                    } else {
                        $('#other_user_img').val('');
                        $('#file_view_link').html('-');
                    }
                }
            });
        }


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
                    "upload_file": {
                        required: true,
                        extension: "png|jpg|jpeg|ppt|pptx|mp4|avi|mov|mkv|pdf|doc|docx|xls|xlsx"
                    },
                },
                messages: {
                    "upload_file": {
                        required: "File is Required",
                        extension: "Only above mentioned file types are allowed."
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
            e.preventDefault();

            initializeValidation();

            if ($("#company-profile").valid()) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to Upload File.",
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

