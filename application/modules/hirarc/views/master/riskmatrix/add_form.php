<?php
$editId = postData($getriskratedatas, 'RISK_RATE_AUTO_ID');
$formTitle = ($editId > 0 ) ? 'Edit Risk Matrix' : 'Add Risk Matrix';
?>
<style>
    .modal-header{
        background: #e6af0a;
        padding : 10px;
    }
    .modal-title{
        color: white;
    }
    .form-group{
        margin-bottom: 0rem !important;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo $formTitle; ?></h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<?php
echo form_open('#', 'class="form-horizontal" id="pro_act" novalidate');
?>



<!-- Modal body -->
<div class="modal-body">
    <div class="row col-12">
        <div class="col-6">
            <label for="loctyp"> Severity Rating<span class="error"> * </span></label>
            <?php
            $seve = isset($getriskratedatas->SEVERITY) && !empty($getriskratedatas->SEVERITY) ? $getriskratedatas->SEVERITY : '';
            $termdata = array(
                'id' => 'SEVERITY',
                'class' => 'form-control select2 ',
                'required' => true,
                'checkselect' => 'select2'
            );
            echo form_dropdown('SEVERITY', $severity, $seve, $termdata);
            ?>
            <label class="error">
                <?php echo form_error('SEVERITY'); ?>
            </label>

        </div> 
        <div class="col-6">
            <label for="loctyp"> Likelihood Rating<span class="error"> * </span></label>
            <?php
            $like = isset($getriskratedatas->LIKELIHOOD) && !empty($getriskratedatas->LIKELIHOOD) ? $getriskratedatas->LIKELIHOOD : '';
            $termdata = array(
                'id' => 'LIKELIHOOD',
                'class' => 'form-control select2 ',
                'required' => true,
                'checkselect' => 'select2'
            );
            echo form_dropdown('LIKELIHOOD', $likelhood, $like, $termdata);
            ?>
            <label class="error">
                <?php echo form_error('LIKELIHOOD'); ?>
            </label>

        </div>  
    </div>
    <div class="row col-12">
        <div class="col-6">
            <div class="form-group">
                <label for="loctyp"> Risk Rate<span class="error"> * </span></label>
                <?php
                $editpro_name = postData($getriskratedatas, 'RISK_RATE');
                $catName = [
                    'name' => 'RISK_RATE',
                    'id' => 'RISK_RATE',
                    'class' => 'form-control',
                    'readonly' => TRUE,
                    'value' => $editpro_name,
                ];
                echo form_input($catName);
                ?>
            </div>
        </div> 
        <div class="from-group col-6">
            <label for="COLOR_CODE">Choose Color Code <span class="error"> * </span></label><br>
            <input type="color" name="COLOR_CODE" id="COLOR_CODE" required="true" value="<?php echo postData($getriskratedatas, 'RISK_LEVEL_COL_CODE'); ?>">
        </div>
    </div>


</div>

<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('RISK_RATE_AUTO_ID', $editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {

        $('#SEVERITY,#LIKELIHOOD').on('change', function () {
            var sev_val = $('#SEVERITY').val();
            var lik_val = $('#LIKELIHOOD').val();
            if (lik_val != '' && sev_val != '') {
                var risk_rate = lik_val * sev_val;
                $('#RISK_RATE').val(risk_rate);
            }
//            else if (lik_val == '') {
//                alert('Select Likelihood');
//            } else {
//                alert('Select Severity');
//            }
        });
        $("#pro_act").validate({
            rules: { 
                "SEVERITY": {
                    required: true
                },
                "LIKELIHOOD": {
                    required: true
                },
                "COLOR_CODE": {
                    required: true
                },
            },
            messages: {
                "SEVERITY": {
                    required: "Severity is required"
                },
                "LIKELIHOOD": {
                    required: "Likelhood is required"
                },
            },
            submitHandler: function (form) {
                var formDatas = $('form').serialize();
                var url = "<?php echo BASE_URL('hirarc/master/saveriskmatrix'); ?>";
                var data = formDatas;
                $.ajax({
                    type: 'ajax',
                    dataType: 'json',
                    method: 'post',
                    data: data,
                    url: url,
                    success: function (resp) {
                        var errMsgs = resp.status;
                        if (errMsgs == 'error') {

                            $('.error').html('');
                            $.each(resp.errors, function (key, value) {
                                $(".error").css('display', 'block');
                                var keys1 = key.replace(/\[/gi, '_');
                                var keys = keys1.replace(/\]/gi, '');
                                $('#' + keys + '_error').html(value);

                            });
                        } else if (errMsgs) {
                            window.location.reload();
                        } else {
                            window.location.reload();
                        }

                    }
                });
            }

        });



    });


</script>

