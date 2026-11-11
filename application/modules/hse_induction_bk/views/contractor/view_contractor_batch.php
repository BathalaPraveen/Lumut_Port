<style>
    .emplBorder {
        background-color: #007bff;
    }
    .file-badge {
        display: inline-block;
        padding: 4px 9px;
        font-size: 13px;
        background: #f1f7ff;
        border: 1px solid #cce5ff;
        border-radius: 4px;
        margin: 2px 4px 2px 0;
        color: #0056b3;
        white-space: nowrap;
    }
    .table-details td {
        padding: 10px 14px;
        /* font-size: 14px; */
        vertical-align: middle;
    }
    .table-details tr:nth-child(odd) {
        background-color: #fcfcfc;
    }
    /* Employees table font size & spacing */
    .employees-table th {
        /* font-size: 14px; */
        padding: 10px 12px;
        vertical-align: middle;
        white-space: nowrap;
    }
    .employees-table td {
        /* font-size: 14px; */
        padding: 10px 12px;
        vertical-align: middle;
    }
    .employees-table small {
        /* font-size: 13px; */
    }
    .employees-table .badge {
        /* font-size: 13px; */
        padding: 5px 8px;
    }
</style>

<div class="content-wrapper" style="padding-top: 15px;">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-headprimary">
                        <div class="row headingStyl">
                            <div class="col-md-12">
                                <h4>View Batch Details - <?php echo htmlspecialchars($batch->BATCH_NO); ?></h4>
                                <a href="<?php echo BASE_URL('hse_induction/contractor_employees/' . encryptval($contractor_id)); ?>">
                                    <button type="button" class="btn btn-primary backBtns">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </button>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Section 1: Batch & Company Details -->
                            <div class="invoice p-3 mb-3">
                                <div class="card-header emplBorder">
                                    <h3 class="card-title" style="color: #ffff;">Batch & Company Details</h3>
                                </div>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped table-details">
                                            <tbody>
                                                <tr>
                                                    <td width="20%"><b>Company Name</b></td>
                                                    <td width="2%">:</td>
                                                    <td width="28%"><strong><?php echo htmlspecialchars($contractor->CONT_COMPANY); ?></strong></td>
                                                    <td width="20%"><b>Contractor ID</b></td>
                                                    <td width="2%">:</td>
                                                    <td width="28%"><strong><?php echo htmlspecialchars($contractor->CONT_ID); ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Person In-Charge (PIC)</b></td>
                                                    <td>:</td>
                                                    <td><?php echo htmlspecialchars($contractor->CONT_NAME); ?></td>
                                                    <td><b>PIC Contact / Email</b></td>
                                                    <td>:</td>
                                                    <td><?php echo htmlspecialchars($contractor->CONT_PHONE_NO . ' / ' . $contractor->CONT_EMAIL_ID); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Batch Number</b></td>
                                                    <td>:</td>
                                                    <td><span class="badge badge-primary font-weight-bold" style="font-size: 14px; padding: 5px 12px;"><?php echo htmlspecialchars($batch->BATCH_NO); ?></span></td>
                                                    <td><b>Created On</b></td>
                                                    <td>:</td>
                                                    <td><?php echo date('d-m-Y H:i', strtotime($batch->CREATED_ON)); ?></td>
                                                </tr>
                                                <!--
                                                <tr>
                                                    <td><b>Payment</b></td>
                                                    <td>:</td>
                                                    <td><?php echo htmlspecialchars($batch->PAYMENT); ?></td>
                                                    <td><b>Validity Date</b></td>
                                                    <td>:</td>
                                                    <td><strong><?php echo ($batch->VALIDITY_DATE && $batch->VALIDITY_DATE != '0000-00-00') ? date('d-m-Y', strtotime($batch->VALIDITY_DATE)) : '-'; ?></strong></td>
                                                </tr>
                                                -->
                                                <tr>
                                                    <td><b>Approval Status</b></td>
                                                    <td>:</td>
                                                    <td>
                                                        <?php
                                                        $appStat = isset($batch->APPROVAL_STATUS) ? (int)$batch->APPROVAL_STATUS : 1;
                                                        if ($appStat == 2) {
                                                            echo '<span class="badge badge-success px-3 py-1 font-weight-bold" style="font-size:14px;"><i class="fa fa-check-circle mr-1"></i> Approved</span>';
                                                        } elseif ($appStat == 3) {
                                                            echo '<span class="badge badge-danger px-3 py-1 font-weight-bold" style="font-size:14px;"><i class="fa fa-times-circle mr-1"></i> Rejected</span>';
                                                        } else {
                                                            echo '<span class="badge badge-warning px-3 py-1 font-weight-bold" style="font-size:14px;"><i class="fa fa-clock mr-1"></i> Pending Approval</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><b>Total Employees</b></td>
                                                    <td>:</td>
                                                    <td><strong><?php echo count($employees); ?> Person(s)</strong></td>
                                                </tr>
                                                <?php if (!empty($batch->REJECT_REASON)): ?>
                                                <tr>
                                                    <td class="text-danger"><b>Rejection Reason</b></td>
                                                    <td class="text-danger">:</td>
                                                    <td colspan="4" class="text-danger font-weight-bold"><?php echo nl2br(htmlspecialchars($batch->REJECT_REASON)); ?></td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: Batch Employees -->
                            <div class="invoice p-3 mb-3">
                                <div class="card-header emplBorder">
                                    <h3 class="card-title" style="color: #ffff;">Batch Employees (<?php echo count($employees); ?>)</h3>
                                </div>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-bordered table-striped employees-table" style="margin-top:10px;">
                                            <thead style="background: #007bff; color: #fff;">
                                                <tr>
                                                    <th style="width: 40px; text-align: center;">#</th>
                                                    <th>Employee Name</th>
                                                    <th>Email ID</th>
                                                    <th>Phone No</th>
                                                    <th>ID Type & No</th>
                                                    <th>Gender & DOB</th>
                                                    <th>Designation</th>
                                                    <th>Nationality, Religion & Race</th>
                                                    <th>Marital Status & Exp</th>
                                                    <th>Emergency Contact</th>
                                                    <th>Terminal</th>
                                                    <th>Uploaded Documents & Certificates</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($employees)): ?>
                                                    <?php foreach ($employees as $i => $emp): 
                                                        $natName = isset($nat_map[$emp->NATIONALITY_ID]) ? $nat_map[$emp->NATIONALITY_ID] : $emp->NATIONALITY_OTHER;
                                                        $dobStr = ($emp->DOB && $emp->DOB != '0000-00-00') ? date('d-m-Y', strtotime($emp->DOB)) : '-';
                                                    ?>
                                                    <tr>
                                                        <td class="text-center font-weight-bold"><?php echo $i + 1; ?></td>
                                                        <td><strong><?php echo htmlspecialchars($emp->EMP_NAME); ?></strong></td>
                                                        <td><?php echo htmlspecialchars($emp->EMP_EMAIL); ?></td>
                                                        <td><?php echo htmlspecialchars($emp->EMP_PHONE); ?></td>
                                                        <td>
                                                            <span class="badge badge-info"><?php echo htmlspecialchars($emp->ID_TYPE); ?></span><br>
                                                            <small class="font-weight-bold"><?php echo htmlspecialchars($emp->ID_NUMBER); ?></small>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlspecialchars($emp->GENDER); ?><br>
                                                            <small class="text-muted"><i class="fa fa-birthday-cake mr-1"></i><?php echo $dobStr; ?></small>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($emp->DESIGNATION); ?></td>
                                                        <td>
                                                            <b>Nat:</b> <?php echo htmlspecialchars($natName); ?><br>
                                                            <small><b>Rel:</b> <?php echo htmlspecialchars($emp->RELIGION); ?> | <b>Race:</b> <?php echo htmlspecialchars($emp->RACE); ?></small>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $maritalMap = ['1' => 'Single', '2' => 'Married', '3' => 'Divorced'];
                                                            $mStatusText = isset($maritalMap[$emp->MARITAL_STATUS]) ? $maritalMap[$emp->MARITAL_STATUS] : $emp->MARITAL_STATUS;
                                                            echo htmlspecialchars($mStatusText);
                                                            ?><br>
                                                            <small class="text-muted"><?php echo htmlspecialchars($emp->WORK_EXPERIENCE); ?> yr(s) exp</small>
                                                        </td>
                                                        <td>
                                                            <b><?php echo htmlspecialchars($emp->EMERGENCY_NAME); ?></b> (<?php echo htmlspecialchars($emp->EMERGENCY_RELATIONSHIP); ?>)<br>
                                                            <small><i class="fa fa-phone mr-1"></i><?php echo htmlspecialchars($emp->EMERGENCY_PHONE); ?></small><br>
                                                            <small class="text-muted"><?php echo htmlspecialchars($emp->EMERGENCY_ADDRESS); ?></small>
                                                        </td>
                                                        <td><span class="badge badge-secondary"><?php echo htmlspecialchars($emp->TERMINALS); ?></span></td>
                                                        <td>
                                                            <div style="line-height: 22px;">
                                                                <?php if (!empty($emp->PASSPORT_IC_FILE)): ?>
                                                                    <a href="<?php echo BASE_URL . $emp->PASSPORT_IC_FILE; ?>" target="_blank" class="file-badge">
                                                                        <i class="fas fa-file-alt"></i> Passport/IC
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if (!empty($emp->PHOTO_FILE)): ?>
                                                                    <a href="<?php echo BASE_URL . $emp->PHOTO_FILE; ?>" target="_blank" class="file-badge">
                                                                        <i class="fas fa-image"></i> Photo
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if (!empty($emp->WORK_PERMIT_FILE)): ?>
                                                                    <a href="<?php echo BASE_URL . $emp->WORK_PERMIT_FILE; ?>" target="_blank" class="file-badge">
                                                                        <i class="fas fa-file-contract"></i> Work Permit
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php 
                                                                if (!empty($emp->OTHER_DOCS)):
                                                                    $otherDocs = json_decode($emp->OTHER_DOCS, true);
                                                                    if (is_array($otherDocs)):
                                                                        foreach ($otherDocs as $odIdx => $odPath):
                                                                ?>
                                                                    <a href="<?php echo BASE_URL . $odPath; ?>" target="_blank" class="file-badge">
                                                                        <i class="fas fa-paperclip"></i> Other Doc <?php echo ($odIdx + 1); ?>
                                                                    </a>
                                                                <?php 
                                                                        endforeach;
                                                                    endif;
                                                                endif; 
                                                                ?>

                                                                <!-- Competency Certs -->
                                                                <?php if (!empty($emp->CERT_FORKLIFT)): ?>
                                                                    <a href="<?php echo BASE_URL . $emp->CERT_FORKLIFT; ?>" target="_blank" class="file-badge">
                                                                        <i class="fas fa-certificate text-warning"></i> Forklift
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if (!empty($emp->CERT_CRANE)): ?>
                                                                    <a href="<?php echo BASE_URL . $emp->CERT_CRANE; ?>" target="_blank" class="file-badge">
                                                                        <i class="fas fa-certificate text-warning"></i> Crane Operator
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if (!empty($emp->CERT_AGTES)): ?>
                                                                    <a href="<?php echo BASE_URL . $emp->CERT_AGTES; ?>" target="_blank" class="file-badge">
                                                                        <i class="fas fa-certificate text-warning"></i> AGTES
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if (!empty($emp->CERT_AESP)): ?>
                                                                    <a href="<?php echo BASE_URL . $emp->CERT_AESP; ?>" target="_blank" class="file-badge">
                                                                        <i class="fas fa-certificate text-warning"></i> AESP
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if (!empty($emp->CERT_SCAFFOLDER)): ?>
                                                                    <a href="<?php echo BASE_URL . $emp->CERT_SCAFFOLDER; ?>" target="_blank" class="file-badge">
                                                                        <i class="fas fa-certificate text-warning"></i> Scaffolder
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php 
                                                                if (!empty($emp->CERT_OTHER)):
                                                                    $certOthers = json_decode($emp->CERT_OTHER, true);
                                                                    if (is_array($certOthers)):
                                                                        foreach ($certOthers as $coIdx => $coPath):
                                                                ?>
                                                                    <a href="<?php echo BASE_URL . $coPath; ?>" target="_blank" class="file-badge">
                                                                        <i class="fas fa-certificate text-warning"></i> Other Cert <?php echo ($coIdx + 1); ?>
                                                                    </a>
                                                                <?php 
                                                                        endforeach;
                                                                    endif;
                                                                endif; 
                                                                ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="9" class="text-center">No employee records found in this batch.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Super Admin / HSSE Approval Actions -->
                            <?php
                            $userRole = $this->session->userdata('user_type_id');
                            // Accessible to Super Admin (1), Admin (2), HSSE (6), HSSE Head/Reviewer (7)
                            $canApprove = in_array($userRole, [1, 2, 6, 7]) || empty($userRole);
                            ?>
                            <?php if ($appStat == 1): ?>
                            <div class="invoice p-3 mb-3 text-center" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px;">
                                <h4 class="mb-3 font-weight-bold">HSSE Verification</h4>

                                <?php if ($canApprove): ?>
                                    <button type="button" class="btn btn-success btn-md mx-2 px-4 font-weight-bold" data-toggle="modal" data-target="#approveBatchModal">
                                        <i class="fas fa-check-circle mr-1"></i> Approve
                                    </button>
                                    <button type="button" class="btn btn-danger btn-md mx-2 px-4 font-weight-bold" data-toggle="modal" data-target="#rejectBatchModal">
                                        <i class="fas fa-times-circle mr-1"></i> Reject
                                    </button>
                                <?php else: ?>
                                    <span class="badge badge-warning px-3 py-2 font-weight-bold" style="font-size:14px;">
                                        <i class="fas fa-clock mr-1"></i> Pending Approval by HSSE / Super Admin Team
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal: Approve Batch -->
<div class="modal fade" id="approveBatchModal" tabindex="-1" role="dialog" aria-labelledby="approveBatchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <?php echo form_open('hse_induction/approve_contractor_batch/' . encryptval($batch->BATCH_AUTO_ID)); ?>
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold" id="approveBatchModalLabel"><i class="fas fa-check-circle mr-1"></i> Approve Batch <?php echo htmlspecialchars($batch->BATCH_NO); ?></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <p>Are you sure you want to <b>APPROVE</b> Batch <b><?php echo htmlspecialchars($batch->BATCH_NO); ?></b> containing <b><?php echo count($employees); ?></b> employee(s)?</p>
                <div class="alert alert-info py-2 small mb-0">
                    <i class="fas fa-info-circle mr-1"></i> An approval confirmation email will be sent to the contractor PIC (<b><?php echo htmlspecialchars($contractor->CONT_EMAIL_ID); ?></b>).
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-check mr-1"></i> Confirm Approval</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Modal: Reject Batch -->
<div class="modal fade" id="rejectBatchModal" tabindex="-1" role="dialog" aria-labelledby="rejectBatchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <?php echo form_open('hse_induction/reject_contractor_batch/' . encryptval($batch->BATCH_AUTO_ID)); ?>
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title font-weight-bold" id="rejectBatchModalLabel"><i class="fas fa-times-circle mr-1"></i> Reject Batch <?php echo htmlspecialchars($batch->BATCH_NO); ?></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <p>Please provide the reasons for rejection. This reason will be emailed to the contractor PIC (<b><?php echo htmlspecialchars($contractor->CONT_EMAIL_ID); ?></b>) so they can correct and re-submit.</p>
                <div class="form-group">
                    <label><b>Rejection Reason / Safety Remarks <span class="text-danger">*</span></b></label>
                    <textarea name="reject_reason" id="batch_reject_reason" class="form-control" rows="4" placeholder="Enter rejection details or missing document requirements" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger font-weight-bold"><i class="fas fa-paper-plane mr-1"></i> Reject Batch & Email Contractor</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
