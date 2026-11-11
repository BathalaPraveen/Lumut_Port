<?php
$emploID = postData($getEmploydetails,'EMP_AUTO_ID');
$emploentID = postData($getEmploydetails,'EMP_ID');
$emplName = postData($getEmploydetails,'EMP_NAME');
$emplGender = postData($getEmploydetails,'EMP_GENDER');
$emplNation = postData($getEmploydetails,'EMP_NATIONALITY');
$emplNationother = postData($getEmploydetails,'EMP_NATIONALITY_OTHER');
$emplDesig = postData($getEmploydetails,'EMP_DESIGNATION_ID');
$emplDept = postData($getEmploydetails,'EMP_DEPT_ID');
$emplTerminal = postData($getEmploydetails,'EMP_LOC_ID');
$emplMail = postData($getEmploydetails,'EMP_EMAIL_ID');
$emplCertiname = postData($getEmploydetails,'CERT_NAME');
$emplCertiIdmain = postData($getEmploydetails,'COMP_CERT_ID');
if($getEmploydetails->CERT_START_DATE != ''){
$emplStartdate = date('d-m-Y',strtotime($getEmploydetails->CERT_START_DATE));
}else{
   $emplStartdate = ''; 
}
if($getEmploydetails->CERT_END_DATE != ''){
$emplEnddate = date('d-m-Y',strtotime($getEmploydetails->CERT_END_DATE));
}else{
    $emplEnddate = '';
}
$emplElistatus = postData($getEmploydetails,'CERT_STATUS');
$emplCertpath = postData($getEmploydetails,'CERT_PATH');
$emplCertimgname = postData($getEmploydetails,'CERT_FILE_NAME');
$emplCertimgextn = postData($getEmploydetails,'CERT_EXT');

if($emplCertimgname != ''){
    $compCertFilepath = $emplCertpath.$emplCertimgname;
}else{
    $compCertFilepath = '';
}

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
            <div class="container-fluid">

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">


                        <!-- general form elements -->
                        <div class="card card-headprimary">
                            <div class="row headingStyl">
                                <div class="col-md-12">
                                    <?php if($emploID != ''){ ?>
                                    <h4>Edit Employee</h4>
                                    <?php }else{ ?>
                                    <h4>Add Employee</h4>
                                    <?php } ?>
                                    
                                    <a href="<?php echo BASE_URL('master/employee') ?>">
                                        <!--<button type="button" class="btn btn-primary  float-right"><i class="fa fa-arrow-left"></i> Back</button>-->
                                        <button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>
                                </div>
                            </div>


                             <?php 
                             if(!empty($emploID)){
                                 echo form_open_multipart('master/employee/insertEmployee/'. encryptval($emploID) , 'class="form-horizontal" id="company-profile" novalidate'); 
                             }else{
                                 echo form_open_multipart('master/employee/insertEmployee/' , 'class="form-horizontal" id="company-profile" novalidate'); 
                             }
                               
                                
                                ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border emplBorder" >
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
                                                    'id' => 'emp_no',
                                                    'class' => 'form-control',
                                                    'value' => $emploentID,
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Employee ID',
                                                ];
                                                echo form_input($emNumdatas);
                                                ?>
                                                <span id="errEmpno" class="error"></span>
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
                                                    'value' => $emplName,
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
                                                echo form_dropdown('emp[gender]', $dropGender, $emplGender, $eGenddata);
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
                                                echo form_dropdown('emp[nationality]', $dropNation, $emplNation, $eNatndata);
                                                ?>
                                                 <span class="error"><?php echo form_error('emp[nationality]') ?></span>
                                            </div>
                                            <div class="otherNation"></div>
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
                                                echo form_dropdown('emp[desig]', $dropdesignation, $emplDesig, $eDesigdata);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[desig]') ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Terminal <span class="error"> * </span></label>
                                                <?php
                                                $eLoctdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'location',
                                                    'checkSelect' => 'select2',
                                                    'onchange' => 'getAjaxDepartment(this.value)',
                                                ];
                                                echo form_dropdown('emp[location]', $dropTermname, $emplTerminal, $eLoctdata);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[location]') ?></span>
                                            </div>
                                        </div>
           
                                    </div>

                                    <div class="row m-l-10">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Department <span class="error"> * </span></label>
                                                <?php
                                                $eDeptdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'depart',
                                                    'checkSelect' => 'select2',
                                                    
                                                ];
                                                echo form_dropdown('emp[depart]', $dropDepart, $emplDept, $eDeptdata);
                                                ?>
                                                <span class="error"><?php echo form_error('emp[depart]') ?></span>
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
                                                    'value' => $emplMail,
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
                                
                                
                            </div>
                            
                             <div class="card-body">
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border emplBorder" >
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
                                                    'value' => $emplCertiname,
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
                                                    'value' => $emplStartdate,
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
                                                    'value' => $emplEnddate,
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
                                                $eliStat = ['' => 'Select Status','Y' => 'Eligible','N' => 'Not Eligible'];
                                                echo form_dropdown('emp[elig_status]', $eliStat, $emplElistatus, $eDesigdata);
                                                ?>
                                            </div>
                                        </div>
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Competency Certificate </label>
                                                <input type="hidden" value="<?php echo $emplCertiIdmain; ?>" name="emp[mainCerti_id]">
                                                       <div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important; " data-provides="fileinput" >
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                        <?php
                                                        if ( $compCertFilepath != '') {
                                                           
                                                           if($emplCertimgextn != '' && $emplCertimgextn != '.pdf'){ ?>
                                                               <img src='<?php echo BASE_URL .  $compCertFilepath ?>' alt='<?php echo $emplCertimgname; ?>' />     
                                                          <?php }else{ ?>
                                                                <iframe src='<?php echo BASE_URL .  $compCertFilepath ?>'></iframe>
                                                         <?php  }
                                                            ?>
                                                        
                                                           <?php  } ?>
                                                    </div>
                                                    <p class="mini-txt">(pdf,gif, png, jpeg, jpg )</p>
                                                    <div class="file-pop" >                                                    
                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img src='<?php echo BASE_URL("/assets/images/photo.png"); ?>' class="imgupload"  style=" width: 30%; "/></span>
                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                            <input type="file" name="competency_certi[]" accept="image/*,application/pdf" class="compFile"></span>

                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="user_img[]" value="<?php echo  $compCertFilepath; ?>">
                                        
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
//                                            echo $emplotherCertimgname;
                                            
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
                                                            if($emplotherCertimgext != '' && $emplotherCertimgext != '.pdf'){
                                                            ?>
                                                      
                                                            <img src='<?php echo BASE_URL .  $compotherCertFilepath ?>' alt='<?php echo $emplotherCertimgname; ?>' style="height: 100%;" />     
                                                             <?php }else{ 
                                                                 ?>
                                                              <iframe src='<?php echo BASE_URL .  $compotherCertFilepath ?>'></iframe>
                                                              <!--<img src='<?php echo BASE_URL .  $compotherCertFilepath ?>' alt='<?php echo $emplotherCertimgname; ?>' />-->        
                                                           <?php  }} ?>
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
                                         <span class="float-right"><i class="fa fa-trash removeCerti"></i></span>
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
                                                            <img src='<?php echo BASE_URL .  $insuranceFilepath ?>' alt='<?php echo $insuranceFilename; ?>' style="height: 100%;" />     
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
                                        $data = array('id' => 'submitEmp', 'type' => 'submit', 'content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> SUBMIT', 'class' => 'btn btn-primary');
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

        $.validator.addMethod('filesize', function (value, element, param) {
           
            return this.optional(element) || (Math.round(element.files[0].size / (1024 * 1024)) <= 5)
        }, 'File size must be less than 5MB');

        $.validator.addClassRules("compFile", {
//            accept: "png|jpe?g|gif",
            required: false,
            filesize : true
        });

        $("#company-profile").validate({
            ignore: [],
            success: function (error) {
                error.removeClass("error");
                error.addClass("d-none");
            },

            rules: {
                "emp[emp_no]": {
                    required: true,
//                    alphanumeric: true,
                    alphanumericwithspecialchar: true,
                   
                },
                "emp[emp_name]": {
                    required: true,
//                     alphaspace: true,
                     alphaspacewithspecialchar: true,
                    maxlength: 50,
                    minlength: 2
                },
                "emp[gender]" : {
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
               "emp[nationality_other]" : {
                    required: true,
                    alphaspace: true,
                },
                "emp[compCerti_name]" : {
//                    alphaspace: true,
                    alphaspacewithspecialchar: true,
                    maxlength: 50,
                    minlength: 2
                }


            },
            messages: {
                "emp[emp_no]": {
                    required: "Employee Number is required"
                },
                "emp[emp_name]": {
                    required: "Employee Name is required"
                },
                "emp[gender]": {
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

      $.validator.addClassRules("oth_compCerti_name", {
//            alphaspace: true,
            alphaspacewithspecialchar: true,
            maxlength: 50,
            minlength: 2
        });

    });
    
    $(document).ready(function(){
        $("#nationality").on('change',function(){
            var natVal = $(this).val();
            var natOther = '<?php echo $emplNationother; ?>'
            if(natVal == 3){
                $(".otherNation").html('<input type="text" class="form-control" name="emp[nationality_other]" value="'+natOther+'">')
            }else{
                $(".otherNation").html('');
            }
         }).change();
        
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
                                                    <div class="file-pop" style=""><span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img src="'+baseUrl+'/assets/images/photo.png" class="imgupload" style=" width: 30%; "></span>\n\
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
                    
                var url = "<?php echo BASE_URL('master/employee/deleteParticularcerti') ?>";
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
//                                $(".othCompdetl").load(" .othCompdetl");
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
                swal('Sorry','Competency Details cannot be left empty','warning');
            }
            }else{
            if(count > 1){
                $(this).closest('.othercertiDet').remove();
            }else{
                swal('Sorry','Competency Details cannot be left empty','warning');
            }
        }
        })
        
        $(document).on('keyup','#emp_no',function(){
            var empId = $(this).val();
            var url = "<?php echo BASE_URL('master/employee/getEmploid') ?>";
                var data = {empId: empId,'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
           
           
                    $.ajax({
                        dataType : 'json',
                        type : 'ajax',
                        method : 'post',
                        data : data,
                        url : url,
                        success: function(resp){
                           
                           var Finstatus = resp.status;
                           var Finmsg = resp.msg;
                           if(Finstatus){
                              
//                               $("#errEmpno").html('<label id="emp_no-error" class="error" for="emp_no">'+Finmsg+'</label>');
                               $("#errEmpno").html(Finmsg);
                              
                           }else{
//                               $("#errEmpno").removeClass('error');
                               $("#errEmpno").html('');
                              
                           }
                         
                        }
                    });
        })
    });
</script>
