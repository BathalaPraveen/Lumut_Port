<?php

$SPECIFIC_LOC_ID = postData($editData, 'SPECIFIC_LOC_ID');
$SPECIFIC_LOC_NAME = postData($editData, 'SPECIFIC_LOC_NAME');

$SPECIFIC_LOC_DESC = postData($editData, 'SPECIFIC_LOC_DESC');
$TERMINAL_NAME = postData($editData, 'TERMINAL_NAME');

//print_r($editData);exit;
?>

<style>
    .viewpage {
        /*        font-size: 14px;*/
    }
    .newhr {
        margin-top: 15px;
        margin-bottom: 15px;
        border-color: white;
    }
    .card-header-inner{
        color: #fff;
        background-color: #007bff;
        font-weight: bold;
        text-transform: uppercase;
    }
    .card-link{
        color: #fff;
    }
    .card-header a:hover{
        color: #fff;
    }
    .red{
        color:red;
    }
    .removeItem:not(:disabled):not(.disabled).active, .removeItem:not(:disabled):not(.disabled):active, .removeItem,.removeItem:hover{
        color: #fff;
        background-color: red;
        border-color:red;
    }
    .uppertext{
        text-transform: uppercase;
    }
    .card-header-cc {
        color: #fff;
        background-color: green;
    }
    .docLabel{
        margin-left: 15px;
    }

    
    .tdlabel{
        width:23%;
    }
    .title-head{
        text-transform: uppercase;
    }
    .title-colon{
        width:1%;
    }
    .imagepopcombine:hover .popupgal {
        opacity: 1;
    }
    .popupgal{
        position: absolute;
        font-size: 3rem !important;
        color: #fff;
        opacity: 0;
        transition: .2s opacity ease-in-out;
        z-index: 5;
        background: #b7b7b77d;
        min-width: 82%;
        min-height: 90%;
        max-width: 90%;
        top: 0;
        text-align: center;
        border: 2px solid #007cb7;
    }
    .popupgal i{
        margin-top: 25%;
    }

</style>
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div id="accordion" class="permitAccordion">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">


                            <!-- general form elements -->
                            <div class="card card-headprimary">

                                <div class="card-header headingStyl ">

                                    <h4 class='title-head'>View Location </h4>
                                    <a href="<?php echo BASE_URL('master/LocationMaster') ?>"><button type="button" class="btn btn-primary backBtns"> Back</button></a>

                                </div>
                                <div class="card-body">
                                   
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                            Location Detail<span class="float-right"></span>
                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>Specific Location ID</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($SPECIFIC_LOC_ID != '') ? $SPECIFIC_LOC_ID : '-'; ?></td>
                                                 
                                                        </tr>

                                                        <tr>
                                                            <td class="tdlabel"><b>Terminal Name</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($TERMINAL_NAME != '') ? $TERMINAL_NAME : '-'; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="tdlabel"><b>Specific Location Name</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($SPECIFIC_LOC_NAME != '') ? $SPECIFIC_LOC_NAME : '-'; ?></td>
                                                        </tr>
                                                         <tr>
                                                            <td class="tdlabel"><b>Description</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td colspan="4"><?php echo ($SPECIFIC_LOC_DESC != '') ? $SPECIFIC_LOC_DESC : '-'; ?></td>
                                                        </tr>

                                                    </table>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                   
                                </div> 
                            </div>
                            <!-- /.card -->

                        </div>
                        <!--/.col (left) -->

                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
