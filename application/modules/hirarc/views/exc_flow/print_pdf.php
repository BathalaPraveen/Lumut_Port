<?php
$HIRARC_ID = postData($hir_details, 'HIRARC_ID');
$COM_NAME = postData($hir_details, 'COM_NAME');
$COM_NAME_OTH = postData($hir_details, 'OTH_COMP_NAME');
$TERMINAL_NAME = postData($hir_details, 'TERMINAL_NAME');
$HIRARC_FLOW_STATUS = postData($hir_details, 'HIRARC_FLOW_STATUS');
$EMP_NAME = postData($hir_details, 'EMP_NAME');
$cnd_by = postData($hir_details, 'cnd_by');
$DEPT_NAME = postData($hir_details, 'DEPT_NAME');
$PRO_NAME = postData($hir_details, 'PRO_ACT_LOC');
$HOD_ID = postData($hir_details, 'HOD_ID');
$MAIN_AUTO_ID = postData($hir_details, 'MAIN_AUTO_ID');
$Notify_id = postData($hir_details, 'CREATED_BY');
$ds_na = postData($hir_details, 'ds_na');
$des_name = postData($hir_details, 'des_name');
$CREATED_ON = convertDate(postData($hir_details, 'CREATED_ON'));
$legalDatas = [
    '' => 'Select Applicable Legal',
    '1' => 'OSHA 1994',
    '2' => 'FMA 1967',
    '3' => 'EQA 1974',
    '4' => 'N/A'
];
$statusDatas = [
    '' => 'Select Status',
    '1' => 'Open',
    '2' => 'Close'
];
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
    <body style="font-family:'calibri';">        
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
    <div style="">
        <table  border="0" style="width:100%;border:0;">
            <tr>
                <td border="0"  style="text-align:center;font-size: 18px;"><b>HAZARD IDENTIFICATION RISK ASSESSMENT & RISK CONTROL (HIRARC)</b></td>
            </tr>   
        </table> 
        <table class="table" style="width: 100%;">
            <tr class="row">  
                <td class="cell" style="width: 260px;background-color: #e4dede;font-size: 12px;padding-left:10px; "><b>COMPANY</b></td>
                <td class="title-colon w-20 cell text-center">:</td>
                <td class="cell"><?php echo ($COM_NAME != '') ? $COM_NAME : $COM_NAME_OTH; ?></td>
                <td class="cell" style="width: 260px;background-color: #e4dede;padding-left:10px;font-size: 12px;"><b>HIRARC NO</b></td>
                <td class="w-20 cell text-center">:</td>
                <td class="cell"><?php echo ($HIRARC_ID != '') ? $HIRARC_ID : 'Nil'; ?></td>
            </tr>
            <tr class="row"> 
                <td class="cell" style="width: 260px;background-color: #e4dede;padding-left:10px;font-size: 12px;"><b>PROCESS / LOCATION /ACTIVITY</b></td>
                <td class="w-20 cell text-center">:</td>
                <td class="cell" colspan="4"><?php echo $PRO_NAME; ?></td>
            </tr>
            <tr>
                <td class="cell" style="width: 260px;background-color: #e4dede;padding-left:10px;font-size: 12px;"><b>CONDUCTED BY:</b>
                    <br><label>Name</label><br><label>Designation</label><br><label>Signature</label>
                </td>
                <td class="w-20 cell text-center">:<br>:<br>:</td>
                <td class="cell"><?php echo $cnd_by; ?><br><?php echo $des_name; ?><br>&nbsp;</td>
                <td class="cell" style="width: 260px;background-color: #e4dede;padding-left:10px;font-size: 12px;"><b>APPROVED BY:</b>
                    <br><label>Name</label><br><label>Designation</label><br><label>Signature</label>
                </td>
                <td class="w-20 cell text-center">:<br>:<br>:</td>
                <td class="cell"><?php echo $EMP_NAME; ?><br><?php echo $ds_na; ?><br>&nbsp;</td>
            </tr>
            <tr>
                <td class="cell" style="width: 260px;background-color: #e4dede;padding-left:10px;font-size: 12px;"><b>DATE</b></td>
                <td class="w-20 cell text-center">:</td>
                <td class="cell"><?php echo $CREATED_ON; ?></td>

                <td class="cell" style="width: 260px;background-color: #e4dede;padding-left:10px;font-size: 12px;"><b>DATE</b></td>
                <td class="w-20 ce1l text-center">:</td>
                <td class="cell"><?php echo $CREATED_ON; ?></td>

            </tr>
        </table>
        <div style="padding-top:25px;">
            <table class="table">
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center cell">Hazard Identification</td>
                        <td colspan="6" class="text-center cell">Risk Analysis</td>
                        <td colspan="4" class="text-center cell">Risk Control/Opportunities</td>
                    </tr>
                    <tr>
                        <td class="text-center cell">No.</td>
                        <td class="cell" style="padding: 30px;text-align: center;">Process/Activity/ Area</td>
                        <td class="cell" style="padding: 25px; text-align: center;">R/NR/E</td>
                        <td class="cell" style="padding: 30px;text-align: center;">Hazard</td> 
                        <td class="cell" style="padding: 25px;text-align: center;">Which Can Cause Effect</td>
                        <td class="cell" style="padding: 25px;text-align: center;">Existing Risk Control</td>
                        <td class="cell" style="padding: 25px;text-align: center;">Applicable Legal & Other Req.</td>
                        <td class="cell" style="text-align: center;">(S)</td>
                        <td class="cell" style="text-align: center;">(L)</td>
                        <td class="cell">(RR)</td> 
                        <td class="cell">Risk Level</td>
                        <td class="cell">Recommended Control/Opportunities</td>
                        <td class="cell">Person In-Charge</td>
                        <td class="cell">Due Date</td>
                        <td class="cell">Status (Open/ Close)</td>
                    </tr> 
                    <?php
                    if (is_array($hir_flow_details) && $hir_flow_details != '') {
                        $i = 1;
                        foreach ($hir_flow_details as $key => $value) {
                            ?> 
                            <tr>
                                <td class="cell"><?php echo $i; ?></td>
                                <td class="cell" style="padding: 5px;">
                                    <?php echo postData($value, 'FK_PRO_ACT_NAME'); ?>
                                </td>
                                <td class="cell" style="padding: 5px;">
                                    <?php echo postData($value, 'HAZ_TYPE_NAME'); ?>
                                </td>
                                <td class="cell" style="padding: 5px;"> 
                                    <?php
                                    $row_id = $value->RP_AUTO_ID;
                                    $hirarc_id = $value->FK_HIRARC_MAIN_ID;
                                    $haz_data = getAllHazardDatas($row_id, $hirarc_id);
                                    if (is_array($haz_data) && !empty($haz_data)) {
                                        $count = count($haz_data);
                                        foreach ($haz_data as $key => $kval) {
                                            if ($count == 1) {
                                                echo postData($kval, 'HAZ_NAME');
                                            } else {
                                                echo postData($kval, 'HAZ_NAME') . ', ';
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="cell" style="padding: 5px;">
                                    <?php
                                    $cause_data = getAllCauseDatas($row_id, $hirarc_id);
                                    if (is_array($cause_data) && !empty($cause_data)) {
                                        $count = count($cause_data);
                                        foreach ($cause_data as $key => $cval) {
                                            if ($count == 1) {
                                                echo postData($cval, 'CAUSE_NAME');
                                            } else {
                                                echo postData($cval, 'CAUSE_NAME') . ', ';
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="cell" style="padding: 5px;">
                                    <?php
                                    $exit_data = getAllExitingDatas($row_id, $hirarc_id);
                                    if (is_array($exit_data) && !empty($exit_data)) {
                                        $count = count($exit_data);
                                        foreach ($exit_data as $key => $eval) {
                                            if ($count == 1) {
                                                echo postData($eval, 'CONTROL_NAME');
                                            } else {
                                                echo postData($eval, 'CONTROL_NAME') . ', ';
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="cell" style="padding: 5px;">
                                    <?php
                                    $legel = explode(',', postData($value, 'FK_LEGAL_ID'));
                                    $count = count($legel);
                                    foreach ($legel as $key => $val) {
                                        if ($count == 1) {
                                            print_r($legalDatas[$val]);
                                        } else {
                                            print_r($legalDatas[$val] . ',');
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="cell" style="padding: 5px;">
                                    <?php echo postData($value, 'SEVERITY'); ?>
                                </td>
                                <td class="cell" style="padding: 5px;">
                                    <?php echo postData($value, 'LIKELIHOOD'); ?>
                                </td>
                                <td class="cell" style="padding: 5px;">
                                    <?php echo postData($value, 'FK_RISK_RATE'); ?>
                                </td>
                                <td class="cell" style="padding: 5px;background-color: <?php echo postData($value, 'FK_RISK_LEVEL_COL_CODE'); ?>">

                                </td>
                                <td class="cell" style="padding: 5px;">
                                    <?php
                                    global $RecoCntrlDatas;
                                    print_r($RecoCntrlDatas[postData($value, 'RECOMMENED_CONTROL')]);
if (postData($value, 'RECOMMENED_CONTROL') != 1) {
                                                                                   $a = " - ";
                                                                                   $b = $emp_name = postData($value, 'RECOMMENED_CONTROL_TEXT');
                                                                                   echo $a.$b ;
                                                                                }
                                    ?>
                                </td>
                                <?php
                                if (postData($value, 'RECOMMENED_CONTROL') == 1) {
                                    $emp_name = '-';
                                    $due_date = '-';
                                    $status = '-';
                                } else {
                                    $emp_name = postData($value, 'PERSON_INCHARGE');
                                    $due_date = (postData($value, 'DUE_DATE') != '0000-00-00') ? convertDate(postData($value, 'DUE_DATE')) : '';
                                    $status = $statusDatas[postData($value, 'RISK_PRO_END_STATUS')];
                                }
                                ?>
                                <td class="cell" style="padding: 5px;">
                                    <?php echo $emp_name; ?>
                                </td>
                                <td class="cell" style="padding: 5px;">
                                    <?php echo $due_date; ?>
                                </td>
                                <td class="cell" style="padding: 5px;">
                                    <?php print_r($status); ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <pagebreak></pagebreak>
    <div style="">
        <b>Note :</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span style="font-size: 12px;">Risk control/opportunities to eliminate the hazard & reduce OH&S risks.</span><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span style="font-size: 12px;">R: Routine&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NR: Non-Routine&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E: Emergency</span>
        <div style="padding-top: 20px;">
            <div style="width: 100%; border-top: 1px solid #000;"></div>
        </div>
        <div style="padding-top: 5px;">
            <div style="width: 100%; text-align: center;font-size: 12px;"><b><u>RISK ASSESSMENT</u></b></div>
        </div>
        <div style="padding-top: 30px;">
            <table style="width:100%;" autosize="1">
                <tr>
                    <td style="width: 50%;">
                        <table class="table">
                            <tr>
                                <td class="cell" colspan="3" style="text-align: center;font-size: 12px;"><b>SEVERITY OF CONSEQUENCE (S)</b></td>
                            </tr>
                            <tr>
                                <td class="cell" style="text-align: center;background-color: #e4dede;font-size: 11px;"><b>Severity</b></td>
                                <td class="cell" style="text-align: center;background-color: #e4dede;font-size: 11px"><b>Rating</b></td>
                                <td class="cell" style="text-align: center;background-color: #e4dede;font-size: 11px"><b>Definition</b></td>
                            </tr>
                            <tr>   
                                <td class="cell text-center" style="font-size: 11px;">Catastrophic</td>
                                <td class="cell text-center" style="font-size: 11px;">5</td>
                                <td class="cell" style="font-size: 11px;">Death, numerous fatalities, irrecoverable property damage and productivity. </td>
                            </tr>
                            <tr>   
                                <td class="cell text-center" style="font-size: 11px;">Fatal</td>
                                <td class="cell text-center" style="font-size: 11px;">4</td>
                                <td class="cell" style="font-size: 11px;">Approximately one single fatality / major property damage if hazard is realized (MC ≥ 7 days)</td>
                            </tr>
                            <tr>   
                                <td class="cell text-center" style="font-size: 11px;">Serious</td>
                                <td class="cell text-center" style="font-size: 11px;">3</td>
                                <td class="cell" style="font-size: 11px;">Non-fatal injury, permanent disability (MC for 4 – 6 days) </td>
                            </tr>
                            <tr>   
                                <td class="cell text-center" style="font-size: 11px;">Minor</td>
                                <td class="cell text-center" style="font-size: 11px;">2</td>
                                <td class="cell" style="font-size: 11px;">Disabling but not permanent injury (MC ≤ 3 days)</td>
                            </tr>
                            <tr>   
                                <td class="cell text-center" style="font-size: 11px;">Negligible</td>
                                <td class="cell text-center" style="font-size: 11px;">1</td>
                                <td class="cell" style="font-size: 11px;">Minor abrasions, bruises, cuts, first aid type injury.</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%;">
                        <table class="table" style="height:101%">
                            <tr>
                                <td class="cell" colspan="3" style="text-align: center;font-size: 12px;"><b>LIKELIHOOD OF OCCURRENCE (L)</b></td>
                            </tr>
                            <tr>
                                <td class="cell" style="text-align: center;background-color: #e4dede;font-size: 11px;"><b>Likelihood</b></td>
                                <td class="cell" style="text-align: center;background-color: #e4dede;font-size: 11px;"><b>Rating</b></td>
                                <td class="cell" style="text-align: center;background-color: #e4dede;font-size: 11px;"><b>Definition</b></td>
                            </tr>
                            <tr>   
                                <td class="cell text-center" style="font-size: 11px;padding: 3px;">Most Likely</td>
                                <td class="cell text-center" style="font-size: 11px;">5</td> 
                                <td class="cell" style="font-size: 11px;">The most likely result of the hazard / event being realized (daily/monthly)</td>
                            </tr>
                            <tr>   
                                <td class="cell text-center" style="font-size: 11px;padding: 3px;">Possible</td>
                                <td class="cell text-center" style="font-size: 11px;">4</td>
                                <td class="cell" style="font-size: 11px;">A good chance of occurring and is not unusual (≥ 1 years)</td>
                            </tr>
                            <tr>   
                                <td class="cell text-center" style="font-size: 11px;padding: 3px;">Conceivable</td>
                                <td class="cell text-center" style="font-size: 11px;">3</td>
                                <td class="cell" style="font-size: 11px;">Might occur at sometimes in future (2 – 4 years)</td>
                            </tr> 
                            <tr>   
                                <td class="cell text-center" style="font-size: 11px;padding: 3px;">Remote</td>
                                <td class="cell text-center" style="font-size: 11px;">2</td>
                                <td class="cell" style="font-size: 11px;">Has not been known to occur after many years (5 – 7 years)</td>
                            </tr>
                            <tr>   
                                <td class="cell text-center" style="font-size: 11px;padding: 3px;">Inconceivable</td>
                                <td class="cell text-center" style="font-size: 11px;">1</td>
                                <td class="cell" style="font-size: 11px;">Is practically impossible and has never occurred (≥ 8 years)</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div style="padding-top: 30px;">
            <table style="width:100%;" autosize="1">
                <tr>
                    <td style="width: 35%;">
                        <table>
                            <tr>
                                <td colspan="6" style="text-align: center;font-size: 14px;"><b>RISK RATING MATRIX</b></td>
                            </tr>
                        </table>
                        <table class="table">
                            <tr>
                                <td style="border-top: none !important;">&nbsp;</td>
                                <td class="cell" colspan="5" style="text-align: center;background-color: #e4dede;font-size: 11px;"><b>Severity (S)</b></td>
                            </tr>
                            <tr>
                                <td class="cell text-center" style="width: 100px;height: 40px;background-color: #e4dede;font-size: 11px;"><b>Likelihood (L)</b></td>
                                <td class="cell text-center" style="width: 50px;background-color: #e4dede;font-size: 11px;">1</td> 
                                <td class="cell text-center" style="width: 50px;background-color: #e4dede;font-size: 11px;">2</td>
                                <td class="cell text-center" style="width: 50px;background-color: #e4dede;font-size: 11px;">3</td>
                                <td class="cell text-center" style="width: 50px;background-color: #e4dede;font-size: 11px;">4</td>
                                <td class="cell text-center" style="width: 50px;background-color: #e4dede;font-size: 11px;">5</td>
                            </tr>
                            <tr> 
                                <td class="cell text-center" style="width: 100px;height: 30px;font-size: 11px;">5</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">5</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">10</td>
                                <td class="cell text-center" style="width: 50px;background-color: #f51a1a;font-size: 11px;">15</td>
                                <td class="cell text-center" style="width: 50px;background-color: #f51a1a;font-size: 11px;">20</td>
                                <td class="cell text-center" style="width: 50px;background-color: #f51a1a;font-size: 11px;">25</td>
                            </tr>
                            <tr>
                                <td class="cell text-center" style="width: 100px;height: 30px;font-size: 11px;">4</td>
                                <td class="cell text-center" style="width: 50px;background-color: #15bb3b;font-size: 11px;">4</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">8</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">12</td>
                                <td class="cell text-center" style="width: 50px;background-color: #f51a1a;font-size: 11px;">16</td>
                                <td class="cell text-center" style="width: 50px;background-color: #f51a1a;font-size: 11px;">20</td>
                            </tr>
                            <tr>
                                <td class="cell text-center" style="width: 100px;height: 30px;font-size: 11px;">3</td>
                                <td class="cell text-center" style="width: 50px;background-color: #15bb3b;font-size: 11px;">3</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">6</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">9</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">12</td>
                                <td class="cell text-center" style="width: 50px;background-color: #f51a1a;font-size: 11px;">15</td>
                            </tr>
                            <tr>
                                <td class="cell text-center" style="width: 100px;height: 30px;font-size: 11px;">2</td>
                                <td class="cell text-center" style="width: 50px;background-color: #15bb3b;font-size: 11px;">2</td>
                                <td class="cell text-center" style="width: 50px;background-color: #15bb3b;font-size: 11px;">4</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">6</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">8</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">10</td>
                            </tr>
                            <tr>
                                <td class="cell text-center" style="width: 100px;height: 30px;font-size: 11px;">1</td>
                                <td class="cell text-center" style="width: 50px;background-color: #15bb3b;font-size: 11px;">1</td>
                                <td class="cell text-center" style="width: 50px;background-color: #15bb3b;font-size: 11px;">2</td>
                                <td class="cell text-center" style="width: 50px;background-color: #15bb3b;font-size: 11px;">3</td>
                                <td class="cell text-center" style="width: 50px;background-color: #15bb3b;font-size: 11px;">4</td>
                                <td class="cell text-center" style="width: 50px;background-color: #fbff00;font-size: 11px;">5</td>
                            </tr>
                        </table>                            
                    </td>
                    <td style="width: 65%;">
                        <table>
                            <tr>
                                <td colspan="6" style="text-align: center;font-size: 14px;"><b>RISK LEVEL</b></td>
                            </tr>
                        </table>
                        <table class="table">
                            <tr>
                                <td class="cell" style="width: 60px;font-size: 11px;height: 30px;text-align: center;background-color: #e4dede;height: 20px;"><b>Risk</b></td>
                                <td class="cell" style="width: 60px;font-size: 11px;height: 30px;text-align: center;background-color: #e4dede;"><b>Description</b></td>
                                <td class="cell" style="font-size: 11px;height: 30px;text-align: center;background-color: #e4dede;"><b>Action</b></td>
                            </tr>
                            <tr>
                                <td class="cell" style="font-size: 11px;height: 50px;text-align: center;background-color: #f51a1a;height: 55px;">15 ~ 25</td>
                                <td class="cell" style="font-size: 11px;background-color: #f51a1a;text-align: center;">High</td>
                                <td class="cell" style="font-size: 11px;">A <b>HIGH</b> risk requires <b>immediate</b> action to control the hazard as detailed in the hierarchy of control. Actions taken must be documented on the risk assessment form including date for completion.</td>
                            </tr>
                            <tr>
                                <td class="cell" style="font-size: 11px;height: 50px;text-align: center;background-color: #fbff00;height: 55px;">5 ~ 12</td>
                                <td class="cell" style="font-size: 11px;background-color: #fbff00;text-align: center;">Medium</td>
                                <td class="cell" style="font-size: 11px;;">A <b>MEDIUM</b> risk requires a planned approach to controlling the hazard and applies temporary measure if required. Actions taken must be documented on the risk assessment form including date for completion.</td>
                            </tr>
                            <tr> 
                                <td class="cell" style="font-size: 11px;height: 50px;text-align: center;background-color: #15bb3b;height: 55px;">1 ~ 4</td>
                                <td class="cell" style="font-size: 11px;background-color: #15bb3b;text-align: center;">Low</td>
                                <td class="cell" style="font-size: 11px;">A risk identified as <b>LOW</b> may be considered as acceptable and further reduction may not be necessary. However, if the risk can be resolved quickly and efficiently, control measures should be implemented and recorded.</td>
                            </tr>
                        </table>   
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
