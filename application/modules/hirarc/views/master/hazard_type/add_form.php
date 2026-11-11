<?php 
$editId = postData($getHazardatas, 'HAZ_TYPE_AUTO_ID');
$formTitle = ($editId > 0 ) ? 'Edit Type of Activity Name' : 'Add Type of Activity Name';
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
    <h4 class="modal-title"><?php echo $formTitle;?></h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<?php
echo form_open('#', 'class="form-horizontal" id="pro_act" novalidate');
?>



<!-- Modal body -->
<div class="modal-body">
    
    <div class="form-group">
        <label for="loctyp"> Type of Activity Name <span class="error"> * </span></label>
        <?php
        $editpro_name = postData($getHazardatas, 'HAZ_TYPE_NAME');
        $catName = [
            'name' => 'haz_name',
            'id' => 'haz_name',
            'class' => 'form-control',
            'placeholder' => 'Enter Type of Activity Name',
            'value' => $editpro_name,
        ];
        echo form_input($catName);
        ?>
        <label class="error" id="haz_name_error">
          
        </label>
       
    </div>

</div>

<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('HAZ_TYPE_AUTO_ID',$editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
          $("#pro_act").validate({

            rules: {
                "haz_name": {
                    required: true,
                    maxlength: 100,
                    alphaspace: true,
                    minlength: 1
                },
            },
            messages: {
                "haz_name": {
                    required: "Type of Activity is required"
                },
            },
            submitHandler: function (form) {
                var formDatas = $('form').serialize();
                var url = "<?php echo BASE_URL('hirarc/master/saveHazardType'); ?>";
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
                                $('#'+keys+'_error').html(value);
                              
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

