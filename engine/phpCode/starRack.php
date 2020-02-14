<?php
// This function take number from 0 to 100 and return the correspondence color code for html 
function getColorCode( $valueMonth){

 switch (true) {
  case $valueMonth > 90:
     $colorCode='#33CC33';
   break;
  case $valueMonth > 80:
    $colorCode='#42BD2E';
    break;
  case $valueMonth > 70:
   $colorCode='#52AD29';
   break;
  case $valueMonth > 60:
   $colorCode='#619E24';
   break;
  case $valueMonth > 50:
   $colorCode='#708F1F';
   break;
  case $valueMonth > 40:
   $colorCode='#80801A';
   break;
  case $valueMonth > 30:
   $colorCode='#966912';
   break;
  case $valueMonth > 20:
   $colorCode='#AD520A';
   break;
  case $valueMonth > 10:
   $colorCode='#BD4205';
   break;
  case $valueMonth >= 0:
   $colorCode='#CC3300';
   break;
  default:
   $colorCode='#CC3300';
   break;
 }
 return($colorCode);
}
// This funcion is build to draw stars

function starRackFn( $rank){

	switch ($rank) {
		case 1:
			$stars='<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>';
			break;
		case 2:
			$stars='<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star-half-o" style="color:orange"></i>';
			break;
		case 3:
			$stars='<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>';
			break;
		case 4:
			$stars='<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star-half-o" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>';
			break;
		case 5:
			$stars='<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>';
			break;
		case 6:
			$stars='<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star-half-o" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>';
			break;
		case 7:
			$stars='<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>';
			break;
		case 8:
			$stars='<i class="fa fa-star" style="color:orange"></i>
					<i class="fa fa-star-half-o" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>
					<i class="fa fa-star-o" style="color:orange"></i>';
			break;
		case 9:
			$stars='<i class="fa fa-star" style="color:orange"></i>
				<i class="fa fa-star-o" style="color:orange"></i>
				<i class="fa fa-star-o" style="color:orange"></i>
				<i class="fa fa-star-o" style="color:orange"></i>
				<i class="fa fa-star-o" style="color:orange"></i>';
			break;
		case 10:
			$stars='<i class="fa fa-star-half-o" style="color:orange"></i>
			<i class="fa fa-star-o" style="color:orange"></i>
			<i class="fa fa-star-o" style="color:orange"></i>
			<i class="fa fa-star-o" style="color:orange"></i>
			<i class="fa fa-star-o" style="color:orange"></i>';
			break;

									
		
	}
	return($stars);
}


function starRackFnBig( $rank){

	switch ($rank) {
		case 1:
			$stars='<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>';
			break;
		case 2:
			$stars='<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star-half-o fa-lg" style="color:green"></i>';
			break;
		case 3:
			$stars='<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>';
			break;
		case 4:
			$stars='<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star-half-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>';
			break;
		case 5:
			$stars='<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>';
			break;
		case 6:
			$stars='<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star-half-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>';
			break;
		case 7:
			$stars='<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>';
			break;
		case 8:
			$stars='<i class="fa fa-star fa-lg" style="color:green"></i>
					<i class="fa fa-star-half-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>';
			break;
		case 9:
			$stars='<i class="fa fa-star fa-lg" style="color:green"></i>
				<i class="fa fa-star-o fa-lg" style="color:green"></i>
				<i class="fa fa-star-o fa-lg" style="color:green"></i>
				<i class="fa fa-star-o fa-lg" style="color:green"></i>
				<i class="fa fa-star-o fa-lg" style="color:green"></i>';
			break;
		case 10:
			$stars='<i class="fa fa-star-half-o fa-lg" style="color:green"></i>
			<i class="fa fa-star-o fa-lg" style="color:green"></i>
			<i class="fa fa-star-o fa-lg" style="color:green"></i>
			<i class="fa fa-star-o fa-lg" style="color:green"></i>
			<i class="fa fa-star-o fa-lg" style="color:green"></i>';
			break;
		case 11:
			$stars='<i class="fa fa-star-half-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>
					<i class="fa fa-star-o fa-lg" style="color:green"></i>';
			break;

				

	}
	return($stars);
}
?>
