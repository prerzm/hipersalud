<?php include("header.php"); ?>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1>Experimental</h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
				<li class="active">Experimental</li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

			<div class="span6">

				<div class="widget">
					
					<div class="widget-header">
						<h3>
							<i class="icon-plus-sign"></i>
							Pronósticos (copy)
						</h3>

					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
					
                        <?php if($partidos) { ?>
							<?php for($i=0; $i<count($partidos); $i++) { ?>
                                <?=$partidos[$i]['local_nombre']." vs. ".$partidos[$i]['visitante_nombre'];?>: <?=$partidos[$i]['fcst'];?><br>
                            <?php } ?>
                        <?php } ?>
						
					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span6 -->

			<div class="span6">

				<div class="widget widget-table">
					
					<div class="widget-header">
						<h3>
							<i class="icon-calendar"></i>
							Pronósticos
						</h3>
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">

                        <table class="table table-striped table-bordered table-highlight" id="partidosTable">
							<thead>
								<tr>
									<th>Partido</th>
									<th>Pronóstico</th>
									<th>Resultados</th>
								</tr>
							</thead>
							<tbody>
								<?php if($partidos) { ?>
									<?php for($i=0; $i<count($partidos); $i++) { ?> 
										<tr class="odd gradeX">
											<td><?=$partidos[$i]['local_nombre']." vs. ".$partidos[$i]['visitante_nombre'];?></td>
											<td><?=$partidos[$i]['fcst'];?></td>
											<td><?=$partidos[$i]['results'];?></td>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>

					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span6 -->

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->

<?php include("footer.php"); ?>