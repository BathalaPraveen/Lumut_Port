<?php
   $start = $this->input->post('start_date')
        ? $this->input->post('start_date')
        : $this->input->get('start_date');

    $end = $this->input->post('end_date')
        ? $this->input->post('end_date')
        : $this->input->get('end_date');
    if($start != ""){
        $hmpFdate = date('d-m-Y', strtotime($start));
    }else{
        $hmpFdate = "";
    }
    if($end != ""){
        $hmpTdate = date('d-m-Y', strtotime($end));
    }else{
        $hmpTdate = "";
    }
    
?>
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('hmpflash'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        
                        <div class="card-header">
                            <h3 class="card-title">Program List</h3>
                            <?php
                            $groupid = getCurrentUserGroupId(); 
                                if($groupid == 6 || $groupid == 7 || is_admin()){
                        ?>
                            <a href="<?php echo BASE_URL('hmp/hmp/addHmp') ?>" class="btn btn-sm btn-primary float-right" >Add Program</a>
                            <?php }?>
                        </div>
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php 
                            $formData = [
                                 'class'=>'form-horizontal',
                                 'id'=>'search_form',
                                 'novalidate'=>'novalidate',
                                'id' => 'filterForm'
                                 ];
                            
                            echo form_open('hmp/hmp/hmpInfo', $formData);
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
                                            'class' => 'form-control  dateFilt',
                                            'autocomplete' => 'off',
                                            'value' => $hmpFdate,
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
                                            'class' => 'form-control  dateFilt',
                                            'autocomplete' => 'off',
                                            'value' => $hmpTdate,
                                        );

                                        echo form_input($data);
                                        ?> 
                                        <?php echo form_error('end_date', '<div class="error">', '</div>'); ?>
                                        <span class="red"></span><br/>
                                       

                                    </div>
                                </div>
                             
                                <div class="col-md" style="margin-top:8px;">  
                                 <label ></label><br>
                                <input type="reset"  class="btn btn-danger btnRefresh" id="reset" name="reset"  value="Reset">
                               </div>
                            </div>
                            <?php 
                            echo form_close(); ?>
                            
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> HSSE Program ID </th>
                                        <th> Program Name </th>
                                        <th> Start Date </th>
                                        <th> End Date </th>
                                        <th> Location </th>
                                        <th> Department </th>
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
<script>

  $(document).ready(function () {
      
      $(".dateFilt").on("change",function(){
            $("#filterForm").submit();
      });
      
        $(".datepicker").datepicker({
	    autoclose: true
	});
      
       
        $("#start_date").datepicker({
	    autoclose: true,
            startDate: new Date(),
            format: 'dd-mm-yyyy'
	}).on('changeDate', function (selected) {
            
	    var minDate = new Date(selected.date.valueOf());
	     $('#end_date').datepicker('setStartDate', minDate);

	});
        $("#end_date").datepicker({
	    autoclose: true,
            startDate: new Date(),
            format: 'dd-mm-yyyy'
	}).on('changeDate', function (selected) {
	    var minDate = new Date(selected.date.valueOf());
	    
	});
        
        $(".btnRefresh").on('click',function(){
       
            window.location = '<?php echo BASE_URL("hmp/hmp/hmpInfo") ?>'
        });
  });

</script>
<script>

  $(document).ready(function () {

        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';


        $(document).on("click", ".deleteHmp", function (e) {
            e.preventDefault();
            var url = '<?php echo BASE_URL("hmp/hmp/deleteHmp"); ?>';
            var deletId = $(this).attr("delt-id");

            deleteDatas(url, deletId, csrfName, csrfToken)


        });
       

    });
</script>

