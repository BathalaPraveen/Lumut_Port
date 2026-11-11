<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/Logo_Replace.png" style="width:200px;height:45px;">';
$checkIcon = '<img src="' . PDF_IMG_PATH . 'company_logo/check_green.png" class="doc-check">';
$bulletIcon = '<img src="' . PDF_IMG_PATH . 'company_logo/bullet_blue.png" class="cert-bullet">';
$cntrentID = isset($contractor->CONT_ID) ? $contractor->CONT_ID : '';
$cmpnName = isset($contractor->CONT_COMPANY) ? $contractor->CONT_COMPANY : '';
$contName = isset($contractor->CONT_NAME) ? $contractor->CONT_NAME : '';
$cntrMail = isset($contractor->CONT_EMAIL_ID) ? $contractor->CONT_EMAIL_ID : '';
$cntrPhone = isset($contractor->CONT_PHONE_NO) ? $contractor->CONT_PHONE_NO : '';
$batchNo = isset($batch->BATCH_NO) ? $batch->BATCH_NO : '';
$payment = isset($batch->PAYMENT) ? $batch->PAYMENT : '';
$validityDate = ($batch->VALIDITY_DATE && $batch->VALIDITY_DATE != '0000-00-00') ? date('d-m-Y', strtotime($batch->VALIDITY_DATE)) : '-';
$createdOn = isset($batch->CREATED_ON) ? date('d-m-Y H:i', strtotime($batch->CREATED_ON)) : date('d-m-Y');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Batch Details - <?php echo $batchNo; ?></title>
        <style>
            * {
                font-family: Arial, Helvetica, sans-serif;
                color: #333;
                font-size: 11px;
                line-height: 15px;
            }
            @page {
                size: auto;
                margin-header: 0mm;
                margin-footer: 3mm;
                odd-header-name: html_myHeader1;
                even-header-name: html_myHeader2;
                odd-footer-name: html_myFooter1;
                even-footer-name: html_myFooter2;
            }
            .full-width {
                width: 100%;
                font-size: 11px;
            }
            .section-title {
                width: 100%;
                background-color: #FFFF00;
                color: #000;
                font-weight: bold;
                font-size: 12px;
                padding: 6px 8px;
                margin-bottom: 6px;
                text-transform: uppercase;
            }
            .section-title-sub {
                width: 100%;
                background-color: #2768ad;
                color: #fff;
                font-weight: bold;
                font-size: 12px;
                padding: 6px 8px;
                margin-top: 15px;
                margin-bottom: 6px;
                text-transform: uppercase;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }
            .table td {
                padding: 5px 8px;
                font-size: 11px;
                vertical-align: top;
            }
            .summ tr:nth-child(odd) {
                background-color: rgb(245, 245, 245);
            }
            .table-bordered {
                border: 1px solid #bfbebe;
            }
            .table-bordered td, .table-bordered th {
                border: 1px solid #bfbebe;
            }
            .tdlabel {
                font-weight: bold;
                color: #333;
                text-transform: uppercase;
            }
            .title-colon {
                width: 10px;
                text-align: center;
                font-weight: bold;
            }
            .data-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 4px;
                margin-bottom: 15px;
            }
            .data-table th {
                background-color: #2768ad;
                color: #ffffff;
                font-weight: bold;
                font-size: 10px;
                text-align: center;
                padding: 7px 4px;
                border: 1px solid #1f548d;
                text-transform: uppercase;
            }
            .data-table td {
                border: 1px solid #d0d7de;
                padding: 6px 5px;
                font-size: 10px;
                vertical-align: top;
            }
            .data-table tr:nth-child(even) {
                background-color: #f9fbfd;
            }
            .text-center {
                text-align: center;
            }
            .badge-cert {
                display: block;
                padding: 2px 4px;
                background-color: #f0f7ff;
                border: 1px solid #cce5ff;
                color: #004085;
                font-size: 8.5px;
                line-height: 12px;
                border-radius: 3px;
                margin-bottom: 2px;
            }
            .badge-doc {
                display: block;
                padding: 2px 4px;
                background-color: #f2fbf4;
                border: 1px solid #c3e6cb;
                color: #155724;
                font-size: 8.5px;
                line-height: 12px;
                border-radius: 3px;
                margin-bottom: 2px;
            }
            .cert-bullet {
                width: 7px;
                height: 7px;
                vertical-align: middle;
                margin-right: 3px;
            }
            .doc-check {
                width: 9px;
                height: 9px;
                vertical-align: middle;
                margin-right: 3px;
            }
            .sign-table {
                width: 100%;
                margin-top: 25px;
                border-collapse: collapse;
            }
            .sign-box {
                border-top: 1px solid #333;
                text-align: center;
                padding-top: 6px;
                font-size: 11px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <!-- Header 1 -->
        <htmlpageheader name="myHeader1" style="display:none">
            <table border="0" style="width:100%;border:0;background-color:#FFF;padding-top:8px;padding-bottom:6px;">
                <tr>
                    <td border="0" style="width:25%;text-align:left;vertical-align:middle;"><?php echo $logo; ?></td>
                    <td border="0" style="width:75%;text-align:right;font-size:20px;font-weight:bold;color:#2768ad;vertical-align:middle;">
                        CONTRACTOR INDUCTION BATCH REPORT
                    </td>
                </tr>
            </table>
            <table border="0" style="width:100%;border:0;border-top:4px solid #000;margin-bottom:8px;">
                <tr>
                    <td border="0" style="width:40%;font-size:11px;color:#333;padding-top:3px;">Company: <strong><?php echo htmlspecialchars($cmpnName); ?></strong></td>
                    <td border="0" style="width:60%;text-align:right;font-size:11px;font-weight:bold;color:#000;padding-top:3px;">
                        BATCH: <?php echo htmlspecialchars($batchNo); ?> | CONTRACTOR ID: <?php echo htmlspecialchars($cntrentID); ?>
                    </td>
                </tr>
            </table>
        </htmlpageheader>

        <!-- Header 2 (multi-page) -->
        <htmlpageheader name="myHeader2" style="display:none">
            <table border="0" style="width:100%;border:0;background-color:#FFF;padding-top:8px;padding-bottom:6px;">
                <tr>
                    <td border="0" style="width:25%;text-align:left;vertical-align:middle;"><?php echo $logo; ?></td>
                    <td border="0" style="width:75%;text-align:right;font-size:18px;font-weight:bold;color:#2768ad;vertical-align:middle;">
                        CONTRACTOR INDUCTION BATCH REPORT
                    </td>
                </tr>
            </table>
            <table border="0" style="width:100%;border:0;border-top:4px solid #000;margin-bottom:8px;">
                <tr>
                    <td border="0" style="width:40%;font-size:11px;color:#333;padding-top:3px;">Company: <strong><?php echo htmlspecialchars($cmpnName); ?></strong></td>
                    <td border="0" style="width:60%;text-align:right;font-size:11px;font-weight:bold;color:#000;padding-top:3px;">
                        BATCH: <?php echo htmlspecialchars($batchNo); ?> | CONTRACTOR ID: <?php echo htmlspecialchars($cntrentID); ?>
                    </td>
                </tr>
            </table>
        </htmlpageheader>

        <!-- Footer 1 -->
        <htmlpagefooter name="myFooter1" style="display:none">
            <table width="100%" style="width:100%;border:0;background-color:#FFF;border-top:4px solid #000;padding-top:6px;padding-bottom:6px;">
                <tr>
                    <td width="33%" style="font-size:10px;font-style:italic;color:#333;">{DATE d-m-Y H:i}</td>
                    <td width="34%" align="center" style="font-size:10px;font-weight:bold;color:#333;">NeoEHS - Contractor Induction Management</td>
                    <td width="33%" style="text-align:right;font-size:10px;font-weight:bold;color:#333;">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        </htmlpagefooter>

        <!-- Footer 2 -->
        <htmlpagefooter name="myFooter2" style="display:none">
            <table width="100%" style="width:100%;border:0;background-color:#FFF;border-top:4px solid #000;padding-top:6px;padding-bottom:6px;">
                <tr>
                    <td width="33%" style="font-size:10px;font-style:italic;color:#333;">{DATE d-m-Y H:i}</td>
                    <td width="34%" align="center" style="font-size:10px;font-weight:bold;color:#333;">NeoEHS - Contractor Induction Management</td>
                    <td width="33%" style="text-align:right;font-size:10px;font-weight:bold;color:#333;">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        </htmlpagefooter>

        <!-- Section 1: Batch & Company Info -->
        <table style="width:100%;padding-bottom:4px;">
            <tr>
                <td style="width:100%;background-color:#FFFF00;color:#000;font-weight:bold;font-size:12px;padding:6px 8px;text-transform:uppercase;">
                    BATCH & COMPANY DETAILS
                </td>
            </tr>
        </table>

        <table class="table table-bordered summ full-width">
            <tr>
                <td width="20%" class="tdlabel">Company Name</td>
                <td class="title-colon">:</td>
                <td width="28%"><strong><?php echo htmlspecialchars($cmpnName); ?></strong></td>
                <td width="20%" class="tdlabel">Contractor ID</td>
                <td class="title-colon">:</td>
                <td width="28%"><strong><?php echo htmlspecialchars($cntrentID); ?></strong></td>
            </tr>
            <tr>
                <td class="tdlabel">Person In-Charge (PIC)</td>
                <td class="title-colon">:</td>
                <td><?php echo htmlspecialchars($contName); ?></td>
                <td class="tdlabel">PIC Phone / Email</td>
                <td class="title-colon">:</td>
                <td><?php echo htmlspecialchars($cntrPhone . ' / ' . $cntrMail); ?></td>
            </tr>
            <tr>
                <td class="tdlabel">Batch Number</td>
                <td class="title-colon">:</td>
                <td><strong style="color:#2768ad;font-size:12px;"><?php echo htmlspecialchars($batchNo); ?></strong></td>
                <td class="tdlabel">Payment Details</td>
                <td class="title-colon">:</td>
                <td><?php echo htmlspecialchars($payment); ?></td>
            </tr>
            <tr>
                <td class="tdlabel">Validity Date</td>
                <td class="title-colon">:</td>
                <td><strong><?php echo htmlspecialchars($validityDate); ?></strong></td>
                <td class="tdlabel">Created On</td>
                <td class="title-colon">:</td>
                <td><?php echo htmlspecialchars($createdOn); ?></td>
            </tr>
        </table>

        <!-- Section 2: Employee List -->
        <table style="width:100%;padding-bottom:4px;margin-top:10px;">
            <tr>
                <td style="width:100%;background-color:#2768ad;color:#fff;font-weight:bold;font-size:12px;padding:6px 8px;text-transform:uppercase;">
                    INDUCTED CONTRACTOR EMPLOYEES (<?php echo count($employees); ?>)
                </td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 20px;">#</th>
                    <th style="width: 90px;">Employee Name</th>
                    <th style="width: 80px;">ID & Gender</th>
                    <th style="width: 70px;">DOB & Exp</th>
                    <th style="width: 75px;">Designation</th>
                    <th style="width: 70px;">Contact No</th>
                    <th style="width: 70px;">Nationality & Religion</th>
                    <th style="width: 85px;">Emergency Contact</th>
                    <th style="width: 60px;">Terminal</th>
                    <th>Competency Certificates</th>
                    <th style="width: 90px;">Uploaded Documents</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($employees)): ?>
                    <?php foreach ($employees as $idx => $emp):
                        $natName = isset($nat_map[$emp->NATIONALITY_ID]) ? $nat_map[$emp->NATIONALITY_ID] : $emp->NATIONALITY_OTHER;
                        $dobStr = ($emp->DOB && $emp->DOB != '0000-00-00') ? date('d-m-Y', strtotime($emp->DOB)) : '-';
                        
                        // Parse other docs
                        $otherDocCount = 0;
                        if (!empty($emp->OTHER_DOCS)) {
                            $od = json_decode($emp->OTHER_DOCS, true);
                            if (is_array($od)) {
                                $otherDocCount = count($od);
                            }
                        }

                        // Parse cert other docs
                        $certOtherCount = 0;
                        if (!empty($emp->CERT_OTHER)) {
                            $co = json_decode($emp->CERT_OTHER, true);
                            if (is_array($co)) {
                                $certOtherCount = count($co);
                            }
                        }
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $idx + 1; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($emp->EMP_NAME); ?></strong><br>
                            <small style="color:#666;"><?php echo htmlspecialchars($emp->EMP_EMAIL); ?></small>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($emp->ID_NUMBER); ?></strong><br>
                            <span style="font-size: 8px; color:#555;"><?php echo htmlspecialchars($emp->ID_TYPE); ?> | <?php echo htmlspecialchars($emp->GENDER); ?></span>
                        </td>
                        <td>
                            <?php echo $dobStr; ?><br>
                            <span style="font-size: 8px; color:#555;"><?php echo htmlspecialchars($emp->WORK_EXPERIENCE); ?> yr(s)</span>
                        </td>
                        <td><?php echo htmlspecialchars($emp->DESIGNATION); ?></td>
                        <td><?php echo htmlspecialchars($emp->EMP_PHONE); ?></td>
                        <td>
                            <?php echo htmlspecialchars($natName); ?><br>
                            <span style="font-size: 8px; color:#555;"><?php echo htmlspecialchars($emp->RELIGION); ?> / <?php echo htmlspecialchars($emp->RACE); ?></span>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($emp->EMERGENCY_NAME); ?></strong> (<?php echo htmlspecialchars($emp->EMERGENCY_RELATIONSHIP); ?>)<br>
                            <span style="font-size: 8px; color:#222;"><?php echo htmlspecialchars($emp->EMERGENCY_PHONE); ?></span>
                        </td>
                        <td><?php echo htmlspecialchars($emp->TERMINALS); ?></td>
                        <td>
                            <?php
                            $hasCert = false;
                            if (!empty($emp->CERT_FORKLIFT)) { echo '<div class="badge-cert">' . $bulletIcon . ' Forklift</div>'; $hasCert = true; }
                            if (!empty($emp->CERT_CRANE)) { echo '<div class="badge-cert">' . $bulletIcon . ' Crane Operator</div>'; $hasCert = true; }
                            if (!empty($emp->CERT_AGTES)) { echo '<div class="badge-cert">' . $bulletIcon . ' AGTES</div>'; $hasCert = true; }
                            if (!empty($emp->CERT_AESP)) { echo '<div class="badge-cert">' . $bulletIcon . ' AESP</div>'; $hasCert = true; }
                            if (!empty($emp->CERT_SCAFFOLDER)) { echo '<div class="badge-cert">' . $bulletIcon . ' Scaffolder</div>'; $hasCert = true; }
                            if ($certOtherCount > 0) { echo '<div class="badge-cert">' . $bulletIcon . ' Other Cert (' . $certOtherCount . ')</div>'; $hasCert = true; }
                            if (!$hasCert) { echo '<span style="color:#888;">None</span>'; }
                            ?>
                        </td>
                        <td>
                            <?php
                            $hasDoc = false;
                            if (!empty($emp->PASSPORT_IC_FILE)) { echo '<div class="badge-doc">' . $checkIcon . ' Passport/IC</div>'; $hasDoc = true; }
                            if (!empty($emp->PHOTO_FILE)) { echo '<div class="badge-doc">' . $checkIcon . ' Photo</div>'; $hasDoc = true; }
                            if (!empty($emp->WORK_PERMIT_FILE)) { echo '<div class="badge-doc">' . $checkIcon . ' Work Permit</div>'; $hasDoc = true; }
                            if ($otherDocCount > 0) { echo '<div class="badge-doc">' . $checkIcon . ' Others (' . $otherDocCount . ')</div>'; $hasDoc = true; }
                            if (!$hasDoc) { echo '<span style="color:#888;">None</span>'; }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center" style="padding:15px;color:#888;">No employee records found in this batch.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

            </body>
</html>