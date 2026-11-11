<style>
 

</style>

<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('inspcTn'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Inspection List</h3>
                           <?php  
                           
                           $userTypID = getCurrentUserGroupId(); 
                           $designId = getParticsessdata('USER_DESINATION_ID');
                           if($userTypID == 6 || $userTypID == 7 || ($userTypID == 4 && $designId == 19)){
                           ?>
                             <a href="<?php echo BASE_URL('inspection/addInspection') ?>" class="btn btn-sm btn-primary float-right" ><i class="fa fa-plus-circle"> Add Inspection</i></a>
                           <?php } ?>
                        </div>
                       
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped tableLoad">
                                <thead>
                                    <tr>
                                        <th> Inspection ID </th>
                                        <th> Inspection Date </th>
                                        <th> Type of Inspection </th>
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
        
       var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
       var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
       
        
        $(document).on("click",".deleteInspection",function(e){
             e.preventDefault();
       var url = '<?php echo BASE_URL("inspection/deleteInspection"); ?>';
       var deletId = $(this).attr("delt-id");
       
            deleteDatas(url,deletId,csrfName,csrfToken)
           
       
    });
    
   
     
    });
</script>

