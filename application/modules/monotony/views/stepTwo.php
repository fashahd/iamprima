<div class="container">
<!--chart dashboard start-->
	<div id="chart-dashboard">
		<div class="row">
			<div class="col s12 m12 l12">
				<div id="card-widgets">
					<div class="row">
						<div class="col m12 s12  l6">
							<div class="col s12 m12 l12">
								<ul id="task-card" class="collection with-header">
									<li class="collection-header cyan white-text">
										<p class="white-text">Tentukan Jumlah Sesi Per Hari</p>
									</li>
									<li class="collection-item ">
										<form method="POST" action="<?php echo base_url()?>stepThree">
											<?php echo $ret;?>
											<button class="btn btn-info">Next</button>
										</form>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url()?>appsource/js/modules/typeHandle.js"></script>