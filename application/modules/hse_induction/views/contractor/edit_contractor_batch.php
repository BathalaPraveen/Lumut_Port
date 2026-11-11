<style>
    body, html {
        overflow-x: hidden !important;
    }
    .emp-table-wrapper {
        overflow-x: auto !important;
    }
    .error {
        color: #dc3545;
        font-size: 12px;
        font-weight: 500;
        margin-top: 4px;
        display: block;
    }
    .req {
        color: #dc3545;
        font-weight: bold;
    }
    .company-banner {
        background-color: #e8f4fd;
        border: 1px solid #b8daff;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .company-banner label {
        font-weight: 600;
        color: #004085;
    }
    .emp-table-wrapper {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background: #fff;
        max-width: 100%;
        overflow-x: auto;
    }
    #empTable th {
        background: #227bff;
        color: #fff;
        font-size: 13px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        padding: 10px 8px;
    }
    #empTable td {
        vertical-align: middle;
        padding: 8px 6px;
        background: #fff;
    }
    #empTable input.form-control, #empTable select.form-control {
        font-size: 13px;
        height: 38px;
        padding: 6px 10px;
    }
    .select2-container .select2-selection--single {
        height: 38px !important;
        font-size: 13px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        padding-left: 10px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
    .action-btn-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-delete-custom {
        background-color: #fff !important;
        border: 1px solid #dc3545 !important;
        color: #dc3545 !important;
        padding: 4px 8px;
    }
    .btn-delete-custom:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
    }
    .btn-upload-modal {
        background-color: #fff;
        border: 1px solid #17a2b8;
        color: #17a2b8;
        font-weight: 600;
        font-size: 12px;
        padding: 4px 10px;
        white-space: nowrap;
    }
    .btn-upload-modal:hover {
        background-color: #17a2b8;
        color: #fff;
    }
    .btn-upload-modal.has-files {
        background-color: #e8f4fd;
        border-color: #28a745;
        color: #28a745;
    }
    .upload-status-badge {
        display: block;
        margin-top: 3px;
        font-size: 11px;
    }
    .file-link-existing {
        font-size: 11px;
        margin-bottom: 4px;
        display: inline-block;
        background: #e9f5ff;
        border: 1px solid #b8daff;
        border-radius: 3px;
        padding: 2px 6px;
        color: #0056b3;
    }
    .file-link-existing:hover {
        background: #0056b3;
        color: #fff;
    }
    /* Modal styles */
    #docUploadModal .modal-header {
        background: #227bff;
        color: #fff;
        padding: 12px 20px;
    }
    #docUploadModal .modal-title {
        color: #fff;
        font-size: 16px;
        font-weight: 600;
    }
    #docUploadModal .close {
        color: #fff;
        opacity: 0.9;
        text-shadow: none;
    }
    .modal-section-card {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background: #fafbfe;
        padding: 14px 16px;
        height: 100%;
    }
    .modal-section-card h6 {
        font-size: 13px;
        font-weight: bold;
        color: #004085;
        border-bottom: 2px solid #b8daff;
        padding-bottom: 6px;
        margin-bottom: 12px;
    }
    .doc-field-item {
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px dashed #e9ecef;
    }
    .doc-field-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .doc-field-item label {
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 3px;
        display: block;
        color: #333;
    }
    .file-input-sm {
        font-size: 11px;
    }
    .multi-file-item {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }
    .multi-file-item:last-child {
        margin-bottom: 0;
    }
    .btn-icon-sub {
        cursor: pointer;
        font-size: 16px;
        line-height: 1;
    }
    .btn-icon-sub.text-success:hover {
        color: #218838 !important;
    }
    .btn-icon-sub.text-danger:hover {
        color: #c82333 !important;
    }
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid" style="margin-top:0px;">
                <?php echo $this->session->flashdata('employee_msg'); ?>

                <div class="card card-headprimary">
                    <div class="row headingStyl">
                        <div class="col-md-12">
                            <h4>Edit Contractor Batch - <?php echo htmlspecialchars($batch->BATCH_NO); ?></h4>
                            <a href="<?php echo BASE_URL('hse_induction/contractor_employees/' . encryptval($contractor_id)); ?>"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php echo form_open_multipart('hse_induction/update_contractor_batch/' . encryptval($batch->BATCH_AUTO_ID), array('id' => 'empForm', 'novalidate' => 'novalidate')); ?>

                        <!-- 1. Top Section: Company Details & Common Batch, Payment, Validity -->
                        <div class="company-banner">
                            <!-- Company Details -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Company Name:</label>
                                    <div class="form-control-plaintext font-weight-bold" style="font-size:16px;">
                                        <?php echo htmlspecialchars($contractor->CONT_COMPANY); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Contractor ID:</label>
                                    <div class="form-control-plaintext font-weight-bold">
                                        <?php echo htmlspecialchars($contractor->CONT_ID); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Person In-Charge (PIC):</label>
                                    <div class="form-control-plaintext font-weight-bold">
                                        <?php echo htmlspecialchars($contractor->CONT_NAME); ?>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-top: 1px dashed #b8daff; margin: 10px 0 15px 0;">

                            <!-- Common BATCH, Payment, Validity -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>BATCH <span class="req">*</span></label>
                                        <input type="text" name="common_batch_no" id="common_batch_no" class="form-control" value="<?php echo htmlspecialchars($batch->BATCH_NO); ?>" readonly required>
                                    </div>
                                </div>
                                <!-- Payment and Validity commented out as requested
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Payment <span class="req">*</span></label>
                                        <input type="text" name="common_payment" id="common_payment" class="form-control" value="<?php echo htmlspecialchars($batch->PAYMENT); ?>" placeholder="Enter Payment details">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Validity <span class="req">*</span></label>
                                        <input type="text" name="common_validity" id="common_validity" class="form-control singledaterangepicker" value="<?php echo $valDate; ?>" placeholder="DD-MM-YYYY" autocomplete="off">
                                    </div>
                                </div>
                                -->
                                <input type="hidden" name="common_payment" id="common_payment" value="<?php echo htmlspecialchars($batch->PAYMENT); ?>">
                                <?php
                                $valDate = ($batch->VALIDITY_DATE && $batch->VALIDITY_DATE != '0000-00-00') ? date('d-m-Y', strtotime($batch->VALIDITY_DATE)) : '';
                                ?>
                                <input type="hidden" name="common_validity" id="common_validity" value="<?php echo $valDate; ?>">
                            </div>
                        </div>

                        <!-- 2. Employee Details Table -->
                        <div class="emp-table-wrapper table-responsive">
                            <table class="table table-bordered mb-0" id="empTable">
                                <thead>
                                    <tr>
                                        <th style="width: 45px;">#</th>
                                        <th style="min-width: 200px;">Contractor Employee Name <span class="req">*</span></th>
                                        <th style="min-width: 190px;">Contractor Employee Email ID <span class="req">*</span></th>
                                        <th style="min-width: 160px;">Contractor Employee Phone No <span class="req">*</span></th>
                                        <th style="min-width: 150px;">Contractor ID Type <span class="req">*</span></th>
                                        <th style="min-width: 170px;">NRIC / Passport No <span class="req">*</span></th>
                                        <th style="min-width: 140px;">Gender <span class="req">*</span></th>
                                        <th style="min-width: 150px;">Date of Birth <span class="req">*</span></th>
                                        <th style="min-width: 170px;">Designation <span class="req">*</span></th>
                                        <th style="min-width: 180px;">Nationality <span class="req">*</span></th>
                                        <th style="min-width: 150px;">Religion <span class="req">*</span></th>
                                        <th style="min-width: 150px;">Race <span class="req">*</span></th>
                                        <th style="min-width: 150px;">Marital Status <span class="req">*</span></th>
                                        <th style="min-width: 150px;">Work Experience (Yrs) <span class="req">*</span></th>
                                        <th style="min-width: 190px;">Emergency Contact Name <span class="req">*</span></th>
                                        <th style="min-width: 170px;">Emergency Relationship <span class="req">*</span></th>
                                        <th style="min-width: 160px;">Emergency Phone No <span class="req">*</span></th>
                                        <th style="min-width: 220px;">Emergency Address <span class="req">*</span></th>
                                        <th style="min-width: 180px;">Terminal <span class="req">*</span></th>
                                        <th style="min-width: 140px; text-align: center;">Upload <span class="req">*</span></th>
                                        <th style="min-width: 100px; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="empTableBody">
                                    <?php
                                    $empList = !empty($employees) ? $employees : [null];
                                    foreach ($empList as $idx => $emp):
                                        $empId = $emp ? $emp->EMP_AUTO_ID : '';
                                        $empName = $emp ? $emp->EMP_NAME : '';
                                        $empEmail = $emp ? $emp->EMP_EMAIL : '';
                                        $empPhone = $emp ? $emp->EMP_PHONE : '';
                                        $idType = $emp ? $emp->ID_TYPE : 'NRIC';
                                        $idNumber = $emp ? $emp->ID_NUMBER : '';
                                        $gender = $emp ? $emp->GENDER : 'Male';
                                        $dobVal = ($emp && !empty($emp->DOB) && $emp->DOB != '0000-00-00') ? date('d-m-Y', strtotime($emp->DOB)) : '';
                                        $desig = $emp ? $emp->DESIGNATION : '';
                                        $natId = $emp ? $emp->NATIONALITY_ID : '';
                                        $natOther = $emp ? $emp->NATIONALITY_OTHER : '';
                                        $religion = $emp ? $emp->RELIGION : '';
                                        $race = $emp ? $emp->RACE : '';
                                        $maritalStatus = $emp ? $emp->MARITAL_STATUS : 'Single';
                                        $workExp = $emp ? $emp->WORK_EXPERIENCE : '';
                                        $emergName = $emp ? $emp->EMERGENCY_NAME : '';
                                        $emergRel = $emp ? $emp->EMERGENCY_RELATIONSHIP : '';
                                        $emergPhone = $emp ? $emp->EMERGENCY_PHONE : '';
                                        $emergAddress = $emp ? $emp->EMERGENCY_ADDRESS : '';
                                        $termName = $emp ? $emp->TERMINALS : '';
                                        $passportFile = $emp ? $emp->PASSPORT_IC_FILE : '';
                                        $photoFile = $emp ? $emp->PHOTO_FILE : '';
                                        $workPermitFile = $emp ? $emp->WORK_PERMIT_FILE : '';
                                        $othersDocs = ($emp && !empty($emp->OTHER_DOCS)) ? json_decode($emp->OTHER_DOCS, true) : [];
                                        $certOther = ($emp && !empty($emp->CERT_OTHER)) ? json_decode($emp->CERT_OTHER, true) : [];
                                        
                                        $hasExistingDocs = (!empty($passportFile) || !empty($photoFile) || !empty($workPermitFile));
                                    ?>
                                    <tr class="emp-row" data-index="<?php echo $idx; ?>">
                                        <td class="text-center font-weight-bold row-num"><?php echo $idx + 1; ?></td>
                                        <input type="hidden" name="emp[<?php echo $idx; ?>][emp_auto_id]" value="<?php echo $empId; ?>">

                                        <!-- Employee Name -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][emp_name]" class="form-control emp-name" value="<?php echo htmlspecialchars($empName); ?>" placeholder="Enter Full Name" required>
                                        </td>

                                        <!-- Email ID -->
                                        <td>
                                            <input type="email" name="emp[<?php echo $idx; ?>][email]" class="form-control emp-email" value="<?php echo htmlspecialchars($empEmail); ?>" placeholder="Enter Email ID" required>
                                        </td>

                                        <!-- Phone No -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][phone]" class="form-control emp-phone" value="<?php echo htmlspecialchars($empPhone); ?>" placeholder="Enter Phone No" required>
                                        </td>

                                        <!-- ID Type -->
                                        <td>
                                            <select name="emp[<?php echo $idx; ?>][id_type]" class="form-control select2 id-type-select" checkSelect="select2" style="width:100%;" required>
                                                <option value="NRIC" <?php echo ($idType == 'NRIC') ? 'selected' : ''; ?>>NRIC</option>
                                                <option value="Passport No" <?php echo ($idType == 'Passport No') ? 'selected' : ''; ?>>Passport No</option>
                                            </select>
                                        </td>

                                        <!-- NRIC / Passport No -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][id_number]" class="form-control id-number-input" value="<?php echo htmlspecialchars($idNumber); ?>" placeholder="Enter NRIC No" required>
                                        </td>

                                        <!-- Gender -->
                                        <td>
                                            <select name="emp[<?php echo $idx; ?>][gender]" class="form-control select2" checkSelect="select2" style="width:100%;" required>
                                                <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                            </select>
                                        </td>

                                        <!-- Date of Birth -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][dob]" class="form-control emp-dob-picker" value="<?php echo $dobVal; ?>" placeholder="DD-MM-YYYY" autocomplete="off" required>
                                        </td>

                                        <!-- Designation -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][designation]" class="form-control emp-desig" value="<?php echo htmlspecialchars($desig); ?>" placeholder="Enter Designation" required>
                                        </td>

                                        <!-- Nationality -->
                                        <td>
                                            <select name="emp[<?php echo $idx; ?>][nationality]" class="form-control select2 nationality-select" checkSelect="select2" style="width:100%;" required>
                                                <option value="">Select Nationality</option>
                                                <?php foreach ($nationalities as $nat): ?>
                                                    <option value="<?php echo $nat->NATIONALITY_ID; ?>" <?php echo ($natId == $nat->NATIONALITY_ID) ? 'selected' : ''; ?> data-name="<?php echo strtolower($nat->NATIONALITY_NAME); ?>"><?php echo htmlspecialchars($nat->NATIONALITY_NAME); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="other-nat-container mt-1" style="<?php echo ($natId == 3 || !empty($natOther)) ? '' : 'display:none;'; ?>">
                                                <input type="text" name="emp[<?php echo $idx; ?>][nationality_other]" class="form-control" value="<?php echo htmlspecialchars($natOther); ?>" placeholder="Specify Nationality">
                                            </div>
                                        </td>

                                        <!-- Religion -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][religion]" class="form-control" value="<?php echo htmlspecialchars($religion); ?>" placeholder="Enter Religion" required>
                                        </td>

                                        <!-- Race -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][race]" class="form-control" value="<?php echo htmlspecialchars($race); ?>" placeholder="Enter Race" required>
                                        </td>

                                        <!-- Marital Status -->
                                        <td>
                                            <select name="emp[<?php echo $idx; ?>][marital_status]" class="form-control select2" checkSelect="select2" style="width:100%;" required>
                                                <option value="1" <?php echo ($maritalStatus == '1' || $maritalStatus == 'Single') ? 'selected' : ''; ?>>Single</option>
                                                <option value="2" <?php echo ($maritalStatus == '2' || $maritalStatus == 'Married') ? 'selected' : ''; ?>>Married</option>
                                                <option value="3" <?php echo ($maritalStatus == '3' || $maritalStatus == 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
                                            </select>
                                        </td>

                                        <!-- Work Experience -->
                                        <td>
                                            <input type="number" step="0.5" min="0" name="emp[<?php echo $idx; ?>][work_experience]" class="form-control" value="<?php echo htmlspecialchars($workExp); ?>" placeholder="e.g. 3" required>
                                        </td>

                                        <!-- Emergency Contact Name -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][emergency_name]" class="form-control" value="<?php echo htmlspecialchars($emergName); ?>" placeholder="Contact Person" required>
                                        </td>

                                        <!-- Emergency Relationship -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][emergency_relationship]" class="form-control" value="<?php echo htmlspecialchars($emergRel); ?>" placeholder="e.g. Spouse, Father" required>
                                        </td>

                                        <!-- Emergency Phone No -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][emergency_phone]" class="form-control" value="<?php echo htmlspecialchars($emergPhone); ?>" placeholder="Emergency Phone" required>
                                        </td>

                                        <!-- Emergency Address -->
                                        <td>
                                            <input type="text" name="emp[<?php echo $idx; ?>][emergency_address]" class="form-control" value="<?php echo htmlspecialchars($emergAddress); ?>" placeholder="Emergency Address" required>
                                        </td>

                                        <!-- Terminal (Single Select) -->
                                        <td>
                                            <select name="emp[<?php echo $idx; ?>][terminals]" class="form-control select2 terminals-select" checkSelect="select2" style="width:100%;" required>
                                                <option value="">Select Terminal</option>
                                                <?php foreach ($terminals as $term): ?>
                                                    <option value="<?php echo htmlspecialchars($term->TERMINAL_NAME); ?>" <?php echo ($termName == $term->TERMINAL_NAME) ? 'selected' : ''; ?>><?php echo htmlspecialchars($term->TERMINAL_NAME); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>

                                        <!-- Upload Documents & Certificates (Modal Trigger) -->
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-upload-modal open-doc-modal-btn <?php echo $hasExistingDocs ? 'has-files' : ''; ?>" data-row-idx="<?php echo $idx; ?>">
                                                <i class="<?php echo $hasExistingDocs ? 'fa fa-check-circle' : 'fa fa-upload'; ?>"></i> Upload
                                            </button>
                                            <div class="upload-status-badge">
                                                <?php if ($hasExistingDocs): ?>
                                                    <span class="upload-badge-text text-success font-weight-bold">Files uploaded</span>
                                                <?php else: ?>
                                                    <span class="upload-badge-text text-muted">No files</span>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Hidden container holding this row's file inputs & existing previews -->
                                            <div class="row-doc-storage" data-row-idx="<?php echo $idx; ?>" style="display:none;">
                                                <div class="storage-docs">
                                                    <div class="doc-field-item">
                                                        <label>Passport / IC <span class="req">*</span></label>
                                                        <?php if (!empty($passportFile)): ?>
                                                            <div><a href="<?php echo BASE_URL($passportFile); ?>" target="_blank" class="file-link-existing"><i class="fa fa-file"></i> View Existing Passport/IC</a></div>
                                                        <?php endif; ?>
                                                        <input type="file" name="passport_ic_<?php echo $idx; ?>" class="form-control-file file-input-sm passport-file" <?php echo empty($passportFile) ? 'required' : ''; ?>>
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Photo <span class="req">*</span></label>
                                                        <?php if (!empty($photoFile)): ?>
                                                            <div><a href="<?php echo BASE_URL($photoFile); ?>" target="_blank" class="file-link-existing"><i class="fa fa-image"></i> View Existing Photo</a></div>
                                                        <?php endif; ?>
                                                        <input type="file" name="photo_<?php echo $idx; ?>" class="form-control-file file-input-sm photo-file" <?php echo empty($photoFile) ? 'required' : ''; ?>>
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Work Permit <span class="req">*</span></label>
                                                        <?php if (!empty($workPermitFile)): ?>
                                                            <div><a href="<?php echo BASE_URL($workPermitFile); ?>" target="_blank" class="file-link-existing"><i class="fa fa-file"></i> View Existing Work Permit</a></div>
                                                        <?php endif; ?>
                                                        <input type="file" name="work_permit_<?php echo $idx; ?>" class="form-control-file file-input-sm workpermit-file" <?php echo empty($workPermitFile) ? 'required' : ''; ?>>
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Others (Driving License / Medical Exam)</label>
                                                        <?php if (!empty($othersDocs) && is_array($othersDocs)): ?>
                                                            <div class="existing-files-group mb-2">
                                                                <?php foreach ($othersDocs as $odIdx => $f): ?>
                                                                    <div class="existing-file-pill d-inline-block mr-1 mb-1" style="background:#e9f5ff; border:1px solid #b8daff; border-radius:3px; padding:2px 6px;">
                                                                        <input type="hidden" name="emp[<?php echo $idx; ?>][existing_others][]" value="<?php echo htmlspecialchars($f); ?>">
                                                                        <a href="<?php echo BASE_URL($f); ?>" target="_blank" class="text-primary mr-1" style="font-size:11px;">
                                                                            <i class="fa fa-paperclip"></i> <?php echo basename($f); ?>
                                                                        </a>
                                                                        <i class="fa fa-times text-danger remove-existing-file-btn" style="cursor:pointer; font-size:12px;" title="Remove this file"></i>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="others-doc-container" data-emp-idx="<?php echo $idx; ?>">
                                                            <div class="multi-file-item">
                                                                <input type="file" name="others_<?php echo $idx; ?>[]" class="form-control-file file-input-sm">
                                                                <i class="fa fa-plus-circle text-success btn-icon-sub add-others-doc-btn" title="Add another file"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="storage-certs">
                                                    <div class="doc-field-item">
                                                        <label>Forklift</label>
                                                        <?php if ($emp && !empty($emp->CERT_FORKLIFT)): ?>
                                                            <div><a href="<?php echo BASE_URL($emp->CERT_FORKLIFT); ?>" target="_blank" class="file-link-existing"><i class="fa fa-certificate"></i> View Forklift Cert</a></div>
                                                        <?php endif; ?>
                                                        <input type="file" name="cert_forklift_<?php echo $idx; ?>" class="form-control-file file-input-sm">
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Crane Operator</label>
                                                        <?php if ($emp && !empty($emp->CERT_CRANE)): ?>
                                                            <div><a href="<?php echo BASE_URL($emp->CERT_CRANE); ?>" target="_blank" class="file-link-existing"><i class="fa fa-certificate"></i> View Crane Cert</a></div>
                                                        <?php endif; ?>
                                                        <input type="file" name="cert_crane_<?php echo $idx; ?>" class="form-control-file file-input-sm">
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>AGTES</label>
                                                        <?php if ($emp && !empty($emp->CERT_AGTES)): ?>
                                                            <div><a href="<?php echo BASE_URL($emp->CERT_AGTES); ?>" target="_blank" class="file-link-existing"><i class="fa fa-certificate"></i> View AGTES Cert</a></div>
                                                        <?php endif; ?>
                                                        <input type="file" name="cert_agtes_<?php echo $idx; ?>" class="form-control-file file-input-sm">
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>AESP</label>
                                                        <?php if ($emp && !empty($emp->CERT_AESP)): ?>
                                                            <div><a href="<?php echo BASE_URL($emp->CERT_AESP); ?>" target="_blank" class="file-link-existing"><i class="fa fa-certificate"></i> View AESP Cert</a></div>
                                                        <?php endif; ?>
                                                        <input type="file" name="cert_aesp_<?php echo $idx; ?>" class="form-control-file file-input-sm">
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Scaffolder</label>
                                                        <?php if ($emp && !empty($emp->CERT_SCAFFOLDER)): ?>
                                                            <div><a href="<?php echo BASE_URL($emp->CERT_SCAFFOLDER); ?>" target="_blank" class="file-link-existing"><i class="fa fa-certificate"></i> View Scaffolder Cert</a></div>
                                                        <?php endif; ?>
                                                        <input type="file" name="cert_scaffolder_<?php echo $idx; ?>" class="form-control-file file-input-sm">
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Other Document</label>
                                                        <?php if (!empty($certOther) && is_array($certOther)): ?>
                                                            <div class="existing-files-group mb-2">
                                                                <?php foreach ($certOther as $coIdx => $co): ?>
                                                                    <div class="existing-file-pill d-inline-block mr-1 mb-1" style="background:#e9f5ff; border:1px solid #b8daff; border-radius:3px; padding:2px 6px;">
                                                                        <input type="hidden" name="emp[<?php echo $idx; ?>][existing_cert_other][]" value="<?php echo htmlspecialchars($co); ?>">
                                                                        <a href="<?php echo BASE_URL($co); ?>" target="_blank" class="text-primary mr-1" style="font-size:11px;">
                                                                            <i class="fa fa-paperclip"></i> <?php echo basename($co); ?>
                                                                        </a>
                                                                        <i class="fa fa-times text-danger remove-existing-file-btn" style="cursor:pointer; font-size:12px;" title="Remove this file"></i>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="cert-other-container" data-emp-idx="<?php echo $idx; ?>">
                                                            <div class="multi-file-item">
                                                                <input type="file" name="cert_other_<?php echo $idx; ?>[]" class="form-control-file file-input-sm">
                                                                <i class="fa fa-plus-circle text-success btn-icon-sub add-cert-other-btn" title="Add another certificate"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Action Column -->
                                        <td class="text-center align-middle">
                                            <div class="action-btn-group">
                                                <button type="button" class="btn btn-primary btn-sm add-row-action-btn" title="Add More Employee">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-delete-custom btn-sm remove-row-btn" style="<?php echo (count($empList) > 1) ? '' : 'display:none;'; ?>" title="Remove this employee">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-success px-4" id="submitBtn">
                                    Submit
                                </button>
                                <a href="<?php echo BASE_URL('hse_induction/contractor_employees/' . encryptval($contractor_id)); ?>" class="btn btn-secondary ml-2">
                                    Cancel
                                </a>
                            </div>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal Popup for Document & Certificate Upload -->
<div class="modal fade" id="docUploadModal" tabindex="-1" role="dialog" aria-labelledby="docUploadModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="docUploadModalLabel">
                    <i class="fa fa-upload mr-1"></i> Upload Documents & Certificates - <span id="modalEmployeeLabel" class="text-warning">Employee</span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Column: Document Upload -->
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="modal-section-card">
                            <h6><i class="fa fa-id-card mr-1 text-primary"></i> Document Upload <span class="req">*</span></h6>
                            <div id="modalDocContainer">
                                <!-- Populated dynamically when modal opens -->
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Competency Certificates -->
                    <div class="col-md-6">
                        <div class="modal-section-card">
                            <h6><i class="fa fa-certificate mr-1 text-warning"></i> Competency Certificate(s)</h6>
                            <div id="modalCertContainer">
                                <!-- Populated dynamically when modal opens -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary px-4" data-dismiss="modal">
                    <i class="fa fa-check mr-1"></i> Save & Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var rowIndex = <?php echo count($empList); ?>;
        var currentActiveRowIdx = null;

        function initSelect2(container) {
            container.find('.select2').each(function () {
                $(this).select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: $(this).find('option:first').text() || 'Select'
                });
            });
        }
        initSelect2($('#empTable'));

        function initDatepicker() {
            $('.singledaterangepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: false,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            }).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
                $(this).valid && $(this).valid();
            });

            // Date of Birth picker: with Month & Year dropdowns, maxDate today, and wide year selection
            $('.emp-dob-picker').each(function () {
                if ($(this).data('daterangepicker')) {
                    $(this).data('daterangepicker').remove();
                }
                $(this).daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    maxDate: moment(),
                    minYear: 1940,
                    maxYear: parseInt(moment().format('YYYY'), 10),
                    locale: {
                        format: 'DD-MM-YYYY'
                    }
                }).on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('DD-MM-YYYY'));
                    $(this).valid && $(this).valid();
                });
            });
        }
        initDatepicker();

        $(document).on('change', '.id-type-select', function () {
            var val = $(this).val();
            var row = $(this).closest('tr');
            var input = row.find('.id-number-input');
            if (val === 'Passport No') {
                input.attr('placeholder', 'Enter Passport No');
            } else {
                input.attr('placeholder', 'Enter NRIC No');
            }
        });

        $(document).on('change', '.nationality-select', function () {
            var selectedOption = $(this).find('option:selected');
            var natName = (selectedOption.attr('data-name') || selectedOption.text() || '').trim().toLowerCase();
            var otherContainer = $(this).closest('td').find('.other-nat-container');
            if (natName === 'other' || natName === 'others') {
                otherContainer.show();
                otherContainer.find('input').rules('add', {
                    required: true,
                    messages: { required: "Please specify nationality" }
                });
            } else {
                otherContainer.hide();
                otherContainer.find('input').rules('remove', 'required');
                otherContainer.find('input').val('');
            }
        });

        // --- MODAL POPUP LOGIC ---
        function returnInputsToRow() {
            if (currentActiveRowIdx !== null) {
                var storage = $('.row-doc-storage[data-row-idx="' + currentActiveRowIdx + '"]');
                if (storage.length) {
                    $('#modalDocContainer > *').appendTo(storage.find('.storage-docs'));
                    $('#modalCertContainer > *').appendTo(storage.find('.storage-certs'));
                    updateRowUploadBadge(currentActiveRowIdx);
                }
                currentActiveRowIdx = null;
            }
        }

        function updateRowUploadBadge(rowIdx) {
            var row = $('tr.emp-row[data-index="' + rowIdx + '"]');
            var storage = $('.row-doc-storage[data-row-idx="' + rowIdx + '"]');
            var filesCount = 0;

            storage.find('input[type="file"]').each(function () {
                if (this.files && this.files.length > 0) {
                    filesCount += this.files.length;
                }
            });

            var hasExisting = storage.find('.file-link-existing').length > 0;
            var btn = row.find('.btn-upload-modal');
            var badgeText = row.find('.upload-badge-text');

            if (filesCount > 0) {
                btn.addClass('has-files');
                btn.html('<i class="fa fa-check-circle"></i> Upload (' + filesCount + ' new)');
                badgeText.removeClass('text-muted text-danger').addClass('text-success font-weight-bold').text(filesCount + ' new file(s) chosen');
            } else if (hasExisting) {
                btn.addClass('has-files');
                btn.html('<i class="fa fa-check-circle"></i> Upload');
                badgeText.removeClass('text-muted text-danger').addClass('text-success font-weight-bold').text('Files uploaded');
            } else {
                btn.removeClass('has-files');
                btn.html('<i class="fa fa-upload"></i> Upload');
                badgeText.removeClass('text-success font-weight-bold').addClass('text-muted').text('No files');
            }
        }

        // Open Modal handler
        $(document).on('click', '.open-doc-modal-btn', function () {
            returnInputsToRow();

            var rowIdx = $(this).attr('data-row-idx');
            var row = $('tr.emp-row[data-index="' + rowIdx + '"]');
            var empName = row.find('.emp-name').val().trim();
            var rowNum = row.find('.row-num').text().trim();
            var label = empName ? empName + ' (Employee #' + rowNum + ')' : 'Employee #' + rowNum;

            $('#modalEmployeeLabel').text(label);
            currentActiveRowIdx = rowIdx;

            var storage = $('.row-doc-storage[data-row-idx="' + rowIdx + '"]');
            storage.find('.storage-docs > *').appendTo('#modalDocContainer');
            storage.find('.storage-certs > *').appendTo('#modalCertContainer');

            $('#docUploadModal').modal('show');
        });

        // When modal hides, return inputs
        $('#docUploadModal').on('hide.bs.modal', function () {
            returnInputsToRow();
        });

        // + Icon click handler for "Others" in modal
        $(document).on('click', '.add-others-doc-btn', function () {
            var container = $(this).closest('.others-doc-container');
            var empIdx = container.attr('data-emp-idx');
            var itemHtml = '<div class="multi-file-item mt-1">' +
                           '  <input type="file" name="others_' + empIdx + '[]" class="form-control-file file-input-sm">' +
                           '  <i class="fa fa-minus-circle text-danger btn-icon-sub remove-multi-file-btn" title="Remove this file"></i>' +
                           '</div>';
            container.append(itemHtml);
        });

        // + Icon click handler for "Other Document" in modal
        $(document).on('click', '.add-cert-other-btn', function () {
            var container = $(this).closest('.cert-other-container');
            var empIdx = container.attr('data-emp-idx');
            var itemHtml = '<div class="multi-file-item mt-1">' +
                           '  <input type="file" name="cert_other_' + empIdx + '[]" class="form-control-file file-input-sm">' +
                           '  <i class="fa fa-minus-circle text-danger btn-icon-sub remove-multi-file-btn" title="Remove this certificate"></i>' +
                           '</div>';
            container.append(itemHtml);
        });

        $(document).on('click', '.remove-multi-file-btn', function () {
            $(this).closest('.multi-file-item').remove();
        });

        // Click handler to remove an existing file pill
        $(document).on('click', '.remove-existing-file-btn', function () {
            $(this).closest('.existing-file-pill').fadeOut(200, function () {
                $(this).remove();
            });
        });

        function addNewRow() {
            returnInputsToRow();

            var idx = rowIndex;
            rowIndex++;

            var firstRow = $('#empTableBody tr:first');
            firstRow.find('.select2').each(function () {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }
            });

            var newRow = firstRow.clone();
            initSelect2(firstRow);

            newRow.attr('data-index', idx);
            newRow.find('.row-num').text(idx + 1);
            newRow.find('.remove-row-btn').show();

            // Clear values and hidden emp_auto_id for new row
            newRow.find('input[name*="emp_auto_id"]').val('');
            newRow.find('input[type="text"], input[type="email"], input[type="file"]').val('');
            newRow.find('.select2-container').remove();

            // Setup modal trigger button & storage for new row
            newRow.find('.open-doc-modal-btn').attr('data-row-idx', idx).removeClass('has-files').html('<i class="fa fa-upload"></i> Upload');
            newRow.find('.upload-badge-text').removeClass('text-success font-weight-bold').addClass('text-muted').text('No files');

            var storage = newRow.find('.row-doc-storage');
            storage.attr('data-row-idx', idx);
            storage.find('.file-link-existing').remove();
            storage.find('.existing-files-group').remove();

            // Reset dynamic file upload containers
            storage.find('.others-doc-container').attr('data-emp-idx', idx).html(
                '<div class="multi-file-item">' +
                '  <input type="file" name="others_' + idx + '[]" class="form-control-file file-input-sm">' +
                '  <i class="fa fa-plus-circle text-success btn-icon-sub add-others-doc-btn" title="Add another file"></i>' +
                '</div>'
            );
            storage.find('.cert-other-container').attr('data-emp-idx', idx).html(
                '<div class="multi-file-item">' +
                '  <input type="file" name="cert_other_' + idx + '[]" class="form-control-file file-input-sm">' +
                '  <i class="fa fa-plus-circle text-success btn-icon-sub add-cert-other-btn" title="Add another certificate"></i>' +
                '</div>'
            );

            // Re-name basic fields & files
            newRow.find('[name]').each(function () {
                var name = $(this).attr('name');
                if (name) {
                    name = name.replace(/emp\[\d+\]/, 'emp[' + idx + ']');
                    name = name.replace(/passport_ic_\d+/, 'passport_ic_' + idx);
                    name = name.replace(/photo_\d+/, 'photo_' + idx);
                    name = name.replace(/work_permit_\d+/, 'work_permit_' + idx);
                    name = name.replace(/cert_forklift_\d+/, 'cert_forklift_' + idx);
                    name = name.replace(/cert_crane_\d+/, 'cert_crane_' + idx);
                    name = name.replace(/cert_agtes_\d+/, 'cert_agtes_' + idx);
                    name = name.replace(/cert_aesp_\d+/, 'cert_aesp_' + idx);
                    name = name.replace(/cert_scaffolder_\d+/, 'cert_scaffolder_' + idx);
                    $(this).attr('name', name);
                }
            });

            // For newly added rows in edit, required docs must be selected if no existing file
            storage.find('.passport-file, .photo-file, .workpermit-file').attr('required', 'required');

            // Defaults
            newRow.find('.id-type-select').val('NRIC');
            newRow.find('.id-number-input').attr('placeholder', 'Enter NRIC No');
            newRow.find('.nationality-select').val('');
            newRow.find('.terminals-select').val('');
            newRow.find('.other-nat-container').hide().find('input').val('');
            newRow.find('.emp-dob-picker').val('');

            $('#empTableBody').append(newRow);

            initSelect2(newRow);
            initDatepicker();
            applyValidationRules();
            updateRowNumbers();
        }

        $(document).on('click', '.add-row-action-btn', function () {
            addNewRow();
        });

        $(document).on('click', '.remove-row-btn', function () {
            if ($('#empTableBody tr').length > 1) {
                var row = $(this).closest('tr');
                var rIdx = row.attr('data-index');
                if (currentActiveRowIdx === rIdx) {
                    $('#docUploadModal').modal('hide');
                }
                row.remove();
                updateRowNumbers();
            }
        });

        function updateRowNumbers() {
            var count = $('#empTableBody tr').length;
            $('#empTableBody tr').each(function (i) {
                $(this).find('.row-num').text(i + 1);
                if (count > 1) {
                    $(this).find('.remove-row-btn').show();
                } else {
                    $(this).find('.remove-row-btn').hide();
                }
            });
        }

        $("#empForm").validate({
            ignore: [],
            errorElement: "span",
            errorClass: "error",
            errorPlacement: function (error, element) {
                if (element.attr('checkSelect') === 'select2') {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.is(':checkbox')) {
                    error.insertAfter(element.closest('.form-check'));
                } else if (element.hasClass('passport-file') || element.hasClass('photo-file') || element.hasClass('workpermit-file')) {
                    var rowIdx = element.closest('.row-doc-storage').attr('data-row-idx');
                    if (rowIdx !== undefined) {
                        var row = $('tr.emp-row[data-index="' + rowIdx + '"]');
                        var badge = row.find('.upload-badge-text');
                        badge.removeClass('text-muted text-success').addClass('text-danger font-weight-bold').text('Required docs missing!');
                    }
                    error.insertAfter(element);
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
                if ($(element).hasClass('passport-file') || $(element).hasClass('photo-file') || $(element).hasClass('workpermit-file')) {
                    var rowIdx = $(element).closest('.row-doc-storage').attr('data-row-idx');
                    if (rowIdx !== undefined) {
                        $('tr.emp-row[data-index="' + rowIdx + '"]').find('.btn-upload-modal').addClass('border-danger');
                    }
                }
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#common_payment').rules('add', { required: true, messages: { required: "Payment is required" } });
        $('#common_validity').rules('add', { required: true, messages: { required: "Validity date is required" } });

        function applyValidationRules() {
            $('.emp-name').each(function () {
                $(this).rules('add', { required: true, messages: { required: "Employee Name is required" } });
            });
            $('.emp-email').each(function () {
                $(this).rules('add', { required: true, email: true, messages: { required: "Email ID is required", email: "Enter valid Email ID" } });
            });
            $('.emp-phone').each(function () {
                $(this).rules('add', { required: true, messages: { required: "Phone No is required" } });
            });
            $('.id-number-input').each(function () {
                $(this).rules('add', { required: true, messages: { required: "NRIC/Passport No is required" } });
            });
            $('.emp-desig').each(function () {
                $(this).rules('add', { required: true, messages: { required: "Designation is required" } });
            });
            $('.nationality-select').each(function () {
                $(this).rules('add', { required: true, messages: { required: "Nationality is required" } });
            });
            $('.terminals-select').each(function () {
                $(this).rules('add', { required: true, messages: { required: "Please select Terminal" } });
            });
        }

        applyValidationRules();

        $(document).on('change', '.select2', function () {
            $(this).valid && $(this).valid();
        });

        $('#empForm').on('submit', function () {
            returnInputsToRow();
        });
    });
</script>