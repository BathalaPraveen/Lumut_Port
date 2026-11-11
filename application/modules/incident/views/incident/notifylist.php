
<style type="text/css">
    
    .buttons-copy{
        display: none;
    }
    .buttons-csv{
        display: none;
    }
</style>

<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
		<?php echo $this->session->flashdata('incflash'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                       <?php if($_SESSION['userinfo']->USER_TYPE_ID == '4' || $_SESSION['userinfo']->USER_TYPE_ID == '5' || $_SESSION['userinfo']->USER_TYPE_ID == '1' || $_SESSION['userinfo']->USER_TYPE_ID == '2' || $_SESSION['userinfo']->USER_TYPE_ID == '6' || $_SESSION['userinfo']->USER_TYPE_ID == '7'){ ?>
                        <div class="card-header  card-headprimary">
                            <h3 class="card-title"><?php echo $pageTitle; ?></h3>
                            <a href="<?php echo BASE_URL('incident/notify') ?>" class="btn btn-sm btn-primary float-right" ><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add Incident Notification</a>
                        </div>
                       <?php } ?>
                        <!-- /.card-header -->
                         <div class="card-body">
                            <?php 
                            $formData = [
                                 'class'=>'form-horizontal',
                                 'id'=>'search_form',
                                 'novalidate'=>'novalidate'
                                 ];
                            
                            echo form_open('#', $formData);
                            ?>
                            <div class="row m-t-10">
                                

                                <div class="col-md">  
                                    <label >Start Date </label><br>
                                    <div>

                                        <?php
                                        $data = array(
                                            'name' => 'start_date',
                                            'id' => 'start_date',
                                            'placeholder' => '',
                                            'class' => 'form-control datepicker',
                                            'autocomplete' => 'off',
                                            'value' => !empty($from_date) ? date('d-m-Y', strtotime($from_date)) : '',
                                        );

                                        echo form_input($data);
                                        ?>  
                                        <?php echo form_error('start_date', '<div class="error">', '</div>'); ?>
                                        <span class="red"></span><br/>
                                       

                                    </div>
                                </div>

                                <div class="col-md">  
                                    <label >End Date </label><br>
                                    <div>
                                        <?php
                                        $data = array(
                                            'name' => 'end_date',
                                            'id' => 'end_date',
                                            'placeholder' => '',
                                            'class' => 'form-control datepicker',
                                            'autocomplete' => 'off',
                                            'value' => !empty($to_date) ? date('d-m-Y', strtotime($to_date)) : '',

                                        );

                                        echo form_input($data);
                                        ?> 
                                        <?php echo form_error('end_date', '<div class="error">', '</div>'); ?>
                                        <span class="red"></span><br/>
                                       

                                    </div>
                                </div>
                                <div class="col-md">  
                                <label >Status </label><br>
                                <div>
                                    <select class="form-control NotifyStatus" name="NotifyStatus" id="NotifyStatus">
                                                   <option value="">Select - Status </option>
                                                   <?php 
                                                      foreach($notifyStatusList as $nl){
                                                         ?>
                                                   <option value="<?php echo $nl['INC_NOTIFY_STATUS_ID']?>"><?php echo $nl['INC_FORM_STATUS_NAME']?></option>
                                                   <?php } ?>
                                </select>
                                   
                                   
                                </div>
        
                               </div>
                                <div class="col-md" style="margin-top:8px;">  
                                 <label ></label><br>
                                 <button  class="btn btn-success" id="searchbtn" name="search">Search</button>
                                 <input type="reset"  class="btn btn-danger" id="reset" name="reset"  value="Reset">
                               </div>
                            </div>
                            <?php 
                            echo form_close();
                            ?>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Incident ID</th>
                                        <th>Location</th>
                                        <th>Specific Location</th>
					<th>Date and Time</th>
                                        <th>Reported By</th>
                                        <th>Status</th>
<!--                                        <th></th>
                                        <th></th>
                                        <th></th>-->
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

	$(document).on("click", ".deleteInc", function (e) {
	    e.preventDefault();
	    var deletId = $(this).attr("delt-id");
            var tableName = 'INCIDENT_NOTIFICATION_DETAILS';
            var prmyId = 'INCIDENT_NOTIFY_ID';
            var whrId = 'NOTIFY_STATUS';
            var url = '<?php echo BASE_URL("incident/deleteIncNotifyInfo"); ?>';
            
            deleteDatas(url, deletId, csrfName, csrfToken)
            //var data = {deletId:deletId,tableName:tableName,prmyId:prmyId,whrId:whrId, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'};
//             $.ajax({
//                type:'POST',
//                url:url,
//                data:data,
//                success: function(data){
//                  
//                  }
//                });


	});
    function showtable(type){
       // alert(1);
      
    if(type =='reload'){

       $('#example1').DataTable().clear().destroy();
    }
    var tname = '<?php echo $this->security->get_csrf_token_name(); ?>';

    var table = $('#example1').DataTable({
        destroy: true,
         "bSort": false,
            responsive: true,
             "processing": true, 
            "serverSide": true, 

   
           // dom: "<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
             dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-6'f><'col-sm-12 col-md-2'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "ajax": {
                "url": "<?php echo isset($ajaxurl) ? site_url($ajaxurl) : '' ?>",
                "type": "POST",
                "data": function (d) {
            d.searchextra = $('#search_form').serializeArray();
                    d.<?php echo $this->security->get_csrf_token_name(); ?> ='<?php echo $this->security->get_csrf_hash(); ?>';
        }
        },
            buttons: [{
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }}, {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }}, {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }}]
              
           
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

       
        $('.dt-buttons').find('.buttons-pdf').append(pdfPath).attr("data-toggle", 'tooltip').attr('title', 'Export to PDF').attr('data-placement', 'bottom');
        $('.dt-buttons').find('.buttons-print').append(printPath).attr("data-toggle", 'tooltip').attr('title', 'Print').attr('data-placement', 'bottom');
        $('.dt-buttons').find('.buttons-excel').append(excelPath).attr("data-toggle", 'tooltip').attr('title', 'Export to Excel').attr('data-placement', 'bottom');
       
    return table;   
}
    $(document).ready(function () {
         $(".datepicker").datepicker({
        autoclose: true
    });
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
        $(document).on('click', '.inc_event_target', function (e) {
            e.preventDefault();
            $('#rolemodal').modal('show').find('.modal-content').load($(this).attr('href'));
        });
        
        $('#start_date').datepicker({
        todayBtn: 1,
        autoclose: true,
            
    }).on('changeDate', function (selected) {
           
        var minDate = new Date(selected.date.valueOf());
            
        $('#end_date').datepicker('setStartDate', minDate);
           
    });
    
        showtable('init');

       
         $(document).on("click", "#searchbtn", function (e) {
            e.preventDefault();
            var table = showtable('reload');
            table.draw();
        });
        $('#reset').click(function (e) {
             e.preventDefault();
            $('#start_date').val('');
            $('#wildcardSearch').val('');
            $('#end_date').val('');
            $('#NotifyStatus').val('').trigger('change');
            $('form#search_form').trigger("reset");

            var tableids = showtable('reload');
            
            $('#start_date').removeData();
            $('#wildcardSearch').removeData('');
            $('#start_date').datepicker('setEndDate', false);
            $('#end_date').removeData();
            $('#end_date').datepicker('setStartDate', false);
            tableids.ajax.reload( null, false );
    });
       
     });   

    });
</script>

