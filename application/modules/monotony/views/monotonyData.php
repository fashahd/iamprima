<?php		
	$now = date("Y-m-d");
	
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
							<p style="margin-top:15px"><button class="btn red" onClick="showGrafikWeek()">Load Week Chart</button></p>
						</div>
					</div>          
                </div>   
				<div class="col s12 m12 l12 center">
					<div class="col s6 m6 l6">
						<select id="monthMonotony" class="optionMid">
							<?php echo $optBulan ?>
						</select>
					</div>  
					<div class="col s6 m6 l6">
						<select id="yearMonotony" class="optionMid">
							<?php echo $optTahun ?>
						</select>
					</div>
				</div>
            </div>
		<div class="row">
           <div class="col m12 s12 l12" id="monotonyElement">
				<div class="card">
					<div class="card-content">
						<table class="striped" id="monotonyTable">
							<?php echo $monotonyData?>
						</table>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>