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
	
		$('#form-add').validate({
			rules: {
				label: {
					required: true
				},
				name: {
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

			<h1>Campos</h1>

			<ul class="breadcrumb">
				<li><a href="./">Inicio</a> <span class="divider">/</span></li>
				<li class="active">Campos</li>
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
									<label class="control-label" for="label">Label</label>
									<div class="controls">
										<input type="text" id="label" name="label" value="" class="input-large" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="name">Key</label>
									<div class="controls">
										<input type="text" id="name" name="name" value="" class="input-large" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="type">Tipo</label>
									<div class="controls">
										<select name="type" class="input-large">
											<option value="text">text</option>
                                            <option value="textarea">textarea</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="size">Tamaño</label>
									<div class="controls">
										<select name="size" class="input-large">
                                            <option value="mini">mini</option>
                                            <option value="small">small</option>
                                            <option value="large">large</option>
                                            <option value="xlarge">xlarge</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="required">Requerido</label>
									<div class="controls">
										<label class="radio inline"><input type="radio" id="required_yes" name="required" class="radio" value="1"> Si </label> &nbsp;
                                        <label class="radio inline"><input type="radio" id="required_no" name="required" class="radio" value="0" checked> No </label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="minLen">Mínimo y Máximo</label>
									<div class="controls">
										<input type="text" id="minLen" name="minLen" class="input input-small" value="1" />&nbsp;
                                        <input type="text" id="maxLen" name="maxLen" class="input input-small" value="5" />
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-primary btn-large" style="margin-left:0px;">Agregar</button>
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
									<th>Label</th>
									<th>Key</th>
									<th>Tipo</th>
                                    <th>Tamaño</th>
                                    <th>Requerido</th>
                                    <th>Min-Max</th>
								</tr>
							</thead>
							<tbody>
								<?php if($results) { ?>
									<?php for($i=0; $i<count($results); $i++) { ?>
										<tr class="<?=($i%2==0) ? 'odd gradeX' : 'even gradeC';?>">
											<td><a href="?mod=<?=ps($mod);?>&cmd=<?=ps('edit');?>&id=<?=ps($results[$i]['fieldId']);?>"><?=$results[$i]['label'];?></a></td>
											<td><?=$results[$i]['name'];?></td>
                                            <td><?=$results[$i]['type'];?></td>
                                            <td><?=$results[$i]['size'];?></td>
                                            <td><?=((bool)$results[$i]['required']) ? "Si" : "No";?></td>
											<td><?=$results[$i]['minLen']."-".$results[$i]['maxLen'];?></td>
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