    <style>

ul li{
  padding-left:20px;
}

    </style>
<?php
function showInfoPopup($arrayIn) {
	$count=0;
	$countGeo=0;
	$countImg=0;
	$countNote=0;
	foreach ($arrayIn as $nest1key => $nest1){
		if ($nest1[0]){
			echo '<br>' .$nest1key .' = ' .$nest1[0] ;
			if($nest1[1] || $nest1[2] || $nest1[3] || $nest1[3]){
				if ($nest1[1]){
					echo '<a class="popup-with-zoom-anim nav-link" href="#ref-small-dialog' .$count .'">
							 <i class="fa fa-book"></i>
							</a>
							<div id="ref-small-dialog' .$count .'" class="zoom-anim-dialog mfp-hide small-dialog">
							<h3> References </h3>
							<ul>';
					foreach ($nest1[1] as $nest2 ){
						echo '<li> <a href="' .$nest2 .'">' .$nest2 .'</a></li>';
					}
					echo '</ul></div>';
				}
				if ($nest1[2]){
					echo '<a class="popup-with-zoom-anim nav-link" href="#note-small-dialog' .$countNote .'">
							<i class="fa fa-sticky-note"></i>
							</a>
							<div id="note-small-dialog' .$countNote .'" class="zoom-anim-dialog mfp-hide small-dialog">
							<h3> Notes </h3>
							<ul>';					
					foreach ($nest1[2] as $nest2 ){
						echo '<br><li> ' .$nest2 .'</li>';
					}
					echo '</ul></div>';
				}
				if ($nest1[3]){
					echo '<a class="popup-with-zoom-anim nav-link" href="#img-small-dialog' .$countImg .'">
							<i class="fa  fa-picture-o"></i>
							</a>
							<div id="img-small-dialog' .$countImg .'" class="zoom-anim-dialog mfp-hide small-dialog">
							<h3> Images </h3>
							';
					//echo '<div class="zoom-gallery">';
					/*Width/height ratio of thumbnail and the main image must match to avoid glitches.
					If ratios are different, you may add CSS3 opacity transition to the main image to make the change less noticable.
					*/
					foreach ($nest1[3] as $nest2 ){
						//echo '<img src="../../DBimagesLink/'  .'" alt="Smiley face" width="42" height="42" border="5">';
						//echo '<a href="../../DBimagesLink/' .$nest2  .'" data-source="../../DBimagesLink/'
							//	.$nest2 .'" title="Into The Blue" style="width:193px;height:125px;">';
						echo '<br><img src="../../DBimagesLink/' .$nest2 .'" style="width:500px;" align="middle">';
						//echo '</a>';
					}
					echo '<br></div>';
				}
				if ($nest1[4]){
					echo '<a class="popup-with-zoom-anim nav-link" href="#geo-small-dialog' .$countGeo .'">
							<i class="fa fa-map-marker"></i>
							</a>
							<div id="geo-small-dialog' .$countGeo .'" class="zoom-anim-dialog mfp-hide small-dialog">
							<h3> Geo </h3>
							';
					foreach ($nest1[4] as $nest2 ){
							$sentStrings.=$nest2 .'X';
						}								
					echo '<object type="text/html" data="map/geoInfoMap.php?geo='  
								.$sentStrings .'&name=' .$nest1key .'&var=' .$arrayIn[cropID][0]  
							 .'" width="800px" height="600px" style="overflow:auto; ridge gray"></object>';
					echo '</div>';
				}
			}
		}
		$count++;
		$countGeo++;
		$countImg++;
		$countNote++;
	}
	echo '<br><br><hr>';
	echo '</font>';
}
?>