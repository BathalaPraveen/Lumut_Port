<?php
//echo "<pre>";
//print_R($getEmploydetails);
//exit;
$cntrID = postData($getEmploydetails,'CONT_AUTO_ID');
$cntroentID = postData($getEmploydetails,'CONT_ID');
if($cntroentID != ''){
   $finContaID = $cntroentID;
}else{
    $finContaID = $contrUniq;
}
$cntrName = postData($getEmploydetails,'CONT_NAME');
$cmpnyName = postData($getEmploydetails,'CONT_COMPANY');
$cntrGender = postData($getEmploydetails,'CONT_GENDER');
$cntrNation = postData($getEmploydetails,'CONT_NATIONALITY');
$cntrNationother = postData($getEmploydetails,'CONT_NATIONALITY_OTHER');
$cntrDesig = postData($getEmploydetails,'CONT_DESIGNATION');
$cntrSpec = postData($getEmploydetails,'CONT_SPECIAL');
$cntrPhone = postData($getEmploydetails,'CONT_PHONE_NO');
$cntrMail = postData($getEmploydetails,'CONT_EMAIL_ID');
$cntrAddress = postData($getEmploydetails,'CONT_ADDRESS');
$cntrCity = postData($getEmploydetails,'CONT_CITY');
$cntrCntry = postData($getEmploydetails,'CONT_COUNTRY');
$cntrPostcode = postData($getEmploydetails,'CONT_POSTAL_CODE');
$cntrDOB = postData($getEmploydetails,'CONT_DOB');
if($cntrDOB != ''){
    $finlDOB = date("d-m-Y",strtotime($cntrDOB));
}else{
    $finlDOB = '';
}
$cntrNric = postData($getEmploydetails,'CONT_ID_NUMBER');
$cntrIDtyp = postData($getEmploydetails,'CONT_ID_TYPE');

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
                                    <?php if($cntrID != ''){ ?>
                                    <h4>Edit Contractor</h4>
                                    <?php }else{ ?>
                                    <h4>Add Contractor</h4>
                                    <?php } ?>
                                    
                                    <a href="<?php echo BASE_URL('master/contractor') ?>"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>
                                </div>
                            </div>


                             <?php 
                             if(!empty($cntrID)){
                                 echo form_open_multipart('master/contractor/insertContractor/'. encryptval($cntrID) , 'class="form-horizontal" id="company-profile" novalidate'); 
                             }else{
                                 echo form_open_multipart('master/contractor/insertContractor/' , 'class="form-horizontal" id="company-profile" novalidate'); 
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
                                                <label>Contractor ID <span class="error"> * </span></label>
                                                <?php
                                                $conNumdatas = [
                                                    'name' => 'cont[cont_no]',
                                                    'class' => 'form-control',
                                                    'value' => $finContaID,
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'readonly' => 'readonly',
                                                    'placeholder' => 'Enter Contractor ID',
                                                ];
                                                echo form_input($conNumdatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[cont_no]') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Company Name <span class="error"> * </span></label>
                                                <?php
                                                $comNamedatas = [
                                                    'name' => 'cont[comp_name]',
                                                    'id' => 'comp_name',
                                                    'class' => 'form-control',
                                                    'value' => $cmpnyName,
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Company Name',
                                                ];
                                                echo form_input($comNamedatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[comp_name]') ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Contractor Name <span class="error"> * </span></label>
                                                <?php
                                                $conNamedatas = [
                                                    'name' => 'cont[cont_name]',
                                                    'id' => 'cont_name',
                                                    'class' => 'form-control',
                                                    'value' => $cntrName,
                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Contractor Name',
                                                ];
                                                echo form_input($conNamedatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[cont_name]') ?></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                     <div class="row m-t-10 m-l-10">
                                         
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Gender <span class="error"> * </span></label>
                                                <?php
                                                $eGenddata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'gender',
                                                    'checkSelect' => 'select2',
                                                ];
                                                echo form_dropdown('cont[gender]', $dropGender, $cntrGender, $eGenddata);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[gender]') ?></span>
                                            </div>
                                        </div>
                                         
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Date of Birth <span class="error"> * </span></label>
                                                <?php
                                                $conDobdatas = [
                                                    'name' => 'cont[dob]',
                                                    'id' => 'dob',
                                                    'class' => 'form-control singledaterangepicker',
                                                    'value' => $finlDOB,
//                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter DOB',
                                                ];
                                                echo form_input($conDobdatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[dob]') ?></span>
                                            </div>
                                        </div>
                                          <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Email ID <span class="error"> * </span></label>
                                                <?php
                                                $conMaildatas = [
                                                    'name' => 'cont[cont_mail]',
                                                    'id' => 'cont_mail',
                                                    'class' => 'form-control',
                                                    'value' => $cntrMail,
                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Mail ID',
                                                ];
                                                echo form_input($conMaildatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[cont_mail]') ?></span>
                                            </div>
                                        </div>
                                            
                                        </div>
                                    
                                    <div class="row m-t-10 m-l-10">
                                         
                                            <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Phone No <span class="error"> * </span></label>
                                                <?php
                                                $conPhonedatas = [
                                                    'name' => 'cont[phone_num]',
                                                    'id' => 'phone_num',
                                                    'class' => 'form-control',
                                                    'value' => $cntrPhone,
                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Phone Number',
                                                ];
                                                echo form_input($conPhonedatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[phone_num]') ?></span>
                                            </div>
                                        </div>
                                            
                                            <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Address <span class="error"> * </span></label>
                                                <?php
                                                $conAddrdatas = [
                                                    'name' => 'cont[address]',
                                                    'id' => 'address',
                                                    'class' => 'form-control',
                                                    'value' => $cntrAddress,
                                                    'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Address',
                                                    'rows' => 2,
                                                    'cols' => 5,
                                                ];
                                                echo form_textarea($conAddrdatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[address]') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Company Specialization <span class="error"> * </span></label>
                                                <?php
                                                $conSpecdatas = [
                                                    'name' => 'cont[comp_spec]',
                                                    'id' => 'comp_spec',
                                                    'class' => 'form-control',
                                                    'value' => $cntrSpec,
                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Company Specialization',
                                                ];
                                                echo form_input($conSpecdatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[comp_spec]') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-10 m-l-10">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Designation <span class="error"> * </span></label>
                                                <?php
                                                $eDesigdata = [
                                                    'class' => 'form-control ',
                                                    'id' => 'desig',
                                                    'name' => 'cont[desig]',
                                                    'value' => $cntrDesig
                                                    
                                                ];
                                                echo form_input($eDesigdata);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[desig]') ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Contractor ID Type </label>
                                                <?php
                                                $eIdtypdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'contIdtyp',
                                                    'checkSelect' => 'select2',
                                                ];
                                                $idTypdata = ['' => 'Select ID Type','NRIC' => 'NRIC','PASSPORT' => 'PASSPORT'];
                                                echo form_dropdown('cont[contIdtyp]', $idTypdata, $cntrIDtyp, $eIdtypdata);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[contIdtyp]') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">-
                                                <label>NRIC/Passport No </label>
                                                <?php
                                                $conNricdatas = [
                                                    'name' => 'cont[nric]',
                                                    'id' => 'nric',
                                                    'class' => 'form-control',
                                                    'value' => $cntrNric,
//                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter NRIC/Passport No',
                                                ];
                                                echo form_input($conNricdatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[nric]') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="row m-t-10 m-l-10">
                                            <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>City <span class="error"> * </span></label>
                                                <?php
                                                $conCitydatas = [
                                                    'name' => 'cont[city]',
                                                    'id' => 'city',
                                                    'class' => 'form-control',
                                                    'value' => $cntrCity,
                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter City',
                                                ];
                                                echo form_input($conCitydatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[city]') ?></span>
                                            </div>
                                        </div>
                                            
                                            <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Country <span class="error"> * </span></label>
                                                <?php
                                                $conCountrydatas = [
                                                    'name' => 'cont[country]',
                                                    'id' => 'country',
                                                    'class' => 'form-control',
                                                    'value' => $cntrCntry,
                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Country',
                                                ];
                                                echo form_input($conCountrydatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[country]') ?></span>
                                            </div>
                                        </div>
                                            
                                            <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Postal Code <span class="error"> * </span></label>
                                                <?php
                                                $conPostaldatas = [
                                                    'name' => 'cont[pos_code]',
                                                    'id' => 'pos_code',
                                                    'class' => 'form-control',
                                                    'value' => $cntrPostcode,
                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Postal Code',
                                                    
                                                ];
                                                echo form_input($conPostaldatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[pos_code]') ?></span>
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
                                                echo form_dropdown('cont[nationality]', $dropNation, $cntrNation, $eNatndata);
                                                ?>
                                                 <span class="error"><?php echo form_error('cont[nationality]') ?></span>
                                            </div>
                                            <div class="otherNation"></div>
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
                                                    'name' => 'cont[compCerti_name]',
                                                    'id' => 'compCerti_name',
                                                    'class' => 'form-control',
                                                    'value' => $emplCertiname,
//                                                'required' => true,
                                                    'autocomplete' => 'off',
                                                    'placeholder' => 'Enter Certificate Name',
                                                ];
                                                echo form_input($emCertnamedatas);
                                                ?>
                                                <span class="error"><?php echo form_error('cont[compCerti_name]') ?></span>
                                            </div>
                                        </div>
                                       
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Start Date </label>
                                               <?php
                                                $emCertnamedatas = [
                                                    'name' => 'cont[start_date]',
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
                                                    'name' => 'cont[end_date]',
                                                    'id' => 'compCerti_name',
                                                    'class' => 'form-control singledaterangepicker',
                                                    'value' => $emplEnddate,
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
                                                <label>Status (Eligible/Not Eligible to apply PTW) </label>
                                                <?php
                                                $eDesigdata = [
                                                    'class' => 'form-control select2',
                                                    'id' => 'elig_status',
                                                ];
                                                $eliStat = ['' => 'Select Status','Y' => 'Eligible','N' => 'Not Eligible'];
                                                echo form_dropdown('cont[elig_status]', $eliStat, $emplElistatus, $eDesigdata);
                                                ?>
                                            </div>
                                        </div>
                                        
                                         <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Competency Certificate </label>
                                                <input type="hidden" value="<?php echo $emplCertiIdmain; ?>" name="cont[mainCerti_id]">
                                                
                                                       <div class="fileinput fileinput-new apprFileinput" style="    margin-top: -30px !important; " data-provides="fileinput" >
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                        <?php
                                                       
                                                        if ( $compCertFilepath != '') {
                                                             if($emplCertimgextn != '' && $emplCertimgextn != '.pdf'){ ?>
                                                                 <img src='<?php echo BASE_URL .  $compCertFilepath ?>'  style="height: 100%;" />     
                                                           <?php  }else{ ?>
                                                                 <iframe src='<?php echo BASE_URL .  $compCertFilepath ?>'></iframe>
                                                          <?php   }
                                                            ?>
                                                        
                                                            
                                                        <?php } ?>
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
                                         <span class="float-right "><i class="fa fa-trash removeCerti"></i></span>
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
                "cont[comp_name]": {
                    required: true,
//                     alphanumeric: true,
                     alphanumericwithspecialchar: true,
                   
                },
                "cont[cont_name]": {
                    required: true,
//                     alphaspace: true,
                     alphaspacewithspecialchar: true,
                     maxlength: 50,
                    minlength: 2
                   
                },
                "cont[cont_mail]": {
                    required: true,
                    email: true

                },
                "cont[comp_spec]": {
                    required: true,
//                     alphaspace: true,
                     alphaspacewithspecialchar: true,
                   
                },
                "cont[phone_num]": {
                    required: true,
                    number: true,
                    maxlength: 16,
                    minlength: 10
                   
                },
               "cont[address]" : {
                    required: true,
//                    accept_address: true,
                    programming_char:true,
                  },
               "cont[city]" : {
                    required: true,
                    alphaspace: true,
                  },
               "cont[country]" : {
                    required: true,
                    alphaspace: true,
                  },
               "cont[pos_code]" : {
                    required: true,
                    number: true,
                    maxlength: 10,
                    minlength: 5
                  },
               "cont[gender]" : {
                    required: true,
                  },
                "cont[nationality]" : {
                    required: true,
                  },
                "cont[desig]" : {
                    required: true,
//                    alphaspace :true,
                    alphaspacewithspecialchar: true,
                    maxlength: 50,
                    minlength: 3
                  },
                "cont[nationality_other]" : {
                     required: true,
                    alphaspace: true,
                 },
                 "cont[compCerti_name]" : {
//                    alphaspace: true,
                    alphaspacewithspecialchar: true,
                    maxlength: 50,
                    minlength: 2
                }
                
            },
            messages: {
                "cont[comp_name]": {
                    required: "Company Name is required"
                },
                "cont[cont_name]": {
                    required: "Contractor Name is required"
                },
                "cont[cont_mail]": {
                    required: "Contractor Mail ID is required"
                },
                "cont[comp_spec]": {
                    required: "Company Specialization is required"
                },
                "cont[phone_num]": {
                    required: "Phone Number is required"
                },
                "cont[address]": {
                    required: "Address is required"
                },
                "cont[city]": {
                    required: "City is required"
                },
                "cont[country]": {
                    required: "Country is required"
                },
                "cont[pos_code]": {
                    required: "Postal Code is required"
                },
                "cont[gender]": {
                    required: "Gender is required"
                },
                "cont[nationality]": {
                    required: "Nationality is required"
                },
                "cont[desig]": {
                    required: "Designation is required"
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
            var natOther = '<?php echo $cntrNationother; ?>'
            if(natVal == 3){
                $(".otherNation").html('<input type="text" class="form-control" name="cont[nationality_other]" value="'+natOther+'">')
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
                    
                var url = "<?php echo BASE_URL('master/contractor/deleteParticularcerti') ?>";
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
                              
//                             swal('Success','resp.msg','success');
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
       
        
    });
</script>

