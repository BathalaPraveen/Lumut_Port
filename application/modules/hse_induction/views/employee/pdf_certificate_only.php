<?php
$empName = isset($emp->EMP_NAME) ? $emp->EMP_NAME : 'Employee';
$empCode = isset($emp->EMP_ID) ? $emp->EMP_ID : '';
$inductionDate = (!empty($induction->PASSED_DATE)) ? date('d/m/Y', strtotime($induction->PASSED_DATE)) : date('d/m/Y');
$dueDate = (!empty($induction->VALIDITY_DATE) && $induction->VALIDITY_DATE != '0000-00-00') ? date('d/m/Y', strtotime($induction->VALIDITY_DATE)) : date('d/m/Y', strtotime('+1 year'));

$certBgPath = FCPATH . 'assets/images/hse_induction/certificate_bg.png';
$logoPath = FCPATH . 'assets/images/hse_induction/lumut_port_logo.png';
$sampleQr = FCPATH . 'assets/images/hse_induction/sample_qr.png';

$qrPath = (!empty($induction->QR_CODE_PATH) && file_exists(FCPATH . $induction->QR_CODE_PATH))
    ? (FCPATH . $induction->QR_CODE_PATH)
    : $sampleQr;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Certificate of Completion - <?php echo htmlspecialchars($empName); ?></title>
    <style>
        @page {
            background: url("<?php echo $certBgPath; ?>") no-repeat 0 0;
            background-image-resize: 6;
            margin: 0;
        }
        body {
            font-family: "Bell MT", Georgia, "Times New Roman", serif;
            text-align: center;
            color: #1a202c;
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body>
    <div style="padding-top: 55px; text-align: center;">
        <img src="<?php echo $logoPath; ?>" style="width: 140px;" alt="Lumut Port Logo" />
    </div>

    <div style="margin-top: 25px;">
        <div style="font-size: 36pt; font-weight: bold; letter-spacing: 2px; color: #161D26; text-transform: uppercase;">
            CERTIFICATE
        </div>
        <div style="font-size: 21pt; font-weight: bold; letter-spacing: 3px; color: #161D26; margin-top: 4px; text-transform: uppercase;">
            OF COMPLETION
        </div>
    </div>

    <div style="margin-top: 35px;">
        <div style="font-size: 15pt; font-style: italic; color: #4b5563;">
            This is to certify that
        </div>
        <div style="font-size: 24pt; font-weight: bold; color: #0b1118; margin: 14px 0; text-transform: uppercase; letter-spacing: 1px;">
            <?php echo htmlspecialchars($empName); ?>
        </div>
        <div style="font-size: 14pt; color: #4b5563;">
            has successfully completed the
        </div>
        <div style="font-size: 19pt; font-weight: bold; color: #161D26; margin-top: 8px; letter-spacing: 1px;">
            LUMUT PORT - HSE INDUCTION TRAINING
        </div>
    </div>

    <!-- Centered Compact QR Code (Table prevents mPDF 100% width stretch) -->
    <table align="center" style="margin: 25px auto 0 auto; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 5px; background-color: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 6px; text-align: center;">
                <img src="<?php echo $qrPath; ?>" style="width: 80px; height: 80px;" alt="QR Code" />
            </td>
        </tr>
    </table>

    <div style="margin-top: 25px; font-size: 12pt; font-weight: bold; color: #1e293b;">
        Induction Date : <?php echo $inductionDate; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Due Date : <?php echo $dueDate; ?>
    </div>
</body>
</html>
