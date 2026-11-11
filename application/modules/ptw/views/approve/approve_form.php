<script>
        var loadingImg = '<?php echo LOADING_IMG; ?>';
        var defaultImg = '<?php echo DEFAULT_IMG_PNG;?>';
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
        min-height: 89%;
        top: 0;
        text-align: center;
        border: 2px solid #007cb7;
    }
    .popupgal i{
        margin-top: 25%;
    }
</style>
<?php 
 global $aPTWPermission;
  $userType = getCurrentUserGroupId();
$defaultImg = DEFAULT_IMG_PNG;
$OAList = getOAList('drop');
$viewData = [
        'aDisableAttr' => [
        'readonly' => 'readonly',
        'disabled' => 'disabled'
    ],
    'OAList'=>$OAList,
    'aPTWPermission'=>$aPTWPermission,
    'userType'=>$userType
];
 $submitFormName = 'approve_form';
  $verficationView = (in_array($userType, $aPTWPermission['verfication_a']) || in_array($userType, $aPTWPermission['verfication_b']) || is_admin()) ? TRUE : FALSE;
  $section7A = (in_array($userType, $aPTWPermission['verfication_a']) || is_admin()) ? TRUE : FALSE;
  $section7B = (in_array($userType, $aPTWPermission['verfication_b']) || is_admin()) ? TRUE : FALSE;
  $PTWClose = (in_array($userType, $aPTWPermission['close']) || is_admin()) ? TRUE : FALSE;
  $PTWStop = (in_array($userType, $aPTWPermission['stop']) || is_admin()) ? TRUE : FALSE;
  $PTWAck = (in_array($userType, $aPTWPermission['acknowledge']) || is_admin()) ? TRUE : FALSE;
  $PTWStatus = postData($editData,'STATUS');
  $showBtn = FALSE;
  
  $pType = postData($editData, 'PERMIT_TYPE');
  $CSStatus = postData($editData, 'CONFINED_SPACE');
  $CSCompletion = postData($editData, 'CONFINED_SPACE_COMPLETION');
  $appTypeId = postData($editData, 'APPLICANT_USER_TYPE_ID');
  $showCSBtn = FALSE;
  //$CSCompletion = 'Y';
   $adminbtnDisable = FALSE;
    $currentUserType = getCurrentUserGroupId();
   if($PTWStatus == 6 && $pType == 2 && $CSStatus == 'Y' && $CSCompletion == 'N' && ($appTypeId == $currentUserType  || is_admin() )){
       $showCSBtn = TRUE;
       $PTWClose = FALSE;
        $submitFormName = 'confined_space_form';
         $adminbtnDisable = (is_admin()) ? TRUE : FALSE;
   }else if($PTWStatus == 6 && $pType == 2 && $CSStatus == 'Y' && $CSCompletion == 'N' && $currentUserType == 6){
      
        $form_action_url = $approval_action_url;
       
   }
   
   if($PTWStatus == 6 && $CSCompletion == 'Y' && $CSStatus == 'Y'  && $pType == 2 ){
       $PTWClose = TRUE;
       $showCSBtn = FALSE;
   }
        
  if($section7A == TRUE && $PTWStatus == 1){
      $showBtn = TRUE;
  }else if($section7B == TRUE && $PTWStatus == 2  && ($QAVeifyPermission == TRUE || is_admin() )){
      $showBtn = TRUE;
  }
   $showAckBtn = FALSE;
  if($PTWStatus == 4 && $PTWAck){
      $showAckBtn = TRUE;
  }
   $showStopBtn = FALSE;
  if($PTWStatus == 6  && $PTWStop == TRUE){
      $showStopBtn = TRUE;
      $submitFormName = 'stop_cancel_form';
  }
  
 
          
  $showReactiveBtn = FALSE;
  if($PTWStatus == 8 && $PTWStop == TRUE){
      $showReactiveBtn = TRUE;
       $submitFormName = 'reactivate_cancel_form';
  }
  $showCloseBtn = FALSE;
  if($PTWClose == TRUE && in_array($PTWStatus, [6,10]) ){
      $showCloseBtn = TRUE; 
      $submitFormName = 'close_form';
  }
  
  if(is_admin() && $PTWStatus >=6 && $PTWStatus !=8){
      $submitFormName = 'admin_stop_cancel_close_form';
  }
 
?>

<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div id="accordion" class="permitAccordion">
                <?php

                $formData = [
                    'class'=>'form-horizontal',
                    'id'=>$submitFormName,
                    'novalidate'=>'novalidate'
                ];
              
              echo form_open_multipart($form_action_url, $formData);
              echo form_hidden('ptw_id',$ptw_id);     
              echo form_hidden('permitType',$permitType);     
              echo form_hidden('designationId',postData($userDetails, 'DESIGNATIONID'));     
              echo form_hidden('sectionId',postData($userDetails, 'DEPTNAMEID'));     
              echo form_hidden('companyName',postData($userDetails, 'COMPANY'));   
//              echo '<pre>';
//              print_r(validation_errors());
//              echo '</pre>';
              
?>
               
                <div class="row">            
                    <div class="col-md-12">                
                        <div class="card card-headprimary">
                            <div class="row headingStyl">
                                <div class="col-md-8">
                                    <h4><?php echo $permitType; ?> WORK PERMIT </h4>
                                   
                                </div>
                                <div class="col-md-4">
                                     <a href="<?php echo $backURL ?>"><button type="button" class="btn btn-primary  float-right"><i class="fa fa-arrow-left"></i> Back</button></a> 
                                     <?php if($PTWStatus >=6){?>
                                     <a class="btn btn-primary float-right" style="margin-right:10px;"  href="<?php echo BASE_URL.'/ptw/permit/generateSancFormPdf/'.$editId;?>" class="" title="PDF" target="_blank"><i class="fa fa-download" aria-hidden="true" style="color:#FFF;"></i>&nbsp;Download Sanctioning form </a>
                                     <?php } ?>
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
                                        <a class="card-link " data-toggle="collapse" href="#section_1_pequisition" >
                                            Section 1 – Requisition – Permit Applicant of Performing Authority (PA)<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_1_pequisition" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">

                                           <?php echo $this->load->view('section1_form',$viewData); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " data-toggle="collapse" href="#section_2_hazardous" >
                                            Section 2 - Hazardous Activities<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_2_hazardous" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                               <?php echo $this->load->view('section2_form',$viewData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " data-toggle="collapse" href="#section_3_wpp">
                                            Section 3 - WORKSITE PREPARATION/PRECAUTIONS (Select appropriate boxes)<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_3_wpp" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                               <?php echo $this->load->view('section3_form',$viewData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " data-toggle="collapse" href="#section_4_PPE">
                                            SECTION 4 - PERSONAL PROTECTIVE EQUIPMENT (Select appropriate boxes)<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_4_PPE" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                               <?php echo $this->load->view('section4_form',$viewData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " data-toggle="collapse" href="#section_5_jointvisit">
                                            SECTION 5 - JOINT VISIT BEFORE WORK COMMENCES<span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_5_jointvisit" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                               <?php echo $this->load->view('section5_form',$viewData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if(($verficationView == TRUE && $PTWStatus >=1)|| $PTWStatus >=4)
                                {?>
                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " data-toggle="collapse" href="#section_7_verification">
                                            Section 7 – Verification (A.Verification by SHO/HSE Executive) <span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_7_verification" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                         <?php echo $this->load->view('section7a_form',$viewData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                <?php if(($verficationView == TRUE &&  $PTWStatus == 2 && $section7B == TRUE) || $PTWStatus >=3)
                                {?>
                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " data-toggle="collapse" href="#section_7_verification_qa">
                                            Section 7 – Verification (B.VERIFICATION BY OPERATING AUTHORITY (OA)) <span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_7_verification_qa" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                         <?php echo $this->load->view('section7b_form',$viewData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                
                                <?php if($PTWStatus >=6 && $PTWStop == TRUE) {?>
                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " data-toggle="collapse" href="#section_8a">
                                            SECTION 8 - PERMIT STOPPAGE   <span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_8a" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                         <?php echo $this->load->view('section8a_form',$viewData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <?php } ?>
                                <?php if($PTWStatus >=8 && $PTWStatus !=9 && $PTWStop == TRUE) {?>
                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " data-toggle="collapse" href="#section_8b">
                                            SECTION 8 - RE-ACTIVATE  PERMIT <span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_8b" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                         <?php echo $this->load->view('section8b_form',$viewData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <?php } ?>
                                
                                <?php if($PTWStatus >=4 && $PTWAck == TRUE) {?>
                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " data-toggle="collapse" href="#section_9">
                                            SECTION 9 - PERMIT RECIPIENT <span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_9" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                         <?php echo $this->load->view('section9_form',$viewData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                <?php
                                
                                if(in_array($PTWStatus, [6,10]) && $PTWClose == TRUE) {?>
                                <div class="card">
                                    <div class="card-header ">
                                        <a class="card-link " data-toggle="collapse" href="#section_10">
                                            SECTION 10 - COMPLETION OF WORK (PERMIT CLOSURE) <span class="float-right"></span>
                                        </a>
                                    </div>
                                    <div id="section_10" class="collapse multi-collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                         <?php echo $this->load->view('section10_form',$viewData); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                 <div class="row">
                                     <div class="col-md-12 text-center">
                                <?php if($verficationView == TRUE && $showBtn== TRUE){?>
                                
                                                
                                                    <input type="submit" class="btn btn-success " name="approve" value="Approve"/>
                                                     <input type="submit" class="btn btn-danger " name="reject" value="Reject"/>
                                               
                                            
                                <?php } ?>

                                <?php if($showAckBtn){
                                    ?>

                                                    <input type="submit" class="btn btn-info " name="acknowledge" value="Acknowledge"/>
                                                     
                                               
                                            
                              <?php  } ?>
                               <?php if($showStopBtn){
                                   $disBtn = ($adminbtnDisable) ? 'disabled' : '';
                                    ?>

                                                    <input type="submit" class="btn btn-warning " name="stop" value="Stop Permit" <?php echo $disBtn;?>/>
                                          <input type="submit" class="btn btn-danger " name="cancel" value="Cancel Permit" <?php echo $disBtn;?>/>           
                                                     
                                             
                              <?php  } ?>

<?php if($showReactiveBtn){
                                    ?>

                                                    <input type="submit" class="btn btn-warning " name="reactive" value="Re-activate Permit"/>
                                          <input type="submit" class="btn btn-danger " name="cancel" value="Cancel Permit"/>           
                                                     
                                             
                              <?php  } ?>
<?php if($showCloseBtn){
                                    ?>
                                          

                                                     <input type="submit" class="btn btn-success " name="close" value="Submit & Close"/>
                                               
                              <?php  } ?>
                             <?php if($showCSBtn){
                                 $disBtn = ($adminbtnDisable) ? 'disabled' : '';
                                 ?>
                                                      <input type="submit" class="btn btn-success " name="confinedSpace" value="Submit" <?php echo $disBtn;?>/>
                             <?php } ?>
                                        </div>
                                     </div>

                            </div>



                            <!-- /.card -->
                        </div>
                    </div>
                </div>

              
             <?php echo form_close();?>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

</div>

<script>
    $(document).ready(function() {
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
        $.validator.addClassRules('gastestresult', {
            required: true,

        });
        
         $('#admin_stop_cancel_close_form').validate({
	rules: {

	    "stop_cancel_declaration": {
		required: true,
	    },
	    "stop_comments": {
		required: true,
	    },
	   
	    
	   
	},
	messages: {
	    "stop_cancel_declaration": {
		required: "Please select the Option",
	    },
	    "stop_comments": {
		required: "Please enter your comments",
	    },
           
	   
	},
        success: function(label,element) {
                label.parent().removeClass('error');
		label.remove();
					
	},
        highlight: function(element) {
            $(element).parent('div').addClass('error');
        },
        unhighlight: function(element) {
            $(element).parent('div').removeClass('error');
        },
        errorPlacement: function (error, element) {
            if (element.hasClass('select2')) {
               error.insertAfter(element.next('span')); 
           } else {
               error.insertAfter(element);
           }
             
        },
	submitHandler: function (form) {
            var submitButtonName =  $(this.submitButton).attr("name");
            $('#submitaction').val(submitButtonName);
            swal({
                title: "Are you sure",
                text: "You want to "+submitButtonName,
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
                            
                            form.submit();
                           
                        } 
                    });
             
	    
	}
    });
       
       
    })
</script>

