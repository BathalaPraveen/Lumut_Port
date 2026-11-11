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
                            <h3 class="card-title">Employee HSE Induction</h3>
                        </div>
                       
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> Employee ID </th>
                                        <th> Employee Name </th>
                                        <th> Department </th>
                                        <th> Designation </th>
                                        <th> Type </th>
                                        <th> Status </th>
                                        <th> Score </th>
                                        <th> Validity Date </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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

<script>
$(document).ready(function () {
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
});
</script>
