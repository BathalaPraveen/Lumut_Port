
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('respflash'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Inspection Checklist Type</h3>
                            <a href="<?php echo BASE_URL('inspection/addInsp_checklist') ?>" class="btn btn-sm btn-primary float-right resptarget" >
                                <i class="fa fa-plus-circle"></i>  Add Checklist Type
                            </a>
                        </div>
                       
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <!--<th>Checklist Type ID</th>-->
                                        <th>Checklist Type</th>
                                        <th>Created on</th>
                                        <th>Action</th>
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
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<!----- popup ends----->



<script>

    $(document).ready(function () {
        
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
       var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
        $(document).on('click','.resptarget', function (e) {
            e.preventDefault();
            $('#respmodal').modal('show').find('.modal-content').load($(this).attr('href'));
        });
        
        $(document).on("click",".deleteInspchecklist",function(e){
             e.preventDefault();
       var url = '<?php echo BASE_URL("inspection/deleteInsp_checklist"); ?>';
       var deletId = $(this).attr("delt-id");
       
            deleteDatas(url,deletId,csrfName,csrfToken)
           
       
    });

    });
</script>

