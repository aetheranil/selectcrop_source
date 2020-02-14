<?php 
////////////////////////////////////////////////////////////////////////
// function to get all table values for a crop + ref,notes,images,Geo
////////////////////////////////////////////////////////////////////////
function getTableData($conn, $table_name,$cropID, $table_arr) {
	if ($conn->connect_error) {
		die('Could not connect: ' .$conn->connect_error);
		echo "Please contact you System administrator";
	}
	// create select statement for the sent table
	$sqlSelect='select * from ' .$table_name .' where cropID="' .$cropID .'";';
	//echo '<br>' .$sqlSelect .'<pre>';
	//print_r($table_arr); 
	//echo '</pre><br>';
	// run the select statement
	$res_sel = $conn->query($sqlSelect);
	$count=0;
	// get the result from the query
	$row_res=$res_sel->fetch_assoc();
	// create a result multidimension array
	$ref_arr_res1=Array();
	// loop in the table columns sent to function one by one
	foreach ( $table_arr as $col){
		// create statment to get the references attached to this value
		$sql_ref1='select r.reference from ' .$table_name .' a , Info_' .$table_name .' i , KBS_Parameter_References r ' ;
		$sql_ref2='where a.cropID="' .$cropID .'" and a.cropID=i.cropID and i.' .$col .'=r.info_id;';
		$sql_ref= $sql_ref1 .$sql_ref2;
		// create statment to get the Notes attached to this value
		$sql_note1='select n.note from ' .$table_name .' a , Info_' .$table_name .' i , KBS_Parameter_Notes n ' ;
		$sql_note2='where a.cropID="' .$cropID .'" and a.cropID=i.cropID and i.' .$col .'=n.info_id;';
		$sql_note= $sql_note1 .$sql_note2;
		// create statment to get the Images attached to this value
		$sql_img1='select m.path from ' .$table_name .' a , Info_' .$table_name .' i , KBS_Parameter_Images m ' ;
		$sql_img2='where a.cropID="' .$cropID .'" and a.cropID=i.cropID and i.' .$col .'=m.info_id;';
		$sql_img= $sql_img1 .$sql_img2;
		// create statment to get the Geo attached to this value
		$sql_geo1='select g.country_id from ' .$table_name .' a , Info_' .$table_name .' i , KBS_Parameter_Geo g ' ;
		$sql_geo2='where a.cropID="' .$cropID .'" and a.cropID=i.cropID and i.' .$col .'=g.info_id;';
		$sql_geo= $sql_geo1 .$sql_geo2;
		// run the select
		$res_ref = $conn->query($sql_ref);
		$res_note = $conn->query($sql_note);
		$res_img = $conn->query($sql_img);
		$res_geo = $conn->query($sql_geo);
		// free the array that will get the reference as it is in a loop
		unset($ref_arr);
		$ref_arr = array();
		unset($note_arr);
		$note_arr = array();
		unset($img_arr);
		$img_arr = array();
		unset($geo_arr);
		$geo_arr = array();
		// fill the array with references
		while ($row_ref=$res_ref->fetch_assoc()){
			array_push($ref_arr,$row_ref["reference"]);
		}
		// fill the array with notes
		while ($row_note=$res_note->fetch_assoc()){
			array_push($note_arr,$row_note["note"]);
		}
		// fill the array with Images
		while ($row_img=$res_img->fetch_assoc()){
			array_push($img_arr,$row_img["path"]);
		}
		// fill the array with Geo
		while ($row_geo=$res_geo->fetch_assoc()){
			array_push($geo_arr,$row_geo["country_id"]);
		}
		// add the reference array and the value of the correspondance columns to array of result with array name of the column name
		$arr_res[$col]=Array ($row_res[$col],$ref_arr,$note_arr,$img_arr,$geo_arr);

		// Getting ref

		$count++;
	}
	// draw table header
	//echo '<br><br><h2>' .$table_name .'</h2> <br><br>';
	// display the table
	//html_show_array($arr_res);
	//echo '<hr>';
	// return the resulted array
	return $arr_res;
}
////////////////////////////////////////////////////////////////////////
?>