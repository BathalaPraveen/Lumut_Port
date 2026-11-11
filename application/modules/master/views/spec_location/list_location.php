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
                            <h3 class="card-title">Specific Location</h3>
                            <a href="<?php echo BASE_URL('master/LocationMaster/addLocation') ?>" class="btn btn-sm btn-primary float-right" >Add Location</a>
                        </div>
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> Location Id </th>
                                        <th> Location Name </th>
                                        <th> Terminal Name </th>
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


        $(document).on("click", ".deleteLocation", function (e) {
            e.preventDefault();
            var url = '<?php echo BASE_URL("master/LocationMaster/deleteLocation"); ?>';
            var deletId = $(this).attr("delt-id");

            deleteDatas(url, deletId, csrfName, csrfToken)


        });
        $(".btnRefresh").on('click', function () {
            window.location = '<?php echo BASE_URL("master/location") ?>'
        });
        $(".filterVals,#to_date,#from_date").on("change", function () {
            if($('#location_type').val() != "") {
                $('#region_id').val('');
            }
            $("#filterForm").submit();
        });

    });
</script>

