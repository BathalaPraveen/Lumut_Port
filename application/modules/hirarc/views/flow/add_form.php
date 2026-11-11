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
                                    <h4>ADD HIRARC</h4>
                                    <a href="<?php echo BASE_URL('hirarc/hirarc') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $gethazid = isset($gethirarcdatas->MAIN_AUTO_ID) && !empty($gethirarcdatas->MAIN_AUTO_ID) ? $gethirarcdatas->MAIN_AUTO_ID : '';
                                ?>
                                <?php echo form_open('hirarc/hirarc/save_hirarc/' . encryptval($gethazid), 'class="form-horizontal" id="hirarc_submit" novalidate'); ?>

                                <div class="emplDet m-t-10">
                                    <div class="row" >
                                        <div class="col-md-12">
                                            <div class="box-header with-border" >
                                                <h5 class=""> HIRARC </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Company <span class="error">*</span></label>
                                                <?php
                                                $getComId = isset($gethirarcdatas->FK_COMP_ID) && !empty($gethirarcdatas->FK_COMP_ID) ? $gethirarcdatas->FK_COMP_ID : set_value('port[ID_TYPE]');
                                                $compdata = array(
                                                    'id' => 'company_Id',
                                                    'class' => 'form-control select2 ',
                                                    'required' => true,
                                                    'checkselect' => 'select2'
                                                );
                                                echo form_dropdown('company_Id', $getCompanyNamedatas, $getComId, $compdata);
                                                ?>
                                                <span class="error"><?php echo form_error('company_Id') ?></span>
                                            </div>
                                        </div>
                                        <?php 
                                        $cls = 'd-none';
                                        if($gethirarcdatas->OTH_COMP_NAME !='') {
                                            $cls = '';
                                        } else {
                                            $cls = 'd-none';
                                        }
                                        ?>
                                        <div class="col-md-6 cmpny_othr <?php echo $cls; ?>">
                                            <div class="form-group">
                                                <label>Other <span class="error">*</span></label>
                                                <?php
                                                $cMaildatas = [
                                                    'name' => 'other',
                                                    'id' => 'other',
                                                    'class' => 'form-control',
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'value' => isset($gethirarcdatas->OTH_COMP_NAME) && !empty($gethirarcdatas->OTH_COMP_NAME) ? $gethirarcdatas->OTH_COMP_NAME : ''
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <span class="error"><?php echo form_error('other') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Terminal <span class="error">*</span></label>
                                                <?php
                                                $getTerId = isset($gethirarcdatas->FK_TERMINAL_ID) && !empty($gethirarcdatas->FK_TERMINAL_ID) ? $gethirarcdatas->FK_TERMINAL_ID : set_value('FK_TERMINAL_ID');
                                                $termdata = array(
                                                    'id' => 'TER_ID',
                                                    'class' => 'form-control select2 ',
                                                    'required' => true,
                                                    'checkselect' => 'select2'
                                                );
                                                echo form_dropdown('Ter_ID', $geterminalNamedatas, $getTerId, $termdata);
                                                ?>
                                                <label class="error"><?php echo form_error('TER_ID'); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Department <span class="error">*</span></label>
                                                <?php
                                                $getdeprtId = isset($gethirarcdatas->FK_DEPT_ID) && !empty($gethirarcdatas->FK_DEPT_ID) ? $gethirarcdatas->FK_DEPT_ID : set_value('FK_DEPT_ID');
                                                $deptdata = array(
                                                    'id' => 'dept_Id',
                                                    'class' => 'form-control select2 ',
                                                    'required' => true,
                                                    'checkselect' => 'select2'
                                                );
                                                echo form_dropdown('dept_Id', $getDeptNamedatas, $getdeprtId, $deptdata);
                                                ?>
                                                <span class="error"><?php echo form_error('dept_Id') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Process/Location / Activity <span class="error">*</span></label>
                                                <?php
                                                $getProcVal = isset($gethirarcdatas->PRO_ACT_LOC) && !empty($gethirarcdatas->PRO_ACT_LOC) ? $gethirarcdatas->PRO_ACT_LOC : set_value('PRO_ACT_LOC');
                                                $procdata = array(
                                                    'id' => 'pro_Id',
                                                    'class' => 'form-control',
                                                    'required' => true,
                                                    'rows' => 4,
                                                    'cols' => 4,
                                                    'name' => 'pro_name'
                                                );
                                                echo form_textarea($procdata,$getProcVal);
                                                ?>
                                                <span class="error"><?php echo form_error('pro_Id') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Approve By<span class="error">*</span></label>
                                               <?php
                                                $getEmpId = isset($gethirarcdatas->HOD_ID) && !empty($gethirarcdatas->HOD_ID) ? $gethirarcdatas->HOD_ID : set_value('HOD_ID');
                                                $empdata = array(
                                                    'id' => 'emp_Id',
                                                    'class' => 'form-control select2 ',
                                                    'required' => true,
                                                    'checkselect' => 'select2' 
                                                );
                                                echo form_dropdown('emp_Id', $empList, $getEmpId, $empdata);
                                                ?>
                                                <span class="error"><?php echo form_error('emp_Id') ?></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group m-t-10" style="text-align: center;">
                                        <div class="col-sm-offset-2 col-sm-10"> 
                                            <?php
                                            $data = array('id' => 'submit', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Next', 'class' => 'btn btn-primary');
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
    $(document).ready(function () {
        
        $('#company_Id').on('change',function(){
           var cmp_val = $(this).val();
           if(cmp_val == '2') {
               $('.cmpny_othr').removeClass('d-none');
           } else {
               $('.cmpny_othr').addClass('d-none');
           } 
        });
        $.validator.addMethod('alphanumeric', function (value) {
            return /^[A-Za-z1-9 ]*$/.test(value);
        }, "Please Enter only Alphanumeric characters");

        $.validator.addMethod('alphanospace', function (value) {
            return /^[A-Za-z]*$/.test(value);
        }, "Please Enter only Alphabetic characters.No spaces allowed");

        $.validator.addMethod('alphaspace', function (value) {
            return /^[A-Za-z ]*$/.test(value);
        }, "Please Enter only Alphabetic characters");



        $("#hirarc_submit").validate({
            //            ignore: [],
            //            success: function (error) {
            //                error.removeClass("error");
            //            },

            rules: {
                "company_Id": {
                    required: true
                },
                "Ter_ID": {
                    required: true
                },
                "dept_Id": {
                    required: true
                },
                "pro_name": {
                    required: true,
                    alphaspace:true
                },
                "other": {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    alphanumeric: true
                },
                "emp_Id": {
                    required: true
                }
            },
            messages: {
                "company_Id": {
                    required: "Company Name is required" 
                },
                "other": { 
                    required: "Company Name is required",
                    alphaspace: "Special charaters are not allowed"
                },
                "dept_Id": { 
                    required: "Department Name is required"
                },
                "Ter_ID": { 
                    required: "Terminal Name is required"
                },
                "pro_name": {
                    required: "Process/Location/Activity is required"
                },
                "emp_Id": {
                    required: "Employee name is required"
                }
            },
            errorPlacement: function (error, element) {

                if (element.attr('checkSelect') == 'select2') {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                    element.closest(".imgGroup").last().append(error);
                }
            }

        });
    });
</script>
