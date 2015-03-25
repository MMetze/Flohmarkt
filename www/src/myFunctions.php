<?php 
	/**
	 * sanitize for sql execution
	 * @param string $string
	 * @return string
	 */
	function sanitizeString($string) {
		global $dbc;
		$string= strip_tags($string);
		$string= trim(mysqli_real_escape_string($dbc->db, $string));
		
		if( strlen($string)==0 )
			return NULL;
		
		return $string;
	}
	
	# transform sql to german date
	function mydate($date) {
		if( $date == NULL )
			return NULL;
	
		return date("d.m.Y", strtotime($date));
	}
?>