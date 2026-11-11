<?php
$cntrentID = postData($getEmploydetails, 'CONT_ID');
$cntrentAutoID = postData($getEmploydetails, 'CONT_AUTO_ID');
$compName = postData($getEmploydetails, 'CONT_COMPANY');
$compRegNo = postData($getEmploydetails, 'CONT_REG_NO');
$compEmail = postData($getEmploydetails, 'CONT_COMP_EMAIL');
$compPhone = postData($getEmploydetails, 'CONT_COMP_PHONE');
$compSpec = postData($getEmploydetails, 'CONT_SPECIAL');
$compAddress = postData($getEmploydetails, 'CONT_ADDRESS');
$compCity = postData($getEmploydetails, 'CONT_CITY');
$compCountry = postData($getEmploydetails, 'CONT_COUNTRY');
$compPostal = postData($getEmploydetails, 'CONT_POSTAL_CODE');

$picName = postData($getEmploydetails, 'CONT_NAME');
$picDesig = postData($getEmploydetails, 'CONT_DESIGNATION');
$picEmail = postData($getEmploydetails, 'CONT_EMAIL_ID');
$picPhone = postData($getEmploydetails, 'CONT_PHONE_NO');
$pdpaAgree = postData($getEmploydetails, 'CONT_PDPA_AGREE');
$logStatus = postData($getEmploydetails, 'CON_LOGIN_STATUS');
$rejectReason = postData($getEmploydetails, 'CONT_REJECT_REASON');
$banReason = postData($getEmploydetails, 'CONT_BAN_REASON');

$loginPassword = isset($emplLogindet) ? postData($emplLogindet, 'ORG_PWD') : '';

if ($logStatus == 'P') {
    $statusText = 'Pending Approval';
    $statusBadge = 'badge-warning';
} elseif ($logStatus == 'E') {
    $statusText = 'Approved';
    $statusBadge = 'badge-success';
} elseif ($logStatus == 'S') {
    $statusText = 'Suspended / Banned';
    $statusBadge = 'badge-danger';
} else {
    $statusText = 'Rejected';
    $statusBadge = 'badge-danger';
}
?>
<style>
.emplBorder{
    background-color: #007bff;
}
.action-box {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 20px;
    margin-top: 20px;
}
</style>
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">

                        <?php if ($this->session->flashdata('success_msg')) { ?>
                            <div class="alert alert-success alert-dismissible mt-2">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="fas fa-check-circle mr-1"></i> <?php echo $this->session->flashdata('success_msg'); ?>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div class="alert alert-danger alert-dismissible mt-2">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <i class="fas fa-exclamation-triangle mr-1"></i> <?php echo $this->session->flashdata('error_msg'); ?>
                            </div>
                        <?php } ?>

                        <!-- general form elements -->
                        <div class="card card-headprimary">

                            <div class="card-header">
                                <h4 class="card-title">Contractor Details</h4>
                                <a href="<?php echo BASE_URL('hse_induction') ?>" class="btn btn-sm btn-primary float-right locatnTyptarget"><i class="fa fa-arrow-left"></i> Back</a>
                            </div>

                            <div class="card-body">

                                <div class="invoice p-3 mb-3">
                                    <div class="card-header emplBorder">
                                        <h3 class="card-title" style="color: #ffff;">Basic Details</h3>
                                    </div>
                                    <div class="row">

                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td width="23%"><b>Contractor ID</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrentID; ?></td>
                                                        <td width="23%"><b>Company Name</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $compName; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Company Registration No</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $compRegNo ? $compRegNo : '-'; ?></td>
                                                        <td width="23%"><b>Company Email ID</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $compEmail ? $compEmail : '-'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Company Phone No</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $compPhone ? $compPhone : '-'; ?></td>
                                                        <td width="23%"><b>Company Specialization</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $compSpec; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>PIC Name</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $picName; ?></td>
                                                        <td width="23%"><b>PIC Designation</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $picDesig; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>PIC Email ID</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $picEmail; ?></td>
                                                        <td width="23%"><b>PIC Mobile No</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $picPhone; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Address</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $compAddress; ?></td>
                                                        <td width="23%"><b>City</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $compCity; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>Country</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $compCountry; ?></td>
                                                        <td width="23%"><b>Postal Code</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $compPostal; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="23%"><b>PDPA Agreement</b></td>
                                                        <td>:</td>
                                                        <td width="23%">
                                                            <?php if ($pdpaAgree == 'Y') { ?>
                                                                <span class="badge badge-success">Agreed</span>
                                                            <?php } else { ?>
                                                                <span class="badge badge-danger">Pending</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td width="23%"><b>Status</b></td>
                                                        <td>:</td>
                                                        <td width="23%">
                                                            <span class="badge <?php echo $statusBadge; ?>" style="font-size: 13px; padding: 5px 10px;"><?php echo $statusText; ?></span>
                                                        </td>
                                                    </tr>
                                                    <?php if ($logStatus == 'D' && !empty($rejectReason)) { ?>
                                                    <tr>
                                                        <td width="23%"><b class="text-danger">Rejection Reason</b></td>
                                                        <td>:</td>
                                                        <td colspan="4" class="text-danger"><b><?php echo nl2br(htmlspecialchars($rejectReason)); ?></b></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if ($logStatus == 'E' && !empty($loginPassword)) { ?>
                                                    <tr>
                                                        <td width="23%"><b>Login Username</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $cntrentID; ?></td>
                                                        <td width="23%"><b>Password</b></td>
                                                        <td>:</td>
                                                        <td width="23%"><?php echo $loginPassword; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="invoice p-3 mb-3">
                                    <div class="card-header emplBorder">
                                        <h3 class="card-title" style="color:#ffff;text-align:center;">Document Details</h3>
                                    </div>
                                    <div class="row">

                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped" style="width:100%;text-align:center;">
                                                <thead style="background: #94960ae0;font-weight: bold;color:#ffff;text-align:center;">
                                                    <tr>
                                                        <td style="width:10%">S/No</td>
                                                        <td style="width:40%">Document Title</td>
                                                        <td style="width:20%">Uploaded Date</td>
                                                        <td style="width:30%">Document File</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1;
                                                if (isset($getOthercertdet) && !empty($getOthercertdet)) {
                                                    foreach ($getOthercertdet as $insDKey => $InsData) {
                                                        $fileExtn = strtolower(postData($InsData, 'CERT_EXT'));
                                                        $filePath = BASE_URL . $InsData->CERT_PATH . $InsData->CERT_FILE_NAME;
                                                        ?>
                                                        <tr>
                                                            <td style="width:10%"><?php echo $i++; ?></td>
                                                            <td style="width:40%;"><?php echo $InsData->CERT_NAME ? $InsData->CERT_NAME : 'Contractor Document'; ?></td>
                                                            <td style="width:20%"><?php echo date("d-m-Y", strtotime($InsData->CREATED_ON)); ?></td>
                                                            <td style="width:30%">
                                                                <?php if (!empty($InsData->CERT_FILE_NAME)) { ?>
                                                                    <?php if (in_array($fileExtn, ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                                                                        <a href="<?php echo $filePath; ?>" target="_blank">
                                                                            <img src="<?php echo $filePath; ?>" style="max-height:60px;" alt="<?php echo $InsData->CERT_FILE_NAME; ?>">
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a href="<?php echo $filePath; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                            <i class="fas fa-file-pdf"></i> <?php echo $InsData->CERT_FILE_NAME; ?>
                                                                        </a>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    -
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="4">No data Available</td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- <---- New code: Approve and Reject Action Panel Start ---->
                                <div class="invoice p-3 mb-3 action-box text-center">
                                    <h4 class="mb-3 font-weight-bold">Contractor Verification Actions</h4>

                                    <?php if ($logStatus == 'P') { ?>
                                        <button type="button" class="btn btn-success btn-lg mx-2 px-4" data-toggle="modal" data-target="#approveModal">
                                            <i class="fas fa-check-circle mr-1"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-danger btn-lg mx-2 px-4" data-toggle="modal" data-target="#rejectModal">
                                            <i class="fas fa-times-circle mr-1"></i> Reject
                                        </button>
                                        <button type="button" class="btn btn-warning btn-lg mx-2 px-4 text-dark font-weight-bold" data-toggle="modal" data-target="#suspendBanModal">
                                            <i class="fas fa-user-slash mr-1"></i> Suspend / Ban
                                        </button>
                                    <?php } elseif ($logStatus == 'E') { ?>
                                        <div class="alert alert-success d-inline-block px-4 py-2 mb-3">
                                            <i class="fas fa-check-double mr-1"></i> <b>This Contractor is Approved & Login Credentials have been issued.</b>
                                        </div>
                                        <br>
                                        <button type="button" class="btn btn-warning btn-lg mx-2 px-4 text-dark font-weight-bold" data-toggle="modal" data-target="#suspendBanModal">
                                            <i class="fas fa-user-slash mr-1"></i> Suspend / Ban
                                        </button>
                                    <?php } elseif ($logStatus == 'S') { ?>
                                        <div class="alert alert-danger d-inline-block px-4 py-2 mb-2">
                                            <i class="fas fa-ban mr-1"></i> <b>This Contractor is currently SUSPENDED / BANNED from Lumut Port.</b>
                                        </div>
                                        <?php if (!empty($banReason)) { ?>
                                            <div class="text-danger small mb-3"><b>Reason:</b> <?php echo nl2br(htmlspecialchars($banReason)); ?></div>
                                        <?php } ?>
                                        <br>
                                        <button type="button" class="btn btn-success mx-2" data-toggle="modal" data-target="#approveModal">
                                            <i class="fas fa-undo mr-1"></i> Re-Approve / Lift Suspension & Ban
                                        </button>
                                    <?php } else { ?>
                                        <div class="alert alert-danger d-inline-block px-4 py-2 mb-2">
                                            <i class="fas fa-ban mr-1"></i> <b>This Contractor application was Rejected.</b> Awaiting re-submission.
                                        </div>
                                        <?php if (!empty($rejectReason)) { ?>
                                            <div class="text-danger small mb-2"><b>Reason:</b> <?php echo nl2br(htmlspecialchars($rejectReason)); ?></div>
                                        <?php } ?>
                                        <br>
                                        <button type="button" class="btn btn-success mx-2" data-toggle="modal" data-target="#approveModal">
                                            <i class="fas fa-check-circle mr-1"></i> Approve Now
                                        </button>
                                        <button type="button" class="btn btn-warning mx-2 text-dark font-weight-bold" data-toggle="modal" data-target="#suspendBanModal">
                                            <i class="fas fa-user-slash mr-1"></i> Suspend / Ban
                                        </button>
                                    <?php } ?>
                                </div>
                                <!-- <---- New code: Approve and Reject Action Panel End ---->

                            </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <?php echo form_open('hse_induction/approveContractor/' . $encrypted_id, ['id' => 'approveForm']); ?>
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="approveModalLabel"><i class="fas fa-user-check mr-1"></i> Approve Contractor Application</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <p>Upon approval, a login account will be generated and login credentials will be emailed to <b><?php echo $picEmail; ?></b>.</p>
                <div class="form-group">
                    <label><b>Username / Contractor ID</b></label>
                    <input type="text" class="form-control" value="<?php echo $cntrentID; ?>" readonly>
                </div>
                <div class="form-group">
                    <label><b>Set Password <span class="text-danger">*</span></b></label>
                    <input type="text" name="password" id="approve_password" class="form-control" placeholder="Enter Password" value="<?php echo (!empty($loginPassword)) ? $loginPassword : substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789'), 0, 8); ?>" required>
                    <small class="text-muted">A secure password has been generated by default, or you can type a custom one.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-check mr-1"></i> Confirm & Send Approval Email</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <?php echo form_open('hse_induction/rejectContractor/' . $encrypted_id, ['id' => 'rejectForm']); ?>
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel"><i class="fas fa-user-times mr-1"></i> Reject Contractor Application</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <p>Please enter the reason for rejection. This reason and an <b>Edit & Re-Submit registration link</b> will be emailed to <b><?php echo $picEmail; ?></b>.</p>
                <div class="form-group">
                    <label><b>Rejection Reason / Remarks <span class="text-danger">*</span></b></label>
                    <textarea name="reject_reason" id="reject_reason" class="form-control" rows="4" placeholder="Enter reasons for rejection" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-paper-plane mr-1"></i> Submit Rejection & Email Contractor</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Suspend / Ban Modal -->
<div class="modal fade" id="suspendBanModal" tabindex="-1" role="dialog" aria-labelledby="suspendBanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <?php echo form_open('hse_induction/suspendBanContractor/' . $encrypted_id, ['id' => 'suspendBanForm']); ?>
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title font-weight-bold" id="suspendBanModalLabel"><i class="fas fa-user-slash mr-1"></i> Suspend / Ban Contractor</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">
                <div class="alert alert-warning py-2 mb-3 small">
                    <i class="fas fa-exclamation-triangle mr-1"></i> This action will revoke portal login access for <b><?php echo htmlspecialchars($compName); ?></b> and notify the contractor.
                </div>
                <div class="form-group">
                    <label><b>Reason for Suspension / Ban <span class="text-danger">*</span></b></label>
                    <textarea name="ban_reason" id="ban_reason" class="form-control" rows="4" placeholder="Specify violations, safety breaches or administrative grounds" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger font-weight-bold"><i class="fas fa-gavel mr-1"></i> Apply Status & Notify</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
