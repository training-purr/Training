<?php
	$staff_details = array(
		array(
			'Nick',
			'ABCDEFGH12345678',
			'KFC',
			'Coffee',
			'Mac'
		),
		array(
			'Jon',
			'12345678ABCDEFGH',
			'Sushi',
			'IceTea',
			'PC'
		)
	);
	
	foreach($staff_details as $staff){
		if($staff[0] == $_GET["name"]){
			if($staff[1] == $_GET["code"]){
				echo "
					<p><strong>Name:</strong><font color='white'> {$staff[0]}</font></p>
					<p><strong>Fav. food:</strong><font color='white'> {$staff[2]}</font></p>
					<p><strong>Fav. drink:</strong><font color='white'> {$staff[3]}</font></p>
					<p><strong>Mac or PC:</strong><font color='white'> {$staff[4]}</font></p>
				";
			}else{
				echo "ERROR: Secret code was incorrect";
			}
		}
	}
?>