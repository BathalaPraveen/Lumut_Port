<?php
$visitorName = isset($visitor->VISITOR_NAME) ? $visitor->VISITOR_NAME : 'Visitor';
$visitorComp = isset($visitor->COMPANY_NAME) ? $visitor->COMPANY_NAME : 'Visitor Company';
$visitorIc = isset($visitor->IC_PASSPORT_NO) ? $visitor->IC_PASSPORT_NO : '-';
$terminalName = !empty($visitor->TERMINAL_NAME) ? $visitor->TERMINAL_NAME : 'Lumut Port';
$certNo = !empty($visitor->CERTIFICATE_NO) ? $visitor->CERTIFICATE_NO : ('PORT-VIS-' . str_pad($visitor->VISITOR_ID, 4, '0', STR_PAD_LEFT));
$inductionDate = (!empty($visitor->PASSED_DATE)) ? date('d/m/Y', strtotime($visitor->PASSED_DATE)) : date('d/m/Y');
$dueDate = (!empty($visitor->VALIDITY_DATE) && $visitor->VALIDITY_DATE != '0000-00-00') ? date('d/m/Y', strtotime($visitor->VALIDITY_DATE)) : ((!empty($visitor->VISIT_DATETIME_END)) ? date('d/m/Y', strtotime($visitor->VISIT_DATETIME_END)) : date('d/m/Y'));

$photoPath = BASE_URL . 'assets/images/hse_induction/default_avatar.png';
$qrImgSrc = (!empty($visitor->QR_CODE_PATH) && file_exists(FCPATH . $visitor->QR_CODE_PATH))
    ? BASE_URL . $visitor->QR_CODE_PATH
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

/* Front Badge Info */
.front-emp-info {
    text-align: center;
    margin-top: 10px;
}
.front-emp-name {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0b1118;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.front-emp-comp {
    font-size: 0.95rem;
    font-weight: 700;
    color: #374151;
    margin-top: 2px;
}
.front-emp-valid {
    font-size: 0.95rem;
    font-weight: 800;
    color: #b91c1c;
    margin-top: 6px;
}

/* Dark Metadata Box on Back of Pass */
.dark-meta-card {
    background-color: #161D26;
    border-radius: 12px;
    padding: 12px 16px;
    margin: 4px 0 10px 0;
    color: #ffffff;
}
.meta-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    font-size: 0.82rem;
    line-height: 1.5;
    margin-bottom: 5px;
    border-bottom: 1px dotted rgba(255,255,255,0.15);
    padding-bottom: 3px;
}
.meta-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
}
.meta-lbl {
    color: #94a3b8;
    font-weight: 700;
    font-size: 0.78rem;
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
}
.meta-val.green {
    color: #4ade80;
}

/* Back QR Frame */
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
    font-size: 0.76rem;
    font-weight: 800;
    color: #1e293b;
    text-align: center;
    margin-top: 4px;
}

/* -------------------------------------------------------------
   CERTIFICATE OF COMPLETION STYLES
   ------------------------------------------------------------- */
.cert-display-card {
    position: relative;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    margin: 0 auto;
    max-width: 950px;
}
.cert-aspect-box {
    position: relative;
    width: 100%;
    padding-bottom: 70.7%; /* A4 Landscape aspect ratio */
    overflow: hidden;
    background-color: #ffffff;
}
.cert-bg-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: fill;
    z-index: 1;
}
.cert-inner-content {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 2;
    padding: 40px 60px;
    text-align: center;
    font-family: "Bell MT", Georgia, "Times New Roman", serif;
}
.cert-top-logo {
    text-align: center;
    margin-bottom: 25px;
}
.cert-top-logo img {
    width: 180px;
    max-width: 80%;
    object-fit: contain;
}
.cert-heading-1 {
    font-size: 3.2rem;
    font-weight: 800;
    letter-spacing: 3px;
    color: #161D26;
    margin: 0;
    line-height: 1.1;
    text-transform: uppercase;
}
.cert-heading-2 {
    font-size: 1.8rem;
    font-weight: 800;
    letter-spacing: 4px;
    color: #161D26;
    margin: 6px 0 0 0;
    text-transform: uppercase;
}
.cert-body-text {
    margin-top: 35px;
    color: #161D26;
}
.cert-preamble {
    font-size: 1.35rem;
    font-style: italic;
    color: #4b5563;
    margin-bottom: 15px;
}
.cert-recipient-name {
    font-size: 2.2rem;
    font-weight: 800;
    color: #0b1118;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid #cbd5e1;
    display: inline-block;
    padding: 0 40px 8px 40px;
    margin: 10px 0 15px 0;
}
.cert-middle-text {
    font-size: 1.25rem;
    color: #4b5563;
    margin-bottom: 10px;
}
.cert-training-title {
    font-size: 1.65rem;
    font-weight: 800;
    color: #161D26;
    letter-spacing: 1px;
    margin-top: 8px;
}
.cert-qr-holder {
    margin-top: 35px;
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
    width: 120px;
    height: 120px;
    display: block;
}
.cert-dates-row {
    margin-top: 25px;
    font-size: 1.1rem;
    font-weight: 800;
    color: #1e293b;
    letter-spacing: 0.5px;
}
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header no-print">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-id-card text-success mr-2"></i>Visitor HSE Induction Pass & Certificate</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>hse_induction/visitor">HSE Induction</a></li>
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
                                        <i class="fas fa-id-card text-primary mr-2"></i> Visitor HSE Induction Pass & Certificate
                                    </h4>
                                    <div class="d-flex align-items-center" style="gap: 15px;">
                                        <div class="text-muted small d-none d-sm-block">
                                            Candidate: <strong class="text-dark"><?php echo htmlspecialchars($visitorName); ?></strong>
                                        </div>
                                        <a href="<?php echo BASE_URL; ?>hse_induction/visitor" class="btn btn-sm btn-primary">
                                            <i class="fa fa-arrow-left mr-1"></i> Back to Visitor List
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
                                <div class="tab-content" id="passCertTabsContent">

                                    <!-- TAB 1: PORT PASS BADGE (FRONT & BACK CARDS) -->
                                    <div class="tab-pane fade show active" id="tab-port-pass" role="tabpanel">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom no-print">
                                            <div>
                                                <span class="badge badge-success px-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
                                                    <i class="fas fa-check-circle mr-1"></i> HSE INDUCTION VERIFIED &bull; 100% PASSED
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center mt-2 mt-sm-0" style="gap: 6px;">
                                                <a href="<?php echo BASE_URL; ?>hse_induction/visitor/pass_pdf/<?php echo $visitor->VISITOR_ID; ?>" target="_blank" class="btn btn-sm btn-outline-success font-weight-bold shadow-sm" title="Download Port Pass (PDF)">
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
                                                    <div class="badge-header-pill">
                                                        <div class="helmet-circle">
                                                            <img src="<?php echo BASE_URL; ?>assets/images/hse_induction/safety_helmet_icon.png" alt="Safety Helmet">
                                                        </div>
                                                        <div class="badge-header-title">PORT PASS</div>
                                                    </div>
                                                    <div class="lumut-badge-logo">
                                                        <img src="<?php echo BASE_URL; ?>assets/images/hse_induction/lumut_port_logo.png" alt="Lumut Port">
                                                    </div>
                                                    <div class="tech-photo-frame">
                                                        <div class="corner-mk top-left"></div>
                                                        <div class="corner-mk top-right"></div>
                                                        <div class="corner-mk bottom-left"></div>
                                                        <div class="corner-mk bottom-right"></div>
                                                        <img src="<?php echo $photoPath; ?>" class="emp-photo-img" alt="Visitor Photo">
                                                    </div>
                                                    <div class="front-emp-info">
                                                        <div class="front-emp-name"><?php echo htmlspecialchars($visitorName); ?></div>
                                                        <div class="front-emp-comp"><?php echo htmlspecialchars($visitorComp); ?></div>
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
                                                    <div class="dark-meta-card">
                                                        <div class="meta-row">
                                                            <span class="meta-lbl">NAME :</span>
                                                            <span class="meta-val"><?php echo htmlspecialchars($visitorName); ?></span>
                                                        </div>
                                                        <div class="meta-row">
                                                            <span class="meta-lbl">COMPANY :</span>
                                                            <span class="meta-val"><?php echo htmlspecialchars($visitorComp); ?></span>
                                                        </div>
                                                        <div class="meta-row">
                                                            <span class="meta-lbl">I.C./PASSPORT :</span>
                                                            <span class="meta-val"><?php echo htmlspecialchars($visitorIc); ?></span>
                                                        </div>
                                                        <div class="meta-row">
                                                            <span class="meta-lbl">TERMINAL :</span>
                                                            <span class="meta-val"><?php echo htmlspecialchars($terminalName); ?></span>
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
                                                    <div class="tech-qr-frame">
                                                        <div class="corner-mk top-left"></div>
                                                        <div class="corner-mk top-right"></div>
                                                        <div class="corner-mk bottom-left"></div>
                                                        <div class="corner-mk bottom-right"></div>
                                                        <img src="<?php echo $qrImgSrc; ?>" class="qr-code-img" alt="Scannable QR Code">
                                                    </div>
                                                    <div class="qr-scan-text">Scan QR Code for Pass Verification</div>
                                                </div>
                                                <div class="badge-strip-bottom"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TAB 2: CERTIFICATE OF COMPLETION -->
                                    <div class="tab-pane fade" id="tab-certificate" role="tabpanel">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom no-print">
                                            <div>
                                                <span class="badge badge-primary px-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
                                                    <i class="fas fa-award mr-1"></i> Official HSE Induction Certificate &bull; Ref: <?php echo htmlspecialchars($certNo); ?>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center mt-2 mt-sm-0" style="gap: 6px;">
                                                <a href="<?php echo BASE_URL; ?>hse_induction/visitor/certificate_pdf/<?php echo $visitor->VISITOR_ID; ?>" target="_blank" class="btn btn-sm btn-outline-primary font-weight-bold shadow-sm" title="Download Certificate (PDF)">
                                                    <i class="fas fa-download mr-1"></i> Download Certificate (PDF)
                                                </a>
                                                <button type="button" onclick="window.print();" class="btn btn-sm btn-outline-secondary shadow-sm" title="Print Certificate">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="cert-display-card">
                                            <div class="cert-aspect-box">
                                                <img src="<?php echo BASE_URL; ?>assets/images/hse_induction/certificate_bg.png" class="cert-bg-img" alt="Certificate Background">
                                                <div class="cert-inner-content">
                                                    <div class="cert-top-logo">
                                                        <img src="<?php echo BASE_URL; ?>assets/images/hse_induction/lumut_port_logo.png" alt="Lumut Port Logo">
                                                    </div>
                                                    <div class="cert-heading-1">CERTIFICATE</div>
                                                    <div class="cert-heading-2">OF COMPLETION</div>
                                                    <div class="cert-body-text">
                                                        <div class="cert-preamble">This is to certify that</div>
                                                        <div class="cert-recipient-name"><?php echo htmlspecialchars($visitorName); ?></div>
                                                        <div class="cert-middle-text">has successfully completed the</div>
                                                        <div class="cert-training-title">LUMUT PORT - HSE INDUCTION TRAINING</div>
                                                    </div>
                                                    <div class="cert-qr-holder">
                                                        <div class="cert-qr-inner">
                                                            <img src="<?php echo $qrImgSrc; ?>" alt="QR Code">
                                                        </div>
                                                    </div>
                                                    <div class="cert-dates-row">
                                                        Induction Date : <?php echo $inductionDate; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Due Date : <?php echo $dueDate; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TAB 3: ASSESSMENT AUDIT LOG -->
                                    <div class="tab-pane fade" id="tab-audit-log" role="tabpanel">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom no-print">
                                            <div>
                                                <h5 class="font-weight-bold text-dark mb-0">
                                                    <i class="fas fa-history text-secondary mr-2"></i>Assessment History & Attempt Log
                                                </h5>
                                                <small class="text-muted">Detailed examination records and audit trace for this visitor.</small>
                                            </div>
                                            <div class="d-flex align-items-center mt-2 mt-sm-0" style="gap: 6px;">
                                                <a href="<?php echo BASE_URL; ?>hse_induction/visitor/pdf/<?php echo $visitor->VISITOR_ID; ?>" target="_blank" class="btn btn-sm btn-outline-danger font-weight-bold shadow-sm" title="Download Full Record Dossier (PDF)">
                                                    <i class="fas fa-download mr-1"></i> Download Record (PDF)
                                                </a>
                                                <button type="button" onclick="window.print();" class="btn btn-sm btn-outline-secondary shadow-sm" title="Print Log">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Attempt #</th>
                                                        <th>Completion Date</th>
                                                        <th>Score %</th>
                                                        <th>Marks</th>
                                                        <th>Correct / Wrong</th>
                                                        <th>Status</th>
                                                        <th>Certificate No</th>
                                                        <th>Audit IP</th>
                                                        <th style="min-width: 140px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($attempts)) { ?>
                                                        <?php foreach ($attempts as $att) { ?>
                                                            <tr>
                                                                <td class="font-weight-bold text-center">#<?php echo $att->ATTEMPT_NUMBER; ?></td>
                                                                <td><?php echo date('d-m-Y H:i:s', strtotime($att->ATTEMPT_COMPLETED_AT)); ?></td>
                                                                <td class="font-weight-bold">
                                                                    <?php if ($att->PASS_FAIL_STATUS == 'PASSED') { ?>
                                                                        <span class="text-success"><?php echo $att->PERCENTAGE; ?>%</span>
                                                                    <?php } else { ?>
                                                                        <span class="text-danger"><?php echo $att->PERCENTAGE; ?>%</span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td><?php echo round($att->MARKS_OBTAINED, 1); ?> / <?php echo round($att->TOTAL_AVAILABLE_MARKS, 0); ?></td>
                                                                <td>
                                                                    <span class="text-success"><i class="fas fa-check mr-1"></i><?php echo $att->CORRECT_ANSWERS; ?></span>
                                                                    &nbsp;|&nbsp;
                                                                    <span class="text-danger"><i class="fas fa-times mr-1"></i><?php echo $att->INCORRECT_ANSWERS; ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php if ($att->PASS_FAIL_STATUS == 'PASSED') { ?>
                                                                        <span class="badge badge-success">PASSED</span>
                                                                    <?php } else { ?>
                                                                        <span class="badge badge-danger">FAILED</span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo !empty($att->CERTIFICATE_NO) ? '<span class="font-monospace text-primary">' . htmlspecialchars($att->CERTIFICATE_NO) . '</span>' : '-'; ?>
                                                                </td>
                                                                <td class="small text-muted"><?php echo !empty($att->IP_ADDRESS) ? htmlspecialchars($att->IP_ADDRESS) : '-'; ?></td>
                                                                <td>
                                                                    <div class="d-flex align-items-center" style="gap: 6px;">
                                                                        <a href="<?php echo BASE_URL; ?>hse_induction/visitor/attempt_details/<?php echo $att->ATTEMPT_ID; ?>" class="btn btn-xs btn-info font-weight-bold" title="View Question Answers Preview">
                                                                            <i class="fas fa-eye mr-1"></i> Preview
                                                                        </a>
                                                                        <a href="<?php echo BASE_URL; ?>hse_induction/visitor/attempt_pdf/<?php echo $att->ATTEMPT_ID; ?>" target="_blank" class="btn btn-xs btn-outline-danger" title="Download Attempt PDF">
                                                                            <i class="fas fa-file-pdf"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <tr>
                                                            <td colspan="9" class="text-center py-4 text-muted">
                                                                <i class="fas fa-info-circle mr-1"></i> No assessment attempts recorded yet for this visitor.
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

