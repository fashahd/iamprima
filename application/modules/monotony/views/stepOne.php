<div class="contrainer">
		<div class="row">
			<div class="col l6 m12 s12">
				<div class="card">
					<div class="col l12 m12 s12">
						<div class="card-content">
							<div class="tab-content">
								<form id="stepOne">
								<div class="tab-pane active">
									<table class="table">
										<tbody>
											<td>
												<p>Pilih Tanggal</p>
												<?php echo $selectWeek?>
											</td>
										</tbody>
										<tbody>
											<?php echo $checkBoxAtlet?>
											<tr><td><button class="btn btn-info">Next</button></td></tr>
										</tbody>
									</table>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
<?php echo $this->session->userdata("msg");?>