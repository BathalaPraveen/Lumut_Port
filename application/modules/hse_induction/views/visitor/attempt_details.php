<?php
$isInternalAdmin = !empty($is_internal_admin);
$backUrl = $isInternalAdmin ? (BASE_URL . 'hse_induction/visitor') : (BASE_URL . 'hse_induction/visitor_registration/attend/' . (isset($visitor->ACCESS_TOKEN) ? $visitor->ACCESS_TOKEN : ''));
$pdfUrl = $isInternalAdmin ? (BASE_URL . 'hse_induction/visitor/attempt_pdf/' . $attempt->ATTEMPT_ID) : (BASE_URL . 'hse_induction/visitor_registration/attempt_pdf/' . $attempt->ATTEMPT_ID);
$reattendUrl = BASE_URL . 'hse_induction/visitor_registration/attend/' . (isset($visitor->ACCESS_TOKEN) ? $visitor->ACCESS_TOKEN : '') . '?reattend=1';
$hasPassed = ($attempt->PASS_FAIL_STATUS == 'PASSED') || (!empty($visitor->INDUCTION_STATUS) && $visitor->INDUCTION_STATUS == 'PASSED');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($site_title) ? $site_title : 'Attempt Breakdown - Lumut Port'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700,800&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH; ?>fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH_CSS; ?>adminlte.min.css">
    <link rel="stylesheet" href="<?php echo LAYOUT_PLUG_PATH_CSS; ?>kabbani_styles.css">
    <!-- jQuery -->
    <script src="<?php echo LAYOUT_PLUG_PATH; ?>jquery/jquery.min.js"></script>

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Source Sans Pro', sans-serif;
            color: #1e293b;
        }
        .public-top-bar {
            background-color: #161D26;
            color: #ffffff;
            padding: 12px 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .main-container {
            max-width: 980px;
            margin: 25px auto;
            padding: 0 15px 40px 15px;
        }
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
</head>
<body>

<div class="public-top-bar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <img src="<?php echo BASE_URL; ?>assets/images/hse_induction/lumut_port_logo.png" style="height: 36px;" alt="Lumut Port Logo">
        <div class="ml-3 d-none d-sm-block">
            <h5 class="mb-0 font-weight-bold" style="color: #FEC001; font-size: 1.05rem;">LUMUT MARITIME TERMINAL</h5>
            <small class="text-white-50">HSSE ASSESSMENT EVALUATION &bull; ATTEMPT #<?php echo $attempt->ATTEMPT_NUMBER; ?> PREVIEW</small>
        </div>
    </div>
    <div>
        <a href="<?php echo $backUrl; ?>" class="btn btn-sm btn-outline-light font-weight-bold">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>
</div>

<div class="main-container">

    <!-- Attempt Summary Box -->
    <div class="card card-outline <?php echo ($attempt->PASS_FAIL_STATUS == 'PASSED') ? 'card-success' : 'card-danger'; ?> mb-4 shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title font-weight-bold mb-0">
                    Attempt #<?php echo $attempt->ATTEMPT_NUMBER; ?> Evaluation Summary - <?php echo htmlspecialchars($visitor->VISITOR_NAME); ?> (<?php echo htmlspecialchars($visitor->COMPANY_NAME); ?>)
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
                    <div>
                        <a href="<?php echo $pdfUrl; ?>" target="_blank" class="btn btn-sm btn-outline-success font-weight-bold mr-2">
                            <i class="fas fa-file-pdf mr-1"></i> Download Attempt PDF
                        </a>
                    </div>
                </div>
            <?php } elseif ($attempt->PASS_FAIL_STATUS == 'FAILED') { ?>
                <div class="alert alert-danger mt-3 mb-0 py-2 d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        <strong>Requirement Not Met:</strong> Under HSSE regulations, a 100% score is mandatory to pass.
                    </div>
                    <div class="d-flex align-items-center" style="gap: 6px;">
                        <?php if (!$hasPassed) { ?>
                            <a href="<?php echo $reattendUrl; ?>" class="btn btn-sm btn-warning font-weight-bold">
                                <i class="fas fa-redo-alt mr-1"></i> Re-attend Exam
                            </a>
                        <?php } ?>
                        <a href="<?php echo $pdfUrl; ?>" target="_blank" class="btn btn-sm btn-outline-danger font-weight-bold">
                            <i class="fas fa-file-pdf mr-1"></i> Download PDF
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Question-by-Question Review -->
    <h5 class="font-weight-bold text-dark mb-3">
        <i class="fas fa-list-ol mr-2 text-primary"></i>Question-by-Question Evaluation Review
    </h5>

    <?php if (!empty($answers)) { ?>
        <?php foreach ($answers as $idx => $ans) { 
            $isCorrect = ($ans->IS_CORRECT == 1);
        ?>
            <div class="card card-default mb-4 shadow-sm border <?php echo $isCorrect ? 'border-success' : 'border-danger'; ?>">
                <div class="card-header py-2 bg-light d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-dark">
                        <i class="fas fa-question-circle mr-1 text-primary"></i> Question #<?php echo $ans->QUESTION_NUMBER; ?>
                    </span>
                    <div>
                        <?php if ($isCorrect) { ?>
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
                        <div class="text-center mb-3">
                            <img src="<?php echo BASE_URL . $ans->QUESTION_IMG; ?>" class="img-fluid rounded border" style="max-height: 200px;" alt="Question Image">
                        </div>
                    <?php } ?>

                    <!-- Options list -->
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
                                    $badgeHtml = '<span class="badge badge-success float-right"><i class="fas fa-check-circle mr-1"></i> Visitor Selected (Correct)</span>';
                                } elseif ($isUserChoice && $ans->IS_CORRECT == 0) {
                                    $boxClass = 'user-incorrect';
                                    $badgeHtml = '<span class="badge badge-danger float-right"><i class="fas fa-times-circle mr-1"></i> Visitor Selected (Wrong)</span>';
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
    <?php } else { ?>
        <div class="alert alert-warning">
            <i class="fas fa-info-circle mr-1"></i> No answer records found for this attempt.
        </div>
    <?php } ?>

    <div class="text-center mt-4">
        <a href="<?php echo $backUrl; ?>" class="btn btn-secondary font-weight-bold px-4 py-2">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
        <?php if ($attempt->PASS_FAIL_STATUS == 'FAILED' && !$hasPassed) { ?>
            <a href="<?php echo $reattendUrl; ?>" class="btn btn-warning font-weight-bold px-4 py-2 ml-2">
                <i class="fas fa-redo-alt mr-1"></i> Re-attend Exam Now
            </a>
        <?php } ?>
    </div>

</div>

</body>
</html>
