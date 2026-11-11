<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($site_title) ? $site_title : 'Visitor HSE Induction Registration - Lumut Port'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700,800&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>fontawesome-free/css/all.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style (AdminLTE + Bootstrap 4) -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH_CSS; ?>adminlte.min.css">
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH_CSS; ?>kabbani_styles.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Source Sans Pro', sans-serif;
            color: #212529;
            min-height: 100vh;
        }
        .public-top-nav {
            background-color: #161D26;
            color: #ffffff;
            padding: 14px 24px;
            border-bottom: 4px solid #FEC001;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .public-top-nav img {
            height: 42px;
            background: #ffffff;
            padding: 4px 10px;
            border-radius: 6px;
        }
        .nav-brand-title {
            color: #FEC001;
            font-weight: 800;
            font-size: 1.15rem;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .nav-brand-subtitle {
            color: #cbd5e1;
            font-size: 0.8rem;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .main-reg-container {
            max-width: 960px;
            margin: 30px auto;
            padding: 0 15px 40px 15px;
        }
        .card-headprimary {
            border-top: 4px solid #FEC001;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            background: #ffffff;
        }
        .headingStyl {
            padding: 18px 22px 14px 22px;
            border-bottom: 1px solid #edf2f7;
        }
        .headingStyl h4 {
            color: #161D26;
            font-weight: 800;
            margin: 0;
            font-size: 1.3rem;
        }
        .with-border {
            background-color: #161D26;
            color: #ffffff;
            padding: 10px 16px;
            border-radius: 4px;
            margin-bottom: 18px;
            margin-top: 15px;
        }
        .with-border h5 {
            margin: 0;
            font-weight: 700;
            font-size: 0.98rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .form-group label {
            font-weight: 700;
            color: #334155;
            font-size: 0.88rem;
            margin-bottom: 5px;
        }
        .form-group label .req {
            color: #dc3545;
            font-weight: 800;
            margin-left: 2px;
        }
        .form-control {
            height: calc(2.25rem + 4px);
            font-size: 0.92rem;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        }
        textarea.form-control {
            height: auto;
        }
        .pdpa-card {
            background-color: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 6px;
            padding: 16px 20px;
            margin: 20px 0 25px 0;
        }
        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.25rem + 4px) !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            line-height: calc(2.25rem + 2px) !important;
            font-size: 0.92rem;
        }

        /* Frontend Validation Error Styles */
        label.error, span.error {
            color: #dc3545 !important;
            font-size: 0.84rem !important;
            font-weight: 600 !important;
            margin-top: 4px;
            display: block;
        }
        .form-control.is-invalid, .form-control.error {
            border-color: #dc3545 !important;
            background-color: #fff8f8;
        }
        .select2-container .select2-selection.border-danger {
            border: 1px solid #dc3545 !important;
        }
    </style>
</head>
<body>

<!-- Header Navigation Bar Matching Other Modules -->
<div class="public-top-nav d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <img src="<?php echo BASE_URL . 'assets/images/modules/company_logo/LOGO-LUMUT-PORTju.png'; ?>" alt="Lumut Port Logo">
        <div class="ml-3 d-none d-sm-block">
            <h4 class="nav-brand-title">LUMUT MARITIME TERMINAL</h4>
            <p class="nav-brand-subtitle">HSSE DEPARTMENT &bull; VISITOR SAFETY CLEARANCE SYSTEM</p>
        </div>
    </div>
    <div>
        <a href="<?php echo BASE_URL; ?>login" class="btn btn-sm btn-outline-light font-weight-bold">
            <i class="fas fa-sign-in-alt mr-1"></i> Staff Login
        </a>
    </div>
</div>

<div class="main-reg-container">

    <!-- Error/Notice Flash Messages -->
    <?php $errorMsg = $this->session->flashdata('error_msg'); ?>
    <?php if (!empty($errorMsg)) { ?>
        <div class="alert alert-danger shadow-sm mb-4">
            <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $errorMsg; ?>
        </div>
    <?php } ?>

    <!-- Main Registration Card (Matches Other Modules Card Pattern) -->
    <div class="card card-headprimary">
        <div class="headingStyl d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="fas fa-user-plus text-primary mr-2"></i>Visitor Registration Form</h4>
                <small class="text-muted">Please fill in all mandatory information to request visitor port access clearance.</small>
            </div>
            <div>
                <span class="badge badge-warning px-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
                    <i class="fas fa-shield-alt mr-1"></i> HSE Induction Mandatory
                </span>
            </div>
        </div>

        <div class="card-body p-4">
            <?php echo form_open('hse_induction/visitor_registration/save', ['id' => 'formVisitorReg', 'class' => 'needs-validation', 'novalidate' => 'novalidate']); ?>

            <!-- SECTION 1: VISITOR INFORMATION -->
            <div class="box-header with-border">
                <h5><i class="fas fa-user-circle mr-2 text-warning"></i>1. Visitor Particulars</h5>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company Name <span class="req">*</span></label>
                        <input type="text" name="COMPANY_NAME" id="COMPANY_NAME" class="form-control" placeholder="Enter Company Name" required maxlength="255" value="<?php echo set_value('COMPANY_NAME'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Visitor Full Name <span class="req">*</span></label>
                        <input type="text" name="VISITOR_NAME" id="VISITOR_NAME" class="form-control" placeholder="Full name as per IC / Passport" required maxlength="255" value="<?php echo set_value('VISITOR_NAME'); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>IC / Passport No. <span class="req">*</span></label>
                        <input type="text" name="IC_PASSPORT_NO" id="IC_PASSPORT_NO" class="form-control" placeholder="e.g. 900101-08-5432 or Passport Number" required maxlength="100" value="<?php echo set_value('IC_PASSPORT_NO'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Vehicle Detail <span class="text-muted small font-weight-normal">(Optional)</span></label>
                        <input type="text" name="VEHICLE_DETAIL" id="VEHICLE_DETAIL" class="form-control" placeholder="e.g. Car Plate: AKU 1234 (Toyota)" maxlength="100" value="<?php echo set_value('VEHICLE_DETAIL'); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email ID <span class="req">*</span></label>
                        <input type="email" name="EMAIL_ID" id="EMAIL_ID" class="form-control" placeholder="name@company.com" required maxlength="255" value="<?php echo set_value('EMAIL_ID'); ?>">
                        <small class="form-text text-muted">Assessment invitation link & OTP will be sent to this email.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone No <span class="req">*</span></label>
                        <input type="text" name="PHONE_NO" id="PHONE_NO" class="form-control" placeholder="e.g. +6012-3456789" required maxlength="50" value="<?php echo set_value('PHONE_NO'); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address <span class="req">*</span></label>
                        <textarea name="ADDRESS" id="ADDRESS" class="form-control" rows="2" placeholder="Full residential or company address" required><?php echo set_value('ADDRESS'); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: VISIT DETAILS -->
            <div class="box-header with-border">
                <h5><i class="fas fa-calendar-check mr-2 text-warning"></i>2. Visit Schedule & Terminal Entry</h5>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Visit Start Date & Time <span class="req">*</span></label>
                        <input type="datetime-local" name="VISIT_DATETIME" id="VISIT_DATETIME" class="form-control" required value="<?php echo set_value('VISIT_DATETIME', date('Y-m-d\TH:i', strtotime('+1 hour'))); ?>">
                        <small class="form-text text-muted"><i class="far fa-calendar-check mr-1"></i> Starting date & time of terminal arrival</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Visit End Date & Time (Validity Period) <span class="req">*</span></label>
                        <input type="datetime-local" name="VISIT_DATETIME_END" id="VISIT_DATETIME_END" class="form-control" required value="<?php echo set_value('VISIT_DATETIME_END', date('Y-m-d\TH:i', strtotime('+2 days 18:00'))); ?>">
                        <small class="form-text text-muted"><i class="far fa-calendar-times mr-1"></i> Port Pass & Certificate validity will expire on this date</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Terminal <span class="req">*</span></label>
                        <select name="TERMINAL_ID" id="TERMINAL_ID" class="form-control select2" required style="width: 100%;">
                            <option value="">-- Select Terminal --</option>
                            <?php if (!empty($terminals)) { ?>
                                <?php foreach ($terminals as $t) { ?>
                                    <option value="<?php echo $t->TER_AUTO_ID; ?>" <?php echo set_select('TERMINAL_ID', $t->TER_AUTO_ID); ?>>
                                        <?php echo htmlspecialchars($t->TERMINAL_NAME); ?> <?php echo !empty($t->TERMINAL_SHORTNAME) ? '(' . htmlspecialchars($t->TERMINAL_SHORTNAME) . ')' : ''; ?>
                                    </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Person of contact (from LMTSB) <span class="req">*</span></label>
                        <select name="CONTACT_PERSON_ID" id="CONTACT_PERSON_ID" class="form-control select2" required style="width: 100%;">
                            <option value="">-- Select LMTSB Person of Contact (Host) --</option>
                            <?php if (!empty($employees)) { ?>
                                <?php foreach ($employees as $e) { ?>
                                    <option value="<?php echo $e->EMP_AUTO_ID; ?>" <?php echo set_select('CONTACT_PERSON_ID', $e->EMP_AUTO_ID); ?>>
                                        <?php echo htmlspecialchars($e->EMP_NAME); ?> (<?php echo htmlspecialchars($e->EMP_ID); ?>) - <?php echo !empty($e->dept_name) ? htmlspecialchars($e->dept_name) : 'LMTSB'; ?>
                                    </option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <small class="form-text text-muted">Select the Lumut Maritime Terminal employee or department host you are visiting.</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Visit Purpose <span class="req">*</span></label>
                        <textarea name="VISIT_PURPOSE" id="VISIT_PURPOSE" class="form-control" rows="2" placeholder="Describe the purpose of your visit (e.g. Official meeting, site inspection, cargo audit)" required><?php echo set_value('VISIT_PURPOSE'); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: PDPA CONSENT -->
            <div class="box-header with-border">
                <h5><i class="fas fa-user-shield mr-2 text-warning"></i>3. Personal Data Protection Policy & Consent</h5>
            </div>

            <div class="pdpa-card">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkPDPA" name="PDPA_AGREED" value="Y" required <?php echo set_checkbox('PDPA_AGREED', 'Y', true); ?>>
                    <label class="custom-control-label" for="checkPDPA" style="cursor: pointer; font-size: 0.92rem; line-height: 1.5; font-weight: 600;">
                        I hereby confirm and acknowledge that I have read, understood, and agree to the 
                        <a href="https://lumutport.com/personal-data-protection-policy/" target="_blank" class="text-primary font-weight-bold text-underline">
                            Personal Data Protection Act (PDPA) Policy <i class="fas fa-external-link-alt small ml-1"></i>
                        </a> 
                        of Lumut Maritime Terminal Sdn Bhd. I consent to the processing of my personal details for terminal security, safety clearance, and HSE audit compliance. <span class="req">*</span>
                    </label>
                </div>
            </div>

            <!-- SUBMIT BUTTON (Simple standard submit button, no telegram plane icon) -->
            <div class="text-center pt-3 pb-2">
                <button type="submit" id="btnSubmitReg" class="btn btn-primary font-weight-bold px-4 py-2" style="min-width: 130px; font-size: 1rem;">
                    Submit
                </button>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>

    <div class="text-center mt-4 text-muted small">
        &copy; <?php echo date('Y'); ?> Lumut Maritime Terminal Sdn Bhd. All rights reserved. &bull; HSSE Department
    </div>

</div>

<!-- Scripts -->
<script src="<?php echo LAYOUT_PLUG_PATH; ?>jquery/jquery.min.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>select2/js/select2.full.min.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH_JS; ?>adminlte.min.js"></script>
<script src="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 dropdowns
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    // Clear Select2 validation error on change
    $('.select2').on('change', function() {
        $(this).valid();
    });

    // Custom Validator: Visit End >= Visit Start
    $.validator.addMethod("greaterThanStart", function(value, element) {
        var startVal = $('#VISIT_DATETIME').val();
        if (!startVal || !value) return true;
        return new Date(value) >= new Date(startVal);
    }, "Visit End Date & Time must be equal to or after Start Date & Time");

    // jQuery Validate for Visitor Registration Form
    $('#formVisitorReg').validate({
        rules: {
            COMPANY_NAME: {
                required: true,
                minlength: 2
            },
            VISITOR_NAME: {
                required: true,
                minlength: 2
            },
            IC_PASSPORT_NO: {
                required: true,
                minlength: 3
            },
            EMAIL_ID: {
                required: true,
                email: true
            },
            PHONE_NO: {
                required: true,
                minlength: 7
            },
            ADDRESS: {
                required: true,
                minlength: 5
            },
            VISIT_DATETIME: {
                required: true
            },
            VISIT_DATETIME_END: {
                required: true,
                greaterThanStart: true
            },
            TERMINAL_ID: {
                required: true
            },
            CONTACT_PERSON_ID: {
                required: true
            },
            VISIT_PURPOSE: {
                required: true,
                minlength: 4
            },
            PDPA_AGREED: {
                required: true
            }
        },
        messages: {
            COMPANY_NAME: {
                required: "Company Name is required",
                minlength: "Company Name must be at least 2 characters"
            },
            VISITOR_NAME: {
                required: "Visitor Full Name is required",
                minlength: "Visitor Name must be at least 2 characters"
            },
            IC_PASSPORT_NO: {
                required: "IC / Passport No. is required",
                minlength: "Please enter a valid IC / Passport Number"
            },
            EMAIL_ID: {
                required: "Email ID is required",
                email: "Please enter a valid email address (e.g. name@company.com)"
            },
            PHONE_NO: {
                required: "Phone No is required",
                minlength: "Please enter a valid phone number"
            },
            ADDRESS: {
                required: "Address is required",
                minlength: "Address must be at least 5 characters"
            },
            VISIT_DATETIME: {
                required: "Visit Start Date & Time is required"
            },
            VISIT_DATETIME_END: {
                required: "Visit End Date & Time is required",
                greaterThanStart: "Visit End Date & Time must be equal to or after Start Date & Time"
            },
            TERMINAL_ID: {
                required: "Please select a Terminal"
            },
            CONTACT_PERSON_ID: {
                required: "Please select Person of Contact (from LMTSB)"
            },
            VISIT_PURPOSE: {
                required: "Visit Purpose is required",
                minlength: "Visit Purpose must be at least 4 characters"
            },
            PDPA_AGREED: {
                required: "Please accept the Personal Data Protection Policy to proceed"
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('text-danger small font-weight-bold mt-1');
            if (element.hasClass('select2-hidden-accessible')) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.attr('type') === 'checkbox') {
                error.insertAfter(element.closest('.custom-control'));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid error');
            if ($(element).hasClass('select2-hidden-accessible')) {
                $(element).next('.select2-container').find('.select2-selection').addClass('border-danger');
            }
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid error');
            if ($(element).hasClass('select2-hidden-accessible')) {
                $(element).next('.select2-container').find('.select2-selection').removeClass('border-danger');
            }
        },
        invalidHandler: function(event, validator) {
            // Smooth scroll to the first invalid field
            if (validator.errorList.length) {
                var firstErrorElem = $(validator.errorList[0].element);
                $('html, body').animate({
                    scrollTop: firstErrorElem.offset().top - 120
                }, 400);
            }
        }
    });
});
</script>

</body>
</html>
