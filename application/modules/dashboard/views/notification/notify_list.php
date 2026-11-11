<!-- Content Wrapper. Contains page content -->


<style>
     /* .even{
        background-color: #cdf0f7 !important;
    }*/
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="vd_panel-header">
        <ul class="breadcrumb">
            <li><a href="#">Master</a> </li>
            <li class="active">Incident Management</li>
        </ul>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="row">            
            <div class="col-md-12">
                <div>
                    <?php echo $this->session->flashdata('incd'); ?>
                </div> 
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title main-heading">Notification List</h3>
                      
                    </div>
                    <!-- /.box-header -->
                    <!-- box-body -->                           
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="table" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr >
                                            <th>Message</th>
                                            <th>Created On</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box primary -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

