<?php include("header.php"); ?>

<div class="container">
		
		<div id="page-title" class="clearfix">

			<h1><?=$record->get("name");?></h1>

			<ul class="breadcrumb">
				<li><a href="./"><?=LABEL_MENU_HOME;?></a> <span class="divider">/</span></li>
				<li class="active"><?=LABEL_MY_INFO;?></li>
			</ul>
			
		</div> <!-- /.page-title -->
		
		<div class="row">

			<div class="span12">

				<!--- alert messagess ---->
				<?php $global_alerts->display(); ?>

			</div> <!-- /.span12 -->

        </div> <!-- /.row -->

        <div class="row">

            <div class="span3">

                <div class="widget widget-form">
                    
                    <div class="widget-header">
                        <h3>
                            <i class="icon-user"></i>
                            <?=LABEL_DETAILS;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
                    <div class="widget-content">

                        <form action="./?mod=<?=ps('inf');?>" method="post" id="form-add" class="form" novalidate="novalidate">
                        <input type="hidden" name="cmd" value="<?=ps('update');?>">

                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="name"><?=LABEL_NAME;?></label>
                                    <div class="controls">
                                        <input type="text" id="name" name="name" class="input" autocomplete="off" value="<?=$record->get("name");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="email"><?=LABEL_EMAIL;?></label>
                                    <div class="controls">
                                        <input type="text" id="email" name="email" class="input" autocomplete="off" value="<?=$record->get("email");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="dob"><?=LABEL_DOB;?></label>
                                    <div class="controls">
                                        <input type="text" id="dob" name="dob" placeholder="yyyy-mm-dd" class="input input-small" autocomplete="off" value="<?=$record->get("dob");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="height"><?=LABEL_HEIGHT;?></label>
                                    <div class="controls">
                                        <input type="text" id="height" name="height" class="input input-small" autocomplete="off" value="<?=$record->get("height");?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="sex"><?=LABEL_SEX;?></label>
                                    <div class="controls">
                                        <label class="radio"><input type="radio" name="sex" id="sexm" value="Masculino" <?=($record->get("sex")=="M") ? 'checked="checked"': '';?>> <?=LABEL_MALE;?></label>
                                        <label class="radio"><input type="radio" name="sex" id="sexf" value="Femenino" <?=($record->get("sex")=="F") ? 'checked="checked"': '';?>> <?=LABEL_FEMALE;?></label>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn" onclick="window.location='./?mod=pat';">&nbsp;<i class="icon-arrow-left"></i> <?=LABEL_FORMS_BACK;?></button>
                                    <button type="submit" class="btn btn-primary">&nbsp;<i class="icon-hdd"></i> <?=LABEL_FORMS_UPDATE;?></button>
                                </div>
                            </fieldset>
                        </form>

                    </div> <!-- /.widget-content -->
                    
                </div> <!-- /.widget -->

            </div><!-- ./span detalles -->

            <div class="span3">

                <div class="widget widget-form">
                    
                    <div class="widget-header">
                        <h3>
                            <i class="icon-check"></i>
                            <?=LABEL_FORMS_ADD;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
					<div class="widget-content">

                        <form action="./?mod=<?=ps('inf');?>" method="post" id="form-add" class="form" novalidate="novalidate">
                            <input type="hidden" name="cmd" value="<?=ps('paramsadd');?>">

                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label" for="weight"><?=LABEL_PARAMS_WEIGHT;?></label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input type="text" class="input input-small" id="weight" name="fields[weight]" autocomplete="off" value=""><span class="add-on">kg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="weight"><?=LABEL_PARAMS_HEART_RATE;?></label>
                                    <div class="controls">
                                        <div class="input-append">
                                            <input type="text" class="input input-small" id="fc" name="fields[fc]" autocomplete="off" value=""><span class="add-on">BPM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="weight"><?=LABEL_PARAMS_BLOOD_PRESSURE;?></label>
                                    <div class="controls">
                                        <div class="input-prepend input-append">
                                            <span class="add-on"><?=LABEL_PARAMS_SYS_SHORT;?></span><input type="text" class="input input-mini" id="presis" name="fields[presis]" autocomplete="off" value=""><span class="add-on">mmHg</span>
                                        </div>
                                        <div class="input-prepend input-append">
                                            <span class="add-on"><?=LABEL_PARAMS_DIA_SHORT;?></span><input type="text" class="input input-mini" id="predia" name="fields[predia]" autocomplete="off" value=""><span class="add-on">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary" style="margin-left:5px;">&nbsp;<i class="icon-hdd"></i> <?=LABEL_FORMS_ADD;?></button>
                                </div>
                            </fieldset>
                        </form>

					</div> <!-- /.widget-content -->
					
				</div> <!-- /.widget -->

			</div><!-- ./span add-params -->

            <?php if(count($data)>0) { ?>
                <!-- params -->
                <div class="span3">

                    <div class="widget widget-table">
                        
                        <div class="widget-header">
                            <h3>
                                <i class="icon-check"></i>
                                <?=LABEL_PARAMS;?>
                            </h3>

                        </div> <!-- /.widget-header -->
                        
                        <div class="widget-content">

                            <table class="table table-striped table-bordered responsive">
                                <thead>
                                    <tr>
                                        <th><?=LABEL_DATE;?></th>
                                        <th><?=LABEL_PARAMS_WEIGHT;?></th>
                                        <th><?=LABEL_PARAMS_BMI;?></th>
                                        <th><?=LABEL_PARAMS_HEART_RATE_SHORT;?></th>
                                        <th><?=LABEL_PARAMS_BLOOD_PRESSURE_SHORT;?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data as $d) { ?>
                                        <tr class="odd gradeX">
                                            <td style="text-align:center;"><?=$d['date'];?></td>
                                            <td style="text-align:center;"><?=NumberFormat::float($d['weight']);?></td>
                                            <td style="text-align:center;"><?=$d['bmi'];?></td>
                                            <td style="text-align:center;"><?=$d['fc'];?></td>
                                            <td style="text-align:center;"><?=$d['presis']."/".$d['predia'];?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div> <!-- /.widget-content -->
                        
                    </div> <!-- /.widget -->

                </div><!-- ./span -->
            <?php } ?>

            <!-- appointments -->
            <div class="span3">

                <div class="widget widget-table">
                    
                    <div class="widget-header">
                        <h3>
                            <i class="icon-check"></i>
                            <?=LABEL_APPOINTMENTS;?>
                        </h3>

                    </div> <!-- /.widget-header -->
                    
                    <div class="widget-content">

                        <table class="table table-striped table-bordered responsive">
                            <thead>
                                <tr>
                                    <th><?=LABEL_DATE;?></th>
                                    <th><?=LABEL_DOCTOR;?></th>
                                    <th><?=LABEL_APPOINTMENTS_STATUS;?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($appointments) { ?>
                                    <?php foreach($appointments as $a) { ?>
                                        <tr class="odd gradeX">
                                            <td><?=DateLang::short($a['appDateTime']);?></td>
                                            <td><?=$a['name'];?></td>
                                            <td><span class="label label-<?=$a['class'];?>"><?=$a['appStatus'];?></span></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
						</table>

                    </div> <!-- /.widget-content -->
                    
                </div> <!-- /.widget -->

            </div><!-- ./span -->

        </div><!-- ./row -->

        <div class="row">

		</div> <!-- /.row -->

	</div> <!-- /.container -->
	
</div> <!-- /#content -->


<?php include("footer.php"); ?>