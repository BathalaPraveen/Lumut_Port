<?php
$cntrID = postData($getProgramdatas, 'REC_AUTO_ID', 0);
$formTitle = ($editId > 0 ) ? 'Edit Record Master' : 'Add Record Master';

$startsDate = postData($getProgramdatas, 'REC_REC_DATE');
$endsDate = postData($getProgramdatas, 'REC_EXP_DATE');



    $startDate = ($startsDate != '') ? date('d-m-Y', strtotime($startsDate)) : '';
    $endDate = ($endsDate != '') ? date('d-m-Y', strtotime($endsDate)) : '';


$editTerminalId = postData($getProgramdatas, 'REC_TER_ID', $this->input->post('pro[REC_TER_ID]'));
?>
<style>
    #map {

        height:360px;
        width: 100%;
    }
    .keyContdetails{
        border: 2px solid #1e6dab;
    }
    .imgupload{
        width: 100%;
        height: 100%;
    }
    .fileinput img{
        width: 100%;
        height: 100%;
    }

</style>
<style>
    .deptBordstyl{
        border: 3px solid #296dc6;
    padding: 10px;
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
    .imgupload{
        width: 100%;
        height: 100%;
    }
    .fileinput img{
        width: 100%;
        height: 100%;
    }
     .emplBorder{
        background-color: #007bff;
    }
    .panel-body{
            border: 2px solid #227bff;
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
                                    <a href="<?php echo BASE_URL('hmp/rec/recInfo') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>


                             <?php 
                             if(!empty($cntrID)){
                                 echo form_open_multipart('hmp/rec/saveRec/'. encryptval($cntrID) , 'class="form-horizontal" id="company-profile" novalidate'); 
                             }else{
                                 echo form_open_multipart('hmp/rec/saveRec/' , 'class="form-horizontal" id="company-profile" novalidate'); 
                             }
                               
                                
                                ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border emplBorder" >
                                            <h5 class=""> Record Master Detail </h5>
                                        </div>

                                    </div>
                                </div>
                               <div class="panel-body col-md-12">

                                    <div class="row m-t-10 m-l-10">
                                        <div class="col-md-4">

                                            <label>Record ID  <span class="error">*</span></label>
                                            <?php
                                            $AutoId = isset($getProgramdatas->REC_ID) && !empty($getProgramdatas->REC_ID) ? $getProgramdatas->REC_ID : $getAutoId;
                                            $cMaildatas = [
                                                'name' => 'pro[REC_ID]',
                                                'class' => 'form-control',
                                                'value' => $AutoId,
                                                'autocomplete' => 'off',
                                                'readonly' => TRUE
                                            ];
                                            echo form_input($cMaildatas);
                                            ?>
                                            <label class="error"><?php echo form_error('pro[REC_ID]') ?></label>

                                        </div>

                                        <div class="col-md-4">

                                            <label>Record  Name  <span class="error">*</span></label>
                                            <?php
                                            $getProname = isset($getProgramdatas->REC_NAME) && !empty($getProgramdatas->REC_NAME) ? $getProgramdatas->REC_NAME : set_value('pro[REC_NAME]');
                                            $cnamedata = array(
                                                'name' => 'pro[REC_NAME]',
                                                'id' => 'REC_NAME',
                                                'placeholder' => 'Enter Record Name',
                                                'class' => 'form-control',
                                                'value' => $getProname,
                                                'required' => true,
                                                'minlength' => 3,
                                                'maxlength' => 25,
                                                'autocomplete' => 'off'
                                            );

                                            echo form_input($cnamedata);
                                            ?>
                                            <label class="error"><?php echo form_error('pro[REC_NAME]') ?></label>

                                        </div>
                                        <div class="col-md-4">

                                            <label>Terminal <span class="error"> * </span></label>
                                            <?php
                                            $eLoctdata = [
                                                'class' => 'form-control select2',
                                                'id' => 'location',
                                                'checkSelect' => 'select2'
                                            ];
                                            echo form_dropdown('pro[REC_TER_ID]', $locationDetails, $editTerminalId, $eLoctdata);
                                            ?>
                                            <span class="error"><?php echo form_error('pro[REC_TER_ID]') ?></span>

                                        </div>
                                        <div class="col-md-4">

                                            <label >Record Date </label><br>
                                            <div>

                                                <?php
                                                $data = array(
                                                    'name' => 'pro[REC_REC_DATE]',
                                                    'id' => 'REC_REC_DATE',
                                                    'placeholder' => '',
                                                    'class' => 'form-control ',
                                                    'autocomplete' => 'off',
                                                    'value' => $startDate,
                                                );

                                                echo form_input($data);
                                                ?>  
                                                <label class="error"><?php echo form_error('pro[REC_REC_DATE]') ?></label>

                                            </div>
                                        </div>
                                        <div class="col-md-4">

                                            <label >Expiry Date </label><br>
                                            <div>

                                                <?php
                                                $data = array(
                                                    'name' => 'pro[REC_EXP_DATE]',
                                                    'id' => 'REC_EXP_DATE',
                                                    'placeholder' => '',
                                                    'class' => 'form-control',
                                                    'autocomplete' => 'off',
                                                    'value' => $endDate,
                                                );

                                                echo form_input($data);
                                                ?>  
                                                <label class="error"><?php echo form_error('pro[REC_EXP_DATE]') ?></label>

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Model Name/No  </label>
                                            <?php
                                            $getmodname = isset($getProgramdatas->REC_MOD_NAME) && !empty($getProgramdatas->REC_MOD_NAME) ? $getProgramdatas->REC_MOD_NAME : set_value('pro[REC_MOD_NAME]');
                                            $cmodnamedata = array(
                                                'name' => 'pro[REC_MOD_NAME]',
                                                'id' => 'REC_MOD_NAME',
                                                'placeholder' => 'Enter Model Name/No',
                                                'class' => 'form-control',
                                                'value' => $getmodname,
                                                'minlength' => 3,
                                                'maxlength' => 25,
                                                'autocomplete' => 'off'
                                            );

                                            echo form_input($cmodnamedata);
                                            ?>
                                            <label class="error"><?php echo form_error('pro[REC_MOD_NAME]') ?></label>

                                        </div>
                                    </div>
                                    <div class="row  m-l-10">


                                        <div class="col-md-4">
                                            <label>Location Detail  </label>
                                            <?php
                                            $getmodlocname = isset($getProgramdatas->REC_LOC_NAME) && !empty($getProgramdatas->REC_LOC_NAME) ? $getProgramdatas->REC_LOC_NAME : set_value('pro[REC_LOC_NAME]');
                                            $cmodlocnamedata = array(
                                                'name' => 'pro[REC_LOC_NAME]',
                                                'id' => 'REC_LOC_NAME',
                                                'placeholder' => 'Enter Location Detail',
                                                'class' => 'form-control',
                                                'value' => $getmodlocname,
                                                'minlength' => 3,
                                                'maxlength' => 25,
                                                'autocomplete' => 'off'
                                            );

                                            echo form_input($cmodlocnamedata);
                                            ?>
                                            <label class="error"><?php echo form_error('pro[REC_LOC_NAME]') ?></label>

                                        </div>
                                        <div class="col-sm-5">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label> Description </label>
                                                <?php
                                                $getprodesc = isset($getProgramdatas->REC_DESC) && !empty($getProgramdatas->REC_DESC) ? $getProgramdatas->REC_DESC : set_value('pro[REC_DESC]');
                                                $cAddr1data = array(
                                                    'name' => 'pro[REC_DESC]',
                                                    'id' => 'REC_DESC',
                                                    'placeholder' => 'Enter Description',
                                                    'class' => 'form-control',
                                                    'value' => $getprodesc,
                                                    'rows' => 4,
                                                    'cols' => 4,
                                                    'autocomplete' => 'off'
                                                );
                                                echo form_textarea($cAddr1data);
                                                ?>
                                                <span class="error"><?php echo form_error('pro[REC_DESC]') ?></span>
                                            </div>
                                        </div>
 <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Notification Alert <span class="error">*</span></label>
                                                <?php
                                                $getNotId = isset($getProgramdatas->REC_NOT) && !empty($getProgramdatas->REC_NOT) ? $getProgramdatas->REC_NOT : set_value('pro[REC_NOT]');
                                                $notdata = array(
                                                    'id' => 'pro[REC_NOT]',
                                                    'class' => 'form-control select2 ',
                                                    'required' => true,
                                                    'checkselect' => 'select2'
                                                );
                                                echo form_dropdown('pro[REC_NOT]', $idTypeData, $getNotId, $notdata);
                                                ?>
                                                <label class="error"><?php echo form_error('pro[REC_NOT]'); ?></label>
                                            </div>
                                        </div>
                                       
                                    </div>


                                  

                                </div>
                                
                                
                            </div>
                            
                          
                            
                            <div class="card-body othCompdetl">
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border emplBorder" >
                                            <h5 class=""> Record Details </h5>
                                            <span class="btn btn-xs btn-success  float-right addMorcerti"><i class="fa fa-plus-square"> Add More</i></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">
                                    
                                    <?php
                                   
                                    if(isset($getOthercertdet) && !empty($getOthercertdet)){ 
                                        
                                        foreach($getOthercertdet as $othKey => $othVal){
                                            $certiRowval = $othKey+1;
                                            $othCertiID = postData($othVal,'REC_IMG_ID');
                                           
                                            $emplotherCertpath = postData($othVal,'REC_FILE_PATH');
                                             $emplotherCertimgname = postData($othVal,'REC_FILENAME');
                                             $emplotherCertimgext = postData($othVal,'REC_FILE_EXT');
                                             
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
                                                </div>
                                        </div>
                                       
                                     
                                        
                                        
                                    </div>
                                    
                                    <div class="row m-t-10 m-l-10">
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Document Upload </label>
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
                                         <span class="float-right "><i class="fa fa-trash removeCerti"></i></span>
                                    <div class="row m-t-10 m-l-10" >
                                        <div class="col-sm-4">
                                            <div class="form-group" style="display:none;">
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
                                       
                                     
                                        
                                    </div>
                                    
                                    <div class="row m-t-10 m-l-10">
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Document Upload </label>
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
                                <?php echo form_close(); ?>
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
                            $(document).ready(function(){  
                                $("#REC_REC_DATE").datepicker({
            autoclose: true,
            //   startDate: new Date(),
            format: 'dd-mm-yyyy'
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#REC_EXP_DATE').datepicker('setStartDate', minDate);
        });


        $("#REC_EXP_DATE").datepicker({
            autoclose: true,
            //   startDate: new Date(),
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

        $.validator.addClassRules("atarfile", {
            accept: "pdf,png|jpe?g|gif",
            required: false,
            filesize: true
        });

        $("#company-profile").validate({
            ignore: [],
            success: function (error) {
                error.removeClass("error");
                error.addClass("d-none");
            },
            rules: {

                "pro[REC_ID]": {
                    required: true
                },
                "pro[REC_NAME]": {
                    required: true,
                    minlength: 2,
                    maxlength: 255
                },
                "pro[REC_MOD_NAME]": {
                    
                    minlength: 2,
                    maxlength: 255
                },
                "pro[REC_LOC_NAME]": {
                    
                    minlength: 2,
                    maxlength: 255
                },
                "pro[REC_TER_ID]": {
                    required: true
                },
                "pro[REC_DESC]": {

                  //  accept_address: true,
                    minlength: 2
                },
            },
            messages: {
                "pro[REC_ID]": {
                    required: "Record ID is required"
                },
                "pro[REC_NAME]": {
                    required: "Record Name is required"
                },
                "pro[REC_TER_ID]": {
                    required: "Terminal is required"
                }

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

   
      
 
        $(document).on('click','.addMorcerti',function(){
       
        var baseUrl = '<?php echo BASE_URL; ?>'
       var lastCerti = $(this).parents().eq(2).next().find(".othercertiDet").last().attr("certiRow-id");
      
       var newCertirow = parseInt(lastCerti)+1;
        var html = '<div class="othercertiDet" certiRow-id="'+newCertirow+'"> <span class="float-right removeCerti"><i class="fa fa-trash"></i></span>\n\
                            <div class="row m-t-10 m-l-10">\n\
                                        <div class="col-sm-4" style="display:none;">\n\
                                            <div class="form-group">\n\
                                                <label>Competency Certificate Name</label>\n\
                                                <input type="text" name="certi['+newCertirow+'][oth_compCerti_name]" value="" id="oth_compCerti_name_'+newCertirow+'" class="form-control oth_compCerti_name" autocomplete="off" placeholder="Enter Certificate Name">\n\
                                                <span class="error"></span>\n\
                                            </div>\n\
                                        </div>\n\
                                        </div>\n\
                                        <div class="row m-t-10 m-l-10">\n\
                                        <div class="col-sm-4">\n\
                                            <div class="form-group">\n\
                                                <label>Document Upload </label>\n\
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
                    
                var url = "<?php echo BASE_URL('hmp/rec/deleteRecordcerti') ?>";
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
                                
});
                              
//                             swal('Success','resp.msg','success');
                        }
                    })
                }
            })
            }else{
            swal('Sorry','Record Master Upload cannot be left empty','warning');
        }
        }else{
            if(count > 1){
                $(this).closest('.othercertiDet').remove();
            }else{
                swal('Sorry','Record Master Upload cannot be left empty','warning');
            }
        }
        })
       
        
    });
</script>

