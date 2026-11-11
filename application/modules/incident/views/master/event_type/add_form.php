<?php 
$editId = postData($getInccatdatas, 'EVENT_TYPE_ID',0);
$formTitle = ($editId > 0 ) ? 'Edit Incident Event Type' : 'Add Incident Event Type';
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


echo form_open('#', 'class="form-horizontal" id="role-type" novalidate')
?>



<!-- Modal body -->
<div class="modal-body">
    
    <div class="form-group">
        <label for="loctyp"> Incident Event Type <span class="error"> * </span></label>
        <?php
        $editIncicat = postData($getInccatdatas, 'EVENT_TYPE_NAME');
        $catName = [
            'name' => 'inci_event_type',
            'id' => 'inci_event_type',
            'class' => 'form-control',
            'placeholder' => 'Enter Incident Event Type',
            'value' => $editIncicat,
        ];
        echo form_input($catName);
        ?>
        <label class="error" id="inci_event_type_error">
          
        </label>
       
    </div>

</div>

<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('inc_event_type_id',$editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
        $.validator.addMethod('alpha_dash_space', function (value) {
    return /^[A-Za-z/,.()% ]*$/.test(value);
}, "Please Enter valid Alphabetic characters with allowed special charters are /,.%()");
          $("#role-type").validate({

            rules: {
                "inci_event_type": {
                    required: true,
                   alpha_dash_space: true,
                    //alphaspace: true,
                    maxlength: 100,
                    //programming_char:true,
                    minlength: 3
                },

            },
            messages: {
               
                "inci_event_type": {
                    required: "Incident Event Type is required"
                },

            },
            submitHandler: function (form) {
                var formDatas = $('form').serialize();
                var url = "<?php echo BASE_URL('incident/master/saveIncEventType') ?>";
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

