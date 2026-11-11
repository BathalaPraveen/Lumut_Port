<?php
$editId = postData($getAOCdatas, 'CLS_ID', '');
$formTitle = ($editId != "" ) ? 'Edit Area of Classification' : 'Add Area of Classification';
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
echo form_open('#', 'class="form-horizontal" id="aoc-form" novalidate')
?>
<!-- Modal body -->
<div class="modal-body">

    <div class="form-group">
        <label for="cls_title"> Area of Classification <span class="error"> * </span></label>
	<?php
	$editIncicat = postData($getAOCdatas, 'CLS_NAME');
	$catName = [
	    'name' => 'cls_title',
	    'id' => 'cls_title',
	    'class' => 'form-control',
	    'placeholder' => 'Enter Area of Classification',
	    'value' => $editIncicat,
	];
	echo form_input($catName);
	?>
        <label class="error" id="cls_title_error">

        </label>
    </div>
</div>
<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('cls_id', $editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
	$("#aoc-form").validate({
	    rules: {
		"cls_title": {
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
		"cls_title": {
		    required: "Area of Classification is required",
//		    remote: "This Area of Classification is already entered"
		}
	    },
	    submitHandler: function (form) {
		var formDatas = $('form').serialize();
		var url = "<?php echo BASE_URL('ptw/masters/saveAOC') ?>";
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

