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
	
	if($role_type == "ATL"){
		$btnCreate = '
			<a href="'.base_url().'createRecovery" class="btn btn-just-icon btn-round btn-pinterest">
				<i class="material-icons">edit</i>
			</a>';
	}else{
		$btnCreate = '';
	}
?>
<div class="content" onload="load()">
	<div class="container-fluid">
		<div class="col-md-12">
			<div class="card card-profile sea-games">
				<div class="card-avatar" style="border: 7px solid <?php echo $wellness?>">
					<a href="#">
						<img class="img" src="<?php echo $atletPic?>" />
					</a>
				</div>
				<div class="card-content">
					<h4 class="card-title"><?php echo $labelAtlet?></h4>
					<h6 class="category text-gray"><?php echo $atletGroup?> / <?php echo $atletEvent?></h6>
					<span><button class="btn btn-info btn-round">Recovery Management</button></span>
					<?php echo $btnCreate?>
				</div>
			</div>
			<div id="modalMonotony">
			</div>
			<div id="monotonyElement">
				<div class="card">
					<div class="card-content">
						<table class="table" id="monotonyTable">
							<?php 
									echo $ret.$retTotal;
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->userdata("msg");?>