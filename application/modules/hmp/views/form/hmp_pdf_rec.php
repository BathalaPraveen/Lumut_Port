<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:250px;height:75px;">';
$logo1 = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="float:right;width:200px;height:35px;">';
?>

<?php
//echo "<pre>";
//print_r($getEmploydetails);
//exit;
$REC_ID = postData($editData,'REC_ID');
$REC_NAME = postData($editData,'REC_NAME');
$REC_MOD_NAME = postData($editData,'REC_MOD_NAME');
$REC_DESC = postData($editData,'REC_DESC');
$REC_LOC_NAME = postData($editData,'REC_LOC_NAME');
$EMP_NAME = postData($editData,'EMP_NAME');
$terName = postData($editData,'loc_name');
if($editData->REC_REC_DATE != ''){
$recdate = date('d-m-Y',strtotime($editData->REC_REC_DATE));
}else{
   $recdate = ''; 
}
if($editData->REC_EXP_DATE != ''){
$expdate = date('d-m-Y',strtotime($editData->REC_EXP_DATE));
}else{
   $expdate = ''; 
}
$recStatus = postData($editData,'REC_MAIN_STATUS');

if($emplCertStatus == 1){
    $finStatus = 'Valid';
}else{
    $finStatus = 'Expired';
}

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
    <body style="font-family:'arial';">        
    
        <htmlpageheader name="myHeader1" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">RECORD MASTER</td>


            </tr> 

        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $REC_ID;?></td>
            </tr>
        </table>

    </htmlpageheader>
    <htmlpageheader name="myHeader2" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">RECORD MASTER</td>


            </tr> 

        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $REC_ID;?></td>
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
    
    <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                 BASIC DETAILS
            </td>

        </tr>
    </table>
    
    <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td width="23%" class="tdlabel txt-uppercase"><b>Record ID</b></td>
            <td>:</td>
            <td width="23%"><?php echo $REC_ID; ?></td>
            <td width="23%" class="tdlabel txt-uppercase"><b>Record Name</b></td>
            <td class="title-colon">:</td>
            <td width="23%"><?php echo $REC_NAME;; ?></td>

        </tr>
        <tr>
            <td width="23%" class="tdlabel txt-uppercase"><b>Terminal</b></td>
            <td class="title-colon">:</td>
            <td width="23%"><?php echo $terName; ?></td>
            <td width="23%" class="tdlabel txt-uppercase"><b>Record Date</b></td>
            <td class="title-colon">:</td>
            <td width="23%"><?php echo $recdate; ?></td>

        </tr>
        <tr>
            <td width="23%" class="tdlabel txt-uppercase"><b>Expiry Date</b></td>
            <td class="title-colon">:</td>
            <td width="23%"><?php echo $expdate; ?></td>
            <td width="23%" class="tdlabel txt-uppercase"><b>Model Name/No</b></td>
            <td class="title-colon">:</td>
            <td width="23%"><?php echo $REC_MOD_NAME; ?></td>

        </tr>
        <tr>
            <td width="23%" class="tdlabel txt-uppercase"><b>Location Detail</b></td>
            <td class="title-colon">:</td>
            <td width="23%"><?php echo $REC_LOC_NAME; ?></td>
            <td width="23%" class="tdlabel txt-uppercase"><b>Recorded By</b></td>
            <td class="title-colon">:</td>
            <td width="23%"><?php echo $EMP_NAME; ?></td>

        </tr>
        <tr>
            <td width="23%" class="tdlabel txt-uppercase"><b>Description</b></td>
            <td class="title-colon">:</td>
            <td width="23%"><?php echo $REC_DESC; ?></td>
            

        </tr>
     
    </table>
    
<br>
<br>


    <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                DOCUMENT DETAILS
            </td>

        </tr>
    </table>
    
    <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        

        <div class="box-body" style="padding:15px 0;">
            <table style="width:100%;padding-left: 10px;padding: 15px;" class=" full-width innertable ">

                <thead style=" background-color: rgb(228, 228, 228) !important;height:10px !important;">
                    <tr style="background-color: rgb(228, 228, 228) !important;height:10px !important;">
                        <th style="width:7%;" class="txt-uppercase">S/No</th>
                        <th style="width:50%;" class="txt-uppercase">Document</th>

                    </tr>
                  
                </thead>
                <tbody >
                     <?php
                $i = 1;
                $checkData = '';
                if (isset($getOthercertdet) && !empty($getOthercertdet)) {
                    foreach ($getOthercertdet as $insDKey => $InsData) {
                         $fileExtn = postData($InsData,'REC_FILE_EXT');
                        $bfrKeyval = $insDKey - 1;
                        ?>

                     <tr>
                                <td style="width:20%;text-align:center"><?php echo $i++; ?></td>
                                <?php if ($InsData->REC_FILENAME != '') { ?>
                                    <td style="width:40%;text-align:center;">
                                        <?php if($fileExtn != '.pdf'){ ?>
                                        <img src="<?php echo BASE_URL.$InsData->REC_FILE_PATH.''.$InsData->REC_FILENAME; ?>" style="height:15%" alt="<?php echo $InsData->REC_FILENAME; ?>">
                                        <?php }else{ ?>
                                       <?php echo $InsData->REC_FILENAME; ?>
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
    
</body>
</html>
