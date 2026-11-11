<style>
   
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

                        <div class="card card-headprimary">
                            <div class="row headingStyl">
                                <div class="col-md-12">
                                    <h4>ADD EMPLOYEE</h4>
                                    <a href="<?php echo BASE_URL('master/employee') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>
                            
                               


                            <div class="card-body">
                                 <?php echo form_open_multipart('master/employee/insertEmployee', 'class="form-horizontal" id="company-profile" novalidate'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class="">  Basic Details </h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">
                                    <div class="row m-t-10 m-l-10">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Employee No <span class="error"> * </span></label>
                                                <?php
                                                $emNumdatas = [
                                                    'name' => 'emp[emp_no]',
                                                    'class' => 'form-control',
                                                    'value' => '',
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Employee ID',
                                                ];
                                                echo form_input($emNumdatas);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[emp_no]') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Employee Name <span class="error"> * </span></label>
                                                <?php
                                                $emNamedatas = [
                                                    'name' => 'emp[emp_name]',
                                                    'id' => 'emp_name',
                                                    'class' => 'form-control',
                                                    'value' => '',
                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Employee Name',
                                                ];
                                                echo form_input($emNamedatas);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[emp_name]') ?></span>
                                            </div>
                                        </div>
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Gender <span class="error"> * </span></label>
                                                <?php
                                                $eGenddata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'gender',
                                                    'checkSelect' => 'select2',
                                                ];
                                                echo form_dropdown('emp[gender]', $dropGender, '', $eGenddata);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[gender]') ?></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row m-t-10 m-l-10">
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Nationality <span class="error"> * </span></label>
                                                <?php
                                                $eNatndata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'nationality',
                                                    'checkSelect' => 'select2',
                                                ];
                                                echo form_dropdown('emp[nationality]', $dropNation, '', $eNatndata);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[nationality]') ?></span>
                                            </div>
                                        </div>
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Designation <span class="error"> * </span></label>
                                                <?php
                                                $eDesigdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'desig',
                                                    'checkSelect' => 'select2',
                                                ];
                                                echo form_dropdown('emp[desig]', $dropdesignation, '', $eDesigdata);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[desig]') ?></span>
                                            </div>
                                        </div>
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Department <span class="error"> * </span></label>
                                                <?php
                                                $eDeptdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'depart',
                                                    'checkSelect' => 'select2',
                                                ];
                                                echo form_dropdown('emp[depart]', $dropDepart, '', $eDeptdata);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[depart]') ?></span>
                                            </div>
                                        </div>
                                        
                                         

                                    </div>

                                    <div class="row m-l-10">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Terminal <span class="error"> * </span></label>
                                                <?php
                                                $eLoctdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'location',
                                                    'checkSelect' => 'select2',
                                                ];
                                                echo form_dropdown('emp[location]', $dropTermname, '', $eLoctdata);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[location]') ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Email ID </label>
                                                <?php
                                                $emMaildatas = [
                                                    'name' => 'emp[emp_mail]',
                                                    'id' => 'emp_mail',
                                                    'class' => 'form-control',
                                                    'value' => '',
//                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Mail ID',
                                                ];
                                                echo form_input($emMaildatas);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[emp_mail]') ?></span>
                                            </div>
                                        </div>
          
                                    </div>
                                  
                                </div>
                                 <?php echo form_close(); ?>
                           
                            </div>
                            
                            <div class="card-body">
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class="">  Competency Details </h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">
                                    <div class="row m-t-10 m-l-10">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Competency Certificate Name</label>
                                                <?php
                                                $emCertnamedatas = [
                                                    'name' => 'emp[compCerti_name]',
                                                    'id' => 'compCerti_name',
                                                    'class' => 'form-control',
                                                    'value' => '',
//                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Certificate Name',
                                                ];
                                                echo form_input($emCertnamedatas);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[compCerti_name]') ?></span>
                                            </div>
                                        </div>
                                       
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Start Date </label>
                                               <?php
                                                $emCertnamedatas = [
                                                    'name' => 'emp[start_date]',
                                                    'id' => 'compCerti_name',
                                                    'class' => 'form-control singledaterangepicker',
                                                    'value' => '',
//                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                 ];
                                                echo form_input($emCertnamedatas);
                                                ?>
                                             </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>End Date </label>
                                               <?php
                                                $emCertnamedatas = [
                                                    'name' => 'emp[end_date]',
                                                    'id' => 'compCerti_name',
                                                    'class' => 'form-control singledaterangepicker',
                                                    'value' => '',
//                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                ];
                                                echo form_input($emCertnamedatas);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[nationality]') ?></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row m-t-10 m-l-10">
                                        
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Status (Eligible/Not Eligible to apply PTW) </label>
                                                <?php
                                                $eDesigdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'elig_status',
                                                ];
                                                $eliStat = ['' => 'Select Status','1' => 'Eligible','2' => 'Not Eligible'];
                                                echo form_dropdown('emp[elig_status]', $eliStat, '', $eDesigdata);
                                                ?>
                                            </div>
                                        </div>
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Competency Certificate </label>
                                                       <div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important; " data-provides="fileinput" >
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                        <?php
                                                        if ( $insuranceFilepath != '') {
                                                            ?>
                                                            <img src='<?php echo BASE_URL .  $insuranceFilepath ?>' alt='<?php echo $insuranceFilename; ?>' />     
                                                        <?php } ?>
                                                    </div>
                                                    <p class="mini-txt">(pdf,doc,gif, png, jpeg, jpg )</p>
                                                    <div class="file-pop" >                                                    
                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img src='<?php echo BASE_URL("/assets/images/photo.png"); ?>'  style=" width: 30%; "/></span>
                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                            <input type="file" name="competency_certi[]" accept="image/*,.pdf,.doc" required></span>

                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="user_img[]" value="<?php echo  $insuranceFilepath; ?>">
                                        
                                            </div>
                                        </div>
                                        
                                        
                                    </div>

                                </div>
                           

                            </div>
                            <div class="card-body">
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class=""> Other Competency Details </h5>
                                            <span class="btn btn-sm btn-success  float-right"><i class="fa fa-plus-square"></i></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">
                                    <div class="row m-t-10 m-l-10">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Competency Certificate Name</label>
                                                <?php
                                                $emCertnamedatas = [
                                                    'name' => 'emp[oth_compCerti_name]',
                                                    'id' => 'oth_compCerti_name',
                                                    'class' => 'form-control ',
                                                    'value' => '',
//                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Certificate Name',
                                                ];
                                                echo form_input($emCertnamedatas);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[compCerti_name]') ?></span>
                                            </div>
                                        </div>
                                       
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Start Date </label>
                                               <?php
                                                $emCertnamedatas = [
                                                    'name' => 'emp[oth_start_date]',
                                                    'id' => 'compCerti_name',
                                                    'class' => 'form-control singledaterangepicker',
                                                    'value' => '',
//                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                   
                                                ];
                                                echo form_input($emCertnamedatas);
                                                ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>End Date </label>
                                               <?php
                                                $emCertnamedatas = [
                                                    'name' => 'emp[oth_end_date]',
                                                    'id' => 'compCerti_name',
                                                    'class' => 'form-control singledaterangepicker',
                                                    'value' => '',
//                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                  
                                                ];
                                                echo form_input($emCertnamedatas);
                                                ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row m-t-10 m-l-10">
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Competency Certificate </label>
                                                       <div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important; " data-provides="fileinput" >
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                        <?php
                                                        if ( $insuranceFilepath != '') {
                                                            ?>
                                                            <img src='<?php echo BASE_URL .  $insuranceFilepath ?>' alt='<?php echo $insuranceFilename; ?>' />     
                                                        <?php } ?>
                                                    </div>
                                                    <p class="mini-txt">(pdf,doc,gif, png, jpeg, jpg )</p>
                                                    <div class="file-pop" >                                                    
                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img src='<?php echo BASE_URL("/assets/images/photo.png"); ?>'  style=" width: 30%; "/></span>
                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                            <input type="file" name="oth_competency_certi[]" accept="image/*,.pdf,.doc" required></span>

                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="user_img[]" value="<?php echo  $insuranceFilepath; ?>">
                                        
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                    <div class="addMorecompet">
                                        
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
                            
                           
                        </div>

                       
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

</script>
<script type="text/javascript">
    $(document).ready(function () {


        $("#company-profile").validate({
            ignore: [],
            success: function (error) {
                error.removeClass("error");
                error.addClass("d-none");
            },

            rules: {
                "emp[emp_no]": {
                    required: true,
                    alphanumeric: true,
                   
                },
                "emp[emp_name]": {
                    required: true,
                     alphaspace: true,
                    maxlength: 50,
                    minlength: 2
                },
                "emp[Gender]" : {
                    required: true,
                  },
                "emp[nationality]" : {
                    required: true,
                  },
                "emp[desig]" : {
                    required: true,
                  },
                "emp[depart]" : {
                    required: true,
                  },
                "emp[location]" : {
                    required: true,
                  },
                "emp[emp_mail]": {
//                    required: true,
                    email: true

                },


            },
            messages: {
                "emp[emp_no]": {
                    required: "Employee Number is required"
                },
                "emp[emp_name]": {
                    required: "Employee Name is required"
                },
                "emp[Gender]": {
                    required: "Gender is required"
                },
                "emp[nationality]": {
                    required: "Nationality is required"
                },
                "emp[desig]": {
                    required: "Designation is required"
                },
                "emp[depart]": {
                    required: "Department is required"
                },
                "emp[location]": {
                    required: "Terminal is required"
                },

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
