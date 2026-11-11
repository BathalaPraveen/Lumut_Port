<style>
.stepper-wrapper {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
    position: relative;
}
.stepper-wrapper::before {
    content: "";
    position: absolute;
    top: 25px;
    left: 40px;
    right: 40px;
    height: 3px;
    background-color: #dee2e6;
    z-index: 1;
}
.step-item {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
}
.step-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #e9ecef;
    color: #6c757d;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: bold;
    border: 3px solid #dee2e6;
    transition: all 0.3s ease;
}
.step-item.active .step-circle {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.4);
}
.step-item.completed .step-circle {
    background-color: #28a745;
    color: #fff;
    border-color: #28a745;
}
.step-label {
    margin-top: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #6c757d;
}
.step-item.active .step-label {
    color: #007bff;
}
.step-item.completed .step-label {
    color: #28a745;
}

/* Option Cards */
.option-label {
    display: block;
    cursor: pointer;
    background: #ffffff;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 14px 18px;
    margin-bottom: 12px;
    transition: all 0.2s ease-in-out;
}
.option-label:hover {
    border-color: #007bff;
    background-color: #f8fbff;
}
.option-radio {
    display: none;
}
.option-radio:checked + .option-label {
    border-color: #007bff;
    background-color: #eaf3ff;
    box-shadow: 0 0 0 1px #007bff;
}
.option-indicator {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid #a0aec0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-weight: bold;
    font-size: 13px;
    color: #4a5568;
    background: #fff;
    vertical-align: middle;
}
.option-radio:checked + .option-label .option-indicator {
    background: #007bff;
    border-color: #007bff;
    color: #fff;
}
.question-card.unanswered-error {
    border: 2px solid #dc3545 !important;
    background-color: #fff9f9 !important;
    box-shadow: 0 0 10px rgba(220, 53, 69, 0.25);
}

/* Pass Card & Badge Styling */
.port-pass-cards-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
    padding: 15px 0;
}
.pass-badge-card {
    width: 320px;
    background: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.badge-strip-top {
    height: 16px;
    background: #FEC001;
    width: 100%;
}
.badge-strip-bottom {
    height: 12px;
    background: #FEC001;
    width: 100%;
    margin-top: auto;
}
.lanyard-slot {
    width: 44px;
    height: 10px;
    background-color: #e2e8f0;
    border: 1px solid #cbd5e1;
    border-radius: 5px;
    margin: 8px auto 4px auto;
}
.badge-card-body {
    padding: 10px 15px 15px 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.badge-header-pill {
    border: 2px solid #161D26;
    border-radius: 25px;
    padding: 3px 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 4px 0 8px 0;
    background: #ffffff;
}
.helmet-circle {
    width: 28px;
    height: 28px;
    background: #FEC001;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
}
.helmet-circle img {
    width: 18px;
    height: 18px;
    object-fit: contain;
}
.badge-header-title {
    font-weight: 900;
    font-size: 1.05rem;
    letter-spacing: 2px;
    color: #161D26;
}
.lumut-badge-logo {
    text-align: center;
    margin: 4px 0;
}
.lumut-badge-logo img {
    height: 28px;
    max-width: 140px;
    object-fit: contain;
}
.tech-photo-frame {
    position: relative;
    width: 130px;
    height: 155px;
    margin: 6px auto;
    padding: 6px;
    background: #f8fafc;
}
.emp-photo-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 1px solid #cbd5e1;
}
.corner-mk {
    position: absolute;
    width: 14px;
    height: 14px;
    border: 3px solid #161D26;
    pointer-events: none;
}
.corner-mk.top-left { top: 0; left: 0; border-right: none; border-bottom: none; }
.corner-mk.top-right { top: 0; right: 0; border-left: none; border-bottom: none; }
.corner-mk.bottom-left { bottom: 0; left: 0; border-right: none; border-top: none; }
.corner-mk.bottom-right { bottom: 0; right: 0; border-left: none; border-top: none; }
.front-emp-info { text-align: center; margin-top: 8px; }
.front-emp-name { font-size: 1.15rem; font-weight: 800; color: #0b1118; text-transform: uppercase; }
.front-emp-comp { font-size: 0.9rem; font-weight: 700; color: #374151; margin-top: 2px; }
.front-emp-valid { font-size: 0.9rem; font-weight: 800; color: #b91c1c; margin-top: 6px; }

.dark-meta-card {
    background-color: #161D26;
    border-radius: 10px;
    padding: 10px 14px;
    margin: 4px 0 8px 0;
    color: #ffffff;
}
.meta-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    font-size: 0.78rem;
    line-height: 1.45;
    margin-bottom: 4px;
    border-bottom: 1px dotted rgba(255,255,255,0.12);
    padding-bottom: 2px;
}
.meta-row:last-child { border-bottom: none; margin-bottom: 0; }
.meta-lbl { color: #94a3b8; font-weight: 700; font-size: 0.72rem; width: 44%; }
.meta-val { color: #ffffff; font-weight: 700; text-align: right; width: 56%; word-break: break-word; }
.meta-val.gold { color: #FEC001; font-family: monospace; }
.meta-val.green { color: #4ade80; }

.tech-qr-frame {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 6px auto 4px auto;
    padding: 6px;
    background: #ffffff;
}
.qr-code-img { width: 100%; height: 100%; object-fit: contain; }
.qr-scan-text { font-size: 0.72rem; font-weight: 800; color: #1e293b; text-align: center; margin-top: 3px; }
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-clipboard-check text-primary mr-2"></i>HSE Induction Assessment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>hse_induction/employee">HSE Induction</a></li>
                            <li class="breadcrumb-item active">Induction Assessment</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Employee Profile Card -->
                <div class="card card-outline card-primary mb-3">
                    <div class="card-body py-2">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center text-md-left mb-2 mb-md-0">
                                <span class="d-inline-block bg-primary text-white rounded-circle text-center font-weight-bold" style="width: 50px; height: 50px; line-height: 50px; font-size: 22px;">
                                    <?php echo strtoupper(substr($emp->EMP_NAME, 0, 1)); ?>
                                </span>
                            </div>
                            <div class="col-md-7">
                                <h5 class="mb-1 font-weight-bold text-dark">
                                    <?php echo htmlspecialchars($emp->EMP_NAME); ?>
                                    <small class="badge badge-secondary ml-1"><?php echo htmlspecialchars($emp->EMP_ID); ?></small>
                                    <span class="badge badge-info ml-1">Employee HSE Induction</span>
                                </h5>
                                <p class="text-muted mb-0 small">
                                    <i class="fas fa-building mr-1"></i> Dept: <strong><?php echo !empty($emp->dept_name) ? htmlspecialchars($emp->dept_name) : 'General'; ?></strong>
                                    &nbsp;|&nbsp;
                                    <i class="fas fa-id-badge mr-1"></i> Desig: <strong><?php echo !empty($emp->desig_name) ? htmlspecialchars($emp->desig_name) : '-'; ?></strong>
                                </p>
                            </div>
                            <div class="col-md-3 text-md-right text-center mt-2 mt-md-0">
                                <span class="text-muted small d-block">Induction Status:</span>
                                <?php
                                $indStatus = !empty($induction->INDUCTION_STATUS) ? $induction->INDUCTION_STATUS : 'NOT_STARTED';
                                if ($indStatus == 'PASSED') {
                                    echo '<span class="badge badge-success px-3 py-2" style="font-size: 0.95rem;"><i class="fas fa-check-circle mr-1"></i> PASSED (100%)</span>';
                                } elseif ($indStatus == 'FAILED') {
                                    echo '<span class="badge badge-danger px-3 py-2" style="font-size: 0.95rem;"><i class="fas fa-times-circle mr-1"></i> FAILED</span>';
                                } else {
                                    echo '<span class="badge badge-warning px-3 py-2" style="font-size: 0.95rem;"><i class="fas fa-clock mr-1"></i> IN PROGRESS</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stepper Navigation -->
                <div class="stepper-wrapper">
                    <div class="step-item active" id="stepper1">
                        <div class="step-circle"><i class="fas fa-video"></i></div>
                        <div class="step-label">1. Training Material</div>
                    </div>
                    <div class="step-item" id="stepper2">
                        <div class="step-circle"><i class="fas fa-file-alt"></i></div>
                        <div class="step-label">2. Assessment Exam</div>
                    </div>
                    <div class="step-item" id="stepper3">
                        <div class="step-circle"><i class="fas fa-award"></i></div>
                        <div class="step-label">3. Result & QR Pass</div>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- STEP 1: TRAINING MATERIAL (NON-SKIPPABLE) -->
                <!-- ============================================================== -->
                <div id="sectionStep1" class="step-content">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="card-title font-weight-bold mb-0">
                                <i class="fas fa-play-circle text-primary mr-2"></i>Step 1: Mandatory HSE Induction Material
                            </h5>
                            <span class="badge badge-danger float-right"><i class="fas fa-lock mr-1"></i> Full View Required</span>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info py-2 mb-3">
                                <i class="fas fa-info-circle mr-1"></i>
                                <strong>Important Instruction:</strong> You are required to view the complete induction material below.
                                <strong>Forward skipping is strictly disabled.</strong> Once you have completed viewing 100% of the material, the assessment exam will unlock automatically.
                            </div>

                            <div id="videoLockWarning" class="alert alert-danger py-2 mb-2" style="display:none;">
                                <i class="fas fa-ban mr-1"></i>
                                <strong>Skipping Not Allowed:</strong> You cannot fast-forward or skip ahead in the induction video. Please watch it sequentially to the end.
                            </div>

                            <!-- Media Player / Viewer Container -->
                            <?php if ($mediaType == 'video' && !empty($material->upload_file)) { ?>
                                <div class="text-center bg-dark p-2 rounded mb-3">
                                    <video id="inductionVideo" class="w-100" style="max-height: 520px; outline:none;" controls controlsList="nodownload noplaybackrate" disablePictureInPicture>
                                        <source src="<?php echo BASE_URL . $material->upload_file; ?>" type="video/mp4">
                                        Your browser does not support HTML5 video playback.
                                    </video>
                                </div>

                                <div class="p-3 bg-light border rounded mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="font-weight-bold text-dark">
                                            <i class="fas fa-video mr-1 text-primary"></i> Watching Progress: <span id="progressPercentText" class="text-primary font-weight-bold">0%</span>
                                        </span>
                                        <span id="videoStatusBadge" class="badge badge-warning px-3 py-1">
                                            <i class="fas fa-hourglass-half mr-1"></i> Watching In Progress
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 14px; border-radius: 7px;">
                                        <div id="videoProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%;"></div>
                                    </div>
                                </div>

                            <?php } elseif (($mediaType == 'pdf' || $mediaType == 'document' || $mediaType == 'image') && !empty($material->upload_file)) { ?>
                                <div class="border rounded p-2 mb-3 bg-white" style="min-height: 520px;">
                                    <?php if ($mediaType == 'image') { ?>
                                        <div class="text-center p-3">
                                            <img src="<?php echo BASE_URL . $material->upload_file; ?>" class="img-fluid rounded shadow-sm" style="max-height: 520px;" alt="Induction Material">
                                        </div>
                                    <?php } else { ?>
                                        <iframe id="docFrame" src="<?php echo BASE_URL . $material->upload_file; ?>" style="width: 100%; height: 520px; border: none;"></iframe>
                                    <?php } ?>
                                </div>

                                <div class="p-3 bg-light border rounded mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="font-weight-bold text-dark">
                                            <i class="fas fa-book-reader mr-1 text-info"></i> Document Review Requirement: <span id="docCountdown" class="text-info font-weight-bold">20</span>s remaining
                                        </span>
                                        <span id="videoStatusBadge" class="badge badge-warning px-3 py-1">
                                            <i class="fas fa-hourglass-half mr-1"></i> Review Required
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 14px; border-radius: 7px;">
                                        <div id="videoProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 0%;"></div>
                                    </div>
                                </div>

                            <?php } else { ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> No active training material has been uploaded yet for this induction type in the Master module.
                                </div>
                            <?php } ?>

                            <!-- Bottom Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center pt-2">
                                <a href="<?php echo BASE_URL; ?>hse_induction/employee" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i> Back to Employee List
                                </a>

                                <button type="button" id="btnProceedExam" class="btn btn-primary" disabled>
                                    <span>Proceed to Exam</span>
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- STEP 2: ASSESSMENT EXAM (MANDATORY & CANNOT BE SKIPPED) -->
                <!-- ============================================================== -->
                <div id="sectionStep2" class="step-content" style="display:none;">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title font-weight-bold mb-0">
                                <i class="fas fa-tasks text-primary mr-2"></i>Step 2: HSE Assessment Examination
                            </h5>
                            <span class="badge badge-danger ml-auto">
                                <i class="fas fa-star mr-1"></i> 100% Score Required to Pass
                            </span>
                        </div>
                        <div class="card-body">
                            <!-- Notice Banner -->
                            <div class="alert alert-warning py-2 mb-4">
                                <h6 class="font-weight-bold mb-1"><i class="fas fa-exclamation-circle mr-1"></i>Assessment Instructions & Rules:</h6>
                                <ul class="mb-0 pl-3 small">
                                    <li><strong>Every question is mandatory:</strong> You are not permitted to skip any question.</li>
                                    <li><strong>Passing standard is 100%:</strong> You must answer all questions correctly. Any score below 100% is considered a failure.</li>
                                    <li>If you pass with 100%, your <strong>official QR Code Pass</strong> will be generated immediately.</li>
                                    <li>If you fail, you will be required to <strong>attend again</strong> from Step 1.</li>
                                </ul>
                            </div>

                            <form id="formAssessment" autocomplete="off">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <input type="hidden" name="emp_id" value="<?php echo $enc_id; ?>">

                                <?php if (!empty($questions)) { ?>
                                    <div class="questions-container">
                                        <?php foreach ($questions as $qIdx => $q) { ?>
                                            <div class="card card-default question-card mb-4 border" id="card_question_<?php echo $q->id; ?>" data-qid="<?php echo $q->id; ?>">
                                                <div class="card-header py-2 bg-light">
                                                    <div class="d-flex align-items-center">
                                                        <span class="font-weight-bold text-primary mr-2">
                                                            <i class="fas fa-question-circle mr-1"></i> Question <?php echo ($qIdx + 1); ?> of <?php echo count($questions); ?>
                                                        </span>
                                                        <span class="badge badge-danger q-required-badge">Mandatory</span>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="question-text font-weight-bold mb-3 text-dark">
                                                        <?php echo htmlspecialchars($q->question); ?>
                                                    </h5>

                                                    <?php if (!empty($q->question_img)) { ?>
                                                        <div class="mb-3 text-center">
                                                            <img src="<?php echo BASE_URL . $q->question_img; ?>" class="img-fluid rounded border" style="max-height: 220px;" alt="Question Image">
                                                        </div>
                                                    <?php } ?>

                                                    <!-- Options List (Shuffled for each Candidate) -->
                                                    <div class="options-group">
                                                        <?php
                                                        $opts = [
                                                            1 => ['text' => $q->option_a, 'img' => $q->option_a_img],
                                                            2 => ['text' => $q->option_b, 'img' => $q->option_b_img],
                                                            3 => ['text' => $q->option_c, 'img' => $q->option_c_img],
                                                            4 => ['text' => $q->option_d, 'img' => $q->option_d_img],
                                                        ];
                                                        $optKeys = [1, 2, 3, 4];
                                                        shuffle($optKeys);
                                                        $letters = ['A', 'B', 'C', 'D'];
                                                        $dispIndex = 0;

                                                        foreach ($optKeys as $optNum) {
                                                            $optVal = $opts[$optNum];
                                                            // Display option only if text or image is present
                                                            if (!empty($optVal['text']) || !empty($optVal['img'])) {
                                                                $letter = $letters[$dispIndex];
                                                                $dispIndex++;
                                                                $optInputId = 'q_' . $q->id . '_opt_' . $optNum;
                                                        ?>
                                                            <div class="option-wrapper">
                                                                <input type="radio" class="option-radio" name="question_<?php echo $q->id; ?>" id="<?php echo $optInputId; ?>" value="<?php echo $optNum; ?>">
                                                                <label class="option-label" for="<?php echo $optInputId; ?>">
                                                                    <span class="option-indicator"><?php echo $letter; ?></span>
                                                                    <span class="option-text font-weight-normal text-dark">
                                                                        <?php echo htmlspecialchars($optVal['text']); ?>
                                                                    </span>
                                                                    <?php if (!empty($optVal['img'])) { ?>
                                                                        <div class="mt-2 text-center">
                                                                            <img src="<?php echo BASE_URL . $optVal['img']; ?>" class="img-fluid rounded border" style="max-height: 120px;" alt="Option <?php echo $letter; ?>">
                                                                        </div>
                                                                    <?php } ?>
                                                                </label>
                                                            </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="q-error-msg text-danger font-weight-bold small mt-1" style="display:none;">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i> This question is mandatory. Please select an answer.
                                                    </div>

                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="card-footer bg-white border-top text-center py-3">
                                        <button type="button" id="btnSubmitExam" class="btn btn-primary">
                                            <i class="fas fa-check mr-1"></i> Submit
                                        </button>
                                    </div>

                                <?php } else { ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle mr-2"></i> No active assessment questions found for this induction type in the Master module.
                                    </div>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- STEP 3: RESULT & QR CODE PASS (DYNAMIC) -->
                <!-- ============================================================== -->
                <div id="sectionStep3" class="step-content" style="display:none;">
                    <div id="resultContent">
                        <!-- Populated by JavaScript upon submission -->
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

<!-- SweetAlert2 Scripts / Styling -->
<link href="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.css" rel="stylesheet">
<script src="<?php echo LAYOUT_PLUG_PATH; ?>sweetalert2_new/sweetalert2.min.js"></script>

<script>
$(document).ready(function() {
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
    var encEmpId = '<?php echo $enc_id; ?>';
    var mediaType = '<?php echo $mediaType; ?>';
    var videoCompleted = <?php echo (!empty($induction->VIDEO_STATUS) && $induction->VIDEO_STATUS == 'COMPLETED') ? 'true' : 'false'; ?>;
    var totalQuestions = <?php echo !empty($questions) ? count($questions) : 0; ?>;

    // -------------------------------------------------------------
    // VIDEO / TRAINING COMPLETION TRACKING (NON-SKIPPABLE)
    // -------------------------------------------------------------
    var video = document.getElementById('inductionVideo');
    var maxTimeWatched = 0;
    var isMarkedComplete = videoCompleted;

    if (videoCompleted) {
        unlockProceedButton();
    }

    if (video) {
        // Prevent fast-forward / seeking ahead
        video.addEventListener('timeupdate', function() {
            if (video.currentTime > maxTimeWatched + 1.2) {
                video.currentTime = maxTimeWatched;
                $('#videoLockWarning').stop(true, true).slideDown(200).delay(2500).slideUp(200);
            } else if (video.currentTime > maxTimeWatched) {
                maxTimeWatched = video.currentTime;
            }

            var percent = 0;
            if (video.duration > 0) {
                percent = Math.min(100, Math.floor((maxTimeWatched / video.duration) * 100));
            }
            $('#videoProgressBar').css('width', percent + '%');
            $('#progressPercentText').text(percent + '%');

            // Trigger completion at >= 98% or within 0.5s of end
            if ((percent >= 98 || (video.duration > 0 && maxTimeWatched >= video.duration - 0.8)) && !isMarkedComplete) {
                isMarkedComplete = true;
                notifyVideoComplete(Math.floor(maxTimeWatched));
            }
        });

        // Prevent playback speed hack
        video.addEventListener('ratechange', function() {
            if (video.playbackRate > 1.0) {
                video.playbackRate = 1.0;
            }
        });

        video.addEventListener('ended', function() {
            if (!isMarkedComplete) {
                isMarkedComplete = true;
                notifyVideoComplete(Math.floor(video.duration));
            }
        });
    } else if (mediaType == 'document' || mediaType == 'pdf' || mediaType == 'image') {
        // Non-video media reading timer requirement (20 seconds)
        if (!videoCompleted) {
            var timeLeft = 20;
            var docTimer = setInterval(function() {
                timeLeft--;
                var progressPercent = Math.min(100, Math.floor(((20 - timeLeft) / 20) * 100));
                $('#videoProgressBar').css('width', progressPercent + '%');
                $('#docCountdown').text(timeLeft);

                if (timeLeft <= 0) {
                    clearInterval(docTimer);
                    notifyVideoComplete(20);
                }
            }, 1000);
        } else {
            unlockProceedButton();
        }
    } else {
        // No media uploaded
        unlockProceedButton();
    }

    function notifyVideoComplete(seconds) {
        $.ajax({
            url: '<?php echo BASE_URL; ?>hse_induction/employee/record_video_complete',
            type: 'POST',
            data: {
                [csrfName]: csrfToken,
                emp_id: encEmpId,
                watched_seconds: seconds,
                type_id: 2
            },
            dataType: 'json',
            success: function(resp) {
                unlockProceedButton();
                Swal.fire({
                    icon: 'success',
                    title: 'Training Material Completed!',
                    text: 'You have completed the required induction material. The assessment exam is now unlocked.',
                    confirmButtonText: 'Proceed to Exam',
                    confirmButtonColor: '#28a745'
                }).then(function() {
                    goToStep2();
                });
            },
            error: function() {
                unlockProceedButton();
            }
        });
    }

    function unlockProceedButton() {
        $('#btnProceedExam').prop('disabled', false).removeClass('btn-secondary').addClass('btn-success pulse-btn');
        $('#videoStatusBadge').removeClass('badge-warning').addClass('badge-success').html('<i class="fas fa-check-circle mr-1"></i> Completed');
        $('#videoProgressBar').css('width', '100%').removeClass('progress-bar-animated bg-warning bg-info').addClass('bg-success');
        $('#progressPercentText').text('100%');
    }

    // -------------------------------------------------------------
    // STEP TRANSITIONS
    // -------------------------------------------------------------
    $('#btnProceedExam').on('click', function() {
        goToStep2();
    });

    function goToStep2() {
        $('#sectionStep1').slideUp(300);
        $('#sectionStep2').slideDown(400);

        $('#stepper1').removeClass('active').addClass('completed');
        $('#stepper2').addClass('active');

        $('html, body').animate({
            scrollTop: $('#sectionStep2').offset().top - 80
        }, 500);
    }

    // Clear error highlights when an option is clicked
    $('.option-radio').on('change', function() {
        var card = $(this).closest('.question-card');
        card.removeClass('unanswered-error');
        card.find('.q-error-msg').slideUp();
        card.find('.q-required-badge').removeClass('badge-danger').addClass('badge-success').text('Answered');

        // Check if all questions are answered now
        var remainingCount = 0;
        $('.question-card').each(function() {
            var qid = $(this).data('qid');
            if (!$(this).find('input[name="question_' + qid + '"]:checked').val()) {
                remainingCount++;
            }
        });
    });

    // -------------------------------------------------------------
    // EXAM SUBMISSION & STRICT NON-SKIPPABLE VALIDATION
    // -------------------------------------------------------------
    $('#btnSubmitExam').on('click', function(e) {
        e.preventDefault();

        var unansweredCards = [];
        var answersMap = {};

        $('.question-card').each(function(idx) {
            var qid = $(this).data('qid');
            var selected = $(this).find('input[name="question_' + qid + '"]:checked').val();

            if (!selected) {
                unansweredCards.push({
                    card: $(this),
                    qnum: (idx + 1)
                });
            } else {
                answersMap[qid] = selected;
            }
        });

        // "DONT ALLOW TO SKIP NEED TO ATTEND" - Inline Question Validation
        if (unansweredCards.length > 0) {
            // Highlight all missing cards
            $('.question-card').removeClass('unanswered-error');
            $('.q-error-msg').hide();

            unansweredCards.forEach(function(item) {
                item.card.addClass('unanswered-error');
                item.card.find('.q-error-msg').slideDown();
                item.card.find('.q-required-badge').removeClass('badge-primary badge-success').addClass('badge-danger').text('Required');
            });

            // Smooth scroll to the first missing question
            $('html, body').animate({
                scrollTop: unansweredCards[0].card.offset().top - 100
            }, 500);

            return false;
        }

        // All questions answered, confirm submission
        Swal.fire({
            title: 'Submit Assessment?',
            html: 'You have answered all <strong>' + totalQuestions + '</strong> questions.<br><br>' +
                  '<span class="badge badge-warning p-2">Note: 100% score is required to pass.</span>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.value) {
                submitExamAnswers(answersMap);
            }
        });
    });

    function submitExamAnswers(answersMap) {
        Swal.fire({
            title: 'Evaluating Assessment...',
            text: 'Calculating your HSE Induction score',
            allowOutsideClick: false,
            didOpen: function() {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '<?php echo BASE_URL; ?>hse_induction/employee/submit_exam',
            type: 'POST',
            data: {
                [csrfName]: csrfToken,
                emp_id: encEmpId,
                answers: JSON.stringify(answersMap)
            },
            dataType: 'json',
            success: function(res) {
                Swal.close();
                renderExamResult(res);
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Evaluation Error',
                    text: 'An error occurred while evaluating your exam. Please try again.'
                });
            }
        });
    }

    // -------------------------------------------------------------
    // RENDER EXAM RESULT: PASS (100% + QR CODE) OR FAIL (ATTEND AGAIN)
    // -------------------------------------------------------------
    function renderExamResult(res) {
        $('#sectionStep2').slideUp(300);
        $('#sectionStep3').slideDown(400);

        $('#stepper2').removeClass('active').addClass('completed');
        $('#stepper3').addClass('active');

        var html = '';

        if (res.status === true && res.result === 'PASSED') {
            // 100% PASS OUTCOME
            html += '<div class="card card-success card-outline shadow-lg mb-4">';
            html += '  <div class="card-header bg-success text-white text-center py-3">';
            html += '    <h3 class="font-weight-bold mb-0"><i class="fas fa-trophy mr-2"></i>CONGRATULATIONS! YOU HAVE PASSED</h3>';
            html += '    <p class="mb-0">Perfect Score: 100% (' + res.correct_count + '/' + res.total_count + ' Correct)</p>';
            html += '  </div>';
            html += '  <div class="card-body p-4">';

            // Verified Official Port Pass Badge (Front & Back)
            <?php
            $realPhoto = BASE_URL . 'assets/images/hse_induction/default_avatar.png';
            if (!empty($emp->PROFILE_IMG) && file_exists(FCPATH . $emp->PROFILE_IMG)) {
                $realPhoto = BASE_URL . $emp->PROFILE_IMG;
            } elseif (!empty($emp->PHOTO_FILE) && file_exists(FCPATH . $emp->PHOTO_FILE)) {
                $realPhoto = BASE_URL . $emp->PHOTO_FILE;
            }
            ?>
            var photoUrl = '<?php echo $realPhoto; ?>';
            var helmetIcon = '<?php echo BASE_URL; ?>assets/images/hse_induction/safety_helmet_icon.png';
            var badgeLogo = '<?php echo BASE_URL; ?>assets/images/hse_induction/lumut_port_logo.png';
            var empName = '<?php echo htmlspecialchars($emp->EMP_NAME); ?>';
            var empCode = '<?php echo htmlspecialchars($emp->EMP_ID); ?>';
            var deptName = '<?php echo !empty($emp->dept_name) ? htmlspecialchars($emp->dept_name) : "LUMUT MARITIME TERMINAL"; ?>';
            var desigName = '<?php echo !empty($emp->desig_name) ? htmlspecialchars($emp->desig_name) : "STAFF"; ?>';

            html += '    <div class="port-pass-cards-row">';
            // FRONT BADGE
            html += '      <div class="pass-badge-card">';
            html += '        <div class="badge-strip-top"></div>';
            html += '        <div class="lanyard-slot"></div>';
            html += '        <div class="badge-card-body">';
            html += '          <div class="badge-header-pill">';
            html += '            <div class="helmet-circle"><img src="' + helmetIcon + '" alt="Helmet"></div>';
            html += '            <div class="badge-header-title">PORT PASS</div>';
            html += '          </div>';
            html += '          <div class="lumut-badge-logo"><img src="' + badgeLogo + '" alt="Lumut Port"></div>';
            html += '          <div class="tech-photo-frame">';
            html += '            <div class="corner-mk top-left"></div><div class="corner-mk top-right"></div>';
            html += '            <div class="corner-mk bottom-left"></div><div class="corner-mk bottom-right"></div>';
            html += '            <img src="' + photoUrl + '" class="emp-photo-img" alt="Employee Photo">';
            html += '          </div>';
            html += '          <div class="front-emp-info">';
            html += '            <div class="front-emp-name">' + empName + '</div>';
            html += '            <div class="front-emp-comp">' + deptName + '</div>';
            html += '            <div class="front-emp-valid">VALID UNTIL : ' + res.validity_date + '</div>';
            html += '          </div>';
            html += '        </div>';
            html += '        <div class="badge-strip-bottom"></div>';
            html += '      </div>';

            // BACK BADGE
            html += '      <div class="pass-badge-card">';
            html += '        <div class="badge-strip-top"></div>';
            html += '        <div class="lanyard-slot"></div>';
            html += '        <div class="badge-card-body">';
            html += '          <div class="dark-meta-card">';
            html += '            <div class="meta-row"><span class="meta-lbl">NAME :</span><span class="meta-val">' + empName + '</span></div>';
            html += '            <div class="meta-row"><span class="meta-lbl">COMPANY :</span><span class="meta-val">' + deptName + '</span></div>';
            html += '            <div class="meta-row"><span class="meta-lbl">I.C./PASSPORT :</span><span class="meta-val">' + empCode + '</span></div>';
            html += '            <div class="meta-row"><span class="meta-lbl">DESIGNATION:</span><span class="meta-val">' + desigName + '</span></div>';
            html += '            <div class="meta-row"><span class="meta-lbl">PASS ID :</span><span class="meta-val gold">' + res.certificate_no + '</span></div>';
            html += '            <div class="meta-row"><span class="meta-lbl">INDUCTION DATE :</span><span class="meta-val">' + (res.pass_date || '<?php echo date("d/m/Y"); ?>') + '</span></div>';
            html += '            <div class="meta-row"><span class="meta-lbl">DUE DATE :</span><span class="meta-val green">' + res.validity_date + '</span></div>';
            html += '          </div>';
            html += '          <div class="tech-qr-frame">';
            html += '            <div class="corner-mk top-left"></div><div class="corner-mk top-right"></div>';
            html += '            <div class="corner-mk bottom-left"></div><div class="corner-mk bottom-right"></div>';
            html += '            <img src="<?php echo BASE_URL; ?>' + res.qr_code_url + '" class="qr-code-img" alt="Pass QR">';
            html += '          </div>';
            html += '          <div class="qr-scan-text">Scan QR Code for Pass Verification</div>';
            html += '        </div>';
            html += '        <div class="badge-strip-bottom"></div>';
            html += '      </div>';
            html += '    </div>';

            // Action Buttons
            html += '    <div class="text-center mt-3 d-flex flex-wrap justify-content-center" style="gap: 8px;">';
            html += '      <a href="<?php echo BASE_URL; ?>hse_induction/employee/view_pass/' + encEmpId + '" class="btn btn-primary font-weight-bold shadow-sm">';
            html += '        <i class="fas fa-id-card mr-1"></i> View Result';
            html += '      </a>';
            var passPreviewUrl = (res && res.attempt_id) ? ('<?php echo BASE_URL; ?>hse_induction/employee/attempt_details/' + res.attempt_id) : ('<?php echo BASE_URL; ?>hse_induction/employee/attempt_details');
            html += '      <a href="' + passPreviewUrl + '" class="btn btn-info font-weight-bold shadow-sm">';
            html += '        <i class="fas fa-eye mr-1"></i> View Preview';
            html += '      </a>';
            html += '      <a href="<?php echo BASE_URL; ?>hse_induction/employee" class="btn btn-secondary font-weight-bold shadow-sm">';
            html += '        <i class="fas fa-arrow-left mr-1"></i> Back to Employee List';
            html += '      </a>';
            html += '    </div>';

            html += '  </div>';
            html += '</div>';

        } else {
            // FAIL OUTCOME (SCORE < 100%)
            html += '<div class="card card-danger card-outline shadow-lg mb-4">';
            html += '  <div class="card-header bg-danger text-white text-center py-3">';
            html += '    <h3 class="font-weight-bold mb-0"><i class="fas fa-times-circle mr-2"></i>ASSESSMENT RESULT: FAILED</h3>';
            html += '    <p class="mb-0">Your Score: <strong>' + res.score + '%</strong> (' + res.correct_count + '/' + res.total_count + ' Correct)</p>';
            html += '  </div>';
            html += '  <div class="card-body p-4 text-center">';
            html += '    <div class="alert alert-danger max-w-600 mx-auto text-left" style="max-width: 650px; margin: 0 auto;">';
            html += '      <h5 class="font-weight-bold mb-2"><i class="fas fa-exclamation-triangle mr-1"></i>100% Score is Required to Pass</h5>';
            html += '      <p class="mb-1">Under Lumut Port HSSE safety regulations, all participants must achieve a <strong>100% passing mark</strong> to receive safety clearance.</p>';
            html += '      <p class="mb-0">Because you scored below 100%, your induction pass was not generated. You are required to <strong>attend the induction again</strong> from the beginning.</p>';
            html += '    </div>';

            // Action Buttons
            html += '    <div class="mt-3 d-flex flex-wrap justify-content-center" style="gap: 8px;">';
            var failPreviewUrl = (res && res.attempt_id) ? ('<?php echo BASE_URL; ?>hse_induction/employee/attempt_details/' + res.attempt_id) : ('<?php echo BASE_URL; ?>hse_induction/employee/attempt_details');
            html += '      <a href="' + failPreviewUrl + '" class="btn btn-info font-weight-bold shadow-sm">';
            html += '        <i class="fas fa-eye mr-1"></i> View Preview';
            html += '      </a>';
            html += '      <button type="button" id="btnAttendAgain" class="btn btn-warning font-weight-bold shadow-sm">';
            html += '        <i class="fas fa-redo-alt mr-1"></i> Attend Again';
            html += '      </button>';
            html += '      <a href="<?php echo BASE_URL; ?>hse_induction/employee" class="btn btn-secondary font-weight-bold shadow-sm">';
            html += '        <i class="fas fa-arrow-left mr-1"></i> Back to Employee List';
            html += '      </a>';
            html += '    </div>';

            html += '  </div>';
            html += '</div>';
        }

        $('#resultContent').html(html);

        $('html, body').animate({
            scrollTop: $('#sectionStep3').offset().top - 80
        }, 500);
    }

    // -------------------------------------------------------------
    // "ATTEND AGAIN" HANDLER: RESETS PROGRESS & RESTARTS STEP 1
    // -------------------------------------------------------------
    $(document).on('click', '#btnAttendAgain', function() {
        Swal.fire({
            title: 'Restart Induction?',
            text: 'You will re-watch the training material and re-take the assessment exam.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            confirmButtonText: 'Yes, Start Again',
            cancelButtonText: 'Cancel'
        }).then(function(res) {
            if (res.value) {
                window.location.href = '<?php echo BASE_URL; ?>hse_induction/employee/take/' + encEmpId + '?reattend=1';
            }
        });
    });

    <?php if (!empty($induction->INDUCTION_STATUS) && $induction->INDUCTION_STATUS == 'FAILED' && $this->input->get('reattend') != '1' && !empty($latest_attempt)) { ?>
        var initialFailResult = {
            status: true,
            result: 'FAILED',
            score: <?php echo round($latest_attempt->PERCENTAGE); ?>,
            correct_count: <?php echo (int)$latest_attempt->CORRECT_ANSWERS; ?>,
            total_count: <?php echo (int)$latest_attempt->TOTAL_QUESTIONS; ?>,
            attempt_id: <?php echo (int)$latest_attempt->ATTEMPT_ID; ?>,
            attempt_number: <?php echo (int)$latest_attempt->ATTEMPT_NUMBER; ?>
        };
        $('#sectionStep1').hide();
        $('#stepper1').removeClass('active').addClass('completed');
        renderExamResult(initialFailResult);
    <?php } ?>

});
</script>

