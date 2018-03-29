<?php
require('includes/application_top.php');
require('includes/functions/xorder.php');
$help_contents = "<h5>Help</h5><div class='metabox-prefs'><a href='http://www.gmslink.com/documentation.php' target='_blank'>Documentation</a><br /><a href='http://www.gmslink.com/support/' target='_blank'>Support Forums</a>";
$title = "Account Payable";
$icon="icon-themes";


$process = false;
 
if (isset($HTTP_POST_VARS['action'])) 
{

    $action                  = tep_db_prepare_input($HTTP_POST_VARS['action']);
    $idx                     = tep_db_prepare_input($HTTP_POST_VARS['idx']);
    
    $vendors_id              = tep_db_prepare_input($HTTP_POST_VARS['vendors_id']);
    $contractors_id          = tep_db_prepare_input($HTTP_POST_VARS['contractors_id']);  
    
    $ap_date                 = tep_convert_date(tep_db_prepare_input($HTTP_POST_VARS['ap_date']));
    $due_date                 = tep_convert_date(tep_db_prepare_input($HTTP_POST_VARS['due_date']));
    $pay_date                 = tep_convert_date(tep_db_prepare_input($HTTP_POST_VARS['pay_date']));
    
    $amount                  = tep_db_prepare_input($HTTP_POST_VARS['amount']);  
    $paid                    = tep_db_prepare_input($HTTP_POST_VARS['paid']);
    $credit                  = tep_db_prepare_input($HTTP_POST_VARS['credit']);
    $typ                     = tep_db_prepare_input($HTTP_POST_VARS['payment_type']);
    $ref_no                  = tep_db_prepare_input($HTTP_POST_VARS['ref_no']);
    $po_no                  = tep_db_prepare_input($HTTP_POST_VARS['po_no']);
    $invoice_no                  = tep_db_prepare_input($HTTP_POST_VARS['invoice_no']);
    
    $status                  = tep_db_prepare_input($HTTP_POST_VARS['status']);
    $remarks                 = $HTTP_POST_VARS['remarks'];
    $remarks                 = str_replace("\"","'",$remarks);
    $remarks                 = str_replace("\\","",$remarks);  
    
  
    
    $msgU = "";		
	  $error = false;
	  
	  
	  
	  
	  //echo "action:" . $action;
	          
    switch ($action) 
  	{      
  	        case 'D' :  if ( $session_update_role == "off" ) tep_redirect(HTTP_SERVER);
  	                    $sql = "delete from " . TABLE_ACCOUNT_PAYABLE . " where idx = '" . (int)$idx . "' ";
  	                    $result = tep_db_query($sql); 
  	                    if ( $result > 0 )
                        {
                        	   $sql = "delete from " . TABLE_ACCOUNT_PAYABLE_CONTRACTOR . " where idx = '" . (int)$idx . "' ";
  	                         $result = tep_db_query($sql); 
  	                         $msgU = "Success Delete for Account Payable" ;
  	                         
  	                      
  	                    }
  	                    else
  	                    {
  	                         $msgU = "There is some problem for Delete Account Payable."; 
  	                         $error = true;
  	                    }
  	        
  	                    break;
  	        case 'I' :  if ( $session_update_role == "off" ) tep_redirect(HTTP_SERVER);
  	        
  	                     if ($company_id != '')   {   }
                         else 
                         {
      	                         $pieces = explode(",", $session_company_id);
      	                         $company_id = $pieces[0];
                         } 
  	                    $sql_data = array(   'vendors_id'      => $vendors_id,
  	                                         'contractors_id'  => $contractors_id,     
                                             'ap_date'         => $ap_date,
                                             'due_date'        => $due_date,
                                             'pay_date'        => $pay_date,
                                             'amt'          => $amount,
                                             'paid'            => $paid,
                                             'credit'          => $credit,
                                             'typ'             => $typ,
                                             'ref_no'          => $ref_no,
                                             'invoice_no'      => $invoice_no,  
                                             'so_no'           => $so_no,
                                             'style_no'        => $style_no,                                          
                                             'status'          => $status
                                             );
                           if( $session_users_admin != '1' && $session_company_id != '' && $session_company_id != '0' )
                                  {
      	                                $sql_data['company_id'] = $company_id;
                                  } 
                           if( $typ == '4')
                           {
                           	   $sql_data['po_no'] = $po_no;
                           }                      
                           $result = tep_db_perform(TABLE_ACCOUNT_PAYABLE, $sql_data,'insert');
                           if ( $result > 0 )
                           {
                                $idx = tep_db_insert_id();
						                    tep_db_query("update " . TABLE_ACCOUNT_PAYABLE . " set remarks = '" . $remarks . "' where idx = '" . (int)$idx . "'");
						                    						                   
						                    $msgU = "Success insert Account Payable."; 
  	                       }
  	                       else
  	                       {
  	                            $msgU = "There is some problem for insert Account Payable."; 
  	                            $error = true;
  	                       }
  	                    
  	                    break;
  	        case 'U' :  if ( $session_update_role == "off" ) tep_redirect(HTTP_SERVER);
  	                         
  	                    $sql_data = array(   'vendors_id'      => $vendors_id,
  	                                         'contractors_id'  => $contractors_id,     
                                             'ap_date'         => $ap_date,
                                             'due_date'        => $due_date,
                                             'pay_date'        => $pay_date,
                                             'amt'          => $amount,
                                             'paid'            => $paid,
                                             'credit'          => $credit,
                                             'typ'             => $typ,
                                             'ref_no'          => $ref_no, 
                                             'invoice_no'      => $invoice_no,  
                                             'so_no'           => $so_no,
                                             'style_no'        => $style_no,                                           
                                             'status'          => $status
                                             );
                           if( $typ == '4')
                           {
                           	   $sql_data['po_no'] = $po_no;
                           }     
                               
                           $result = tep_db_perform(TABLE_ACCOUNT_PAYABLE, $sql_data,'update', "idx = '" . (int)$idx . "'");
                           if ( $result > 0 )
                           {
                               
						                    tep_db_query("update " . TABLE_ACCOUNT_PAYABLE . " set remarks = '" . $remarks . "' where idx = '" . (int)$idx . "'");
						                    
						                   
						                    $msgU = "Success update Account Payable."; 
  	                       }
  	                       else
  	                       {
  	                            $msgU = "There is some problem for update Account Payable.";
  	                            $error = true;
  	                       }
  	        
  	                    break;
  	                    
  	                    
  	 }
  	 
  	 $successReturnUrl = "/account_payable.php?idx=" . $idx;
	   $errorReturnUrl   = "/account_payable.php";
  	 if ( $error )
  	 {
  	      echo ("<script language='JavaScript'>\n<!--\n alert('" . $msgU . "');\n document.location.href='" . $successReturnUrl . "';\n  //-->\n</script>"); 
  	 }
  	 else
  	 {
  	      
  	      echo ("<script language='JavaScript'>\n<!--\n alert('" . $msgU . "');\n document.location.href='" . $successReturnUrl . "';\n  //-->\n</script>"); 
  	 }
  	 

}
else
{
   $idx = $HTTP_GET_VARS['idx'];
}



if ( $idx != "" ) 
{
          
         $sql = "select *  from " . TABLE_ACCOUNT_PAYABLE . "  where  idx ='" . (int) $idx . "' ";
	 
	       $sql_query = tep_db_query($sql);
         $rcd = tep_db_fetch_array($sql_query);
         
         $company_id     = $rcd['company_id'];
          if( $session_users_admin != '1' && $session_company_id != '' && $session_company_id != '0' )
          {
          	  $pieces = explode(",", $session_company_id);
				     if ( !in_array($company_id,$pieces) ) tep_redirect(HTTP_SERVER);      	
         }  
        	       
         $vendors_id   = $rcd['vendors_id'];
         $contractors_id   = $rcd['contractors_id'];
         $so_no   = $rcd['so_no'];
         $po_no   = $rcd['po_no'];
         $style_no   = $rcd['style_no'];
         
         if($vendors_id != '' && $vendors_id != 0)
         {
         	 $rc = teb_query(" select vendors_name from vendors where vendors_id='" . (int) $vendors_id . "' ");
           $vendors_name = $rc['vendors_name'];
         } else {
         	 $rc = teb_query(" select contractors_name from contractors where contractors_id='" . (int) $contractors_id . "' ");
           $vendors_name = $rc['contractors_name'];
         }
         
         $ap_date        = tep_convert_date_kr($rcd['ap_date']);  if ( $ap_date == "00/00/0000") $ap_date = ""; 
         $due_date       = tep_convert_date_kr($rcd['due_date']);  if ( $due_date == "00/00/0000") $due_date = "";
         $pay_date       = tep_convert_date_kr($rcd['pay_date']);  if ( $pay_date == "00/00/0000") $pay_date = "";
          
         $amount            = $rcd['amt'];
         $paid           = $rcd['paid'];
         $credit           = $rcd['credit'];
         $payment_type      = $rcd['typ'];
         $ref_no          = $rcd['ref_no'];
         $invoice_no      = $rcd['invoice_no'];
         
         $status         = $rcd['status'];
         $remarks        = $rcd['remarks'];
         $amount_str   = sprintf("%01.2f", $amount);
         $credit_str   = sprintf("%01.2f", $credit);
         $paid_str   = sprintf("%01.2f", $paid);
         $balance_str = sprintf("%01.2f", $amount - $paid - $credit);
           
         $action = "U";
         $po_list=""; $po_nos="";
         $cut_list="";     $style_list="";
         $delivery_type_str = ""; 
         
         $so_terms = "";
         if( $so_no != '')
         {
         	  $so_rc = teb_query("select terms from xorder where order_no='" . $so_no . "' ");
         	  $so_terms = $so_rc['terms'];
         	
         }
         
        if($payment_type == "0" || $payment_type == "") 
        {
        	  $payment_type_str = "Fabric Payment";
        	  $ref_str = "P/L #";
        	  
        	  if ($po_no != '')
               {
                    $cut_sql =  "select DISTINCT cut_no from cuts where order_no ='" .  $po_no . "'"; 
                    //echo $cut_sql . "<br>";
                    $cut_query = tep_db_query($cut_sql);    
                         
                    while( $cut_rec = tep_db_fetch_array($cut_query) ) 
                    {
                    	   if($cut_list == "") $cut_list = $cut_rec['cut_no'];
                    	   else $cut_list .= "," . $cut_rec['cut_no'];
                    }
               }                
      
        }
        if($payment_type == "1") 
        {
        	   $payment_type_str = "Trim Payment";
        	   $ref_str = "Rec #";
        	   
        	   if ($po_no != '')
                {
                     $cut_sql =  "select DISTINCT cut_no from cuts where order_no ='" .  $po_no . "'"; 
                     //echo $cut_sql . "<br>";
                     $cut_query = tep_db_query($cut_sql);    
                          
                     while( $cut_rec = tep_db_fetch_array($cut_query) ) 
                     {
                     	   if($cut_list == "") $cut_list = $cut_rec['cut_no'];
                     	   else $cut_list .= "," . $cut_rec['cut_no'];
                     }
                }   
        	
        }
        if($payment_type == "2") 
        {
        	   $payment_type_str = "Contract Payment";           
        	   $ref_str = "Receive #";
        	   
        	   $sql = "select * from receive where receive_no = '" . $ref_no . "' ";
             if($rcd = teb_query($sql))
             {        	
             	 $sql2 = "select b.po, b.style from sales_orders a, sales_orders_details b where a.idx=b.idx and b.po !='' and " .
             	         " a.order_no ='" . $rcd['po'] . "'";          
             	 $cut_list = $rcd['ref_no'];
      
             }
             else
             {
             	   $ref_str = "Contract #";
             	   $sql = "select b.cut_no,a.* from production_order a, production_order_detail b where a.idx=b.idx and a.order_no ='" . $ref_no . "' LIMIT 1  ";
             	   $rcd = teb_query($sql);
             	   
             	   $cut_list = $rcd['cut_no'];
             	   $contract_idx = $rcd['idx'];
             	
             	
             }
        }
        if($payment_type == "3") 
        {
        	   $payment_type_str = "Sendout Payment";           
        	   $ref_str = "Receive #";
        	   $sendout_type = "";
        	   
        	   $sql = "select * from trim_new_sendout where order_no = '" . $ref_no . "' ";
             if($rcd = teb_query($sql))
             {        	
             	 $so_type = $rcd['sendout_type'];
               if( $so_type == '1' ) $sendout_type = "Fabric Modified";      
               else                  $sendout_type = "Piece Moving";             
  
             	 
             	 $sql2 = "select b.po, b.style from sales_orders a, sales_orders_details b where a.idx=b.idx and b.po !='' and " .
             	         " a.order_no ='" . $rcd['po_no'] . "'";          
             	 $cut_list = $rcd['cut_no'];
      
             }
             else
             {
             	   $sendout_type = "FABRIC";
             	   $sql = "select * from fabric_sendout_order where order_no = '" . $ref_no . "' ";
                 if($rcd = teb_query($sql))
                 {        	
             	      $sql2 = "select b.po, b.style from sales_orders a, sales_orders_details b where a.idx=b.idx and b.po !='' and " .
             	              " a.order_no ='" . $rcd['po_no'] . "'";          
             	      $cut_list = $rcd['cut_no'];
             	   }
             }
        
        }
        if($payment_type == "4") 
        {
        	   $payment_type_str = "Credit Memo";           
        	   $ref_str = "";    
        
        }
        
        
        
        
        
      
}
else
{
          $action = "I";
          $ref_str = "P/L #";
          
}
  
?>
<?php require(DIR_WS_INCLUDES . 'body_header.php'); ?>

<SCRIPT src="/js/prototype.js" type=text/javascript></SCRIPT>
<?php require("js/JavascriptForceNumericInput.php"); ?>
<script src="/js/date_validation.js"></script>
<script language="JavaScript" src="/js/calendar_us.js"></script>
<link rel="stylesheet" href="/css/calendar.css">

<script type="text/javascript" src="/js/jquery/jquery/jquery-1.7.1.min.js"></script>

<script language=javascript>
<!--

function chkFields(flag) 
{
    if ( flag != 'D' ) 
    {
             if( document.account_payable_edit.payment_type.value != '4')
             {
    		      if ( document.account_payable_edit.ref_no.value =="") 
    		      {
    		      	  alert("Please type Ref No!!! ");
    		      	  document.account_payable_edit.ref_no.focus();
    		      		return false;
    		      } 
             }
              
              if ( document.account_payable_edit.ap_date.value =="") 
    		      {
    		      	  alert("Please input AR Date. ");
    		      	  document.account_payable_edit.ap_date.focus();
    		      		return false;
    		      } 
              
              if ( document.account_payable_edit.status.value =="") 
    		      {
    		      	  document.account_payable_edit.status.value=0;    		      		
    		      } 
    		     
    		      
    }
    
    return true;

}

function goUpdate(flag) 
{
      if ( chkFields(flag) ) 
	    {
	    		if ( flag == 'D' ) 
		        {
                    var paid = document.account_payable_edit.paid.value;
                    var credit = document.account_payable_edit.credit.value;
                    var answer2 = false;            
                    
                    var answer = confirm("Are you sure you want to delete this item ?");
                    if (answer)
                    {
                        if(paid == '0' || paid == '0.00' || paid == '')
                        {                          
			                    if(credit == '0' || credit == '0.00' || credit == '')
                          {                          
			                       document.account_payable_edit.action.value = 'D';	  	       
                          }
                          else
                          {
                             alert('Can not delete this AP. There was a credit made.');
                             return false;
                          }  	 	       
                        }
                        else
                        {
                            alert('Can not delete this AP. There was a payment made.');
                            return false;
                        }
                    }
		        }

	    		document.account_payable_edit.submit();
                
	    }

}




function setStatus(status)
{
   document.account_payable_edit.status.value = status;

}

function addContractors()
 { 
             
             var tbl = document.getElementById("vendor_contractor_table");
             
             try 
             { 
            
     
                 var lastRow = tbl.rows.length;        
                 var newRow = tbl.insertRow(lastRow - 1);
            
                 tbl.deleteRow(lastRow);
                 newCell = newRow.insertCell(0);             
                 newCell.innerHTML = "<?=tep_select_contractors('contractors_id',$contractors_id)?>";
              
            
                 newRow.style.backgroundColor = '#ffffff';   
                 
             } 
             catch (ex) 
             { 
                 alert(ex); //if exception occurs 
             }
              
} 

function addFabricVendors()
 { 
             
             var tbl = document.getElementById("vendor_contractor_table");
             
             try 
             { 
            
     
                 var lastRow = tbl.rows.length;        
                 var newRow = tbl.insertRow(lastRow - 1);
            
                 tbl.deleteRow(lastRow);
                 newCell = newRow.insertCell(0);             
                 newCell.innerHTML = "<?=tep_select_vendors_type('vendors_id',$vendors_id,'  ','','1')?>";
              
            
                 newRow.style.backgroundColor = '#ffffff';   
                 
             } 
             catch (ex) 
             { 
                 alert(ex); //if exception occurs 
             }
              
} 
function addTrimVendors()
 { 
             
             var tbl = document.getElementById("vendor_contractor_table");
             
             try 
             { 
            
     
                 var lastRow = tbl.rows.length;        
                 var newRow = tbl.insertRow(lastRow - 1);
            
                 tbl.deleteRow(lastRow);
                 newCell = newRow.insertCell(0);             
                 newCell.innerHTML = "<?=tep_select_vendors_type('vendors_id',$vendors_id,'','','2')?>";
              
            
                 newRow.style.backgroundColor = '#ffffff';   
                 
             } 
             catch (ex) 
             { 
                 alert(ex); //if exception occurs 
             }
              
} 
function addVendors()
 { 
             
             var tbl = document.getElementById("vendor_contractor_table");
             
             try 
             { 
            
     
                 var lastRow = tbl.rows.length;        
                 var newRow = tbl.insertRow(lastRow - 1);
            
                 tbl.deleteRow(lastRow);
                 newCell = newRow.insertCell(0);             
                 newCell.innerHTML = "<?=tep_select_vendors('vendors_id',$vendors_id)?>";
              
            
                 newRow.style.backgroundColor = '#ffffff';   
                 
             } 
             catch (ex) 
             { 
                 alert(ex); //if exception occurs 
             }
              
} 
function change_vc()
{
	var frm = document.account_payable_edit;
	var vc = frm.sel_vc.value;
	if(vc == 'C') addContractors();
	else addVendors();	
}
function typeChange()
{	
	 var frm = document.account_payable_edit;
	 var chosenoption=frm.payment_type.options[frm.payment_type.selectedIndex];
	 //alert('chosenoption='+chosenoption.value);
   
    if ( chosenoption.value == "4")
   {
	    document.getElementById("td_vendor").innerHTML = "<select id=sel_vc width=180 onchange='change_vc();'><option></option><option value='C'>Contractor</option><option value='V'>Vendor</option></select>";
	    document.getElementById("td_vendor").className += "required"; 
	    document.getElementById("td_po").className += "required"; 
      document.account_payable_edit.po_no.readOnly=false;
	
	 } 
   else if ( chosenoption.value == "2")
   {
	    document.getElementById("ref_str").innerHTML = "Receive #";
	    document.getElementById("td_vendor").className += "main"; 
	    document.getElementById("td_po").className += "main"; 
	    document.getElementById("td_vendor").innerHTML = " Vendor/Contractor ";
		  addContractors();
	 } else if (chosenoption.value == "1") {
	    document.getElementById("ref_str").innerHTML = "Rec #";
	    document.getElementById("td_vendor").className += "main"; 
	    document.getElementById("td_po").className += "main"; 
	    document.getElementById("td_vendor").innerHTML = " Vendor/Contractor ";
		  addTrimVendors();			
	 } else {
	    document.getElementById("ref_str").innerHTML = "P/L #";
      document.getElementById("td_vendor").className += "main"; 
	    document.getElementById("td_po").className += "main"; 
	    document.getElementById("td_vendor").innerHTML = " Vendor/Contractor ";
		  addFabricVendors();		
	 }
  
	
}



function ref_no_lookup(inputString)
{	
		    if(inputString.length == 0)
		    {
		    	   // Hide the suggestion box.
		    	   $('#ref_no_suggestions').hide();
		    }
		    else
		    {
             var frm = document.account_payable_edit;
	           var chosenoption=frm.payment_type.options[frm.payment_type.selectedIndex];
	   
             if ( chosenoption.value == "2")
             {
		    	    
		    	       $.post("/autoComplete/rpc_ref_no2.php", { queryString: "" + inputString + "" }, function(data)
		    	       {
		    	       	if( data.length > 0)
		    	       	{
                 
		    	       		$('#ref_no_suggestions' ).show();
		    	       		$('#ref_no_autoSuggestionsList').html(data);
		    	       	}
                 
		    	       });
		    	    } else if (chosenoption.value == "1") {
		    	    	  $.post("/autoComplete/rpc_ref_no1.php", { queryString: "" + inputString + "" }, function(data)
		    	       {
		    	       	if( data.length > 0)
		    	       	{
                 
		    	       		$('#ref_no_suggestions' ).show();
		    	       		$('#ref_no_autoSuggestionsList').html(data);
		    	       	}
                 
		    	       });
		    	    	
		    	    } else {
		    	    	 $.post("/autoComplete/rpc_ref_no.php", { queryString: "" + inputString + "" }, function(data)
		    	       {
		    	       	if( data.length > 0)
		    	       	{
                 
		    	       		$('#ref_no_suggestions' ).show();
		    	       		$('#ref_no_autoSuggestionsList').html(data);
		    	       	}
                 
		    	       });
		    	    	
		    	    }
        
		    }
  	
} // lookup

function fill_ref_no(id) {


	  document.account_payable_edit.ref_no.value = id;

		setTimeout("$('#ref_no_suggestions').hide();", 200);
    ajax_ref_check();
}

function ajax_ref_check() 
{
	    var frm = document.account_payable_edit;
	    var chosenoption=frm.payment_type.options[frm.payment_type.selectedIndex];
	    
	    
	    if ( frm.ref_no.value == "" ) return;	 
	
      if ( chosenoption.value == "2") {
            
            new Ajax.Request('ajax_updater.php',   
	          			{     
	          				method:'get',   
	          			  parameters: 'get_contract_by_ref_no=' + frm.ref_no.value,
	          				onComplete: result_get_so_by_ref_no,
	          				onFailure: function()
	          									{ 
	          										alert('Something went wrong...') 
	          									}   
	          			}
	          );
	     } else if ( chosenoption.value == "1") {
	     	   
	     	    new Ajax.Request('ajax_updater.php',   
	          			{     
	          				method:'get',   
	          			  parameters: 'get_trim_rec_by_ref_no=' + frm.ref_no.value,
	          				onComplete: result_get_so_by_ref_no,
	          				onFailure: function()
	          									{ 
	          										alert('Something went wrong...') 
	          									}   
	          			}
	          );
	     	
	     } else {
	     	    new Ajax.Request('ajax_updater.php',   
	          			{     
	          				method:'get',   
	          			  parameters: 'get_so_by_ref_no=' + frm.ref_no.value,
	          				onComplete: result_get_so_by_ref_no,
	          				onFailure: function()
	          									{ 
	          										alert('Something went wrong...') 
	          									}   
	          			}
	          );
	     	
	     }
	     	
}

function result_get_so_by_ref_no(xmlHttpRequest) 
{
      var innerText_from = xmlHttpRequest.responseText;
      var mySplitResult = innerText_from.split("`");
      var frm = document.account_payable_edit;
      
      frm.so_no.value = mySplitResult[0];
      frm.po_no.value = mySplitResult[1];
      frm.cut_no.value = mySplitResult[2];
      frm.style_no.value = mySplitResult[3];
      if(mySplitResult[4] != '')   
      {
      	frm.amount.value = parseFloat(mySplitResult[4]).toFixed(2);
      	frm.balance.value = parseFloat(mySplitResult[4]).toFixed(2);
      }
      if(mySplitResult[5] != '')   frm.ap_date.value = mySplitResult[5];
      if(mySplitResult[6] != '')   
      {
      	var chosenoption=frm.payment_type.options[frm.payment_type.selectedIndex];
      	if (chosenoption.value == "2") 
      	{  
      		frm.contractors_id.value = mySplitResult[6];
      		if(mySplitResult[7] != '') frm.pay_date.value = mySplitResult[7];
      		frm.delivery_type.value = mySplitResult[8];
      	} else frm.vendors_id.value = mySplitResult[6];
      }
      

 }

function cal_bal()
{
	  var frm = document.account_payable_edit;
	  var amount = frm.amount.value; if(amount == '') amount=0.00;
	  var credit = frm.credit.value; if(credit == '') credit=0.00;
	  var paid = frm.paid.value;     if(paid == '') paid=0.00;
	  
	  var balance = parseFloat(amount) - parseFloat(credit) - parseFloat(paid);
	  
	  frm.balance.value = parseFloat(balance).toFixed(2);
	
}
-->
</script>


<?php echo tep_draw_form('account_payable_edit', tep_href_link('account_payable.php', '', 'SSL'), 'post', 'onSubmit="return check_form(account_payable_edit);"') . tep_draw_hidden_field('action', $action); ?>
<input name="idx" type=hidden value="<?=$idx?>">
<div class="top_display">
<table width="820" border="0" cellpadding="0" style="margin-top:3px;" cellspacing="1" bgcolor="#ededed">
  <tbody>
     <tr>
       <td height="1" bgcolor=#DDDDDD width="160"  class="main" ></td>
       <td height="1" bgcolor=#DDDDDD width="250"  class="main" ></td>
       <td height="1" bgcolor=#DDDDDD width="150"  class="main" ></td>
       <td height="1" bgcolor=#DDDDDD width="250"  class="main" ></td>
  </tr>
    <tr>
    	<td align="right" valign="middle" bgcolor="#f3f2f2"  >Type&nbsp;</td>
      <td valign="middle"  style="padding-left:5px;" bgcolor="#ffffff">
      <?php 
         if($action == 'U') 
         {
      	     echo $payment_type_str;  
      	  
          	?>
          	       <input name="payment_type" type=hidden value="<?=$payment_type?>">
    
          	<?php       	  
          	         	     
      	 } else {
      ?>

      <SELECT style="WIDTH: 140px;" onChange="typeChange();" name=payment_type> 
       <OPTION value=0 <?php if ($payment_type == "0" || $payment_type == "" ) echo "selected"; ?> >Fabric Payment</OPTION>
       <OPTION value=1 <?php if ($payment_type == "1" ) echo "selected"; ?> > Trim Payment</OPTION>
       <OPTION value=2 <?php if ($payment_type == "2" ) echo "selected"; ?> >Contract Payment</OPTION>
       <OPTION value=3 <?php if ($payment_type == "3" ) echo "selected"; ?> >Sendout Payment</OPTION>
       <OPTION value=4 <?php if ($payment_type == "4" ) echo "selected"; ?> >Credit Memo</OPTION>
     </SELECT>
    <?php } ?>
      </td>
      <td align="right" valign="middle" bgcolor="#f3f2f2"  style="padding-left:5px;">Invoice #&nbsp;</td>
      <td valign="middle"  style="padding-left:5px;" bgcolor="#ffffff">
      	<input <?php if($action == 'U') //echo "readOnly"; ?> name="invoice_no" type="text" class="inputbox_center" id="invoice_no"  style="width:160px;"  
      	value="<?=$invoice_no?>" maxlength="20" /></td>
      
    </tr>    
    <tr>     
      <td align="right" valign="middle" bgcolor="#f3f2f2" id=td_vendor >Vendor/Contractor&nbsp;</td>
      <td align="left" bgcolor=#ffffff class="main" style="padding-left:5px;">          	     
          <table id='vendor_contractor_table'><tr><td>
          	<?php  if ( $action == "U" )   
          	       {
          	       	  echo $vendors_name; 
          	?>
          	       <input name="vendors_id" type=hidden value="<?=$vendors_id?>">
          	       <input name="contractors_id" type=hidden value="<?=$contractors_id?>">
          	<?php       	  
          	       }
          	       else 
          	       {           	           
          	           if( $payment_type == "0" || $payment_type == "" ) echo tep_select_vendors_type('vendors_id',$vendors_id,' style="width:132px;" ','','1');
          	           if ($payment_type == "1" ) echo tep_select_vendors_type('vendors_id',$vendors_id,'  style="width:132px;" ','','2');
          	           if ($payment_type == "2" ) echo tep_select_contractors('contractors_id',$contractors_id);
          	           if ($payment_type == "3" ) echo tep_select_contractors('contractors_id',$contractors_id);
          	           
          	       }  
          	  ?>
        
          </td></tr></table>
          </td>       
      <td align="right" valign="middle" bgcolor="#f3f2f2"  style="padding-left:5px;" id=ref_str><?=$ref_str?>&nbsp;</td>
      <td valign="middle"  style="padding-left:5px;" bgcolor="#ffffff">
      	<input <?php if($action == 'U') echo "readOnly"; ?> name="ref_no" type="text" class="inputbox_center" id="ref_no"   
      	onkeyup='ref_no_lookup(this.value);' onBlur='ajax_ref_check();' style="width:160px;"  value="<?=$ref_no?>" maxlength="20"  />
      	<div class='customers_suggestionsBox' id='ref_no_suggestions' style='display: none;'>
     <div class='customers_suggestionList' id='ref_no_autoSuggestionsList'>&nbsp;</div></div>
     	 <?php 
     	 if ($action == 'U') { 
     	 	  if($payment_type == "0" || $payment_type == "") {
     	 	?>     	 
     	 <a onClick="document.location.href='fabric_receiving_list.php?s_status=3&s_pl_no=<?=urlencode($ref_no)?><?=$extra_Url?>'"><img src='/images/buttons/apn_next_btn.png'></a>  	
      <?php  
          } else if($payment_type == "1") {
       ?>
       <a onClick="document.location.href='trim_receiving_list.php?s_status=2&s_so_no=<?=urlencode($ref_no)?><?=$extra_Url?>'"><img src='/images/buttons/apn_next_btn.png'></a>  	
       <?php  
          } else if($payment_type == "2") {
          	  if($ref_str == "Contract #") {
          	  	
          	  	if ($cut_list != '') $address="production_order_detail_by_cut";
          	  	else                 $address="production_order_detail";
       ?>
       <a onClick="document.location.href='<?=$address?>.php?idx=<?=urlencode($contract_idx)?><?=$extra_Url?>'"><img src='/images/buttons/apn_next_btn.png'></a>  	
       <?php  } else {  ?>
       <a onClick="document.location.href='receiving_list.php?s_delivery_type=3&s_received_no=<?=urlencode($ref_no)?><?=$extra_Url?>'"><img src='/images/buttons/apn_next_btn.png'></a>  	
       <?php  
            } 
          } else if ($payment_type == "3") {
          	 
          	 if($sendout_type != "FABRIC")
          	 {
          	    $s_rc = teb_query("select idx from trim_new_sendout where order_no='" . $ref_no . "'");
          	    
          	    if( $sendout_type == "Fabric Modified" )  $link = "sendout_order.php";
                else                                      $link = "sendout_order_piece.php";
  
          	 
       ?>
       <a onClick="document.location.href='<?=$link?>?idx=<?=$s_rc['idx']?><?=$extra_Url?>'"><img valign="middle" src='/images/buttons/apn_next_btn.png'></a>  	
     <?php   } 
             else {
     	          $s_rc = teb_query("select idx from fabric_sendout_order where order_no='" . $ref_no . "'");
     ?> 
         <a onClick="document.location.href='fabric_sendout_order.php?idx=<?=$s_rc['idx']?><?=$extra_Url?>'"><img valign="middle" src='/images/buttons/apn_next_btn.png'></a>  	
     
     <?php 
            }
          } 
       }?>
      	</td>
    </tr>
    <tr>
    	  <td height="27" align="right" valign="middle" bgcolor="#f3f2f2" style="padding-left:5px;">Date&nbsp;</td>
      <td height="27" valign="middle" style="padding-left:5px;" bgcolor="#ffffff">
      
      <table  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input class="inputbox_center" name="ap_date"  type="text" id="ap_date" size=10 aria-required="true" value="<?=$ap_date?>" /></td>
        <td><script language="JavaScript"> new tcal ({ 'formname': 'account_payable_edit','controlname': 'ap_date'}); </script></td>
      </tr>
    </table>
      
      </td>
    	<td align="right" valign="middle" bgcolor="#f3f2f2">Status&nbsp;</td>
      <td valign="middle" style="padding-left:5px;" bgcolor="#ffffff">
      
      <input type='radio' name='status_radio' <?php if ( $status == '0' || $status == '' ) echo " checked='checked'"; ?> onClick="setStatus('0');"  />
Open
  <input type='radio' name='status_radio' <?php if ( $status == '1') echo " checked='checked'"; ?> onClick="setStatus('1');" />
Close 
<input type=hidden name=status value="<?=$status?>">

      </td>
    </tr>
    <tr>
      <td height="6" bgcolor="#DDDDDD" colspan="4"></td>     
    </tr>
    <tr>
      <td align="right" valign="middle" bgcolor="#f3f2f2">SO #&nbsp;</td>
      <td valign="middle"  style="padding-left:5px;" bgcolor="#ffffff">
      	<input name="so_no" type="text" readOnly class="inputbox_center" id="so_no"  value="<?=$so_no?>" style="width:150px;text-align:left;" /></td>
      <td align="right" valign="middle" bgcolor="#f3f2f2" id=td_po>PO #&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" bgcolor="#ffffff">
      	<input name="po_no" type="text" readOnly class="inputbox_center" id="po_no"  value="<?=$po_no?>" style="width:200px;text-align:left;" /></td>
    </tr>
    <tr>
      <td align="right" valign="middle" bgcolor="#f3f2f2">Style #&nbsp;</td>
      <td valign="middle"  style="padding-left:5px;" bgcolor="#ffffff">
      	<input name="style_no" type="text" readOnly class="inputbox_center" id="style_no"  value="<?=$style_no?>" style="width:150px;text-align:left;" /></td>
      <td align="right" valign="middle" bgcolor="#f3f2f2">Cut #&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" bgcolor="#ffffff">
      	<input name="cut_no" type="text" readOnly class="inputbox_center" id="cut_no"  value="<?=$cut_list?>" style="width:200px;text-align:left;" /></td>
    </tr>
    <tr>
      <td align="right" valign="middle" bgcolor="#f3f2f2">Pay Date&nbsp;</td>
      <td valign="middle"  style="padding-left:5px;" bgcolor="#ffffff">
      	<input name="pay_date" type="text" readOnly class="inputbox_center" id="pay_date"  value="<?=$pay_date?>" style="width:150px;text-align:left;" /></td>
      <td align="right" valign="middle" bgcolor="#f3f2f2">Delivery Type&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" bgcolor="#ffffff">
      	<input name="delivery_type" type="text" readOnly class="inputbox_center" id="delivery_type"  value="<?=$delivery_type_str?>" style="width:200px;text-align:left;" /></td>
    </tr>
     <tr>
      <td align="right" valign="middle" bgcolor="#f3f2f2">Terms&nbsp;</td>
      <td valign="middle"  style="padding-left:5px;" bgcolor="#ffffff">
      	<input name="so_terms" type="text" readOnly class="inputbox_center" id="so_terms"  value="<?=$so_terms?>" style="width:150px;text-align:left;" /></td>
      <td align="right" valign="middle" bgcolor="#f3f2f2">&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" bgcolor="#ffffff">&nbsp;</td>
    </tr>
    <tr>
      <td height="6" bgcolor="#DDDDDD" colspan="4"></td>     
    </tr>
   
    <tr>
      <td align="right" valign="middle" bgcolor="#f3f2f2">Amount&nbsp;</td>
      <td valign="middle"  style="padding-left:5px;" bgcolor="#ffffff">
      	<input  name="amount" type="text" <?php if($action == 'U') echo "readOnly"; ?> class="inputbox_center" id="amount" onblur="cal_bal();" onkeydown='ForceNumericInput(this.value, true, false)' value="<?=$amount_str?>" style="width:90px;text-align:right;" /></td>
      <td align="right" valign="middle" bgcolor="#f3f2f2">Credit&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" bgcolor="#ffffff">
      	<input  name="credit" type="text" <?php if($action == 'U') echo "readOnly"; ?> class="inputbox_center" id="credit" onblur="cal_bal();"  onkeydown='ForceNumericInput(this.value, true, false)' value="<?=$credit_str?>" style="width:90px;text-align:right;" /></td>
    </tr>
    <tr>
      <td align="right" valign="middle" bgcolor="#f3f2f2">Balance&nbsp;</td>
      <td valign="middle"  align=left style="padding-left:5px;" bgcolor="#ffffff">
      	<input  name="balance" type="text" disabled class="inputbox_center" id="balance"   value="<?=$balance_str?>"  style="width:90px;text-align:right;" /></td>
      <td align="right" valign="middle" bgcolor="#f3f2f2">Paid&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" bgcolor="#ffffff">
      	<input  name="paid" type="text"  <?php if($action == 'U') echo "readOnly"; ?> class="inputbox_center" id="paid" onblur="cal_bal();"  onkeydown='ForceNumericInput(this.value, true, false)' value="<?=$paid_str?>" style="width:90px;text-align:right;" /></td>
    </tr>
     <tr>
      <td align="right" valign="middle" bgcolor="#f3f2f2">Due Date&nbsp;</td>
      <td height="27" valign="middle" style="padding-left:5px;" bgcolor="#ffffff">
      <table  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input class="inputbox_center" name="due_date"  type="text" id="due_date" size=10 aria-required="true" value="<?=$due_date?>" /></td>
        <td><script language="JavaScript"> new tcal ({ 'formname': 'account_payable_edit','controlname': 'due_date'}); </script></td>
      </tr>
    </table>
      </td>
      <td align="right" valign="middle" bgcolor="#f3f2f2">&nbsp;</td>
      <td  valign="middle" style="padding-left:5px;" bgcolor="#ffffff">&nbsp;</td>
    </tr>
    <tr>
      <td height="1" bgcolor="#DDDDDD" colspan="6"></td>
    </tr>
  </tbody>
</table>
</div>
<br style="line-height:10px;">  

<table width=820 border=0 cellpadding="0" cellspacing="0">
  <tr>   
   <td width=405>&nbsp;&nbsp;&nbsp;<img src="/images/media-button-video.gif">&nbsp;<strong>Remark</strong>&nbsp;</td>
   <td width=405>&nbsp;&nbsp;&nbsp;<img src="/images/media-button-video.gif">&nbsp;<strong>Office Memo</strong>&nbsp;</td>
  </tr>
</table>
<table width="820" bgcolor="#ffffff" style="padding-top:0px;" border="0" cellpadding="0" cellspacing="0" >
  <tr>  
    <td valign=top width="405"  bgcolor="#FFFFFF">&nbsp;
        <span style="padding-top:5px;padding-bottom:5px;padding-right:0px;">
          <textarea name="office_memo"  class=inputbox_center rows="6" style="height:120px; width:95%" cols="30"><?=$remarks?></textarea>
        </span>
    </td>
<?php
  $all_office_memo = "";

if( $po_no != '')
{
	$rcd = teb_query(" select office_memo from sales_orders where order_no='" . $po_no . "' ");
  $office_memo = $rcd['office_memo'];
   
  $list_query = tep_db_query(" select order_no,office_memo from fabric_order where po='" . $po_no . "' ");
  $fo_memo = "";
  while ($fo_list = tep_db_fetch_array($list_query)) 
  {
  	 if ($fo_memo != "") 
  	 {
  	 	 $fo_memo .= "\nOrder No : " . $fo_list['order_no'] . "\n" . $fo_list['office_memo'];
  	 }
  	 else 
  	 {
  	 	  if ( $fo_list['office_memo'] != '') $fo_memo = "Order No : " . $fo_list['order_no'] . "\n" . $fo_list['office_memo'];
  	 }
  }
 
  $list_query = tep_db_query("select order_no,office_memo from trim_order where po='" . $po_no . "'");
  $to_memo = "";
  while ($to_list = tep_db_fetch_array($list_query)) 
  {
  	 if ($to_memo != "") 
  	 {
  	 	 $to_memo .= "\nOrder No : " . $to_list['order_no'] . "\n" . $to_list['office_memo'];
  	 }
  	 else 
  	 {
  	 	  if ( $to_list['office_memo'] != '') $to_memo = "Order No : " . $to_list['order_no'] . "\n" . $to_list['office_memo'];
  	 }
  }
  
  $list_query = tep_db_query("select lot_no,office_memo from fabric_receiving where po='" . $po_no . "'");
  $fr_memo = "";
  while ($fr_list = tep_db_fetch_array($list_query)) 
  {
  	 if ($fr_memo != "") 
  	 {
  	 	 $fr_memo .= "\nLot No : " . $fr_list['lot_no'] . "\n" . $fr_list['office_memo'];
  	 }
  	 else 
  	 {
  	 	  if ( $fr_list['office_memo'] != '') $fr_memo = "Lot No : " . $fr_list['lot_no'] . "\n" . $fr_list['office_memo'];
  	 }
  }
  
  $list_query = tep_db_query("select cut_no,office_memo from cuts where order_no='" . $po_no . "'");
  $cut_memo = "";
  while ($cut_list = tep_db_fetch_array($list_query)) 
  {
  	 if ($cut_memo != "") 
  	 {
  	 	 $cut_memo .= "\nCut No : " . $cut_list['cut_no'] . "\n" . $cut_list['office_memo'];
  	 }
  	 else 
  	 {
  	 	  if ( $cut_list['office_memo'] != '') $cut_memo = "Cut No : " . $cut_list['cut_no'] . "\n" . $cut_list['office_memo'];
  	 }
  }
 
  $list_query = tep_db_query("select receive_no,office_memo from receive where po='" . $po_no . "'");
  $receive_memo = "";
  while ($receive_list = tep_db_fetch_array($list_query)) 
  {
  	 if ($receive_memo != "") 
  	 {
  	 	 $receive_memo .= "\nReceive No : " . $receive_list['receive_no'] . "\n" . $receive_list['office_memo'];
  	 }
  	 else 
  	 {
  	 	  if ( $receive_list['office_memo'] != '') $receive_memo = "Receive No : " . $receive_list['receive_no'] . "\n" . $receive_list['office_memo'];
  	 }
  }
  
  $list_query = tep_db_query("select order_no,office_memo from cut_order where po_no='" . $po_no . "'");
  $cut_order_memo = "";
  while ($cut_order_list = tep_db_fetch_array($list_query)) 
  {
  	 if ($cut_order_memo != "") 
  	 {
  	 	 $cut_order_memo .= "\nCutting Order No : " . $cut_order_list['order_no'] . "\n" . $cut_order_list['office_memo'];
  	 }
  	 else 
  	 {
  	 	  if ( $cut_order_list['office_memo'] != '') $cut_order_memo = "Cutting Order No : " . $cut_order_list['order_no'] . "\n" . $cut_order_list['office_memo'];
  	 }
  }
  
  $sql = "select rec_no,office_memo from trim_receiving where trim_order_no in " .
         "(select order_no from trim_order where po='" . $po_no . "')";
  $list_query = tep_db_query($sql);
  $tr_memo = "";
  while ($tr_list = tep_db_fetch_array($list_query)) 
  {
  	 if ($tr_memo != "") 
  	 {
  	 	 $tr_memo .= "\nTrim Receiving No : " . $tr_list['rec_no'] . "\n" . $tr_list['office_memo'];
  	 }
  	 else 
  	 {
  	 	  if ( $tr_list['office_memo'] != '') $tr_memo = "Trim Receiving No : " . $tr_list['rec_no'] . "\n" . $tr_list['office_memo'];
  	 }
  }
  
  $list_query = tep_db_query("select order_no,office_memo from production_order where so='" . $po_no . "'");
  $cotract_memo = "";
  while ($contract_list = tep_db_fetch_array($list_query)) 
  {
  	 if ($cotract_memo != "") 
  	 {
  	 	 $cotract_memo .= "\nContract No : " . $contract_list['order_no'] . "\n" . $contract_list['office_memo'];
  	 }
  	 else 
  	 {
  	 	  if ( $contract_list['office_memo'] != '') $cotract_memo = "Contract No : " . $contract_list['order_no'] . "\n" . $contract_list['office_memo'];
  	 }
  }

  if ($office_memo != "") $all_office_memo .= "<Production Order Memo> \n" . $office_memo . "\n\n";  
  if ($cut_order_memo != "") $all_office_memo .= "<Cutting Order Memo> \n" . $cut_order_memo . "\n\n"; 
  if ($cut_memo != "") $all_office_memo .= "<Cut Memo> \n" . $cut_memo . "\n\n"; 
  if ($fo_memo != "") $all_office_memo .= "<Fabric Order Memo> \n" . $fo_memo . "\n\n";
  if ($fr_memo != "") $all_office_memo .= "<Fabric Receiving Memo> \n" . $fr_memo . "\n\n";  
  if ($to_memo != "") $all_office_memo .= "<Trim Order Memo> \n" . $to_memo . "\n\n";
  if ($tr_memo != "") $all_office_memo .= "<Trim Receiving Memo> \n" . $tr_memo . "\n\n";
  if ($cotract_memo != "") $all_office_memo .= "<Contract Memo> \n" . $cotract_memo . "\n\n"; 
  if ($receive_memo != "") $all_office_memo .= "<Receive Memo> \n" . $receive_memo . "\n\n"; 
}
?>
   <td vAlign=top width="405"  bgcolor="#FFFFFF">&nbsp;
        <span style="padding-top:5px;padding-bottom:5px;padding-right:0px;">
          <textarea readonly class=inputbox_center rows="6" style="height:120px; width:95%" cols="30"><?=$all_office_memo?></textarea>
        </span>
    </td>
  </tr>
</table>
<br>
<?php
$successReturnUrl = "/account_payable_list.php";
?>

<table width="820"  border="0" cellpadding="0" style="padding-top:5px;padding-bottom:5px;" cellspacing="0" >
<tr><td height=12></td></tr>
<tr>
<td width="249"  align=left style="padding-left:4px;">
<input type="button" class="button-primary" style="height:20px;" tabindex=-1 onClick="document.location.href='<?=$successReturnUrl?>'" value="  Back  " name="goback" /> &nbsp;


</td>
<td align=right >


	<?php if ($action == 'I' ) { ?>
	<?php if ( $session_update_role == "on" ) { ?>
	    <input type="button" style="height:20px;"  class="button-primary" tabindex=-1  onClick="goUpdate('I');" value="  Save  " name="Insert" /> 
	<?php } ?>
  <?php } ?>
	
	<?php if ($action == 'U' ) { ?>
	<?php if ( $session_update_role == "on" ) { ?>
	    <?php if ($status == "0") { ?>
     <input type="button"  style="height:20px;"  class="button-primary" onClick="goUpdate('U');" value=" Update " name="update" />   
  <!--     
     <input type="button"   style="height:20px;" value="  Delete " name="delete" onClick="goUpdate('D');" id="delete" class="button-primary" /> //-->
      <?php } ?>
	<?php } ?>    
	<?php } ?>
	

</td>
</tr>
</table>


</form>




<?php require(DIR_WS_INCLUDES . 'body_footer.php'); ?>