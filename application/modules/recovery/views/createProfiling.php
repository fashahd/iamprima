<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-12">
				<div class="card">
					<div class="card-content">
						<form class="form-horizontal" id="formProfiling">
							<div class="row">
								<label class="col-md-3 label-on-left">Pick Atlet</label>
								<div class="col-md-9">
									<?php echo $labelAtlet?>
								</div>
							</div>
							<div class="row">
								<label class="col-md-3 label-on-left">Messo</label>
								<div class="col-md-9">
									<div class="form-group label-floating is-empty">
										<label class="control-label"></label>
										<input type="number" class="form-control" name="messo" required>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<label class="col-md-3 label-on-left">Komponopen</label>
								<div class="col-md-7 col-xs-10">
									<div class="form-group label-floating is-empty">
										<label class="control-label"></label>
										<input type="text" class="form-control" name="komponen[0]" required>
									</div>
								</div>
								<!--<div class="col-md-2 col-xs-2"><i class="fa fa-trash fa-2x"></i></div>-->
							</div>
							<div class="row">
								<label class="col-md-3 label-on-left">Benchmark</label>
								<div class="col-md-7">
									<div class="form-group label-floating is-empty">
										<label class="control-label"></label>
										<input type="text" class="form-control" name="benchmark[0]" required>
									</div>
								</div>
							</div>
							<div class="row">
								<label class="col-md-3 label-on-left">Current</label>
								<div class="col-md-7">
									<div class="form-group label-floating is-empty">
										<label class="control-label"></label>
										<input type="text" class="form-control" name="current[0]" required>
									</div>
								</div>
							</div>
							<!--<div class="row">
								<label class="col-md-3 label-on-left">Point Type</label>
								<div class="col-md-3 col-xs-5 checkbox-radios">
									<div class="radio">
										<label>
											<input type="radio" id="ascending" name="option"> Ascending
										</label>
									</div>
								</div>
								<div class="col-md-3 col-xs-5 checkbox-radios">
									<div class="radio">
										<label>
											<input type="radio" id="descending" name="option" checked> Descending
										</label>
									</div>
								</div>
							</div>-->
							<div id="komponenRow"></div>
							<div class="row">
								<div class="col-md-3"></div>	
								<div class="col-md-9">
									<span class="btn btn-primary" onClick="addKomponen()">
										<i class="fa fa-plus-square fa-2x"></i> Add Komponopen
									</span>
								</div>								
							</div>
							<div class="row">
								<label class="col-md-3 label-on-left">Note</label>
								<div class="col-md-9">
									<div class="form-group label-floating is-empty">
										<label class="control-label"></label>
										<input type="text" class="form-control" name="catatan">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-button">
										<button type="submit" class="btn btn-block btn-rose">Save Profiling</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>