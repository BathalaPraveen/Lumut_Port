<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>

    /* =========================================
       Main Card
    ========================================= */

    .person-registration-card {
        margin-top: 10px;
    }


    /* =========================================
       Page Header
    ========================================= */

    .person-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .person-page-header h4 {
        margin: 0;
        font-size: 23px;
        font-weight: 400;
    }


    /* =========================================
       Section
    ========================================= */

    .person-section {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 0 15px 20px 15px;
        margin-bottom: 20px;
    }


    /* =========================================
       Section Title
    ========================================= */

    .person-section-title {
        background: #0878b5;
        color: #fff;
        font-size: 18px;
        font-weight: 400;
        padding: 9px 16px;
        margin: 0 -15px 18px -15px;
        border-radius: 3px 3px 0 0;
    }


    /* =========================================
       Form Groups
    ========================================= */

    .person-form-group {
        margin-bottom: 18px;
    }

    .person-form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 7px;
        color: #222;
    }

    .person-form-group .form-control {
        height: 38px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        box-shadow: none;
    }

    .person-form-group textarea.form-control {
        height: auto;
        min-height: 85px;
        resize: vertical;
    }

    .person-form-group .form-control:focus {
        border-color: #80bdff;
        box-shadow: none;
    }


    /* =========================================
       File Input
    ========================================= */

    .person-file-input {
        height: 38px !important;
        padding: 5px 8px;
    }


    /* =========================================
       Required Mark
    ========================================= */

    .required-mark {
        color: red;
        margin-left: 2px;
    }


    /* =========================================
       Validation Error
    ========================================= */

    .field-error {
        display: none;
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
        line-height: 18px;
    }

    .form-control.input-error {
        border-color: #dc3545 !important;
        box-shadow: none !important;
    }

    .form-control.input-success {
        border-color: #28a745 !important;
        box-shadow: none !important;
    }


    /* =========================================
       Buttons
    ========================================= */

    .person-form-buttons {
        text-align: center;
        margin-top: 10px;
    }

    .person-form-buttons .btn {
        margin: 0 2px;
        min-width: 95px;
    }


    /* =========================================
       Alerts
    ========================================= */

    .person-alert {
        margin-bottom: 20px;
    }


    /* =========================================
       Row Spacing
    ========================================= */

    .person-row {
        margin-left: -8px;
        margin-right: -8px;
    }

    .person-row > [class*="col-"] {
        padding-left: 8px;
        padding-right: 8px;
    }


    /* =========================================
       File Help Text
    ========================================= */

    .file-help {
        display: block;
        margin-top: 5px;
        font-size: 12px;
        color: #6c757d;
    }


    /* =========================================
       Responsive
    ========================================= */

    @media (max-width: 767px) {

        .person-page-header {
            display: block;
        }

        .person-page-header .btn {
            margin-top: 10px;
        }

        .person-section {
            padding-left: 10px;
            padding-right: 10px;
        }

        .person-section-title {
            margin-left: -10px;
            margin-right: -10px;
        }

    }

</style>


<div class="wrapper">

    <div class="content-wrapper">

        <section class="content">

            <div class="container-fluid">


                <!-- =========================================
                     Page Header
                ========================================== -->

                <div class="person-page-header">

                    <h4>
                        Person Registration
                    </h4>

                    <a
                        href="<?php echo BASE_URL('face_recognition/Person/scan'); ?>"
                        class="btn btn-primary"
                    >
                        Back
                    </a>

                </div>


                <!-- =========================================
                     Main Card
                ========================================== -->

                <div class="card person-registration-card">

                    <div class="card-body">


                        <!-- =========================================
                             Success Message
                        ========================================== -->

                        <?php if ($this->session->flashdata('success')) { ?>

                            <div class="alert alert-success person-alert">

                                <?php
                                echo $this->session->flashdata('success');
                                ?>

                            </div>

                        <?php } ?>


                        <!-- =========================================
                             Error Message
                        ========================================== -->

                        <?php if ($this->session->flashdata('error')) { ?>

                            <div class="alert alert-danger person-alert">

                                <?php
                                echo $this->session->flashdata('error');
                                ?>

                            </div>

                        <?php } ?>


                        <?php

                        echo form_open_multipart(
                            'face_recognition/Person/store',
                            array(
                                'id' => 'personForm',
                                'class' => 'form-horizontal'
                            )
                        );

                        ?>


                        <!-- =========================================
                             PERSONAL INFORMATION
                        ========================================== -->

                        <div class="person-section">

                            <div class="person-section-title">
                                Personal Information
                            </div>


                            <div class="row person-row">


                                <!-- =================================
                                     Person Code
                                ================================== -->

                                <div class="col-md-4">

                                    <div class="person-form-group">

                                        <label for="person_code">

                                            Person Code

                                            <span class="required-mark">
                                                *
                                            </span>

                                        </label>


                                        <input
                                            type="text"
                                            name="person_code"
                                            id="person_code"
                                            class="form-control"
                                            placeholder="Enter person code"
                                            value="<?php echo set_value('person_code'); ?>"
                                        >


                                        <span
                                            id="person_code_error"
                                            class="field-error"
                                        >
                                            Person Code is required.
                                        </span>

                                    </div>

                                </div>


                                <!-- =================================
                                     Name
                                ================================== -->

                                <div class="col-md-4">

                                    <div class="person-form-group">

                                        <label for="name">

                                            Name

                                            <span class="required-mark">
                                                *
                                            </span>

                                        </label>


                                        <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            class="form-control"
                                            placeholder="Enter name"
                                            value="<?php echo set_value('name'); ?>"
                                        >


                                        <span
                                            id="name_error"
                                            class="field-error"
                                        >
                                            Name is required.
                                        </span>

                                    </div>

                                </div>


                                <!-- =================================
                                     Date of Birth
                                ================================== -->

                                <div class="col-md-4">

                                    <div class="person-form-group">

                                        <label for="date_of_birth">
                                            Date of Birth
                                        </label>


                                        <input
                                            type="date"
                                            name="date_of_birth"
                                            id="date_of_birth"
                                            class="form-control"
                                            value="<?php echo set_value('date_of_birth'); ?>"
                                        >

                                    </div>

                                </div>


                                <!-- =================================
                                     Gender
                                ================================== -->

                                <div class="col-md-4">

                                    <div class="person-form-group">

                                        <label for="gender">
                                            Gender
                                        </label>


                                        <select
                                            name="gender"
                                            id="gender"
                                            class="form-control select2"
                                        >

                                            <option value="">
                                                Select Gender
                                            </option>

                                            <option
                                                value="Male"
                                                <?php echo set_select('gender', 'Male'); ?>
                                            >
                                                Male
                                            </option>

                                            <option
                                                value="Female"
                                                <?php echo set_select('gender', 'Female'); ?>
                                            >
                                                Female
                                            </option>

                                            <option
                                                value="Other"
                                                <?php echo set_select('gender', 'Other'); ?>
                                            >
                                                Other
                                            </option>

                                        </select>

                                    </div>

                                </div>


                                <!-- =================================
                                     Phone
                                ================================== -->

                                <div class="col-md-4">

                                    <div class="person-form-group">

                                        <label for="phone">
                                            Phone
                                        </label>


                                        <input
                                            type="text"
                                            name="phone"
                                            id="phone"
                                            class="form-control"
                                            placeholder="Enter phone number"
                                            value="<?php echo set_value('phone'); ?>"
                                        >

                                    </div>

                                </div>


                                <!-- =================================
                                     Email
                                ================================== -->

                                <div class="col-md-4">

                                    <div class="person-form-group">

                                        <label for="email">
                                            Email
                                        </label>


                                        <input
                                            type="email"
                                            name="email"
                                            id="email"
                                            class="form-control"
                                            placeholder="Enter email"
                                            value="<?php echo set_value('email'); ?>"
                                        >

                                    </div>

                                </div>


                                <!-- =================================
                                     Department
                                ================================== -->

                                <div class="col-md-4">

                                    <div class="person-form-group">

                                        <label for="department">
                                            Department
                                        </label>


                                        <input
                                            type="text"
                                            name="department"
                                            id="department"
                                            class="form-control"
                                            placeholder="Enter department"
                                            value="<?php echo set_value('department'); ?>"
                                        >

                                    </div>

                                </div>


                                <!-- =================================
                                     Designation
                                ================================== -->

                                <div class="col-md-4">

                                    <div class="person-form-group">

                                        <label for="designation">
                                            Designation
                                        </label>


                                        <input
                                            type="text"
                                            name="designation"
                                            id="designation"
                                            class="form-control"
                                            placeholder="Enter designation"
                                            value="<?php echo set_value('designation'); ?>"
                                        >

                                    </div>

                                </div>


                                <!-- =================================
                                     Company
                                ================================== -->

                                <div class="col-md-4">

                                    <div class="person-form-group">

                                        <label for="company">
                                            Company
                                        </label>


                                        <input
                                            type="text"
                                            name="company"
                                            id="company"
                                            class="form-control"
                                            placeholder="Enter company"
                                            value="<?php echo set_value('company'); ?>"
                                        >

                                    </div>

                                </div>


                                <!-- =================================
                                     Address
                                ================================== -->

                                <div class="col-md-12">

                                    <div class="person-form-group mb-0">

                                        <label for="address">
                                            Address
                                        </label>


                                        <textarea
                                            name="address"
                                            id="address"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Enter address"
                                        ><?php echo set_value('address'); ?></textarea>

                                    </div>

                                </div>


                            </div>

                        </div>


                        <!-- =========================================
                             FACE INFORMATION
                        ========================================== -->

                        <div class="person-section">

                            <div class="person-section-title">
                                Face Information
                            </div>


                            <div class="row person-row">


                                <!-- =================================
                                     Profile Image
                                ================================== -->

                                <div class="col-md-6">

                                    <div class="person-form-group">

                                        <label for="profile_image">

                                            Profile Image

                                            <span class="required-mark">
                                                *
                                            </span>

                                        </label>


                                        <input
                                            type="file"
                                            name="profile_image"
                                            id="profile_image"
                                            class="form-control person-file-input"
                                            accept=".jpg,.jpeg,.png"
                                        >


                                        <span
                                            id="profile_image_error"
                                            class="field-error"
                                        >
                                            Profile Image is required.
                                        </span>


                                        <small class="file-help">
                                            Allowed: JPG, JPEG, PNG.
                                            Maximum 5 MB.
                                        </small>

                                    </div>

                                </div>


                                <!-- =================================
                                     Face Image
                                ================================== -->

                                <div class="col-md-6">

                                    <div class="person-form-group">

                                        <label for="face_image">

                                            Face Image

                                            <span class="required-mark">
                                                *
                                            </span>

                                        </label>


                                        <input
                                            type="file"
                                            name="face_image"
                                            id="face_image"
                                            class="form-control person-file-input"
                                            accept=".jpg,.jpeg,.png"
                                        >


                                        <span
                                            id="face_image_error"
                                            class="field-error"
                                        >
                                            Face Image is required.
                                        </span>


                                        <small class="file-help">
                                            Upload a clear image containing
                                            one face.
                                        </small>

                                    </div>

                                </div>


                            </div>

                        </div>


                        <!-- =========================================
                             BUTTONS
                        ========================================== -->

                        <div class="person-form-buttons">

                            <button
                                type="reset"
                                class="btn btn-secondary"
                                id="resetBtn"
                            >
                                Reset
                            </button>


                            <button
                                type="submit"
                                class="btn btn-primary"
                                id="registerBtn"
                            >
                                Register Person
                            </button>

                        </div>


                        <?php echo form_close(); ?>


                    </div>

                </div>

            </div>

        </section>

    </div>

</div>


<script>

/*
|--------------------------------------------------------------------------
| Elements
|--------------------------------------------------------------------------
*/

var personForm =
    document.getElementById('personForm');

var personCode =
    document.getElementById('person_code');

var nameField =
    document.getElementById('name');

var profileImage =
    document.getElementById('profile_image');

var faceImage =
    document.getElementById('face_image');


/*
|--------------------------------------------------------------------------
| Show Error
|--------------------------------------------------------------------------
*/

function showFieldError(
    input,
    errorId,
    message
) {

    input.classList.add('input-error');

    input.classList.remove('input-success');


    var error =
        document.getElementById(errorId);


    error.innerHTML =
        message;


    error.style.display =
        'block';
}


/*
|--------------------------------------------------------------------------
| Hide Error
|--------------------------------------------------------------------------
*/

function hideFieldError(
    input,
    errorId
) {

    input.classList.remove('input-error');

    input.classList.add('input-success');


    var error =
        document.getElementById(errorId);


    error.style.display =
        'none';
}


/*
|--------------------------------------------------------------------------
| Validate Person Code
|--------------------------------------------------------------------------
*/

function validatePersonCode()
{
    if (
        personCode.value.trim() === ''
    ) {

        showFieldError(
            personCode,
            'person_code_error',
            'Person Code is required.'
        );

        return false;
    }


    hideFieldError(
        personCode,
        'person_code_error'
    );

    return true;
}


/*
|--------------------------------------------------------------------------
| Validate Name
|--------------------------------------------------------------------------
*/

function validateName()
{
    if (
        nameField.value.trim() === ''
    ) {

        showFieldError(
            nameField,
            'name_error',
            'Name is required.'
        );

        return false;
    }


    hideFieldError(
        nameField,
        'name_error'
    );

    return true;
}


/*
|--------------------------------------------------------------------------
| Validate Profile Image
|--------------------------------------------------------------------------
*/

function validateProfileImage()
{
    if (
        !profileImage.files ||
        profileImage.files.length === 0
    ) {

        showFieldError(
            profileImage,
            'profile_image_error',
            'Profile Image is required.'
        );

        return false;
    }


    var file =
        profileImage.files[0];


    /*
     * File type
     */

    var allowedTypes = [
        'image/jpeg',
        'image/png'
    ];


    if (
        allowedTypes.indexOf(
            file.type
        ) === -1
    ) {

        showFieldError(
            profileImage,
            'profile_image_error',
            'Please upload a JPG, JPEG or PNG image.'
        );

        return false;
    }


    /*
     * Maximum 5 MB
     */

    if (
        file.size > 5 * 1024 * 1024
    ) {

        showFieldError(
            profileImage,
            'profile_image_error',
            'Profile Image must not exceed 5 MB.'
        );

        return false;
    }


    hideFieldError(
        profileImage,
        'profile_image_error'
    );

    return true;
}


/*
|--------------------------------------------------------------------------
| Validate Face Image
|--------------------------------------------------------------------------
*/

function validateFaceImage()
{
    if (
        !faceImage.files ||
        faceImage.files.length === 0
    ) {

        showFieldError(
            faceImage,
            'face_image_error',
            'Face Image is required.'
        );

        return false;
    }


    var file =
        faceImage.files[0];


    /*
     * File type
     */

    var allowedTypes = [
        'image/jpeg',
        'image/png'
    ];


    if (
        allowedTypes.indexOf(
            file.type
        ) === -1
    ) {

        showFieldError(
            faceImage,
            'face_image_error',
            'Please upload a JPG, JPEG or PNG image.'
        );

        return false;
    }


    /*
     * Maximum 5 MB
     */

    if (
        file.size > 5 * 1024 * 1024
    ) {

        showFieldError(
            faceImage,
            'face_image_error',
            'Face Image must not exceed 5 MB.'
        );

        return false;
    }


    hideFieldError(
        faceImage,
        'face_image_error'
    );

    return true;
}


/*
|--------------------------------------------------------------------------
| Submit Validation
|--------------------------------------------------------------------------
*/

personForm.addEventListener(
    'submit',
    function(e) {

        var valid = true;


        /*
         * Validate all required fields
         */

        if (!validatePersonCode()) {
            valid = false;
        }


        if (!validateName()) {
            valid = false;
        }


        if (!validateProfileImage()) {
            valid = false;
        }


        if (!validateFaceImage()) {
            valid = false;
        }


        /*
         * Stop submission if invalid
         */

        if (!valid) {

            e.preventDefault();


            /*
             * Scroll to first error
             */

            var firstError =
                document.querySelector(
                    '.input-error'
                );


            if (firstError) {

                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });


                firstError.focus();
            }


            return false;
        }

    }
);


/*
|--------------------------------------------------------------------------
| Person Code - Validate on Blur
|--------------------------------------------------------------------------
*/

personCode.addEventListener(
    'blur',
    function() {

        validatePersonCode();

    }
);


/*
|--------------------------------------------------------------------------
| Name - Validate on Blur
|--------------------------------------------------------------------------
*/

nameField.addEventListener(
    'blur',
    function() {

        validateName();

    }
);


/*
|--------------------------------------------------------------------------
| Person Code - Remove Error While Typing
|--------------------------------------------------------------------------
*/

personCode.addEventListener(
    'input',
    function() {

        if (
            personCode.value.trim() !== ''
        ) {

            hideFieldError(
                personCode,
                'person_code_error'
            );
        }

    }
);


/*
|--------------------------------------------------------------------------
| Name - Remove Error While Typing
|--------------------------------------------------------------------------
*/

nameField.addEventListener(
    'input',
    function() {

        if (
            nameField.value.trim() !== ''
        ) {

            hideFieldError(
                nameField,
                'name_error'
            );
        }

    }
);


/*
|--------------------------------------------------------------------------
| Profile Image Change
|--------------------------------------------------------------------------
*/

profileImage.addEventListener(
    'change',
    function() {

        validateProfileImage();

    }
);


/*
|--------------------------------------------------------------------------
| Face Image Change
|--------------------------------------------------------------------------
*/

faceImage.addEventListener(
    'change',
    function() {

        validateFaceImage();

    }
);


/*
|--------------------------------------------------------------------------
| Reset
|--------------------------------------------------------------------------
*/

document.getElementById('resetBtn')
    .addEventListener(
        'click',
        function() {

            setTimeout(
                function() {

                    /*
                     * Remove validation classes
                     */

                    document
                        .querySelectorAll(
                            '.input-error, .input-success'
                        )
                        .forEach(
                            function(element) {

                                element.classList.remove(
                                    'input-error'
                                );

                                element.classList.remove(
                                    'input-success'
                                );

                            }
                        );


                    /*
                     * Hide validation messages
                     */

                    document
                        .querySelectorAll(
                            '.field-error'
                        )
                        .forEach(
                            function(element) {

                                element.style.display =
                                    'none';

                            }
                        );

                },
                10
            );

        }
    );

</script>