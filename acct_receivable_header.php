 <page backcolor="#ffffff" style="font-size:8pt;" backtop="10mm" backbottom="10mm" backleft="5mm" backright="10mm">
 	
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
     <td style="width:350px;" valign=top align=right >
     
     <table style="width: 100%; text-align: right; border: solid 0px #000000;" cellspacing="0" cellpadding="0">
       <tr>
        <td align=right valign=top style="text-align:right; width:100%;">
           <span align=right valign=top style="text-align:right;font-weight: bold; font-size: 22pt;color: black">
           	Account Receivable&nbsp;&nbsp;</span><br><br><br><br><br>
                                    
         </td>
       </tr>
     </table></td>
   </tr>
 </table>
 <br /><br />
 
 <table cellpadding="0" cellspacing="0" style="width:98%; border: solid 2px #000000;">
           <tr>
           	<td bgcolor=#ffffff style="width:15%;height:4px;border-right:1px dotted black;"></td>
           	<td bgcolor=#ffffff style="width:35%;height:4px;"></td>
           	<td bgcolor=#ffffff style="width:15%;height:4px;border-left:2px solid black;border-right:1px dotted black;"></td>
           	<td bgcolor=#ffffff style="width:33%;height:4px;"></td>
           </tr>
           <tr>
             <td bgcolor=#ffffff rowspan=5 style="height:20px;font-size: 11pt ; font-weight: bold;padding-top:4px;padding-bottom:4px;border-right:1px dotted black;">Customer</td>
             <td bgcolor=#ffffff style="padding-left:5px;padding-top:4px;font-size: 10pt;"><strong><?=$customers_name?></strong></td>
             <td bgcolor=#ffffff style="text-align:right;padding-right:5px;height:20px;font-size: 11pt ; font-weight: bold;padding-top:4px;padding-bottom:4px;border-left:2px solid black;border-right:1px dotted black;">Date</td>
             <td bgcolor=#ffffff style="padding-left:5px;padding-top:4px;font-size: 10pt;" valign=middle><strong><?=$ar_date?></strong></td>
           </tr>
           <tr>
              <td bgcolor=#ffffff style="height:12px;padding-left:5px;font-size: 10pt;"><?=$customers_billto_addr1?></td>
              <td bgcolor=#ffffff style="text-align:right;padding-right:5px;font-size:10pt; font-weight: bold;padding-top:4px;padding-bottom:4px;border-left:2px solid black;border-right:1px dotted black;">Type</td>
              <td bgcolor=#ffffff style="height:12px;padding-left:5px;font-size: 10pt;"><?=$typ_str?></td>
           </tr>
           <tr>
              <td bgcolor=#ffffff style="height:12px;padding-left:5px;font-size: 10pt;"><?=$customers_billto_addr2?></td>
              <td bgcolor=#ffffff style="text-align:right;padding-right:5px;font-size: 10pt ; font-weight: bold;padding-top:4px;padding-bottom:4px;border-left:2px solid black;border-right:1px dotted black;">Ref #</td>
              <td bgcolor=#ffffff style="height:12px;padding-left:5px;font-size: 10pt;"><?=$ref_no?></td>
           </tr>
           <tr>
              <td bgcolor=#ffffff style="height:12px;padding-left:5px;font-size: 10pt;"><?=$customers_billto_addr3?></td>
              <td bgcolor=#ffffff style="text-align:right;padding-right:5px;font-size: 10pt ; font-weight: bold;padding-top:4px;padding-bottom:4px;border-left:2px solid black;border-right:1px dotted black;">Division</td>
              <td bgcolor=#ffffff style="height:12px;padding-left:5px;font-size: 10pt;"><?=$division_name?></td>
           </tr>
           <tr>
              <td bgcolor=#ffffff style="height:12px;padding-left:5px;padding-bottom:4px;font-size: 10pt;"><?=$customers_phone?></td>
              <td bgcolor=#ffffff style="text-align:right;padding-right:5px;font-size: 10pt ; font-weight: bold;padding-top:4px;padding-bottom:4px;border-left:2px solid black;border-right:1px dotted black;">Store</td>
              <td bgcolor=#ffffff style="height:12px;padding-left:5px;padding-bottom:4px;font-size: 10pt;"><?=$store_name?></td>
           </tr>  
           <tr>
           	<td bgcolor=#ffffff style="height:4px;border-right:1px dotted black;"></td>
           	<td bgcolor=#ffffff style="height:4px;"></td>
           	<td bgcolor=#ffffff style="height:4px;border-left:2px solid black;border-right:1px dotted black;"></td>
           	<td bgcolor=#ffffff style="height:4px;"></td>
           </tr>       
 </table>
<br>

 <table cellpadding="0" cellspacing="0" border=1 style="width:98%;">
           <tr>
             <td style="width:15%;text-align:right;padding-right:5px;height:18px;font-size: 11pt ; font-weight: bold;">Due Date</td>
             <td style="width:35%;padding-left:5px;font-size: 10pt;"><strong><?=$due_date?></strong></td>
             <td  style="width:15%;text-align:right;padding-right:5px;font-size: 11pt ; font-weight: bold;">Status</td>
             <td  style="width:33%;padding-left:5px;font-size: 10pt;" valign=middle><strong><?=$status_str?></strong></td>
           </tr>
           <tr>
           	  <td  style="text-align:right;padding-right:5px;height:18px;font-size: 10pt ; font-weight: bold;">Amount</td>
              <td  style="padding-left:5px;font-size: 10pt;"><?=number_format($amt,2)?></td>
              <td  style="text-align:right;padding-right:5px;font-size:10pt; font-weight: bold;">Credit</td>
              <td  style="padding-left:5px;font-size: 10pt;"><?=number_format($credit,2)?></td>
           </tr>
           <tr>
              <td  style="text-align:right;padding-right:5px;height:18px;font-size: 10pt ; font-weight: bold;">Paid</td>
              <td  style="padding-left:5px;font-size: 10pt;"><?=number_format($paid,2)?></td>
              <td  style="text-align:right;padding-right:5px;font-size: 10pt ; font-weight: bold;"><?=$extra_str?></td>
              <td  style="padding-left:5px;font-size: 10pt;"><?=number_format($extra_amt_str,2)?></td>
           </tr>
           <tr>
           	  <td  style="text-align:right;padding-right:5px;height:18px;font-size: 10pt ; font-weight: bold;">Balance</td>
              <td  style="padding-left:5px;font-size: 10pt;"><?=number_format($ar_bal,2)?></td>
              <td  style="text-align:right;padding-right:5px;font-size: 10pt ; font-weight: bold;">Payment Method</td>
              <td  style="padding-left:5px;font-size: 10pt;"><?=$payment_method_name?></td>
           </tr>     
 </table>                      
  </font> 

 </page_header>