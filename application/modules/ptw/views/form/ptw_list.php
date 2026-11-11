<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('permitflash'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $pageTitle; ?></h3>
                            <div class="float-right">
                                <a href="#" id="exportExcelBtn" class="btn btn-sm btn-primary mr-2">
                                    <i class="fa fa-file-export" aria-hidden="true"></i>&nbsp; Export Excel
                                </a>
                                <?php if ($addPermission) {
                                ?>
                                    <a href="<?php echo $addURL ?>" class="btn btn-sm btn-primary float-right"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; <?php echo $addButtonTitle; ?></a>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php
                            $formData = [
                                'class' => 'form-horizontal',
                                'id' => 'search_form',
                                'novalidate' => 'novalidate'
                            ];

                            echo form_open('#', $formData);
                            ?>
                            <div class="row m-t-10">
                                <div class="col-md">
                                    <label>Start Date </label><br>
                                    <div>

                                        <?php
                                        $data = array(
                                            'name' => 'start_date',
                                            'id' => 'start_date',
                                            'placeholder' => '',
                                            'class' => 'form-control datepicker',
                                            'autocomplete' => 'off',
                                            'value' => !empty($from_date) ? date('m/d/Y', strtotime($from_date)) : '',
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo form_error('start_date', '<div class="error">', '</div>'); ?>
                                        <span class="red"></span><br />


                                    </div>
                                </div>
                                <div class="col-md">
                                    <label>End Date </label><br>
                                    <div>
                                        <?php
                                        $data = array(
                                            'name' => 'end_date',
                                            'id' => 'end_date',
                                            'placeholder' => '',
                                            'class' => 'form-control datepicker',
                                            'autocomplete' => 'off',
                                            'value' => !empty($to_date) ? date('m/d/Y', strtotime($to_date)) : '',
                                        );

                                        echo form_input($data);
                                        ?>
                                        <?php echo form_error('end_date', '<div class="error">', '</div>'); ?>
                                        <span class="red"></span><br />


                                    </div>
                                </div>
                                <div class="col-md">
                                    <label>Status </label><br>
                                    <div>
                                        <?php
                                        $statusDetails = [
                                            'id' => 'status',
                                            'class' => 'form-control select2bs4 select2',
                                            'style' => 'width:100%',
                                        ];
                                        echo form_dropdown('status', $statusList, '', $statusDetails);
                                        ?>
                                        <?php echo form_error('location', '<div class="error">', '</div>'); ?>

                                    </div>

                                </div>
                                <div class="col-md" style="margin-top:8px;">
                                    <label></label><br>
                                    <button class="btn btn-success" id="searchbtn" name="search">Search</button>
                                    <input type="reset" class="btn btn-danger" id="reset" name="reset" value="Reset">
                                </div>
                            </div>
                            <?php
                            echo form_close();
                            ?>
                            <table id="ptw_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>PTW ID</th>
                                        <th>Location</th>
                                        <th>Specific Location</th>
                                        <th>Date and Time</th>
                                        <th>Applied By</th>
                                        <th>Status</th>
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
 function showtable(type) {
    if (type == 'reload') {
        $('#ptw_table').DataTable().clear().destroy();
    }

    var table = $('#ptw_table').DataTable({
        "bSort": false,
        responsive: true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-6'f><'col-sm-12 col-md-2'>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "ajax": {
            "url": "<?php echo isset($ajaxurl) ? site_url($ajaxurl) : '' ?>",
            "type": "POST",
            "data": function(d) {
                d.searchextra = $('#search_form').serializeArray();
                d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
            }
        }
    });

    return table;
}

    $(document).ready(function() {
        $(".datepicker").datepicker({
            autoclose: true
        });
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
        $(document).on('click', '.inc_event_target', function(e) {
            e.preventDefault();
            $('#rolemodal').modal('show').find('.modal-content').load($(this).attr('href'));
        });

        $('#start_date').datepicker({
            todayBtn: 1,
            autoclose: true,

        }).on('changeDate', function(selected) {

            var minDate = new Date(selected.date.valueOf());

            $('#end_date').datepicker('setStartDate', minDate);

        });

        showtable('init');

        $(document).on("click", ".deleteptw", function(e) {
            e.preventDefault();
            var url = '<?php echo $deleteURL; ?>';
            var deletId = $(this).attr("delt-id");

            deleteDatas(url, deletId, csrfName, csrfToken)


        });
        $(document).on("click", "#searchbtn", function(e) {
            e.preventDefault();
            var table = showtable('reload');
            table.draw();
        });
        $('#reset').click(function(e) {
            e.preventDefault();
            $('#start_date').val('');
            $('#end_date').val('');
            $('.select2').val('').trigger('change');
            $('form#search_form').trigger("reset");

            var tableids = showtable('reload');

            $('#start_date').removeData();
            $('#start_date').datepicker('setEndDate', false);
            $('#end_date').removeData();
            $('#end_date').datepicker('setStartDate', false);
            tableids.ajax.reload(null, false);
        });

    });
    $(document).on('click', '#exportExcelBtn', function(e) {
        e.preventDefault();

        // Get current URL
        const currentUrl = window.location.href;

        // Extract list type from URL path
        let listType = 'NORMAL'; // default
        if (currentUrl.includes('criticalList')) {
            listType = 'CRITICAL';
        }

        // Get filter values from form
        const searchstartDate = $('#start_date').val();
        const searchendDate = $('#end_date').val();
        const searchstatus = $('#status').val();

        // Build export URL with all parameters
        let exportUrl = '<?php echo BASE_URL("ptw/permit/generate_excel") ?>?';

        // Add list type parameter
        exportUrl += `type=${listType}&`;

        // Add existing URL parameters we want to keep
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('status')) exportUrl += `status=${urlParams.get('status')}&`;
        if (urlParams.has('year')) exportUrl += `year=${urlParams.get('year')}&`;
        if (urlParams.has('terminal')) exportUrl += `terminal=${urlParams.get('terminal')}&`;

        // Add filter parameters
        exportUrl += `start_date=${encodeURIComponent(searchstartDate)}&`;
        exportUrl += `end_date=${encodeURIComponent(searchendDate)}&`;
        exportUrl += `searchstatus=${encodeURIComponent(searchstatus)}`;

        // Remove trailing '&' if it exists
        exportUrl = exportUrl.replace(/&$/, '');

        // Redirect to export URL
        window.location.href = exportUrl;
    });
</script>