<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('locatn'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">HIRARC Cause Effect</h3>
                            <a href="<?php echo BASE_URL('hirarc/master/addcauseaffect') ?>" class="btn btn-sm btn-primary float-right" >Add Cause Effect</a>
                        </div>
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> Activity/Process/Area </th>
                                        <th> Hazard Type </th>
                                        <th> Hazard Name </th>
                                        <th> Cause Effect Name </th>
                                        <th> Created on</th>
                                        <th> Action</th>
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



<script>

    $(document).ready(function () {

        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';


        $(document).on("click", ".deletecause", function (e) {
            e.preventDefault();
            var url = '<?php echo BASE_URL("hirarc/Master/deleteCauseAff"); ?>';
            var deletId = $(this).attr("delt-id");

            deleteDatas(url, deletId, csrfName, csrfToken);
        });
    });
</script>

