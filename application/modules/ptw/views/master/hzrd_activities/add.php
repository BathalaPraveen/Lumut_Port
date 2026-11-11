<?php
$editId = postData($getHAdatas, 'HZRDA_ID', '');
$formTitle = ($editId != "") ? 'Edit Hazard Activities' : 'Add Hazard Activities';
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
echo form_open('#', 'class="form-horizontal" id="aoc-form"')
?>
<!-- Modal body -->
<div class="modal-body">

    <div class="form-group">
        <label for="cls_title"> Hazard Type <span class="error"> * </span></label>
	<?php
	$edittype = postData($getHAdatas, 'PTYPE');
	$options = array(
	    '' => 'Select Hazard Type',
	    'NORMAL' => 'Normal',
	    'CRITICAL' => 'Critical',
	    'BOTH' => 'Both'
	);
	$extra = 'class="form-control" id="hzrd_type"';
	echo form_dropdown('hzrdtype', $options, $edittype, $extra);
	?>
        <label class="error" id="hzrdtype_error">

        </label>
    </div>
    
    <div class="form-group">
        <label for="cls_title"> Hazard Category <span class="error"> * </span></label>
	<?php
	$editrefId = postData($getHAdatas, 'HZRDAC_REF_ID');
	
	$extra = 'class="form-control select2bs4 select2" id="hzrdrefId"';
	echo form_dropdown('hzrdrefId', $getHACatDetails, $editrefId, $extra);
	?>
        <label class="error" id="hzrdtype_error">

        </label>
    </div>
 
 
    <div class="form-group">
        <label for="ha_title"> Hazard Activity <span class="error"> * </span></label>
	<?php
	$editIncicat = postData($getHAdatas, 'HZRDA_NAME');
	$catName = [
	    'name' => 'hatitle',
	    'id' => 'hatitle',
	    'class' => 'form-control',
	    'placeholder' => 'Enter Hazard Activities',
	    'value' => $editIncicat,
	];
	echo form_input($catName);
	?>
        <label class="error" id="hatitle_error">

        </label>
    </div>
    <?php 
    $dislayStyle = ($editrefId == 2) ? 'display:block;': 'display:none';
    ?>
    <div class="form-group" id="checllistdiv" style="<?php echo $dislayStyle;?>">
        <label for="ha_cklist"> Has Checklist <span class="error"> * </span></label>        
	<?php
	$hascheck = postData($getHAdatas, 'HZRDA_CHKLST', '0');
	$yjs = array('id' => 'haschky','class'=>'haschklist');
	$njs = array('id' => 'haschkn','class'=>'haschklist');
	$checkedyes = ($hascheck == 'Y') ? TRUE : FALSE;
	$checkedno = ($hascheck == 'N') ? TRUE : FALSE;
	echo form_radio('hasChecklist', 'Y', $checkedyes, $yjs);
	echo '<label for="haschky"> Yes</label>';
	echo form_radio('hasChecklist', 'N', $checkedno, $njs);
	echo '<label for="haschkn"> No</label>';
	?>
        
        
    </div>
    <span class="error" id="haschklist_error"></span>

</div>
<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('ha_id', $editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
        $('.select2').select2()
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    
    $(document).on('change','#hzrdrefId',function () {
        var val = $(this).val();
        if(val == 2){
            $('#checllistdiv').show();
        }else{
            $('#checllistdiv').hide();
        }
    });
	$("#aoc-form").validate({
	    rules: {
		"hzrdtype": {
		    required: true
		},
                "hzrdrefId": {
		    required: true
		},
		"hatitle": {
		    required: true,
		    brace_slash_hiphen_alphaspace: true,
		    maxlength: 50,
		    minlength: 3,

		},
		"hasChecklist": {
		    required: function (element){
                         return $("#hzrdrefId :selected").val() == "2";
                    }
		}

	    },
	    messages: {
		"hzrdtype": {
		    required: "Hazard Type is required",

		},
                "hzrdrefId": {
		    required: "Hazard Category is required",

		},
		"hatitle": {
		    required: "Hazard Activity is required"
		},
		"hasChecklist": {
		    required: "Checklist Selection is required"
		}
	    },
             errorPlacement: function (error, element) {
               
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('span'));
                }else if (element.attr('name') == 'hasChecklist') {
                    error.appendTo('span#haschklist_error');
                    
                } else {
                    error.insertAfter(element);
                }

            },
	    submitHandler: function (form) {		
		var formDatas = $(form).serialize();
		var url = "<?php echo BASE_URL.'ptw/masters/saveHA'; ?>";
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
				var keys = keys1.replace(/\]/gi, '_');
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

