<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('employee_msg'); ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Contractor Batches - <?php echo isset($contractor->CONT_COMPANY) ? htmlspecialchars($contractor->CONT_COMPANY) : ''; ?> <small>(<?php echo isset($contractor->CONT_ID) ? htmlspecialchars($contractor->CONT_ID) : ''; ?>)</small></h3>
                            <a href="<?php echo BASE_URL('hse_induction'); ?>" class="btn btn-sm btn-secondary float-right ml-2"><i class="fa fa-arrow-left"></i> Back</a>
                            <a href="<?php echo BASE_URL('hse_induction/add_contractor_employee/' . encryptval($contractor_id)); ?>" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus"></i> Add Contractor Employee</a>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
                                        <th> Batch No </th>
                                        <!--
                                        <th> Payment </th>
                                        <th> Validity </th>
                                        -->
                                        <th> Created On </th>
                                        <th> Status </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
</div>
