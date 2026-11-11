<?php
$editId = postData($getWpidatas, 'WPPI_ID', '');
$formTitle = ($editId != "") ? 'Edit Worksite preparation/ precautions Item' : 'Add Worksite preparation/ precautions Item';
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
echo form_open('#', 'class="form-horizontal" id="wppi-form" novalidate')
?>
<!-- Modal body -->
<div class="modal-body">

    <div class="form-group">
        <label for="category"> Category <span class="error"> * </span></label>
	<?php
	$edittype = postData($getWpidatas, 'REF_WPPC_ID');
	$options = $getCatdatas;
	$extra = 'class="form-control" id="category"';
	echo form_dropdown('category', $options, $edittype,$extra);
	?>
        <label class="error" id="category_error">

        </label>
    </div>
    <div class="form-group">
        <label for="itemname"> Item Name <span class="error"> * </span></label>
	<?php
	$editIncicat = postData($getWpidatas, 'WPPI_NAME');
	$catName = [
	    'name' => 'itemname',
	    'id' => 'itemname',
	    'class' => 'form-control',
	    'placeholder' => 'Enter Item Name',
	    'value' => $editIncicat,
	];
	echo form_input($catName);
	?>
        <label class="error" id="itemname_error">

        </label>
    </div>
</div>
<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('wppi_id', $editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
	$("#wppi-form").validate({
	    rules: {		
		"category": {
		    required: true
		},
		"itemname": {
		    required: true,
		    descrptns: true,
		    maxlength: 50,
		    minlength: 3,

		}

	    },
	    messages: {
		"category": {
		    required: "Category is required",
		},
		"itemname": {
		    required: "Item Name is required",
		    
		}
	    },
	    submitHandler: function (form) {
		var formDatas = $('form').serialize();
		var url = "<?php echo BASE_URL('ptw/masters/savewppi') ?>";
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

