<?php
$editId = postData($getgtslocdatas, 'UNIQ_ID');
$formTitle = ($editId > 0 ) ? 'Edit GTS Location Point' : 'Add GTS Location Point';
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
echo form_open('#', 'class="form-horizontal" id="gts_sub" novalidate');
?>

<!-- Modal body -->
<div class="modal-body">
    <div class="form-group">
        <label for="loctyp"> GTS Point ID</label>
        <?php
        $point_id = postData($getgtslocdatas, 'POINT_ID');
        $catName = [
            'name' => 'gts[POINT_ID]',
            'id' => 'POINT_ID',
            'class' => 'form-control',
            'value' => $point_id != '' ? $point_id : $gts_uniq_id,
            'readonly' => TRUE
        ];
        echo form_input($catName);
        ?>
    </div>
    <div class="form-group">
        <label>Terminal <span class="error">*</span></label>
        <?php
        $getTerId = isset($getgtslocdatas->TERM_ID) && !empty($getgtslocdatas->TERM_ID) ? $getgtslocdatas->TERM_ID : set_value('gts[TERMIN_ID]');
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
    <div class="form-group">
        <label for="loctyp"> GTS Location Point Name <span class="error"> * </span></label>
        <?php
        $editpro_name = postData($getgtslocdatas, 'LOCA_POINT');
        $catName = [
            'name' => 'gts[LOCA_POINT]',
            'id' => 'LOCA_POINT',
            'class' => 'form-control',
            'placeholder' => 'Enter GTS Location Point',
            'value' => $editpro_name,
            'required' => true
        ];
        echo form_input($catName);
        ?>
        <label class="error LOCA_POINT">
        </label>

    </div>

</div>

<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('UNIQ_ID', $editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
        $("#gts_sub").validate({

            rules: {
                "gts[TERMIN_ID]": {
                    required: true

                },
                "gts[LOCA_POINT]": {
                    required: true,
                    alphanumericwithspecialchar: true,
                    minlength: 3,
                    maxlength: 100
                },
            },
            messages: {
                "gts[TERMIN_ID]": {
                    required: "Terminal Name is required"
                },
                "gts[LOCA_POINT]": {
                    required: "Location Name is required"
                }
            },
            submitHandler: function (form) {
                var formDatas = $('form').serialize();
                var url = "<?php echo BASE_URL('gts/master/save_gts_loc_point'); ?>";
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
                                $('.TERMIN_ID').html(value);
                                $('.LOCA_POINT').html(value);

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

