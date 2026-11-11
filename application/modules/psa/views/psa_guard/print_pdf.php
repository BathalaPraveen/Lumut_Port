<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:230px;height:70px;">';
?>
<html>
    <head>
        <style>
            .left_align{
                margin-top: 20px;
                text-align: left;
                margin-left: 20px;
            }
            .mtop{
                margin-top: 20px;
            }
            .mpadding{
                padding:0px !important;
            }
            .fbold{
                font-weight:bold;
            }
            .caps{
                text-transform: uppercase;
            }
            .texthide{
                display:none;
            }
            .line {
                width: 20%;
                margin-left: 0;
                border-top: 2px solid #de0124;
                margin-top: 0;
            }

            .timeline-header {
                background-color: #287ebd;
                color: white !important;
                font-weight: bold;
                text-transform: uppercase;
            }
            .finput
            {
                width: 250px; 
                height: 150px;
            }
            .theads{
                background-color:#c5dde8;
                color:white !important;
            }
            .incident{
                width: 30px;
                height: 30px;
                font-size: 15px;
                line-height: 30px;
                position: absolute;
                color: #666;
                background: #d2d6de;
                border-radius: 50%;
                text-align: center;
                left: 18px;
                top: 0;
            }
            .fbold{
                font-weight:bold;
            }
            .reason {
                padding: 5px;
                border: 3px solid red;
                margin-bottom: 10px;
                background-color: #FFB6C1;
            }
            .mtop-20{
                margin-top:20px !important;
            }
            .text-caps{
                text-transform: uppercase;
            }
            .tab{
                margin-top: 10px;
            }
            .panel-box-header{
                background-color:  #0095e5;
            }
            .panel-box-title{
                color: #FFF !important;
            }
            .parts{display: none;}
            p{
                font-size:1em;
                text-indent: -0.5em;
                padding-left: 0.5em;
            }

            *{
                font-family:calibri; color:#333; font-size:11px; line-height:15px;
            }
            @page {
                size: auto;
                margin-header: 0mm;
                margin-footer: 3mm;
                odd-header-name: html_myHeader1;
                even-header-name: html_myHeader2;
                odd-footer-name: html_myFooter1;
                even-footer-name: html_myFooter2;
            }

            @page noheader {
                odd-header-name: _blank;
                even-header-name: _blank;
                odd-footer-name: _blank;
                even-footer-name: _blank;
            }
            .full-width{
                width:100%;
            }
            .bg-grey{
                background-color:#f1f1f1; 
                border:1px solid #333;
            }
            .padding-5{
                padding:5px;
            }
            .innertable td{
                padding: 5px 10px 5px; 
            }
            .max-width{
                width:95%;
                margin: 0 auto;
            }
            .bg-light-gr{
                background: #00bcd5;
                color: #fff;
            }
            .bg-light-green{
                background: #8cc34b;
                color: #fff;
            }
            .bg-dark-green{
                background: #009688;
                color: #fff;
            }
            .witness{
                margin-bottom: 20px;
            }
            .witness.even tr td .btn{
                background: #8cc34b !important;
                color: #fff;
            }
            .witness.odd tr td .btn{
                background: #009688 !important;
                color: #fff;
            }
            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }
            .bg-light-blue-active{
                background-color: #357ca5 !important;
            }
            .pull-right{
                text-align:right;
            }
            .innertable{
                margin-bottom: 10px;
            }
            h3{
                font-size:0.9em;
                font-weight:bold;
            }
            .box td{
                padding: 30px;
            }

            p{
                font-size:0.9em;
                text-indent: -0.5em;
                padding-left: 0.5em;
            }
/*            .cell
            {
                border-left: 0.2px solid;
                border-right: 0.2px solid;
                border-bottom: 0.2px solid;
                border-top: 0.2px solid;
            }*/
            .col-md-12{
                padding-left: 100px;
            }
            .col-md-3 {
                width: 33%;
            }
            .summ tr:nth-child(odd){
                background-color : rgb(228, 228, 228) !important;
            }
            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {

                text-align: justify;
            }
            .txt-uppercase{
                text-transform: uppercase;

            }
        </style>
    </head>  
    <body style="font-family:'arial';">        
    <htmlpageheader name="myHeader1" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:80%;text-align:center;font-size: 24px;font-weight: bold">LUMUT MARITIME TERMINAL SDN. BHD.</td>
            </tr> 
        </table>
        <table  border="0" style="width:100%;border:0;border-top: 1px solid #000;">
            <tr>
                <!--<td border="0"  style="width:30%;"></td>-->
                <td border="0"  style="text-align:center;font-size: 12px;font-weight: bold"><?php echo $HIRARC_ID; ?></td>
            </tr>  
        </table>

    </htmlpageheader>


    <htmlpagefooter name="myFooter2" style="display:none">
        <table width="100%">
            <tr>
                <td width="33%">My document</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
            </tr>
        </table>
    </htmlpagefooter>  
    <?php
//    echo '<pre>';
//    print_r($getPsadatas); exit;
    $NAME = postData($getPsadatas[0], 'NAME');
    $ID_TYPE = postData($getPsadatas[0], 'ID_TYPE');
    if ($ID_TYPE == '1') {
        $idval = 'IC';
    } elseif ($ID_TYPE == '2') {
        $idval = 'PassPort';
    }
    $PASS_NO = postData($getPsadatas[0], 'PASS_NO');
    $COMP_NAME = postData($getPsadatas[0], 'COMP_NAME');
    $term = postData($getPsadatas[0], 'TERMINAL_NAME');
    $DESIG = postData($getPsadatas[0], 'DESIG');
    $contName = postData($getPsadatas[0], 'CONT_NAME');
    $IND_DATE = convertDate(postData($getPsadatas[0], 'IND_DATE'), 'd-m-Y');
    $IND_DUE_DATE = convertDate(postData($getPsadatas[0], 'IND_DUE_DATE'), 'd-m-Y');
    $VEC_ENTRY_DATE = convertDate(postData($getPsadatas[0], 'VEC_ENTRY_DATE_TIME'), 'd-m-Y');
    $VEC_ENTRY_TIME = date('H:i:s', strtotime(postData($getPsadatas[0], 'VEC_ENTRY_DATE_TIME')));
    $VEC_EXIT_DATE = convertDate(postData($getPsadatas[0], 'VEC_EXIT_DATE_TIME'), 'd-m-Y');
    $VEC_EXIT_TIME = date('H:i:s', strtotime(postData($getPsadatas[0], 'VEC_EXIT_DATE_TIME')));
    $VEC_TYPE = postData($getPsadatas[0], 'VEC_TYPE');
    global $vechical_type;
    $vec_name = $vechical_type[$VEC_TYPE];
    $VEC_OTHER = postData($getPsadatas[0], 'VEC_OTHER');
    $VEC_NO = postData($getPsadatas[0], 'VEC_NO');
    $PURPOSE = postData($getPsadatas[0], 'PURPOSE');
    ?>
    <div class="box-body" style="padding:5px 0;"> 
        <div class="box" style="border:1px solid #2837A2;border-radius:0px;">
            <!--            <div class="box-title" style="background:#005787;color:white;padding:0px 15px;">
                            <h4 class="fbold panel-box-title" style="padding:0px;">Insurance Details</h4>
                        </div>-->
            <h3 style="padding:10px 10px;background:#737b88;color:white;margin:0 0px;">PORT SECURITY ACCESS DETAILS</h3>

            <div class="box-body" style="padding:5px 8px;">

                <!--<h3 style="padding:6px 10px;background:#C7B307;color:white;margin:0 15px;">Insurance Details</b>-->
                <table class="table summ innertable">
                    <tr>
                        <td class="cell text-center">
                            <b class="txt-uppercase" style="font-size: 11px;">Name</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;">: <?php
                                echo ($NAME != '') ? $NAME : 'Nil';
                                ?> </p>
                        </td> 
                    </tr> 
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">ID Type</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo ($idval != '') ? $idval : 'Nil'; ?> </p>
                        </td>
                    </tr> 
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">IC/Passport No</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo ($PASS_NO != '') ? $PASS_NO : 'Nil'; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Company Name</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo $COMP_NAME; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Designation</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo $DESIG; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Terminal</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo $term; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Induction Date</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo $IND_DATE; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Induction Due Date</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo $IND_DUE_DATE; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Vehicle Type</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo $vec_name; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Vehicle Number	</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo ($VEC_NO != '') ? $VEC_NO : 'Nil'; ?> </p>
                        </td>
                    </tr>
                    <?php if ($VEC_TYPE == '5') { ?>
                        <tr><td class="tdlabel"><b>Vehicle Other</b></td>
                            <td>: <?php echo $VEC_OTHER; ?></td>

                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Purpose</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo $PURPOSE; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Vehicle Entry Date</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;"> : <?php echo $VEC_ENTRY_DATE; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Vehicle Entry Time</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;">: <?php echo $VEC_ENTRY_TIME; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Vehicle Exit Date</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;">: <?php echo $VEC_EXIT_DATE; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <b class="txt-uppercase" style="font-size: 11px;">Vehicle Exit Time</b>
                        </td>
                        <td class="cell">
                            <p style="font-size: 11px;">: <?php echo $VEC_EXIT_TIME; ?> </p>
                        </td>
                    </tr>
                </table> 
            </div>
        </div>
        <div class="box" style="border:1px solid #2837A2;border-radius:0px;margin-top:20px;">
            <!--            <div class="box-title" style="background:#005787;color:white;padding:0px 15px;">
                            <h4 class="fbold panel-box-title" style="padding:0px;">Insurance Details</h4>
                        </div>-->
            <h3 style="padding:10px 10px;background:#737b88;color:white;margin:0 0px;"> CERTIFICATE DETAILS</h3>

            <div class="box-body" style="padding:5px 8px;">

    <div class="box fsize" style="border-radius:0px;">
        
            <table style="width:100%;padding-left: 10px;padding: 15px;" class=" full-width innertable ">

                <thead style=" background-color: rgb(228, 228, 228) !important;height:10px !important;">
                    <tr style="background-color: rgb(228, 228, 228) !important;height:10px !important;">
                        <th style="width:7%;" class="txt-uppercase">S/No</th>
                        <th style="width:20%;" class="txt-uppercase">Certificate Name</th>
                        <th style="width:10%;" class="txt-uppercase">Start Date</th>
                        <th style="width:10%;" class="txt-uppercase">End Date</th>
                        <th style="width:50%;" class="txt-uppercase">Certificate</th>

                    </tr>
                  
                </thead>
                <tbody >
                     <?php
                $i = 1;
                $checkData = '';
                if (isset($getOthercertdet) && !empty($getOthercertdet)) {
                    foreach ($getOthercertdet as $insDKey => $InsData) {
                         $fileExtn = postData($InsData,'CERT_EXT');
                        $bfrKeyval = $insDKey - 1;
                        ?>

                     <tr>
                                <td style="width:20%;text-align:center"><?php echo $i++; ?></td>
                                <td style="width:20%;text-align:center;"><?php echo $InsData->CERT_NAME; ?></td>
                                <td style="width:10%;text-align:center;"><?php echo date("d-m-Y", strtotime($InsData->CERT_START_DATE)); ?></td>
                                <td style="width:10%;text-align:center;"><?php echo date("d-m-Y", strtotime($InsData->CERT_END_DATE)); ?></td>
                                <?php if ($InsData->CERT_FILE_NAME != '') { ?>
                                    <td style="width:40%;text-align:center;">
                                        <?php if($fileExtn != '.pdf'){ ?>
                                        <img src="<?php echo BASE_URL.$InsData->CERT_PATH.''.$InsData->CERT_FILE_NAME; ?>" style="height:15%" alt="<?php echo $InsData->CERT_FILE_NAME; ?>">
                                        <?php }else{ ?>
                                       <?php echo $InsData->CERT_FILE_NAME; ?>
                                        <?php } ?>
                                     </td>
                                <?php } else { ?>
                                    <td style="width:40%;text-align:center;"> - </td>
        <?php } ?>
                            </tr>
                                <?php }
}else{ ?>
     <tr style="text-align:center;"> <td  colspan="4">No data Available<td> </tr>
<?php }
?>
                </tbody>
            </table>

        
    </div>
            </div>
        </div>
    </div>
    <br><br><br>
</body>
</html>
