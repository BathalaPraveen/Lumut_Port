<style>
.answer-box {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 10px;
    background: #ffffff;
    transition: all 0.2s;
}
.answer-box.user-correct {
    border-color: #28a745;
    background-color: #e8f9ed;
}
.answer-box.user-incorrect {
    border-color: #dc3545;
    background-color: #fdf2f2;
}
.answer-box.correct-target {
    border-color: #28a745;
    border-style: dashed;
    background-color: #f0fff4;
}
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-search-plus text-primary mr-2"></i>Attempt #<?php echo $attempt->ATTEMPT_NUMBER; ?> Answers Preview</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>hse_induction/employee">HSE Induction</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>hse_induction/assessment_history/index/<?php echo $enc_emp_id; ?>">History</a></li>
                            <li class="breadcrumb-item active">Attempt #<?php echo $attempt->ATTEMPT_NUMBER; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <!-- Attempt Summary Box -->
                <div class="card card-outline <?php echo ($attempt->PASS_FAIL_STATUS == 'PASSED') ? 'card-success' : 'card-danger'; ?> mb-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title font-weight-bold mb-0">
                                Attempt #<?php echo $attempt->ATTEMPT_NUMBER; ?> Evaluation Summary - <?php echo htmlspecialchars($attempt->EMP_NAME); ?> (<?php echo htmlspecialchars($attempt->EMP_ID); ?>)
                            </h5>
                        </div>
                        <div class="ml-auto">
                            <?php if ($attempt->PASS_FAIL_STATUS == 'PASSED') { ?>
                                <span class="badge badge-success px-3 py-2 font-weight-bold" style="font-size: 1rem;"><i class="fas fa-check-circle mr-1"></i> PASSED (100%)</span>
                            <?php } else { ?>
                                <span class="badge badge-danger px-3 py-2 font-weight-bold" style="font-size: 1rem;"><i class="fas fa-times-circle mr-1"></i> FAILED (<?php echo $attempt->PERCENTAGE; ?>%)</span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 col-md-3 border-right mb-2 mb-md-0">
                                <span class="text-muted small text-uppercase font-weight-bold d-block">Completion Time</span>
                                <h6 class="font-weight-bold mb-0 text-dark"><?php echo date('d-m-Y H:i:s', strtotime($attempt->ATTEMPT_COMPLETED_AT)); ?></h6>
                            </div>
                            <div class="col-6 col-md-3 border-right mb-2 mb-md-0">
                                <span class="text-muted small text-uppercase font-weight-bold d-block">Score / Percentage</span>
                                <h5 class="font-weight-bold mb-0 <?php echo ($attempt->PASS_FAIL_STATUS == 'PASSED') ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo round($attempt->MARKS_OBTAINED, 1); ?> / <?php echo round($attempt->TOTAL_AVAILABLE_MARKS, 0); ?> (<?php echo $attempt->PERCENTAGE; ?>%)
                                </h5>
                            </div>
                            <div class="col-6 col-md-3 border-right">
                                <span class="text-muted small text-uppercase font-weight-bold d-block">Correct / Incorrect</span>
                                <h6 class="font-weight-bold mb-0">
                                    <span class="text-success"><i class="fas fa-check mr-1"></i><?php echo $attempt->CORRECT_ANSWERS; ?></span>
                                    &nbsp;|&nbsp;
                                    <span class="text-danger"><i class="fas fa-times mr-1"></i><?php echo $attempt->INCORRECT_ANSWERS; ?></span>
                                </h6>
                            </div>
                            <div class="col-6 col-md-3">
                                <span class="text-muted small text-uppercase font-weight-bold d-block">Audit IP Address</span>
                                <span class="font-weight-bold text-muted"><?php echo !empty($attempt->IP_ADDRESS) ? htmlspecialchars($attempt->IP_ADDRESS) : 'Local/Internal'; ?></span>
                            </div>
                        </div>

                        <?php if (!empty($attempt->CERTIFICATE_NO)) { ?>
                            <div class="alert alert-success mt-3 mb-0 py-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-award mr-1"></i>
                                    <strong>Official Certificate No:</strong> <span style="font-family: monospace;"><?php echo htmlspecialchars($attempt->CERTIFICATE_NO); ?></span>
                                </div>
                                <a href="<?php echo BASE_URL; ?>hse_induction/employee/view_pass/<?php echo $enc_emp_id; ?>" class="btn btn-sm btn-success font-weight-bold">
                                    <i class="fas fa-qrcode mr-1"></i> View QR Pass Card
                                </a>
                            </div>
                        <?php } elseif ($attempt->PASS_FAIL_STATUS == 'FAILED') { ?>
                            <div class="alert alert-danger mt-3 mb-0 py-2 d-flex flex-wrap justify-content-between align-items-center">
                                <div class="mb-2 mb-md-0">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <strong>Assessment Result: FAILED (Score: <?php echo $attempt->PERCENTAGE; ?>%)</strong> — 100% score is required to pass. You can review your answers vs correct answers below and re-attend the exam.
                                </div>
                                <a href="<?php echo BASE_URL; ?>hse_induction/employee/take/<?php echo $enc_emp_id; ?>?reattend=1" class="btn btn-sm btn-warning font-weight-bold shadow-sm">
                                    <i class="fas fa-redo-alt mr-1"></i> Re-attend Exam
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Actions Bar -->
                <div class="mb-3 d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <a href="<?php echo BASE_URL; ?>hse_induction/employee/view_pass/<?php echo $enc_emp_id; ?>" class="btn btn-outline-secondary font-weight-bold mr-2">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Pass & History
                        </a>
                        <a href="<?php echo BASE_URL; ?>hse_induction/employee" class="btn btn-outline-secondary font-weight-bold mr-2">
                            <i class="fas fa-list mr-1"></i> Employee List
                        </a>
                        <?php if ($attempt->PASS_FAIL_STATUS == 'FAILED' || empty($attempt->VALIDITY_DATE) || $attempt->VALIDITY_DATE < date('Y-m-d')) { ?>
                            <a href="<?php echo BASE_URL; ?>hse_induction/employee/take/<?php echo $enc_emp_id; ?>?reattend=1" class="btn btn-warning font-weight-bold shadow-sm">
                                <i class="fas fa-redo-alt mr-1"></i> Re-attend Exam
                            </a>
                        <?php } ?>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <a href="<?php echo BASE_URL; ?>hse_induction/employee/attempt_pdf/<?php echo $attempt->ATTEMPT_ID; ?>" target="_blank" class="btn btn-sm btn-danger font-weight-bold shadow-sm">
                            <i class="fas fa-file-pdf mr-1"></i> Download Attempt PDF
                        </a>
                    </div>
                </div>

                <!-- Question-by-Question Breakdown -->
                <?php if (!empty($answers)) { ?>
                    <?php foreach ($answers as $ans) { ?>
                        <div class="card card-default mb-4 shadow-sm border <?php echo ($ans->IS_CORRECT == 1) ? 'border-success' : 'border-danger'; ?>">
                            <div class="card-header py-2 bg-light d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold text-dark">
                                    <i class="fas fa-question-circle mr-1 text-primary"></i> Question #<?php echo $ans->QUESTION_NUMBER; ?>
                                </span>
                                <div>
                                    <?php if ($ans->IS_CORRECT == 1) { ?>
                                        <span class="badge badge-success px-3 py-1 font-weight-bold"><i class="fas fa-check mr-1"></i> Correct (+<?php echo round($ans->MARKS_AWARDED, 1); ?> marks)</span>
                                    <?php } else { ?>
                                        <span class="badge badge-danger px-3 py-1 font-weight-bold"><i class="fas fa-times mr-1"></i> Incorrect (0.0 marks)</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="font-weight-bold text-dark mb-3">
                                    <?php echo htmlspecialchars($ans->QUESTION_TEXT); ?>
                                </h5>

                                <?php if (!empty($ans->QUESTION_IMG)) { ?>
                                    <div class="mb-3 text-center">
                                        <img src="<?php echo BASE_URL . $ans->QUESTION_IMG; ?>" class="img-fluid rounded border" style="max-height: 200px;" alt="Question Image">
                                    </div>
                                <?php } ?>

                                <!-- Options Analysis -->
                                <div class="options-analysis">
                                    <?php
                                    $opts = [
                                        '1' => ['text' => $ans->OPTION_A, 'img' => $ans->OPTION_A_IMG, 'letter' => 'A'],
                                        '2' => ['text' => $ans->OPTION_B, 'img' => $ans->OPTION_B_IMG, 'letter' => 'B'],
                                        '3' => ['text' => $ans->OPTION_C, 'img' => $ans->OPTION_C_IMG, 'letter' => 'C'],
                                        '4' => ['text' => $ans->OPTION_D, 'img' => $ans->OPTION_D_IMG, 'letter' => 'D'],
                                    ];

                                    foreach ($opts as $optNum => $optVal) {
                                        if (!empty($optVal['text']) || !empty($optVal['img'])) {
                                            $isUserChoice = ($ans->SELECTED_OPTION == $optNum);
                                            $isCorrectChoice = ($ans->CORRECT_OPTION == $optNum);

                                            $boxClass = '';
                                            $badgeHtml = '';

                                            if ($isUserChoice && $ans->IS_CORRECT == 1) {
                                                $boxClass = 'user-correct';
                                                $badgeHtml = '<span class="badge badge-success float-right"><i class="fas fa-check-circle mr-1"></i> Employee Selected (Correct)</span>';
                                            } elseif ($isUserChoice && $ans->IS_CORRECT == 0) {
                                                $boxClass = 'user-incorrect';
                                                $badgeHtml = '<span class="badge badge-danger float-right"><i class="fas fa-times-circle mr-1"></i> Employee Selected (Wrong)</span>';
                                            } elseif ($isCorrectChoice && !$isUserChoice) {
                                                $boxClass = 'correct-target';
                                                $badgeHtml = '<span class="badge badge-success float-right"><i class="fas fa-arrow-left mr-1"></i> Correct Answer</span>';
                                            }
                                    ?>
                                        <div class="answer-box <?php echo $boxClass; ?>">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong class="mr-2">[<?php echo $optVal['letter']; ?>]</strong>
                                                    <span><?php echo htmlspecialchars($optVal['text']); ?></span>
                                                </div>
                                                <div><?php echo $badgeHtml; ?></div>
                                            </div>
                                            <?php if (!empty($optVal['img'])) { ?>
                                                <div class="mt-2 text-center">
                                                    <img src="<?php echo BASE_URL . $optVal['img']; ?>" class="img-fluid rounded border" style="max-height: 120px;" alt="Option <?php echo $optVal['letter']; ?>">
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="text-center py-3">
                    <?php if ($attempt->PASS_FAIL_STATUS == 'FAILED' || empty($attempt->VALIDITY_DATE) || $attempt->VALIDITY_DATE < date('Y-m-d')) { ?>
                        <a href="<?php echo BASE_URL; ?>hse_induction/employee/take/<?php echo $enc_emp_id; ?>?reattend=1" class="btn btn-warning btn-lg font-weight-bold shadow-sm mr-2">
                            <i class="fas fa-redo-alt mr-1"></i> Re-attend Exam
                        </a>
                    <?php } ?>
                    <a href="<?php echo BASE_URL; ?>hse_induction/assessment_history/index/<?php echo $enc_emp_id; ?>" class="btn btn-outline-secondary btn-lg mr-2">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Attempt History
                    </a>
                    <a href="<?php echo BASE_URL; ?>hse_induction/employee" class="btn btn-primary btn-lg">
                        <i class="fas fa-list mr-1"></i> Employee List
                    </a>
                </div>

            </div>
        </section>
    </div>
</div>

