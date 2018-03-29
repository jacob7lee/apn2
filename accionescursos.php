<?php

  $campos = array('CursoID','Inicio','Terminacion','Ganancias');
	$PersonaID = sanitizeMySQL( $_GET["PersonaID"] );

	if($_GET["action"] == "list")
	{


		//Get record count
		//$result = queryMysql("SELECT COUNT(*) AS RecordCount FROM Personas WHERE Nombre LIKE '$term%' OR ApellidoPaterno LIKE '$term%' OR ApellidoMaterno LIKE '$term%';");
		//$row = mysql_fetch_array($result);
		//$recordCount = $row['RecordCount'];

		$jtSorting = sanitizeMySQL( $_GET["jtSorting"] );
		// $jtStartIndex = sanitizeMySQL( $_GET["jtStartIndex"] );
		// $jtPageSize = sanitizeMySQL( $_GET["jtPageSize"] );

		//Get records from database
		$result = queryMysql("SELECT CT.CursoTomadoID, C.CursoID, CT.Inicio, CT.Terminacion, Ganancias  FROM Personas AS P INNER JOIN CursosTomados AS CT INNER JOIN Cursos AS C ON P.PersonaID = CT.PersonaID AND CT.CursoID = C.CursoID WHERE P.PersonaID = '$PersonaID' AND P.EmpresaID = $empresaID ORDER BY $jtSorting;");
		//$result = queryMysql("SELECT P.PersonaID, Ingreso, Nombre, ApellidoPaterno, ApellidoMaterno, Sexo, Nacimiento, Pu.PuestoID FROM Personas AS P INNER JOIN PuestosAsignados AS PA INNER JOIN Puestos AS Pu ON P.PersonaID = PA.PersonaID AND PA.PuestoID = Pu.PuestoID WHERE Nombre LIKE '$term%' OR ApellidoPaterno LIKE '$term%' OR ApellidoMaterno LIKE '$term%' ORDER BY $jtSorting LIMIT $jtStartIndex,$jtPageSize ;");
		//SELECT P.PersonaID, Ingreso, Nombre, ApellidoPaterno, ApellidoMaterno, Sexo, Nacimiento, Puesto FROM Personas AS P INNER JOIN PuestosAsignados AS PA INNER JOIN Puestos AS Pu ON P.PersonaID = PA.PersonaID AND PA.PuestoID = Pu.PuestoID

		//Add all records to an array
		$rows = array();
		while($row = mysql_fetch_array($result))
		{
			$rows[] = $row;
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		//$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);

	} 
	else if($_GET["action"] == "create")
	{
		foreach( $campos as $campo )
		{
			$$campo = sanitizeMySQL($_POST[$campo]);
		}

		queryMysql("INSERT INTO CursosTomados (CursoID,PersonaID,Inicio,Terminacion,Ganancias) VALUES ('$CursoID','$PersonaID','$Inicio','$Terminacion','$Ganancias')");

		//Get last inserted record (to return to jTable)
		$result = queryMysql("SELECT CursoTomadoID, C.CursoID, CT.Inicio, CT.Terminacion, Ganancias  FROM Personas AS P INNER JOIN CursosTomados AS CT INNER JOIN Cursos AS C ON P.PersonaID = CT.PersonaID AND CT.CursoID = C.CursoID WHERE CursoTomadoID = LAST_INSERT_ID() AND P.EmpresaID = $empresaID;");

		$row = mysql_fetch_array($result);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	} 
	else if($_GET["action"] == "update")
	{
		foreach( $campos as $campo )
		{
			$$campo = sanitizeMySQL($_POST[$campo]);
		}

		$CursoTomadoID = sanitizeMySQL($_POST['CursoTomadoID']);
		//Update record in database
		$result = queryMysql("UPDATE CursosTomados SET CursoID = '$CursoID', Inicio = '$Inicio', Terminacion = '$Terminacion', Ganancias = '$Ganancias' WHERE CursoTomadoID = $CursoTomadoID;");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	} 
	else if($_GET["action"] == "delete")
	{
		$CursoTomadoID = sanitizeMySQL($_POST['CursoTomadoID']);
		//Delete from database
		$result = mysql_query("DELETE FROM CursosTomados WHERE CursoTomadoID = $CursoTomadoID;");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}