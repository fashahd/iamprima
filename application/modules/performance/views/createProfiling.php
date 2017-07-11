
<section id="content">
	<div class="container">
		<!--chart dashboard start-->
		<div id="chart-dashboard">
			<div class="row">
				<div class="col s12 m12 l6">
					<div id="card-widgets">
						<div class="row">
							<form class="form-horizontal" id="formProfiling">
							<div class="col s12 m12 l12">
								<ul id="task-card" class="collection with-header">
									<li class="collection-header cyan white-text">
										<label class="col-md-3 label-on-left white-text">Pilih Atlet</label>
										<div class="col-md-9">
											<?php echo $labelAtlet?>
										</div>
									</li>
									<li class="collection-item ">
										<label class="col-md-3 label-on-left">Messo</label>
										<div class="col-md-9">
											<div class="form-group label-floating is-empty">
												<label class="control-label"></label>
												<input type="number" class="form-control" name="messo" required>
											</div>
										</div>
										<label class="col-md-3 label-on-left">Komponopen Test</label>
										<div class="col-md-7 col-xs-10">
											<div class="form-group label-floating is-empty">
												<label class="control-label"></label>
												<input type="text" class="form-control" name="komponen[0]" required>
											</div>
										</div>
										<label class="col-md-3 label-on-left">Benchmark</label>
										<div class="col-md-7">
											<div class="form-group label-floating is-empty">
												<label class="control-label"></label>
												<input type="number" class="form-control" name="benchmark[0]" required>
											</div>
										</div>
										<label class="col-md-3 label-on-left">Current</label>
										<div class="col-md-7">
											<div class="form-group label-floating is-empty">
												<label class="control-label"></label>
												<input type="number" class="form-control" name="current[0]" required>
											</div>
										</div>
									</li>
									<div id="komponenRow"></div>
									<li class="collection-item ">
										<label class="col-md-3 label-on-left">Catatan</label>
										<div class="col-md-7 col-xs-10">
											<div class="form-group label-floating is-empty">
												<label class="control-label"></label>
												<textarea type="text" class="materialize-textarea" name="catatan"></textarea>
											</div>
										</div>
									</li>
									<li class="collection-item ">
										<span class="btn cyan" onClick="addKomponen()">
											<i class="mdi-content-add"></i> Add
										</span>&nbsp&nbsp
										<button class="btn red darken-4">
											<i class="mdi-content-save"></i> Simpan
										</button>
									</li>
								</ul>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>