<?php include("header.php"); ?>

<script>

	$(document).ready(function(){

		$('#results').dataTable( {
			sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
			sPaginationType: "bootstrap",
			oLanguage: {
				"sLengthMenu": "_MENU_ records per page"
			},
			iDisplayLength: 50,
			aaSorting: [[5,"asc"]]
		});
	
		$('#form-edit').validate({
			rules: {
				moduloKey: {
					required: true
				},
				menuParentKey: {
					required: true
				},
				menuIcon: {
					required: true
				},
				modulo: {
					required: true
				}
			},
			focusCleanup: false,
			
			highlight: function(label) {
				$(label).closest('.control-group').removeClass ('success').addClass('error');
			},
			success: function(label) {
				label
					.text('OK!').addClass('valid')
					.closest('.control-group').addClass('success');
			},
			errorPlacement: function(error, element) {
				error.appendTo( element.parents ('.controls') );
			}
		});

		$('.form').eq (0).find ('input').eq (0).focus ();

	}); // end document.ready

</script>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1>Módulos</h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
				<li class="active">Módulos</li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

			<div class="span3">

				<div class="widget widget-form">
					
					<div class="widget-header">
						<h3>
							<i class="icon-plus-sign"></i>
							Agregar Módulo
						</h3>

					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
					
						<form action="./?mod=<?=ps($mod);?>" method="post" id="form-add" class="form" novalidate="novalidate">
							<input type="hidden" name="cmd" value="<?=ps('add');?>">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="moduloKey">Key</label>
									<div class="controls">
										<input type="text" id="moduloKey" name="moduloKey" value="" class="input-large" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="menuParentKey">Parent Key</label>
									<div class="controls">
										<input type="text" id="menuParentKey" name="menuParentKey" value="" class="input-large" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="menuParentName">Parent Name</label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">ES</span><input type="text" class="input input-small" id="menuParentName_ES" name="es[menuParentName]" autocomplete="off" value="">
										</div>
										<div class="input-prepend">
											<span class="add-on">EN</span><input type="text" class="input input-small" id="menuParentName_EN" name="en[menuParentName]" autocomplete="off" value="">
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="menuIcon">Icon</label>
									<div class="controls">
										<input type="text" id="menuIcon" name="menuIcon" value="" class="input-large" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="modulo">Nombre</label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">ES</span><input type="text" class="input input-small" id="modulo_ES" name="es[modulo]" autocomplete="off" value="">
										</div>
										<div class="input-prepend">
											<span class="add-on">EN</span><input type="text" class="input input-small" id="modulo_EN" name="en[modulo]" autocomplete="off" value="">
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="orden">Orden</label>
									<div class="controls">
										<input type="text" id="orden" name="orden" value="" class="input-large" />
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-primary btn-large" style="margin-left:0px;">Agregar</button>
								</div>
							</fieldset>
						</form>
						
					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span4 agregar -->

			<div class="span9">

				<div class="widget widget-table">
					
					<div class="widget-header">
						<h3>
							<i class="icon-th-list"></i>
							Resultados
						</h3>
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
						
						<table class="table table-striped table-bordered table-highlight" id="results">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Key</th>
									<th>Parent Key</th>
									<th>Parent Name</th>
									<th>Icon</th>
									<th>Orden</th>
								</tr>
							</thead>
							<tbody>
								<?php if($results) { ?>
									<?php for($i=0; $i<count($results); $i++) { ?>
										<tr class="<?=($i%2==0) ? 'odd gradeX' : 'even gradeC';?>">
											<td><a href="?mod=<?=ps($mod);?>&cmd=<?=ps('edit');?>&id=<?=ps($results[$i]['moduloId']);?>"><?=$results[$i]['modulo'];?></a></td>
											<td><?=$results[$i]['moduloKey'];?></td>
											<td><?=$results[$i]['menuParentKey'];?></td>
											<td><?=$results[$i]['menuParentName'];?></td>
											<td><?=$results[$i]['menuIcon'];?></td>
											<td><?=$results[$i]['orden'];?></td>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>

					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span -->

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->


<?php include("footer.php"); ?>