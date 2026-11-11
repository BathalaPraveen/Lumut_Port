<?php
$editId = postData($getAwdatas, 'PPEC_ID', '');
$formTitle = ($editId != "" ) ? 'Edit Personal Protective Equipment Category' : 'Add Personal Protective Equipment Category';
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
echo form_open('#', 'class="form-horizontal" id="ppec-form" novalidate')
?>
<!-- Modal body -->
<div class="modal-body">

    <div class="form-group">
        <label for="cls_title"> Personal Protective Equipment Category <span class="error"> * </span></label>
	<?php
	$editIncicat = postData($getAwdatas, 'PPEC_NAME');
	$catName = [
	    'name' => 'ppec_cat',
	    'id' => 'ppec_cat',
	    'class' => 'form-control',
	    'placeholder' => 'Enter Category',
	    'value' => $editIncicat,
	];
	echo form_input($catName);
	?>
        <label class="error" id="wppc_cat_error">

        </label>
    </div>
</div>
<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('ppec_id', $editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
	$("#ppec-form").validate({
	    rules: {
		"ppec_cat": {
		    required: true,
		    alphaspacewithspecialchar: true,
		    maxlength: 50,
		    minlength: 3,
//		    remote: {
//			url: "<?php echo BASE_URL('ptw/masters/checkAOC') ?>",
//			type: "get",
//			data:{editId:<?php echo $editId;?>}
//		    }
		}

	    },
	    messages: {
		"ppec_cat": {
		    required: "Category is required",
//		    remote: "This Area of Classification is already entered"
		}
	    },
	    submitHandler: function (form) {
		var formDatas = $('form').serialize();
		var url = "<?php echo BASE_URL('ptw/masters/saveppec') ?>";
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
				$('#' + keys + 'error').html(value);

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

