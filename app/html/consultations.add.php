<?php include("header.php"); ?>

<script src="./js/dm.js"></script>
<script src="./js/plugins/chart/chart.js"></script>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1><?=LABEL_CONSULTATION;?> - <?=$record->get("name");?></h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
				<li><a href="./?mod=<?=ps('csu');?>"><?=LABEL_CONSULTATIONS;?></a> <span class="divider">/</span></li>
				<li class="active"><?=LABEL_CONSULTATIONS;?></li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

			<div class="<?=(count($data)>0) ? 'span4' : 'span8';?>">

				<div class="widget widget-form">
						
					<div class="widget-tabs">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#consulta"><i class="icon-user"></i> <?=LABEL_CONSULTATION;?></a>
							</li>
							<li>
								<a href="#historico"><i class="icon-th-list"></i> <?=LABEL_CONSULTATIONS_HISTORY;?> <?=($history) ? '<span class="badge badge-warning">'.count($history).'</span>' : '';?></a>
							</li>
						</ul>
						
					</div> <!-- /.widget-tabs -->
							
					<div class="widget-content">
						
						<div class="tab-content">

							<!-- Agregar Consulta -->
							<div class="tab-pane active" id="consulta">
						
								<form action="./?mod=<?=ps('csu');?>" method="post" id="form-csu" class="form" novalidate="novalidate">
								<input type="hidden" name="cmd" value="<?=ps('save');?>">
								<input type="hidden" name="id" value="<?=ps($record->id());?>">
								<input type="hidden" name="did" value="<?=ps($did);?>">

									<fieldset>
										<div class="control-group">
											<label class="control-label" for="weight"><?=LABEL_PARAMS_WEIGHT;?></label>
											<div class="controls">
												<div class="input-append">
													<input type="text" class="input input-small" id="weight" name="params[weight]" autocomplete="off" onchange="bmi(this.value, <?=$record->get('height');?>);" value=""><span class="add-on">kg</span>
												</div>
												<div id="div_imc" style="font-size:1.2em;">
													<?=LABEL_PARAMS_BMI;?>: <span id="calc_imc">-</span>&nbsp;
													<i id="icon_imc_under" class="icon-arrow-down" style="display:none;padding-top:2px;"></i>
													<i id="icon_imc_ok" class="icon-ok" style="display:none;padding-top:2px;"></i>
													<i id="icon_imc_over" class="icon-arrow-up" style="display:none;padding-top:2px;"></i>
												</div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="fc"><?=LABEL_PARAMS_HEART_RATE;?></label>
											<div class="controls">
												<div class="input-append">
													<input type="text" class="input input-small" id="fc" name="params[fc]" autocomplete="off" value=""><span class="add-on">BPM</span>
												</div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="presis"><?=LABEL_PARAMS_BLOOD_PRESSURE;?></label>
											<div class="controls">
												<div class="input-prepend input-append">
													<span class="add-on"><?=LABEL_PARAMS_SYS_SHORT;?></span><input type="text" class="input input-mini" id="presis" name="params[presis]" autocomplete="off" value=""><span class="add-on">mmHg</span>
												</div>
												<div class="input-prepend input-append">
													<span class="add-on"><?=LABEL_PARAMS_DIA_SHORT;?></span><input type="text" class="input input-mini" id="predia" name="params[predia]" autocomplete="off" value=""><span class="add-on">mmHg</span>
												</div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="glu"><?=LABEL_PARAMS_GLUCOSE;?></label>
											<div class="controls">
												<div class="input-append">
													<input type="text" class="input input-small" id="glu" name="params[glu]" autocomplete="off" value=""><span class="add-on">mg</span>
												</div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="diagnosis"><?=LABEL_CONSULTATIONS_DIAGNOSIS;?></label>
											<div class="controls">
												<textarea class="input input-xlarge" rows="3" id="diagnosis" name="fields[diagnosis]"></textarea>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="notes"><?=LABEL_CONSULTATIONS_NOTES;?></label>
											<div class="controls">
												<textarea class="input input-xlarge" rows="3" id="notes" name="fields[notes]"></textarea>
											</div>
										</div>
										<div class="form-actions">
											<button type="button" class="btn" style="margin-left:0px;" onclick="window.location='./?mod=<?=ps('csu');?>';"><i class="icon-arrow-left"></i> <?=LABEL_FORMS_BACK;?></button>
											<button type="submit" class="btn btn-primary" style="margin-left:5px;"><i class="icon-hdd"></i> <?=LABEL_FORMS_SAVE;?></button>
										</div>
									</fieldset>

								</form>
						
							</div> <!-- /.tab-pane -->
							
							<!-- Histórico de Consultas -->
							<div class="tab-pane" id="historico" style="min-height:200px;padding:15px;">
								<?php include("consultations.history.php"); ?>
							</div> <!-- /.tab-pane -->
							
						</div> <!-- /.tab-content -->
						
					</div> <!-- /widget-content -->
					
				</div> <!-- /widget -->

			</div><!-- ./span -->

			<div class="span4">

				<div class="widget">
						
					<div class="widget-header">
						<h3>
							<i class="icon-tasks"></i>
							<?=LABEL_DETAILS;?>
						</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content" style="height:200px;font-size:1.4em;">

						<h3><?=$record->get("name");?></h3>
						<strong><?=LABEL_EMAIL;?>:</strong> <?=$record->get("email");?><br>
						<strong><?=LABEL_AGE;?>:</strong> <?=$record->get("age")." (".$record->get("dob").")";?><input type="hidden" name="dob" value="<?=$record->get("dob");?>"><br>
						<strong><?=LABEL_HEIGHT;?>:</strong> <?=$record->get("height");?>cm<br>
						<strong><?=LABEL_SEX;?>:</strong> <?=($record->get("sex")=="M") ? LABEL_MALE : LABEL_FEMALE;?>
						
					</div> <!-- /widget-content -->
				
				</div> <!-- /widget -->

			</div>

			<?php if(count($app_data)>0) { ?>
			<div class="span4">

				<div class="widget">
						
					<div class="widget-header">
						<h3>
							<i class="icon-calendar"></i>
							<?=LABEL_CONSULTATIONS_ATTENDANCE;?>
						</h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">

						<div style="height:200px;">
							<canvas id="consultations-chart" style="margin-left:auto;margin-right:auto;"></canvas>
						</div>

					</div> <!-- /widget-content -->
				
				</div> <!-- /widget -->

			</div>
			<?php } ?>

			<?php if(count($data)>0) { ?>
			<div class="span8">

				<div class="widget widget-form">
						
					<div class="widget-tabs">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#weighttab"><i class="icon-tasks"></i> <?=LABEL_PARAMS_WEIGHT;?> &amp; <?=LABEL_PARAMS_BMI;?></a>
							</li>
							<li>
								<a href="#hearttab"><i class="icon-heart"></i> <?=LABEL_PARAMS_BLOOD_PRESSURE;?> &amp; <?=LABEL_PARAMS_HEART_RATE;?></a>
							</li>
						</ul>
						
					</div> <!-- /.widget-tabs -->
							
					<div class="widget-content">
						
						<div class="tab-content" style="height:230px;padding-top:30px;">

							<!-- weight & bmi -->
							<div class="tab-pane active" id="weighttab">

								<div style="width:49%;float:left;">
									<canvas id="weight-chart"></canvas>
								</div>

								<div style="width:49%;float:right;">
									<canvas id="bmi-chart"></canvas>
								</div>

							</div> <!-- /.tab-pane -->
							
							<!-- hr & bp -->
							<div class="tab-pane" id="hearttab">

								<div style="width:49%;float:left;">
									<canvas id="bp-chart"></canvas>
								</div>

								<div style="width:49%;float:right;">
									<canvas id="hr-chart"></canvas>
								</div>

							</div> <!-- /.tab-pane -->
							
						</div> <!-- /.tab-content -->
						
					</div> <!-- /widget-content -->
					
				</div> <!-- /widget -->

			</div><!-- ./span4 detalles -->
			<?php } ?>

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->

<script>

	<?php include("inc.graphs.js.php"); ?>

</script>

<?php include("footer.php"); ?>