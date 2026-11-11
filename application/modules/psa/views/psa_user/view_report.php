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
//    echo '<pre>';
//    print_r($getPsadatas); exit;
    $NAME = postData($getPsadatas[0], 'NAME');
    $ID_TYPE = postData($getPsadatas[0], 'ID_TYPE');
    if($ID_TYPE == '1') {
        $idval =  'IC';
    } elseif($ID_TYPE == '2') {
         $idval =  'PassPort';
    }
    $PASS_NO = postData($getPsadatas[0], 'PASS_NO');
    $COMP_NAME = postData($getPsadatas[0], 'COMP_NAME');
    $term = postData($getPsadatas[0], 'TERMINAL_NAME');
    $DESIG = postData($getPsadatas[0], 'DESIG');
    $contName = postData($getPsadatas[0], 'CONT_NAME');
    $IND_DATE = convertDate(postData($getPsadatas[0], 'IND_DATE'),'d-m-Y');
    $IND_DUE_DATE = convertDate(postData($getPsadatas[0], 'IND_DUE_DATE'),'d-m-Y');
    $VEC_ENTRY_DATE = convertDate(postData($getPsadatas[0], 'VEC_ENTRY_DATE_TIME'),'d-m-Y');
    $VEC_ENTRY_TIME = date('h:i:s', strtotime(postData($getPsadatas[0], 'VEC_ENTRY_DATE_TIME')));
    $VEC_EXIT_DATE = convertDate(postData($getPsadatas[0], 'VEC_EXIT_DATE_TIME'),'d-m-Y');
    $VEC_EXIT_TIME = date('h:i:s', strtotime(postData($getPsadatas[0], 'VEC_EXIT_DATE_TIME')));
    $VEC_TYPE = postData($getPsadatas[0], 'VEC_TYPE');
    global $vechical_type;
    $vec_name = $vechical_type[$VEC_TYPE];
    $VEC_OTHER = postData($getPsadatas[0], 'VEC_OTHER');
    $VEC_NO = postData($getPsadatas[0], 'VEC_NO');
    $PURPOSE = postData($getPsadatas[0], 'PURPOSE');
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

                                    <h4 class='title-head'>Port Security Access </h4>
                                    <a href="<?php echo BASE_URL . 'psa/portsecurity'; ?>"><button type="button" class="btn btn-primary backBtns"> Back</button></a>

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
                                                            <td class="tdlabel"><b>Name</b></td>
                                                            <td>:</td>
                                                            <td ><?php echo ($NAME != '') ? $NAME : 'Nil'; ?></td>
                                                            <td class="tdlabel"><b>ID Type</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($idval != '') ? $idval : 'Nil'; ?></td>

                                                        </tr>

                                                        <tr>
                                                            <td class="tdlabel"><b>IC/Passport No</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo ($PASS_NO != '') ? $PASS_NO : 'Nil'; ?></td>

                                                            <td class="tdlabel"><b>Company Name</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $COMP_NAME; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Designation</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $DESIG; ?></td>

                                                            <td class="tdlabel"><b>Terminal</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $term; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Induction Date</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $IND_DATE; ?></td>

                                                            <td class="tdlabel"><b>Induction Due Date</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php echo $IND_DUE_DATE; ?></td>

                                                        </tr>
<!--                                                        <tr>
                                                            <td class="tdlabel"><b>Vehicle Type</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php // echo $vec_name; ?></td>
 
                                                            <td class="tdlabel"><b>Vehicle Number</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php // echo ($VEC_NO != '') ? $VEC_NO : 'Nil'; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <?php // if($VEC_TYPE == '5') { ?>
                                                            <td class="tdlabel"><b>Vehicle Other</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php // echo $VEC_OTHER; ?></td>
                                                            <?php // } ?>
                                                            <td class="tdlabel"><b>Purpose</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php // echo $PURPOSE; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Vehicle Entry Date</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php // echo $VEC_ENTRY_DATE; ?></td>
                                                            <td class="tdlabel"><b>Vehicle Entry Time</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php // echo $VEC_ENTRY_TIME; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="tdlabel"><b>Vehicle Exit Date</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php // echo $VEC_EXIT_DATE; ?></td>
                                                            <td class="tdlabel"><b>Vehicle Exit Time</b></td>
                                                            <td class="title-colon">:</td>
                                                            <td ><?php // echo $VEC_EXIT_TIME; ?></td>
                                                        </tr>-->
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                
                                <div class="card-body">
                                    <div class="card ">
                                        <div class="card-header card-header-inner">
                                            Certificate Details<span class="float-right"></span>

                                        </div>

                                        <div class="card-body">
                                            <div class="row viewpage">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-striped">
                                                       <thead style="background: #aba90b;font-weight: bold;color:#ffff;text-align:center;">
                                                        <tr>
                                                            <td style="width:20%">S/No</td>
                                                            <td style="width:20%">Certificate Name</td>
                                                            <td style="width:10%">Start Date</td>
                                                            <td style="width:10%">End Date</td>
                                                            <td style="width:40%">Certificate</td>
                                                        </tr>
                                                    </thead>

                                                     
                                                <?php
                                                $i = 1;
                                                $checkData='';
//                                                echo "<pre>";
//                                                print_R($getOthercertdet);
//                                                exit;
                                                if(isset($getOthercertdet) && !empty($getOthercertdet)){
                                                foreach ($getOthercertdet as $insDKey => $InsData) {
                                                    $fileExtn = postData($InsData,'CERT_EXT');
                                                   $bfrKeyval = $insDKey-1;
                                                  
                                                    ?>
                                                <tbody style="text-align:center;">
                                                   
                                                        <tr>
                                                            <td style="width:20%"><?php echo $i++; ?></td>
                                                            <td style="width:20%;"><?php echo $InsData->CERT_NAME; ?></td>
                                                            <td style="width:10%"><?php echo date("d-m-Y",strtotime($InsData->CERT_START_DATE)); ?></td>
                                                            <td style="width:10%"><?php echo date("d-m-Y",strtotime($InsData->CERT_END_DATE)); ?></td>
                                                           <?php if($InsData->CERT_FILE_NAME != ''){ ?>
                                                            <td style="width:40%">
                                                                <?php if($fileExtn != '.pdf'){ ?>
                                                                <img src="<?php echo BASE_URL.$InsData->CERT_PATH.''.$InsData->CERT_FILE_NAME; ?>" style="height:15%" alt="<?php echo $InsData->CERT_FILE_NAME; ?>">
                                                                <?php }else{ ?>
                                                                <a href="<?php echo BASE_URL.$InsData->CERT_PATH.''.$InsData->CERT_FILE_NAME; ?>" target="blank"><?php echo $InsData->CERT_FILE_NAME; ?></a>
                                                                <?php } ?>
                                                            </td>
                                                           <?php }else{ ?>
                                                            <td style="width:40%"> - </td>
                                                           <?php } ?>
                                                        </tr>
                                                        
                                                    
                                                <?php }}else{ ?>
                                                       <tr style="text-align:center"> <td  colspan="4">No data Available<td> </tr>
                                                <?php } ?>
                                                     </tbody>      
                                                    
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
