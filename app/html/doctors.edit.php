<?php include("header.php"); ?>

<script>

    $(document).ready(function(){

		// date
		$("#dob").datepicker({ dateFormat: 'yy-mm-dd' });

	}); // end document.ready

</script>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1><?=$record->get("name");?></h1>

			<ul class="breadcrumb">
				<li><a href="./"><?=LABEL_MENU_HOME;?></a> <span class="divider">/</span></li>
                <li><a href="./?mod=<?=ps('doc');?>"><?=LABEL_DOCTORS;?></a> <span class="divider">/</span></li>
				<li class="active"><?=LABEL_DOCTORS;?></li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

            <?php if($edit) { ?>

                <form action="./?mod=<?=ps('doc');?>" method="post" id="form-add" novalidate="novalidate">
                <input type="hidden" name="cmd" value="<?=ps('update');?>">
                <input type="hidden" name="id" value="<?=ps($record->id());?>">

            <?php } ?>

            <div class="span4">

                <div class="widget widget-form">
                    
                    <div class="widget-header">
                        <h3>
                            <i class="icon-user"></i>
                            <?=LABEL_DETAILS;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
                    <div class="widget-content">

                        <?php if($edit) { ?>
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="name"><?=LABEL_NAME;?></label>
                                    <div class="controls">
                                        <input type="text" id="name" name="name" class="input input-xlarge" autocomplete="off" value="<?=$record->get("name");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="email"><?=LABEL_EMAIL;?></label>
                                    <div class="controls">
                                        <input type="text" id="email" name="email" class="input input-xlarge" autocomplete="off" value="<?=$record->get("email");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="dob"><?=LABEL_DOB;?></label>
                                    <div class="controls">
                                        <input type="text" id="dob" name="dob" placeholder="yyyy-mm-dd" class="input input-small" autocomplete="off" value="<?=$record->get("dob");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="esp"><?=LABEL_DOCTORS_SPECIALTY;?></label>
                                    <div class="controls">
                                        <input type="text" id="esp" name="fields[esp]" class="input input-xlarge" autocomplete="off" value="<?=$record->get("esp");?>" />
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn" style="margin-left:0px;" onclick="window.location='./?mod=<?=ps('doc');?>';">&nbsp;<i class="icon-arrow-left"></i> <?=LABEL_FORMS_BACK;?></button>
                                    <button type="submit" class="btn btn-primary" style="margin-left:5px;">&nbsp;<i class="icon-hdd"></i> <?=LABEL_FORMS_UPDATE;?></button>
                                </div>
                            </fieldset>
                        <?php } else { ?>
                            <fieldset>
                                <div class="control-group"><h2><?=$record->get("name");?></h2></div>
                                <div class="control-group">
                                    <p style="font-size:16px;">
                                        <strong><?=LABEL_EMAIL;?>:</strong> <?=$record->get("email");?><br>
                                        <strong><?=LABEL_AGE;?>:</strong> <?=$record->get("age")." (".$record->get("dob").")";?><br>
                                        <strong><?=LABEL_HEIGHT;?>:</strong> <?=$record->get("height");?><br>
                                        <strong><?=LABEL_SEX;?>:</strong> <?=$record->get("sex");?><br>
                                    </p>
                                    <p>*<?=LABEL_USER_SINCE;?>: <?=$record->get("dateCreated");?></p>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn btn-large" style="margin-left:0px;" onclick="window.location='./?mod=<?=ps('doc');?>';">&nbsp;<i class="icon-arrow-left"></i> <?=LABEL_FORMS_BACK;?></button>
                                    <button type="submit" class="btn btn-primary btn-large" style="margin-left:5px;">&nbsp;<i class="icon-hdd"></i> <?=LABEL_FORMS_UPDATE;?></button>
                                </div>
                            </fieldset>
                        <?php } ?>

                    </div> <!-- /.widget-content -->
                    
                </div> <!-- /.widget -->

            </div><!-- ./span4 detalles -->

            <div class="span8">

                <div class="widget widget-table">
                    
                    <div class="widget-header">
                        <h3>
                            <i class="icon-list-alt"></i>
                            <?=LABEL_CONSULTATIONS;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
                    <div class="widget-content">

                        <table class="table table-striped table-bordered responsive">
                            <thead>
                                <tr>
                                    <th><?=LABEL_DATE;?></th>
                                    <th><?=LABEL_PATIENT;?></th>
                                    <th><?=LABEL_CONSULTATIONS_NOTES;?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX">
                                    <td>2024-10-01</td>
                                    <td>Julieta Montes</td>
                                    <td>El paciente tiene cita el próximo mes</td>
                                </tr>
                                <tr class="even gradeC">
                                    <td>2024-11-01</td>
                                    <td>Roberto Canales</td>
                                    <td></td>
                                </tr>
                                <tr class="odd gradeA">
                                    <td>2024-12-01</td>
                                    <td>Hilda Roberta Barros</td>
                                    <td></td>
                                </tr>
                                <tr class="odd gradeX">
                                    <td>2025-01-01</td>
                                    <td>Ernesto Frodel</td>
                                    <td></td>
                                </tr>
                                <tr class="even gradeC">
                                    <td>2025-02-01</td>
                                    <td>Anna Estrella</td>
                                    <td></td>
                                </tr>
                                <tr class="odd gradeA">
                                    <td>2025-03-01</td>
                                    <td>Eduviges Nieto</td>
                                    <td></td>
                                </tr>
                            </tbody>
						</table>

                    </div> <!-- /.widget-content -->
                    
                </div> <!-- /.widget -->

            </div><!-- ./span exped -->

            <?php if($edit) { ?>

                </form>

            <?php } ?>

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->


<?php include("footer.php"); ?>