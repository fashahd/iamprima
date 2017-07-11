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

	$ret = "";
	if($pmcList){
		$tmpDate = 1;
		$ret .= '<table class="striped">';
		foreach($pmcList as $key){
			$detail_id			= $key->monotonyDetailID;
			$detail_date		= $key->monotonyDetailDate;
			$detailSession		= $key->monotonyDetailSession;
			$detailVolume		= $key->monotonyVolume;
			$warmup 			= $key->warmup;
			$core 				= $key->core;
			$coolDown 			= $key->cooldown;
			$volcore 			= $key->volcore;
			$volwarm 			= $key->volwarm;
			$volcool 			= $key->volcool;

			if($role_type == "KSC" OR $role_type == "CHC"){
				$warmup = $this->ModelPMC->optionActualWarmUp($warmup);
				$core 	= $this->ModelPMC->optionActualCore($core);
				$coolDown 	= $this->ModelPMC->optionActualCoolDown($coolDown);
				$volcore = '
					<div class="input-field col s12">
						<input placeholder="60" id="volcore" name="volcore[]" type="number" class="validate" value="'.$volcore.'">
						<label for="first_name">Volume Core</label>
					</div>
				';
				$volwarm = '
					<div class="input-field col s12">
						<input placeholder="60" id="volwarm" name="volwarm[]" type="number" class="validate" value="'.$volwarm.'">
						<label for="first_name">Volume Warm Up</label>
					</div>
				';
				$volcool = '
					<div class="input-field col s12">
						<input placeholder="60" id="volcool" name="volcool[]" type="number" class="validate" value="'.$volcool.'">
						<label for="first_name">Volume Cool Down</label>
					</div>
				';
			}
			
			$daySet = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum`at","Sabtu");
			
			$day	= date("w", strtotime($detail_date));
			
			$hari		= $daySet[$day];
			$tangal	= date("d M Y", strtotime($detail_date));
			
			if($tmpDate<>$detail_date){
				$ret .='
					<thead><tr><th colspan="3" class="indigo white-text"><h6><b>'.$hari.', '.$tangal.'</b></h6></th></tr></thead>
				';
				$tmpDate = $detail_date;
			}
			
			$ret .='<tbody>'
					 . '<input type="hidden" name="detail_id[]" value="'.$detail_id.'"/>'
					 . '<input type="hidden" name="detailSession[]" value="'.$detailSession.'"/>'
					 . '<tr><th class="red white-text" colspan="2"><h6><b>Session Name : '.$detailSession.'</b></h6></th>'
					 . '<th class="red white-text">Volume : '.$detailVolume.' Min</th></tr>'
					 . '<tr><td><b>Warm Up : </b></td><td>'.$warmup.'</td><td>'.$volwarm.'</td></tr>'
					 . '<tr><td><b>Core : </b></td><td>'.$core.'</td><td>'.$volcore.'</td></tr>'
					 . '<tr><td><b>Cool Down : </b></td><td>'.$coolDown.'</td><td>'.$volcool.'</td></tr>'
					 . '</tbody>';
				
		}
			$ret .="</table>";
	}else{
		$ret .="Data Tidak Ditemukan";
	};
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
							<p style="margin-top:15px"><button class="btn red">PMC Data</button></p>
						</div>
					</div>        
                </div>  
            </div>
            <!-- profile-page-sidebar-->
        </div>
		<div class="row">
           <div class="col m12 s12 l12" id="DataMonotony">
		   		<form id="formPMC">
				<table class="bordered striped responsive-table">
					<?php echo $ret ?>
					<?php if($role_type == "CHC" OR $role_type == "KSC"){ ?>
					<tr>
						<td>
							<button class="btn cyan" onClick="savePMC()">Simpan</button>
						</td>
					</tr>
					<?php } ?>
					<tr><td id="loading"></td></tr>
				</table>
				</form>
			</div>
		</div>
    </div>
</div>