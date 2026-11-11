
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('atarflash'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Overall Report</h3>
                             <a href="<?php echo BASE_URL('atar/overall/exportPdf') ?>" class="btn btn-sm btn-primary float-right" ><i class="fa fa-file-pdf"></i> Download Pdf</a>
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

                        <!-- Location -->
                             <div class="col-md-4 m-t-10">
                                <label>Terminal </label>
                                <?php
                                $eLoctdata = [
                                    'class' => 'form-control select2',
                                    'id' => 'location',
                                    'checkSelect' => 'select2',
                                    'onchange' => 'getAjaxLocation(this.value)',
                                ];
                                echo form_dropdown('ATAR_LOC_ID', $getLocInfo, $editTerminalId, $eLoctdata);
                                ?>
                                <span class="error"><?php echo form_error('ATAR_LOC_ID') ?></span>

                            </div>

                            <!-- Specific Location -->
                            <div class="col-md-4 m-t-10">
                                <label>Specific Location </label>
                                <?php
                                $eSpecificdata = [
                                    'class' => 'form-control select2',
                                    'id' => 'specific_loc',
                                    'checkSelect' => 'select2',
                                ];
                                echo form_dropdown('ATAR_SPEC_LOC_ID', $getSpecLocInfo, $editSpecificLocationId, $eSpecificdata);
                                ?>
                                <span class="error"><?php echo form_error('ATAR_SPEC_LOC_ID') ?></span>
                            </div>

                            <!-- Reporter Name  -->
                            <div class="col-md-4 m-t-10" style="display:none;"> 
                                <label >Reporter Name</label><br>
                              
                                    <?php
                                    $reporternamedetails = [
                                        'id' => 'reporter_name',
                                        'class' => 'form-control select2bs4 select2',
                                    ];
                                    echo form_dropdown('reporter_name', $getEmployeeList, '', $reporternamedetails);
                                    ?>
                                
                                <span class="red"></span>
                            </div>

                            
                           </div>
                           <div class="row m-t-10" >
                             <!-- Assigned Person Name  -->
                            <div class="col-md-4 m-t-10" style="display:none;" > 
                                <label>Assigned Person</label><br>
                              
                                    <?php
                                    $assignedpersonnamedetails = [
                                        'id' => 'assigned_person_name',
                                        'class' => 'form-control select2bs4 select2',
                                    ];
                                    echo form_dropdown('assigned_person_name', $getEmployeeAssignedList, '', $assignedpersonnamedetails);
                                    ?>
                                
                                <span class="red"></span>
                            </div>

                            <!-- Search & Reset Buttons -->
                            <div class="col-md-4 m-t-10" style="margin-top: 40px;">
                                <button class="btn btn-success" id="searchbtn" name="search">Search</button>
                                <input type="reset" class="btn btn-danger" id="reset" name="reset" value="Reset">
                            </div>
                       </div>
                      <br>
                        <?php echo form_close(); ?>
                            <table id="overallatar1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> Category </th>
                                        <th> Location </th>
                                        <th> Date & Time </th>
                                        <th> Status </th>
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


<script type="text/javascript">
    $('#specific_loc').change(function () {
        //alert("sdgsdgs")
        var vals = $(this).val();
        if (vals === '-1') {
            $('#ATAR_SPEC_LOC_OTHER').removeClass('d-none');
            $('.specificOther').removeClass('d-none');
        } else {
            $('#ATAR_SPEC_LOC_OTHER').addClass('d-none');
             $('.specificOther').addClass('d-none');
        }
    });


    function getAjaxLocation(id) {
         //alert(id);
        var url = "<?php echo BASE_URL('common/getAjaxLocation') ?>";
        var data = {terminalID: id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
        $.ajax({
            dataType: 'json',
            data: 'ajax',
            method: 'post',
            data: data,
            url: url,
            success: function (resp) {
                $("#specific_loc").html(resp.loctdatas)
            }
        });

    }
  

</script>
<script>
    function showtable(type) {
        if (type == 'reload') {
            $('#overallatar1').DataTable().clear().destroy();
        }
        var tname = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var table = $('#overallatar1').DataTable({
            "bSort": false,
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-6'f><'col-sm-12 col-md-2'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "ajax": {
                "url": "<?php echo isset($ajaxurl) ? site_url($ajaxurl) : '' ?>",
                "type": "POST",
                 "data": function(d) {
                    d.searchextra = $('#search_form').serializeArray();
                    d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
                }
            },

            buttons: [{
                extend: 'print',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }, {
                extend: 'pdf',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }, {
                extend: 'excel',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }]
        });
        table.buttons().container()
            .appendTo($('div.eight.column:eq(0)', table.table().container()));
        $('.dt-buttons').find('.buttons-pdf').empty().removeClass('dt-button');
        $('.dt-buttons').find('.buttons-print').empty().removeClass('dt-button');
        $('.dt-buttons').find('.buttons-excel').empty().removeClass('dt-button');
        $('.dt-buttons').find('.buttons-copy').empty().removeClass('dt-button');
        $('.dt-buttons').find('.buttons-csv').empty().removeClass('dt-button');
        var pdfPath = '<i class="fa fa-file-pdf" aria-hidden="true" style="font-size: 24px;color: #ffffff;"></i>';
        var printPath = '<i class="fa fa-print" aria-hidden="true"  style="font-size: 24px;color: #ffffff;"></i>';
        var excelPath = '<i class="fa fa-file-excel" aria-hidden="true" style="font-size: 24px;color: #ffffff;"></i>';
        //        var copyPath = '<i class="fa fa-files-o" aria-hidden="true"  style="font-size: 24px;color: #da4e4e;"></i>';
        //        var csvPath = '<i class="fa fa-file-excel-o" aria-hidden="true" style="font-size: 24px;color: green;"></i>';
        $('.dt-buttons').find('.buttons-pdf').append(pdfPath).attr("data-toggle", 'tooltip').attr('title', 'Export to PDF').attr('data-placement', 'bottom');
        $('.dt-buttons').find('.buttons-print').append(printPath).attr("data-toggle", 'tooltip').attr('title', 'Print').attr('data-placement', 'bottom');
        $('.dt-buttons').find('.buttons-excel').append(excelPath).attr("data-toggle", 'tooltip').attr('title', 'Export to Excel').attr('data-placement', 'bottom');
        //        $('.dt-buttons').find('.buttons-copy').append(copyPath).attr("data-toggle", 'tooltip').attr('title', 'Copy').attr('data-placement', 'bottom');
        //        $('.dt-buttons').find('.buttons-csv').append(csvPath).attr("data-toggle", 'tooltip').attr('title', 'Export to CSV').attr('data-placement', 'bottom');
        return table;

    }
    $(document).ready(function() {
        showtable('init');
        $(document).on("click", "#searchbtn", function(e) {
            e.preventDefault();
            var table = showtable('reload');
            table.draw();
        });
          $('#reset').click(function(e) {
            e.preventDefault();
            $('.select2').val('').trigger('change');
            $('form#search_form').trigger("reset");
            var tableids = showtable('reload');
            tableids.ajax.reload(null, false);
        });

    });
</script>

