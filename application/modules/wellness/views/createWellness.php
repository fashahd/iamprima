<div class="container">
	<!--card widgets start-->
	<div id="card-widgets">
		<div class="row">
			<div class="col s12 m12 l12">
			<form id="formWellness">
				<div id="card-widgets" class="seaction">
					<div class="row">
						<div class="col s12 m6 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Lama Tidur</p>
								</li>
								<li class="collection-item">							
									<div id="input-radio-buttons" class="section">
										<p><?php echo $lama_tidur?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="col s12 m6 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Kualitas Tidur</p>
								</li>
								<li class="collection-item">							
									<div id="input-radio-buttons" class="section">
										<p><?php echo $kualitas_tidur?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="col s12 m6 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Soreness</p>
								</li>
								<li class="collection-item">							
									<div id="input-radio-buttons" class="section">
										<p><?php echo $soreness?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="col s12 m6 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Energi</p>
								</li>
								<li class="collection-item">							
									<div id="input-radio-buttons" class="section">
										<p><?php echo $energi?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="col s12 m6 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Mood</p>
								</li>
								<li class="collection-item">							
									<div id="input-radio-buttons" class="section">
										<p><?php echo $mood?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="col s12 m6 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Stress</p>
								</li>
								<li class="collection-item">							
									<div id="input-radio-buttons" class="section">
										<p><?php echo $stress?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="col s12 m6 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Focus</p>
								</li>
								<li class="collection-item">							
									<div id="input-radio-buttons" class="section">
										<p><?php echo $mental?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="col s12 m6 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Jumlah Nutrisi</p>
								</li>
								<li class="collection-item">							
									<div id="input-radio-buttons" class="section">
										<p><?php echo $jml_nutrisi?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="col s12 m6 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Kualitas Nutrisi</p>
								</li>
								<li class="collection-item">							
									<div id="input-radio-buttons" class="section">
										<p><?php echo $kwt_nutrisi?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="col s12 m6 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Hidrasi</p>
								</li>
								<li class="collection-item">							
									<div id="input-radio-buttons" class="section">
										<p><?php echo $hydration?></p>
									</div>
								</li>
							</ul>
						</div>
						<div class="col s12 m12 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Berat Badan</p>
								</li>
								<li class="collection-item">	
									<input type="number" name="berat_badan" step="any" required/>
								</li>
							</ul>
						</div>
						<div class="col s12 m12 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Nadi Basa Per Menit</p>
								</li>
								<li class="collection-item">	
									<input type="number" name="rhr" max="99" required/>
								</li>
							</ul>
						</div>
						<div class="col s12 m12 l4">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header cyan">
									<p class="task-card-date">Cidera (Jika Tidak Ada Kosongkan)</p>
								</li>
								<li class="collection-item">	
									<input type="text" name="cidera" />
								</li>
							</ul>
						</div>
						<div class="col s12 m12 l12">
							<ul id="task-card" class="collection with-header">
								<li class="collection-header red">
									<button class="btn cyan">Simpan</button>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
