<?php include("header.php"); ?>

<link href="./js/plugins/autocomplete/css/styles.css" rel="stylesheet" />
<script type="text/javascript" src="js/plugins/autocomplete/js/jquery.autocomplete.js"></script>

<script>

	$(document).ready(function(){

		$('#results').dataTable( {
			sDom: "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
			sPaginationType: "bootstrap",
			oLanguage: {
				"sLengthMenu": "_MENU_ records per page"
			},
			iDisplayLength: 50,
			aaSorting: [[0,"desc"]]
		});
	
		$('#form-add').validate({
			rules: {
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

		// autocomplete suggestion box
		$('#autocomplete').autocomplete({
			serviceUrl: './ajx.php',
			params: {cmd: '<?=ps('patient_search');?>'},
			minChars: 3,
			maxHeight: 250,
			showNoSuggestionNotice: true,
			noSuggestionNotice: "<?=LABEL_CONSULTATIONS_NO_PATIENTS;?>",
			onSelect: function (suggestion) {
				/*alert('You selected: ' + suggestion.value + ', ' + suggestion.data);*/
				contact_check(suggestion.data);
			}
		});

		<?php if(Session::get_safe('roleId')!=ROLE_DOCTOR) { ?>
		$('#autocomplete_doctor').autocomplete({
			serviceUrl: './ajx.php',
			params: {cmd: '<?=ps('doctor_search');?>'},
			minChars: 3,
			maxHeight: 250,
			showNoSuggestionNotice: true,
			noSuggestionNotice: "<?=LABEL_CONSULTATIONS_NO_DOCTORS;?>",
			onSelect: function (suggestion) {
				$("#did").val(suggestion.data);
			}
		});
		<?php } ?>

		// reset search
		$("#autocomplete").on( "keypress", function() {
			contact_check(0);
		});

		// date
		$("#dob").datepicker({ dateFormat: 'yy-mm-dd' });

	}); // end document.ready

	function contact_check(id) {
		var contact_id = parseInt(id);
		if(contact_id>0) {
			$("#div_email").hide();
			$("#div_dob").hide();
			$("#div_height").hide();
			$("#div_sex").hide();
			$("#id").val(contact_id);
		} else {
			$("#div_email").show();
			$("#div_dob").show();
			$("#div_height").show();
			$("#div_sex").show();
			$("#id").val(0);
		}
	}

</script>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1><?=LABEL_CONSULTATIONS;?></h1>

			<ul class="breadcrumb">
				<li><a href="./"><?=LABEL_MENU_HOME;?></a> <span class="divider">/</span></li>
				<li class="active"><?=LABEL_CONSULTATIONS;?></li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

            <?php if($global_perms->can($mod, "ADD")) { ?>
			<div class="span3">

				<div class="widget widget-form">
					
					<div class="widget-header">
						<h3>
							<i class="icon-plus-sign"></i>
							<?=LABEL_FORMS_ADD;?>
						</h3>

					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
					
                        <form action="./?mod=<?=ps('csu');?>" method="post" id="form-add" class="form" novalidate="novalidate">
                            <input type="hidden" name="cmd" value="<?=ps('newpat');?>">
							<input type="hidden" name="id" id="id" value="">
							<input type="hidden" name="did" id="did" value="">
                            <fieldset>
								<?php if(Session::get_safe('roleId')!=ROLE_DOCTOR) { ?>
									<div class="control-group">
										<label class="control-label" for="doctor"><?=LABEL_DOCTOR;?></label>
										<div class="controls">
											<input type="text" id="autocomplete_doctor" name="doctor" value="" class="input-large" autocomplete="off" />
											<div id="selction-ajax-doctor"></div>
										</div>
									</div>
								<?php } ?>
                                <div class="control-group">
                                    <label class="control-label" for="name"><?=LABEL_PATIENT;?></label>
                                    <div class="controls">
                                        <input type="text" id="autocomplete" name="name" value="" class="input-large" autocomplete="off" />
										<div id="selction-ajax"></div>
                                    </div>
                                </div>
                                <div id="div_email" class="control-group">
                                    <label class="control-label" for="email"><?=LABEL_EMAIL;?></label>
                                    <div class="controls">
                                        <input type="text" id="email" name="email" value="" class="input-large" autocomplete="off" />
                                    </div>
                                </div>
                                <div id="div_dob" class="control-group">
                                    <label class="control-label" for="dob"><?=LABEL_DOB;?></label>
                                    <div class="controls">
                                        <input type="text" id="dob" name="dob" placeholder="yyyy-mm-dd" value="" class="input-large" autocomplete="off" />
                                    </div>
                                </div>
                                <div id="div_height" class="control-group">
                                    <label class="control-label" for="height"><?=LABEL_HEIGHT;?></label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input type="text" class="input input-mini" id="height" name="fields[height]" autocomplete="off" value="" ><span class="add-on">cm</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="div_sex" class="control-group">
                                    <label class="control-label" for="sex"><?=LABEL_SEX;?></label>
                                    <div class="controls">
                                        <label class="radio"><input type="radio" name="fields[sex]" id="sexm" value="M" checked="checked"> <?=LABEL_MALE;?></label>
                                        <label class="radio"><input type="radio" name="fields[sex]" id="sexf" value="F"> <?=LABEL_FEMALE;?></label>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn-large" style="margin-left:0px;"><?=LABEL_FORMS_ADD;?></button>
                                </div>
                            </fieldset>
                        </form>
						
					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span -->
            <?php } ?>

            <div <?=($global_perms->can($mod, "ADD")) ? 'class="span9"' : 'class="span12"';?>>

				<div class="widget widget-table">
					
					<div class="widget-header">
						<h3>
							<i class="icon-th-list"></i>
							<?=LABEL_CONSULTATIONS;?>
						</h3>
					</div> <!-- /.widget-header -->
					
					<div class="widget-content">
						
						<table class="table table-striped table-bordered table-highlight" id="results">
							<thead>
								<tr>
									<th><?=LABEL_DATE;?></th>
									<?php if(Session::get_safe('roleId')==ROLE_PATIENT) { ?>
										<th><?=LABEL_DOCTOR;?></th>
										<th><?=LABEL_EMAIL;?></th>
									<?php } elseif(Session::get_safe('roleId')==ROLE_DOCTOR) { ?>
										<th><?=LABEL_PATIENT;?></th>
										<th><?=LABEL_EMAIL;?></th>
										<th><?=LABEL_AGE;?></th>
									<?php } else { ?>
										<th><?=LABEL_DOCTOR;?></th>
										<th><?=LABEL_PATIENT;?></th>
										<th><?=LABEL_EMAIL;?></th>
										<th><?=LABEL_AGE;?></th>
									<?php } ?>
									<th><?=LABEL_APPOINTMENTS_STATUS;?></th>
								</tr>
							</thead>
							<tbody>
								<?php if($results) { ?>
									<?php for($i=0; $i<count($results); $i++) { ?>
										<tr class="<?=($i%2==0) ? 'odd gradeX' : 'even gradeC';?>">
											<?php if(Session::get_safe('roleId')==ROLE_PATIENT) { ?>
												<?php if($results[$i]['appStatusId']==APP_ATTENDED) { ?>
													<td><a href="?mod=<?=ps('csu');?>&cmd=<?=ps('edit');?>&id=<?=ps($results[$i]['appointmentId']);?>"><?=substr($results[$i]['appDateTime'], 0, 10);?></a></td>
												<?php } else { ?>
													<td><?=substr($results[$i]['appDateTime'], 0, 10);?></td>
												<?php } ?>
											<?php } else { ?>
												<td><a href="?mod=<?=ps('csu');?>&cmd=<?=ps('edit');?>&id=<?=ps($results[$i]['appointmentId']);?>"><?=substr($results[$i]['appDateTime'], 0, 10);?></a></td>
											<?php } ?>
											<?php if(Session::get_safe('roleId')==ROLE_PATIENT) { ?>
												<td><?=$results[$i]['doctor'];?></td>
												<td><?=$results[$i]['email'];?></td>
											<?php } elseif(Session::get_safe('roleId')==ROLE_DOCTOR) { ?>
												<td><?=$results[$i]['patient'];?></td>
												<td><?=$results[$i]['email'];?></td>
												<td><?=$results[$i]['age'];?></td>
											<?php } else { ?>
												<td><?=$results[$i]['doctor'];?></td>
												<td><?=$results[$i]['patient'];?></td>
												<td><?=$results[$i]['email'];?></td>
												<td><?=$results[$i]['age'];?></td>
											<?php } ?>
											<td><span class="label label-<?=$results[$i]['class'];?>"><?=$results[$i]['appStatus'];?></span></td>
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