<?php
$editRespid = postData($getCategories, 'id');
?>
<div class="modal-header">
    <h4 class="modal-title"><?php echo ($editRespid) ? 'Edit Type' : 'Add Type'; ?></h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<?php echo form_open('hse_induction/master/save_type/' . $editRespid, 'class="form-horizontal" id="type_form" novalidate'); ?>

<div class="modal-body">
    <input type="hidden" name="main_mas[hiddenrespID]" value='<?php echo $editRespid; ?>'>

    <div class="form-group">
        <label for="type">Type <span class="text-danger">*</span></label>
        <?php
        $editRespname = postData($getCategories, 'type');
        $respName = [
            'name' => 'main_mas[type]',
            'id' => 'type',
            'class' => 'form-control',
            'placeholder' => 'Enter type name',
            'value' => $editRespname,
            'required' => 'required'
        ];
        echo form_input($respName);
        ?>
        <span class="text-danger type_err"><?php echo form_error('main_mas[type]'); ?></span>
    </div>
</div>

<div class="modal-footer justify-content-center">
    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#type_form").validate({
            rules: {
                "main_mas[type]": {
                    required: true,
                    maxlength: 100,
                    minlength: 2
                }
            },
            messages: {
                "main_mas[type]": {
                    required: "Type name is required",
                    maxlength: "Maximum 100 characters allowed",
                    minlength: "Minimum 2 characters required"
                }
            },
            errorPlacement: function(error, element) {
                element.closest('.form-group').find('.type_err').html(error);
            },
            success: function(label) {
                label.closest('.form-group').find('.type_err').html('');
            }
        });

        $("#type_form").on('submit', function(e) {
            e.preventDefault();
            if ($("#type_form").valid()) {
                var formData = new FormData(this);
                var url = "<?php echo BASE_URL('hse_induction/master/save_type'); ?>";

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        if (resp.status == true) {
                            window.location.reload();
                        } else {
                            $(".type_err").text(resp.msgs ? resp.msgs : "Error saving type").show();
                        }
                    },
                    error: function() {
                        alert("An error occurred while processing the request.");
                    }
                });
            }
        });
    });
</script>


