<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:230px;height:65px;">';

$visitorName = isset($visitor->VISITOR_NAME) ? $visitor->VISITOR_NAME : 'Visitor';
$visitorComp = isset($visitor->COMPANY_NAME) ? $visitor->COMPANY_NAME : '-';
$visitorIc = isset($visitor->IC_PASSPORT_NO) ? $visitor->IC_PASSPORT_NO : '-';
$email = isset($visitor->EMAIL_ID) ? $visitor->EMAIL_ID : '-';
$phone = isset($visitor->PHONE_NO) ? $visitor->PHONE_NO : '-';
$address = isset($visitor->ADDRESS) ? $visitor->ADDRESS : '-';
$purpose = isset($visitor->VISIT_PURPOSE) ? $visitor->VISIT_PURPOSE : '-';
$visitStart = (!empty($visitor->VISIT_DATETIME)) ? date('d-m-Y H:i', strtotime($visitor->VISIT_DATETIME)) : '-';
$visitEnd = (!empty($visitor->VISIT_DATETIME_END)) ? date('d-m-Y H:i', strtotime($visitor->VISIT_DATETIME_END)) : $visitStart;
$visitDatetime = ($visitStart !== '-' && $visitEnd !== $visitStart) ? ($visitStart . ' to ' . $visitEnd) : $visitStart;
$terminal = !empty($visitor->TERMINAL_NAME) ? $visitor->TERMINAL_NAME : 'Lumut Port';
$contactPerson = !empty($visitor->PIC_EMP_NAME) ? $visitor->PIC_EMP_NAME : (!empty($visitor->CONTACT_PERSON_NAME) ? $visitor->CONTACT_PERSON_NAME : '-');
$regNo = isset($visitor->VISITOR_REG_NO) ? $visitor->VISITOR_REG_NO : '-';

$indStatus = isset($visitor->INDUCTION_STATUS) ? $visitor->INDUCTION_STATUS : 'NOT_STARTED';
$score = isset($visitor->SCORE_PERCENTAGE) ? round($visitor->SCORE_PERCENTAGE, 1) : 0;
$certNo = !empty($visitor->CERTIFICATE_NO) ? $visitor->CERTIFICATE_NO : '-';
$passDate = (!empty($visitor->PASSED_DATE)) ? date('d-m-Y', strtotime($visitor->PASSED_DATE)) : '-';
$validityDate = (!empty($visitor->VALIDITY_DATE) && $visitor->VALIDITY_DATE != '0000-00-00') ? date('d-m-Y', strtotime($visitor->VALIDITY_DATE)) : '-';

$qrPath = (!empty($visitor->QR_CODE_PATH) && file_exists(FCPATH . $visitor->QR_CODE_PATH)) ? (FCPATH . $visitor->QR_CODE_PATH) : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Visitor HSE Induction Record - <?php echo htmlspecialchars($visitorName); ?></title>
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
    </style>
</head>
<body>

    <!-- Header Block -->
    <table class="full-width" style="margin-bottom: 8px;">
        <tr>
            <td style="width: 50%; vertical-align: middle;">
                <?php echo $logo; ?>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: middle;">
                <h2 style="margin: 0; color: #161D26; font-size: 14px;">LUMUT MARITIME TERMINAL</h2>
                <div style="font-size: 9.5px; font-weight: bold; color: #555;">HEALTH, SAFETY & ENVIRONMENT DEPARTMENT</div>
                <div style="font-size: 9px; color: #777;">VISITOR HSE INDUCTION DOSSIER & SAFETY CLEARANCE RECORD</div>
                <div style="font-size: 8.5px; color: #888;">Generated On: <?php echo date('d-m-Y H:i:s'); ?></div>
            </td>
        </tr>
    </table>

    <div style="border-top: 2px solid #161D26; margin-bottom: 10px;"></div>

    <!-- Section 1: Visitor Registration Details -->
    <div class="section-header">1. VISITOR REGISTRATION & PROFILE DETAILS</div>
    <table class="data-table">
        <tr>
            <th style="width: 20%;">Visitor Name</th>
            <td style="width: 30%; font-weight: bold;"><?php echo htmlspecialchars($visitorName); ?></td>
            <th style="width: 20%;">Company Name</th>
            <td style="width: 30%;"><?php echo htmlspecialchars($visitorComp); ?></td>
        </tr>
        <tr>
            <th>IC / Passport No.</th>
            <td><?php echo htmlspecialchars($visitorIc); ?></td>
            <th>Registration Ref</th>
            <td style="font-family: monospace; font-weight: bold;"><?php echo htmlspecialchars($regNo); ?></td>
        </tr>
        <tr>
            <th>Email Address</th>
            <td><?php echo htmlspecialchars($email); ?></td>
            <th>Phone Number</th>
            <td><?php echo htmlspecialchars($phone); ?></td>
        </tr>
        <tr>
            <th>Scheduled Visit</th>
            <td style="font-weight: bold; color: #0284c7;"><?php echo $visitDatetime; ?></td>
            <th>Terminal</th>
            <td style="font-weight: bold;"><?php echo htmlspecialchars($terminal); ?></td>
        </tr>
        <tr>
            <th>Person of Contact (LMTSB)</th>
            <td colspan="3"><?php echo htmlspecialchars($contactPerson); ?></td>
        </tr>
        <tr>
            <th>Visit Purpose</th>
            <td colspan="3"><?php echo htmlspecialchars($purpose); ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td colspan="3"><?php echo htmlspecialchars($address); ?></td>
        </tr>
    </table>

    <!-- Section 2: Induction Assessment Status & Clearance -->
    <div class="section-header">2. HSE INDUCTION STATUS & CLEARANCE EVALUATION</div>

    <?php if ($visitor->APPROVAL_STATUS == 'REJECTED') { ?>
        <div style="background-color: #fee2e2; border: 2px solid #dc2626; border-radius: 4px; padding: 10px 12px; margin-bottom: 12px;">
            <div style="color: #b91c1c; font-weight: bold; font-size: 11px; margin-bottom: 4px;">
                &#9888; APPLICATION REJECTED BY HSSE DEPARTMENT
            </div>
            <div style="font-size: 10px; color: #1e293b; line-height: 14px;">
                <strong>Reason for Rejection:</strong> <?php echo !empty($visitor->REJECTION_REASON) ? htmlspecialchars($visitor->REJECTION_REASON) : 'Application criteria not met / HSSE safety clearance denied.'; ?>
            </div>
            <div style="font-size: 9px; color: #64748b; margin-top: 4px;">
                <strong>Decision Date:</strong> <?php echo (!empty($visitor->APPROVED_ON) && $visitor->APPROVED_ON != '0000-00-00 00:00:00') ? date('d-m-Y H:i:s', strtotime($visitor->APPROVED_ON)) : '-'; ?>
            </div>
        </div>
    <?php } ?>

    <table class="data-table">
        <tr>
            <th style="width: 25%;">Induction Status</th>
            <td style="width: 25%;">
                <?php if ($indStatus == 'PASSED') { ?>
                    <span class="badge-pass">PASSED (100%)</span>
                <?php } elseif ($indStatus == 'FAILED') { ?>
                    <span class="badge-fail">FAILED (<?php echo $score; ?>%)</span>
                <?php } else { ?>
                    <span class="badge-pending"><?php echo str_replace('_', ' ', $indStatus); ?></span>
                <?php } ?>
            </td>
            <th style="width: 25%;">Score Percentage</th>
            <td style="width: 25%; font-weight: bold;">
                <?php echo ($indStatus !== 'NOT_STARTED') ? ($score . '%') : 'N/A'; ?>
            </td>
        </tr>
        <tr>
            <th>Official Pass Certificate No</th>
            <td style="font-family: monospace; font-weight: bold; color: #161D26;"><?php echo htmlspecialchars($certNo); ?></td>
            <th>Total Attempts Made</th>
            <td><?php echo isset($visitor->ATTEMPTS_COUNT) ? (int)$visitor->ATTEMPTS_COUNT : count($attempts); ?></td>
        </tr>
        <tr>
            <th>Induction Passed Date</th>
            <td><?php echo $passDate; ?></td>
            <th>Pass Validity Due Date</th>
            <td style="font-weight: bold; color: #16a34a;"><?php echo $validityDate; ?></td>
        </tr>
    </table>

    <!-- Section 3: Official Scannable QR Code -->
    <?php if ($indStatus == 'PASSED' && !empty($qrPath)) { ?>
        <div class="section-header">3. OFFICIAL QR CODE SAFETY VERIFICATION BADGE</div>
        <table style="width: 100%; border: 2px solid #161D26; background-color: #f8fafc; margin-bottom: 12px; padding: 10px;">
            <tr>
                <td style="width: 120px; text-align: center; vertical-align: middle;">
                    <img src="<?php echo $qrPath; ?>" style="width: 95px; height: 95px; border: 1px solid #cbd5e1; background: #fff; padding: 4px;" alt="QR Code" />
                </td>
                <td style="vertical-align: middle; padding-left: 15px;">
                    <h3 style="margin: 0; color: #161D26; font-size: 13px;">LUMUT PORT OFFICIAL VISITOR PASS</h3>
                    <div style="font-size: 10px; color: #0284c7; font-weight: bold; margin: 4px 0;">PASS ID: <?php echo htmlspecialchars($certNo); ?></div>
                    <div style="font-size: 9px; color: #555; line-height: 13px;">
                        This visitor has successfully fulfilled all HSSE mandatory briefing guidelines and achieved 100% on the examination.
                        Present this pass upon terminal arrival for checkpoint verification.
                    </div>
                </td>
            </tr>
        </table>
    <?php } ?>

    <!-- Section 4: Assessment Attempt History -->
    <div class="section-header">4. ASSESSMENT ATTEMPT LOG & AUDIT HISTORY</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 10%; text-align: center;">Attempt #</th>
                <th style="width: 25%;">Completion Date & Time</th>
                <th style="width: 15%; text-align: center;">Score %</th>
                <th style="width: 15%; text-align: center;">Correct / Wrong</th>
                <th style="width: 15%; text-align: center;">Result</th>
                <th style="width: 20%;">Audit IP</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($attempts)) { ?>
                <?php foreach ($attempts as $att) { ?>
                    <tr>
                        <td style="text-align: center; font-weight: bold;">#<?php echo $att->ATTEMPT_NUMBER; ?></td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($att->ATTEMPT_COMPLETED_AT)); ?></td>
                        <td style="text-align: center; font-weight: bold; color: <?php echo ($att->PASS_FAIL_STATUS == 'PASSED') ? '#16a34a' : '#dc2626'; ?>;">
                            <?php echo $att->PERCENTAGE; ?>%
                        </td>
                        <td style="text-align: center;">
                            <?php echo $att->CORRECT_ANSWERS; ?> / <?php echo $att->INCORRECT_ANSWERS; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php if ($att->PASS_FAIL_STATUS == 'PASSED') { ?>
                                <span class="badge-pass">PASSED</span>
                            <?php } else { ?>
                                <span class="badge-fail">FAILED</span>
                            <?php } ?>
                        </td>
                        <td style="font-size: 9px; color: #666;"><?php echo !empty($att->IP_ADDRESS) ? htmlspecialchars($att->IP_ADDRESS) : '-'; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #888;">No examination attempts recorded yet.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Section 5: Endorsement & Signatures -->
    <div class="section-header">5. REGULATORY CLEARANCE & HSSE ENDORSEMENT</div>
    <table class="full-width" style="margin-top: 15px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <div style="font-weight: bold; font-size: 9.5px;">Visitor Declaration:</div>
                <div style="font-size: 8.5px; color: #666; margin-top: 2px;">I confirm that I have reviewed the HSE Induction materials and will comply with all Lumut Port HSSE safety regulations.</div>
                <div style="margin-top: 35px; border-top: 1px dashed #666; width: 80%; font-size: 9px;">
                    <strong><?php echo htmlspecialchars($visitorName); ?></strong><br>
                    <span>Date: <?php echo date('d-m-Y'); ?></span>
                </div>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: top;">
                <div style="font-weight: bold; font-size: 9.5px;">Authorized Terminal HSSE Officer:</div>
                <div style="font-size: 8.5px; color: #666; margin-top: 2px;">Lumut Maritime Terminal Sdn Bhd Safety Enforcement Division</div>
                <div style="margin-top: 35px; border-top: 1px dashed #666; width: 80%; margin-left: auto; font-size: 9px;">
                    <strong>Official Endorsement & Verification Stamp</strong><br>
                    <span>Lumut Maritime Terminal Sdn Bhd</span>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>

