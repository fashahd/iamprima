 <?php
	 $table = "";
	 $tmpDate = 1;
	 for($i=0; $i<count($data['date']); $i++) {
		$COUNT 	= $data['date'][$i]['COUNT'];
		$DAY   	= $data['date'][$i]['DAY'];
		$DATE 	= $data['date'][$i]['DATE'];
		$count = 1;
		for($j=0; $j<$COUNT; $j++) {
			if($tmpDate<>$DATE){
				$dayof = '<h4 class="card-title">'.$DAY.', '.date("d M Y",strtotime($DATE)).'</h4>';
				$tmpDate = $DATE;
			}
			$table .= '';
			$table .= '
			<div class="card">
				<div class="card-content">
					'.$dayof.'
					<p><b>Sessi Ke '.$count.'</b></p>
					<div class="form-group label-floating">
						<label class="control-label">Session Type</label>
						<input type="text" class="form-control" name="'.str_replace("%idx%", $i, $form['session']).'" required>
					</div>
					<div class="form-group" style="margin-bottom:10px">
						<label class="control-label">Effort scale 1 to 10 - RPE</label>
						<select name="'.str_replace("%idx%", $i, $form['scale']).'" class="browser-default js--animations" required >
							<option value="0"	>0 - Not Set</option>
							<option value="1"	>1 - rest/very very easy</option>
							<option value="2"	>2 - very easy</option>
							<option value="3"	>3 - easy</option>
							<option value="4"	>4 - medium</option>
							<option value="5"	>5 - med - hard</option>
							<option value="6"	>6 - hard</option>
							<option value="7"	>7 - hard - very hard</option>
							<option value="8"	>8 - very hard</option>
							<option value="9"	>9 - very very hard</option>
							<option value="10"	>10 - extremly hard</option>
						</select>
					</div>
					<div class="form-group label-floating">
						<label class="control-label">Duration Volume in minutes</label>
						<input class="form-control" name="'.str_replace("%idx%", $i, $form['volume']).'" type="number" required>
					</div>
				</div>
			</div>
					';
			$count++;
		}
	 }
?>

<div class="container">
<!--chart dashboard start-->
	<div id="chart-dashboard">
		<div class="row">
			<div class="col s12 m12 l12">
				<div id="card-widgets">
					<div class="row">
						<div class="col m12 s12  l6">
							<div class="col s12 m12 l12">
							<form id="formMonotony">
								<ul id="task-card" class="collection with-header">
									<li class="collection-header">
										<label class="control-label">Phase</label>
										<input type="text" class="form-control" name="phase" required>
										<label class="control-label">Target</label>
										<input type="text" class="form-control" name="goal" value="1.5">
										<?php echo $table ?>
										<button class="btn red">Simpan</button>
									</li>
								</ul>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url()?>appsource/js/modules/typeHandle.js"></script>