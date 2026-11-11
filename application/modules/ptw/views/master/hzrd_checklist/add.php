<?php
$editId = postData($getWpidatas, 'HZRDA_ITEM_ID', '');
$formTitle = ($editId != "") ? 'Edit Hazard Activity Item' : 'Add Hazard Activity Item'; 
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
echo form_open('#', 'class="form-horizontal" id="hai-form" novalidate')
?>
<!-- Modal body -->
<div class="modal-body">

<!--    <div class="form-group">
        <label for="cls_title"> Hazard Type <span class="error"> * </span></label>
	<?php
	$edittype = postData($getWpidatas, 'REF_HZRDA_ID');
	$options = $getCatdatas;
	$extra = 'class="form-control" id="hzrd_type"';
	echo form_dropdown('hzrdtype', $options, $edittype,$extra);
	?>
        <label class="error" id="hzrdtype_error">

        </label>
    </div>-->
    <div class="form-group">
        <label for="ha_chklst"> Hazard Activity Item <span class="error"> * </span></label>
	<?php
	$editIncicat = postData($getWpidatas, 'HZRDA_CHKL_NAME');
	$catName = [
	    'name' => 'hachklst',
	    'id' => 'hachklst',
	    'class' => 'form-control',
	    'placeholder' => 'Enter hazard activities item',
	    'value' => $editIncicat,
	];
	echo form_input($catName);
	?>
        <label class="error" id="hachklst_error">

        </label>
    </div>
</div>
<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('hac_id', $editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
	$("#hai-form").validate({
	    rules: {		

		"hachklst": {
		    required: true,
		    descrptns: true,
		    maxlength: 200,
		    minlength: 3,

		}

	    },
	    messages: {

		"hachklst": {
		    required: "Hazard activities item is required",

		}
	    },
	    submitHandler: function (form) {
		var formDatas = $(form).serialize();
		var url = "<?php echo BASE_URL('ptw/masters/savehai') ?>";
		var datas = formDatas;
		$.ajax({
		    type: 'ajax',
		    dataType: 'json',
		    method: 'post',
		    data: datas,
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

