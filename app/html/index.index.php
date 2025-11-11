<?php include("header.php"); ?>

<script src="./js/dm.js"></script>
<script src="./js/plugins/chart/chart.js"></script>

<div class="container">
	
	<div class="row">
		
		<div class="span12">

			<!--- alert messagess ---->
			<?php $global_alerts->display(); ?>

		</div> <!-- /.span -->

	</div> <!-- /.row -->

	<?php if($role_id==ROLE_PATIENT) { ?>
		<div class="row">
			<?php include("index.index.patient.php"); ?>
		</div> <!-- /.row -->
	<?php } ?>

</div> <!-- /.container -->

<script>

	<?php include("inc.graphs.js.php"); ?>

</script>

<?php include("footer.php"); ?>