<?php

class db {
	public $db;
	public $pre;
	
	// Open SQL connection using parameters stored in config.inc.php
function __construct() {
		global $config;
	
			$this->db = mysqli_connect($config["db_host"],$config["db_user"],$config["db_pass"], $config["db_name"]);
			if (!$this->db) {
				die("Database Connection Error: " . mysqli_error($this->db));
			}
			
			/*$db_select = mysql_select_db($config["db_name"], $this->db);
			if (!$db_select) {
				die("Database selection failed: " .mysql_error());
			};*/
			$this->pre= $config["db_prefix"];
	}
	
	// Close SQL connection when class object is discarded
function __destruct() {
		mysqli_close($this->db);
	}
	
	// Run query on selected database
public function myQuery($query, $uid=0) {

		$defNULL= array( "'NULL'", "''" );
		$query= str_replace($defNULL, "NULL", $query);
		
		# enable logging
		if( true ) {   # set for uid if only with actual user
			$sub= substr($query, 0, 5);
			if( ($sub=="DELET" || $sub=="INSER" || $sub=="UPDAT") && strpos($query,'tmp_')==false ) { # $sub=="DELET" || $sub=="INSER" || $sub=="UPDAT"
				$log= 'INSERT INTO logging ( userid, query ) VALUES ( "' . $uid . '", "' . $query . '" )';
				mysqli_query($this->db, $log);
			}
		}
		
		$result = mysqli_query($this->db, $query);
		
		if (!$result) {
			$message = "Ung&uuml;ltige Abfrage: " . mysqli_error($this->db) . "\n";
			$message .= "Query: " . $query;
			die($message);
		}
		return $result;
	}
	
public function mysqli_exec_batch ($p_query, $p_transaction_safe = true) {
	if ($p_transaction_safe) {
		  $p_query = 'START TRANSACTION;' . $p_query . '; COMMIT;';
	};
	$query_split = preg_split ("/[;]+/", $p_query);
	foreach ($query_split as $command_line) {
		$command_line = trim($command_line);
		if ($command_line != '') {
			$query_result = mysqli_query($this->db, $command_line);
				if ($query_result == 0) {
					break;
				};
			};
		};
		return $query_result;
	}
	
}  // end of class db
?>