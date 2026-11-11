<?php
$empName = isset($emp->EMP_NAME) ? $emp->EMP_NAME : 'Employee';
$empCode = isset($emp->EMP_ID) ? $emp->EMP_ID : '';
$deptName = !empty($emp->dept_name) ? $emp->dept_name : 'LUMUT MARITIME TERMINAL';
$desigName = !empty($emp->desig_name) ? $emp->desig_name : 'STAFF';
$certNo = !empty($induction->CERTIFICATE_NO) ? $induction->CERTIFICATE_NO : ('PORT-' . str_pad($induction->ID, 4, '0', STR_PAD_LEFT));
$inductionDate = (!empty($induction->PASSED_DATE)) ? date('d/m/Y', strtotime($induction->PASSED_DATE)) : date('d/m/Y');
$dueDate = (!empty($induction->VALIDITY_DATE) && $induction->VALIDITY_DATE != '0000-00-00') ? date('d/m/Y', strtotime($induction->VALIDITY_DATE)) : date('d/m/Y', strtotime('+1 year'));

$photoPath = BASE_URL . 'assets/images/hse_induction/default_avatar.png';
if (!empty($emp->PROFILE_IMG) && file_exists(FCPATH . $emp->PROFILE_IMG)) {
    $photoPath = BASE_URL . $emp->PROFILE_IMG;
} elseif (!empty($emp->PHOTO_FILE) && file_exists(FCPATH . $emp->PHOTO_FILE)) {
    $photoPath = BASE_URL . $emp->PHOTO_FILE;
}

$qrImgSrc = (!empty($induction->QR_CODE_PATH) && file_exists(FCPATH . $induction->QR_CODE_PATH))
    ? BASE_URL . $induction->QR_CODE_PATH
    : BASE_URL . 'assets/images/hse_induction/sample_qr.png';
?>

<style>
/* -------------------------------------------------------------
   CONTAINER & TABS STYLES (FULL PAGE WIDTH MATCHING OTHER MODULES)
   ------------------------------------------------------------- */
.card-outline-tabs .nav-tabs .nav-link {
    font-size: 0.95rem;
    font-weight: 700;
    color: #495057;
    padding: 10px 20px;
    border-radius: 4px 4px 0 0;
}
.card-outline-tabs .nav-tabs .nav-link.active {
    color: #007bff;
    border-top: 3px solid #007bff;
    background-color: #ffffff;
    font-weight: 800;
}

/* -------------------------------------------------------------
   PORT PASS BADGE STYLES (MATCHES USER PPTX TEMPLATE EXACTLY)
   ------------------------------------------------------------- */
.port-pass-cards-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
    padding: 20px 0;
}

.pass-badge-card {
    width: 340px;
    background: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

/* Yellow Accent Strips */
.badge-strip-top {
    height: 18px;
    background: #FEC001;
    width: 100%;
}
.badge-strip-bottom {
    height: 14px;
    background: #FEC001;
    width: 100%;
    margin-top: auto;
}

/* Lanyard Slot Punch */
.lanyard-slot {
    width: 48px;
    height: 12px;
    background-color: #e2e8f0;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    margin: 10px auto 6px auto;
}

.badge-card-body {
    padding: 12px 18px 18px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Badge Header Pill */
.badge-header-pill {
    border: 2px solid #161D26;
    border-radius: 25px;
    padding: 4px 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 4px 0 10px 0;
    background: #ffffff;
}
.helmet-circle {
    width: 32px;
    height: 32px;
    background: #FEC001;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.helmet-circle img {
    width: 22px;
    height: 22px;
    object-fit: contain;
}
.badge-header-title {
    font-weight: 900;
    font-size: 1.15rem;
    letter-spacing: 2px;
    color: #161D26;
}

/* Lumut Port Logo Badge */
.lumut-badge-logo {
    text-align: center;
    margin: 4px 0 8px 0;
}
.lumut-badge-logo img {
    height: 34px;
    max-width: 160px;
    object-fit: contain;
}

/* Tech Photo Frame with Corner Brackets */
.tech-photo-frame {
    position: relative;
    width: 140px;
    height: 170px;
    margin: 8px auto;
    padding: 8px;
    background: #f8fafc;
}
.emp-photo-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 1px solid #cbd5e1;
}

/* Tech Corner Markers */
.corner-mk {
    position: absolute;
    width: 16px;
    height: 16px;
    border: 3px solid #161D26;
    pointer-events: none;
}
.corner-mk.top-left {
    top: 0;
    left: 0;
    border-right: none;
    border-bottom: none;
}
.corner-mk.top-right {
    top: 0;
    right: 0;
    border-left: none;
    border-bottom: none;
}
.corner-mk.bottom-left {
    bottom: 0;
    left: 0;
    border-right: none;
    border-top: none;
}
.corner-mk.bottom-right {
    bottom: 0;
    right: 0;
    border-left: none;
    border-top: none;
}

/* Front Details */
.front-emp-info {
    text-align: center;
    margin-top: 10px;
}
.front-emp-name {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0b1118;
    text-transform: uppercase;
    line-height: 1.3;
}
.front-emp-comp {
    font-size: 0.95rem;
    font-weight: 700;
    color: #374151;
    margin-top: 4px;
}
.front-emp-valid {
    font-size: 0.95rem;
    font-weight: 800;
    color: #b91c1c;
    margin-top: 8px;
    letter-spacing: 0.5px;
}

/* -------------------------------------------------------------
   BACK PASS CARD (DARK METADATA & QR CODE)
   ------------------------------------------------------------- */
.dark-meta-card {
    background-color: #161D26;
    border-radius: 12px;
    padding: 14px 16px;
    margin: 4px 0 12px 0;
    color: #ffffff;
}
.meta-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    font-size: 0.82rem;
    line-height: 1.5;
    margin-bottom: 5px;
    border-bottom: 1px dotted rgba(255,255,255,0.12);
    padding-bottom: 3px;
}
.meta-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
}
.meta-lbl {
    color: #94a3b8;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.76rem;
    width: 44%;
}
.meta-val {
    color: #ffffff;
    font-weight: 700;
    text-align: right;
    width: 56%;
    word-break: break-word;
}
.meta-val.gold {
    color: #FEC001;
    font-family: monospace;
    font-size: 0.9rem;
}
.meta-val.green {
    color: #4ade80;
}

/* Tech QR Frame */
.tech-qr-frame {
    position: relative;
    width: 140px;
    height: 140px;
    margin: 8px auto 6px auto;
    padding: 8px;
    background: #ffffff;
}
.qr-code-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.qr-scan-text {
    font-size: 0.75rem;
    font-weight: 800;
    color: #1e293b;
    text-align: center;
    letter-spacing: 0.5px;
    margin-top: 4px;
}

/* -------------------------------------------------------------
   CERTIFICATE OF COMPLETION (A4 PORTRAIT TEMPLATE)
   ------------------------------------------------------------- */
.cert-display-card {
    max-width: 820px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 1px solid #e2e8f0;
}
.cert-background-canvas {
    background: url('<?php echo BASE_URL; ?>assets/images/hse_induction/certificate_bg.png') no-repeat center top / 100% 100%;
    min-height: 1140px;
    padding: 70px 60px 80px 60px;
    position: relative;
    text-align: center;
    font-family: "Bell MT", Georgia, "Times New Roman", serif;
}
.cert-top-logo {
    text-align: center;
    margin-bottom: 30px;
}
.cert-top-logo img {
    width: 180px;
    max-width: 80%;
    object-fit: contain;
}
.cert-heading-1 {
    font-size: 3.4rem;
    font-weight: 800;
    letter-spacing: 3px;
    color: #161D26;
    margin: 0;
    line-height: 1.1;
    text-transform: uppercase;
}
.cert-heading-2 {
    font-size: 1.9rem;
    font-weight: 800;
    letter-spacing: 4px;
    color: #161D26;
    margin: 6px 0 0 0;
    text-transform: uppercase;
}
.cert-body-text {
    margin-top: 45px;
    color: #161D26;
}
.cert-preamble {
    font-size: 1.45rem;
    font-style: italic;
    color: #4b5563;
    margin-bottom: 20px;
}
.cert-recipient-name {
    font-size: 2.3rem;
    font-weight: 800;
    color: #0b1118;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid #cbd5e1;
    display: inline-block;
    padding: 0 40px 8px 40px;
    margin: 10px 0 20px 0;
}
.cert-middle-text {
    font-size: 1.35rem;
    color: #4b5563;
    margin-bottom: 12px;
}
.cert-training-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #161D26;
    letter-spacing: 1px;
    margin-top: 10px;
}
.cert-qr-holder {
    margin-top: 45px;
    text-align: center;
}
.cert-qr-inner {
    display: inline-block;
    padding: 8px;
    background: #ffffff;
    border: 2px solid #cbd5e1;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}
.cert-qr-inner img {
    width: 135px;
    height: 135px;
    display: block;
}
.cert-dates-row {
    margin-top: 30px;
    font-size: 1.15rem;
    font-weight: 800;
    color: #1e293b;
    letter-spacing: 0.5px;
}

/* -------------------------------------------------------------
   PRINT MEDIA RULES
   ------------------------------------------------------------- */
@media print {
    body * {
        visibility: hidden;
    }
    .main-footer, .main-header, .main-sidebar, .content-header, .no-print, .nav-tabs {
        display: none !important;
    }
    .print-target-area, .print-target-area * {
        visibility: visible;
    }
    .print-target-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .tab-content > .tab-pane {
        display: block !important;
        opacity: 1 !important;
    }
    .cert-display-card {
        box-shadow: none !important;
        border: none !important;
    }
    .pass-badge-card {
        box-shadow: none !important;
        page-break-inside: avoid;
    }
}
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header no-print">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-id-card text-success mr-2"></i>HSE Induction Pass & Certificate</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>hse_induction/employee">HSE Induction</a></li>
                            <li class="breadcrumb-item active">Pass & Certificate</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline card-outline-tabs shadow-sm">
                            <div class="card-header p-0 border-bottom-0 no-print">
                                <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2">
                                    <h4 class="card-title font-weight-bold mb-0">
                                        <i class="fas fa-id-card text-primary mr-2"></i> HSE Induction Pass & Certificate
                                    </h4>
                                    <div class="d-flex align-items-center" style="gap: 15px;">
                                        <div class="text-muted small d-none d-sm-block">
                                            Candidate: <strong class="text-dark"><?php echo htmlspecialchars($empName); ?></strong>
                                        </div>
                                        <a href="<?php echo BASE_URL; ?>hse_induction/employee" class="btn btn-sm btn-primary">
                                            <i class="fa fa-arrow-left mr-1"></i> Back
                                        </a>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs px-3" id="passCertTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active font-weight-bold" id="tab-pass-link" data-toggle="tab" href="#tab-port-pass" role="tab">
                                            <i class="fas fa-id-badge text-warning mr-1"></i> PORT PASS (ID BADGE)
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold" id="tab-cert-link" data-toggle="tab" href="#tab-certificate" role="tab">
                                            <i class="fas fa-award text-primary mr-1"></i> CERTIFICATE OF COMPLETION
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold" id="tab-log-link" data-toggle="tab" href="#tab-audit-log" role="tab">
                                            <i class="fas fa-history text-secondary mr-1"></i> ASSESSMENT AUDIT LOG
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content print-target-area" id="passCertTabsContent">

                        <!-- TAB 1: PORT PASS BADGE (FRONT & BACK CARDS) -->
                        <div class="tab-pane fade show active" id="tab-port-pass" role="tabpanel">
                            
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom no-print">
                                <div>
                                    <span class="badge badge-success px-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
                                        <i class="fas fa-check-circle mr-1"></i> HSE INDUCTION VERIFIED &bull; 100% PASSED
                                    </span>
                                </div>
                                <div class="d-flex align-items-center mt-2 mt-sm-0" style="gap: 6px;">
                                    <a href="<?php echo BASE_URL; ?>hse_induction/employee/pass_pdf/<?php echo $enc_id; ?>" target="_blank" class="btn btn-sm btn-outline-success font-weight-bold shadow-sm" title="Download Port Pass (PDF)">
                                        <i class="fas fa-download mr-1"></i> Download Pass (PDF)
                                    </a>
                                    <button type="button" onclick="window.print();" class="btn btn-sm btn-outline-secondary shadow-sm" title="Print Port Pass">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="port-pass-cards-row">
                                <!-- FRONT CARD -->
                                <div class="pass-badge-card">
                                    <div class="badge-strip-top"></div>
                                    <div class="lanyard-slot"></div>

                                    <div class="badge-card-body">
                                        <!-- Header Pill -->
                                        <div class="badge-header-pill">
                                            <div class="helmet-circle">
                                                <img src="<?php echo BASE_URL; ?>assets/images/hse_induction/safety_helmet_icon.png" alt="Safety Helmet">
                                            </div>
                                            <div class="badge-header-title">PORT PASS</div>
                                        </div>

                                        <!-- Lumut Logo -->
                                        <div class="lumut-badge-logo">
                                            <img src="<?php echo BASE_URL; ?>assets/images/hse_induction/lumut_port_logo.png" alt="Lumut Port">
                                        </div>

                                        <!-- Photo Frame with Tech Corner Markers -->
                                        <div class="tech-photo-frame">
                                            <div class="corner-mk top-left"></div>
                                            <div class="corner-mk top-right"></div>
                                            <div class="corner-mk bottom-left"></div>
                                            <div class="corner-mk bottom-right"></div>
                                            <img src="<?php echo $photoPath; ?>" class="emp-photo-img" alt="Employee Photo">
                                        </div>

                                        <!-- Front Information -->
                                        <div class="front-emp-info">
                                            <div class="front-emp-name"><?php echo htmlspecialchars($empName); ?></div>
                                            <div class="front-emp-comp"><?php echo htmlspecialchars($deptName); ?></div>
                                            <div class="front-emp-valid">VALID UNTIL : <?php echo $dueDate; ?></div>
                                        </div>
                                    </div>

                                    <div class="badge-strip-bottom"></div>
                                </div>

                                <!-- BACK CARD -->
                                <div class="pass-badge-card">
                                    <div class="badge-strip-top"></div>
                                    <div class="lanyard-slot"></div>

                                    <div class="badge-card-body">
                                        <!-- Dark Metadata Box -->
                                        <div class="dark-meta-card">
                                            <div class="meta-row">
                                                <span class="meta-lbl">NAME :</span>
                                                <span class="meta-val"><?php echo htmlspecialchars($empName); ?></span>
                                            </div>
                                            <div class="meta-row">
                                                <span class="meta-lbl">COMPANY :</span>
                                                <span class="meta-val"><?php echo htmlspecialchars($deptName); ?></span>
                                            </div>
                                            <div class="meta-row">
                                                <span class="meta-lbl">I.C./PASSPORT :</span>
                                                <span class="meta-val"><?php echo htmlspecialchars($empCode); ?></span>
                                            </div>
                                            <div class="meta-row">
                                                <span class="meta-lbl">DESIGNATION:</span>
                                                <span class="meta-val"><?php echo htmlspecialchars($desigName); ?></span>
                                            </div>
                                            <div class="meta-row">
                                                <span class="meta-lbl">PASS ID :</span>
                                                <span class="meta-val gold"><?php echo htmlspecialchars($certNo); ?></span>
                                            </div>
                                            <div class="meta-row">
                                                <span class="meta-lbl">INDUCTION DATE :</span>
                                                <span class="meta-val"><?php echo $inductionDate; ?></span>
                                            </div>
                                            <div class="meta-row">
                                                <span class="meta-lbl">DUE DATE :</span>
                                                <span class="meta-val green"><?php echo $dueDate; ?></span>
                                            </div>
                                        </div>

                                        <!-- QR Code with Tech Frame -->
                                        <div class="tech-qr-frame">
                                            <div class="corner-mk top-left"></div>
                                            <div class="corner-mk top-right"></div>
                                            <div class="corner-mk bottom-left"></div>
                                            <div class="corner-mk bottom-right"></div>
                                            <img src="<?php echo $qrImgSrc; ?>" class="qr-code-img" alt="Pass QR Code">
                                        </div>
                                        <div class="qr-scan-text">Scan QR Code for Pass Verification</div>
                                    </div>

                                    <div class="badge-strip-bottom"></div>
                                </div>
                            </div>

                        </div>

                        <!-- TAB 2: CERTIFICATE OF COMPLETION (A4 PORTRAIT) -->
                        <div class="tab-pane fade" id="tab-certificate" role="tabpanel">
                            
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom no-print">
                                <div>
                                    <span class="text-muted small font-weight-bold">
                                        <i class="fas fa-award text-warning mr-1"></i> Official Certificate of Completion
                                    </span>
                                </div>
                                <div class="d-flex align-items-center mt-2 mt-sm-0" style="gap: 6px;">
                                    <a href="<?php echo BASE_URL; ?>hse_induction/employee/certificate_pdf/<?php echo $enc_id; ?>" target="_blank" class="btn btn-sm btn-outline-warning text-dark font-weight-bold shadow-sm" title="Download Certificate (PDF)">
                                        <i class="fas fa-download mr-1"></i> Download Certificate (PDF)
                                    </a>
                                    <button type="button" onclick="window.print();" class="btn btn-sm btn-outline-secondary shadow-sm" title="Print Certificate">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="cert-display-card">
                                <div class="cert-background-canvas">
                                    
                                    <!-- Logo -->
                                    <div class="cert-top-logo">
                                        <img src="<?php echo BASE_URL; ?>assets/images/hse_induction/lumut_port_logo.png" alt="Lumut Port Logo">
                                    </div>

                                    <!-- Certificate Titles -->
                                    <h1 class="cert-heading-1">CERTIFICATE</h1>
                                    <h2 class="cert-heading-2">OF COMPLETION</h2>

                                    <!-- Recipient Certification Text -->
                                    <div class="cert-body-text">
                                        <p class="cert-preamble">This is to certify that</p>
                                        <div class="cert-recipient-name">
                                            <?php echo htmlspecialchars($empName); ?>
                                        </div>
                                        <p class="cert-middle-text">has successfully completed the</p>
                                        <h3 class="cert-training-title">
                                            LUMUT PORT - HSE INDUCTION TRAINING
                                        </h3>
                                    </div>

                                    <!-- Centered Scannable QR Code -->
                                    <div class="cert-qr-holder">
                                        <div class="cert-qr-inner">
                                            <img src="<?php echo $qrImgSrc; ?>" alt="Verification QR Code">
                                        </div>
                                    </div>

                                    <!-- Dates -->
                                    <div class="cert-dates-row">
                                        <span>Induction Date : <?php echo $inductionDate; ?></span>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span>Due Date : <?php echo $dueDate; ?></span>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- TAB 3: ASSESSMENT AUDIT LOG & ATTEMPTS -->
                        <div class="tab-pane fade" id="tab-audit-log" role="tabpanel">
                            
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom no-print">
                                <div>
                                    <h5 class="font-weight-bold text-dark mb-1">
                                        <i class="fas fa-list-alt text-primary mr-2"></i>Assessment History & Attempt Log
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        All examination submissions and question snapshots are permanently archived and audited.
                                    </p>
                                </div>
                                <div class="d-flex align-items-center mt-2 mt-sm-0" style="gap: 6px;">
                                    <a href="<?php echo BASE_URL; ?>hse_induction/employee/pdf/<?php echo $enc_id; ?>" target="_blank" class="btn btn-sm btn-outline-danger font-weight-bold shadow-sm" title="Download Full Record (PDF)">
                                        <i class="fas fa-download mr-1"></i> Download Full Record (PDF)
                                    </a>
                                    <button type="button" onclick="window.print();" class="btn btn-sm btn-outline-secondary shadow-sm" title="Print Audit Log">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center" style="width: 10%;">Attempt #</th>
                                            <th>Submission Date & Time</th>
                                            <th class="text-center" style="width: 12%;">Total Qs</th>
                                            <th class="text-center" style="width: 12%;">Correct</th>
                                            <th class="text-center" style="width: 12%;">Incorrect</th>
                                            <th class="text-center" style="width: 12%;">Score %</th>
                                            <th class="text-center" style="width: 15%;">Pass/Fail Status</th>
                                            <th class="text-center" style="width: 12%;">Review</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($attempts)) { ?>
                                            <?php foreach ($attempts as $att) { ?>
                                                <tr>
                                                    <td class="text-center font-weight-bold">#<?php echo $att->ATTEMPT_NUMBER; ?></td>
                                                    <td>
                                                        <i class="far fa-clock text-muted mr-1"></i>
                                                        <?php echo date('d-m-Y H:i:s', strtotime($att->ATTEMPT_COMPLETED_AT)); ?>
                                                    </td>
                                                    <td class="text-center"><?php echo $att->TOTAL_QUESTIONS; ?></td>
                                                    <td class="text-center text-success font-weight-bold"><?php echo $att->CORRECT_ANSWERS; ?></td>
                                                    <td class="text-center text-danger font-weight-bold"><?php echo $att->INCORRECT_ANSWERS; ?></td>
                                                    <td class="text-center font-weight-bold"><?php echo $att->PERCENTAGE; ?>%</td>
                                                    <td class="text-center">
                                                        <?php if ($att->PASS_FAIL_STATUS == 'PASSED') { ?>
                                                            <span class="badge badge-success px-2 py-1">PASSED (100%)</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-danger px-2 py-1">FAILED</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php $attId = !empty($att->ATTEMPT_ID) ? $att->ATTEMPT_ID : $att->ID; ?>
                                                        <a href="<?php echo BASE_URL; ?>hse_induction/employee/attempt_pdf/<?php echo $attId; ?>" target="_blank" class="btn btn-xs btn-outline-danger mr-1" title="Download Attempt PDF">
                                                            <i class="fas fa-file-pdf mr-1"></i> PDF
                                                        </a>
                                                        <a href="<?php echo BASE_URL; ?>hse_induction/employee/attempt_details/<?php echo $attId; ?>" class="btn btn-xs btn-outline-info" title="View question snapshot">
                                                            <i class="fas fa-eye mr-1"></i> Answers
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">
                                                    No assessment attempts recorded.
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
</div>
