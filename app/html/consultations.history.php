<?php if($history) { ?>

	<table class="table table-striped table-bordered table-highlight">
		<thead>
			<tr>
				<th><?=LABEL_DATE;?></th>
				<th><?=LABEL_PARAMS_WEIGHT;?></th>
				<th><?=LABEL_PARAMS_BMI;?></th>
				<th><?=LABEL_PARAMS_HEART_RATE;?></th>
				<th><?=LABEL_PARAMS_BLOOD_PRESSURE;?></th>
				<th><?=LABEL_PARAMS_GLUCOSE;?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($history as $h) { ?>
				<tr>
					<td><a href="./?mod=<?=ps('csu');?>&cmd=<?=ps('edit');?>&id=<?=ps($h['appointmentId']);?>" title="Editar"><?=DateLang::short($h['date']);?><a></td>
					<td><?=$h['weight'];?></td>
					<td><?=$h['bmi'];?></td>
					<td><?=$h['fc'];?></td>
					<td><?=$h['bp'];?></td>
					<td><?=$h['glu'];?></td>
				</tr>
				<tr>
					<td style="text-align:right;"><strong><?=LABEL_CONSULTATIONS_DIAGNOSIS;?></strong></td>
					<td colspan="5"><?=($h['diagnosis']!="") ? $h['diagnosis'] : '-';?></td>
				</tr>
				<tr>
					<td style="text-align:right;"><strong><?=LABEL_CONSULTATIONS_NOTES;?></strong></td>
					<td colspan="5"><?=($h['notes']!="") ? $h['notes'] : '-';?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

<?php } else { ?>
	<h3><?=LABEL_CONSULTATIONS_NO_HISTORY;?></h3>
<?php } ?>

