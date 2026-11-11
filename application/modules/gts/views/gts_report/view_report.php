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

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {
        .datepicker {
            top:290px !important;
        }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
        .datepicker {
            top:300px !important;
        }
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
    <?php

     

    $FK_NOTIFY_TYPE_ID = postData($getgtslocdatas[0], 'FK_NOTIFY_TYPE_ID');
    $point = postData($getgtslocdatas[0], 'LOCA_POINT');
    $term = postData($getgtslocdatas[0], 'TERMINAL_NAME');
    $cont_id = postData($getgtslocdatas[0], 'CONT_ID');
    $contName = postData($getgtslocdatas[0], 'CONT_NAME');
    $emp_id = postData($getgtslocdatas[0], 'EMP_ID');
    $empName = postData($getgtslocdatas[0], 'EMP_NAME');
    $empDes = postData($getgtslocdatas[0], 'des');
    $conDes = postData($getgtslocdatas[0], 'desig');
    $displayStartDate = convertDate(postData($getgtslocdatas[0], 'GTS_DATE_TIME'), 'd-m-Y H:i:s');
    ?>

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

                                    <h4 class='title-head'>GTS Tracking Report </h4>
                                    <a href="<?php echo BASE_URL . 'gts/gts_report'; ?>"><button type="button" class="btn btn-primary backBtns"> Back</button></a>

                                </div>
                                <div class="card-body">
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                            Report Datas<span class="float-right"></span>

                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td class="tdlabel"><b>Guard Employee ID</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($FK_NOTIFY_TYPE_ID == 11) ? $cont_id : $emp_id; ?></td>
                                                            <td class="tdlabel"><b>Guard Name</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($FK_NOTIFY_TYPE_ID == 11) ? $contName : $empName; ?></td>

                                                        </tr>

                                                        <tr>
                                                            <td class="tdlabel"><b>Designation</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($FK_NOTIFY_TYPE_ID == 11) ? $conDes : $empDes; ?></td>

                                                            <td class="tdlabel"><b>Terminal</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $term; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>GTS location Point</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $point; ?></td>

                                                            <td class="tdlabel"><b>Date and Time</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $displayStartDate; ?></td>

                                                        </tr>
                                                    </table>
                                                    <label>Uploaded Images</label>
                                                    <div class="row col-md-12">
                                                        
                                                        <?php
                                                        if (is_array($getgtslocdatas)) {
                                                            foreach ($getgtslocdatas as $akey => $attachmnt) {
                                                                $filepath = postData($attachmnt, 'GTS_FILE_PATH');
                                                                $filename = postData($attachmnt, 'GTS_FILENAME');
                                                                $fileext = postData($attachmnt, 'GTS_FILE_EXT');
                                                                $fileFullpath = BASE_URL . $filepath;
                                                                $displayLabel = ($filepath !='') ? '<img src="' . $fileFullpath . '"/><div class="popupgal"><a data-fancybox="gallery" href="' . $fileFullpath . '"><i class="fa fa-search" aria-hidden="true"></i></a></div>' : $filename;
                                                                ?>
                                                                <div class="col-md-3 imagepopcombine" id='imagepopcombine_<?php echo $akey; ?>'>
                                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <div class="fileinput-preview img-thumbnail"  style="width: 200px; height: 150px;"><?php echo $displayLabel; ?></div>
                                                                    </div>	    
                                                                </div>

                                                                <?php
                                                            }
                                                            ?>
                                                        <?php } ?>
                                                    </div>
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
