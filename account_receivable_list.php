<?php
require('includes/application_top.php');

$help_contents = "<h5>Help</h5><div class='metabox-prefs'><a href='http://www.gmslink.com/documentation.php' target='_blank'>Documentation</a><br /><a href='http://www.gmslink.com/support/' target='_blank'>Support Forums</a>";
$title = "Account Receivable";
$icon = "icon-plugins";

if ( $s_status == "" ) $s_status = "0";
if ( $s_type == "" ) $s_type = "1";
?>
<?php require(DIR_WS_INCLUDES . 'body_header.php'); ?>

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
	
	
	document.shipping_to_customers_form.s_status.value = status;
}

function goFirstSearch() {
    document.shipping_to_customers_form.pageCursor.value = "";
    document.shipping_to_customers_form.submit();
    
}
function goNextSearch() {
	document.shipping_to_customers_form.pageCursor.value = parseInt(document.shipping_to_customers_form.pageCursor.value) + 1;
	document.shipping_to_customers_form.submit();
}

function goProvSearch() {
	document.shipping_to_customers_form.pageCursor.value = parseInt(document.shipping_to_customers_form.pageCursor.value) - 1;
	document.shipping_to_customers_form.submit();
}

function goExcell()
{

   document.location.href="account_receivable_excell.php?s_status=<?=$s_status?>&customers_id=<?=$customers_id?>&s_type=<?=$s_type?>&s_from_date=<?=$s_from_date?>&s_to_date=<?=$s_to_date?>&division=<?=$division?>&s_ref_no=<?=$s_ref_no?>&store=<?=$store?>";
} 
//-->
</script>


<?php


$extra_Url = "&s_status=" . $s_status . "&s_cut_no=" . $s_cut_no . "&s_order_no=" . $s_order_no . "&s_from_date=" . $s_from_date .
             "&s_to_date=" . $s_to_date . "&s_customers_id=" . $s_customers_id;


?>
<script language="JavaScript" src="/js/calendar_us.js"></script>
              <link rel="stylesheet" href="/css/calendar.css">


                  
                  <table width="1120" border="0" cellpadding="0" cellspacing="0"  >
                    <tr>
                      <td align="right" class="main">
                        <div align="right">
                          <input type="button" value=" Payment " style="width:70px;height=20px;" name="addnew" id="addnew" onClick="document.location.href='payment_list.php';" class="button-secondary action" />
                          &nbsp;
                          <input type="button" value=" Statement " style="width:70px;height=20px;" name="addnew" id="addnew" onClick="document.location.href='statement_list.php';" class="button-secondary action" />
                          &nbsp;
                          <input type="button" value=" Add New " style="width:70px;height=20px;" name="addnew" id="addnew" onClick="document.location.href='account_receivable.php';" class="button-secondary action" />
                          &nbsp;
                          <input type="button" value=" Excel " style="width:80px;height:20px;"  name="goExcel" id="goExcel" onClick="goExcell();" class="button-secondary action" />
                          </div></td>
                    </tr>
                   </table><br style="line-height:10px;">
                    <span id="option_div" style="DISPLAY: none; MARGIN-LEFT: 0px; "> 
               <table width="801" border="0" cellpadding="0" cellspacing="1" bgcolor="#f0f0f0">
               <form action="account_receivable_list.php" method="get" name="shipping_to_customers_form" id="shipping_to_customers_form"> <input type="hidden" name="pageCursor" value="<?=$pageCursor?>">
               <tr><td bgcolor=#ffffff style="padding-top:2px; padding-bottom:2px; padding-left:2px; padding-right:2px;">
              
                    
                
                 <table width="100%" border="0" cellpadding="0" cellspacing="1"  >
                    
              <tr>
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">Status&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">
                       <span class="small" style="padding-left:5px;">                     	
                       <input type="radio" name="status_radio_btn"  <?php if ( $s_status == "0" ) echo " checked='checked' "; ?> onclick="statusCheck('0')" value="0">
                        Active                      </span>
                        
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
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">Customer&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">                                            
               
                      <?php                    	
                       $selectStr = "<select  name=customers_id style='width:180px;'><option value=''></option>";
                       $sql = "select customers_id, customers_name1 from " . TABLE_CUSTOMERS . " where 1=1 ";
                       if( $session_users_admin != '1' && $session_company_id != '' && $session_company_id != '0' )
                       {
                       	  //$sql .= " and customers_company_id = '" . $session_company_id . "' ";
                       }
                       $sql .= " order by customers_name1 ";
                       $codes = tep_db_query( $sql );
                       
                       while ($codes_values = tep_db_fetch_array($codes)) 
                       {
                         
                         if ( $customers_id == $codes_values['customers_id'] ) $selectStr .= "<option value=" . $codes_values['customers_id'] . " selected>" . $codes_values['customers_name1'] . "</option>";
                         else                                        $selectStr .= "<option value=" . $codes_values['customers_id'] . "         >" . $codes_values['customers_name1'] . "</option>";    
                                                  
                       }
                       
                       $selectStr .= "</select>";
                       echo $selectStr;
                      ?>
                                            </td>
                      <td bgcolor=#ffffff class="main" align=right style="padding-right:12px;">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="135" align="right" bgcolor=#DDDDDD class="main">Type&nbsp;</td>
                      <td width="292" bgcolor=#ffffff class="main" style="padding-left:5px;">
                      
                      
                      <SELECT style="WIDTH: 180px" name=s_type>
    <OPTION value="ALL">ALL</OPTION>
    <OPTION value=1 <?php if ($s_type == "1" || $s_type == "") echo "selected"; ?> >Regular(Invoice)</OPTION>
    <OPTION value=2 <?php if ($s_type == "2" ) echo "selected"; ?>> Credit Memo</OPTION>
    <OPTION value=3 <?php if ($s_type == "3" ) echo "selected"; ?>>Debit Memo</OPTION>
    </SELECT>               </td>
                      <td bgcolor=#ffffff class="main" align=right style="padding-right:12px;">&nbsp;</td>
                    </tr>
                   <tr>
                     <td align="right" bgcolor=#DDDDDD class="main">Division&nbsp;</td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;">
                       <?php 
                        $selectStr = "<select name='division' style='width:180px;'><option value=''></option>";
                        $codes = tep_db_query("select company_id, name,name2 from company order by name asc ");
     
                        while ($codes_values = tep_db_fetch_array($codes)) 
                        {        
                          if ( $division == $codes_values['company_id'] ) $selectStr .= "<option value='" . $codes_values['company_id'] . "' selected>" . $codes_values['name'] . " " . $codes_values['name2'] . "</option>";
                          else                               $selectStr .= "<option value='" . $codes_values['company_id'] . "'         >" . $codes_values['name'] . " " . $codes_values['name2'] . "</option>";    
                        }
      
                        $selectStr .= "</select>";
                        echo $selectStr;
                       ?>
                     </td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;">&nbsp;</td>
                   </tr>
                   <tr>
                     <td align="right" bgcolor=#DDDDDD class="main">Store&nbsp;</td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;">
                       <?php 
                        $selectStr = "";
                        $selectStr = "<select name='store' style='width:180px;'><option value=''></option>";
                        $codes = tep_db_query("select idx, name,name2 from stores order by name asc ");
     
                        while ($cvs = tep_db_fetch_array($codes)) 
                        {        
                          if ( $store == $cvs['idx'] ) $selectStr .= "<option value='" . $cvs['idx'] . "' selected>" . $cvs['name'] . " " . $cvs['name2'] . "</option>";
                          else                         $selectStr .= "<option value='" . $cvs['idx'] . "'         >" . $cvs['name'] . " " . $cvs['name2'] . "</option>";    
                        }
      
                        $selectStr .= "</select>";
                        echo $selectStr;
                       ?>
                     </td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;">&nbsp;</td>
                   </tr>
                     <tr>
                     <td align="right" bgcolor=#DDDDDD class="main">Ref #&nbsp;</td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;">
                       <input name="s_ref_no" type="text" class="inputbox_center" style="WIDTH: 180px" id="s_ref_no" value="<?=$s_ref_no?>" size="20">                    </td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;"><span style="padding-left:10px;padding-right:10px;">
                       
                     </span>                      </td>
                   </tr>
                   <tr>
                     <td align="right" bgcolor=#DDDDDD class="main">AR Date&nbsp;</td>
                     <td bgcolor=#ffffff class="main" style="padding-left:5px;"><table width="200" border="0" cellpadding="0" cellspacing="0" >
                       <tr>
                           <td width="79"><table border="0" cellpadding="0" cellspacing="0">
                             <tr>
                               <td><input class="inputbox_center" name="s_from_date"  type="text" id="s_from_date" size=10 aria-required="true" value="<?=$s_from_date?>" /></td>
                               <td><script language="JavaScript"> new tcal ({ 'formname': 'shipping_to_customers_form','controlname': 's_from_date'}); </script></td>
                             </tr>
                           </table></td>
                           <td width="13">-</td>
                           <td width="86"><table border="0" cellpadding="0" cellspacing="0">
                             <tr>
                               <td><input class="inputbox_center" name="s_to_date"  type="text" id="s_to_date" size=10 aria-required="true" value="<?=$s_to_date?>" /></td>
                               <td><script language="JavaScript"> new tcal ({ 'formname': 'shipping_to_customers_form','controlname': 's_to_date'}); </script></td>
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

   <table width="1120" border="0" cellpadding="0" cellspacing="0"  >
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
      
      $sql  =  " select * from  " . TABLE_ACCOUNT_RECEIVABLE .  " where 1 = 1";
      
      if ( $s_status != "3" ) $sql .= " and status = '" . $s_status . "' ";
      
       if ( $customers_id != '' )
       {
       	   $sql .= " and customers_id = '" . $customers_id . "' ";
       }       
        
       if ( $s_ref_no != '' )
       {
       	   $sql .= " and ref_no like '%" . $s_ref_no . "%' ";
       }    
       if ( $division != '' )
       {
       	   $sql .= " and company_id='" . $division . "' ";
       } 
       if ( $store != '' )
       {
       	   $sql .= " and store_id='" . $store . "' ";
       }  
  
       if ( $s_type != "ALL" ) $sql .= " and typ = '" . $s_type . "' ";
       
       if ( $s_from_date != ''  )
       {
       	       $sql .= " and ar_date >= str_to_date('" . $s_from_date . "','%m/%d/%Y') ";
       }          
       if ( $s_to_date != ''  )
       {
       	       $sql .= " and ar_date <= str_to_date('" . $s_to_date . "','%m/%d/%Y') ";
       }
       if( $session_users_admin != '1' && $session_company_id != '' && $session_company_id != '0' )
       {
      	      //$sql .= " and company_id in (" . $session_company_id . ") ";
       }
      $sql .= " order by idx desc ";
      
      //echo $sql;
      ?>
      <br style="line-height:10px;">

              		 
              		 
      <table width=1360 border="0" class="list" cellpadding="0" cellspacing="1" bgcolor=#cccccc>
  
      <tr bgcolor=#dfdfdf height="24">
       
      
       
        <td width="200"  valign="middle" class=main  ><div align="center">Customer</div></td>
        <td width="90"   valign="middle" class=main  ><div align="center">Date</div></td>
        <td width="120"  valign="middle" class=main  ><div align="center">Type</div></td>
        <td width="100"  valign="middle" class=main  ><div align="center">Ref#</div></td>
        
        <td width="100"  valign="middle" class=main  ><div align="center">Amount</div></td>
        <td width="81"   valign="middle" class=main  ><div align="center">Paid</div></td>
        <td width="81"   valign="middle" class=main  ><div align="center">Credit</div></td>
        <td width="81"   valign="middle" class=main  ><div align="center">Balance</div></td>             
        
        <td width="90"   valign="middle" class=main  ><div align="center">Due Date</div></td>
       
        <td width="160" valign="middle" class=main  ><div align="center">Division</div></td>
        <td width="160" valign="middle" class=main  ><div align="center">Store</div></td>
      
        <td width="80"  valign="middle" class=main  ><div align="center">Status</div></td>       
        </tr>
      <tr>
        <td colspan="*"  height=1 ></td>
      </tr>
       <?php
       
      $ind  = 0;
      $i = $loc;
              				
   
      $list_split = new splitPageResults($sql, 40);
      $list_query = tep_db_query($list_split->sql_query);
      
      $row = 1;
      while ($list = tep_db_fetch_array($list_query)) 
      {	   
         $company_name = ""; $store_name = "";
         echo "<tr height=17 class='dataTableRow' bgcolor=#f8f9ec onmouseover='rowOverEffect(this)' onmouseout='rowOutEffect(this)' onclick='document.location.href=\"account_receivable.php?idx=" . $list['idx'] . $extra_Url . "\"'>";
        
         $rc = teb_query(" select customers_name1 from customers where customers_id='" . (int) $list['customers_id'] . "' ");
         $customers_name = $rc['customers_name1'];
         $rcd2 = teb_query("select name,name2 from company where company_id = '" . (int) $list['company_id'] . "'");
         $company_name = $rcd2['name'];
         if( trim($rcd2['name2']) != '' ) $company_name .= " " . $rcd2['name2'];
         
         $rcd3 = teb_query("select name,name2 from stores where idx = '" . (int) $list['store_id'] . "'");
         $store_name = $rcd3['name'];
         if( trim($rcd3['name2']) != '' ) $store_name .= " " . $rcd3['name2'];
          
         $typ = "Invoice";
         if ( $list['typ'] == '2'  )  $typ = "Credit Memo";
         if ( $list['typ'] == '3'  )  $typ = "Debit Memo";
              
       
         $status = "Active";
         if ( $list['status'] == '1' ) $status = "Close";
         
         $ar_date            = tep_convert_date_kr($list['ar_date']);  if ( $ar_date == "00/00/0000") $ar_date = "";
         $due_date            = tep_convert_date_kr($list['due_date']);  if ( $due_date == "00/00/0000") $due_date = "";
         
         $credit = $list['credit'];
          
         $rcu = teb_query("select sum(used) as t_used, sum(paid) as t_paid from ar_usages where from_ref_no='" . $list['ref_no'] . "'");
         $paid = $list['paid'] + $rcu['t_paid'];
         //$credit = $list['credit'] - $rcu['t_used'];
         
         $balance = $list['amt'] - $paid - $credit + $rcu['t_used'];
        
        
      ?>   
            <td class=small align="center" ><a href="/account_receivable.php?idx=<?=$list['idx']?><?=$extra_Url?>"><?=$customers_name?></a></td>
            <td class=small align="center"><?=$ar_date?></td>
            <td class=small align="center"><?=$typ?></td>
            <td class=small style="padding-left:5px;"><?=strtoupper($list['ref_no'])?></td>
            
            <td class=small align="right" style="padding-right:2px;" ><?=number_format($list['amt'],2)?></td>
            <td class=small align="right" style="padding-right:2px;" ><?=number_format($paid,2)?></td>
            <td class=small align="right" style="padding-right:2px;" ><?=number_format($credit,2)?></td>
            <td class=small align="right" style="padding-right:2px;" ><?=number_format($balance,2)?></td>
             
            <td class=small align="center" ><?=$due_date?></td> 
        
            <td class=small align="center" ><?=$company_name?></td>
            <td class=small align="center" ><?=$store_name?></td>   
            <td align="center" class=small><?=$status?></td>
          
            
      </tr>
       
      <?php
        $row++;
       }
       
       
       if ( $row < 40 )
       {
          while ( $row < 40 )
          {
      ?>
       <tr bgcolor='#fdfdfc' height='17'>      
           
            <td class=small align="center" nowarp>&nbsp;</td>
            <td class=small style="padding-left:5px;">&nbsp;</td>
            <td class=small >&nbsp;</td>
            <td class=small align="center">&nbsp;</td>
            <td align="center" class=small>&nbsp;</td>
            <td align="center" class=small>&nbsp;</td>
            <td class=small align="center">&nbsp;</td>
            <td align="center" class=small>&nbsp;</td>
            <td align="center" class=small>&nbsp;</td>       
            <td class=small align="center" ></td>
            <td class=small align="center" ></td>
            <td class=small align="center" ></td>
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
<table width=1360 border="0" class="list" cellpadding="0" cellspacing="1" bgcolor=#cccccc>
  <tr bgcolor=#ffffff>
    <td height="27" align=center >
                              
                             <?php
                                     if (($list_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {		//if 3
                              ?>
                               <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                  <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $list_split->display_links(40, tep_get_all_get_params(array('page', 'info'))); ?></td>
                                </tr>
                              </table>
                              <?php
                                   }
                              ?>                 
    </td>
    </tr>
    <tr bgcolor=#ffffff>
    <td height="27" align=left width=230 valign=middle>
    	 &nbsp;<input type="button" class="button-primary" style="height:18px;width:90px;background: #dfdfdf url(/images/button-gray.png) repeat-x scroll left top;border-color: #c0c0c0 !important; color: #000 !important;" tabindex=-1  onClick="document.location.href='customer_ar.php'" value=" Current A/R " name="current_ar" /> 
&nbsp;
<input type="button" class="button-primary" style="height:18px;width:90px;background: #dfdfdf url(/images/button-gray.png) repeat-x scroll left top;border-color: #c0c0c0 !important; color: #000 !important;" tabindex=-1  onClick="document.location.href='aging.php'" value=" Aging " name="toExcel" /> 
&nbsp;
<input type="button" class="button-primary" style="height:18px;width:140px;background: #dfdfdf url(/images/button-gray.png) repeat-x scroll left top;border-color: #c0c0c0 !important; color: #000 !important;" tabindex=-1  onClick="document.location.href='payment_list.php?s_status=3'" value=" Post Dated Payment " name="post_dated" /> 
<!--
<input type="button" class="button-primary" style="height:18px;width:90px; background: #dfdfdf url(/images/button-gray.png) repeat-x scroll left top;border-color: #c0c0c0 !important; color: #000 !important;" tabindex=-1  onClick="document.location.href='javascript:openAR_PrintFrom()'" value=" PDF Print " name="pdf_print" /> 
//-->
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
