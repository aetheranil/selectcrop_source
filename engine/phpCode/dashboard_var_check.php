<?php
/*This functions is to generate the javascript that draw the dashboard
 * the function first reset all null values to zero as the dashboard crash on nulls
 * then the function build the script that mostly create the dataset 
 * at the end fucntion create javascript function to call dashboard function */
	
	// This function is for ranking 
	function check_var_Rank($topTenCrops) {

		/*Creating the script */
		$scriptDashboard= "<div id='Ranking_Dashboard'></div>";
		$scriptDashboard.= '<script>'  ;
		$scriptDashboard.= 'var DashBoard_Ranking_Data=[ ';
		$i=0;
		foreach ($topTenCrops as $cropData){
			//echo '<hr>' .$cropData[1] .'<hr>';
			if ($i == 0 ){
				$scriptDashboard.=  "{State:'" .$cropData[6] ."',freq:{CHO:" .$cropData[3]
				.", Protein:" .$cropData[4]
				.", VitaminA:" .$cropData[5]
				."}}";
			} else {
				$scriptDashboard.=  ",{State:'" .$cropData[6] ."',freq:{CHO:" .$cropData[3]
				.", Protein:" .$cropData[4]
				.", VitaminA:" .$cropData[5]
				."}}";
			}
			
			$i++;
		}

		$scriptDashboard.=  "];";
		$scriptDashboard.=  "dashboard('#Ranking_Dashboard',DashBoard_Ranking_Data);";
		$scriptDashboard.=  '</script>' ;
		// return the string that has the script
		return ($scriptDashboard);
	}
	
	// This function is for ranking Total Yield & Nutrition
	function check_var_Rank_Total_yield_Nu($topTenCrops) {
	
		/*Creating the script */
		$scriptDashboard= "<div id='Ranking_TTSR_Yield_Nu_Dashboard'></div>";
		$scriptDashboard.= '<script>'  ;
		$scriptDashboard.= 'var DashBoard_Ranking_Data_TTSR_Yield_Nu=[ ';
		$i=0;
		foreach ($topTenCrops as $cropData){
			//echo '<hr>' .$cropData[1] .'<hr>';
			if ($i == 0 ){
				$scriptDashboard.=  "{State:'" .$cropData[6] ."',freq:{TTSR:" .$cropData[1]
				.", Yield:" .$cropData[2]
				.", Nu:" .$cropData[7]
				."}}";
			} else {
				$scriptDashboard.=  ",{State:'" .$cropData[6] ."',freq:{TTSR:" .$cropData[1]
				.", Yield:" .$cropData[2]
				.", Nu:" .$cropData[7]
				."}}";
			}
				
			$i++;
		}
	
		$scriptDashboard.=  "];";
		$scriptDashboard.=  "dashboardTTSR('#Ranking_TTSR_Yield_Nu_Dashboard',DashBoard_Ranking_Data_TTSR_Yield_Nu);";
		$scriptDashboard.=  '</script>' ;
		// return the string that has the script
		return ($scriptDashboard);
	}
	
	
?>