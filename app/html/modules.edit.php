<?php include("header.php"); ?>

<script>

	$(document).ready(function(){

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

			<h1>Editar Módulo <?=$record->get("modulo");?></h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps($mod);?>">Módulos</a> <span class="divider">/</span></li>
				<li class="active"><?=$record->get("modulo");?></li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

			<div class="span4">

				<div class="widget widget-form">
					
					<div class="widget-header">
						<h3>
							<i class="icon-plus-sign"></i>
							Editar
						</h3>

					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
					
						<form action="./?mod=<?=ps($mod);?>" method="post" id="form-add" class="form" novalidate="novalidate">
							<input type="hidden" name="cmd" value="<?=ps('update');?>">
							<input type="hidden" name="id" value="<?=ps($id);?>">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="moduloKey">Key</label>
									<div class="controls">
										<input type="text" id="moduloKey" name="moduloKey" value="<?=$record->get("moduloKey");?>" class="input" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="menuParentKey">Parent Key</label>
									<div class="controls">
										<input type="text" id="menuParentKey" name="menuParentKey" value="<?=$record->get("menuParentKey");?>" class="input" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="menuParentName">Parent Name</label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">ES</span><input type="text" class="input input-small" id="menuParentName_ES" name="es[menuParentName]" autocomplete="off" value="<?=$lang_es['menuParentName'];?>">
										</div>
										<div class="input-prepend">
											<span class="add-on">EN</span><input type="text" class="input input-small" id="menuParentName_EN" name="en[menuParentName]" autocomplete="off" value="<?=$lang_en['menuParentName'];?>">
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="menuIcon">Icon</label>
									<div class="controls">
										<input type="text" id="menuIcon" name="menuIcon" value="<?=$record->get("menuIcon");?>" class="input" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="modulo">Nombre</label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">ES</span><input type="text" class="input input-small" id="modulo_ES" name="es[modulo]" autocomplete="off" value="<?=$lang_es['modulo'];?>">
										</div>
										<div class="input-prepend">
											<span class="add-on">EN</span><input type="text" class="input input-small" id="modulo_EN" name="en[modulo]" autocomplete="off" value="<?=$lang_en['modulo'];?>">
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="orden">Orden</label>
									<div class="controls">
										<input type="text" id="orden" name="orden" value="<?=$record->get("orden");?>" class="input" />
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-primary btn-large" style="margin-left:0px;">Guardar</button>
									<button type="button" class="btn btn-large" onclick="window.location='./?mod=<?=ps($mod);?>';">Cancelar</button>
								</div>
							</fieldset>
						</form>
						
					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span4 editar -->

			<div class="span4">

				<div class="widget widget-form">
					
					<div class="widget-header">
						<h3>
							<i class="icon-plus-sign"></i>
							Agregar Permiso
						</h3>

					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
					
						<form action="./?mod=<?=ps($mod);?>" method="post" id="form-add" class="form" novalidate="novalidate">
							<input type="hidden" name="cmd" value="<?=ps('addperm');?>">
                            <input type="hidden" name="id" value="<?=ps($id);?>">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="permisoKey">Key</label>
									<div class="controls">
										<input type="text" id="permisoKey" name="permisoKey" value="" class="input-large" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="permiso">Permiso</label>
									<div class="controls">
										<input type="text" id="permiso" name="permiso" value="" class="input-large" />
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

			<div class="span4">

				<div class="widget widget-table">
					
					<div class="widget-header">
						<h3>
							<i class="icon-th-list"></i>
							Permisos
						</h3>
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
						
						<table class="table table-striped table-bordered table-highlight">
							<thead>
								<tr>
									<th>Permiso</th>
									<th>Key</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php if($results) { ?>
									<?php for($i=0; $i<count($results); $i++) { ?>
										<tr class="<?=($i%2==0) ? 'odd gradeX' : 'even gradeC';?>">
											<td><a href="?mod=<?=ps($mod);?>&cmd=<?=ps('editperm');?>&id=<?=ps($id);?>&pid=<?=ps($results[$i]['permisoId']);?>"><?=$results[$i]['permiso'];?></a></td>
											<td><?=$results[$i]['permisoKey'];?></td>
											<td><a href="?mod=<?=ps($mod);?>&cmd=<?=ps('delperm');?>&id=<?=ps($id);?>&pid=<?=ps($results[$i]['permisoId']);?>" onclick="return confirm('Está seguro que desea eliminar este registro?');"><img src="img/silk/cross.png" /></a></td>
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