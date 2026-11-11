<style>
    #map {

        height:360px;
        width: 100%;
    }
    .keyContdetails{
        border: 2px solid #1e6dab;
    }
    .addMorcerti{
        margin-top: -31px;
        margin-right: 10px;
    }
     .othercertiDet{
        border: 3px solid #f3b908;
        padding: 10px;
        margin-top: 10px;
        margin-bottom: 10px;
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
                                    <h4>ADD PORT SECURITY ACCESS</h4>
                                    <a href="<?php echo BASE_URL('psa/portsecurity') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>
                            
                            <?php
                                $gethazid = isset($getPsadatas->AUTO_ID) && !empty($getPsadatas->AUTO_ID) ? $getPsadatas->AUTO_ID : '';
                                ?>
                                <?php echo form_open_multipart('psa/portsecurity/savepsa/' . encryptval($gethazid), 'class="form-horizontal" id="port_submit" novalidate'); ?>

                            <div class="card-body">
                                
                                <div class="emplDet m-t-10">
                                    <div class="row" >
                                        <div class="col-md-12">
                                            <div class="box-header with-border" >
                                                <h5 class=""> Port Security Access </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12  m-t-10">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Unique Id <span class="error">*</span></label>
                                                <?php
                                                $cMaildatas = [
                                                    'name' => 'port[PORT_UNQ_ID]',
                                                    'id' => 'PORT_UNQ_ID',
                                                    'class' => 'form-control',
                                                    'readonly' => true,
                                                    'autocomplete' => 'off',
                                                    'value' => isset($getPsadatas->PORT_UNQ_ID) && !empty($getPsadatas->PORT_UNQ_ID) ? $getPsadatas->PORT_UNQ_ID : $portUniqId
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Name <span class="error">*</span></label>
                                                <?php
                                                $cMaildatas = [
                                                    'name' => 'port[NAME]',
                                                    'id' => 'NAME',
                                                    'class' => 'form-control',
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'value' => isset($getPsadatas->NAME) && !empty($getPsadatas->NAME) ? $getPsadatas->NAME : ''
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <span class="error"><?php echo form_error('port[name]') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>ID Type <span class="error">*</span></label>
                                                <?php
                                                $getTerId = isset($getPsadatas->ID_TYPE) && !empty($getPsadatas->ID_TYPE) ? $getPsadatas->ID_TYPE : set_value('port[ID_TYPE]');
                                                $termdata = array(
                                                    'id' => 'port[ID_TYPE]',
                                                    'class' => 'form-control select2 ',
                                                    'required' => true,
                                                    'checkselect' => 'select2'
                                                );
                                                echo form_dropdown('port[ID_TYPE]', $idTypeData, $getTerId, $termdata);
                                                ?>
                                                <label class="error"><?php echo form_error('port[ID_TYPE]'); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>IC/Passport No <span class="error">*</span></label>
                                                <?php
                                                $cMaildatas = [
                                                    'name' => 'port[PASS_NO]',
                                                    'id' => 'PASS_NO',
                                                    'class' => 'form-control',
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'value' => isset($getPsadatas->PASS_NO) && !empty($getPsadatas->PASS_NO) ? $getPsadatas->PASS_NO : ''
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <span class="error"><?php echo form_error('port[PASS_NO]') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Company Name <span class="error">*</span></label>
                                                <?php
                                                $cMaildatas = [
                                                    'name' => 'port[COMP_NAME]',
                                                    'id' => 'COMP_NAME',
                                                    'class' => 'form-control',
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'value' => isset($getPsadatas->COMP_NAME) && !empty($getPsadatas->COMP_NAME) ? $getPsadatas->COMP_NAME : ''
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <span class="error"><?php echo form_error('port[COMP_NAME]') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Designation<span class="error">*</span></label>
                                                <?php
                                                $cMaildatas = [
                                                    'name' => 'port[DESIG]',
                                                    'id' => 'DESIG',
                                                    'class' => 'form-control',
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'value' => isset($getPsadatas->DESIG) && !empty($getPsadatas->DESIG) ? $getPsadatas->DESIG : ''
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <span class="error"><?php echo form_error('port[DESIG]') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Terminal <span class="error">*</span></label>
                                                <?php
                                                $getTerId = isset($getPsadatas->TERMIN_ID) && !empty($getPsadatas->TERMIN_ID) ? $getPsadatas->TERMIN_ID : set_value('port[TERMIN_ID]');
                                                $termdata = array(
                                                    'id' => 'TERMIN_ID',
                                                    'class' => 'form-control select2 ',
                                                    'required' => true,
                                                    'checkselect' => 'select2'
                                                );
                                                echo form_dropdown('port[TERMIN_ID]', $geterminalNamedatas, $getTerId, $termdata);
                                                ?>
                                                <label class="error"><?php echo form_error('port[TERMIN_ID]'); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Induction Date<span class="error">*</span></label>
                                                <?php
                                                $cMaildatas = [
                                                    'name' => 'port[IND_DATE]',
                                                    'id' => 'IND_DATE',
                                                    'class' => 'form-control datepicker ',
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'value' => isset($getPsadatas->IND_DATE) && !empty($getPsadatas->IND_DATE) ? convertDate($getPsadatas->IND_DATE,'d-m-Y') : ''
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <span class="error"><?php echo form_error('port[IND_DATE]') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Induction Due Date<span class="error">*</span></label>
                                                <?php
                                                $cMaildatas = [
                                                    'name' => 'port[IND_DUE_DATE]',
                                                    'id' => 'IND_DUE_DATE',
                                                    'class' => 'form-control datepicker',
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'value' => isset($getPsadatas->IND_DUE_DATE) && !empty($getPsadatas->IND_DUE_DATE) ? convertDate($getPsadatas->IND_DUE_DATE,'d-m-Y') : ''
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <span class="error"><?php echo form_error('port[IND_DUE_DATE]') ?></span>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            
                            <div class="card-body othCompdetl">
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border emplBorder" >
                                            <h5 class=""> Other Competency Details </h5>
                                            <span class="btn btn-xs btn-success  float-right addMorcerti"><i class="fa fa-plus-square"> Add More</i></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">
                                    
                                    <?php
                                   
                                    if(isset($getOthercertdet) && !empty($getOthercertdet)){ 
                                        foreach($getOthercertdet as $othKey => $othVal){
                                            $certiRowval = $othKey+1;
                                            $othCertiID = postData($othVal,'COMP_CERT_ID');
                                            $othCertiname = postData($othVal,'CERT_NAME');
                                            $othCertistartdate = date('d-m-Y',strtotime($othVal->CERT_START_DATE));
                                            $othCertienddate = date('d-m-Y',strtotime($othVal->CERT_END_DATE));
                                       
                                            $emplotherCertpath = postData($othVal,'CERT_PATH');
                                            $emplotherCertimgname = postData($othVal,'CERT_FILE_NAME');
                                             $emplotherCertimgext = postData($othVal,'CERT_EXT');

                                            if($emplotherCertimgname != ''){
                                                $compotherCertFilepath = $emplotherCertpath.$emplotherCertimgname;
                                            }else{
                                                $compotherCertFilepath = '';
                                            }
                                            
                                            ?>
                                    
                                    <div class="othercertiDet" certiRow-id="<?php echo $certiRowval; ?>">
                                    <span class="float-right removeCerti" removeCerti-ID="<?php echo $othCertiID; ?>"><i class="fa fa-trash"></i></span>
                                        <div class="row m-t-10 m-l-10" >
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="hidden" name="certi[<?php echo $certiRowval; ?>][other_compCerti_ID]" value="<?php echo $othCertiID; ?>">
                                                <label>Competency Certificate Name</label>
                                                <?php
                                                $emCertnamedatas = [
                                                    'name' => 'certi['.$certiRowval.'][oth_compCerti_name]',
                                                    'id' => 'oth_compCerti_name_'.$certiRowval,
                                                    'class' => 'form-control oth_compCerti_name',
                                                    'value' => $othCertiname,
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
                                                    'name' => 'certi['.$certiRowval.'][oth_start_date]',
                                                    'id' => 'oth_compCerti_startdate_'.$certiRowval,
                                                    'class' => 'form-control singledaterangepicker',
                                                    'value' => $othCertistartdate,
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
                                                    'name' => 'certi['.$certiRowval.'][oth_end_date]',
                                                    'id' => 'oth_compCerti_enddate_'.$certiRowval,
                                                    'class' => 'form-control singledaterangepicker',
                                                    'value' => $othCertienddate,
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
                                                        if ( $compotherCertFilepath != '') {
                                                            if($emplotherCertimgext != '' && $emplotherCertimgext != '.pdf'){ ?>
                                                                <img src='<?php echo BASE_URL .  $compotherCertFilepath ?>' alt='<?php echo $emplotherCertimgname; ?>' style="height: 100%;"/>     
                                                          <?php  }else{ ?>
                                                                <iframe src='<?php echo BASE_URL .  $compotherCertFilepath ?>'></iframe>
                                                          <?php  }
                                                            ?>
                                                        
                                                            
                                                        <?php } ?>
                                                    </div>
                                                    <p class="mini-txt">(pdf,gif, png, jpeg, jpg )</p>
                                                    <div class="file-pop" >                                                    
                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img src='<?php echo BASE_URL("/assets/images/photo.png"); ?>' class="imgupload"  style=" width: 30%; "/></span>
                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                            <input type="file" name="oth_competency_certi[]"  accept="image/*,application/pdf" class="compFile"></span>

                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="other_user_img[]" value="<?php echo  $compotherCertFilepath; ?>">
                                        
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                       
                                        </div>
                                    
                                    <?php } }else{ ?>
                                    
                                    <div class="othercertiDet" certiRow-id="1">
                                         <span class="float-right removeCerti"><i class="fa fa-trash removeCerti"></i></span>
                                    <div class="row m-t-10 m-l-10" >
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Competency Certificate Name</label>
                                                <?php
                                                $emCertnamedatas = [
                                                    'name' => 'certi[1][oth_compCerti_name]',
                                                    'id' => 'oth_compCerti_name_1',
                                                    'class' => 'form-control oth_compCerti_name',
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
                                                    'name' => 'certi[1][oth_start_date]',
                                                    'id' => 'oth_compCerti_startdate_1',
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
                                                    'name' => 'certi[1][oth_end_date]',
                                                    'id' => 'oth_compCerti_enddate_1',
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
                                                            <img src='<?php echo BASE_URL .  $insuranceFilepath ?>' alt='<?php echo $insuranceFilename; ?>' style="height: 100%;"/>     
                                                        <?php } ?>
                                                    </div>
                                                    <p class="mini-txt">(pdf,gif, png, jpeg, jpg )</p>
                                                    <div class="file-pop" >                                                    
                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img src='<?php echo BASE_URL("/assets/images/photo.png"); ?>' class="imgupload"  style=" width: 30%; "/></span>
                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                            <input type="file" name="oth_competency_certi[]"  accept="image/*,application/pdf" class="compFile"></span>

                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="other_user_img[]" value="<?php echo  $insuranceFilepath; ?>">
                                        
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                        
                                        </div>
                                    
                                    <?php } ?>
                                    
                                    <div class="addMorecompet ">
                                        
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
        $(".datepicker").datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy',
                    orientation: "bottom",
                   // startDate: new Date()
                });
        $.validator.addMethod('alphanumeric', function (value) {
            return /^[A-Za-z0-9 ]*$/.test(value);
        }, "Please Enter only Alphanumeric characters");

        $.validator.addMethod('alphanospace', function (value) {
            return /^[A-Za-z]*$/.test(value);
        }, "Please Enter only Alphabetic characters.No spaces allowed");

        $.validator.addMethod('alphaspace', function (value) {
            return /^[A-Za-z ]*$/.test(value);
        }, "Please Enter only Alphabetic characters");

        $.validator.addMethod('filesize', function (value, element, param) {
           
            return this.optional(element) || (Math.round(element.files[0].size / (1024 * 1024)) <= 5)
        }, 'File size must be less than 5MB');

        $.validator.addClassRules("compFile", {
//            accept: "png|jpe?g|gif",
            required: false,
            filesize : true
        });


        $("#port_submit").validate({
            //            ignore: [],
            //            success: function (error) {
            //                error.removeClass("error");
            //            },

            rules: {
                "port[NAME]": {
                    required: true,
                    alphaspace: true,
                    minlength: 3,
                    maxlength: 100
                },
                "port[ID_TYPE]": {
                    required: true
                },
                "port[PASS_NO]": {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                "port[COMP_NAME]": {
                    required: true,
                    minlength: 3,
                    maxlength: 200,
                    alphaspace: true
                },
                "port[DESIG]": {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                    alphaspace: true
                },
                "port[TERMIN_ID]": {
                    required: true
                },
                "port[IND_DATE]": {
                    required: true
                },
                "port[IND_DUE_DATE]": {
                    required: true
                }
            },
            messages: {
                "port[NAME]": {
                    required: "Name is required",
                     alphaspace: "only alphabets are allowed"
                },
                "port[COMP_NAME]": {
                    required: "Company Name is required",
                    alphaspace: "only alphabets are allowed"
                },
                "port[PASS_NO]": {
                    required: "IC/Passport No is required"
                },
                "port[ID_TYPE]": {
                    required: "Id Type is required"
                },
                "port[TERMIN_ID]": {
                    required: "Terminal is required"
                },
                "port[DESIG]": {
                    required: "Designation is required",
                    alphaspace: "only alphabets are allowed"
                },
                "port[IND_DATE]": {
                    required: "Induction Date is required"
                },
                "port[IND_DUE_DATE]": {
                    required: "Induction Due Date is required"
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
        
         $.validator.addClassRules("oth_compCerti_name", {
//            alphaspace: true,
            alphaspacewithspecialchar: true,
            maxlength: 50,
            minlength: 2
        });

    
        $(".addsubtyp").on("click", function (e) {
            e.preventDefault();
            var html = '';
            var rowID = $('.row').last().attr('row-id');
            var finalRowid = parseInt(rowID) + 1;
            html = '<div class="row m-t-10 m-l-10 remRowid" id="remRowid_' + finalRowid + '" row-id="' + finalRowid + '">\n\
                        <div class="col-sm-11">\n\
                                        <div class="form-group">\n\
                                            <input type="text" name="risk[contr_name][]" value="" id="hazId_' + finalRowid + '" class="form-control" required autocomplete="off" >\n\
                                            <span class="error"></span>\n\
                                        </div>\n\
                                    </div>\n\
<div class="col-md-1 trashRem" id="trash_' + finalRowid + '" trash-id="' + finalRowid + '">\n\
<i class="fa fa-trash"></i>\n\
</div>\n\
                    </div>';
            $(".newSubtypes").append(html)
        });

        $(document).on('click', ".trashRem", function () {
            var trashId = $(this).attr("trash-id");
            var count = $(".emplDet").find('.remRowid').length;
            if (count != 1) {
                $("#remRowid_" + trashId).remove();
            } else {
                swal('Sorry', 'Atleast one Existing Risk Control is required', 'error');
            }
        });
        
        $(document).on('click','.addMorcerti',function(){
       
        var baseUrl = '<?php echo BASE_URL; ?>'
       var lastCerti = $(this).parents().eq(2).next().find(".othercertiDet").last().attr("certiRow-id");
      
       var newCertirow = parseInt(lastCerti)+1;
        var html = '<div class="othercertiDet" certiRow-id="'+newCertirow+'"> <span class="float-right removeCerti"><i class="fa fa-trash"></i></span>\n\
                            <div class="row m-t-10 m-l-10">\n\
                                        <div class="col-sm-4">\n\
                                            <div class="form-group">\n\
                                                <label>Competency Certificate Name</label>\n\
                                                <input type="text" name="certi['+newCertirow+'][oth_compCerti_name]" value="" id="oth_compCerti_name_'+newCertirow+'" class="form-control oth_compCerti_name" autocomplete="off" placeholder="Enter Certificate Name">\n\
                                                <span class="error"></span>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-sm-4">\n\
                                            <div class="form-group">\n\
                                                <label>Start Date </label>\n\
                                               <input type="text" name="certi['+newCertirow+'][oth_start_date]" value="" id="oth_compCerti_startdate_'+newCertirow+'" class="form-control singledaterangepicker" autocomplete="off">\n\
                                            </div>\n\
                                        </div>\n\
                                        <div class="col-sm-4">\n\
                                            <div class="form-group">\n\
                                                <label>End Date </label>\n\
                                               <input type="text" name="certi['+newCertirow+'][oth_end_date]" value="" id="oth_compCerti_enddate_'+newCertirow+'" class="form-control singledaterangepicker" autocomplete="off">\n\
                                            </div>\n\
                                        </div>\n\
                                        </div>\n\
                                        <div class="row m-t-10 m-l-10">\n\
                                        <div class="col-sm-4">\n\
                                            <div class="form-group">\n\
                                                <label>Competency Certificate </label>\n\
                                                       <div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important; " data-provides="fileinput">\n\
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput"></div><p class="mini-txt">(pdf,gif, png, jpeg, jpg )</p>\n\
                                                    <div class="file-pop"><span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img src="'+baseUrl+'/assets/images/photo.png" class="imgupload" style=" width: 30%; "></span>\n\
                                                            <span class="fileinput-exists" title="Add Image"></span>\n\
                                                            <input type="file" name="oth_competency_certi[]" accept="image/*,application/pdf" class="compFile"></span>\n\
                                                            <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>\n\
                                                    </div>\n\
                                                </div>\n\
                                                <input type="hidden" name="other_user_img[]" value="">\n\
                                            </div>\n\
                                        </div>\n\
                                       </div>\n\
                                     </div>';
                                $(".addMorecompet").append(html);
                                $(".singledaterangepicker").daterangepicker({
            singleDatePicker: true,
            
            locale :{
                format : 'DD-MM-YYYY',
              
            }
        });
        })
        
        $(document).on("click",".removeCerti",function(){
            var certiId = $(this).attr("removeCerti-ID");
            var count = $(".removeCerti").length;
        if(certiId != 'undefined' && certiId != undefined && certiId != ''){
           if(count > 1){
            swal({
                title: "Are you sure You want to Delete it?",
                text: "<b>You will be unable to Recover data</b>",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                closeButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true,
                html: true,
            },
            function (isConfirm) {
                if (isConfirm) {
                    
                var url = "<?php echo BASE_URL('psa/portsecurity/deleteParticularcerti') ?>";
                var data = {certiId: certiId,'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
           
           
                    $.ajax({
                        dataType : 'json',
                        type : 'ajax',
                        method : 'post',
                        data : data,
                        url : url,
                        success : function(resp){
                            if(resp.status == true){
                                swal({
                                    title: "Deleted!",
                                    text: resp.msg,
                                    type: "success",
                                    timer: 3000,
                                 });
//                                swal('Success',resp.msg,'success');
                              }else{
                                swal('Error',resp.msg,'error');
                             }
//                              $(".othCompdetl").load(" .othCompdetl");
                                $(".othCompdetl").load(" .othCompdetl",function(){
                                $(".singledaterangepicker").daterangepicker({
                                    singleDatePicker: true,

                                    locale :{
                                        format : 'DD-MM-YYYY',

                                    }
                                }); 
                        });
                        }
                    })
                }
            })
            }else{
            swal('Sorry','Certificate Details cannot be left empty','warning');
        }
        }else{
            if(count > 1){
                $(this).closest('.othercertiDet').remove();
            }else{
                swal('Sorry','Certificate Details cannot be left empty','warning');
            }
        }
        })
        
    });
</script>
