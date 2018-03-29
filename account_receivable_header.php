 <page backcolor="#ffffff" style="font-size:8pt;" backtop="10mm" backbottom="10mm" backleft="0mm" backright="10mm">
 	
 <page_header>
 <br />
 <font style="font-size: 9pt ;">
 <table style="width: 100%; text-align: left; border: solid 0px #000000;"   cellspacing="0" cellpadding="0">
   <tr>
     <td style="width: 360px;" valign=top align=left>
     	<table style="width:100%;" border="0" cellspacing="0" cellpadding="0">
     		<tr>
     			<td style="width:100%;" valign=top align=left>
              <?php if( $division_logo != "" ) { ?>
               <img src="<?=HTTPS_SERVER?>/images/logos/<?=$division_logo?>"   style="width:230px;height:120px;">
               <?php } else if ( $store_logo != "" ) { ?>
               <img src="<?=HTTPS_SERVER?>/images/logos_store/<?=$store_logo?>"   style="width:230px;height:120px;">
              <?php } else { ?>
        	 <span align=left style="font-weight: bold; font-size: 16pt; color: black"><?php echo $company_name; ?></span><br>
       	 <span align=left style="font-size: 11pt; color: black"><?php echo $company_address; ?></span><br>
        	 <span align=left style="font-size: 11pt; color: black"><?php echo $company_city; ?></span><br>                             
        	 <span align=left style="font-size: 11pt; color: black">T:<?=$company_phone?> F:<?=$company_fax?></span><br>
        	 <span align=left style="font-size: 11pt; color: black"><?php echo $company_email; ?></span>
              <?php }  ?>
            </td></tr></table>
     </td>
     <td style="width:290px;" valign=top align=right >
     
     <table style="width: 100%; text-align: right; border: solid 0px #000000;" cellspacing="0" cellpadding="0">
       <tr>
        <td align=right valign=top style="text-align:right; width:100%;">
           <span align=right valign=top style="text-align:right;font-weight: bold; font-size: 22pt;color: black">&nbsp;&nbsp;&nbsp;&nbsp;
           	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;STATEMENT</span><br><br><br><br><br>
                                    
         </td>
       </tr>
     </table></td>
   </tr>
 </table>
 <br /><br />
  <table style="width: 100%; text-align: left; border: solid 0px #000000;"   cellspacing="0" cellpadding="0"> 
   <tr>
     <td><table style="width:220px; text-align: left; border: solid 2px #000000;"   cellspacing="0" cellpadding="0">
     	<tr><td bgcolor=#f1f1f1 style="width:90px;height:7px;"></td><td bgcolor=#ffffff style="width:260px;height:7px;"></td></tr>
       <tr>
         <td bgcolor=#f1f1f1 style="width:90px;height:25px;font-size: 11pt ; font-weight: bold;padding-top:4px;">&nbsp;<b>Customer</b></td>
         <td bgcolor=#ffffff style="width:260px;padding-left:10px;padding-top:5px;padding-bottom:5px;height:50px;"><strong><?=$customers_name1?></strong>
         <br><br><?=$customers_billto_addr1?><br>
         <?=$customers_billto_addr2?><br>
         <?=$customers_billto_addr3?><br>
         </td>
       </tr>
       <tr><td bgcolor=#f1f1f1 style="width:90px;height:8px;"></td><td bgcolor=#ffffff style="width:260px;height:8px;"></td></tr>
     </table></td>
     <td><table style="width:220px; text-align: left; border: solid 2px #000000;"   cellspacing="0" cellpadding="0">
       <tr><td bgcolor=#f1f1f1 style="width:150px;height:7px;"></td><td bgcolor=#ffffff style="width:190px;height:7px;"></td></tr>
       <tr>
         <td bgcolor=#f1f1f1 style="text-align:right;width:150px;height:15px;font-size: 11pt ; font-weight: bold;"><b>Date : </b>&nbsp;</td>
         <td bgcolor=#ffffff style="width:190px;padding-left:10px;;height:15px;"><?=$today_date?></td>
       </tr>
       <tr>
         <td bgcolor=#f1f1f1 style="text-align:right;width:150px;height:15px;font-size: 11pt ; font-weight: bold;"><b>Account#  : </b>&nbsp;</td>
         <td bgcolor=#ffffff style="width:190px;padding-left:10px;height:15px;"><?=$customers_id?></td>
       </tr>
       <tr>
         <td bgcolor=#f1f1f1 style="text-align:right;width:150px;height:14px;font-size: 11pt ; font-weight: bold;"><b>Phone/FAX  : </b>&nbsp;</td>
         <td bgcolor=#ffffff style="width:190px;padding-left:10px;;height:14px;"><?=$customers_phone?></td>
       </tr>
       <tr>
         <td bgcolor=#f1f1f1 style="text-align:right;width:150px;height:15px;font-size: 11pt ; font-weight: bold;"><b>Page : </b>&nbsp;</td>

         <td bgcolor=#ffffff style="width:190px;padding-left:10px;;height:15px;">[[page_cu]] / [[page_nb]]</td>
       </tr>
      <tr><td bgcolor=#f1f1f1 style="width:150px;height:8px;"></td><td bgcolor=#ffffff style="width:190px;height:8px;"></td></tr>
       
     </table></td>
   </tr>
  
  
 </table>
                       
  </font> 
  <br /><br />
 <font style="font-size: 10pt ;">
 <table cellpadding="0" cellspacing="0" style="width:100%; border: solid 2px #000000;">
   <tr >            
     <td style="width:70px;height:25px;"   valign="middle" align=center >Invoice No</td>
     <td style="width:80px;"   valign="middle" align=center  >Invoice Date</td>
     <td style="width:80px;"   valign="middle" align=center  >Ship Date</td>
     <td style="width:80px;"   valign="middle" align=center  >Due Date</td> 
     <td style="width:100px;padding-right:10px;"   valign="middle" align=right  >Customer PO</td>
            
     <td style="width:70px;"   valign="middle" align=center  >Amount</td>
     <td style="width:70px;"    valign="middle" align=center  >Paid</td>
     <td style="width:70px;"    valign="middle" align=center  >AR Paid</td>
     <td style="width:80px;"    valign="middle" align=center  >Balance</td>
   </tr>
 </table>

 </font>
 </page_header>