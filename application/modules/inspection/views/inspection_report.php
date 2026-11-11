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
  .emplDetPhoto{
        border: 1px solid #acc4d8;
        padding: 10px;
        margin: 2%;
    }


        </style>
    </head>    
    <body style="font-family:'calibri';">        
   <htmlpageheader name="myHeader1" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">HSSE INSPECTION</td>


            </tr> 

        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $InspBasicDet->INSP_ID;?></td>
            </tr>
        </table>

    </htmlpageheader>
    <htmlpageheader name="myHeader2" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">HSSE INSPECTION</td>


            </tr> 

        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $InspBasicDet->INSP_ID;?></td>
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
            <td class="tdlabel txt-uppercase"><b>Inspection ID</b></td>
            <td>:</td>
            <td ><?php echo $InspBasicDet->INSP_ID; ?></td>
            <td class="tdlabel txt-uppercase"><b>Inspection Date</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo date('d-m-Y', strtotime($InspBasicDet->INSPECTION_DATE)); ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Inspected By</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $InspBasicDet->hsseName; ?></td>
            <td class="tdlabel txt-uppercase"><b>Next Inspection Date</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo date('d-m-Y', strtotime($InspBasicDet->NXT_INSP_DATE)); ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Type of Inspection</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $InspBasicDet->INSP_MOD_NAME_NUM; ?></td>
            <td class="tdlabel txt-uppercase"><b>Registration No</b></td><td class="title-colon">:</td>
            <td ><?php echo postData($InspBasicDet, 'INSP_REG_NUMBER', ' -'); ?></td>

        </tr>
       
        <tr>
            <td class="tdlabel txt-uppercase"><b>Driver/Operator Name</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo postData($InspBasicDet, 'INSP_DRIVER_OPT_NAME', ' -'); ?></td>
            <td class="tdlabel txt-uppercase"><b>PMA/PMT No</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo postData($InspBasicDet, 'INSP_PMA_PMT_NO', ' -'); ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>PMA/PMT Due Date</b></td>
            <td class="title-colon">:</td>
            <td >
                <?php 
                $basicPmadate = $InspBasicDet->INSP_PMA_PMT_DUE_DATE;
                       if($basicPmadate != ''){
                            echo date('d-m-Y', strtotime($InspBasicDet->INSP_PMA_PMT_DUE_DATE)); 
                        }else{
                            echo "-";
                        } ?>
              
            </td>
            <td class="tdlabel txt-uppercase"><b>Certificate No</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo postData($InspBasicDet, 'INSP_CERT_NUM', ' -'); ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Colour Code</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo postData($InspBasicDet, 'INSP_COLOUR_CODE_INS_TYPE', ' -'); ?></td>
            <td class="tdlabel txt-uppercase"><b>Terminal</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo postData($InspBasicDet, 'TERMINAL_NAME', ' -'); ?></td>

        </tr>
        <tr>
            <td class="tdlabel txt-uppercase"><b>Department</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo postData($InspBasicDet, 'DEPT_NAME', ' -'); ?></td>
             <td class="tdlabel txt-uppercase"><b>Verified By</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo postData($InspBasicDet,'execName',' -'); ?></td>
                                                  

        </tr>
       
        <tr>
            <td class="tdlabel txt-uppercase"><b>Description</b></td>
            <td class="title-colon">:</td>
            <td colspan="4"><?php echo postData($InspBasicDet, 'INSP_DESC', ' -'); ?></td>

        </tr>
    </table>
    
    <br>
    
    <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                CheckList Details
            </td>

        </tr>
    </table>

    <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">
        

        <div class="box-body" style="padding:15px 0;">
            <table style="width:100%;padding-left: 10px;padding: 15px;" class=" full-width innertable ">

                <thead style=" background-color: rgb(228, 228, 228) !important;">
                    <tr style="background-color: rgb(228, 228, 228) !important;">
                        <th style="width:7%;">S/No</th>
                        <th style="width:40%;" >CHECK ITEMS</th>
                        <th style="width:30%;" colspan="3">RESULT</th>
                        <th style="width:30%;" >REMARKS</th>

                    </tr>
                    <tr style="background-color: rgb(228, 228, 228) !important;">
                        <th style="width:7%;"></th>
                        <th style="width:40%;"></th>
                        <th style="width:10%;">GOOD</th>
                        <th style="width:10%;">POOR</th>
                        <th style="width:10%;">N/A</th>
                        <th style="width:30%"></th>
                    </tr>

                </thead>

<!--            </table>

            <table style="width:100%;padding-left: 10px;padding: 15px;border-spacing: 0;"  class="full-width innertable ">-->
                <tbody >

                    <?php
                    $i = 1;
                    $checkData = '';
//                                                echo "<pre>";
//                                                print_R($InspectionDet);
//                                                exit;
                    if (isset($InspectionDet) && !empty($InspectionDet)) {

                        foreach ($InspectionDet as $insDKey => $InsData) {
                            $chkSubtypname = postData($InsData, 'subTyp');
                            if ($chkSubtypname != '') {
                                ?>
                                <tr style="background-color: #FFFF00;color:#000;font-weight:bold;border:none;padding-top:10px;" class="subTypclass">
                                    <td></td>
                                    <td colspan="4" style="color:#000;font-weight:bold;text-align:center;"><b><?php echo $chkSubtypname ?></b></td>
                                    <td></td>
                                </tr>
                            <?php
                            }


                            $chkSubtypdata = postData($InsData, 'subTypdata');
                            $chkSubtypdataID = postData($InsData, 'subTypdataID');
                            $chkGoodpoorStat = postData($InsData, 'goodPoor');
                            $chkStatusremark = postData($InsData, 'remaRk');
                            $chkImgdesc = postData($InsData, 'quesDesc');
                            $chkImgPath = postData($InsData, 'filePath');
                            $chkImgname = postData($InsData, 'fileName');

                            $expSubtypdataid = explode(",", $chkSubtypdataID);
                            $expSubtypdatadesc = explode("@", $chkSubtypdata);
                            $expGPstatus = explode(",", $chkGoodpoorStat);
                            $expGPremark = explode(",", $chkStatusremark);
                            $expImagdesc = explode(",", $chkImgdesc);
                            $expImagname = explode(",", $chkImgname);

                            $cdIncr = 0;
                            $imgInd = 0;
                            foreach ($expSubtypdataid as $cdKey => $cdVal) {
                                $bfrKeyval = $cdKey + 1;
                                $goodChecked = '';
                                $poorChecked = '';
                                $naChecked = '';
                                $attRemark = '';
                                $explgooPoorImg = false;

                                $explgooPoor = explode("@", $expGPstatus[$cdIncr]);
                                $explgooPoorRemark = explode("@", $expGPremark[$cdIncr]);

                                if (!empty($expGPstatus[$cdIncr]) && ($explgooPoor[1] == $cdVal)) {

                                    if ($explgooPoor[0] == 1) {
//                                        $goodChecked = '<i class="fa fa-check" aria-hidden="true"></i>';
                                        $goodChecked = '<span style="font-family:arial">&#10004;</span>';
                                    } elseif ($explgooPoor[0] == 2) {
                                        $poorChecked = '<span style="font-family:arial">&#10004;</span>';
                                        $explgooPoorImg = true;
                                        $finalImgdesc = $expImagdesc[$cdIncr];
                                        $finalImgdesc = $expImagdesc[$cdIncr];
                                    } else {
                                        $naChecked = '<span style="font-family:arial">&#10004;</span>';
                                    }
//                                                         
                                    if ($explgooPoorRemark[0] != '') {
                                        $attRemark = $explgooPoorRemark[0];
                                    }
                                    $cdIncr++;
                                } else {
                                    $goodChecked = '<span style="font-family:arial">&#10004;</span>';
                                }
                                $finalImgdet = $chkImgPath . '' . $expImagname[$imgInd];
                                ?>


                                <tr class="" style="">
                                    <td style="width:5%;border:1px solid #bfbfbd;"><?php echo $bfrKeyval; ?></td>
                                    <td style="width:40%;text-align: left;border:1px solid #bfbfbd;"><?php echo $expSubtypdatadesc[$cdKey] ?></td>
                                    <td style="width:10%;text-align: center;border:1px solid #bfbfbd;"><?php echo $goodChecked; ?></td>
                                    <td style="width:10%;text-align: center;border:1px solid #bfbfbd;"><?php echo $poorChecked; ?></td>
                                    <td style="width:10%;text-align: center;border:1px solid #bfbfbd;"><?php echo $naChecked; ?></td>
                                    <td style="width:30%;border:1px solid #bfbfbd;"><?php echo $attRemark; ?></td>
                                </tr>
                                <?php if ($explgooPoorImg) { ?>
                                    <tr style="background: #b1cbea;color:#000000;font-weight: bold;">
                                        <td style="width:50%;text-align: center;" colspan="2"> Image</td>
                                        <td style="width:55%;text-align: center;"  colspan="4"> Description</td>

                                    </tr>
                                    <tr>
                                        <td style="width:50%;border:1px solid #bfbfbd;" colspan="2"> 
                                                <img style="height: 150px;width: 250px;" src="<?php echo BASE_URL . $finalImgdet; ?>" >
                                         
                                        </td>
                                        <td style="width:55%;border:1px solid #bfbfbd;"  colspan="4"> <?php echo $finalImgdesc; ?></td>

                                    </tr>
                                    <?php
                                    $imgInd++;
                                }
                                ?>

                            <?php }
                            ?>


    <?php }
} ?>
                </tbody>
            </table>
            
            <?php 
                                     
                                        $safunsafStat = postData($InspBasicDet,'INSP_SAFE_UNSAFE');
                                        $labSafestat = (isset($safunsafStat) && ($safunsafStat == 1)) ? 'Safe' : 'Unsafe';
                                         ?>
            <div class="row" style='margin-left:20px;text-align:justify;width:90%'>
            <div class="col-md-12">
                <span style='font-family:helvetica'>&#10004;</span> &nbsp;&nbsp;I have conducted an inspection and hereby declared that the mention tool / equipment / machine is <b> <?php echo $labSafestat; ?> </b> for use during the time of inspection.
                                              
            </div>
        </div>
            
            <?php if(isset($getAllmoreimages) && !empty($getAllmoreimages)){ ?>
            <div class="row" style="margin: 10px;text-decoration: underline;">
                <div class="col-md-12">
                    <b>Image Upload</b>
                </div>
            </div>
             <div class="row" style="padding-left:35px;">
                                    <div class="col-md-12">
                                        
                                         <div class="rows" >
                                        <?php
                                                foreach($getAllmoreimages as $amiKey => $amiVal){
                                                    $moreImgname = postData($amiVal,'INSP_NOT_IMG_FILENAME');
                                                    $moreImgpath = postData($amiVal,'INSP_NOT_IMG_FILEPATH');
                                                    $addMorimageloc = $moreImgpath.''.$moreImgname;
                                                ?>
                                             
                                                <div style="width:50%;float: left;">
                                                    <div style="display: inline-block;max-width: 100vw;margin-bottom: 9px;" >
                                                        <div  style="width: 300px; height: 250px;display: inline-block;margin-bottom: 5px;overflow: hidden;text-align: center;vertical-align: middle;">
                                                            <img  src="<?php echo BASE_URL.$addMorimageloc; ?>"  style="vertical-align: top;padding-top:10px;padding-bottom:10px;width: 300px; height: 250px" />
                                                           
                                                        </div>

                                                    </div>	    
                                                </div>
                                
                                        
                                            <?php 
                                            
                                       } ?>
                                             </div>
                                         
                                    </div>
                                </div>
             <?php  } ?>
            
            
            <?php if(!empty(postData($InspBasicDet,'INSP_NOTE_DESC'))){ ?>
        <div class="row" style='margin-left:20px;width:90%;margin-top:20px;'>
            <div class="col-md-12">
                <label><b>NOTE : </b></label>
                <span style="text-align:justify;"><?php echo postData($InspBasicDet,'INSP_NOTE_DESC'); ?></span>
            </div>
        </div>
            <?php } ?>

        </div> 
        

    </div>  


</body>
</html>

