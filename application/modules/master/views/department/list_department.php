
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('department'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Department</h3>
                            <a href="<?php echo BASE_URL('master/department/addDepartment') ?>" class="btn btn-sm btn-primary float-right" >Add Department</a>
                        </div>
                       
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> Department ID </th>
                                        <th> Terminal Name </th>
                                        <th> Department Name </th>
                                        <th> Email ID</th>
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
       
        
        $(document).on("click",".deleteDepartment",function(e){
             e.preventDefault();
       var url = '<?php echo BASE_URL("master/department/deleteDepartment"); ?>';
       var deletId = $(this).attr("delt-id");
       
            deleteDatas(url,deletId,csrfName,csrfToken)
           
       
    });

    });
</script>

