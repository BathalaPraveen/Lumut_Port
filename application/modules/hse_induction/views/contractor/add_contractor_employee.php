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
                            <h4>Add Contractor Employee</h4>
                            <a href="<?php echo BASE_URL('hse_induction/contractor_employees/' . encryptval($contractor_id)); ?>"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-arrow-left"></i> Back</button></a>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php echo form_open_multipart('hse_induction/save_contractor_employee/' . encryptval($contractor_id), array('id' => 'empForm', 'novalidate' => 'novalidate')); ?>

                        <!-- 1. Top Section: Company Details & Common Batch, Payment, Validity -->
                        <div class="company-banner">
                            <!-- Company Details -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Company Name:</label>
                                    <div class="form-control-plaintext font-weight-bold" style="font-size:16px;">
                                        <?php echo htmlspecialchars($contractor->CONT_COMPANY); ?>
                                    </div>
                                    <input type="hidden" name="company_name" value="<?php echo htmlspecialchars($contractor->CONT_COMPANY); ?>">
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

                            <!-- Common BATCH, Payment, Validity (Batch level fields) -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>BATCH <span class="req">*</span></label>
                                        <input type="text" name="common_batch_no" id="common_batch_no" class="form-control" value="<?php echo htmlspecialchars($next_batch); ?>" readonly required>
                                    </div>
                                </div>
                                <!-- Payment and Validity commented out as requested
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Payment <span class="req">*</span></label>
                                        <input type="text" name="common_payment" id="common_payment" class="form-control" placeholder="Enter Payment details">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Validity <span class="req">*</span></label>
                                        <input type="text" name="common_validity" id="common_validity" class="form-control singledaterangepicker" placeholder="DD-MM-YYYY" autocomplete="off">
                                    </div>
                                </div>
                                -->
                                <input type="hidden" name="common_payment" id="common_payment" value="-">
                                <input type="hidden" name="common_validity" id="common_validity" value="">
                            </div>
                        </div>

                        <!-- 2. Employee Details Table (Add More rows) -->
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
                                    <!-- Row 0 -->
                                    <tr class="emp-row" data-index="0">
                                        <td class="text-center font-weight-bold row-num">1</td>

                                        <!-- Employee Name -->
                                        <td>
                                            <input type="text" name="emp[0][emp_name]" class="form-control emp-name" placeholder="Enter Full Name" required>
                                        </td>

                                        <!-- Email ID -->
                                        <td>
                                            <input type="email" name="emp[0][email]" class="form-control emp-email" placeholder="Enter Email ID" required>
                                        </td>

                                        <!-- Phone No -->
                                        <td>
                                            <input type="text" name="emp[0][phone]" class="form-control emp-phone" placeholder="Enter Phone No" required>
                                        </td>

                                        <!-- ID Type -->
                                        <td>
                                            <select name="emp[0][id_type]" class="form-control select2 id-type-select" checkSelect="select2" style="width:100%;" required>
                                                <option value="NRIC">NRIC</option>
                                                <option value="Passport No">Passport No</option>
                                            </select>
                                        </td>

                                        <!-- NRIC / Passport No -->
                                        <td>
                                            <input type="text" name="emp[0][id_number]" class="form-control id-number-input" placeholder="Enter NRIC No" required>
                                        </td>

                                        <!-- Gender -->
                                        <td>
                                            <select name="emp[0][gender]" class="form-control select2" checkSelect="select2" style="width:100%;" required>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </td>

                                        <!-- Date of Birth -->
                                        <td>
                                            <input type="text" name="emp[0][dob]" class="form-control emp-dob-picker" placeholder="DD-MM-YYYY" autocomplete="off" required>
                                        </td>

                                        <!-- Designation -->
                                        <td>
                                            <input type="text" name="emp[0][designation]" class="form-control emp-desig" placeholder="Enter Designation" required>
                                        </td>

                                        <!-- Nationality -->
                                        <td>
                                            <select name="emp[0][nationality]" class="form-control select2 nationality-select" checkSelect="select2" style="width:100%;" required>
                                                <option value="">Select Nationality</option>
                                                <?php foreach ($nationalities as $nat): ?>
                                                    <option value="<?php echo $nat->NATIONALITY_ID; ?>" data-name="<?php echo strtolower($nat->NATIONALITY_NAME); ?>"><?php echo htmlspecialchars($nat->NATIONALITY_NAME); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="other-nat-container mt-1" style="display:none;">
                                                <input type="text" name="emp[0][nationality_other]" class="form-control" placeholder="Specify Nationality">
                                            </div>
                                        </td>

                                        <!-- Religion -->
                                        <td>
                                            <input type="text" name="emp[0][religion]" class="form-control" placeholder="Enter Religion" required>
                                        </td>

                                        <!-- Race -->
                                        <td>
                                            <input type="text" name="emp[0][race]" class="form-control" placeholder="Enter Race" required>
                                        </td>

                                        <!-- Marital Status -->
                                        <td>
                                            <select name="emp[0][marital_status]" class="form-control select2" checkSelect="select2" style="width:100%;" required>
                                                <option value="1">Single</option>
                                                <option value="2">Married</option>
                                                <option value="3">Divorced</option>
                                            </select>
                                        </td>

                                        <!-- Work Experience -->
                                        <td>
                                            <input type="number" step="0.5" min="0" name="emp[0][work_experience]" class="form-control" placeholder="e.g. 3" required>
                                        </td>

                                        <!-- Emergency Contact Name -->
                                        <td>
                                            <input type="text" name="emp[0][emergency_name]" class="form-control" placeholder="Contact Person" required>
                                        </td>

                                        <!-- Emergency Relationship -->
                                        <td>
                                            <input type="text" name="emp[0][emergency_relationship]" class="form-control" placeholder="e.g. Spouse, Father" required>
                                        </td>

                                        <!-- Emergency Phone No -->
                                        <td>
                                            <input type="text" name="emp[0][emergency_phone]" class="form-control" placeholder="Emergency Phone" required>
                                        </td>

                                        <!-- Emergency Address -->
                                        <td>
                                            <input type="text" name="emp[0][emergency_address]" class="form-control" placeholder="Emergency Address" required>
                                        </td>

                                        <!-- Terminal (Single Select Dropdown) -->
                                        <td>
                                            <select name="emp[0][terminals]" class="form-control select2 terminals-select" checkSelect="select2" style="width:100%;" required>
                                                <option value="">Select Terminal</option>
                                                <?php foreach ($terminals as $term): ?>
                                                    <option value="<?php echo htmlspecialchars($term->TERMINAL_NAME); ?>"><?php echo htmlspecialchars($term->TERMINAL_NAME); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>

                                        <!-- Upload Documents & Certificates (Modal Trigger) -->
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-upload-modal open-doc-modal-btn" data-row-idx="0">
                                                <i class="fa fa-upload"></i> Upload
                                            </button>
                                            <div class="upload-status-badge text-muted">
                                                <span class="upload-badge-text">No files</span>
                                            </div>

                                            <!-- Hidden container holding this row's file inputs -->
                                            <div class="row-doc-storage" data-row-idx="0" style="display:none;">
                                                <div class="storage-docs">
                                                    <div class="doc-field-item">
                                                        <label>Passport / IC <span class="req">*</span></label>
                                                        <input type="file" name="passport_ic_0" class="form-control-file file-input-sm passport-file" required>
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Photo <span class="req">*</span></label>
                                                        <input type="file" name="photo_0" class="form-control-file file-input-sm photo-file" required>
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Work Permit <span class="req">*</span></label>
                                                        <input type="file" name="work_permit_0" class="form-control-file file-input-sm workpermit-file" required>
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Others (Driving License / Medical Exam)</label>
                                                        <div class="others-doc-container" data-emp-idx="0">
                                                            <div class="multi-file-item">
                                                                <input type="file" name="others_0[]" class="form-control-file file-input-sm">
                                                                <i class="fa fa-plus-circle text-success btn-icon-sub add-others-doc-btn" title="Add another file"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="storage-certs">
                                                    <div class="doc-field-item">
                                                        <label>Forklift</label>
                                                        <input type="file" name="cert_forklift_0" class="form-control-file file-input-sm">
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Crane Operator</label>
                                                        <input type="file" name="cert_crane_0" class="form-control-file file-input-sm">
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>AGTES</label>
                                                        <input type="file" name="cert_agtes_0" class="form-control-file file-input-sm">
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>AESP</label>
                                                        <input type="file" name="cert_aesp_0" class="form-control-file file-input-sm">
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Scaffolder</label>
                                                        <input type="file" name="cert_scaffolder_0" class="form-control-file file-input-sm">
                                                    </div>
                                                    <div class="doc-field-item">
                                                        <label>Other Document</label>
                                                        <div class="cert-other-container" data-emp-idx="0">
                                                            <div class="multi-file-item">
                                                                <input type="file" name="cert_other_0[]" class="form-control-file file-input-sm">
                                                                <i class="fa fa-plus-circle text-success btn-icon-sub add-cert-other-btn" title="Add another certificate"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Action Column: + Add More & Delete -->
                                        <td class="text-center align-middle">
                                            <div class="action-btn-group">
                                                <button type="button" class="btn btn-primary btn-sm add-row-action-btn" title="Add More Employee">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-delete-custom btn-sm remove-row-btn" style="display:none;" title="Remove this employee">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Acknowledgment -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="p-2" style="background:#fff3cd; border:1px solid #ffeeba; border-radius:4px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="ack_status" value="Y" id="ackStatus" required checked>
                                        <label class="form-check-label font-weight-bold text-dark" for="ackStatus">
                                            The PIC acknowledges that all documents and information provided are accurate and correct. <span class="req">*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
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
                    <i class="fa fa-upload mr-1"></i> Upload Documents & Certificates - <span id="modalEmployeeLabel" class="text-warning">Employee #1</span>
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
        var rowIndex = 1;
        var currentActiveRowIdx = null;

        // Initialize Select2 on target container
        function initSelect2(context) {
            context.find('.select2').each(function () {
                $(this).select2({
                    width: '100%',
                    placeholder: $(this).find('option:first').text()
                });
            });
        }
        initSelect2($(document));

        // Initialize Datepicker
        function initDatepicker() {
            // General date pickers (like common validity)
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

        // ID Type change handler
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

        // Nationality change handler
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

            var btn = row.find('.btn-upload-modal');
            var badgeText = row.find('.upload-badge-text');

            if (filesCount > 0) {
                btn.addClass('has-files');
                btn.html('<i class="fa fa-check-circle"></i> Upload (' + filesCount + ')');
                badgeText.removeClass('text-muted text-danger').addClass('text-success font-weight-bold').text(filesCount + ' file(s) selected');
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

        // - Icon click handler to remove a single dynamically added file input
        $(document).on('click', '.remove-multi-file-btn', function () {
            $(this).closest('.multi-file-item').remove();
        });

        // Add More Row Function triggered from Action column (+)
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

            // Clear inputs and remove cloned select2 DOM
            newRow.find('input[type="text"], input[type="email"], input[type="file"]').val('');
            newRow.find('.select2-container').remove();

            // Update modal trigger button & storage container for new index
            newRow.find('.open-doc-modal-btn').attr('data-row-idx', idx).removeClass('has-files').html('<i class="fa fa-upload"></i> Upload');
            newRow.find('.upload-badge-text').removeClass('text-success font-weight-bold').addClass('text-muted').text('No files');

            var storage = newRow.find('.row-doc-storage');
            storage.attr('data-row-idx', idx);

            // Reset dynamic file upload containers to only 1 input with plus icon
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

        // Remove row
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

        // jQuery Validate
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
                    // Place error inside modal or under upload button
                    var rowIdx = element.closest('.row-doc-storage').attr('data-row-idx');
                    if (rowIdx !== undefined) {
                        var row = $('tr.emp-row[data-index="' + rowIdx + '"]');
                        var badge = row.find('.upload-badge-text');
                        badge.removeClass('text-muted text-success').addClass('text-danger font-weight-bold').text('Required documents missing!');
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

        // Common top fields rules
        // Payment & Validity are hidden, so do not require validation
        // $('#common_payment').rules('add', { required: true, messages: { required: "Payment is required" } });
        // $('#common_validity').rules('add', { required: true, messages: { required: "Validity date is required" } });

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
            $('.passport-file').each(function () {
                $(this).rules('add', { required: true, messages: { required: "Passport/IC is required" } });
            });
            $('.photo-file').each(function () {
                $(this).rules('add', { required: true, messages: { required: "Photo is required" } });
            });
            $('.workpermit-file').each(function () {
                $(this).rules('add', { required: true, messages: { required: "Work Permit is required" } });
            });
        }

        applyValidationRules();

        // Validate select2 on change
        $(document).on('change', '.select2', function () {
            $(this).valid && $(this).valid();
        });

        // Before submit, ensure modal inputs are back in form
        $('#empForm').on('submit', function () {
            returnInputsToRow();
        });
    });
</script>