
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
    <h3 class="modal-title"> Add  Checklist Type</h3>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<?php
 $editRespid = postData($getRespdatas,'INSP_CHECK_TYP_ID');

    echo form_open('inspection/saveInsp_checklist/'.$editRespid, 'class="form-horizontal" id="resp-type" novalidate')
    ?>



<!-- Modal body -->
<div class="modal-body">
    <?php $styleCSS = ($editRespid == '') ? '' : 'd-none' ?>
    
        <input type="hidden" name="insp[hiddenrespID]" value='<?php echo $editRespid; ?>'>
        
   
    <div class="form-group">
        <label for="loctyp"> Checklist Type <span class="error"> * </span></label>
        <?php
        $editRespname = postData($getRespdatas,'INSP_CHECK_TYP_NAME');
        $respName = [
            'name' => 'insp[checklist_name]',
            'id' => 'checklist_name',
            'class' => 'form-control',
            'placeholder' => 'Enter Checklist Type',
            'value' => $editRespname,
        ];
        echo form_input($respName);
        ?>
         <!--<span class="error"><?php echo form_error('insp[checklist_name]') ?></span>-->
        <label class="error loctyp_err">
            
        </label>
    </div>
    
</div>

<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <button type="submit" class="btn btn-primary "><i class="fa fa-save"></i> Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">
    
    $(document).ready(function(){
        var GetErr = '';
         $.validator.addMethod('alphanumeric', function (value) {
            return /^[A-Za-z0-9/,.()%  ]*$/.test(value);
        }, "Please Enter valid Alphanumeric characters with allowed special charters are /,.()%");

        
    $.validator.addMethod('alphaspace',function (value) {
            return /^[A-Za-z ]*$/.test(value);
        },"Please Enter only Alphabetic characters");
        
       
      $("#resp-type").validate({
            success: function (error) {
                error.removeClass("error");
                 GetErr = 'no error';
                return GetErr;
            },

            rules: {
               
                "insp[checklist_name]": {
                    required: true,
                    alphanumeric: true,
                    maxlength: 50,
                    minlength: 3
                },
               
                
              },
            messages: {
                "insp[checklist_name]": {
                    required: "Inspection Checklist Type is required"
                },
                
            },

        });

    $("#resp-type").submit(function(e){
        if(GetErr == ''){
             return false;
        }else{
       e.preventDefault();
       var formDatas = $('form').serialize();
        var url = "<?php echo BASE_URL('inspection/saveInsp_checklist') ?>";
        var data = formDatas;
        
        $.ajax({
            type : 'ajax',
            dataType : 'json',
            method : 'post',
            data : data,
            url : url,
            success : function(resp){
                var errMsgs = resp.status;
                console.log(resp)
                console.log(errMsgs)
                if(errMsgs == 'error'){
                   
                    $(".error").css('display','block');
                    $(".loctyp_err").text(resp.checklist_name)
                    
                    
                }else if(errMsgs){
                    window.location.reload();
                }else{
                    window.location.reload();
                }
                 
            }
        });
    }
      
    })
    
    
        
    });
   

</script>