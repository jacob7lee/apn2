<?php
require('includes/application_top.php');
require_once 'excel/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Apnlink.com")
							 ->setLastModifiedBy("Jacob Lee")
							 ->setTitle("Account Receivable Report file")
							 ->setSubject("Account Receivable Report file")
							 ->setDescription("Generating Excel Report.")
							 ->setKeywords("Account Receivable Report file")
							 ->setCategory("Account Receivable Report file");


// Create a first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setSize( 16 );
$objPHPExcel->getActiveSheet()->setCellValue('D1', "Account Receivable Report [" . date('m_d_Y') . "] ");

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);

$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_DARKGREEN ) );
$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->setCellValue('A3', "CUSTOMER")
                              ->setCellValue('B3', "DATE")
                              ->setCellValue('C3', "TYPE")
                              ->setCellValue('D3', "REF #")
                              ->setCellValue('E3', "AMOUNT")
                              ->setCellValue('F3', "PAID")
                              ->setCellValue('G3', "CREDIT")
                              ->setCellValue('H3', "BALANCE")
                              ->setCellValue('I3', "DUE DATE")
                              ->setCellValue('J3', "DIVISION")
                              ->setCellValue('K3', "STORE")
                              ->setCellValue('L3', "STATUS");


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
      
	   
	       $list_query = tep_db_query($sql);
         $total_order=0;$total_rec=0;$total_bal=0;$total_amt=0;
	       $rows = 4;
	       
	       
         $sum_amt=0;
         $sum_paid=0;
         $sum_credit=0;
         $sum_bal=0;
         
      
	       while ($list = tep_db_fetch_array($list_query) )                     
         {     
              
              $company_name = ""; $store_name = "";
                            
              $rc = teb_query(" select customers_name1 from customers where customers_id='" . (int) $list['customers_id'] . "' ");
              $customers_name = $rc['customers_name1'];
              $rcd2 = teb_query("select name,name2 from company where company_id = '" . (int) $list['company_id'] . "'");
              $company_name = $rcd2['name'];
              if( trim($rcd2['name2']) != '' ) $company_name .= " " . $rcd2['name2'];
              
              $rcd3 = teb_query("select name,name2 from stores where idx = '" . (int) $list['store_id'] . "'");
              $store_name = $rcd3['name'];
              if( trim($rcd3['name2']) != '' ) $store_name .= " " . $rcd3['name2'];
               
              $typ = "Invoice";
              
              if ( $list['typ'] == '1' || $list['typ'] == '')  $typ = "Invoice";
              if ( $list['typ'] == '2'  )  $typ = "Credit Memo";
              if ( $list['typ'] == '3'  )  $typ = "Debit Memo";
                   
              
              $status = "Active";
              if ( $list['status'] == '1' ) $status = "Close";
              
              $ar_date            = tep_convert_date_kr($list['ar_date']);  if ( $ar_date == "00/00/0000") $ar_date = "";
              $due_date            = tep_convert_date_kr($list['due_date']);  if ( $due_date == "00/00/0000") $due_date = "";
              
              $rcu = teb_query("select sum(used) as t_used, sum(paid) as t_paid from ar_usages where from_ref_no='" . $list['ref_no'] . "'");
              $paid = $list['paid'] + $rcu['t_paid'];
              $credit = $list['credit'] - $rcu['t_used'];
         
              $balance = $list['amt'] - $paid - $credit;
              
              $sum_amt   += $list['amt'];
              $sum_paid  += $paid;
              $sum_credit  += $credit;
              $sum_bal   += $balance;
              
	            
	            $objPHPExcel->getActiveSheet()->getStyle('A'. $rows )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	            $objPHPExcel->getActiveSheet()->setCellValue('A' . $rows, $customers_name);
	            $objPHPExcel->getActiveSheet()->getStyle('B'. $rows . ':D'. $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	            $objPHPExcel->getActiveSheet()->setCellValue('B' . $rows, $ar_date);
	            $objPHPExcel->getActiveSheet()->setCellValue('C' . $rows, $typ);
	            $objPHPExcel->getActiveSheet()->setCellValue('D' . $rows, strtoupper($list['ref_no']));
	            $objPHPExcel->getActiveSheet()->getStyle('E'. $rows . ':H'. $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	            $objPHPExcel->getActiveSheet()->getStyle('E'. $rows . ':H' . $rows)->getNumberFormat()->setFormatCode("#,##0.00");
	            $objPHPExcel->getActiveSheet()->setCellValue('E' . $rows, $list['amt']);
	            $objPHPExcel->getActiveSheet()->setCellValue('F' . $rows, $paid);
	            $objPHPExcel->getActiveSheet()->setCellValue('G' . $rows, $credit);
	            $objPHPExcel->getActiveSheet()->setCellValue('H' . $rows, $balance);	            
	            $objPHPExcel->getActiveSheet()->getStyle('I'. $rows . ':K'. $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $objPHPExcel->getActiveSheet()->setCellValue('I' . $rows, $due_date);                      
              $objPHPExcel->getActiveSheet()->setCellValue('J' . $rows, $company_name);              
	            $objPHPExcel->getActiveSheet()->setCellValue('K' . $rows, $store_name);
	            $objPHPExcel->getActiveSheet()->getStyle('L'. $rows )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	            $objPHPExcel->getActiveSheet()->setCellValue('L' . $rows, $status);
	           
                 
             
             $rows++;  
         }
    
        
         
         $rows++;
         
         $objPHPExcel->getActiveSheet()->getStyle('A'. $rows . ':K' . $rows)->getFont()->setSize( 13 );
         $objPHPExcel->getActiveSheet()->getStyle('A'. $rows . ':K' . $rows)->getFont()->setBold(true);
         $objPHPExcel->getActiveSheet()->getStyle('A'. $rows . ':K' . $rows)->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_DARKGREEN ) );
         $objPHPExcel->getActiveSheet()->setCellValue('D' . $rows, "Grand Total : ");
         $objPHPExcel->getActiveSheet()->getStyle('E'. $rows . ':H'. $rows)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	       $objPHPExcel->getActiveSheet()->getStyle('E'. $rows . ':H' . $rows)->getNumberFormat()->setFormatCode("#,##0.00");
         
         $objPHPExcel->getActiveSheet()->setCellValue('E' . $rows, $sum_amt);
         $objPHPExcel->getActiveSheet()->setCellValue('F' . $rows, $sum_paid);
         $objPHPExcel->getActiveSheet()->setCellValue('G' . $rows, $sum_credit);
         $objPHPExcel->getActiveSheet()->setCellValue('H' . $rows, $sum_bal);
         
      
	        
   $objPHPExcel->setActiveSheetIndex(0);
   // Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Account Receivable Report.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;      
         
         ?>  
