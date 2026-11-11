<?php
$editId = postData($getppeidatas, 'PPEI_ID', '');
$formTitle = ($editId != "") ? 'Edit Personal Protective Equipment Item' : 'Add Personal Protective Equipment Item';
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
echo form_open('#', 'class="form-horizontal" id="ppei-form" novalidate')
?>
<!-- Modal body -->
<div class="modal-body">

    <div class="form-group">
        <label for="category"> Category <span class="error"> * </span></label>
	<?php
	$edittype = postData($getppeidatas, 'REF_PPEC_ID');
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
	$editIncicat = postData($getppeidatas, 'PPEI_NAME');
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
    <div class="form-group">
        <label for="mandatecklist"> Mandatory <span class="error"> * </span></label>        
	<?php
	$hascheck = postData($getppeidatas, 'PPEI_MANDATE');
	$yjs = array('id' => 'haschky');
	$njs = array('id' => 'haschkn');
	$checkedyes = ($hascheck == 'Y') ? TRUE : FALSE;
	$checkedno = ($hascheck == 'N') ? TRUE : FALSE;
	echo form_radio('mandate', 'Y', $checkedyes, $yjs);
	echo '<label for="haschky"> Yes</label>';
	echo form_radio('mandate', 'N', $checkedno, $njs);
	echo '<label for="haschkn"> No</label>';
	?>
        

        
    </div>
    <span class="error" id="hasChecklist_error"></span>
</div>
<!-- Modal footer -->
<div class="modal-footer justify-content-center">
    <?php echo form_hidden('ppei_id', $editId); ?>
    <button type="submit" class="btn btn-primary ">Submit</button>
</div>
<?php form_close(); ?>

<script type="text/javascript">

    $(document).ready(function () {
	$("#ppei-form").validate({
	    rules: {		
		"category": {
		    required: true
		},
		"itemname": {
		    required: true,
		    descrptns: true,
		    maxlength: 50,
		    minlength: 3,

		},
		"mandate": {
		    required: true
		}

	    },
             errorPlacement: function (error, element) {
               
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('span'));
                }else if (element.attr('name') == 'mandate') {
                    error.appendTo('span#hasChecklist_error');
                    
                } else {
                    error.insertAfter(element);
                }

            },
	    messages: {
		"category": {
		    required: "Category is required",
		},
		"itemname": {
		    required: "Item Name is required",
		},
		"mandate": {
		    required: "Mandatory is required",
		}
	    },
	    submitHandler: function (form) {
		var formDatas = $('form').serialize();
		var url = "<?php echo BASE_URL('ptw/masters/saveppei') ?>";
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

