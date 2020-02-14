<?php 
////////////////////////////////////////////////////////////////////////
// Including functions and parameters
////////////////////////////////////////////////////////////////////////
// for printing mutlidimensional array
include("show_array.php");
// tables arch
include("tablesCols.php");
// database info
include("connParm.php");
// function to get table info
include("getTableData.php");
// function to convert array to list
include("showInfoPopup.php");
//**********************************************************************
function getTableData($first_time,$crop_name){
	////////////////////////////////////////////////////////////////////////
	// Check for the first login
	////////////////////////////////////////////////////////////////////////
		if (isset($_POST['flag_first'])){
			$first_time=$_POST['flag_first'];
		} else {
			$first_time=0;
		}
	//**********************************************************************
		
	//////////////////////////////////////////////////////////////////////////
	// Database connection
	//////////////////////////////////////////////////////////////////////////
	$conn = new mysqli($host, $user, $password, $schema , $port);
	if ($conn->connect_error) {
		die('Could not connect: ' .$conn->connect_error);
		echo "Please contact you System administrator";
	}
	//**********************************************************************
	
	//////////////////////////////////////////////////////////////////////////
	// Getting all crops name and build a combo box
	//////////////////////////////////////////////////////////////////////////
	$sql_crop_name="select name from KBS_General;";
	$result_crop_name = $conn->query($sql_crop_name);
	$combobox="<select name='crop_name' onChange='cropSel.submit()'>";
	$combobox .= '<option value="" SELECTED>Choose a Crop';
	//echo '<option value="newcrop" >Insert New Crop';
	while($row = $result_crop_name->fetch_assoc())
	{
		$combobox .=  "<option value = '".$row["name"]."'>".$row["name"]."</option>";
	}
	$combobox .= "</select>";
	
	// Keeping the combo box selection
	if ( $first_time == '1'){
		if (isset($_POST['crop_name'])){
			$crop_name = $_POST['crop_name'];
	
			
		}
	}
	// Setting the flag after the first choice.
	//**********************************************************************
	
	//////////////////////////////////////////////////////////////////////////
	// Getting the CropID
	//////////////////////////////////////////////////////////////////////////
	if ($crop_name){
		$sql_cropID='select cropID from KBS_General where name="' .$crop_name .'";';
		$result_cropID = $conn->query($sql_cropID);
		$row=$result_cropID->fetch_assoc();
		$cropID=$row["cropID"];
		
		// Getting all tables informations
		$KBS_General_Data[]=getTableData($conn,"KBS_General",$cropID,$KBS_General_col);
		$KBS_General_Usage_Data[]=getTableData($conn,"KBS_General_Usage",$cropID,$KBS_General_Usage_col);
		$KBS_General_Type_Data[]=getTableData($conn,"KBS_Type",$cropID,$KBS_Type_col);
		$KBS_Growth_Habit_Data[]=getTableData($conn,"KBS_Growth_Habit",$cropID,$KBS_Growth_Habit_col);	
		$KBS_Growth_Cycle_Data[]=getTableData($conn,"KBS_Growth_Cycle",$cropID,$KBS_Growth_Cycle_col);
		$KBS_Agronomic_Practices_Data[]=getTableData($conn,"KBS_Agronomic_Practices",$cropID,$KBS_Agronomic_Practices_col);
		$KBS_Fertiliser_Data[]=getTableData($conn,"KBS_Fertiliser",$cropID,$KBS_Fertiliser_col);
		$KBS_Pathology_Data[]=getTableData($conn,"KBS_Pathology",$cropID,$KBS_Pathology_col);
		$KBS_Agroecology_Data[]=getTableData($conn,"KBS_Agroecology",$cropID,$KBS_Agroecology_col);
		$KBS_Resist_Tolerance_Data[]=getTableData($conn,"KBS_Resist_Tolerance",$cropID,$KBS_Resist_Tolerance_col);
		$KBS_Cropping_System_Data[]=getTableData($conn,"KBS_Cropping_System",$cropID,$KBS_Cropping_System_col);
		$KBS_Season_Data[]=getTableData($conn,"KBS_Season",$cropID,$KBS_Season_col);
		$KBS_Food_Parts_Used_Data[]=getTableData($conn,"KBS_Food_Parts_Used",$cropID,$KBS_Food_Parts_Used_col);		
		$KBS_Nutrient_Composition_Data[]=getTableData($conn,"KBS_Nutrient_Composition",$cropID,$KBS_Nutrient_Composition_col);
		$KBS_Nutrient_Minerals_Data[]=getTableData($conn,"KBS_Nutrient_Minerals",$cropID,$KBS_Nutrient_Minerals_col);
		$KBS_Nutrient_VitaminsData[]=getTableData($conn,"KBS_Nutrient_Vitamins",$cropID,$KBS_Nutrient_Vitamins_col);
		//$KBS_Optimal_Handling_Fresh_produce_Data[]=getTableData($conn,"KBS_Optimal_Handling_Fresh_produce",$cropID,$KBS_Optimal_Handling_Fresh_produce_col);
		$KBS_Cooling_Method_Data[]=getTableData($conn,"KBS_Cooling_Method",$cropID,$KBS_Cooling_Method_col);
		$KBS_Food_Preparation_Data[]=getTableData($conn,"KBS_Food_Preparation",$cropID,$KBS_Food_Preparation_col);
		$KBS_Stroage_Form_Data[]=getTableData($conn,"KBS_Stroage_Form",$cropID,$KBS_Stroage_Form_col);
		$KBS_Storage_Life_Data[]=getTableData($conn,"KBS_Storage_Life",$cropID,$KBS_Storage_Life_col);
		$KBS_Biomass_Uses_Data[]=getTableData($conn,"KBS_Biomass_Uses",$cropID,$KBS_Biomass_Uses_col);
		$KBS_Biomass_Parts_Used_Data[]=getTableData($conn,"KBS_Biomass_Parts_Used",$cropID,$KBS_Biomass_Parts_Used_col);
		$KBS_Biomass_Proximate_Data[]=getTableData($conn,"KBS_Biomass_Proximate",$cropID,$KBS_Biomass_Proximate_col);
		$KBS_Biomass_Ulitmate_Data[]=getTableData($conn,"KBS_Biomass_Ulitmate",$cropID,$KBS_Biomass_Ulitmate_col);
		$KBS_Biomass_Thermogravimetric_Data[]=getTableData($conn,"KBS_Biomass_Thermogravimetric",$cropID,$KBS_Biomass_Thermogravimetric_col);
		$KBS_Biomass_Output_Data[]=getTableData($conn,"KBS_Biomass_Output",$cropID,$KBS_Biomass_Output_col);
		$KBS_Subsidy_Data[]=getTableData($conn,"KBS_Subsidy",$cropID,$KBS_Subsidy_col);
		$KBS_Price_Data[]=getTableData($conn,"KBS_Price",$cropID,$KBS_Price_col);
		$KBS_Water_Source_Data[]=getTableData($conn,"KBS_Water_Source",$cropID,$KBS_Water_Source_col);
		$KBS_Infrastructure_Data[]=getTableData($conn,"KBS_Infrastructure",$cropID,$KBS_Infrastructure_col);
		$KBS_Market_Data[]=getTableData($conn,"KBS_Market",$cropID,$KBS_Market_col);
		$KBS_Human_Data[]=getTableData($conn,"KBS_Human",$cropID,$KBS_Human_col);
	}
	return ($combobox);
}
	
	
	// Close DB connection  
	//$conn->close();
?>