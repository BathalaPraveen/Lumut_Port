<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
    .face-scan-page {
        padding: 15px;
    }

    .scan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .scan-header h4 {
        margin: 0;
        font-size: 23px;
        font-weight: 400;
    }

    .scan-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
    }

    .scan-section {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .scan-section-title {
        background: #0878b5;
        color: #fff;
        padding: 10px 15px;
        font-size: 18px;
        border-radius: 4px 4px 0 0;
    }

    .scan-section-body {
        padding: 20px;
    }

    .camera-wrapper {
        text-align: center;
    }

    #camera {
        width: 100%;
        max-width: 650px;
        height: 400px;
        object-fit: cover;
        background: #000;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    #canvas {
        display: none;
    }

    .scan-buttons {
        margin-top: 15px;
        text-align: center;
    }

    .scan-buttons .btn {
        margin: 3px;
        min-width: 110px;
    }

    .upload-area {
        max-width: 650px;
        margin: 0 auto;
    }

    .upload-area label {
        font-weight: 600;
        margin-bottom: 8px;
    }

    #previewImage {
        display: none;
        width: 100%;
        max-width: 400px;
        max-height: 300px;
        object-fit: contain;
        margin: 15px auto;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .scan-result {
        margin-top: 20px;
    }

    .scan-message {
        padding: 15px;
        border-radius: 4px;
        text-align: center;
    }

    .scan-message.success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .scan-message.warning {
        background: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
    }

    .scan-message.danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .person-result {
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
    }

    .person-result-header {
        background: #0878b5;
        color: #fff;
        padding: 10px 15px;
        font-size: 18px;
    }

    .person-result-body {
        padding: 20px;
    }

    .person-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .person-detail {
        margin-bottom: 9px;
    }

    .person-detail label {
        font-weight: 600;
        margin-right: 5px;
    }

    .match-score {
        margin-top: 12px;
        font-weight: 600;
    }

    @media (max-width: 767px) {

        #camera {
            height: 300px;
        }

        .scan-header {
            display: block;
        }

        .scan-header .btn {
            margin-top: 10px;
        }
    }
</style>


<div class="content-wrapper">

    <section class="content">

        <div class="container-fluid face-scan-page">

            <!-- Header -->
            <div class="scan-header">

                <h4>
                    Face Recognition
                </h4>

                <a
                    href="<?php echo base_url('face_recognition/Person/create'); ?>"
                    class="btn btn-primary"
                >
                    Register Person
                </a>

            </div>


            <div class="scan-card">


                <!-- ============================= -->
                <!-- CAMERA SCAN -->
                <!-- ============================= -->

                <div class="scan-section">

                    <div class="scan-section-title">
                        Camera Scan
                    </div>

                    <div class="scan-section-body">

                        <div class="camera-wrapper">

                            <video
                                id="camera"
                                autoplay
                                playsinline
                            ></video>

                            <canvas id="canvas"></canvas>


                            <div class="scan-buttons">

                                <button
                                    type="button"
                                    id="startCamera"
                                    class="btn btn-success"
                                >
                                    Start Camera
                                </button>

                                <button
                                    type="button"
                                    id="scanPerson"
                                    class="btn btn-primary"
                                    disabled
                                >
                                    Scan Person
                                </button>

                                <button
                                    type="button"
                                    id="stopCamera"
                                    class="btn btn-danger"
                                    disabled
                                >
                                    Stop Camera
                                </button>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ============================= -->
                <!-- FILE UPLOAD -->
                <!-- ============================= -->

                <div class="scan-section">

                    <div class="scan-section-title">
                        Upload Image
                    </div>

                    <div class="scan-section-body">

                        <div class="upload-area">

                            <div class="form-group">

                                <label for="faceImage">
                                    Select Face Image
                                </label>

                                <input
                                    type="file"
                                    id="faceImage"
                                    class="form-control"
                                    accept="image/jpeg,image/jpg,image/png"
                                >

                                <small class="text-muted">
                                    JPG, JPEG or PNG. Upload a clear image
                                    containing one face.
                                </small>

                            </div>


                            <img
                                id="previewImage"
                                alt="Face Preview"
                            >


                            <div class="text-center">

                                <button
                                    type="button"
                                    id="uploadScanBtn"
                                    class="btn btn-primary"
                                >
                                    Scan Uploaded Image
                                </button>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- ============================= -->
                <!-- RESULT -->
                <!-- ============================= -->

                <div
                    id="scanResult"
                    class="scan-result"
                ></div>


            </div>

        </div>

    </section>

</div>


<script>

let stream = null;


/*
|--------------------------------------------------------------------------
| Show Message
|--------------------------------------------------------------------------
*/
function showMessage(message, type)
{
    const result =
        document.getElementById('scanResult');

    let cssClass = 'warning';

    if (type === 'success') {
        cssClass = 'success';
    }

    if (type === 'danger') {
        cssClass = 'danger';
    }

    result.innerHTML =
        '<div class="scan-message ' +
        cssClass +
        '">' +
        escapeHtml(message) +
        '</div>';
}


/*
|--------------------------------------------------------------------------
| Start Camera
|--------------------------------------------------------------------------
*/
document
    .getElementById('startCamera')
    .addEventListener('click', function () {

        startCamera();

    });


async function startCamera()
{
    try {

        stream =
            await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user'
                },
                audio: false
            });


        const camera =
            document.getElementById('camera');

        camera.srcObject = stream;


        document.getElementById('startCamera')
            .disabled = true;

        document.getElementById('scanPerson')
            .disabled = false;

        document.getElementById('stopCamera')
            .disabled = false;


        showMessage(
            'Camera started. Position the face clearly and click Scan Person.',
            'success'
        );

    }
    catch (error) {

        console.error(error);

        showMessage(
            'Unable to access camera. Please allow camera permission.',
            'danger'
        );

    }
}


/*
|--------------------------------------------------------------------------
| Stop Camera
|--------------------------------------------------------------------------
*/
document
    .getElementById('stopCamera')
    .addEventListener('click', function () {

        stopCamera();

    });


function stopCamera()
{
    if (stream) {

        stream
            .getTracks()
            .forEach(function(track) {

                track.stop();

            });

        stream = null;
    }


    document.getElementById('camera')
        .srcObject = null;


    document.getElementById('startCamera')
        .disabled = false;

    document.getElementById('scanPerson')
        .disabled = true;

    document.getElementById('stopCamera')
        .disabled = true;
}


/*
|--------------------------------------------------------------------------
| Camera Scan
|--------------------------------------------------------------------------
*/
document
    .getElementById('scanPerson')
    .addEventListener('click', function () {

        const camera =
            document.getElementById('camera');

        const canvas =
            document.getElementById('canvas');


        if (
            !camera.videoWidth ||
            !camera.videoHeight
        ) {

            showMessage(
                'Camera is not ready.',
                'danger'
            );

            return;
        }


        canvas.width =
            camera.videoWidth;

        canvas.height =
            camera.videoHeight;


        const context =
            canvas.getContext('2d');


        context.drawImage(
            camera,
            0,
            0,
            canvas.width,
            canvas.height
        );


        canvas.toBlob(
            function(blob) {

                sendImageToServer(
                    blob,
                    'face_scan.jpg'
                );

            },
            'image/jpeg',
            0.90
        );

    });


/*
|--------------------------------------------------------------------------
| File Preview
|--------------------------------------------------------------------------
*/
document
    .getElementById('faceImage')
    .addEventListener('change', function () {

        const file =
            this.files[0];

        const preview =
            document.getElementById('previewImage');


        if (!file) {

            preview.style.display = 'none';

            return;
        }


        if (
            file.type !== 'image/jpeg' &&
            file.type !== 'image/jpg' &&
            file.type !== 'image/png'
        ) {

            showMessage(
                'Please select a JPG, JPEG or PNG image.',
                'danger'
            );

            this.value = '';

            preview.style.display = 'none';

            return;
        }


        const reader =
            new FileReader();


        reader.onload = function(event) {

            preview.src =
                event.target.result;

            preview.style.display =
                'block';

        };


        reader.readAsDataURL(file);

    });


/*
|--------------------------------------------------------------------------
| Upload Scan
|--------------------------------------------------------------------------
*/
document
    .getElementById('uploadScanBtn')
    .addEventListener('click', function () {

        const fileInput =
            document.getElementById('faceImage');


        if (
            !fileInput.files ||
            fileInput.files.length === 0
        ) {

            showMessage(
                'Please select an image first.',
                'danger'
            );

            return;
        }


        const file =
            fileInput.files[0];


        sendImageToServer(
            file,
            file.name
        );

    });


/*
|--------------------------------------------------------------------------
| Send Image to CodeIgniter
|--------------------------------------------------------------------------
*/
function sendImageToServer(file, fileName)
{
    const formData =
        new FormData();


    formData.append(
        'image',
        file,
        fileName || 'face_scan.jpg'
    );


    /*
     * CSRF token
     */
    formData.append(
        '<?php echo $this->security->get_csrf_token_name(); ?>',
        '<?php echo $this->security->get_csrf_hash(); ?>'
    );


    showMessage(
        'Scanning face, please wait...',
        'warning'
    );


    document.getElementById('scanPerson')
        .disabled = true;

    document.getElementById('uploadScanBtn')
        .disabled = true;


    fetch(
        '<?php echo base_url("face_recognition/Person/identify"); ?>',
        {
            method: 'POST',

            body: formData,

            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }
    )
    .then(function(response) {

        if (!response.ok) {

            return response
                .text()
                .then(function(text) {

                    throw new Error(
                        'HTTP ' +
                        response.status +
                        ': ' +
                        text.substring(0, 300)
                    );

                });

        }


        return response.json();

    })
    .then(function(data) {

        console.log(
            'Recognition response:',
            data
        );


        displayResult(data);

    })
    .catch(function(error) {

        console.error(
            'Recognition error:',
            error
        );


        showMessage(
            'Face recognition request failed.',
            'danger'
        );

    })
    .finally(function() {

        document.getElementById('scanPerson')
            .disabled = false;

        document.getElementById('uploadScanBtn')
            .disabled = false;

    });
}


/*
|--------------------------------------------------------------------------
| Display Result
|--------------------------------------------------------------------------
*/
function displayResult(data)
{
    const result =
        document.getElementById('scanResult');


    /*
     * Person found
     */
    if (
        data.status === true &&
        data.found === true &&
        data.person
    ) {

        const person =
            data.person;


        let html = '';


        html +=
            '<div class="person-result">';


        html +=
            '<div class="person-result-header">' +
            'Person Found' +
            '</div>';


        html +=
            '<div class="person-result-body">';


        html +=
            '<div class="row">';


        /*
         * Image
         */
        html +=
            '<div class="col-md-3 text-center">';


        if (person.profile_image) {

            html +=
                '<img src="' +
                escapeHtml(
                    person.profile_image
                ) +
                '" class="person-photo">';

        }
        else {

            html +=
                '<div class="person-photo">' +
                'No Image' +
                '</div>';

        }


        html += '</div>';


        /*
         * Details
         */
        html +=
            '<div class="col-md-9">';


        html += detail(
            'Person Code',
            person.person_code
        );

        html += detail(
            'Name',
            person.name
        );

        html += detail(
            'Date of Birth',
            person.date_of_birth
        );

        html += detail(
            'Gender',
            person.gender
        );

        html += detail(
            'Phone',
            person.phone
        );

        html += detail(
            'Email',
            person.email
        );

        html += detail(
            'Department',
            person.department
        );

        html += detail(
            'Designation',
            person.designation
        );

        html += detail(
            'Company',
            person.company
        );

        html += detail(
            'Address',
            person.address
        );


        html +=
            '<div class="match-score">' +
            'Match Score: ' +
            escapeHtml(
                data.similarity
            ) +
            '%' +
            '</div>';


        html += '</div>';

        html += '</div>';

        html += '</div>';

        html += '</div>';


        result.innerHTML =
            html;


        return;
    }


    /*
     * Not found
     */
    let message =
        data.message ||
        'Person not found.';


    let html =
        '<div class="scan-message warning">' +
        '<strong>Person Not Found</strong><br>' +
        escapeHtml(message);


    if (
        data.similarity !== undefined
    ) {

        html +=
            '<div class="match-score">' +
            'Match Score: ' +
            escapeHtml(
                data.similarity
            ) +
            '%' +
            '</div>';

    }


    html += '</div>';


    result.innerHTML =
        html;
}


/*
|--------------------------------------------------------------------------
| Detail
|--------------------------------------------------------------------------
*/
function detail(label, value)
{
    if (
        value === null ||
        value === undefined ||
        value === ''
    ) {

        value = '-';

    }


    return (
        '<div class="person-detail">' +
        '<label>' +
        escapeHtml(label) +
        ':</label> ' +
        escapeHtml(value) +
        '</div>'
    );
}


/*
|--------------------------------------------------------------------------
| Escape HTML
|--------------------------------------------------------------------------
*/
function escapeHtml(value)
{
    if (
        value === null ||
        value === undefined
    ) {

        return '';
    }


    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}


/*
|--------------------------------------------------------------------------
| Stop camera on page exit
|--------------------------------------------------------------------------
*/
window.addEventListener(
    'beforeunload',
    function() {

        if (stream) {

            stream
                .getTracks()
                .forEach(function(track) {

                    track.stop();

                });
        }

    }
);

</script>