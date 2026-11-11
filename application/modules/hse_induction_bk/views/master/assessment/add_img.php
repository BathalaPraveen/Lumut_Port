<style>
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

    .btn-file>input {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        font-size: 23px;
        cursor: pointer;
        opacity: 0;
        direction: ltr;
    }

    .fileinput .thumbnail {
        display: inline-block;
        margin-bottom: 5px;
        overflow: hidden;
        text-align: center;
        vertical-align: middle;
    }

    .bootimgheights {
        width: 200px;
        height: 120px;
    }

    .file-pop {
        top: 24% !important;
        margin-left: 5% !important;
        margin-right: 0% !important;
        position: absolute;
        font-size: 20px;
    }

    .imgupload,
    .fileinput img {
        width: 100%;
        height: 100%;
    }
</style>

<div class="modal-header">
    <h3 class="modal-title"> Add Image</h3>
    <button type="button" class="close" data-dismiss="modal" data-target="#myModal">&times;</button>
</div>

<div class="modal-body text-center">
    <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-preview thumbnail bootimgheights ans_img" data-trigger="fileinput"></div>
        <p class="mini-txt">(png, jpeg, jpg)</p>
        <div class="file-pop file-pop-img">
            <span class="text-green btn-file">
                <span class="photo fileinput-new" title="Add Image">
                    <img src='<?php echo BASE_URL("/assets/images/photo.png"); ?>' style="width: 30%;" />
                </span>
                <span class="fileinput-exists" title="Add Image"></span>
                <input type="file" name="opt_img" id="opt_img" class="upl_img" accept="image/*" required>
            </span>
            <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image">
                <i class="fa fa-times-circle-o" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <div class="text-center m-t-20">
        <?php
        echo form_input([
            'id' => 'upref',
            'name' => 'upref',
            'type' => 'hidden',
            'value' => $opt_val
        ]);
        echo form_input([
            'id' => 'uprefOp',
            'name' => 'uprefOp',
            'type' => 'hidden',
            'value' => $optin
        ]);
        echo form_button([
            'id' => 'upload_img',
            'type' => 'submit',
            'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Upload',
            'class' => 'btn btn-primary'
        ]);
        ?>
    </div>
</div>

<div class="modal-footer justify-content-center">
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#upload_img").click(function() {
            $('.close').trigger('click');

            var did = $('#upref').val();
            var didd = $('#uprefOp').val();
            var formData = new FormData();
            var test = $('#opt_img')[0].files[0];

            if (test !== undefined) {
                formData.append('file', test);
                formData.append('option', did);
                formData.append('optionn', didd);
                formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');

                var url = '<?php echo BASE_URL; ?>';
                $.ajax({
                    url: url + 'hse_induction/master/qaimag',
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('#mod_ans_' + data.option).val(data.result).css('display', 'none');
                        $('#mod_ques_' + data.option).val(data.result);
                        $('#mod_hid_ans_' + data.option).val(data.result);
                        $('#mod_img_' + data.option).html(data.image).css('display', 'block');

                        $('#QN_NAME_IMGS_' + data.optionn + data.option).val(data.result);
                        $('#OPTION_' + data.optionn + data.option).val(data.result).css('display', 'none');
                        $('#mod_hid_ans_' + data.option).val(data.result);
                        $('#mod_img_' + data.optionn + data.option).html(data.image);
                        $('#mod_img_' + data.optionn + data.optionn + data.option).val(data.result);
                        $('#mod_img_' + data.optionn + data.option).css('display', 'block');
                        $('#qn_img_' + data.optionn + data.option).val(data.result);
                        $('#mod_ques_' + data.optionn + data.option).val(data.result);
                    }
                });
            } else {
                alert('Image File Cannot be Empty');
                return false;
            }
        });
    });
</script>
