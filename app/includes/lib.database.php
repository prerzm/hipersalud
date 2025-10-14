<?php

# Execute sql query returning affected rows
function sql_query($sql, $debug=false) {

	global $mysqli;

	if($debug==true) {
		sql_display_query($sql);
		return 1;
	} else {
		$mysqli->query($sql) or sql_error($sql, $mysqli->errno, $mysqli->error);
		return $mysqli->affected_rows;
	}

}

# Execute sql query returning inserted id
function sql_query_id($sql, $debug=false) {

	global $mysqli;

	if($debug==true) {
		sql_display_query($sql);
		return rand(100000,190000);
	} else {
		$mysqli->query($sql) or sql_error($sql, $mysqli->errno, $mysqli->error);
		return $mysqli->insert_id;

	}

}

# Return array with results or false
function sql_select($sql, $debug=false) {

	global $mysqli;

	if($debug==true) {
		sql_display_query($sql);
	}
	
	# query
	$result	= @$mysqli->query($sql) or sql_error($sql, $mysqli->errno, $mysqli->error);
	
	if(($numrows=@$result->num_rows)>0) {
		$array	= array();
		for($i=0;$i<$numrows;$i++) {
			$array[$i] = @$result->fetch_assoc();
		}
		return $array;
	}
	
	return false;

}

# return single array with result or false
function sql_select_row($sql, $debug=false) {

	global $mysqli;

	if($debug==true) {
		sql_display_query($sql);
	}
	
	# query
	$result	= $mysqli->query($sql) or sql_error($sql, $mysqli->errno, $mysqli->error);
	
	# form array
	if(($numrows=@$result->num_rows)>0) {
		return @$result->fetch_assoc();
	}
	
	return false;

}

# return single value of a query
function sql_select_value($sql, $debug=false) {

	global $mysqli;

	if($debug==true) {
		sql_display_query($sql);
	}
	
	# query
	$result	= @$mysqli->query($sql) or sql_error($sql, $mysqli->errno, $mysqli->error);
	
	# form array
	if(($numrows=@$result->num_rows)>0) {
		$array 	= @$result->fetch_array(MYSQLI_NUM);
		return $array[0];
	}

	return false;

}

# update with array for keys => values
function query_update($table, $values, $where, $debug=false) {

	global $mysqli;

	# verify and update
	if(trim($table)!="" && is_array($values) && count($values)>0 && trim($where)!="") {

		$i = 0;
		$str_fields = "";
	
		foreach($values as $key => $value) {
			if($i==0) {
				$str_fields.="$key='$value'";
			} else {
				$str_fields.=", $key='$value'";
			}
			$i++;
		}
		
		// build query
		$sql = "UPDATE $table SET $str_fields WHERE $where;";
	
		if($debug==true) {
			sql_display_query($sql);
			return 1;
		} else {
			$result	= @$mysqli->query($sql) or sql_error($sql, $mysqli->errno, $mysqli->error);
			return @$mysqli->affected_rows;
		}
	
	}

	return false;
	
}

# delete
function query_delete($table, $where, $debug=false) {

	global $mysqli;
	
	# verify info
	if(trim($table)!="" && trim($where)!="") {

		// build query
		$sql = "DELETE FROM $table WHERE $where;";
	
		if($debug==true) {
			sql_display_query($sql);
			return 1;
		} else {
			$result	= @$mysqli->query($sql) or sql_error($sql, $mysqli->errno, $mysqli->error);
			return @$mysqli->affected_rows;
		}
	
	}

	return false;
	
}

# insert
function query_insert($table, $values, $debug=false) {

	global $mysqli;

	if(is_array($values) && count($values)>0) {

		$i = 0;
		$str_fields = "(";
		$str_values = "(";
	
		foreach($values as $key=>$value) {
			if($i==0) {
				$str_fields.="$key";
				$str_values.="'".$mysqli->real_escape_string($value)."'";
			} else {
				$str_fields.=", $key";
				$str_values.=", '".$mysqli->real_escape_string($value)."'";
			}
			$i++;
		}
		
		$str_fields.=")";
		$str_values.=")";

		// build query
		$sql = "INSERT INTO $table $str_fields VALUES $str_values;";
	
		if($debug==true) {
			sql_display_query($sql);
			return rand(100000,110000);
		} else {
			$result	= @$mysqli->query($sql) or sql_error($sql, $mysqli->errno, $mysqli->error);
			return @$mysqli->insert_id;
		}

	}
	
}

# format query for display
function sql_display_query($sql) {

	$array_search = array("SELECT", "FROM", "WHERE", "GROUP", "ORDER", "LIMIT", "INSERT", "INTO", "VALUES", "DELETE", "UPDATE", "SET");
	$array_replace = array("<br>SELECT", "<br>FROM", "<br>WHERE", "<br>GROUP", "<br>ORDER", "<br>LIMIT", "<br>INSERT", "<br>INTO", "<br>VALUES", "<br>DELETE", "<br>UPDATE", "<br>SET");

	print "[sql_query] ".str_replace( $array_search, $array_replace, $sql)."<br>";

}

# log error and/or display
function sql_error($sql, $mysqli_errno, $mysqli_err) {
	error_log("$mysqli_errno - $mysqli_err  ($sql)");
	if(error_reporting()==E_ALL) {
		print "<table cellspacing=\"0\" cellpadding=\"5\" style=\"width:100%; border: 1px solid #000000;\">
				<tr><td align=\"center\" style=\"border-bottom: 1px solid #000000; \"><font color=\"red\">[$mysqli_errno] - $mysqli_err</font></td></tr>
				<tr><td height=\"10\"></td></tr>
				<tr><td align=\"center\">$sql</td></tr>
				</table>";
	}
}

?>