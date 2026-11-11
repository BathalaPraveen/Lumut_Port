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
                            <h3 class="card-title">Port Security Access</h3>
                            <a href="<?php echo BASE_URL('psa/portsecurity/addpsa') ?>" class="btn btn-sm btn-primary float-right" >Add Port Security Access</a>
                        </div>
                        <?php
                        $param = array(
                            'class' => 'form-horizontal',
                            'method' => 'post',
                            'id' => 'filterForm');
                        echo form_open('psa/portsecurity', $param);
                        ?>

                        <div class="row m-t-10 m-l-80">
                            <div class="col-md-4">
                                <label>From Date</label>
                                <?php
                                $fromDate = [
                                    'name' => 'from_date',
                                    'id' => 'from_date',
                                    'class' => 'form-control datepicker dateFilt',
                                    'value' => $frmdate,
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Select From date'
                                ];
                                echo form_input($fromDate);
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label>To Date</label>
                                <?php
                                $toDate = [
                                    'name' => 'to_date',
                                    'id' => 'to_date',
                                    'class' => 'form-control datepicker dateFilt',
                                    'value' => $to_date,
                                    'autocomplete' => 'off',
                                    'placeholder' => 'Select To date'
                                ];
                                echo form_input($toDate);
                                ?>
                            </div> 
                        </div>

                        <div class="row  marginStyl">
                            <div class="col-md-12">
                                <label class="btn btn-xs btn-info btnRefresh float-right"><i class="fa fa-sync"></i> Refresh</label>
                            </div>
                        </div>

                        <?php form_close(); ?>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> PSS ID </th>
                                        <th> Name </th>
                                        <th> IC/Passport No</th>
                                        <th> Company Name </th>
                                        <th> Location </th>
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
            var url = '<?php echo BASE_URL("psa/portsecurity/deletepsa"); ?>';
            var deletId = $(this).attr("delt-id");

            deleteDatas(url, deletId, csrfName, csrfToken);
        });

        $(".dateFilt").on("change", function () {
            $("#filterForm").submit();
        });
        $('.btnRefresh').on('click',function() {
        window.location = 'portsecurity';
    });
    });
</script>

