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
		$type = "physic";
	}
	if($role_type == "CHC"){
		$type = "technical";
	}
	if($role_type == "PSY"){
		$type = "mental";
	}
	
	if($role_type == "KSC" OR $role_type == "CHC" OR $role_type == "PSY"){
		$btnCreate = '
			<a href="'.base_url().'createPerformance" class="btn btn-just-icon btn-round btn-pinterest">
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
								<div class="chip cyan white-text">Performance Profiling</div>
							</p>
						</div>
					</div>          
                </div> 
            </div>
            <!-- profile-page-sidebar-->
        </div>
		<div class="row">
            <div id="wellnessElement">
                <!-- Profile About  -->
				<?php echo $profilingData ?>
			</div>
		</div>
    </div>
</div>