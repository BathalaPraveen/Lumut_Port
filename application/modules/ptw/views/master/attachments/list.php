
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
		<?php echo $this->session->flashdata('atflash'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $pageTitle; ?></h3>
                            <a href="<?php echo BASE_URL('ptw/masters/addAT') ?>" class="btn btn-sm btn-primary float-right inc_event_target" ><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add <?php echo $pageTitle; ?></a>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Name</th>
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
<div class="modal modal-info fade" id="rolemodal" role="basic" aria-hidden="true">
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
	$(document).on('click', '.inc_event_target', function (e) {
	    e.preventDefault();
	    $('#rolemodal').modal('show').find('.modal-content').load($(this).attr('href'));
	});

	$(document).on("click", ".deleteAT", function (e) {
	    e.preventDefault();
	    var url = '<?php echo $deleteURL; ?>';
	    var deletId = $(this).attr("delt-id");

	    deleteDatas(url, deletId, csrfName, csrfToken)


	});

    });
</script>

