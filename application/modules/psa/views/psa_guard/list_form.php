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
                            <a href="<?php echo BASE_URL('psa/PSAUpload') ?>" class="btn btn-sm btn-primary float-right"><i class="fa fa-upload"></i> Bulk Upload</a>
                            <a href="<?php echo BASE_URL('psa/psa_report/exportPdf') ?>" class="btn btn-sm btn-primary float-right  m-r-10"><i class="fa fa-file-pdf"></i> Download Pdf</a>
                            <a href="<?php echo BASE_URL('psa/psa_report/exportExcel') ?>" class="btn btn-sm btn-primary float-right m-r-10"><i class="fa fa-file-excel"></i> Download Excel</a>
                        </div>
                        <?php
                        $param = array(
                            'class' => 'form-horizontal',
                            'method' => 'post',
                            'id' => 'filterForm'
                        );
                        echo form_open('psa/psa_report/psa_guard', $param);
                        ?>

                        <div class="row m-t-10 m-l-80">
                            <div class="col-md-4">
                                <label>IC/Passport No</label>
                                <?php
                                $getTerId = isset($getPsadatas->VEC_TYPE) && !empty($getPsadatas->VEC_TYPE) ? $getPsadatas->VEC_TYPE : set_value('port[VEC_TYPE]');
                                $termdata = array(
                                    'id' => 'ic_no',
                                    'class' => 'form-control select2',
                                    'required' => true,
                                    'checkselect' => 'select2'
                                );
                                echo form_dropdown('ic_no', $getIcdatas, $ic_no, $termdata);
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label>Name</label>
                                <?php
                                $getTerId = isset($getPsadatas->VEC_TYPE) && !empty($getPsadatas->VEC_TYPE) ? $getPsadatas->VEC_TYPE : set_value('port[VEC_TYPE]');
                                $termdata = array(
                                    'id' => 'name',
                                    'class' => 'form-control select2',
                                    'required' => true,
                                    'checkselect' => 'select2'
                                );
                                echo form_dropdown('name', $getNamedatas, $name, $termdata);
                                ?>
                            </div>
                            <?php if ($user_type == 1) { ?>
                                <div class="col-md-3">
                                    <label>Status (Induction Due Date)</label>
                                    <?php
                                    $getStatdatas = [
                                        '' => 'Select Status (Induction Due Date)',
                                        '1' => 'Expired',
                                        '2' => 'Valid'
                                    ];

                                    $stdata = array(
                                        'id' => 'stat',
                                        'class' => 'form-control select2',
                                        'required' => true,
                                        'checkselect' => 'select2'
                                    );
                                    echo form_dropdown('stat', $getStatdatas, $stat, $stdata);
                                    ?>
                                </div>
                            <?php } ?>

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
                              <!-- <div class="col-md-3">
                                    <label>Company Name</label>
                                    <?php
                                    // $getStatdatas = [
                                    //     '' => 'Select Status (Induction Due Date)',
                                    //     '1' => 'Expired',
                                    //     '2' => 'Valid'
                                    // ];

                                    // $stdata = array(
                                    //     'id' => 'stat',
                                    //     'class' => 'form-control select2',
                                    //     'required' => true,
                                    //     'checkselect' => 'select2'
                                    // );
                                    // echo form_dropdown('cname', $getCNamedatas, $cname, $stdata);
                                    ?>
                                </div> -->

                            <div class="col-md-4">
                                <label class="btn btn-xs btn-info btnRefresh m-t-10"><i class="fa fa-sync"></i> Refresh</label>
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
                                        <th>Induction Due Date</th>
                                        <th> Company Name </th>
                                        <th> Location </th>
                                        <th> Acknowledged By </th>
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
    $(document).ready(function() {

        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';


        $(document).on("click", ".deletepsa", function(e) {
            e.preventDefault();
            var url = '<?php echo BASE_URL("psa/portsecurity/deletepsa"); ?>';
            var deletId = $(this).attr("delt-id");

            deleteDatas(url, deletId, csrfName, csrfToken);
        });

        $("#name,#ic_no,#stat,#from_date,#to_date").on("change", function() {
            $("#filterForm").submit();
        });
        $('.btnRefresh').on('click', function() {
            window.location = 'psa_guard';
        });
    });
</script>