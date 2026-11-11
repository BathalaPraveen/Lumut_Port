<?php 
$eSection = ($editData != FALSE) ? 1 : 0;
?>
<script>
    var defaultImg = '<?php echo DEFAULT_IMG_PNG;?>';
    var editSection = '<?php echo $eSection;?>';
    function addDays(date, days) {
        var maxDate = new Date(date);
        maxDate.setDate(maxDate.getDate() + days);
        return maxDate;
    }
     function formatAMPM(date) {
          var hours = date.getHours();
          var minutes = date.getMinutes();
          var ampm = hours >= 12 ? 'pm' : 'am';
          hours = hours % 12;
          hours = hours ? hours : 12; // the hour '0' should be '12'
          minutes = minutes < 10 ? '0'+minutes : minutes;
          var strTime = hours + ':' + minutes + ' ' + ampm;
          return strTime;
        }
        
        function getTodayDate() {
            var d = new Date();
            var month = d.getMonth() + 1;
            var day = d.getDate();
            var year = d.getFullYear();
            var today = (day<10?'0':'')+ day + '-' +(month<10?'0':'')+ month + '-' + year;
            return today;
       }
</script>
<style>
    .newhr {
        margin-top: 15px;
        margin-bottom: 15px;
        border-color: white;
    }
    .card-header{
        color: #fff;
        background-color: #007bff;
        font-weight: bold;
        text-transform: uppercase;
    }
    .card-link{
        color: #fff;
    }
    .card-header a:hover{
        color: #fff;
    }
    .red{
        color:red;
    }
    .removeItem:not(:disabled):not(.disabled).active, .removeItem:not(:disabled):not(.disabled):active, .removeItem,.removeItem:hover{
        color: #fff;
        background-color: red;
        border-color:red;
    }
    .uppertext{
        text-transform: uppercase;
    }
    .card-header-cc {
        color: #fff;
        background-color: green;
    }
    .imagepopcombine:hover .popupgal {
        opacity: 1;
    }
    .popupgal{
        position: absolute;
        font-size: 3rem !important;
        color: #fff;
        opacity: 0;
        transition: .2s opacity ease-in-out;
        z-index: 5;
        background: #b7b7b77d;
        min-width: 82%;
        min-height: 70%;
        top: 0;
        text-align: center;
        border: 2px solid #007cb7;
    }
    .popupgal i{
        margin-top: 25%;
    }
    
   
    /* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
    .datepicker {
            top:290px !important;
        }
}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (min-width: 1200px) {
    .datepicker {
            top:300px !important;
        }
}
</style>
<?php $defaultImg = DEFAULT_IMG_PNG;
$confineLoopEntryCount = 0;
$formDatas = [
    'confineLoopEntryCount'=>$confineLoopEntryCount
];
 $PTWStatus = postData($editData,'STATUS');
 $HSERemarks = postData($editData,'SHO_HSE_REMARKS');
?>

<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div id="accordion" class="permitAccordion">
                <?php
//                echo '<pre>';
//                print_r(validation_errors());
//                print_r($this->input->post());
//                echo '</pre>';
                $formData = [
                    'class' => 'form-horizontal',
                    'id' => 'permint_form',
                    'novalidate'
                ];

                echo form_open_multipart($form_action_url, $formData);
                echo form_hidden('ptw_id', $ptw_id);
                echo form_hidden('permitType', $permitType);
                echo form_hidden('designationId', postData($userDetails, 'DESIGNATIONID'));
                echo form_hidden('sectionId', postData($userDetails, 'DEPTNAMEID'));
                echo form_hidden('companyName', postData($userDetails, 'COMPANY'));
                ?>

                <div class="row">            
                    <div class="col-md-12">                
                        <div class="card card-headprimary">
                            <div class="row headingStyl">
                                <div class="col-md-12">
                                    <h4><?php echo $permitType; ?> WORK PERMIT </h4>
                                    <a href="<?php echo $backURL; ?>"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>
                                </div>
                            </div>
                            <div class="" style="margin-top:10px;">
<?php
echo $this->session->flashdata('flashmsg');
?>
                            </div>
                            <div class="card-body">

                                <div class="card ">
                                    <div class="card-header ">
                                        <a class="card-link " href="javascript:void(0)" >
                                            Section 1 – Requisition – Permit Applicant of Performing Authority (PA)<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_1_pequisition" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                          
                                            <?php if($PTWStatus == 3){
                                             ?>
                                            <div class="row" style="background:#FFCCCB">
                                                <div class="col-md">
                                                    <label>HSE Reject Remarks : </label>
                                                    <p><?php echo $HSERemarks;?></p>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                           
                                            

<?php echo $this->load->view('section1_form'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " href="javascript:void(0)">
                                            Section 2 - Hazardous Activities<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_2_hazardous" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
<?php echo $this->load->view('section2_form',$formDatas); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " href="javascript:void(0)">
                                            Section 3 - WORKSITE PREPARATION/PRECAUTIONS (Select appropriate boxes)<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_3_wpp" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
<?php echo $this->load->view('section3_form'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " href="javascript:void(0)">
                                            SECTION 4 - PERSONAL PROTECTIVE EQUIPMENT (Select appropriate boxes)<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_4_PPE" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
<?php echo $this->load->view('section4_form'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " href="javascript:void(0)">
                                            SECTION 5 - JOINT VISIT BEFORE WORK COMMENCES<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_5_jointvisit" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
<?php echo $this->load->view('section5_form'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                


                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary ">Submit</button> 
                                    </div>
                                </div>

                            </div>



                            <!-- /.card -->
                        </div>
                    </div>
                </div>


<?php echo form_close(); ?>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

</div>

<script>
    $(document).ready(function () {
         var loadingImg = '<?php echo LOADING_IMG; ?>';
        function deleteDoc(url, data,refid,addref,addClass) {
            var loadingImg = '<?php echo LOADING_IMG; ?>';
            var response = false;
            swal({
                title: "Are you sure",
                text: "You want to delete",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                closeButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            swal({
                                title: "Please wait..",
                                imageUrl: loadingImg,
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                            $.ajax({
                                url: url,
                                type: "post",
                                data: data,
                                dataType: 'JSON',
                                cache: false,
                                success: function (resp) {

                                    if (resp.status) {
                                        swal({
                                            title: "Success",
                                            text: resp.msgs,
                                            type: "success",
                                            confirmButtonClass: "btn-primary",
                                            confirmButtonText: "OK",
                                            closeOnConfirm: true,

                                        },
                                                function (isConfirm) {
                                                    if (isConfirm) {
                                                        
                                                         $('#'+refid).remove();
                                                         
                                                         var pcount = $('.' + addClass).children('.col-md-3').length;
                                                        if(pcount == 0 && addref !=''){
                                                            $('#'+addref).trigger('click');
                                                        }
                                                    }
                                                }
                                        )
//                                swal('Success', resp.msgs, 'success');

                                    } else {
                                        swal({
                                            title: "Error",
                                            text: resp.msgs,
                                            type: "error",
                                            confirmButtonClass: "btn-primary",
                                            confirmButtonText: "OK",
                                            closeOnConfirm: true,

                                        }

                                        )

                                    }
                                }
                            });
                        } else {
                            swal('Sorry', 'There occured some error', 'warning');

                        }
                    });

                    return response;
        }

        $(document).on('click', '.additionalDoc', function () {
            
            var dref = $(this).attr('data-ref');
            var drefbind = $(this).attr('data-refbind');
            var dmaxfile = $(this).attr('data-max');
            var dclassName = $(this).attr('data-classname');
            var daccept = $(this).attr('data-accept');
            var dacceptmsg = $(this).attr('data-acceptmsg');
            var classAttr = '';
            var acceptAttr = '';
            var acceptMsgAttr = '';
            if (typeof dclassName !== typeof undefined && dclassName !== false) {
                classAttr = 'class="' + dclassName + '"';
            }
            if (typeof daccept !== typeof undefined && daccept !== false) {
                acceptAttr = 'accept="' + daccept + '"';
            }
            if (typeof dacceptmsg !== typeof undefined && dacceptmsg !== false) {
                acceptMsgAttr = 'data-msg-accept ="' + dacceptmsg + '"';
            }

            var count = $('.' + drefbind).children('.col-md-3').length;
         
            var html = '<div class="col-md-3"><div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"><img src="'+defaultImg+'" /></div><div style="display: inline-block;float:left;margin-right:5px;"><span class="btn-file" style="display: inline-block;"><span class=" btn btn-sm btn-primary fileinput-new">Select image</span><span class="btn btn-sm btn-warning fileinput-exists">Change</span><input type="file" name="' + dref + '[]" ' + classAttr + ' ' + acceptAttr + ' ' + acceptMsgAttr + '> </span></div><div><a href="javascript:void(0)" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>';
        if(count > 0){
        html += '<a style="margin-left:5px;" href="javascript:void(0)" class="btn btn-sm btn-danger deleteFile">Delete</a>';
        }
        html += '</div></div></div>';
            if (dmaxfile != -1 && count > 0 && count < dmaxfile) {

                $('.' + drefbind).append(html);
            } else if (dmaxfile == -1 && count > 0) {
                $('.' + drefbind).append(html);
            }
            
            if(count == 0){
                $('.' + drefbind).append(html);
            }
           

        });
        $(document).on('click', '.deleteFile', function () {
            $(this).closest('.col-md-3').remove();
        });


        $('.select2').on('change', function () {
            $(this).valid();

        });
        
        $('.otherfield').on('keypress', function () {
            $(this).valid();

        });
        $('#start_date').on('change', function () {
            $(this).valid();
        });
        $('#end_date').on('change', function () {
            $(this).valid();
        });
        
        $.validator.addMethod('filesize', function (value, element, param) {
           
    return this.optional(element) || (Math.round(element.files[0].size / (1024 * 1024)) <= 5)
}, 'File size must be less than 5MB');
        $.validator.addClassRules('additional_doc_req', {
            required: true,

        });
        $.validator.addClassRules('ccchecklist', {
            required: true,

        });
        $.validator.addClassRules('wppCheckbox', {
            required: true,

        });

        $.validator.addClassRules("initialfilerequire", {
            accept: "png|jpe?g|gif",
            required: true,
            filesize : true
        });

        $.validator.addClassRules("initialfile", {
            accept: "png|jpe?g|gif",
            required: false
        });

        $.validator.addClassRules("docfileupload", {
            accept: "pdf|png|jpe?g|gif",
            required: false,
            filesize : true
        });

        $.validator.addClassRules("docfileuploadrequire", {
            accept: "pdf|png|jpe?g|gif",
            required: true,
            filesize : true
        });
        
        $.validator.addClassRules("otherfield", {
            programming_char:true,
            minlength:3,
            maxlength:255
        });
        $.validator.addClassRules('gastest', {
            required: true,

        });
        
        $.validator.addMethod('alphaspacedot', function (value) {
           return /^[A-Za-z\. ]*$/.test(value);
       }, "Please enter only alphabetic characters,space and dot");
        $.validator.addClassRules("namefield", {
            programming_char:true,
            alphaspacedot:true,
            minlength:3,
            maxlength:255
        });

        $.validator.addMethod("notEqualTo", function (value, element, param) {
            return this.optional(element) || value != param;
        }, "Both are same,Select another option");

        var cspaceLoop = '<?php echo $confineLoopEntryCount;?>';
        var csval = parseInt(cspaceLoop)-1;
        console.log(csval);
            
        $('#permint_form').validate({
            rules: {

                "location": {
                    required: true,
                },
                "specific_location": {
                    required: true,
                    alphanumericwithspecialchar: true,
                    programming_char:true,
                },
                "start_date": {
                    required: true,
                },
                "end_date": {
                    required: true,
                },
                "area_classification": {
                    required: true,
                },
                "work_description": {
                    required: true,
                    programming_char:true,
                },
                "specialworkinstruction_option": {
                    required: true,
                   
                },
                "special_work_instruction": {
                    required: false,
                    programming_char:true,
                },
                "hazardActivities_routine[]": {
                    required: true,
                },
                "hazardActivities_cc[]": {
                    required: true,
                },

                "wpp_checklist_1[]": {
                    required: true,
                },
                "other_ppe_desc": {
                    required: function (element) {
                        return $("input[name='PPE_ref_id[-1][checklist][]']:checked").val() == "-1";

                    },
                },
                "hirarc_type": {
                    required: function (element) {
                        return $("input[name='hazardActivities_additional_doc[24]']:checked").val() == "24";

                    },
                },
                "hirarc_reports[]": {
                    required: function (element) {
                        var dcolength = $('.hirarcupload').get(0).files.length;
                        var pcount = $('.fileuploadrow_24').children('.edit_upload_documents_24').length;
                        if(editSection == 1 && dcolength == 0){
                            dcolength = pcount;
                        }
                        
                        
                        var hiracVal = $("input[name='hirarc_type']").val();
                            if(hiracVal == '1' && dcolength ==0){
                                return true;
                            }else{
                                return false;
                            }
                       
                    },
                },
                "operation_authority_1": {
                    required: true,
                    notEqualTo: function () {
                        return $('#operation_authority_2').val()
                    }
                },
                "operation_authority_2": {
                    required: true,
                    notEqualTo: function () {
                        return $('#operation_authority_1').val()
                    }
                },
                "initial_declaration": {
                    required: true,

                },
                
                "confined_space[-1][lel]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == -1){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[-1][O2]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == -1){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[-1][H2S]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == -1){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[-1][CO]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == -1){
                            return true;
                        }else{
                            return false;
                        }

                    },
                },
                "confined_space[-1][agt_name]":{
                    required: function (element) {
                        if($("input[name='gas_test_declaration']:checked").val() == "1" && csval == -1){
                            return true;
                        }else{
                            return false;
                        }

                    },
                }
                
                


            },
            messages: {
                "location": {
                    required: "Please select the Location",
                },
                "specific_location": {
                    required: "Please enter the Specific Location",
                },
                "start_date": {
                    required: "Please select Start Date",
                },
                "end_date": {
                    required: "Please select End Date",
                },
                "area_classification": {
                    required: "Please select Area Classification",
                },
                "work_description": {
                    required: "Please enter the Work Description",
                },
                "specialworkinstruction_option": {
                    required: "Please selecth Special Work Instruction Option",
                },
                "special_work_instruction": {
                    required: "Please enter the Special Work Instruction",
                },
                "hazardActivities_routine[]": {
                    required: "Please select atleast one from Normal/Routine - Details of work hazards",
                },
                "wpp_checklist_1[]": {
                    required: "Please select atleast one from Basic requirements",
                },
                "hazardActivities_cc[]": {
                    required: "Please select atleast one from Critical activity - Details of work hazards",
                },
                "other_hazardActivities_routine[]": {
                    required: "Please enter Others ",
                },

                "additional_doc_req": {
                    required: "Please select additional document",
                },
                "other_ppe_desc": {
                    required: "Please enter the Others"
                },
                "hirarc_type": {
                    required: "Please select the option"
                },
                "hirarc_reports[]": {
                    required: "Please select HIRARC ID / Upload attachment"
                },
                "operation_authority_1": {
                    required: "Please select Operating Authority 1",
                },
                "operation_authority_2": {
                    required: "Please select Operating Authority 2",
                },
                "initial_declaration": {
                    required: "Please tick the declaration",

                },
                "gas_test_declaration":{
                    required: "Please tick the gas test",
                }


            },
            success: function (label, element) {
                label.parent().removeClass('error');
                label.remove();

            },
            highlight: function (element) {
                $(element).parent('div').addClass('error');
            },
            unhighlight: function (element) {
                $(element).parent('div').removeClass('error');
            },
            errorPlacement: function (error, element) {
                console.log(element.attr('name'));
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('span'));
                } else if (element.attr('name') == 'area_classification') {
                    error.appendTo('span.area_classification_error');
                } else if (element.hasClass('hazardRoutineDiv')) {
                    error.appendTo('span.hazardRoutineDiv_error');
                } else if (element.hasClass('hazardAddCCDiv')) {
                    error.appendTo('span.hazardAddCCDiv_error');
                } else if (element.hasClass('additional_doc_req')) {
                    error.appendTo(element.parent('.form-check').next('span.hazact_error'));
                } else if (element.hasClass('ccchecklist')) {
                    error.appendTo(element.parent('.form-check').next('span.ccchecklist_error'));
                } else if (element.attr('name') == 'other_hazardActivities_routine[]') {
                    console.log('error');
                    error.appendTo(element.parent('.input-group').next('span.red'));
                } else if (element.attr('name') == 'wpp_checklist_1[]') {

                    error.appendTo('span.wpp_checklist_1_error');
                } else {
                    error.insertAfter(element);
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

        $(document).on('click', '.deleteDoc', function () {
            
       
            var pClass = $(this).parent().closest('.col-md-3').parent().attr('class');
            var pclass = pClass.replace('row','');
            var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
            var url = '<?php echo $deleteURL; ?>';
          
            var dataId = $(this).attr("data-id");
            var dataRef = $(this).attr("data-ref");
            var delType = $(this).attr("data-ref-type");
            var refid = $(this).attr("data-refid");
            var fpath = $(this).attr("data-filepath");
            var addVal = $(this).attr("data-addref");
            var data = {delId: dataId, delRef: dataRef, delType: delType,delFilepath:fpath, '<?php echo $this->security->get_csrf_token_name(); ?>': csrfToken};
             deleteDoc(url, data,refid,addVal,$.trim(pclass));
             
            
          
           
            


        })
    })
</script>

