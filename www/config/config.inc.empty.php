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

<?php		// Database connection and global includes
	include_once "../src/myClasses.php";
	include_once "../src/myFunctions.php";
	
	$config= array (
		"db_host" => "",		// Server hosting mysql instance
		"db_user" => "",		// User to log into database
		"db_pass" => "",		// password to use
		"db_name" => "",		// Database name
		"db_prefix" => ""		// Table Prefix
	);
?>