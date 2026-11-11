<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:250px;height:75px;">';
$logo1 = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="float:right;width:200px;height:35px;">';
$specLtnid = explode(",",postData($InspBasicDet,'MON_INSP_SPE_LOC_ID'));
$specLtnname = postData($InspBasicDet,'specLoctn');
$specLtnother = postData($InspBasicDet,'MON_INSP_SPE_LOC_OTHER');
if(in_array("-1",$specLtnid)){
    $finalSpectlctn = $specLtnname.','.$specLtnother;
}else{
    $finalSpectlctn = $specLtnname;
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
    <body style="font-family:'calibri';">        
    <htmlpageheader name="myHeader1" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">HSSE MONTHLY INSPECTION</td>


            </tr> 

        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $InspBasicDet->MON_INSP_ID;?></td>
            </tr>
        </table>

    </htmlpageheader>
    <htmlpageheader name="myHeader2" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="" >
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">HSSE MONTHLY INSPECTION</td>


            </tr> 

        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #000;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $InspBasicDet->MON_INSP_ID;?></td>
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
            <td ><?php echo $InspBasicDet->MON_INSP_ID; ?></td>
            <td class="tdlabel txt-uppercase"><b>Inspection Date</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo date('d-m-Y', strtotime($InspBasicDet->MON_INSPECTION_DATE)); ?></td>

        </tr>
       <tr>
	   
           
            <td class="tdlabel txt-uppercase"><b>Terminal</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo postData($InspBasicDet, 'TERMINAL_NAME', ' -'); ?></td>
           
		     <td class="tdlabel txt-uppercase"><b> Location</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $finalSpectlctn; ?></td>
            
        </tr>
        <tr>
         
			
			 <td class="tdlabel txt-uppercase"><b>Inspected By</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $InspBasicDet->EMP_NAME; ?></td>
			<?php if($activityDets[0]->revName !=''){ ?>
             <td class="tdlabel txt-uppercase"><b> Reviewed By</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $activityDets[0]->revName ?></td>
            <?php } ?>
        </tr>

        
         <tr>
            
            <?php if($activityDets[0]->verifName !=''){ ?>
             <td class="tdlabel txt-uppercase"><b> Verified By</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $activityDets[0]->verifName ?></td>
            <?php } ?>
            
             <?php if($activityDets[0]->apprName !=''){ ?>
             <td class="tdlabel txt-uppercase"><b> Approved By</b></td>
            <td class="title-colon">:</td>
            <td ><?php echo $activityDets[0]->apprName ?></td>
            <?php } ?>
        </tr>
        
        
      
       

    </table>
    


    <br>
    
    <table style="width:100%;padding-bottom: 10px;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                padding: 5px 5px 5px;">
                CHECKLIST DETAILS
            </td>

        </tr>
    </table>

    <div class="box fsize" style="border:1px solid #aba90b;border-radius:0px;">

        
        <div class="box-body" style="padding:5px 0;">
            
            <?php  
//            echo "<pre>";
//            print_r($InspectionDet);
//            exit;

                                    if(isset($InspectionDet) && !empty($InspectionDet)){ 
                                        $i = 1;
                                        $checkData='';
                                         $finalMaxscore = 0;
                                        $finalGivenscore = 0;
                                        foreach ($InspectionDet as $insDKey => $InsData) {
                                           
                                                     $chkSubtypname = postData($InsData,'subTyp');
                                                     
                                                   
                                                  $chkSubtypdata = postData($InsData,'subTypdata');
                                                  $chkSubtypdataID = postData($InsData,'subTypdataID');
                                                  $expRadioSD = explode(",",$InsData->scoreValue);                   
                                                    $expRemark = explode(",",$InsData->remaRk); 
                                                  $chkImgdesc = postData($InsData,'quesDesc');
                                                  $chkImgPath = explode(",",$InsData->filePath);
                                                  $chkImgname = explode(",",$InsData->fileName);
                                                  
                                                   $expSubtypid = postData($editVal,'FK_MON_SUB_CAT_ID');                   
//                                           $inspUserstatval = postData($editVal,'INSP_USER_STATUS');                   
                                           
                                           $expinspDetid = explode(",",$editVal->inspDetID); 
                                                 
                                                  $expSubtypdataid = explode(",",$chkSubtypdataID);
                                                  $expSubtypdatadesc = explode("@",$chkSubtypdata);
                                                   
                                        ?>
            
            <table style="width:100%;padding-left: 10px;padding: 15px;" class=" full-width innertable ">
                 <?php //   if($chkSubtypname != ''){ ?>
                
                <thead style="background-color: rgb(228, 228, 228) !important;;font-weight: bold;color:#000000 !important;text-align:center;">
                    <tr style="background-color: rgb(228, 228, 228) !important;">
<!--                        <th style="width:7%;"></th>-->
                        <th style="width:50%;margin-left:10%" colspan="2">Item</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        
                    </tr>
                    <tr style="background-color: rgb(228, 228, 228) !important;">
                        <th style="width:7%;">S/No</th>
                        <th style="width:50%;" ><?php echo $chkSubtypname; ?></th>
                        <th style="width:10%;">MAX SCORE</th>
                        <th style="width:10%;" >GIVEN SCORE</th>
                        <th style="width:30%;" >COMMENTS</th>
                    </tr>
                  
                </thead>

            <!--</table>-->
             <?php // } ?>
            <!--<table style="width:100%;padding-left: 10px;padding: 15px;border-spacing: 0;"  class="full-width innertable ">-->
                <tbody >
 <?php
                                               
                                                  $goodRadkey = 0;
                                                  $imgInd = 0;
                                                 
                                                   $calculateGivenscore = 0;
                                                  $calculateMaxscore = 0;
                                                  foreach($expSubtypdataid as $cdKey => $cdVal){
                                                     
                                                       $bfrKeyval = $cdKey+1;
                                                     $scoreZero = '';
                                                    $scoreOne = '';
                                                     $scoreTwo = '';
                                                     $scoreThree = '';
                                                     $scoreNA = '';
                                                     $scoreValue = '';
                                                     $attRemark = '-';
                                                    $explgooPoorImg = false;
                                                    
                                                     $maximumScore = 3;
                                                     $explFileimg = explode("@",$chkImgname[$goodRadkey]);
                                                     $explScore = explode("@",$expRadioSD[$goodRadkey]);
                                                     $explgooPoorRemark = explode("@",$expRemark[$goodRadkey]);
                                                   
                                                     
                                                       if(!empty($expRadioSD[$goodRadkey]) && ($explScore[1] == $cdVal)){
                                                          
                                                              if($explScore[0] == 0){
                                                                   $scoreValue = '0';
                                                                   
                                                              }
                                                              elseif($explScore[0] == 1){
                                                                   $scoreValue = 1;
                                                                  
                                                              }elseif($explScore[0] == 2){
                                                                  $scoreValue = 2;
                                                                 
                                                              }elseif($explScore[0] == 3){
                                                                  $scoreValue = 3;
                                                                 
                                                              }else{
                                                                   $scoreValue = 'NA';
                                                              }
//                                                         
                                                              if($explgooPoorRemark[0] != ''){
                                                                  $attRemark = $explgooPoorRemark[0];
                                                              }
                                                          $goodRadkey++;
                                                      }else{
                                                         $scoreValue = 3;
                                                      }
                                                      if($explFileimg[1] == $cdVal){
                                                          $finalImgdet = $expBfrimgpath[0].''.$explFileimg[0];
                                                          $imageAppend = true;
                                                      }else{
                                                          $finalImgdet = '';
                                                          $imageAppend = false;
                                                      }
                                                      
                                                      if($explChkListfinal[1] == $cdVal){
                                                          $checkListeditid = $explChkListfinal[0];
                                                         
                                                      }else{
                                                          $checkListeditid = '';
                                                        
                                                      }
                                                      
                                                       if($scoreValue != 'NA'){
                                                        $calculateGivenscore = $calculateGivenscore+$scoreValue;
                                                        $calculateMaxscore = $calculateMaxscore+$maximumScore;
                                                      }
//                                                   
                                                      ?>
                                                     
                                
                                <tr class="" style="">
                                    <td style="width:5%;border:1px solid #bfbfbd;"><?php echo $bfrKeyval; ?></td>
                                    <td style="width:50%;text-align: left;border:1px solid #bfbfbd;"><?php echo $expSubtypdatadesc[$cdKey] ?></td>
                                    <td style="width:10%;text-align: center;border:1px solid #bfbfbd;">
                                         <?php if($scoreValue == 'NA'){ 
                                                                    echo $scoreValue;
                                                                }else{ 
                                                                    echo 3;
                                                                } ?>
                                    </td>
                                    <td style="width:10%;text-align: center;border:1px solid #bfbfbd;"><?php echo $scoreValue; ?></td>
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
                             $finalMaxscore = $finalMaxscore+$calculateMaxscore;
                             $finalGivenscore = $finalGivenscore+$calculateGivenscore;
                            ?>
                            <tr style="text-align:center;">
                                <td style="border:1px solid #bfbfbd;text-align:center;"></td>
                                <td style="border:1px solid #bfbfbd;text-align:center;"><b>Total Points awarded:</b> </td>
                                <td style="border:1px solid #bfbfbd;text-align:center;"><b><?php echo $calculateMaxscore; ?></b></td>
                                <td style="border:1px solid #bfbfbd;text-align:center;"><b><?php echo $calculateGivenscore; ?></b></td>
                                <td style="border:1px solid #bfbfbd;text-align:center;"></td>
                            </tr>

                </tbody>
            </table>
            <?php }
} ?>
            
             <?php 
                                $percentScore = ($finalGivenscore/$finalMaxscore)*100;
                                $finalPerscore = round($percentScore,0);
                                $perfStatus = monthlyInspperformanceClasify($finalPerscore);
                                ?>
                                <table style="width:100%;padding-left: 10px;padding: 15px;" class=" full-width innertable ">
                                    <thead style="background-color: rgb(228, 228, 228) !important;">
                                        <tr style="background-color: rgb(228, 228, 228) !important;">
                                            <th>Grand Total</th>
                                            <th>Max Score</th>
                                            <th>Score</th>
                                            <th>% Mark</th>
                                            <th>Performance Classification</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="background: <?php echo postData($perfStatus,'color');  ?>">
                                            <td style="text-align:center;">Total Points</td>
                                            <td style="text-align:center;"><?php echo $finalMaxscore; ?></td>
                                            <td style="text-align:center;"><?php echo $finalGivenscore; ?></td>
                                           
                                            <td style="text-align:center;"><?php echo $finalPerscore; ?></td>
                                            <td style="text-align:center;"><?php echo postData($perfStatus,'status');  ?></td>
                                           
                                        </tr>
                                        
                                    </tbody>
                                 </table>
            
            
                            <?php 

                                if(isset($InspectionDet) && !empty($InspectionDet)){  
                                    $initCheckpic = explode("@",$InspectionDet[0]->fileName);
                                   
                             //   if($initCheckpic[0] != ''){ 
                                    ?>
                                  <div class="row" style="padding-left:25px;">
                                    <div class="col-md-12">
                                        <h4>PHOTO ATTACHMENTS</h4>
                                    </div>
                                </div>
								
								
							<!--	 <table style="width:100%;padding-left: 10px;padding: 15px;" class=" full-width innertable ">
                                    <thead style="background-color: rgb(228, 228, 228) !important;">
									<tr style="background-color: rgb(228, 228, 228) !important;">
								  <th style="width:70%;text-align:center;">Image</th>
								  <th style="width:30%;text-align:center;">Description</th>
								  </tr>
								   </thead>
                               </table> -->
							 
                              
                                        <?php 
//                                   
                                        foreach($InspectionDet as $inKey => $inVal){
                                            $filename = postData($inVal,'fileName');
                                            $imgRemark = postData($inVal,'remaRk');
                                             $expFilename = explode(",",$filename);
//                                           
                                             ?>
										  <table style="width:100%;padding-left: 10px;padding: 15px;" class=" full-width innertable ">
								 <?php foreach($expFilename as $fikey => $fiVal){
                                           
                                            $filepath = 'assets/images/modules/inspection/monthly/';
                                            $expFilenameAt = explode("@",$fiVal);
                                            $expRemark = explode(",",$imgRemark);
                                            $finalFilename = $expFilenameAt[0];
                                            $subtypDataid = $expFilenameAt[1];
                                            $appenImg = '';
//                                         
                                            if($finalFilename != ''){
                                           
                                                $appenImg = BASE_URL.''.$filepath.''.$finalFilename;
//                                         
                                        ?>
								   
								   <tbody>
                                       
										
										
								   
								   
                                             
                                                
												
												<tr style="display: inline-block;">
								   <td style="width:65%;display: inline-block;overflow: hidden;text-align: center;vertical-align: middle;border:1px solid #bfbfbd;"><img  src="<?php echo $appenImg; ?>"  style="vertical-align: top;width: 300px; height: 250px" /></td>
								   <td style="width:35%;display: inline-block;overflow: hidden;text-align: center;vertical-align: middle;border:1px solid #bfbfbd;"><p><?php echo $expRemark[$fikey]; ?></p></td>
								   </tr>
												
												
                                                   
                                          
                                
                                        
                                          
									    </tbody>
										
										  <?php 
                                            
                                       } } ?>
								   </table>
                                           
                                          <?php  } 
//                                         exit;
                                          
                                            ?>
										
											
                                   
                             
            
                                <?php } //} ?>
             

                                <!--</div>-->
            

        </div> 
   

    </div>
    
                                <table style="width:100%;padding-bottom: 10px;margin-top:20px;">
                                    <tr>
                                        <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;display: inline-block;
                                            padding: 5px 5px 5px;">
                                            INSPECTION ACTIVITY DETAILS
                                        </td>

                                    </tr>
                                </table>
            
                                  <table style="width:100%;" class="table summ full-width innertable">
                                                    
                                                    <tbody>
                                                    
                                                     <tr>
                                                        <td style="background-color:#FFFF00;"><b >Prepared By</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $activityDet[0]->HSSEname ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td>
                                                            <?php echo date("d-m-Y H:i:s",strtotime($activityDet[0]->MON_ACT_INSP_HSSE_DATE)); ?>
                                                            
                                                        </td>
														
                                                    </tr>
                                                     <tr>
                                                        <td></td>
                                                    </tr>
													
                                                    <?php if(isset($activityDet) && !empty($activityDet)){ 
                                                            foreach($activityDet as $acKey => $acVal){
                                                                $reviewName = postData($acVal,'revName');
                                                                $verifyName = postData($acVal,'verifName');
                                                                $approvName = postData($acVal,'apprName');
                                                                $hssEName = postData($acVal,'HSSEname');
                                                                
                                                                $reviCmnt = postData($acVal,'MON_ACT_INSP_REVIEWER_COMMNET');
                                                                $verifiCmnt = postData($acVal,'MON_ACT_INSP_VERIFIER_COMMENT');
                                                                $approvCmnt = postData($acVal,'MON_ACT_INSP_APPROVER_COMMENT');
                                                                
                                                                $inspAccrej = postData($acVal,'MON_ACT_INSP_ACC_REJ_STATUS');
                                                                if($reviewName != ''){
                                                                    $reviewDate = date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_REVIEW_DATE));
                                                                            if($inspAccrej == 1){
                                                            ?>
                                                                                <tr>
                                                                                    <td style="background-color:#FFFF00;"><b>Review By</b></td>
                                                                                    <td>:</td>
                                                                                    <td><?php echo $reviewName; ?></td>
                                                                                    <td><b>Date & Time</b></td>
                                                                                    <td>:</td>
                                                                                    <td><?php echo $reviewDate; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><b> Status</b></td>
                                                                                    <td>:</td>
                                                                                    <td colspan="4">APPROVED</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><b> Comment</b></td>
                                                                                    <td>:</td>
                                                                                    <td colspan="4"><?php echo $reviCmnt; ?></td>
                                                                                </tr>
																				 <tr>
																				<td></td>
																			</tr>
                                                                <?php }else{ ?>
                                                                        <tr>
                                                                             <td style="background-color:#FFFF00;"><b> Review By</b></td>
                                                                            <td>:</td>
                                                                            <td><?php echo $reviewName; ?></td>
                                                                            <td><b>Date & Time</b></td>
                                                                            <td>:</td>
                                                                            <td><?php echo $reviewDate; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                                    <td><b> Status</b></td>
                                                                                    <td>:</td>
                                                                                    <td colspan="4">REJECTED</td>
                                                                                </tr>
                                                                         <tr>
                                                                                    <td><b>Comment</b></td>
                                                                                    <td>:</td>
                                                                                    <td colspan="4"><?php echo $reviCmnt; ?></td>
                                                                                </tr>
																				 <tr>
																				<td></td>
																			</tr>
                                                               <?php }
                                                               if($hssEName != '' && $inspAccrej == '0' && $acKey != 0){ ?>
                                                                    <tr>
                                                                        <td style="background-color:#FFFF00;"><b> Re-Prepared By</b></td>
                                                                        <td>:</td>
                                                                        <td><?php echo $hssEName; ?></td>
                                                                        <td><b>Date & Time</b></td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            <?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_HSSE_DATE)); ?>

                                                                        </td>
                                                                    </tr>
																	<tr>
																				<td></td>
																			</tr>

                                                             <?php  }
                                                                } ?>
                                                   <!--hsse-->
                                                   <?php if($hssEName != '' && $inspAccrej == '0' && $acKey != 0){ ?>
                                                    <tr>
                                                        <td style="background-color:#FFFF00;"><b> Re-Prepared By</b></td>
                                                        <td>:</td>
                                                        <td><?php echo $hssEName; ?></td>
                                                        <td><b>Date & Time</b></td>
                                                        <td>:</td>
                                                        <td>
                                                            <?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_HSSE_DATE)); ?>
                                                           
                                                        </td>
                                                    </tr>
													<tr>
																				<td></td>
																			</tr>

                                                   <?php } ?>
                                                   <!--verifier-->
                                                 <?php   if($verifyName != ''){
                                                        if($inspAccrej == 1){ ?>
                                                        <tr>
                                                            <td style="background-color:#FFFF00;"><b> Verified By</b></td>
                                                            <td>:</td>
                                                            <td><?php echo $verifyName; ?></td>
                                                            <td><b>Date & Time</b></td>
                                                            <td>:</td>
                                                            <td><?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_VERIFY_DATE)); ?></td>
                                                        </tr>
                                                        <tr>
                                                                                    <td><b> Status</b></td>
                                                                                    <td>:</td>
                                                                                    <td colspan="4">APPROVED</td>
                                                                                </tr>
                                                         <tr>
                                                            <td><b>Comment</b></td>
                                                            <td>:</td>
                                                             <td colspan="4"><?php echo $verifiCmnt; ?></td>
                                                        </tr>
																																		<tr>
																				<td></td>
																			</tr>
                                                      <?php  }else{ ?>
                                                        <tr>
                                                            <td style="background-color:#FFFF00;"><b> Verified By</b></td>
                                                            <td>:</td>
                                                            <td><?php echo $verifyName; ?></td>
                                                            <td><b>Date & Time</b></td>
                                                            <td>:</td>
                                                            <td><?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_VERIFY_DATE)); ?></td>
                                                        </tr>
                                                        <tr>
                                                                                    <td><b> Status</b></td>
                                                                                    <td>:</td>
                                                                                    <td colspan="4">REJECTED</td>
                                                                                </tr>
                                                         <tr>
                                                            <td><b>Comment</b></td>
                                                            <td>:</td>
                                                             <td colspan="4"><?php echo $verifiCmnt; ?></td>
                                                        </tr>
														<tr>
																				<td></td>
																			</tr>
                                                     <?php }
                                                                    
                                                    } ?>
                                                    
                                                    <!--approver-->
                                                    <?php if($approvName != ''){
                                                        if($inspAccrej == 1){ ?>
                                                            <tr>
                                                                <td style="background-color:#FFFF00;"><b> Approved By</b></td>
                                                                <td>:</td>
                                                                <td><?php echo $approvName; ?></td>
                                                                <td><b>Date & Time</b></td>
                                                                <td>:</td>
                                                                <td><?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_APPROVE_DATE)); ?></td>
                                                            </tr>
                                                            <tr>
                                                                                    <td><b> Status</b></td>
                                                                                    <td>:</td>
                                                                                    <td colspan="4">APPROVED</td>
                                                                                </tr>
                                                             <tr>
                                                                <td><b>Comment</b></td>
                                                                <td>:</td>
                                                                 <td colspan="4"><?php echo $approvCmnt; ?></td>
                                                            </tr>
															
                                                      <?php  }else{ ?>
                                                        <tr>
                                                            <td><b> Approved By</b></td>
                                                            <td>:</td>
                                                            <td><?php echo $approvName; ?></td> 
                                                            <td><b>Date & Time</b></td>
                                                            <td>:</td>
                                                            <td><?php echo date("d-m-Y H:i:s",strtotime($acVal->MON_ACT_INSP_APPROVE_DATE)); ?></td>
                                                        </tr>
                                                        <tr>
                                                                                    <td><b> Status</b></td>
                                                                                    <td>:</td>
                                                                                    <td colspan="4">REJECTED</td>
                                                                                </tr>
                                                        <tr>
                                                                <td><b>Comment</b></td>
                                                                <td>:</td>
                                                                 <td colspan="4"><?php echo $approvCmnt; ?></td>
                                                            </tr>
															
                                                     <?php }
                                                    }
                                                              } } ?>
                                                </tbody>
                                 </table>


</body>
</html>

