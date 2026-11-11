<?php
$editId = postData($getProgramdatas, 'HMP_AUTO_ID', 0);
$formTitle = ($editId > 0 ) ? 'Edit Program' : 'Add Program';

$startDate = postData($getProgramdatas, 'HMP_APP_START_DATE',$this->input->post('pro[HMP_START_DATE]'));
$endDate = postData($getProgramdatas, 'HMP_APP_END_DATE',$this->input->post('pro[HMP_END_DATE]'));

$trigger = FALSE;
if($getProgramdatas != FALSE){
    $trigger = TRUE;
    $startDate = ($startDate !='') ? date('d-m-Y', strtotime($startDate)): '';
    $endDate = ($endDate !='') ? date('d-m-Y', strtotime($endDate)): '';
}

$editTerminalId = postData($getProgramdatas, 'HMP_LOC_ID',$this->input->post('pro[HMP_LOC_ID]'));
$editDeptId = postData($getProgramdatas, 'HMP_DEPT_ID',$this->input->post('pro[HMP_DEPT_ID]'));
$editUnitHeadId = postData($getProgramdatas, 'HMP_UNIT_HEAD_ID',$this->input->post('pro[HMP_UNIT_HEAD_ID]'));
$editExecId = postData($getProgramdatas, 'HMP_EXEC_ID',$this->input->post('pro[HMP_EXEC_ID]'));



$executiveList = getExecutive('drop');
$unitHeadList = getUnitHead('drop');
?>
<style>
    #map {

        height:360px;
        width: 100%;
    }
    .keyContdetails{
        border: 2px solid #1e6dab;
    }

</style>
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class=" content">
            <div class="container-fluid">

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">


                        <!-- general form elements -->
                        <div class="card card-headprimary">
                            <div class="row headingStyl">
                                <div class="col-md-12">
                                    <h4><?php echo $formTitle; ?></h4>
                                    <a href="<?php echo BASE_URL('hmp/hmp/hmpInfo') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>


                            <div class="card-body">
                                <?php
                                $getProid = isset($getProgramdatas->HMP_AUTO_ID) && !empty($getProgramdatas->HMP_AUTO_ID) ? $getProgramdatas->HMP_AUTO_ID : '';
                                ?>
                                <?php echo form_open('hmp/hmp/saveHmp/' . encryptval($getProid), 'class="form-horizontal" id="company-profile" novalidate'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class="">  HSSE Program Detail </h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">

                                    <div class="row m-t-10 m-l-10">
                                        <div class="col-md-4">
                                            
                                                <label>Program ID  <span class="error">*</span></label>
                                                <?php
                                                $AutoId = isset($getProgramdatas->HMP_ID) && !empty($getProgramdatas->HMP_ID) ? $getProgramdatas->HMP_ID : $getAutoId;
                                                $cMaildatas = [
                                                    'name' => 'pro[HMP_ID]',
                                                    'class' => 'form-control',
                                                    'value' => $AutoId,
                                                    'autocomplete' => 'off',
                                                    'readonly' => TRUE
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <label class="error"><?php echo form_error('pro[HMP_ID]') ?></label>
                                           
                                        </div>

                                        <div class="col-md-4">
                                           
                                                <label>Program  Name  <span class="error">*</span></label>
                                                <?php
                                                $getProname = isset($getProgramdatas->HMP_NAME) && !empty($getProgramdatas->HMP_NAME) ? $getProgramdatas->HMP_NAME : set_value('pro[HMP_NAME]');
                                                $cnamedata = array(
                                                    'name' => 'pro[HMP_NAME]',
                                                    'id' => 'HMP_NAME',
                                                    'placeholder' => 'Enter Program Name',
                                                    'class' => 'form-control',
                                                    'value' => $getProname,
                                                    'required' => true,
                                                    'minlength' => 3,
                                                    'maxlength' => 25,
                                                    'autocomplete' => 'off'
                                                );

                                                echo form_input($cnamedata);
                                                ?>
                                                <label class="error"><?php echo form_error('pro[HMP_NAME]') ?></label>
                                          
                                        </div>
                                        <div class="col-md-4">
                                           
                                                <label >Start Date <span class="error">*</span></label><br>
                                                <div>

                                                    <?php
                                                    $data = array(
                                                        'name' => 'pro[HMP_START_DATE]',
                                                        'id' => 'HMP_START_DATE',
                                                        'placeholder' => '',
                                                        'class' => 'form-control',
                                                        'autocomplete' => 'off',
                                                        'value' => $startDate,
                                                    );

                                                    echo form_input($data);
                                                    ?>  
                                                     <label class="error"><?php echo form_error('pro[HMP_START_DATE]') ?></label>
                                                  
                                                   
                                                </div>
                                            
                                        </div>
                                    </div>
                                    <div class="row  m-l-10">
                                        <div class="col-md-4">
                                            
                                                <label >End Date <span class="error">*</span></label><br>
                                                <div>

                                                    <?php
                                                    $data = array(
                                                        'name' => 'pro[HMP_END_DATE]',
                                                        'id' => 'HMP_END_DATE',
                                                        'placeholder' => '',
                                                        'class' => 'form-control',
                                                        'autocomplete' => 'off',
                                                        'value' => $endDate,
                                                    );

                                                    echo form_input($data);
                                                    ?>  
                                                    <label class="error"><?php echo form_error('pro[HMP_END_DATE]') ?></label>
                                                  
                                                   
                                                </div>
                                        
                                        </div>
                                         <div class="col-sm-6">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Program Description <span class="error">*</span></label>
                                                <?php
                                                $getprodesc = isset($getProgramdatas->HMP_DESC) && !empty($getProgramdatas->HMP_DESC) ? $getProgramdatas->HMP_DESC : set_value('pro[HMP_DESC]');
                                                $cAddr1data = array(
                                                    'name' => 'pro[HMP_DESC]',
                                                    'id' => 'HMP_DESC',
                                                    'placeholder' => 'Enter Program Description',
                                                    'class' => 'form-control',
                                                    'value' => $getprodesc,
                                                    'rows' => 4,
                                                    'cols' => 4,
                                                    'autocomplete' => 'off'
                                                );
                                                echo form_textarea($cAddr1data);
                                                ?>
                                                <span class="error"><?php echo form_error('pro[HMP_DESC]') ?></span>
                                            </div>
                                        </div>

                                    </div>
                                    
                                </div>
                                
                                
                                <div class="row m-t-10">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class="">  Location and Department </h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">

                                    <div class="row m-t-10 m-l-10">
                                     <div class="col-md-4">
                                            
                                                <label>Terminal <span class="error"> * </span></label>
                                                <?php
                                                $eLoctdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'location',
                                                    'checkSelect' => 'select2',
                                                    'onchange' => 'getAjaxDepartment(this.value)',
                                                ];
                                                echo form_dropdown('pro[HMP_LOC_ID]', $locationDetails, $editTerminalId, $eLoctdata);
                                                ?>
                                                <span class="error"><?php echo form_error('pro[HMP_LOC_ID]') ?></span>
                                         
                                        </div>

                                        <div class="col-sm-4 m-b-10">
                                            
                                                <label>Department <span class="error"> * </span></label>
                                                <?php
                                                $eDeptdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'depart',
                                                    'checkSelect' => 'select2',
                                                    
                                                ];
                                                echo form_dropdown('pro[HMP_DEPT_ID]', $deptDetails, $editDeptId, $eDeptdata);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[depart]') ?></span>
                                         
                                        </div>
                                        
                                    </div>
                                  
                                    
                                </div>
                                
                                <div class="row m-t-10">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class="">  Employee Detail </h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">

                                    <div class="row m-t-10 m-l-10">
                                     <div class="col-md-4">

                                                <label>Unit Head <span class="error"> * </span></label>
                                                <?php
                                                $unitdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'HMP_UNIT_HEAD_ID',
                                                    'checkSelect' => 'select2'
                                                ];
                                                echo form_dropdown('pro[HMP_UNIT_HEAD_ID]', $unitHeadList, $editUnitHeadId, $unitdata);
                                                ?>
                                                <span class="error"><?php echo form_error('pro[HMP_LOC_ID]') ?></span>
                                         
                                        </div>

                                        <div class="col-sm-4 m-b-10">
                                            
                                                <label>Executive <span class="error"> * </span></label>
                                                <?php
                                                $exedata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'HMP_EXEC_ID',
                                                    'checkSelect' => 'select2',
                                                    
                                                ];
                                                echo form_dropdown('pro[HMP_EXEC_ID]', $executiveList, $editExecId, $exedata);
                                                ?>
                                                <span class="error"><?php echo form_error('pro[HMP_EXEC_ID]') ?></span>
                                         
                                        </div>
                                        
                                    </div>
                                  
                                    
                                </div>
                                
                              
                                <div class="form-group m-t-10" style="text-align: center;">
                                    <div class="col-sm-offset-2 col-sm-12"> 

                                        <?php
                                        $data = array('id' => 'submit', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SUBMIT', 'class' => 'btn btn-primary');
                                        echo form_button($data);
                                        ?>
                                    </div>
                                </div>

                                <!-- input states -->
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->
<script type="text/javascript">
    function getAjaxDepartment(id) {
        var url = "<?php echo BASE_URL('common/getAjaxDepartment') ?>";
        var data = {terminalID: id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
        $.ajax({
            dataType: 'json',
            data: 'ajax',
            method: 'post',
            data: data,
            url: url,
            success: function (resp) {
                $("#depart").html(resp.deptdatas)
            }
        });
      
    }
    
    $(document).ready(function () {
        $("#HMP_START_DATE").datepicker({
	    autoclose: true,
            //startDate: new Date(),
            format: 'dd-mm-yyyy'
	}).on('changeDate', function (selected) {
            
	    var minDate = new Date(selected.date.valueOf());
	     $('#HMP_END_DATE').datepicker('setStartDate', minDate);

	});
        $("#HMP_END_DATE").datepicker({
	    autoclose: true,
            startDate: new Date(),
            format: 'dd-mm-yyyy'
	}).on('changeDate', function (selected) {
	    var minDate = new Date(selected.date.valueOf());
	    
	});
        
 

        $.validator.addMethod('alphanumeric', function (value) {
             return /^[A-Za-z0-9/,.  ]*$/.test(value);
}, "Please Enter valid Alphanumeric characters with allowed special charters are /,.");


        $.validator.addMethod('accept_address', function (value) {
            return /^[a-zA-Z0-9\/\\n\s,.'-_*()+&^$#@!% ]{1,}$/.test(value);
        }, "Please Enter a valid address");
     
        $("#company-profile").validate({
            ignore: [],
            success: function (error) {
                error.removeClass("error");
                error.addClass("d-none");
            },

            rules: {

                "pro[HMP_ID]": {
                    required: true
                },
                "pro[HMP_NAME]": {
                    required: true,
                    minlength: 2,
                    maxlength: 255,
                   // programming_char:true
                },
                "pro[HMP_START_DATE]": {
                    required: true
                },
                "pro[HMP_END_DATE]": {
                    required: true
                },
                "pro[HMP_LOC_ID]": {
                    required: true
                },
                "pro[HMP_DEPT_ID]": {
                    required: true
                },
                "pro[HMP_UNIT_HEAD_ID]": {
                    required: true
                },
                "pro[HMP_EXEC_ID]": {
                    required: true
                },
               
                "pro[HMP_DESC]": {
                    required: true,
                    accept_address: true,
                    minlength: 2,
                   // programming_char:true
                },
            },
            messages: {
                "pro[HMP_ID]": {
                    required: "Program ID is required"
                },
                "pro[HMP_NAME]": {
                    required: "Program Name is required"
                },
                "pro[HMP_START_DATE]": {
                    required: "Program Start Date is required"
                },
                "pro[HMP_END_DATE]": {
                    required: "Program End Date is required"
                },
                "pro[HMP_LOC_ID]": {
                    required: "Terminal is required"
                },
                "pro[HMP_DEPT_ID]": {
                    required: "Department is required"
                },
                "pro[HMP_UNIT_HEAD_ID]": {
                    required: "Unit Head is required"
                },
                "pro[HMP_EXEC_ID]": {
                    required: "Executive is required"
                },
                "pro[HMP_DESC]": {
                    required: "Program Description is required"
                },
            },
            errorPlacement: function (error, element) {

                if (element.attr('checkSelect') == 'select2') {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                    element.closest(".imgGroup").last().append(error);
                }
            },
            submitHandler: function (form) {
                swal({
                    title: "Please wait..",
                    imageUrl: loadingImg,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                form.submit();
            }

        });
    });
</script>
