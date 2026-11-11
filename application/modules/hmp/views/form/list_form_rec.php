<?php
    
    
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
                            <h3 class="card-title">Record Master List</h3>
                            <?php
                            $groupid = getCurrentUserGroupId(); 
                                if($groupid == 6 || $groupid == 7 || is_admin()){
                        ?>
                            <a href="<?php echo BASE_URL('hmp/rec/addRec') ?>" class="btn btn-sm btn-primary float-right" >Add Record Master</a>
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
                            
                            echo form_open('hmp/rec/recInfo', $formData);
                            ?>
                          
                            <?php 
                            echo form_close(); ?>
                            
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> Record ID </th>
                                        <th> Record Name </th>
                                        <th> Terminal </th>
                                        <th> Record Date </th>
                                        <th> Expiry Date </th>
                                        
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


        $(document).on("click", ".deleteHmp", function (e) {
            e.preventDefault();
            var url = '<?php echo BASE_URL("hmp/rec/deleteRec"); ?>';
            var deletId = $(this).attr("delt-id");

            deleteDatas(url, deletId, csrfName, csrfToken)


        });
       

    });
</script>

