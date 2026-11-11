<?php 

$deptID = postData($getAlldeptDatas,'DEPT_AUTO_ID');
$getdeptUniqID = postData($getAlldeptDatas,'DEPT_ID');
if(!empty($getdeptUniqID)){
    $deptUniqID = $getdeptUniqID;
}else{
    $deptUniqID = $deptUniq;
}
$termID = postData($getAlldeptDatas,'FK_TERMINAL_ID');
$deptName = postData($getAlldeptDatas,'DEPT_NAME');
$mailID = postData($getAlldeptDatas,'DEPT_EMAIL_ID');
$deptDesc = postData($getAlldeptDatas,'DEPT_DESC');
?>
<style>
    .deptBordstyl{
        border: 3px solid #296dc6;
    padding: 10px;
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
                                    <h4>Add Department</h4>
                                    <a href="<?php echo BASE_URL('master/department/department') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>


                            <div class="card-body">
                                
                                <?php 
                                if($deptID != ''){
                                    echo form_open('master/department/insertDepartment/'. encryptval($deptID) , 'class="form-horizontal" id="company-profile" novalidate'); 
                                }else{
                                    echo form_open('master/department/insertDepartment/' , 'class="form-horizontal" id="company-profile" novalidate'); 
                                }
                                ?>
                                <div class="deptBordstyl">
                                <div class="row m-l-10">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Department Id <span class="error"> * </span></label>
                                            <?php
                                            $deprtId = [
                                                'class' => 'form-control',
                                                'value' => $deptUniqID,
                                                'name' => 'dept[dept_uniqid]',
                                                'readonly' => 'readonly',
                                                'id' => 'dept_uniqid',
                                               
                                            ]; 
                                           
                                            echo form_input($deprtId);
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Terminal Name <span class="error"> * </span></label>
                                            <?php
                                            $terNamedatas = [
                                                'class' => 'form-control select2',
                                                'required' => true,
                                                'autocomplete' => 'off',
                                                'id' => 'term_name',
                                                'checkSelect' => 'select2',
                                            ];
                                            echo form_dropdown('dept[term_name]', $dropTermname, $termID, $terNamedatas);
                                            ?>
                                            <span class="error"><?php echo form_error('dept[term_name]') ?></span>
                                       </div>
                                    </div>
         
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                            <label>Department Name <span class="error"> * </span></label>
                                            <?php
                                            $depNamedatas = [
                                                'class' => 'form-control',
                                                'value' => $deptName,
                                                'name' => 'dept[dept_name]',
                                                'id' => 'dept_name',
                                               'required' => true
                                            ]; 
                                           
                                            echo form_input($depNamedatas);
                                            ?>
                                            <span class="error depname_err"><?php echo form_error('dept[dept_name]') ?></span>
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="row m-l-10">
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                            <label>Email ID  </label>
                                            <?php
                                            $mailIddatas = [
                                                'class' => 'form-control',
                                                'value' => $mailID,
                                                'name' => 'dept[mail_id]',
                                                'id' => 'mail_id',
                                            ]; 
                                           
                                            echo form_input($mailIddatas);
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                            <label>Description </label>
                                            <?php
                                            $depDescdatas = [
                                                'class' => 'form-control',
                                                'value' => $deptDesc,
                                                'name' => 'dept[dept_desc]',
                                                'id' => 'dept_desc',
                                                'rows' => 3,
                                                'cols' => 7,
                                            ]; 
                                           
                                            echo form_textarea($depDescdatas);
                                            ?>
                                         </div>
                                    </div>
                                </div>
                                </div>
                               
                                <div class="form-group m-t-10" style="text-align: center;">
                                    <div class="col-sm-offset-2 col-sm-10"> 

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
    $(document).ready(function () {


        $("#company-profile").validate({
            ignore: [],
            success: function (error) {
                error.removeClass("error");
                error.addClass("d-none");
            },

            rules: {
                "dept[dept_name]": {
                    required: true,
                    alphaspace: true,
                    maxlength: 50,
                    minlength: 2
                },
                "dept[term_name]": {
                    required: true
                },
                
                "dept[mail_id]": {
                     email: true
                },
                "dept[dept_desc]": {
                     descrptns: true,
                     maxlength: 250,
                     minlength: 5
                },
                
//              
            },
            messages: {
                "dept[dept_name]": {
                    required: "Department Name is required"
                },
                "dept[term_name]": {
                    required: "Terminal Name is required"
                },
//                "dept[mail_id]": {
//                    required: "Region ID is required"
//                },            
            },
            errorPlacement: function (error, element) {

                if (element.attr('checkSelect') == 'select2') {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                } 
            }

        });

       


    });

</script>

