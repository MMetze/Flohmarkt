<?php 
/* 	Flohmarkt Kasse - Manage sells and seller payouts
    Copyright (C) 2015  Metze, Matthias

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	
	Contact information
	eMail: m.metze@gmx.com
	GitHub: https://github.com/MMetze/Flohmarkt
 */
 ?>

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