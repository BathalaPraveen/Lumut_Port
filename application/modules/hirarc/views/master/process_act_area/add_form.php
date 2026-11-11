<?php 
$editId = postData($getprocessdatas, 'PRO_AUTO_ID');
$formTitle = ($editId > 0 ) ? 'Edit Activity Process Area Name' : 'Add Activity Process Area Name';
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
        <label for="loctyp"> Activity Process Area Name <span class="error"> * </span></label>
        <?php
        $editpro_name = postData($getprocessdatas, 'PRO_NAME');
        $catName = [
            'name' => 'pro_act',
            'id' => 'pro_name',
            'class' => 'form-control',
            'placeholder' => 'Enter Activity Process Area Name',
            'value' => $editpro_name,
        ];
        echo form_input($catName);
        ?>
        <label class="error" id="pro_act_error">
          
        </label>
       
    </div>

</div>

<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('PRO_AUTO_ID',$editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
          $("#pro_act").validate({

            rules: {
                "pro_act": {
                    required: true,
                    maxlength: 100,
                    minlength: 3
                },
            },
            messages: {
                "pro_act": {
                    required: "Activity Process Area Name is required"
                },
            },
            submitHandler: function (form) {
                var formDatas = $('form').serialize();
                var url = "<?php echo BASE_URL('hirarc/master/saveActivityProArea'); ?>";
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

