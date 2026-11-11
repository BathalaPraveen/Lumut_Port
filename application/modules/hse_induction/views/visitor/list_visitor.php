<!-- SweetAlert2 Plugin -->
<link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.css">

<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-users-cog text-primary mr-2"></i>Visitor HSE Induction</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>hse_induction/visitor">HSE Induction</a></li>
                            <li class="breadcrumb-item active">Visitor Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Alert Messages -->
                <?php if ($this->session->flashdata('success_msg')) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-1"></i> <?php echo $this->session->flashdata('success_msg'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('error_msg')) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle mr-1"></i> <?php echo $this->session->flashdata('error_msg'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>

                <!-- Summary Info Boxes -->
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-id-card-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Visitors</span>
                                <span class="info-box-number"><?php echo isset($allCount) ? $allCount : count($visitors); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pending Approval</span>
                                <span class="info-box-number"><?php echo isset($pendingCount) ? $pendingCount : 0; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Approved</span>
                                <span class="info-box-number"><?php echo isset($approvedCount) ? $approvedCount : 0; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-award"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Passed (100% Score)</span>
                                <span class="info-box-number"><?php echo isset($passedCount) ? $passedCount : 0; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visitors Table Card -->
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">
                            <i class="fas fa-list mr-1"></i> Registered Visitor Records
                        </h3>
                        <div class="card-tools">
                            <a href="<?php echo BASE_URL; ?>hse_induction/visitor_registration" target="_blank" class="btn btn-sm btn-outline-primary font-weight-bold">
                                <i class="fas fa-external-link-alt mr-1"></i> Public Registration Form
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Filters -->
                        <form method="get" action="<?php echo BASE_URL; ?>hse_induction/visitor" class="form-inline mb-3">
                            <label class="mr-2 font-weight-bold text-muted small">Approval:</label>
                            <select name="approval_status" class="form-control form-control-sm mr-3" onchange="this.form.submit()">
                                <option value="">All Approval Status</option>
                                <option value="PENDING" <?php echo (isset($filters['approval_status']) && $filters['approval_status'] == 'PENDING') ? 'selected' : ''; ?>>Pending</option>
                                <option value="APPROVED" <?php echo (isset($filters['approval_status']) && $filters['approval_status'] == 'APPROVED') ? 'selected' : ''; ?>>Approved</option>
                                <option value="REJECTED" <?php echo (isset($filters['approval_status']) && $filters['approval_status'] == 'REJECTED') ? 'selected' : ''; ?>>Rejected</option>
                            </select>

                            <label class="mr-2 font-weight-bold text-muted small">Induction:</label>
                            <select name="induction_status" class="form-control form-control-sm mr-3" onchange="this.form.submit()">
                                <option value="">All Induction Status</option>
                                <option value="PASSED" <?php echo (isset($filters['induction_status']) && $filters['induction_status'] == 'PASSED') ? 'selected' : ''; ?>>Passed</option>
                                <option value="FAILED" <?php echo (isset($filters['induction_status']) && $filters['induction_status'] == 'FAILED') ? 'selected' : ''; ?>>Failed</option>
                                <option value="IN_PROGRESS" <?php echo (isset($filters['induction_status']) && $filters['induction_status'] == 'IN_PROGRESS') ? 'selected' : ''; ?>>In Progress</option>
                                <option value="NOT_STARTED" <?php echo (isset($filters['induction_status']) && $filters['induction_status'] == 'NOT_STARTED') ? 'selected' : ''; ?>>Not Started</option>
                            </select>

                            <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="Search Visitor / Company / IC" value="<?php echo isset($filters['search']) ? htmlspecialchars($filters['search']) : ''; ?>">
                            <button type="submit" class="btn btn-sm btn-primary mr-1"><i class="fas fa-search mr-1"></i> Filter</button>
                            <a href="<?php echo BASE_URL; ?>hse_induction/visitor" class="btn btn-sm btn-secondary"><i class="fas fa-sync-alt mr-1"></i> Reset</a>
                        </form>

                        <div class="table-responsive">
                            <table id="visitorTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Reg No</th>
                                        <th>Visitor Details</th>
                                        <th>Company</th>
                                        <th>Scheduled Visit</th>
                                        <th>Terminal & Contact Person</th>
                                        <th>Approval Status</th>
                                        <th>Induction</th>
                                        <th>Score</th>
                                        <th>Validity</th>
                                        <th style="min-width: 140px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($visitors)) { ?>
                                        <?php foreach ($visitors as $v) { 
                                            $hasStart = (!empty($v->VISIT_DATETIME) && $v->VISIT_DATETIME != '0000-00-00 00:00:00');
                                            $hasEnd = (!empty($v->VISIT_DATETIME_END) && $v->VISIT_DATETIME_END != '0000-00-00 00:00:00');
                                            $isExpired = false;
                                            if (!empty($v->VALIDITY_DATE) && $v->VALIDITY_DATE != '0000-00-00') {
                                                if (strtotime($v->VALIDITY_DATE . ' 23:59:59') < time()) {
                                                    $isExpired = true;
                                                }
                                            } elseif ($hasEnd && strtotime($v->VISIT_DATETIME_END) < time()) {
                                                $isExpired = true;
                                            }
                                            if ($v->INDUCTION_STATUS === 'EXPIRED') {
                                                $isExpired = true;
                                            }
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="badge badge-light border font-monospace"><?php echo htmlspecialchars($v->VISITOR_REG_NO); ?></span>
                                                </td>
                                                <td>
                                                    <strong class="text-dark"><?php echo htmlspecialchars($v->VISITOR_NAME); ?></strong><br>
                                                    <small class="text-muted"><i class="fas fa-id-card mr-1"></i><?php echo htmlspecialchars($v->IC_PASSPORT_NO); ?></small><br>
                                                    <small class="text-muted"><i class="fas fa-envelope mr-1"></i><?php echo htmlspecialchars($v->EMAIL_ID); ?></small>
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold"><?php echo htmlspecialchars($v->COMPANY_NAME); ?></span>
                                                    <?php if (!empty($v->VEHICLE_DETAIL)) { ?>
                                                        <br><small class="text-muted"><i class="fas fa-truck mr-1"></i><?php echo htmlspecialchars($v->VEHICLE_DETAIL); ?></small>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($hasStart) { ?>
                                                        <div class="small font-weight-bold text-dark text-nowrap">
                                                            <span class="badge badge-light border text-primary mr-1"><i class="fas fa-play mr-1"></i>From:</span>
                                                            <?php echo date('d-m-Y H:i', strtotime($v->VISIT_DATETIME)); ?>
                                                        </div>
                                                        <div class="small font-weight-bold text-dark text-nowrap mt-1">
                                                            <span class="badge badge-light border text-info mr-1"><i class="fas fa-flag-checkered mr-1"></i>To:</span>
                                                            <?php echo $hasEnd ? date('d-m-Y H:i', strtotime($v->VISIT_DATETIME_END)) : date('d-m-Y 18:00', strtotime($v->VISIT_DATETIME)); ?>
                                                        </div>
                                                        <?php if ($isExpired) { ?>
                                                            <span class="badge badge-danger mt-1"><i class="fas fa-calendar-times mr-1"></i> Expired</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-success mt-1"><i class="fas fa-clock mr-1"></i> Active</span>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <span class="text-muted small">-</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info mb-1"><?php echo !empty($v->TERMINAL_NAME) ? htmlspecialchars($v->TERMINAL_NAME) : 'Lumut Port'; ?></span><br>
                                                    <small class="text-muted"><i class="fas fa-user-tie mr-1"></i>PIC: <strong><?php echo !empty($v->PIC_EMP_NAME) ? htmlspecialchars($v->PIC_EMP_NAME) : (!empty($v->CONTACT_PERSON_NAME) ? htmlspecialchars($v->CONTACT_PERSON_NAME) : '-'); ?></strong></small>
                                                </td>
                                                <td>
                                                    <?php if ($v->APPROVAL_STATUS == 'APPROVED') { ?>
                                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Approved</span>
                                                    <?php } elseif ($v->APPROVAL_STATUS == 'REJECTED') { ?>
                                                        <span class="badge badge-danger px-2 py-1" title="<?php echo htmlspecialchars($v->REJECTION_REASON); ?>"><i class="fas fa-times mr-1"></i> Rejected</span>
                                                    <?php } else { ?>
                                                        <span class="badge badge-warning px-2 py-1"><i class="fas fa-hourglass-half mr-1"></i> Pending</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($isExpired) { ?>
                                                        <span class="badge badge-danger px-2 py-1"><i class="fas fa-calendar-times mr-1"></i> Expired</span>
                                                    <?php } elseif ($v->INDUCTION_STATUS == 'PASSED') { ?>
                                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Passed</span>
                                                    <?php } elseif ($v->INDUCTION_STATUS == 'FAILED') { ?>
                                                        <span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i> Failed</span>
                                                    <?php } elseif ($v->INDUCTION_STATUS == 'IN_PROGRESS') { ?>
                                                        <span class="badge badge-warning px-2 py-1"><i class="fas fa-spinner fa-spin mr-1"></i> In Progress</span>
                                                    <?php } else { ?>
                                                        <span class="badge badge-secondary px-2 py-1">Not Started</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($v->INDUCTION_STATUS == 'PASSED') { ?>
                                                        <span class="badge badge-success">100%</span>
                                                    <?php } elseif ($v->INDUCTION_STATUS == 'FAILED') { ?>
                                                        <span class="badge badge-danger"><?php echo round($v->SCORE_PERCENTAGE); ?>%</span>
                                                    <?php } else { ?>
                                                        <span class="text-muted">-</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($v->VALIDITY_DATE) && $v->VALIDITY_DATE != '0000-00-00') { ?>
                                                        <div class="font-weight-bold <?php echo $isExpired ? 'text-danger' : 'text-success'; ?>">
                                                            <?php echo date('d-m-Y', strtotime($v->VALIDITY_DATE)); ?>
                                                        </div>
                                                        <?php if ($isExpired) { ?>
                                                            <span class="badge badge-danger">Expired</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-success">Valid</span>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <span class="text-muted">-</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="gap: 6px;">
                                                        <?php if ($v->APPROVAL_STATUS == 'PENDING') { ?>
                                                            <!-- Approve Button (SweetAlert confirmation) -->
                                                            <button type="button" class="btn btn-sm btn-success btn-approve-swal" data-url="<?php echo BASE_URL; ?>hse_induction/visitor/approve/<?php echo $v->VISITOR_ID; ?>" data-name="<?php echo htmlspecialchars($v->VISITOR_NAME); ?>" title="Approve Visitor (Send OTP & Link)">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <!-- Reject Button (SweetAlert prompt) -->
                                                            <button type="button" class="btn btn-sm btn-danger btn-reject-swal" data-id="<?php echo $v->VISITOR_ID; ?>" data-name="<?php echo htmlspecialchars($v->VISITOR_NAME); ?>" title="Reject Visitor">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        <?php } elseif ($v->APPROVAL_STATUS == 'APPROVED' && !$isExpired) { ?>
                                                            <!-- Resend OTP Button (ONLY FOR APPROVED & NON-EXPIRED VISITORS - SweetAlert confirmation) -->
                                                            <button type="button" class="btn btn-sm btn-outline-warning btn-resend-otp-swal" data-url="<?php echo BASE_URL; ?>hse_induction/visitor/resend_otp/<?php echo $v->VISITOR_ID; ?>" data-email="<?php echo htmlspecialchars($v->EMAIL_ID); ?>" data-name="<?php echo htmlspecialchars($v->VISITOR_NAME); ?>" title="Resend OTP Email">
                                                                <i class="fas fa-envelope"></i>
                                                            </button>
                                                        <?php } ?>
                                                        <!-- When REJECTED: No email or resend buttons. Only the Dossier PDF button below is shown -->

                                                        <?php if ($v->APPROVAL_STATUS == 'APPROVED' && $v->INDUCTION_STATUS == 'PASSED' && !$isExpired) { ?>
                                                            <!-- View Pass & QR Code -->
                                                            <a href="<?php echo BASE_URL; ?>hse_induction/visitor/view_pass/<?php echo $v->VISITOR_ID; ?>" class="btn btn-sm btn-outline-success" title="View Port Pass & Certificate">
                                                                <i class="fas fa-qrcode"></i>
                                                            </a>
                                                            <!-- Download Pass PDF -->
                                                            <a href="<?php echo BASE_URL; ?>hse_induction/visitor/pass_pdf/<?php echo $v->VISITOR_ID; ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Download Port Pass (PDF)">
                                                                <i class="fas fa-id-badge"></i>
                                                            </a>
                                                            <!-- Download Certificate PDF -->
                                                            <a href="<?php echo BASE_URL; ?>hse_induction/visitor/certificate_pdf/<?php echo $v->VISITOR_ID; ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Download Certificate (PDF)">
                                                                <i class="fas fa-award"></i>
                                                            </a>
                                                        <?php } elseif ($v->APPROVAL_STATUS == 'APPROVED' && $v->INDUCTION_STATUS == 'PASSED' && $isExpired) { ?>
                                                            <span class="badge badge-secondary py-1 px-2" title="Port Pass Expired"><i class="fas fa-calendar-times mr-1"></i> Pass Expired</span>
                                                        <?php } ?>

                                                        <!-- Full Record Dossier PDF -->
                                                        <a href="<?php echo BASE_URL; ?>hse_induction/visitor/pdf/<?php echo $v->VISITOR_ID; ?>" target="_blank" class="btn btn-sm btn-outline-danger" title="Download Full Record Dossier (PDF)">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="10" class="text-center py-4 text-muted">
                                                <i class="fas fa-info-circle mr-1"></i> No data available in table
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

<!-- SweetAlert2 Library Script -->
<script src="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.js"></script>

<script>
$(document).ready(function() {
    // Show SweetAlert for Flash Messages if available
    <?php if ($this->session->flashdata('success_msg')) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            html: <?php echo json_encode($this->session->flashdata('success_msg')); ?>,
            confirmButtonColor: '#28a745'
        });
    <?php } ?>
    <?php if ($this->session->flashdata('error_msg')) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Notice',
            html: <?php echo json_encode($this->session->flashdata('error_msg')); ?>,
            confirmButtonColor: '#dc3545'
        });
    <?php } ?>

    // SweetAlert for Approve Visitor (Send OTP & Assessment Invitation)
    $('.btn-approve-swal').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        var name = $(this).data('name');

        Swal.fire({
            title: 'Approve Visitor?',
            html: 'Approve visitor clearance for <strong>' + name + '</strong>?<br><small class="text-muted">This will generate a 6-digit OTP and send an assessment invitation email.</small>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-check-circle mr-1"></i> Yes, Approve & Send OTP',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Approving Visitor...',
                    text: 'Please wait while the approval and OTP email are being processed.',
                    allowOutsideClick: false,
                    didOpen: function() {
                        Swal.showLoading();
                    }
                });
                window.location.href = url;
            }
        });
    });

    // SweetAlert for Reject Visitor (Prompts for rejection reason, NO email sent, only status updated)
    $('.btn-reject-swal').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        var actionUrl = '<?php echo BASE_URL; ?>hse_induction/visitor/reject/' + id;

        Swal.fire({
            title: 'Reject Visitor Application?',
            html: 'Are you sure you want to reject visitor clearance for <strong>' + name + '</strong>?<br><span class="text-danger small font-weight-bold">Please specify the safety/clearance reason below:</span>',
            input: 'textarea',
            inputPlaceholder: 'Please enter reason for HSSE safety rejection...',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-times-circle mr-1"></i> Confirm Rejection',
            cancelButtonText: 'Cancel',
            inputValidator: function(value) {
                if (!value || !value.trim()) {
                    return 'A rejection reason is required!';
                }
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Rejecting Visitor...',
                    text: 'Please wait while updating visitor record.',
                    allowOutsideClick: false,
                    didOpen: function() {
                        Swal.showLoading();
                    }
                });

                var form = $('<form>', {
                    'method': 'POST',
                    'action': actionUrl
                });
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '<?php echo $this->security->get_csrf_token_name(); ?>',
                    'value': '<?php echo $this->security->get_csrf_hash(); ?>'
                }));
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'rejection_reason',
                    'value': result.value
                }));
                $('body').append(form);
                form.submit();
            }
        });
    });

    // SweetAlert for Resend OTP (ONLY for Approved visitors)
    $('.btn-resend-otp-swal').on('click', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        var email = $(this).data('email');
        var name = $(this).data('name');

        Swal.fire({
            title: 'Resend Assessment OTP?',
            html: 'Regenerate and send a new 6-digit OTP code to:<br><div class="p-2 mt-2 font-weight-bold text-primary bg-light border rounded" style="font-size: 1.05rem;">' + email + '</div><small class="text-muted mt-1 d-block">Visitor: ' + name + '</small>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0284c7',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-paper-plane mr-1"></i> Send OTP Email',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Sending OTP Email...',
                    text: 'Please wait while the invitation email is being dispatched.',
                    allowOutsideClick: false,
                    didOpen: function() {
                        Swal.showLoading();
                    }
                });
                window.location.href = url;
            }
        });
    });
});
</script>

