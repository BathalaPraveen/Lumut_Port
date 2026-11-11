<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:230px;height:65px;">';

$empName = isset($emp->EMP_NAME) ? $emp->EMP_NAME : 'Employee';
$empId = isset($emp->EMP_ID) ? $emp->EMP_ID : '';
$username = isset($emp->USERNAME) ? $emp->USERNAME : '-';
$dept = isset($emp->dept_name) ? $emp->dept_name : '-';
$desig = isset($emp->desig_name) ? $emp->desig_name : '-';
$email = isset($emp->EMP_EMAIL_ID) ? $emp->EMP_EMAIL_ID : '-';
$phone = isset($emp->EMP_PHONE_NO) ? $emp->EMP_PHONE_NO : '-';

$indStatus = isset($induction->INDUCTION_STATUS) ? $induction->INDUCTION_STATUS : 'NOT_STARTED';
$score = isset($induction->SCORE_PERCENTAGE) ? round($induction->SCORE_PERCENTAGE, 1) : 0;
$certNo = !empty($induction->CERTIFICATE_NO) ? $induction->CERTIFICATE_NO : '-';
$passDate = (!empty($induction->PASSED_DATE)) ? date('d-m-Y', strtotime($induction->PASSED_DATE)) : '-';
$validityDate = (!empty($induction->VALIDITY_DATE) && $induction->VALIDITY_DATE != '0000-00-00') ? date('d-m-Y', strtotime($induction->VALIDITY_DATE)) : '-';

// Original employee photo from login_details or contractor record
$defaultAvatar = FCPATH . 'assets/images/hse_induction/default_avatar.png';
$photoPath = $defaultAvatar;
if (!empty($emp->PROFILE_IMG) && file_exists(FCPATH . $emp->PROFILE_IMG)) {
    $photoPath = FCPATH . $emp->PROFILE_IMG;
} elseif (!empty($emp->PHOTO_FILE) && file_exists(FCPATH . $emp->PHOTO_FILE)) {
    $photoPath = FCPATH . $emp->PHOTO_FILE;
}

$qrPath = (!empty($induction->QR_CODE_PATH) && file_exists(FCPATH . $induction->QR_CODE_PATH)) ? (FCPATH . $induction->QR_CODE_PATH) : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>HSE Induction Record - <?php echo htmlspecialchars($empName); ?></title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            font-size: 10.5px;
            line-height: 14.5px;
        }
        @page {
            margin-top: 10mm;
            margin-bottom: 12mm;
            margin-left: 10mm;
            margin-right: 10mm;
            odd-footer-name: html_myFooter1;
            even-footer-name: html_myFooter1;
        }
        .full-width {
            width: 100%;
            border-collapse: collapse;
        }
        .section-header {
            width: 100%;
            background-color: #161D26;
            color: #ffffff;
            font-weight: bold;
            font-size: 11px;
            padding: 5px 8px;
            margin-top: 12px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .data-table th, .data-table td {
            border: 1px solid #dcdcdc;
            padding: 5px 8px;
            font-size: 10px;
        }
        .data-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            text-align: left;
        }
        .badge-pass {
            background-color: #16a34a;
            color: #ffffff;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
        }
        .badge-fail {
            background-color: #dc2626;
            color: #ffffff;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
        }
        .badge-pending {
            background-color: #d97706;
            color: #ffffff;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
        }
        .qr-card-box {
            border: 2px solid #161D26;
            background-color: #f8fafc;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Header Block Matching Other Modules -->
    <table class="full-width" style="margin-bottom: 8px;">
        <tr>
            <td style="width: 50%; vertical-align: middle;">
                <?php echo $logo; ?>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: middle;">
                <h2 style="margin: 0; color: #161D26; font-size: 14px;">LUMUT MARITIME TERMINAL</h2>
                <div style="font-size: 10px; font-weight: bold; color: #555;">HEALTH, SAFETY & ENVIRONMENT DEPARTMENT</div>
                <div style="font-size: 8.5px; color: #777;">Document Ref: HSE-IND-EMP-<?php echo htmlspecialchars($empId); ?> | Date: <?php echo date('d-m-Y'); ?></div>
            </td>
        </tr>
    </table>

    <div style="text-align: center; border-top: 2px solid #161D26; border-bottom: 2px solid #161D26; padding: 5px 0; margin-bottom: 10px;">
        <h3 style="margin: 0; font-size: 13px; color: #161D26; letter-spacing: 0.5px; text-transform: uppercase;">
            EMPLOYEE HSE INDUCTION RECORD & SAFETY STATUS REPORT
        </h3>
    </div>

    <!-- Section 1: Employee Information -->
    <div class="section-header">1. Employee Information</div>
    <table class="data-table">
        <tr>
            <th style="width: 20%;">Employee Name</th>
            <td style="width: 30%; font-weight: bold; font-size: 11px;"><?php echo htmlspecialchars($empName); ?></td>
            <th style="width: 20%;">Employee ID</th>
            <td style="width: 30%; font-weight: bold; color: #161D26;"><?php echo htmlspecialchars($empId); ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?php echo htmlspecialchars($username); ?></td>
            <th>User Type / Role</th>
            <td><span style="font-weight: bold; color: #0284c7;">Employee</span></td>
        </tr>
        <tr>
            <th>Department</th>
            <td><?php echo htmlspecialchars($dept); ?></td>
            <th>Designation</th>
            <td><?php echo htmlspecialchars($desig); ?></td>
        </tr>
        <tr>
            <th>Email Address</th>
            <td><?php echo htmlspecialchars($email); ?></td>
            <th>Phone Number</th>
            <td><?php echo htmlspecialchars($phone); ?></td>
        </tr>
    </table>

    <!-- Section 2: HSE Induction Certification & Safety Status -->
    <div class="section-header">2. HSE Induction Assessment & Safety Status</div>
    <table class="data-table">
        <tr>
            <th style="width: 20%;">Induction Status</th>
            <td style="width: 30%;">
                <?php
                if ($indStatus == 'PASSED') {
                    echo '<span class="badge-pass">PASSED (100%)</span>';
                } elseif ($indStatus == 'FAILED') {
                    echo '<span class="badge-fail">FAILED (' . round($score) . '%)</span>';
                } elseif ($indStatus == 'IN_PROGRESS') {
                    echo '<span class="badge-pending">IN PROGRESS</span>';
                } else {
                    echo '<span class="badge-pending">NOT STARTED</span>';
                }
                ?>
            </td>
            <th style="width: 20%;">Passing Standard</th>
            <td style="width: 30%; font-weight: bold;">100% Mark Required</td>
        </tr>
        <tr>
            <th>Assessment Score</th>
            <td style="font-weight: bold; font-size: 11px;">
                <?php echo ($indStatus != 'NOT_STARTED') ? $score . '%' : '-'; ?>
            </td>
            <th>Induction Type</th>
            <td>Employee HSE Safety Induction</td>
        </tr>
        <tr>
            <th>Certificate / Pass No</th>
            <td style="font-family: monospace; font-weight: bold; color: #161D26;">
                <?php echo htmlspecialchars($certNo); ?>
            </td>
            <th>Date Certified</th>
            <td><?php echo $passDate; ?></td>
        </tr>
        <tr>
            <th>Validity Period</th>
            <td colspan="3" style="font-weight: bold; color: <?php echo ($indStatus == 'PASSED') ? '#16a34a' : '#555'; ?>;">
                <?php echo ($validityDate != '-') ? 'Valid until ' . $validityDate . ' (1 Year Mandatory Validity)' : '-'; ?>
            </td>
        </tr>
    </table>

    <!-- Section 3: Official Pass Card & QR Verification (if passed) -->
    <?php if ($indStatus == 'PASSED' && !empty($qrPath)) { ?>
        <div class="section-header">3. Official Terminal Security Pass & QR Verification</div>
        <table class="full-width qr-card-box">
            <tr>
                <!-- Original Employee Photo -->
                <td style="width: 25%; text-align: center; vertical-align: middle;">
                    <div style="border: 1px solid #161D26; padding: 3px; display: inline-block; background: #fff;">
                        <img src="<?php echo $photoPath; ?>" style="width: 100px; height: 125px; object-fit: cover;" alt="Photo">
                    </div>
                    <div style="font-size: 8.5px; font-weight: bold; color: #555; margin-top: 3px;">Employee Photo</div>
                </td>

                <!-- Scannable QR Code -->
                <td style="width: 25%; text-align: center; vertical-align: middle;">
                    <div style="border: 1px solid #161D26; padding: 3px; display: inline-block; background: #fff;">
                        <img src="<?php echo $qrPath; ?>" style="width: 110px; height: 110px;" alt="QR Code">
                    </div>
                    <div style="font-size: 8.5px; font-weight: bold; color: #161D26; margin-top: 3px;">Scannable QR Pass</div>
                </td>

                <!-- Pass Details -->
                <td style="width: 50%; vertical-align: middle; text-align: left; padding-left: 12px;">
                    <div style="font-weight: bold; font-size: 12px; color: #161D26; margin-bottom: 4px;">
                        LUMUT PORT HSSE VERIFIED PASS
                    </div>
                    <p style="margin: 0 0 6px 0; font-size: 9.5px; line-height: 13.5px; color: #444;">
                        This digital clearance verifies that <strong><?php echo htmlspecialchars($empName); ?></strong> (<?php echo htmlspecialchars($empId); ?>) has successfully completed the mandatory terminal HSE Induction and achieved <strong>100%</strong> in the safety assessment.
                    </p>
                    <table style="width: 100%; font-size: 9.5px; border-top: 1px dotted #ccc; padding-top: 4px;">
                        <tr>
                            <td style="width: 40%; color: #666;">Pass ID / Ref:</td>
                            <td style="font-weight: bold; font-family: monospace; color: #161D26;"><?php echo htmlspecialchars($certNo); ?></td>
                        </tr>
                        <tr>
                            <td style="color: #666;">Valid Until:</td>
                            <td style="font-weight: bold; color: #16a34a;"><?php echo $validityDate; ?></td>
                        </tr>
                        <tr>
                            <td style="color: #666;">Issued By:</td>
                            <td>Lumut Maritime Terminal HSSE Safety Dept</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <?php } ?>

    <!-- Section 4: Assessment Attempts History Log -->
    <?php if (!empty($attempts)) { ?>
        <div class="section-header" style="margin-top: 12px;">4. Assessment Attempt History & Audit Log</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">Attempt #</th>
                    <th style="width: 25%;">Date & Time</th>
                    <th style="width: 13%; text-align: center;">Total Qs</th>
                    <th style="width: 13%; text-align: center;">Correct</th>
                    <th style="width: 13%; text-align: center;">Incorrect</th>
                    <th style="width: 13%; text-align: center;">Score %</th>
                    <th style="width: 13%; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attempts as $att) { ?>
                    <tr>
                        <td style="text-align: center; font-weight: bold;">#<?php echo $att->ATTEMPT_NUMBER; ?></td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($att->ATTEMPT_COMPLETED_AT)); ?></td>
                        <td style="text-align: center;"><?php echo $att->TOTAL_QUESTIONS; ?></td>
                        <td style="text-align: center; color: #16a34a; font-weight: bold;"><?php echo $att->CORRECT_ANSWERS; ?></td>
                        <td style="text-align: center; color: #dc2626; font-weight: bold;"><?php echo $att->INCORRECT_ANSWERS; ?></td>
                        <td style="text-align: center; font-weight: bold;"><?php echo $att->PERCENTAGE; ?>%</td>
                        <td style="text-align: center;">
                            <?php if ($att->PASS_FAIL_STATUS == 'PASSED') { ?>
                                <span class="badge-pass">PASSED</span>
                            <?php } else { ?>
                                <span class="badge-fail">FAILED</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

    <!-- Section 5: Official Signatures & Verification Endorsement -->
    <table class="full-width" style="margin-top: 25px; border-top: 1px solid #ccc; padding-top: 10px; page-break-inside: avoid;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <div style="font-weight: bold; font-size: 9.5px; color: #333;">Employee Signature & Acknowledgement:</div>
                <div style="margin-top: 30px; font-size: 9.5px; border-top: 1px dashed #777; width: 75%;">
                    <strong><?php echo htmlspecialchars($empName); ?></strong><br>
                    <small>Signature & Date</small>
                </div>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: top;">
                <div style="font-weight: bold; font-size: 9.5px; color: #333;">Authorized Terminal HSSE Department:</div>
                <div style="margin-top: 30px; font-size: 9.5px; border-top: 1px dashed #777; width: 75%; margin-left: auto;">
                    <strong>Lumut Maritime Terminal Sdn Bhd</strong><br>
                    <small>Official Safety Clearance Stamp</small>
                </div>
            </td>
        </tr>
    </table>

    <htmlpagefooter name="html_myFooter1">
        <div style="text-align: center; font-size: 8.5px; color: #888; border-top: 1px solid #eee; padding-top: 4px;">
            Lumut Maritime Terminal Sdn Bhd &copy; <?php echo date('Y'); ?> | Automated Safety Induction Examination System | Page {PAGENO} of {nb}
        </div>
    </htmlpagefooter>

</body>
</html>
