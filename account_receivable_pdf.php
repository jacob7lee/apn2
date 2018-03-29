<?php

  require('includes/application_top.php');
  header("Cache-Control: no-cache");
  header("Pragma: no-cache");

 	ob_start();
 	include( DIR_FS_CATALOG . '/account_receivable_print.php');
	$content = ob_get_clean();

	require_once( DIR_FS_CATALOG . '/html2pdf_v4.03/html2pdf.class.php');

	try
	{

		$html2pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15');
		//$html2pdf->setModeDebug();

		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('account_receivable_' . $customers_id . '.pdf');

	}
	catch(HTML2PDF_exception $e) { echo $e; }



	