

<?php
//echo "<pre>";
//print_r($getEmploydetails);
//print_r($emplLogindet);
//exit;
$cntrentID = postData($getEmploydetails,'CONT_ID');
$cntrentuniqID = postData($getEmploydetails,'CONT_AUTO_ID');
$contName = postData($getEmploydetails,'CONT_NAME');
$cmpnName = postData($getEmploydetails,'CONT_COMPANY');
$cntrGender = postData($getEmploydetails,'GENDER_NAME');
$cntrNation = postData($getEmploydetails,'NATIONALITY_NAME');
$cntrNationother = postData($getEmploydetails,'CONT_NATIONALITY_OTHER');
$cntrDesig = postData($getEmploydetails,'CONT_DESIGNATION');
$cntrDesigID = postData($getEmploydetails,'CONT_DESIGNATION');
$cntrMail = postData($getEmploydetails,'CONT_EMAIL_ID');
$cntrPhone = postData($getEmploydetails,'CONT_PHONE_NO');
$emploLogin = postData($getEmploydetails,'CON_LOGIN_STATUS');

$cntrSpec = postData($getEmploydetails,'CONT_SPECIAL');
$cntrAdres = postData($getEmploydetails,'CONT_ADDRESS');
$cntrCity = postData($getEmploydetails,'CONT_CITY');
$cntrCntry = postData($getEmploydetails,'CONT_COUNTRY');
$cntrPostal = postData($getEmploydetails,'CONT_POSTAL_CODE');
$cntrDOB = date("d-m-Y",strtotime($getEmploydetails->CONT_DOB));
$cntrNRIC = postData($getEmploydetails,'CONT_ID_NUMBER');
$cntrLogstatus = postData($getEmploydetails,'CON_LOGIN_STATUS');

$emploLogineditid = postData($emplLogindet,'LOGIN_ID');
$emploPassword = postData($emplLogindet,'ORG_PWD');
//echo "<pre>";
//print_R($emplLogindet);
//exit;

if($cntrLogstatus == 'P'){
    $contLog = 'Pending';
    $statusColor = 'pendStatusstyl';
}elseif($cntrLogstatus == 'E'){
    $contLog = 'Activated';
    $statusColor = 'enabStatusstyl';
}else{
    $contLog = 'Deactivated';
     $statusColor = 'disabStatusstyl';
}
?>
<style>
    .enabStatusstyl{
        background-color: #1ca71c !important;
        color: #fff !important;
        text-align: center;
    }
    .disabStatusstyl{
        background-color: #dc3545 !important;
        color: #fff !important;
        text-align: center;
    }
    .pendStatusstyl{
        background-color: #f19307fa !important;
        color: #fff !important;
        text-align: center;
    }
    .emplBorder{
        background-color: #007bff;
    }
</style>
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">


                        <!-- general form elements -->
                        <div class="card card-headprimary">

                            <div class="card-header">
                                <h3 class="card-title"> Activate/Deactivate Contractor</h3>
                                <a href="<?php echo BASE_URL('master/contractor') ?>" class="btn btn-sm btn-primary float-right locatnTyptarget" ><i class="fa fa-arrow-left"></i> Back</a>
                            </div>

                            <?php
                                if(!empty($cntrentuniqID)){
                                    $editEmpid = encryptval($cntrentuniqID);
                                }else{
                                    $editEmpid = '';
                                }
                                echo form_open('master/contractor/updateContstatus/' . $editEmpid, 'class="form-horizontal" id="resp-type" novalidate')
                                ?>

                            <div class="card-body">


                                <div class="invoice p-3 mb-3">
                                    <div class="card-header emplBorder" >
                                        <h3 class="card-title" style="color: #ffff;">Contractor Details</h3>
                                    </div>
                                    <div class="row">


                                        <div class="col-12 table-responsive">
                                            
                                            <input type="hidden" name="stat[userRefid]" value="<?php echo $cntrentuniqID ?>">
                                            <input type="hidden" name="stat[contDesig]" value="<?php echo $cntrDesigID ?>">
                                            <input type="hidden" name="stat[contID]" value="<?php echo $cntrentID ?>">
                                            <input type="hidden" name="stat[contrcName]" value="<?php echo $contName ?>">
                                            <input type="hidden" name="stat[contMailid]" value="<?php echo $cntrMail ?>">
                                            <input type="hidden" value="<?php echo $emploLogineditid; ?>" name="stat[hidLogid]">
                                            <table class="table table-striped" style="">
                                                <tbody>
                                                    <tr>
                                                        <td width="23%"><b>Contractor ID</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrentID; ?></td>
                                                        <td width="23%"><b>Company Name</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cmpnName; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Contractor Name</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $contName; ?></td>
                                                        <td width="23%"><b>Gender</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrGender; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Date of Birth</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrDOB; ?></td>
                                                        <td width="23%"><b>Mail ID</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrMail; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Phone Number</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrPhone; ?></td>
                                                        <td width="23%"><b>Address</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrAdres; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Company Specialization</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrSpec; ?></td>
                                                        <td width="23%"><b>Designation</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrDesig; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>NRIC/Passport No</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrNRIC; ?></td>
                                                        <td width="23%"><b>Nationality</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo (isset($cntrNation) && $cntrNation != 'Other') ? $cntrNation : $cntrNationother; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>City</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrCity ; ?></td>
                                                        <td width="23%"><b>Country</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrCntry; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Postal Code</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrPostal; ?></td>
                                                        <td width="23%"><b>Contractor Status</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><label class="btn btn-xs <?php echo $statusColor; ?>"><?php echo $contLog; ?></label></td>
                                                     
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>User Name</b></td>
                                                        <td>:</td>
                                                        <td width="23%" colspan="4"><?php echo $cntrentID; ?></td>
                                                     
                                                    </tr>
                                                    <?php // if($emploLogin == 'P'){ ?>
                                                   <?php if(getParticsessdata('USER_TYPE_ID') == 1 && $emploLogin != 'E'){ ?>
                                                    <tr>
                                                       <td width="23%"><b>Password</b></td>
                                                        <td>:</td>
                                                        <td width="23%">
                                                            <input type="text" id="password"  class="form-control" placeholder="Enter Password" name="stat[password]" value="<?php echo $emploPassword; ?>">
                                                             <span class="error" id="passErr"></span>
                                                        </td>
                                                        <td width="23%"><b>Confirm Password</b></td>
                                                        <td>:</td>
                                                        <td width="23%">
                                                            <input type="text" id="cnfrm_password" class="form-control" placeholder="Enter Confirm Password" name="stat[confirm_password]" value="<?php echo $emploPassword; ?>">
                                                            <span class="error" id="cnfrmErr"></span>
                                                        </td>
                                                       
                                                    </tr>
                                                 <?php } ?>
                                                    <tr class="appendPassword">
                                                       
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer justify-content-center">
                                        <input type="hidden" name="stat[empStatus]" value="">
                                        <?php if($emploLogin == 'E'){ ?>
                                        <button type="submit"  id="submiPass"  class="btnClickpassword btn btn-primary d-none"><i class="fa fa-user-circle"></i> Submit</button>
                                        <button type="button"  id="changePasEmp"  class="btnClicksubchange btn btn-primary "><i class="fa fa-user-circle"></i> Change Password</button>
                                        <button type="submit"  id="disabEmp"  class="btnClicksub btn btn-danger "><i class="fa fa-user-circle"></i> Deactivate Contractor</button>
                                        <?php }else{ ?>
                                        <button type="submit"  id="enabEmp"  class="btnClicksub btn btn-success "><i class="fa fa-user-circle"></i> Activate Contractor</button>
                                        <?php } ?>
                                    </div>
                                    
                                </div>
                              
                            </div>
                            
                            <?php form_close(); ?>
                            
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

 var value = $("#password").val();

       $.validator.addMethod("checklower", function(value) {
  return /[[*|\"%:<>[\]{}`\\()';=!#@&$]/.test(value);
});
$.validator.addMethod("checkupper", function(value) {
  return /[A-Z]/.test(value);
});
$.validator.addMethod("checkdigit", function(value) {
  return /[0-9]/.test(value);
});
$.validator.addMethod("checkspl", function(value) {
  return /[a-z]/.test(value);
});


         $("#resp-type").validate({
            ignore: [],

            rules: {
                "stat[password]": {
                    required: true,
                    //alphanumeric: true,
                     maxlength: 25,
                   minlength: 8,
                    checklower:true,
                    checkupper:true,
                    checkdigit:true,
                    checkspl:true,
                },
                "stat[confirm_password]": {
                    required: true,
                    //alphanumeric: true,
                     maxlength: 25,
                   minlength: 8,
                    checklower:true,
                    checkupper:true,
                    checkdigit:true,
                    checkspl:true,
                },
               
            },
            messages: {
                "stat[password]": {
                    required: "Password is required",
checklower:"Please enter atleast one Special Characters",
                    checkupper:"Please enter atleast one Uppercase Alphabet",
                    checkdigit:"Please enter atleast one Numeric",
                    checkspl:"Please enter atleast one Lowercase Alphabet",
                },
                "stat[confirm_password]": {
                    required: "Confirm Password is required",
checklower:"Please enter atleast one Special Characters",
                    checkupper:"Please enter atleast one Uppercase Alphabet",
                    checkdigit:"Please enter atleast one Numeric",
                    checkspl:"Please enter atleast one Lowercase Alphabet",
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
             submitHandler: function (form,e) {
                var submTyp = $(".btnClicksub").attr('id');
                if(submTyp == 'enabEmp'){
                    $("input[name='stat[empStatus]']").val("E");
                }else if(submTyp== 'disabEmp'){
                    $("input[name='stat[empStatus]']").val("D");
                }else{
                    $("input[name='stat[empStatus]']").val("E");
                   
                }
                e.preventDefault();
                if(submTyp == 'enabEmp'){
                swal({
                    title: "Are you sure?",
                    text: "<b> You want to Activate the Contractor</b>",
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
                         loader();
                         form.submit();
                    }
                });
            }else if(submTyp== 'disabEmp'){
                swal({
                title: "Are you sure?",
                text: "<b> You want to Deactivate the Contractor</b>",
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
                    loader();
                    form.submit();
                }
            });
            }else{
                    swal({
                            title: "Are you sure?",
                            text: "<b> You want to submit</b>",
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
                                 loader();
                                form.submit();
                            }
                        });
                }
             }

        });
        
        $(document).on('keyup','#cnfrm_password',function(){
            var passVal = $("#password").val();
            var cnfpassVal = $(this).val();
           $("#cnfrmErr").text('');
            $("#passErr").text('');
            if(cnfpassVal != passVal){
                $("#cnfrmErr").text("Confirm Password must be the same as Password")
            }
        })
        $(document).on('keyup','#password',function(){
            var cnfpassVal = $("#cnfrm_password").val();
            var passVal = $(this).val();
            $("#passErr").text('');
            $("#cnfrmErr").text('');
            if((cnfpassVal != passVal) && cnfpassVal != ''){
                $("#passErr").text("Password must be the same as Confirm Password")
            }
        });
        
         $(document).on('click','#changePasEmp',function(){
            var passW = '<?php echo $emploPassword; ?>'
            
            var appHtml = '<td width="23%"><b>Password</b></td>\n\
                            <td> : </td>\n\
                            <td width="23%">\n\
                                <input type="text" id="password" class="form-control" placeholder="Enter Password" name="stat[password]" value="'+passW+'">\n\
                                <span class="error" id="passErr"></span>\n\
                             </td>\n\
                             <td width="23%"><b>Confirm Password</b></td>\n\
                             <td>:</td>\n\
                             <td width="23%">\n\
                                <input type="text" id="cnfrm_password" class="form-control" placeholder="Enter Confirm Password" name="stat[confirm_password]" value="'+passW+'">\n\
                                <span class="error" id="cnfrmErr"></span>\n\
                              </td>\n\
        ';
                                            $(".appendPassword").html(appHtml);
                                            $(".btnClicksub").remove();
//                                            $("#disabEmp").removeClass('d-none');
                                            $(".btnClicksubchange").addClass('d-none');
                                            $(".btnClickpassword").removeClass('d-none');
        })
       
    });


</script>


                                                       
                                                   
