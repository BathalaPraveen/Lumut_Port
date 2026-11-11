<?php
$editId = postData($getATdatas, 'ADD_DOC_ID', '');
$formTitle = ($editId != "") ? 'Edit Document' : 'Add Document';
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
echo form_open('#', 'class="form-horizontal" id="ad-form" novalidate')
?>
<!-- Modal body -->
<div class="modal-body">

    <div class="form-group">
        <label for="cls_title"> Document Category <span class="error"> * </span></label>
	<?php
	$edittype = postData($getATdatas, 'ADD_DOC_CATEGORY');
	$options = array(
	    'NORMAL' => 'Normal',
	    'CRITICAL' => 'Critical'
	);
	$extra = 'class="form-control" id="doc_cat"';
	echo form_dropdown('doccat', $options, $edittype,$extra);
	?>
        <label class="error" id="doccat_error">

        </label>
    </div>
    <div class="form-group">
        <label for="cls_title"> Document Type <span class="error"> * </span></label>
	<?php
	$edittype = postData($getATdatas, 'ADD_DOC_PTW_TYPE');
	$options = array(
	    'LMT' => 'LMT',
	    'LBT' => 'LBT',
	    'BOTH' => 'BOTH'
	);
	$extra = 'class="form-control" id="docptw_type"';
	echo form_dropdown('docptwtype', $options, $edittype,$extra);
	?>
        <label class="error" id="docptwtype_error">

        </label>
    </div>
    <div class="form-group">
        <label for="ha_title"> Document Name <span class="error"> * </span></label>
	<?php
	$editIncicat = postData($getATdatas, 'ADD_DOC_NAME');
	$catName = [
	    'name' => 'docname',
	    'id' => 'docname',
	    'class' => 'form-control',
	    'placeholder' => 'Enter Document Name',
	    'value' => $editIncicat,
	];
	echo form_input($catName);
	?>
        <label class="error" id="hatitle_error">

        </label>
    </div>
</div>
<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('doc_id', $editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
	$("#ad-form").validate({
	    rules: {		
		"doc_type": {
		    required: true
		},
		"docptw_type": {
		    required: true
		},
		"docname": {
		    required: true,
		    descrptns: true,
		    maxlength: 50,
		    minlength: 3,
//		    remote: {
//			url: "<?php echo BASE_URL('ptw/masters/checkAOC') ?>",
//			type: "get",
//			data:{editId:<?php echo $editId; ?>}
//		    }
		}

	    },
	    messages: {
		"doc_type": {
		    required: "Document Category is required"
		},
		"docptw_type": {
		    required: "Document Type is required"
		},
		"docname": {
		    required: "Document Name is required",
		    descrptns: "Document Name can contain only alphabets, numbers, space and special characters(/,.())"
		}
	    },
	    submitHandler: function (form) {
		var formDatas = $('form').serialize();
		var url = "<?php echo BASE_URL('ptw/masters/saveAT') ?>";
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

