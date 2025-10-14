<?php

function get_stickers_array() {

	$str = file_get_contents(PATH_ROOT."uploads".DIRECTORY_SEPARATOR."Sticker Collection.sc");
	$arr = json_decode($str, true);
	$loaded = $arr['stickers'];
	
	foreach($loaded as $key => $value) {
		$country = trim(substr($key, 0, 3));
		$sticker = (int)substr($key, strpos($key, " "));
		$stickers[$country][$sticker] = $value;
	}

	ksort($stickers);

	foreach($stickers as $key => &$cts) {
		if($key=="FWC") {
			$start = 1;
			$limit = 18;
		} elseif($key=="TL") {
			$start = 19;
			$limit = 29;
		} else {
			$start = 1;
			$limit = 20;
		}
		for($i=$start; $i<=$limit; $i++) {
			if(!isset($cts[$i])) {
				$cts[$i] = 0;
			}
		}
	}

	foreach($stickers as &$cts) {
		ksort($cts);
	}

	return $stickers;

}

switch($cmd) {

	case 'missing':

		$stickers = get_stickers_array();
		$total = 0;

		foreach($stickers as $ct => $st) {
			print "<br>$ct: ";
			foreach($st as $key => $qty) {
				if($qty==0) {
					$total++;
					print "$key, ";
				}
			}
		}

		print "<br><br>Total stickers missing: $total<br>";

	break;

	case 'repeated':

		$stickers = get_stickers_array();

		foreach($stickers as $ct => $st) {
			print "<br>$ct: ";
			foreach($st as $key => $qty) {
				if($qty>1) {
					print "$key, ";
				}
			}
		}

	break;

	default:

		# vars
		$torneo_default = Torneo::get_default_torneo();
		$jornada_id = (int)$torneo_default['jornada_id'];

		# queries
		$partidos = sql_select("SELECT partido_id, jornada_id, local_nombre, visitante_nombre FROM partidos WHERE jornada_id = $jornada_id");

		for($i=0; $i<count($partidos); $i++) {
			$result = sql_select_row("SELECT resultado, COUNT(resultado) AS total FROM `resultados` WHERE partido_id = ".$partidos[$i]['partido_id']." GROUP BY resultado ORDER BY total DESC LIMIT 0, 1");
			$partidos[$i]['fcst'] = $result['resultado'];
			$partidos[$i]['results'] = $result['total'];
		}

		# view
		include(getview("test.index"));

	break;

}

?>