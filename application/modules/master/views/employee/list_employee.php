
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('employee'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-header">
                            <div class="col-9">
                            <h3 class="card-title">Employee Management</h3>
                        </div>
                           <div class="col-3 float-right">
                               <a href="<?php echo BASE_URL('master/employeeUpload') ?>" class="btn btn-sm btn-primary " ><i class="fa fa-upload"></i> Bulk Upload</a>
                            <a href="<?php echo BASE_URL('master/employee/addEmployee') ?>" class="btn btn-sm btn-primary " ><i class="fa fa-plus-circle"></i> Add Employee</a>
                             </div>
                        </div>
                       
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> Employee ID </th>
                                        <th> Employee Name </th>
                                        <th> Designation</th>
                                        <th> Department</th>
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

<!----- popup starts----->
<div class="modal modal-info fade" id="respmodal" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
    </div>
</div>
<!----- popup ends----->




<script>

    $(document).ready(function () {
        
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
       var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
       
        $(document).on('click','.emplStatus', function (e) {
            e.preventDefault();
            $('#respmodal').modal('show').find('.modal-content').load($(this).attr('href'));
        });
        
        $(document).on("click",".deleteEmployee",function(e){
             e.preventDefault();
       var url = '<?php echo BASE_URL("master/employee/deleteEmployee"); ?>';
       var deletId = $(this).attr("delt-id");
       
            deleteDatas(url,deletId,csrfName,csrfToken)
           
       
    });

    });
</script>

