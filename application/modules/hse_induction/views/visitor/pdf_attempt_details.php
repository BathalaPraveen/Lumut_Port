<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:220px;height:65px;">';

$visitorName = isset($visitor->VISITOR_NAME) ? $visitor->VISITOR_NAME : 'Visitor';
$visitorComp = isset($visitor->COMPANY_NAME) ? $visitor->COMPANY_NAME : 'Visitor Company';
$visitorIc = isset($visitor->IC_PASSPORT_NO) ? $visitor->IC_PASSPORT_NO : '-';
$terminal = !empty($visitor->TERMINAL_NAME) ? $visitor->TERMINAL_NAME : 'Lumut Port';
$attemptNo = isset($attempt->ATTEMPT_NUMBER) ? $attempt->ATTEMPT_NUMBER : 1;
$completedAt = (!empty($attempt->ATTEMPT_COMPLETED_AT)) ? date('d-m-Y H:i:s', strtotime($attempt->ATTEMPT_COMPLETED_AT)) : '-';
$score = isset($attempt->PERCENTAGE) ? $attempt->PERCENTAGE : 0;
$marksObtained = isset($attempt->MARKS_OBTAINED) ? round($attempt->MARKS_OBTAINED, 1) : 0;
$totalMarks = isset($attempt->TOTAL_AVAILABLE_MARKS) ? round($attempt->TOTAL_AVAILABLE_MARKS, 0) : 100;
$status = isset($attempt->PASS_FAIL_STATUS) ? $attempt->PASS_FAIL_STATUS : 'FAILED';
$certNo = !empty($attempt->CERTIFICATE_NO) ? $attempt->CERTIFICATE_NO : '-';
$ipAddress = !empty($attempt->IP_ADDRESS) ? $attempt->IP_ADDRESS : 'Internal/Local';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assessment Attempt #<?php echo $attemptNo; ?> - <?php echo htmlspecialchars($visitorName); ?></title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            font-size: 10.5px;
            line-height: 14px;
        }
        @page {
            margin-top: 10mm;
            margin-bottom: 12mm;
            margin-left: 10mm;
            margin-right: 10mm;
            odd-footer-name: html_myFooter;
            even-footer-name: html_myFooter;
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
            padding: 5px 7px;
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
        .q-card {
            border: 1px solid #cbd5e1;
            margin-bottom: 10px;
            background: #ffffff;
            page-break-inside: avoid;
        }
        .q-header {
            background: #f8fafc;
            padding: 5px 8px;
            border-bottom: 1px solid #cbd5e1;
            font-weight: bold;
        }
        .q-body {
            padding: 8px;
        }
        .opt-item {
            padding: 3px 6px;
            margin-bottom: 3px;
            border-radius: 3px;
            font-size: 9.5px;
        }
        .opt-user-correct {
            background-color: #dcfce7;
            border: 1px solid #86efac;
            font-weight: bold;
            color: #166534;
        }
        .opt-user-wrong {
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
            font-weight: bold;
            color: #991b1b;
        }
        .opt-correct-target {
            background-color: #f0fdf4;
            border: 1px dashed #22c55e;
            font-weight: bold;
            color: #15803d;
        }
        .opt-regular {
            color: #475569;
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
                <div style="font-size: 10.5px; font-weight: bold; color: #555;">HSSE SAFETY INDUCTION ASSESSMENT AUDIT REPORT</div>
                <div style="font-size: 9px; color: #777;">Document Ref: HSE-VISITOR-ATTEMPT-<?php echo $attemptNo; ?>-<?php echo htmlspecialchars($visitor->VISITOR_REG_NO); ?> | Date: <?php echo date('d-m-Y'); ?></div>
            </td>
        </tr>
    </table>

    <div style="text-align: center; border-top: 2px solid #161D26; border-bottom: 2px solid #161D26; padding: 5px 0; margin-bottom: 10px;">
        <h3 style="margin: 0; font-size: 13px; color: #161D26; letter-spacing: 0.5px; text-transform: uppercase;">
            VISITOR ASSESSMENT ATTEMPT #<?php echo $attemptNo; ?> EVALUATION BREAKDOWN
        </h3>
    </div>

    <!-- Section 1: Candidate & Assessment Information -->
    <div class="section-header">1. Visitor & Assessment Summary</div>
    <table class="data-table">
        <tr>
            <th style="width: 20%;">Visitor Name</th>
            <td style="width: 30%; font-weight: bold;"><?php echo htmlspecialchars($visitorName); ?></td>
            <th style="width: 20%;">Registration No</th>
            <td style="width: 30%; font-weight: bold; font-family: monospace; color: #161D26;"><?php echo htmlspecialchars($visitor->VISITOR_REG_NO); ?></td>
        </tr>
        <tr>
            <th>Company Name</th>
            <td><?php echo htmlspecialchars($visitorComp); ?></td>
            <th>IC / Passport</th>
            <td><?php echo htmlspecialchars($visitorIc); ?></td>
        </tr>
        <tr>
            <th>Attempt Number</th>
            <td style="font-weight: bold;">Attempt #<?php echo $attemptNo; ?></td>
            <th>Completed At</th>
            <td><?php echo $completedAt; ?></td>
        </tr>
        <tr>
            <th>Assessment Result</th>
            <td>
                <?php if ($status == 'PASSED') { ?>
                    <span class="badge-pass">PASSED (100%)</span>
                <?php } else { ?>
                    <span class="badge-fail">FAILED (<?php echo $score; ?>%)</span>
                <?php } ?>
            </td>
            <th>Score Obtained</th>
            <td style="font-weight: bold; font-size: 11px;">
                <?php echo $marksObtained; ?> / <?php echo $totalMarks; ?> Marks (<?php echo $score; ?>%)
            </td>
        </tr>
        <tr>
            <th>Correct / Incorrect</th>
            <td>
                <strong style="color: #16a34a;"><?php echo $attempt->CORRECT_ANSWERS; ?> Correct</strong> &nbsp;|&nbsp; 
                <strong style="color: #dc2626;"><?php echo $attempt->INCORRECT_ANSWERS; ?> Incorrect</strong>
            </td>
            <th>Total Questions</th>
            <td style="font-weight: bold;"><?php echo $attempt->TOTAL_QUESTIONS; ?> Questions</td>
        </tr>
        <?php if (!empty($certNo) && $certNo != '-') { ?>
            <tr>
                <th>Certificate Number</th>
                <td colspan="3" style="font-family: monospace; font-weight: bold; color: #161D26;">
                    <?php echo htmlspecialchars($certNo); ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Section 2: Question-by-Question Snapshot Evaluation -->
    <div class="section-header">2. Question-by-Question Evaluation Snapshot</div>

    <?php if (!empty($answers)) { ?>
        <?php foreach ($answers as $ans) { ?>
            <div class="q-card">
                <table class="full-width q-header">
                    <tr>
                        <td style="width: 70%; text-align: left;">
                            <strong>Question #<?php echo $ans->QUESTION_NUMBER; ?>:</strong>
                            <?php echo htmlspecialchars($ans->QUESTION_TEXT); ?>
                        </td>
                        <td style="width: 30%; text-align: right;">
                            <?php if ($ans->IS_CORRECT == 1) { ?>
                                <span class="badge-pass">Correct (+<?php echo round($ans->MARKS_AWARDED, 1); ?>)</span>
                            <?php } else { ?>
                                <span class="badge-fail">Incorrect (0.0)</span>
                            <?php } ?>
                        </td>
                    </tr>
                </table>

                <div class="q-body">
                    <?php
                    $opts = [
                        '1' => ['text' => $ans->OPTION_A, 'letter' => 'A'],
                        '2' => ['text' => $ans->OPTION_B, 'letter' => 'B'],
                        '3' => ['text' => $ans->OPTION_C, 'letter' => 'C'],
                        '4' => ['text' => $ans->OPTION_D, 'letter' => 'D'],
                    ];

                    foreach ($opts as $optNum => $optVal) {
                        if (!empty($optVal['text'])) {
                            $isUserChoice = ($ans->SELECTED_OPTION == $optNum);
                            $isCorrectChoice = ($ans->CORRECT_OPTION == $optNum);

                            $cls = 'opt-regular';
                            $prefix = '';

                            if ($isUserChoice && $ans->IS_CORRECT == 1) {
                                $cls = 'opt-user-correct';
                                $prefix = '[SELECTED - CORRECT] ';
                            } elseif ($isUserChoice && $ans->IS_CORRECT == 0) {
                                $cls = 'opt-user-wrong';
                                $prefix = '[SELECTED - WRONG] ';
                            } elseif ($isCorrectChoice && $ans->IS_CORRECT == 0) {
                                $cls = 'opt-correct-target';
                                $prefix = '[CORRECT ANSWER] ';
                            }
                            ?>
                            <div class="opt-item <?php echo $cls; ?>">
                                <strong>(<?php echo $optVal['letter']; ?>)</strong> <?php echo $prefix; ?><?php echo htmlspecialchars($optVal['text']); ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p style="text-align: center; color: #888;">No question snapshot records found for this attempt.</p>
    <?php } ?>

    <!-- Section 3: Signatures & Compliance Verification -->
    <table class="full-width" style="margin-top: 15px; border-top: 1px solid #ccc; padding-top: 10px; page-break-inside: avoid;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <div style="font-weight: bold; font-size: 9.5px;">Visitor Signature & Acknowledgement:</div>
                <div style="margin-top: 25px; font-size: 9.5px; border-top: 1px dashed #777; width: 75%;">
                    <strong><?php echo htmlspecialchars($visitorName); ?></strong><br>
                    <small>Signature & Date</small>
                </div>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: top;">
                <div style="font-weight: bold; font-size: 9.5px;">HSSE Examination Invigilator / Authority:</div>
                <div style="margin-top: 25px; font-size: 9.5px; border-top: 1px dashed #777; width: 75%; margin-left: auto;">
                    <strong>Lumut Port HSSE Safety Department</strong><br>
                    <small>Lumut Maritime Terminal Sdn Bhd</small>
                </div>
            </td>
        </tr>
    </table>

    <htmlpagefooter name="html_myFooter">
        <div style="text-align: center; font-size: 8.5px; color: #888; border-top: 1px solid #eee; padding-top: 4px;">
            Lumut Maritime Terminal Sdn Bhd &copy; <?php echo date('Y'); ?> | Automated Safety Induction Examination System | Page {PAGENO} of {nb}
        </div>
    </htmlpagefooter>

</body>
</html>

