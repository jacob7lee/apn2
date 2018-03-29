<?php
require('includes/application_top.php');
require('includes/functions/xorder.php');
require('includes/functions/codes.php');

$help_contents = "<h5>Help</h5><div class='metabox-prefs'><a href='http://www.gmslink.com/documentation.php' target='_blank'>Documentation</a><br /><a href='http://www.gmslink.com/support/' target='_blank'>Support Forums</a>";
$title = "Account Receivable";
$icon="icon-themes";


$process = false;
 
if (isset($HTTP_POST_VARS['action'])) 
{

    $action                  = tep_db_prepare_input($HTTP_POST_VARS['action']);
    $idx                     = tep_db_prepare_input($HTTP_POST_VARS['idx']);
    
    $customers_id            = tep_db_prepare_input($HTTP_POST_VARS['customers_id']);
    
    $ar_date                 = tep_convert_date(tep_db_prepare_input($HTTP_POST_VARS['ar_date']));
    $amt                     = tep_db_prepare_input($HTTP_POST_VARS['amt']);
    $prev_total_amt          = tep_db_prepare_input ($HTTP_POST_VARS['prev_total_amt']);
    $paid                    = tep_db_prepare_input($HTTP_POST_VARS['paid']);
    $credit                  = tep_db_prepare_input($HTTP_POST_VARS['credit']);
    $typ                     = tep_db_prepare_input($HTTP_POST_VARS['typ']);
    $ref_no                  = tep_db_prepare_input($HTTP_POST_VARS['ref_no']);
    $due_date                = tep_convert_date(tep_db_prepare_input($HTTP_POST_VARS['due_date']));
    $status                  = tep_db_prepare_input($HTTP_POST_VARS['status']);
    
    $company_id              = tep_db_prepare_input($HTTP_POST_VARS['company_id']);
    $store_id                = tep_db_prepare_input($HTTP_POST_VARS['store_id']);
    $invoice_idx             = tep_db_prepare_input($HTTP_POST_VARS['invoice_idx']);
    $payment_method          = tep_db_prepare_input($HTTP_POST_VARS['payment_method']);
 
    $remarks                 = $HTTP_POST_VARS['remarks'];
    $remarks                 = str_replace("\"","'",$remarks);
    $remarks                 = str_replace("\\","",$remarks);    
    
 
    
    $msgU = "";		
	  $error = false;
	  
	  //echo "action:" . $action;
	          
    switch ($action) 
  	{      
  	        case 'D' :  if ( $session_update_role == "off" ) tep_redirect(HTTP_SERVER);
  	                    $sql = "delete from " . TABLE_ACCOUNT_RECEIVABLE . " where idx = '" . (int)$idx . "' ";
  	                    $result = tep_db_query($sql); 
  	                    if ( $result > 0 )
                        {
  	                         
  	                         if($typ == "2")
  	                         {
  	                         	  $sql = "delete from money_trans where source_type='6' and invoice_idx = '" . $idx . "' ";
                                $result = tep_db_query($sql);
  	                         }
  	                         else if($typ == "3")
  	                         {
  	                         	  $sql = "delete from money_trans where source_type='7' and invoice_idx = '" . $idx . "' ";
                                $result = tep_db_query($sql);
  	                         }
  	                         else
  	                         {
  	                         	  if( $invoice_idx == "")
  	                         	  {
  	                         	  	$sql = "delete from money_trans where source_type='8' and invoice_idx = '" . $idx . "' ";
                                  $result = tep_db_query($sql);  	                         	  	
  	                         	  } 	
  	                         }
  	                         
  	                         
  	                         $edit_data_array = array('change_by'    => $session_users_id,
                                                      'pages'        => 'Account Receivable',
                                                      'ref_no'       => $ref_no,
                                                      'actions'      => 'Delete',
                                                      'change_date'  => 'now()'
                                                     );
						                  tep_db_perform("account_edit_history", $edit_data_array,'insert');
  	                         
  	                         
  	                         $msgU = "Success Delete for Account Receivable" ;
  	                    }
  	                    else
  	                    {
  	                         $msgU = "There is some problem for Delete Account Receivable."; 
  	                         $error = true;
  	                    }
  	        
  	                    break;
  	        case 'I' :  if ( $session_update_role == "off" ) tep_redirect(HTTP_SERVER);
  	        
  	                    $sql_data = array(   'customers_id'  => $customers_id,
                                             'ar_date'       => $ar_date,
                                             'amt'           => $amt,
                                             'paid'          => $paid,
                                             'credit'        => $credit,
                                             'typ'           => $typ,
                                             'ref_no'        => $ref_no,
                                             'due_date'      => $due_date,
                                             'status'        => $status,
                                             'company_id'    => $company_id,
                                             'store_id'      => $store_id
                                             );
                          if($invoice_idx == "")
                          {
                          	 $sql_data['payment_method'] = $payment_method;
                          }
                           //echo "insert 1";
                           
                           $result = tep_db_perform(TABLE_ACCOUNT_RECEIVABLE, $sql_data,'insert');
                           if ( $result > 0 )
                           {
                                $idx = tep_db_insert_id();
						                    tep_db_query("update " . TABLE_ACCOUNT_RECEIVABLE . " set remarks = '" . $remarks . "' where idx = '" . (int)$idx . "'");
						                    
						                    $source_type == "";
						                    
						                    if($typ == "2") $source_type = '6';
						                    if($typ == "3") $source_type = '7';
						                    if($typ == "1" && $invoice_idx == "") $source_type = '8';
						                    
						                    if( $source_type != "" )
						                    {
						                         $trans_data = array('ref_no'               => $ref_no, 
                                                        'invoice_idx'          => $idx, 	
                                                        'customers_id'         => $customers_id ,
                                                        'trans_date'           => $ar_date ,                                                   
                                                        'created_by'           => $session_users_name ,
                                                        'paid'                 => $paid,                                                   
                                                        'amt'                  => $amt, 
                                                        'credit'               => $credit,        
                                                        'payment_type'         => $payment_method,
                                                        'source_type'          => $source_type,                                          
                                                        'store_id'             => $store_id,
                                                        'company_id'           => $company_id
                                                        );         
                                     $result = tep_db_perform('money_trans', $trans_data,'insert');
						                    }
						                    
						                    $bal = $amt - $paid - $credit;
						                    $edit_data_array = array('change_by'    => $session_users_id,
                                                         'pages'        => 'Account Receivable',
                                                         'ref_no'       => $ref_no,
                                                         'actions'      => 'Create',
                                                         'amount'       => $bal,
                                                         'change_date'  => 'now()'
                                                        );
						                    tep_db_perform("account_edit_history", $edit_data_array,'insert');
                           
						                    $msgU = "Success insert Account Receivable."; 
  	                       }
  	                       else
  	                       {
  	                            $msgU = "There is some problem for insert Account Receivable."; 
  	                            $error = true;
  	                       }
  	                    
  	                    break;
  	        case 'U' :  if ( $session_update_role == "off" ) tep_redirect(HTTP_SERVER);
  	                    
  	                    $sql_data = array(   'customers_id'  => $customers_id,
                                             'ar_date'       => $ar_date,
                                             'amt'           => $amt,
                                             'paid'          => $paid,
                                             'credit'        => $credit,
                                             'typ'           => $typ,
                                             'ref_no'        => $ref_no,
                                             'due_date'      => $due_date,
                                             'status'        => $status,
                                             'company_id'    => $company_id,
                                             'store_id'      => $store_id
                                             );
                           if($invoice_idx == "")
                           {
                          	 $sql_data['payment_method'] = $payment_method;
                           }
                           
                           $result = tep_db_perform(TABLE_ACCOUNT_RECEIVABLE, $sql_data,'update', "idx = '" . (int)$idx . "'");
                           if ( $result > 0 )
                           {
                               
						                    tep_db_query("update " . TABLE_ACCOUNT_RECEIVABLE . " set remarks = '" . $remarks . "' where idx = '" . (int)$idx . "'");
						                    
						                    $source_type == "";
						                    
						                    if($typ == "2") $source_type = '6';
						                    if($typ == "3") $source_type = '7';
						                    if($typ == "1" && $invoice_idx == "") $source_type = '8';
						                    
						                    if( $source_type != "" )
						                    {
						                         $sql = "delete from money_trans where source_type='" . $source_type . "' and invoice_idx = '" . $idx . "' ";
                                     $result = tep_db_query($sql);
                                     
						                         $trans_data = array('ref_no'               => $ref_no, 
                                                        'invoice_idx'          => $idx, 	
                                                        'customers_id'         => $customers_id ,
                                                        'trans_date'           => $ar_date ,                                                   
                                                        'created_by'           => $session_users_name ,
                                                        'paid'                 => $paid,                                                   
                                                        'amt'                  => $amt, 
                                                        'credit'               => $credit,        
                                                        'payment_type'         => $payment_method,
                                                        'source_type'          => $source_type,                                          
                                                        'store_id'             => $store_id,
                                                        'company_id'           => $company_id
                                                        );         
                                     $result = tep_db_perform('money_trans', $trans_data,'insert');
						                    }
						                    
						                    $change_amt = $amt - $paid - $credit - $prev_total_amt;
						                    $edit_data_array = array('change_by'    => $session_users_id,
                                                         'pages'        => 'Account Receivable',
                                                         'ref_no'       => $ref_no,
                                                         'actions'      => 'Update',
                                                         'amount'       => $change_amt,
                                                         'change_date'  => 'now()'
                                                        );
						                    tep_db_perform("account_edit_history", $edit_data_array,'insert');
                                      
						                    $msgU = "Success update Account Receivable."; 
  	                       }
  	                       else
  	                       {
  	                            $msgU = "There is some problem for update Account Receivable.";
  	                            $error = true;
  	                       }
  	        
  	                    break;
  	                    
  	                    
  	 }
  	 
  	 $bellad_extra_Url = "&s_search_option=" . $s_search_option . "&s_status=" . $s_status . "&s_po_no=" . $s_po_no . "&s_order_no=" . $s_order_no . "&s_customers_id=" . $s_customers_id . "&s_from_date=" . $s_from_date .
                "&s_to_date=" . $s_to_date . "&s_style_no=" . $s_style_no;
  	 $apnReturnUrl .= "account_receivable.php?idx=" . $idx . $bellad_extra_Url;
	   
  	 if ( $action == 'D') 
  	 {  	     	  
  	     	  $apnReturnUrl = "account_receivable_list.php";
  	     	  echo ("<script language='JavaScript'>\n<!--\n alert('" . $msgU . "');\n document.location.href='" . $apnReturnUrl . "';\n  //-->\n</script>"); 
  	 } 
  	 else
  	 {
  	     if ( $error )
  	     {
  	          echo ("<script language='JavaScript'>\n<!--\n alert('" . $msgU . "');\n document.location.href='" . $apnReturnUrl . "';\n  //-->\n</script>"); 
  	     }
  	     else
  	     {
  	          
  	          echo ("<script language='JavaScript'>\n<!--\n alert('" . $msgU . "');\n document.location.href='" . $apnReturnUrl . "';\n  //-->\n</script>"); 
  	     }
  	 }

}
else
{
   $idx = $HTTP_GET_VARS['idx'];
}



if ( $idx != "" ) 
{
          
         $sql = "select *  from " . TABLE_ACCOUNT_RECEIVABLE . "  where  idx ='" . (int) $idx . "' ";
	      
	       $sql_query = tep_db_query($sql);
         $rcd = tep_db_fetch_array($sql_query);
         $company_id   = $rcd['company_id'];
         $store_id     = $rcd['store_id'];
         /*
         if( $session_users_admin != '1' && $session_company_id != '' && $session_company_id != '0' )
         {
         	  $pieces = explode(",", $session_company_id);
				     if ( !in_array($company_id,$pieces) ) tep_redirect(HTTP_SERVER);         	
         }  
         */
	       $invoice_idx     = $rcd['invoice_idx'];
         $customers_id   = $rcd['customers_id'];
         
         $rc = teb_query(" select customers_name1 from customers where customers_id='" . (int) $rcd['customers_id'] . "' ");
         $customers_name = $rc['customers_name1'];
         
         $ar_date        = tep_convert_date_kr($rcd['ar_date']);  if ( $ar_date == "00/00/0000") $ar_date = ""; 
         $due_date       = tep_convert_date_kr($rcd['due_date']);  if ( $due_date == "00/00/0000") $due_date = ""; 
         $amt            = $rcd['amt'];
         $paid           = $rcd['paid'];
         $credit         = $rcd['credit'];
         $typ            = $rcd['typ'];
         $ref_no         = $rcd['ref_no'];
         $payment_method = $rcd['payment_method'];
         
         $status         = $rcd['status'];
         $remarks        = $rcd['remarks'];
         $rma_chk        = $rcd['rma_chk'];
         
         $rcu = teb_query("select sum(used) as t_used, sum(paid) as t_paid from ar_usages where from_ref_no='" . $ref_no . "'");
        
         $amount_str = sprintf("%01.2f", $amt);
         $paid_str = sprintf("%01.2f", $paid);
         $credit_str = sprintf("%01.2f", $credit);
         $ar_bal = $amt - $paid - $credit + $rcu['t_used'] - $rcu['t_paid'];
         $balance_str = sprintf("%01.2f", $ar_bal);
         
         
         if ($typ == "2" ) 
         {
         	   $typ_str = "Credit Memo";
         	   $extra_str = "Credit Used";
         	   $extra_amt_str = sprintf("%01.2f", $rcu['t_used']);
         	   
         }
         else if ($typ == "3" ) $typ_str = "Debit Memo";
         else
         {
         	   $typ_str = "Regular(Invoice)";
         	   $extra_str = "AR Paid";
         	   $extra_amt_str = sprintf("%01.2f", $rcu['t_paid']);
         }
      
         $action = "U";
    
}
else
{
          $action = "I";
          $ar_date = date("m") . "/" . date("d") . "/" . date("Y");
}
  
?>
<?php require(DIR_WS_INCLUDES . 'body_header.php'); ?>

<?php require("js/JavascriptForceNumericInput.php"); ?>
<script src="/js/date_validation.js"></script>
<script language="JavaScript" src="/js/calendar_us.js"></script>
<link rel="stylesheet" href="/css/calendar.css">
<script language=javascript>
<!--

function chkFields(flag) 
{
    if ( flag != 'D' ) 
    {
    
              
    	        
    		      if ( document.account_receive_edit.customers_id.value =="") 
    		      {
    		      	  alert("Account Receivable is empty,Please select Customer. ");
    		      	  document.account_receive_edit.customers_id.focus();
    		      		return false;
    		      } 
  
              if ( document.account_receive_edit.ref_no.value =="") 
    		      {
    		      	  alert("Ref # is empty,Please input Ref #. ");
    		      	  document.account_receive_edit.ref_no.focus();
    		      		return false;
    		      }
    		      
              if ( document.account_receive_edit.ar_date.value =="") 
    		      {
    		      	  alert("Please input AR Date. ");
    		      	  document.account_receive_edit.ar_date.focus();
    		      		return false;
    		      } 
    		      if ( document.account_receive_edit.due_date.value =="") 
    		      {
    		      	  alert("Please input DUE Date. ");
    		      	  document.account_receive_edit.due_date.focus();
    		      		return false;
    		      }
    		      if ( document.account_receive_edit.company_id.value == '' )
              {             	   
          	      if ( document.account_receive_edit.store_id.value == '') 
                  {
    		      	     alert(" Please select a Division or Store.");
    		      	     document.account_receive_edit.company_id.focus();
    		      		   return false;
    		      	  }                       
              }
        <?php if($invoice_idx == "") { ?>
              if ( document.account_receive_edit.payment_method.value =="") 
    		      {
    		      	  alert("Please select Payment Method. ");
    		      	  document.account_receive_edit.payment_method.focus();
    		      		return false;
    		      } 
    		     
    		<?php  } ?>      
    }
    
    return true;

}

function goUpdate(flag) 
{
      if ( chkFields(flag) ) 
	    {
	    		if ( flag == 'D' ) document.account_receive_edit.action.value = 'D';
	    		document.account_receive_edit.submit();
	    }

}



function setStatus(status)
{
   document.account_receive_edit.status.value = status;

}


function sum()
{
    var amt = 0.0;
    var paid = 0.0;
    var credit = 0.0;
    var balance = 0.0;
    var extra_amt = 0.0;
    var typ = document.account_receive_edit.amt.value;
 
    try
    {
        amt       = ( $.trim(document.account_receive_edit.amt.value) == '' ) ? 0.0 : parseFloat( $.trim(document.account_receive_edit.amt.value) );
    }
    catch ( ex )
    {
        amt       = 0.0;
    }
    
    try
    {
        paid       = ( $.trim(document.account_receive_edit.paid.value) == '' ) ? 0.0 : parseFloat( $.trim(document.account_receive_edit.paid.value) );
    }
    catch ( ex )
    {
        paid       = 0.0;
    }
    try
    {
        credit       = ( $.trim(document.account_receive_edit.credit.value) == '' ) ? 0.0 : parseFloat( $.trim(document.account_receive_edit.credit.value) );
    }
    catch ( ex )
    {
        credit       = 0.0;
    }
    try
    {
        extra_amt       = ( $.trim(document.account_receive_edit.extra_amt.value) == '' ) ? 0.0 : parseFloat( $.trim(document.account_receive_edit.extra_amt.value) );
    }
    catch ( ex )
    {
        extra_amt       = 0.0;
    }
    
     
    try
    {    
    
        balance = amt - paid - credit;
        
        if( extra_amt > 0.0 )
        {
        	  if( typ == '1' ) balance += extra_amt;
        	  else if( typ == '2' ) balance -= extra_amt;
        }
        document.account_receive_edit.balance.value = balance.toFixed(2);
    }
    catch ( ex)
    {
         alert(ex);
    }

}

function getstoreDivision()
{	
    var frm = document.account_receive_edit;
	  var store_id = frm.store_id.value;
	  var action = frm.action.value;
	  if( store_id == "" ) return;
	  
     $.get("ajax_updater4.php", { get_division_from_store: store_id  }, function(data)
     {	        
         if( data.length > 0)
	       {
	      	  frm.company_id.value = data;
	       }    
     });
}
function com_change()
{
	 var frm = document.account_receive_edit;	
   if( frm.company_id.options[frm.company_id.selectedIndex].value != '' )
   {   	   	   
   	   frm.store_id.value='';  	
   }
	
}

function ajax_ref_dup_check() 
{
	    var frm = document.account_receive_edit;
	    var ref_no = $.trim(frm.ref_no.value);
	    var idx = $.trim(frm.idx.value);
	    if ( ref_no == '' ) return;
	    
	   $.get("ajax_updater.php", { get_ar_ref_dup_check: ref_no, idx: idx  }, function(data)
     {	        
         if( data.length > 0)
	       {
	      	   if(data > 0)
		         {		         	   
                 frm.ref_no.value = "";
                 frm.ref_no.focus();
		         	   alert("There is Exist Invoice # ,Please input another #");
		         }
	       }    
     });
	    
	     
}

function remove_rows(obj)
{
	
	var remove_button_rows = document.getElementsByName("remove_button[]");
	var usage_idx_rows = document.getElementsByName("usage_idx[]");
	var usage_ref_no_rows = document.getElementsByName("usage_ref_no[]");
	
	var lastRow = remove_button_rows.length;
	var current_row = 0;
         
  for ( var i = 0; i < lastRow ; i++)
  {
             if ( remove_button_rows[i] == obj )
             {
                  current_row = i;
                  break;	
             } 
  }
    
  var usage_idx = usage_idx_rows[current_row].value;
  var usage_ref_no =  usage_ref_no_rows[current_row].value;
  
  //alert("usage_idx : " + usage_idx + ", usage_ref_no : " + usage_ref_no);
  var answer = confirm("Are you sure you want to delete this record ( " + usage_ref_no + " ) ?");
  if(answer)
  {
       var ar_idx = document.account_receive_edit.idx.value;
       $.get("ajax_updater_3.php", { del_ar_usage:  usage_idx, to_ref_no: usage_ref_no  }, function(data)
       {	        
           if( data.length > 0)
	         {	        
	         	  var url = "/account_receivable.php?idx=" + ar_idx;
	            document.location.href=url;          
	         }    
       });	
	
  }
  
  return false;
}

function typChange()
{
   var frm = document.account_receive_edit;
   var typ = frm.typ.options[frm.typ.selectedIndex].value;

   if( typ == '1' || typ == '3')
   {
   	  document.getElementById('td_credit').classList.remove('required');
      document.getElementById('td_credit').classList.add('main');
      document.getElementById('td_amount').classList.remove('main');
      document.getElementById('td_amount').classList.add('required');
      
      $('#credit').val('');
      $('#credit').attr('readonly', true);
      $('#amt').attr('readonly', false);
      
      sum();
   	
   }
   if( typ == '2')
   {
   	  document.getElementById('td_credit').classList.remove('main');
      document.getElementById('td_credit').classList.add('required');
      document.getElementById('td_amount').classList.remove('required');
      document.getElementById('td_amount').classList.add('main');
      
      $('#amt').val('');
      $('#credit').attr('readonly', false);
      $('#amt').attr('readonly', true);
      
      sum();
   	
   }
}

function openAR_PrintFrom()
{
   var frm = document.account_receive_edit;
   var idx = frm.idx.value;
 
   OpenPopup('acct_receivable_pdf.php?idx='+idx);


}

//-->
</script>


<?php echo tep_draw_form('account_receive_edit', tep_href_link('account_receivable.php', '', 'SSL'), 'post', 'onSubmit="return check_form(account_receive_edit);"') . tep_draw_hidden_field('action', $action); ?>

<input name="idx" type=hidden value="<?=$idx?>">
<input name="invoice_idx" type=hidden value="<?=$invoice_idx?>">
<input type=hidden name="prev_total_amt" value="<?=$balance_str?>">
<div class="top_display">
<table width="820" border="0" cellpadding="0" style="margin-top:3px;" cellspacing="1" bgcolor="#ededed">
  <tbody>
    <tr>
        <td height="1" colspan="2" bgcolor="#DDDDDD"></td>
    </tr>
    <tr>
      <td width="150" align="right" valign="middle" class="required" bgcolor="#f3f2f2">Customer&nbsp;</td>
      <td width="280" height="27" valign="middle" style="padding-left:5px;">
      <?php
      
      $xrmove = false;
      
      ?>
      <?php require('customers_auto_completed.php'); ?></td>
      <td width="130" align="right" valign="middle" class="required" bgcolor="#f3f2f2" style="padding-left:5px;">Date&nbsp;</td>
      <td width="260" valign="middle" style="padding-left:5px;">
      
      <table  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input class="inputbox_center" name="ar_date"  type="text" id="ar_date" size=10 aria-required="true" value="<?=$ar_date?>" /></td>
        <td><?php if ( $session_update_role == "on" ) { ?>
        	<script language="JavaScript"> new tcal ({ 'formname': 'account_receive_edit','controlname': 'ar_date'}); </script><?php } ?></td>
      </tr>
    </table>
      
      </td>
    </tr>
    
    <tr>
      <td align="right" valign="middle" class="main" bgcolor="#f3f2f2">Type&nbsp;</td>
      <td valign="middle"  style="padding-left:5px;">
    <?php  if($action == "U") { echo $typ_str; ?>  
    <input type=hidden name=typ value="<?=$typ?>" >
    <?php } else { ?>  
      <SELECT style="WIDTH: 140px" name=typ onchange="typChange();">
    <OPTION value=""></OPTION>
    <OPTION value=1 <?php if ($typ == "1" || $typ == "") echo "selected"; ?> >Regular(Invoice)</OPTION>
    <OPTION value=2 <?php if ($typ == "2" ) echo "selected"; ?>>Credit Memo</OPTION>
    <OPTION value=3 <?php if ($typ == "3" ) echo "selected"; ?>>Debit Memo</OPTION>
    </SELECT>
    <?php } ?>  
      </td>
      <td align="right" valign="middle" class="required" bgcolor="#f3f2f2"  style="padding-right:5px;">Ref #</td>
      <td valign="middle"  style="padding-left:5px;">
      	<input  name="ref_no" type="text" class="inputbox_center" id="ref_no"  style="width:160px;"  
      	<?php if($invoice_idx != "") { echo " readonly "; } else { echo " onBlur='ajax_ref_dup_check();' "; } ?> 
      	value="<?=$ref_no?>" maxlength="20"  />
      </td>
    </tr>
    <tr>
    <td align="right" class="main" style="padding-right:5px;" >Division</td>
    <td style="padding-left:5px;">
    	  <select name="company_id" style=" width:200px;" onChange="com_change();">
           	<option value=''></option>
           	<?php
           	   $codes = tep_db_query("select company_id,name,name2 from company  order by name asc");
           	   
                while ($codes_values = tep_db_fetch_array($codes)) 
                {
                	   $company_names = $codes_values['name'];
                	  if($codes_values['name2'] != '' ) $company_names .= " - " . $codes_values['name2'];
                	  
                	  if ( $company_id == $codes_values['company_id'] ) 
                	  {
                	  	$selectStr .= "<option value='" . $codes_values['company_id'] . "' selected>" . $company_names . "</option>";
                	  }
                   else                              
                   {
                   	 $selectStr .= "<option value='" . $codes_values['company_id'] . "'         >" . $company_names . "</option>";    
                   }                              
        
                }
                echo $selectStr;
           	?>
        </select>  
    </td>
    <td align="right" class=main  style="padding-right:5px;" >Store Name</td>
	   <td style="padding-left:5px;" >    
    	<?=tep_select_one_store('store_id',$store_id,' onChange="getstoreDivision();" style="width:200px;" '); ?>
     </td>
    
    </tr> 
    <tr>
      <td height="6" bgcolor="#DDDDDD" colspan="4"></td>     
    </tr>
  
    <tr>
      <td width="101" align="right" class="required" valign="middle" bgcolor="#f3f2f2">Due Date&nbsp;</td>
      <td width="386" height="27" valign="middle" style="padding-left:5px;">
      <table  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input class="inputbox_center" name="due_date"  type="text" id="due_date" size=10 aria-required="true" value="<?=$due_date?>" /></td>
        <td><?php if ( $session_update_role == "on" ) { ?>
        	<script language="JavaScript"> new tcal ({ 'formname': 'account_receive_edit','controlname': 'due_date'}); </script>
        	<?php } ?></td>
      </tr>
    </table>
      </td>
      <td width="129" align="right" class="main" valign="middle" bgcolor="#f3f2f2">Status&nbsp;</td>
      <td width="241"  valign="middle" style="padding-left:5px;" >      
      <input type='radio' name='status_radio' <?php if ( $status == '0' || $status == '' ) echo " checked='checked'"; ?> onClick="setStatus('0');"  />Active
      <input type='radio' name='status_radio' <?php if ( $status == '1') echo " checked='checked'"; ?> onClick="setStatus('1');" />Close 
      <input type=hidden name=status value="<?=$status?>">
      </td>
    </tr>
    <tr>
      <td align="right" valign="middle" class="required" bgcolor="#f3f2f2" id="td_amount">Amount&nbsp;</td>
      <td valign="middle"  style="padding-left:5px;" ><input  name="amt" type="text" class="inputbox_center" id="amt" onblur="sum();" onkeydown='ForceNumericInput(this.value, true, false)' value="<?=$amount_str?>" style="width:90px;text-align:right;" /></td>
      <td align="right" valign="middle" class="main" bgcolor="#f3f2f2" id="td_credit">Credit&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" ><input  name="credit" type="text" class="inputbox_center" id="credit" onblur="sum();"  onkeydown='ForceNumericInput(this.value, true, false)' value="<?=$credit_str?>" style="width:90px;text-align:right;" /></td>
    </tr>
    <tr>
      <td align="right" valign="middle" class="main" bgcolor="#f3f2f2">Paid&nbsp;</td>
      <td valign="middle" style="padding-left:5px;"><input  name="paid" type="text" class="inputbox_center" id="paid" onblur="sum();"  onkeydown='ForceNumericInput(this.value, true, false)' value="<?=$paid_str?>" style="width:90px;text-align:right;" /></td>
      <td align="right" valign="middle" class="main" bgcolor="#f3f2f2"><?=$extra_str?>&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" ><input  name="extra_amt" type="text" class="inputbox_center" id="extra_amt" onblur="sum();"  readonly value="<?=$extra_amt_str?>" style="width:90px;text-align:right;" /></td>
    </tr>
    <tr>
      <td align="right" valign="middle" class="main" bgcolor="#f3f2f2">Balance&nbsp;</td>
      <td valign="middle"  align=left style="padding-left:5px;"><input  name="balance" type="text" class="inputbox_center" id="balance"   value="<?=$balance_str?>" readonly  style="width:90px;text-align:right;" /></td>
      <td align="right" valign="middle" class="main" bgcolor="#f3f2f2">&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" ></td>
    </tr>
 <?php
   if($invoice_idx == "") {
 ?>
   	<tr>
      <td align="right" valign="middle" class="main" bgcolor="#f3f2f2">Payment Method&nbsp;</td>
      <td valign="middle"  align=left style="padding-left:5px;">
      	<?=tep_select_codes_by_idx('paymenttype','payment_method',$payment_method,' style=" width:180px;  " ')?> </td>
      <td align="right" valign="middle" class="main" bgcolor="#f3f2f2">&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" ></td>
    </tr>   	
 <?php
  }
  ?>  	
    <tr>
      <td height="1" bgcolor="#DDDDDD" colspan="6"></td>
    </tr>
  </tbody>
</table>

</div>
<?php
if ($typ == "2" ) 
{
?>
<br>
<table border="0" cellspacing="0" cellpadding="0" width="600">
  <tbody>
    <tr>
      <td><img src="/images/bullet/i_news.gif" />&nbsp;<strong>Credit Usage Detail</strong></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<table width=630 border="0" id="usages_table" class="list" cellpadding="0" cellspacing="1" bgcolor=#cccccc>
    <tr  bgcolor=#dfdfdf height="24">              
      <td width="126"  class=main><div align="center">Ref #</div></td>  
      <td width="180" class=main><div align="center">Date</div></td>   
      <td width="100"  class=main><div align="center">Amount</div></td>    
      <td width="210"  class=main><div align="center">Created By</div></td> 
      <td width="14"  class=main><div align="center"></div></td>
    </tr> 

<?php
    $ru_query = tep_db_query("select * from ar_usages where from_ref_no='" . $ref_no . "'");
    while($list = tep_db_fetch_array($ru_query) )
    {        
         $rc = teb_query("select idx from invoice where invoice_no='" . $list['to_ref_no'] . "' ");
         $rcd = teb_query("select users_name from users where users_id='" . $list['created_by'] . "' ");
              
         $u_create_date  = tep_convert_date_kr($list['create_date']);  if ( $u_create_date == "00/00/0000") $u_create_date = "";

?>
    <tr  bgcolor='#ffffff' height='18'>    	
       <td class=small style="text-align:center;"><a href='invoice.php?<?=$extra_Url?>&idx=<?=$rc['idx']?>&<?=$extra_Url?>' target='_blank'><?=$list['to_ref_no']?></a></td>
       <td class=small style="text-align:center;"><?=$u_create_date?></td>
       <td class=small style="text-align:right;padding-right:8px;"><?=number_format($list['used'],2)?></td>
       <td class=small style="padding-left:5px;"><?=$rcd['users_name']?></td>
       <td  align=center><input type=image name='remove_button[]' onClick="return remove_rows(this);" src="/images/buttons/delete_row.jpg" width=13>
        <input type=hidden name='usage_idx[]' value='<?=$list['idx']?>'><input type=hidden name='usage_ref_no[]' value='<?=$list['to_ref_no']?>'>
       </td>  
    </tr>
<?php
    }
?>
</table>
<?php
}
?>
<br>
<table border="0" cellspacing="0" cellpadding="0" width="820">
  <tbody>
    <tr>
      <td><img src="/images/bullet/i_news.gif" />&nbsp;<strong>Remark</strong></td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<textarea name="remarks"   rows="9" style="width:820px;" ><?=$remarks?></textarea>         

<?php
$successReturnUrl = "/account_receivable_list.php";
?>

<table width="820"  border="0" cellpadding="0" style="padding-top:5px;padding-bottom:5px;" cellspacing="0" >
<tr><td height=12></td></tr>
<tr>
<td width="400"  align=left style="padding-left:4px;">
<input type="button" class="button-primary" style="height:20px;width:90px;" onClick="document.location.href='<?=$successReturnUrl?>'" value="  Back  " name="goback" /> &nbsp;

&nbsp;
<input type="button" class="button-primary" style="width:135px;height:20px; background: #dfdfdf url(/images/button-gray.png) repeat-x scroll left top;border-color: #c0c0c0 !important; color: #000 !important;" tabindex=-1  onClick="document.location.href='payment_history.php?idx=<?=$idx?>'" value=" AR Payment History " name="Excell" /> 
&nbsp;
<?php if ($action == 'U' ) { ?>
 <input type="button" class="button-primary" style="width:90px;height:20px; background: #dfdfdf url(/images/button-gray.png) repeat-x scroll left top;border-color: #c0c0c0 !important; color: #000 !important;" tabindex=-1  onClick="openAR_PrintFrom();" value=" PDF Print " name="pdf_print" /> 
 <?php } ?>
</td>
<td align=right >
<?php if ( $from == '' ) { ?>

	<?php if ($action == 'I' ) { ?>
	<?php if ( $session_update_role == "on" ) { ?>
	    <input type="button" style="height:20px;width:90px;"  class="button-primary" tabindex=-1  onClick="goUpdate('I');" value="  Save  " name="Insert" /> 
	<?php }  } ?>
	
	
	
	<?php if ($action == 'U' ) { ?>
	<?php if ( $session_update_role == "on" && $invoice_idx== "" ) { ?>
	    <?php if ($status == "0") { ?>
	    
      <input type="button" style="height:20px;width:90px;"  class="button-primary" onClick="goUpdate('U');" value=" Update " name="update" /> 
     
      <?php } ?>
      <input type="button" style="height:20px;width:90px;"  value="  Delete " name="delete" onClick="goUpdate('D');" id="delete" class="button-primary" /> 
	<?php }  }  } ?>
</td>
</tr>
</table>


</form>



<script type="text/javascript"> 


function stopRKey(evt) { 
  var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 


document.onkeypress = stopRKey; 

</script> 

<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>