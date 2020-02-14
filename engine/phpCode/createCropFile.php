
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Crop creation</title>

</head>
<body>

<?php
// database info





// this function is used to create crop in the database in all tables and fill the info ID of the shadow tables.
	function createCrop($cropName , $cropSciName , $cropFamName, $cropVarName, $cropLandName,$cropPlantName,$others){
		include("phpCode/connParm.php");
		include("phpCode/tablesCols.php");
		//////////////////////////////////////////////////////////////////////////
		// Database connection
		//////////////////////////////////////////////////////////////////////////
		$conn = new mysqli($host, $user, $password, $schema , $port);
		if ($conn->connect_error) {
			die('Could not connect: ' .$conn->connect_error);
			echo "Please contact you System administrator";
		}
		//**********************************************************************
		
		$sqlInstKBS_General= "INSERT INTO KBS_General (name, sci_name, fam_name, variety, kbs_gen_others, landrace, plant) 
				VALUES ('" .$cropName ."', '" .$cropSciName ."',
						 '" .$cropFamName ."', '" .$cropVarName ."', '" .$others ."',
						 		 '" .$cropLandName ."' ,'" .$cropPlantName ."');";
		$eXsqlInstKBS_General = $conn->query($sqlInstKBS_General);
		if (!$eXsqlInstKBS_General) {
			die('Could not query:' . mysql_error());
		} else {
			$KBS_General_flag_success="1";		
		}
		
		// Display Alert Message of the successfully creation
		if ($KBS_General_flag_success){
			echo '<script language="javascript">';
			echo 'alert("New Crop had been successfully created")';
			echo '</script>';
		} else {
			echo '<script language="javascript">';
			echo 'alert("Something went wrong! contact you administration")';
			echo '</script>';
		}
		// get the crop ID
		$sql_crop_ID="select cropID from KBS_General;";
		$eXsql_crop_ID = $conn->query($sql_crop_ID);
		// loop till you get the last ID
		while($row = $eXsql_crop_ID->fetch_assoc())
		{
			$cropIDInsert=$row["cropID"];
		}
		// get info ID 
		$sql_infoID="SELECT info_ID FROM Info_ID;";
		$eXsql_infoID = $conn->query($sql_infoID);
		// loop till you get the last ID
		while($row = $eXsql_infoID->fetch_assoc())
		{
			$infoID=$row["info_ID"];
		}
		
		$errorCheckTableData=1;
		// fill all data tables with the cropID
		foreach ($KBS_All_Tables as $table_data_name){
			if ($table_data_name != 'KBS_General') {
				$sqlTableDataInsert= "INSERT INTO " .$table_data_name ." (cropID) VALUES ('" .$cropIDInsert ."');";
				$eXsqlTableDataInsert = $conn->query($sqlTableDataInsert);
				if (!$eXsqlTableDataInsert) {
					$errorCheckTableData=0;
				}
			}
			// fill all the infoID shadow tables with cropID and infoIDs
			$table_data_nameArr=$table_data_name .'_col';
			$table_Info_name= 'Info_' .$table_data_name;
			$sqlTableInfoInsert= "INSERT INTO " .$table_Info_name ."( cropID " ;
			foreach ($$table_data_nameArr as $field_name){
				if($field_name != 'cropID')
					$sqlTableInfoInsert.= "," .$field_name ;
			}
			$sqlTableInfoInsert.= ") VALUES ('" .$cropIDInsert ."' ";
			foreach ($$table_data_nameArr as $field_name){
				if($field_name != 'cropID')
					$sqlTableInfoInsert.= ",'" .$infoID++ ."'";
			}			
			$sqlTableInfoInsert.=");";
			$eXsqlTableInfoInsert = $conn->query($sqlTableInfoInsert);
			if (!$eXsqlTableInfoInsert) {
				$errorCheckTableData=0;
			}
			//echo $sqlTableInfoInsert;
		//	echo '<pre>' .print_r($$table_data_name) .' </pre>';
		}
		// Update Info ID
		$updateInfoID= "UPDATE Info_ID SET info_ID='" .$infoID ."';";
		$eXupdateInfoID = $conn->query($updateInfoID);
		if (!$eXupdateInfoID) {
			$errorCheckTableData=0;
		}

		//echo '<pre>' .$cropIDInsert ; print_r($KBS_All_Tables) ; echo '</pre>';
		
	}

?>

</body>
</html>
