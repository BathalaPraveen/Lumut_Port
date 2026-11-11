<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:250px;height:75px;">';
$logo1 = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="float:right;width:200px;height:35px;">';

$ATAR_ID = postData($editData, 'ATAR_ID');
$Reporter = postData($editData, 'Reporter');
$desig = postData($editData, 'desig');

$loc_name = postData($editData, 'loc_name');
$spec_loc_name = postData($editData, 'spec_loc_name');

$ATAR_REPORT_DATETIME = date('d-m-Y H:i:s', strtotime(postData($editData, 'ATAR_REPORT_DATETIME')));
$ATAR_SPEC_LOC_OTHER = postData($editData, 'ATAR_SPEC_LOC_OTHER');

$ATAR_USEE_WHAT_RECCOM = postData($editData, 'ATAR_USEE_WHAT_RECCOM');
$ATAR_INC_DESC_FINDING = postData($editData, 'ATAR_INC_DESC_FINDING');

$ATAR_HSSE_DATE_TARGET = date('d-m-Y', strtotime(postData($editData, 'ATAR_HSSE_DATE')));

$ATAR_ASSIGN_HOD_DATE_ACTUAL = date('d-m-Y', strtotime(postData($editData, 'ATAR_ASSIGN_HOD_DATE')));
$ATAR_ASSIGN_HOD_DESC = postData($editData, 'ATAR_ASSIGN_HOD_DESC');

$ATAR_REJECT_HSSE_DESC = postData($editData, 'ATAR_REJECT_HSSE_DESC');

$Hod = postData($editData, 'Hod');
$Hsse = postData($editData, 'Hsse');
$Unithead = postData($editData, 'Unithead');
$ATAR_ASSIGN_HSSE_DESC = postData($editData, 'ATAR_ASSIGN_HSSE_DESC');
$ATAR_APP_STATUS = postData($editData, 'ATAR_APP_STATUS');
$ATAR_ASSIGN_HOD_ID = postData($editData, 'ATAR_ASSIGN_HOD_ID');
$ATAR_MAIN_CAT_ID = postData($editData, 'ATAR_MAIN_CAT_ID');
$mainCat = postData($editData, 'mainCat');

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
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">ATAR [Daily Observation]</td>


            </tr> 

        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $ATAR_ID;?></td>
            </tr>
        </table>

    </htmlpageheader>
    <htmlpageheader name="myHeader2" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">ATAR [Daily Observation]</td>


            </tr> 

        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $ATAR_ID;?></td>
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


    <table style="width:100%;padding-bottom: 10px;margin-top: 10px">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                Daily Observation Detail
            </td>

        </tr>
    </table>

    <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Reporter Name</b></td>
            <td>:</td>
            <td ><?php echo $Reporter; ?></td>
           

        </tr>
         <tr>
           <td class="tdlabel txt-uppercase"><b>Position</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $desig; ?></td>
           
        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Location</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $loc_name; ?></td>
           

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Specific Location</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo ($ATAR_SPEC_LOC_OTHER != '') ? $ATAR_SPEC_LOC_OTHER  : $spec_loc_name; ?></td>
           
        </tr>
       
     
        <tr>
            <td class="tdlabel txt-uppercase"><b>DATE and Time </b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $ATAR_REPORT_DATETIME; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Finding/ Observation</b></td>
            <td class="title-colon">:</td>
            <td colspan="1"><?php echo $ATAR_INC_DESC_FINDING; ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Recommendations</b></td>
            <td class="title-colon">:</td>
            <td colspan="1"><?php echo $ATAR_USEE_WHAT_RECCOM; ?></td>

        </tr>
         <?php if($mainCat != '' ){ ?>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Category</b></td>
            <td class="title-colon">:</td>
            <td><?php echo ($mainCat != '') ? $mainCat : '-'; ?></td>
        </tr>
        <?php }?>
    </table>
     <div style="clear:both"></div>
     
    <table style="width:100%;padding-bottom: 10px;margin-top: 10px">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                HSSE items checked Detail
            </td>

        </tr>
    </table>

    <table style="width:100%;padding-left: 10px;" class="hello full-width innertable">
    <thead >
        <tr style="background-color: #a9a6a6">
            <th style="border: 1px solid #a9a6a6;"> ITEM </th>
            <th style="border: 1px solid #a9a6a6;"> STATUS (Y/N) </th>
            <th style="border: 1px solid #a9a6a6;"> ITEM </th>
            <th style="border: 1px solid #a9a6a6;"> STATUS (Y/N) </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #a9a6a6;">1. PERMIT TO WORK SYSTEM</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php  echo $obsdetails->PERMIT_TO_WORK; ?></td>
            <td style="border: 1px solid #a9a6a6;">12. ACCESS & EGRESS</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->ACCESS; ?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #a9a6a6;">2. HEALTH & WELFARE</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->HEALTH; ?></td>
            <td style="border: 1px solid #a9a6a6;">13. EXCAVATION / EARTHWORKS</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->EXCAVATION; ?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #a9a6a6;">3. FIRE PRECAUTIONS</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->FIRE; ?></td>
            <td style="border: 1px solid #a9a6a6;">14. GASES / FLAMMABLE LIQUIDS</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->GASES; ?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #a9a6a6;">4. HOUSEKEEPING</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->HOUSEKEEPING; ?></td>
            <td style="border: 1px solid #a9a6a6;">15. HAZARDOUS SUBSTANCES</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->HAZARDOUS; ?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #a9a6a6;">5. PPE / SAFETY EQUIPMENT</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->PPE; ?></td>
            <td style="border: 1px solid #a9a6a6;">16. ELECTRICAL</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->ELECTRICAL; ?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #a9a6a6;">6. POWER TOOLS</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->POWER; ?></td>
            <td style="border: 1px solid #a9a6a6;">17. SAFETY SIGNS/NOTICES</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->SAFETY; ?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #a9a6a6;">7. PLANT / MACHINERY/CERTIFICATION</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->PLANT; ?></td>
            <td style="border: 1px solid #a9a6a6;">18. HAND TOOLS</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->HAND; ?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #a9a6a6;">8. LIFTING GEAR / APPLIANCES</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->LIFTING; ?></td>
            <td style="border: 1px solid #a9a6a6;">19. WORK AT HEIGHT</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->WORK_AT_HEIGHT; ?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #a9a6a6;">9. SCAFFOLDING</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->SCAFFOLDING; ?></td>
            <td style="border: 1px solid #a9a6a6;">20. RADIATION</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->RADIATION; ?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #a9a6a6;">10. BARRIERS</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->BARRIERS; ?></td>
            <td style="border: 1px solid #a9a6a6;">21. ENVIRONMENT</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->ENVIRONMENT; ?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #a9a6a6;">11. OTHERS</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->OTHERS; ?></td>
            <td style="border: 1px solid #a9a6a6;">22. OTHERS</td>
            <td style="border: 1px solid #a9a6a6;text-align: center;"><?php echo $obsdetails->OTH; ?></td>
        </tr>
    </tbody>
</table>
     <div>
         &nbsp;&nbsp;&nbsp;Remark: Disciplinary actions or fine will be charged according failure to comply with HSSE         
         instructions. 
     </div>
     <div style="clear:both"></div>
       <?php 
             if ($getudailyimage != FALSE) { ?>
     <table style="width:100%;margin-top: 10px;" class="table summ full-width innertable">
       
            <tr>
            <td colspan="4">
                <ol>
                <?php 
          
                 $i=0;
                        foreach ($getudailyimage as $akey => $attachmnt) {
                            $i++;
                            $filepath = postData($attachmnt, 'ATAR_FILE_PATH');
                            $filename = postData($attachmnt, 'ATAR_FILENAME');
                            $fileext = postData($attachmnt, 'ATAR_FILE_EXT');
                            $is_image = 1 ;
                            $fileFullpath = BASE_URL . $filepath.$filename ;
                            
                           // $displayLabel = ($is_image == 1) ? '<img  src="' . $fileFullpath . '" width="200px" height="150px" style="vertical-align: top;padding-top:10px;padding-bottom:10px;" />' : $filename;
                            ?>
                    <img style="margin-left:50px;padding:10px;" src="<?php echo  $fileFullpath; ?>" width="370" height="200" />
                       <?php
                        }
                        ?>
                   
                </ol>
            </td>

        </tr>
     
    </table>
    <?php } ?>
      
       <div style="clear:both"></div>
       <?php if($ATAR_APP_STATUS > 2 && $ATAR_ASSIGN_HOD_ID != 0){ ?>
        <table style="width:100%;padding-bottom: 10px;margin-top: 10px">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                Action Details
            </td>

        </tr>
    </table>
       
   <table style="width:100%;" class="table summ full-width innertable">
        <tr>
            <td class="tdlabel txt-uppercase"><b>Assigned By</b></td>
            <td>:</td>
            <td ><?php echo $Hsse; ?></td>
           
        </tr>
         <tr>
            <td class="tdlabel txt-uppercase"><b>Unit Head</b></td>
            <td>:</td>
            <td ><?php echo $Unithead; ?></td>
           
        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Assigned Person</b></td>
            <td>:</td>
            <td ><?php echo $Hod; ?></td>
           
        </tr>
         <tr>
            <td class="tdlabel txt-uppercase"><b>Targeted Date to complete action</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $ATAR_HSSE_DATE_TARGET; ?></td>

        </tr>
        <?php if($ATAR_APP_STATUS > 4 || $ATAR_APP_STATUS == 3){ ?>
         <tr>
            <td class="tdlabel txt-uppercase"><b>Description entered by HOD</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $ATAR_ASSIGN_HOD_DESC; ?></td>

        </tr>
  
        <tr>
            <td class="tdlabel txt-uppercase"><b>Date Closed</b></td>
            <td>:</td>
            <td ><?php echo $ATAR_ASSIGN_HOD_DATE_ACTUAL; ?></td>
           
        </tr>
        <?php }?>
         <?php if($ATAR_ASSIGN_HSSE_DESC != '' && $ATAR_APP_STATUS == 3){ ?>
         <tr>
            <td class="tdlabel txt-uppercase"><b>Reason for approval</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $ATAR_REJECT_HSSE_DESC; ?></td>

        </tr>
         <?php }?>
        <?php if($ATAR_REJECT_HSSE_DESC != '' && $ATAR_APP_STATUS >= 5){ ?>
         <tr>
            <td class="tdlabel txt-uppercase"><b>Reason for Rejection</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $ATAR_REJECT_HSSE_DESC; ?></td>

        </tr>
         <?php }?>
       
    </table>
   <?php 
             if ($getudailyafterimage!= FALSE) { ?>
  <table style="width:100%;" class="table summ full-width innertable">
       
            <tr>
            <td colspan="6">
                <ol>
                <?php 
            
                 $i=0;
                        foreach ($getudailyafterimage as $akey => $attachmnt) {
                            $i++;
                            $filepath = postData($attachmnt, 'ATAR_FILE_PATH');
                            $filename = postData($attachmnt, 'ATAR_FILENAME');
                            $fileext = postData($attachmnt, 'ATAR_FILE_EXT');
                            $is_image = 1 ;
                            $fileFullpath = BASE_URL . $filepath.$filename ;
                            
                           // $displayLabel = ($is_image == 1) ? '<img  src="' . $fileFullpath . '" width="200px" height="150px" style="vertical-align: top;padding-top:10px;padding-bottom:10px;" />' : $filename;
                            ?>
                     <img style="margin-left:50px;padding:10px;" src="<?php echo  $fileFullpath; ?>" width="250" height="200" />
                       <?php
                        }
                        ?>
                    
                </ol>
            </td>

        </tr>
     
    </table>
       <?php } ?>
        <?php } ?>
        </body>
</html>

