<?php
require('includes/application_top.php');

$help_contents = "<h5>Help</h5><div class='metabox-prefs'><a href='http://www.gmslink.com/documentation.php' target='_blank'>Documentation</a><br /><a href='http://www.gmslink.com/support/' target='_blank'>Support Forums</a>";
$title = "Account Payable";
$icon = "icon-plugins";

?>
<?php require(DIR_WS_INCLUDES . 'body_header.php'); ?>

<script src="/js/jquery/jquery/jquery-1.7.1.min.js"></script>

<script language=javascript>
<!--
function openAR_PrintFrom()
{

var menu = document.getElementById("pdf_div").style;

if (menu.display=="block")
{ 
				menu.display="none";
}  
else 
{ 
				menu.display="block";
} 

}

function changType() 
{
   
   
   
<?php if (    $pos_browser > -1    )  { ?>
   menu=eval("document.all.option_div.style");
<?php } else { ?>
   var menu = document.getElementById("option_div").style;
<?php } ?>

   if (menu.display=="block"){ 
				menu.display="none";
			}  
			else { 
				menu.display="block";
			} 
  
  
  
}



function statusCheck(status)
{
	
	
	document.account_payable_list_form.s_status.value = status;
}

function goFirstSearch() {
    document.account_payable_list_form.pageCursor.value = "";
    document.account_payable_list_form.submit();
    
}
function goNextSearch() {
	document.account_payable_list_form.pageCursor.value = parseInt(document.account_payable_list_form.pageCursor.value) + 1;
	document.account_payable_list_form.submit();
}

function goProvSearch() {
	document.account_payable_list_form.pageCursor.value = parseInt(document.account_payable_list_form.pageCursor.value) - 1;
	document.account_payable_list_form.submit();
}


function so_lookup(inputString) 
	{
		
		if(inputString.length == 0) 
		{
			   // Hide the suggestion box.			
			   $('#po_id_suggestions').hide();
		} 
		else 
		{
		
			    
			    $.post("/autoComplete/rpc_sos.php", { queryString: "" + inputString + "" }, function(data)
			    {
			    	if( data.length > 0) 
			    	{		  
			    		$('#po_id_suggestions' ).show();
			    		$('#po_id_autoSuggestionsList').html(data);
			    	}			   
			    	
			    });
		}
	} // lookup	
	
	function fill_so_no(id) {
	
    document.account_payable_list_form.s_so_no.value = id;
    
		setTimeout("$('#po_id_suggestions').hide();", 200);
}

function po_lookup(inputString) 
	{
		
		if(inputString.length == 0) 
		{
			   // Hide the suggestion box.			
			   $('#po_id_suggestions').hide();
		} 
		else 
		{
		
			    
			    $.post("/autoComplete/rpc_pos3.php", { queryString: "" + inputString + "" }, function(data)
			    {
			    	if( data.length > 0) 
			    	{		  
			    		$('#po_id_suggestions' ).show();
			    		$('#po_id_autoSuggestionsList').html(data);
			    	}			   
			    	
			    });
		}
	} // lookup	
	
	function fill_po_no(id) {
	
    document.account_payable_list_form.s_po_no.value = id;
    
		setTimeout("$('#po_id_suggestions').hide();", 200);
}

function lookup(inputString) 
{		
		if(inputString.length == 0) 
		{
			   // Hide the suggestion box.			
			   $('#vendors_suggestions').hide();
		} 
		else 
		{
		
			    
			    $.post("/autoComplete/rpc_vendors.php", { queryString: "" + inputString + "" }, function(data)
			    {
			    	if( data.length > 0) 
			    	{			    	 
			    		$('#vendors_suggestions' ).show();
			    		$('#vendors_autoSuggestionsList').html(data);
			    	}		    	
		
			    	
			    });
		
		  
		}
} // lookup	
	
	
function fill_vendors(id,name) {

		//alert('id='+id+', name='+name);
		document.account_payable_list_form.vendors_id.value = id;
		document.account_payable_list_form.vendors_name.value = name;
		setTimeout("$('#vendors_suggestions').hide();", 200);		
}
//-->
</script>


<?php


$extra_Url = "&s_status=" . $s_status . "&s_cut_no=" . $s_cut_no . "&s_order_no=" . $s_order_no . "&s_from_date=" . $s_from_date .
             "&s_to_date=" . $s_to_date . "&s_customers_id=" . $s_customers_id;

//$s_type = '3';
?>
<script language="JavaScript" src="/js/calendar_us.js"></script>
              <link rel="stylesheet" href="/css/calendar.css">


                  
                  <table width="1020" border="0" cellpadding="0" cellspacing="0"  >
                    <tr>
                      <td align="right" class="main">
                        <div align="right">
                        	<input type="button" value=" Vendors " style="width:70px;height=20px;" name="addnew" id="addnew" onClick="document.location.href='vendors.php';" class="button-secondary action" />
                          &nbsp;
                          <input type="button" value=" Contractors " style="width:80px;height=20px;" name="addnew" id="addnew" onClick="document.location.href='contractors.php';" class="button-secondary action" />
                          &nbsp;
                        	<input type="button" value=" Bank Accounts " style="width:95px;height=20px;" name="addnew" id="addnew" onClick="document.location.href='bank_accounts_list.php';" class="button-secondary action" />
                          &nbsp;
                          <input type="button" value=" Checks " style="width:70px;height=20px;" name="addnew" id="addnew" onClick="document.location.href='checks_list.php';" class="button-secondary action" />
                          &nbsp;
                          <input type="button" value=" Payment " style="width:70px;height=20px;" name="addnew" id="addnew" onClick="document.location.href='ap_payment_list.php';" class="button-secondary action" />
                          &nbsp;
                          
                          <input type="button" value=" Add New " style="width:70px;height=20px;" name="addnew" id="addnew" onClick="document.location.href='account_payable.php';" class="button-secondary action" />
                          </div></td>
                    </tr>
                   </table><br style="line-height:10px;">
                    <span id="option_div" style="DISPLAY: none; MARGIN-LEFT: 0px; "> 
               <table width="1020" border="0" cellpadding="0" cellspacing="1" bgcolor="#f0f0f0">
               <form action="account_payable_list.php" method="get" name="account_payable_list_form" id="account_payable_list_form"> <input type="hidden" name="pageCursor" value="<?=$pageCursor?>">
               <tr><td bgcolor=#ffffff style="padding-top:2px; padding-bottom:2px; padding-left:2px; padding-right:2px;">
              
                    
                
                 <table width="100%" border="0" cellpadding="0" cellspacing="1"  >
                    
              <tr>
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">Status&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">
                       <span class="small" style="padding-left:5px;">                     	
                       <input type="radio" name="status_radio_btn"  <?php if ( $s_status == "0" || $s_status == "") echo " checked='checked' "; ?> onclick="statusCheck('0')" value="0">
                        Open                      </span>
                        
                      <span class="small" style="padding-left:5px;">
                       <input type="radio" name="status_radio_btn"   <?php if ( $s_status == "1" ) echo " checked='checked' "; ?> onclick="statusCheck('1')" value="1">
                       Close</span>
                      
                        <span class="small" style="padding-left:5px;">
                        <input type="radio" name="status_radio_btn"   <?php if ( $s_status == "3" ) echo " checked='checked' "; ?> onclick="statusCheck('3')" value="3">
                       All</span>
                      
                        
                         <input type=hidden name=s_status value="<?=$s_status?>">                      </td>
                      <td bgcolor=#ffffff class="main" align=right style="padding-right:12px;">
                      	
                   	    <input type="button" value="  Find  " onClick="goFirstSearch();" style="width:70px;" name="find_sale_order" id="find_sale_order" class="button-secondary action" />                   	  </td>
                   </tr>
                    
                    <tr>
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">Vendor&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">
                      <input onkeyup="lookup(this.value);" class='inputbox_center' style='width:160px;' maxlength=60 id='vendors_name' name='vendors_name' type='text' value="<?=$vendors_name?>"  >
                      <div class='suggestionsBox' id='vendors_suggestions' style='display: none;'>
                        <div class='suggestionList' id='vendors_autoSuggestionsList'>&nbsp;</div>  </div>
                        <input type="hidden" id="vendors_id" name="vendors_id" value="<?=$vendors_id?>">
                       </td>
                      <td bgcolor=#ffffff class="main" align=right style="padding-right:12px;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">Contractor&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">
                      
                      
                      <?=tep_select_contractors('contractors_id',$contractors_id)?>                      </td>
                      <td bgcolor=#ffffff class="main" align=right style="padding-right:12px;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">Type&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">
                      
                      
                      <SELECT style="WIDTH: 120px" name=s_type>   
                 <OPTION value=0 <?php if ($s_type == "0" ) echo "selected"; ?> >Fabric Payment</OPTION>
                 <OPTION value=1 <?php if ($s_type == "1" ) echo "selected"; ?>  >Trim Payment</OPTION>
                 <OPTION value=2 <?php if ($s_type == "2" ) echo "selected"; ?> >Contract Payment</OPTION>
                 <OPTION value=3 <?php if ($s_type == "3" ) echo "selected"; ?> >Sendout Payment</OPTION>
                 <OPTION value=4 <?php if ($s_type == "4" || $s_type == "") echo "selected"; ?>  >All Payment</OPTION>
             
                     </SELECT>     </td>
                      <td bgcolor=#ffffff class="main" align=right style="padding-right:12px;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">Invoice #&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">
                      	<input name="s_invoice_no" type="text" class="inputbox_center" id="s_invoice_no"  style="width:160px;"  
                        	value="<?=$s_invoice_no?>" maxlength="20"  /></td>
                      	
                     </tr>
                     <tr>
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">Ref #&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">
                      	<input name="s_ref_no" type="text" class="inputbox_center" id="s_ref_no"  style="width:160px;"  
                        	value="<?=$s_ref_no?>" maxlength="20"  /></td>
                      	
                     </tr>

                     <tr>
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">PO #&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">
                      	<input name="s_po_no" type="text" onkeyup='po_lookup(this.value);' class="inputbox_center" id="s_po_no"  style="width:160px;"  
                        	value="<?=$s_po_no?>" maxlength="20"  />
                        	<div class='customers_suggestionsBox' id='po_id_suggestions' style='display: none;'>
                       <div class='customers_suggestionList' id='po_id_autoSuggestionsList'>&nbsp;</div></div>
                       	</td>
                      	
                     </tr>
                     <tr>
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">Style #&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">
                      	<input name="s_style_no" type="text" class="inputbox_center" id="s_style_no"  style="width:160px;"  
                        	value="<?=$s_style_no?>" maxlength="20"  /></td>
                      	
                     </tr>
                     <tr>
                     <td align="right" bgcolor=#DDDDDD class="main">Pay Date&nbsp;</td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;"><table width="200" border="0" cellpadding="0" cellspacing="0" >
                       <tr>
                           <td width="79"><table border="0" cellpadding="0" cellspacing="0">
                             <tr>
                               <td><input class="inputbox_center" name="s_pay_from_date"  type="text" id="s_pay_from_date" size=10 aria-required="true" value="<?=$s_pay_from_date?>" /></td>
                               <td><script language="JavaScript"> new tcal ({ 'formname': 'account_payable_list_form','controlname': 's_pay_from_date'}); </script></td>
                             </tr>
                           </table></td>
                           <td width="13">-</td>
                           <td width="86"><table border="0" cellpadding="0" cellspacing="0">
                             <tr>
                               <td><input class="inputbox_center" name="s_pay_to_date"  type="text" id="s_pay_to_date" size=10 aria-required="true" value="<?=$s_pay_to_date?>" /></td>
                               <td><script language="JavaScript"> new tcal ({ 'formname': 'account_payable_list_form','controlname': 's_pay_to_date'}); </script></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;">&nbsp;</td>
                   </tr>
                     <tr>
                     <td align="right" bgcolor=#DDDDDD class="main">Date&nbsp;</td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;"><table width="200" border="0" cellpadding="0" cellspacing="0" >
                       <tr>
                           <td width="79"><table border="0" cellpadding="0" cellspacing="0">
                             <tr>
                               <td><input class="inputbox_center" name="s_from_date"  type="text" id="s_from_date" size=10 aria-required="true" value="<?=$s_from_date?>" /></td>
                               <td><script language="JavaScript"> new tcal ({ 'formname': 'account_payable_list_form','controlname': 's_from_date'}); </script></td>
                             </tr>
                           </table></td>
                           <td width="13">-</td>
                           <td width="86"><table border="0" cellpadding="0" cellspacing="0">
                             <tr>
                               <td><input class="inputbox_center" name="s_to_date"  type="text" id="s_to_date" size=10 aria-required="true" value="<?=$s_to_date?>" /></td>
                               <td><script language="JavaScript"> new tcal ({ 'formname': 'account_payable_list_form','controlname': 's_to_date'}); </script></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;">&nbsp;</td>
                   </tr>
                   <tr>
                     <td align="right" bgcolor=#DDDDDD class="main">Due Date&nbsp;</td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;"><table width="200" border="0" cellpadding="0" cellspacing="0" >
                       <tr>
                           <td width="79"><table border="0" cellpadding="0" cellspacing="0">
                             <tr>
                               <td><input class="inputbox_center" name="s_from_duedate"  type="text" id="s_from_duedate" size=10 aria-required="true" value="<?=$s_from_duedate?>" /></td>
                               <td><script language="JavaScript"> new tcal ({ 'formname': 'account_payable_list_form','controlname': 's_from_duedate'}); </script></td>
                             </tr>
                           </table></td>
                           <td width="13">-</td>
                           <td width="86"><table border="0" cellpadding="0" cellspacing="0">
                             <tr>
                               <td><input class="inputbox_center" name="s_to_duedate"  type="text" id="s_to_duedate" size=10 aria-required="true" value="<?=$s_to_duedate?>" /></td>
                               <td><script language="JavaScript"> new tcal ({ 'formname': 'account_payable_list_form','controlname': 's_to_duedate'}); </script></td>
                             </tr>
                           </table></td>
                         </tr>
                       </table></td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;">&nbsp;</td>
                   </tr>
                 </table>
               
                    
                    
                  
                  </td>
               </tr>
              
               </form> 

               </table>  </span>

   <table width="1020" border="0" cellpadding="0" cellspacing="0"  >
               <tr>
               <td bgcolor=#ffffff align=left style="padding-right:2px;">
                     <div id="screen-meta-links">
                             <div id="contextual-help-link-wrap" style="width:70px;" class="hide-if-no-js screen-meta-toggle">
                                 <a href="javascript:changType();" class=ner>&nbsp;&nbsp;&nbsp;Search&nbsp;&nbsp;&nbsp;</a>
                             </div>
                     </div> 
               </TD>
               </TR>
               </Table>


<?php
     if ($pageCursor == '' ) $pageCursor = 0;
     $fetch_row_count = 0;
      if ( $s_status == "" ) $s_status = "0";
      if ( $s_type == "" ) $s_type = "4";
      $sql  =  " select * from  " . TABLE_ACCOUNT_PAYABLE .  " where 1 = 1";
      
      if ( $s_status != "3" ) $sql .= " and status = '" . $s_status . "' ";
      
       if ( $vendors_id != '' )
       {
       	   $sql .= " and vendors_id = '" . $vendors_id . "' ";
       }
       if ( $contractors_id != '')
       {
       	   $sql .= " and contractors_id = '" . $contractors_id . "' ";
       } 
       if ( $s_ref_no != '' )
       {
       	   $sql .= " and ref_no like '" . $s_ref_no . "%' ";
       }
       if ( $s_invoice_no != '' )
       {
       	   $sql .= " and invoice_no = '" . $s_invoice_no . "' ";
       }

       if ( $s_po_no != '' )
       {
       	   $sql .= " and po_no = '" . $s_po_no . "' ";
       }
       if ( $s_style_no != '' )
       {
       	   $sql .= " and style_no like '" . $s_style_no . "%' ";
       }
       if ( $s_type != '4' ) $sql .= " and typ = '" . (int)$s_type . "' ";
       
       
       
       if ( $s_pay_from_date != ''  )
       {
       	       $sql .= " and pay_date >= str_to_date('" . $s_pay_from_date . "','%m/%d/%Y') ";
       }
          
       if ( $s_pay_to_date != ''  )
       {
       	       $sql .= " and pay_date <= str_to_date('" . $s_pay_to_date . "','%m/%d/%Y') ";
       }
       if ( $s_from_date != ''  )
       {
       	       $sql .= " and ap_date >= str_to_date('" . $s_from_date . "','%m/%d/%Y') ";
       }
          
       if ( $s_to_date != ''  )
       {
       	       $sql .= " and ap_date <= str_to_date('" . $s_to_date . "','%m/%d/%Y') ";
       }
       if ( $s_from_duedate != ''  )
       {
       	       $sql .= " and due_date >= str_to_date('" . $s_from_duedate . "','%m/%d/%Y') ";
       }
          
       if ( $s_to_duedate != ''  )
       {
       	       $sql .= " and due_date <= str_to_date('" . $s_to_duedate . "','%m/%d/%Y') ";
       }
       if( $session_users_admin != '1' && $session_company_id != '' && $session_company_id != '0' )
       {
      	      $sql .= " and company_id in (" . $session_company_id . ") ";
       }
      $sql .= " order by ap_date asc ";
      
      //echo $sql . "<br>";
     
      ?>
      <br style="line-height:10px;">

              		 
              		 
      <table width=1020 border="0" class="list" cellpadding="0" cellspacing="1" bgcolor=#cccccc>
  
      <tr bgcolor=#dfdfdf height="24">
       
      
        <td width="80"   valign="middle" class=small  ><div align="center">Date</div></td>
        <td width="200"  valign="middle" class=small  ><div align="center">Vendors/Contractors</div></td>
        
        <td width="130"  valign="middle" class=small  ><div align="center">Type</div></td>
        <td width="90"    valign="middle" class=small  ><div align="center">Ref#</div></td>
        <td width="90"    valign="middle" class=small  ><div align="center">Invoice#</div></td>
        
        <td width="80"  valign="middle" class=small  ><div align="center">Amount</div></td>
        <td width="70"   valign="middle" class=small  ><div align="center">Paid</div></td>
        <td width="70"   valign="middle" class=small  ><div align="center">Credit</div></td>
        <td width="70"   valign="middle" class=small  ><div align="center">Balance</div></td>             
        
        <td width="80"   valign="middle" class=small  ><div align="center">Due Date</div></td>
        <?php if( $session_users_admin == '1' ) { ?>
            <td width="100" valign="middle" class=small  ><div align="center">Division</div></td>
        <?php  }  ?>
        <td width="60"  valign="middle" class=small  ><div align="center">Status</div></td>       
        </tr>
      <tr>
        <td colspan="*"  height=1 ></td>
      </tr>
       <?php
       
      $ind  = 0;
      $i = $loc;
              				
      //$list_split = new splitPageResults($sql, MAX_DISPLAY_PAGE_LINKS);
      $list_split = new splitPageResults($sql, 30);
      $list_query = tep_db_query($list_split->sql_query);
      
      $row = 1;
      while ($list = tep_db_fetch_array($list_query)) 
      {	   
         
         echo "<tr height=17 class='dataTableRow' bgcolor=#f8f9ec onmouseover='rowOverEffect(this)' onmouseout='rowOutEffect(this)' onclick='document.location.href=\"account_payable.php?idx=" . $list['idx'] . $extra_Url . "\"'>";
        
         if($list['typ'] == '2' || $list['typ'] == '3')
         {
         	 $rc = teb_query(" select contractors_name from contractors where contractors_id='" . (int) $list['contractors_id'] . "' ");
           $vendor_name = $rc['contractors_name'];         	 
         } else {
         	 $rc = teb_query(" select vendors_name from vendors where vendors_id='" . (int) $list['vendors_id'] . "' ");
           $vendor_name = $rc['vendors_name'];
         }
         $rcd2 = teb_query("select name from company where company_id = '" . (int) $list['company_id'] . "'");
         $company_name = $rcd2['name'];
        
          
         $typ = "";
         
         if ( $list['typ'] == '0' || $list['typ'] == '')  $typ = "Fabric Payment";
         if ( $list['typ'] == '1'  )  $typ = "Trim Payment";
         if ( $list['typ'] == '2'  )  $typ = "Contract Payment";  
         if ( $list['typ'] == '3'  )  $typ = "Sendout Payment";     
         if ( $list['typ'] == '4'  )  $typ = "Credit Memo";          
       
         $status = "Open";
         if ( $list['status'] == '1' ) $status = "Close";
         
         $ap_date            = tep_convert_date_kr($list['ap_date']);  if ( $ap_date == "00/00/0000") $ap_date = "";if ( $ap_date == "01/01/0001" ) $ap_date = "";
         $due_date            = tep_convert_date_kr($list['due_date']);  if ( $due_date == "00/00/0000") $due_date = "";if ( $due_date == "01/01/0001" ) $due_date = "";
        
         $extra1_amt     = $list['extra1_amt']; if ( $extra1_amt == "" ) $extra1_amt = "0";
         $extra2_amt     = $list['extra2_amt']; if ( $extra2_amt == "" ) $extra2_amt = "0";
         
         $amt = $list['amt']; ;
    
         $amount_str   = sprintf("%01.2f", $amt);
        
         //$amount_str = sprintf("%01.2f", $list['amt']);
         $paid_str = sprintf("%01.2f", $list['paid']);
         $credit_str = sprintf("%01.2f", $list['credit']);
         $balance_str = sprintf("%01.2f", $amt - $list['paid'] - $list['credit']);
        
      ?>   
            <td class=small align="center"><?=$ap_date?></td>
            <td class=small align="center" ><?=$vendor_name?></td>
            
            <td class=small align="center"><?=$typ?></td>
            <td class=small style="padding-left:5px;"><?=strtoupper($list['ref_no'])?></td>
            <td class=small style="padding-left:5px;"><?=$list['invoice_no']?></td>
            <td class=small align="right" style="padding-right:2px;" ><?=$amount_str?></td>
            <td class=small align="right" style="padding-right:2px;" ><?=$paid_str?></td>
            <td class=small align="right" style="padding-right:2px;" ><?=$credit_str?></td>
            <td class=small align="right" style="padding-right:2px;" ><?=$balance_str?></td>
             
            <td class=small align="center" ><?=$due_date?></td>  
            <?php if( $session_users_admin == '1' ) { ?>
              <td class=small align="center" ><?=$company_name?></td>
            <?php  }  ?>        
            <td align="center" class=small><?=$status?></td>
          
            
      </tr>
       
      <?php
        $row++;
       }
       
       
       if ( $row < 30 )
       {
          while ( $row < 30 )
          {
      ?>
       <tr bgcolor='#fdfdfc' height='17'>      
           
            <td class=small align="center" nowarp>&nbsp;</td>
            <td class=small style="padding-left:5px;">&nbsp;</td>
            <td class=small >&nbsp;</td>
            <td class=small >&nbsp;</td>
            <td class=small align="center">&nbsp;</td>
            <td align="center" class=small>&nbsp;</td>
            <td align="center" class=small>&nbsp;</td>
            <td class=small align="center">&nbsp;</td>
            <td align="center" class=small>&nbsp;</td>
            <td align="center" class=small>&nbsp;</td>
           <td align="center" class=small>&nbsp;</td>
           <?php if( $session_users_admin == '1' ) { ?>
            <td class=small align="center" ></td>
            <?php  }  ?>
       </tr>
       

       <?php 
        $row++;
           }
       }
       ?>
           
  <tr>
        <td colspan="*" bgcolor=#ffffff height=1 >
           <div id=pdf_div style="margin-top:10px;margin-left:10px;margin-right:10px;margin-bottom:10px;display:none;";>
              
           </div>
        </td>
  </tr>
</table>
<table width=1020 border="0" class="list" cellpadding="0" cellspacing="1" bgcolor=#cccccc>

  <tr bgcolor=#ffffff>

    <td height="27" align=center  >
                              
                             <?php
                                     if (($list_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {		//if 3
                              ?>
                               <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                  <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $list_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></td>
                                </tr>
                              </table>
                              <?php
                                   }
                              ?>                 
    </td>
    </tr>
</table>
<table width=1020 border="0" class="list" cellpadding="0" cellspacing="1" bgcolor=#cccccc>

  <tr bgcolor=#ffffff>
    <td height="27" align=left  >
    <input type="button" class="button-primary" style="width:90px;height:20px; background: #dfdfdf url(/images/button-gray.png) repeat-x scroll left top;border-color: #c0c0c0 !important; color: #000 !important;"  onClick="document.location.href='customer_ap.php'" value=" Current A/P " name="current_ar" />&nbsp;
<input type="button" class="button-primary" style="width:90px;height:20px; background: #dfdfdf url(/images/button-gray.png) repeat-x scroll left top;border-color: #c0c0c0 !important; color: #000 !important;"  onClick="document.location.href='ap_aging.php'" value=" Aging " name="aging" /> &nbsp;
<input type="button" class="button-primary" style="width:130px;height:20px; background: #dfdfdf url(/images/button-gray.png) repeat-x scroll left top;border-color: #c0c0c0 !important; color: #000 !important;"  onClick="document.location.href='ap_aging_summary.php'" value=" Aging(Summary) " name="aging_summary" /> &nbsp;
<input type="button" class="button-primary" style="width:160px;height:20px; background: #dfdfdf url(/images/button-gray.png) repeat-x scroll left top;border-color: #c0c0c0 !important; color: #000 !important;"  onClick="document.location.href='ap_payment_projection.php'" value=" AP Payment Projection " name="ap_payment_projection" /> 
</td>
</tr>
</table>
<script language=javascript>
<!--
function goPrint_pdf()
{


    frm = document.pdf_form;
    if ( frm.customers_v2_id == "" )
    {
         alert(" Please enter customers!");
         frm.customers_v2_name.focus();
    }
    else 
    if ( frm.from_date.value == "" )
    {
         alert(" Please enter ar start date!");
         frm.from_date.focus();
    }
    else 
    {
         frm.submit();
    }



}


//-->
</Script>

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>
