<?php
$editId = postData($getDailyActdatas, 'ATAR_AUTO_ID', 0);
$formTitle = ($editId > 0 ) ? 'Edit Daily Observation' : 'Add Daily Observation';


$editTerminalId = postData($getDailyActdatas, 'ATAR_LOC_ID', $this->input->post('udaily[ATAR_LOC_ID]'));
$editSpecificLocationId = postData($getDailyActdatas, 'ATAR_SPEC_LOC_ID', $this->input->post('udaily[ATAR_SPEC_LOC_ID]'));

$aPERMIT_TO_WORK = postData($obsdetails, 'PERMIT_TO_WORK', $this->input->post('udaily[PERMIT_TO_WORK]'));
$aHEALTH = postData($obsdetails, 'HEALTH', $this->input->post('udaily[HEALTH]'));
$aFIRE = postData($obsdetails, 'FIRE', $this->input->post('udaily[FIRE]'));
$aHOUSEKEEPING = postData($obsdetails, 'HOUSEKEEPING', $this->input->post('udaily[HOUSEKEEPING]'));
$aPPE = postData($obsdetails, 'PPE', $this->input->post('udaily[PPE]'));
$aPOWER = postData($obsdetails, 'POWER', $this->input->post('udaily[POWER]'));
$aPLANT = postData($obsdetails, 'PLANT', $this->input->post('udaily[PLANT]'));
$aLIFTING = postData($obsdetails, 'LIFTING', $this->input->post('udaily[LIFTING]'));
$aSCAFFOLDING = postData($obsdetails, 'SCAFFOLDING', $this->input->post('udaily[SCAFFOLDING]'));
$aBARRIERS = postData($obsdetails, 'BARRIERS', $this->input->post('udaily[BARRIERS]'));
$aOTHERS = postData($obsdetails, 'OTHERS', $this->input->post('udaily[OTHERS]'));
$aACCESS = postData($obsdetails, 'ACCESS', $this->input->post('udaily[ACCESS]'));
$aEXCAVATION = postData($obsdetails, 'EXCAVATION', $this->input->post('udaily[EXCAVATION]'));
$aGASES = postData($obsdetails, 'GASES', $this->input->post('udaily[GASES]'));
$aHAZARDOUS = postData($obsdetails, 'HAZARDOUS', $this->input->post('udaily[HAZARDOUS]'));
$aELECTRICAL = postData($obsdetails, 'ELECTRICAL', $this->input->post('udaily[ELECTRICAL]'));
$aSAFETY = postData($obsdetails, 'SAFETY', $this->input->post('udaily[SAFETY]'));
$aHAND = postData($obsdetails, 'HAND', $this->input->post('udaily[HAND]'));
$aWORK_AT_HEIGHT = postData($obsdetails, 'WORK_AT_HEIGHT', $this->input->post('udaily[WORK_AT_HEIGHT]'));
$aRADIATION = postData($obsdetails, 'RADIATION', $this->input->post('udaily[RADIATION]'));
$aENVIRONMENT = postData($obsdetails, 'ENVIRONMENT', $this->input->post('udaily[ENVIRONMENT]'));
$aOTH = postData($obsdetails, 'OTH', $this->input->post('udaily[OTH]'));

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
    .mini-txt{
        text-align: center;
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
                                    <a href="<?php echo BASE_URL('atar/daily/dailyInfo') ?>"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>
                                </div>
                            </div>


                            <div class="card-body">
                                <?php
                                $getDailyid = isset($getDailyActdatas->ATAR_AUTO_ID) && !empty($getDailyActdatas->ATAR_AUTO_ID) ? $getDailyActdatas->ATAR_AUTO_ID : '';
                                ?>
                                <?php echo form_open_multipart('atar/daily/saveDaily/' . encryptval($getDailyid), 'class="form-horizontal" id="company-profile" novalidate'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class="">  Daily Observation </h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body col-md-12">

                                    <div class="row m-t-10 m-l-10">
                                        <div class="col-md-4">

                                            <label>Reporter Name </label>
                                            <?php
                                            $Reporter = isset($getDailyActdatas->Reporter) && !empty($getDailyActdatas->Reporter) ? $getDailyActdatas->Reporter : $getUserInfo['NAME'];
                                            $cMaildatas = [
                                                'name' => 'udaily[ATAR_REPORTER]',
                                                'class' => 'form-control',
                                                'value' => $Reporter,
                                                'autocomplete' => 'off',
                                                'readonly' => TRUE
                                            ];
                                            echo form_input($cMaildatas);
                                            ?>
                                            <label class="error"><?php echo form_error('udaily[ATAR_REPORTER]') ?></label>

                                        </div>
                                        <div class="col-md-4" style="display:none;">

                                            <label>Reporter ID </label>
                                            <?php
                                            $ReporterID = isset($getDailyActdatas->ATAR_REPORTER_ID) && !empty($getDailyActdatas->ATAR_REPORTER_ID) ? $getDailyActdatas->ATAR_REPORTER_ID : $getUserId;
                                            $crepdatas = [
                                                'name' => 'udaily[ATAR_REPORTER_ID]',
                                                'class' => 'form-control',
                                                'value' => $ReporterID,
                                                'autocomplete' => 'off',
                                                'readonly' => TRUE
                                            ];
                                            echo form_input($crepdatas);
                                            ?>
                                            <label class="error"><?php echo form_error('udaily[ATAR_REPORTER_ID]') ?></label>

                                        </div>

                                        <div class="col-md-4">

                                            <label>Position<span class="error">*</span></label>
                                            <?php
                                            $positionName = isset($getDailyActdatas->desig) && !empty($getDailyActdatas->desig) ? $getDailyActdatas->desig : $getUserInfo['DESIGNATION'];
                                            $cpositiondata = array(
                                                'name' => 'udaily[DES_NAME]',
                                                'id' => 'DES_NAME',
                                                'placeholder' => 'Enter Position',
                                                'class' => 'form-control',
                                                'value' => $positionName,
                                                'readonly' => TRUE,
                                                'autocomplete' => 'off'
                                            );

                                            echo form_input($cpositiondata);
                                            ?>
                                            <label class="error"><?php echo form_error('udaily[DES_NAME]') ?></label>

                                        </div>
                                        <div class="col-md-4" style="display:none;">

                                            <label>Position ID </label>
                                            <?php
                                            $positionID = isset($getDailyActdatas->USER_DESINATION_ID) && !empty($getDailyActdatas->USER_DESINATION_ID) ? $getDailyActdatas->USER_DESINATION_ID : $getUserInfo['DESIGNATIONID'];
                                            $positioniddatas = [
                                                'name' => 'udaily[USER_DESINATION_ID]',
                                                'class' => 'form-control',
                                                'value' => $positionID,
                                                'autocomplete' => 'off',
                                                'readonly' => TRUE
                                            ];
                                            echo form_input($positioniddatas);
                                            ?>
                                            <label class="error"><?php echo form_error('udaily[USER_DESINATION_ID]') ?></label>

                                        </div>
                                        <div class="col-md-4">

                                            <label>Location <span class="error"> * </span></label>
                                            <?php
                                            $eLoctdata = [
                                                'class' => 'form-control select2',
                                                'id' => 'location',
                                                'checkSelect' => 'select2',
                                                'onchange' => 'getAjaxLocation(this.value)',
                                            ];
                                            echo form_dropdown('udaily[ATAR_LOC_ID]', $getLocInfo, $editTerminalId, $eLoctdata);
                                            ?>
                                            <span class="error"><?php echo form_error('udaily[ATAR_LOC_ID]') ?></span>

                                        </div>
                                    </div>
                                    <div class="row  m-l-10">
                                        <div class="col-sm-4 m-b-10">

                                            <label>Specific Location <span class="error"> * </span></label>
                                            <?php
                                            $eSpecificdata = [
                                                'class' => 'form-control select2',
                                                'id' => 'specific_loc',
                                                'checkSelect' => 'select2',
                                            ];
                                            echo form_dropdown('udaily[ATAR_SPEC_LOC_ID]', $getSpecLocInfo, $editSpecificLocationId, $eSpecificdata);
                                            ?>
                                            <span class="error"><?php echo form_error('udaily[ATAR_SPEC_LOC_ID]') ?></span>

                                        </div>
                                         <?php
                                              $dnone = ($editSpecificLocationId == -1) ? '' : 'd-none';
                                           ?>
                                        <div class="col-sm-4 m-b-10 specificOther <?php echo $dnone ;?>">
                                            <label><br></label>
                                            <?php
                                             $speclocother = isset($getDailyActdatas->ATAR_SPEC_LOC_OTHER) && !empty($getDailyActdatas->ATAR_SPEC_LOC_OTHER) ? $getDailyActdatas->ATAR_SPEC_LOC_OTHER : "";
                                        
                                              $data = [
                                                  'name' => 'udaily[ATAR_SPEC_LOC_OTHER]',
                                                  'placeholder' => 'Enter Specific Location(Other)',
                                                  'id' => 'ATAR_SPEC_LOC_OTHER',
                                                  'class' => 'form-control ' . $dnone,
                                                  'value' => $speclocother
                                              ];
                                              echo form_input($data);
                                              ?>
                                        </div>
                                        <div class="col-md-4">

                                            <label>Date and Time </label>
                                            <?php
                                            $dateTimeatar = isset($getDailyActdatas->ATAR_REPORT_DATETIME) && !empty($getDailyActdatas->ATAR_REPORT_DATETIME) ? date('Y-m-d', strtotime($getDailyActdatas->ATAR_REPORT_DATETIME)) : $currentDateTime;
                                            $cdatetimedatas = [
                                                'name' => 'udaily[ATAR_REPORT_DATETIME]',
                                                'class' => 'form-control',
                                                'value' => $dateTimeatar,
                                                'autocomplete' => 'off',
                                                'readonly' => TRUE
                                            ];
                                            echo form_input($cdatetimedatas);
                                            ?>
                                            <label class="error"><?php echo form_error('udaily[ATAR_REPORT_DATETIME]') ?></label>

                                        </div>

                                    </div>

                                </div>
                               <div class="panel-body col-md-12">
                                    <div class="row m-t-10 m-l-10">
                                        <div class="col-sm-12 table-responsive">
                                            <table id="" class="table table-bordered table-striped">
                                                <thead style="background: linear-gradient(45deg, #f3ba32, #da9f11);">
                                                    <tr>
                                                        <th> ITEM </th>
                                                        <th> STATUS (Y/N) </th>
                                                        <th> ITEM </th>
                                                        <th> STATUS (Y/N) </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1. PERMIT TO WORK SYSTEM </td>
                                                        <td>
                                                            <?php
                                                            
                                                            // $permitDetails = [
                                                            //     'id' => 'PERMIT_TO_WORK',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $permitdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[PERMIT_TO_WORKS]', $permitdata, $aPERMIT_TO_WORK, $permitDetails);
                                                            // echo form_hidden('udaily[PERMIT_TO_WORK]',$aPERMIT_TO_WORK);
                                                            if (!isset($aPERMIT_TO_WORK)) {
                                                                $aPERMIT_TO_WORK = 'Y';
                                                            }
                                                            ?>                                               
                                                                <input type="hidden" name="udaily[PERMIT_TO_WORK]" value="N">
                                                                <input type="checkbox" name="udaily[PERMIT_TO_WORK]" value="Y" <?php echo ($aPERMIT_TO_WORK == 'Y') ? 'checked' : ''; ?>>
                                                        </td>
                                                        <td>12. ACCESS & EGRESS</td>
                                                        <td>
                                                            <?php
                                                            // $ACCESSDetails = [
                                                            //     'id' => 'ACCESS',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $ACCESSdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[ACCESSS]', $ACCESSdata, $aACCESS, $ACCESSDetails);
                                                            // echo form_hidden('udaily[ACCESS]',$aACCESS);
                                                            ?>
                                                            <?php
                                                            // Set default to 'Y' if not set
                                                            if (!isset($aACCESS)) {
                                                                $aACCESS = 'Y';
                                                            }
                                                            ?>                                                         
                                                                <input type="hidden" name="udaily[ACCESS]" value="N">
                                                                <input type="checkbox" name="udaily[ACCESS]" value="Y" <?php echo ($aACCESS == 'Y') ? 'checked' : ''; ?>>                                                        
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2. HEALTH & WELFARE</td>
                                                        <td>
                                                            <?php
                                                            // $HEALTHDetails = [
                                                            //     'id' => 'HEALTH',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $HEALTHdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[HEALTHS]', $HEALTHdata, $aHEALTH, $HEALTHDetails);
                                                            // echo form_hidden('udaily[HEALTH]',$aHEALTH);
                                                            ?>
                                                            <?php
                                                            // Set default value to 'Y' if not already set
                                                            if (!isset($aHEALTH)) {
                                                                $aHEALTH = 'Y';
                                                            }
                                                            ?>
                                                                <input type="hidden" name="udaily[HEALTH]" value="N">
                                                                <input type="checkbox" name="udaily[HEALTH]" value="Y" <?php echo ($aHEALTH == 'Y') ? 'checked' : ''; ?>>
                                                        </td>
                                                        <td>13. EXCAVATION / EARTHWORKS</td>
                                                        <td>
                                                            <?php
                                                            // $EXCAVATIONDetails = [
                                                            //     'id' => 'EXCAVATION',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $EXCAVATIONdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[EXCAVATIONS]', $EXCAVATIONdata, $aEXCAVATION, $EXCAVATIONDetails);
                                                            // echo form_hidden('udaily[EXCAVATION]',$aEXCAVATION);
                                                            ?>
                                                            <?php
                                                            // Set default value to 'Y' if not already set
                                                            if (!isset($aEXCAVATION)) {
                                                                $aEXCAVATION = 'Y';
                                                            }
                                                            ?>

                                                                <input type="hidden" name="udaily[EXCAVATION]" value="N">
                                                                <input type="checkbox" name="udaily[EXCAVATION]" value="Y" <?php echo ($aEXCAVATION == 'Y') ? 'checked' : ''; ?>>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3. FIRE PRECAUTIONS</td>
                                                        <td>
                                                            <?php
                                                            // $FIREDetails = [
                                                            //     'id' => 'FIRE',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $FIREdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[FIRES]', $permitdata, $aFIRE, $FIREDetails);
                                                            // echo form_hidden('udaily[FIRE]',$aFIRE);
                                                            ?>
                                                            <?php
                                                            // Set default value to 'Y' if not already set
                                                            if (!isset($aFIRE)) {
                                                                $aFIRE = 'Y';
                                                            }
                                                            ?>
                                                                <input type="hidden" name="udaily[FIRE]" value="N">
                                                                <input type="checkbox" name="udaily[FIRE]" value="Y" <?php echo ($aFIRE == 'Y') ? 'checked' : ''; ?>>
                                                        </td>
                                                        <td>14. GASES / FLAMMABLE LIQUIDS</td>
                                                        <td>
                                                            <?php
                                                            // $GASESDetails = [
                                                            //     'id' => 'GASES',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $GASESdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[GASESS]', $GASESdata, $aGASES, $GASESDetails);
                                                            // echo form_hidden('udaily[GASES]',$aGASES);
                                                            ?>
                                                            <?php
                                                            // Set default to 'Y' if not already defined
                                                            if (!isset($aGASES)) {
                                                                $aGASES = 'Y';
                                                            }
                                                            ?>

                                                                 <input type="hidden" name="udaily[GASES]" value="N">
                                                                <input type="checkbox" name="udaily[GASES]" value="Y" <?php echo ($aGASES == 'Y') ? 'checked' : ''; ?>>
                                                              

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>4. HOUSEKEEPING</td>
                                                        <td>
                                                            <?php
                                                            // $HOUSEKEEPINGDetails = [
                                                            //     'id' => 'HOUSEKEEPING',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $HOUSEKEEPINGdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[HOUSEKEEPINGS]', $HOUSEKEEPINGdata, $aHOUSEKEEPING, $HOUSEKEEPINGDetails);
                                                            // echo form_hidden('udaily[HOUSEKEEPING]',$aHOUSEKEEPING);
                                                            ?>
                                                            <?php
                                                            // Set default to 'Y' if not already defined
                                                            if (!isset($aHOUSEKEEPING)) {
                                                                $aHOUSEKEEPING = 'Y';
                                                            }
                                                            ?>

                                                                <input type="hidden" name="udaily[HOUSEKEEPING]" value="N">
                                                                <input type="checkbox" name="udaily[HOUSEKEEPING]" value="Y" <?php echo ($aHOUSEKEEPING == 'Y') ? 'checked' : ''; ?>>
                                                            

                                                        </td>
                                                        <td>15. HAZARDOUS SUBSTANCES</td>
                                                        <td>
                                                            <?php
                                                            // $HAZARDOUSDetails = [
                                                            //     'id' => 'HAZARDOUS',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $HAZARDOUSdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[HAZARDOUSS]', $HAZARDOUSdata, $aHAZARDOUS, $HAZARDOUSDetails);
                                                            // echo form_hidden('udaily[HAZARDOUS]',$aHAZARDOUS);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aHAZARDOUS)) {
                                                                $aHAZARDOUS = 'Y';
                                                            }
                                                            ?>

                                                                <input type="hidden" name="udaily[HAZARDOUS]" value="N">
                                                                <input type="checkbox" name="udaily[HAZARDOUS]" value="Y" <?php echo ($aHAZARDOUS == 'Y') ? 'checked' : ''; ?>>
                                                            

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>5. PPE / SAFETY EQUIPMENT</td>
                                                        <td>
                                                            <?php
                                                            // $PPEDetails = [
                                                            //     'id' => 'PPE',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $PPEdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[PPES]', $PPEdata, $aPPE, $PPEDetails);
                                                            // echo form_hidden('udaily[PPE]',$aPPE);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aPPE)) {
                                                                $aPPE = 'Y';
                                                            }
                                                            ?>

                                                                <input type="hidden" name="udaily[PPE]" value="N">
                                                                <input type="checkbox" name="udaily[PPE]" value="Y" <?php echo ($aPPE == 'Y') ? 'checked' : ''; ?>>


                                                        </td>
                                                        <td>16. ELECTRICAL</td>
                                                        <td>
                                                            <?php
                                                            // $ELECTRICALDetails = [
                                                            //     'id' => 'ELECTRICAL',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $ELECTRICALdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[ELECTRICALS]', $ELECTRICALdata, $aELECTRICAL, $ELECTRICALDetails);
                                                            // echo form_hidden('udaily[ELECTRICAL]',$aELECTRICAL);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aELECTRICAL)) {
                                                                $aELECTRICAL = 'Y';
                                                            }
                                                            ?>

                                                                <input type="hidden" name="udaily[ELECTRICAL]" value="N">
                                                                <input type="checkbox" name="udaily[ELECTRICAL]" value="Y" <?php echo ($aELECTRICAL == 'Y') ? 'checked' : ''; ?>>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>6. POWER TOOLS</td>
                                                        <td>
                                                            <?php
                                                            // $POWERDetails = [
                                                            //     'id' => 'POWER',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $POWERdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[POWERS]', $POWERdata, $aPOWER, $POWERDetails);
                                                            // echo form_hidden('udaily[POWER]',$aPOWER);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aPOWER)) {
                                                                $aPOWER = 'Y';
                                                            }
                                                            ?>
                                                                <input type="hidden" name="udaily[POWER]" value="N">
                                                                <input type="checkbox" name="udaily[POWER]" value="Y" <?php echo ($aPOWER == 'Y') ? 'checked' : ''; ?>>
                                                           

                                                        </td>
                                                        <td>17. SAFETY SIGNS/NOTICES</td>
                                                        <td>
                                                            <?php
                                                            // $SAFETYDetails = [
                                                            //     'id' => 'SAFETY',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $SAFETYdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[SAFETYS]', $SAFETYdata, $aSAFETY, $SAFETYDetails);
                                                            // echo form_hidden('udaily[SAFETY]',$aSAFETY);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aSAFETY)) {
                                                                $aSAFETY = 'Y';
                                                            }
                                                            ?>
                                                                <input type="hidden" name="udaily[SAFETY]" value="N">
                                                                <input type="checkbox" name="udaily[SAFETY]" value="Y" <?php echo ($aSAFETY == 'Y') ? 'checked' : ''; ?>>                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>7. PLANT / MACHINERY/CERTIFICATION</td>
                                                        <td>
                                                            <?php
                                                            // $PLANTDetails = [
                                                            //     'id' => 'PLANT',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $PLANTdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[PLANTS]', $PLANTdata, $aPLANT, $PLANTDetails);
                                                            // echo form_hidden('udaily[PLANT]',$aPLANT);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aPLANT)) {
                                                                $aPLANT = 'Y';
                                                            }
                                                            ?>
                                                                <input type="hidden" name="udaily[PLANT]" value="N">
                                                                <input type="checkbox" name="udaily[PLANT]" value="Y" <?php echo ($aPLANT == 'Y') ? 'checked' : ''; ?>>
                                                               

                                                        </td>
                                                        <td>18. HAND TOOLS</td>
                                                        <td>
                                                            <?php
                                                            // $HANDDetails = [
                                                            //     'id' => 'HAND',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $HANDdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[HANDS]', $HANDdata, $aHAND, $HANDDetails);
                                                            // echo form_hidden('udaily[HAND]',$aHAND);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aHAND)) {
                                                                $aHAND = 'Y';
                                                            }
                                                            ?>
                                                                <input type="hidden" name="udaily[HAND]" value="N">
                                                                <input type="checkbox" name="udaily[HAND]" value="Y" <?php echo ($aHAND == 'Y') ? 'checked' : ''; ?>>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>8. LIFTING GEAR / APPLIANCES</td>
                                                        <td>
                                                            <?php
                                                            // $LIFTINGDetails = [
                                                            //     'id' => 'LIFTING',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $LIFTINGdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[LIFTINGS]', $LIFTINGdata, $aLIFTING, $LIFTINGDetails);
                                                            // echo form_hidden('udaily[LIFTING]',$aLIFTING);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aLIFTING)) {
                                                            $aLIFTING = 'Y';
                                                            }
                                                            ?>
                                                            <input type="hidden" name="udaily[LIFTING]" value="N">
                                                            <input type="checkbox" name="udaily[LIFTING]" value="Y" <?php echo ($aLIFTING == 'Y') ? 'checked' : ''; ?>>
                                                        </td>
                                                        <td>19. WORK AT HEIGHT</td>
                                                        <td>
                                                            <?php
                                                            // $WORK_AT_HEIGHTDetails = [
                                                            //     'id' => 'WORK_AT_HEIGHT',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $WORK_AT_HEIGHTdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[WORK_AT_HEIGHTS]', $WORK_AT_HEIGHTdata, $aWORK_AT_HEIGHT, $WORK_AT_HEIGHTDetails);
                                                            // echo form_hidden('udaily[WORK_AT_HEIGHT]',$aWORK_AT_HEIGHT);

                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aWORK_AT_HEIGHT)) {
                                                                $aWORK_AT_HEIGHT = 'Y';
                                                            }
                                                            ?>

                                                                <input type="hidden" name="udaily[WORK_AT_HEIGHT]" value="N">
                                                                <input type="checkbox" name="udaily[WORK_AT_HEIGHT]" value="Y" <?php echo ($aWORK_AT_HEIGHT == 'Y') ? 'checked' : ''; ?>>
                                                            
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>9. SCAFFOLDING</td>
                                                        <td>
                                                            <?php
                                                            // $SCAFFOLDINGDetails = [
                                                            //     'id' => 'SCAFFOLDING',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $SCAFFOLDINGdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[SCAFFOLDINGS]', $SCAFFOLDINGdata, $aSCAFFOLDING, $SCAFFOLDINGDetails);
                                                            // echo form_hidden('udaily[SCAFFOLDING]',$aSCAFFOLDING);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aSCAFFOLDING)) {
                                                                $aSCAFFOLDING = 'Y';
                                                            }
                                                            ?>

                                                                <input type="hidden" name="udaily[SCAFFOLDING]" value="N">
                                                                <input type="checkbox" name="udaily[SCAFFOLDING]" value="Y" <?php echo ($aSCAFFOLDING == 'Y') ? 'checked' : ''; ?>>


                                                        </td>
                                                        <td>20. RADIATION</td>
                                                        <td>
                                                            <?php
                                                            // $RADIATIONDetails = [
                                                            //     'id' => 'RADIATION',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $RADIATIONdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[RADIATIONS]', $RADIATIONdata, $aRADIATION, $RADIATIONDetails);
                                                            // echo form_hidden('udaily[RADIATION]',$aRADIATION);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aRADIATION)) {
                                                                $aRADIATION = 'Y';
                                                            }
                                                            ?>
                                                                <input type="hidden" name="udaily[RADIATION]" value="N">
                                                                <input type="checkbox" name="udaily[RADIATION]" value="Y" <?php echo ($aRADIATION == 'Y') ? 'checked' : ''; ?>>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>10. BARRIERS</td>
                                                       <td>
                                                            <?php
                                                            // $BARRIERSDetails = [
                                                            //     'id' => 'BARRIERS',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $BARRIERSdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[BARRIERSS]', $BARRIERSdata, $aBARRIERS, $BARRIERSDetails);
                                                            // echo form_hidden('udaily[BARRIERS]',$aBARRIERS);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aBARRIERS)) {
                                                                $aBARRIERS = 'Y';
                                                            }
                                                            ?>
                                                                <input type="hidden" name="udaily[BARRIERS]" value="N">
                                                                <input type="checkbox" name="udaily[BARRIERS]" value="Y" <?php echo ($aBARRIERS == 'Y') ? 'checked' : ''; ?>>                                                            
                                                        </td>
                                                        <td>21. ENVIRONMENT</td>
                                                        <td>
                                                            <?php
                                                            // $ENVIRONMENTDetails = [
                                                            //     'id' => 'ENVIRONMENT',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $ENVIRONMENTdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[ENVIRONMENTS]', $ENVIRONMENTdata, $aENVIRONMENT, $ENVIRONMENTDetails);
                                                            // echo form_hidden('udaily[ENVIRONMENT]',$aENVIRONMENT);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aENVIRONMENT)) {
                                                                $aENVIRONMENT = 'Y';
                                                            }
                                                            ?>

                                                                <input type="hidden" name="udaily[ENVIRONMENT]" value="N">
                                                                <input type="checkbox" name="udaily[ENVIRONMENT]" value="Y" <?php echo ($aENVIRONMENT == 'Y') ? 'checked' : ''; ?>>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>11. OTHERS</td>
                                                        <td>
                                                            <?php
                                                            // $OTHERSDetails = [
                                                            //     'id' => 'OTHERS',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $OTHERSdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[OTHERSS]', $OTHERSdata, $aOTHERS, $OTHERSDetails);
                                                            // echo form_hidden('udaily[OTHERS]',$aOTHERS);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aOTHERS)) {
                                                                $aOTHERS = 'Y';
                                                            }
                                                            ?>

                                                                <input type="hidden" name="udaily[OTHERS]" value="N">
                                                                <input type="checkbox" name="udaily[OTHERS]" value="Y" <?php echo ($aOTHERS == 'Y') ? 'checked' : ''; ?>>


                                                        </td>
                                                        <td>22. OTHERS</td>
                                                        <td>
                                                            <?php
                                                            // $OTHDetails = [
                                                            //     'id' => 'OTH',
                                                            //     'class' => 'form-control select2',
                                                            //     'checkSelect' => 'select2'
                                                            //   ];
                                                            // $OTHdata = [
                                                            //     'N' => 'N',
                                                            //     'Y' => 'Y'
                                                            // ];
                                                            // echo form_dropdown('udaily[OTHS]', $OTHdata, $aOTH, $OTHDetails);
                                                            // echo form_hidden('udaily[OTH]',$aOTH);
                                                            ?>
                                                            <?php
                                                            // Default to 'Y' if not set
                                                            if (!isset($aOTH)) {
                                                                $aOTH = 'Y';
                                                            }
                                                            ?>

                                                                <input type="hidden" name="udaily[OTH]" value="N">
                                                                <input type="checkbox" name="udaily[OTH]" value="Y" <?php echo ($aOTH == 'Y') ? 'checked' : ''; ?>>


                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body col-md-12">

                                    <div class="row m-t-10 m-l-10">
                                       

                                        <div class="col-sm-12">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Finding/ Observation <span class="error">*</span></label>
                                                <?php
                                                $finding = isset($getDailyActdatas->ATAR_INC_DESC_FINDING) && !empty($getDailyActdatas->ATAR_INC_DESC_FINDING) ? $getDailyActdatas->ATAR_INC_DESC_FINDING : "";
                                                $cfinding = array(
                                                    'name' => 'udaily[ATAR_INC_DESC_FINDING]',
                                                    'id' => 'ATAR_INC_DESC_FINDING',
                                                    'placeholder' => 'Enter Finding/ Observation',
                                                    'class' => 'form-control',
                                                    'value' => $finding,
                                                    'rows' => 4,
                                                    'cols' => 4,
                                                    'autocomplete' => 'off'
                                                );
                                                echo form_textarea($cfinding);
                                                ?>
                                                <span class="error"><?php echo form_error('udaily[ATAR_INC_DESC_FINDING]') ?></span>
                                            </div>
                                        </div>
                                         <div class="col-sm-12">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Recommendations <span class="error">*</span></label>
                                                <?php
                                                $recom = isset($getDailyActdatas->ATAR_USEE_WHAT_RECCOM) && !empty($getDailyActdatas->ATAR_USEE_WHAT_RECCOM) ? $getDailyActdatas->ATAR_USEE_WHAT_RECCOM : "";
                                                $crecom = array(
                                                    'name' => 'udaily[ATAR_USEE_WHAT_RECCOM]',
                                                    'id' => 'ATAR_USEE_WHAT_RECCOM',
                                                    'placeholder' => 'Enter Recommendations',
                                                    'class' => 'form-control',
                                                    'value' => $recom,
                                                    'rows' => 4,
                                                    'cols' => 4,
                                                    'autocomplete' => 'off'
                                                );
                                                echo form_textarea($crecom);
                                                ?>
                                                <span class="error"><?php echo form_error('udaily[ATAR_USEE_WHAT_RECCOM]') ?></span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <span class="btn btn-xs btn-success  float-right addMorcerti"><i class="fa fa-plus-square"> Add More</i></span>
                                        </div>


                                    </div>

                                    <div class="col-md-12">

                                        <?php
                                        if (isset($getAlldailyimage) && !empty($getAlldailyimage)) {
                                            //  echo "<pre>";
                                            //   print_r($getUseeActdatas);exit;
                                            ?>

                                            <div class="othercertiDet" certiRow-id="<?php echo $useeRowval; ?>">

                                                <div class="row m-t-10 m-l-10 addMorecompet">
                                                    <?php
                                                    foreach ($getAlldailyimage as $othKey => $othVal) {
                                                        $useeRowval = $othKey + 1;
                                                        $useeID = postData($othVal, 'ATAR_ATT_ID');
                                                        $useeimgpath = postData($othVal, 'ATAR_FILE_PATH');
                                                        $useeimgname = postData($othVal, 'ATAR_FILENAME');

                                                        if ($useeimgname != '') {
                                                            $useeFilepath = $useeimgpath;
                                                        } else {
                                                            $useeFilepath = '';
                                                        }
                                                        ?>
                                                        <div class="col-sm-4">

                                                            <label>Image Upload </label>
                                                            <span class="float-right removeCertinew" removeCerti-ID="<?php echo $useeID; ?>"><i class="fa fa-trash"></i></span>

                                                            <div class="form-group">

                                                                <div class="fileinput fileinput-new apprFileinput" style="margin-top: -30px !important; " data-provides="fileinput" >
                                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                                        <?php
                                                                        if ($useeFilepath != '') {
                                                                            ?>
                                                                            <img src='<?php echo BASE_URL . $useeFilepath ?>' alt='<?php echo $useeimgname; ?>' style="height: 100%;"/>     
                                                                        <?php } ?>
                                                                    </div>
                                                                    <p class="mini-txt">( png, jpeg, jpg )</p>
                                                                    <div class="file-pop" >                                                    
                                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src='<?php echo BASE_URL("/assets/images/photo.png"); ?>'  style=" width: 30%; "/></span>
                                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                                            <input type="file" name="udailyimage[]" class="atarfile"  accept="image/*"></span>

                                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="other_user_img[]" value="<?php echo $useeFilepath; ?>">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                                <?php
                                            } else {
                                                ?>
                                                <div class="othercertiDet" certiRow-id="1">


                                                    <div class="row m-t-10 m-l-10 addMorecompet">

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Image Upload </label>
                                                                <div class="fileinput fileinput-new apprFileinput" style="margin-top: -30px !important; " data-provides="fileinput" >
                                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" >      
                                                                        <?php
                                                                        if ($useeFilepath != '') {
                                                                            ?>
                                                                            <img src='<?php echo BASE_URL . $useeFilepath ?>' alt='<?php echo $useeimgname; ?>' style="height: 100%;"/>     
                                                                        <?php } ?>
                                                                    </div>
                                                                    <p class="mini-txt">( png, jpeg, jpg )</p>
                                                                    <div class="file-pop" >                                                    
                                                                        <span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src='<?php echo BASE_URL("/assets/images/photo.png"); ?>'  style=" width: 30%; "/></span>
                                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                                            <input type="file" name="udailyimage[]" class="atarfile" accept="image/*"></span>

                                                                        <button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists"  data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="other_user_img[]" value="<?php echo $useeFilepath; ?>">

                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>

                                            <?php } ?>



                                        </div>
                                    </div>
                                </div>

 
                            </div>


                            <div class="form-group m-t-10" style="text-align: center;">
                                <div class="col-sm-offset-2 col-sm-12"> 

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
      $('#specific_loc').change(function () {
        //alert("sdgsdgs")
        var vals = $(this).val();
        if (vals === '-1') {
            $('#ATAR_SPEC_LOC_OTHER').removeClass('d-none');
            $('.specificOther').removeClass('d-none');
        } else {
            $('#ATAR_SPEC_LOC_OTHER').addClass('d-none');
             $('.specificOther').addClass('d-none');
        }
    });
    
    
    function getAjaxLocation(id) {
        // alert(id);
        var url = "<?php echo BASE_URL('common/getAjaxLocation') ?>";
        var data = {terminalID: id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
        $.ajax({
            dataType: 'json',
            data: 'ajax',
            method: 'post',
            data: data,
            url: url,
            success: function (resp) {
                $("#specific_loc").html(resp.loctdatas)
            }
        });

    }



    $(document).ready(function () {


       $.validator.addMethod('accept_address', function (value) {
            return /^[a-zA-Z0-9\/\\n\s,.'-_*()+&^$#@!% ]{1,}$/.test(value);
        }, "Please Enter a valid data");

         $.validator.addMethod('filesize', function (value, element, param) {
           
            return this.optional(element) || (Math.round(element.files[0].size / (1024 * 1024)) <= 5)
        }, 'File size must be less than 5MB');

        $.validator.addClassRules("atarfile", {
            accept: "png|jpe?g|gif",
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

                "udaily[ATAR_REPORTER]": {
                    required: true
                },
                "udaily[DES_NAME]": {
                    required: true
                },
                "udaily[ATAR_LOC_ID]": {
                    required: true
                },
                "udaily[ATAR_SPEC_LOC_ID]": {
                    required: true
                },
                "udaily[ATAR_REPORT_DATETIME]": {
                    required: true
                },
                "udaily[ATAR_INC_DESC_FINDING]": {
                    required: true,
                    accept_address: true
                   // programming_char:true
                },
                "udaily[ATAR_SPEC_LOC_OTHER]": {
		    required: function () {
			if ($("#specific_loc").val() == '-1') {
			    return true;
			} else {
			    return false;
			}
		    },
                     programming_char: function () {
			if ($("#specific_loc").val() == '-1') {
			    return true;
			} else {
			    return false;
			}
		    }
		},


                "udaily[ATAR_USEE_WHAT_RECCOM]": {
                    required: true,
                    accept_address: true
                  //  programming_char:true
                },
            },
            messages: {
                "udaily[ATAR_REPORTER]": {
                    required: "Reporter Name is required"
                },
                "udaily[DES_NAME]": {
                    required: "Designation is required"
                },
                "udaily[ATAR_LOC_ID]": {
                    required: "Location is required"
                },
                "udaily[ATAR_SPEC_LOC_ID]": {
                    required: "Specific Location is required"
                },
                "udaily[ATAR_REPORT_DATETIME]": {
                    required: "DATE and Time is required"
                },
                
                "udaily[ATAR_INC_DESC_FINDING]": {
                    required: "Finding/ Observation is required"
                },
                "udaily[ATAR_SPEC_LOC_OTHER]": {
		    required: 'Specific Location Other is required'
		},
                "udaily[ATAR_USEE_WHAT_RECCOM]": {
                    required: "Recommendations is required"
                },
            },
            errorPlacement: function (error, element) {

                if (element.attr('checkSelect') == 'select2') {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                    element.closest(".imgGroup").last().append(error);
                }
            },submitHandler: function (form) {
                swal({
                    title: "Please wait..",
                    imageUrl: loadingImg,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                form.submit();
            }

        });
    });
</script>
<script>
    $(document).on('click', '.addMorcerti', function () {

        var baseUrl = '<?php echo BASE_URL; ?>'
        var lastUsee = $(this).parents().eq(2).next().find(".othercertiDet").last().attr("certiRow-id");

        var newUseerow = parseInt(lastUsee) + 1;
        var html = '<div class="col-sm-4" style="margin-top:30px;">\n\
  <span class="float-right removeCertinew">\n\
<i class="fa fa-trash"></i>\n\
</span>\n\
<div class="form-group">\n\
<div class="fileinput fileinput-new apprFileinput" style="margin-top: -30px !important;" data-provides="fileinput">\n\
<div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput">\n\
</div>\n\
<p class="mini-txt">(png, jpeg, jpg )</p>\n\
<div class="file-pop">\n\
<span class="text-green btn-file">\n\
<span class="photo fileinput-new" title="Add Image">\n\
<img class="imgupload" src="' + baseUrl + '/assets/images/photo.png" style=" width: 30%; ">\n\
</span>\n\
<span class="fileinput-exists" title="Add Image">\n\
</span>\n\
<input type="file" name="udailyimage[]" class="atarfile" accept="image/*">\n\
</span>\n\
<button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image">\n\
<i class="fa fa-times-circle-o" aria-hidden="true"></i>\n\
</button>\n\
</div>\n\
</div>\n\
<input type="hidden" name="other_user_img[]" value="">\n\
</div>\n\
</div>\n\
';
        $(".addMorecompet").append(html);

    })
    $(document).on('click', '.removeCertinew', function () {
        $(this).closest('.col-sm-4').remove();
    })
</script>

