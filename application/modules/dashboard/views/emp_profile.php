<?php
$emploID = postData($getEmploydetails, 'EMP_AUTO_ID');
$emploentID = postData($getEmploydetails, 'EMP_ID');
$emplName = postData($getEmploydetails, 'EMP_NAME');
$emplGender = postData($getEmploydetails, 'GENDER_NAME');
$emplNation = postData($getEmploydetails, 'NATIONALITY_NAME');
$emplNationother = postData($getEmploydetails, 'EMP_NATIONALITY_OTHER');
$emplDesig = postData($getEmploydetails, 'DESIGNATION_NAME');
$emplDept = postData($getEmploydetails, 'DEPT_NAME');
$emplTerminal = postData($getEmploydetails, 'TERMINAL_NAME');
$emplMail = postData($getEmploydetails, 'EMP_EMAIL_ID');
$emplCertiname = postData($getEmploydetails, 'CERT_NAME');
if ($getEmploydetails->CERT_START_DATE != '') {
    $emplStartdate = date('d-m-Y', strtotime($getEmploydetails->CERT_START_DATE));
} else {
    $emplStartdate = '';
}
if ($getEmploydetails->CERT_END_DATE != '') {
    $emplEnddate = date('d-m-Y', strtotime($getEmploydetails->CERT_END_DATE));
} else {
    $emplEnddate = '';
}
$emplCertpath = postData($getEmploydetails, 'CERT_PATH');
$emplCertimgname = postData($getEmploydetails, 'CERT_FILE_NAME');
$emplCertimgext = postData($getEmploydetails, 'CERT_EXT');
$emplCertStatus = postData($getEmploydetails, 'CERT_STATUS');

if ($emplCertStatus == 'Y') {
    $finStatus = 'Eligible';
} else {
    $finStatus = 'Not Eligible';
}
$compCertFilepath = '';
if ($emplCertimgname != '') {
    $compCertFilepath = $emplCertpath . $emplCertimgname;
}
?>
<div class="invoice p-3 mb-3">
    <div class="card-header" style="background: #15519b;">
        <h3 class="card-title" style="color: #ffff;">Basic Details</h3>
    </div>
    <div class="row">


        <div class="col-12 table-responsive">
            <table class="table table-striped" style="">
                <tbody>
                    <tr>
                        <td width="23%"><b>Employee No</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $emploentID; ?></td>
                        <td width="23%"><b>Employee Name</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $emplName; ?></td>
                    </tr>
                    <tr>
                        <td width="23%"><b>Gender</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $emplGender; ?></td>
                        <td width="23%"><b>Nationality</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo (isset($emplNation) && $emplNation != 'Other') ? $emplNation : $emplNationother; ?></td>
                    </tr>
                    <tr>
                        <td width="23%"><b>Designation</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $emplDesig; ?></td>
                        <td width="23%"><b>Terminal</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $emplTerminal; ?></td>
                    </tr>
                    <tr>
                        <td width="23%"><b>Department</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $emplDept; ?></td>
                        <td width="23%"><b>Email ID</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $emplMail; ?></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="invoice p-3 mb-3">
    <div class="card-header" style="background: #15519b;">
        <h3 class="card-title" style="color: #ffff;">Competency Details</h3>
    </div>
    <div class="row">


        <div class="col-12 table-responsive">
            <table class="table table-striped" style="">
                <tbody>
                    <tr>
                        <td width="23%"><b>Competency Certificate Name</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $emplCertiname; ?></td>
                        <td width="23%"><b>Competency Certificate Status</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $finStatus; ?></td>
                    </tr>
                    <tr>
                        <td width="23%"><b>Start Date</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $emplStartdate; ?></td>
                        <td width="23%"><b>End Date</b></td>
                        <td>:</td>
                        <td width="23%"><?php echo $emplEnddate; ?></td>
                    </tr>
                    <tr >
                        <td width="23%"><b>Competency Certificate</b></td>
                        <td >:</td>
                        <td >
                            <?php
                            if ($compCertFilepath != '') {
                                if ($emplCertimgext != '.pdf') {
                                    ?>
                                    <img src="<?php echo BASE_URL . $compCertFilepath ?>" style="height: 15%;">
                                <?php } else { ?>
                                    <a href="<?php echo BASE_URL . $compCertFilepath ?>" target="blank"><?php echo $emplCertimgname; ?></a>
                                <?php }
                            } else { ?>

<?php } ?>
                        </td>
                        <td colspan="3"></td>

                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>