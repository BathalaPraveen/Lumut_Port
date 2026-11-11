<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:250px;height:75px;">';
$logo1 = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="float:right;width:200px;height:35px;">';


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
            .uppertext{
                text-transform: uppercase;
            }
            p{
                font-size:11px;
            }
            p.desc{
                font-size:1em; 
                text-indent: 30px!important;
            }
            .table{
                border:1px solid #bfbebe;
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

            .table td {
                padding:6px;
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
            .col-md-3-pdf{
                margin: 5px;
                float: left;
                width: 45% !important;
                border: 2px solid #000;
                padding: 5px;
            }

            .tab-border table, .tab-border table th, .tab-border table td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            .tab-border table th, .tab-border table td {
                padding: 15px;
            }
            .fsize{
                font-size: 11px;
            }

            .doc-border table, .doc-border table th, .doc-border table td {
                border: 1px solid black;
                border-collapse: collapse;
                text-align: center;
            }
            .doc-border table th, .doc-border table td {
                padding: 5px;
            }
            .tcenter{
                text-align: center;
            }      

               
         


        </style>

    </head>    
    <body style="font-family:'calibri';">        
    <htmlpageheader name="myHeader1" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">ATAR Report</td>


            </tr> 

        </table>
        <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
            <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"></td>
            </tr>
        </table>

    </htmlpageheader>
    <htmlpageheader name="myHeader2" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">ATAR Report</td>


            </tr> 

        </table>
        <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
            <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"></td>
            </tr>
        </table>

    </htmlpageheader>

    <htmlpagefooter name="myFooter1" style="display:none">
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
    </htmlpagefooter>

    <htmlpagefooter name="myFooter2" style="display:none">
        <table width="100%" style="width:100%;border:0;background-color: #FFF;border-top: 4px solid #000;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td width="33%">My document</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
            </tr>
        </table>
    </htmlpagefooter>  


<?php
if (is_array($editDataUnsafe) && $editDataUnsafe != '') { ?>

    <table style="width:100%;padding-bottom: 10px;margin-top: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                Unsafe Act Type
            </td>   `   

        </tr>
    </table>

    <table style="width:100%;padding-left: 10px;" class="hello full-width innertable">
        <thead >
            <tr style="background-color: #a9a6a6">
                <th style="border: 1px solid #a9a6a6;"> Date Raised </th>
                <th style="border: 1px solid #a9a6a6;"> Description </th>
                <th style="border: 1px solid #a9a6a6;"> Raised By</th>
                <th style="border: 1px solid #a9a6a6;"> Location </th>
                <th style="border: 1px solid #a9a6a6;"> Proposed Corrective / Preventive Action </th>
                <th style="border: 1px solid #a9a6a6;"> Responsible Person </th>
                <th style="border: 1px solid #a9a6a6;"> Agreed Closed Out Date </th>
                <th style="border: 1px solid #a9a6a6;"> Date Closed </th>
                <th style="border: 1px solid #a9a6a6;"> Status </th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach ($editDataUnsafe as $keysafe => $valuesafe) {
        ?>
                    <tr>
                        <td style="border: 1px solid #a9a6a6;"><?php echo date('d-m-Y H:i:s', strtotime($valuesafe->ATAR_REPORT_DATETIME)); ?></td>
                        <?php if($valuesafe->ATAR_INC_DESC_FINDING != ""){ 
                            $find = $valuesafe->ATAR_INC_DESC_FINDING;
                            
                        }else{
                            $find = $valuesafe->ATAR_USEE_WHAT_RECCOM;
                        } ?>
                        <?php if($valuesafe->ATAR_UACT_WHAT != ""){ 
                            $recomm = $valuesafe->ATAR_UACT_WHAT;
                            
                        }else{
                            $recomm = $valuesafe->ATAR_USEE_WHAT_RECCOM;
                        } ?>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $find; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valuesafe->Reporter; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valuesafe->loc_name; ?></td>
                         <td style="border: 1px solid #a9a6a6;"><?php echo  $recomm ;?></td>
                       
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valuesafe->Hod; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo convertDate($valuesafe->ATAR_HSSE_DATE, 'd-m-Y'); ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo convertDate($valuesafe->ATAR_ASSIGN_HOD_DATE, 'd-m-Y'); ?></td>
                                         <td style="border: 1px solid #a9a6a6;">
        <?php echo ($valuesafe->ATAR_APP_STATUS == 3) ? 'Approved' : '-'; ?>
                        </td>
                       
                    </tr>
        <?php
    }
}
?>
        </tbody>
    </table>

    <div style="clear:both"></div>
    <?php
if (is_array($editDatamachine) && $editDatamachine != '') { ?>
  <table style="width:100%;padding-bottom: 10px;margin-top: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
               Machineries/Equipment/tools non-compliance Type
            </td>   `   

        </tr>
    </table>

    <table style="width:100%;padding-left: 10px;" class="hello full-width innertable">
        <thead >
            <tr style="background-color: #a9a6a6">
                <th style="border: 1px solid #a9a6a6;"> Date Raised </th>
                <th style="border: 1px solid #a9a6a6;"> Description </th>
                <th style="border: 1px solid #a9a6a6;"> Raised By</th>
                <th style="border: 1px solid #a9a6a6;"> Location </th>
                <th style="border: 1px solid #a9a6a6;"> Proposed Corrective / Preventive Action </th>
                <th style="border: 1px solid #a9a6a6;"> Responsible Person </th>
                <th style="border: 1px solid #a9a6a6;"> Agreed Closed Out Date </th>
                <th style="border: 1px solid #a9a6a6;"> Date Closed </th>
                <th style="border: 1px solid #a9a6a6;"> Status </th>
            </tr>
        </thead>
        <tbody>
<?php

    foreach ($editDatamachine as $keymac => $valuemac) {
        ?>
                    <tr>
                        <td style="border: 1px solid #a9a6a6;"><?php echo date('d-m-Y H:i:s', strtotime($valuemac->ATAR_REPORT_DATETIME)); ?></td>
       
                         <?php if($valuemac->ATAR_INC_DESC_FINDING != ""){ 
                            $find = $valuemac->ATAR_INC_DESC_FINDING;
                            
                        }else{
                            $find = $valuemac->ATAR_USEE_WHAT_RECCOM;
                        } ?>
                        <?php if($valuemac->ATAR_UACT_WHAT != ""){ 
                            $recomm = $valuemac->ATAR_UACT_WHAT;
                            
                        }else{
                            $recomm = $valuemac->ATAR_USEE_WHAT_RECCOM;
                        } ?>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $find; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valuemac->Reporter; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valuemac->loc_name; ?></td>
                          <td style="border: 1px solid #a9a6a6;"><?php echo  $recomm ;?></td>
                       <td style="border: 1px solid #a9a6a6;"><?php echo $valuemac->Hod; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo convertDate($valuemac->ATAR_HSSE_DATE, 'd-m-Y'); ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo convertDate($valuemac->ATAR_ASSIGN_HOD_DATE, 'd-m-Y'); ?></td>
                                         <td style="border: 1px solid #a9a6a6;">
        <?php echo ($valuemac->ATAR_APP_STATUS == 3) ? 'Approved' : '-'; ?>
                        </td>
                       
                    </tr>
        <?php
    }
}
?>
        </tbody>
    </table>

    <div style="clear:both"></div>
    <?php
if (is_array($editDatahouse) && $editDatahouse != '') { ?>
  <table style="width:100%;padding-bottom: 10px;margin-top: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
               House Keeping Type
            </td>   `   

        </tr>
    </table>

    <table style="width:100%;padding-left: 10px;" class="hello full-width innertable">
        <thead >
            <tr style="background-color: #a9a6a6">
                <th style="border: 1px solid #a9a6a6;"> Date Raised </th>
                <th style="border: 1px solid #a9a6a6;"> Description </th>
                <th style="border: 1px solid #a9a6a6;"> Raised By</th>
                <th style="border: 1px solid #a9a6a6;"> Location </th>
                <th style="border: 1px solid #a9a6a6;"> Proposed Corrective / Preventive Action </th>
                <th style="border: 1px solid #a9a6a6;"> Responsible Person </th>
                <th style="border: 1px solid #a9a6a6;"> Agreed Closed Out Date </th>
                <th style="border: 1px solid #a9a6a6;"> Date Closed </th>
                <th style="border: 1px solid #a9a6a6;"> Status </th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach ($editDatahouse as $keyhou => $valuehou) {
        ?>
                    <tr>
                        <td style="border: 1px solid #a9a6a6;"><?php echo date('d-m-Y H:i:s', strtotime($valuehou->ATAR_REPORT_DATETIME)); ?></td>
        <?php if($valuesafe->ATAR_INC_DESC_FINDING != ""){ 
                            $find = $valuehou->ATAR_INC_DESC_FINDING;
                            
                        }else{
                            $find = $valuehou->ATAR_USEE_WHAT_RECCOM;
                        } ?>
                        <?php if($valuehou->ATAR_UACT_WHAT != ""){ 
                            $recomm = $valuehou->ATAR_UACT_WHAT;
                            
                        }else{
                            $recomm = $valuehou->ATAR_USEE_WHAT_RECCOM;
                        } ?>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $find; ?></td>
                                 <td style="border: 1px solid #a9a6a6;"><?php echo $valuehou->Reporter; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valuehou->loc_name; ?></td>
                          <td style="border: 1px solid #a9a6a6;"><?php echo  $recomm ;?></td>
                       <td style="border: 1px solid #a9a6a6;"><?php echo $valuehou->Hod; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo convertDate($valuehou->ATAR_HSSE_DATE, 'd-m-Y'); ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo convertDate($valuehou->ATAR_ASSIGN_HOD_DATE, 'd-m-Y'); ?></td>
                                         <td style="border: 1px solid #a9a6a6;">
       <?php echo ($valuehou->ATAR_APP_STATUS == 3) ? 'Approved' : '-'; ?>
                        </td>
                       
                    </tr>
        <?php
    }
}
?>
        </tbody>
    </table>

    <div style="clear:both"></div>
<?php
if (is_array($editDatacondition) && $editDatacondition != '') { ?>
 <table style="width:100%;padding-bottom: 10px;margin-top: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
               Unsafe condition Type
            </td>   `   

        </tr>
    </table>

    <table style="width:100%;padding-left: 10px;" class="hello full-width innertable">
        <thead >
            <tr style="background-color: #a9a6a6">
                <th style="border: 1px solid #a9a6a6;"> Date Raised </th>
                <th style="border: 1px solid #a9a6a6;"> Description </th>
                <th style="border: 1px solid #a9a6a6;"> Raised By</th>
                <th style="border: 1px solid #a9a6a6;"> Location </th>
                <th style="border: 1px solid #a9a6a6;"> Proposed Corrective / Preventive Action </th>
                <th style="border: 1px solid #a9a6a6;"> Responsible Person </th>
                <th style="border: 1px solid #a9a6a6;"> Agreed Closed Out Date </th>
                <th style="border: 1px solid #a9a6a6;"> Date Closed </th>
                <th style="border: 1px solid #a9a6a6;"> Status </th>
            </tr>
        </thead>
        <tbody>
<?php

    foreach ($editDatacondition as $keycon => $valuecon) {
        ?>
                    <tr>
                        <td style="border: 1px solid #a9a6a6;"><?php echo date('d-m-Y H:i:s', strtotime($valuecon->ATAR_REPORT_DATETIME)); ?></td>
       
                         <?php if($valuecon->ATAR_INC_DESC_FINDING != ""){ 
                            $find = $valuecon->ATAR_INC_DESC_FINDING;
                            
                        }else{
                            $find = $valuecon->ATAR_USEE_WHAT_RECCOM;
                        } ?>
                        <?php if($valuecon->ATAR_UACT_WHAT != ""){ 
                            $recomm = $valuecon->ATAR_UACT_WHAT;
                            
                        }else{
                            $recomm = $valuecon->ATAR_USEE_WHAT_RECCOM;
                        } ?>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $find; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valuecon->Reporter; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valuecon->loc_name; ?></td>
                         <td style="border: 1px solid #a9a6a6;"><?php echo  $recomm ;?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valuecon->Hod; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo convertDate($valuecon->ATAR_HSSE_DATE, 'd-m-Y'); ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo convertDate($valuecon->ATAR_ASSIGN_HOD_DATE, 'd-m-Y'); ?></td>
                                         <td style="border: 1px solid #a9a6a6;">
       <?php echo ($valuecon->ATAR_APP_STATUS == 3) ? 'Approved' : '-'; ?>
                        </td>
                       
                    </tr>
        <?php
    }
}
?>
        </tbody>
    </table>

    <div style="clear:both"></div>

<?php
if (is_array($editDataenv) && $editDataenv != '') { ?>
 <table style="width:100%;padding-bottom: 10px;margin-top: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
              Environmental Type
            </td>   `   

        </tr>
    </table>

    <table style="width:100%;padding-left: 10px;" class="hello full-width innertable">
        <thead >
            <tr style="background-color: #a9a6a6">
                <th style="border: 1px solid #a9a6a6;"> Date Raised </th>
                <th style="border: 1px solid #a9a6a6;"> Description </th>
                <th style="border: 1px solid #a9a6a6;"> Raised By</th>
                <th style="border: 1px solid #a9a6a6;"> Location </th>
                <th style="border: 1px solid #a9a6a6;"> Proposed Corrective / Preventive Action </th>
                <th style="border: 1px solid #a9a6a6;"> Responsible Person </th>
                <th style="border: 1px solid #a9a6a6;"> Agreed Closed Out Date </th>
                <th style="border: 1px solid #a9a6a6;"> Date Closed </th>
                <th style="border: 1px solid #a9a6a6;"> Status </th>
            </tr>
        </thead>
        <tbody>
<?php

    foreach ($editDataenv as $keyenv => $valueenv) {
        ?>
                    <tr>
                        <td style="border: 1px solid #a9a6a6;"><?php echo date('d-m-Y H:i:s', strtotime($valueenv->ATAR_REPORT_DATETIME)); ?></td>
       
                        <?php if($valueenv->ATAR_INC_DESC_FINDING != ""){ 
                            $find = $valueenv->ATAR_INC_DESC_FINDING;
                            
                        }else{
                            $find = $valueenv->ATAR_USEE_WHAT_RECCOM;
                        } ?>
                        <?php if($valueenv->ATAR_UACT_WHAT != ""){ 
                            $recomm = $valueenv->ATAR_UACT_WHAT;
                            
                        }else{
                            $recomm = $valueenv->ATAR_USEE_WHAT_RECCOM;
                        } ?>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $find; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valueenv->Reporter; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo $valueenv->loc_name; ?></td>
                         <td style="border: 1px solid #a9a6a6;"><?php echo  $recomm ;?></td>
                       <td style="border: 1px solid #a9a6a6;"><?php echo $valueenv->Hod; ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo convertDate($valueenv->ATAR_HSSE_DATE, 'd-m-Y'); ?></td>
                        <td style="border: 1px solid #a9a6a6;"><?php echo convertDate($valueenv->ATAR_ASSIGN_HOD_DATE, 'd-m-Y'); ?></td>
                                         <td style="border: 1px solid #a9a6a6;">
       <?php echo ($valueenv->ATAR_APP_STATUS == 3) ? 'Approved' : '-'; ?>
                        </td>
                       
                    </tr>
        <?php
    }
}
?>
        </tbody>
    </table>

    <div style="clear:both"></div>
    
    <table style="width:100%;padding-left: 10px;" class="hello full-width innertable">
        <thead >
            <tr style="background-color: #a9a6a6">
                <th style="border: 1px solid #a9a6a6;"> Types </th>
                <th style="border: 1px solid #a9a6a6;"> HSSE Observations </th>
               
            </tr>
        </thead>
        <tbody >


                    <tr >
                        
                        <td style="border: 1px solid #a9a6a6;text-align: center;">Unsafe Act</td>
                        <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $editCountCat->unsafeActcount; ?></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #a9a6a6;text-align: center;">Machine /Equipment /Tools </td>
                        <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $editCountCat->machcount; ?></td>
                    </tr>
                    <tr>
                         <td style="border: 1px solid #a9a6a6;text-align: center;">Housekeeping </td>
                       <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $editCountCat->housecount; ?></td>
                    </tr>
                    <tr>
                         <td style="border: 1px solid #a9a6a6;text-align: center;">Unsafe Condition </td>
                       <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $editCountCat->unsafeConcount; ?></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #a9a6a6;text-align: center;">Environmental </td>
                             <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $editCountCat->envcount; ?></td>     
                  
                    </tr> 
        
        </tbody>
    </table>
</body>
</html>
