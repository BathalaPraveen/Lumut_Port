<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($site_title) ? $site_title : 'Visitor Registration Submitted - Lumut Port'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700,800&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH_CSS; ?>adminlte.min.css">
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH_CSS; ?>kabbani_styles.css">

    <style>
        body {
            background: linear-gradient(135deg, #0b1727 0%, #172a45 50%, #0b1727 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Source Sans Pro', sans-serif;
            padding: 30px 15px;
            color: #1e293b;
        }
        .success-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
            max-width: 680px;
            width: 100%;
            overflow: hidden;
            border-top: 6px solid #28a745;
        }
        .header-brand {
            background-color: #161D26;
            color: #ffffff;
            padding: 24px 30px;
            text-align: center;
            position: relative;
        }
        .header-brand img {
            max-height: 48px;
            margin-bottom: 10px;
        }
        .header-brand h4 {
            margin: 0;
            font-weight: 800;
            letter-spacing: 1px;
            color: #FEC001;
            font-size: 1.25rem;
        }
        .header-brand p {
            margin: 4px 0 0 0;
            color: #94a3b8;
            font-size: 0.88rem;
        }
        .success-body {
            padding: 32px 36px;
        }
        .icon-circle {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background-color: #d1fae5;
            color: #059669;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin-bottom: 16px;
            box-shadow: 0 6px 15px rgba(5, 150, 105, 0.2);
        }
        .ref-box {
            background-color: #f8fafc;
            border: 2px dashed #0284c7;
            border-radius: 10px;
            padding: 16px;
            margin: 20px 0;
            text-align: center;
        }
        .ref-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            font-weight: 700;
            display: block;
        }
        .ref-number {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0284c7;
            font-family: monospace;
            letter-spacing: 1px;
            margin-top: 4px;
        }
        .details-table th {
            width: 40%;
            color: #64748b;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 12px;
            border: none;
            background: #f8fafc;
        }
        .details-table td {
            color: #0f172a;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 8px 12px;
            border: none;
            background: #f8fafc;
        }
        .notice-box {
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 14px 18px;
            border-radius: 4px;
            margin-top: 22px;
            font-size: 0.9rem;
            color: #92400e;
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="header-brand">
        <img src="<?php echo BASE_URL; ?>assets/images/hse_induction/lumut_port_logo.png" alt="Lumut Port Logo">
        <h4>LUMUT MARITIME TERMINAL</h4>
        <p>HSSE DEPARTMENT &bull; VISITOR SAFETY MANAGEMENT</p>
    </div>

    <div class="success-body text-center">
        <div class="icon-circle">
            <i class="fas fa-check"></i>
        </div>

        <h3 class="font-weight-bold text-dark mb-1">Registration Submitted!</h3>
        <p class="text-muted mb-3">Your visitor pass request has been successfully recorded and submitted for HSSE approval.</p>

        <div class="ref-box">
            <span class="ref-label">Registration Reference Number</span>
            <div class="ref-number"><?php echo htmlspecialchars($visitor->VISITOR_REG_NO); ?></div>
            <div class="mt-2">
                <span class="badge badge-warning px-3 py-1 font-weight-bold" style="font-size: 0.85rem;">
                    <i class="fas fa-hourglass-half mr-1"></i> PENDING HSSE APPROVAL
                </span>
            </div>
        </div>

        <div class="text-left mt-3">
            <table class="table table-sm details-table rounded overflow-hidden">
                <tbody>
                    <tr>
                        <th>Visitor Name</th>
                        <td><?php echo htmlspecialchars($visitor->VISITOR_NAME); ?></td>
                    </tr>
                    <tr>
                        <th>Company Name</th>
                        <td><?php echo htmlspecialchars($visitor->COMPANY_NAME); ?></td>
                    </tr>
                    <tr>
                        <th>IC / Passport No.</th>
                        <td><?php echo htmlspecialchars($visitor->IC_PASSPORT_NO); ?></td>
                    </tr>
                    <tr>
                        <th>Email ID</th>
                        <td><?php echo htmlspecialchars($visitor->EMAIL_ID); ?></td>
                    </tr>
                    <tr>
                        <th>Scheduled Visit</th>
                        <td><?php echo date('d-m-Y H:i', strtotime($visitor->VISIT_DATETIME)); ?></td>
                    </tr>
                    <tr>
                        <th>Terminal</th>
                        <td><?php echo !empty($visitor->TERMINAL_NAME) ? htmlspecialchars($visitor->TERMINAL_NAME) : 'Lumut Port'; ?></td>
                    </tr>
                    <tr>
                        <th>Person of Contact</th>
                        <td><?php echo !empty($visitor->PIC_EMP_NAME) ? htmlspecialchars($visitor->PIC_EMP_NAME) : (!empty($visitor->CONTACT_PERSON_NAME) ? htmlspecialchars($visitor->CONTACT_PERSON_NAME) : '-'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="notice-box text-left">
            <h6 class="font-weight-bold mb-1"><i class="fas fa-info-circle mr-1"></i> Next Steps & Email Notification:</h6>
            <p class="mb-0">
                1. Your application is being reviewed by the Lumut Port HSSE Department.<br>
                2. Once approved, you will receive an invitation email at <strong><?php echo htmlspecialchars($visitor->EMAIL_ID); ?></strong> containing your secure assessment link and a <strong>One-Time Password (OTP)</strong>.<br>
                3. You will watch the required HSE briefing video and pass the safety assessment before your visit.
            </p>
        </div>

        <div class="mt-4 pt-2 d-flex justify-content-center" style="gap: 12px;">
            <a href="<?php echo BASE_URL; ?>login" class="btn btn-outline-secondary font-weight-bold px-4 py-2">
                <i class="fas fa-arrow-left mr-1"></i> Return to Login
            </a>
            <a href="<?php echo BASE_URL; ?>hse_induction/visitor_registration" class="btn btn-primary font-weight-bold px-4 py-2">
                <i class="fas fa-user-plus mr-1"></i> Register Another Visitor
            </a>
        </div>
    </div>
</div>

</body>
</html>

