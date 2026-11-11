<div class="wrapper">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-history text-primary mr-2"></i>Employee Assessment History</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>hse_induction/employee">HSE Induction</a></li>
                            <li class="breadcrumb-item active">Assessment History</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                <!-- Employee Profile Summary -->
                <div class="card card-outline card-primary mb-3 shadow-sm">
                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center text-md-left mb-2 mb-md-0">
                                <span class="d-inline-block bg-primary text-white rounded-circle text-center font-weight-bold" style="width: 55px; height: 55px; line-height: 55px; font-size: 24px;">
                                    <?php echo strtoupper(substr($emp->EMP_NAME, 0, 1)); ?>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-1 font-weight-bold text-dark">
                                    <?php echo htmlspecialchars($emp->EMP_NAME); ?>
                                    <small class="badge badge-secondary ml-1"><?php echo htmlspecialchars($emp->EMP_ID); ?></small>
                                </h4>
                                <p class="text-muted mb-0 small">
                                    <i class="fas fa-building mr-1"></i> Dept: <strong><?php echo !empty($emp->dept_name) ? htmlspecialchars($emp->dept_name) : 'General'; ?></strong>
                                    &nbsp;|&nbsp;
                                    <i class="fas fa-id-badge mr-1"></i> Desig: <strong><?php echo !empty($emp->desig_name) ? htmlspecialchars($emp->desig_name) : '-'; ?></strong>
                                </p>
                            </div>
                            <div class="col-md-4 text-md-right text-center mt-2 mt-md-0">
                                <div class="d-inline-block text-left mr-3">
                                    <span class="text-muted small d-block">Total Attempts:</span>
                                    <strong class="h5 mb-0 text-dark"><?php echo !empty($attempts) ? count($attempts) : 0; ?></strong>
                                </div>
                                <div class="d-inline-block text-left">
                                    <span class="text-muted small d-block">Current Status:</span>
                                    <?php
                                    $indStatus = !empty($induction->INDUCTION_STATUS) ? $induction->INDUCTION_STATUS : 'NOT_STARTED';
                                    if ($indStatus == 'PASSED') {
                                        echo '<span class="badge badge-success px-3 py-2"><i class="fas fa-check-circle mr-1"></i> PASSED (100%)</span>';
                                    } elseif ($indStatus == 'FAILED') {
                                        echo '<span class="badge badge-danger px-3 py-2"><i class="fas fa-times-circle mr-1"></i> FAILED</span>';
                                    } else {
                                        echo '<span class="badge badge-secondary px-3 py-2"><i class="fas fa-clock mr-1"></i> NOT STARTED</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attempts Table -->
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title font-weight-bold mb-0">
                            <i class="fas fa-clipboard-list text-primary mr-2"></i>Historical Assessment Attempts Log
                        </h5>
                        <div class="card-tools ml-auto">
                            <a href="<?php echo BASE_URL; ?>hse_induction/employee" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back to Employee List
                            </a>
                            <a href="<?php echo BASE_URL; ?>hse_induction/employee/take/<?php echo $enc_id; ?>?reattend=1" class="btn btn-sm btn-primary ml-1">
                                <i class="fas fa-redo-alt mr-1"></i> New Attempt
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php if (!empty($attempts)) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr class="bg-light">
                                            <th style="width: 80px;">Attempt #</th>
                                            <th>Date & Time</th>
                                            <th>Total Qs</th>
                                            <th>Answered</th>
                                            <th>Correct</th>
                                            <th>Incorrect</th>
                                            <th>Marks Obtained</th>
                                            <th>Percentage</th>
                                            <th>Result Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($attempts as $att) { ?>
                                            <tr>
                                                <td class="text-center font-weight-bold">
                                                    <span class="badge badge-dark font-weight-bold" style="font-size: 0.95rem;">
                                                        #<?php echo $att->ATTEMPT_NUMBER; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong><?php echo date('d-m-Y H:i', strtotime($att->ATTEMPT_COMPLETED_AT)); ?></strong>
                                                    <?php if (!empty($att->IP_ADDRESS)) { ?>
                                                        <small class="d-block text-muted">IP: <?php echo htmlspecialchars($att->IP_ADDRESS); ?></small>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center"><?php echo $att->TOTAL_QUESTIONS; ?></td>
                                                <td class="text-center"><?php echo $att->QUESTIONS_ANSWERED; ?></td>
                                                <td class="text-center text-success font-weight-bold">
                                                    <i class="fas fa-check-circle mr-1"></i><?php echo $att->CORRECT_ANSWERS; ?>
                                                </td>
                                                <td class="text-center text-danger font-weight-bold">
                                                    <i class="fas fa-times-circle mr-1"></i><?php echo $att->INCORRECT_ANSWERS; ?>
                                                </td>
                                                <td class="text-center font-weight-bold">
                                                    <?php echo round($att->MARKS_OBTAINED, 1); ?> / <?php echo round($att->TOTAL_AVAILABLE_MARKS, 0); ?>
                                                </td>
                                                <td class="text-center font-weight-bold" style="font-size: 1rem;">
                                                    <?php if ($att->PASS_FAIL_STATUS == 'PASSED') { ?>
                                                        <span class="text-success"><?php echo $att->PERCENTAGE; ?>%</span>
                                                    <?php } else { ?>
                                                        <span class="text-danger"><?php echo $att->PERCENTAGE; ?>%</span>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($att->PASS_FAIL_STATUS == 'PASSED') { ?>
                                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> PASSED</span>
                                                    <?php } else { ?>
                                                        <span class="badge badge-danger px-2 py-1"><i class="fas fa-times mr-1"></i> FAILED</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo BASE_URL; ?>hse_induction/employee/attempt_pdf/<?php echo $att->ATTEMPT_ID; ?>" target="_blank" class="btn btn-sm btn-danger mr-1" title="Download Attempt PDF">
                                                        <i class="fas fa-file-pdf mr-1"></i> PDF
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>hse_induction/employee/attempt_details/<?php echo $att->ATTEMPT_ID; ?>" class="btn btn-sm btn-info" title="View Question-by-Question Answers">
                                                        <i class="fas fa-search-plus mr-1"></i> View Answers
                                                    </a>
                                                    <?php if ($att->PASS_FAIL_STATUS == 'PASSED') { ?>
                                                        <a href="<?php echo BASE_URL; ?>hse_induction/employee/view_pass/<?php echo $enc_id; ?>" class="btn btn-sm btn-success ml-1" title="View QR Pass">
                                                            <i class="fas fa-qrcode"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info text-center py-4">
                                <i class="fas fa-info-circle fa-2x mb-2 text-primary"></i>
                                <h5>No Assessment Attempts Recorded Yet</h5>
                                <p class="mb-3">This employee has not taken any HSE Induction assessment attempts.</p>
                                <a href="<?php echo BASE_URL; ?>hse_induction/employee/take/<?php echo $enc_id; ?>" class="btn btn-primary font-weight-bold">
                                    <i class="fas fa-play-circle mr-1"></i> Start First Induction Attempt
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

