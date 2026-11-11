<?php
$logo = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="width:250px;height:75px;">';
$logo1 = '<img src="' . PDF_IMG_PATH . 'company_logo/LOGO-LUMUT-PORTju.png" style="float:right;width:200px;height:35px;">';
$permitNumber = postData($editData, 'LIVE_PERMIT_NO');
?>

<html>
    <head>
        <style>
            *{
                font-family:arial; color:#333; font-size:0.8em; line-height:15px;
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
        
             .full-width table, .full-width table th, .full-width table td {
  border: 1px solid black;
  border-collapse: collapse;
}
.full-width table th, .full-width table td {
  padding: 15px;
}
            
  


        </style>

    </head>    
    <body style="font-family:'arial';">        
    <htmlpageheader name="myHeader1" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="">
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                 <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">PERMIT TO WORK</td>


            </tr>
          
        </table>
         <table  border="0" style="width:100%;border:0;border-top: 4px solid #FFFF00;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $permitNumber;?></td>
            </tr>
        </table>

    </htmlpageheader>
    <htmlpageheader name="myHeader2" style="display:none">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr style="">
                <td border="0"  style="width:20%;float:left;text-align:left;"><?php echo $logo; ?></td>
                 <td border="0"  style="width:70%;float:right;text-align:right;font-size: 24px;font-weight: bold">PERMIT TO WORK</td>


            </tr>
          
        </table>
        <table  border="0" style="width:100%;border:0;border-top: 4px solid #FFFF00;">
             <tr>
                <td border="0"  style="width:30%;"></td>
                <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"><?php echo $permitNumber;?></td>
            </tr>
        </table>

    </htmlpageheader>

    <htmlpagefooter name="myFooter1" style="display:none">
        <table width="100%" style="width:100%;border:0;background-color: #FFF;border-top: 4px solid #FFFF00;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td width="33%">
                    <span style="font-style: italic;"></span>
                </td>
                <td width="33%" align="center" style="font-weight: bold; font-style: italic;">

                </td>
                <td width="33%" style="text-align: right;">
                   
                </td>
            </tr>
        </table>
    </htmlpagefooter>

    <htmlpagefooter name="myFooter2" style="display:none">
        <table width="100%" style="width:100%;border:0;background-color: #FFF;border-top: 4px solid #FFFF00;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td width="33%">My document</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
            </tr>
        </table>
    </htmlpagefooter>  
    <div class="full-width">
    <table class="" style="width:100%">
        <thead>
            <tr>
        <th>Date/Time (24hrs)</th>
        <th>Work Supervisor Name</th>
        <th>Signature</th>
        </tr>
        </thead>
        <tbody>
            <?php for($i=0;$i<=54;$i++){?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
    
        </body>
</html>
