<?php
	$heading = ['Firstname', 'LastName', 'Profile pic'];
	$names = ['vamshi', 'kolanu', 'srividya', 'majeti', 'sridivya', 'majeti', 'paladi', 'dinesh', 'saibabu', 'majeti'];
	$images = ['http://i.dailymail.co.uk/i/pix/2016/03/22/13/32738A6E00000578-3504412-image-a-6_1458654517341.jpg', 'http://www.gettyimages.pt/gi-resources/images/Homepage/Hero/PT/PT_hero_42_153645159.jpg', 'https://cdn.theatlantic.com/assets/media/img/photo/2015/11/images-from-the-2016-sony-world-pho/s01_130921474920553591/main_900.jpg?1448476701', 'http://i.telegraph.co.uk/multimedia/archive/03598/lightning-10_3598416k.jpg', 'https://www.nasa.gov/sites/default/files/styles/image_card_4x3_ratio/public/thumbnails/image/av_oa6_l2.jpg?itok=aJqW6Vob'];

	echo '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">';

	echo 
	'<div class="col-md-4 col-md-offset-4">
	<table class="table">
		<thead><tr>';
			for ($i=0; $i<count($heading); $i++) {
				echo '<th>' . $heading[$i].'</th>';
			}  
		echo '</tr></thead>
		<tbody>';
			for ($j=0,$i=0; $j<count($names),$i<count($images); $j=$j+2,$i++){
				echo '<tr><th>' . $names[$j] .'</th>';
				echo '<th>' . $names[$j+1] .'</th>';
				echo '<th>' . '<img src="'.$images[$i] .'", width="50px", height="50px">' .'</th>';
				echo '<th> <button class="btn btn-primary" onclick="alert(`Hi`);"> Submit</button></th></tr>';
			}  		
		echo '</tbody></table></div>';
?>