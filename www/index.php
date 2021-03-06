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
 
<html>

<?php
	#settings and db
	session_start();
	include_once "config/config.inc.php";
	
	$dbc= new db();
	$pf= $dbc->pre;
	
	#sanitize
	if(isset($_GET["view"]))
		$view= $_GET["view"];
	else
		$view= NULL;
	
	# get latest event, if none set
	if(!isset($_SESSION["event"])) {
			$query= "SELECT MAX(ID) AS ID FROM " . $pf . "events LIMIT 1;";
			$result= $dbc->myQuery($query);
			$result= mysqli_fetch_object($result);
			$_SESSION["event"]= $result->ID;
	}
	if(!isset($_SESSION["trans"])) {
		$_SESSION["trans"]= NULL;
	}
	
	$lasttrans= NULL;
	
	if(isset($_GET["event"])) {
		$_SESSION["event"]= sanitizeString($_GET["event"]);
	}
	
	if(isset($_POST["type"]))
		$p_type= $_POST["type"];
	else	
		$p_type= NULL;
	
	if(isset($_POST["entry"]))
		$entry= sanitizeString($_POST["entry"]);
	else
		$entry= NULL;
	

	/* manage posts */
	switch( $p_type ) {
		case "new":
			$neweventname= sanitizeString($_POST["name"]);
			$neweventdate= sanitizeString($_POST["date"]);
			$query= "INSERT INTO " . $pf . "events ( name, date ) VALUES ( '$neweventname', '$neweventdate' );";
			$dbc->myQuery($query);
			break;
		
		case "entry":
			if( $_SESSION["trans"]==NULL || !isset($_SESSION["trans"]) ) { /* create new transaction ID */
				$dbc->myQuery("LOCK TABLES " . $pf . "transactions WRITE;");
				$query="INSERT INTO " . $pf . "transactions ( event_id ) VALUES ( " . $_SESSION["event"] . " );";
				$dbc->myQuery($query);
				$lastid= $dbc->myQuery("SELECT LAST_INSERT_ID() AS ID;");
				$lastid= mysqli_fetch_object($lastid);
				$lastid= $lastid->ID;
				$dbc->myQuery("UNLOCK TABLES;");
				
				$_SESSION["trans"]= $lastid;				
			} 
			if($entry=="") {
				$query= "SELECT SUM(value) AS total FROM " . $pf . "transaction_details WHERE transaction_id=" . $_SESSION["trans"] . ";";
				$sum= $dbc->myQuery($query);
				$sum= mysqli_fetch_object($sum);
				$sum= $sum->total;
				$lasttrans= $_SESSION["trans"];
				$_SESSION["trans"]= NULL;
			} else {
				$transaction= explode("*", $entry);
				$transaction[1]= str_replace(",", ".", $transaction[1]);
				if(is_numeric($transaction[0]) && is_numeric($transaction[1]) ) {
					$query="INSERT INTO " . $pf . "transaction_details ( transaction_id, seller, value ) VALUES ( " . $_SESSION["trans"] . ", " . $transaction[0] . ", '" . $transaction[1] . "');";
					$dbc->myQuery($query);
				}
			}
		break;
	}
?>

<head>
<?php
	if( $_SESSION["event"] != NULL ) {
		$query="SELECT name, date FROM " . $pf . "events WHERE ID=" . $_SESSION["event"] . ";";
		$info= $dbc->myQuery($query);
		$info= mysqli_fetch_object($info);
	}
?>

<title>Flohmarkt - <?php if( $info ) echo mydate($info->date) . " " . $info->name; ?></title>
</head>

<link rel="stylesheet" type="text/css" href="config/style.css">

<body>

<div id="Header">

</div>

<div id="Navigation">
	<a href="?view=new">neu</a><br />
	<?php
		$query= "SELECT * FROM " . $pf . "events ORDER BY date DESC;";
		$result= $dbc->myQuery($query);
		while( $row=mysqli_fetch_object($result) ) {
			echo "<a href=\"?view=eventdetails&event=$row->ID\">" . mydate($row->date) . "</a><br />";
		}
	?>
</div>

<div id="ContentWrap">
	<?php
		/* new event */
		if( $view=="new" ) {
			?>
			<form name="newevent" action="index.php" method="post">
				<input name="type" value="new" type="hidden" />
				Name: <input name="name" type="text" maxlength="32" required><br />
				Datum: <input name="date" type="date" required><br />
				<input type="submit" />
			</form>
			<?php
		} else if( $view=="eventdetails") {
			$totalsum= 0;
			$query= "SELECT seller, SUM(value) AS sum";
			$query.= " FROM " . $pf . "transaction_details AS d LEFT JOIN " . $pf . "transactions AS t";
			$query.= " ON d.transaction_ID=t.ID";
			$query.= " WHERE t.event_id=" . $_SESSION["event"] . " GROUP BY seller;";
			
			$result= $dbc->myQuery($query);
			
			?>
			<table>
				<tr>
					<th>Verk&auml;ufer</th>
					<th>Summe</th>
					<th>Netto</th>
				</tr>			
				<?php while( $row= mysqli_fetch_object($result) ) {
						$totalsum= $totalsum+$row->sum;
					?>
					<tr>
						<td><?php echo $row->seller; ?></td>
						<td><?php echo number_format((float)$row->sum, 2, ',', ''); ?>&euro;</td>
						<td><?php echo number_format((float)$row->sum*0.80, 2, ',', ''); ?>&euro;</td>
					</tr>
				<?php } ?>
			</table>
			<B>Gesamt: <?php echo number_format((float)$totalsum, 2, ',', ''); ?>&euro;</B>
			<?php
				
		}

		if( isset($_SESSION["event"]) && $view!="new" ) {
			if( $view!=NULL ) 
				echo "<hr>";
			?>
			<form name="entry" action="index.php" method="post">
				<input name="type" value="entry" type="hidden" />
				<input name="transaction" value="<?php echo $_SESSION["trans"]; ?>" type="hidden">
				Verk&auml;ufer*Preis<br />
				<input name="entry" type="text" autofocus /><br />
				Leeres Feld= Verkauf beenden
			</form>
			<?php
			if( $_SESSION["trans"] || $lasttrans ) {
				if( $_SESSION["trans"] ) {
					$lasttrans= $_SESSION["trans"];
				}
				$query= "SELECT * FROM " . $pf . "transaction_details WHERE transaction_ID=" . $lasttrans . ";";
				$result= $dbc->myQuery($query);
				?>
				<table>
					<tr>
						<th>Verk&auml;ufer</th>
						<th>Summe</th>
					</tr>			
					<?php while( $row= mysqli_fetch_object($result) ) {
						?>
						<tr>
							<td><?php echo $row->seller; ?></td>
							<td><?php echo $row->value; ?>&euro;</td>
						</tr>
						<?php 
					}
					if( isset($sum) ) {
							?>
							<tr>
								<td><B>Summe</B></td>
								<td><B><?php echo $sum; ?>&euro;</B></td>
							</tr> <?php
					} ?>
				</table>
				<?php
				$lasttrans= NULL;
			}
		}
		
		
	?>
	
</div>
	

</body>
</html>
