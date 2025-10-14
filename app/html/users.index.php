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
			aaSorting: [[0,"asc"]]
		});
	
		$('#form-edit').validate({
			rules: {
				name: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				password: {
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

			<h1>Usuarios</h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
				<li class="active">Usuarios</li>
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
							Agregar
						</h3>

					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
					
						<form action="./?mod=<?=ps($mod);?>" method="post" id="form-add" class="form" novalidate="novalidate">
							<input type="hidden" name="cmd" value="<?=ps('add');?>">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="name">Nombre</label>
									<div class="controls">
										<input type="text" id="name" name="name" value="" class="input-large" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="email">Email</label>
									<div class="controls">
										<input type="text" id="email" name="email" value="" class="input-large" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="rolId">Rol</label>
									<div class="controls">
										<select name="rolId" class="input-large">
											<?=Html::select_options($roles, "rolId", "rol", 1);?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="password">Contraseña</label>
									<div class="controls">
										<input type="password" id="password" name="password" value="" class="input-large" />
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-primary btn-large" style="margin-left:0px;">Guardar</button>
								</div>
							</fieldset>
						</form>
						
					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span5 agregar -->

			<div class="span8">

				<div class="widget widget-table">
					
					<div class="widget-header">
						<h3>
							<i class="icon-th-list"></i>
							Usuarios
						</h3>
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
						
						<table class="table table-striped table-bordered table-highlight" id="results">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Email</th>
									<th>Rol</th>
								</tr>
							</thead>
							<tbody>
								<?php if($results) { ?>
									<?php for($i=0; $i<count($results); $i++) { ?>
										<tr class="<?=($i%2==0) ? 'odd gradeX' : 'even gradeC';?>">
											<td><a href="?mod=<?=ps($mod);?>&cmd=<?=ps('edit');?>&id=<?=ps($results[$i]['userId']);?>"><?=$results[$i]['name'];?></a></td>
											<td><?=$results[$i]['email'];?></td>
											<td><?=$results[$i]['rol'];?></td>
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