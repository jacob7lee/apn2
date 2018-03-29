<?php
        // require('includes/application_top.php');
         define('PAGE_SIZE', 29);
        
         $company_name=""; $company_address=""; $company_city=""; $company_phone=""; $company_fax=""; $company_web=""; $company_email="";
         
         /*
         $company_query = tep_db_query("select configuration_title, configuration_value from configuration where configuration_group_id = '1' order by sort_order");
         
         while ($company_rc = tep_db_fetch_array($company_query)) 
        {
        	 if ( $company_rc['configuration_title'] == 'Company Name' ) $company_name = $company_rc['configuration_value'];
        	 if ( $company_rc['configuration_title'] == 'Company Address' ) $company_address = $company_rc['configuration_value'];
        	 if ( $company_rc['configuration_title'] == 'Company City' ) $company_city = $company_rc['configuration_value'];
        	 if ( $company_rc['configuration_title'] == 'Company Phone' ) $company_phone = $company_rc['configuration_value'];
        	 if ( $company_rc['configuration_title'] == 'Company Fax' ) $company_fax = $company_rc['configuration_value'];
        	 if ( $company_rc['configuration_title'] == 'Company Web' ) $company_web = $company_rc['configuration_value'];
        	 if ( $company_rc['configuration_title'] == 'Company Email' ) $company_email = $company_rc['configuration_value'];      
         }
         */
         
         if( $store_id != "" && $store_id != '0')
         {
         	   $ssrc = teb_query("select * from stores where idx='" . $store_id . "'");
	           $store_logo = $ssrc['store_logo'];
	           $company_name = $ssrc['name'];
	           if($ssrc['name2'] != "")  $company_name .= "<br>" . $ssrc['name2'];
	           $company_address = $ssrc['address1'];
	           if($ssrc['address2'] != "")  $company_address .= "<br>" . $ssrc['address2'];
             $company_city = $ssrc['city'];
             $company_phone = $ssrc['phone'];
             $company_fax = $ssrc['fax'];
         	
         }
         else if( $company_id == '' || $company_id == '0' )
         {   
                $company_query = tep_db_query("select configuration_title, configuration_value from configuration where configuration_group_id = '1' order by sort_order");
                
                while ($company_rc = tep_db_fetch_array($company_query)) 
                {
        	         if ( $company_rc['configuration_title'] == 'Company Name' ) $company_name = $company_rc['configuration_value'];
        	         if ( $company_rc['configuration_title'] == 'Company Address' ) $company_address = $company_rc['configuration_value'];
        	         if ( $company_rc['configuration_title'] == 'Company City' ) $company_city = $company_rc['configuration_value'];
        	         if ( $company_rc['configuration_title'] == 'Company Phone' ) $company_phone = $company_rc['configuration_value'];
        	         if ( $company_rc['configuration_title'] == 'Company Fax' ) $company_fax = $company_rc['configuration_value'];
        	         if ( $company_rc['configuration_title'] == 'Company Web' ) $company_web = $company_rc['configuration_value'];
        	         if ( $company_rc['configuration_title'] == 'Company Email' ) $company_email = $company_rc['configuration_value'];      
                }
            
            
         }
         else
         {
         	  $c_rcd = teb_query("select * from company where company_id='" . $company_id . "'");
            $division_logo = $c_rcd['division_logo'];            
            $company_name    = $c_rcd['name'];
            $company_address = $c_rcd['address'];
            if($c_rcd['address2'] != "")  $company_address .= "<br>" . $c_rcd['address2'];
            $company_city    = $c_rcd['city'];
            $company_phone   = $c_rcd['phone'];
            $company_fax     = $c_rcd['fax'];
         	
         }

         $csql = " select * from customers where customers_id ='" . $customers_id . "' ";
          
         $rcc = teb_query($csql);
         $customers_name1 = $rcc['customers_name1'];
         
         $customers_billto_addr1 = $rcc['customers_billto_addr1'];
         $customers_billto_addr2 = $rcc['customers_billto_addr2'];
         $customers_billto_addr3 = $rcc['customers_billto_addr3'];
         
         $customers_email_address = $rcc['customers_email_address'];
         $customers_phone = $rcc['customers_phone'] . "&nbsp;/&nbsp; " . $rcc['customers_fax'];
         
         $today_date = date("m") . "/" . date("d") . "/" . date("Y");
      
     
        $page         = 1;
        $seq          = 0;
        $isFirstPage  = true;
        $pre_style_no = "";
        $style_no     = "";
        $pre_desc     = "";
        
        $sum_amount = 0.00;
        $sum_paid = 0.00;
        $sum_balance = 0.00;
        $sum_ar_paid =0.00;
        
        $sql = " select * from ar where status = '0' and  typ != '2' and customers_id = '" . $customers_id . "'  ";
        $sql .= " and ar_date  >= str_to_date('" . $from_date . "','%m/%d/%Y') ";
        if ( $to_date != '' ) $sql .= " and ar_date  <= str_to_date('" . $to_date . "','%m/%d/%Y') ";
        if ( $store_id != '' ) $sql .= " and store_id='" . $store_id . "' ";
        if ( $company_id != '' ) $sql .= " and company_id='" . $company_id . "' "; 
        $sql .= "order by ar_date";
        $list_query = tep_db_query($sql);
     
        $rec_rows = tep_db_num_rows($list_query);
        $total_pages = (int) $rec_rows / PAGE_SIZE;
        if ( ($rec_rows % PAGE_SIZE) > 0 ) $total_pages++;
        
        
        while($list = tep_db_fetch_array($list_query) )
        {
      
             if ( $seq % PAGE_SIZE == 0 ) 
             {
                  if ( $seq != 0 ) 
                  {
             ?>
                      </table>
                      </div>
                      <page_footer>
		                  
                      		<table style="width: 100%; border: solid 0px black;">
                      		
                      			<tr>
                      				<td style="text-align: left;	width: 50%"><?=STORE_OWNER?></td>
                      				<td style="text-align: right;	width: 50%">page [[page_cu]]/[[page_nb]]</td>
                      			</tr>
                      		</table>
                      </page_footer>
                   </page>

                    
             <?php
                 }                                       
            
                 include( DIR_FS_CATALOG . '/account_receivable_header.php');
                 
             }
             
           

         
            if ( $seq % PAGE_SIZE == 0 ) 
            {    
            	   
   	              ?>
                  <div style="margin-top:300px;">
   	              <table  cellpadding="0" cellspacing="0" style="width:100%; border: solid 0px #000000;">
   	              <?php
            }
            
             
            $invoice_no = "";
            $invoice_date = "";
            $custpmer_po = "";
            
            if ( $list['typ'] == '1' )
            {
                 $isql = " select invoice_no,invoice_date,customers_po ,order_date, ship_date " .
                         " from invoice " . 
                         " where invoice_no='" . $list['ref_no']  . "' ";
                 
                 //echo $isql . "<br>";        
                 if ( $rc = teb_query($isql) )
                 {
                     
                     $invoice_no = $rc['invoice_no'];
                     $invoice_date = $rc['invoice_date'];
                     $custpmer_po = $rc['customers_po'];
                     
                     $invoice_date = tep_convert_date_kr($rc['invoice_date']); if ( $invoice_date == "00/00/0000") $invoice_date = "";
                     $order_date = tep_convert_date_kr($rc['order_date']); if ( $order_date == "00/00/0000") $order_date = "";
                     $ship_date = tep_convert_date_kr($rc['ship_date']); if ( $ship_date == "00/00/0000") $ship_date = "";
                 }
                 
            
            }
            
            
            $ar_date = tep_convert_date_kr($list['ar_date']); if ( $ar_date == "00/00/0000") $ar_date = "";
        $due_date = tep_convert_date_kr($list['due_date']); if ( $due_date == "00/00/0000") $due_date = "";
        
        if ( $list['typ'] == '2' )
        {
        	 $amt_str = sprintf("%01.2f", -$list['amt']);
           $paid_str = sprintf("%01.2f", -$list['paid']);
           $sum_amount -= $list['amt'];
           $sum_paid -= $list['paid'];
        
           $balance = -$list['amt'] + $list['paid'];
        	
        } 
        else
        {
           $amt_str = sprintf("%01.2f", $list['amt']);
           $paid_str = sprintf("%01.2f", $list['paid']);
           $sum_amount += $list['amt'];
           $sum_paid += $list['paid'];
           //$balance = $list['amt'] - $list['paid'];
           
           $rcu = teb_query("select sum(used) as t_used, sum(paid) as t_paid from ar_usages where from_ref_no='" . $list['ref_no'] . "'");
           
           $ar_paid_str = sprintf("%01.2f", $rcu['t_paid']);
           $sum_ar_paid += $rcu['t_paid'];
           
           $balance = $list['amt'] - $list['paid'] + $rcu['t_used'] - $rcu['t_paid'];
        
           
        }
        
        $balance_str = sprintf("%01.2f", $balance);  
        $sum_balance += $balance;
           
             
      	    //if ( $seq % 2 == 0 ) $bgcolor="ffffff";
      	    //else                 $bgcolor="ffffff";
      	    
?>

<font style="font-size: 9pt ;">
<tr  style="height:14px;width:100%;">
        <td style="width:70px;" >&nbsp;<?=$list['ref_no']?></td>
        <td style="width:70px;" ><?=$invoice_date?></td>
        <td style="width:70px;" ><?=$ship_date?></td>
        <td style="width:70px;" ><?=$due_date?></td>    
        <td style="width:80px;" align=center><?=$custpmer_po?></td>            
        <td style="width:60px;padding-right:3px;" align=right><?=number_format($amt_str, 2, '.', ',')?></td>
        <td style="width:60px;padding-right:3px;" align=right><?=number_format($paid_str, 2, '.', ',')?></td>
        <td style="width:60px;padding-right:3px;" align=right><?=number_format($ar_paid_str, 2, '.', ',')?></td>
        <td style="width:60px;padding-right:3px;" align=right><?=number_format($balance_str, 2, '.', ',')?></td>
</tr>
</font>        

<?php

             $seq++;
      }



 $sum_amount_str = sprintf("%01.2f", $sum_amount);
 $sum_paid_str = sprintf("%01.2f", $sum_paid);
 $sum_balance_str = sprintf("%01.2f", $sum_balance);    
 $sum_ar_paid_str = sprintf("%01.2f", $sum_ar_paid);   
    
    ?>
    <tr><td colspan=9 style="border-bottom: solid 2px #000000; height:1px;width:100%;" align=center></td></tr>
  <font style="font-size: 10pt ;">
    <tr  style=" height:16px;">
        <td  colspan=4 align=center></td>
         <td   align=center><font style="font-weight: bold; font-size: 11pt ;">Invoice Total</font></td>
        <td    align=right><?=number_format($sum_amount_str, 2, '.', ',')?>&nbsp;</td>
        <td    align=right><?=number_format($sum_paid_str, 2, '.', ',')?>&nbsp;</td>
        <td    align=right><?=number_format($sum_ar_paid_str, 2, '.', ',')?>&nbsp;</td>
        <td    align=right><?=number_format($sum_balance_str, 2, '.', ',')?>&nbsp;</td>
       
     </tr>
  </font>
   
            	         
       
 </table> 
<br /><br /><br />
  
  
 <table  cellpadding="0" cellspacing="0" style="width:100%; border: solid 2px #000000;"> 
 <?php 
 $sql = " select * from ar where status = '0' and  typ = '2' and customers_id = '" . $customers_id . "'  ";
        $sql .= " and ar_date  >= str_to_date('" . $from_date . "','%m/%d/%Y') ";
     
        if ( $to_date != '' ) $sql .= " and ar_date  <= str_to_date('" . $to_date . "','%m/%d/%Y') ";
     
        $list_query = tep_db_query($sql);
        $credit_sum_balance = 0.00;
        while($list = tep_db_fetch_array($list_query) )
        {
        	 
        	 $amt_str = sprintf("%01.2f", $list['amt']);
           $paid_str = sprintf("%01.2f", $list['paid']);
           $sum_amount -= $list['amt'];
           $sum_paid -= $list['paid'];
        
           $balance = $list['amt'] - $list['paid'];
           $credit_sum_balance += $balance;
           $balance_str = sprintf("%01.2f", $balance);  
           
           $sum_balance -= $balance;
           
           $due_date = tep_convert_date_kr($list['due_date']); if ( $due_date == "00/00/0000") $due_date = "";
?>	
 <font style="font-size: 10pt ;">
<tr  bgcolor=#ffffff style="border-bottom: solid 0px #000000; height:30px;width:753px;">

        <td style="width:80px;" align=left>&nbsp;<?=$list['ref_no']?></td>
        <td style="width:80px;" align=center>&nbsp;</td>
        <td style="width:80px;" align=center>&nbsp;</td>
        <td style="width:80px;" align=center><?=$due_date?>&nbsp;</td> 
        <td style="width:100px;" align=center>&nbsp;</td>
               
        <td style="width:90px;" align=right><?=number_format($amt_str, 2, '.', ',')?>&nbsp;</td>
        <td style="width:90px;" align=right><?=number_format($paid_str, 2, '.', ',')?>&nbsp;</td>
        <td style="width:90px;" align=right>&nbsp;<?=number_format($balance_str, 2, '.', ',')?></td>
</tr>
</font>

<?php 
    } 
    $credit_sum_balance_str = sprintf("%01.2f", $credit_sum_balance); 
    $sum_balance_str = sprintf("%01.2f", $sum_balance); 
    ?>
 <tr>
	      <td height=5 style="width:80px;" align=center>&nbsp;</td>
        <td height=5 style="width:80px;" align=center>&nbsp;</td>
        <td height=5 style="width:80px;" align=center>&nbsp;</td>
        <td height=5 style="width:80px;" align=center>&nbsp;</td> 
        <td height=5 style="width:100px;" align=center>&nbsp;</td>
               
        <td height=5 style="width:90px;" align=right>&nbsp;</td>
        <td height=5 style="width:90px;" align=right>&nbsp;</td>
        <td height=5 style="width:90px;" align=right>&nbsp;</td>
</tr>
 <tr>
	     <td style="width:80px;" align=center>&nbsp;</td>    
	     <td style="width:80px;" align=center>&nbsp;</td>  
	     <td style="width:420px;" colspan=5 align=center><font style="font-weight: bold; font-size: 11pt ;">Credit Total</font></td>
	     <td style="width:90px;" align=right>&nbsp;<font style="font-size: 10pt ;"><?=number_format($credit_sum_balance_str, 2, '.', ',')?></font></td>
</tr>
</table>
<br /><br />
<table  cellpadding="0" cellspacing="0" style="width:100%; border: solid 0px #000000;">
	<tr  bgcolor=#ffffff style="height:1px;width:100%;">
        <td style="width:100px;" align=center>&nbsp;</td>
        <td style="width:80px;" align=center>&nbsp;</td>
        <td style="width:80px;" align=center>&nbsp;</td>
        <td style="width:80px;" align=center>&nbsp;</td>
        <td style="width:100px;" align=center>&nbsp;</td>
        
        <td style="width:90px;" align=right>&nbsp;</td>
        <td style="width:90px;" align=right>&nbsp;</td>
        <td style="width:90px;" align=right>&nbsp;</td>
</tr>
 <font style="font-size: 11pt ;">
	<tr  bgcolor=#ffffff style="border-bottom: solid 0px #000000; height:30px;width:753px;">

        <td style="width:100px;" align=center>&nbsp;</td>
        <td style="width:80px;" align=center>&nbsp;</td>
        <td colspan=5 align=center><font style="font-weight: bold; font-size: 13pt ;">&nbsp;&nbsp;Pay This Amount</font></td>
        <td align=right><?=number_format($sum_balance_str, 2, '.', ',')?></td>
</tr>
</font>
</table>
</div>
	
<page_footer>
		
		<table style="width: 100%; border: solid 0px black;">
		
			<tr>
				<td style="text-align: left;	width: 50%"><?=STORE_OWNER?></td>
				<td style="text-align: right;	width: 50%">page [[page_cu]] / [[page_nb]]</td>
			</tr>
		</table>
</page_footer>
	
</page>



