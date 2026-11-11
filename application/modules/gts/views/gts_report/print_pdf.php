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
            .cell
            {
                border-left: 0.2px solid;
                border-right: 0.2px solid;
                border-bottom: 0.2px solid;
                border-top: 0.2px solid;
            }
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
            .table{
                border-left: thin solid;
                border-right: thin solid;
                border-bottom: thin solid #000000;
                border-top: thin solid;
                margin-top: 10px;
                margin-bottom: 10px;
                border-collapse: collapse;
            }
        </style>
    </head>  
    <body style="font-family:'arial';">        
    <htmlpageheader name="myHeader1" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:80%;text-align:center;font-size: 24px;font-weight: bold">GTS TRACKING REPORT</td>
            </tr> 
        </table>
        <table  border="0" style="width:100%;border:0;border-top: 1px solid #000;">
            <tr>
                <!--<td border="0"  style="width:30%;"></td>-->
                <td border="0"  style="text-align:center;font-size: 12px;font-weight: bold"><?php echo $HIRARC_ID; ?></td>
            </tr>  
        </table>

    </htmlpageheader>

    <!--    <htmlpagefooter name="myFooter1" style="display:none">
            <table width="100%" style="width:100%;border:0;background-color: #FFF;border-top: 4px solid #000;padding-top:10px;padding-bottom:10px;">
                <tr>
                    <td width="33%">
                        <span style="font-style: italic;">{DATE d-m-Y}</span>
                    </td>
                    <td width="33%" align="center" style="font-weight: bold; font-style: italic;">
    
                    </td>
                    <td width="33%" style="text-align: right;">
                        {PAGENO}/{nbpg}
                    </td>
                </tr>
            </table>
        </htmlpagefooter>-->

    <htmlpagefooter name="myFooter1"> 
        <table width="100%" style="width:100%;border:0;background-color: #FFF;border-top: 4px solid #000;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td width="33%"></td>
                <td width="33%" align="center">Page {PAGENO} of {nbpg}</td>
                <td width="33%" style="text-align: right;"></td>
            </tr>
        </table>
    </htmlpagefooter>  
    <?php
 $FK_NOTIFY_TYPE_ID = postData($getgtslocdatas[0], 'FK_NOTIFY_TYPE_ID');
    $point = postData($gtslocdatas[0], 'LOCA_POINT');
    $term = postData($gtslocdatas[0], 'TERMINAL_NAME');
    $cont_id = postData($gtslocdatas[0], 'CONT_ID');
    $contName = postData($gtslocdatas[0], 'CONT_NAME');
    $emp_id = postData($gtslocdatas[0], 'EMP_ID');
    $empName = postData($gtslocdatas[0], 'EMP_NAME');
    $empDes = postData($gtslocdatas[0], 'des');
    $conDes = postData($gtslocdatas[0], 'desig');
    $displayStartDate = convertDate(postData($gtslocdatas[0], 'GTS_DATE_TIME'), 'd-m-Y H:i:s');
    ?>
    <div> 
        <div class="box-body" style="padding:5px 0;"> 
            <div class="box" style="border:1px solid #2837A2;border-radius:0px;">
                <!--            <div class="box-title" style="background:#005787;color:white;padding:0px 15px;">
                                <h4 class="fbold panel-box-title" style="padding:0px;">Insurance Details</h4>
                            </div>-->
                <h3 style="padding:10px 10px;background-color: #FFFF00;color:#000;margin:0 0px;">GTS REPORT DETAILS</h3>

                <div class="box-body" style="padding:5px 0;">

                    <!--<h3 style="padding:6px 10px;background:#C7B307;color:white;margin:0 15px;">Insurance Details</p>-->
                    <table style="width:100%;" class=" full-width summ innertable">
                        <tr>
                            <td>
                                <b class="txt-uppercase" style="font-size: 11px;">Guard Employee ID</b>
                            </td>
                            <td>:</td>
                            <td>
                                <p style="font-size: 11px;"><?php
                                    echo ($FK_NOTIFY_TYPE_ID == 11) ? $cont_id : $emp_id;
                                    ;
                                    ?> </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b class="txt-uppercase" style="font-size: 11px;">Guard Name</b>
                            </td>
                            <td>:</td>
                            <td>
                                <p style="font-size: 11px;"> <?php echo ($FK_NOTIFY_TYPE_ID == 11) ? $contName : $empName; ?> </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b class="txt-uppercase"  style="font-size: 11px;">Designation</b>
                            </td>
                            <td>:</td>
                            <td>
                                <p style="font-size: 11px;"> <?php echo ($FK_NOTIFY_TYPE_ID == 11) ? $conDes : $empDes; ?> </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b class="txt-uppercase"  style="font-size: 11px;">Terminal</b>
                            </td>
                            <td>:</td>
                            <td>
                                <p style="font-size: 11px;"> <?php echo $term; ?> </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b class="txt-uppercase"  style="font-size: 11px;">GTS location Point</b>
                            </td>
                            <td>:</td>
                            <td>
                                <p style="font-size: 11px;"> <?php echo $point; ?> </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b class="txt-uppercase"  style="font-size: 11px;">Date and Time</b>
                            </td>
                            <td>:</td>
                            <td>
                                <p style="font-size: 11px;"> <?php echo $displayStartDate; ?> </p>
                            </td>
                        </tr>
                    </table> 
                    <div class="col-md-12" > 
                        <table style="width:80%;" class="table full-width innertable">
                            <tr>
                                <td class="cell" style="font-size: 11px;"><b>SR.No</b></td>
                                <td class="cell" style="text-align: center;font-size: 11px;"><b>Uploaded Images</b></td>
                            </tr>
                            <?php
                            if (is_array($gtslocdatas)) {
                                $i = 1;
                                foreach ($gtslocdatas as $akey => $attachmnt) {
                                    $filepath = postData($attachmnt, 'GTS_FILE_PATH');
                                    $filename = postData($attachmnt, 'GTS_FILENAME');
                                    $fileext = postData($attachmnt, 'GTS_FILE_EXT');
                                    $fileFullpath = BASE_URL . $filepath;
                                    $displayLabel = ($filepath != '') ? '<a href="' . $fileFullpath . '">View Image</a>' : 'Nil';
                                    ?>
                                    <tr>
                                        <td class="cell" style="font-size: 11px;"><?php echo $i; ?></td>
                                        <td class="cell" style="height: 20px;font-size: 11px;">
                                            <?php echo $displayLabel; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            <?php } ?>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <br><br><br>
    </div>
</body>
</html>
