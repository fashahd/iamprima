<?php 
	$kaos = "";
	$jaket = "";
	$celana = "";
	$sepatu = "";
	if($personalData){
		foreach($personalData as $personal){
			$kaos = $personal->kaos;
			$jaket = $personal->jaket;
			$celana = $personal->celana;
			$sepatu = $personal->sepatu;
		}
	}
?>	