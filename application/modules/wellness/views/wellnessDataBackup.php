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

		$btnCreate = '';
	}else{
		if($role_type == "ATL" AND $atletID == $username){
			$btnCreate = '
				<a href="'.base_url().'newWellness" class="btn btn-just-icon btn-round btn-pinterest">
					<i class="material-icons">edit</i>
				</a>';
		}else{
			$btnCreate = '';
		}
		$wellness = "#607D8B";
	}
?>
<div class="container">
    <div class="section">
        <!-- profile-page-content -->
        <div class="row">
            <!-- profile-page-sidebar-->
            <div class="col s12 m12 l12">
                <!-- Profile About  -->
                <div class="card sea-games">
                    <figure class="card-profile-image center">
						<div id="imgArea" class="card-avatar">
							<img style="border: solid 5px <?php echo $wellness ?>" src="<?php echo $atletPic?>" alt="profile image" class="circle z-depth-2 responsive-img activator">
						</div>
						<div class="card-content center">
							<div class="col s12 m12 l12">
								<p><?php echo $atletGroup ?> / <?php echo $atletEvent ?></p>
								<p><button class="btn red" onClick="wellnessGrafik()">Wellness Chart</button></p>
							</div>
						</div>  
                    </figure>           
                </div>   
				<div class="col s12 m12 l12 center">
					<div class="col s12 m12 l12">
						<?php echo $labelAtlet.$labelGroup ?>
					</div>
					<div class="col s6 m6 l6">
						<select id="month" class="optionMid">
							<?php echo $optBulan ?>
						</select>
					</div>  
					<div class="col s6 m6 l6">
						<select id="year" class="optionMid">
							<?php echo $optTahun ?>
						</select>
					</div>
				</div>
            </div>
            <!-- profile-page-sidebar-->
        </div>
		<div class="row">
            <div class="col s12 m12 l12" id="wellnessElement">
                <!-- Profile About  -->
				<?php echo $wellnessData ?>
			</div> 
            <div class="col s12 m12 l12" id="wellnessElement2">
			</div>
		</div>
    </div>
</div>