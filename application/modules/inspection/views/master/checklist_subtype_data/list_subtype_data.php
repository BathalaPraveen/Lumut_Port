<style>
    /*    .alert-success {
        color: #fff;
        background: #28a745;
        border-color: #23923d;
    }
    .alert-danger {
        color: #fff;
        background: #dc3545;
        border-color: #d32535;
    }*/
    #stylDEsc{
        width: 100% ;
    overflow: hidden;
    display: inline-block;
    text-overflow: ellipsis;
    white-space: nowrap;
    }
    .subTypdatatab{
         margin: 0 auto;
  width: 100%;
  clear: both;
  border-collapse: collapse;
  table-layout: fixed;
  word-wrap:break-word; 
    }
</style>
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="" style="margin-top:10px;">
                <?php echo $this->session->flashdata('clsubflash'); ?>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title"> Checklist Subtype Data</h3>
                            <a href="<?php echo BASE_URL('inspection/add_insp_subtypedata') ?>" class="btn btn-sm btn-primary float-right" ><i class="fa fa-plus-circle"> Add Checklist Subtype Data</i></a>
                        </div>
                       
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped subTypdatatab">
                                <thead>
                                    <tr>
                                        <th>Checklist Type </th>
                                        <th>Checklist Subtype </th>
                                        <th>Checklist Subtype Data</th>
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



<script>

    $(document).ready(function () {
        
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
       var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
       
        
        $(document).on("click",".deletesubtypedata",function(e){
             e.preventDefault();
       var url = '<?php echo BASE_URL("inspection/delete_insp_subtypedata"); ?>';
       var deletId = $(this).attr("delt-id");
      
            deleteDatas(url,deletId,csrfName,csrfToken)
           
       
    });

    });
</script>

