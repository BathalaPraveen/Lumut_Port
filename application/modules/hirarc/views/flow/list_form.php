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
                            <h3 class="card-title">hirarc</h3>
                            <?php 
                            $usertypeId = getCurrentUserGroupId();
                            if(is_admin() || $hirarcPermission['add'][0] == $usertypeId) { ?>
                            <a href="<?php echo BASE_URL('hirarc/hirarc/add_hirarc') ?>" class="btn btn-sm btn-primary float-right" >Add HIRARC</a>
                            <?php } ?>
                        </div> 
                        <?php
                        $param = array(
                            'class' => 'form-horizontal',
                            'method' => 'post',
                            'id' => 'filterForm');
                        echo form_open('hirarc/hirarc', $param);
                        ?>

                        <div class="row m-t-10 m-l-80">
                            <div class="col-md-4">
                                <label>Status</label>
                                <?php
                                $compdata = array(
                                    'id' => 'status',
                                    'class' => 'form-control select2 ',
                                    'required' => true,
                                    'checkselect' => 'select2'
                                );
                                echo form_dropdown('status', $status_drop, $status, $compdata);
                                ?>
                            </div>
                        </div>

                        <!--                        <div class="row  marginStyl">
                                                    <div class="col-md-12">
                                                        <label class="btn btn-xs btn-info btnRefresh float-right"><i class="fa fa-sync"></i> Refresh</label>
                                                    </div>
                                                </div>-->

                        <?php echo form_close(); ?>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> HIRARC No </th>
                                        <th> Department</th>
                                        <th> Location </th>
                                        <th> Process/Location / Activity </th>
                                        <th> Task Status </th>
                                        <th> HIRARC Status </th>
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


        $(document).on("click", ".deletepsa", function (e) {
            e.preventDefault();
            var url = '<?php echo BASE_URL("hirarc/deletehirarc"); ?>';
            var deletId = $(this).attr("delt-id");

            deleteDatas(url, deletId, csrfName, csrfToken);
        });

        $("#status").on("change", function () {
            $("#filterForm").submit();
        });
       
    });
</script>

