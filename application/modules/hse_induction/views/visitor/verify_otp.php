<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($site_title) ? $site_title : 'Verify OTP - Lumut Port HSE Induction'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700,800&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH_CSS; ?>adminlte.min.css">
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH_CSS; ?>kabbani_styles.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #0b1727 0%, #172a45 50%, #0b1727 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Source Sans Pro', sans-serif;
            padding: 20px 15px;
            color: #1e293b;
        }
        .otp-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            max-width: 520px;
            width: 100%;
            overflow: hidden;
            border-top: 6px solid #0284c7;
        }
        .header-brand {
            background-color: #161D26;
            color: #ffffff;
            padding: 22px 24px;
            text-align: center;
        }
        .header-brand img {
            max-height: 44px;
            margin-bottom: 8px;
        }
        .header-brand h4 {
            margin: 0;
            font-weight: 800;
            letter-spacing: 1px;
            color: #FEC001;
            font-size: 1.2rem;
        }
        .header-brand p {
            margin: 4px 0 0 0;
            color: #94a3b8;
            font-size: 0.85rem;
        }
        .otp-body {
            padding: 32px 30px;
        }
        .icon-shield {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background-color: #e0f2fe;
            color: #0284c7;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 16px;
            box-shadow: 0 6px 16px rgba(2, 132, 199, 0.25);
        }
        .otp-input-field {
            font-size: 28px;
            letter-spacing: 10px;
            text-align: center;
            font-family: monospace;
            font-weight: 800;
            height: 58px;
            border: 2px solid #cbd5e1;
            border-radius: 10px;
            color: #0f172a;
            transition: all 0.25s ease;
        }
        .otp-input-field:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.2);
            outline: none;
        }
        .visitor-info-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 22px;
            font-size: 0.88rem;
        }
    </style>
</head>
<body>

<div class="otp-card">
    <div class="header-brand">
        <img src="<?php echo BASE_URL; ?>assets/images/hse_induction/lumut_port_logo.png" alt="Lumut Port Logo">
        <h4>LUMUT MARITIME TERMINAL</h4>
        <p>HSSE DEPARTMENT &bull; VISITOR HSE INDUCTION</p>
    </div>

    <div class="otp-body text-center">
        <?php if (!empty($is_expired)) { ?>
            <!-- EXPIRED STATE -->
            <div class="icon-shield" style="background-color: #fee2e2; color: #dc2626;">
                <i class="fas fa-calendar-times"></i>
            </div>

            <h3 class="font-weight-bold text-danger mb-1">Induction Certificate Expired</h3>
            <p class="text-muted mb-3 small">
                Your HSE Induction Port Pass and safety clearance expired on <strong><?php echo (!empty($visitor->VALIDITY_DATE)) ? date('d-m-Y', strtotime($visitor->VALIDITY_DATE)) : 'Due Date'; ?></strong>.
            </p>

            <div class="alert alert-warning py-3 text-left small mb-3">
                <h6 class="font-weight-bold mb-1"><i class="fas fa-exclamation-triangle mr-1"></i> New Registration Required</h6>
                Under Lumut Port HSSE regulations, an expired certificate cannot be used for terminal entry. Please register again to attend the HSE Induction briefing and obtain a new valid port pass.
            </div>

            <div class="visitor-info-box text-left">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Visitor Name:</span>
                    <strong class="text-dark"><?php echo htmlspecialchars($visitor->VISITOR_NAME); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Company:</span>
                    <strong class="text-dark"><?php echo htmlspecialchars($visitor->COMPANY_NAME); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Previous Pass Ref:</span>
                    <strong class="text-secondary font-monospace"><?php echo htmlspecialchars(!empty($visitor->CERTIFICATE_NO) ? $visitor->CERTIFICATE_NO : $visitor->VISITOR_REG_NO); ?></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Validity Expired:</span>
                    <span class="text-danger font-weight-bold"><?php echo (!empty($visitor->VALIDITY_DATE) && $visitor->VALIDITY_DATE != '0000-00-00') ? date('d-m-Y', strtotime($visitor->VALIDITY_DATE)) : (!empty($visitor->VISIT_DATETIME_END) ? date('d-m-Y H:i', strtotime($visitor->VISIT_DATETIME_END)) : '-'); ?></span>
                </div>
            </div>

            <a href="<?php echo BASE_URL; ?>hse_induction/visitor_registration" class="btn btn-primary btn-block font-weight-bold py-2 shadow-sm" style="font-size: 1.05rem; border-radius: 8px;">
                <i class="fas fa-user-plus mr-1"></i> Register Again for HSE Induction
            </a>

            <div class="mt-4 pt-2 border-top text-muted small">
                &copy; <?php echo date('Y'); ?> Lumut Maritime Terminal Sdn Bhd &bull; HSSE Department
            </div>

        <?php } else { ?>

            <!-- ACTIVE / VERIFICATION STATE -->
            <?php if (!empty($is_passed)) { ?>
                <div class="icon-shield" style="background-color: #dcfce7; color: #16a34a;">
                    <i class="fas fa-award"></i>
                </div>
                <h3 class="font-weight-bold text-dark mb-1">Access Your Port Pass & Certificate</h3>
                <p class="text-muted mb-3 small">
                    You have successfully passed the HSE Induction Assessment with a <strong>100% Score</strong>! Please enter your OTP code to view and download your official Port Pass & Certificate.
                </p>
            <?php } else { ?>
                <div class="icon-shield">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="font-weight-bold text-dark mb-1">Enter Verification OTP</h3>
                <p class="text-muted mb-3 small">
                    Please enter the 6-digit One-Time Password sent to your email to access the mandatory HSE briefing and assessment.
                </p>
            <?php } ?>

            <?php if ($this->session->flashdata('error_msg')) { ?>
                <div class="alert alert-danger py-2 text-left small mb-3">
                    <i class="fas fa-exclamation-triangle mr-1"></i> <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
            <?php } ?>

            <div class="visitor-info-box text-left">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Visitor Name:</span>
                    <strong class="text-dark"><?php echo htmlspecialchars($visitor->VISITOR_NAME); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Company:</span>
                    <strong class="text-dark"><?php echo htmlspecialchars($visitor->COMPANY_NAME); ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Registration No:</span>
                    <strong class="text-primary font-monospace"><?php echo htmlspecialchars($visitor->VISITOR_REG_NO); ?></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Email Sent To:</span>
                    <span class="text-muted font-italic"><?php echo htmlspecialchars($visitor->EMAIL_ID); ?></span>
                </div>
            </div>

            <form method="post" action="<?php echo BASE_URL; ?>hse_induction/visitor_registration/verify_otp" autocomplete="off">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                <div class="form-group text-left mb-4">
                    <label class="font-weight-bold text-dark small text-uppercase" style="letter-spacing: 0.5px;">6-Digit OTP Code <span class="text-danger">*</span></label>
                    <input type="text" name="otp_code" maxlength="6" pattern="[0-9]{6}" required class="form-control otp-input-field" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;" autofocus>
                    <small class="form-text text-muted text-center mt-2">
                        <i class="fas fa-clock mr-1"></i> Enter the 6-digit OTP code received in your email.
                    </small>
                </div>

                <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2" style="font-size: 1.05rem; border-radius: 8px;">
                    <?php echo (!empty($is_passed)) ? 'Verify & Download Pass <i class="fas fa-download ml-1"></i>' : 'Verify & Proceed to Induction <i class="fas fa-arrow-right ml-1"></i>'; ?>
                </button>
            </form>

            <div class="mt-4 pt-2 border-top text-muted small">
                Did not receive the OTP? Please contact Lumut Port HSSE or your LMTSB host to resend your invitation code.
            </div>

        <?php } ?>
    </div>
</div>

<script src="<?php echo LAYOUT_PLUG_PATH; ?>jquery/jquery.min.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.js"></script>
<?php if ($this->session->flashdata('error_msg')) { ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Authentication Error',
        text: <?php echo json_encode($this->session->flashdata('error_msg')); ?>,
        confirmButtonColor: '#0284c7'
    });
</script>
<?php } ?>
</body>
</html>

