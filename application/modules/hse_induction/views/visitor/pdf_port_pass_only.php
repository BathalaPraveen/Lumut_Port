<?php
$visitorName = isset($visitor->VISITOR_NAME) ? $visitor->VISITOR_NAME : 'Visitor';
$visitorComp = isset($visitor->COMPANY_NAME) ? $visitor->COMPANY_NAME : 'Visitor Company';
$visitorIc = isset($visitor->IC_PASSPORT_NO) ? $visitor->IC_PASSPORT_NO : '-';
$terminalName = !empty($visitor->TERMINAL_NAME) ? $visitor->TERMINAL_NAME : 'Lumut Port';
$certNo = !empty($visitor->CERTIFICATE_NO) ? $visitor->CERTIFICATE_NO : ('PORT-VIS-' . str_pad($visitor->VISITOR_ID, 4, '0', STR_PAD_LEFT));
$inductionDate = (!empty($visitor->PASSED_DATE)) ? date('d/m/Y', strtotime($visitor->PASSED_DATE)) : date('d/m/Y');
$dueDate = (!empty($visitor->VALIDITY_DATE) && $visitor->VALIDITY_DATE != '0000-00-00') ? date('d/m/Y', strtotime($visitor->VALIDITY_DATE)) : date('d/m/Y', strtotime('+1 day'));

// Absolute paths for mPDF
$logoPath = FCPATH . 'assets/images/hse_induction/lumut_port_logo.png';
$badgeLogo = FCPATH . 'assets/images/hse_induction/lumut_port_logo.png';
$helmetIcon = FCPATH . 'assets/images/hse_induction/safety_helmet_icon.png';
$sampleQr = FCPATH . 'assets/images/hse_induction/sample_qr.png';
$defaultAvatar = FCPATH . 'assets/images/hse_induction/default_avatar.png';
$photoPath = $defaultAvatar;

$qrPath = (!empty($visitor->QR_CODE_PATH) && file_exists(FCPATH . $visitor->QR_CODE_PATH))
    ? (FCPATH . $visitor->QR_CODE_PATH)
    : $sampleQr;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Official Port Pass - <?php echo htmlspecialchars($visitorName); ?></title>
    <style>
        @page {
            margin-top: 10mm;
            margin-bottom: 8mm;
            margin-left: 10mm;
            margin-right: 10mm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }
        .full-width {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>

    <!-- Minimal Clean Header -->
    <table class="full-width" style="margin-bottom: 12px; border-bottom: 2px solid #161D26; padding-bottom: 6px;">
        <tr>
            <td style="width: 50%; vertical-align: middle;">
                <img src="<?php echo $logoPath; ?>" style="height: 32px;" alt="Lumut Port Logo" />
            </td>
            <td style="width: 50%; text-align: right; vertical-align: middle;">
                <div style="font-size: 11px; font-weight: bold; color: #161D26; text-transform: uppercase;">
                    HSSE DEPARTMENT &bull; VISITOR PORT PASS (ID BADGE)
                </div>
                <div style="font-size: 9px; color: #64748b; margin-top: 1px;">
                    Pass ID: <strong style="color: #0b1118; font-family: monospace;"><?php echo htmlspecialchars($certNo); ?></strong> | Issued: <?php echo $inductionDate; ?>
                </div>
            </td>
        </tr>
    </table>

    <!-- CUTOUT BOX WITH DASHED BORDER FOR BADGE POUCH INSERTION -->
    <div style="border: 1.5px dashed #94a3b8; border-radius: 8px; padding: 14px 10px; background-color: #f8fafc; text-align: center;">

        <div style="font-size: 8.5px; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">
            &#9986; Cut along dashed line &bull; Fits standard vertical ID badge holder (approx. 70mm &times; 100mm)
        </div>

        <!-- PORT PASS (FRONT & BACK BADGE CARDS SIDE-BY-SIDE) -->
        <table align="center" style="margin: 0 auto; border-collapse: separate; border-spacing: 18px 0;">
            <tr>
                <!-- ================= FRONT CARD ================= -->
                <td style="vertical-align: top; width: 290px;">
                    <table style="width: 290px; border: 2px solid #161D26; border-radius: 14px; border-collapse: collapse; background-color: #ffffff; overflow: hidden;">
                        <!-- Top Yellow Accent Bar -->
                        <tr>
                            <td style="background-color: #FEC001; height: 16px; font-size: 1px; line-height: 16px;">&nbsp;</td>
                        </tr>
                        <!-- Lanyard Slot Punch Guide -->
                        <tr>
                            <td align="center" style="padding-top: 8px; padding-bottom: 4px;">
                                <table align="center" style="width: 48px; height: 10px; background-color: #e2e8f0; border: 1px solid #cbd5e1; border-radius: 5px; border-collapse: collapse;">
                                    <tr><td style="height: 10px; font-size: 1px;">&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Badge Header Pill: [Helmet] PORT PASS -->
                        <tr>
                            <td align="center" style="padding: 2px 14px 4px 14px;">
                                <table align="center" style="border: 2px solid #161D26; border-radius: 18px; border-collapse: collapse; padding: 4px 14px; background-color: #ffffff;">
                                    <tr>
                                        <td style="vertical-align: middle; padding-right: 6px;">
                                            <img src="<?php echo $helmetIcon; ?>" style="width: 20px; height: 20px; vertical-align: middle;" />
                                        </td>
                                        <td style="vertical-align: middle; font-weight: 900; font-size: 13px; letter-spacing: 2px; color: #161D26;">
                                            PORT PASS
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Lumut Port Logo -->
                        <tr>
                            <td align="center" style="padding-top: 4px; padding-bottom: 2px;">
                                <img src="<?php echo $logoPath; ?>" style="height: 26px; max-width: 140px;" />
                            </td>
                        </tr>
                        <!-- Visitor Avatar / Photo -->
                        <tr>
                            <td align="center" style="padding: 6px 0;">
                                <table align="center" style="border: 1.5px solid #0284c7; border-radius: 8px; border-collapse: collapse; background-color: #f0f9ff;">
                                    <tr>
                                        <td style="padding: 4px; font-size: 1px;">
                                            <img src="<?php echo $photoPath; ?>" style="width: 100px; height: 120px; border-radius: 4px;" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Visitor Details -->
                        <tr>
                            <td align="center" style="padding: 4px 12px 12px 12px;">
                                <div style="font-weight: 900; font-size: 14px; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <?php echo htmlspecialchars($visitorName); ?>
                                </div>
                                <div style="font-weight: bold; font-size: 10px; color: #475569; margin-top: 2px;">
                                    <?php echo htmlspecialchars($visitorComp); ?>
                                </div>
                                <div style="margin-top: 4px;">
                                    <span style="display: inline-block; background-color: #e0f2fe; color: #0369a1; font-weight: bold; font-size: 9px; padding: 2px 8px; border-radius: 4px; border: 1px solid #bae6fd;">
                                        <?php echo htmlspecialchars($terminalName); ?>
                                    </span>
                                </div>
                                <div style="font-weight: 900; font-size: 10.5px; color: #dc2626; margin-top: 6px; letter-spacing: 0.5px;">
                                    VALID UNTIL : <?php echo $dueDate; ?>
                                </div>
                            </td>
                        </tr>
                        <!-- Bottom Yellow Accent Bar -->
                        <tr>
                            <td style="background-color: #FEC001; height: 16px; font-size: 1px; line-height: 16px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>

                <!-- ================= BACK CARD ================= -->
                <td style="vertical-align: top; width: 290px;">
                    <table style="width: 290px; border: 2px solid #161D26; border-radius: 14px; border-collapse: collapse; background-color: #ffffff; overflow: hidden;">
                        <!-- Top Yellow Accent Bar -->
                        <tr>
                            <td style="background-color: #FEC001; height: 16px; font-size: 1px; line-height: 16px;">&nbsp;</td>
                        </tr>
                        <!-- Lanyard Slot Punch Guide -->
                        <tr>
                            <td align="center" style="padding-top: 8px; padding-bottom: 4px;">
                                <table align="center" style="width: 48px; height: 10px; background-color: #e2e8f0; border: 1px solid #cbd5e1; border-radius: 5px; border-collapse: collapse;">
                                    <tr><td style="height: 10px; font-size: 1px;">&nbsp;</td></tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Dark Navy Metadata Card -->
                        <tr>
                            <td align="center" style="padding: 8px 12px 4px 12px;">
                                <table style="width: 100%; background-color: #161D26; border-radius: 8px; border-collapse: collapse; padding: 12px 12px; font-size: 9px; line-height: 18px;">
                                    <tr>
                                        <td style="width: 42%; color: #94a3b8; font-weight: bold; text-align: left; padding: 1px 0;">NAME :</td>
                                        <td style="color: #ffffff; font-weight: bold; text-align: right; padding: 1px 0;"><?php echo htmlspecialchars($visitorName); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #94a3b8; font-weight: bold; text-align: left; padding: 1px 0;">COMPANY :</td>
                                        <td style="color: #ffffff; font-weight: bold; text-align: right; padding: 1px 0;"><?php echo htmlspecialchars($visitorComp); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #94a3b8; font-weight: bold; text-align: left; padding: 1px 0;">I.C./PASSPORT :</td>
                                        <td style="color: #ffffff; font-weight: bold; text-align: right; padding: 1px 0;"><?php echo htmlspecialchars($visitorIc); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #94a3b8; font-weight: bold; text-align: left; padding: 1px 0;">TERMINAL :</td>
                                        <td style="color: #ffffff; font-weight: bold; text-align: right; padding: 1px 0;"><?php echo htmlspecialchars($terminalName); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #94a3b8; font-weight: bold; text-align: left; padding: 1px 0;">PASS ID :</td>
                                        <td style="color: #FEC001; font-weight: bold; font-family: monospace; text-align: right; padding: 1px 0;"><?php echo htmlspecialchars($certNo); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #94a3b8; font-weight: bold; text-align: left; padding: 1px 0;">INDUCTION DATE :</td>
                                        <td style="color: #ffffff; text-align: right; padding: 1px 0;"><?php echo $inductionDate; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #94a3b8; font-weight: bold; text-align: left; padding: 1px 0;">DUE DATE :</td>
                                        <td style="color: #4ade80; font-weight: bold; text-align: right; padding: 1px 0;"><?php echo $dueDate; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Scannable High-Res QR Code -->
                        <tr>
                            <td align="center" style="padding-top: 20px; padding-bottom: 21.5px;">
                                <table align="center" style="border: 1px solid #cbd5e1; border-radius: 6px; border-collapse: collapse; background-color: #ffffff;">
                                    <tr>
                                        <td style="padding: 4px; font-size: 1px; text-align: center;">
                                            <img src="<?php echo $qrPath; ?>" style="width: 110px; height: 110px; display: block;" />
                                        </td>
                                    </tr>
                                </table>
                                <div style="font-size: 8px; font-weight: bold; color: #161D26; margin-top: 6px;">
                                    Scan QR Code for Pass Verification
                                </div>
                            </td>
                        </tr>
                        <!-- Bottom Yellow Accent Bar -->
                        <tr>
                            <td style="background-color: #FEC001; height: 16px; font-size: 1px; line-height: 16px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Folding / Insertion Guidance -->
        <div style="font-size: 8px; color: #64748b; margin-top: 10px;">
            Fold along the vertical center line to form a two-sided card, or insert Front and Back into a clear badge holder.
        </div>
    </div>

    <!-- Security & Terminal Regulations Notice -->
    <table class="full-width" style="margin-top: 12px; border: 1px solid #e2e8f0; border-radius: 6px; padding: 6px 10px; background-color: #ffffff; font-size: 8px; line-height: 12px; color: #475569;">
        <tr>
            <td style="width: 100%;">
                <strong style="color: #0f172a;">Port Security Notice:</strong>
                This pass is non-transferable and must be worn visibly at all times within Lumut Maritime Terminal premises.
                Valid only for authorized terminal zones up to the specified due date. Authorized security and HSSE officers may scan the QR code to verify live validity at any checkpoint.
            </td>
        </tr>
    </table>

    <div style="text-align: center; font-size: 8px; color: #94a3b8; margin-top: 8px;">
        &copy; <?php echo date('Y'); ?> Lumut Maritime Terminal Sdn Bhd &bull; HSSE Department &bull; Verified Security Identification Pass
    </div>

</body>
</html>
