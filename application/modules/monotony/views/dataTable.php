<?php		
	$now = date("Y-m-d");
	
	$dayList = array(
		'Sun' => 'Minggu',
		'Mon' => 'Senin',
		'Tue' => 'Selasa',
		'Wed' => 'Rabu',
		'Thu' => 'Kamis',
		'Fri' => 'Jumat',
		'Sat' => 'Sabtu'
	);
	
	if($atletWellnessDate == $now AND $atletWellnessValue	!= 0){	
		if($atletWellnessValue <= 59){
			$wellness = "#FF0000";
		}elseif($atletWellnessValue >= 60 && $atletWellnessValue <= 69) {
			$wellness = "#FF9D00";
		}elseif($atletWellnessValue >= 70 && $atletWellnessValue <= 79){
			$wellness = "#E1FF00";
		}elseif($atletWellnessValue >= 80 && $atletWellnessValue <= 89){
			$wellness = "#9BFF77";
		}else{
			$wellness = "#00CE25";
		}		
	}else{
		$wellness = "#607D8B";
	}
	
	if($role_type == "KSC"){
		$btnCreate = '
			<a href="'.base_url().'stepOne" class="btn btn-just-icon btn-round btn-pinterest">
				<i class="material-icons">edit</i>
			</a>';
	}else{
		$btnCreate = '';
	}
	$data 		= "";
	
	if($table){
		$tmpdata = 0;
		$count = count($table);
		$Details = $cell["value"];
		foreach($table as $num => $row){
			$mdldate[$num] 		= $row->monotonyDetailDate;
			$sessType[$num] 	= $row->monotonyDetailSession;
			$detIntensity[$num]	= $row->monotonyIntensity;
			$detVolume[$num]	= $row->monotonyVolume;
			$day[$num] 			= date("D",strtotime($mdldate[$num]));
			$hari				= $day[$num];
			$dayHari			= $dayList[$hari];
			$totalVolume[$num] = $detIntensity[$num]*$detVolume[$num];
			
			if( isset($Details[$mdldate[$num]]) ) {
				$TrainingLoad = '<td rowspan="'.$Details[$mdldate[$num]]['count'].'">
				  '.$Details[$mdldate[$num]]['trainingday'].'</td>';
				unset($Details[$mdldate[$num]]);
			}else {
				$TrainingLoad = "";
			}
			
			$RIGHT = ($num==0)?'[TrainingMonotoryLeft][TrainingMonotoryRight][TrainingStrainLeft][TrainingStrainRight]':'';
			$data .="<tr><td>$dayHari - ".($num+1)."</td><td>".date("d M Y", strtotime($mdldate[$num]))."</td>"
				   ."<td>$sessType[$num]</td><td class='text-center'>$detIntensity[$num]</td>"
				   ."<td class='text-center'>$detVolume[$num]</td>"
				   ."<td class='text-center'>$totalVolume[$num]</td>".$TrainingLoad."".$RIGHT;
		}
		$TrainingMonotory['left']  = '<td class="text-center" rowspan="'.$count.'">'.$variation.'</td>';
	    $TrainingMonotory['right'] = '<td class="text-center" rowspan="'.$count.'">'.$target.'</td>';
		$TrainingStrain['left']    = '<td class="text-center" rowspan="'.$count.'">'.$desc.'</td>';
	    $TrainingStrain['right']   = '<td class="text-center" rowspan="'.$count.'">'.$load.'</td>';
		$data = str_replace("[TrainingMonotoryLeft]",    $TrainingMonotory['left']  , $data);
		$data = str_replace("[TrainingMonotoryRight]",   $TrainingMonotory['right'] , $data);
		$data = str_replace("[TrainingStrainLeft]",      $TrainingStrain['left']    , $data);
		$data = str_replace("[TrainingStrainRight]",     $TrainingStrain['right']   , $data);
		
		$data .= '<tr><td colspan="3" rowspan="3"></td>'
				.'<td rowspan="3"></td>'
				.'<td class="text-center">Weakly TL</td>'
				.'<td class="text-center" style="font-weight: bold;">'.$total.'</td>'
				.'<td colspan="5" class="text-center">Last Week : '.number_format($last, 2, ".", "").'</td>
			 </tr>
			 <tr>
				<td class="text-center">Av daily load</td>
				<td class="text-center" style="font-weight: bold;">'.$average.'</td>
				<td colspan="2" rowspan="2" class="numeric text-center" style="font-weight: bold;"></td>
			 </tr>
			 <tr>
				<td class="numeric text-center">SD</td>
				<td class="numeric text-center" style="font-weight: bold;">'.$stdev.'</td>
			 </tr>
		';
	}
	
	if($role_type == "KSC"){
		$btnCreate = '
			<a href="'.base_url().'stepOne" class="btn btn-just-icon btn-round btn-pinterest">
				<i class="material-icons">edit</i>
			</a>';
	}else{
		$btnCreate = '';
	}
?>
<div class="container">
    <div class="section">
        <!-- profile-page-content -->
        <div class="row">
            <!-- profile-page-sidebar-->
            <div class="col s12 m12 l12">
                <!-- Profile About  -->
				<div class="card sea-games center" style="height:350px">
					<div id="imgArea" class="card-avatar">
						<img style="border: solid 5px <?php echo $wellness ?>" src="<?php echo $atletPic?>" alt="profile image" class="circle z-depth-2 responsive-img activator">
					</div>
					<div class="card-content center">
						<div class="col s12 m12 l12">
							<p style="margin-bottom:15px"><?php echo $labelAtlet?></p>
							<p><div class="chip cyan white-text" <?php echo $labelGroup?>><?php echo $atletGroup ?> / <?php echo $atletEvent ?></div></p>
							<p style="margin-top:15px">
								<button onClick="chartSessionMonotony('<?php echo $monotonyID?>')" class="btn red white-text">Chart Per Sessi</button>
								<button onClick="chartDayMonotony('<?php echo $monotonyID?>')" class="btn red white-text">Chart Per Hari</button>
							</p>
						</div>
					</div>          
                </div> 
            </div>
            <!-- profile-page-sidebar-->
        </div>
		<div class="row">
           <div class="col m12 s12 l12" id="DataMonotony">
				<table class="bordered striped responsive-table">
					<thead>
						<tr>
							<td class="cyan white-text">Hari</td>
							<td class="cyan white-text">TGL</td>
							<td class="cyan white-text">SESSION</td>
							<td class="cyan white-text">INTENSITAS</td>
							<td class="cyan white-text">VOLUME</td>
							<td class="cyan white-text" colspan="2">TRAINING LOAD</td>
							<td class="cyan white-text" colspan="2">TRAINING MONOTORY</td>
							<td class="cyan white-text" colspan="2">TRAINING STRAIN</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="red white-text text-center" width="10%">Sesi latihan</td>
							<td class="red white-text text-center" width="10%">Week starting</td>
							<td class="red white-text text-center" width="20%">Session Type</td>
							<td class="red white-text text-center">Effort scale 1 to 10 - RPE</td>
							<td class="red white-text text-center">Duration session workout in minutes</td>
							<td class="red white-text text-center" colspan="2">Intensity X volume</td>
							<td class="red white-text text-center" >Daily Variation</td>
							<td class="red white-text text-center" >Target 1.5</td>
							<td class="red white-text text-center" >Total Impact on Athlete</td>
							<td class="red white-text text-center" >Load X Monotony</td>
						</tr>
						<?php echo $data ?>
					</tbody>
				</table>
			</div>
		</div>
    </div>
</div>