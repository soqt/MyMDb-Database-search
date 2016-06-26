<?php
/*
Yumeng Wang
CSE 154
Home work 5
This is the search-all.php page, using SQL to search out all movies
acted by given actor.
*/
	include("common.php");

	parameter_check();

	$first_name = strtolower($_GET["firstname"]);
	$last_name = strtolower($_GET["lastname"]);

	heading();

	$db = database();
	$id = id($db, $last_name, $first_name);
	
	if (!$id) { ?>
		<p> Actor <?= $first_name ?> <?= $last_name ?> not found </p>

	<?php
	}else { ?>
		<h1>Results for <?=$first_name ?> <?=$last_name ?></h1>
	<?php
		$id = $db->quote($id);
		$rows = $db->query("SELECT name, year
							FROM movies m 
							JOIN roles r ON r.movie_id = m.id
							JOIN actors a ON a.id = r.actor_id
							WHERE a.id = $id
							ORDER BY m.year DESC, m.name ");
		$caption = "All Film";
		table($rows, $caption);
	}
	footer();
	
?>
