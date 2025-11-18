<?php include("header.php"); ?>

<link href="./js/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
<link href="./css/pages/calendar.css" rel="stylesheet">

<link href="./js/plugins/autocomplete/css/styles.css" rel="stylesheet" />
<script type="text/javascript" src="js/plugins/autocomplete/js/jquery.autocomplete.js"></script>

<script src="./js/plugins/fullcalendar/fullcalendar.min.js"></script>

<script>

	$(function () {
		
		$('#calendar-holder').fullCalendar({
			defaultView: "month",
			header: {
				left: 'prev, next',
				center: 'title',
				right: 'month,basicWeek,basicDay,'
			},
			<?php if($global_language->get()=="es") { ?>
			monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre"],
			monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
			dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
			dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
			buttonText: {
				month: "Mes",
				week: "Semana",
				day: "Día"
			},
			<?php } ?>
			events: './ajx.php?cmd=<?=ps("calevents");?>&id=<?=ps($doctor_id);?>'
		});

		// autocomplete suggestion box
		$('#autocomplete_patient').autocomplete({
			serviceUrl: './ajx.php',
			params: {cmd: '<?=ps('patient_search');?>'},
			minChars: 3,
			maxHeight: 250,
			showNoSuggestionNotice: true,
			noSuggestionNotice: "<?=LABEL_CONSULTATIONS_NO_PATIENTS;?>",
			onSelect: function (suggestion) {
				contact_check(suggestion.data);
			}
		});

		// autocomplete suggestion box
		$('#autocomplete_doctor').autocomplete({
			serviceUrl: './ajx.php',
			params: {cmd: '<?=ps('doctor_search');?>'},
			minChars: 3,
			maxHeight: 250,
			showNoSuggestionNotice: true,
			noSuggestionNotice: "<?=LABEL_CONSULTATIONS_NO_DOCTORS;?>",
			onSelect: function (suggestion) {
				window.location='./?mod=<?=ps('apo');?>&date=<?=ps($date);?>&seldoctor=' + suggestion.data;
			}
		});

		// reset search
		$("#autocomplete_patient").on( "keypress", function() {
			contact_check(0);
		});

		// date-picker
		$("#date").datepicker({ dateFormat: 'yy-mm-dd' });
		
	});

	function contact_check(id) {
		var contact_id = parseInt(id);
		if(contact_id>0) {
			$("#div_email").hide();
			$("#div_dob").hide();
			$("#div_height").hide();
			$("#div_sex").hide();
			$("#modal_pid").val(contact_id);
		} else {
			$("#div_email").show();
			$("#div_dob").show();
			$("#div_height").show();
			$("#div_sex").show();
			$("#modal_pid").val(0);
		}
	}

	// modal add appointment
	function modalAppAdd(timeval) {
		$("#modal_time").val(timeval);
		$("#appDateTimeLabel").html('<?=$date;?> <?=LABEL_APPOINTMENTS_ADD_AT;?> '+timeval);
	}

	// modal edit appointment
	function modalAppNotes(id, name, notes) {
		$("#appNotesId").val(id);
		$("#appNotesNotes").val(notes);
		$("#appNotesName").html(name);
	}

</script>

<div class="container">
	
	<div id="page-title" class="clearfix">

		<h1><?=(Session::get_safe('roleId')==ROLE_DOCTOR) ? LABEL_APPOINTMENTS : LABEL_APPOINTMENTS." - ".$doctor->get('name') ;?></h1>

		<ul class="breadcrumb">
			<li><a href="./"><?=LABEL_MENU_HOME;?></a> <span class="divider">/</span></li>
			<li class="active"><?=LABEL_APPOINTMENTS;?></li>
		</ul>

	</div> <!-- /.page-title -->

	<div class="row">
		
		<div class="span12">

			<!--- alert messagess ---->
			<?php $global_alerts->display(); ?>

		</div> <!-- /.span -->

	</div> <!-- /.row -->

	<div class="row">

		<div class="span7">

			<div class="widget widget-table">

				<div class="widget-content">

					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th colspan="2" style="text-align:center;font-weight:bold;font-size:1.2em;">
									<a class="btn btn-mini" href="./?mod=<?=ps('apo');?>&date=<?=ps($prev);?>&did=<?=ps($doctor_id);?>">&nbsp;<i class="icon-arrow-left"></i></a>
									<span style="margin-left:20px;margin-right:20px;"><?=DateLang::long($date);?></span>
									<a class="btn btn-mini" href="./?mod=<?=ps('apo');?>&date=<?=ps($next);?>&did=<?=ps($doctor_id);?>">&nbsp;<i class="icon-arrow-right"></i></a>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($intervals as $i) { ?>
								<?php if($i['blocked']==false) { ?>
									<tr>
										<td style="width:50px;text-align:center;"><?=$i['time'];?></td>
										<td>
											<?php if(is_array($i['apps'])) { ?>
												<?php foreach($i['apps'] as $app) { ?>
													<div class="appBox">
														<div class="appBox_name App_<?=$app['appStatusId'];?>"><?=$app['name'];?></div>
														<?php if($app['notes']!="") { ?>
															<div class="appBox_notes"><?=$app['notes'];?></div>
														<?php } ?>
														<div class="appBox_controls">
															<?php if($app['appStatusId']==APP_SCHEDULED) { ?>
																<a class="btn btn-success btn-mini" href="./?mod=<?=ps('csu');?>&cmd=<?=ps('edit');?>&id=<?=ps($app['appointmentId']);?>" style="margin-left:0px;" title="<?=LABEL_CONSULTATION;?>">&nbsp;<i class="icon-heart"></i></a>
																<a class="btn btn-danger btn-mini" href="./?mod=<?=ps('apo');?>&cmd=<?=ps('missed');?>&date=<?=ps($date);?>&did=<?=ps($doctor_id);?>&id=<?=ps($app['appointmentId']);?>" style="margin-left:5px;" title="<?=LABEL_CONSULTATIONS_MISSED;?>" onclick="return confirm('<?=LABEL_CONSULTATIONS_MISSED_CONFIRM;?>?');">&nbsp;<i class="icon-thumbs-down"></i></a>
																<a href="#modalAppNotes" class="btn btn-info btn-mini" style="margin-left:5px;" title="<?=LABEL_CONSULTATIONS_NOTES;?>" data-toggle="modal" onclick="modalAppNotes(<?=(int)$app['appointmentId'];?>, '<?=$app['name'];?>', '<?=$app['notes'];?>');">&nbsp;<i class="icon-edit"></i></a>
															<?php } elseif($app['appStatusId']==APP_ATTENDED) { ?>
																<a class="btn btn-success btn-mini" href="./?mod=<?=ps('csu');?>&cmd=<?=ps('edit');?>&id=<?=ps($app['appointmentId']);?>" style="margin-left:0px;" title="<?=LABEL_CONSULTATION;?>">&nbsp;<i class="icon-heart"></i></a>
																<a href="#modalAppNotes" class="btn btn-info btn-mini" style="margin-left:5px;" title="<?=LABEL_CONSULTATIONS_NOTES;?>" data-toggle="modal" onclick="modalAppNotes(<?=(int)$app['appointmentId'];?>, '<?=$app['name'];?>', '<?=$app['notes'];?>');">&nbsp;<i class="icon-edit"></i></a>
															<?php } elseif($app['appStatusId']==APP_MISSED) { ?>
																<?=LABEL_APPOINTMENTS_MISSED;?>
															<?php } else { ?>
															<?php } ?>
														</div>
													</div>
												<?php } ?>
												<div style="clear:both;">&nbsp;</div>
												<a href="#modalAppAdd" class="btn btn-mini" title="Agregar" data-toggle="modal" onclick="modalAppAdd('<?=$i['time'];?>');">&nbsp;<i class="icon-plus"></i></a>
											<?php } else { ?>
												<a href="#modalAppAdd" class="btn btn-mini" title="Agregar" data-toggle="modal" onclick="modalAppAdd('<?=$i['time'];?>');">&nbsp;<i class="icon-plus"></i></a>
												<?php /*<a class="btn btn-danger btn-mini" href="./?mod=<?=ps('apo');?>&cmd=block&date=<?=$i['date'];?>&time=<?=$i['time'];?>" title="Bloquear" onclick="return confirm('Está seguro que desea bloquear este horario?');">&nbsp;<i class="icon-lock"></i></a>*/ ?>
											<?php } ?>
										</td>
									</tr>
								<?php } else { ?>
									<tr>
										<td style="width:50px;text-align:center;"><?=$i['time'];?></td>
										<td style="background-color:#f2dede;color:#b94a48;"><a href="./?mod=<?=ps('apo');?>&cmd=unblock&date=<?=$i['date'];?>&time=<?=$i['time'];?>" title="Desbloquear" style="color:#b94a48;" onclick="return confirm('Está seguro que desea desbloquear este horario?');">Bloqueado</a></td>
									</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
					
				</div> <!-- /widget-content -->
				
			</div> <!-- /widget -->

		</div> <!-- /.span -->

		<?php if(Session::get_safe('roleId')!=ROLE_DOCTOR) { ?>
		<div class="span3">

			<div class="widget">

				<div class="widget-header">
					<h3>
						<i class="icon-user"></i>
						<?=LABEL_DOCTOR;?>
					</h3>
				</div> <!-- /.widget-header -->

				<div class="widget-content" style="padding-top:5px;">
					<input type="text" id="autocomplete_doctor" name="doctor" class="input input-large" style="margin-top:10px;" autocomplete="off" value="" />
					<div id="selction-ajax-doctor"></div>
				</div> <!-- /.widget-content -->

			</div> <!-- /.widget -->

		</div> <!-- /.span -->
		<?php } ?>

		<div class="<?=(Session::get_safe('roleId')!=ROLE_DOCTOR) ? 'span2' : 'span5';?>">

			<div class="widget">

				<div class="widget-header">
					<h3>
						<i class="icon-calendar"></i>
						<?=LABEL_DATE;?>
					</h3>
				</div> <!-- /.widget-header -->

				<div class="widget-content" style="padding-top:5px;">
					<input type="text" id="date" name="date" class="input <?=(Session::get_safe('roleId')!=ROLE_DOCTOR) ? 'input-small' : 'input-large';?>" style="margin-top:10px;" onchange="window.location='./?mod=<?=ps('apo');?>&seldate='+this.value+'&did=<?=ps($doctor_id);?>';" />
				</div> <!-- /.widget-content -->

			</div> <!-- /.widget -->

		</div> <!-- /.span -->

		<div class="span5">

			<div class="widget widget-fullcalendar">
				
				<div class="widget-header">
					<h3>
						<i class="icon-calendar"></i>
						<?=LABEL_CALENDAR;?>
					</h3>
				</div> <!-- /.widget-header -->
				
				<div class="widget-content">
					
					<div id="calendar-holder"></div> <!-- /#calendar-holder -->
					
				</div> <!-- /widget-content -->
				
			</div> <!-- /widget -->

		</div> <!-- /.span -->
		
	</div> <!-- /.row -->

</div> <!-- /.container -->

<!-- modals -->
<div class="modal fade hide" id="modalAppAdd">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3><?=LABEL_APPOINTMENTS_ADD_DAY;?> <span id="appDateTimeLabel"></span></h3>
	</div>
	<form name="form-add" id="form-add" method="post" action="./?mod=<?=ps('apo');?>" class="form-horizontal" style="padding-bottom:0px;margin-bottom:0px;">
		<input type="hidden" name="cmd" value="<?=ps('schedule');?>">
		<input type="hidden" name="did" value="<?=$doctor_id;?>">
		<input type="hidden" name="date" value="<?=$date;?>">
		<input type="hidden" name="pid" id="modal_pid" value="0">
		<input type="hidden" name="time" id="modal_time" value="0">
		<fieldset>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="name"><?=LABEL_PATIENT;?></label>
					<div class="controls">
						<input type="text" name="name" id="autocomplete_patient" class="input input-xlarge" autocomplete="off" value="" />
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
							<input type="text" class="input input-small" id="height" name="fields[height]" autocomplete="off" value=""><span class="add-on">cm</span>
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
				<div class="control-group">
					<label class="control-label" for="appNotes"><?=LABEL_CONSULTATIONS_NOTES;?></label>
					<div class="controls">
						<input type="text" name="fields[notes]" id="appNotes" class="input input-xlarge" autocomplete="off" value="" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal"><?=LABEL_FORMS_CANCEL;?></button>
				<button type="submit" class="btn btn-primary"><?=LABEL_FORMS_ADD;?></button>
			</div>
		</fieldset>
	</form>
</div>

<div class="modal fade hide" id="modalAppNotes">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3><?=LABEL_APPOINTMENT;?> <span id="appNotesName"></span></h3>
	</div>
	<form name="form-add" id="form-add" method="post" action="./?mod=<?=ps('apo');?>" class="form-horizontal" style="padding-bottom:0px;margin-bottom:0px;">
		<input type="hidden" name="cmd" id="cmd" value="<?=ps('notes');?>">
		<input type="hidden" name="id" id="appNotesId" value="0">
		<input type="hidden" name="did" value="<?=ps($doctor_id);?>">
		<input type="hidden" name="date" value="<?=ps($date);?>">
		<fieldset>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="appNotesNotes"><?=LABEL_CONSULTATIONS_NOTES;?></label>
					<div class="controls">
						<input type="text" name="notes" id="appNotesNotes" class="input input-xlarge" autocomplete="off" value="" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal"><?=LABEL_FORMS_CANCEL;?></button>
				<button type="submit" class="btn btn-primary"><?=LABEL_FORMS_ADD;?></button>
			</div>
		</fieldset>
	</form>
</div>

<?php include("footer.php"); ?>