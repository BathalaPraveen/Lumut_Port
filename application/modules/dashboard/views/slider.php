<?php
//echo "<pre>";
//print_R($getEmploydetails);
//exit;
$cntrID = postData($getSlider,'SLIDER_ID');


?>
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
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('slider'); ?>
            </div>
            <div class="container-fluid">

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-headprimary">
                            <div class="row headingStyl">
                                <div class="col-md-12">
                                    <h4>Add Slider</h4>
                                </div>
                            </div>


                            <?php 
                             if(!empty($cntrID)){
                                 echo form_open_multipart('dashboard/slider/insertSlider/'. encryptval($cntrID) , 'class="form-horizontal" id="company-profile" novalidate'); 
                             }else{
                                 echo form_open_multipart('dashboard/slider/insertSlider/' , 'class="form-horizontal" id="company-profile" novalidate'); 
                             }
                               
                                
                                ?>

                            
                            <div class="card-body othCompdetl">
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border emplBorder" >
                                            <h5 class=""> Image Details </h5>
                                            <span class="btn btn-xs btn-success  float-right addMorcerti"><i class="fa fa-plus-square"> Add More</i></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">
                                    
                                    <?php
                                   //print_r($getAllslider);exit;
                                    if(isset($getSlider) && !empty($getSlider)){ 
                                        foreach($getSlider as $othKey => $othVal){
                                            $certiRowval = $othKey;
                                            $othCertiID = postData($othVal,'SLIDER_ID');
                                          
                                            $emplotherCertpath = postData($othVal,'SLI_FILE_PATH');
                                            $emplotherCertimgname = postData($othVal,'SLI_FILENAME');
                                             $emplotherCertimgext = postData($othVal,'SLI_FILE_EXT');

                                            if($emplotherCertimgname != ''){
                                                $compotherCertFilepath = $emplotherCertpath.$emplotherCertimgname;
                                            }else{
                                                $compotherCertFilepath = '';
                                            }
                                            
                                            ?>
                                    
                                    <div class="othercertiDet" certiRow-id="<?php echo $certiRowval; ?>">
                                    <span class="float-right removeCerti" removeCerti-ID="<?php echo $othCertiID; ?>"><i class="fa fa-trash"></i></span>
                                        <input type="hidden" name="certi[<?php echo $certiRowval; ?>][other_compCerti_ID]" value="<?php echo $othCertiID; ?>">
                                    <div class="row m-t-10 m-l-10">
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                
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
                                                    <p style="text-align:center;" class="mini-txt">(png, jpeg, jpg )</p>
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
                                         <span class="float-right removeCerti"><i class="fa fa-trash removeCertinew"></i></span>
                                    
                                    
                                    <div class="row m-t-10 m-l-10">
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                
                                                       <div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important; " data-provides="fileinput" >
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                        <?php
                                                        if ( $insuranceFilepath != '') {
                                                            ?>
                                                            <img src='<?php echo BASE_URL .  $insuranceFilepath ?>' alt='<?php echo $insuranceFilename; ?>' style="height: 100%;"/>     
                                                        <?php } ?>
                                                    </div>
                                                    <p style="text-align:center;" class="mini-txt">(png, jpeg, jpg )</p>
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
                                    <div class=""> 

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
    
    
      $(document).ready(function () {

        $.validator.addClassRules("compFile", {
            accept: "png|jpe?g|gif",
            required: false
          
        });

        $("#company-profile").validate({
            ignore: [],
            success: function (error) {
                error.removeClass("error");
                error.addClass("d-none");
            },

            rules: {
                
                
            },
            messages: {
                
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
    
    $(document).ready(function(){
     
        $(document).on('click','.addMorcerti',function(){
       
        var baseUrl = '<?php echo BASE_URL; ?>'
       var lastCerti = $(this).parents().eq(2).next().find(".othercertiDet").last().attr("certiRow-id");
      
       var newCertirow = parseInt(lastCerti)+1;
        var html = '<div class="othercertiDet" certiRow-id="'+newCertirow+'"> <span class="float-right removeCertinew"><i class="fa fa-trash"></i></span>\n\
                                        <div class="row m-t-10 m-l-10">\n\
                                        <div class="col-sm-4">\n\
                                            <div class="form-group">\n\
                                                       <div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important; " data-provides="fileinput">\n\
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput"></div><p style="text-align:center;" class="mini-txt">(png, jpeg, jpg )</p>\n\
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
                    
                var url = "<?php echo BASE_URL('dashboard/slider/deleteParticularslider') ?>";
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
                              $(".othCompdetl").load(" .othCompdetl");
//                             swal('Success','resp.msg','success');
                        }
                    })
                }
            })
            }else{
            swal('Sorry','Image cannot be left empty','warning');
        }
        })
        
         $(document).on('click','.removeCertinew',function(){
            $(this).closest('.othercertiDet').remove();
        })
        
    });
</script>

