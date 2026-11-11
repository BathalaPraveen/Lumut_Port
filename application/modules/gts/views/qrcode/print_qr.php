<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:230px;height:70px;">';
?>
<html>
    <head>
        <style>
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
                font-size: 11px;
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
            p{
                font-size:11px;
            }
            p.desc{
                font-size:1em; 
                text-indent: 30px!important;
            }

            .inj_per tr:nth-child(odd){
                background-color : rgba(63, 147, 187, 0.10) !important;
            }
            .inj_det tr:nth-child(odd){
                background-color : rgba(59, 188, 212, 0.10) !important;
            }
            .witns tr:nth-child(odd){
                background-color : rgba(241, 146, 52, 0.10) !important;
            }
            .summ tr:nth-child(odd){
                background-color : rgb(228, 228, 228) !important;
            }

            .boxtitle {

                font-weight: bold;
                color: #333 !important;
            }
            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {

                text-align: justify;
            }
            .texthide{
                display:none;
            }  
            body {
                color-adjust: exact;
                -webkit-print-color-adjust: exact;

            }
            .label_high{
                background-color: #ff0000 !important;

            }
            .label_low{
                background-color: #008f11 !important;
            }
            .label_medium{
                background-color: #f2ff00 !important;
            }

            .labels {

                padding: 10px;
                font-weight: bold;

                text-transform: uppercase;
            }


            .web
            {

                width:100%;
                border-collapse:collapse;
                font-size:11px;
                line-height:25px
            }
            .web td  
            {
                font-size:11px;
                border:1px solid #D9E9F4;
                padding:5px 5px 5px 5px;
            }

            .web tr:nth-child(odd){
                background-color : rgba(63, 147, 187, 0.10) !important;
            }
            .web th 
            {
                font-size:12px;
                text-align:left;
                padding:3px 0px 3px 10px;
                color:#ffffff;
                background-color:#316191;
                border:1px solid #316191;
            }
            .web tr.alt td 
            {
                color:#000000;
                background-color:#316191;
            }



            .panelheading {
                font-size: 11px;
            }
            .panel-body {
                padding: 15px;
            }
            .col-md-3-p {
                width: 22% !important;
            }
            .col-md-12 {
                width: 100% !important;
            }
            .box-header {

                display: block;
                padding: 10px;
                position: relative;
            }

            .box-header.with-border {
                border-radius: 0px !important;
            }
            .box-header.with-border {
                border-bottom: 1px solid #007cb7 !important;
            }

            .col-print{
                padding:20px !important;
            }

            .row {
                margin-right: -10px;
                margin-left: -10px;
            }

            .col-md-6-p {
                width: 42% !important;
            }
            .web td p.fjust{
                text-align: justify !important;
            }
            .web td h5.fright{

                text-align: right !important;
            }
            .txt-uppercase{
                text-transform: uppercase;

            }
            .table{
                border-left: thin solid;
                border-right: thin solid;
                border-bottom: thin solid #000000;
                border-top: thin solid;
            }

            .table{
                margin-top: 10px;
                margin-bottom: 10px;
                border-collapse: collapse;
            }

            table tr {
                border-bottom: 1px solid black;
            }

            table tr:last-child { 
                border-bottom: none; 
            }
            .tcenter{
                text-align: center;
            }   
            .tdborder{
                border: 1px solid #bfbebe;
            }
            .w-20{
                width: 20px;
            }
            .text-center {
                text-align: center;
            }
            .cell
            {
                border-left: 0.2px solid;
                border-right: 0.2px solid;
                border-bottom: 0.2px solid;
                border-top: 0.2px solid;
                font-size: 12px;
            }
            .row
            {
                display: block;
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
                <td border="0"  style="text-align:center;font-size: 12px;font-weight: bold"><?php // echo $gtslocdatas->COMPANY_NAME;  ?></td>
            </tr>  
        </table>

    </htmlpageheader>


    <htmlpagefooter name="myFooter1" style="display:none">
        <table width="100%">
            <tr>
                <td width="33%">
                    <span style="font-weight: bold;"><?php echo $gtslocdatas->COMPANY_NAME; ?></span>
                </td>
                <td width="33%" align="center" style="font-weight: bold; font-style: italic;">

                </td>
                <td width="33%" style="text-align: right;">
                    {PAGENO}/{nbpg}
                </td>
            </tr>
        </table>
    </htmlpagefooter>

    <htmlpagefooter name="myFooter2" style="display:none">
        <table width="100%">
            <tr>
                <td width="33%">My document</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
            </tr>
        </table>
    </htmlpagefooter>    
    <div class="box-body" style="padding-top: 5px;"> 
        <div class="box" style="border:1px solid #2837A2;border-radius:0px;">
            <!--            <div class="box-title" style="background:#005787;color:white;padding:0px 15px;">
                            <h4 class="fbold panel-box-title" style="padding:0px;">Insurance Details</h4>
                        </div>-->
            <h3 style="padding:10px 10px;background:#fdff33;color:#000;margin:0 0px;">GTS Details</h3>

            <div class="box-body" style="padding:5px 0;">

                <!--<h3 style="padding:6px 10px;background:#C7B307;color:white;margin:0 15px;">Insurance Details</h3>-->
                <table style="width:100%;padding-left: 10px;" class="full-width innertable">
                    <tr>
                        <td class="cell">
                            <h3>GTS Point ID</h3>
                        </td>
                        <td class="cell">
                            <p>: <?php echo $gtslocdatas->POINT_ID; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <h3>Terminal name</h3>
                        </td>
                        <td class="cell">
                            <p>: <?php echo $gtslocdatas->TERMINAL_NAME; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <h3>GTS Point</h3>
                        </td>
                        <td class="cell">
                            <p>: <?php echo $gtslocdatas->LOCA_POINT; ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">
                            <h3>Created On</h3>
                        </td>
                        <td class="cell">
                            <p>: <?php echo convertDate($gtslocdatas->CREATED_ON, 'd-m-Y'); ?> </p>
                        </td>
                    </tr>
                </table>
                <div style="text-align: center;">
                    <h2>QR Code</h2>
                    <?php
                    if (isset($gtslocdatas->QR_IMG_PATH) && $gtslocdatas->QR_IMG_PATH != "") {
                        ?>
                        <img   style="width: 60%;" src="<?php echo BASE_URL . $gtslocdatas->QR_IMG_PATH; ?>">
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
    <br><br><br>
</body>
</html>
